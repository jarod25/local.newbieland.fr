<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use \Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use \Knp\Bundle\MenuBundle\KnpMenuBundle;
use Vich\UploaderBundle\VichUploaderBundle;
use Knp\Bundle\PaginatorBundle\KnpPaginatorBundle;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function registerBundles() : iterable
    {
        $contents = require $this->getProjectDir().'/config/bundles.php';
        foreach ($contents as $class => $envs) {
            if ($envs[$this->environment] ?? $envs['all'] ?? false) {
                yield new $class();
            }
        }
        $bundles = [
            new FrameworkBundle(),
            new KnpMenuBundle(),
            new VichUploaderBundle(),
            new KnpPaginatorBundle(),
        ];

        return $bundles;
    }
}
