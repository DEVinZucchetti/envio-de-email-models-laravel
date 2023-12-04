<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarEmail;
use App\Models\Product;
use Exception;

class SendEmailToUsers extends Command
{
    protected $signature = 'app:send-email-to-users';
    protected $description = 'Envia e-mail diário com lista de sugestões de jogos aos usuários';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Iniciando o envio de e-mail programado...');

        // Obtenha a lista de sugestões de jogos
        $jogosSugeridos = $this->obterJogosAleatorios(10);

        // Crie a instância do e-mail
        $email = new EnviarEmail($jogosSugeridos);

        // Envie o e-mail para os usuários (substitua pelo lógica real para obter os usuários)
        $usuarios = $this->obterUsuarios(); // Substitua pela lógica real para obter os usuários

        foreach ($usuarios as $usuario) {
            Mail::to($usuario->email)->send($email);
        }

        $this->info('E-mails enviados com sucesso!');
    }

    private function obterJogosAleatorios($quantidade)
    {
        try {
            // Lógica para obter 10 jogos aleatórios
            // Usando o controlador ProductController
            $products = Product::inRandomOrder()->limit($quantidade)->get();

            // Obtendo apenas o nome dos produtos
            $jogos = $products->pluck('name');

            return $jogos;
        } catch (Exception $exception) {
            $this->error('Erro ao obter jogos: ' . $exception->getMessage());
            return [];
        }
    }
}
