<?php namespace App\Component;

use Symfony\Contracts\Translation\TranslatorInterface;

use App\Entity\UserManagement\UserInfo;

class Orm
{
    /** @var TranslatorInterface */
    protected $translator;
    
    public function __construct(
        TranslatorInterface $translator
    ) {
        $this->translator   = $translator;
    }
    
    public function userTitleChoices()
    {
        return [
            UserInfo::TITLE_MISTER  => $this->translator->trans( 'salary-j.form.users.mister', [], 'SalaryJ' ),
            UserInfo::TITLE_MRS     => $this->translator->trans( 'salary-j.form.users.mrs', [], 'SalaryJ' ),
            UserInfo::TITLE_MISS    => $this->translator->trans( 'salary-j.form.users.miss', [], 'SalaryJ' ),
        ];
    }
}
