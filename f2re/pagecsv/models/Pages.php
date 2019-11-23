<?php namespace F2re\Pagecsv\Models;

use Model;

/**
 * Model
 */
class Pages extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    //use \October\Rain\Database\Traits\SoftDelete;

    //protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'f2re_pagecsv_pages';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
}
