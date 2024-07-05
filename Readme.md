## Unoserver conversion client library
Simple library to run unoconvert inside your php applications.

### Installation
```bash
composer require mops1k/unoserver-client
```

### Usage example

1. From document:
```php
<?php
use Unoserver\Converter\ClientBuilder;
use Unoserver\Converter\Connection\Remote;
use Unoserver\Converter\Source\Format;

$builder = new ClientBuilder();
$builder->init(Remote::class, [
    'command' => '/usr/bin/unoconvert', // path to unoconvert binary
    'host' => '127.0.0.1', // remote unoserver host
    'port' => 2003, // remote unoserver port
]);
$client = $builder->fromDocument('/document/path.docx'); // set path to file convert from
$client->toFormat(Format::PDF); // set format to convert to
$file = $client->convert(); // will return \SplFileInfo object with converted file
```
2. From spreadsheet:
```php
<?php
use Unoserver\Converter\ClientBuilder;
use Unoserver\Converter\Connection\Remote;
use Unoserver\Converter\Source\Format;

$builder = new ClientBuilder();
$builder->init(Remote::class, [
    'command' => '/usr/bin/unoconvert', // path to unoconvert binary
    'host' => '127.0.0.1', // remote unoserver host
    'port' => 2003, // remote unoserver port
]);
$client = $builder->fromSpreadsheet('/document/path.xlsx'); // set path to file convert from
$client->toFormat(Format::PDF); // set format to convert to
$file = $client->convert(); // will return \SplFileInfo object with converted file
```

More docs soon...
