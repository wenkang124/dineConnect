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
            <h5>Create New Dish</h5>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.menu_foods.index', ['merchant_id'=>$merchant_id])}}">Dishes</a></li>
                <li class="breadcrumb-item">New Dish</li>
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
                                    <form class="form-horizontal" action="{{ route('admin.menu_foods.store', ['merchant_id'=>$merchant_id]) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                                        @csrf                  
                                        <div class="row">
                                            <div class="col-lg-12" style="margin-top: 25px;">
                                                <div class="form-group text-right">
                                                    <a class="btn btn-secondary" href="{{ route('admin.menu_foods.index', ['merchant_id'=>$merchant_id]) }}">Back</a>
                                                    <button type="submit" class="btn btn-success create-menu_food_btn">Create</button>
                                                </div>
                                            </div>
                                        </div>
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
                                                    @include('admin.menu_foods.form.index', ['readonly'=>''])
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
                                                    <div class="col-lg-2">
                                                        <div class="form-group">
                                                            <button type="button" class="btn bg-success addmore" 
                                                            data-container="flavour_container" 
                                                            data-clone="flavour_percentage"
                                                            data-input-count="3"
                                                            data-input-1="portion_size_input" data-input-name-1="portion_sizes[]"
                                                            data-input-2="portion_servings_input" data-input-name-2="portion_servings[]"
                                                             data-input-3="portion_descriptions_input" data-input-name-3="portion_descriptions[]">
                                                                Add
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                @include('admin.menu_foods.form.flavours', ['readonly'=>''])                 
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
                                                    <div class="col-lg-2">
                                                        <div class="form-group">
                                                            <button type="button" class="btn bg-success addmore"
                                                            data-container="portion_container" 
                                                            data-clone="portion_list"
                                                            data-input-name-1="portion_sizes[]"
                                                            data-input-name-2="portion_servings[]"
                                                            data-input-name-3="portion_descriptions[]">
                                                                Add
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                @include('admin.menu_foods.form.portions', ['readonly'=>''])                 
                                            </div>                                            
                                        </div>                 
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group text-right">
                                                    <a class="btn btn-secondary" href="{{ route('admin.menu_foods.index', ['merchant_id'=>$merchant_id]) }}">Back</a>
                                                    <button type="submit" class="btn btn-success create-menu_food_btn">Create</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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

     
@if(old('phone'))
    var old_telephone_val = "{{ old('phone') }}";
    setTimeout(
        function() {
            $('#telephone').val('');
            $('#telephone').val(old_telephone_val);
        }, 100);
@endif

@if(old('mobile_prefix_id'))
    var old_mobile_prefix = "{{ old('mobile_prefix_id') }}";
    $('.dial_code').val(old_mobile_prefix);
    // $("span:contains('FIND ME')")
    setTimeout(
        function() {
            var span_with_moblie_prefix = $('.moto-widget-contact_form-form .iti--separate-dial-code .iti__country-list .iti__dial-code:contains(+213)');
            // console.log('span_with_moblie_prefix', span_with_moblie_prefix);
            var parent_li = span_with_moblie_prefix.parent();
            // console.log('parent_li', parent_li);
            // parent_li.trigger("click");
            parent_li.click();
        }, 1000);
@endif
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
