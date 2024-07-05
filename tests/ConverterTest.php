<?php

namespace Unoserver\Converter\Test;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Unoserver\Converter\Connection\ConnectionInterface;
use Unoserver\Converter\Connection\Local;
use Unoserver\Converter\Connection\Remote;
use Unoserver\Converter\Converter;
use Unoserver\Converter\ConverterFactory;
use Unoserver\Converter\ConverterFactoryInterface;
use Unoserver\Converter\ConverterInterface;
use Unoserver\Converter\Exception\ConversionException;
use Unoserver\Converter\Exception\FormatNotSupportedException;
use Unoserver\Converter\Exception\SourceFileNotExistsException;
use Unoserver\Converter\Exception\SourceNotDefinedException;
use Unoserver\Converter\Source\Document;
use Unoserver\Converter\Source\Format;

class ConverterTest extends TestCase
{
    /**
     * @param int|list<int> $size
     *
     * @throws SourceNotDefinedException
     * @throws \Exception
     */
    #[DataProvider('dataProvider')]
    public function testConverterRemote(
        string $path,
        string $type,
        string|Format $format,
        int|array $size,
        string $mimeType
    ): void {
        $this->runConverterTester(
            Remote::class,
            $path,
            $type,
            $format,
            $size,
            $mimeType
        );
    }

    /**
     * @param int|list<int> $size
     *
     * @throws SourceNotDefinedException
     * @throws \Exception
     */
    #[DataProvider('dataProvider')]
    public function testConverterLocal(
        string $path,
        string $type,
        string|Format $format,
        int|array $size,
        string $mimeType
    ): void {
        $this->runConverterTester(
            Local::class,
            $path,
            $type,
            $format,
            $size,
            $mimeType
        );
    }

    public function testBadFormatEnum(): void
    {
        $this->expectException(FormatNotSupportedException::class);
        $this->expectExceptionMessage('The format "php" is not supported by source Unoserver\Converter\Source\Document.');
        $options['host'] = 'unoserver';
        $factory = new ConverterFactory();
        $factory->initConverter(Remote::class, $options);
        $converter = $factory->fromDocument(__DIR__.'/Stubs/Document.docx');
        $converter->toFormat('php');
    }

    public function testBadFormatDocument(): void
    {
        $this->expectException(FormatNotSupportedException::class);
        $this->expectExceptionMessage('The format "xlsx" is not supported by source Unoserver\Converter\Source\Document.');
        $options['host'] = 'unoserver';
        $factory = new ConverterFactory();
        $factory->initConverter(Remote::class, $options);
        $converter = $factory->fromDocument(__DIR__.'/Stubs/Document.docx');
        $converter->toFormat(Format::XLSX);
    }

    public function testProcessFailed(): void
    {
        $this->expectException(ConversionException::class);
        $this->expectExceptionMessage('Conversion process failed.');
        $options['command'] = '/somewhere/unoserver';
        $factory = new ConverterFactory();
        $factory->initConverter(Local::class, $options);
        $converter = $factory->fromDocument(__DIR__.'/Stubs/Document.docx');
        $converter->toFormat(Format::EPUB);
        $converter->convert();
    }

    public function testNoSource(): void
    {
        $this->expectException(SourceNotDefinedException::class);
        $this->expectExceptionMessage('Source not defined.');
        $connection = new Remote(['host' => 'unoserver']);
        $converter = new Converter($connection);
        $converter->convert();
    }

    public function testSourceFileDoesNotExists(): void
    {
        $this->expectException(SourceFileNotExistsException::class);
        $this->expectExceptionMessage('Source file "/not/exists/file.docx" does not exists.');
        new Document('/not/exists/file.docx');
    }

