<?php


namespace App\FactoryPattern;


class PredictionHome
{

    /**
     * PredictionHome constructor.
     */
    public function __construct($market_type, $prediction)
    {
        $this->market_type = $market_type;
        $this->prediction = $prediction;
    }

    public function createPrediction(): PredictionHome
    {
        return new PredictionHome('1x2','1');
    }
}
