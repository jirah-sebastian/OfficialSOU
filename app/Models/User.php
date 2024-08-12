<?php

namespace App\Models;

use App\Notifications\VerifyUserNotification;
use App\Traits\Auditable;
use Carbon\Carbon;
use DateTimeInterface;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use SoftDeletes, Notifiable, InteractsWithMedia, Auditable, HasFactory;

    public $table = 'users';

    public const STATUS_SELECT = [
        'Pending'  => 'Pending',
        'Approved' => 'Approved',
        'Rejected' => 'Rejected',
        'Archived' => 'Archived',
    ];

    protected $appends = [
        'profile',
    ];

    protected $hidden = [
        'remember_token',
        'password',
    ];


    protected $dates = [
        'email_verified_at',
        'birthdate',
        'date_filed',
        'approval_update_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public const YEAR_SELECT = [
        'Second Year' => 'Second Year',
        'Third Year'  => 'Third Year',
        'Fourth Year' => 'Fourth Year',
        'Fifth Year'  => 'Fifth Year',
        'Sixth year'  => 'Sixth year',
    ];
    public const GENDER_SELECT = [
        'Male'   => 'Male',
        'Female' => 'Female',
    ];

    public const COURSE_SELECT = [
        'Bachelor of Science in Agribusiness (BSAb)' => 'Bachelor of Science in Agribusiness (BSAb)',
        'Bachelor of Science in Agriculture (BSA)' => 'Bachelor of Science in Agriculture (BSA)',
        'Bachelor of Arts in Filipino (BAFil)' => 'Bachelor of Arts in Filipino (BAFil)',
        'Bachelor of Arts in Literature (BALit)' => 'Bachelor of Arts in Literature (BALit)',
        'Bachelor of Arts in Social Sciences (BASS)' => 'Bachelor of Arts in Social Sciences (BASS)',
        'Bachelor of Science in Development Communication (BSDC)' => 'Bachelor of Science in Development Communication (BSDC)',
        'Bachelor of Science in Psychology (BSPsych)' => 'Bachelor of Science in Psychology (BSPsych)',
        'Bachelor of Science in Accountancy (BSAc)' => 'Bachelor of Science in Accountancy (BSAc)',
        'Bachelor of Science in Business Administration (BSBA)' => 'Bachelor of Science in Business Administration (BSBA)',
        'Bachelor of Science in Entrepreneurship (BSEntrep)' => 'Bachelor of Science in Entrepreneurship (BSEntrep)',
        'Bachelor of Science in Management Accounting (BSMA)' => 'Bachelor of Science in Management Accounting (BSMA)',
        'Bachelor of Culture and Arts Education (BCAEd)' => 'Bachelor of Culture and Arts Education (BCAEd)',
        'Bachelor of Early Childhood Education (BECEd)' => 'Bachelor of Early Childhood Education (BECEd)',
        'Bachelor of Elementary Education (BEEd)' => 'Bachelor of Elementary Education (BEEd)',
        'Bachelor of Physical Education (BPEd)' => 'Bachelor of Physical Education (BPEd)',
        'Bachelor of Secondary Education (BSEd)' => 'Bachelor of Secondary Education (BSEd)',
        'Bachelor of Technology and Livelihood Education (BTLEd)' => 'Bachelor of Technology and Livelihood Education (BTLEd)',
        'Bachelor of Science in Agricultural and Biosystems Engineering (BSABE)' => 'Bachelor of Science in Agricultural and Biosystems Engineering (BSABE)',
        'Bachelor of Science in Civil Engineering (BSCE)' => 'Bachelor of Science in Civil Engineering (BSCE)',
        'Bachelor of Science in Information Technology (BSIT)' => 'Bachelor of Science in Information Technology (BSIT)',
        'Bachelor of Science in Fisheries (BSF)' => 'Bachelor of Science in Fisheries (BSF)',
        'Bachelor of Science in Food Technology (BSFT)' => 'Bachelor of Science in Food Technology (BSFT)',
        'Bachelor of Science in Fashion and Textile Technology (BSFTT)' => 'Bachelor of Science in Fashion and Textile Technology (BSFTT)',
        'Bachelor of Science in Hospitality Management (BSHM)' => 'Bachelor of Science in Hospitality Management (BSHM)',
        'Bachelor of Science in Tourism Management (BSTM)' => 'Bachelor of Science in Tourism Management (BSTM)',
        'Bachelor of Science in Biology (BSBio)' => 'Bachelor of Science in Biology (BSBio)',
        'Bachelor of Science in Chemistry (BSChem)' => 'Bachelor of Science in Chemistry (BSChem)',
        'Bachelor of Science in Environmental Science (BSES)' => 'Bachelor of Science in Environmental Science (BSES)',
        'Bachelor of Science in Meteorology (BSMet)' => 'Bachelor of Science in Meteorology (BSMet)',
        'Bachelor of Science in Mathematics (BSMath)' => 'Bachelor of Science in Mathematics (BSMath)',
        'Bachelor of Science in Statistics (BSStat)' => 'Bachelor of Science in Statistics (BSStat)',
        'Doctor of Veterinary Medicine (DVM)' => 'Doctor of Veterinary Medicine (DVM)'
    ];
    
    protected $fillable = [
        'name',
        'email',
        'approved',
        'so_name',
        'email_verified_at',
        'password',
        'remember_token',
        'course',
        'year',
        'religion',
        'nationality',
        'birthdate',
        'birthplace',
        'gender',
        'present_address',
        'home_address',
        'contact_no',
        'father_name',
        'father_contact_no',
        'mother_name',
        'mothers_contact_no',
        'source_of_financial_support',
        'talent_skills',
        'date_filed',
        'gender',
        'approval_by_id',
        'approval_update_at',
        'remark',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by_id',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    public function getIsSoAdminAttribute()
    {
        return $this->roles()->where(function ($query) {
            $query->whereIn('id',[2]);
        })->exists();
    }

    public function getIsAdminAttribute()
    {
        return $this->roles()->where(function ($query) {
            $query->whereIn('id',[1,2,3]);
        })->exists();
    }
    public function getIsPresAttribute()
    {
        return $this->roles()->where(function ($query) {
            $query->whereIn('id',[3]);
        })->exists();
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        self::created(function (self $user) {
            $registrationRole = config('panel.registration_default_role');
            if (! $user->roles()->get()->contains($registrationRole)) {
                $user->roles()->attach($registrationRole);
            }
        });
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function createdByActivities()
    {
        return $this->hasMany(Activity::class, 'created_by_id', 'id');
    }

    public function createdByAnnouncements()
    {
        return $this->hasMany(Announcement::class, 'created_by_id', 'id');
    }

    public function createdByResources()
    {
        return $this->hasMany(Resource::class, 'created_by_id', 'id');
    }

    public function createdBySoLists()
    {
        return $this->hasMany(SoList::class, 'created_by_id', 'id');
    }

    public function getProfileAttribute()
    {
        $file = $this->getMedia('profile')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function created_by()
    {
        return $this->belongsTo(self::class, 'created_by_id');
    }
    public function getApprovalUpdateAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
        // return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setApprovalDateAttribute($value)
    {
        $this->attributes['approval_date'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function approval_by()
    {
        return $this->belongsTo(self::class, 'approval_by_id');
    }

}