# ExtraPDO

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]

A very thin layer over the PDO class.

## Install

Via Composer

``` bash
$ composer require jworksuk/extra-pdo
```
## Usage

``` php
require_once '/path/to/vendor/autoload.php';

use JWorksUK\ExtraPDO;
use Acme\Model;

$pdo = ExtraPDO::createMySqlConnection(
    'databaseName',
    'databaseHost',
    'databaseUser',
    'databasePassword'
);

$model = $pdo
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
$model->doModelThing();

$models = $pdo
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

foreach ($models as $model) {
    $model->doModelThing();
}
```

## Testing

``` bash
$ composer test
```

[ico-version]: https://img.shields.io/packagist/v/jworksuk/extra-pdo.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/jworksuk/extra-pdo/master.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/jworksuk/extra-pdo
[link-travis]: https://travis-ci.org/jworksuk/extra-pdo