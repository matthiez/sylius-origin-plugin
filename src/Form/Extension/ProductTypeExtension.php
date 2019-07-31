<?php
declare(strict_types=1);

namespace Ecolos\SyliusOriginPlugin\Form\Extension;

use Sylius\Bundle\ProductBundle\Form\Type\ProductType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\FormBuilderInterface;

final class ProductTypeExtension extends AbstractTypeExtension
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('originCountryCode', CountryType::class, [
                'required' => false
            ]);
    }

    /**
     * @inheritdoc
     */
    public function getExtendedTypes(): iterable
    {
        return [ProductType::class];
    }
}
