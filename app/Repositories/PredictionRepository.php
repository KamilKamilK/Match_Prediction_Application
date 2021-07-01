<?php

namespace App\Repositories;

use App\Models\Prediction;

class PredictionRepository
{
    /**
     * @var Prediction
     */
    protected $prediction;

    /**
     * PredictionRepository Constructor.
     *
     * @param Prediction $prediction
     */
    public function __construct(Prediction $prediction)
    {
        $this->prediction = $prediction;
    }

    /**
     * Save prediction
     *
     * @param $data
     * @return Prediction
     */

    public function save($data)
    {
        $prediction = new $this->prediction;

        $prediction->event_id = $data['event_id'];
        $prediction->market_type = $data['market_type'];
        $prediction->prediction = $data['prediction'];

        $prediction->save();

        return $prediction->fresh();
    }
    /**
     * Update prediction status
     *
     * @param $data
     * @return Prediction
     */

    public function update($id, $data)
    {
        $prediction = $this->prediction->find($id);

        $prediction->status = $data['status'];
        $prediction->update();

        return $prediction;
    }

    /**
     * Get all predictions
     *
     * @return Prediction $prediction
     */

    public function getAllPredictions()
    {

        return $this->prediction->orderBy('id')->get();
    }
}

?>
