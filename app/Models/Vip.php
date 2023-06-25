<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vip extends Model
{
    use HasFactory;

    protected $table = 'vip';

    protected $guarded = ['id'];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
