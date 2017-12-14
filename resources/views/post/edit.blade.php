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
	                <form action="{{ route('post.update', $post->id) }}" method="POST" enctype="multipart/form-data">
	                	{{ csrf_field() }}
						<div class="form-group">
						  	<label for="titulo">Título</label>
						    <input type="text" class="form-control" name="title" id="title" placeholder="Título" value="{{ $post->title }}">
						</div>
                        <div class="form-group">
                            <label for="description">Postagem</label>
                            <textarea class="form-control" rows="3" name="post" id="post">{{ $post->post }}</textarea>
                        </div>
						<br />
						<button type="submit" class="btn btn-primary">Salvar</button>
	                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
