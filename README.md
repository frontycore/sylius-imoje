# Sylius IMoje.pl payment gateway plugin

Integration of imoje.pl Paywall API to Sylius as a new payment method.

See Paywall [API documentation](https://www.imoje.pl/developerzy/paywall-api).

Check also great [GoPay plugin by Czende](https://packagist.org/packages/czende/gopay-plugin). It has been great inspiration for IMoje.pl payment plugin.

## Installation

```bash
$ composer require fronty/sylius-imoje
```

Add plugin dependencies to your AppKernel.php file:

```php
public function registerBundles()
{
    return array_merge(parent::registerBundles(), [
        ...

        new \Fronty\SyliusIMojePlugin\FrontySyliusIMojePlugin(),
    ]);
}
```

## Beware
This plugin is not tested, therefore it's not an official Sylius plugin. Please be careful.
If you'd like to add testing, you are more than welcome to send PR!

## Usage
### Sandbox (testing mode)
Register new Sandbox account at https://sandbox.imoje.ingbank.pl/ (PL only).
Log in and go to "Sklepy" tab (top left). In the table, click on "Sklep testowy" to expand and then to "Szczegóły" link.
Go to "Dane do integracji" tab. There you will see your credentials, which should be filled in payment setting:
- "Identyfikator klienta" is Merchant ID
- "Identyfikator sklepu" is Service ID
- "Klucz sklepu" is Secret Key

Go to Sylius admin and create new payment of IMoje.pl type. Choose Testing environment and use credentials from sanbox admin.

### Production
You will receive production credentials from IMoje.pl organization. After that, go to IMoje.pl payment settings in Sylius admin,
fill given credentials and select Production environment. That's all :)


## How to change visible payment methods.
By default, this plugin uses only `card` and `pbl` payment methods. If you want to specify others or change any other Gateway configuration,
just overwrite service `fronty.imoje.gateway_factory` with your own and change `visibleMethod` in `payum.default_options` field.


## Todo
- Tests to become an official Sylius plugin :)
- Notification implementation