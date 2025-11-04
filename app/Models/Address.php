<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Organization;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['organization_id', 'building_name', 'street_name', 'city', 'country', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
