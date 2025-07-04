<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'author_id'];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}