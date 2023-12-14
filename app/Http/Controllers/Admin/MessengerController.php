<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MessengerController extends Controller
{
    public function conversationList()
	{
		return view('admin.conversation.list');
	}
}
