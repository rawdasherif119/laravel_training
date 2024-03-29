<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Cache;

class City extends Model
{
    use SoftDeletes;


    protected $fillable = [
        'city_name','country_id'
    ];
     /** @inheritdoc */
    protected $with = ['country'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function country()
    {
        return $this ->belongsTo(Country::class);
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }
}
