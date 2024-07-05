<?php

namespace Unoserver\Converter\Source;

class Document extends AbstractSource
{
    public function isSupportConversionFormat(Format $format): bool
    {
        return \in_array(
            $format,
            [Format::PDF, Format::HTML, Format::DOC, Format::DOCX, Format::EPUB]
        );
    }
}
