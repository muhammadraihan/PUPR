@extends('layouts.page')

@section('title', 'Siklus Create')

@section('css')
<link rel="stylesheet" media="screen, print" href="{{asset('css/formplugins/select2/select2.bundle.css')}}">
<link rel="stylesheet" media="screen, print" href="{{asset('css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css')}}">
@endsection

@section('content')
<div class="row">
    <div class="col-xl-6">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>Edit <span class="fw-300"><i>Dokumen Pembebasan Lahan</i></span></h2>
                <div class="panel-toolbar">
                    <a class="nav-link active" href="{{route('lahan.index')}}"><i class="fal fa-arrow-alt-left">
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
                        Form with <code>*</code> can not be empty.
                    </div>
                    {!! Form::open(['route' => ['lahan.update',$lahan->uuid],'method' => 'PUT','class' =>
                    'needs-validation','novalidate','enctype' => 'multipart/form-data']) !!}

                    <div class="form-group col-md-6 mb-3">
                        {{ Form::label('pekerjaan','Pekerjaan',['class' => 'required form-label'])}}
                        {{ Form::text('pekerjaan_id',$lahan->pekerjaan_id,['placeholder' => 'Pekerjaan','class' => 'form-control '.($errors->has('nama') ? 'is-invalid':''),'required'])}}
                        @if ($errors->has('pekerjaan'))
                        <div class="invalid-feedback">{{ $errors->first('pekerjaan') }}</div>
                        @endif
                    </div>

                    <div class="form-group col-md-6 mb-3">
                        {{ Form::label('kebutuhan','Kebutuhan',['class' => 'required form-label'])}}
                        {{ Form::text('kebutuhan',$lahan->kebutuhan,['placeholder' => 'Kebutuhan','class' => 'form-control '.($errors->has('kebutuhan') ? 'is-invalid':''),'required'])}}
                        @if ($errors->has('kebutuhan'))
                        <div class="invalid-feedback">{{ $errors->first('kebutuhan') }}</div>
                        @endif
                    </div>

                    <div class="form-group col-md-6 mb-3">
                        {{ Form::label('sudah_bebas','Sudah Bebas',['class' => 'required form-label'])}}
                        {{ Form::text('sudah_bebas',$lahan->sudah_bebas,['placeholder' => 'Sudah Bebas','class' => 'form-control '.($errors->has('sudah_bebas') ? 'is-invalid':''),'required'])}}
                        @if ($errors->has('sudah_bebas'))
                        <div class="invalid-feedback">{{ $errors->first('sudah_bebas') }}</div>
                        @endif
                    </div>

                    <div class="form-group col-md-6 mb-3">
                        {{ Form::label('belum_bebas','Belum Bebas',['class' => 'required form-label'])}}
                        {{ Form::text('belum_bebas',$lahan->belum_bebas,['placeholder' => 'Belum Bebas','class' => 'form-control '.($errors->has('belum_bebas') ? 'is-invalid':''),'required'])}}
                        @if ($errors->has('belum_bebas'))
                        <div class="invalid-feedback">{{ $errors->first('belum_bebas') }}</div>
                        @endif
                    </div>

                    <div class="form-group col-md-6 mb-3">
                        {{ Form::label('permasalahan','Permasalahan',['class' => 'required form-label'])}}
                        {{ Form::text('permasalahan',$lahan->permasalahan,['placeholder' => 'Permasalahan','class' => 'form-control '.($errors->has('permasalahan') ? 'is-invalid':''),'required'])}}
                        @if ($errors->has('permasalahan'))
                        <div class="invalid-feedback">{{ $errors->first('permasalahan') }}</div>
                        @endif
                    </div>

                    <div class="form-group col-md-6 mb-3">
                        {{ Form::label('tindak_lanjut','Tindak Lanjut',['class' => 'required form-label'])}}
                        {{ Form::text('tindak_lanjut',$lahan->tindak_lanjut,['placeholder' => 'Tindak Lanjut','class' => 'form-control '.($errors->has('tindak_lanjut') ? 'is-invalid':''),'required'])}}
                        @if ($errors->has('tindak_lanjut'))
                        <div class="invalid-feedback">{{ $errors->first('tindak_lanjut') }}</div>
                        @endif
                    </div>

                    <div class="form-group col-md-6 mb-3">
                        {{ Form::label('dokumentasi_id','Dokumentasi',['class' => 'required form-label'])}}
                        <iframe src="{{Storage::url('pembebasanLahan/'.$lahan->dokumentasi_id)}}" frameborder="0" style="width:100%;min-height:640px;"></iframe>
                        <input type="file" id="filecontrol" name="dokumentasi_id" class="form-control">
                        @if ($errors->has('dokumentasi_id'))
                        <div class="invalid-feedback">{{ $errors->first('dokumentasi_id') }}</div>
                        @endif
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
<script src="{{asset('js/formplugins/select2/select2.bundle.js')}}"></script>
<script src="{{asset('js/formplugins/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
@endsection