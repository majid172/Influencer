<?php

namespace App\Http\Controllers\User;

use App\Events\ChatEvent;
use App\Events\UpdateUserNotification;
use App\Http\Controllers\Controller;
use App\Models\Messenger;
use App\Models\SiteNotification;
use App\Models\User;
use App\Traits\Notify;
use App\Traits\Upload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
	use Upload, Notify;

	public $user, $theme;

	public function __construct()
	{
		$this->middleware(['auth']);
		$this->middleware(function ($request, $next) {
			$this->user = auth()->user();
			return $next($request);
		});
		$this->theme = template();
	}

	public function message()
	{
		return view($this->theme . 'user.message.messageList');
	}

	public function getContacts(Request $request)
	{

		$contacts = Messenger::with('sender', 'job')
			->where('sender_id', auth()->id())
			->orWhere('receiver_id', auth()->id())
			->latest()
			->get()
			->map(function ($item) {
				if ($item->sender_id == auth()->id()) {
					return $item->receiver;
				} else {
					return $item->sender;
				}

			})
			->unique()
			->values()
			->map(function ($item) {

				$item->chat_last_message = Messenger::select('message')
					->where(function ($query) use ($item) {
						$query->where(['sender_id' => $item->id, 'receiver_id' => auth()->id()]);
					})
					->orWhere(function ($query) use ($item) {
						$query->where(['sender_id' => auth()->id(), 'receiver_id' => $item->id]);
					})
					->latest()->first();
				return $item;
			})
			->map(function ($item) {
				$item->image = getFile($item->profile->driver, $item->profile->profile_picture);
				return $item;
			})
			->map(function ($item) {
				if (isset($item->chat_last_seen)) {
					$item->chat_last_seen = Carbon::parse($item->chat_last_seen)->shortRelativeDiffForHumans();
				}
				return $item;
			});


		$unreadIds = Messenger::select(DB::raw('`sender_id` as senderId, count(`sender_id`) as messages_count'))
			->where('receiver_id', auth()->id())
			->where('read', 0)
			->groupBy('sender_id')
			->get();


		$contacts = $contacts->map(function ($contact) use ($unreadIds) {
			$contactUnread = $unreadIds->where('senderId', $contact->id)->first();

			$contact->unread = $contactUnread ? $contactUnread->messages_count : 0;

			return $contact;
		});

		return response()->json($contacts);
	}

	public function getMessages(Request $request, $id)
	{

		Messenger::where('sender_id', $id)->where('receiver_id', auth()->id())->update(['read' => 1]);

		$messages = Messenger::with('sender', 'sender.profile', 'receiver', 'receiver.profile', 'file')
			->where(function ($query) use ($id) {
				$query->where(['sender_id' => $id, 'receiver_id' => auth()->id()]);
			})
			->orWhere(function ($query) use ($id) {
				$query->where(['sender_id' => auth()->id(), 'receiver_id' => $id]);
			})
			->get()
			->map(function ($item) {
				$image = getFile($item->sender->profile->driver, $item->sender->profile->profile_picture);
				$item['sender_image'] = $image;
				return $item;
			})
			->map(function ($item) {
				$image = getFile($item->receiver->profile->driver, $item->receiver->profile->profile_picture);
				$item['receiver_image'] = $image;
				return $item;
			})
			->map(function ($item) {
				if (isset($item->file[0])) {
					$file = getFile($item->file[0]->driver, $item->file[0]->file);
					$item['fileImage'] = $file;
				}
				return $item;
			});

		$messages->push(auth()->user());

		return response()->json($messages);
	}


	public function sendMessage(Request $request)
	{
		$this->validate($request, [
			'file' => 'nullable|mimes:jpg,png,jpeg,PNG|max:3072',
		]);

		$message = new Messenger();
		$message->sender_id = (string)$this->user->id;
		$message->receiver_id = $request->receiver_id;
		$message->message = $request->message;
		$message->save();

		if ($request->hasFile('file')) {
			$messageFile = $this->fileUpload($request->file, config('location.message.path'));
			$message->file()->create([
				'file' => $messageFile['path'],
				'driver' => $messageFile['driver'],
			]);
			$fileImage = getFile($messageFile['driver'], $messageFile['path']);
		} else {
			$fileImage = null;
		}
		$sender_image = getFile($this->user->profile->driver, $this->user->profile->profile_picture);
		$response = [
			'sender_id' => $message->sender_id,
			'receiver_id' => $message->receiver_id,
			'message' => $message->message,
			'fileImage' => $fileImage,
			'sender_image' => $sender_image,
			'name' => auth()->user()->name,
			'time' => 'just now',
		];


		ChatEvent::dispatch((object)$response);

		$member_profile = User::where('id', $request->receiver_id)->first();
		$msg = [
			'username' => $this->user->username,
		];
		$action = [
			"link" => route('user.message'),
			"icon" => "fas fa-money-bill-alt text-white"
		];
		$this->userPushNotification($member_profile, 'USER_SENT_MESSAGE', $msg, $action, $message->sender_id);

		return response()->json($response);
	}


	public function chatLeaveingTime($id)
	{
		$userLastSeen = User::where('id', $id)->update(['chat_last_seen' => Carbon::now()]);
		return response()->json($userLastSeen);
	}


	public function deletePushnotification($id)
	{
		$siteNotification = SiteNotification::where(['site_notificational_id' => Auth::id(), 'msg_sender_id' => $id])->get();
		if ($siteNotification) {
			$siteNotification->each->delete();
			event(new UpdateUserNotification(Auth::id()));
			$data['status'] = true;
		} else {
			$data['status'] = false;
		}
		return $data;
	}

	public function proposerMessage(Request $request)
	{
		$request->validate([
			'message' => 'required'
		]);

		$message = new Messenger();
		$message->sender_id = $request->sender_id;
		$message->receiver_id = $request->receiver_id;
		$message->job_id = $request->job_id;
		$message->listing_id = $request->listing_id;
		$message->message = $request->message;
		$message->save();
		return back()->with('Message send successfully');
	}

	public function show()
	{
		$getMessages = Messenger::where('receiver_id', auth()->id())->where('read', 0)->latest()->get()->map(function ($query) {
			$query->name = $query->sender->name ?? 'lol';
			$query->sender_image = $query->sender->profilePicture();
			$query->time = diffForHumans($query->created_at);
			return $query;
		});
		return $getMessages;
	}

	public function readAt($id)
	{
		$message = Messenger::find($id);
		if ($message) {
			$message->read = 1;
			$message->save();
		}
		$data['status'] = true;
		return $data;
	}

	public function readAll()
	{
		$message = Messenger::where('receiver_id', auth()->id())->where('read', 0)->latest()->get()->map(function ($query) {
			$query->read = 1;
			$query->save();
		});
		$data['status'] = true;
		return $data;
	}

}
