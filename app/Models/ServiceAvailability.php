<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\ServiceAvailabilityObserver;

#[ObservedBy([ServiceAvailabilityObserver::class])]
class ServiceAvailability extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'service_availabilities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'area_id',
        'service_type_id',
        'status',
        'notes',
        'last_updated',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'last_updated' => 'datetime',
        ];
    }

    /**
     * Get the area that owns the service availability.
     */
    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    /**
     * Get the service type that owns the service availability.
     */
    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class);
    }

    /**
     * Get the status history for the service availability.
     */
    public function statusHistory()
    {
        return $this->hasMany(StatusHistory::class);
    }

    /**
     * Scope a query to filter by area.
     */
    public function scopeByArea($query, $areaId)
    {
        return $query->where('area_id', $areaId);
    }

    /**
     * Scope a query to filter by service type.
     */
    public function scopeByServiceType($query, $serviceTypeId)
    {
        return $query->where('service_type_id', $serviceTypeId);
    }

    /**
     * Scope a query to filter by status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
