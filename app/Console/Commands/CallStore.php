<?php

namespace App\Console\Commands;

use App\Models\Store;
use App\Models\Answer;
use App\Models\Incidence;
use App\Models\Call;
use App\Models\User;
use Illuminate\Console\Command;

class CallStore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'call:store {id} {user} {type} {phonenumber}';

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
        $elementId = $this->argument('id');
        $type = $this->argument('type');
        $phonenumber = $this->argument('phonenumber');

        $user = User::find($userid);
        if($type=='answer') {
            $element = Answer::find($elementId);
        } else if($type=='incidence') {
            $element = Incidence::find($elementId);
        }
        $store = $store = Store::where('code','=',$element->store)->where('client','=',$element->client)->first();

        if(($user->token != null && $user->phone != null && $user->token != '' && $user->phone != '') || env('APP_NAME')=='QualyterTEST') {
            $post = [];
            if(env('APP_NAME')=='QualyterTEST') {
                if($phonenumber != ''){
                    $this->info('local');
                    $post['from_number'] = intval('34872583167');
                    $post['to_number'] = intval($phonenumber);
                    $authorization = 'Authorization:  138a032c631da0db13b4d1252742ebb2ce17599a';
                }else{
                    $this->info('local');
                    $post['from_number'] = intval('34872583167');
                    $post['to_number'] = intval('617370097');
                    $authorization = 'Authorization:  138a032c631da0db13b4d1252742ebb2ce17599a';
                }
                
            } else {
                if($phonenumber != ''){
                    $this->info('production');
                    $post['from_number'] = intval($user->phone);
                    $post['to_number'] = intval(trim(str_replace('+','',$phonenumber)));//$store->phonenumber;
                    $authorization = 'Authorization: '.$user->token;
                }else{
                    $this->info('production');
                    $post['from_number'] = intval($user->phone);
                    $post['to_number'] = intval(trim(str_replace('+','',$store->phonenumber)));//$store->phonenumber;
                    $authorization = 'Authorization: '.$user->token;
                }
                
            }
            $post['timeout'] = 30;
            $post['device'] = 'SIP';
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
                $response = json_decode($response, true, 512, JSON_BIGINT_AS_STRING);
                $call = new Call();
                $call->call_id = $response['call_id'];
                $call->external_id = $elementId;
                $call->type = substr($type,0,1);
                $call->user_id = $userid;
                $call->save();
            }

            return $response;

        }
    }
}
