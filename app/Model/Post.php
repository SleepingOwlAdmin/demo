<?php namespace App\Model;

use Baum\Extensions\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'text',
        'text_html',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact()
    {
        return $this->belongsTo('App\Model\Contact');
    }

}
