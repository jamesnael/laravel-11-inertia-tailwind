<?php 

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class HomepageCountryFilter extends ModelFilter
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
        $this->country($value);
    }

    public function country($value, $orWhere = false)
    {
        if ($orWhere) {
            return $this->orWhereHas('country', function($subQuery) use ($value) {
                $subQuery->where('name', 'LIKE', '%' . $value . '%');
            });
        }

        return $this->whereHas('country', function($subQuery) use ($value) {
            $subQuery->where('name', 'LIKE', '%' . $value . '%');
        });
    }

    public function sortOrder($sortOrder)
    {
        foreach ($sortOrder as $value) {
            $this->orderBy($value['column'], $value['order']);
        }
    }
}
