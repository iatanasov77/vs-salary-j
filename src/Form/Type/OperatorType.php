<?php namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\FormInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Entity\OperatorsGroup;
use App\Entity\Operator;

class OperatorType extends AbstractType implements DataMapperInterface
{
    public function buildForm( FormBuilderInterface $builder, array $options ) : void
    {
        $builder
            ->add( 'group', EntityType::class, [
                'label'                 => 'salary-j.form.group',
                'translation_domain'    => 'SalaryJ',
                'required'              => false,
                'class'                 => OperatorsGroup::class,
                'choice_label'          => 'name',
                'placeholder'           => 'salary-j.form.common_group',
            ])
            
            ->add( 'name', TextType::class, [
                'label'                 => 'salary-j.form.name',
                'translation_domain'    => 'SalaryJ',
            ])
            
            // configure the data mapper for this FormType
            ->setDataMapper( $this )
        ;
    }
    
    /**
     * @param Operator|null $viewData
     */
    public function mapDataToForms( $viewData, \Traversable $forms ) : void
    {
        // there is no data yet, so nothing to prepopulate
        if ( null === $viewData ) {
            return;
        }
        
        // invalid data type
        if ( ! $viewData instanceof Operator ) {
            throw new UnexpectedTypeException( $viewData, Operator::class );
        }
        
        /** @var FormInterface[] $forms */
        $forms  = iterator_to_array( $forms );
        
        // initialize form field values
        $forms['group']->setData( $viewData->getGroup() );
        $forms['name']->setData( $viewData->getName() );
    }
    
    public function mapFormsToData( \Traversable $forms, &$viewData ): void
    {
        /** @var FormInterface[] $forms */
        $forms  = iterator_to_array( $forms );
        
        // as data is passed by reference, overriding it will change it in
        // the form object as well
        // beware of type inconsistency, see caution below
        $viewData = new Operator(
            $forms['group']->getData(),
            $forms['name']->getData()
        );
    }
}
