<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
	public $theme;

	public function __construct()
    {
        $this->theme = template();
    }

    public function chat($id)
	{
		$proposser_id = $id;
		return view($this->theme.'user.chat.chat',compact('proposser_id'));
	}

	public function chatStore(Request $request,$id)
	{
		
		dd($request->all());
	}
}
