<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\log;
use App\Mail\SendEmailWithGames;
use Illuminate\Console\Command;

class SendEmailWithGamesToUsers extends Command
{
   
    protected $signature = 'app:send-email-with-games-to-users';

    protected $description = 'envia um email com um pdf contendo 10 jogos selecionados aleatórios no banco de dados às 08:00 todos os dias';

    public function handle()
    {
        $products = Product::query()
            ->inRandomOrder()
            ->take(10)
            ->get();

        Mail::to('perozin.arthur@gmail.com', 'Arthur Perozin')
        ->send(new SendEmailWithGames());

      /*  foreach($products as $product){
            Log::info($product->name);
        }
     */
    }
}
