<?php

namespace App\Http\Controllers;


use App\Models\Event;
use App\Http\Resources\EventResource;
use App\Http\Resources\EventCollection;
use Illuminate\Http\Request;

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

    // Tutte le chiamate POST E PUT
    // utilizzano la request per recuperare i dati
    // presenti nel body della richiesta.

    public function create(Request $request){
        // var_dump($request->all());die;

        //Il validate controlla che i required ci siano 
        // sennò l'evento non viene creato.
        //Gestisce gli errori dell'utente.


        $this->validate($request, [
            'name' => 'required|string|min:3',
            'description' => 'required|string',
            'date' => 'required|date',
            'cover_url' => 'required|url',
            'price' => 'required|numeric',
            'address' => 'required|string',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'views_count' => 'required|integer',
            'comments_count' => 'required|integer',
            'likes_count'=> 'required|integer'
        ]);

        $event = new Event ($request->all());
        //La richiesta di salvataggio viene fatta dal DB tramite Eloquent utilizzando ... .
        $event->save(); 

        //Questi sono due modi per fare la stesssa cosa.
        //Ovvero creare un evento passandoi parametri
        // presenti nel body della richiesta
        
        // $event -> name = $request->name;
        // $event -> date = $request->date;
        // $event -> cover_url = $request->cover_url;
        // $event -> price = $request->price;
        // $event -> lat = $request->lat;
        // $event -> lon = $request->lon;
        // $event -> views_count = $request->views_count;
        // $event -> comments_count = $request->comments_count;
        // $event -> likes_count = $request->likes_count;
        // $event -> created_at = $request->created_at;
        // $event -> updated_at = $request->updated_at;
        
    
        return new EventResource($event);
    }


    public function update(Request $request, $id){

        $this->validate($request, [
            'name' => 'string|min:3',
            'description' => 'string',
            'date' => 'date',
            'cover_url' => 'url',
            'price' => 'numeric',
            'address' => 'string',
            'lat' => 'numeric',
            'lng' => 'numeric',
            'views_count' => 'integer',
            'comments_count' => 'integer',
            'likes_count'=> 'integer'
        ]);
        
        $event = Event::find($id);
        if (!$event){  
            return $this->failure('The searched event does not exist', 1, 404);
            
        } 
        $event->update($request->all()); 

        return new EventResource($event);
    }

}