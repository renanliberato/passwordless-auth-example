<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Db;

use PDO;

/**
 * Description of Connection
 *
 * @author renan
 */
class Connection
{

    public static $instance;
    private PDO $pdo;

    public static function get(string $host, string $db, string $user, string $pass, string $charset)
    {
        if (self::$instance === null) {
            self::$instance = new Connection($host, $db, $user, $pass, $charset);
        }
        
        return self::$instance;
    }

    public function __construct(string $host, string $db, string $user, string $pass, string $charset)
    {
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
    }

    public function queryAll($sql, $parameters = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($parameters);

        return $stmt->fetchAll();
    }

    public function query($sql, $parameters = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($parameters);
        return $stmt->fetch();
    }

    public function execute($sql, $parameters = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($parameters);

        return $stmt->rowCount();
    }

}
