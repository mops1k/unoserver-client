<?php

namespace Unoserver\Converter\Wrapper;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Process\Process;

interface WrapperInterface
{
    public function configure(OptionsResolver $resolver): void;

    public function process(string $format, string $document, string $outputPath): Process;
}
