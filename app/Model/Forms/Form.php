<?php namespace App\Model\Forms;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $table ='forms';

    protected $fillable = [
        'title',
        'textaddon',
        'checkbox',
        'date',
        'time',
        'timestamp',
        'image',
        'images',
        'select',
        'textarea',
        'ckeditor',
    ];

    public function getImagesAttribute($value)
    {
        return preg_split('/,/', $value, -1, PREG_SPLIT_NO_EMPTY);
    }

    public function setImagesAttribute($images)
    {
        $this->attributes['images'] = implode(',', $images);
    }

}
