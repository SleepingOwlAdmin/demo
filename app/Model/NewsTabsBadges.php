<?php namespace App\Model;

class NewsTabsBadges extends News
{
    protected $table = 'news';
    
    public function scopePublished($query){
       return $query->where('published', 1);
    }

    public function scopeUnpublished($query){
       return $query->where('published', 0);
    }
}
