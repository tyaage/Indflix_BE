<?php

namespace App\Models;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Genre extends Model
{
    use HasFactory;

    protected $table = 'genre';

    protected $guarded = ['id'];

    public $timestamps = false;

    public function movie()
    {
        return $this->belongsToMany(Movie::class);
    }
}
