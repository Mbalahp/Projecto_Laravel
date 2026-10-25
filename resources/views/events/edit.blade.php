@extends('layouts.app')
@section('title', 'Editando'.$event->title)
@section('content')
<div class="container">
    <h1>Meus eventos</h1>
    <h1>Editando {{$event->title}}</h1>
   <form action="/events/update/{{$event ->id}}" method='POST' enctype='multipart/form-data'>
     @csrf
    @method(PUT)
   </form>

    @if (session('msg'))
        <p class="alert alert-success">{{ session('msg') }}</p>
    @endif

    @if (count($events) > 0)
        <table class="table">
            <tr>
                <th>Nome</th>
                <th>Cidade</th>
                <th>Acções</th>
            </tr>

            @foreach ($events as $event)
            <tr>
                <td>{{ $event->title }}</td>
                <td>{{ $event->city }}</td>
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
</div>
@endsection