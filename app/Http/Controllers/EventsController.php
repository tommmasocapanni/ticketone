<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Resources\EventResource;

class EventsController extends Controller {
    public function __construct() {
    }

    public function index() {
        // Lumen è un framework MVC (Model View Controller)
        // Che significa?
        // Utente fa chiamata (e.g. Postman) -> chiamata arriva al router (web.php) ->
        // router invia a controller (qui) ->  controller esegue query utilizzando model (e.g. Event:all())->
        // model restituisce il risultato a controller ($events) ->
        // controller utilizza una view per rispondere a utente (e.g. EventResource::collection($events))
        // Le view vengono generalmente utilizzate per siti web
        // noi stiamo costruendo servizi RESTful e quindi utilizzeremo le Risorse
        // anzichè le view (MA È LA STESSA INDENTICA COSA)

        // Primo passo nel controller, uso il modello per effettuare una query
        // Per ogni tabella del database ci deve essere una classe PHP nei models
        // I nomi delle tabelle devono essere plurale e.g. events
        // I nomi dei modelli devono essere al singolare e.g. Event
        $events = Event::all(); // SELECT * FROM events; (https://laravel.com/docs/9.x/eloquent#collections)

        // Utilizzo una risorsa per ritornare il risultato all'utente (https://laravel.com/docs/9.x/eloquent-resources)
        return EventResource::collection($events);
    }
}