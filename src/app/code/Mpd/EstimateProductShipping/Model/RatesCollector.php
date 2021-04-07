<?php

namespace Mpd\EstimateProductShipping\Model;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\QuoteFactory;
use Magento\Quote\Model\Quote\Item;
use Magento\Quote\Model\Quote\ItemFactory as QuoteItemFactory;

/**
 * Collects shipping rates
 */
class RatesCollector
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var QuoteFactory
     */
    private $quoteFactory;

    /**
     * @var QuoteItemFactory
     */
    private $quoteItemFactory;

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param QuoteFactory $quoteFactory
     * @param QuoteItemFactory $quoteItemFactory
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        QuoteFactory $quoteFactory,
        QuoteItemFactory $quoteItemFactory
    ) {
        $this->productRepository = $productRepository;
        $this->quoteFactory = $quoteFactory;
        $this->quoteItemFactory = $quoteItemFactory;
    }

    /**
     * Emulates a cart with a product to triggers the shipping
     * rates calculation
     * @param String $postcode
     * @param Integer $productId
     * @param Double $qty
     * @return Array
     */
    public function getProductRates($postcode, $productId, $qty)
    {
        $product = $this->productRepository->getById($productId);
        
        // creates an empty shopping cart
        /** @var \Magento\Quote\Model\Quote */
        $quote = $this->quoteFactory->create();
        
        // adds product to cart
        /** @var \Magento\Quote\Model\Quote\Item */
        $item = $this->quoteItemFactory->create();
        $item->setProduct($product);
        $item->setQty($qty);
        $quote->addItem($item);

        // informs the destiny postcode and set the flags
        // to triggers the shipping rates calculation
        $shippingAddress = $quote->getShippingAddress();
        $shippingAddress->setPostcode($postcode)
                        ->setCountryId("BR")
                        ->setCollectShippingRates(true)
                        ->collectShippingRates();
        
        return $this->_formatResult($shippingAddress->getGroupedAllShippingRates());
    }

    /**
     * Formats the rates for further use in another area of
     * the module
     * @param Array $groupedRates
     * @return Array
     */
    private function _formatResult($groupedRates)
    {
        $returnedRates = [];

        foreach ($groupedRates as $carrierCode => $carrierRates) {
            foreach ($carrierRates as $rate) {
                $returnedRates[] = [
                    "carrier_code"  => $rate->getCarrier(),
                    "carrier_title" => $rate->getCarrierTitle(),
                    "method_code"   => $rate->getMethod(),
                    "method_title"  => $rate->getMethodTitle(),
                    "description"   => $rate->getMethodDescription(),
                    "price"         => $rate->getPrice(),
                    "available"     => empty($rate->getErrorMessage()),
                    "error"         => $rate->getErrorMessage() ?: "",
                ];
            }
        }

        return $returnedRates;
    }
}