    /**
     * @param class-string<ConnectionInterface> $connection
     * @param int|list<int>                     $size
     *
     * @throws SourceNotDefinedException
     */
    private function runConverterTester(
        string $connection,
        string $path,
        string $type,
        string|Format $format,
        int|array $size,
        string $mimeType
    ): void {
        $options = [];
        if (Remote::class === $connection) {
            $options['host'] = 'unoserver';
        }
        $factory = new ConverterFactory();

        // ==> start mocks init
        //        $filename = \pathinfo($path, PATHINFO_FILENAME);
        //        $convertedExtension = ($format instanceof Format) ? $format->value : $format;
        //        /** @var ConverterInterface $converter */
        //        $converter = self::getMockBuilder(Converter::class)->disableOriginalConstructor()->getMock();
        //        $converter->method('convert')->willReturn(
        //            new \SplFileInfo(__DIR__.'/Stubs/Converted/'.$filename.'.'.$convertedExtension)
        //        );
        //        /** @var ConverterFactoryInterface $factory */
        //        $factory = self::getMockBuilder(ConverterFactory::class)->getMock();
        //        $factory->method('initConverter')->with($connection, $options)->willReturn($factory);
        //        $factory->method('fromDocument')->willReturn($converter);
        //        $factory->method('fromSpreadsheet')->willReturn($converter);
        // <== end mocks init

        $factory->initConverter($connection, $options);
        $converter = null;
        switch ($type) {
            case 'document':
                $converter = $factory->fromDocument($path);
                break;
            case 'spreadsheet':
                $converter = $factory->fromSpreadsheet($path);
                break;
        }
        if (null === $converter) {
            $this->markTestSkipped('No type provided.');
        }

        $converter->toFormat($format);
        $file = $converter->convert();

        self::assertTrue($file->isFile());
        self::assertEquals('file', $file->getType());
        if (is_array($size)) {
            self::assertContains($file->getSize(), $size);
        } else {
            self::assertEquals($size, $file->getSize());
        }
        self::assertEquals($mimeType, \mime_content_type($file->getPathname()));
    }

    public static function dataProvider(): \Generator
    {
        yield 'Convert document to pdf' => [
            'path' => __DIR__.'/Stubs/Document.docx',
            'type' => 'document',
            'format' => Format::PDF,
            'size' => 8043,
            'mimeType' => 'application/pdf',
        ];
        yield 'Convert document to html' => [
            'path' => __DIR__.'/Stubs/Document.docx',
            'type' => 'document',
            'format' => Format::HTML,
            'size' => 610,
            'mimeType' => 'text/html',
        ];
        yield 'Convert document to epub' => [
            'path' => __DIR__.'/Stubs/Document.docx',
            'type' => 'document',
            'format' => Format::EPUB,
            'size' => [2336, 2337, 2338, 2339],
            'mimeType' => 'application/epub+zip',
        ];
        yield 'Convert document to doc' => [
            'path' => __DIR__.'/Stubs/Document.docx',
            'type' => 'document',
            'format' => Format::DOC,
            'size' => 10240,
            'mimeType' => 'application/msword',
        ];
        yield 'Convert spreadsheet to pdf' => [
            'path' => __DIR__.'/Stubs/Spreadsheet.xlsx',
            'type' => 'spreadsheet',
            'format' => Format::PDF,
            'size' => 7566,
            'mimeType' => 'application/pdf',
        ];
        yield 'Convert spreadsheet to html' => [
            'path' => __DIR__.'/Stubs/Spreadsheet.xlsx',
            'type' => 'spreadsheet',
            'format' => Format::HTML,
            'size' => 1059,
            'mimeType' => 'text/html',
        ];
        yield 'Convert spreadsheet to csv' => [
            'path' => __DIR__.'/Stubs/Spreadsheet.xlsx',
            'type' => 'spreadsheet',
            'format' => Format::CSV,
            'size' => 17,
            'mimeType' => 'text/plain',
        ];
        yield 'Convert spreadsheet to xls' => [
            'path' => __DIR__.'/Stubs/Spreadsheet.xlsx',
            'type' => 'spreadsheet',
            'format' => Format::XLS,
            'size' => 5632,
            'mimeType' => 'application/vnd.ms-excel',
        ];
    }
}
