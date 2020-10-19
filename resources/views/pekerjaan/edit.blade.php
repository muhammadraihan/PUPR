@extends('layouts.page')

@section('title', 'Pekerjaan Edit')

@section('css')
<link rel="stylesheet" media="screen, print" href="{{asset('css/formplugins/select2/select2.bundle.css')}}">
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
                        {{ Form::label('jenis_pekerjaan','Jenis pekerjaan',['class' => 'required form-label'])}}
                        {{ Form::text('jenis_pekerjaan',$pekerjaan->jenis_pekerjaan,['placeholder' => 'Jenis Pekerjaan','class' => 'form-control '.($errors->has('jenis_pekerjaan') ? 'is-invalid':''),'required'])}}
                        @if ($errors->has('jenis_pekerjaan'))
                        <div class="invalid-feedback">{{ $errors->first('jenis_pekerjaan') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-md-4 mb-3">
                        {{ Form::label('satker_id','ID Satuan Kerja',['class' => 'required form-label'])}}
                        {{ Form::text('satker_id',$pekerjaan->satker_id,['placeholder' => 'ID Satuan Kerja','class' => 'form-control '.($errors->has('satker_id') ? 'is-invalid':''),'required'])}}
                        @if ($errors->has('satker_id'))
                        <div class="invalid-feedback">{{ $errors->first('satker_id') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-md-4 mb-3">
                        {{ Form::label('tahun_mulai','Tahun Mulai',['class' => 'required form-label'])}}
                        {{ Form::text('tahun_mulai',$pekerjaan->tahun_mulai,['placeholder' => 'Tahun Mulai','class' => 'form-control '.($errors->has('tahun_mulai') ? 'is-invalid':''),'required'])}}
                        @if ($errors->has('tahun_mulai'))
                        <div class="invalid-feedback">{{ $errors->first('tahun_mulai') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-md-4 mb-3">
                        {{ Form::label('tahun_selesai','Tahun Selesai',['class' => 'required form-label'])}}
                        {{ Form::text('tahun_selesai',$pekerjaan->tahun_selesai,['placeholder' => 'Tahun Selesai','class' => 'form-control '.($errors->has('tahun_selesai') ? 'is-invalid':''),'required'])}}
                        @if ($errors->has('tahun_selesai'))
                        <div class="invalid-feedback">{{ $errors->first('tahun_selesai') }}</div>
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
<script>
    $(document).ready(function(){
        $('.select2').select2();
        
        // Generate a password string
        function randString(){
            var chars = "abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNP123456789";
            var string_length = 8;
            var randomstring = '';
            for (var i = 0; i < string_length; i++) {
                var rnum = Math.floor(Math.random() * chars.length);
                randomstring += chars.substring(rnum, rnum + 1);
            }
            return randomstring;
        }
        
        // Create a new password
        $(".getNewPass").click(function(){
            var field = $('#password').closest('div').find('input[name="password"]');
            field.val(randString(field));
        });

        //Enable input and button change password
        $('#enablePassChange').click(function() {
            if ($(this).is(':checked')) {
                $('#passwordForm').attr('disabled',false); //enable input
                $('#getNewPass').attr('disabled',false); //enable button
            } else {
                    $('#passwordForm').attr('disabled', true); //disable input
                    $('#getNewPass').attr('disabled', true); //disable button
            }
        });
    });
</script>
@endsection