<?php

namespace Unoserver\Converter;

use Unoserver\Converter\Wrapper\WrapperInterface;
use Unoserver\Converter\Exception\ConversionException;
use Unoserver\Converter\Exception\FormatNotSupportedException;
use Unoserver\Converter\Exception\SourceNotDefinedException;
use Unoserver\Converter\Source\Format;
use Unoserver\Converter\Source\FormatInterface;
use Unoserver\Converter\Source\SourceInterface;

class Client implements ClientInterface
{
    protected WrapperInterface $connection;

    public function __construct(WrapperInterface $connection)
    {
        $this->connection = $connection;
    }

    protected ?SourceInterface $sourceFile = null;
    protected FormatInterface $format = Format::PDF;

    public function fromSource(SourceInterface $source): self
    {
        $this->sourceFile = $source;

        return $this;
    }

    /**
     * Specify what format you want to convert your source file to.
     *
     * @throws \Exception
     */
    public function toFormat(string|FormatInterface $format): self
    {
        try {
            $formatEnum = $format;
            if (is_string($format)) {
                $formatEnum = Format::from($format);
            }
            if (!$format instanceof \BackedEnum) {
                throw new \InvalidArgumentException(\sprintf(
                    'Format must be type of string or enum, %s given.',
                    gettype($format),
                ));
            }
            if (!$this->sourceFile->isSupportConversionFormat($formatEnum)) {
                throw new FormatNotSupportedException(\sprintf(
                    'The format "%s" is not supported by source %s.',
                    $format->value,
                    $this->sourceFile::class
                ));
            }

            $this->format = $formatEnum;

            return $this;
        } catch (\ValueError) {
            throw new FormatNotSupportedException(\sprintf(
                'The format "%s" is not supported by source %s.',
                /* @phpstan-ignore-next-line */
                (!$format instanceof Format) ? $format : $format->value,
                $this->sourceFile::class
            ));
        }
    }

    /**
     * Converts the source file to the specified format.
     *
     * @throws ConversionException
     * @throws SourceNotDefinedException
     */
    public function convert(): \SplFileInfo
    {
        if (null === $this->sourceFile) {
            throw new SourceNotDefinedException();
        }

        return $this->sourceFile->convert($this->connection, $this->format);
    }
}
