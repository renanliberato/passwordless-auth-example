<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PasswordlessAuth\Service;

use Laminas\Mail\Transport\Smtp;
use PasswordlessAuth\Repository\UserRepositoryInterface;
use PasswordlessAuth\Repository\SessionRepositoryInterface;

/**
 * Description of AuthService
 *
 * @author renan
 */
class AuthService
{

    const USERID_COOKIENAME = 'passwordlessauth_userid';

    private UserRepositoryInterface $userRepository;
    private SessionRepositoryInterface $sessionRepository;
    private Smtp $mailTransport;

    public function __construct(UserRepositoryInterface $userRepository, SessionRepositoryInterface $sessionRepository, Smtp $mailTransport)
    {
        $this->userRepository = $userRepository;
        $this->sessionRepository = $sessionRepository;
        $this->mailTransport = $mailTransport;
    }

    public function logout(): void
    {
        $this->sessionRepository->markSessionAsPurged($_COOKIE[self::USERID_COOKIENAME]);
        
        unset($_COOKIE[self::USERID_COOKIENAME]);
        setcookie(self::USERID_COOKIENAME, null, -1, '/');
    }

    public function isLoggedIn(): bool
    {
        $cookieValue = $_COOKIE[self::USERID_COOKIENAME] ?? null;

        return $cookieValue != null && $this->sessionRepository->getActiveSessionFromAccessToken($cookieValue) != null;
    }
    
    public function getSessions(): array
    {
        $cookieValue = $_COOKIE[self::USERID_COOKIENAME] ?? null;
        
        if ($cookieValue == null)
            return [];
        
        $currentSession = $this->sessionRepository->getActiveSessionFromAccessToken($cookieValue);
        
        if ($currentSession == null)
            return [];
        
        return $this->sessionRepository->getSessions($currentSession);
    }

    public function authenticate(string $email): void
    {
        $userWithEmail = $this->userRepository->getFromEmail($email);

        if ($userWithEmail === null)
            throw new \Exception("user not found");

        $token = random_int(1111, 9999);
        $accessToken = uniqid();

        $this->sessionRepository->createSession($userWithEmail->id, $token, $accessToken);

        $this->sendValidateTokenMail($token, $email);
    }

    public function register(string $email, string $name): void
    {
        $userWithEmail = $this->userRepository->getFromEmail($email);

        if ($userWithEmail !== null)
            throw new \Exception('email already existent');

        $token = random_int(1111, 9999);
        $id = uniqid();

        $this->userRepository->createUser($id, $name, $email);

        $accessToken = uniqid();
        $this->sessionRepository->createSession($id, $token, $accessToken);

        $this->sendValidateTokenMail($token, $email);
    }

    public function validateToken(string $email, string $token): void
    {
        $userWithEmail = $this->userRepository->getFromEmail($email);

        if ($userWithEmail === null)
            throw new \Exception('email non existent');

        $session = $this->sessionRepository->getSessionFromUserAndToken($userWithEmail->id, $token);

        if (!$session) {
            throw new \Exception('user not found');
        }

        $this->sessionRepository->markSessionAsActive($session->accessToken);

        setcookie(self::USERID_COOKIENAME, $session->accessToken, time() + (86400 * 30), "/");
    }

    public function disconnect(string $accessToken): void
    {
        $this->sessionRepository->markSessionAsPurged($accessToken);
    }

    private function sendValidateTokenMail($token, $email)
    {
        $message = new \Laminas\Mail\Message();
        $message->addTo($email);
        $message->addFrom('me@renanliberato.com.br');
        $message->setSubject('Welcome!');

        $mimeMessage = new \Laminas\Mime\Message();
        $html = new \Laminas\Mime\Part("<p>Here is your code to authenticate:</p><p>{$token}</p>");
        $html->type = \Laminas\Mime\Mime::TYPE_HTML;
        $html->charset = 'utf-8';
        $html->encoding = \Laminas\Mime\Mime::ENCODING_QUOTEDPRINTABLE;
        $mimeMessage->setParts([$html]);

        $message->setBody($mimeMessage);

        $this->mailTransport->send($message);
    }

}
