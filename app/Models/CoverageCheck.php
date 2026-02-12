<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoverageCheck extends Model
{
    protected $fillable = [
        'area_id',
        'latitude',
        'longitude',
        'coverage_data',
        'user_ip',
    ];

    protected $casts = [
        'coverage_data' => 'array',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
