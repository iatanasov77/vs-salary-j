<?php namespace App;

use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Routing\RouteCollectionBuilder;

class SalaryJKernel extends BaseKernel
{
    use MicroKernelTrait;

    private const CONFIG_EXTS = '.{php,xml,yaml,yml}';
    
    private const APP_ID = 'salary-j';
    
    public function registerBundles(): iterable
    {
        $contents = require $this->getProjectDir().'/config/applications/salary-j/bundles.php';
        foreach ($contents as $class => $envs) {
            if ($envs[$this->environment] ?? $envs['all'] ?? false) {
                yield new $class();
            }
        }
    }
    
    public function getProjectDir(): string
    {
        return \dirname(__DIR__);
    }
    
    public function getVarDir()
    {
        $dirVar = $this->getProjectDir() . '/var/' . self::APP_ID;
        if ( isset( $_ENV['DIR_VAR'] ) ) {
            $dirVar = $_ENV['DIR_VAR'] . '/' . self::APP_ID;
        }
        
        return $dirVar;
    }
    
    public function getCacheDir()
    {
        return $this->getVarDir() . '/cache/' . $this->environment;
        //return parent::getCacheDir();
    }
    
    public function getLogDir()
    {
        return $this->getVarDir() . '/log';
        //return parent::getLogDir();
    }
    
    protected function configureContainer( ContainerBuilder $container, LoaderInterface $loader ): void
    {
        $container->addResource(new FileResource($this->getProjectDir().'/config/applications/salary-j/bundles.php'));
        $container->setParameter('container.dumper.inline_class_loader', true);
        $confDir = $this->getProjectDir().'/config/applications/salary-j';
        
        $loader->load($confDir.'/{packages}/*'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/{packages}/'.$this->environment.'/**/*'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/{services}'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/{services}_'.$this->environment.self::CONFIG_EXTS, 'glob');
    }
    
    protected function configureRoutes(RouteCollectionBuilder $routes): void
    {
        $confDir = $this->getProjectDir().'/config/applications/salary-j';
        
        $routes->import($confDir.'/{routes}/'.$this->environment.'/**/*'.self::CONFIG_EXTS, '/', 'glob');
        $routes->import($confDir.'/{routes}/*'.self::CONFIG_EXTS, '/', 'glob');
        $routes->import($confDir.'/{routes}'.self::CONFIG_EXTS, '/', 'glob');
    }
}
