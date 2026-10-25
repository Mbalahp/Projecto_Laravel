@extends('layout.main')

@section('title', $event->title)

@section('content')

<div class="col-md-10 offset-md-1">
    <div class="row">
        <div class="col-md-6" id="image-container">
            @if($event->image)
                <img src="/img/events/{{ $event->image }}" alt="{{ $event->title }}" class="img-fluid">
            @endif
        </div>
        <div id="info-container" class="col-md-6">
            <h1>{{ $event->title }}</h1>
            <p class="event-city">
                <ion-icon name="location-outline"></ion-icon> {{ $event->city }}
            </p>
            <p class="events-participants">
                <ion-icon name="people-outline"></ion-icon> {{ count($event->users) }} participantes
            </p>
            <p class="event-owner">
                <ion-icon name="star-outline"></ion-icon> {{ $eventOwner->name ?? 'Sem dono' }}
            </p>

            <form action="/events/join/{{ $event->id }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary" id="event-submit">Confirmar presença</button>
            </form>

            <h3>O evento conta com:</h3>
            <ul id="items-list">
                @foreach($event->items ?? [] as $item)
                    <li><ion-icon name="play-outline"></ion-icon> <span>{{ $item }}</span></li>
                @endforeach
            </ul>

            <div class="col-md-12" id="description-container">
                <h3>Sobre o Evento</h3>
                <p class="event-description">{{ $event->description }}</p>
            </div>
        </div>
    </div>
</div>

@endsection