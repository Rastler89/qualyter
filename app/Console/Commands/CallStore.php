<?php

namespace App\Console\Commands;

use App\Models\Store;
use App\Models\Answer;
use App\Models\User;
use Illuminate\Console\Command;

class CallStore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'call:store {answerId} {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $userid = $this->argument('user');
        $answerId = $this->argument('answerId');

        $user = User::find($userid);
        $answer = Answer::find($answerId);
        $store = $store = Store::where('code','=',$answer->store)->where('client','=',$answer->client)->first();

        if($user->token != null && $user->phone != null && $user->token != '' && $user->phone != '') {
            $post = [];
            $post['from_number'] = intval($user->phone);
            $post['to_number'] = intval(trim(str_replace('+','',$store->phonenumber)));//$store->phonenumber;
            $post['timeout'] = 30;
            $post['device'] = 'SIP';
            //echo"<pre>";print_r(json_encode($post));echo"</pre>";die();
            $authorization = 'Authorization: '.$user->token;
            //lanzar curl
            $callback = curl_init();
            curl_setopt($callback, CURLOPT_URL, "https://public-api.ringover.com/v2/callback");
            curl_setopt($callback, CURLOPT_HTTPHEADER, array('Content-Type:application/json',$authorization));
            curl_setopt($callback, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($callback, CURLOPT_POST, true);
            curl_setopt($callback, CURLOPT_POSTFIELDS,json_encode($post));
            $response = curl_exec($callback);
            $errors = curl_error($callback);
            $code = curl_getinfo($callback, CURLINFO_HTTP_CODE);
            curl_close($callback);
            
            if($code == 200) {
                $response = json_decode($response, true);
                $callids = json_decode($answer->callId,true);
                $callids[] = strval($response['call_id']);
                $answer->callId = json_encode($callids);
                $answer->save();
            }

        }
    }
}
