<?php

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use App\Controller\DatabaseTestController;

return function (ContainerConfigurator $configurator) {
    $services = $configurator->services();

    // Configura os serviços padrões
    $services
        ->defaults()
        ->autowire(true)      // Injeção automática de dependências
        ->autoconfigure(true); // Registro automático como comandos, assinantes de eventos, etc.

    // Registra automaticamente todos os serviços no diretório src
    $services->load('App\\', '../src/')
        ->exclude([
            '../src/DependencyInjection/',
            '../src/Entity/',
            '../src/Kernel.php',
        ]);

    // Define o controlador DatabaseTestController como um serviço explícito
    $services->set(DatabaseTestController::class)
        ->public();  // Torna o serviço público para ser usado nas rotas
};
