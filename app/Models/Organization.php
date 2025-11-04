<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contact;
use App\Models\Address;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'industry', 'description', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
