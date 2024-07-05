<?php

namespace Unoserver\Converter\Source;

use Unoserver\Converter\Connection\ConnectionInterface;
use Unoserver\Converter\Exception\ConversionException;

interface SourceInterface
{
    public function getPath(): string;

    public function isDeletable(): bool;

    public function isSupportConversionFormat(Format $format): bool;

    /**
     * @throws ConversionException
     */
    public function convert(ConnectionInterface $connection, Format $format): \SplFileInfo;
}
