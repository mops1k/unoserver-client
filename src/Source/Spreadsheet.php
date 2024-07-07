<?php

namespace Unoserver\Converter\Source;

class Spreadsheet extends AbstractSource
{
    public function getSupportedConversionFormats(): array
    {
        return [Format::PDF, Format::HTML, Format::XLS, Format::XLSX, Format::ODS, Format::CSV];
    }
}
