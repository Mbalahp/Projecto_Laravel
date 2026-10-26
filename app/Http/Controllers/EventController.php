<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Event;
use App\User;

class EventController extends Controller
{
    public function index(){
        $search = request('search');

        if($search){
            $events = Event::where([
                ['title', 'like', '%'.$search.'%']
            ])->get();
        }else{
            $events = Event::all();
        }

        return view('welcome', ['events' => $events, 'search' => $search]);
    }

    public function create(){
        return view('events.create');
    }

    public function produto(){
        $busca = request('search');

        return view('produto', ['busca' => $busca]);
    }

    public function cont(){
        return view('cont');
    }

    public function produtos($id = null){
        return view('produtos', ['id' => $id]);
    }

    public function store(Request $request){
        $event = new Event;

        $event->title = $request->title;
        $event->date = $request->date;
        $event->city = $request->city;
        $event->private = $request->private;
        $event->description = $request->description;
        $event->items = $request->items ?? [];

        // Upload da imagem
        if($request->hasFile('image') && $request->file('image')->isValid()){
            $requestImage = $request->image;
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName().strtotime("now")).".".$extension;
            $requestImage->move(public_path('img/events'), $imageName);
            $event->image = $imageName;
        }

        // Dono do evento
        $user = auth()->user();
        $event->user_id = $user->id;

        $event->save();

        return redirect('/dashboard')->with('msg', 'Evento criado com sucesso!');
    }

    public function show($id){
        $event = Event::findOrFail($id);
        $eventOwner = User::where('id', $event->user_id)->first();

        return view('events.show', ['event' => $event, 'eventOwner' => $eventOwner]);
    }

    public function dashboard(){
    $user = auth()->user();

    $events = $user->events;
    $eventsAsParticipant = $user->eventsAsParticipant;

    return view('events.home', [
        'events' => $events,
        'eventsAsParticipant' => $eventsAsParticipant
    ]);
    }

    public function home(){
        return redirect('/dashboard');
    }

    public function edit($id){
        $event = Event::findOrFail($id);

        return view('events.edit', ['event' => $event]);
    }

    public function update(Request $request, $id){
        $event = Event::findOrFail($id);
        $event->fill($request->only([
            'title',
            'date',
            'city',
            'private',
            'description',
        ]));
        $event->items = $request->input('items', []);

        if($request->hasFile('image') && $request->file('image')->isValid()){
            $requestImage = $request->file('image');
            $imageName = md5($requestImage->getClientOriginalName().strtotime("now")).".".$requestImage->extension();
            $requestImage->move(public_path('img/events'), $imageName);
            $event->image = $imageName;
        }

        $event->save();

        return redirect('/dashboard')->with('msg', 'Evento editado com sucesso!');
    }

    public function destroy($id){
        Event::findOrFail($id)->delete();

        return redirect('/dashboard')->with('msg', 'Evento excluído com sucesso!');
    }

    public function joinEvent($id){
        $user = auth()->user();
        $user->eventsAsParticipant()->syncWithoutDetaching([$id]);

        $event = Event::findOrFail($id);

        return redirect('/dashboard')->with('msg', 'A tua presença está confirmada no evento ' . $event->title);
    }

    public function leaveEvent($id){
        $user = auth()->user();
        $user->eventsAsParticipant()->detach($id);

        $event = Event::findOrFail($id);

        return redirect('/dashboard')->with('msg', 'Removeste a tua presença do evento ' . $event->title);
    }
}