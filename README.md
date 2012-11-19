# Tax Framework for the SilverStripe Shop module

Tax is a fee that a merchant collects from the customer by law for the government. Some governments have
different tax rates for different kinds of products

## Requirements

 * Shop module v0.9

## Installation

 * Put the shop_taxframework folder into your SilverStripe root directory
 * Add the TaxFrameworkModifier to your modifiers config, eg:

```php
    Order::set_modifiers(array(
        'TaxFrameworkModifier'
    ));
```

 * You need to use the new SteppedCheckout system to allow customers to set their address
 before tax is calculated. To enable steps add the following to your mysite/_config.php file:

```php
    SteppedCheckout::setupSteps();
```
 
 Note that you will also need to update your CheckoutPage.ss template to be more like the
 SteppedCheckoutPage.ss template, found in shop/templates/Layout/.

If you need some example tax classes and rates to populate your site for testing/development, 
you can run the task: `yoursite.tld/dev/tasks/PopulateTaxClassesTask`

## Further Documentation

See the docs/en folder.