<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'description',
        'icon',
    ];

    /**
     * Get the service availability records for this service type.
     */
    public function serviceAvailabilities()
    {
        return $this->hasMany(ServiceAvailability::class);
    }
}
