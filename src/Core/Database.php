<?php
namespace App\Core;

class Database
{
    private $host;
    private $name;
    private $user;
    private $password;
    private $charset;

    public function __construct()
    {
        $this->host = $_ENV['DB_HOST'];
        $this->name = $_ENV['DB_NAME'];
        $this->user = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->charset = $_ENV['DB_CHARSET'];
    }

    private $options = [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES => false,
    ];

    private static $instance = null;

    public function getConnection() {
        if (self::$instance === null) {
            self::$instance = new \PDO(
                "mysql:host={$this->host};dbname={$this->name};charset={$this->charset}",
                $this->user,
                $this->password,
                $this->options
            );
        }
        return self::$instance;
    }
}
