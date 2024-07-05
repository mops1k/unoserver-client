<?php

namespace Unoserver\Converter\Exception;

class ConversionException extends \RuntimeException
{
    public function __construct(
        string $message = 'Conversion process failed.',
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
