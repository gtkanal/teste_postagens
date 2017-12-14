@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <ol class="breadcrumb panel-heading">
                    <li class="active">Postagens</li>
                </ol>
                <div class="panel-body">
                    <form class="form-inline" action="{{ route('post.search') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="put">
                        <div class="form-group" style="float: right;">
                            <p><a href="{{route('post.add')}}" class="btn btn-info btn-sm"><i class="glyphicon glyphicon-plus"></i> Adicionar</a></p>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Título">
                        </div>
                        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i> Buscar</button>
                    </form>
                    <br />
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($posts))
                                @foreach($posts as $post)
                                    <tr>
                                        <td> <a href="{{route('post.detail', $post->id)}}" >{{ $post->title }}</a></td>
                                        <td width="155" class="text-center">
                                            <a href="{{route('post.edit', $post->id)}}" class="btn btn-default">Editar</a>
                                            <a href="{{route('post.delete', $post->id)}}" class="btn btn-danger">Excluir</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    @if(!isset($search))
                    <div align="center">
                        {!! $posts->links() !!}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection