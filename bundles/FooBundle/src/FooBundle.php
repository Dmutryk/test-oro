<?php
namespace FooBundle;

use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class FooBundle extends AbstractBundle
{
    public function getPath(): string
    {
        return __DIR__;
    }
}