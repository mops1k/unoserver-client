<?php

namespace Unoserver\Converter;

use Unoserver\Converter\Source\Format;
use Unoserver\Converter\Source\SourceInterface;

interface ConverterInterface
{
    public function fromSource(SourceInterface $source);

    public function toFormat(string|Format $format): self;

    public function convert(): \SplFileInfo;
}
