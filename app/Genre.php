<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Movie;

class Genre extends Model
{
    protected $fillable = [
        'description',
    ];

    public function movies()
    {
        return $this->belongsToMany(Movie::class);
    }

    protected static function booted()
    {
        static::deleting(function ($genre) {
            if ($genre->movies()->exists()) {
                throw new \Exception('Related movies found');
            }});
    }
    use SoftDeletes;
}
