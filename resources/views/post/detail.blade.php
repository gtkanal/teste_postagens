@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if($success == 1)
                    <div class="alert alert-success">
                        <strong>Comentário adicionado com sucesso!</strong>
                    </div>
                @elseif($success == 0)
                    <div class="alert alert-danger">
                        <strong>Comentário não adicionado!</strong>
                    </div>
                @endif

                <div class="panel panel-default">
                    <ol class="breadcrumb panel-heading">
                        <li><a href="{{route('post.index')}}">Postagem</a></li>
                        <li class="active">Detalhe</li>
                    </ol>
                    <div class="panel-body">
                        <div class="container" style="padding-right: 7%;">
                            <h2><label for="title">{{ $post->title }}</label></h2>
                            <pre>
                                {{ $post->post }}
                            </pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <ol class="breadcrumb panel-heading">
                        Comentários
                    </ol>
                    <div class="panel-body">
                        <form action="{{ route('comment.save') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" id="post_id" name="post_id" value="{{ $post->id }}">
                            <div class="form-group">
                                <textarea class="form-control" rows="3" name="comment" id="comment"></textarea>
                            </div>
                            <br />
                            <button type="submit" class="btn btn-primary">Comentar</button>
                        </form>
                    </div>
                    <div class="panel-footer">
                        @if(count($comments) > 0)
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID do usuário</th>
                                    <th>ID do comentário</th>
                                    <th>Login</th>
                                    <th>Assinante</th>
                                    <th>Data/Hora</th>
                                    <th>Comentário</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($comments as $comment)
                                    <tr>
                                        <td>{{ $comment->user->id}}</td>
                                        <td>{{ $comment->id }}</td>
                                        <td>{{ $comment->user->email }}</td>
                                        <td>{{ $comment->user->isSubscriber() ? "Assinante" : "Não assinante"}}</td>
                                        <td>{{ $comment->formattedDate() }}</td>
                                        <td>{{ $comment->comment }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection