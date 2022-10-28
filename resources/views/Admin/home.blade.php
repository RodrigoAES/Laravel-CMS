@extends('adminlte::page')

@section('plugins.Chartjs', true)

@section('title', 'Painel')

@section('content_header')
    <div class="row">
        <div class="col-md-6">
            <h1>Dashboard</h1>
        </div>
        <div class="col-md-6">
            <form id="form" method="GET">
                <select name="limit" onchange="event.target.parentElement.submit()">
                    <option {{$limit == '-30 days' ? 'selected' : null}} value="-30 days">Últimos 30 dias</option>
                    <option {{$limit == '-60 days' ? 'selected' : null}} value="-60 days">Útimos 60 dias</option>
                    <option {{$limit == '-90 days' ? 'selected' : null}} value="-90 days">Útimos 90 dias</option>
                    <option {{$limit == '-120 days' ? 'selected' : null}} value="-120 days">Útimos 120 dias</option>
                </select>
            </form> 
        </div>
    </div>
    
@endsection
@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$visitsCount}}</h3>
                    <p>Acessos</p>
                </div>
                <div class="icon">
                    <i class="far fa-fw fa-eye"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{$onlineCount}}</h3>
                    <p>Usuários Online</p>
                </div>
                <div class="icon">
                    <i class="far fa-fw fa-heart"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{$pagesCount}}</h3>
                    <p>Páginas</p>
                </div>
                <div class="icon">
                    <i class="far fa-fw fa-sticky-note"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{$userCount}}</h3>
                    <p>Usuários</p>
                </div>
                <div class="icon">
                    <i class="far fa-fw fa-user"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Páginas mais visitadas</h3>
                </div>
                <div class="card-body">
                    <canvas id="pageGraph"></canvas>
                </div>
            </div>
        </div>
    </div>

    @section('js')
        <script>
            window.onload = function() {
                let ctx = document.getElementById('pageGraph').getContext('2d');
                window.pageGraph = new Chart(ctx, {
                    type:'pie',
                    data:{
                        datasets:[{
                            data:{{$pageData}},
                            backgroundColor:'#0000FF'
                        }],
                        labels:{!! $pageLabels !!}
                    },
                    options:{
                        responsive:true,
                        legend:{
                            display:false
                        }
                    }
                });

            }
        </script>
    @endsection
@endsection


