@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <ol class="breadcrumb panel-heading">
                        <li><a href="{{route('post.index')}}">Postagens</a></li>
                        <li class="active">Editar</li>
                    </ol>
                    <div class="panel-body">
                        <div>
                            <h2><label for="title">{{ $post->title }}</label></h2>
                        </div>
                        <div>
                            {{ $post->post }}
                        </div>
                    </div>
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
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Comentário</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($comments as $comment)
                        <tr>
                            <td>{{ $comment->user->name }}</td>
                            <td>{{ $comment->comment }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection