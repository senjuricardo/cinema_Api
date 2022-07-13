<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Movie;

class Actor extends Model
{
    protected $fillable = [
        'name',
    ];

    public function movies()
    {
        return $this->belongsToMany(Movie::class);
    }
    protected static function booted()
    {
        static::deleting(function ($actor) {
            if ($actor->movies()->exists()) {
                throw new \Exception('Related movies found');
            }});
    }

    use SoftDeletes;
}
