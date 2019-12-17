<?php namespace F2re\Pagecsv\Models;

use Model;
use Illuminate\Support\Facades\DB;

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
    
    /**
     * The columns of the full text index
     */
    protected $searchable = [
        'title',
    ];
    
    /**
     *  Scope for pagination
     * 
     **/
    public function scopeQueryPaginate($query, $options = []) 
    {
        extract(array_merge([
            'page'    => 1,
            'perPage' => 20,
        ], $options));

        return $query->paginate($perPage, $page);
    }
    
    /**
     * Scope a query that matches a full text search of term.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $term
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $term)
    {
        // $columns = implode(',',$this->searchable);
		    $query->where('title', 'like', "%{$term}%");
        // $query->whereRaw("MATCH ({$columns}) AGAINST (? IN BOOLEAN MODE)" , $this->fullTextWildcards($term));
 
        return $query;
    }

    /**
     * Search geo spartial records by _id record and _r radius
     *
     */
    public function scopeSearchGeo($query, $_id, $_r, $_limit)
    {
      $circle_radius = 3959;
      if ( $_id>0 ){
        $_fromcur = Pages::where('id',$_id)->first();
        if ( $_fromcur ){
          $lat = $_fromcur->lat;
          $lon = $_fromcur->lon;
          if ( $lat!='' && $lon!='' ){
            return $candidates = DB::select(
                   'SELECT * FROM
                        (SELECT *, (' . $circle_radius . ' * acos(cos(radians(' . $lat . ')) * cos(radians(lat)) *
                        cos(radians(lon) - radians(' . $lon . ')) +
                        sin(radians(' . $lat . ')) * sin(radians(lat))))
                        AS distance
                        FROM '.$this->table.'
                        WHERE id<>'.$_id.' ) AS distances
                    WHERE distance < ' . $_r . ' 
                    ORDER BY distance
                    LIMIT '.($_limit>0?$_limit:0).'; ');
          }
        }
      }
      return $query;
    }
    
    /**
     * Replaces spaces with full text search wildcards
     *
     * @param string $term
     * @return string
     */
    protected function fullTextWildcards($term)
    {
        // removing symbols used by MySQL
        $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~'];
        $term = str_replace($reservedSymbols, '', $term);
 
        $words = explode(' ', $term);
 
        foreach($words as $key => $word) {
            /*
             * applying + operator (required word) only big words
             * because smaller ones are not indexed by mysql
             */
            if(strlen($word) >= 2) {
                $words[$key] = '+' . $word . '*';
            }
        }
 
        $searchTerm = implode( ' ', $words);
 
        return $searchTerm;
    }
    
}
