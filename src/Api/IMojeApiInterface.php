<?php

declare(strict_types=1);

namespace Fronty\SyliusIMojePlugin\Api;

/**
 * @author Ondrej Seliga <ondrej@seliga.cz>
 */
interface IMojeApiInterface
{
	const HASH_METHOD = 'sha256';

	const URL_PRODUCTION = 'https://paywall.imoje.pl/pl/payment';
	const URL_SANDBOX = 'https://sandbox.paywall.imoje.pl/pl/payment';

	const STATUS_SETTLED = 'settled';
	const STATUS_REJECTED = 'rejected';
}