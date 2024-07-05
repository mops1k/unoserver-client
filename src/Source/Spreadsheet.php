<?php

namespace Unoserver\Converter\Source;

class Spreadsheet extends AbstractSource
{
    public function isSupportConversionFormat(Format $format): bool
    {
        return \in_array(
            $format,
            [Format::PDF, Format::HTML, Format::XLS, Format::XLSX, Format::CSV]
        );
    }
}
