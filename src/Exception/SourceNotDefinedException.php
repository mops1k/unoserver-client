<?php

namespace Unoserver\Converter\Exception;

class SourceNotDefinedException extends \Exception
{
    public function __construct(int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct('Source not defined.', $code, $previous);
    }
}
