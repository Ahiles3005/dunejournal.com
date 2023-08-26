<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsTags extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $table = 'news_tags';

    protected $fillable = ['news_id', 'tag_id'];

    public function findNews(News $news, $tagId){
        $items = $this->join('news', 'news.id', '=', $this->table.'.news_id')->where($this->table.'.tag_id', $tagId)->get(['news.*']);

        dd($items);

        return $news->sortResult($items);
    }
}
