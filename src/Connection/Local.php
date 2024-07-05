<?php

namespace Unoserver\Converter\Connection;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Process\Process;

class Local extends AbstractConnection
{
    public function configure(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'command' => '/usr/bin/unoconvert',
        ]);
    }

    public function process(string $format, string $document, string $outputPath): Process
    {
        return Process::fromShellCommandline(
            implode(' ', [
                $this->options['command'],
                '--convert-to',
                $format,
                '-',
                '-',
                '< '.\escapeshellarg($document),
                '> '.\escapeshellarg($outputPath),
            ]),
        )->setInput($document);
    }
}
