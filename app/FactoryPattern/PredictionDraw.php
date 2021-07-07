<?php


namespace App\FactoryPattern;


class PredictionDraw
{

    /**
     * PredictionDraw constructor.
     */
    public function __construct($market_type,$prediction)
    {
        $this->market_type = $market_type;
        $this->prediction = $prediction;
    }

    public function createPrediction(): PredictionDraw
    {
        return new PredictionDraw('1x2','x');
    }
}
