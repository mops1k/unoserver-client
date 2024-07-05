<?php

namespace Unoserver\Converter;

use Unoserver\Converter\Connection\ConnectionInterface;

interface ConverterFactoryInterface
{
    /**
     * @param class-string<ConnectionInterface> $connectionTypeName
     * @param array<string, mixed>              $options
     */
    public function initConverter(string $connectionTypeName, array $options): self;

    public function fromDocument(string $path, bool $deleteSourceFileOnSuccess = false): ConverterInterface;

    public function fromSpreadsheet(string $path, bool $deleteSourceFileOnSuccess = false): ConverterInterface;
}
