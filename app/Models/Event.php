<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model {
    //Fillable è una proprieta presente in tutti i modelli 
    // e ci permette di definire i permitted params.
    // Il bulk create/update funzionerà solo se questo oggetto
    // conterà tutti i dati necesssarinper la creazione di una riga sul DB;
    protected $fillable = [
        'name', 
        'description', 
        'date', 
        'cover_url', 
        'price', 
        'address', 
        'lat', 
        'lng', 
        'views_count', 
        'comments_count', 
        'likes_count'];
}