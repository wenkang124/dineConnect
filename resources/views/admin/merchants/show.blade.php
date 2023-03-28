@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="row">
        <div class="col-lg-auto">
            <h4 class="text-dark pl-2">Merchant Management</h4>
        </div>
        <div class="col-lg-auto ml-auto">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    More Action
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    {{-- <a class="dropdown-item" href="{{ route('admin.menu_sub_categories.index', ['merchant_id'=> $item->id]) }}">Dishes Management</a> --}}
                    <a class="dropdown-item" href="{{ route('admin.merchant_galleries.index', ['merchant_id'=> $item->id]) }}">Galleries Management</a>
                    <a class="dropdown-item" href="{{ route('admin.merchant_reviews.index', ['merchant_id'=> $item->id]) }}">Reviews Management</a>
                </div>
            </div>
        </div>
        <div class="col-lg-auto">
            <a href="{{ route('admin.menu_sub_categories.index', ['merchant_id'=>$item->id]) }}" class="btn btn-primary" title="Manage">
                Manage Sub Categories
            </a>
        </div>
        <div class="col-lg-auto">
            <a href="{{ route('admin.menu_foods.index', ['merchant_id'=>$item->id]) }}" class="btn btn-primary" title="Manage">
                Manage Dishes
            </a>
        </div>
    </div>
@stop

@section('content')
    <!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">   
            <h5>Listing</h5>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.merchants.index')}}">Merchants</a></li>
                <li class="breadcrumb-item">{{ $item->name }}</li>
            </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            @if(Session::has('success'))
                <div class="col-lg-12">
                    <div class="alert alert-success">{!! Session::get('success') !!}</div>
                </div>
            @endif
            @if ($errors->any())
            <div class="col-lg-12">
                <div class="alert alert-danger alert-dismissable">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            <div class="col-lg-12">                    
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <section class="content">
                                    <!-- Default box -->
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Merchant Details</h3>
                            
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                <i class="fas fa-minus"></i></button>
                                                {{-- <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                                <i class="fas fa-times"></i></button> --}}
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">    
                                                @include('admin.merchants.form.index', ['readonly'=>'readonly'])
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Other Details</h3>
                            
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                <i class="fas fa-minus"></i></button>
                                                {{-- <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                                <i class="fas fa-times"></i></button> --}}
                                            </div>
                                        </div>
                                        <div class="card-body">      
                                            <div class="row">    
                                                @include('admin.merchants.form.other-details', ['readonly'=>'readonly'])
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
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
    // $('#datatable').DataTable({
    //     processing: true,
    //     // serverSide: true,
    //     dom: 'Bfrtip',
    //     buttons: [
    //         { extend: 'copy', text: 'Copy' },
    //         {
    //             extend: 'csv',
    //             text: 'Export',
    //             title: 'Merchants {{ date('Y-m-d') }}'
    //         },
    //         {
    //             extend: 'print',
    //             text: 'Print',
    //             key: {
    //                 key: 'p',
    //                 altkey: true
    //             }, 
    //             title: 'Merchants {{ date('Y-m-d') }}'
    //         }
    //     ],
    //     ajax: "{!! route('admin.merchants.datatable') !!}",
    //     order: [[ 0, "desc" ]],
    //     columns: [
    //         { data: 'id', name: 'id' },
    //         { data: 'created_at', name: 'created_at' },
    //         { data: 'name', name: 'name' },
    //         { data: 'email', name: 'email' },
    //         { data: 'phone', name: 'phone' },
    //         { data: 'status', name: 'status',
    //             render: function(row){
    //                 return row? row : '-'
    //             } 
    //         },
    //         { data: 'action', name: 'action' },
    //     ]
    // });

</script>
@stop
