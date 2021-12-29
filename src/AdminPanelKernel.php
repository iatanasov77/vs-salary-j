<?php namespace App;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Routing\RouteCollectionBuilder;

use Vankosoft\ApplicationBundle\Component\Application\Kernel as BaseKernel;

class AdminPanelKernel extends BaseKernel
{
    const VERSION       = '1.6.5';
    
    /**
     * Override MicroKernelTrait::registerBundles()
     * 
     * {@inheritdoc}
     */
    public function registerBundles(): iterable
    {
        $contents = require $this->getProjectDir().'/config/admin-panel/bundles.php';
        foreach ($contents as $class => $envs) {
            if ($envs[$this->environment] ?? $envs['all'] ?? false) {
                yield new $class();
            }
        }
    }
    
    protected function configureContainer( ContainerBuilder $container, LoaderInterface $loader ): void
    {
        $container->setParameter( 'vs_application.session_save_path', $this->getVarDir() . '/sessions/' );
        
        $container->addResource( new FileResource( $this->getProjectDir().'/config/admin-panel/bundles.php' ) );
        //$container->setParameter( 'container.dumper.inline_class_loader', true );
        
        $confDir    = $this->getProjectDir() . '/config/admin-panel';
        
        $loader->load( $confDir . '/{packages}/*' . self::CONFIG_EXTS, 'glob' );
        $loader->load( $confDir . '/{packages}/' . $this->environment . '/**/*' . self::CONFIG_EXTS, 'glob' );
        $loader->load( $confDir . '/{services}' . self::CONFIG_EXTS, 'glob' );
        $loader->load( $confDir . '/{services}_' . $this->environment . self::CONFIG_EXTS, 'glob' );
    }
    
    protected function configureRoutes( RouteCollectionBuilder $routes ): void
    {
        $confDir    = $this->getProjectDir() . '/config/admin-panel';
        
        $routes->import( $confDir . '/{routes}/' . $this->environment . '/**/*' . self::CONFIG_EXTS, '/', 'glob' );
        $routes->import( $confDir . '/{routes}/*' . self::CONFIG_EXTS, '/', 'glob' );
        $routes->import( $confDir . '/{routes}' . self::CONFIG_EXTS, '/', 'glob' );
    }
}
