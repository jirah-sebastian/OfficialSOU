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

class Activity extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, Auditable, HasFactory;

    public $table = 'activities';

    protected $appends = [
        'content_photo',
        'permit',
    ];

    protected $dates = [
        'event_date',
        'approval_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const STATUS_SELECT = [
        'Pending'  => 'Pending',
        'Approved' => 'Approved',
        'Rejected' => 'Rejected',
        'Archived' => 'Archived',
    ];
    
    public const TYPE_OF_ACTIVITY_SELECT = [
        'Fund Raising'      => 'Fund Raising',
        'Organizational'    => 'Organizational',
        'Recreational'      => 'Recreational',
        'Community Service' => 'Community Service',
        'Educational'       => 'Educational',
        'Socio-Cultural'    => 'Socio-Cultural',
    ];


    protected $casts = [
        'sustainable_development_goal' => 'array',
    ];

    public const SUSTAINABLE_DEVELOPMENT_GOALS = [
        '1 - No Poverty'                               => 'SDG 1 - No Poverty',
        '2 - Zero Hunger'                              => 'SDG 2 - Zero Hunger',
        '3 - Good Health and Well-being'                => 'SDG 3 - Good Health and Well-being',
        '4 - Quality Education'                         => 'SDG 4 - Quality Education',
        '5 - Gender Equality'                           => 'SDG 5 - Gender Equality',
        '6 - Clean Water and Sanitation'                => 'SDG 6 - Clean Water and Sanitation',
        '7 - Affordable and Clean Energy'              => 'SDG 7 - Affordable and Clean Energy',
        '8 - Decent Work and Economic Growth'          => 'SDG 8 - Decent Work and Economic Growth',
        '9 - Industry, Innovation and Infrastructure'  => 'SDG 9 - Industry, Innovation and Infrastructure',
        '10 - Reduced Inequality'                      => 'SDG 10 - Reduced Inequality',
        '11 - Sustainable Cities and Communities'      => 'SDG 11 - Sustainable Cities and Communities',
        '12 - Responsible Consumption and Production'  => 'SDG 12 - Responsible Consumption and Production',
        '13 - Climate Action'                           => 'SDG 13 - Climate Action',
        '14 - Life Below Water'                         => 'SDG 14 - Life Below Water',
        '15 - Life on Land'                             => 'SDG 15 - Life on Land',
        '16 - Peace and Justice Strong Institutions'    => 'SDG 16 - Peace, Justice and Strong Institutions',
        '17 - Partnerships to achieve the Goal'         => 'SDG 17 - Partnerships for the Goal',
    ];
    
    protected $fillable = [
        'title',
        'sub_title',
        'content',
        'event_date',
        'status',
        'remarks',
        'is_published',
        'organization_id',
        'created_by_id',
        'type_of_activity',
        'sustainable_development_goal',
        'gad_funded',
        'event_place',
        'created_at',
        'approval_by_id',
        'approval_date',
        'updated_at',
        'deleted_at',
        'o_status',
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

    public function getContentPhotoAttribute()
    {
        $file = $this->getMedia('content_photo')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function getEventDateAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEventDateAttribute($value)
    {
        $this->attributes['event_date'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function organization()
    {
        return $this->belongsTo(SoList::class, 'organization_id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
    public function getPermitAttribute()
    {
        return $this->getMedia('permit')->last();
    }
    public function approval_by()
    {
        return $this->belongsTo(User::class, 'approval_by_id');
    }

    public function getApprovalDateAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setApprovalDateAttribute($value)
    {
        $this->attributes['approval_date'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }
}