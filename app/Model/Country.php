<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Traits\OrderableModel;

class Country extends Model
{
    use OrderableModel;



    protected $table = 'countries';

    protected $fillable = ['title', 'test'];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function getOrderField()
    {
        return 'order';
    }

}
