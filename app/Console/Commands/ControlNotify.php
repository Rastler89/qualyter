<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Client;
use App\Models\Store;
use App\Models\Incidence;
use App\Models\Agent;
use App\Models\User;
use App\Models\Team;
use Mail;
use App\Mail\ReminderAgent;
use App\Mail\ReminderManager;

class ControlNotify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'control:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send mails for incidents with control day to be fulfilled today';

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
        $inc_team = [];
        $inc_qc = [];
        $incidences = Incidence::whereBetween('closed',[date('Y-m-d 00:00:00', time()),date('Y-m-d 23:59:59', time())])->get();
        foreach($incidences as $incidence) {
            $agent = Agent::find($incidence->owner);
            $store = Store::where('code','=',$incidence->store)->get();
            $incidence['store_name'] = $store[0]->name;
            $incidence['agent_name'] = $agent->name;
            //Enviar correo
            if(env('APP_NAME')=='QualyterTEST') {
                Mail::to('test@optimaretail.es')->locale('es')->send(new ReminderAgent($incidence));
            } else {
                Mail::to($agent->email)->locale('es')->send(new ReminderAgent($incidence));
            }
            //Se prepara para el manager
            $team = Team::where('url','=',$agent->team)->get();
            $manager = User::find($team[0]->manager);
            if(!isset($inc_team[$manager->id])) {
                $inc_team[$manager->id]['email'] = $manager->email;
            }
            $inc_team[$manager->id]['incidences'][]=$incidence;
            
            $user = User::find($incidence->responsable);
            //se prepara para qc
            if(!isset($inc_qc[$user->id])) {
                $inc_qc[$user->id]['email'] = $user->email;
            }
            $inc_qc[$user->id]['incidences'][]=$incidence;
        }
        //Enviar correo manager
        foreach($inc_team as $email) {
            if(env('APP_NAME')=='QualyterTEST') {
                Mail::to('test@optimaretail.es')->locale('es')->send(new ReminderManager($email));
            } else {
                Mail::to($email['email'])->locale('es')->send(new ReminderManager($email));
            }
        }

        //Enviar correo qc
        foreach($inc_qc as $email) {
            if(env('APP_NAME')=='QualyterTEST') {
                Mail::to('test@optimaretail.es')->locale('es')->send(new ReminderManager($email));
            } else {
                Mail::to($email['email'])->locale('es')->send(new ReminderManager($email));
            }
        }

        return 0;
    }
}
