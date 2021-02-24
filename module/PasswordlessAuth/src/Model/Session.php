<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PasswordlessAuth\Model;

/**
 * Description of Session
 *
 * @author renan
 */
class Session
{
    public string $userId;
    public string $token;
    public string $accessToken;
    public string $active;
    public string $purged;
    public string $createdAt;
    
    public static function fromData(array $data): Session {
        $session = new self();
        $session->userId = $data['user_id'];
        $session->token = $data['token'];
        $session->accessToken = $data['access_token'];
        $session->active = $data['active'];
        $session->purged = $data['purged'];
        $session->createdAt = $data['created_at'];
        
        return $session;
    }
}
