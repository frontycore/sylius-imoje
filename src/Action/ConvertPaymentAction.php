<?php

declare(strict_types=1);

namespace Fronty\SyliusIMojePlugin\Action;

use Payum\Core\Action\ActionInterface;
use Payum\Core\Model\PaymentInterface;
use Payum\Core\Request\Convert;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Bridge\Spl\ArrayObject;

/**
 * @author Ondrej Seliga <ondrej@seliga.cz>
 */
final class ConvertPaymentAction implements ActionInterface
{

	/**
	 * @param Convert $request
	 * @throws RequestNotSupportedException
	 */
	public function execute($request)
	{
		RequestNotSupportedException::assertSupports($this, $request);

		$payment = $request->getSource();
		$details = ArrayObject::ensureArrayObject($payment->getDetails());

		$details['amount'] = $payment->getTotalAmount();
		$details['currency'] = $payment->getCurrencyCode();
		$details['orderId'] = $payment->getNumber();
		$details['orderDescription'] = $payment->getDescription();
		$details['customerEmail'] = $payment->getClientEmail();

		$request->setResult((array)$details);
	}

	/**
     * {@inheritdoc}
     */
	public function supports($request)
	{
		return
            $request instanceof Convert &&
            $request->getSource() instanceof PaymentInterface &&
            $request->getTo() === 'array';
	}
}