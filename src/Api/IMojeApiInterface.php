<?php

declare(strict_types=1);

namespace Fronty\SyliusIMojePlugin\Api;

/**
 * @author Ondrej Seliga <ondrej@seliga.cz>
 */
interface IMojeApiInterface
{
	/** Signature hash algorithm */
	const HASH_METHOD = 'sha256';

	/** Sandbox and production API endpoint URLs */
	const URL_PRODUCTION = 'https://paywall.imoje.pl/pl/payment';
	const URL_SANDBOX = 'https://sandbox.paywall.imoje.pl/pl/payment';

	/** Response statuses according to which to mark payment status */
	const STATUS_SETTLED = 'settled';
	const STATUS_REJECTED = 'rejected';
}