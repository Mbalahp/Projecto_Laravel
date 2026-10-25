<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $casts = [
        'items' => 'array'
    ];

    protected $dates = ['date'];

    protected $guarded = [];

    // Dono do evento
    public function user(){
        return $this->belongsTo('App\User');
    }

    // Participantes do evento
    public function users(){
        return $this->belongsToMany('App\User');
    }
}