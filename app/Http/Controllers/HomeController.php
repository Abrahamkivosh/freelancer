<?php

namespace App\Http\Controllers;

use App\Job;
use App\JobProposal;
use App\Payment\MpesaGateway;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Mpesa;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // dd(auth()->user());

        if (Auth::user()->role_id == 1) {
            /*admin*/
            return view('home');
        } elseif (Auth::user()->role_id == 2) {
            /*freelancer*/
            return view('freelancer.dashboard');
        }
        /*client*/
        return view('client.dashboard');
    }

    public function wallet()
    {
        return view('wallet');
    }
    public function loadWallet(Request $request, MpesaGateway $mpesaGateway)
    {
        $user = Auth::user();
        $amount = $request->amount;
        $phone = $request->phone;


        try {
            $response = $mpesaGateway->lipaNaMPesaOnlineAPI($phone, $amount);

            $user->mpesa()->create([
                'user_id' => auth()->user()->id,
                'merchantRequestID' => $response['MerchantRequestID'],
                'checkoutRequestID' => $response['CheckoutRequestID'],
                'responseCode' => $response['ResponseCode'],
                'responseDescription' => $response['ResponseDescription'],
                'customerMessage' => $response['CustomerMessage'],
                'phoneNumber' => $phone,
                'amount' => $amount,
            ]);
            $user->deposit($amount);
            return back()->with('message', $response['CustomerMessage']);
        } catch (\Throwable $th) {
            return   back()->with('error', $th->getMessage());
        }
    }
    public function withdrawWallet(Request $request, MpesaGateway $mpesaGateway)
    {
        $user = Auth::user();
        $amount = $request->amount;
        $phone = $request->phone;
        $mpesa = $mpesaGateway->B2C($phone, $amount);
        $user->withdraw($amount);
        return redirect()->back()->with('message', 'Withdraw Successful');
    }

    public function handle_result(Request $request)
    {
        $data = $request->all();
        $data = $data['Body']['stkCallback'];
        $result = Mpesa::where('checkoutRequestID', $data['CheckoutRequestID'])->where('active', true)->first();
        $result->active = false;
        $result->result = json_encode($data);
        $result->save();
        $amount = 0;

        if ($result == null || $result->merchantRequestID != $data['MerchantRequestID'])
            return null;
        $result->resultCode = $data['ResultCode'];
        $result->resultDesc = $data['ResultDesc'];
        $result->save();
        if ($result->resultCode == 0) {
            $items = $data['CallbackMetadata']['Item'];
            foreach ($items as $item) {
                if ($item['Name'] == 'Amount' && array_key_exists('Value', $item))
                    $result->amount = $item['Value'];
                elseif ($item['Name'] == 'MpesaReceiptNumber' && array_key_exists('Value', $item))
                    $result->mpesaReceiptNumber = $item['Value'];
                elseif ($item['Name'] == 'Balance' && array_key_exists('Value', $item))
                    $result->balance = $item['Value'];
                elseif ($item['Name'] == 'TransactionDate' && array_key_exists('Value', $item))
                    $result->transactionDate = date('Y-m-d H:i:s', strtotime($item['Value']));
            }


            if ($result->save()) {
                auth()->user()->deposit($amount);
            }
        }
    }


    public function time_out_url(Request $request)
    {
        $result = Mpesa::create([
            'result' => $request

        ]);
    }


    public function withdraw_result(Request $request)
    {
        $data = $request->all();
        $data = $data['result'];
        $result = Mpesa::where('ConversationID', $data['ConversationID'])->first();
        $result->result = json_encode($data);
        $result->save();

        if ($result->ResultCode == 0) {
            $items = $data['ResultParameters']['ResultParameter'];
            foreach ($items as $item) {
                if ($item['key'] == 'TransactionAmount' && array_key_exists('Value', $item))
                    $result->amount = $item['Value'];
                elseif ($item['key'] == 'TransactionReceipt' && array_key_exists('Value', $item))
                    $result->TransactionID = $item['Value'];
                elseif ($item['key'] == 'ReceiverPartyPublicName' && array_key_exists('Value', $item))
                    $result->ReceiverPartyPublicName = $item['Value'];
                elseif ($item['key'] == 'TransactionCompletedDateTime' && array_key_exists('Value', $item))
                    $result->TransactionCompletedDateTime = date('Y-m-d H:i:s', strtotime($item['Value']));
            }
            $result->save();
        }
    }





    public function rate(Request $request)
    {
        $user = User::find($request->user);
        $user->rateOnce($request->rate);
    }

    public function download($file)
    {
        $prop = JobProposal::find($file);
        if ($prop->delivery_file != null) {
            return Storage::download($prop->delivery_file);
        }
        return redirect()->back();
    }
    public function downloadJob($file)
    {
        $prop = Job::find($file);

        if ($prop->file != null) {
            return Storage::download($prop->file);
        }
        return redirect()->back();
    }
}
