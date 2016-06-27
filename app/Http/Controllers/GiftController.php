<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Redis;
use Auth;

class GiftController extends Controller
{
    public function index()
    {
    	$uid = Auth::user()->id;
    	//dd($uid);
    	$sentStatus = Redis::hget('receiveGift', $uid);
    	//dd($sent);

    	if ($sentStatus == 1) {
    		return redirect()->route('index')->with('state', 'Bạn đã lựa chọn quà. Vui lòng chờ hệ thống gửi quà!');
    	}
    	else if ($sentStatus == 2) {
    		return redirect()->route('index')->with('state', 'Hệ thống đã gửi quà. Vui lòng kiểm tra!');
    	}
    	return view('welcome');
    }

    public function store($gift_id)
    {
    	$uid = Auth::user()->id;
    	Redis::hsetnx('gift', $uid, $gift_id);
    	Redis::hsetnx('receiveGift', $uid, 1);
    	return back();
    }
}
