<?php
namespace Repositories;

use PDO;
use PDOException;
use Config\DbConfig;

class Repository
{
    protected PDO $connection;

    public function __construct()
    {

        require_once __DIR__ . '/../config/DbConfig.php';

        try {
            $this->connection = new PDO(
                DbConfig::TYPE . ':host=' . DbConfig::SERVERNAME . ';dbname=' . DbConfig::DATABASE,
                DbConfig::USERNAME,
                DbConfig::PASSWORD
            );
                
            // set the PDO error mode to exception
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
          }
    }
}
