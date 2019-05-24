# Sylius IMoje.pl payment gateway plugin

Integration of imoje.pl transaction API to Sylius as a new payment method.

See also great [GoPay plugin by Czende](https://packagist.org/packages/czende/gopay-plugin), which was great inspiration for this plugin.

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

## Usage
### Sandbox (testing mode)
Register new Snadbox account at https://sandbox.imoje.ingbank.pl/ (PL only).
Log in and go to "Sklepy" tab (top left). In the table, click on "Sklep testowy" to expand and then to "Szczegóły" link.
Go to "Dane do integracji" tab. There you will see your credentials, which should be filled in payment setting:
- "Identyfikator klienta" is Merchant ID
- "Identyfikator sklepu" is Service ID

Go to Sylius admin and create new payment of IMoje.pl type. Choose Testing environment and use credentials from sanbox admin.
