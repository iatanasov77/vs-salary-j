<?php namespace App\Form;

use Vankosoft\ApplicationBundle\Form\AbstractForm;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Vankosoft\ApplicationBundle\Component\I18N;

use App\Form\Type\ModelType;
use App\Entity\Model;

class ModelForm extends AbstractForm
{
    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        parent::buildForm( $builder, $options );
        
        $model = $options['data'];
        $builder
            ->setMethod( $model && $model->getId() ? 'PUT' : 'POST' )
            
            ->add( 'application_code', HiddenType::class, ['mapped' => false] )
            
            ->add( 'currentLocale', ChoiceType::class, [
                'label'                 => 'salary-j.form.locale',
                'translation_domain'    => 'SalaryJ',
                'choices'               => \array_flip( I18N::LanguagesAvailable() ),
                'mapped'                => false,
            ])
            
            ->add( 'model', ModelType::class, [
                'mapped'        => false,
                'data_class'    => Model::class,
            ])
        ;
    }
    
    public function getName()
    {
        return 'salary_j.model';
    }
}
