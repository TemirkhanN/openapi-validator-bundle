<?php

declare(strict_types=1);

namespace Test\TemirkhanN\OpenapiValidatorBundle\Kernel;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;

class Kernel extends \Symfony\Component\HttpKernel\Kernel
{
    use MicroKernelTrait;

    public function getProjectDir()
    {
        return __DIR__;
    }
}
