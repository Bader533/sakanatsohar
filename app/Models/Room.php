<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'kind_en', 'kind_ar', 'price',
        'description_en', 'description_ar', 'image_url',
        'totalrooms', 'currentrooms', 'orderrooms', 'living_id ',
    ];

    public function living()
    {
        return $this->belongsTo(Living::class);
    }

    public function order()
    {
        return $this->hasOne(Waiting::class);
    }
}
