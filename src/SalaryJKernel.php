<?php namespace App;

use Vankosoft\ApplicationBundle\Component\Application\Kernel as BaseKernel;

class SalaryJKernel extends BaseKernel
{
    const VERSION   = '1.7.0';
    const APP_ID    = 'salary-j';
    
    /**
     * {@inheritDoc}
     * @see \Symfony\Component\HttpKernel\Kernel::getProjectDir()
     *
     * READ HERE: https://symfony.com/doc/current/reference/configuration/kernel.html#project-directory
     */
    public function getProjectDir(): string
    {
        return \dirname( __DIR__ );
    }
    
    protected function __getConfigDir(): string
    {
        return $this->getProjectDir() . '/config/applications/salary-j';
    }
}
