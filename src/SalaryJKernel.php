<?php namespace App;

use Vankosoft\ApplicationBundle\Component\Application\Kernel as BaseKernel;

class SalaryJKernel extends BaseKernel
{
    const VERSION   = '1.7.0';
    const APP_ID    = 'salary-j';
    
    protected function __getConfigDir(): string
    {
        return $this->getProjectDir() . '/config/applications/salary-j';
    }
}
