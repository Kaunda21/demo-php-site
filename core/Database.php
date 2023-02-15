<?php

namespace Core;

use PDO;
use Core\Response;

class Database
{
    public $connection;
    public $statement;

    function __construct($config, $username = 'root', $password = '')
    {
        $dsn = "mysql:" . http_build_query($config, '', ';');
        $this->connection = new PDO($dsn, $username, $password, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    function query($query, $options = [])
    {
        $this->statement = $this->connection->prepare($query);
        $this->statement->execute($options);

        return $this;
    }

    public function find()
    {
        return $this->statement->fetch();
    }

    public function findOrFail()
    {
        $result = $this->find();

        if (!$result) {
            abort(Response::NOT_FOUND);
        }

        return $result;
    }

    public function get()
    {
        return $this->statement->fetchAll();
    }
}
