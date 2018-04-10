<?php

namespace JWorksUK;

use PDOStatement;

/**
 * Class ExtraPDOStatement
 * @package JWorksUK
 */
class ExtraPDOStatement extends PDOStatement
{
    /**
     * @param callable $function
     * @return mixed
     */
    public function fetchAndMap(callable $function)
    {
        $row = $this->fetch();

        if ($row) {
            return $function($row);
        }

        return $row;
    }

    /**
     * @param callable $function
     * @return array
     */
    public function fetchAllAndMap(callable $function)
    {
        return array_map($function, $this->fetchAll());
    }
}
