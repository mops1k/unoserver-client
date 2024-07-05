<?php

namespace Unoserver\Converter\Exception;

class SourceFileNotExistsException extends \Exception
{
    public function __construct(string $path = '', int $code = 0, ?\Throwable $previous = null)
    {
        $message = sprintf(
            'Source file "%s" does not exists.',
            $path,
        );
        parent::__construct($message, $code, $previous);
    }
}
