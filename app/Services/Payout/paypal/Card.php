<?php

namespace App\Services\Payout\paypal;

use App\Models\Payout;
use App\Models\PayoutMethod;
use App\Models\RazorpayContact;
use App\Models\Transaction;
use Facades\App\Services\BasicCurl;

class Card
{
	public static function payouts($payout)
	{
		$card = new Card();
		$method = PayoutMethod::where('code', 'paypal')->first();
		$info = json_decode($payout->withdraw_information);

		if ($method->environment == 'live') {
			$api = 'https://api-m.paypal.com/v1/';
		} else {
			$api = 'https://api-m.sandbox.paypal.com/v1/';
		}

		$CLIENT_ID = optional($method->parameters)->cleint_id;
		$KEY_SECRET = optional($method->parameters)->secret;

		$url = $api . 'payments/payouts';
		$recipient_type = $info->recipient_type->fieldValue;
		$value = $info->amount->fieldValue;
		$receiver = $info->receiver->fieldValue;

		$headers = [
			'Content-Type: application/json',
			'Authorization: Basic ' . base64_encode("{$CLIENT_ID}:{$KEY_SECRET}")
		];

		$postParam = [
			"sender_batch_header" => [
				"sender_batch_id" => substr(md5(mt_rand()), 0, 10),
				"email_subject" => "You have a payout!",
				"email_message" => "You have received a payout! Thanks for using our service!",
			],
			"items" => [
				[
					"recipient_type" => $recipient_type,
					"amount" => [
						"value" => $value,
						"currency" => $payout->currency_code
					],
					"receiver" => $receiver,
				]
			]
		];

		$response = $card->payoutCurlPostRequestWithHeaders($url, $headers, $postParam);
		$result = json_decode($response);

		if (isset($result->batch_header)) {
			return [
				'status' => 'success',
				'response_id' => $result->batch_header->payout_batch_id
			];
		} else {
			return [
				'status' => 'error',
				'data' => $result->details[0]->issue
			];
		}
	}

	public static function getResponse($apiResponse)
	{
		if ($apiResponse) {
			if ($apiResponse->batch_header) {
				$payout = Payout::where('response_id', $apiResponse->batch_header->payout_batch_id)->first();
				if ($payout) {
					if ($apiResponse->event_type == 'PAYMENT.PAYOUTSBATCH.SUCCESS' || $apiResponse->event_type == 'PAYMENT.PAYOUTS-ITEM.SUCCEEDED' || $apiResponse->event_type == 'PAYMENT.PAYOUTSBATCH.PROCESSING') {
						if ($apiResponse->event_type != 'PAYMENT.PAYOUTSBATCH.PROCESSING') {
							$transaction = new Transaction();
							$transaction->amount = $payout->amount;
							$transaction->charge = $payout->charge;
							$transaction->currency_id = $payout->currency_id;
							$payout->transactional()->save($transaction);
							$payout->status = 2;
							$payout->save();
							return [
								'status' => 'success',
								'payout' => $payout,
							];
						}
					} else {
						$payout->status = 6;
						$payout->last_error = $apiResponse->summary;
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

	public static function payoutCurlPostRequestWithHeaders($url, $headers, $postParam = [])
	{
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postParam));

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
}
