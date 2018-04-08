<?php

namespace JWorksUK;

use PDO;

/**
 * Class ExtraPDO
 * @package JWorksUK
 */
class ExtraPDO extends PDO
{
    /**
     * @var array [int => int|array]
     */
    protected static $defaultOptions = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    /**
     * @param string $db_name
     * @param string $db_host
     * @param string $username
     * @param string $password
     * @param array $options
     * @return ExtraPDO
     */
    public static function createMySqlConnection(
        $db_name,
        $db_host,
        $username = '',
        $password = '',
        array $options = []
    ) {
        return static::create(sprintf('mysql:dbname=%s;host=%s', $db_name, $db_host), $username, $password, $options);
    }

    /**
     * @param string $sqlitePath
     * @param array $options
     * @return ExtraPDO
     */
    public static function createSqliteConnection($sqlitePath, array $options = [])
    {
        return static::create("sqlite:$sqlitePath", '', '', $options);
    }

    /**
     * @param array $options
     * @return ExtraPDO
     */
    public static function createSqliteMemoryConnection(array $options = [])
    {
        return static::create('sqlite::memory:', '', '', $options);
    }

    /**
     * Execute mysql statement with parameters.
     *
     * @param  string $sql
     * @param  array  $parameters
     * @return ExtraPDOStatement
     */
    public function executeStatement($sql, array $parameters = [])
    {
        /** @var ExtraPDOStatement $st */
        $st = $this->prepare($sql);

        $st->execute($parameters);

        return $st;
    }

    /**
     * @param string $dsn
     * @param string $username
     * @param string $password
     * @param array $options
     * @return static
     */
    public static function create($dsn, $username = '', $password = '', array $options = [])
    {
        return new static($dsn, $username, $password, self::addDefaultAttributes($options));
    }

    /**
     * @param array $options
     * @return array
     */
    protected static function addDefaultAttributes($options)
    {
        foreach (self::$defaultOptions as $attribute => $value) {
            if (!isset($options[$attribute])) {
                $options[$attribute] = $value;
            }
        }

        $options[PDO::ATTR_STATEMENT_CLASS] = [ExtraPDOStatement::class];

        return $options;
    }
}
