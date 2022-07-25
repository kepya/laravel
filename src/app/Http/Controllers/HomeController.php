<?php

namespace App\Http\Controllers;
use Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mockery\Undefined;
use Validator;

class HomeController extends Controller
{
    public function sign_in(Request $request){

    	return view('welcome');
    }

    public function login(Request $request){

    	$phone = $request->input('phone');
        $password = md5(sha1($request->input('password')));

	    $url = "http://172.17.0.2:4000/login";
	    $data = array(
	        'phone' => $phone,
	        'password' => $password,
	    );
	    $data_json = json_encode($data);
	    $headers = [];

	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_HEADERFUNCTION,
	        function ($curl, $header) use (&$headers) {
	            $len = strlen($header);
	            $header = explode(':', $header, 2);
	              if (count($header) < 2) // ignore invalid headers
	                    return $len;

	            $headers[strtolower(trim($header[0]))][] = trim($header[1]);
	            return $len;
	        }
	    );
	    $response  = curl_exec($ch);
	    curl_close($ch);

	    $informations = json_decode($response, true);

	    if($informations['status'] == 200){

	        $userdata = $informations['result'];
	        $cookie = $headers['set-cookie'];
	        $tokentab = explode(';', $cookie[0]);
	        $expire = $tokentab[1];
	        $expiretab =  explode('=', $expire);
	        $timeout  = $expiretab[1];

            $pathtab  = explode('=', $tokentab[2]);
            $path  = $pathtab[1];

	        $location = $userdata['localisation'];

	        if($userdata['isDelete'] == 1){

	        	Session::flash('message', 'You account doesn\'t exist anymore');
	        	return redirect()->back()->withInput();

	        }else{

	        	$request->session()->put('id',$userdata['_id']);
			    $request->session()->put('name',$userdata['name']);
			    $request->session()->put('profile',$userdata['profile']);
                $request->session()->put('status',$userdata['status']);

	        	if(array_key_exists('profileImage', $userdata)){
	        	$request->session()->put('photo',$userdata['profileImage']);
	        	}

	        	setcookie('token', $cookie[0],time() + $timeout,null,null,false,true);

		        if($userdata['profile'] != 'user'){
                    if($userdata['status'] == 0){
                        Session::flash('message', 'You have been blocked');
                        return redirect()->back()->withInput();
                    }else{
                        return redirect()->route('adminHome');
                    }
		        }else{
		            return redirect()->route('clientHome');
		        }
			     //    if(!empty($location['longitude']) && !empty($location['latitude'])){

			     //    }else{
			     //    	  $request->session()->put('profile',$userdata['profile']);
						  // setcookie('token', $cookie[0],time() + $timeout,null,null,false,true);
			     //          return redirect()->route('seeClauses');
			     //    }

	        }
	    }else{
	        $err  = $informations['error'];
	        Session::flash('message', $err);
	        return redirect()->back()->withInput();
	    }
	}

	public function forgot_password(){
		return view('forgotPassword');
	}

	public function reset(Request $request){

		$phone = $request->input('phone');

        $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://172.17.0.2:4000/login/userInfo/".$phone,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);

        if ($response->status == 200){

            $name = $response->result;

            $to = 'sipoufoknj@gmail.com';
            $subject = 'Reset Customer\'s Password ';
            $message = 'Dear Administrator </br> Mr/Mrs/M'.$name.' whose the phone number is '.$phone.' wants to change his password. </br>
            His default password is forage@2021 </br> Best Regards.';
            mail($to, $subject, $message);

            Session::flash('message', 'Your request is being taking in charge!');
            Session::flash('alert-class', 'alert-success');
            return redirect()->back();

        }else{
            Session::flash('message', ucfirst($response->error));
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }


	}

    public function adminHome()
	{

		$alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=',$token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer '.$tokenVal;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://172.17.0.2:4000/admin/facture/getByStatus/false',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array('Authorization: '.$Authorization),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, true);

        $invoicesAdvenced = array();

        if(array_key_exists('result', $response)) {
            $invoicesAdvenced = $response['result'];
        }
        // $i=0;
        // $invoicesAdvenced = array();

        $year = date("Y");

        $month = date("m");

        // foreach($response as $key => $value){
        //     if($i >= 1){
        //         $invoicesAdvenced = $value;
        //         //dump($value);
        //     }
        //     $i = $i + 1;
        //     //dump($key);
        // }

        //dump($invoicesAdvenced);
        // if (gettype($invoicesAdvenced) != "array") {
        //     $invoicesAdvenced = array();
        // }

        $client = array();

        foreach($invoicesAdvenced as $invoice){

            $idClient = $invoice['idClient'];
            $url = curl_init();
            curl_setopt_array($url, array(
                CURLOPT_URL => 'http://172.17.0.2:4000/client/auth/'.$idClient,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array('Authorization: '.$Authorization),
            ));

            $response = curl_exec($url);
            $response = json_decode($response);

            $i=0;

            array_push($client,$response->result);
            // foreach($response as $key => $value){
            //     if($i >= 1){
            //         //$client = $value;
            //         array_push($client,$value);
            //         //dump($value);
            //     }
            //     $i = $i + 1;
            //     //dump($key);
            // }

        }

        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_URL => 'http://172.17.0.2:4000/admin/facture/'.$year.'/'.$month.'/0/1',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array('Authorization: '.$Authorization),
        ));

        $re = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($re);
        $resu = $res->result;


        $earnly = 0;
        $invoices_paid = array();
        $invoices_month = array();
        $invoices_year = array();
        $row = 0;
        //array_push($invoices_paid,$value);

        $invoices_month = $res->result;
        foreach ($resu as $tab) {
            if($tab->facturePay){
                array_push($invoices_paid,$tab);
                $earnly = $tab->montantVerse + $earnly;
            }
        }

        $people = array();
        $number0fClient = 0;

        if ($invoices_paid > 0) {
            foreach($invoices_paid as $invoice){

                $idClient = $invoice->idClient;
                $url = curl_init();
                curl_setopt_array($url, array(
                    CURLOPT_URL => 'http://172.17.0.2:4000/client/auth/'.$idClient,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array('Authorization: '.$Authorization),
                ));

                $response = curl_exec($url);
                $response = json_decode($response);

                $i=0;
                array_push($people,$response->result);
            }
        }
        $number0fClient = count($people);

        $url_client = curl_init();
        curl_setopt_array($url_client, array(
            CURLOPT_URL => 'http://172.17.0.2:4000/admin/auth/getClient',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array('Authorization: '.$Authorization),
        ));

        $user = curl_exec($url_client);
        curl_close($url_client);
        $user = json_decode($user, true);

        $user_list = array();
        if(array_key_exists('result', $user)){
            $user_list = $user['result'];
        }

        $numberOfAllClient = count($user_list);
        $pourcent = 0;
        if($numberOfAllClient != 0){
            $pourcent = number_format((($number0fClient / $numberOfAllClient) * 100), 2);
        }
        //dump($invoicesAdvenced);

        // annuel
        $url_annuel = curl_init();
        curl_setopt_array($url_annuel, array(
            CURLOPT_URL => 'http://172.17.0.2:4000/admin/facture/factureByYear/'.$year,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array('Authorization: '.$Authorization),
        ));

        $invoices_annuel = curl_exec($url_annuel);
        $invoices_annuel = json_decode($invoices_annuel);
        $invoices_annuel_list = $invoices_annuel->result;

        // foreach($invoices_annuel as $key => $value){
        //     if($i >= 3){
        //         $invoices_annuel_list = $value;
        //     }
        //     $i = $i + 1;
        // }


        $url1 = "http://172.17.0.2:4000/stock/getAll";
        $data1 = array(
            'page' => 1,
            'limit' => 0,
        );
        $data_json1 = json_encode($data1);

        $ch1 = curl_init();
        curl_setopt($ch1, CURLOPT_URL, $url1);
        curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: '.$Authorization));
        curl_setopt($ch1, CURLOPT_POST, 1);
        curl_setopt($ch1, CURLOPT_POSTFIELDS,$data_json1);
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
        $response1  = curl_exec($ch1);
        curl_close($ch1);
        $response1 = json_decode($response1,true);
        $data1= $response1['result']['docs'];


        return view('admin/dashboard',[
            'invoices' => $invoicesAdvenced,
            'client' => $client,
            'pourcent' => $pourcent,
            'earnly' => $earnly,
            'earnly_invoices' => $invoices_annuel_list,
            'materials' => $data1
        ]);

    }

}
