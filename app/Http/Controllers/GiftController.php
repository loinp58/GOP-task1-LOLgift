<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Mockery\CountValidator\Exception;
use Redis;
use Auth;
use App\Gift;
use DB;

class GiftController extends Controller
{
    public function index()
    {
    	$uid = Auth::user()->id;
    	// dd($uid);
    	$sentStatus = Redis::hget('gift', $uid);
//		dd($sentStatus);
		if (!$sentStatus) {
			$sentStatus = 0;
		}
		else {
			$gift = DB::table('gifts')->where('uid', $uid)->first();
			if ($gift) {
				$sentStatus = $gift->state;
			}
			//dd($sentStatus);
		}

    	if ($sentStatus == 1) {
    		return redirect()->route('index')->with('state', 'Bạn đã lựa chọn quà. Vui lòng chờ hệ thống gửi quà!');
    	}
    	else if ($sentStatus == 2) {
    		return redirect()->route('index')->with('state', 'Hệ thống đã gửi quà. Vui lòng kiểm tra!');
    	}
    	return view('welcome');
    }

    public function store(Request $request)
    {
    	$uid = Auth::user()->id;
		$gift_id = (int)$request->input('gift_id');
		// dd($gift_id);
    	Redis::hsetnx('gift', $uid, $gift_id);
    	Redis::rpush('receiveGift', $uid);
		try {
			Gift::create([
				'uid' => $uid,
				'gift' => $gift_id,
				'state' => 1,
			]);
		} catch(Exception $ex) {
			dd($ex->getMessage());
		}

		// dd($gift_id);
    	return back();
    }
}
