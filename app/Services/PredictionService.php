<?php

namespace App\Services;

use App\Models\Prediction;
use App\Repositories\PredictionRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\log;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class PredictionService
{

    /**
     * @var $predictionRepository
     */
    protected $predictionRepository;

    /**
     * PredictictionService constructor
     *
     * @param PredictionRepository $predictionRrepository
     */

    public function __construct(PredictionRepository $predictionRepository)
    {
        $this->predictionRepository = $predictionRepository;
    }

    /**
     * Validate prediction data
     * Store to DB if there are no errors
     *
     * @param  array $data
     * @return string
     */

    public function savePredictionData($data)
    {
        $validator = Validator::make($data, [
            'event_id' => 'required|int',
            'market_type' => 'required',
            'prediction' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $result = $this->predictionRepository->save($data);

        return $result;
    }
    /**
     * Validate prediction data
     * Update in DB if there are no errors
     *
     * @param array $data
     * @return string
     */

    public function updatePredictionData(array $data, $id)
    {
        $validator = Validator::make($data, [
            'status' => 'required',

        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        DB::beginTransaction();

        try {
            $prediction = $this->predictionRepository->update($data, $id);
        } catch (Exception $e) {
            DB::rollBack();
            log::info($e->getMessage());

            throw new InvalidArgumentException('Unable to update prediction status');
        }

        DB::commit();

        return $prediction;

    }

    /**
     * Get all predictions
     *
     *@return String
     */

    public function getAll()
    {
        return $this->predictionRepository->getAllPredictions();
    }
}

?>
