@extends('layouts.app')
@section('title', 'Editando '.$event->title)
@section('content')
<div class="container">
    <h1>Editando {{ $event->title }}</h1>

    <form action="/events/update/{{ $event->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="image">Imagem do evento</label>
            @if ($event->image)
                <p><img src="/img/events/{{ $event->image }}" alt="{{ $event->title }}" style="max-width: 200px;"></p>
            @endif
            <input type="file" class="form-control-file" id="image" name="image">
        </div>

        <div class="form-group">
            <label for="title">Título</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $event->title) }}">
        </div>

        <div class="form-group">
            <label for="date">Data do evento</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ old('date', optional($event->date)->format('Y-m-d')) }}">
        </div>

        <div class="form-group">
            <label for="city">Cidade</label>
            <input type="text" class="form-control" id="city" name="city" value="{{ old('city', $event->city) }}">
        </div>

        <div class="form-group">
            <label for="private">O evento é privado?</label>
            <select name="private" id="private" class="form-control">
                <option value="0" {{ old('private', $event->private) == 0 ? 'selected' : '' }}>Não</option>
                <option value="1" {{ old('private', $event->private) == 1 ? 'selected' : '' }}>Sim</option>
            </select>
        </div>

        <div class="form-group">
            <label for="description">Descrição</label>
            <textarea name="description" id="description" class="form-control">{{ old('description', $event->description) }}</textarea>
        </div>

        @php($selectedItems = old('items', $event->items ?? []))
        <div class="form-group">
            <label>Adicione itens de infraestrutura</label>
            @foreach (['Cadeiras', 'Brinde', 'Cerveja grátis', 'Open Food'] as $item)
                <div class="form-group">
                    <input type="checkbox" name="items[]" value="{{ $item }}" {{ in_array($item, $selectedItems) ? 'checked' : '' }}>
                    {{ $item }}
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Guardar alterações</button>
    </form>
</div>
@endsection
