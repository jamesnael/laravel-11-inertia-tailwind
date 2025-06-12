<?php 

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class HistoryFilter extends ModelFilter
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
        $this->year($value);
    }

    public function year($value, $orWhere = false)
    {
        if ($orWhere) {
            return $this->orWhere('year', 'LIKE', '%'.$value.'%');
        }
        return $this->where('year', 'LIKE', '%'.$value.'%');
    }

    public function sortOrder($sortOrder)
    {
        foreach ($sortOrder as $value) {
            $this->orderBy($value['column'], $value['order']);
        }
    }
}
