<?php

namespace Rz\PiwikBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class RzPiwikExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('block.xml');
        $this->configureBlocks($config['blocks'], $container);
    }

    /**
     * @param array                                                   $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     *
     * @return void
     */
    public function configureBlocks($config, ContainerBuilder $container)
    {
        #piwik widget
        $container->setParameter('rz_piwik.block.piwik_widget', $config['piwik_widget']['class']);
        $temp = $config['piwik_widget']['templates'];
        $templates = array();
        foreach ($temp as $template) {
            $templates[$template['path']] = $template['name'];
        }
        $container->setParameter('rz_piwik.block.piwik_widget.templates', $templates);
    }
}
