<?php


namespace App\FactoryPattern;


class PredictionCorrectScore
{

    /**
     * predictionCorrectScore constructor.
     */
    public function __construct($market_type, $prediction)
    {
        $this->market_type = $market_type;
        $this->prediction = $prediction;
    }

    public function createPrediction(): PredictionCorrectScore
    {
        return new PredictionCorrectScore('correct_score', regex('/(\d)(:)(\d)/'));
    }
}
