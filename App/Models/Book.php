<?php

namespace App\Models;

use PDO;
use PDOException;

class Book extends \Core\Model
{
    public static function getAll(): array
    {
        try {
            $sql = <<<'SQL'
                SELECT
                    tbook.nBookID AS book_id,
                    tbook.cTitle AS title,
                    tauthor.cName AS author_first_name,
                    tauthor.cSurname AS author_last_name,
                    tpublishingcompany.cName AS publisher,
                    tbook.nPublishingYear AS publishing_year
                FROM tbook
                    INNER JOIN tauthor
                        ON tbook.nAuthorID = tauthor.nAuthorID
                    INNER JOIN tpublishingcompany
                        ON tbook.nPublishingCompanyID = tpublishingcompany.nPublishingCompanyID
                ORDER BY tbook.cTitle;
            SQL;

            return self::execute($sql);
        } catch (PDOException $e) {
            throw new \Exception("Error <strong>{$e->getMessage()}</strong> in model " . get_called_class());
        }
    }
}