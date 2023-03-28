@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h4 class="text-dark pl-2">Review Management:- <a href="{{ route('admin.merchants.show',$merchant) }}">{{ $merchant->name }}</a></h4>
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
                <li class="breadcrumb-item"><a href="{{route('admin.merchant_reviews.index', ['merchant_id'=> $merchant_id])}}">Reviews</a></li>
                <li class="breadcrumb-item">Review Details</li>
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
                                            <h3 class="card-title">Review Details</h3>
                            
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                <i class="fas fa-minus"></i></button>
                                                {{-- <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                                <i class="fas fa-times"></i></button> --}}
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">    
                                                @include('admin.merchants.reviews.form.index', ['readonly'=>'readonly'])
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">  
                @include('admin.merchants.reviews.comments.index')
            </div>
            
            <div class="col-lg-12">  
                @include('admin.merchants.reviews.reports.index')
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
                title: 'Review Comments {{ date('Y-m-d') }}', 
                className: 'btn-custom mb-3'
            }
        ],
        ajax: "{!! route('admin.review_comments.datatable', ['review_id'=>$item->id]) !!}",
        order: [[ 0, "desc" ]],
        columns: [
            { data: 'id', name: 'id' },
            { data: 'created_at', name: 'created_at' },
            { data: 'user', name: 'user' },
            { data: 'message', name: 'message' },
            { data: 'total_likes', name: 'total_likes' },
            { data: 'total_reports', name: 'total_reports' },
            { data: 'active', name: 'active',
                render: function(row){
                    return row? row : '-'
                } 
            },
            { data: 'actions', name: 'actions' },
        ]
    });

    $('#datatable2').DataTable({
        processing: true,
        // serverSide: true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'csv',
                text: 'Export',
                title: 'Review Reports {{ date('Y-m-d') }}', 
                className: 'btn-custom mb-3'
            }
        ],
        ajax: "{!! route('admin.review_reports.datatable', ['review_id'=>$item->id]) !!}",
        order: [[ 0, "desc" ]],
        columns: [
            { data: 'id', name: 'id' },
            { data: 'created_at', name: 'created_at' },
            { data: 'user', name: 'user' },
            { data: 'reason_name', name: 'reason_name' },
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
