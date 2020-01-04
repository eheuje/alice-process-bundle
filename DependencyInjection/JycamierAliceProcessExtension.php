<?php


namespace Jycamier\AliceProcessBundle\DependencyInjection;

use ReflectionClass;
use Sidus\BaseBundle\DependencyInjection\Loader\ServiceLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class JycamierAliceProcessExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $refl = new ReflectionClass($this);
        $loader = new ServiceLoader($container);
        $serviceFolderPath = dirname($refl->getFileName(), 2).'/Resources/config/services';
        $loader->loadFiles($serviceFolderPath);
    }
}
