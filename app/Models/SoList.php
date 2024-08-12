<?php

namespace App\Models;

use App\Traits\Auditable;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SoList extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, Auditable, HasFactory;

    public $table = 'so_lists';

    protected $appends = [
        'banner',
    ];

    protected $dates = [
        'expired_at',
        'anniversary_date',
        'approval_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const APPROVED_SELECT = [
        'Pending'  => 'Pending',
        'Approved' => 'Approved',
        'Rejected' => 'Rejected',
        'Archived' => 'Archived',
    ];
    protected $fillable = [
        'so_name',
        'so_category_id',
        'overview',
        'information',
        'expired_at',
        'created_by_id',
        'approved',
        'o_status',
        'remark',
        'anniversary_date',
        'adviser',
        'adviserEmail',
        'adviserCollege',
        'adviserYears',
        'adviserField',
        'approval_by_id',
        'approval_date',
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

    public function soListSoRegistrations()
    {
        return $this->hasMany(SoRegistration::class, 'so_list_id', 'id');
    }

    public function organizationActivities()
    {
        return $this->hasMany(Activity::class, 'organization_id', 'id');
    }

    public function organizationOrganizationApplicationForms()
    {
        return $this->hasMany(OrganizationApplicationForm::class, 'organization_id', 'id');
    }

    public function organization_admins()
    {
        return $this->belongsToMany(User::class);
    }

    public function so_category()
    {
        return $this->belongsTo(SoCategory::class, 'so_category_id');
    }

    public function getBannerAttribute()
    {
        $file = $this->getMedia('banner')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function getExpiredAtAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setExpiredAtAttribute($value)
    {
        $this->attributes['expired_at'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
    public function getAnniversaryDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setAnniversaryDateAttribute($value)
    {
        $this->attributes['anniversary_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function approval_by()
    {
        return $this->belongsTo(User::class, 'approval_by_id');
    }

    public function getApprovalDateAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
        // return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setApprovalDateAttribute($value)
    {
        $this->attributes['approval_date'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;

        // $this->attributes['approval_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }
}