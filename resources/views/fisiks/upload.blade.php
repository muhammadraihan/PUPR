@extends('layouts.page')

@section('title', 'Pelaksanaan Fisik Create')

@section('css')
<link rel="stylesheet" media="screen, print" href="{{asset('css/formplugins/dropzone/dropzone.css')}}">
@endsection

@section('content')
<div class="row">
    <div class="col-xl-6">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>Dokumentasi <span class="fw-300"><i>Pelaksanaan Fisik</i></span></h2>
                <div class="panel-toolbar">
                    <a class="nav-link active" href="{{route('fisik.index')}}"><i class="fal fa-arrow-alt-left">
                        </i>
                        <span class="nav-link-text">Back</span>
                    </a>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip"
                        data-offset="0,10" data-original-title="Fullscreen"></button>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="panel-tag">
                        Info Pekerjaan
                    </div>
                    {!! Form::open(['route' => 'fisik.store','method' => 'POST','class' =>
                    'needs-validation','novalidate']) !!}
                    <div class="row">
                        <div class="form-group col-md-8 mb-3">
                            {!! Form::label('pekerjaan', 'Nama Paket', ['class' => 'form-label']) !!}
                            {!! Form::text('pekerjaan',$fisik->pekerjaan->title, ['class' => 'form-control'.($errors->has('pekerjaan') ? 'is-invalid':''), 'disabled'
                            => 'disabled',]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-2 mb-3">
                            {!! Form::label('urutan', 'Pelaksanaan Ke', ['class' => 'form-label']) !!}
                            {!! Form::text('urutan',$fisik->nomor_pelaksanaan, ['class' => 'form-control'.($errors->has('urutan') ? 'is-invalid':''), 'disabled'
                            => 'disabled',]) !!}
                        </div>
                        <div class="form-group col-md-2 mb-3">
                            {!! Form::label('urutan', 'Tanggal Pelaksanaan', ['class' => 'form-label']) !!}
                            {!! Form::text('urutan',$fisik->tanggal_pelaksanaan, ['class' => 'form-control'.($errors->has('urutan') ? 'is-invalid':''), 'disabled'
                            => 'disabled',]) !!}
                        </div>
                    </div>
                    <div class="">
                        <div class="panel-hdr">
                            <h2>Dokumentasi <span class="fw-300"><i>Kondisi Awal</i></span></h2>
                        </div>
                        <div id="dropzone-early" class="dropzone">
                            <div class="needsclick dz-message">
                                <i class="fal fa-cloud-upload text-muted mb-3"></i> <br>
                                <span class="text-uppercase">Tarik file foto kesini atau klik untuk upload.</span>
                                <br>
                                <span class="fs-sm text-muted">file tidak boleh<strong> 3mb</strong></span>
                                <br>
                                <span class="fs-sm text-muted">file yang diizinkan adalah<strong> jpg, jpeg, png</strong></span>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="panel-hdr">
                            <h2>Dokumentasi <span class="fw-300"><i>Kondisi sebelum</i></span></h2>
                        </div>
                        <div id="dropzone-before" class="dropzone">
                            <div class="needsclick dz-message">
                                <i class="fal fa-cloud-upload text-muted mb-3"></i> <br>
                                <span class="text-uppercase">Tarik file foto kesini atau klik untuk upload.</span>
                                <br>
                                <span class="fs-sm text-muted">file tidak boleh<strong> 3mb</strong></span>
                                <br>
                                <span class="fs-sm text-muted">file yang diizinkan adalah<strong> jpg, jpeg, png</strong></span>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="panel-hdr">
                            <h2>Dokumentasi <span class="fw-300"><i>Kondisi Saat Ini</i></span></h2>
                        </div>
                        <div id="dropzone-present" class="dropzone">
                            <div class="needsclick dz-message">
                                <i class="fal fa-cloud-upload text-muted mb-3"></i> <br>
                                <span class="text-uppercase">Tarik file foto kesini atau klik untuk upload.</span>
                                <br>
                                <span class="fs-sm text-muted">file tidak boleh<strong> 3mb</strong></span>
                                <br>
                                <span class="fs-sm text-muted">file yang diizinkan adalah<strong> jpg, jpeg, png</strong></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                    <button class="btn btn-primary ml-auto" type="submit">Submit</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{asset('js/formplugins/dropzone/dropzone.js')}}"></script>
<script>
    // prevent dropzone attach twice
    Dropzone.autoDiscover = false;
    $(document).ready(function(){
        $("#dropzone-early").dropzone({ 
            paramName: "image-early",
            url: "/file/post",
            addRemoveLinks: true,
        });
        $("#dropzone-before").dropzone({
            paramName: "image-before",
            url: "/file/post",
            addRemoveLinks: true,
        });
        $("#dropzone-present").dropzone({
            paramName: "image-now",
            url: "/file/post",
            addRemoveLinks: true,
        });
    });
</script>
@endsection