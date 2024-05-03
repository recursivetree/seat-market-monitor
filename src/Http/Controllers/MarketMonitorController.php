<?php

namespace RecursiveTree\Seat\MarketMonitor\Http\Controllers;

use Illuminate\Http\Request;
use RecursiveTree\Seat\MarketMonitor\Http\DataTables\MarketPricesDataTable;
use Seat\Web\Http\Controllers\Controller;

class MarketMonitorController extends Controller
{
    public function index(MarketPricesDataTable $data_table)
    {
        return $data_table->render('marketmonitor::table');
    }
}