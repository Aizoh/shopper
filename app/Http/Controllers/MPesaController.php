<?php

namespace App\Http\Controllers;

use App\Models\MPesa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Throwable;

use function Laravel\Prompts\alert;

class MPesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MPesa $mPesa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MPesa $mPesa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MPesa $mPesa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MPesa $mPesa)
    {
        //
    }

    public function EncryptData()
    {
        $fp = fopen("/var/www/html/quezesha/public/ProductionCertificate.cer", "r");
        $pub_key = fread($fp, 8192);
        fclose($fp);
        $source = "QHLCl@im@R00ts";

        openssl_public_encrypt($source, $crypttext, $pub_key);

        return (base64_encode($crypttext));
    }


    public function generateAccessToken()
    {

        //sandbox

        // $consumer_key="JIzNoAwTaZ0co2wzx9pJBrG3JGEKVGyd";
        // $consumer_secret="y99iAqN5TA3COs1c";

        //Live
        $consumer_key = "2dBIOmc6ljdLwYzobPuqV71dTbtJLAWi";
        $consumer_secret = "bWhWO8jPjL9izpxO";

        //  $consumer_key="rB4oAQtG6NKQHL7Rm7xDC49n33rZkjOUOZyprWzJtznL25fK";
        //  $consumer_secret="dFwvRMNOkxbTydmNXPoBhK1jzcqEYPJfHdDua7GAAAP8FdjLXAHVpG4VvDOtx7Lq";

        $credentials = base64_encode($consumer_key . ":" . $consumer_secret);
        $url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
        // $url = "https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Basic " . $credentials));
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);

        $access_token = json_decode($curl_response);
        return $access_token->access_token;
    }

    public function lipaNaMpesaPassword()
    {
        // $lipa_time = Carbon::rawParse('now')->format('YmdHms');
        $lipa_time = Carbon::now()->format('YmdHis');
        // $passkey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";      
        // $BusinessShortCode = 174379; //sandbox

        $passkey = '241dfdba7670d0d10e09fea37ff2b660f7d335ca10229584fcf43bbf7dea36ea';
        $BusinessShortCode = 4081653; //live

        $timestamp = $lipa_time;
        $lipa_na_mpesa_password = base64_encode($BusinessShortCode . $passkey . $timestamp);
        return $lipa_na_mpesa_password;
    }

    public function MpesaSTKPush($phone, $amount, $id)
    {
        $validator = Validator::make(
            [
                'phone' => $phone,
                'amount' => $amount,
            ],
            [
                'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:12',
                'amount' => 'required|numeric|min:1',
            ]
        );

        // Sanitize phone number (remove spaces or dashes, format properly)
        $phone = preg_replace('/[^0-9]/', '', $phone); // Strip non-numeric characters
        if (substr($phone, 0, 1) === '0') {
            $phone = '254' . substr($phone, 1); // Convert 07XXXXXXX to 2547XXXXXXX
        }


        // $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $this->generateAccessToken()));
        $curl_post_data = [
            //Fill in the request parameters with valid values
            // 'BusinessShortCode' => 174379,
            'BusinessShortCode' => 4081653,
            'Password' => $this->lipaNaMpesaPassword(),
            'Timestamp' => Carbon::now()->format('YmdHis'),
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $amount,
            'PartyA' => $phone, // replace this with your phone number
            // 'PartyB' => 174379,
            'PartyB' => 4081653,
            'PhoneNumber' => $phone, // replace this with your phone number
            //'CallBackURL' => 'https://319d5839e097.ngrok.io/api/transaction/confirmation',
            // 'CallBackURL' => env('MPESA_CALLBACK'),
            'CallBackURL' => "https://www.questholdings.biz/nikopay/public/api/transaction/confirmation",
            'AccountReference' => env('APP_NAME', 'Con Fee'),
            // 'AccountReference' => "0100005694919",
            'TransactionDesc' => "Consolidation Fees."
        ];
        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = curl_exec($curl);
 
        // Check for cURL errors
        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);
            // Session::flash('alert-danger', 'cURL Error: ' . $error);
            return false;
        }

        curl_close($curl);

        // Decode JSON response
        $response = json_decode($curl_response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            // Session::flash('alert-danger', 'Invalid response from M-Pesa. Please try again.');
            return false;
        }

        // Handle no response or missing fields
        if (!$response || empty($response)) {
            // Session::flash('alert-danger', 'No response from M-Pesa. Please try again.');
            return false;
        }
        //handle positive response

        if (isset($response['ResponseCode']) && $response['ResponseCode'] == '0') {
            //create an entry here.
            $mpesaTransaction = Mpesa::create([

                'reference' => $response['reference'] ?? null,
                'amount' => $amount,
                'user_id' => $response['user_id'] ?? Auth::id(), // Default to the current authenticated user
                'cons_id' => $id ?? null,
                'status' => $response['status'] ?? 'Pending',
                'MerchantRequestID' => $response['MerchantRequestID'] ?? null,
                'CheckoutRequestID' => $response['CheckoutRequestID'] ?? null,
                'PhoneNumber' => $response['PhoneNumber'] ?? null,
                'MpesaReceiptNumber' => $response['MpesaReceiptNumber'] ?? null,
                'ResultCode' => $response['ResultCode'] ?? null,
                'ResultDesc' => $response['ResultDesc'] ?? null,
                'CustomerMessage' => $response['CustomerMessage'] ?? null,
                'description' => $response['description'] ?? null,
                'TransactionDate' => isset($response['TransactionDate'])
                    ? \Carbon\Carbon::createFromFormat('YmdHis', $response['TransactionDate'])->toDateString()
                    : null,

            ]);
            // Session::flash('alert-success', $response['ResponseDescription'] . '.' . ' Please check your phone and enter your mpesa pin.');
            return true;
        } else {
            $errorMessage =  $response['ResponseDescription'] ?? 'An error occurred.';
            // alert()::flash('alert-danger', $errorMessage);
            return false;
        }

        //    FacadesSession::flash('alert-success',$response->CustomerMessage.' Please check your phone and enter your mpesa pin');
        //return redirect()->back();  

    }

    public function callback(Request $request)
    {
        Log::info('MPesa Callback Received:', $request->all());

        $callback = $request->input('Body.stkCallback');

        if (!$callback) {
            return response()->json(['message' => 'Invalid callback data'], 400);
        }

        $checkoutRequestId = $callback['CheckoutRequestID'] ?? null;
        $resultCode = $callback['ResultCode'] ?? null;
        $resultDesc = $callback['ResultDesc'] ?? null;

        // Find the existing MPesa transaction by CheckoutRequestID
        $mpesaTransaction = Mpesa::where('CheckoutRequestID', $checkoutRequestId)->first();

        if (!$mpesaTransaction) {
            Log::error("MPesa Transaction not found for CheckoutRequestID: {$checkoutRequestId}");
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        // If transaction was successful, update it with callback metadata
        if ($resultCode === 0) {
            $callbackMetadata = $callback['CallbackMetadata']['Item'] ?? [];

            $amount = $this->getMetadataValue($callbackMetadata, 'Amount');
            $mpesaReceiptNumber = $this->getMetadataValue($callbackMetadata, 'MpesaReceiptNumber');
            $transactionDate = $this->getMetadataValue($callbackMetadata, 'TransactionDate');
            $phoneNumber = $this->getMetadataValue($callbackMetadata, 'PhoneNumber');

            $mpesaTransaction->update([
                'status' => 'Completed',
                'amount' => $amount,
                'MpesaReceiptNumber' => $mpesaReceiptNumber,
                'PhoneNumber' => $phoneNumber,
                'TransactionDate' => $transactionDate
                    ? \Carbon\Carbon::createFromFormat('YmdHis', $transactionDate)->toDateString()
                    : null,
                'ResultCode' => $resultCode,
                'ResultDesc' => $resultDesc,
            ]);

            return response()->json(['message' => 'Transaction updated successfully'], 200);
        }

        // If transaction failed, update the status
        $mpesaTransaction->update([
            'status' => 'Failed',
            'ResultCode' => $resultCode,
            'ResultDesc' => $resultDesc,
        ]);

        return response()->json(['message' => 'Transaction updated as failed'], 400);
    }

    /**
     * Helper function to extract metadata values
     */
    private function getMetadataValue($metadata, $key)
    {
        foreach ($metadata as $item) {
            if ($item['Name'] === $key) {
                return $item['Value'] ?? null;
            }
        }
        return null;
    }

    /**instantiate payment from another conytroller */
    // public function postpayment(Request $request, $id){

    //     $this->validate($request,[
    //          'phoneNumber' => 'in:myNumber,another',
    //          'phone'  => ['nullable', 'numeric'], 
    //          'myphone' => ['numeric'],
    //      ]);
 
    //      if ($request->has('phone') && $request->phone !== null) {
    //          $mpesa_phone = $request->phone;
    //      } else {
    //          $mpesa_phone = $request->myphone;
    //      }
 
    //      $mympesa =  new MpesaController ();
    //      $amount = 10;
    //      $mympesa->MpesaSTKPush($mpesa_phone, $amount, $id);
    //      Alert::success('STK processed', 'Check your device to authorize the payment');
 
    //      return redirect()->route('cons_loans', $id);
 
    //  }

    //using guzzle

    //user methods sing guzzle
    public function token()
    {
        $customer_key = env('CUSTOMER_KEY');
        $customer_secret = env('CUSTOMER_SECRET');
        $authorization_url = env('AUTHORIZATION_URL');

        $response = Http::withBasicAuth($customer_key, $customer_secret)->get($authorization_url);
        //get access token only
        return $response['access_token'];
    }

    //stk push: Mpesa Express
    public function stk_push()
    {
        //get access key from above
        $access_token = $this->token();
        $time_stamp = Carbon::now()->format('YmdHis');
        $amount = '1';
        // Payer
        $party_a = '254718582904';
        //receiver paybill
        $party_b = env('BUSINESS_SHORTCODE');
        $phone_number = 254718582904;
        // receive feedback
        // Name of who's being payed
        $passkey = env('PASSKEY');
        $transaction_type = env('TRANSACTION_TYPE');
        // $callback_url = env('CALLBACK_URL');
        $callback_url ='https://48a1-197-248-34-233.ngrok-free.app/payments/stk-callback';
        $business_short_code = env('BUSINESS_SHORTCODE');
        $account_reference = env('ACCOUNT_REFERENCE');
        $password = base64_encode($business_short_code . $passkey . $time_stamp);
        $push_url = env('PUSH_URL');
        $transaction_desc = env('TRANSACTION_DESCRIPTION');

        try {
            $response = Http::withToken($access_token)->post($push_url, [
                'BusinessShortCode' => $business_short_code,
                'Password' => $password,
                'Timestamp' => $time_stamp,
                'TransactionType' => $transaction_type,
                'Amount' => $amount,
                'PartyA' => $party_a,
                'PartyB' => $party_b,
                'PhoneNumber' => $phone_number,
                'AccountReference' => $account_reference,
                'TransactionDesc' => $transaction_desc,
                'CallBackURL' => $callback_url
            ]);
        } catch (Throwable $e) {
            return $e->getMessage();
        }
        $res = json_decode($response);
        $ResponseCode = $res->ResponseCode;
        if ($ResponseCode == 0) {
            $MerchantRequestID = $res->MerchantRequestID;
            $CheckoutRequestID = $res->CheckoutRequestID;
            $CustomerMessage = $res->CustomerMessage;

            //save to database
            $payment = new Mpesa();
            $payment->phone = $phone_number;
            $payment->amount = $amount;
            $payment->reference = $account_reference;
            $payment->description = $transaction_desc;
            $payment->MerchantRequestID = $MerchantRequestID;
            $payment->CheckoutRequestID = $CheckoutRequestID;
            $payment->status = 'Requested';
            $payment->save();

            return $CustomerMessage;
        }
    }

    public function stk_callback()
    {
        // Retrieve the input data
        $data = file_get_contents('php://input');
        Storage::disk('local')->put('stk.txt', $data);
        $response = json_decode($data);

        $ResultCode = $response->Body->stkCallback->ResultCode;

        if ($ResultCode == 0) {
            $MerchantRequestID = $response->Body->stkCallback->MerchantRequestID;
            $CheckoutRequestID = $response->Body->stkCallback->CheckoutRequestID;
            $ResultDesc = $response->Body->stkCallback->ResultDesc;
            $Amount = $response->Body->stkCallback->CallbackMetadata->Item[0]->Value;
            $MpesaReceiptNumber = $response->Body->stkCallback->CallbackMetadata->Item[1]->Value;
            //$Balance=$response->Body->stkCallback->CallbackMetadata->Item[2]->Value;
            $TransactionDate = $response->Body->stkCallback->CallbackMetadata->Item[3]->Value;
            $PhoneNumber = $response->Body->stkCallback->CallbackMetadata->Item[3]->Value;

            $payment = Mpesa::where('CheckoutRequestID', $CheckoutRequestID)->firstOrfail();
            $payment->status = 'Paid';
            $payment->TransactionDate = $TransactionDate;
            $payment->MpesaReceiptNumber = $MpesaReceiptNumber;
            $payment->ResultDesc = $ResultDesc;
            $payment->save();
        } else {

            $CheckoutRequestID = $response->Body->stkCallback->CheckoutRequestID;
            $ResultDesc = $response->Body->stkCallback->ResultDesc;
            $payment = Mpesa::where('CheckoutRequestID', $CheckoutRequestID)->firstOrfail();

            $payment->ResultDesc = $ResultDesc;
            $payment->status = 'Failed';
            $payment->save();
        }
    }

    //business to customers initialization

    public function b2c(){
        $access_token = $this->token();

        //get certificate
        $path = Storage::disk('local')->get('SandboxCertificate.cer');
        $pk= openssl_csr_get_public_key($path);

        // openssl_public_encrypt(
        //     $InitiatorPassword,
        //     $encrypted,
        //     $pk,
        //     $padding=OPENSSL_PKCS1_PADDING
    
        // );

        $OriginatorConversationID="23b6a85d-48dd-4862-acf8-79844cd70e25";
        $InitiatorName = env('INTIATOR_NAME');
        $SecurityCredential ="JidTqVzt7usJRy0R0b2tsO1dM6OANunRfWT9/hHbCJ91JjFGy7+1taTtLGrMY39sGCc89bXVvkvEjfn4gG+zm6kqkWL7hCsW+FhhAvalbf+2jxFOf4E0XyNh6dJSI8M/pftIuOF9Ykby4pRN7lB5Vr4HYhsRyiP2wSny6T2RRL8P/iYd/B5YmnwSNcUYIPmmJOJ/QTFGbUyF247Wtix0npJWI3d8M+bGZyb5H8WRNEKt5+p/2PapQK97CcrYBdxbJWkjPMNaVvpb1A04kcXHK92ZPkq7/YEsYflZL/VsAXkwIFoAMpB9BQfS16NcCzXj1PKMAUmdCdvaUOgupymzXw==";
        $CommandID='SalaryPayment';
        $Amount=10;
        $PartyA= 600990; //a different shortcode for B2C only
        $PartyB= 254708374149;
        $Remarks= "Test remarks";
        $QueueTimeOutURL=env('B2C_TIMEOUTURL');
        $ResultURL=env('B2CRESULTSURL');
        $Occasion= "occassion";
        $b2curl = env('B2CURL');

        $response=Http::withToken($access_token)->post($b2curl,[
            'OriginatorConversationID'=>$OriginatorConversationID,
            'InitiatorName'=>$InitiatorName,
            'SecurityCredential'=>$SecurityCredential,
            'CommandID'=>$CommandID,
            'Amount'=>$Amount,
            'PartyA'=>$PartyA,
            'PartyB'=>$PartyB,
            'Remarks'=>$Remarks,
            'QueueTimeOutURL'=>$QueueTimeOutURL,
            'ResultURL'=>$ResultURL,
            'Occassion'=>$Occasion,
    
        ]);
    
        return $response;
    }
}
