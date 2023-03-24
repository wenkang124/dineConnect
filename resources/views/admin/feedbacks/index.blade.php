@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<div class="row">
    <div class="col-lg-auto">
        <h4 class="text-dark pl-2">Feedback Management</h4>
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
                            <h3 class="card-title">Feedback Listing</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Created At</th>
                                            <th>User</th>
                                            <th>Message</th>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.0/chart.min.js" integrity="sha512-asxKqQghC1oBShyhiBwA+YgotaSYKxGP1rcSYTDrB0U6DxwlJjU59B67U8+5/++uFjcuVM8Hh5cokLjZlhm3Vg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $('#datatable').DataTable({
        processing: true,
        // serverSide: true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'csv',
                text: 'Export',
                title: 'Feedbacks {{ date('Y-m-d') }}', 
                className: 'btn-custom mb-3'
            }
        ],
        ajax: "{!! route('admin.feedbacks.datatable') !!}",
        columns: [
            { data: 'id', name: 'id',
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },orderable: false
            },
            { data: 'created_at', name: 'created_at' },
            { data: 'user_name', name: 'user_name' },
            { data: 'message', name: 'message' },
            ]
    });

</script>
@stop