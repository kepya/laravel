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
            CURLOPT_URL => 'http://172.17.0.3:4000/admin/facture/getStaticInformation',
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

        if (array_key_exists('result', $response)) {
            if (!empty($response['result'])) {
                $newIndex = $_POST['newIndex'];
                $dateReleveNewIndex = $_POST['date'];
                $idClient = $_POST['userId'];
                $oldIndex = $_POST['oldIndex'];

                // je definie l'url de connexion.
                $url = "http://172.17.0.3:4000/admin/facture/" . $idClient;
                // je definie la donnée de ma facture.
                $facture = array(
                    'newIndex' => $newIndex,
                    'dateReleveNewIndex' => $dateReleveNewIndex,
                    'oldIndex' => $oldIndex,
                );


                $data_json = json_encode($facture);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response  = curl_exec($ch);

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
                CURLOPT_URL => 'http://172.17.0.3:4000/admin/facture/doInvoiceWithDate/' . $date,
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

        if (isset($_POST['reload'])) {
            $url = curl_init();
            curl_setopt_array($url, array(
                CURLOPT_URL => 'http://172.17.0.3:4000/admin/facture/userThatHaveNotPaidInvoiceWithDate/' . $date,
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

            $invoices = $response -> result;
            if ($invoices == null) {
                $invoices = [];
            }


            $page_en_cours = 0;
            $previous_page = 0;
            $size = 0;
            $hasPrevPage= false;
            $hasNextPage= false;
            $next_page= 0;

            return view('admin/facture', [
                'invoices' => $invoices,
                'date' => $date,
                'page_size' => $size,
                'page_en_cours' => $page_en_cours,
                'previous_page' => $previous_page,
                'hasPrevPage' => $hasPrevPage,
                'hasNextPage' => $hasNextPage,
                'next_page' => $next_page,
                'isSearch' => false,

                "username"=> "",
            ]);

        }

        return view('admin/facture', ['users' => $users, 'date' => $date]);
    }

    public function adminStatus()
    {
        $url = "http://172.17.0.3:4000/admin/facture/" . date("Y") . "/" . date("m") . "/100/1";
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
        $client = array();
        $lengthPaid = count($invoice['result']);
        for ($i = 0; $i < $lengthPaid; $i++) {
            $curl2 = curl_init();
            curl_setopt_array($curl2, array(
                CURLOPT_URL => 'http://172.17.0.3:4000/client/auth/' . $invoice['result'][$i]['idClient'],
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

        $url = "http://172.17.0.3:4000/stock/type";
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

        $url = "http://172.17.0.3:4000/stock/type";
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

        $url = "http://172.17.0.3:4000/stock/type";

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

            $url = "http://172.17.0.3:4000/stock/";
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

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response  = curl_exec($ch);
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
        }
    }

    public function adminRemove()
    {

        $url = "http://172.17.0.3:4000/stock/getAll";

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

        $url = "http://172.17.0.3:4000/stock/type";
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

        $url = "http://172.17.0.3:4000/stock/type/" . $id;
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

            $url = "http://172.17.0.3:4000/stock/type";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($response, true);
            $types = $response['result'];


            $url1 = "http://172.17.0.3:4000/stock/getByType";
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

        $url = "http://172.17.0.3:4000/stock/type";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);
        $types = $response['result'];


        $url1 = "http://172.17.0.3:4000/stock/getAll";
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

            $url = "http://172.17.0.3:4000/stock/" . $id;
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

        $url = "http://172.17.0.3:4000/admin/auth/" . $id;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);
        $userdata = $response['result'];

        $url1 = "http://172.17.0.3:4000/admin/facture/getStaticInformation";
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
        return view('admin/profile', ['data' => $userdata, 'static' => $static, 'index' => $index]);
    }

    public function adminEditProfile(Request $request)
    {

        $id = $request->session()->get('id');

        $url = "http://172.17.0.3:4000/admin/auth/" . $id;
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
            $home = empty($request->input('home')) ? "Not set" : $request->input('home');


            $url = "http://172.17.0.3:4000/admin/auth/update";
            $alltoken = $_COOKIE['token'];
            $alltokentab = explode(';', $alltoken);
            $token = $alltokentab[0];
            $tokentab = explode('=', $token);
            $tokenVal = $tokentab[1];
            $Authorization = 'Bearer ' . $tokenVal;

            $data = array(
                'name' => $name,
                'phone' => $phone,
                'email' => $email,
                "profileImage" => $photoPath,
                "description" => $home,
            );

            $data_json = json_encode($data);

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

            $url = "http://172.17.0.3:4000/admin/auth/updatePassword";
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

        $url = "http://172.17.0.3:4000/admin/facture/staticInformation";
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

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response);

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


        $url = "http://172.17.0.3:4000/admin/facture/penalty";
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

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response);

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

        $month = date("m");

        $page = 1;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://172.17.0.3:4000/admin/facture/factureByYear/' . $year,

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
                //array_push($invoices,$value);

            }
            $i = $i + 1;

        }

        $page_en_cours = $page_size;
        $previous_page = 1;
        $next_page = 1;

        $arrLength = count($invoices);


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
                array_push($invoicesWithPaginator, $invoices[$i]);
            }
        }

        if (gettype($invoices) != "array") {
            $invoices = array();
        }



        $client = array();

        foreach ($invoicesWithPaginator as $invoice) {

            $idClient = $invoice->idClient;
            $url = curl_init();
            curl_setopt_array($url, array(
                CURLOPT_URL => 'http://172.17.0.3:4000/client/auth/' . $idClient,
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


        $month = date("m");


        $page = 1;
        $invoices_paid = array();
        $invoices_unpaid = array();

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://172.17.0.3:4000/admin/facture/factureByYear/' . $year,

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

        if (gettype($invoices_paid) != "array") {
            $invoices_paid = array();
        }



        $client = array();

        foreach ($invoicesWithPaginator as $invoice) {

            $idClient = $invoice->idClient;
            $url = curl_init();
            curl_setopt_array($url, array(
                CURLOPT_URL => 'http://172.17.0.3:4000/client/auth/' . $idClient,
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
        return redirect()->route('ConsumptionUnPaidInvoices', ['page' => $page_size,
        'size' => $size]);
    }

    public function searchInvoicesWithPagination(Request $request)
    {
        $alltoken = $_COOKIE['token'];
            $alltokentab = explode(';', $alltoken);
            $token = $alltokentab[0];
            $tokentab = explode('=', $token);
            $tokenVal = $tokentab[1];
            $Authorization = 'Bearer ' . $tokenVal;

            $month = $request->month;
            $year = $request->year;
            $consumption = $request->consumption;
            $username = $request->username;
            $size = $request->size;
            $page = $request->page;
            $type = $request->type;
            $url ='';
            if(empty($month)){
                $month = 0;
            }

            if(empty($year)){
                $year = 0;
            }

            if(empty($consumption)){
                $consumption = 0;
            }

            if(empty($username)){
                $username = " ";
            }

            if(empty($size)){
                $size = 5;
            }

            if(empty($page)){
                $page = 1;
            }

            if (isset($_POST['previous_page'])) {
                $page = $page - 1;
            }

            if (isset($_POST['current_page'])) {

            }

            if (isset($_POST['next_page'])) {
                $page = $page + 1;
            }

            if ($type == "unpaid") {
                $url = "consumptionThatAreNotPaid";
            }

            if ($type == "paid") {
                $url = "consumptionThatArePaid";
            }

            if ($type == "all") {
                $url = "consumption";
            }

            $url = "http://172.17.0.3:4000/admin/facture/search/".$page."/".$size;
            $alltoken = $_COOKIE['token'];
            $alltokentab = explode(';', $alltoken);
            $token = $alltokentab[0];
            $tokentab = explode('=',$token);
            $tokenVal = $tokentab[1];
            $Authorization = 'Bearer '.$tokenVal;

            $data = array(
                "username"=> $username,
                "consumption"=>  intval($consumption),
                "year"=> intval($year),
                "month"=> intval($month),
                "type"=> $type,
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

            if ($response->status == 500) {
                return view('admin/'.$url, [
                    'invoices' => [],
                    'size' => 0,
                    'url' => "/admin/consumption-that-are-paid",
                    'page_en_cours' => 1,
                    'previous_page' => 1,
                    'hasPrevPage' => false,
                    'hasNextPage' => false,
                    'next_page' => 1,
                    'isSearch' => true,

                    "username"=> "",
                    "consumption"=>  0,
                    "year"=> 0,
                    "month"=> 0,
                ]);
            }

            $bill = $response-> result -> docs;
            $previous_page = $response-> result -> prevPage;
            $next_page = $response-> result -> nextPage;
            $hasPrevPage = $response-> result -> hasPrevPage;
            $hasNextPage = $response-> result -> hasNextPage;
            $page_en_cours = $response-> result -> page;
            $size = count($bill);

            return view('admin/'.$url, [
                'invoices' => $bill,
                'size' => $size,
                'url' => "/admin/consumption-that-are-unpaid",
                'page_en_cours' => $page_en_cours,
                'previous_page' => $previous_page,
                'hasPrevPage' => $hasPrevPage,
                'hasNextPage' => $hasNextPage,
                'next_page' => $next_page,

                "username"=> $username,
                'isSearch' => true,
                "consumption"=>  intval($consumption),
                "year"=> intval($year),
                "month"=> intval($month),
            ]);

    }

    //All Invoice that the admin have
    public function searchInvoices(Request $request)
    {
        // all Invoices
        if (isset($_POST['send_search'])) {
            $alltoken = $_COOKIE['token'];
            $alltokentab = explode(';', $alltoken);
            $token = $alltokentab[0];
            $tokentab = explode('=', $token);
            $tokenVal = $tokentab[1];
            $Authorization = 'Bearer ' . $tokenVal;

            $month = $request->month;
            $year = $request->year;
            $consumption = $request->consumption;
            $username = $request->username;
            $size = $request->size;
            $page = $request->page;

            if(empty($month)){
                $month = 0;
            }

            if(empty($year)){
                $year = 0;
            }

            if(empty($consumption)){
                $consumption = 0;
            }

            if(empty($username)){
                $username = " ";
            }

            if(empty($size)){
                $size = 5;
            }

            if(empty($page)){
                $page = 1;
            }

            $url = "http://172.17.0.3:4000/admin/facture/search/".$page."/".$size;
            $alltoken = $_COOKIE['token'];
            $alltokentab = explode(';', $alltoken);
            $token = $alltokentab[0];
            $tokentab = explode('=',$token);
            $tokenVal = $tokentab[1];
            $Authorization = 'Bearer '.$tokenVal;

            $data = array(
                "username"=> $username,
                "consumption"=>  intval($consumption),
                "year"=> intval($year),
                "month"=> intval($month),
                "type"=> "all",
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


            if ($response == null || $response->status == 500) {
                return view('admin/consumption', [
                    'invoices' => [],
                    'size' => 0,
                    'url' => "/admin/consumption",
                    'page_en_cours' => 1,
                    'previous_page' => 1,
                    'hasPrevPage' => false,
                    'hasNextPage' => false,
                    'next_page' => 1,
                    'isSearch' => false,

                    "username"=> "",
                    "consumption"=>  0,
                    "year"=> 0,
                    "month"=> 0,
                ]);
            }

            $bill = $response-> result -> docs;
            $previous_page = $response-> result -> prevPage;
            $next_page = $response-> result -> nextPage;
            $hasPrevPage = $response-> result -> hasPrevPage;
            $hasNextPage = $response-> result -> hasNextPage;
            $page_en_cours = $response-> result -> page;
            $size = count($bill);
            return view('admin/consumption', [
                'invoices' => $bill,
                'size' => $size,
                'url' => "/admin/consumption",
                'page_en_cours' => $page_en_cours,
                'previous_page' => $previous_page,
                'hasPrevPage' => $hasPrevPage,
                'hasNextPage' => $hasNextPage,
                'next_page' => $next_page,

                "username"=> $username,
                'isSearch' => true,
                "consumption"=>  intval($consumption),
                "year"=> intval($year),
                "month"=> intval($month),
            ]);
        }
        if (isset($_POST['send_pagination'])) {
            $size = $_POST['select_size'];
            $page = 1;

            return redirect()->route('allInvoices', ['page' => $page,'size' => $size]);
        }

        // all consumption that are paid
        if (isset($_POST['send_search_consumption_paid'])){
            $alltoken = $_COOKIE['token'];
            $alltokentab = explode(';', $alltoken);
            $token = $alltokentab[0];
            $tokentab = explode('=', $token);
            $tokenVal = $tokentab[1];
            $Authorization = 'Bearer ' . $tokenVal;

            $month = $request->month;
            $year = $request->year;
            $consumption = $request->consumption;
            $username = $request->username;
            $size = $request->size;
            $page = $request->page;

            if(empty($month)){
                $month = 0;
            }

            if(empty($year)){
                $year = 0;
            }

            if(empty($consumption)){
                $consumption = 0;
            }

            if(empty($username)){
                $username = " ";
            }

            if(empty($size)){
                $size = 5;
            }

            if(empty($page)){
                $page = 1;
            }

            $url = "http://172.17.0.3:4000/admin/facture/search/".$page."/".$size;
            $alltoken = $_COOKIE['token'];
            $alltokentab = explode(';', $alltoken);
            $token = $alltokentab[0];
            $tokentab = explode('=',$token);
            $tokenVal = $tokentab[1];
            $Authorization = 'Bearer '.$tokenVal;

            $data = array(
                "username"=> $username,
                "consumption"=>  intval($consumption),
                "year"=> intval($year),
                "month"=> intval($month),
                "type"=> "paid",
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

            if ($response == null || $response->status == 500) {
                return view('admin/consumptionThatArePaid', [
                    'invoices' => [],
                    'size' => 0,
                    'url' => "/admin/consumption-that-are-paid",
                    'page_en_cours' => 1,
                    'previous_page' => 1,
                    'hasPrevPage' => false,
                    'hasNextPage' => false,
                    'next_page' => 1,
                    'isSearch' => false,

                    "username"=> "",
                    "consumption"=>  0,
                    "year"=> 0,
                    "month"=> 0,
                ]);
            }

            $bill = $response-> result -> docs;
            $previous_page = $response-> result -> prevPage;
            $next_page = $response-> result -> nextPage;
            $hasPrevPage = $response-> result -> hasPrevPage;
            $hasNextPage = $response-> result -> hasNextPage;
            $page_en_cours = $response-> result -> page;
            $size = count($bill);
            return view('admin/consumptionThatArePaid', [
                'invoices' => $bill,
                'size' => $size,
                'url' => "/admin/consumption-that-are-paid",
                'page_en_cours' => $page_en_cours,
                'previous_page' => $previous_page,
                'hasPrevPage' => $hasPrevPage,
                'hasNextPage' => $hasNextPage,
                'next_page' => $next_page,

                "username"=> $username,
                'isSearch' => true,
                "consumption"=>  intval($consumption),
                "year"=> intval($year),
                "month"=> intval($month),
            ]);
        }

        if (isset($_POST['send_pagination_consumption_paid'])) {
            $size = $_POST['select_size'];
            $page = 1;

            return redirect()->route('ConsumptionPaidInvoices', ['page' => $page,'size' => $size]);
        }

        // all consumption that are unpaid
        if (isset($_POST['send_search_consumption_unpaid'])) {
            $alltoken = $_COOKIE['token'];
            $alltokentab = explode(';', $alltoken);
            $token = $alltokentab[0];
            $tokentab = explode('=', $token);
            $tokenVal = $tokentab[1];
            $Authorization = 'Bearer ' . $tokenVal;

            $month = $request->month;
            $year = $request->year;
            $consumption = $request->consumption;
            $username = $request->username;
            $size = $request->size;
            $page = $request->page;

            if(empty($month)){
                $month = 0;
            }

            if(empty($year)){
                $year = 0;
            }

            if(empty($consumption)){
                $consumption = 0;
            }

            if(empty($username)){
                $username = " ";
            }

            if(empty($size)){
                $size = 5;
            }

            if(empty($page)){
                $page = 1;
            }

            $url = "http://172.17.0.3:4000/admin/facture/search/".$page."/".$size;
            $alltoken = $_COOKIE['token'];
            $alltokentab = explode(';', $alltoken);
            $token = $alltokentab[0];
            $tokentab = explode('=',$token);
            $tokenVal = $tokentab[1];
            $Authorization = 'Bearer '.$tokenVal;

            $data = array(
                "username"=> $username,
                "consumption"=>  intval($consumption),
                "year"=> intval($year),
                "month"=> intval($month),
                "type"=> "unpaid",
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

            if ($response == null || $response->status == 500) {
                return view('admin/consumptionThatAreNotPaid', [
                    'invoices' => [],
                    'size' => 0,
                    'url' => "/admin/consumption-that-are-unpaid",
                    'page_en_cours' => 1,
                    'previous_page' => 1,
                    'hasPrevPage' => false,
                    'hasNextPage' => false,
                    'next_page' => 1,
                    'isSearch' => false,

                    "username"=> "",
                    "consumption"=>  0,
                    "year"=> 0,
                    "month"=> 0,
                ]);
            }

            $bill = $response-> result -> docs;
            $previous_page = $response-> result -> prevPage;
            $next_page = $response-> result -> nextPage;
            $hasPrevPage = $response-> result -> hasPrevPage;
            $hasNextPage = $response-> result -> hasNextPage;
            $page_en_cours = $response-> result -> page;
            $size = count($bill);
            return view('admin/consumptionThatAreNotPaid', [
                'invoices' => $bill,
                'size' => $size,
                'url' => "/admin/consumption-that-are-unpaid",
                'page_en_cours' => $page_en_cours,
                'previous_page' => $previous_page,
                'hasPrevPage' => $hasPrevPage,
                'hasNextPage' => $hasNextPage,
                'next_page' => $next_page,

                "username"=> $username,
                'isSearch' => true,
                "consumption"=>  intval($consumption),
                "year"=> intval($year),
                "month"=> intval($month),
            ]);
        }

        if (isset($_POST['send_pagination_consumption_unpaid'])) {
            $size = $_POST['select_size'];
            $page = 1;

            return redirect()->route('ConsumptionUnPaidInvoices', ['page' => $page,'size' => $size]);
        }
    }

    public function allInvoices(Request $request)
    {
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        $size = $request->size;
        $page = $request->page;

        if(isset($size)){
            if (empty($size)) {
                $size = 5;
            }
        } else {
            $size = 5;
        }

        if(isset($page)){
            if (empty($page)) {
                $page = 1;
            }
        } else {
            $page = 1;
        }
        $url = "http://172.17.0.3:4000/admin/facture/search/".$page."/".$size;

        $data = array(
            "type"=> "all",
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
        if ($response->status == 500) {
            return view('admin/consumption', [
                'invoices' => [],
                'size' => 0,
                'url' => "/admin/consumption",
                'page_en_cours' => 1,
                'previous_page' => 1,
                'hasPrevPage' => false,
                'hasNextPage' => false,
                'next_page' => 1,
                'isSearch' => false,

                "username"=> "",
                "consumption"=>  0,
                "year"=> 0,
                "month"=> 0,
            ]);
        }

        $bill = $response-> result -> docs;
        $previous_page = $response-> result -> prevPage;
        $next_page = $response-> result -> nextPage;
        $hasPrevPage = $response-> result -> hasPrevPage;
        $hasNextPage = $response-> result -> hasNextPage;
        $page_en_cours = $response-> result -> page;
        $size = count($bill);

        return view('admin/consumption', [
            'invoices' => $bill,
            'size' => $size,
            'url' => "/admin/consumption",
            'page_en_cours' => $page_en_cours,
            'previous_page' => $previous_page,
            'hasPrevPage' => $hasPrevPage,
            'hasNextPage' => $hasNextPage,
            'next_page' => $next_page,
            'isSearch' => false,

            "username"=> "",
            "consumption"=>  0,
            "year"=> 0,
            "month"=> 0,
        ]);
    }

    public function allUnPaidClients(Request $request, $page=0, $size=0)
    {
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        if($page=0 || $size=0){
            $size = $request->limit;
            $page = $request->page;
        }


        if (isset($request->entrySize)){
            $size = $request->entrySize;
        }

        if (empty($size)) {
            $size = 10;
        }

        if (empty($page)) {
            $page = 1;
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://172.17.0.3:4000/admin/auth/getClientsWithTotalCostUnpaidWithPagination/'.$page.'/'.$size,
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

        return view('admin/consumptionThatAreNotPaid', [
            'response' => $response,
            'size' => $size,
            'page' => $page
        ]);
    }

    public function allUnPaidInvoices($id){

        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://172.17.0.3:4000/admin/facture/getTotalUnpaidInvoiceByClient/'.$id,
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

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://172.17.0.3:4000/client/auth/'.$id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
        ));

        $response2 = curl_exec($curl);
        curl_close($curl);
        $response2 = json_decode($response2);

        return view('admin/consumptionThatAreNotPaidClient', [
            'unPaidInvoices' => $response->result->unPaidInvoices,
            'userInfo' => $response2->result
        ]);
    }

    public function searchUnpaidCustomer(Request $request){

        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        $size = $request->limit;
        $page = $request->page;
        $name = $request->name;

        if(!empty($name)){

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://172.17.0.3:4000/admin/auth/getClientsWithTotalCostUnpaid',
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

            $result = $response -> result;

            $customers = array();

            // print_r($result);

            foreach ($result as $result) {
                $user = $result->client;
                $unPaidAmount = $result->unpaidAmount;
                $username = $user -> name;
                if(strpos($username, $name) !== false){
                    //echo "Word Found!";
                    array_push($customers, ['client'=>$user, 'unPaidAmount'=>$unPaidAmount]);
                } else{
                    //echo "Word Not Found!";
                }
            }

            $response = [
                'status' => '200',
                "search" => 'search',
                "result" => json_decode(json_encode($customers), true)
            ];

            return view('admin/consumptionThatAreNotPaid', [
                'response2' => $response,
                'size' => $size,
                'page' => $page
            ]);

        }else{

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://172.17.0.3:4000/admin/auth/getClientsWithTotalCostUnpaidWithPagination/'.$page.'/'.$size,
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

            return view('admin/consumptionThatAreNotPaid', [
                'response' => $response,
                'size' => $size,
                'page' => $page
            ]);
        }

    }

    public function payBill(Request $request){

        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        $id = $request->id;
        $page = $request->page;
        $size = $request->size;
        $amount = $request->amount;

        $url = "http://172.17.0.3:4000/admin/facture/payFactureByUser/".$id;

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

        $response = json_decode($response);

        $messageOK = null;
        $messageErr = null;

        if ($response->status == 200) {
            $messageOK = "Action Done Successfully";
        } else {
            $messageErr = ucfirst($response->error);
        }

        //Users with unpaid Bills
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://172.17.0.3:4000/admin/auth/getClientsWithTotalCostUnpaidWithPagination/'.$page.'/'.$size,
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


        return view('admin/consumptionThatAreNotPaid', [
            'response' => $response,
            'size' => $size,
            'page' => $page,
            'messageOk' => $messageOK,
            'messageErr' => $messageErr
        ]);

    }

    public function allPaidInvoices(Request $request)
    {
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        $size = $request->size;
        $page = $request->page;

        if(isset($size)){
            if (empty($size)) {
                $size = 5;
            }
        } else {
            $size = 5;
        }

        if(isset($page)){
            if (empty($page)) {
                $page = 1;
            }
        } else {
            $page = 1;
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://172.17.0.3:4000/admin/facture/getByStatusWithPagination/true/'.$page.'/'.$size,
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

        if ($response->status == 500) {
            return view('admin/consumptionThatArePaid', [
                'invoices' => [],
                'size' => 0,
                'url' => "/admin/consumption-that-are-paid",
                'page_en_cours' => 1,
                'previous_page' => 1,
                'hasPrevPage' => false,
                'hasNextPage' => false,
                'next_page' => 1,
                'isSearch' => false,

                "username"=> "",
                "consumption"=>  0,
                "year"=> 0,
                "month"=> 0,
            ]);
        }
        $bill = $response-> result -> docs;
        $previous_page = $response-> result -> prevPage;
        $next_page = $response-> result -> nextPage;
        $hasPrevPage = $response-> result -> hasPrevPage;
        $hasNextPage = $response-> result -> hasNextPage;
        $page_en_cours = $response-> result -> page;
        $size = count($bill);

        return view('admin/consumptionThatArePaid', [
            'invoices' => $bill,
            'size' => $size,
            'url' => "/admin/consumption-that-are-paid",
            'page_en_cours' => $page_en_cours,
            'previous_page' => $previous_page,
            'hasPrevPage' => $hasPrevPage,
            'hasNextPage' => $hasNextPage,
            'next_page' => $next_page,
            'isSearch' => false,

            "username"=> "",
            "consumption"=>  0,
            "year"=> 0,
            "month"=> 0,
        ]);
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
            CURLOPT_URL => 'http://172.17.0.3:4000/admin/facture/one/' . $invoice_id,
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

        $curl2 = curl_init();
        curl_setopt_array($curl2, array(
            CURLOPT_URL => 'http://172.17.0.3:4000/client/auth/' . $invoice['result']['idClient'],
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
            CURLOPT_URL => 'http://172.17.0.3:4000/admin/auth/' . $invoice['result']['idAdmin'],
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

        // dd($invoice);

        $pdf = PDF::loadView('facturePdf/generator', ['invoice' => $invoice, 'client' => $client, 'admin' => $admin]);
        return $pdf->download('facture-' . $client['result']['name'] . '-' . date('F') . '.pdf');;
    }

    public function detailInvoive($invoice_id)
    {
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://172.17.0.3:4000/admin/facture/one/' . $invoice_id,
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


                $invoice = $value;

            }
            $i = $i + 1;

        }

        if (gettype($invoice) != "array" && gettype($invoice) != "object") {

            $invoice = array();
        }


        if ($invoice->idClient != null) {
            $client = array();

            $idClient = $invoice->idClient;
            $url = curl_init();
            curl_setopt_array($url, array(
                CURLOPT_URL => 'http://172.17.0.3:4000/client/auth/' . $idClient,
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
                    $client = $value;
                }
                $i = $i + 1;
            }

            curl_close($url);
        }

        return view(
            'admin/detailInvoice',
            [
                'invoice' => $invoice,
                'client' => $client,
                'show' => false,
            ]
        );
    }

    public function deleteInvoive($invoice_id)
    {
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://172.17.0.3:4000/admin/facture/remove/' . $invoice_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => array('Authorization: ' . $Authorization),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
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

        // return redirect()->route('/admin/consumption-that-are-unpaid');
    }

    public function getClientByInvoices($invoice_id, $client_id)
    {
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;


        if ($client_id != null) {
            $client = array();

            $idClient = $client_id;
            $url = curl_init();
            curl_setopt_array($url, array(
                CURLOPT_URL => 'http://172.17.0.3:4000/client/auth/' . $client_id,
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
                    $client = $value;
                }
                $i = $i + 1;
            }

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
            CURLOPT_URL => 'http://172.17.0.3:4000/admin/facture/getByStatus/false',
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

        $year = date("Y");

        $month = date("m");

        foreach ($response as $key => $value) {
            if ($i >= 1) {
                $invoicesAdvenced = $value;
            }
            $i = $i + 1;
        }

        if (gettype($invoicesAdvenced) != "array") {
            $invoicesAdvenced = array();
        }

        $client = array();

        foreach ($invoicesAdvenced as $invoice) {

            $idClient = $invoice->idClient;
            $url = curl_init();
            curl_setopt_array($url, array(
                CURLOPT_URL => 'http://172.17.0.3:4000/client/auth/' . $idClient,
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

        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_URL => 'http://172.17.0.3:4000/admin/facture/' . $year . '/' . $month . '/1000/1',
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
                    CURLOPT_URL => 'http://172.17.0.3:4000/client/auth/' . $idClient,
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
            CURLOPT_URL => 'http://172.17.0.3:4000/admin/auth/getClient',
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

        // annuel
        $url_annuel = curl_init();
        curl_setopt_array($url_annuel, array(
            CURLOPT_URL => 'http://172.17.0.3:4000/admin/facture/factureByYear/' . $year,
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
            CURLOPT_URL => 'http://172.17.0.3:4000/admin/facture/' . $idClient,
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
                $invoices = $value;
            }
            $i = $i + 1;
        }

        return view('client/consumption', ['invoices' => $invoices]);
    }

    //finish to paid invoice
    public function finishToPaidInvoice()
    {
        if (isset($_POST['connect'])) {
            $amount = $_POST['amount'];
            $invoice_id = $_POST['idInvoice'];

            $url = "http://172.17.0.3:4000/admin/facture/statusPaidFacture/" . $invoice_id;
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
                CURLOPT_URL => 'http://172.17.0.3:4000/admin/facture/one/' . $invoice_id,
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
                    $invoice = $value;
                }
                $i = $i + 1;
            }

            if (gettype($invoice) != "array" && gettype($invoice) != "object") {
                $invoice = array();
            }

            if ($invoice->idClient != null) {
                $client = array();

                $idClient = $invoice->idClient;
                $url = curl_init();
                curl_setopt_array($url, array(
                    CURLOPT_URL => 'http://172.17.0.3:4000/client/auth/' . $idClient,
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
                        $client = $value;
                    }
                    $i = $i + 1;
                }
            }
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
        if (isset($_POST['connect'])) {
            $url = "http://172.17.0.3:4000/admin/facture/one/" . $invoice_id;
            $alltoken = $_COOKIE['token'];
            $alltokentab = explode(';', $alltoken);
            $token = $alltokentab[0];
            $tokentab = explode('=', $token);
            $tokenVal = $tokentab[1];
            $Authorization = 'Bearer ' . $tokenVal;

            $newIndex = $_POST['newIndex'];
            $dateSpicy = $_POST['dateSpicy'];

            $facture = array(
                "newIndex"  => intval($newIndex),
                // "montantVerse"  => intval($amountPaid),
                "dateReleveNewIndex"  => $dateSpicy
            );

            $data_json = json_encode($facture);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: '.$Authorization));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response  = curl_exec($ch);
            curl_close($ch);

            $messageErr = null;
            $messageOK = null;

            $response = json_decode($response);

            if ($response->status == 200) {
                $messageOK = "Action Done Successfully";
                Session::flash('message', 'Invoice updated!');
                Session::flash('alert-class', 'alert-success');
            } else {
                $messageErr = ucfirst($response->error);
                Session::flash('message', ucfirst($response['error']));
                Session::flash('alert-class', 'alert-danger');
            }
        }
        return redirect()->back();
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
            CURLOPT_URL => 'http://172.17.0.3:4000/admin/auth/getClient',
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
                $users = $value;
            }
            $i = $i + 1;
        }

        if (gettype($users) != "array") {
            $users = array();
        }
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


        $newIndex = $_POST['newIndex'];
        $date = $_POST['date'];
        $idClient = $_POST['userId'];
        if (isset($_POST['oldIndex'])) {
            $oldIndex = $_POST['oldIndex'];
        } else {
            $oldIndex = 0;
        }

        $meter = $_POST['meter'];

        // je definie l'url de connexion.
        $url = "http://172.17.0.3:4000/admin/facture/" . $idClient;

        $data1 = array(
            'idCompteur'=> $meter,
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

        if ($response1['status'] == 200) {
            Session::flash('message', 'Invoice created!');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', ucfirst($response1['error']));
            Session::flash('alert-class', 'alert-danger');
        }


        $url = curl_init();
        curl_setopt_array($url, array(
            CURLOPT_URL => 'http://172.17.0.3:4000/admin/facture/userThatHaveNotPaidInvoiceWithDate/' . $date,
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

        //print_r($response);

        $invoices = $response -> result;
        if ($invoices == null) {
            $invoices = [];
        }

        return view('admin/facture', ['invoices' => $invoices, 'date' => $date]);
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

        $date = session()->get('dateOfInvoices');

        $url = curl_init();
        curl_setopt_array($url, array(
            CURLOPT_URL => 'http://172.17.0.3:4000/admin/facture/doInvoiceWithDate/' . $date,
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

        $users = array();

        if ($response->status == 200) {
            $users = $response->result;
            return view('admin/facture', ['users' => $users, 'date' => $date]);
        } else {
            return redirect()->back();
        }
    }

    public function adminInvoiceInformation(Request $request, $page=1, $size=6)
    {
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        if (isset($_POST['submit'])) {
            $day = $_POST['day'];
            $month = $_POST['month'];
            $year = $_POST['year'];

            if ($year <= date('Y')) {
                if ($month <= date('m')) {
                    $time = strtotime($month . '/' . $day . '/' . $year);
                    $date = date('Y-m-d', $time);
                    session()->put('dateOfInvoices', $date);
                    $url = "" . $date;

                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'http://172.17.0.3:4000/admin/facture/getStaticInformation',
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

                    if(array_key_exists('result',$response)){

                        if (!empty($response['result'])) {
                            try {
                                $url = curl_init();
                                curl_setopt_array($url, array(
                                    CURLOPT_URL => 'http://172.17.0.3:4000/admin/facture/userThatHaveNotPaidInvoiceWithDate/' . $date . '/' . $page . '/' . $size,
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

                                $invoices = $response-> result -> docs;
                                $previous_page = $response-> result -> prevPage;
                                $next_page = $response-> result -> nextPage;
                                $hasPrevPage = $response-> result -> hasPrevPage;
                                $hasNextPage = $response-> result -> hasNextPage;
                                $page_en_cours = $response-> result -> page;

                                if ($invoices == null) {
                                    $invoices = [];
                                }

                                return view('admin/facture', [
                                    'invoices' => $invoices,
                                    'date' => $date,
                                    'page_size' => $size,
                                    'page_en_cours' => $page_en_cours,
                                    'previous_page' => $previous_page,
                                    'hasPrevPage' => $hasPrevPage,
                                    'hasNextPage' => $hasNextPage,
                                    'next_page' => $next_page,
                                    'isSearch' => false,
                                    'url' => '/admin/addInvoice',
                                    "username"=> "",
                                ]);
                            } catch (Exception $e) {
                                Session::flash('messageErr', $e->getMessage());
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
            }

            $message = "You cannot create invoice with date greater than date of today";
            Session::flash('message', $message);
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }

        if (isset($_POST['paginate_invoice']) || isset($_POST['reload']) || isset($_POST['previous_page'])
        || isset($_POST['next_page']) || isset($_POST['current_page']) || isset($_POST['search'])){

            $date = $request->date;
            $page_size = $request->page_size;
            $page_en_cours = $request->page_en_cours;
            $username = $request->username;

            if ($page_en_cours || $page_en_cours == null || $page_en_cours == "") {
                $page_en_cours = $page;
            }

            if ($page_size || $page_size == null || $page_size == "") {
                $page_size = $size;
            }

            if(isset($_POST['reload'])) {
                $page =  1;
                $username = "";
            }

            if(isset($_POST['previous_page'])) {
                $page = $page - 1;
            }

            if(isset($_POST['next_page'])) {
                $page = $page + 1;
            }

            if (($username != '' && $username != null) || isset($request->name)) {
                if (isset($request->name) && $request->name != '' && $request->name != null) {
                    $username = $request->name;
                }

                $find = array(
                    'username' => $username
                );
                $data_json = json_encode($find);
                try {
                    $url = 'http://172.17.0.3:4000/admin/facture/userThatHaveNotPaidInvoiceWithDate/' . $date . '/' . $page . '/' . $page_size;
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response  = curl_exec($ch);
                    curl_close($ch);

                    $response = json_decode($response);
                    if ($response->status == 200) {
                        $invoices = $response-> result -> docs;
                        $previous_page = $response-> result -> prevPage;
                        $next_page = $response-> result -> nextPage;
                        $hasPrevPage = $response-> result -> hasPrevPage;
                        $hasNextPage = $response-> result -> hasNextPage;
                        $page_en_cours = $response-> result -> page;

                        if ($invoices == null) {
                            $invoices = [];
                        }

                        return view('admin/facture', [
                            'invoices' => $invoices,
                            'date' => $date,
                            'page_size' => $page_size,
                            'page_en_cours' => $page_en_cours,
                            'previous_page' => $previous_page,
                            'hasPrevPage' => $hasPrevPage,
                            'hasNextPage' => $hasNextPage,
                            'next_page' => $next_page,
                            'isSearch' => true,
                            'url' => '/admin/addInvoice',
                            "username"=> $username,
                        ]);

                    } else {
                        Session::flash('message', ucfirst($response->error));
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->back();
                    }
                } catch (Exception $e) {
                    Session::flash('messageErr', $e->getMessage());
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->back();
                }
            } else {
                try {
                    $url = curl_init();
                    curl_setopt_array($url, array(
                        CURLOPT_URL => 'http://172.17.0.3:4000/admin/facture/userThatHaveNotPaidInvoiceWithDate/' . $date . '/' . $page . '/' . $page_size,
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

                    $invoices = $response-> result -> docs;
                    $previous_page = $response-> result -> prevPage;
                    $next_page = $response-> result -> nextPage;
                    $hasPrevPage = $response-> result -> hasPrevPage;
                    $hasNextPage = $response-> result -> hasNextPage;
                    $page_en_cours = $response-> result -> page;

                    if ($invoices == null) {
                        $invoices = [];
                    }

                    return view('admin/facture', [
                        'invoices' => $invoices,
                        'date' => $date,
                        'page_size' => $page_size,
                        'page_en_cours' => $page_en_cours,
                        'previous_page' => $previous_page,
                        'hasPrevPage' => $hasPrevPage,
                        'hasNextPage' => $hasNextPage,
                        'next_page' => $next_page,
                        'isSearch' => false,
                        'url' => '/admin/addInvoice',
                        "username"=> "",
                    ]);
                } catch (Exception $e) {
                    Session::flash('messageErr', $e->getMessage());
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->back();
                }
            }
        }

        return view('admin/addDateOfFacture');
    }

    public function finance()
    {
        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        $url = "http://172.17.0.3:4000/admin/facture";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);
        $factures = $response['result'];


        $url1 = "http://172.17.0.3:4000/stock/getAll";
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


        $url2 = "http://172.17.0.3:4000/admin/facture/factureByYear/" . date('Y');
        $ch2 = curl_init();
        curl_setopt($ch2, CURLOPT_URL, $url2);
        curl_setopt($ch2, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        $response2  = curl_exec($ch2);
        curl_close($ch2);
        $response2 = json_decode($response2, true);
        $data2 = $response2['result'];

        $url3 = "http://172.17.0.3:4000/stock/getInputMaterialByYear/" . date('Y');
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

        $url = "http://172.17.0.3:4000/admin/facture";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);
        $factures = $response['result'];


        $url1 = "http://172.17.0.3:4000/stock/getAll";
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


        $url2 = "http://172.17.0.3:4000/admin/facture/factureByYear/" . $year;
        $ch2 = curl_init();
        curl_setopt($ch2, CURLOPT_URL, $url2);
        curl_setopt($ch2, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        $response2  = curl_exec($ch2);
        curl_close($ch2);
        $response2 = json_decode($response2, true);
        $data2 = $response2['result'];

        $url3 = "http://172.17.0.3:4000/stock/getInputMaterialByYear/" . $year;
        $ch3 = curl_init();
        curl_setopt($ch3, CURLOPT_URL, $url3);
        curl_setopt($ch3, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
        $response3  = curl_exec($ch3);
        curl_close($ch3);
        $response3 = json_decode($response3, true);
        $data3 = $response3['result'];

        $url4 = "http://172.17.0.3:4000/admin/facture/factureByYear/" . date('Y');
        $ch4 = curl_init();
        curl_setopt($ch4, CURLOPT_URL, $url4);
        curl_setopt($ch4, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch4, CURLOPT_RETURNTRANSFER, true);
        $response4  = curl_exec($ch4);
        curl_close($ch4);
        $response4 = json_decode($response4, true);
        $data4 = $response4['result'];

        $url5 = "http://172.17.0.3:4000/stock/getInputMaterialByYear/" . date('Y');
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

        $url = "http://172.17.0.3:4000/admin/auth/client/1/10";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);

        $url1 = "http://172.17.0.3:4000/stock/getAll";
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

        return view('admin/finances_details', ['response' => $response, 'materials' => $data1]);
    }

    public function financeDetailSearch(Request $request){
        $page = $request->page;

        $url = "http://172.17.0.3:4000/admin/auth/client/".$page."/10";
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

        $url1 = "http://172.17.0.3:4000/stock/getAll";
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

        return view('admin/finances_details', ['response' => $response, 'materials' => $data1]);
    }

    public function financeDetailSearchByPage($page)
    {
        $url = "http://172.17.0.3:4000/admin/auth/client/".$page."/10";
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

        $url1 = "http://172.17.0.3:4000/stock/getAll";
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

        return view('admin/finances_details', ['response' => $response, 'materials' => $data1]);
    }

    public function customerDetails($id)
    {

        $alltoken = $_COOKIE['token'];
        $alltokentab = explode(';', $alltoken);
        $token = $alltokentab[0];
        $tokentab = explode('=', $token);
        $tokenVal = $tokentab[1];
        $Authorization = 'Bearer ' . $tokenVal;

        $url = "http://172.17.0.3:4000/admin/facture/clientFactureByYear/" . date('Y') . "/" . $id;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);
        $factures = $response['result'];


        $url1 = "http://172.17.0.3:4000/client/auth/" . $id;
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

        $url = "http://172.17.0.3:4000/admin/facture/clientFactureByYear/" . $year . "/" . $id;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'authorization: ' . $Authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);
        $factures = $response['result'];


        $url1 = "http://172.17.0.3:4000/client/auth/" . $id;
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
