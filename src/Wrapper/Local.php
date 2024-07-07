<?php

namespace Unoserver\Converter\Wrapper;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;

class Local extends AbstractWrapper
{
    public function configure(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'command' => null,
        ]);
    }

    public function process(string $format, string $document, string $outputPath): Process
    {
        return Process::fromShellCommandline(
            implode(' ', [
                $this->options['command'] ?? (new ExecutableFinder())->find('unoconvert'),
                '--host-location',
                'local',
                '--host',
                '127.0.0.1',
                '--port',
                2003,
                '--convert-to',
                '-',
                '-',
                '<',
                \escapeshellarg($document),
                '>>',
                \escapeshellarg($outputPath),
            ]),
        )->setInput($document);
    }
}
