<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Ilog,App\Maestro;
use Mail;
class RefrigerioNoche extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refrigerionoche:actualizarrefrigerionoche';

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
     * @return mixed
     */
    public function handle()
    {

        $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC actualizarnoche');
        $stmt->execute();

        // correos from(de)
        $emailfrom = Maestro::where('codigoatributo','=','0002')->where('codigoestado','=','00001')->first();
        // correos principales y  copias
        $email     = Maestro::where('codigoatributo','=','0002')->where('codigoestado','=','00004')->first();

        Mail::send('emails.refrigerionoche', [], function($message) use ($emailfrom,$email)
        {

            $emailprincipal     = explode(",", $email->correoprincipal);
            
            $message->from($emailfrom->correoprincipal, 'REFRIGERIO DE LA NOCHE');

            if($email->correocopia<>''){
                $emailcopias        = explode(",", $email->correocopia);
                $message->to($emailprincipal)->cc($emailcopias);
            }else{
                $message->to($emailprincipal);                
            }
            $message->subject($email->descripcion);

        });
        


        $fechatime                           = date("Ymd H:i:s");
        $fecha                               = date("Ymd");

        $cabecera                            = new Ilog;
        $cabecera->descripcion               = '(Sistema) Actualizacion de refrigerios de la noche';
        $cabecera->fecha                     = $fecha;
        $cabecera->fechatime                 = $fechatime;
        $cabecera->save();

        Log::info("Correo Enviado");
    }
}
