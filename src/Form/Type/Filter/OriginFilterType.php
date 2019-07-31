<?php

declare(strict_types=1);

namespace Ecolos\SyliusOriginPlugin\Form\Type\Filter;

use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Sylius\Component\Channel\Context\RequestBased\ChannelContext;
use Sylius\Bundle\CoreBundle\Doctrine\ORM\ProductRepository;
use Sylius\Component\Taxonomy\Repository\TaxonRepositoryInterface;

class OriginFilterType extends AbstractType
{
    /** @var ChannelContext */
    protected $channelContext;

    /** @var ProductRepository */
    protected $productRepository;

    /** @var RequestStack */
    protected $request;

    /** @var TaxonRepositoryInterface */
    protected $taxonRepository;

    public function __construct(
        ChannelContextInterface $channelContext,
        ProductRepository $productRepository,
        RequestStack $request,
        TaxonRepositoryInterface $taxonRepository
    )
    {
        $this->channelContext = $channelContext;
        $this->productRepository = $productRepository;
        $this->request = $request;
        $this->taxonRepository = $taxonRepository;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $taxonSlug = $this->request->getCurrentRequest()->attributes->get("slug");
        $locale = $this->request->getCurrentRequest()->attributes->get("_locale");
        $channel = $this->channelContext->getChannel();
        $taxonId = $this->taxonRepository->findOneBySlug($taxonSlug, $locale)->getId();

        $products = array_filter($this->productRepository->findByTaxon($channel, $locale, $taxonId),
            function (ProductInterface $product) {
                return $product->isEnabled() && strlen((string)$product->getOriginCountryCode());
            });

        usort($products, function (ProductInterface $a, ProductInterface $b) {
            return strcmp($a->getOriginCountryName(), $b->getOriginCountryName());
        });

        $builder
            ->addModelTransformer(new CollectionToArrayTransformer())
            ->add(
                'origins',
                ChoiceType::class,
                [
                    'choices' => array_reduce(
                        $products,
                        function (array $arr, ProductInterface $product) {
                            $arr[$product->getOriginCountryName()] = $product->getOriginCountryCode();

                            return $arr;
                        }, []),
                    "multiple" => true,
                    "label" => false
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'origins' => [],
            ])
            ->setAllowedTypes('origins', ['array']);
    }
}
