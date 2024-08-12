<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Carbon\Carbon;
class SoRegistration extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, Auditable, HasFactory;

    public $table = 'so_registrations';

    protected $dates = [
        'birthdate',
        'date_filed',
        'date_approval',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = [
        'profile_picture',
        'profile_form',
        'parent_consent_form',
        'data_privacy_form',
        'med_cert',
    ];

    public const MEMBERSHIP_TYPE_SELECT = [
        'Member'          => 'Member',
        'Officer'         => 'Officer',
        'Honorary Member' => 'Honorary Member',
    ];


    public const YEAR_SELECT = [
        '2nd Year' => '2nd Year',
        '3rd Year' => '3rd Year',
        '4th Year' => '4th Year',
        '5th Year' => '5th Year',
        '6th Year' => '6th Year',
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

    public const PRESIDENT_APPROVAL_SELECT = [
        'Approved' => 'Approved',
        'Pending'  => 'Pending',
        'Rejected' => 'Rejected',
    ];
    public const ADMIN_APPROVAL_SELECT = [
        'Approved'                                    => 'Approved',
        'Pending'                                     => 'Pending',
        'Rejected'                                    => 'Rejected',
        'Waiting for Organization President Approval' => 'Waiting for Organization President Approval',
    ];



    protected $fillable = [
        'full_name',
        'email',
        'so_list_id',
        'course',
        'year',
        'gender',
        'religion',
        'nationality',
        'birthdate',
        'birthplace',
        'present_address',
        'home_address',
        'contact_no',
        'father_name',
        'father_contact_no',
        'mother_name',
        'mother_contact_no',
        'source_of_financial_support',
        'talent_skills',
        'date_filed',
        'position',
        'membership_type',
        'title_id',
        'remark',
        'president_approval',
        'admin_approval',
        'admin_remark',
        'approved_by_id',
        'date_approval',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function getProfilePictureAttribute()
    {
        $file = $this->getMedia('profile_picture')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function so_list()
    {
        return $this->belongsTo(SoList::class, 'so_list_id');
    }

    public function title()
    {
        return $this->belongsTo(Title::class, 'title_id');
    }

    public function getProfileFormAttribute()
    {
        return $this->getMedia('profile_form')->last();
    }

    public function getParentConsentFormAttribute()
    {
        return $this->getMedia('parent_consent_form')->last();
    }

    public function getDataPrivacyFormAttribute()
    {
        return $this->getMedia('data_privacy_form')->last();
    }

    public function getMedCertAttribute()
    {
        return $this->getMedia('profile_form')->last();
    }

    public function getBirthdateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setBirthdateAttribute($value)
    {
        $this->attributes['birthdate'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getDateFiledAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateFiledAttribute($value)
    {
        $this->attributes['date_filed'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }
    public function approved_by()
    {
        return $this->belongsTo(User::class, 'approved_by_id');
    }

    public function getDateApprovalAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setDateApprovalAttribute($value)
    {
        $this->attributes['date_approval'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }
}