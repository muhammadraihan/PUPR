@extends('layouts.page')

@section('title', 'Pelaksanaan Fisik')

@section('css')
<link rel="stylesheet" media="screen, print" href="{{asset('css/datagrid/datatables/datatables.bundle.css')}}">
@endsection

@section('content')
<div class="subheader">
    <h1 class="subheader-title">
        <i class='subheader-icon fal fa-building'></i> Module: <span class='fw-300'>Pelaksanaan Fisik</span>
        <small>
            Module for manage pelaksanaan fisik.
        </small>
    </h1>
</div>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Pelaksanaan <span class="fw-300"><i>Fisik</i></span>
                </h2>
                <div class="panel-toolbar">
                    @can('add_pelaksanaan')
                    <a class="nav-link active" href="{{route('pelaksanaan.create')}}"><i class="fal fa-plus-circle">
                        </i>
                        <span class="nav-link-text">Add New</span>
                    </a>
                    @endcan
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip"
                        data-offset="0,10" data-original-title="Fullscreen"></button>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <!-- datatable start -->
                    <table id="datatable" class="table table-bordered table-hover table-striped w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Paket</th>
                                <th>Renc. Fisik (%)</th>
                                <th>Real. Fisik (%)</th>
                                <th>Dev. Fisik (%)</th>
                                <th>Renc. Keuangan (%)</th>
                                <th>Real. Keuangan (%)</th>
                                <th>Dev. Keuangan (%)</th>
                                <th>Permasalahan</th>
                                <th>Tindakan</th>
                                <th>Pelaksaaan</th>
                                <th>Tgl. Pelaksanaan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<form action="" method="POST" class="delete-form">
    {{ csrf_field() }}
    <!-- Delete modal center -->
    <div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Confirmation
                        <small class="m-0 text-muted">
                        </small>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure want to delete data?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary remove-data-from-delete-form"
                        data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Delete Data</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('js')
<script src="{{asset('js/datagrid/datatables/datatables.bundle.js')}}"></script>
<script>
    $(document).ready(function(){
        $('#datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "order": [[ 0, "asc" ]],
            "ajax":{
                url:'{{route('pelaksanaan.index')}}',
                type : "GET",
                dataType: 'json',
                error: function(data){
                    console.log(data);
                    }
            },
            "columns": [
                {data:'rownum',width:'*',searchable:false},
                {data: 'paket',width:'*'},
                {data: 'rencana_fisik',width:'*'},
                {data: 'realisasi_fisik',width:'*'},
                {data: 'deviasi_fisik',width:'*'},
                {data: 'rencana_keuangan',width:'*'},
                {data: 'realisasi_keuangan',width:'*'},
                {data: 'deviasi_keuangan',width:'*'},
                {data: 'permasalahan',width:'*'},
                {data: 'tindakan',width:'*'},
                {data: 'nomor_pelaksanaan',width:'*'},
                {data: 'tanggal_pelaksanaan',width:'*'},
                {data: 'action',width:'*',searchable:false}    
            ]
        });
        
        // Delete Data
        $('#datatable').on('click', '.delete-btn[data-url]', function (e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            var url = $(this).attr('data-url');
            var token = $(this).attr('data-token');
            $(".delete-form").attr("action",url);
            $('body').find('.delete-form').append('<input name="_token" type="hidden" value="'+ token +'">');
            $('body').find('.delete-form').append('<input name="_method" type="hidden" value="DELETE">');
            $('body').find('.delete-form').append('<input name="id" type="hidden" value="'+ id +'">');
        });

        // Clear Data When Modal Close
        $('.remove-data-from-delete-form').on('click',function() {
            $('body').find('.delete-form').find("input").remove();
        });
    });
</script>
@endsection