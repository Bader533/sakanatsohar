<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Living extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name_en', 'name_ar',
        'description_en', 'description_ar',
        'address_en', 'address_ar',
        'ownername_en', 'ownername_ar', 'phone', 'created_at', 'updated_at',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function images()
    {
        return $this->hasmany(Image::class);
    }
}
