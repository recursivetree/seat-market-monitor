<?php

namespace RecursiveTree\Seat\MarketMonitor\Http\Controllers;

use Illuminate\Http\Request;
use RecursiveTree\Seat\MarketMonitor\Http\Controllers\Utils\LocationScope;
use RecursiveTree\Seat\MarketMonitor\Http\DataTables\MarketPricesDataTable;
use Seat\Eveapi\Models\Universe\UniverseStructure;
use Seat\Web\Http\Controllers\Controller;

class MarketMonitorController extends Controller
{
    public function index(MarketPricesDataTable $data_table)
    {
        return $data_table->addScope(new LocationScope(request()->input('location')))->render('marketmonitor::table');
    }

    public function getLocations(Request $request)
    {
        if ($request->query('_type', 'query') == 'find') {
            $alliance = UniverseStructure::find($request->query('q', 0));

            return response()->json([
                'id' => $alliance->alliance_id,
                'text' => $alliance->name,
            ]);
        }

        $structures = UniverseStructure::where('name', 'like', '%' . $request->query('q', '') . '%')
            ->orderBy('name')
            ->get()
            ->map(function ($structure, $key) {
                return [
                    'id' => $structure->structure_id,
                    'text' => $structure->name,
                ];
            });

        return response()->json([
            'results' => $structures,
        ]);
    }
}