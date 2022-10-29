@extends('adminlte::page')

@section('title', 'Nova Página')

@section('content_header')
    <h1>Nova Página</h1>
@endsection

@section('content')
    @if($errors->any())
        <div class="alert alert-danger">
            <h5><i class="icon fas fa-ban"></i>Ocorreu um erro.</h5>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <form class="form-horizontal" method="POST" action="{{route('pages.store')}}">
                @csrf
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label">Título da Página</label>
                        <div class="col-sm-10">
                            <input type="text" name="title" value="{{old('title')}}" class="form-control @error('title')is-invalid @enderror" />
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Corpo</label>
                    <div class="col-sm-10">
                        <textarea name="body" class="form-control bodyfield">{{old('body')}}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <input type="submit" value="Criar" class="btn btn-success"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
     @section('js')
        <script src="https://cdn.tiny.cloud/1/yv4zdqtps7cqgm794u89f14y4b7zp0nbs1un2289ymkiwwux/tinymce/5/tinymce.min.js"></script>
        <script>
            tinymce.init({
                selector:'textarea.bodyfield',
                height:300,
                menubar:false,
                plugins:['link', 'table', 'image', 'autoresize', 'lists'],
                toolbar:'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | table | link image | bulllist numlist',
                content_css:'{{asset('Assets/css/content.css')}}',
                images_upload_url:'{{route('imageupload')}}',
                images_upload_credentials:true,
                convert_urls:false
            });
        </script>
    @endsection
@endsection

