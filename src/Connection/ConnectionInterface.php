<?php

namespace Unoserver\Converter\Connection;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Process\Process;

interface ConnectionInterface
{
    public function configure(OptionsResolver $resolver): void;

    public function process(string $format, string $document, string $outputPath): Process;
}
