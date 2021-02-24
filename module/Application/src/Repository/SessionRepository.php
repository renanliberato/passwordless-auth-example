<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Repository;

use Application\Db\Connection;
use PasswordlessAuth\Model\Session;

/**
 * Description of SessionRepository
 *
 * @author renan
 */
class SessionRepository implements \PasswordlessAuth\Repository\SessionRepositoryInterface
{

    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function createSession(string $userId, string $token, string $accessToken)
    {
        $this->connection->execute('insert into session values (?,?,?,0,0, CURRENT_TIMESTAMP())', [
            $userId,
            $token,
            $accessToken
        ]);
    }

    public function getSessionFromUserAndToken(string $userId, string $token): ?Session
    {
        $data = $this->connection->query('select * from session where user_id = ? and token = ? and active = 0', [$userId, $token]);

        if ($data === false)
            return null;

        return Session::fromData($data);
    }

    public function markSessionAsActive(string $accessToken)
    {
        $this->connection->execute('update session set active = 1 where access_token = ?', [$accessToken]);
    }
    
    public function markSessionAsPurged(string $accessToken)
    {
        $this->connection->execute('update session set purged = 1 where access_token = ?', [$accessToken]);
    }
    
    public function getSessions(Session $session): array
    {
        $list = $this->connection->queryAll('select * from session where user_id = ? and active = 1 order by created_at desc', [$session->userId]);

        if ($list === false)
            return [];
        
        return array_map(function ($data) {
            return Session::fromData($data);
        }, $list);
    }

    public function getActiveSessionFromAccessToken(string $accessToken): ?Session
    {
        $data = $this->connection->query('select * from session where access_token = ? and active = 1 and purged = 0', [$accessToken]);

        if ($data === false)
            return null;

        return Session::fromData($data);
    }

}
