@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h4 class="text-dark pl-2">Advertisement Management</h4>
@stop

@section('content')
    <!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">   
            <h5>Create New Advertisement</h5>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.advertisements.index')}}">Advertisements</a></li>
                <li class="breadcrumb-item">New Advertisement</li>
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
                                    <form class="form-horizontal" action="{{ route('admin.advertisements.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                                        @csrf                        
                                        <div class="row">
                                            <div class="col-lg-12" style="margin-top: 25px;">
                                                <div class="form-group text-right">
                                                    <a class="btn btn-secondary" href="{{ route('admin.advertisements.index') }}">Back</a>
                                                    <button type="submit" class="btn btn-success create-banner_btn">Add</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Advertisement Details</h3>
                                
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                    <i class="fas fa-minus"></i></button>
                                                    {{-- <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                                    <i class="fas fa-times"></i></button> --}}
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                    <div class="row">    
                                                        @include('admin.advertisements.form.index', ['readonly'=>''])
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12" style="margin-top: 25px;">
                                                <div class="form-group text-right">
                                                    <a class="btn btn-secondary" href="{{ route('admin.advertisements.index') }}">Back</a>
                                                    <button type="submit" class="btn btn-success create-banner_btn">Add</button>
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

</script>
@stop
