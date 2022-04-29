<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Resources\EventResource;
use App\Http\Resources\EventCollection;

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
        return new EventCollection($events);
    }

    public function show($id){
        // Recupero il singolo evento utilizzando l'dentificativo (ID)
        $event = Event::find($id);

        if ($event){    // È true solo se l'oggetto non è null
            //Ritorno l'evento interessato all'utente, esistente;
            return new EventResource($event);
            
        } else { //Vuol dire che l'oggetto non è stato trovato
            return $this->failure('The searched event does not exist', 1, 404);
        }
    }
}