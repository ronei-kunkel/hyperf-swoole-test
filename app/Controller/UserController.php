<?php declare(strict_types=1);

namespace App\Controller;

use App\Model\User;
use DateTime;
use Hyperf\Coroutine\Parallel;
use Hyperf\HttpServer\Contract\RequestInterface;

class UserController extends AbstractController
{

    private array $retorno = [];

    public function index(RequestInterface $request)
    {

      $start = new DateTime(date("Y-m-d H:i:s:u:v"));

      $parallel = new Parallel();

      $parallel->add(function () {
        $chamado = date("Y-m-d H:i:s:u:v");
        sleep(5);
        $this->retorno[] = [
          'sleep' => '5',
          'chamado' => $chamado,
          'finalizado' => date("Y-m-d H:i:s:u:v")
        ];
      });

      $parallel->add(function () {
        $chamado = date("Y-m-d H:i:s:u:v");
        sleep(4);
        $this->retorno[] =  [
          'sleep' => '4',
          'chamado' => $chamado,
          'finalizado' => date("Y-m-d H:i:s:u:v")
        ];
      });

      $parallel->add(function () {
        $chamado = date("Y-m-d H:i:s:u:v");
        sleep(5);
        $this->retorno[] =  [
          'sleep' => '5',
          'chamado' => $chamado,
          'finalizado' => date("Y-m-d H:i:s:u:v")
        ];
      });

      $parallel->add(function () {
        $chamado = date("Y-m-d H:i:s:u:v");
        sleep(2);
        $this->retorno[] =  [
          'sleep' => '2',
          'chamado' => $chamado,
          'finalizado' => date("Y-m-d H:i:s:u:v")
        ];
      });

      $parallel->add(function () {
        $chamado = date("Y-m-d H:i:s:u:v");
        sleep(1);
        $this->retorno[] =  [
          'sleep' => '1',
          'chamado' => $chamado,
          'finalizado' => date("Y-m-d H:i:s:u:v")
        ];
      });

      $end = new DateTime(date("Y-m-d H:i:s:u:v"));

      $parallel->wait();

      $this->retorno[] = ['total' => (string) $start->diff($end)->f];

      $retorno = $this->retorno;

      $this->retorno = [];

      return $retorno;
    }

    public function show(string $id)
    {
        return User::find($id);
    }

    public function store(RequestInterface $request)
    {
        return User::create($request->all());
    }

    public function delete(string $id)
    {
        return User::destroy($id);
    }
}