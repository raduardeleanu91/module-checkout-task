# Checkout Task

Checkout Task is a Magento 2 module supported by the latest Magento 2 version, compatible with Magento 2 sample theme Luma.

## Functionalities

- Modifies configuration to disable guest checkout
- Adds a custom field on the checkout called "External Order Id" in which the customer can input any text value (up to 40 characters)
- Client side and server side validation for the newly added field
- The field is visible in the frontend in the shipping step of the checkout and in the order details page accessed through the customer's order history
- The field is visible in the order detail page and the order grid in the administration panel


## Installation

composer require raduardeleanu91/module-checkout-task master-dev

php bin/magento setup:upgrade

php bin/magento cache:flush
