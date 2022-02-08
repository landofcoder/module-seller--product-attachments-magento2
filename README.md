# module-seller-product-attachments-magento2
Magento 2 Product Attachments for Marketplace, allow seller manage product attachments

## Module Features
- Allow Seller manage product attachments on his dashboard
- Admin can enable/disable the feature for seller dashboard
- Show Product Attachments on Seller's Product Detail Page
- Support Upload files or use URL

## Setup

1. Require setup modules before:
- [LizardMedia_ProductAttachment](https://github.com/lizardmedia/product-attachments-magento2)
- [Lof MarketPlace](https://landofcoder.com/magento-2-marketplace-extension.html)

2. Module Installation

\* = in production please use the `--keep-generated` option

### Type 1: Zip file

- Unzip the zip file in `app/code/Lofmp`
- Enable the module by running `php bin/magento module:enable Lofmp_ProductAttachment`
- Apply database updates by running `php bin/magento setup:upgrade`\*
- Flush the cache by running `php bin/magento cache:flush`

### Type 2: Composer

- Make the module available in a composer repository for example:
    - private repository `repo.magento.com`
    - public repository `packagist.org`
    - public github repository as vcs
- Add the composer repository to the configuration by running `composer config repositories.repo.magento.com composer https://repo.magento.com/`
- Install the module composer by running `composer require landofcoder/module-seller-product-attachment`
- enable the module by running `php bin/magento module:enable Lofmp_ProductAttachment`
- apply database updates by running `php bin/magento setup:upgrade`\*
- Flush the cache by running `php bin/magento cache:flush`
