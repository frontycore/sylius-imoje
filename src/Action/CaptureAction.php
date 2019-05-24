<?php

declare(strict_types=1);

namespace Fronty\SyliusIMojePlugin\Action;

use Fronty\SyliusIMojePlugin\Api\IMojeApi;
use Payum\Core\Action\ActionInterface;
use Payum\Core\GatewayAwareTrait;
use Payum\Core\GatewayAwareInterface;
use Payum\Core\Request\Capture;
use Payum\Core\Reply\HttpPostRedirect;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\ApiAwareInterface;
use Payum\Core\ApiAwareTrait;

/**
 * @author Ondrej Seliga <ondrej@seliga.cz>
 */
final class CaptureAction implements ActionInterface, GatewayAwareInterface, ApiAwareInterface
{
	use GatewayAwareTrait;
	use ApiAwareTrait;

	public function __construct()
    {
        $this->apiClass = IMojeApi::class;
    }

	/**
	 * @param Capture $request
	 * @throws RequestNotSupportedException
	 */
	public function execute($request)
	{
		RequestNotSupportedException::assertSupports($this, $request);

		$model = $request->getModel();
		$model = ArrayObject::ensureArrayObject($model);

		$order = $request->getFirstModel()->getOrder();
		$customer = $order->getCustomer();
		$token = $request->getToken();

		$model['customerFirstName'] = $customer->getFirstName();
		$model['customerLastName'] = $customer->getLastName();
		$model['customerPhone'] = $customer->getPhoneNumber();
		$model['urlSuccess'] = $token->getAfterUrl() . '&status=settled';
		$model['urlFailure'] = $token->getAfterUrl() . '&status=rejected';
		// $model['urlReturn'] = $token->getAfterUrl();

		throw new HttpPostRedirect(
			$this->api->getApiEndpoint(),
			$this->api->createFields((array)$model)
		);
	}

	/**
     * {@inheritdoc}
     */
    public function supports($request) {
        return
            $request instanceof Capture &&
            $request->getModel() instanceof \ArrayAccess;
    }
}