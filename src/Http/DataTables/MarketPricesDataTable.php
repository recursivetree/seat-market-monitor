<?php

namespace RecursiveTree\Seat\MarketMonitor\Http\DataTables;

use Seat\Eveapi\Models\Character\CharacterInfo;
use Seat\Eveapi\Models\Market\CharacterOrder;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
class MarketPricesDataTable extends DataTable
{
    /**
     * @return \Illuminate\Http\JsonResponse|\Yajra\DataTables\DataTableAbstract|\Yajra\DataTables\EloquentDataTable
     */
    public function ajax(): JsonResponse
    {
        return datatables()->eloquent($this->applyScopes($this->query()))
            ->editColumn('type.typeName', function ($row) {
                return view('web::partials.type', [
                    'type_id' => $row->type->typeID,
                    'type_name' => $row->name ? sprintf('%s (%s)', $row->name, $row->type->typeName) : $row->type->typeName,
                    'variation' => $row->type->group->categoryID == 9 ? 'bpc' : 'icon',
                ])->render();
            })
            ->editColumn('character.name', function ($row) {
                return view('web::partials.character', [
                    'character' => CharacterInfo::find($row->character_id)
                ])->render();
            })
            ->editColumn('location_id', function ($row) {
                return view('marketmonitor::partials.structure', [
                    'order' => $row
                ])->render();
            })
            ->editColumn('price', function ($row) {
                return sprintf('%s ISK',number($row->price));
            })
            ->editColumn('sell_price', function ($row) {
                return sprintf('%s ISK',number($row->sell_price));
            })
            ->editColumn('percentage', function ($row) {
                return sprintf('%s%%',number($row->percentage,2));
            })
            ->rawColumns(['type.typeName','character.name','location_id'])
            ->toJson();
    }

    /**
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->postAjax()
            ->columns($this->getColumns())
            ->postAjax([
                'data' => 'function(d) { d.location = $("#dt-location-selector").val(); }',
            ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return CharacterOrder::query()
            ->selectRaw(DB::raw("(price / sell_price*100) as percentage, character_id, price, sell_price, market_prices.type_id, location_id"))
            ->where('is_buy_order',null)
            ->join('market_prices','market_prices.type_id','character_orders.type_id')
            ->where('state','active');
        //::;
    }

    /**
     * @return array
     */
    public function getColumns()
    {
        return [
            ['data' => 'type.typeName', 'title' => trans_choice('web::seat.type', 2), 'orderable' => false],
            ['data' => 'character.name', 'title' => trans_choice('web::seat.character',1),'orderable' => false],
            ['data' => 'location_id', 'title' => trans_choice('web::seat.location',1)],
            ['data' => 'price', 'title' => trans('web::seat.price')],
            ['data' => 'sell_price', 'title' => "Sell Price (Default Market Region)"],
            ['data' => 'percentage', 'title' => "Percentage"],
        ];
    }
}