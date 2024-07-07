<?php

namespace Unoserver\Converter;

use Unoserver\Converter\Wrapper\WrapperInterface;

interface ClientBuilderInterface
{
    /**
     * @param class-string<WrapperInterface> $wrapper
     * @param array<string, mixed>              $options
     */
    public function init(string $wrapper, array $options): self;

    public function fromDocument(string $path, bool $deleteSourceFileOnSuccess = false): ClientInterface;

    public function fromSpreadsheet(string $path, bool $deleteSourceFileOnSuccess = false): ClientInterface;

    public function fromPresentation(string $path, bool $deleteSourceFileOnSuccess = false): ClientInterface;
}
