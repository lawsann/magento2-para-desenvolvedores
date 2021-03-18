<?php

namespace Mpd\EstimateProductShipping\Controller\Estimate;

use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\Result\Json as JsonResult;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

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
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    /**
     * For now, build a mock JSON response
     * @return JsonResult
     */
    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        $result->setData
        ([
            "success" => true,
            "rates" => 
            [
                [
                    "carrier_code" => "ownfleet",
                    "carrier_title" => "Entrega Própria",
                    "methods" => 
                    [
                        [
                            "method_code" => "economic",
                            "method_title" => "Entrega Econômica - em até 5 dias úteis",
                            "price" => 5,
                        ], [
                            "method_code" => "express",
                            "method_title" => "Entrega Expressa - em até 1 dia útil",
                            "price" => 20,
                        ],
                    ],
                ],[
                    "carrier_code" => "correios",
                    "carrier_title" => "Correios",
                    "methods" => 
                    [
                        [
                            "method_code" => "pac",
                            "method_title" => "PAC - em até 10 dias útieis",
                            "price" => 19.80,
                        ], [
                            "method_code" => "sedex",
                            "method_title" => "Sedex - em até 3 dias úteis",
                            "price" => 39.90,
                        ],
                    ],
                ],
            ]
        ]);

        return $result;
    }
}
