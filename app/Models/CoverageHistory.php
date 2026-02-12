<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoverageHistory extends Model
{
    protected $table = 'coverage_history';

    protected $fillable = [
        'area_id',
        'coverage_data',
        'ip_address',
    ];

    protected $casts = [
        'coverage_data' => 'array',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
