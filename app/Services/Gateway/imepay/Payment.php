<?php

namespace App\Services\Gateway\imepay;

use App\Models\Deposit;
use App\Models\Fund;
use App\Models\Order;
use Facades\App\Services\BasicService;
use Facades\App\Services\BasicCurl;
use Illuminate\Support\Facades\Auth;

class Payment
{
	public static function prepareData($deposit, $gateway)
	{
		$MerchantModule = optional($gateway->parameters)->MerchantModule;
		$MerchantCode = optional($gateway->parameters)->MerchantCode;
		$username = optional($gateway->parameters)->username;
		$password = optional($gateway->parameters)->password;

//        $MerchantModule = 'GAMINGCEN';
//        $MerchantCode = 'GAMINGCEN';
//        $username = 'gamingcenter';
//        $password = 'ime@1234';
		$url = "https://stg.imepay.com.np:7979/api/Web/GetToken";

		$postParam = array(
			"MerchantCode" => $MerchantCode,
			"Amount" => round($deposit->payable_amount, 2),
			"RefId" => $deposit->utr);

		$headers = array(
			'Content-Type: application/json',
			'Module: ' . base64_encode("{$MerchantModule}"),
			'Authorization: Basic ' . base64_encode("{$username}:{$password}")
			//'Module: R0FNSU5HQ0VO',
			//'Authorization: Basic Z2FtaW5nY2VudGVyOmltZUAxMjM0'
		);


		$checkResponse = BasicCurl::curlPostRequestWithHeadersNew($url, $headers, $postParam);

		$checkResponse = json_decode($checkResponse);


		if ($checkResponse && isset($checkResponse->Message)) {
			$send['error'] = true;
			$send['message'] = "Error:" . @$checkResponse->Message;
			return json_encode($send);
		}

		$deposit->btc_wallet = @$checkResponse->TokenId;
		$deposit->save();

		$val['TokenId'] = $checkResponse->TokenId; //'IHzGMwNqGT24KHsD';
		$val['MerchantCode'] = optional($gateway->parameters)->MerchantCode;
		$val['RefId'] = $deposit->utr;
		$val['TranAmount'] = round($deposit->payable_amount, 2);
		$val['Method'] = 'GET';
		$val['RespUrl'] = route('ipn', [$gateway->code, $deposit->utr]);


		$CancelUrl = route('failed');
		$val['CancelUrl'] = $CancelUrl;
		$send['val'] = $val;
		$send['view'] = $deposit->depositable_type == Order::class ? 'payment.redirect' : 'user.payment.redirect';
		$send['method'] = 'post';
		$send['url'] = 'https://stg.imepay.com.np:7979/WebCheckout/Checkout';
		return json_encode($send);

	}

	public static function ipn($request, $gateway, $deposit = null, $trx = null, $type = null)
	{

		$imePayRes = $request->data;
		$res = base64_decode($imePayRes);
		$resArr = explode('|', $res);

		$deposit = Deposit::where('utr', $resArr[4])->orderBy('id', 'DESC')->with(['gateway', 'user'])->first();
		if ($deposit && $resArr[0] == 0 && $resArr[5] == round($deposit->payable_amount, 2) && $resArr[6] == $deposit->btc_wallet) {
			BasicService::prepareOrderUpgradation($deposit);
			$data['status'] = 'success';
			$data['msg'] = 'Transaction was successful.';
			$data['redirect'] = route('success');
		} else {
			$data['status'] = 'error';
			$data['msg'] = 'Invalid response.';
			$data['redirect'] = route('failed');
		}
		return $data;
	}
}
