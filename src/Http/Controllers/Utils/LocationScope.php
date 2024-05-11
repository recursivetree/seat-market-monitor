<?php

namespace RecursiveTree\Seat\MarketMonitor\Http\Controllers\Utils;
use Yajra\DataTables\Contracts\DataTableScope;

class LocationScope implements DataTableScope
{
    private ?int $location_id;

    /**
     * @param ?int $location_id
     */
    public function __construct(?int $location_id)
    {
        $this->location_id = $location_id;
    }

    public function apply($query){
        if($this->location_id !== null) {
            $query->where('location_id', $this->location_id);
        }
    }
}