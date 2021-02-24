<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PasswordlessAuth\Model;

/**
 * Description of User
 *
 * @author renan
 */
class User
{
    public string $id;
    public string $email;
    
    public static function fromData(array $data): User {
        $user = new self();
        $user->id = $data['id'];
        $user->email = $data['email'];
        
        return $user;
    }
}
