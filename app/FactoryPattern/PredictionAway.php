<?php


namespace App\FactoryPattern;


class PredictionAway
{

    /**
     * PredictionAway constructor.
     */
    public function __construct($market_type,$prediction)
    {
        $this->market_type = $market_type;
        $this->prediction = $prediction;
    }

    public function createPrediction(): PredictionAway
    {
        return new PredictionAway('1x2', '2');
    }
}
