<?php

namespace Unoserver\Converter;

use Unoserver\Converter\Connection\ConnectionInterface;
use Unoserver\Converter\Source\Document;
use Unoserver\Converter\Source\Spreadsheet;

class ClientBuilder implements ClientBuilderInterface
{
    public Client $converter;

    /**
     * @param class-string<ConnectionInterface> $connectionTypeName
     * @param array<string, mixed>              $options
     */
    public function init(string $connectionTypeName, array $options): self
    {
        $connection = new $connectionTypeName($options);
        $this->converter = new Client($connection);

        return $this;
    }

    public function fromDocument(string $path, bool $deleteSourceFileOnSuccess = false): ClientInterface
    {
        $source = new Document($path, $deleteSourceFileOnSuccess);
        $this->converter->fromSource($source);

        return $this->converter;
    }

    public function fromSpreadsheet(string $path, bool $deleteSourceFileOnSuccess = false): ClientInterface
    {
        $source = new Spreadsheet($path, $deleteSourceFileOnSuccess);
        $this->converter->fromSource($source);

        return $this->converter;
    }
}
