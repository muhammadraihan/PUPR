@extends('layouts.page')

@section('title', 'Pekerjaan Create')

@section('css')
<link rel="stylesheet" media="screen, print" href="{{asset('css/formplugins/select2/select2.bundle.css')}}">
<link rel="stylesheet" media="screen, print" href="{{asset('css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css')}}">
@endsection

@section('content')
<div class="row">
    <div class="col-xl-6">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>Add New <span class="fw-300"><i>Pekerjaan</i></span></h2>
                <div class="panel-toolbar">
                    <a class="nav-link active" href="{{route('pekerjaan.index')}}"><i class="fal fa-arrow-alt-left">
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
                    {!! Form::open(['route' => 'pekerjaan.store','method' => 'POST','class' =>
                    'needs-validation','novalidate']) !!}
                    <div class="form-group col-md-4 mb-3">
                        {{ Form::label('title','Title',['class' => 'required form-label'])}}
                        {{ Form::text('title',null,['placeholder' => 'Title','class' => 'form-control '.($errors->has('title') ? 'is-invalid':''),'required'])}}
                        @if ($errors->has('title'))
                        <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-md-4 mb-3">
                        {{ Form::label('jenis_pekerjaan','Jenis Pekerjaan',['class' => 'required form-label'])}}
                        {{ Form::text('jenis_pekerjaan',null,['placeholder' => 'Jenis Pekerjaan','class' => 'form-control '.($errors->has('jenis_pekerjaan') ? 'is-invalid':''),'required'])}}
                        @if ($errors->has('jenis_pekerjaan'))
                        <div class="invalid-feedback">{{ $errors->first('jenis_pekerjaan') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-md-4 mb-3">
                        {{ Form::label('satker_id','ID Satuan Kerja',['class' => 'required form-label'])}}
                        {{ Form::text('satker_id',null,['placeholder' => 'ID Satuan Kerja','class' => 'form-control '.($errors->has('satker_id') ? 'is-invalid':''),'required'])}}
                        @if ($errors->has('satker_id'))
                        <div class="invalid-feedback">{{ $errors->first('satker_id') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-sm-6 col-xl-4">
                        <label>Tahun Mulai</label>
                        <input type="text" class="form-control js-bg-target" placeholder="Tahun Mulai"
                            id="mulai" name="tahun_mulai">
                        @if ($errors->has('mulai'))
                        <div class="invalid-feedback">{{ $errors->first('mulai') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-sm-6 col-xl-4">
                        <label>Tahun Selesai</label>
                        <input type="text" class="form-control js-bg-target" placeholder="Tahun Selesai"
                            id="selesai" name="tahun_selesai">
                        @if ($errors->has('selesai'))
                        <div class="invalid-feedback">{{ $errors->first('selesai') }}</div>
                        @endif
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
    $(document).ready(function(){
        $('.select2').select2();

        $('#mulai').datepicker({
            orientation: "bottom left",
            format: " yyyy", // Notice the Extra space at the beginning
            viewMode: "years",
            minViewMode: "years",
            todayHighlight:'TRUE',
            autoclose: true,
        });

        $('#selesai').datepicker({
            orientation: "bottom left",
            format: " yyyy", // Notice the Extra space at the beginning
            viewMode: "years",
            minViewMode: "years",
            todayHighlight:'TRUE',
            autoclose: true,
        });

    });
</script>
@endsection