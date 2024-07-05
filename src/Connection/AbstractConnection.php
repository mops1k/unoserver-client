<?php

namespace Unoserver\Converter\Connection;

use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractConnection implements ConnectionInterface
{
    /**
     * @var array<string, mixed>
     */
    protected array $options = [];

    /**
     * @param array<string, mixed> $options
     */
    public function __construct(array $options)
    {
        $resolver = new OptionsResolver();
        $this->configure($resolver);
        $this->options = $resolver->resolve($options);
    }
}
