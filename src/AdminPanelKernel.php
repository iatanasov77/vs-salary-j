<?php namespace App;

use Vankosoft\ApplicationBundle\Component\Application\Kernel as BaseKernel;

class AdminPanelKernel extends BaseKernel
{
    const VERSION   = '1.7.0';
    const APP_ID    = 'admin-panel';
    
    protected function __getConfigDir(): string
    {
        return $this->getProjectDir() . '/config/admin-panel';
    }
}
