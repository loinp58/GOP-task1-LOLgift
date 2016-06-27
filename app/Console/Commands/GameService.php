<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use Redis;
use App\Gifted;
use App\User;
use GuzzleHttp\Client;

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

    private function postAPI($url, $id, $gift)
    {
        $data = ['userId' => $id, 'gift' => $gift];
        $client = new Client;
        $res = $client->request('GET', $url, ['json' => $data]);
        Log::info($res->getStatusCode());
        return $res->getStatusCode();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $all = Redis::hgetall('gift');
        $count = 0;
        foreach($all as $id => $gift) {
            $count++;
            if ($count >= 5) break;
            $response = $this->postAPI(env('API_URL'), $id, $gift);
            if ($response == 200) {
                Gifted::create([
                    'uid' => $id,
                    'gift' => $gift,
                    'state' => 1
                ]);
                Redis::hdel('gift', $id);
                Redis::hset('receiveGift', $id, 2);
                Log::info($id . ' : ' . $gift);
            }
        }
    }
}
