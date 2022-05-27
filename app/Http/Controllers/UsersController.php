<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersController extends Controller {
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
        $users = User::all(); // SELECT * FROM events; (https://laravel.com/docs/9.x/eloquent#collections)

        // Utilizzo una risorsa per ritornare il risultato all'utente (https://laravel.com/docs/9.x/eloquent-resources)
        return new UserCollection($users);
    }

    public function show($id){
        // Recupero il singolo evento utilizzando l'dentificativo (ID)
        $user = User::find($id);

        if ($user){    // È true solo se l'oggetto non è null
            //Ritorno l'evento interessato all'utente, esistente;
            return new UserResource($user);
            
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
            'firstName' => 'required|string|min:3',
            'lastName' => 'required|string|min:3',
            'email' =>  'required|email|unique:users',
            'birthDate' => 'required|date',
            'city' => 'required|string',
            'password'=>'required|string|min:6|max:16',

        ]);

        $user = new User ($request->all());
        //La richiesta di salvataggio viene fatta dal DB tramite Eloquent utilizzando ... .
        $user->authToken = Str::random(60);
        $user->password = Hash::make($request-> password);
        $user->save(); 
    
        return new UserResource($user);
    }

    public function login(Request $request){
       

        $this->validate($request, [
           
            'email' =>  'required|email',
            'password'=>'required|string|min:6|max:16',

        ]);
        //where serve per filtrare i risultati di una query e ritorna una lista di risultati
        $user = User::where ('email', $request->email)->first();

        if ($user){
            if (Hash::check($request->passsword, $user->password)){
                return new UserResource($user);

            }
        }
        return $this-> failure('The entered email or password are wrong!', 2, 422);

    }


}