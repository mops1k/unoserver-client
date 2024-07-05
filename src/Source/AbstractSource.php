<?php

namespace Unoserver\Converter\Source;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Unoserver\Converter\Connection\ConnectionInterface;
use Unoserver\Converter\Exception\ConversionException;
use Unoserver\Converter\Exception\SourceFileNotExistsException;

abstract class AbstractSource implements SourceInterface
{
    /**
     * @throws SourceFileNotExistsException
     */
    public function __construct(
        protected string $filepath,
        protected bool $isDeletable = true,
    ) {
        if (!file_exists($this->filepath)) {
            throw new SourceFileNotExistsException($this->filepath);
        }
    }

    public function getPath(): string
    {
        return $this->filepath;
    }

    public function isDeletable(): bool
    {
        return $this->isDeletable;
    }

    /**
     * @throws ConversionException
     */
    public function convert(ConnectionInterface $connection, Format $format): \SplFileInfo
    {
        $tempFile = tempnam('/tmp', 'UNOCONVERT_');

        try {
            $connection
                ->process($format->value, $this->getPath(), $tempFile)
                ->setTimeout(30)
                ->mustRun();
        } catch (ProcessFailedException $processFailedException) {
            throw new ConversionException(previous: $processFailedException);
        }

        if ($this->isDeletable()) {
            unlink($this->getPath());
        }

        return new \SplFileInfo($tempFile);
    }
}
