<?php

namespace Unoserver\Converter;

use Unoserver\Converter\Wrapper\WrapperInterface;
use Unoserver\Converter\Exception\SourceFileNotExistsException;
use Unoserver\Converter\Source\Document;
use Unoserver\Converter\Source\Presentation;
use Unoserver\Converter\Source\Spreadsheet;

class ClientBuilder implements ClientBuilderInterface
{
    public Client $converter;

    /**
     * @param class-string<WrapperInterface> $wrapper
     * @param array<string, mixed>              $options
     */
    public function init(string $wrapper, array $options): self
    {
        $connection = new $wrapper($options);
        $this->converter = new Client($connection);

        return $this;
    }

    /**
     * @throws SourceFileNotExistsException
     */
    public function fromDocument(string $path, bool $deleteSourceFileOnSuccess = false): ClientInterface
    {
        $source = new Document($path, $deleteSourceFileOnSuccess);
        $this->converter->fromSource($source);

        return $this->converter;
    }

    /**
     * @throws SourceFileNotExistsException
     */
    public function fromSpreadsheet(string $path, bool $deleteSourceFileOnSuccess = false): ClientInterface
    {
        $source = new Spreadsheet($path, $deleteSourceFileOnSuccess);
        $this->converter->fromSource($source);

        return $this->converter;
    }

    /**
     * @throws SourceFileNotExistsException
     */
    public function fromPresentation(string $path, bool $deleteSourceFileOnSuccess = false): ClientInterface
    {
        $source = new Presentation($path, $deleteSourceFileOnSuccess);
        $this->converter->fromSource($source);

        return $this->converter;
    }
}
