<?php

namespace App\Http\Controllers;

use App\Payment\MpesaGateway;
use Illuminate\Http\Request;

class MpesaPaymentController extends Controller
{
    public function deposite(Request $request, MpesaGateway $mpesaGateway )
    {
      
        $token = $mpesaGateway->get_access_token() ;
        $payment = $mpesaGateway->lipaNaMPesaOnlineAPI("0707585566", "200") ;
        return $payment ;


    }
}
