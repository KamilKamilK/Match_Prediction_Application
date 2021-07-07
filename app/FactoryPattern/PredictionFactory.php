<?php

namespace App\FactoryPattern;

interface PredictionFactory
{
    public function createPrediction($market_type, $prediction);
}

function showPrediction(PredictionFactory $predictionFactory)
{
    $predictionFactory->createPrediction('1x2','1');

}

showPrediction(new createPredictionFactory);


