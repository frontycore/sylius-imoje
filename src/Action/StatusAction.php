<?php

declare(strict_types=1);

namespace Fronty\SyliusIMojePlugin\Action;

use Fronty\SyliusIMojePlugin\Api\IMojeApiInterface;
use Payum\Core\Action\ActionInterface;
use Payum\Core\Request\GetStatusInterface;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Bridge\Spl\ArrayObject;

/**
 * @author Ondrej Seliga <ondrej@seliga.cz>
 */
final class StatusAction implements ActionInterface
{

	/**
	 * @param GetStatusInterface $request
	 * @throws RequestNotSupportedException
	 */
	public function execute($request)
	{
		RequestNotSupportedException::assertSupports($this, $request);

		$model = ArrayObject::ensureArrayObject($request->getModel());
		// $status = isset($model['imojeStatus']) ? $model['imojeStatus'] : null;
		$status = (isset($_GET['status'])) ? $_GET['status'] : null;

		if ($status === NULL) {
			$request->markNew();
			return;
		}

		if ($status === IMojeApiInterface::STATUS_REJECTED) {
			$request->markCanceled();
			return;
		}

		if ($status === IMojeApiInterface::STATUS_SETTLED) {
			$request->markCaptured();
			return;
		}

		$request->markUnknown();
	}

	/**
	 * {@inheritDoc}
	 */
	public function supports($request) {
		return $request instanceof GetStatusInterface &&
			$request->getModel() instanceof \ArrayAccess;
	}
}