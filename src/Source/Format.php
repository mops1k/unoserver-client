<?php

namespace Unoserver\Converter\Source;

enum Format: string implements FormatInterface
{
    case CSV = 'csv';
    case DOC = 'doc';
    case DOCX = 'docx';
    case EPUB = 'epub';
    case HTML = 'html';
    case ODP = 'odp';
    case ODS = 'ods';
    case ODT = 'odt';
    case PDF = 'pdf';
    case PPT = 'ppt';
    case PPTX = 'pptx';
    case RTF = 'rtf';
    case TXT = 'txt';
    case XLS = 'xls';
    case XLSX = 'xlsx';
}
