@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h4 class="text-dark pl-2">Dishes Management</h4>
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
                <li class="breadcrumb-item"><a href="{{route('admin.menu_foods.index', ['merchant_id'=>$merchant_id])}}">Dishes</a></li>
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
                                            <h3 class="card-title">Dish Details</h3>
                            
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                <i class="fas fa-minus"></i></button>
                                                {{-- <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                                <i class="fas fa-times"></i></button> --}}
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">    
                                                @include('admin.menu_foods.form.index', ['readonly'=>'readonly'])
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Flavours</h3>
                            
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                <i class="fas fa-minus"></i></button>
                                                {{-- <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                                <i class="fas fa-times"></i></button> --}}
                                            </div>
                                        </div>
                                        <div class="card-body">   
                                            @if(count($item->flavours) > 0)
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <div class="form-group">
                                                        <label for="flavour_titles" class="moto-widget-contact_form-label">Title <span class="text-danger">*Example: Spicy-ness, Sour-ness, etc</span></label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5">
                                                    <div class="form-group">
                                                        <label for="flavour_percentages" class="moto-widget-contact_form-label">Percentage <span class="text-danger">%</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                            @include('admin.menu_foods.form.flavours', ['readonly'=>'readonly'])  
                                            @else
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <p>No flavour.</p>
                                                </div>
                                            </div>
                                            @endif              
                                        </div>   
                                    </div> 
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Portions</h3>
                            
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                <i class="fas fa-minus"></i></button>
                                                {{-- <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                                <i class="fas fa-times"></i></button> --}}
                                            </div>
                                        </div>
                                        <div class="card-body">  
                                            @if(count($item->portions) > 0)
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <label for="portion_sizes" class="moto-widget-contact_form-label">Size</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="portion_servings" class="moto-widget-contact_form-label">Portion Serving <span class="text-danger">*Example: 1.5 - 2 person portion</span></label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="portion_descriptions" class="moto-widget-contact_form-label">Portion Description <span class="text-danger">*Example: Suitable for sharing and hungers.</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                            @include('admin.menu_foods.form.portions', ['readonly'=>'readonly'])   
                                            @else
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <p>No portion.</p>
                                                </div>
                                            </div>
                                            @endif              
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
    //             title: 'Foods {{ date('Y-m-d') }}'
    //         },
    //         {
    //             extend: 'print',
    //             text: 'Print',
    //             key: {
    //                 key: 'p',
    //                 altkey: true
    //             }, 
    //             title: 'Foods {{ date('Y-m-d') }}'
    //         }
    //     ],
    //     ajax: "{!! route('admin.menu_foods.datatable', ['merchant_id'=>$merchant_id]) !!}",
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
