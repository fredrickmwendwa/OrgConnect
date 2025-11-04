<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Organization;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = ['organization_id', 'contact_type', 'contact_value', 'description', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
