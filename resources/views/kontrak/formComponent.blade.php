@section('css')

<div class="form-group col-md-6 mb-3">
    {{ Form::label('pagu','Pagu(Dipa)',['class' => 'required form-label'])}}
    {{ Form::text('pagu',null,['placeholder' => 'Pagu(Dipa)','class' => 'form-control '.($errors->has('pagu') ? 'is-invalid':''),'required'])}}
    @if ($errors->has('pagu'))
    <div class="invalid-feedback">{{ $errors->first('pagu') }}</div>
    @endif
</div>

<div class="form-group col-md-6 mb-3">
    {{ Form::label('nilai','Nilai Kontrak',['class' => 'required form-label'])}}
    {{ Form::text('nilai_kontrak',null,['placeholder' => 'Nilai Kontrak','class' => 'form-control '.($errors->has('nilai') ? 'is-invalid':''),'required'])}}
    @if ($errors->has('nilai'))
    <div class="invalid-feedback">{{ $errors->first('nilai') }}</div>
    @endif
</div>

@if ($pekerjaan->jenis->nama == 'Jalan')
    
<div class="form-group col-md-6 mb-3">
    {{ Form::label('jalan','Panjang Jalan',['class' => 'required form-label'])}}
    {{ Form::text('panjang_jalan',null,['placeholder' => 'Panjang Jalan','class' => 'form-control '.($errors->has('jalan') ? 'is-invalid':''),'required'])}}
    @if ($errors->has('jalan'))
    <div class="invalid-feedback">{{ $errors->first('jalan') }}</div>
    @endif
</div>

@else

<div class="form-group col-md-6 mb-3">
    {{ Form::label('jembatan','Panjang Jembatan',['class' => 'required form-label'])}}
    {{ Form::text('panjang_jembatan',null,['placeholder' => 'Panjang Jembatan','class' => 'form-control '.($errors->has('jembatan') ? 'is-invalid':''),'required'])}}
    @if ($errors->has('jembatan'))
    <div class="invalid-feedback">{{ $errors->first('jembatan') }}</div>
    @endif
</div>

@endif


<div class="form-group col-sm-6 col-xl-4">
    <label>Tahun Anggaran</label>
    <input type="text" class="form-control js-bg-target" placeholder="Tahun Anggaran"
        id="anggaran" name="tahun_anggaran">
    @if ($errors->has('anggaran'))
    <div class="invalid-feedback">{{ $errors->first('anggaran') }}</div>
    @endif
</div>

<div class="form-group col-sm-6 col-xl-4">
    <label>Tanggal Awal Kontrak</label>
    <input type="text" class="form-control js-bg-target" placeholder="Tanggal Awal Kontrak"
        id="start" name="tanggal_kontrak_awal">
    @if ($errors->has('start'))
    <div class="invalid-feedback">{{ $errors->first('start') }}</div>
    @endif
</div>

<div class="form-group col-sm-6 col-xl-4">
    <label>Tanggal Adendum Kontrak</label>
    <input type="text" class="form-control js-bg-target" placeholder="Tanggal Adendum Kontrak"
        id="adendum-awal" name="tanggal_adendum_kontrak">
    @if ($errors->has('adendum-awal'))
    <div class="invalid-feedback">{{ $errors->first('adendum-awal') }}</div>
    @endif
</div>

<div class="form-group col-sm-6 col-xl-4">
    <label>Tanggal Adendum Akhir</label>
    <input type="text" class="form-control js-bg-target" placeholder="Tanggal Adendum Akhir"
        id="adendum-akhir" name="tanggal_adendum_akhir">
    @if ($errors->has('adendum-akhir'))
    <div class="invalid-feedback">{{ $errors->first('adendum-akhir') }}</div>
    @endif
</div>

<div class="form-group col-sm-6 col-xl-4">
    <label>Tanggal PHO</label>
    <input type="text" class="form-control js-bg-target" placeholder="Tanggal PHO"
        id="pho" name="tanggal_pho">
    @if ($errors->has('pho'))
    <div class="invalid-feedback">{{ $errors->first('pho') }}</div>
    @endif
</div>

<div class="form-group col-sm-6 col-xl-4">
    <label>Tanggal FHO</label>
    <input type="text" class="form-control js-bg-target" placeholder="Tanggal FHO"
        id="fho" name="tanggal_fho">
    @if ($errors->has('fho'))
    <div class="invalid-feedback">{{ $errors->first('fho') }}</div>
    @endif
</div>

<div class="form-group col-md-6 mb-3">
    {{ Form::label('data_teknis','Data Teknis',['class' => 'required form-label'])}}
    {{ Form::textarea('data_teknis',null,['placeholder' => 'Data Teknis ','class' => 'form-control '.($errors->has('data_teknis') ? 'is-invalid':''),'required'])}}
    @if ($errors->has('data_teknis'))
    <div class="invalid-feedback">{{ $errors->first('data_teknis') }}</div>
    @endif
</div>

@section('js')
<script>
    $(document).ready(function(){

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