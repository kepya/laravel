<?php

namespace App\Http\Controllers;

use Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use PDF;
use Storage;
use App;
// use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{

    public function adminConsumption()
    {
        return view('admin/consumption');
    }

    public function update_aduan(Request $request)
    {
        $message = null;
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://172.17.0.2:4000/admin/facture/getStaticInformation',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, true);
        print_r($response);
        if (array_key_exists('result', $response)) {
            if (!empty($response['result'])) {
                $newIndex = $_POST['newIndex'];
                $dateReleveNewIndex = $_POST['date'];
                $idClient = $_POST['userId'];
                $oldIndex = $_POST['oldIndex'];
                // echo $idClient;

                // je definie l'url de connexion.
                $url = "http://172.17.0.2:4000/admin/facture/" . $idClient;
                // je definie la donnée de ma facture.
                $facture = array(
                    'newIndex' => $newIndex,
                    'dateReleveNewIndex' => $dateReleveNewIndex,
                    'oldIndex' => $oldIndex,
                );
                // dump($facture);

                $data_json = json_encode($facture);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response  = curl_exec($ch);
                //var_dump($response);
                curl_close($ch);

                $response = json_decode($response);

                if ($response->status == 200) {
                    Session::flash('message', 'Action Successfully done!');
                    Session::flash('alert-class', 'alert-success');
                    return redirect()->back();
                } else {
                    Session::flash('message', ucfirst($response->error));
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->back();
                }
            } else {
                $messageErr = 'Please entrer the static informations in ';
                Session::flash('messageErr', $messageErr);
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
        }

        // echo 'chien';
        return view('admin/consumption');
    }

    public function adminSearchInvoiceByCustumer()
    {
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;
        $users = array();
        $date = session()->get('dateOfInvoices');

        if (isset($_POST['search'])) {
            $name = $_POST['name'];
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://172.17.0.2:4000/admin/facture/doInvoiceWithDate/' . $date,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $response = json_decode($response);

            if ($response != null) {
                $status = $response->status;

                if ($status == 200) {
                    $result = $response->result;
                    if ($name != null && $name != '') {
                        foreach($result as $key=>$data) {
                            $username = $data->name;
                            if (strcasecmp($name, $username)) {
                                unset($result[$key]);
                            }
                        }

                        return view('admin/facture', ['users' => $result, 'date' => $date]);
                    } else {
                        return view('admin/facture', ['users' => $result, 'date' => $date]);
                    }
                } else {
                    $users = null;
                    return view('admin/facture', ['users' => $users, 'date' => $date]);
                }
            }
        }

        return view('admin/facture', ['users' => $users, 'date' => $date]);
    }

    public function adminStatus()
    {
        $url = "http://172.17.0.2:4000/admin/facture/" . date("Y") . "/" . date("m") . "/100/1";
        // $url = "http://172.17.0.2:4000/facture/".date("m")."/".date("Y")."/100/1";
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $invoice = json_decode($response, true);
        // echo $url;
        // print_r($response);
        $client = array();
        $lengthPaid = count($invoice['result']);
        for ($i = 0; $i < $lengthPaid; $i++) {
            $curl2 = curl_init();
            curl_setopt_array($curl2, array(
                CURLOPT_URL => 'http://172.17.0.2:4000/client/auth/' . $invoice['result'][$i]['idClient'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
            ));
            $response2 = curl_exec($curl2);
            curl_close($curl2);
            $result = json_decode($response2, true);
            array_push($client, $result['result']);
        }
        return view('admin/status', ['invoice' => $invoice, 'client' => $client]);
    }

    public function manageProducts()
    {

        $url = "http://172.17.0.2:4000/stock/type";
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);

        $result = $response['result'];

        return view('admin/manageProducts', ['data' => $result]);
    }

    public function productsType()
    {

        $url = "http://172.17.0.2:4000/stock/type";
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);

        return view('admin/productsType', ['data' => $response]);
    }

    public function createType(Request $request)
    {

        $type = $request->input('type');

        $url = "http://172.17.0.2:4000/stock/type";

        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        $data = array(
            'name' => $type,
        );
        $data_json = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response);

        if ($data->status == 200) {
            Session::flash('message', 'Action Successfully done!');
            Session::flash('alert-class', 'alert-success');
            return redirect()->back();
        } else {
            Session::flash('message', ucfirst($data->error));
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
    }

    public function storeProduct(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' =>  'bail|required',
                'quantity' => 'bail|required',
                'unitprice' => 'bail|required',
                'description' => 'bail|required',
                'image' => 'bail|required|image|mimes:jpeg,jpg,png|max:2000',
            ],

            $messages = [
                'required' => 'The :attribute is required',
                'image.mimes' => 'Only jpeg,jpg,png formats accepted',
                'image.max' => 'The :attribute must not sized over 2Mo',
            ],
        );

        if ($validator->fails()) {

            return back()->withErrors($validator)->withInput();
        } else {

            $name = $request->input('name');
            $type = $request->input('type');
            $quantity = $request->input('quantity');
            $unitprice = $request->input('unitprice');
            $description = $request->input('description');

            $photo =  $request->file('image')->getClientOriginalName();
            $photoPath = $request->image->storeAs('/products', $photo);

            $url = "http://172.17.0.2:4000/stock/";
            $alltoken = $_COOKIE['token'];
            $alltokentab = explode(';', $alltoken);
            $token = $alltokentab[0];
            $tokentab = explode('=', $token);
            $tokenVal = $tokentab[1];
            $Authorization = 'Bearer ' . $tokenVal;

            $data = array(
                'name' => $name,
                'type' => $type,
                'prixUnit' => $unitprice,
                'quantity' => $quantity,
                "description" => $description,
                "picture" => $photoPath,
            );
            $data_json = json_encode($data);

            // print_r($data_json);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response  = curl_exec($ch);
            curl_close($ch);

            $response = json_decode($response);

            // print_r($response);

            if ($response->status == 200) {
                Session::flash('message', 'Action Successfully done!');
                Session::flash('alert-class', 'alert-success');
                return redirect()->back();
            } else {
                Session::flash('message', ucfirst($response->error));
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
        }
    }

    public function adminRemove()
    {

        $url = "http://172.17.0.2:4000/stock/getAll";

        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        $data = array(
            'page' => 1,
            'limit' => 0,
        );
        $data_json = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response, true);

        $data = $response['result']['docs'];

        return view('admin/remove', ['materials' => $data]);
    }

    public function removeProduct(Request $request)
    {

        $product = $request->input('name');
        $quantity = $request->input('quantity');

        $url = "http://172.17.0.2:4000/stock/type";
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        $data = array(
            'name' => $product,
            'quantity' => $quantity,
        );

        $data_json = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response);

        if ($response->status == 200) {
            Session::flash('message', ucfirst($response->error));
            Session::flash('alert-class', 'alert-success');
            return redirect()->back();
        } else {
            Session::flash('message', ucfirst($response->error));
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
    }

    public function deleteType($id)
    {

        $url = "http://172.17.0.2:4000/stock/type/" . $id;
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response);

        // print_r($response);

        if ($response->status == 200) {
            Session::flash('message', 'Action Successfully done!');
            Session::flash('alert-class', 'alert-success');
            return redirect()->back();
        } else {
            Session::flash('message', ucfirst($response->error));
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
    }

    public function viewTypeStock(Request $request)
    {

        $type = $request->input('type');

        if ($type == "all") {

            $id = 1;
            return redirect()->route('viewStock', [$id]);
        } else {

            $alltoken = $_COOKIE['token'];
            $alltokentab = explode(';', $alltoken);
            $token = $alltokentab[0];
            $tokentab = explode('=', $token);
            $tokenVal = $tokentab[1];
            $Authorization = 'Bearer ' . $tokenVal;

            $url = "http://172.17.0.2:4000/stock/type";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($response, true);
            $types = $response['result'];


            $url1 = "http://172.17.0.2:4000/stock/getByType";
            $data1 = array(
                'page' => 1,
                'limit' => 0,
                'type' => $type,
            );
            $data_json1 = json_encode($data1);

            $ch1 = curl_init();
            curl_setopt($ch1, CURLOPT_URL, $url1);
            curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
            curl_setopt($ch1, CURLOPT_POST, 1);
            curl_setopt($ch1, CURLOPT_POSTFIELDS, $data_json1);
            curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
            $response1  = curl_exec($ch1);
            curl_close($ch1);

            $data1 = json_decode($response1, true);

            return view('admin/stock', ['typeMaterials' => $data1, 'types' => $types, 'nametype' => $type]);
        }
    }

    public function viewStock($id)
    {

        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        $url = "http://172.17.0.2:4000/stock/type";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);
        $types = $response['result'];


        $url1 = "http://172.17.0.2:4000/stock/getAll";
        $data = array(
            'page' => $id,
            'limit' => 5,
        );
        $data_json = json_encode($data);
        $ch1 = curl_init();
        curl_setopt($ch1, CURLOPT_URL, $url1);
        curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch1, CURLOPT_POST, 1);
        curl_setopt($ch1, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
        $response1  = curl_exec($ch1);
        curl_close($ch1);

        $data = json_decode($response1, true);

        return view('admin/stock', ['materials' => $data, 'types' => $types]);
    }

    public function updateProduct(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' =>  'bail|required',
                'quantity' => 'bail|required',
                'unitprice' => 'bail|required',
                'description' => 'bail|required',
                'image' => 'bail|image|mimes:jpeg,jpg,png|max:2000',
            ],

            $messages = [
                'required' => 'The :attribute is required',
                'image.mimes' => 'Only jpeg,jpg,png formats accepted',
                'image.max' => 'The :attribute must not sized over 2Mo',
            ],
        );

        if ($validator->fails()) {

            return back()->withErrors($validator)->withInput();
        } else {

            if ($request->file()) {
                $photo =  $request->file('image')->getClientOriginalName();
                $photoPath = $request->image->storeAs('/products', $photo);
            } else {
                $photo = "";
                $photoPath = $request->input('oldimage');
            }

            $name = $request->input('name');
            $type = $request->input('type');
            $quantity = $request->input('quantity');
            $unitprice = $request->input('unitprice');
            $description = $request->input('description');

            $id = $request->input('id');

            $url = "http://172.17.0.2:4000/stock/" . $id;
            $alltoken = $_COOKIE['token'];
            $alltokentab = explode(';', $alltoken);
            $token = $alltokentab[0];
            $tokentab = explode('=', $token);
            $tokenVal = $tokentab[1];
            $Authorization = 'Bearer ' . $tokenVal;

            $data = array(
                'name' => $name,
                'type' => $type,
                'prixUnit' => $unitprice,
                'quantity' => $quantity,
                "description" => $description,
                "picture" => $photoPath,
            );
            $data_json = json_encode($data);

            // print_r($data_json);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response  = curl_exec($ch);
            curl_close($ch);

            $response = json_decode($response);

            // print_r($response);

            if ($response->status == 200) {
                Session::flash('message', 'Action Successfully done!');
                Session::flash('alert-class', 'alert-success');
                return redirect()->back();
            } else {
                Session::flash('message', ucfirst($response->error));
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
        }
    }

    public function adminClauses()
    {
        return view('admin/adminClauses');
    }

    public function adminProfile(Request $request)
    {

        $id = $request->session()->get('id');

        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        $url = "http://172.17.0.2:4000/admin/auth/" . $id;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);
        $userdata = $response['result'];

        $url1 = "http://172.17.0.2:4000/admin/facture/getStaticInformation";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response1 = curl_exec($ch);
        curl_close($ch);
        $response1 = json_decode($response1, true);

        if (array_key_exists('result', $response1)) {

            if (!empty($response1['result'])) {

                $static = $response1['result'];
                $index = count($static);
            } else {
                $static = "";
                $index = 0;
            }
        }
        //print_r($static);
        return view('admin/profile', ['data' => $userdata, 'static' => $static, 'index' => $index]);
    }

    public function adminEditProfile(Request $request)
    {

        $id = $request->session()->get('id');

        $url = "http://172.17.0.2:4000/admin/auth/" . $id;
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);
        $userdata = $response['result'];

        return view('admin/editProfile', ['data' => $userdata]);
    }

    public function updateAdmin(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
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

            return back()->withErrors($validator)->withInput(['tab' => 'update']);
        } else {

            if ($request->file()) {
                $photo =  $request->file('photo')->getClientOriginalName();
                $photoPath = $request->photo->storeAs('/administrators', $photo);
            } else {
                $photo = "";
                if (Session::has('photo')) {
                    $photoPath = Session::get('photo');
                } else {
                    $photoPath = "noPath";
                }
            }


            $name = $request->input('name');
            $email = $request->input('email');
            $phone = $request->input('phone');
            $home = $request->input('home');


            $url = "http://172.17.0.2:4000/admin/auth/update";
            $alltoken = $_COOKIE['token'];
            $alltokentab = explode(';', $alltoken);
            $token = $alltokentab[0];
            $tokentab = explode('=', $token);
            $tokenVal = $tokentab[1];
            $Authorization = 'Bearer ' . $tokenVal;

            if (!empty($home)) {
                $data = array(
                    'name' => $name,
                    'birthday' => $birthdate,
                    'phone' => $phone,
                    'email' => $email,
                    "profileImage" => $photoPath,
                    "description" => $home,
                );
            } else {
                $data = array(
                    'name' => $name,
                    'birthday' => $birthdate,
                    'phone' => $phone,
                    'email' => $email,
                    "profileImage" => $photoPath,
                );
            }

            $data = array(
                'name' => $name,
                'phone' => $phone,
                'email' => $email,
                "profileImage" => $photoPath,
                "description" => $home,
            );

            $data_json = json_encode($data);

            // print_r($data_json);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
            //curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response  = curl_exec($ch);
            curl_close($ch);

            $response = json_decode($response);

            //print_r($response);

            if ($response->status == 200) {
                $request->session()->put('name', $name);
                $request->session()->put('photo', $photoPath);
                Session::flash('message', 'Action Successfully done!');
                Session::flash('alert-class', 'alert-success');
                return redirect()->back()->withInput(['tab' => 'update']);
            } else {
                Session::flash('message', ucfirst($response->error));
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back()->withInput(['tab' => 'update']);
            }
        }
    }

    public function changePassword(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'newpassword' => 'bail|required|regex:/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,15}$/',
                'confirmpassword' => 'bail|required|same:newpassword',
            ],

            $messages = [
                'confirmpassword.same' => 'Confirm your password',
                'newpassword.regex' => 'Between 8 and 15 characters - Minimum one uppercase letter and one number digit - Minimum one special character !@#$%^&*-',
            ]
        );


        if ($validator->fails()) {

            return back()->withErrors($validator)->withInput(['tab' => 'password_form']);
        } else {

            $newpassword = md5(sha1($request->input('newpassword')));
            $oldpassword = md5(sha1($request->input('oldpassword')));

            $url = "http://172.17.0.2:4000/admin/auth/updatePassword";
            $alltoken = $_COOKIE['token'];
            $alltokentab = explode(';', $alltoken);
            $token = $alltokentab[0];
            $tokentab = explode('=', $token);
            $tokenVal = $tokentab[1];
            $Authorization = 'Bearer ' . $tokenVal;

            $data = array(
                'oldPassword' => $oldpassword,
                'newPassword' => $newpassword,
            );
            $data_json = json_encode($data);

            // print_r($data_json);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
            //curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response  = curl_exec($ch);
            curl_close($ch);

            $response = json_decode($response);

            // print_r($response);

            if ($response->status == 200) {
                Session::flash('message', 'Action Successfully done!');
                Session::flash('alert-class', 'alert-success');
                return redirect()->back()->withInput(['tab' => 'password_form']);
            } else {
                Session::flash('message', ucfirst($response->error));
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back()->withInput(['tab' => 'password_form']);
            }
        }
    }

    public function saveSettings(Request $request)
    {

        $maintenance = $request->input('maintenance');
        $meterprice = $request->input('meterprice');
        $limitDay = $request->input('date');

        $url = "http://172.17.0.2:4000/admin/facture/staticInformation";
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        $data = array(
            'prixUnitaire' => $meterprice,
            'fraisEntretien' => $maintenance,
            'limiteDay' => $limitDay,
        );

        $data_json = json_encode($data);

        // print_r($data_json);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response);

        // print_r($response);

        if ($response->status == 200) {
            Session::flash('message', 'Action Successfully done!');
            Session::flash('alert-class', 'alert-success');
            return redirect()->back()->withInput(['tab' => 'settings']);
        } else {
            Session::flash('message', ucfirst($response->error));
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput(['tab' => 'settings']);
        }
    }

    public function penality(Request $request)
    {

        $sanction = $request->input('sanction');
        $step = $request->input('step');


        $url = "http://172.17.0.2:4000/admin/facture/penalty";
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        $data = array(
            'pas' => $step,
            'amountAdd' => $sanction,
        );

        $data_json = json_encode($data);

        // print_r($data_json);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response);

        // print_r($response);

        if ($response->status == 200) {
            Session::flash('message', 'Action Successfully done!');
            Session::flash('alert-class', 'alert-success');
            return redirect()->back()->withInput(['tab' => 'sanction']);
        } else {
            Session::flash('message', ucfirst($response->error));
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->withInput(['tab' => 'sanction']);
        }
    }


    //All Invoice that the admin have
    public function searchAll($page_size, $size)
    {
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        $year = date("Y");
        //echo $year;

        $month = date("m");
        //echo $month;

        $page = 1;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://172.17.0.2:4000/admin/facture/factureByYear/' . $year,

            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);

        $i = 0;
        $invoices = array();
        $invoicesWithPaginator = array();

        foreach ($response as $key => $value) {
            if ($i >= 1) {
                //echo $value;
                $invoices = $value;
                //array_push($invoices,$value);
                //dump($value);
            }
            $i = $i + 1;
            //dump($key);
        }

        $page_en_cours = $page_size;
        $previous_page = 1;
        $next_page = 1;

        $arrLength = count($invoices);
        //echo $arrLength;

        $size_final = $size * $page_size;

        if ($arrLength < $size) {
            $size = $arrLength;
        } else {
            $page = $arrLength / $size;
            //$next_page = $page + 1;
        }

        if ($page_en_cours > 1) {
            $previous_page = $page_en_cours - 1;
        }

        if ($arrLength < $size_final) {
            $size_final = $arrLength;
            $next_page = $page - 1;
        } else {
            if ($page_size == $size) {
                $next_page = $page;
            }
        }

        if ($size == $size_final) {
            for ($i = 0; $i < $size; $i++) {
                //$invoicesWithPaginator = $invoices[$i];
                array_push($invoicesWithPaginator, $invoices[$i]);
            }
        } else {
            for ($i = $size; $i < $size_final; $i++) {
                //$invoicesWithPaginator = $invoices[$i];
                array_push($invoicesWithPaginator, $invoices[$i]);
            }
        }

        //dump($invoicesWithPaginator);

        if (gettype($invoices) != "array") {
            $invoices = array();
        }

        //dump($invoices);

        $client = array();

        foreach ($invoicesWithPaginator as $invoice) {

            $idClient = $invoice->idClient;
            $url = curl_init();
            curl_setopt_array($url, array(
                CURLOPT_URL => 'http://172.17.0.2:4000/client/auth/' . $idClient,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
            ));

            $response = curl_exec($url);
            $response = json_decode($response);

            $i = 0;

            foreach ($response as $key => $value) {
                if ($i >= 1) {
                    array_push($client, $value);
                }
                $i = $i + 1;
            }
        }
        return view('admin/consumption', [
            'invoices' => $invoicesWithPaginator,
            'client' => $client,
            'page' => $page,
            'size' => $size,
            'page_en_cours' => $page_en_cours,
            'previous_page' => $previous_page,
            'next_page' => $next_page
        ]);
    }

    public function searchAllPaid($page_size, $size)
    {
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        $year = date("Y");
        //echo $year;

        $month = date("m");
        //echo $month;

        $page = 1;
        $invoices_paid = array();
        $invoices_unpaid = array();

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://172.17.0.2:4000/admin/facture/factureByYear/' . $year,

            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);

        $i = 0;
        $invoices = array();
        $invoicesWithPaginator = array();

        foreach ($response as $key => $value) {
            if ($i >= 1) {
                $invoices = $value;
            }
            $i = $i + 1;
        }

        foreach ($invoices as $invoice) {
            if ($invoice->facturePay) {
                array_push($invoices_paid, $invoice);
            } else {
                array_push($invoices_unpaid, $invoice);
            }
        }

        $page_en_cours = $page_size;
        $previous_page = 1;
        $next_page = 1;

        $arrLength = count($invoices_paid);

        $size_final = $size * $page_size;

        if ($arrLength < $size) {
            $size = $arrLength;
        } else {
            $page = $arrLength / $size;
            //$next_page = $page + 1;
        }

        if ($page_en_cours > 1) {
            $previous_page = $page_en_cours - 1;
        }

        if ($arrLength < $size_final) {
            $size_final = $arrLength;
            $next_page = $page - 1;
        } else {
            if ($page_size == $size) {
                $next_page = $page;
            }
        }

        if ($size == $size_final) {
            for ($i = 0; $i < $size; $i++) {
                array_push($invoicesWithPaginator, $invoices_paid[$i]);
            }
        } else {
            for ($i = $size; $i < $size_final; $i++) {
                array_push($invoicesWithPaginator, $invoices_paid[$i]);
            }
        }

        //dump($invoicesWithPaginator);

        if (gettype($invoices_paid) != "array") {
            $invoices_paid = array();
        }

        //dump($invoices);

        $client = array();

        foreach ($invoicesWithPaginator as $invoice) {

            $idClient = $invoice->idClient;
            $url = curl_init();
            curl_setopt_array($url, array(
                CURLOPT_URL => 'http://172.17.0.2:4000/client/auth/' . $idClient,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
            ));

            $response = curl_exec($url);
            $response = json_decode($response);

            $i = 0;

            foreach ($response as $key => $value) {
                if ($i >= 1) {
                    array_push($client, $value);
                }
                $i = $i + 1;
            }
        }
        return view('admin/consumptionThatArePaid', [
            'invoices' => $invoicesWithPaginator,
            'client' => $client,
            'page' => $page,
            'size' => $size,
            'page_en_cours' => $page_en_cours,
            'previous_page' => $previous_page,
            'next_page' => $next_page
        ]);
    }

    public function searchAllUnPaid($page_size, $size)
    {
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        $year = date("Y");
        //echo $year;

        $month = date("m");
        //echo $month;

        $page = 1;
        $invoices_paid = array();
        $invoices_unpaid = array();

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://172.17.0.2:4000/admin/facture/factureByYear/' . $year,

            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);

        $i = 0;
        $invoices = array();
        $invoicesWithPaginator = array();

        foreach ($response as $key => $value) {
            if ($i >= 1) {
                $invoices = $value;
            }
            $i = $i + 1;
        }

        foreach ($invoices as $invoice) {
            if ($invoice->facturePay) {
                array_push($invoices_paid, $invoice);
            } else {
                array_push($invoices_unpaid, $invoice);
            }
        }

        $page_en_cours = $page_size;
        $previous_page = 1;
        $next_page = 1;

        $arrLength = count($invoices_unpaid);

        $size_final = $size * $page_size;

        if ($arrLength < $size) {
            $size = $arrLength;
        } else {
            $page = $arrLength / $size;
            //$next_page = $page + 1;
        }

        if ($page_en_cours > 1) {
            $previous_page = $page_en_cours - 1;
        }

        if ($arrLength < $size_final) {
            $size_final = $arrLength;
            $next_page = $page - 1;
        } else {
            if ($page_size == $size) {
                $next_page = $page;
            }
        }

        if ($size == $size_final) {
            for ($i = 0; $i < $size; $i++) {
                array_push($invoicesWithPaginator, $invoices_unpaid[$i]);
            }
        } else {
            for ($i = $size; $i < $size_final; $i++) {
                array_push($invoicesWithPaginator, $invoices_unpaid[$i]);
            }
        }

        //dump($invoicesWithPaginator);

        if (gettype($invoices_unpaid) != "array") {
            $invoices_unpaid = array();
        }

        //dump($invoices);

        $client = array();

        foreach ($invoicesWithPaginator as $invoice) {

            $idClient = $invoice->idClient;
            $url = curl_init();
            curl_setopt_array($url, array(
                CURLOPT_URL => 'http://172.17.0.2:4000/client/auth/' . $idClient,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
            ));

            $response = curl_exec($url);
            $response = json_decode($response);

            $i = 0;

            foreach ($response as $key => $value) {
                if ($i >= 1) {
                    array_push($client, $value);
                }
                $i = $i + 1;
            }
        }
        
        return view('admin/consumption-that-are-unpaid', [
            'invoices' => $invoicesWithPaginator,
            'client' => $client,
            'page' => $page,
            'size' => $size,
            'page_en_cours' => $page_en_cours,
            'previous_page' => $previous_page,
            'next_page' => $next_page
        ]);
    }

    //All Invoice that the admin have
    public function searchByMonthOrYear()
    {
        // all Invoices
        if (isset($_POST['send_search'])) {
            $alltoken = $_COOKIE['token'];
            $alltokentab = explode(';', $alltoken);
            $token = $alltokentab[0];
            $tokentab = explode('=', $token);
            $tokenVal = $tokentab[1];
            $Authorization = 'Bearer ' . $tokenVal;

            $type = $_POST['type'];
            $month = '';
            $year = '';
            $username = '';

            if ($type === "month") {
                $month = $_POST['search'];
                $year = date("Y");
            } 
            
            if ($type === 'year') {
                $month = date("m");
                $year = $_POST['search'];
            }

            if ($type === 'username') {
                $username = $_POST['searchT'];
                $month = date("m");
                $year = date("Y");
            }

            $page = 1;
            $size = 20;
            $page_en_cours = $page;
            $previous_page = 1;
            $next_page = 1;

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://172.17.0.2:4000/admin/facture/' . $year . '/' . $month . '/' . $size . '/' . $page,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $response = json_decode($response);

            $i = 0;
            $invoices = array();

            foreach ($response as $key => $value) {
                if ($i >= 1) {
                    //echo $value;
                    $invoices = $value;
                    //dump($value);
                }
                $i = $i + 1;
                //dump($key);
            }

            if (gettype($invoices) != "array") {
                //    echo "je t'aime";
                $invoices = array();
            }

            //dump($invoices);

            $client = array();

            foreach ($invoices as $invoice) {

                $idClient = $invoice->idClient;
                //echo $idClient;
                $url = curl_init();
                curl_setopt_array($url, array(
                    CURLOPT_URL => 'http://172.17.0.2:4000/client/auth/' . $idClient,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
                ));

                $response = curl_exec($url);
                $response = json_decode($response);

                $i = 0;
                $user = $response -> result;
               
                array_push($client, $user);
            
            }

            $bill = array();
            $usagers = array();

            if ($username != '' && $username != null) {
                foreach ($client as $key => $user) {
                    $name = $user->name;
                    if (strcasecmp($username, $name)) {
                        unset($invoices[$key]);
                        unset($client[$key]);
                    } else {
                        array_push($usagers, $client[$key]);
                        array_push($bill, $invoices[$key]);
                    }
                }

                
            return view('admin/consumption', [
                'invoices' => $bill,
                'client' => $usagers,
                'page' => $page,
                'size' => $size,
                'page_en_cours' => $page_en_cours,
                'previous_page' => $previous_page,
                'next_page' => $next_page
            ]);
            } else {

            return view('admin/consumption', [
                'invoices' => $invoices,
                'client' => $client,
                'page' => $page,
                'size' => $size,
                'page_en_cours' => $page_en_cours,
                'previous_page' => $previous_page,
                'next_page' => $next_page
            ]);
            }

        }
        if (isset($_POST['send_pagination'])) {
            $alltoken = $_COOKIE['token'];
            $alltokentab = explode(';', $alltoken);
            $token = $alltokentab[0];
            $tokentab = explode('=', $token);
            $tokenVal = $tokentab[1];
            $Authorization = 'Bearer ' . $tokenVal;

            $year = date("Y");
            //echo $year;

            $month = date("m");
            //echo $month;

            $page = 1;

            $size = $_POST['select_size'];

            $page_en_cours = $page;
            $previous_page = 1;
            $next_page = 1;

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://172.17.0.2:4000/admin/facture/factureByYear/' . $year,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $response = json_decode($response);

            $i = 0;
            $invoices = array();
            $invoicesWithPaginator = array();

            foreach ($response as $key => $value) {
                if ($i >= 1) {
                    //echo $value;
                    $invoices = $value;
                    //array_push($invoices,$value);
                    //dump($value);
                }
                $i = $i + 1;
                //dump($key);
            }

            $arrLength = count($invoices);
            //echo $arrLength;

            if ($arrLength < $size) {
                $size = $arrLength;
                $page_en_cours = 1;
            } else {
                $page = $arrLength / $size;
                $next_page = $page_en_cours + 1;
            }

            for ($i = 0; $i < $size; $i++) {
                //$invoicesWithPaginator = $invoices[$i];
                array_push($invoicesWithPaginator, $invoices[$i]);
            }

            //dump($invoicesWithPaginator);

            if (gettype($invoices) != "array") {
                $invoices = array();
            }

            //dump($invoices);

            $client = array();

            foreach ($invoicesWithPaginator as $invoice) {

                $idClient = $invoice->idClient;
                $url = curl_init();
                curl_setopt_array($url, array(
                    CURLOPT_URL => 'http://172.17.0.2:4000/client/auth/' . $idClient,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
                ));

                $response = curl_exec($url);
                $response = json_decode($response);

                $i = 0;

                foreach ($response as $key => $value) {
                    if ($i >= 1) {
                        array_push($client, $value);
                    }
                    $i = $i + 1;
                }
            }
            return view('admin/consumption', [
                'invoices' => $invoicesWithPaginator,
                'client' => $client,
                'page' => $page,
                'size' => $size,
                'page_en_cours' => $page_en_cours,
                'previous_page' => $previous_page,
                'next_page' => $next_page
            ]);
        }

        // all consumption that are paid
        if (isset($_POST['send_search_consumption_paid'])) {
            $alltoken = $_COOKIE['token'];
            $alltokentab = explode(';', $alltoken);
            $token = $alltokentab[0];
            $tokentab = explode('=', $token);
            $tokenVal = $tokentab[1];
            $Authorization = 'Bearer ' . $tokenVal;
            $type = $_POST['type'];

            if ($type === "month" || $type === 'year') {

                $month = '';
                $year = '';

                if ($type === "month") {
                    $month = $_POST['search'];
                    $year = date("Y");
                } else if ($type === 'year') {
                    $month = date("m");
                    $year = $_POST['search'];
                }

                $page = 1;
                $size = 20;
                $page_en_cours = $page;
                $previous_page = 1;
                $next_page = 1;

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'http://172.17.0.2:4000/admin/facture/' . $year . '/' . $month . '/' . $size . '/' . $page,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
                ));

                $response = curl_exec($curl);
                curl_close($curl);
                $response = json_decode($response);

                $i = 0;
                $invoices = array();
                $invoices_paid = array();
                $invoices_unpaid = array();

                foreach ($response as $key => $value) {
                    if ($i >= 1) {
                        //echo $value;
                        $invoices = $value;
                        //dump($value);
                    }
                    $i = $i + 1;
                    //dump($key);
                }

                if (gettype($invoices) != "array") {
                    //    echo "je t'aime";
                    $invoices = array();
                }

                //dump($invoices);
                foreach ($invoices as $invoice) {
                    if ($invoice->facturePay) {
                        array_push($invoices_paid, $invoice);
                    } else {
                        array_push($invoices_unpaid, $invoice);
                    }
                }

                $client = array();

                foreach ($invoices_paid as $invoice) {

                    $idClient = $invoice->idClient;
                    //echo $idClient;
                    $url = curl_init();
                    curl_setopt_array($url, array(
                        CURLOPT_URL => 'http://172.17.0.2:4000/client/auth/' . $idClient,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'GET',
                        CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
                    ));

                    $response = curl_exec($url);
                    $response = json_decode($response);

                    $i = 0;

                    foreach ($response as $key => $value) {
                        if ($i >= 1) {
                            array_push($client, $value);
                        }
                        $i = $i + 1;
                    }
                }

                return view('admin/consumptionThatArePaid', [
                    'invoices' => $invoices_paid,
                    'client' => $client,
                    'page' => $page,
                    'size' => $size,
                    'page_en_cours' => $page_en_cours,
                    'previous_page' => $previous_page,
                    'next_page' => $next_page
                ]);
            } else {
                if ($type === "username" || $type === "meterId") {
                    $month = date("m");
                    $year = date("Y");
                    $page = 1;
                    $size = 20;
                    $page_en_cours = $page;
                    $previous_page = 1;
                    $next_page = 1;
                    $username = '';
                    $meterId = '';
                    if ($type === "username") {
                        $username = $_POST['searchT'];
                    } else if ($type === "meterId") {
                        $meterId = $_POST['searchT'];
                    }

                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'http://172.17.0.2:4000/admin/facture/' . $year . '/' . $month . '/' . $size . '/' . $page,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'GET',
                        CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
                    ));

                    $response = curl_exec($curl);
                    curl_close($curl);
                    $response = json_decode($response);

                    $i = 0;
                    $invoices = array();
                    $invoices_paid = array();
                    $invoices_unpaid = array();
                    $clients = array();
                    $client;

                    foreach ($response as $key => $value) {
                        if ($i >= 1) {
                            $invoices = $value;
                            // array_push($clients,$invoice);
                        }
                        $i = $i + 1;
                    }

                    if (gettype($invoices) != "array") {
                        $invoices = array();
                    }

                    foreach ($invoices as $invoice) {
                        if ($invoice->facturePay) {
                            array_push($invoices_paid, $invoice);
                        } else {
                            array_push($invoices_unpaid, $invoice);
                        }
                    }

                    foreach ($invoices_paid as $invoice) {

                    $idClient = $invoice ->idClient;
                    $url = curl_init();
                    curl_setopt_array($url, array(
                        CURLOPT_URL => 'http://172.17.0.2:4000/client/auth/' . $idClient,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'GET',
                        CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
                    ));

                    $response = curl_exec($url);
                    $response = json_decode($response);
                    $i = 0;

                    $response = curl_exec($url);
                    $response = json_decode($response);
    
                    $user = $response -> result;
                   
                    array_push($client, $user);
                
                }
    
                $bill = array();
                $usagers = array();
    
                foreach ($client as $key => $user) {
                    $name = $user->name;
                    if (strcasecmp($username, $name)) {
                        unset($invoices_paid[$key]);
                        unset($client[$key]);
                    } else {
                        array_push($usagers, $client[$key]);
                        array_push($bill, $invoices_paid[$key]);
    
                    }
                }
    
                return view('admin/consumptionThatArePaid', [
                    'invoices' => $bill,
                    'client' => $usagers,
                    'page' => $page,
                    'size' => $size,
                    'page_en_cours' => $page_en_cours,
                    'previous_page' => $previous_page,
                    'next_page' => $next_page
                ]);
                }
            }
        }
        if (isset($_POST['send_pagination_consumption_paid'])) {
            $alltoken = $_COOKIE['token'];
            $alltokentab = explode(';', $alltoken);
            $token = $alltokentab[0];
            $tokentab = explode('=', $token);
            $tokenVal = $tokentab[1];
            $Authorization = 'Bearer ' . $tokenVal;

            $year = date("Y");
            //echo $year;

            $month = date("m");
            //echo $month;

            $page = 1;

            $size = $_POST['select_size'];

            $page_en_cours = $page;
            $previous_page = 1;
            $next_page = 1;
            $invoices_paid = array();
            $invoices_unpaid = array();

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://172.17.0.2:4000/admin/facture/factureByYear/' . $year,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $response = json_decode($response);

            $i = 0;
            $invoices = array();
            $invoicesWithPaginator = array();

            foreach ($response as $key => $value) {
                if ($i >= 1) {
                    $invoices = $value;
                }
                $i = $i + 1;
                //dump($key);
            }

            foreach ($invoices as $invoice) {
                if ($invoice->facturePay) {
                    array_push($invoices_paid, $invoice);
                } else {
                    array_push($invoices_unpaid, $invoice);
                }
            }

            $arrLength = count($invoices_paid);
            //echo $arrLength;

            if ($arrLength < $size) {
                $size = $arrLength;
                $page_en_cours = 1;
            } else {
                $page = $arrLength / $size;
                $next_page = $page_en_cours + 1;
            }

            for ($i = 0; $i < $size; $i++) {
                array_push($invoicesWithPaginator, $invoices_paid[$i]);
            }

            if (gettype($invoices_paid) != "array") {
                $invoices_paid = array();
            }

            //dump($invoices);

            $client = array();

            foreach ($invoicesWithPaginator as $invoice) {

                $idClient = $invoice->idClient;
                $url = curl_init();
                curl_setopt_array($url, array(
                    CURLOPT_URL => 'http://172.17.0.2:4000/client/auth/' . $idClient,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
                ));

                $response = curl_exec($url);
                $response = json_decode($response);

                $i = 0;

                foreach ($response as $key => $value) {
                    if ($i >= 1) {
                        array_push($client, $value);
                    }
                    $i = $i + 1;
                }
            }
            return view('admin/consumptionThatArePaid', [
                'invoices' => $invoicesWithPaginator,
                'client' => $client,
                'page' => $page,
                'size' => $size,
                'page_en_cours' => $page_en_cours,
                'previous_page' => $previous_page,
                'next_page' => $next_page
            ]);
        }

        // all consumption that are unpaid
        if (isset($_POST['send_search_consumption_unpaid'])) {
            $alltoken = $_COOKIE['token'];
            $alltokentab = explode(';', $alltoken);
            $token = $alltokentab[0];
            $tokentab = explode('=', $token);
            $tokenVal = $tokentab[1];
            $Authorization = 'Bearer ' . $tokenVal;
            $type = $_POST['type'];

            if ($type === "month" || $type === 'year') {

                $month = '';
                $year = '';

                if ($type === "month") {
                    $month = $_POST['search'];
                    $year = date("Y");
                } else if ($type === 'year') {
                    $month = date("m");
                    $year = $_POST['search'];
                }

                $page = 1;
                $size = 20;
                $page_en_cours = $page;
                $previous_page = 1;
                $next_page = 1;

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'http://172.17.0.2:4000/admin/facture/' . $year . '/' . $month . '/' . $size . '/' . $page,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
                ));

                $response = curl_exec($curl);
                curl_close($curl);
                $response = json_decode($response);

                $i = 0;
                $invoices = array();
                $invoices_paid = array();
                $invoices_unpaid = array();

                foreach ($response as $key => $value) {
                    if ($i >= 1) {
                        //echo $value;
                        $invoices = $value;
                        //dump($value);
                    }
                    $i = $i + 1;
                    //dump($key);
                }

                if (gettype($invoices) != "array") {
                    //    echo "je t'aime";
                    $invoices = array();
                }

                //dump($invoices);
                foreach ($invoices as $invoice) {
                    if ($invoice->facturePay) {
                        array_push($invoices_paid, $invoice);
                    } else {
                        array_push($invoices_unpaid, $invoice);
                    }
                }

                $client = array();

                foreach ($invoices_unpaid as $invoice) {

                    $idClient = $invoice->idClient;
                    //echo $idClient;
                    $url = curl_init();
                    curl_setopt_array($url, array(
                        CURLOPT_URL => 'http://172.17.0.2:4000/client/auth/' . $idClient,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'GET',
                        CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
                    ));

                    $response = curl_exec($url);
                    $response = json_decode($response);

                    $i = 0;

                    foreach ($response as $key => $value) {
                        if ($i >= 1) {
                            array_push($client, $value);
                        }
                        $i = $i + 1;
                    }
                }
                return view('admin/consumptionThatAreNotPaid', [
                    'invoices' => $invoices_unpaid,
                    'client' => $client,
                    'page' => $page,
                    'size' => $size,
                    'page_en_cours' => $page_en_cours,
                    'previous_page' => $previous_page,
                    'next_page' => $next_page
                ]);
            } else {
                if ($type === "username" || $type === "meterId") {
                    $month = date("m");
                    $year = date("Y");
                    $page = 1;
                    $size = 20;
                    $page_en_cours = $page;
                    $previous_page = 1;
                    $next_page = 1;
                    $username = '';
                    $meterId = '';
                    if ($type === "username") {
                        $username = $_POST['searchT'];
                    } else if ($type === "meterId") {
                        $meterId = $_POST['searchT'];
                    }

                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'http://172.17.0.2:4000/admin/facture/' . $year . '/' . $month . '/' . $size . '/' . $page,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'GET',
                        CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
                    ));

                    $response = curl_exec($curl);
                    curl_close($curl);
                    $response = json_decode($response);

                    $i = 0;
                    $invoices = array();
                    $invoices_paid = array();
                    $invoices_unpaid = array();
                    $clients = array();

                    foreach ($response as $key => $value) {
                        if ($i >= 1) {
                            $invoices = $value;
                            // array_push($clients,$invoice);
                        }
                        $i = $i + 1;
                    }

                    if (gettype($invoices) != "array") {
                        $invoices = array();
                    }

                    foreach ($invoices as $invoice) {
                        if ($invoice->facturePay) {
                            array_push($invoices_paid, $invoice);
                        } else {
                            array_push($invoices_unpaid, $invoice);
                        }
                    }

                    foreach ($invoices_unpaid as $invoice) {

                    $idClient = $invoice->idClient;
                    $url = curl_init();
                    curl_setopt_array($url, array(
                        CURLOPT_URL => 'http://172.17.0.2:4000/client/auth/' . $idClient,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'GET',
                        CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
                    ));

                    $response = curl_exec($url);
                    $response = json_decode($response);
    
                    $user = $response -> result;
                   
                    array_push($clients, $user);
                
                }
    
                $bill = array();
                $usagers = array();
    
                foreach ($clients as $key => $user) {
                    $name = $user->name;
                    if (strcasecmp($username, $name)) {
                        unset($invoices[$key]);
                        unset($clients[$key]);
                    } else {
                        array_push($usagers, $clients[$key]);
                        array_push($bill, $invoices[$key]);
    
                    }
                }
    
                return view('admin/consumptionThatAreNotPaid', [
                    'invoices' => $bill,
                    'client' => $usagers,
                    'page' => $page,
                    'size' => $size,
                    'page_en_cours' => $page_en_cours,
                    'previous_page' => $previous_page,
                    'next_page' => $next_page
                ]);

                }
            }
        }
        if (isset($_POST['send_pagination_consumption_unpaid'])) {
            $alltoken = $_COOKIE['token'];
            $alltokentab = explode(';', $alltoken);
            $token = $alltokentab[0];
            $tokentab = explode('=', $token);
            $tokenVal = $tokentab[1];
            $Authorization = 'Bearer ' . $tokenVal;

            $year = date("Y");
            //echo $year;

            $month = date("m");
            //echo $month;

            $page = 1;

            $size = $_POST['select_size'];

            $page_en_cours = $page;
            $previous_page = 1;
            $next_page = 1;
            $invoices_paid = array();
            $invoices_unpaid = array();

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://172.17.0.2:4000/admin/facture/factureByYear/' . $year,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $response = json_decode($response);

            $i = 0;
            $invoices = array();
            $invoicesWithPaginator = array();

            foreach ($response as $key => $value) {
                if ($i >= 1) {
                    $invoices = $value;
                }
                $i = $i + 1;
                //dump($key);
            }

            foreach ($invoices as $invoice) {
                if ($invoice->facturePay) {
                    array_push($invoices_paid, $invoice);
                } else {
                    array_push($invoices_unpaid, $invoice);
                }
            }

            $arrLength = count($invoices_unpaid);
            //echo $arrLength;

            if ($arrLength < $size) {
                $size = $arrLength;
                $page_en_cours = 1;
            } else {
                $page = $arrLength / $size;
                $next_page = $page_en_cours + 1;
            }

            for ($i = 0; $i < $size; $i++) {
                array_push($invoicesWithPaginator, $invoices_unpaid[$i]);
            }

            if (gettype($invoices_unpaid) != "array") {
                $invoices_unpaid = array();
            }

            //dump($invoices);

            $client = array();

            foreach ($invoicesWithPaginator as $invoice) {

                $idClient = $invoice->idClient;
                $url = curl_init();
                curl_setopt_array($url, array(
                    CURLOPT_URL => 'http://172.17.0.2:4000/client/auth/' . $idClient,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
                ));

                $response = curl_exec($url);
                $response = json_decode($response);

                $i = 0;

                foreach ($response as $key => $value) {
                    if ($i >= 1) {
                        array_push($client, $value);
                    }
                    $i = $i + 1;
                }
            }
            return view('admin/consumptionThatAreNotPaid', [
                'invoices' => $invoicesWithPaginator,
                'client' => $client,
                'page' => $page,
                'size' => $size,
                'page_en_cours' => $page_en_cours,
                'previous_page' => $previous_page,
                'next_page' => $next_page
            ]);
        }
    }

    public function allInvoices()
    {
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        $year = date("Y");
        //echo $year;

        $month = date("m");
        //echo $month;

        $page = 1;

        $size = 5;

        $page_en_cours = 1;
        $previous_page = 1;
        $next_page = 1;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://172.17.0.2:4000/admin/facture/factureByYear/' . $year,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);

        $i = 0;
        $invoices = array();
        $invoicesWithPaginator = array();

        foreach ($response as $key => $value) {
            if ($i >= 1) {
                //echo $value;
                $invoices = $value;
                //array_push($invoices,$value);
                //dump($value);
            }
            $i = $i + 1;
            //dump($key);
        }

        $arrLength = count($invoices);
        //echo $arrLength;

        if ($arrLength < $size) {
            $size = $arrLength;
            $page_en_cours = 1;
        } else {
            $page = $arrLength / $size;
            $next_page = $page_en_cours + 1;
        }

        for ($i = 0; $i < $size; $i++) {
            //$invoicesWithPaginator = $invoices[$i];
            array_push($invoicesWithPaginator, $invoices[$i]);
        }

        //dump($invoicesWithPaginator);

        if (gettype($invoices) != "array") {
            $invoices = array();
        }

        //dump($invoices);

        $client = array();

        foreach ($invoicesWithPaginator as $invoice) {

            $idClient = $invoice->idClient;
            $url = curl_init();
            curl_setopt_array($url, array(
                CURLOPT_URL => 'http://172.17.0.2:4000/client/auth/' . $idClient,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
            ));

            $response = curl_exec($url);
            $response = json_decode($response);

            $i = 0;

            foreach ($response as $key => $value) {
                if ($i >= 1) {
                    array_push($client, $value);
                }
                $i = $i + 1;
            }
        }


        return view('admin/consumption', [
            'invoices' => $invoicesWithPaginator,
            'client' => $client,
            'page' => $page,
            'size' => $size,
            'page_en_cours' => $page_en_cours,
            'previous_page' => $previous_page,
            'next_page' => $next_page
        ]);
    }

    public function allUnPaidInvoices()
    {
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        $page = 1;

        $size = 5;

        $page_en_cours = 1;
        $previous_page = 1;
        $next_page = 1;

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
            CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);
        //dump($response);

        $i = 0;
        $invoices = array();
        $invoicesWithPaginator = array();
        $client = array();

        if ($response->status == 200) {
            foreach ($response->result as $key => $value) {
                //$invoices = $value;
                array_push($invoices, $value);
            }
        }

        //dump($invoices);
        //echo gettype($invoices);

        if (gettype($invoices) === 'array') {
            $arrLength = count($invoices);
            // echo $arrLength;

            if ($arrLength < $size) {
                $size = $arrLength;
                $page_en_cours = 1;
            } else {
                $page = $arrLength / $size;
                $next_page = $page_en_cours + 1;
            }

            for ($i = 0; $i < $size; $i++) {
                //$invoicesWithPaginator = $invoices[$i];
                array_push($invoicesWithPaginator, $invoices[$i]);
            }

            foreach ($invoicesWithPaginator as $invoice) {

                $idClient = $invoice->idClient;
                $url = curl_init();
                curl_setopt_array($url, array(
                    CURLOPT_URL => 'http://172.17.0.2:4000/client/auth/' . $idClient,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
                ));

                $response = curl_exec($url);
                $response = json_decode($response);
                // dump($response);
                // $i=0;

                $user = $response->result;

                array_push($client, $user);
            }

            return view('admin/consumptionThatAreNotPaid', [
                'invoices' => $invoicesWithPaginator,
                'client' => $client,
                'page' => $page,
                'size' => $size,
                'page_en_cours' => $page_en_cours,
                'previous_page' => $previous_page,
                'next_page' => $next_page
            ]);
        } else {
            return view('admin/consumptionThatAreNotPaid',[
                'invoices' => $invoicesWithPaginator,
                'client' => $client,
                'page' => $page,
                'size' => $size,
                'page_en_cours' => $page_en_cours,
                'previous_page' => $previous_page,
                'next_page' => $next_page
            ]);
        }
    }

    public function allPaidInvoices()
    {
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        $page = 1;

        $size = 5;

        $page_en_cours = 1;
        $previous_page = 1;
        $next_page = 1;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://172.17.0.2:4000/admin/facture/getByStatus/true',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);

        $i = 0;
        $invoices = array();
        $invoicesWithPaginator = array();

        $client = array();

        if ($response->status == 200) {
            foreach ($response->result as $key => $value) {
                //$invoices = $value;
                array_push($invoices, $value);
            }
        }

        if (gettype($invoices) != 'array') {
            return view('admin/consumptionThatArePaid', [
                'invoices' => $invoicesWithPaginator,
                'client' => $client,
                'page' => $page,
                'size' => $size,
                'page_en_cours' => $page_en_cours,
                'previous_page' => $previous_page,
                'next_page' => $next_page
            ]);
        } else {
            $arrLength = count($invoices);
            //echo $arrLength;

            if ($arrLength < $size) {
                $size = $arrLength;
                $page_en_cours = 1;
            } else {
                $page = $arrLength / $size;
                $next_page = $page_en_cours + 1;
            }

            for ($i = 0; $i < $size; $i++) {
                //$invoicesWithPaginator = $invoices[$i];
                array_push($invoicesWithPaginator, $invoices[$i]);
            }

            //dump($invoicesWithPaginator);

            if (gettype($invoices) != "array") {
                $invoices = array();
            }

            //dump($invoices);

            foreach ($invoicesWithPaginator as $invoice) {
                $idClient = $invoice->idClient;
                $url = curl_init();
                curl_setopt_array($url, array(
                    CURLOPT_URL => 'http://172.17.0.2:4000/client/auth/' . $idClient,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
                ));

                $response = curl_exec($url);
                $response = json_decode($response);

                $user = $response->result;

                array_push($client, $user);
            }
            return view('admin/consumptionThatArePaid', [
                'invoices' => $invoicesWithPaginator,
                'client' => $client,
                'page' => $page,
                'size' => $size,
                'page_en_cours' => $page_en_cours,
                'previous_page' => $previous_page,
                'next_page' => $next_page
            ]);
        }
    }

    public function getPenalty()
    {
        if (isset($_POST['penalty'])) {
        }
    }

    public function getTranche()
    {
        if (isset($_POST['tranche'])) {
        }
    }

    public function getPenaltyAndTranche()
    {
        if (isset($_POST['tranche'])) {
        } else if (isset($_POST['penalty'])) {
        }
    }

    public function print($invoice_id)
    {
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://172.17.0.2:4000/admin/facture/one/' . $invoice_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $invoice = json_decode($response, true);

        // print_r($invoice['result']);

        $curl2 = curl_init();
        curl_setopt_array($curl2, array(
            CURLOPT_URL => 'http://172.17.0.2:4000/client/auth/' . $invoice['result']['idClient'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
        ));
        $response2 = curl_exec($curl2);
        curl_close($curl2);
        $client = json_decode($response2, true);

        $curl3 = curl_init();
        curl_setopt_array($curl3, array(
            CURLOPT_URL => 'http://172.17.0.2:4000/admin/auth/' . $invoice['result']['idAdmin'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
        ));
        $response3 = curl_exec($curl3);
        curl_close($curl3);
        $admin = json_decode($response3, true);
        
        $pdf = PDF::loadView('facturePdf/generator', ['invoice' => $invoice, 'client' => $client, 'admin' => $admin]);
return $pdf->download('facture-' . $client['result']['name'] . '-' . date('F') . '.pdf');;
    }

    public function detailInvoive($invoice_id)
    {
        //echo "v ".$invoice_id;
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://172.17.0.2:4000/admin/facture/one/' . $invoice_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);

        $i = 0;
        $invoice = array();

        foreach ($response as $key => $value) {
            if ($i >= 1) {
                //echo $value;
                //array_push($invoice,$value);
                $invoice = $value;
                //dump($value);
            }
            $i = $i + 1;
            //dump($key);
        }

        if (gettype($invoice) != "array" && gettype($invoice) != "object") {
            //    echo "je t'aime";
            $invoice = array();
        }

        //dump($invoice);

        if ($invoice->idClient != null) {
            $client = array();

            $idClient = $invoice->idClient;
            //echo $idClient;
            $url = curl_init();
            curl_setopt_array($url, array(
                CURLOPT_URL => 'http://172.17.0.2:4000/client/auth/' . $idClient,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
            ));

            $response = curl_exec($url);
            $response = json_decode($response);

            $i = 0;

            foreach ($response as $key => $value) {
                if ($i >= 1) {
                    //echo $value;
                    $client = $value;
                }
                $i = $i + 1;
                //dump($key);
            }

            //dump($client);
            curl_close($url);
        }

        //dump($invoice);
        return view(
            'admin/detailInvoice',
            [
                'invoice' => $invoice,
                'client' => $client,
                'show' => false,
            ]
        );
    }

    public function getClientByInvoices($invoice_id, $client_id)
    {
        //echo "v ".$invoice_id;
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        //dump($invoice);

        if ($client_id != null) {
            $client = array();

            $idClient = $client_id;
            //echo $idClient;
            $url = curl_init();
            curl_setopt_array($url, array(
                CURLOPT_URL => 'http://172.17.0.2:4000/client/auth/' . $client_id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
            ));

            $response = curl_exec($url);
            $response = json_decode($response);

            $i = 0;

            foreach ($response as $key => $value) {
                if ($i >= 1) {
                    //echo $value;
                    $client = $value;
                }
                $i = $i + 1;
                //dump($key);
            }

            //dump($client);
            curl_close($url);
        }
        return view(
            'admin/detailInvoice',
            [
                'invoice' => $invoice_id,
                'client' => $client,
                'show' => true,
            ]
        );
    }

    //All Invoice that the admin have
    public function allInvoicesThatHaveAdvenced()
    {
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

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
            CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);

        $i = 0;
        $invoicesAdvenced = array();
        //echo "je";

        $year = date("Y");
        //echo $year;

        $month = date("m");
        //echo $month;

        foreach ($response as $key => $value) {
            if ($i >= 1) {
                //echo $value;
                $invoicesAdvenced = $value;
                //dump($value);
            }
            $i = $i + 1;
            //dump($key);
        }

        //dump($invoicesAdvenced);
        if (gettype($invoicesAdvenced) != "array") {
            // echo "je t'aime";
            $invoicesAdvenced = array();
        }

        $client = array();

        foreach ($invoicesAdvenced as $invoice) {

            $idClient = $invoice->idClient;
            //echo $idClient;
            $url = curl_init();
            curl_setopt_array($url, array(
                CURLOPT_URL => 'http://172.17.0.2:4000/client/auth/' . $idClient,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
            ));

            $response = curl_exec($url);
            $response = json_decode($response);

            $i = 0;

            foreach ($response as $key => $value) {
                if ($i >= 1) {
                    //echo $value;
                    //$client = $value;
                    array_push($client, $value);
                    //dump($value);
                }
                $i = $i + 1;
                //dump($key);
            }
        }

        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_URL => 'http://172.17.0.2:4000/admin/facture/' . $year . '/' . $month . '/1000/1',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
        ));

        $re = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($re);

        $earnly = 0;
        $invoices_paid = array();
        $invoices_month = array();
        $invoices_year = array();
        $row = 0;

        foreach ($res as $key => $value) {
            if ($i >= 3) {
                $row = count($value);
                if ($row > 0) {
                    if ($value->facturePay) {
                        $earnly = $value->montantVerse + $earnly;
                        //array_push($invoices_paid,$value);
                        $invoices_paid = $value;
                    }
                    $invoices_month = $value;
                }
            }
            $i = $i + 1;
        }

        $people = array();
        $number0fClient = 0;

        if ($invoices_paid > 0) {
            foreach ($invoices_paid as $invoice) {

                $idClient = $invoice->idClient;
                $url = curl_init();
                curl_setopt_array($url, array(
                    CURLOPT_URL => 'http://172.17.0.2:4000/client/auth/' . $idClient,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
                ));

                $response = curl_exec($url);
                $response = json_decode($response);

                $i = 0;

                foreach ($response as $key => $value) {
                    if ($i >= 1) {
                        array_push($people, $value);
                    }
                    $i = $i + 1;
                }
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
            CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
        ));

        $user = curl_exec($url_client);
        $user = json_decode($user);
        $user_list = array();

        foreach ($user as $key => $value) {
            if ($i >= 3) {
                $user_list = $value;
            }
            $i = $i + 1;
        }
        $numberOfAllClient = count($user_list);
        $pourcent = ($number0fClient / $numberOfAllClient) * 100;
        //dump($invoicesAdvenced);

        // annuel
        $url_annuel = curl_init();
        curl_setopt_array($url_annuel, array(
            CURLOPT_URL => 'http://172.17.0.2:4000/admin/facture/factureByYear/' . $year,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
        ));

        $invoices_annuel = curl_exec($url_annuel);
        $invoices_annuel = json_decode($invoices_annuel);
        $invoices_annuel_list = array();

        foreach ($invoices_annuel as $key => $value) {
            if ($i >= 3) {
                $invoices_annuel_list = $value;
            }
            $i = $i + 1;
        }

        return view('admin/dashboard', [
            'invoices' => $invoicesAdvenced,
            'client' => $client,
            'pourcent' => $pourcent,
            'earnly' => $earnly,
            'earnly_invoices' => $invoices_annuel_list,
        ]);
    }

    //Function about invoice
    public function allInvoicesByClient()
    {
        $idClient = $_POST['idClient'];

        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://172.17.0.2:4000/admin/facture/' . $idClient,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);

        $i = 0;
        $invoices = array();

        foreach ($response as $key => $value) {
            if ($i >= 1) {
                //echo $value;
                $invoices = $value;
                //dump($value);
            }
            $i = $i + 1;
            //dump($key);
        }

        //dump($users);
        return view('client/consumption', ['invoices' => $invoices]);

        //return view('client/consumption',['invoices' => $invoices]);
    }

    //finish to paid invoice
    public function finishToPaidInvoice()
    {
        if (isset($_POST['connect'])) {
            $amount = $_POST['amount'];
            $invoice_id = $_POST['idInvoice'];

            $url = "http://172.17.0.2:4000/admin/facture/statusPaidFacture/" . $invoice_id;
            $alltoken = $_COOKIE['token'];
            $alltokentab = explode(';', $alltoken);
            $token = $alltokentab[0];
            $tokentab = explode('=', $token);
            $tokenVal = $tokentab[1];
            $Authorization = 'Bearer ' . $tokenVal;

            $facture = array(
                'amount' => $amount
            );

            $data_json = json_encode($facture);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response  = curl_exec($ch);
            curl_close($ch);

            $messageErr = null;
            $messageOK = null;

            $response = json_decode($response);

            if ($response->status == 200) {
                $messageOK = "Action Done Successfully";
            } else {
                $messageErr = ucfirst($response->error);
            }

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://172.17.0.2:4000/admin/facture/one/' . $invoice_id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $response = json_decode($response);

            $i = 0;
            $invoice = array();

            foreach ($response as $key => $value) {
                if ($i >= 1) {
                    //echo $value;
                    //array_push($invoice,$value);
                    $invoice = $value;
                    //dump($value);
                }
                $i = $i + 1;
                //dump($key);
            }

            if (gettype($invoice) != "array" && gettype($invoice) != "object") {
                //    echo "je t'aime";
                $invoice = array();
            }

            //dump($invoice);

            if ($invoice->idClient != null) {
                $client = array();

                $idClient = $invoice->idClient;
                //echo $idClient;
                $url = curl_init();
                curl_setopt_array($url, array(
                    CURLOPT_URL => 'http://172.17.0.2:4000/client/auth/' . $idClient,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
                ));

                $response = curl_exec($url);
                $response = json_decode($response);

                $i = 0;

                foreach ($response as $key => $value) {
                    if ($i >= 1) {
                        //echo $value;
                        $client = $value;
                    }
                    $i = $i + 1;
                    //dump($key);
                }
            }
            //echo "oo";
            return view(
                'admin/detailInvoice',
                [
                    'invoice' => $invoice,
                    'client' => $client,
                    'show' => false,
                    'messageOK' => $messageOK,
                    'messageErr' => $messageErr,
                ]
            );
        }
    }
    //finish to paid invoice
    public function updateInvoice($invoice_id)
    {
        echo " v " . $invoice_id;
        if (isset($_POST['connect'])) {
            // je definie l'url de connexion.
            $url = "http://172.17.0.2:4000/admin/facture/one/" . $invoice_id;

            $alltoken = $_COOKIE['token'];
            $alltokentab = explode(';', $alltoken);
            $token = $alltokentab[0];
            $tokentab = explode('=', $token);
            $tokenVal = $tokentab[1];
            $Authorization = 'Bearer ' . $tokenVal;

            $newIndex = $_POST['newIndex'];
            $penalty = $_POST['penalty'];
            $observation = $_POST['observation'];
            $dateSpicy = $_POST['dateSpicy'];
            $amountPaid = $_POST['amountPaid'];

            // je definie la donnée de ma facture.
            $facture = array(
                "newIndex"  => $newIndex,
                "observation" => $observation,
                "penalite"  => $penalty,
                "montantVerse"  => $amountPaid,
                "dateReleveNewIndex"  => $dateSpicy
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
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));

            //CURLOPT_POST : si la requête doit utiliser le protocole POST pour sa résolution (boolean)
            curl_setopt($ch, CURLOPT_PUT, 1);

            //j'insere la donnée à etre envoyé
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
            //enfin d'avoir un retour sur l'etat de la requette on a CURLOPT_RETURNTRANSFER = true
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response  = curl_exec($ch);
            //var_dump($response);
            curl_close($ch);

            $messageErr = null;
            $messageOK = null;

            $response = json_decode($response);

            if ($response->status == 200) {
                $messageOK = "Action Done Successfully";
            } else {
                $messageErr = ucfirst($response->error);
            }

            echo "ok";
        }
    }

    public function allClient()
    {
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://172.17.0.2:4000/admin/auth/getClient',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);

        $i = 0;
        $users = array();

        foreach ($response as $key => $value) {
            if ($i >= 1) {
                //echo $value;
                $users = $value;
                //dump($value);
            }
            $i = $i + 1;
            //dump($key);
        }

        //dump($users);
        if (gettype($users) != "array") {
            //    echo "je t'aime";
            $users = array();
        }
        //dump($users);
        return view('admin/facture', ['users' => $users]);
    }

    public function addOneInvoice()
    {
        $message = null;
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://172.17.0.2:4000/admin/facture/getStaticInformation',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, true);
        //print_r($response);
        if (array_key_exists('result', $response)) {

            if (!empty($response['result'])) {

                $newIndex = $_POST['newIndex'];
                $date = $_POST['date'];
                $idClient = $_POST['userId'];
                $oldIndex = $_POST['oldIndex'];
                // echo $idClient;

                // je definie l'url de connexion.
                $url = "http://172.17.0.2:4000/admin/facture/" . $idClient;

                $data1 = array(
                    'newIndex' => $newIndex,
                    'oldIndex' => $oldIndex,
                    'dateReleveNewIndex' => $date
                );
                $data_json1 = json_encode($data1);

                $ch1 = curl_init();
                curl_setopt($ch1, CURLOPT_URL, $url);
                curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
                curl_setopt($ch1, CURLOPT_POST, 1);
                curl_setopt($ch1, CURLOPT_POSTFIELDS, $data_json1);
                curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
                $response1  = curl_exec($ch1);
                curl_close($ch1);
                $response1 = json_decode($response1, true);

                //dump($data_json1);
                if ($response1['status'] == 200) {
                    Session::flash('message', 'Invoice created!');
                    Session::flash('alert-class', 'alert-success');

                    $url = curl_init();
                    curl_setopt_array($url, array(
                        CURLOPT_URL => 'http://172.17.0.2:4000/admin/facture/doInvoiceWithDate/' . $date,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'GET',
                        CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
                    ));

                    $data = curl_exec($url);
                    $data = json_decode($data);
                    $users = array();
                    $users = $data->result;
                    // echo $date;
                    // dump($users);
                    return view('admin/facture', ['users' => $users, 'date' => $date]);
                } else {
                    Session::flash('message', ucfirst($response1['error']));
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->back();
                }
            } else {
                $messageErr = "Please entrer the static informations in the ";
                Session::flash('messageErr', $messageErr);
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
        } else {
            $message = "Something wrong happened";
            Session::flash('message', $message);
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
    }

    public function map()
    {
        return view('admin/maps');
    }

    public function createInvoice()
    {
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;
        // echo 'Bearer '.$tokenVal;
        // dump('Bearer '.$tokenVal);

        $date = session()->get('dateOfInvoices');

        $url = curl_init();
        curl_setopt_array($url, array(
            CURLOPT_URL => 'http://172.17.0.2:4000/admin/facture/doInvoiceWithDate/' . $date,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
        ));

        $response = curl_exec($url);
        $response = json_decode($response);

        // dump($response);
        $users = array();

        if ($response->status == 200) {
            $users = $response->result;
            return view('admin/facture', ['users' => $users, 'date' => $date]);
        } else {
            return redirect()->back();
        }
    }

    public function adminInvoiceInformation()
    {
        if (isset($_POST['submit'])) {
            $day = $_POST['day'];
            $month = $_POST['month'];
            $year = $_POST['year'];

            $time = strtotime($month . '/' . $day . '/' . $year);
            $date = date('Y-m-d', $time);
            session()->put('dateOfInvoices', $date);
            $url = "" . $date;

            $alltoken = $_COOKIE['token'];
            $alltokentab = explode(';', $alltoken);
            $token = $alltokentab[0];
            $tokentab = explode('=', $token);
            $tokenVal = $tokentab[1];
            $Authorization = 'Bearer ' . $tokenVal;
            $url = curl_init();
            curl_setopt_array($url, array(
                CURLOPT_URL => 'http://172.17.0.2:4000/admin/facture/doInvoiceWithDate/' . $date,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
            ));

            $response = curl_exec($url);
            $response = json_decode($response);

            // dump($response);
            $users = array();

            if ($response->status == 200) {
                $users = $response->result;
                return view('admin/facture', ['users' => $users, 'date' => $date]);
            } else {
                // Session::flash('message', ucfirst($response->error));
                // Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
        } else {
            return view('admin/addDateOfFacture');
        }
    }

    public function finance()
    {

        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        $url = "http://172.17.0.2:4000/admin/facture";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);
        $factures = $response['result'];


        $url1 = "http://172.17.0.2:4000/stock/getAll";
        $data1 = array(
            'page' => 1,
            'limit' => 0,
        );
        $data_json1 = json_encode($data1);
        $ch1 = curl_init();
        curl_setopt($ch1, CURLOPT_URL, $url1);
        curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch1, CURLOPT_POST, 1);
        curl_setopt($ch1, CURLOPT_POSTFIELDS, $data_json1);
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
        $response1  = curl_exec($ch1);
        curl_close($ch1);
        $response1 = json_decode($response1, true);
        $data1 = $response1['result']['docs'];


        $url2 = "http://172.17.0.2:4000/admin/facture/factureByYear/" . date('Y');
        $ch2 = curl_init();
        curl_setopt($ch2, CURLOPT_URL, $url2);
        curl_setopt($ch2, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        $response2  = curl_exec($ch2);
        curl_close($ch2);
        $response2 = json_decode($response2, true);
        $data2 = $response2['result'];

        $url3 = "http://172.17.0.2:4000/stock/getInputMaterialByYear/" . date('Y');
        $ch3 = curl_init();
        curl_setopt($ch3, CURLOPT_URL, $url3);
        curl_setopt($ch3, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
        $response3  = curl_exec($ch3);
        curl_close($ch3);
        $response3 = json_decode($response3, true);
        $data3 = $response3['result'];

        return view('admin/finances', ['factures' => $factures, 'materials' => $data1, 'yearBills' => $data2, 'materialsYear' => $data3]);
    }

    public function financeYear(Request $request)
    {

        $year = $request->input('year');

        if (!(empty($year))) {
            $year = $request->input('year');
        } else {
            $year = date('Y');
        }

        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        $url = "http://172.17.0.2:4000/admin/facture";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);
        $factures = $response['result'];


        $url1 = "http://172.17.0.2:4000/stock/getAll";
        $data1 = array(
            'page' => 1,
            'limit' => 0,
        );
        $data_json1 = json_encode($data1);

        $ch1 = curl_init();
        curl_setopt($ch1, CURLOPT_URL, $url1);
        curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch1, CURLOPT_POST, 1);
        curl_setopt($ch1, CURLOPT_POSTFIELDS, $data_json1);
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
        $response1  = curl_exec($ch1);
        curl_close($ch1);
        $response1 = json_decode($response1, true);
        $data1 = $response1['result']['docs'];


        $url2 = "http://172.17.0.2:4000/admin/facture/factureByYear/" . $year;
        $ch2 = curl_init();
        curl_setopt($ch2, CURLOPT_URL, $url2);
        curl_setopt($ch2, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        $response2  = curl_exec($ch2);
        curl_close($ch2);
        $response2 = json_decode($response2, true);
        $data2 = $response2['result'];

        $url3 = "http://172.17.0.2:4000/stock/getInputMaterialByYear/" . $year;
        $ch3 = curl_init();
        curl_setopt($ch3, CURLOPT_URL, $url3);
        curl_setopt($ch3, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
        $response3  = curl_exec($ch3);
        curl_close($ch3);
        $response3 = json_decode($response3, true);
        $data3 = $response3['result'];

        $url4 = "http://172.17.0.2:4000/admin/facture/factureByYear/" . date('Y');
        $ch4 = curl_init();
        curl_setopt($ch4, CURLOPT_URL, $url4);
        curl_setopt($ch4, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch4, CURLOPT_RETURNTRANSFER, true);
        $response4  = curl_exec($ch4);
        curl_close($ch4);
        $response4 = json_decode($response4, true);
        $data4 = $response4['result'];

        $url5 = "http://172.17.0.2:4000/stock/getInputMaterialByYear/" . date('Y');
        $ch5 = curl_init();
        curl_setopt($ch5, CURLOPT_URL, $url5);
        curl_setopt($ch5, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch5, CURLOPT_RETURNTRANSFER, true);
        $response5  = curl_exec($ch5);
        curl_close($ch5);
        $response5 = json_decode($response5, true);
        $data5 = $response5['result'];

        return view('admin/finances', ['factures' => $factures, 'materials' => $data1, 'reqYearBills' => $data2, 'reqYearMaterials' => $data3, 'yearBills' => $data4, 'materialsYear' => $data5, 'year' => $year]);
    }

    public function financeDetails()
    {

        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        $url = "http://172.17.0.2:4000/admin/auth/getClient";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);
        $customers = $response['result'];

        $url1 = "http://172.17.0.2:4000/stock/getAll";
        $data1 = array(
            'page' => 1,
            'limit' => 0,
        );
        $data_json1 = json_encode($data1);

        $ch1 = curl_init();
        curl_setopt($ch1, CURLOPT_URL, $url1);
        curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch1, CURLOPT_POST, 1);
        curl_setopt($ch1, CURLOPT_POSTFIELDS, $data_json1);
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
        $response1  = curl_exec($ch1);
        curl_close($ch1);
        $response1 = json_decode($response1, true);
        $data1 = $response1['result']['docs'];

        return view('admin/finances_details', ['customers' => $customers, 'materials' => $data1]);
    }

    public function customerDetails($id)
    {

        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        $url = "http://172.17.0.2:4000/admin/facture/clientFactureByYear/" . date('Y') . "/" . $id;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);
        $factures = $response['result'];


        $url1 = "http://172.17.0.2:4000/client/auth/" . $id;
        $ch1 = curl_init();
        curl_setopt($ch1, CURLOPT_URL, $url1);
        curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
        $response1 = curl_exec($ch1);
        curl_close($ch1);
        $response1 = json_decode($response1, true);
        $userdata = $response1['result'];

        return view('admin/finances_details_customer', ['factures' => $factures, 'userdata' => $userdata]);
    }

    public function customerDetailsYear($id, Request $request)
    {

        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        $year = $request->input('year');

        if (!(empty($year))) {
            $year = $request->input('year');
        } else {
            $year = date('Y');
        }

        $url = "http://172.17.0.2:4000/admin/facture/clientFactureByYear/" . $year . "/" . $id;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);
        $factures = $response['result'];


        $url1 = "http://172.17.0.2:4000/client/auth/" . $id;
        $ch1 = curl_init();
        curl_setopt($ch1, CURLOPT_URL, $url1);
        curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
        $response1 = curl_exec($ch1);
        curl_close($ch1);
        $response1 = json_decode($response1, true);
        $userdata = $response1['result'];

        return view('admin/finances_details_customer', ['facturesYear' => $factures, 'userdata' => $userdata, 'year' => $year]);
    }
}
