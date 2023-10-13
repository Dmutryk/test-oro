<?php
namespace BarBundle;

use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class BarBundle extends AbstractBundle
{
    public function getPath(): string
    {
        return __DIR__;
    }
}