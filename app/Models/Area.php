<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'code',
    ];

    /**
     * Get the service availability records for this area.
     */
    public function serviceAvailabilities()
    {
        return $this->hasMany(ServiceAvailability::class);
    }
}
