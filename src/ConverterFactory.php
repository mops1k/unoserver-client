<?php

namespace Unoserver\Converter;

use Unoserver\Converter\Connection\ConnectionInterface;
use Unoserver\Converter\Source\Document;
use Unoserver\Converter\Source\Spreadsheet;

class ConverterFactory implements ConverterFactoryInterface
{
    public Converter $converter;

    /**
     * @param class-string<ConnectionInterface> $connectionTypeName
     * @param array<string, mixed>              $options
     */
    public function initConverter(string $connectionTypeName, array $options): self
    {
        $connection = new $connectionTypeName($options);
        $this->converter = new Converter($connection);

        return $this;
    }

    public function fromDocument(string $path, bool $deleteSourceFileOnSuccess = false): ConverterInterface
    {
        $source = new Document($path, $deleteSourceFileOnSuccess);
        $this->converter->fromSource($source);

        return $this->converter;
    }

    public function fromSpreadsheet(string $path, bool $deleteSourceFileOnSuccess = false): ConverterInterface
    {
        $source = new Spreadsheet($path, $deleteSourceFileOnSuccess);
        $this->converter->fromSource($source);

        return $this->converter;
    }
}
