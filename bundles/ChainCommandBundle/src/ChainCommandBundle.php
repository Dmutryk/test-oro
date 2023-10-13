<?php
namespace ChainCommandBundle;

use ChainCommandBundle\DependencyInjection\ChainCommandExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class ChainCommandBundle extends AbstractBundle
{
    public function getPath(): string
    {
        return __DIR__;
    }
    
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new ChainCommandExtension();
    }
}