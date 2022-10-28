@extends('adminlte::page')

@section('title', 'Páginas')

@section('content_header')
    <h1>
        Minhas Páginas
        <a href="{{route('pages.create')}}" class="btn btn-sm btn-success new-user">Nova Página</a>
    </h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="50">ID</th>
                        <th>Título</th>
                        <th width="220">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pages as $page)
                        <tr>
                            <td>{{$page->id}}</td>
                            <td>{{$page->title}}</td>
                            <td>
                            <a href="" target="_blank" class="btn btn-sm btn-success">Vizualizar</a>
                            <a href="{{route('pages.edit', ['page'=>$page->id])}}" class="btn btn-sm btn-info">Editar</a> 
                            <form class="d-inline" method="POST" action="{{route('pages.destroy', ['page'=>$page->id])}}">
                                @method('DELETE')
                                @csrf
                                <button  class="btn btn-sm btn-danger">Excluir</button>
                            </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{$pages->links()}}
@endsection

@section('css')
    <style type="text/css">
        h1{
            display:flex;
            justify-content:space-between;
        }
        h1 a {
            margin-right:122px
        }
    </style>
@endsection