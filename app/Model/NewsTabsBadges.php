<?php namespace App\Model;
class NewsTabsBadges extends News
{
    public function scopePublished($query){
       return $query->where('published', 1);
    }
    public function scopeUnpublished($query){
        return $query->where('published', 0);
    }
}