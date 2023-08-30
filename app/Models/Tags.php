<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tags extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $table = 'tags';

    protected $fillable = ['name', 'hover_color', 'is_hot', 'slug'];

}
