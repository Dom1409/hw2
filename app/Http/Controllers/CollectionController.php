<?php

namespace App\Http\Controllers;
use Session;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


use Illuminate\Routing\Controller as BaseController;

class CollectionController extends BaseController
{
    // funzione che restituisce la view della home,
    //in caso non si ha la sessione dell'utente rimanda alla schermata di login
    public function home (){
        //cotrollo accesso
        if(!Session::get('user_id')){
            return redirect('index');
        }
        return view('home');
    }

    //funzione che restituisce il json dell'api che contiene la lista dei giochi
    //che compaiono nella home o che vengno cercati
    public function do_list($lettera)
    {
        // Controllo accesso
        if (!Session::get('user_id')) {
            return redirect('index');
        }
      
           $url='https://www.cheapshark.com/api/1.0/games?title=' .$lettera;
  
           # Creo il CURL handle per l'URL selezionato
           $ch = curl_init();
           curl_setopt($ch, CURLOPT_URL, $url);
           # Setto che voglio ritornato il valore, anziché un boolean (default)
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
           # Eseguo la richiesta all'URL
           $res = curl_exec($ch);
           //decodifico il json e lo assegno ad una variabile
           $json = json_decode($res, true);
           # Libero le risorse
           curl_close($ch);
           
           //impachetto tutto su un json e lo mando alla richiesta fetch fatta da javascript
           echo json_encode($json); 
    }
        
// funzione che restituisce la view della descrizione del gioco,
    //in caso non si ha la sessione dell'utente rimanda alla schermata di login

    public function description_games (){
        //cotrollo accesso
        if(!Session::get('user_id')){
            return redirect('index');
        }
        return view('description');
    }


    //funzione che restituisce il json dell'api che contiene la descrizione del gioco
    //la descrizione del gioco la ottiene tramite lo steam_id
    public function do_description($steam_id){

        $url='https://store.steampowered.com/api/appdetails?appids=' . $steam_id;

        # Creo il CURL handle per l'URL selezionato
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        # Setto che voglio ritornato il valore, anziché un boolean (default)
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        # Eseguo la richiesta all'URL
        $res = curl_exec($ch);
          //decodifico il json e lo assegno ad una variabile
        $json = json_decode($res, true);
        # Libero le risorse
        curl_close($ch);
        //impachetto tutto su un json e lo mando alla richiesta fetch fatta da javascript
        echo json_encode($json); 

    }

    }


