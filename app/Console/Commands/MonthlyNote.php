<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use App\Mail\ClientMonthly;
use App\Models\Client;
use App\Models\Store;
use App\Models\Answer;

class MonthlyNote extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'note:monthly {user=all}';

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
        $user = $this->argument('user');

        if($user == 'all') {
            $fathers = Client::whereNull('father')->get();
            foreach($fathers as $father) {
                $this->core($father);
            }
        } else {
            $fathers = Client::find($user);
            $this->core($fathers);
        }
    }

    private function core($father) {
        if($father->delegation == '00') {
            //busca hijos
            $sons = null;
            $delegations = Client::where('father','=',$father->id)->orderBy('id','desc')->get();
            
            $visits = 0;
            foreach($delegations as $delegation) {
                $average = $this->getAverage($delegation);
                if($average != false) {
                    $sons[$delegation->name] = $average['media'];
                    $visits += $average['total'];
                }
            } 
            if($father->extra) {
                $extra = $this->getExtra($delegations);
                $body = [
                    'locale' => $father->language,
                    'name' => $father->name,
                    'sons' => $sons,
                    'visits' => $visits,
                    'extra' => $extra,
                    'id' => $father->id
                ];
            } else {
                $body = [
                    'locale' => $father->language,
                    'name' => $father->name,
                    'sons' => $sons,
                    'visits' => $visits,
                    'extra' => null,
                    'id' => $father->id
                ];
            }
            $body['type'] = 'delegation';
            if(!is_null($sons)) {
                if(env('APP_NAME')=='QualyterTEST') {
                    Mail::to('test@optimaretail.es')->locale($father->language)->send(new ClientMonthly($body));
                } else {
                    if(strpos($father->email,',') !== false) {
                        $emails = explode(',',$father->email);
                        $this->send($emails,$body);
                    } else if(strpos($father->email,';') !== false) {
                        $emails = explode(';',$father->email);
                        $this->send($emails,$body);
                    } else if(strpos($father->email,"\n")) {
                        $emails = explode("\n",$father->email);
                        $this->send($emails,$body);
                    } else {
                        Mail::to($father->email)->locale($father->language)->send(new ClientMonthly($body));
                    }
                    
                }
            }
        } else {
            //busca tiendas
            $average = $this->getAverage($father);
            if($average != false) {
                if($father->extra) {
                    $extra = $this->getExtra($delegations);
                    $body = [
                        'locale' => $father->language,
                        'name' => $father->name,
                        'visits' => $average['total'],
                        'media' => $average['media'],
                        'extra' => $extra,
                        'id' => $father->id
                    ];
                } else {
                    $body = [
                        'locale' => $father->language,
                        'name' => $father->name,
                        'visits' => $average['total'],
                        'media' => $average['media'],
                        'extra' => null,
                        'id' => $father->id
                    ];
                }
                $body['type'] = 'client';
                //se envia correo
                if(env('APP_NAME')=='QualyterTEST') {
                    Mail::to('test@optimaretail.es')->locale($father->language)->send(new ClientMonthly($body));
                } else {
                    if(strpos($father->email,',') !== false) {
                        $emails = explode(',',$father->email);
                        $this->send($emails,$body);
                    } else if(strpos($father->email,';') !== false) {
                        $emails = explode(';',$father->email);
                        $this->send($emails,$body);
                    } else if(strpos($father->email,"\n")) {
                        $emails = explode("\n",$father->email);
                        $this->send($emails,$body);
                    } else {
                        Mail::to($father->email)->locale($father->language)->send(new ClientMonthly($body));
                    }
                } 
            }               
        }
    }

    private function getExtra($delegations) {
        $visits = 0;
        $qc = 0;
        $send = 0;
        $resp = 0;

        $first_day = first_month_day();
        $last_day = last_month_day();

        foreach($delegations as $delegation) {
            $answers = Answer::where('client','=',$delegation->id)->where('status','<>','8')->whereBetween('expiration',[$first_day,$last_day])->get();
            $visits += count($answers);

            $answers = Answer::where('client','=',$delegation->id)->where('status','=','2')->whereBetween('expiration',[$first_day,$last_day])->get();
            $qc += count($answers);

            $answers = Answer::where('client','=',$delegation->id)->whereIn('status',[3,4,5])->whereBetween('expiration',[$first_day,$last_day])->get();
            $send += count($answers);

            $answers = Answer::where('client','=',$delegation->id)->whereIn('status',[4,5])->whereBetween('expiration',[$first_day,$last_day])->get();
            $resp += count($answers);
        }

        $body = [
            'visits' => $visits,
            'qc' => $qc,
            'send' => $send,
            'resp' => $resp
        ];

        return $body;
    }
    private function getAverage($client) {
        $resp = [];

        $first_day = first_month_day();
        $last_day = last_month_day();

        $stores = Store::where('client','=',$client->id)->get();
        foreach($stores as $store) {
            $answer = Answer::where('store','=',$store->code)->whereIn('status',[2,4,5])->whereBetween('expiration',[$first_day,$last_day])->get();
            if(count($answer) > 0) {
                foreach($answer as $ans) {
                    $response = json_decode($ans->answer,true);
                    $resp[] = $response['valoration'][0];
                }
            }
        }
        if(count($resp) > 0) {
            $total = array_sum($resp);
            $divisor = count($resp);
            $media = $total/$divisor;
            $body = [
                'media' => $media,
                'total' => $total,
            ];
            return $body;
        } else {
            return false;
        }
    }

    private function send($emails,$body) {
        foreach($emails as $email) {
            if(strlen($email)>0) {
                Mail::to($email)->send(new ClientMonthly($body));
            }
        }
    }
}
