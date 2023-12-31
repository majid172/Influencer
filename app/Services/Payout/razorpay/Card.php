<?php

namespace App\Services\Payout\razorpay;

use App\Models\Payout;
use App\Models\PayoutMethod;
use App\Models\RazorpayContact;
use App\Models\Transaction;
use Facades\App\Services\BasicCurl;

class Card
{
	public static function payouts($payout)
	{
		$method = PayoutMethod::where('code', 'razorpay')->first();
		$api = 'https://api.razorpay.com/v1/';
		$KEY_ID = optional($method->parameters)->Key_Id;
		$KEY_SECRET = optional($method->parameters)->Key_Secret;
		$accountNumber = optional($method->parameters)->account_number;

		$card = new Card();
		$res = $card->createContact($api, $KEY_ID, $KEY_SECRET, $payout);
		if ($res['status'] == 'error') {
			return [
				'status' => 'error',
				'data' => $res['data']
			];
		}

		$contact_id = $res['data'];
		$res = $card->createFund($api, $KEY_ID, $KEY_SECRET, $payout, $contact_id);
		if ($res['status'] == 'error') {
			return [
				'status' => 'error',
				'data' => $res['data']
			];
		}

		$info = json_decode($payout->withdraw_information);
		$fund_account_id = $res['data'];
		$currencyCode = $payout->currency_code;
		$amount = (int)$info->amount->fieldValue;

		$url = $api . 'payouts';

		$postParam = [
			"account_number" => $accountNumber,
			"fund_account_id" => $fund_account_id,
			"amount" => $amount,
			"currency" => $currencyCode,
			"mode" => "IMPS",
			"purpose" => "payout",
		];

		$response = $card->razorpayCurlPostRequestWithHeaders($url, $postParam, $KEY_ID, $KEY_SECRET);
		$result = json_decode($response);

		if (isset($result->error)) {
			return [
				'status' => 'error',
				'data' => $result->error->description
			];
		} else {
			return [
				'status' => 'success',
				'response_id' => $result->id,
			];
		}
	}

	public static function createContact($api, $KEY_ID, $KEY_SECRET, $payout)
	{
		$card = new Card();
		$info = json_decode($payout->withdraw_information);
		$name = $info->name->fieldValue;
		$email = $info->email->fieldValue;
		$contact = RazorpayContact::where('name', $name)->where('email', $email)->first();
		if ($contact) {
			return $contact->contact_id;
		}

		$url = $api . 'contacts';

		$postParam = [
			"name" => "Gaurav Kumar",
			"email" => "gaurav.kumar@example.com",
		];

		$response = $card->razorpayCurlPostRequestWithHeaders($url, $postParam, $KEY_ID, $KEY_SECRET);
		$result = json_decode($response);

		if (isset($result->error)) {
			return [
				'status' => 'error',
				'data' => $result->error->description
			];
		} else {
			return [
				'status' => 'success',
				'data' => $result->id
			];
		}
	}

	public static function createFund($api, $KEY_ID, $KEY_SECRET, $payout, $contact_id)
	{
		$card = new Card();
		$info = json_decode($payout->withdraw_information);

		$url = $api . 'fund_accounts';
		$postParam = [
			"contact_id" => $contact_id,
			"account_type" => "bank_account",
			"bank_account" => [
				"name" => $info->name->fieldValue,
				"ifsc" => $info->ifsc->fieldValue,
				"account_number" => $info->account_number->fieldValue,
			]
		];

		$response = $card->razorpayCurlPostRequestWithHeaders($url, $postParam, $KEY_ID, $KEY_SECRET);
		$result = json_decode($response);

		if (isset($result->error)) {
			return [
				'status' => 'error',
				'data' => $result->error->description
			];
		} else {
			return [
				'status' => 'success',
				'data' => $result->id
			];
		}
	}

	public static function getResponse($apiResponse)
	{
		if ($apiResponse) {
			if ($apiResponse->payload) {
				if ($apiResponse->payload->payout) {
					if ($apiResponse->payload->payout->entity) {
						$payout = Payout::where('response_id', $apiResponse->payload->payout->entity->id)->first();
						if ($payout) {
							if ($apiResponse->event == 'payout.processed' || $apiResponse->event == 'payout.updated') {
								if ($payout->status != 2) {
									$transaction = new Transaction();
									$transaction->amount = $payout->amount;
									$transaction->charge = $payout->charge;
									$payout->transactional()->save($transaction);

									$payout->status = 2;
									$payout->save();
									return [
										'status' => 'success',
										'payout' => $payout,
									];
								}
							} elseif ($apiResponse->event == 'payout.rejected' || $apiResponse->event == 'payout.failed') {
								$payout->status = 6;
								$payout->last_error = $apiResponse->payload->payout->entity->status_details->description ?? '';
								$payout->save();
								updateWallet($payout->user_id, $payout->transfer_amount, 1);
								return [
									'status' => 'rejected',
									'payout' => $payout,
								];
							}
						}
					}
				}
			}
		}
	}

	public static function razorpayCurlPostRequestWithHeaders($url, $postParam = [], $KEY_ID, $KEY_SECRET)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postParam));
		curl_setopt($ch, CURLOPT_USERPWD, $KEY_ID . ':' . $KEY_SECRET);

		$headers = array();
		$headers[] = 'Content-Type: application/json';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
}
