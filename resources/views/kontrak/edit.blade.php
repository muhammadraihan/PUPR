@extends('layouts.page')

@section('title', 'Kontrak Create')

@section('css')
<link rel="stylesheet" media="screen, print" href="{{asset('css/formplugins/select2/select2.bundle.css')}}">
<link rel="stylesheet" media="screen, print" href="{{asset('css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css')}}">
@endsection

@section('content')
<div class="row">
    <div class="col-xl-6">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>Edit <span class="fw-300"><i>Kontrak</i></span></h2>
                <div class="panel-toolbar">
                    <a class="nav-link active" href="{{route('kontrak.index')}}"><i class="fal fa-arrow-alt-left">
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
                    {!! Form::open(['route' => ['kontrak.update',$kontrak->uuid],'method' => 'PUT','class' =>
                    'needs-validation','novalidate']) !!}

                    <div class="form-group col-md-6 mb-3">
                        {!! Form::label('Pekerjaan', 'Pilih Pekerjaan', ['class' => 'required form-label']) !!}
                        <select class="pekerjaan select2 form-control" name="pekerjaan_id" readonly>
                            <option value="{{$kontrak->pekerjaan_id}}" selected>{{$kontrak->pekerjaan->title}}</option>
                        </select>
                        @if ($errors->has('pekerjaan'))
                        <div class="help-block text-danger">{{ $errors->first('pekerjaan') }}</div>
                        @endif
                    </div>

                    <div class="form-group col-md-6 mb-3">
                        {{ Form::label('pagu','Pagu(Dipa)',['class' => 'required form-label'])}}
                        {{ Form::text('pagu',$kontrak->pagu,['placeholder' => 'Pagu(Dipa)','class' => 'form-control '.($errors->has('pagu') ? 'is-invalid':''),'required'])}}
                        @if ($errors->has('pagu'))
                        <div class="invalid-feedback">{{ $errors->first('pagu') }}</div>
                        @endif
                    </div>

                    <div class="form-group col-md-6 mb-3">
                        {{ Form::label('nilai','Nilai Kontrak',['class' => 'required form-label'])}}
                        {{ Form::text('nilai_kontrak',$kontrak->nilai_kontrak,['placeholder' => 'Nilai Kontrak','class' => 'form-control '.($errors->has('nilai') ? 'is-invalid':''),'required'])}}
                        @if ($errors->has('nilai'))
                        <div class="invalid-feedback">{{ $errors->first('nilai') }}</div>
                        @endif
                    </div>
                    @if ($kontrak->panjang_jalan !== null)
                        <div class="form-group col-md-6 mb-3">
                            {{ Form::label('jalan','Panjang Jalan',['class' => 'required form-label'])}}
                            {{ Form::text('panjang_jalan',$kontrak->panjang_jalan,['placeholder' => 'Panjang Jalan','class' => 'form-control '.($errors->has('jalan') ? 'is-invalid':''),'required'])}}
                            @if ($errors->has('jalan'))
                            <div class="invalid-feedback">{{ $errors->first('jalan') }}</div>
                            @endif
                        </div>
                    @else
                        <div class="form-group col-md-6 mb-3">
                            {{ Form::label('jembatan','Panjang Jembatan',['class' => 'required form-label'])}}
                            {{ Form::text('panjang_jembatan',$kontrak->panjang_jembatan,['placeholder' => 'Panjang Jembatan','class' => 'form-control '.($errors->has('jembatan') ? 'is-invalid':''),'required'])}}
                            @if ($errors->has('jembatan'))
                            <div class="invalid-feedback">{{ $errors->first('jembatan') }}</div>
                            @endif
                        </div>
                    @endif
                    
                    <div class="form-group col-sm-6 col-xl-4">
                        <label>Tahun Anggaran</label>
                        <input type="text" class="form-control js-bg-target" placeholder="Tahun Anggaran"
                            id="anggaran" name="tahun_anggaran" value="{{$kontrak->tahun_anggaran}}">
                        @if ($errors->has('anggaran'))
                        <div class="invalid-feedback">{{ $errors->first('anggaran') }}</div>
                        @endif
                    </div>

                    <div class="form-group col-sm-6 col-xl-4">
                        <label>Tanggal Awal Kontrak</label>
                        <input type="text" class="form-control js-bg-target" placeholder="Tanggal Awal Kontrak"
                            id="start" name="tanggal_kontrak_awal" value="{{Carbon\Carbon::parse($kontrak->tanggal_kontrak_awal)->format('d-m-Y')}}">
                        @if ($errors->has('start'))
                        <div class="invalid-feedback">{{ $errors->first('start') }}</div>
                        @endif
                    </div>

                    <div class="form-group col-sm-6 col-xl-4">
                        <label>Tanggal Adendum Kontrak</label>
                        <input type="text" class="form-control js-bg-target" placeholder="Tanggal Adendum Kontrak"
                            id="adendum-awal" name="tanggal_adendum_kontrak" value="{{Carbon\Carbon::parse($kontrak->tanggal_adendum_kontrak)->format('d-m-Y')}}">
                        @if ($errors->has('adendum-awal'))
                        <div class="invalid-feedback">{{ $errors->first('adendum-awal') }}</div>
                        @endif
                    </div>

                    <div class="form-group col-sm-6 col-xl-4">
                        <label>Tanggal Adendum Akhir</label>
                        <input type="text" class="form-control js-bg-target" placeholder="Tanggal Adendum Akhir"
                            id="adendum-akhir" name="tanggal_adendum_akhir" value="{{Carbon\Carbon::parse($kontrak->tanggal_adendum_akhir)->format('d-m-Y')}}">
                        @if ($errors->has('adendum-akhir'))
                        <div class="invalid-feedback">{{ $errors->first('adendum-akhir') }}</div>
                        @endif
                    </div>

                    <div class="form-group col-sm-6 col-xl-4">
                        <label>Tanggal PHO</label>
                        <input type="text" class="form-control js-bg-target" placeholder="Tanggal PHO"
                            id="pho" name="tanggal_pho" value="{{Carbon\Carbon::parse($kontrak->tanggal_pho)->format('d-m-Y')}}">
                        @if ($errors->has('pho'))
                        <div class="invalid-feedback">{{ $errors->first('pho') }}</div>
                        @endif
                    </div>

                    <div class="form-group col-sm-6 col-xl-4">
                        <label>Tanggal FHO</label>
                        <input type="text" class="form-control js-bg-target" placeholder="Tanggal FHO"
                            id="fho" name="tanggal_fho" value="{{Carbon\Carbon::parse($kontrak->tanggal_fho)->format('d-m-Y')}}">
                        @if ($errors->has('fho'))
                        <div class="invalid-feedback">{{ $errors->first('fho') }}</div>
                        @endif
                    </div>

                    <div class="form-group col-md-6 mb-3">
                        {{ Form::label('data_teknis','Data Teknis',['class' => 'required form-label'])}}
                        {{ Form::textarea('data_teknis',$kontrak->data_teknis,['placeholder' => 'Data Teknis ','class' => 'form-control '.($errors->has('data_teknis') ? 'is-invalid':''),'required'])}}
                        @if ($errors->has('data_teknis'))
                        <div class="invalid-feedback">{{ $errors->first('data_teknis') }}</div>
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
    $(document).ready(function(){
        $('.select2').select2();

        $('#anggaran').datepicker({
            orientation: "bottom left",
            format: " yyyy", // Notice the Extra space at the beginning
            viewMode: "years",
            minViewMode: "years",
            todayHighlight:'TRUE',
            autoclose: true,
        });

        $('#start').datepicker({
            orientation: "bottom left",
            format: "dd-mm-yyyy",
            todayHighlight:'TRUE',
            autoclose: true,
        });

        $('#adendum-awal').datepicker({
            orientation: "bottom left",
            format: "dd-mm-yyyy",
            todayHighlight:'TRUE',
            autoclose: true,
        });

        $('#adendum-akhir').datepicker({
            orientation: "bottom left",
            format: "dd-mm-yyyy",
            todayHighlight:'TRUE',
            autoclose: true,
        });

        $('#pho').datepicker({
            orientation: "bottom left",
            format: "dd-mm-yyyy",
            todayHighlight:'TRUE',
            autoclose: true,
        });

        $('#fho').datepicker({
            orientation: "bottom left",
            format: "dd-mm-yyyy",
            todayHighlight:'TRUE',
            autoclose: true,
        });

    });
</script>
@endsection