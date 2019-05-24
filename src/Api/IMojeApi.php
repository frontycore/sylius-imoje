<?php

declare(strict_types=1);

namespace Fronty\SyliusIMojePlugin\Api;

use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\Http\HttpException;

/**
 * @author Ondrej Seliga <ondrej@seliga.cz>
 */
final class IMojeApi implements IMojeApiInterface
{

	/** @var ArrayObject */
	private $options = [
		'merchantId' => '',
		'serviceId' => '',
		'serviceKey' => '',
		'environment' => ''
	];

	/**
	 * @param array $options [string $merchantId, string $serviceId, string $serviceKey, string $environment (prouction|sandbox)]
	 */
	public function __construct(array $options) {
		$options = ArrayObject::ensureArrayObject($options);
        $options->defaults($this->options);
        $options->validateNotEmpty([
            'merchantId',
            'serviceId',
            'serviceKey',
            'environment'
        ]);
        $this->options = $options;
	}

	public function getApiEndpoint()
	{
		return ($this->options['environment'] === 'sandbox') ?
			self::URL_SANDBOX :
			self::URL_PRODUCTION;
	}

	public function createFields(array $data): array
	{
		$data = array_merge($data, (array)$this->options);
		$requiredFields = [
			'serviceId',
			'merchantId',
			'amount',
			'currency',
			'orderId',
			'customerFirstName',
			'customerLastName',
			'customerEmail'
		];
		$optionalFields = [
			'customerPhone',
			'urlSuccess',
			'urlFailure',
			'urlReturn',
			'simp',
			'orderDescription',
			'visibleMethod',
			'twistoData'
		];
		$allFields = array_merge($requiredFields, $optionalFields);
		$result = [];
		foreach ($allFields as $field) {
			if (array_key_exists($field, $data)) $result[$field] = $data[$field];
		}
		$result = ArrayObject::ensureArrayObject($result);
		$result->validateNotEmpty($requiredFields);
		$result['signature'] = $this->createSignature((array)$result, $this->options['serviceKey']);
		return (array)$result;
	}

	private function createSignature(array $fields, string $serviceKey): string
	{
		ksort($fields);
		$data = [];
		foreach ($fields as $key => $val) {
			$data[] = "$key=$val";
		}
		$hash = hash(self::HASH_METHOD, implode('&', $data) . $serviceKey) . ';' . self::HASH_METHOD;
		return $hash;
	}
}