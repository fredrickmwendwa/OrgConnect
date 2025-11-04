<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactType extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'description', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
