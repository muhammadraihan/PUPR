@extends('layouts.page')

@section('title', 'Pekerjaan Edit')

@section('css')
<link rel="stylesheet" media="screen, print" href="{{asset('css/formplugins/select2/select2.bundle.css')}}">
<link rel="stylesheet" media="screen, print" href="{{asset('css/formplugins/summernote/summernote.css')}}">
<link rel="stylesheet" media="screen, print" href="{{asset('css/formplugins/dropzone/dropzone.css')}}">
<link rel="stylesheet" media="screen, print" href="{{asset('css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css')}}">
@endsection

@section('content')
<div class="row">
    <div class="col-xl-6">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
            <h2>Edit <span class="fw-300"><i>{{$pekerjaan->nama}}</i></span></h2>
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
                    {!! Form::open(['route' => ['pekerjaan.update',$pekerjaan->uuid],'method' => 'PUT','class' =>
                    'needs-validation','novalidate']) !!}
                    <div class="form-group col-md-4 mb-3">
                        {{ Form::label('title','Title',['class' => 'required form-label'])}}
                        {{ Form::text('title',$pekerjaan->title,['placeholder' => 'Title','class' => 'form-control '.($errors->has('title') ? 'is-invalid':''),'required'])}}
                        @if ($errors->has('title'))
                        <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-md-4 mb-3">
                            {!! Form::label('jenis_pekerjaan', 'Jenis Pekerjaan', ['class' => 'required form-label']) !!}
                            {!! Form::select('jenis_pekerjaan', $jenkers, $pekerjaan->jenker->nama, ['class' => 'select2 form-control'.($errors->has('jenis_pekerjaan') ? 'is-invalid':''), 'required'
                            => '',]) !!}
                            @if ($errors->has('jenis_pekerjaan'))
                            <div class="help-block text-danger">{{ $errors->first('jenis_pekerjaan') }}</div>
                            @endif
                    </div>
                    <div class="form-group col-md-4 mb-3">
                        {{ Form::label('satker_id','ID Satuan Kerja',['class' => 'required form-label'])}}
                        {!! Form::select('satker_id', $satkers, $pekerjaan->satker->nama, ['class' => 'select2 form-control'.($errors->has('satker_id') ? 'is-invalid':''), 'required'
                            => '',]) !!}
                            @if ($errors->has('satker_id'))
                            <div class="help-block text-danger">{{ $errors->first('satler_id') }}</div>
                            @endif
                    </div>
                    <div class="form-group col-md-3 mb-3">
                            {{ Form::label('tahun_mulai','Tahun Mulai',['class' => 'required form-label'])}}
                            <div class="input-group">
                                {{ Form::text('tahun_mulai',$pekerjaan->tahun_mulai,['id'=>'mulai','placeholder' => 'Tahun Mulai','class' => 'form-control '.($errors->has('tahun_mulai') ? 'is-invalid':''),'required'])}}
                                @if ($errors->has('tahun_mulai'))
                                <div class="invalid-feedback">{{ $errors->first('tahun_mulai') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group col-md-3 mb-3">
                            {{ Form::label('tahun_selesai','Tahun Selesai',['class' => 'required form-label'])}}
                            <div class="input-group">
                                {{ Form::text('tahun_selesai',$pekerjaan->tahun_selesai,['id'=>'selesai','placeholder' => 'Tahun Selesai','class' => 'form-control '.($errors->has('tahun_selesai') ? 'is-invalid':''),'required'])}}
                                @if ($errors->has('tahun_selesai'))
                                <div class="invalid-feedback">{{ $errors->first('tahun_selesai') }}</div>
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

    var controls = {
        leftArrow: '<i class="fal fa-angle-left" style="font-size: 1.25rem"></i>',
        rightArrow: '<i class="fal fa-angle-right" style="font-size: 1.25rem"></i>'
    }
    var runDatePicker = function (){
        $('#mulai').datepicker({
            autoclose:true,
            format:'yyyy',
            todayHighlight: true,
            todayBtn: "linked",
            orientation: "bottom left",
            clearBtn: true,
            templates: controls,
            viewMode: "years",
            minViewMode: "years",
        });

        $('#selesai').datepicker({
            autoclose:true,
            format:'yyyy-mm-dd',
            todayHighlight: true,
            todayBtn: "linked",
            orientation: "bottom left",
            clearBtn: true,
            templates: controls,
            viewMode: "years",
            minViewMode: "years",
        });
    }

    $(document).ready(function(){
        $('.select2').select2();

        runDatePicker();
    });
</script>
@endsection