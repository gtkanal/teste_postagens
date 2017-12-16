@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Bem vindo <strong>{{ $user_name }}</strong></div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif


                    @if(count($messages) >  0)
                        @foreach($messages as $message)
                            <div class="alert alert-warning">
                                {!! $message !!}
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-info">
                            <strong>Você não tem notificações no momento!</strong>
                        </div>
                    @endif


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
