<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pusher\Laravel\Facades\Pusher;
use App\Models\Notification;
date_default_timezone_set("Asia/Jakarta");

class SendMessageController extends Controller
{
    //
	public function index()
	{
		return view('send_message');
	}

	public function sendMessage(Request $request)
	{
		$request->validate([
			'title' => 'required',
			'content' => 'required',
			'user_id' => 'required'
		]);

		$array=array(
			'title'=>$request->input('title'),
			'content'=>$request->input('content'),
			'user_id'=>$request->input('user_id'),
		);

		$insert_to_db=Notification::create($array);
		if($insert_to_db==true)
		{
			$data['title'] = $request->input('title');
			$data['content'] = $request->input('content');
			$data['timestamp']=date('Y-m-d H:i:s');
			$data['user_id']=$request->input('user_id');

			$options = array(
				'cluster' => 'ap3',
				'encrypted' => true
			);

			$pusher = new Pusher(
				env('PUSHER_APP_KEY'),
				env('PUSHER_APP_SECRET'),
				env('PUSHER_APP_ID'),
				$options
			);

			Pusher::trigger(''.$data['user_id'].'', 'send-message', $data);
		}

		// $test=$pusher->trigger('Notify', 'send-message', $data);
		// event()

		return redirect()->route('send');
	}
}
