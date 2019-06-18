<?php
namespace App;

use \PDO;

class Connection
{
    public static function getPDO(): PDO
    {
        return  new PDO(
            "mysql:host=" .
                getenv('MYSQL_HOST') .
                ";dbname=" . getenv('MYSQL_DATABASE'),
            getenv('MYSQL_USER'),
            getenv('MYSQL_PASSWORD')
        );
    }
}
