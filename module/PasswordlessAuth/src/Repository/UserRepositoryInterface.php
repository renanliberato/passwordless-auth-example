<?php

namespace PasswordlessAuth\Repository;

use PasswordlessAuth\Model\User;

/**
 * Description of UserRepository
 *
 * @author renan
 */
interface UserRepositoryInterface
{

    function getFromEmail(string $email): ?User;

    function getFromId(string $id): ?User;

    function createUser(string $id, string $name, string $email);

}
