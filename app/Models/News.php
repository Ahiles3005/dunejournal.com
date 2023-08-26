<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class News extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $table = 'news';

    protected $fillable = ['short_descr', 'full_descr', 'asset_url', 'full_image', 'type', 'created_at'];

    public function categories(){
        return $this->hasMany(NewsCategories::class, 'news_id')->join('categories', 'categories.id', '=', 'news_categories.category_id');
    }

    public function tags(){
        return $this->hasMany(NewsTags::class, 'news_id')->join('tags', 'tags.id', '=', 'news_tags.tag_id');
    }

    public function carousel(){
        return $this->hasMany(NewsCarousel::class, 'news_id');
    }

    public function clearAsset($asset){
        $currentAsset = substr($asset, strrpos($asset, '/') + 1);
        Storage::disk('public')->delete('/news_assets/'.$currentAsset);
    }

    public function getSorted(){
        $news = $this->orderBy('id', 'desc')->get();

        return $this->sortResult($news);
    }

    public function search($value){
        $news = $this->where( DB::raw('LOWER(short_descr)'), 'like', "%{$value}%")->orderBy('id', 'desc')->get();

        return $this->sortResult($news);
    }

    public function filterByTag($tag){
        $news = $this->join('news_tags', 'news_tags.news_id', '=', $this->table.'.id')->join('tags', 'tags.id', '=', 'news_tags.tag_id')->where('news_tags.tag_id', $tag)->orderBy($this->table.'.id', 'desc')->get([$this->table.'.*', 'tags.name as tag_name']);

        return $this->sortResult($news);
    }

    public function articleByTag($tag){
        return $this->join('news_tags', 'news_tags.news_id', '=', $this->table.'.id')->join('tags', 'tags.id', '=', 'news_tags.tag_id')->where('news_tags.tag_id', $tag)->select([$this->table.'.*', 'tags.name as tag_name'])->inRandomOrder()->first();
    }

    public function getRandom($amount, $type = 'standart'){
        return $this->join('news_tags', 'news_tags.news_id', '=', $this->table.'.id')->join('tags', 'tags.id', '=', 'news_tags.tag_id')->where('type', $type)->select([$this->table.'.*', 'tags.name as tag_name'])->inRandomOrder()->take($amount)->get();
    }

    public function filterByCategory($category){
        $news = $this->join('news_categories', 'news_categories.news_id', '=', $this->table.'.id')->join('categories', 'categories.id', '=', 'news_categories.category_id')->where('news_categories.category_id', $category)->orderBy($this->table.'.id', 'desc')->get([$this->table.'.*', 'categories.name as category_name']);

        return $this->sortResult($news);
    }

    public function sortResult($news){
        $sorted = [];

        $previosStandartIndex = -1;
        $i = 0;

        foreach($news as $key => $value){
            if( strcmp($value->type, 'hot') === 0 ){
                $sorted[$i] = $value;
            } else {

                if( isset($sorted[$previosStandartIndex]) ){
                    $sorted[$previosStandartIndex][] = $value;
                } else {
                    $sorted[$i][] = $value;
                }

                $previosStandartIndex = $i;
            }

            $i++;
        }

        return $sorted;
    }
}
