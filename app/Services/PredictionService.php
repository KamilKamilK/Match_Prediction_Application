<?php

namespace App\Services;

use App\Models\Prediction;
use App\Repositories\PredictionRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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
     * @param array $data
     * @return string
     */

    public function savePredictionData($data)
    {
        $validator = Validator::make($data, [
            'event_id' => 'required|int',
            'market_type' => Rule::in('1x2', 'correct_score'),
        ]);

        // niedokończona validacja

        if ($data['market_type'] == '1x2') {
            Validator::make($data, [
                'prediction' => Rule::in('1', '2', 'x')
            ]);

        } elseif ('market_type' == 'correct_score') {
            Validator::make($data, [
                'prediction' => 'integer|integer'
            ]);

        } else {
            Validator::make($data, [
                'prediction' => 'require',
            ]);
        }

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $result = $this->predictionRepository->save($data);

        Log::channel('attention')->info('Attention API store ', [
            'createdPrediction' => $result
        ]);

        return $result;
    }

    /**
     * Validate prediction data
     * Update in DB if there are no errors
     *
     * @param array $data
     * @return string
     */

    public function updatePredictionData($id, $data)
    {

        $validator = Validator::make($data, [
            'status' => Rule::in(['win', 'lost', 'unresolved']),
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        if (Prediction::where('id', $id)->exists()) {

            DB::beginTransaction();

            try {

                $prediction = $this->predictionRepository->update($id, $data);

                Log::channel('attention')->info('Attention API update ', [
                    'toUpdatePrediction' => Prediction::where('id', $id)->get()
                ]);

            } catch (Exception $e) {
                DB::rollBack();
                Log::channel('attention')->info($e->getMessage());

                throw new InvalidArgumentException('Unable to update prediction status', 1);
            }

            DB::commit();
        } else {

            throw new InvalidArgumentException("This prediction doesn't exist", 2);
        }

        return $prediction;

    }

    /**
     * Get all predictions
     *
     * @return String
     */

    public function getAll()
    {
        return $this->predictionRepository->getAllPredictions();
    }
}

?>
