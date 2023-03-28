@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<div class="row">
    <div class="col-lg-auto">
        <h4 class="text-dark pl-2">Sub Categories Management :- <a href="{{ route('admin.merchants.show',$merchant) }}">{{ $merchant->name }}</a></h4>
    </div>
    <div class="col-lg-auto ml-auto">
        <a href="{{ route('admin.menu_foods.index', ['merchant_id'=>$merchant_id]) }}" class="btn btn-primary" title="Manage">
            Manage Dishes
        </a>
    </div>
    <div class="col-lg-auto">
        <a href="{{ route('admin.menu_sub_categories.create', ['merchant_id'=>$merchant_id]) }}" class="btn btn-success" title="Add">
            Add New Sub Category
        </a>
    </div>
</div>
@stop

@section('content')                   
<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">
                <section class="content">
                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Sub Category Listing</h3>
            
                            <div class="card-tools">
                                {{-- <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button> --}}
                                {{-- <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                <i class="fas fa-times"></i></button> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Created At</th>
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Image</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.0/chart.min.js"
    integrity="sha512-asxKqQghC1oBShyhiBwA+YgotaSYKxGP1rcSYTDrB0U6DxwlJjU59B67U8+5/++uFjcuVM8Hh5cokLjZlhm3Vg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $('#datatable').DataTable({
        processing: true,
        // serverSide: true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'csv',
                text: 'Export',
                title: 'Menu Sub Categories {{ date('Y-m-d') }}', 
                className: 'btn-custom mb-3'
            }
        ],
        ajax: "{!! route('admin.menu_sub_categories.datatable', ['merchant_id'=>$merchant_id]) !!}",
        order: [[ 0, "desc" ]],
        columns: [
            { data: 'id', name: 'id' },
            { data: 'created_at', name: 'created_at' },
            { data: 'name', name: 'name' },
            { data: 'category', name: 'category' },
            { data: 'thumbnail', name: 'thumbnail' },
            { data: 'active', name: 'active',
                render: function(row){
                    return row? row : '-'
                } 
            },
            { data: 'actions', name: 'actions' },
        ]
    });

</script>
@stop
