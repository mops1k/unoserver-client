<?php

namespace Unoserver\Converter\Source;

class Presentation extends AbstractSource
{
    public function getSupportedConversionFormats(): array
    {
        return [Format::PDF, Format::HTML, Format::PPTX, Format::PPT, Format::ODP];
    }
}
