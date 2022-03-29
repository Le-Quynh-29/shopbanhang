<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Support\AbstractRepository;
use Illuminate\Container\Container;
use Illuminate\Pagination\Paginator;

Paginator::useBootstrap();


class UserRepository extends AbstractRepository
{
    public function model()
    {
        return 'App\Models\User';
    }

    public function __construct(Container $app)
    {
        parent::__construct($app);
    }

    /**
     * Check validate unique name
     *
     * @param mixed $id
     * @param mixed $name
     * @return void
     */
    public function validateUniqueName($id, $name)
    {
        $data = User::where('username', $name);

        if (!is_null($id)) {
            $data = $data->where('id', '<>', $id);
        }
        $data = $data->get();

        if (sizeof($data) == 0) {
            return true;
        }
        return false;
    }

    /**
     * Check validate unique email
     *
     * @param mixed $id
     * @param mixed $email
     * @return void
     */
    public function validateUniqueEmail($id, $email)
    {
        $data = User::where('email', $email);

        if (!is_null($id)) {
            $data = $data->where('id', '<>', $id);
        }
        $data = $data->get();

        if (sizeof($data) == 0) {
            return true;
        }
        return false;
    }
}
