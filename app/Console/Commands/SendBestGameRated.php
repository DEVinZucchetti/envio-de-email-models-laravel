<?php

namespace App\Console\Commands;

use App\Mail\SendBestGameEmail;
use App\Models\Avaliation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendBestGameRated extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-best-game-rated';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia um email com o jogo mais bem avaliado do momento';


    public function handle()
    {
       $result =  DB::select('
       select
            count(product_id) as count_avaliation,
            a.product_id,
            p.name as game,
            p.price as price,
            p.description as description ,
            p.cover as cover
                from avaliations a
                    join products p on p.id = a.product_id
                        where a.recommended = true
                        group by
                            product_id,
                            p.name,
                            p.price,
                            p.description,
                            p.cover
                        order by count_avaliation desc
                        limit 1
            ');

            if(count($result) > 0) {

                Mail::to('taisa_monteiro@estudante.sesisenai.org.br', 'Taisa Guimarães')
                ->send(new SendBestGameEmail($result[0])); //Pegar a primeira posição do array
            }
    }
}