<?php

namespace App\Http\Controllers;

use Session;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use PDF;

class ManageClientController extends Controller
{
    // Dashboard of user
    public function dashboard(){

        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=',$token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer '.$tokenVal;
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://172.17.0.2:4000/client/auth/dashboard',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization:'.$Authorization,
        ),
        ));

        $response = curl_exec($curl);
        $informations = json_decode($response, true);

        curl_close($curl);

        return view('Client/dashboard',['informations' => $informations, 'res' => $response]);
    }

    // setting of user
    public function setting(){

        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=',$token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer '.$tokenVal;
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://172.17.0.2:4000/client/auth/get/getClientByToken',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization:'.$Authorization,
        ),
        ));

        $response = curl_exec($curl);
        $informations = json_decode($response, true);

        curl_close($curl);

        return view('Client/user',['data' => $informations['result']]);
    }

    // setting of user
    public function invoicePaid(){

        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=',$token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer '.$tokenVal;
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://172.17.0.2:4000/client/facture/getFactureWithMonth/true',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization:'.$Authorization,
        ),
        ));

        $response = curl_exec($curl);
        $informations = json_decode($response, true);

        curl_close($curl);

        return view('Client/paidInvoices',['data' => $informations]);
    }

    // budget of user
    public function budget(){

        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=',$token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer '.$tokenVal;
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://172.17.0.2:4000/client/facture/factureClientWithDate',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization:'.$Authorization,
        ),
        ));

        $response = curl_exec($curl);
        $informations = json_decode($response, true);
        $response = json_encode($informations['result']);
        curl_close($curl);

        return view('Client/budget',['data' => $response]);
    }

    public function budget_detail(){

        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=',$token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer '.$tokenVal;
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://172.17.0.2:4000/client/facture',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization:'.$Authorization,
        ),
        ));

        $response = curl_exec($curl);
        $informations = json_decode($response, true);
        curl_close($curl);

        return view('Client/budget_detail',['data' => $informations]);
    }

    public function invoiceUnpaid(){

        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=',$token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer '.$tokenVal;
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://172.17.0.2:4000/client/facture/getFactureWithMonth/false',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization:'.$Authorization,
        ),
        ));

        $response = curl_exec($curl);
        $informations = json_decode($response, true);

        curl_close($curl);

        return view('Client/unpaidInvoices',['data' => $informations]);
    }


    public function update(Request $request){

        $validator = Validator::make($request->all(), [
            'name' =>  'bail|required',
            'email' => 'bail|required|email',
            'phone' => 'bail|required|digits:9',
            'photo' => 'bail|image|mimes:jpeg,jpg,png|max:5000',
            ],

            $messages = [
                'required' => 'The :attribute is required',
                'phone.digits' => '9 digits needed',
                'photo.mimes' => 'Only jpeg,jpg,png formats accepted',
                'photo.max' => 'The :attribute must not sized over 5Mo',
            ]
        );

        if ($validator->fails()) {

            return back()->withErrors($validator)->withInput(['tab'=>'update_form']);

        }else{

            if($request->file()) {
                $photo =  $request->file('photo')->getClientOriginalName();
                $photoPath = $request->photo->storeAs('/customers',$photo);
            }else{
                $photo = "";
                $photoPath = Session::get('photo');
            }


            $name = $request->input('name');
            $birthdate = $request->input('birthdate');
            $email = $request->input('email');
            $phone = $request->input('phone');
            $identifier = $request->input('identifier');


            $url = "http://172.17.0.2:4000/client/auth/update";
            $alltoken = $_COOKIE['token'];
            $alltokentab = explode(';', $alltoken);
            $token = $alltokentab[0];
            $tokentab = explode('=',$token);
            $tokenVal = $tokentab[1];
            $Authorization = 'Bearer '.$tokenVal;


            $data = array(
                'name' => $name,
                'birthday' => $birthdate,
                'phone' => $phone,
                'email' => $email,
                "profileImage" => $photoPath,
            );
            $data_json = json_encode($data);

            //print_r($data_json);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: '.$Authorization));
             //curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response  = curl_exec($ch);
            curl_close($ch);

            $response = json_decode($response);

            // print_r($response);

            if ($response->status == 200){
                $request->session()->put('name',$name);
                $request->session()->put('photo',$photoPath);
                Session::flash('message', 'Action Successfully done!');
                Session::flash('alert-class', 'alert-success');
                return back()->withInput(['tab'=>'update_form']);

            }else{
                Session::flash('message', ucfirst($response->error));
                Session::flash('alert-class', 'alert-danger');
                return back()->withInput(['tab'=>'update_form']);
            }
        }

    }

    public function changePassword(Request $request){

        $validator = Validator::make($request->all(), [
            'newpassword' => 'bail|required|regex:/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,15}$/',
            'confirmpassword' => 'bail|required|same:newpassword',
            ],

            $messages = [
                'confirmpassword.same' => 'Confirm your password',
                'newpassword.regex' => 'Between 8 and 15 characters - Minimum one uppercase letter and one number digit - Minimum one special character !@#$%^&*-',
            ]
        );


        if ($validator->fails()) {

            return back()->withErrors($validator)->withInput(['tab'=>'password_form']);

        }else{

            $newpassword = md5(sha1($request->input('newpassword')));
            $oldpassword = md5(sha1($request->input('oldpassword')));

            $url = "http://172.17.0.2:4000/client/auth/updatePassword";
            $alltoken = $_COOKIE['token'];
            $alltokentab = explode(';', $alltoken);
            $token = $alltokentab[0];
            $tokentab = explode('=',$token);
            $tokenVal = $tokentab[1];
            $Authorization = 'Bearer '.$tokenVal;

            $data = array(
                'oldPassword' => $oldpassword,
                'newPassword' => $newpassword,
            );
            $data_json = json_encode($data);

            // print_r($data_json);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: '.$Authorization));
             //curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response  = curl_exec($ch);
            curl_close($ch);

            $response = json_decode($response);

            // print_r($response);

            if ($response->status == 200){
                Session::flash('message', 'Action Successfully done!');
                Session::flash('alert-class', 'alert-success');
                return redirect()->back()->withInput(['tab'=>'password_form']);

            }else{
                Session::flash('message', ucfirst($response->error));
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back()->withInput(['tab'=>'password_form']);
            }
        }
    }

    public function print($invoice_id){
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=',$token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer '.$tokenVal;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://172.17.0.2:4000/admin/facture/one/'.$invoice_id,
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
        $invoice = json_decode($response, true);

        // print_r($invoice['result']);

        $curl2 = curl_init();
        curl_setopt_array($curl2, array(
            CURLOPT_URL => 'http://172.17.0.2:4000/client/auth/'.$invoice['result']['idClient'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array('Authorization: '.$Authorization),
        ));
        $response2 = curl_exec($curl2);
        curl_close($curl2);
        $client = json_decode($response2, true);

        $curl3 = curl_init();
        curl_setopt_array($curl3, array(
            CURLOPT_URL => 'http://172.17.0.2:4000/admin/auth/'.$invoice['result']['idAdmin'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array('Authorization: '.$Authorization),
        ));
        $response3 = curl_exec($curl3);
        curl_close($curl3);
        $admin = json_decode($response3, true);

        echo($admin['result']['phone']);

        $pdf = PDF::loadView('facturePdf/generator', ['invoice' => $invoice, 'client' => $client, 'admin' => $admin]);

        return $pdf->download('facture-'. $client['result']['name'].'-'.date('F').'.pdf');
        // return view('facturePdf/generator',['invoice' => $invoice, 'client' => $client, 'admin' => $admin]);
    }

    public function overview($invoice_id){
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=',$token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer '.$tokenVal;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://172.17.0.2:4000/admin/facture/one/'.$invoice_id,
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
        $invoice = json_decode($response, true);

        $curl2 = curl_init();
        curl_setopt_array($curl2, array(
            CURLOPT_URL => 'http://172.17.0.2:4000/client/auth/'.$invoice['result']['idClient'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array('Authorization: '.$Authorization),
        ));
        $response2 = curl_exec($curl2);
        curl_close($curl2);
        $client = json_decode($response2, true);

        // print_r($client);
        $curl3 = curl_init();
        curl_setopt_array($curl3, array(
            CURLOPT_URL => 'http://172.17.0.2:4000/admin/auth/'.$invoice['result']['idAdmin'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array('Authorization: '.$Authorization),
        ));
        $response3 = curl_exec($curl3);
        curl_close($curl3);
        $admin = json_decode($response3, true);
        // echo($admin['result']['phone']);

        // $pdf = PDF::loadView('facturePdf/generator', ['invoice' => $invoice, 'client' => $client, 'admin' => $admin]);

        // return $pdf->download('facture-'. $client['result']['name'].'-'.date('F').'.pdf');
        return view('Client/getFacture',['invoice' => $invoice, 'client' => $client, 'admin' => $admin]);
    }

    public function paidFac(Request $request){

            $modalId = $request->input('modalId');
            $montant = $request->input('montant');


            $url = "http://172.17.0.2:4000/client/facture/paid/".$modalId;
            echo $url;
            $alltoken = $_COOKIE['token'];
            $alltokentab = explode(';', $alltoken);
            $token = $alltokentab[0];
            $tokentab = explode('=',$token);
            $tokenVal = $tokentab[1];
            $Authorization = 'Bearer '.$tokenVal;


            $data = array(
                'montant' => $montant,
            );
            $data_json = json_encode($data);

            //print_r($data_json);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: '.$Authorization));
             //curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response  = curl_exec($ch);
            curl_close($ch);

            $response = json_decode($response);

            // print_r($response);

            if ($response->status == 200){
                Session::flash('message', 'Action Successfully done!');
                Session::flash('alert-class', 'alert-success');
                return redirect()->back();

            }else{
                Session::flash('message', ucfirst($response->error));
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }

    }





}
