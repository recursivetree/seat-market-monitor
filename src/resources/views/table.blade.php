@extends('web::layouts.grids.12')

@section('title', "Market Monitor")
@section('page_header',  "Market Monitor")


@section('full')
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label for="dt-location-selector">Location Filter</label>
                <select class="form-control" id="dt-location-selector">

                </select>
            </div>
            {!! $dataTable->table() !!}
        </div>
    </div>
@stop

@push('javascript')
    {{$dataTable->scripts()}}
    <script>
        $(document).ready(function() {
            $('#dt-location-selector').select2({
                placeholder: 'Select a structure',
                ajax: {
                    url: '{{ route('marketmonitor::locations') }}',
                    dataType: 'json',
                    cache: true,
                }
            })
                .on('change', function () {
                    window.LaravelDataTables['dataTableBuilder'].ajax.reload();
                });
        });
    </script>
@endpush
