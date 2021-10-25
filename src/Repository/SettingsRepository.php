<?php namespace App\Repository;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

use App\Entity\Settings;

class SettingsRepository extends EntityRepository
{
    const STATUS_NOT_SAVED  = 0;
    const STATUS_SAVED      = 1;
   
    public function getSettings( $applicationId ) : array
    {
        $entityManager  = $this->getEntityManager();
        
        $query  = $entityManager->createQuery(
            'SELECT s
            FROM App\Entity\Settings s
            WHERE s.application = :applicationId'
        )->setParameter( 'applicationId', $applicationId );
        
        $seetingsArray  = $this->getDefaultSettings();
        foreach ( $query->getResult() as $settings ) {
            $seetingsArray[$settings->getVarName()]['value']    = $settings->getVarValue();
            $seetingsArray[$settings->getVarName()]['status']   = self::STATUS_SAVED;
        }

        return $seetingsArray;
    }
    
    private function getDefaultSettings() : array
    {
        return [
            'minuteBonus'   => [
                'label'     => 'salary-j.settings.minute_bonus',
                'value'     => 20,
                'status'    => self::STATUS_NOT_SAVED
            ],
            'minuteRate'    => [
                'label'     => 'salary-j.settings.minute_rate',
                'value'     => 0.065,
                'status'    => self::STATUS_NOT_SAVED
            ],
        ];
    }
}
