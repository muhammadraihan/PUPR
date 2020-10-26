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
                <h2>Add New <span class="fw-300"><i>Kontrak</i></span></h2>
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
                    {!! Form::open(['route' => 'kontrak.store','method' => 'POST','class' =>
                    'needs-validation','novalidate']) !!}

                    <div class="form-group col-md-6 mb-3">
                        {!! Form::label('Pekerjaan', 'Pilih Pekerjaan', ['class' => 'required form-label']) !!}
                        <select class="pekerjaan select2 form-control" name="pekerjaan_id" >
                            <option value="">Pilih Pekerjaan</option>
                            @foreach($pekerjaan as $p)
                                <option value="{{$p->uuid}}">{{$p->title}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('pekerjaan'))
                        <div class="help-block text-danger">{{ $errors->first('pekerjaan') }}</div>
                        @endif
                    </div>


                    <div id="row">

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

        $('.select2').on('change',function (e){
            var id = $(this).val();
            $.ajax({
                url: "{{route('getForm')}}",
                type: 'GET',
                data: {param: id},
                success: function (data) {
                    $('#row').html(data);
                }
            });
        });

    });
</script>
@endsection