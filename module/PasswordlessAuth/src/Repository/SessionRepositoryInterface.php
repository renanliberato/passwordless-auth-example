<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PasswordlessAuth\Repository;

use PasswordlessAuth\Model\Session;

/**
 * @author renan
 */
interface SessionRepositoryInterface
{
    function createSession(string $userId, string $token, string $accessToken);

    function getSessionFromUserAndToken(string $userId, string $token): ?Session;

    function markSessionAsActive(string $accessToken);
    
    function markSessionAsPurged(string $accessToken);
    
    function getSessions(Session $session): array;

    function getActiveSessionFromAccessToken(string $accessToken): ?Session;
}
