<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace App\Infra\Http\Controller;

use Hyperf\Coroutine\Coroutine;
use Hyperf\Coroutine\Parallel;
use Hyperf\HttpServer\Contract\ResponseInterface;

class IndexController extends AbstractController
{
    private int $ordemExecucaoCorrotina;
    private int $ordemFinalizacaoCorrotina;
    private array $retorno = [];
    private array $sleeps = [];
    private array $sleepSequences = [
        0 => [
            0 => 0,
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0
        ],
        1 => [
            0 => 0,
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5
        ],
        2 => [
            0 => 5,
            1 => 4,
            2 => 3,
            3 => 2,
            4 => 1,
            5 => 0
        ],
        3 => [
            0 => 3,
            1 => 0,
            2 => 2,
            3 => 4,
            4 => 1,
            5 => 5
        ],
        4 => [
            0 => 2,
            1 => 2,
            2 => 0,
            3 => 15,
            4 => 1,
            5 => 20
        ],
        5 => [
            0 => 15,
            1 => 10,
            2 => 14,
            3 => 9,
            4 => 18,
            5 => 20
        ]
    ];

    private string $processType = '';

    private function resetParameters(int $sequence = 0, string $process = '')
    {
        $this->processType               = $process;
        $this->retorno                   = [];
        $this->sleeps                    = $this->sleepSequences[$sequence];
        $this->ordemExecucaoCorrotina    = 1;
        $this->ordemFinalizacaoCorrotina = 1;
    }

    private function newExec(int $ordemAdicaoCorrotina)
    {
        $momentoExecucao              = date("Y-m-d H:i:s");
        $ordemExecucaoCorrotina       = $this->ordemExecucaoCorrotina;
        $this->ordemExecucaoCorrotina += 1;

        $sleep = $this->sleeps[$ordemAdicaoCorrotina - 1];
        Coroutine::sleep($sleep);
        $momentoFinalizacao = date('Y-m-d H:i:s');

        $ordemFinalizacaoCorrotina       = $this->ordemFinalizacaoCorrotina;
        $this->ordemFinalizacaoCorrotina += 1;

        $this->retorno[$this->processType][$ordemAdicaoCorrotina] = [
            'tempo_execucao_funcao'                 => $sleep,
            'ordem_chamada_funcao'                  => $ordemAdicaoCorrotina,
            'ordem_execucao_funcao'                 => $ordemExecucaoCorrotina,
            'ordem_finalizacao_execucao_funcao'     => $ordemFinalizacaoCorrotina,
            'data_hora_inicio_execucao_funcao'      => $momentoExecucao,
            'data_hora_finalizacao_execucao_funcao' => $momentoFinalizacao
        ];
    }

    public function parallel(int $sleepSequence = 0)
    {
        $this->resetParameters($sleepSequence, 'parallel');

        $parallel = new Parallel();

        $parallel->add(function () {
            $this->newExec(1);
        });
        $parallel->add(function () {
            $this->newExec(2);
        });
        $parallel->add(function () {
            $this->newExec(3);
        });
        $parallel->add(function () {
            $this->newExec(4);
        });
        $parallel->add(function () {
            $this->newExec(5);
        });
        $parallel->add(function () {
            $this->newExec(6);
        });

        $parallel->wait();

        return $this->retorno;
    }

    public function sequential(int $sleepSequence = 0)
    {

        $this->resetParameters($sleepSequence, 'sequential');

        $this->newExec(1);
        $this->newExec(2);
        $this->newExec(3);
        $this->newExec(4);
        $this->newExec(5);
        $this->newExec(6);

        return $this->retorno;
    }

    public function index(ResponseInterface $response) {
        return $response->redirect('/parallel', 302);
    }
}