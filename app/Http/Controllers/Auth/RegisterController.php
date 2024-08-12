<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\{UserRegisterAdmin, UserRegisterPres};
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Traits\MediaUploadingTrait;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    use MediaUploadingTrait;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'so_name' =>  ['required', 'string', 'max:255'],
            'course' =>     ['required'],
            'year' => ['required'],
            'religion' => ['required'],
            'nationality' => ['required'],
            'birthdate' => ['required'],
            'birthplace' => ['required'],
            'gender' => ['required'],
            'present_address' => ['required'],
            'home_address' => ['required'],
            'contact_no' => ['required'],
            'father_name' => ['required'],
            'father_contact_no' => ['required'],
            'mother_name' => ['required'],
            'mothers_contact_no' => ['required'],
            'source_of_financial_support' => ['required'],
            'talent_skills' => ['required'],
            'date_filed' => ['required'],
            'gender' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $users = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'so_name'  => $data['so_name'],
            'approved' => 'Pending',

            'course' => $data['course'],
            'year' => $data['year'],
            'religion' => $data['religion'],
            'nationality' => $data['nationality'],
            'birthdate' => $data['birthdate'],
            'birthplace' => $data['birthplace'],
            'gender' => $data['gender'],
            'present_address' => $data['present_address'],
            'home_address' => $data['home_address'],
            'contact_no' => $data['contact_no'],
            'father_name' => $data['father_name'],
            'father_contact_no' => $data['father_contact_no'],
            'mother_name' => $data['mother_name'],
            'mothers_contact_no' => $data['mothers_contact_no'],
            'source_of_financial_support' => $data['source_of_financial_support'],
            'talent_skills' => $data['talent_skills'],
            'date_filed' => $data['date_filed'],
            'gender' => $data['gender'],
        ]);
        Log::info($data);
        Log::info(request());
        $user = User::where('email', $data['email'])->first();
        $admins = User::whereHas('roles', function ($query) {
            $query->where('id', 2);
        })->get();

        if (request()->input('profile', false)) {
            $user->addMedia(storage_path('tmp/uploads/' . basename(request()->input('profile'))))->toMediaCollection('profile');
        }

        if ($media = request()->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $user->id]);
        }


        Log::info($admins);
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new UserRegisterAdmin($data['so_name'], $data['name'], $data['email']));
        }
        Mail::to($data['email'])->send(new UserRegisterPres($data['name'], $data['so_name']));
        return $users;
    }
    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('user_create') && Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new User();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
