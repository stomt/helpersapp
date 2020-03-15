<?php namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Project extends Model {

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'projects';

    protected $guarded = [];

    public static $rules = [];

}
