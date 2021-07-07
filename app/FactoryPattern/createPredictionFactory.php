<?php

namespace App\FactoryPattern;

class createPredictionFactory implements PredictionFactory
{
    public function createPrediction($market_type, $prediction)
    {
        if ($market_type == '1x2') {
            if ($prediction == '1') {
                return new PredictionHome($market_type, $prediction);
            } elseif ($prediction == 'x') {
                return new PredictionDraw($market_type, $prediction);
            } elseif ($prediction == '2') {
                return new PredictionAway($market_type, $prediction);
            }
        }else{
            return new PredictionCorrectScore($market_type, $prediction);
        }
    }
}
