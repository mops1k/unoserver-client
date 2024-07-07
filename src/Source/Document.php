<?php

namespace Unoserver\Converter\Source;

class Document extends AbstractSource
{
    public function getSupportedConversionFormats(): array
    {
        return [Format::PDF, Format::HTML, Format::DOC, Format::DOCX, Format::ODT, Format::RTF, Format::EPUB, Format::TXT];
    }
}
