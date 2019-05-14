<?php

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new FOS\RestBundle\FOSRestBundle(),
            new FOS\ElasticaBundle\FOSElasticaBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),
            new Nelmio\ApiDocBundle\NelmioApiDocBundle(),
            new AppBundle\AppBundle(),
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new TestingBundle\TestingBundle();

            if ('dev' === $this->getEnvironment()) {
                $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
                $bundles[] = new Symfony\Bundle\WebServerBundle\WebServerBundle();
            }
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        // Fixes performance hit when Symfony is run in VM/Vagrant
        // http://www.whitewashing.de/2013/08/19/speedup_symfony2_on_vagrant_boxes.html
        // if (in_array($this->environment, array('dev', 'test'))) {
        //     return '/dev/shm/cache/aegon-pdf-service/frontend/cache/' .  $this->environment;
        // }

        return parent::getCacheDir();
    }

    public function getLogDir()
    {
        // Fixes performance hit when Symfony is run in VM/Vagrant
        // http://www.whitewashing.de/2013/08/19/speedup_symfony2_on_vagrant_boxes.html
        // if (in_array($this->environment, array('dev', 'test'))) {
        //     return '/dev/shm/cache/aegon-pdf-service/frontend/logs';
        // }

        return parent::getLogDir();
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(function (ContainerBuilder $container) {
            $container->setParameter('container.autowiring.strict_mode', true);
            $container->setParameter('container.dumper.inline_class_loader', true);

            $container->addObjectResource($this);
        });
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }

    /**
     * Checks if a given class name belongs to an active bundle.
     *
     * @param string $class A class name
     *
     * @return bool true if the class belongs to an active bundle, false otherwise
     *
     * @deprecated since version 2.6, to be removed in 3.0.
     */
    public function isClassInActiveBundle($class)
    {
        // TODO: Implement isClassInActiveBundle() method.
    }
}
