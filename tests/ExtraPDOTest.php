<?php

namespace JWorksUK;

use JWorksUK\Acme\Model;
use PDO;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class ExtraPDOTest extends TestCase
{

    public function extraPdoProvider()
    {
        return [
            [ExtraPDO::createSqliteConnection(__DIR__.'/test.db')],
            [ExtraPDO::createMySqlConnection($_ENV['DB_NAME'], $_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'])],
            [ExtraPDO::createSqliteMemoryConnection()],
        ];
    }

    /**
     * @test
     */
    public function createSqliteMemoryConnection()
    {
        $connection = ExtraPDO::createSqliteMemoryConnection();
        Assert::assertInstanceOf(PDO::class, $connection);
        Assert::assertInstanceOf(ExtraPDO::class, $connection);
        Assert::assertEquals('sqlite', $connection->getAttribute(PDO::ATTR_DRIVER_NAME));
    }

    /**
     * @test
     */
    public function createSqliteConnection()
    {
        $connection = ExtraPDO::createSqliteConnection(__DIR__.'/test.db');
        Assert::assertInstanceOf(PDO::class, $connection);
        Assert::assertInstanceOf(ExtraPDO::class, $connection);
        Assert::assertEquals('sqlite', $connection->getAttribute(PDO::ATTR_DRIVER_NAME));
    }

    /**
     * @test
     */
    public function createMySqlConnection()
    {
        $connection = ExtraPDO::createMySqlConnection(
            $_ENV['DB_NAME'],
            $_ENV['DB_HOST'],
            $_ENV['DB_USER'],
            $_ENV['DB_PASS']
        );
        Assert::assertInstanceOf(PDO::class, $connection);
        Assert::assertInstanceOf(ExtraPDO::class, $connection);
        Assert::assertEquals('mysql', $connection->getAttribute(PDO::ATTR_DRIVER_NAME));
    }

    /**
     * @test
     */
    public function createWithOptions()
    {
        $pdo = ExtraPDO::createSqliteMemoryConnection([
            PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT
        ]);

        Assert::assertInstanceOf(ExtraPDO::class, $pdo);
        Assert::assertEquals(PDO::ERRMODE_SILENT, $pdo->getAttribute(PDO::ATTR_ERRMODE));
        Assert::assertEquals(PDO::FETCH_ASSOC, $pdo->getAttribute(PDO::ATTR_DEFAULT_FETCH_MODE));
        Assert::assertEquals([ExtraPDOStatement::class], $pdo->getAttribute(PDO::ATTR_STATEMENT_CLASS));
    }

    /**
     * @dataProvider extraPdoProvider
     * @test
     * @param ExtraPDO $pdo
     */
    public function extraPdoStatement(ExtraPDO $pdo)
    {
        $pdo->exec(file_get_contents(__DIR__.'/test.sql'));

        $row = $pdo
            ->executeStatement('SELECT * FROM todos WHERE id=:id', [
                'id' => '15983acf-022f-303a-bfef-a096eaebbf7c'
            ])
            ->fetchAndMap(function ($row) {
                return new Model(
                    $row['id'],
                    $row['name'],
                    $row['list_id'],
                    new \DateTime($row['updated_at']),
                    new \DateTime($row['created_at'])
                );
            });
        Assert::assertInstanceOf(Model::class, $row);
        Assert::assertEquals('amet', $row->getName());

        $rows = $pdo
            ->executeStatement('SELECT * FROM todos WHERE list_id=:listId', [
                'listId' => '05aab6f6-e991-3c59-a980-832cca75c578'
            ])
            ->fetchAllAndMap(function ($row) {
                return new Model(
                    $row['id'],
                    $row['name'],
                    $row['list_id'],
                    new \DateTime($row['updated_at']),
                    new \DateTime($row['created_at'])
                );
            });
        Assert::assertTrue(is_array($rows));
        Assert::assertCount(10, $rows);
    }
}
