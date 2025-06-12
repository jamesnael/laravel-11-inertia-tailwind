<?php 

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class ContactUsFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    /**
     *
     * Any methods defined in the blackist array will not be called by the filter.
     * Those methods are normally used for internal filter logic.
     *
     * @var array
     */    
    protected $blacklist = [];

    public function search($value)
    {
        $this->fullname($value)->email($value, true);
    }

    public function fullname($value, $orWhere = false)
    {
        if ($orWhere) {
            return $this->orWhere('fullname', 'LIKE', '%'.$value.'%');
        }
        return $this->where('fullname', 'LIKE', '%'.$value.'%');
    }

    public function email($value, $orWhere = false)
    {
        if ($orWhere) {
            return $this->orWhere('email', 'LIKE', '%'.$value.'%');
        }
        return $this->where('email', 'LIKE', '%'.$value.'%');
    }

    public function sortOrder($sortOrder)
    {
        foreach ($sortOrder as $value) {
            $this->orderBy($value['column'], $value['order']);
        }
    }
}
