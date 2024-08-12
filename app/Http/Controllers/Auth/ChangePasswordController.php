<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChangePasswordController extends Controller
{
    public function edit()
    {
        abort_if(Gate::denies('profile_password_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = auth()->user(); // Retrieve authenticated user
        return view('auth.passwords.edit', compact('user')); // Pass user to the view
    }

    public function update(UpdatePasswordRequest $request)
    {
        auth()->user()->update($request->all());

        return redirect()->route('profile.password.edit')->with('message', __('global.change_password_success'));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = auth()->user();

        $user->update($request->validated());
        if ($request->input('profile', false)) {
            if (! $user->profile || $request->input('profile') !== $user->profile->file_name) {
                if ($user->profile) {
                    $user->profile->delete();
                }
                $user->addMedia(storage_path('tmp/uploads/' . basename($request->input('profile'))))->toMediaCollection('profile');
            }
        } elseif ($user->profile) {
            $user->profile->delete();
        }
        return redirect()->route('profile.password.edit')->with('message', __('global.update_profile_success'));
    }

    public function destroy()
    {
        $user = auth()->user();

        $user->update([
            'email' => time() . '_' . $user->email,
        ]);

        $user->delete();

        return redirect()->route('login')->with('message', __('global.delete_account_success'));
    }
}