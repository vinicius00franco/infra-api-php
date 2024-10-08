<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DatabaseTestController
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    #[Route('/test-databases', name: 'test_databases')]
    public function testDatabases(): JsonResponse
    {
        // Testando a conexão MySQL
        try {

            /** @var EntityManager $mysqlEntityManager */
            $mysqlEntityManager = $this->doctrine->getManager('mysql'); // Obtém o EntityManager para MySQL
            $mysqlConnection = $mysqlEntityManager->getConnection()->connect();
            $mysqlStatus = $mysqlConnection ? 'MySQL Conectado' : 'Falha na conexão MySQL';
        } catch (\Exception $e) {
            $mysqlStatus = 'Erro MySQL: ' . $e->getMessage();
        }

        // Testando a conexão PostgreSQL
        try {
            
            /** @var EntityManager $postgresqlEntityManager  */
            $postgresqlEntityManager = $this->doctrine->getManager('postgres'); // Obtém o EntityManager para PostgreSQL
            $postgresqlConnection = $postgresqlEntityManager->getConnection()->connect();
            $postgresqlStatus = $postgresqlConnection ? 'PostgreSQL Conectado' : 'Falha na conexão PostgreSQL';
        } catch (\Exception $e) {
            $postgresqlStatus = 'Erro PostgreSQL: ' . $e->getMessage();
        }

        // Retornando os resultados
        return new JsonResponse([
            'mysql' => $mysqlStatus,
            'postgresql' => $postgresqlStatus,
        ]);
    }
}
