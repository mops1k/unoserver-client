<?php

namespace Unoserver\Converter\Wrapper;

use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractWrapper implements WrapperInterface
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
        $resolver->setRequired('command');
        $resolver->setAllowedTypes('command', ['string', 'null']);

        $this->configure($resolver);
        $this->options = $resolver->resolve($options);
    }
}
