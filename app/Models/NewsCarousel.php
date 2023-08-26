<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsCarousel extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $table = 'news_carousel';

    protected $fillable = ['news_id', 'asset_url'];
}

?>
