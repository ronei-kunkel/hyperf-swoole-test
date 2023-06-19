<?php declare(strict_types=1);

namespace App\Infra\Http\Controller;

use App\Model\User;
use DateTime;
use Hyperf\Coroutine\Parallel;
use Hyperf\HttpServer\Contract\RequestInterface;

class UserController extends AbstractController
{

    public function index(RequestInterface $request)
    {
      return [];
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