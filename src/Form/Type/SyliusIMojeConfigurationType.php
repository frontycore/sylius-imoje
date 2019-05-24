<?php

declare(strict_types=1);

namespace Fronty\SyliusIMojePlugin\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @author Ondrej Seliga <ondrej@seliga.cz>
 */
final class SyliusIMojeConfigurationType extends AbstractType
{
	/**
     * {@inheritdoc}
     */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('environment', ChoiceType::class, [
                'choices' => [
                    'fronty.imoje.sandbox' => 'sandbox',
                    'fronty.imoje.production' => 'production'
                ],
                'label' => 'fronty.imoje.environment',
            ])
			->add('merchantId', TextType::class, [
				'label' => 'fronty.imoje.merchant_id',
				'constraints' => [
					new NotBlank([
						'message' => 'fronty.imoje.configuration.merchant_id.not_blank',
						'groups' => ['sylius']
					])
				]
			])
			->add('serviceId', TextType::class, [
				'label' => 'fronty.imoje.service_id',
				'constraints' => [
					new NotBlank([
						'message' => 'fronty.imoje.configuration.service_id.not_blank',
						'groups' => ['sylius']
					])
				]
			])
			->add('serviceKey', TextType::class, [
				'label' => 'fronty.imoje.service_key',
				'constraints' => [
					new NotBlank([
						'message' => 'fronty.imoje.configuration.service_key.not_blank',
						'groups' => ['sylius']
					])
				]
			]);
	}
}