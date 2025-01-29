<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /** @use HasFactory<\Database\Factories\TagFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
    ];

    // ---------------------------- //
    // relations

    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    public function images()
    {
        return $this->morphedByMany(Image::class, 'taggable');
    }

}
