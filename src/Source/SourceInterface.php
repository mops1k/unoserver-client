<?php

namespace Unoserver\Converter\Source;

use Unoserver\Converter\Wrapper\WrapperInterface;
use Unoserver\Converter\Exception\ConversionException;

interface SourceInterface
{
    public function getPath(): string;

    public function isDeletable(): bool;

    public function isSupportConversionFormat(FormatInterface $format): bool;

    /**
     * @throws ConversionException
     */
    public function convert(WrapperInterface $connection, FormatInterface $format): \SplFileInfo;
}
