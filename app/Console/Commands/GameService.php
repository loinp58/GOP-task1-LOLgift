<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use Mockery\CountValidator\Exception;
use Redis;
use App\Gift;
use App\User;
use GuzzleHttp\Client;
use DB;

class GameService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gameservice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The Game service to send OK when run cronjob';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function postAPI($uid, $gift)
    {
        $host = 'http://192.168.33.10:8000';
        $data = ['userId' => $uid, 'gift' => $gift];
        $client = new Client;
        $res = $client->request('GET', $host.'/api', ['json' => $data]);
        return $res;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::info('-----Start------');
        $count = 5;
        for ($i = 0; $i < $count; $i++) {
            $uid = Redis::lpop('receiveGift');
            if (!$uid) return;
            Log::info('UID: '.$uid);
            $gift_id = Redis::hget('gift', $uid);
            Log::info('GIFT: '.$gift_id);
            $response = $this->postAPI($uid, $gift_id);
            if (199 < $response->getStatusCode() && $response->getStatusCode() < 300) {
                Log::info(" Updated for user has id = ".$uid." ".json_decode($response->getBody() ));
                if (json_decode($response->getBody())) {
                    try {
                        Log::info('Update state gift of UID:' . $uid);
                        Gift::where('uid', $uid)->update(['state' => 2]);
                    } catch (Exception $ex) {
                        Log::info($ex->getMessage());
                    }
                }
            }
            else {
                Redis::rpush('receiveGift', $uid);
            }
        }

        if (!Redis::lindex('receiveGift', 0)) {
            $this->checkSendGift();
        }
    }

    public function checkSendGift() {
        try {
            Log::info("Run check Send");
            $unSendGifts = Gift::where('state', '=', 0)->get();
            foreach ($unSendGifts as $gift) {
                Redis::hsetnx('gift', $gift->user_id, $gift->gift_id);
                Redis::lpush('receiveGift', $gift->user_id);
            }
        } catch (Exception $ex) {
            Log::info($ex->getMessage());
        }
    }
}
