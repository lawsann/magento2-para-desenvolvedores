<?php

namespace Mpd\EstimateProductShipping\Controller\Estimate;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Json as JsonResult;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\LocalizedException;
use Mpd\EstimateProductShipping\Model\ShippingCalculator;

/**
 * Action class responsible to collect
 * rates to product shipping
 */
class Index extends Action
{
    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;
    
    /**
     * @var ShippingCalculator
     */
    protected $calculator;
    
    /**
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     * @param ShippingCalculator $calculator
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        ShippingCalculator $calculator
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->calculator = $calculator;
        parent::__construct($context);
    }

    /**
     * For now, build a mock JSON response
     * @return JsonResult
     */
    public function execute()
    {
        $responseJson = [];

        try {
            list($postcode, $productId, $qty) = $this->_loadAndValidateParams();

            $responseJson["rates"] = $this->calculator->getProductRates($postcode, $productId, $qty);
            $responseJson["success"] = true;
        } catch (\Exception $e) {
            $responseJson["error_message"] = __($e->getMessage());
            $responseJson["success"] = false;
        }

        $result = $this->resultJsonFactory->create();
        $result->setData($responseJson);

        return $result;
    }

    /**
     * Gets the params on request object and validate them
     * @return Array
     */
    private function _loadAndValidateParams()
    {
        $postcode = preg_replace("/[^0-9,.]/", "", $this->getRequest()->getParam("postcode"));
            
        if (!$postcode) {
            throw new LocalizedException("Please inform a valid postcode.");
        }

        $productId = (int) $this->getRequest()->getParam("product_id");

        if (!$productId) {
            throw new LocalizedException("Please inform a product ID.");
        }

        $qty = (float) $this->getRequest()->getParam("qty");

        if (!$qty) {
            $qty = 1;
        }

        return [$postcode, $productId, $qty];
    }
}
