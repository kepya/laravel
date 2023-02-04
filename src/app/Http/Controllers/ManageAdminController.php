<?php

namespace App\Http\Controllers;
use Session;
use Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;

class ManageAdminController extends Controller
{
    public function viewAdministrators(){

        $url = "http://172.17.0.3:4000/admin/auth/getAdmin";
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=',$token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer '.$tokenVal;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: '.$Authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response,true);
        // $informations = $response['result'];
        // foreach ($informations as $key => $value) {
        //     $image = $value['profileImage'];
        //     return Storage::url($image);
        // }
        // return Storage::url() http://127.0.0.1:8000/storage/customers/cathedraledouala.jpg
        return view('admin/administrator',['administrators' => $response]);
    }

    public function addAdministrators(){
        return view('/admin/addAdministrator');
    }

    public function storeAdministrators(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'bail|required',
            'email' => 'bail|required|email',
            'phone' => 'bail|required|digits:9',
            'password' => 'bail|required|regex:/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,15}$/',
            'confirmpassword' => 'bail|required|same:password',
            'image' => 'bail|image|mimes:jpeg,jpg,png|max:2000',
            ],

            $messages = [
                'required' => 'The :attribute is required',
                'phone.digits' => '9 digits needed',
                'confirmpassword.same' => 'Confirm your password',
                'password.regex' => 'Between 8 and 15 characters - Minimum one uppercase letter and one number digit - Minimum one special character !@#$%^&*-',
                'image.mimes' => 'Only jpeg,jpg,png formats accepted',
                'image.max' => 'The :attribute must not sized over 2Mo',
            ]
        );

        if ($validator->fails()) {

            return back()->withErrors($validator)->withInput();

        }else{

            if($request->file()) {
                $photo =  $request->file('image')->getClientOriginalName();
                $photoPath = $request->image->storeAs('/administrators',$photo);
            }else{
                $photo = "";
                $photoPath = "noPath";
            }

            $name = $request->input('name');
            $email = $request->input('email');
            $phone = $request->input('phone');
            $home = $request->input('home');
            $password = md5(sha1($request->input('password')));

            $lat = $request->input('lat');
            $lng = $request->input('lng');


            $url = "http://172.17.0.3:4000/admin/auth/register";
            $alltoken = $_COOKIE['token'];
            $alltokentab = explode(';', $alltoken);
            $token = $alltokentab[0];
            $tokentab = explode('=',$token);
            $tokenVal = $tokentab[1];
            $Authorization = 'Bearer '.$tokenVal;

            if(empty($home)){
                $home = " ";
            }

            if($lat && $lng){
                $data = array(
                    'name' => $name,
                    'phone' => $phone,
                    'password' => $password,
                    'email' => $email,
                    "description" => $home,
                    "longitude" => $lng,
                    "latitude" => $lat,
                    "profileImage" => $photoPath,
                );
            }else {
                $data = array(
                    'name' => $name,
                    'phone' => $phone,
                    'password' => $password,
                    'email' => $email,
                    "description" => $home,
                    "profileImage" => $photoPath,
                );
            }

            $data_json = json_encode($data);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: '.$Authorization));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response  = curl_exec($ch);
            curl_close($ch);

            $response = json_decode($response);

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

    public function findAdmin(){
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=',$token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer '.$tokenVal;
        $users = array();

    	if (isset($_POST['search'])) {
            $name = $_POST['name'];
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://172.17.0.3:4000/admin/auth/getAdmin",
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
            $response = json_decode($response);

            $result = $response -> result;
            $length = count($result);

            $customers = array();

            for($i = 0; $i < $length; $i++) {
                $user = $result[$i];
                $username = $user -> name;
                if(strpos($username, $name) !== false){
                    //echo "Word Found!";
                    array_push($customers, $user);
                } else{
                    //echo "Word Not Found!";
                }
            }

            $array = array(
                "status" => "200",
                "result" => json_decode(json_encode($customers), true),
            );

            //dump($array);
            return view('admin/administrator',['administrators' => $array]);
        }
        else {
            $array = array(
                "status" => "404",
                "result" => null,
            );
            //dump($array);
            return view('admin/administrator',['administrators' => $array]);
        }
    }

    public function paidInvoice(Request $request){
        $id = $request->input('id');

        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=',$token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer '.$tokenVal;

        $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://172.17.0.3:4000/admin/facture/statusPaidFacture/'.$id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'PUT',
                CURLOPT_HTTPHEADER => array('Authorization: '.$Authorization),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $response = json_decode($response, true);
            print_r($response);

            return redirect()->back();
    }

    public function dashboard(){

        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=',$token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer '.$tokenVal;
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://172.17.0.3:4000/client/auth/dashboard',
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

    public function viewCustomers(Request $request){

        if(isset($request->size)){
            $size = $request->size;
            $mode = 'tableBloc';
        }else{
            $size = 10;
            $mode  = 'custBloc';
        }

        $url = "http://172.17.0.3:4000/admin/auth/client/1/".$size;
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=',$token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer '.$tokenVal;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: '.$Authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response,true);

        $url2 = "http://172.17.0.3:4000/client/auth/count";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url2);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: '.$Authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response2 = curl_exec($ch);
        curl_close($ch);
        $response2 = json_decode($response2,true);
        $nbrCl = $response2['result'];
       return view('admin/customer',['response' => $response,'nbrCl' => $nbrCl,'size'=>$size,'mode'=>$mode]);
    }

    public function viewCustomersSort(Request $request){

        $customerRef = $request->customerID;
        $order = $request->order;
        $idCompteur = $request->meter;
        $subs_date = $request->subs_date;
        $size = $request->limit;
        $mode = $request->mode;

        if(empty($subs_date)){
            $subs_date = " ";
        }

        if(empty($idCompteur)){
            $idCompteur = " ";
        }

        if(empty($customerRef)){
            $customerRef = "0";
        }

        $url = "http://172.17.0.3:4000/admin/auth/client/find/1/".$size;
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=',$token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer '.$tokenVal;

        $data = array(
            "date"=> $subs_date,
            "refId"=>  intval($customerRef),
            "counterId"=> $idCompteur,
            "order"=> $order,
            "status"=> "active",
        );

        $data_json = json_encode($data);

        // print_r($data_json);
        // dd($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: '.$Authorization));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response,true);
        $results = $response['result']["docs"];

        $nbrCl = count($results);

        return view('admin/customer',['response' => $response,'nbrCl' => $nbrCl,'size'=>$size,"date"=> $subs_date,"refId"=> $customerRef,"counterId"=> $idCompteur,"order"=> $order,'mode'=>$mode]);

    }

    public function viewCustomersByPage($page,$size,Request $request){

        $mode = $request->mode;

        $url = "http://172.17.0.3:4000/admin/auth/client/".$page."/".$size;
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=',$token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer '.$tokenVal;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: '.$Authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response,true);

        $url2 = "http://172.17.0.3:4000/client/auth/count";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url2);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: '.$Authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response2 = curl_exec($ch);
        curl_close($ch);
        $response2 = json_decode($response2,true);
        $nbrCl = $response2['result'];

        return view('admin/customer',['response' => $response,'nbrCl' => $nbrCl, 'size'=>$size,'mode'=>$mode]);
    }

    public function viewCustomersBySearch(Request $request){
        $page = $request->page;
        $size = $request->limit;
        $mode = $request->mode;

        $url = "http://172.17.0.3:4000/admin/auth/client/".$page."/".$size;
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=',$token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer '.$tokenVal;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: '.$Authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response,true);

        $url2 = "http://172.17.0.3:4000/client/auth/count";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url2);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: '.$Authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response2 = curl_exec($ch);
        curl_close($ch);
        $response2 = json_decode($response2,true);
        $nbrCl = $response2['result'];

        //print_r($response);
        return view('admin/customer',['response' => $response,'nbrCl' => $nbrCl,'size'=>$size,'mode'=>$mode]);
    }

    public function blockedCustomers(Request $request){
        if(isset($request->size)){
            $size = $request->size;
            $mode = 'tableBloc';
        }else{
            $size = 10;
            $mode  = 'custBloc';
        }

        $url = "http://172.17.0.3:4000/admin/auth/client/find/1/".$size;
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=',$token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer '.$tokenVal;

        $data = array(
            "date"=> " ",
            "refId"=> 0,
            "counterId"=> " ",
            "order"=>  " ",
            "status"=> "block",//block
        );
        $data_json = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: '.$Authorization));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response,true);
        $results = $response['result']["docs"];
        $nbrCl = count($results);

        // dd($response);

        return view('admin/blockedCustomer',['response' => $response,'nbrCl' => $nbrCl,'size'=>$size,'mode'=>$mode]);
    }

    public function addCustomers(){

        $url2 = "http://172.17.0.3:4000/client/auth/count";
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=',$token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer '.$tokenVal;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url2);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: '.$Authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response2 = curl_exec($ch);
        curl_close($ch);
        $response2 = json_decode($response2,true);
        $nbrCl = $response2['result'];
        return view('/admin/addCustomer',['nbrCl' => $nbrCl]);
    }

    public function storeCustomers(Request $request){

        $validator = Validator::make($request->all(), [
            //'phone' => 'bail|digits:9',
            // 'password' => 'bail|required|regex:/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,15}$/',
            // 'confirmpassword' => 'bail|required|same:password',
            'image' => 'bail|image|mimes:jpeg,jpg,png|max:2000',
            ],
            $messages = [
                // 'required' => 'The :attribute is required',
                //'phone.digits' => '9 digits needed',
                // 'confirmpassword.same' => 'Confirm your password',
                // 'password.regex' => 'Between 8 and 15 characters - Minimum one uppercase letter and one number digit - Minimum one special character !@#$%^&*-',
                'image.mimes' => 'Only jpeg,jpg,png formats accepted',
                'image.max' => 'The :attribute must not sized over 2Mo',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }else{
            if($request->file()) {
                $photo =  $request->file('image')->getClientOriginalName();
                $photoPath = $request->image->storeAs('/customers',$photo);
            }else{
                $photo = "";
                $photoPath = "noPath";
            }

            $name = $request->input('name');
            $nbrePhone = $request->input('nbrePhone');
            $blocSites = $request->input('blocSites');
            $ref_client = $request->input('ref_client');
            $subs_date = $request->input('subs_date');
            $subs_amount = $request->input('subs_amount');
            $observation = $request->input('observation');

            if(empty($name)){
                $name = 'not';
            }

            if(empty($subs_date) || !isset($subs_date)){
                $subs_date = 'not';
            }

            if(empty($ref_client) || !isset($ref_client)){
                $ref_client = 0;
            }

            if(empty($subs_amount) || !isset($subs_amount)){
                $subs_amount = 0;
            }

            if(empty($observation) || !isset($observation)){
                $observation = "not";
            }

            //tableaux de récupération
            $phones = [];
            $homes = [];
            $meters = [];

            //compteurs de bouclage
            $i=0;
            $j=0;

            for($i;$i<$nbrePhone;$i++){
                $phone = $request->input('phone'.$i);
                array_push($phones,$phone);
            }

            for($j;$j<$blocSites;$j++){
                $home = $request->input('home'.$j);
                $meter = $request->input('meter'.$j);
                array_push($homes,$home);
                array_push($meters,$meter);
            }

            $password = md5(sha1('@KF'.$ref_client));
            // echo 'Path: '.Storage::path($photo);

            $url = "http://172.17.0.3:4000/client/auth/register";
            $alltoken = $_COOKIE['token'];
            $alltokentab = explode(';', $alltoken);
            $token = $alltokentab[0];
            $tokentab = explode('=',$token);
            $tokenVal = $tokentab[1];
            $Authorization = 'Bearer '.$tokenVal;

            $data = array(
                'name' => $name,
                'phone' => $phones,
                'password' => $password,
                "idCompteur" => $meters,
                "description" => $homes,
                'customerReference' => intval($ref_client),
                'subscriptionDate' => $subs_date,
                'subscriptionAmount'=> intval($subs_amount),
                'observation' => $observation,
                "profileImage" => $photoPath,
            );

            // dd($data);
            $data_json = json_encode($data);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: '.$Authorization));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response  = curl_exec($ch);
            curl_close($ch);

            $response = json_decode($response);

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

    public function blockCustomer($id,$status){

        $url = "http://172.17.0.3:4000/admin/manageCompte/client/block/".$id;
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=',$token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer '.$tokenVal;

        if($status == 1){
            $data = array(
             'isBlock' => 'false',
            );
        }else{
            $data = array(
             'isBlock' => 'true',
            );
        }

        $data_json = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: '.$Authorization));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response);

        if ($response->status == 200){

            return redirect()->back();

        }else{
            Session::flash('error', ucfirst($response->error));
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }

    }

    public function editCustomer($id){

        $url = "http://172.17.0.3:4000/client/auth/".$id;
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=',$token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer '.$tokenVal;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: '.$Authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response,true);
        $userdata = $response['result'];

        //print_r($userdata);

        return view('admin/editCustomer',['data' => $userdata]);

    }

    public function viewCustomersBlockedBySearch(Request $request){
        $page = $request->page;
        $size = $request->limit;
        $mode = $request->mode;

        $url = "http://172.17.0.3:4000/admin/auth/client/".$page."/".$size;
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=',$token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer '.$tokenVal;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: '.$Authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response,true);

        //print_r($response);

        return view('admin/blockedCustomer',['response' => $response,'size'=>$size,'mode'=>$mode]);
    }

    public function viewCustomersBlockedByPage($page,$size,Request $request){

        $mode = $request->mode;

        $url = "http://172.17.0.3:4000/admin/auth/client/".$page."/".$size;
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=',$token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer '.$tokenVal;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: '.$Authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response,true);

        return view('admin/blockedCustomer',['response' => $response,'size'=>$size,'mode'=>$mode]);
    }

    public function saveCustomer($id,Request $request){

        $validator = Validator::make($request->all(), [
            'photo' => 'bail|image|mimes:jpeg,jpg,png|max:2000',
            ],

            $messages = [
                'photo.mimes' => 'Only jpeg,jpg,png formats accepted',
                'photo.max' => 'The :attribute must not sized over 2Mo',
            ]
        );

        if ($validator->fails()) {

            return back()->withErrors($validator)->withInput();

        }else{

            if($request->file()) {
                $photo =  $request->file('photo')->getClientOriginalName();
                $photoPath = $request->photo->storeAs('/customers',$photo);
            }else{
                $photo = "";
                $photoPath = $request->input('profileImage');
            }

            $name = $request->input('name');
            $nbrePhone = $request->input('nbrePhone');
            $blocSites = $request->input('blocSites');
            $ref_client = $request->input('ref_client');
            $subs_date = $request->input('subs_date');
            $subs_amount = $request->input('subs_amount');
            $observation = $request->input('observation');


            if(empty($name)){
                $name = 'not';
            }

            if(empty($subs_date) || !isset($subs_date)){
                $subs_date = 'not';
            }

            if(empty($ref_client) || !isset($ref_client)){
                $ref_client = 0;
            }

            if(empty($subs_amount) || !isset($subs_amount)){
                $subs_amount = 0;
            }

            if(empty($observation) || !isset($observation)){
                $observation = "not";
            }

            //tableaux de récupération
            $phones = [];
            $homes = [];
            $meters = [];

            //compteurs de bouclage
            $i=0;
            $j=0;

            for($i;$i<$nbrePhone;$i++){
                $phone = $request->input('phone'.$i);
                array_push($phones,$phone);
            }

            for($j;$j<$blocSites;$j++){
                $home = $request->input('home'.$j);
                $meter = $request->input('meter'.$j);
                array_push($homes,$home);
                array_push($meters,$meter);
            }

            $url = "http://172.17.0.3:4000/admin/manageCompte/client/update/".$id;
            $alltoken = $_COOKIE['token'];
            $alltokentab = explode(';', $alltoken);
            $token = $alltokentab[0];
            $tokentab = explode('=',$token);
            $tokenVal = $tokentab[1];
            $Authorization = 'Bearer '.$tokenVal;

            $data = array(
                'name' => $name,
                'phone' => $phones,
                "idCompteur" => $meters,
                "description" => $homes,
                'customerReference' => $ref_client,
                'subscriptionDate' => $subs_date,
                'subscriptionAmount'=> intval($subs_amount),
                'observation' => $observation,
                "profileImage" => $photoPath,
            );


            $data_json = json_encode($data);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: '.$Authorization));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response  = curl_exec($ch);
            curl_close($ch);

            $response = json_decode($response);
            dd($response);

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

    public function searchCustomer(Request $request){
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=',$token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer '.$tokenVal;
        $users = array();

        $mode = $request->mode;

    	if (isset($_POST['search'])) {

            $name = $_POST['name'];
            $size = $_POST['limit'];

            $url2 = "http://172.17.0.3:4000/client/auth/count";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url2);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: '.$Authorization));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response2 = curl_exec($ch);
            curl_close($ch);
            $response2 = json_decode($response2,true);
            $nbrCl = $response2['result'];

            if(!empty($name)){

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "http://172.17.0.3:4000/admin/auth/getClient",
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
                $response = json_decode($response);
                $result = $response -> result;
                $length = count($result);

                $customers = array();

                for($i = 0; $i < $length; $i++) {
                    $user = $result[$i];
                    $username = $user -> name;
                    if(strpos($username, $name) !== false){
                        //echo "Word Found!";
                        array_push($customers, $user);
                    } else{
                        //echo "Word Not Found!";
                    }
                }
                $array = array(
                    "status" => "200",
                    "result" => json_decode(json_encode($customers), true),
                );
                // dd($array);
                return view('admin/customer',['customerSearch' => $array['result'],'response' => null,'nbrCl' => $nbrCl,'size'=>$size,'mode'=>$mode]);

            }else{

                $url = "http://172.17.0.3:4000/admin/auth/client/1/10";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: '.$Authorization));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);
                $response = json_decode($response,true);

                return view('admin/customer',['response' => $response,'nbrCl' => $nbrCl,'size'=>$size,'mode'=>$mode]);
            }

        }
    }

    public function updateAccount($id, Request $request){
        // dump($id);
        $identifier = $request->input('identifier');
        $recent = $request->input('recentIndex');

        $url = "http://172.17.0.3:4000/admin/facture/invoicePreCreate/".$id;
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=',$token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer '.$tokenVal;

        $data = array(
            'IdCompteur' => $identifier,
            'newIndex' => $recent,
        );

        $data_json = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: '.$Authorization));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response);

        //print_r($response);

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

    public function deleteCustomer($id){

        $url = "http://172.17.0.3:4000/admin/manageCompte/client/delete/".$id;
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=',$token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer '.$tokenVal;

        $data = array(
            'isDelete' => 'true',
        );
        $data_json = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: '.$Authorization));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response);

        if ($response->status == 200){

            return redirect()->back();

        }else{
            Session::flash('error', ucfirst($response->error));
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
    }

    public function location(Request $request){

        $id = $request->input('id');
        $description = $request->input('description');
        $lat = $request->input('lat');
        $lng = $request->input('lng');

        $url = "http://172.17.0.3:4000/login/localisation/".$id;
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=',$token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer '.$tokenVal;

        $data = array(
            "description" => $description,
            "longitude" => $lng,
            "latitude" => $lat
        );
        $data_json = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: '.$Authorization));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response);

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

    public function blockAdmin($id,$status){

        $url = "http://172.17.0.3:4000/admin/manageCompte/admin/block/".$id;
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=',$token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer '.$tokenVal;

        if($status == 1){
            $data = array(
             'isBlock' => 'false',
            );
        }else{
            $data = array(
             'isBlock' => 'true',
            );
        }

        $data_json = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: '.$Authorization));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response);

        if ($response->status == 200){

            return redirect()->back();

        }else{
            Session::flash('error', ucfirst($response->error));
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }

    }

    public function editAdmin($id){

        $url = "http://172.17.0.3:4000/admin/auth/".$id;
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=',$token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer '.$tokenVal;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: '.$Authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response,true);
        $userdata = $response['result'];

        return view('admin/editAdmin',['data' => $userdata]);

    }

    public function saveAdmin($id,Request $request){

        $validator = Validator::make($request->all(), [
            'name' =>  'bail|required',
            'email' => 'bail|required|email',
            'phone' => 'bail|required|digits:9',
            'photo' => 'bail|image|mimes:jpeg,jpg,png|max:2000',
            ],

            $messages = [
                'required' => 'The :attribute is required',
                'phone.digits' => '9 digits needed',
                'photo.mimes' => 'Only jpeg,jpg,png formats accepted',
                'photo.max' => 'The :attribute must not sized over 2Mo',
            ]
        );

        if ($validator->fails()) {

            return back()->withErrors($validator)->withInput();

        }else{

            if($request->file()) {
                $photo =  $request->file('photo')->getClientOriginalName();
                $photoPath = $request->photo->storeAs('/administrators',$photo);
            }else{
                $photo = "";
                $photoPath = $request->input('profileImage');
            }


            $name = $request->input('name');
            $email = $request->input('email');
            $phone = $request->input('phone');
            $home = $request->input('home');
            // $longitude = $request->input('lng');
            // $latitude = $request->input('lat');


            $url = "http://172.17.0.3:4000/admin/manageCompte/admin/update/".$id;
            $alltoken = $_COOKIE['token'];
            $alltokentab = explode(';', $alltoken);
            $token = $alltokentab[0];
            $tokentab = explode('=',$token);
            $tokenVal = $tokentab[1];
            $Authorization = 'Bearer '.$tokenVal;

            if(empty($home)){
                $home = " ";
            }

            $data = array(
                'name' => $name,
                'phone' => $phone,
                'email' => $email,
                "description" => $home,
                "profileImage" => $photoPath,
            );
            $data_json = json_encode($data);

            // print_r($data_json);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: '.$Authorization));
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

    public function deleteAdmin($id){

        $url = "http://172.17.0.3:4000/admin/manageCompte/admin/delete/".$id;
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=',$token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer '.$tokenVal;

        $data = array(
            'isDelete' => 'true',
        );
        $data_json = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: '.$Authorization));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response);

        if ($response->status == 200){

            return redirect()->back();

        }else{
            Session::flash('error', ucfirst($response->error));
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
    }

    public function resetPasswd($id){

        $passwd = md5(sha1('forage@2021'));

        $url = "http://172.17.0.3:4000/login/passwordUserReset/".$id;

        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=',$token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer '.$tokenVal;

        $data = array(
            'newPassword' => $passwd,
        );
        $data = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: '.$Authorization));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response);
        //dump($response);
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
