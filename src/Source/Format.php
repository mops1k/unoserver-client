<?php

namespace Unoserver\Converter\Source;

enum Format: string
{
    case PDF = 'pdf';
    case HTML = 'html';
    case DOC = 'doc';
    case DOCX = 'docx';
    case EPUB = 'epub';
    case XLS = 'xls';
    case XLSX = 'xlsx';
    case CSV = 'csv';
}
