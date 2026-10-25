@extends('layout.main')

@section('title', 'HDC Events')

@section('content')

<div class="col-md-12" id="search-container">
    <h1>Busque um evento</h1>
    <form action="/" method='GET'>
        <input type="text" id="search" class="form-control" placeholder="Procurar">
    </form>
</div>

<div id="events-conteiner" class="col-md-12">
    @if($search)
    <h2>Buscando por :{{$search}} </h2>
    @else
    <h2>Proximos eventos</h2>
    @endif
    <h2>Próximos eventos</h2>
    <p>Veja os eventos dos próximos dias</p>

    <div id="cards-conteiner" class="row">
        @foreach($events as $event)
            <div class="card col-md-3">
                <img src="\img\events\{{$event}} -> image" alt="imagem">
                <div class="card-body">
                    <p class="card-date">{{ date('d/m/y', strtotime($event ->date)) }}</p>
                    <h5 class="card-title">{{ $event->title }}</h5>
                    <p class="card-participants">{{ count($event->users ?? []) }} Participantes</p>
                    <a href="/events/{{$event -> id}}" class="btn btn-primary">Ver Detalhes</a>
                </div>
            </div>
        @endforeach
        @if(count($events) == 0)
        <p>Nao foi Possivel encontrar nenhum evento com {{$search}}! <a href="/">Ver todos</a></p>
        @elseif (count($events) == 0)
        <p>Nao ha eventos disponveis</p>
        @endif
    </div>
</div>

@endsection