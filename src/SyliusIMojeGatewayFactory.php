<?php

declare(strict_types=1);

namespace Fronty\SyliusIMojePlugin;

use Fronty\SyliusIMojePlugin\Action\CaptureAction;
use Fronty\SyliusIMojePlugin\Action\ConvertPaymentAction;
use Fronty\SyliusIMojePlugin\Action\StatusAction;
use Fronty\SyliusIMojePlugin\Api\IMojeApi;
use Payum\Core\GatewayFactory;
use Payum\Core\Bridge\Spl\ArrayObject;

/**
 * @author Ondrej Seliga <ondrej@seliga.cz>
 */
class SyliusIMojeGatewayFactory extends GatewayFactory
{
	/**
     * {@inheritDoc}
     */
	protected function populateConfig(ArrayObject $config)
	{
		$config->defaults([
			'payum.factory_name' => 'imoje',
            'payum.factory_title' => 'IMoje.pl',
            'payum.action.status' => new StatusAction(),
            'payum.action.convert_payment' => new ConvertPaymentAction(),
            'payum.action.capture' => new CaptureAction()
		]);

		if ($config['payum.api'] == false) {
			// IMoje default options
			$config['payum.default_options'] = [
				'merchantId' => '',
				'serviceId' => '',
				'serviceKey' => '',
				'environment' => '',
				'visibleMethod' => 'card,pbl' // All methods: card,pbl,blik,twisto
			];
			$config->defaults($config['payum.default_options']);

			// Required fields
			$config['payum.required_options'] = ['merchantId', 'serviceId', 'serviceKey', 'environment'];

			$config['payum.api'] = function(ArrayObject $config) {
				$config->validateNotEmpty($config['payum.required_options']);

				$imojeOptions = [
					'merchantId' => $config['merchantId'],
					'serviceId' => $config['serviceId'],
					'serviceKey' => $config['serviceKey'],
					'environment' => $config['environment'],
					'visibleMethod' => $config['visibleMethod']
				];

				return new IMojeApi($imojeOptions);
			};
		}
	}
}