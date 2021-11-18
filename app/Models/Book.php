<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $perPage = 10;

    protected $fillable = [
        'title',
        'author',
        'description',
        'image'
    ];
}
