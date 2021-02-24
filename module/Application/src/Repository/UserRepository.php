<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Repository;

use Application\Db\Connection;
use PasswordlessAuth\Model\User;

/**
 * Description of UserRepository
 *
 * @author renan
 */
class UserRepository implements \PasswordlessAuth\Repository\UserRepositoryInterface
{

    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getFromEmail(string $email): ?User
    {
        $data = $this->connection->query('select * from user where email = ?', [$email]);

        if ($data === false)
            return null;
        
        return User::fromData($data);
    }

    public function getFromId(string $id): ?User
    {
        $data = $this->connection->query('select * from user where id = ?', [$id]);

        if ($data === false)
            return null;

        return User::fromData($data);
    }

    public function createUser(string $id, string $name, string $email)
    {
        $this->connection->query('insert into user values (?, ?, ?, CURRENT_TIME())', [
            $id,
            $email,
            $name,
        ]);
    }

}
