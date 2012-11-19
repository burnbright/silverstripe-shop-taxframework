## About tax

Different countries, and governing sub-regions have different laws for tax collection. Some sub-regions
charge taxes on top of their parent region tax, so the tax is 'compounding'.

Tax can be a complex thing to calculate. Different combinations of factors need to be taken into account:

 * Locality / sub-locality of:
 	* Merchant
 	* Delivery
 	* Customer
 * Type of product being sold
 * Value of product
 * Value of shipping

Because tax can be different per product, then we need to work out tax on a per-product basis. Total tax
can be displayed at the checkout. Tax could also be displayed on product pages.

### US Tax system

The US taxation system is one where state has it's own tax rate. At the time of writing New York state tax rate 
is 8.875%. New Jersey is 7%. Connecticut is 6.35%, and so on. 50 states, 50 different tax rates.
If a merchant residing in New York is selling to a customer residing in New York, then the merchant collect 
New York sales tax. If the merchant is selling to any other state, they do not need to collect any sales tax,
as it becomes the buyer's responsibility to report the purchase at the end of the year when preparing their 
year-end taxes.

### Inclusive or exclusive

Sometimes you want to include tax in pricing, but still display the amount of tax being charged. Otherwise
tax should be displayed, and added on top of the amount being taxed.

### Compounding tax

Compounding tax is where a sub-locality (county) tax rate, is added to it's parent locality (state) rate.
You can manually add parent locality rates to sub-locality and store as a combined rate.

## Model

 * `TaxClass` - type of tax, and whether it is the default. Each product, and shipping method has a tax class.
 * `TaxRate` - region(s) to apply tax to, and their corresponding rates + options. Each tax class has many tax rates.
 * `TaxFrameworkModifier` - applies tax to order