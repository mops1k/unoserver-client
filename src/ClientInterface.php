<?php

namespace Unoserver\Converter;

use Unoserver\Converter\Source\Format;
use Unoserver\Converter\Source\SourceInterface;

interface ClientInterface
{
    public function fromSource(SourceInterface $source): self;

    public function toFormat(string|Format $format): self;

    public function convert(): \SplFileInfo;
}
