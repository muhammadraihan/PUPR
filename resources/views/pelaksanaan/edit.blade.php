@extends('layouts.page')

@section('title', 'Pelaksanaan Fisik Edit')

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
                <h2>Edit<span class="fw-300"><i>Pelaksanaan</i></span></h2>
                <div class="panel-toolbar">
                    <a class="nav-link active" href="{{route('pelaksanaan.index')}}"><i class="fal fa-arrow-alt-left">
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
                    {!! Form::open(['route' => 'pelaksanaan.store','method' => 'POST','class' =>
                    'needs-validation','novalidate']) !!}
                    <div class="form-row">
                        <div class="form-group col-md-8 mb-3">
                            {!! Form::label('pekerjaan', 'Pekerjaan', ['class' => 'required form-label']) !!}
                            {!! Form::select('pekerjaan', $pekerjaans, $pelaksanaan->pekerjaan->title, ['class' => 'select2 form-control'.($errors->has('pekerjaan') ? 'is-invalid':''), 'required'
                            => '',]) !!}
                            @if ($errors->has('pekerjaan'))
                            <div class="help-block text-danger">{{ $errors->first('pekerjaan') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-row">
                         <div class="form-group col-md-2 mb-3">
                            {{ Form::label('urutan','Pelaksaan Ke',['class' => 'required form-label'])}}
                            <div id="urutan" class="input-group">
                                {{ Form::text('urutan',$pelaksanaan->nomor_pelaksanaan,['placeholder' => 'Pelaksaaan ke','class' => 'form-control '.($errors->has('urutan') ? 'is-invalid':''),'required'])}}
                                @if ($errors->has('urutan'))
                                <div class="invalid-feedback">{{ $errors->first('urutan') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group col-md-3 mb-3">
                            {{ Form::label('tanggal','Tanggal Pelaksanaan',['class' => 'required form-label'])}}
                            <div class="input-group">
                                {{ Form::text('tanggal',$pelaksanaan->tanggal_pelaksanaan,['id'=>'date','placeholder' => 'Tanggal Pelaksaaan','class' => 'form-control '.($errors->has('tanggal') ? 'is-invalid':''),'required'])}}
                                @if ($errors->has('tanggal'))
                                <div class="invalid-feedback">{{ $errors->first('tanggal') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="panel-hdr">
                            <h2>Pelaksanaan <span class="fw-300"><i>Fisik</i></span></h2>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3 mb-3">
                                {{ Form::label('rencana_fisik','Rencana',['class' => 'required form-label'])}}
                                <div id="rencana_fisik" class="input-group">
                                    {{ Form::text('rencana_fisik',$pelaksanaan->rencana_fisik,['placeholder' => 'rencana_fisik','class' => 'form-control '.($errors->has('rencana_fisik') ? 'is-invalid':''),'required'])}}
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            0.00
                                        </span>
                                        <span class="input-group-text">
                                            <i class="fal fa-percent"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('rencana_fisik'))
                                    <div class="invalid-feedback">{{ $errors->first('rencana_fisik') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group col-md-3 mb-3">
                                {{ Form::label('realisasi_fisik','Realisasi',['class' => 'required form-label'])}}
                                <div id="realisasi_fisik" class="input-group">
                                    {{ Form::text('realisasi_fisik',$pelaksanaan->realisasi_fisik,['placeholder' => 'realisasi_fisik','class' => 'form-control '.($errors->has('realisasi_fisik') ? 'is-invalid':''),'required'])}}
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            0.00
                                        </span>
                                        <span class="input-group-text">
                                            <i class="fal fa-percent"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('realisasi_fisik'))
                                    <div class="invalid-feedback">{{ $errors->first('realisasi_fisik') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group col-md-3 mb-3">
                                {{ Form::label('deviasi_fisik','Deviasi',['class' => 'required form-label'])}}
                                <div id="deviasi_fisik" class="input-group">
                                    {{ Form::text('deviasi_fisik',$pelaksanaan->deviasi_fisik,['placeholder' => 'deviasi_fisik','class' => 'form-control '.($errors->has('deviasi_fisik') ? 'is-invalid':''),'required'])}}
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            0.00
                                        </span>
                                        <span class="input-group-text">
                                            <i class="fal fa-percent"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('deviasi_fisik'))
                                    <div class="invalid-feedback">{{ $errors->first('deviasi_fisik') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="panel-hdr">
                            <h2>Pelaksanaan <span class="fw-300"><i>Keuangan</i></span></h2>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3 mb-3">
                                {{ Form::label('rencana_keuangan','Rencana',['class' => 'required form-label'])}}
                                <div id="rencana_keuangan" class="input-group">
                                    {{ Form::text('rencana_keuangan',$pelaksanaan->rencana_keuangan,['placeholder' => 'rencana_keuangan','class' => 'form-control '.($errors->has('rencana_keuangan') ? 'is-invalid':''),'required'])}}
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            0.00
                                        </span>
                                        <span class="input-group-text">
                                            <i class="fal fa-percent"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('rencana_keuangan'))
                                    <div class="invalid-feedback">{{ $errors->first('rencana_keuangan') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group col-md-3 mb-3">
                                {{ Form::label('realisasi_keuangan','Realisasi',['class' => 'required form-label'])}}
                                <div id="realisasi_keuangan" class="input-group">
                                    {{ Form::text('realisasi_keuangan',$pelaksanaan->realisasi_keuangan,['placeholder' => 'realisasi_keuangan','class' => 'form-control '.($errors->has('realisasi_keuangan') ? 'is-invalid':''),'required'])}}
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            0.00
                                        </span>
                                        <span class="input-group-text">
                                            <i class="fal fa-percent"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('realisasi_keuangan'))
                                    <div class="invalid-feedback">{{ $errors->first('realisasi_keuangan') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group col-md-3 mb-3">
                                {{ Form::label('deviasi_keuangan','Deviasi',['class' => 'required form-label'])}}
                                <div id="deviasi_keuangan" class="input-group">
                                    {{ Form::text('deviasi_keuangan',$pelaksanaan->deviasi_keuangan,['placeholder' => 'deviasi_keuangan','class' => 'form-control '.($errors->has('deviasi_keuangan') ? 'is-invalid':''),'required'])}}
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            0.00
                                        </span>
                                        <span class="input-group-text">
                                            <i class="fal fa-percent"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('deviasi_keuangan'))
                                    <div class="invalid-feedback">{{ $errors->first('deviasi_keuangan') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-xl-12 mb-4">
                            {{ Form::label('permasalahan','Permasalahan',['class' => 'form-label'])}}
                            {!! Form::textarea('permasalahan',$pelaksanaan->permasalahan, ['class' => 'form-control'.($errors->has('permasalahan') ? 'is-invalid':''),'required' => 'required','rows' => 5]) !!}
                            @if ($errors->has('permasalahan'))
                            <div class="help-block text-danger">{{ $errors->first('permasalahan') }}</div>
                            @endif
                        </div>
                        <div class="form-group col-xl-12 mb-4">
                            {{ Form::label('tindakan','Tindak Lanjut',['class' => 'form-label'])}}
                            {!! Form::textarea('tindakan',$pelaksanaan->tindakan, ['class' => 'form-control'.($errors->has('tindakan') ? 'is-invalid':''),'required' => 'required','rows' => 5]) !!}
                            @if ($errors->has('tindakan'))
                            <div class="help-block text-danger">{{ $errors->first('tindakan') }}</div>
                            @endif
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
<script src="{{asset('js/formplugins/select2/select2.bundle.js')}}"></script>
<script src="{{asset('js/formplugins/summernote/summernote.js')}}"></script>
<script src="{{asset('js/formplugins/dropzone/dropzone.js')}}"></script>
<script src="{{asset('js/formplugins/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>
<script>
    // date picker
    var controls = {
        leftArrow: '<i class="fal fa-angle-left" style="font-size: 1.25rem"></i>',
        rightArrow: '<i class="fal fa-angle-right" style="font-size: 1.25rem"></i>'
    }
    var runDatePicker = function (){
        $('#date').datepicker({
            autoclose:true,
            format:'yyyy-mm-dd',
            todayHighlight: true,
            todayBtn: "linked",
            orientation: "bottom left",
            clearBtn: true,
            templates: controls
        });
    }

    $(document).ready(function(){
        runDatePicker();
        $('.select2').select2();
        $('.summernote').summernote();
    });
</script>
@endsection