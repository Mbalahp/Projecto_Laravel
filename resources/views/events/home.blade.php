@extends('layouts.app')
@section('title', 'home')
@section('content')
<div class="container">

    @if (session('msg'))
        <p class="alert alert-success">{{ session('msg') }}</p>
    @endif

    <h1>Meus eventos</h1>

    @if (count($events) > 0)
        <table class="table">
            <tr>
                <th>Nome</th>
                <th>Cidade</th>
                <th>Participantes</th>
                <th>Acções</th>
            </tr>

            @foreach ($events as $event)
            <tr>
                <td><a href="/events/{{ $event->id }}">{{ $event->title }}</a></td>
                <td>{{ $event->city }}</td>
                <td>{{ count($event->users) }}</td>
                <td>
                    <a href="/events/edit/{{ $event->id }}" class="btn btn-info">Editar</a>

                    <form action="/events/{{ $event->id }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    @else
        <p>Ainda não tens eventos. <a href="/events/create">Criar evento</a></p>
    @endif

    <h1>Eventos em que participo</h1>

    @if (count($eventsAsParticipant) > 0)
        <table class="table">
            <tr>
                <th>Nome</th>
                <th>Cidade</th>
                <th>Acções</th>
            </tr>

            @foreach ($eventsAsParticipant as $event)
            <tr>
                <td><a href="/events/{{ $event->id }}">{{ $event->title }}</a></td>
                <td>{{ $event->city }}</td>
                <td>
                    <form action="/events/leave/{{ $event->id }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-warning">Remover presença</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    @else
        <p>Ainda não confirmaste presença em nenhum evento. <a href="/">Ver eventos</a></p>
    @endif

</div>
@endsection