<?php

namespace Unoserver\Converter;

use Unoserver\Converter\Connection\ConnectionInterface;

interface ClientBuilderInterface
{
    /**
     * @param class-string<ConnectionInterface> $connectionTypeName
     * @param array<string, mixed>              $options
     */
    public function init(string $connectionTypeName, array $options): self;

    public function fromDocument(string $path, bool $deleteSourceFileOnSuccess = false): ClientInterface;

    public function fromSpreadsheet(string $path, bool $deleteSourceFileOnSuccess = false): ClientInterface;
}
