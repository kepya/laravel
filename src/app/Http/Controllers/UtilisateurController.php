<?php

namespace App\Http\Controllers;
use Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use League\CommonMark\Inline\Element\Code;
use PhpParser\Node\Stmt\Echo_;
use Ramsey\Uuid\Type\Integer;


class UtilisateurController extends Controller
{
    //finish to paid invoice
    public function advanceInvoice()
    {
        $idFacture = $_POST['idFacture'];
        
        // je definie l'url de connexion.
        $url = "http://172.17.0.2:4000/admin/facture/statusPaidFacture/"+$idFacture;
        // je definie la donnée de ma facture.
        $facture = array(
            'status' => true
        );
        
        // j'encode cette donnée là'.
        $data_json = json_encode($facture);

        // Initialisez une session CURL.
        $ch = curl_init();

        // Je definie les propriétés de connexion
        //CURLOPT_URL : permet de definir l'url
        curl_setopt($ch, CURLOPT_URL, $url);

        /*
            on renseignement l'option "CURLOPT_HEADER" avec "true" comme valeur
            pour inclure l'en-tête dans la réponse
        */
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        //CURLOPT_POST : si la requête doit utiliser le protocole POST pour sa résolution (boolean)
        curl_setopt($ch, CURLOPT_PUT, 1);
        
        //j'insere la donnée à etre envoyé
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        //enfin d'avoir un retour sur l'etat de la requette on a CURLOPT_RETURNTRANSFER = true
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        //($response);
        curl_close($ch);
    }

    public function allInvoiceWhichHaveNotPaid()
    {
        // je definie l'url de connexion.
        $url = "http://172.17.0.2:4000/admin​/facture​/getFactureAdvance"; 

        // Initialisez une session CURL.
        $ch = curl_init();  
        
        // Récupérer le contenu de la page
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        
        //Saisir l'URL et la transmettre à la variable.
        curl_setopt($ch, CURLOPT_URL, $url); 

        //Exécutez la requête 
        $invoices = curl_exec($ch); 

        //Afficher le résultat
        // echo $invoices; 
        
        //Je ferme la connexion et je libere les ressources
        curl_close($ch);
        
        $response = json_decode($invoices);
        //var_dump($response);

        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // echo 'HTTP code: ' . $httpcode;

        //return view('admin/dashboard',['invoices' => $invoices]);
    }

    public function delete()
    {
        $url = "http://127.0.0.1/api/1";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        //var_dump($response);
        curl_close($ch);
    }

    
}
