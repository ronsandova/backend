<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\ProductCollection\Application\Form;

use Ergonode\Core\Application\Form\Type\TranslationType;
use Ergonode\ProductCollection\Application\Form\Type\ProductCollectionCodeType;
use Ergonode\ProductCollection\Application\Form\Type\ProductCollectionTypeIdType;
use Ergonode\ProductCollection\Application\Model\ProductCollectionCreateFormModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 */
class ProductCollectionCreateForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'code',
                ProductCollectionCodeType::class
            )
            ->add(
                'name',
                TranslationType::class
            )
            ->add(
                'description',
                TranslationType::class
            )
            ->add(
                'typeId',
                ProductCollectionTypeIdType::class
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProductCollectionCreateFormModel::class,
            'translation_domain' => 'collection',
        ]);
    }

    /**
     * @return null|string
     */
    public function getBlockPrefix(): ?string
    {
        return null;
    }
}
