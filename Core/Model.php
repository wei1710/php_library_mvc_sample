<?php

/**
 * Base model
 */

namespace Core;

use PDO;
use PDOException;
use App\Config;

abstract class Model
{
    protected static function getDB(): PDO
    {
        static $db = null;

        if ($db === null) {
            try {
                $dsn = 'mysql:host=' . Config::DB_HOST .
                    ';dbname=' . Config::DB_NAME .
                    ';charset=utf8';
                $db = new PDO($dsn, Config::DB_USER, Config::DB_PASSWORD);

                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                throw new \Exception("Error <strong>{$e->getMessage()}</strong> in model " . get_called_class());
            }
        }
        return $db;
    }

    /**
     * For SELECTs, it returns the query results as an associative array.
     * For INSERTs, it returns the new PK value.
     * For DELETEs, it returns whether some row has been affected.
     */
    protected static function execute(string $sql, array $params = []): array|int
    {
        $db = static::getDB();

        if (empty($params)) {
            $stmt = $db->query($sql);
        } else {
            $stmt = $db->prepare($sql);
            foreach ($params as $key => $value) {
                $stmt->bindValue(":{$key}", $value);
            }
            $stmt->execute();
        }

        switch (substr(ltrim($sql), 0, 6)) {
            case 'SELECT':
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            case 'INSERT':
                return $db->lastInsertId();
            case 'DELETE':
                return $stmt->rowCount() > 0;
            default:
                return 0;
        }
    }
}