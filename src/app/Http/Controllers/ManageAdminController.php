<?php

namespace App\Http\Controllers;
use Session;
use Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class ManageAdminController extends Controller
{
    public function viewAdministrators(){

        $url = "http://172.17.0.2:4000/admin/auth/getAdmin";
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


            $url = "http://172.17.0.2:4000/admin/auth/register";
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
                CURLOPT_URL => "http://172.17.0.2:4000/admin/auth/getAdmin",
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
                CURLOPT_URL => 'http://172.17.0.2:4000/admin/facture/statusPaidFacture/'.$id,
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

    public function viewCustomers(){

        $url = "http://172.17.0.2:4000/admin/auth/getClient";
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
        // return Storage::url() http://127.0.0.1:8000/storage/cathedraledouala.jpg
        return view('admin/customer',['customers' => $response]);
    }

    public function blockedCustomers(){
        $url = "http://172.17.0.2:4000/admin/auth/getClient";
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
        return view('admin/blockedCustomer',['customers' => $response]);
    }

    public function addCustomers(){
        return view('/admin/addCustomer');
    }

    public function storeCustomers(Request $request){

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
                $photoPath = $request->image->storeAs('/customers',$photo);
            }else{
                $photo = "";
                $photoPath = "noPath";
            }

            $name = $request->input('name');
            $email = $request->input('email');
            $phone = $request->input('phone');
            $home = $request->input('home');
            $lat = $request->input('lat');
            $lng = $request->input('lng');
            $identifier = $request->input('identifier');
            $password = md5(sha1($request->input('password')));
            // echo 'Path: '.Storage::path($photo);

            // return $firstname.' '.$lastname.' '.$birthdate.' '.$email.' '.$phone.' '.$home.' '.$identifier.' '.$password.' '.$photoPath;

            $url = "http://172.17.0.2:4000/client/auth/register";
            $alltoken = $_COOKIE['token'];
            $alltokentab = explode(';', $alltoken);
            $token = $alltokentab[0];
            $tokentab = explode('=',$token);
            $tokenVal = $tokentab[1];
            $Authorization = 'Bearer '.$tokenVal;
            if(empty($home)){
                //dump($home);
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
                    "IdCompteur" => $identifier,
                    "profileImage" => $photoPath,
                );
            }else {
                $data = array(
                    'name' => $name,
                    'phone' => $phone,
                    'password' => $password,
                    'email' => $email,
                    "description" => $home,
                    "IdCompteur" => $identifier,
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

    public function blockCustomer($id,$status){

        $url = "http://172.17.0.2:4000/admin/manageCompte/client/block/".$id;
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

        $url = "http://172.17.0.2:4000/client/auth/".$id;
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

        return view('admin/editCustomer',['data' => $userdata]);

    }

    public function saveCustomer($id,Request $request){

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
                $photoPath = $request->photo->storeAs('/customers',$photo);
            }else{
                $photo = "";
                $photoPath = $request->input('profileImage');
            }


            $name = $request->input('name');
            $email = $request->input('email');
            $phone = $request->input('phone');

            $url = "http://172.17.0.2:4000/admin/manageCompte/client/update/".$id;
            $alltoken = $_COOKIE['token'];
            $alltokentab = explode(';', $alltoken);
            $token = $alltokentab[0];
            $tokentab = explode('=',$token);
            $tokenVal = $tokentab[1];
            $Authorization = 'Bearer '.$tokenVal;

            $data = array(
                'name' => $name,
                'phone' => $phone,
                'email' => $email,
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

    public function searchCustomer(){
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
                CURLOPT_URL => "http://172.17.0.2:4000/admin/auth/getClient",
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
            return view('admin/customer',['customers' => $array]);
        }
        else {
            $array = array(
                "status" => "404",
                "result" => null,
            );
            //dump($array);
            return view('admin/customer',['customers' => $array]);
        }
    }

    public function updateAccount($id, Request $request){
        dump($id);
        $identifier = $request->input('identifier');
        $recent = $request->input('recentIndex');

        $url = "http://172.17.0.2:4000/admin/facture/invoicePreCreate/".$id;
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

        $url = "http://172.17.0.2:4000/admin/manageCompte/client/delete/".$id;
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

        $url = "http://172.17.0.2:4000/login/localisation/".$id;
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

        $url = "http://172.17.0.2:4000/admin/manageCompte/admin/block/".$id;
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

        $url = "http://172.17.0.2:4000/admin/auth/".$id;
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


            $url = "http://172.17.0.2:4000/admin/manageCompte/admin/update/".$id;
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

        $url = "http://172.17.0.2:4000/admin/manageCompte/admin/delete/".$id;
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

        $url = "http://172.17.0.2:4000/login/passwordUserReset/".$id;

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
