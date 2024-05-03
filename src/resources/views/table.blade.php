@extends('web::layouts.grids.12')

@section('title', "Market Monitor")
@section('page_header',  "Market Monitor")


@section('full')
    <div class="card">
        <div class="card-body">
            {!! $dataTable->table() !!}
        </div>
    </div>
@stop

@push('javascript')
    {{$dataTable->scripts()}}
@endpush
