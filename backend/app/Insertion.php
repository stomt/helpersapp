<?php namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Insertion extends Model {

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $guarded = array();

    public static $rules = array();

    public function city()
    {
    	return $this->belongsTo('App\City');
    }

    public function users()
    {
    	return $this->belongsToMany('App\User')
    				->withPivot('amount');
    }

    public function user($user_id)
    {
    	return $this->users()->where('user_id', $user_id)->first();
    }

    public function category(){
        return $this->belongsTo('App\Category');
    }

    public function creator()
    {
    	return $this->hasOne('App\User', 'user_id');
    }

}
