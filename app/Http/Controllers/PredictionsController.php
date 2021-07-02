<?php

namespace App\Http\Controllers;

use App\Models\Prediction;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\PredictionRepository;
use App\Services\PredictionService;


class PredictionsController extends Controller
{
    /**
     * @var $predictionService
     */
    protected $predictionService;

    /**
     * PredictictionService constructor
     *
     * @param PredictionService $predictionService
     */

    public function __construct(PredictionService $predictionService)
    {
        $this->predictionService = $predictionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {

        try {
            $result = $this->predictionService->getAll();
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        $data = $request->only([
            'event_id',
            'market_type',
            'prediction',
        ]);
        $result = ['status' => 204];

        try {
            $result['data'] = $this->predictionService->savePredictionData($data);
        } catch (Exception $e) {
            $result = [
                'status' => 400,
                'error' => $e->getMessage()
            ];
        }
//        $jsonData = $request->all();
//        $json = json_decode($data['event_id']);
//        dd($data);
//        dd($result['status']);

        return response()->json($result, $result['status']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {

        $result = ['status' => 204];
        $data = $request->only([
            'status',
        ]);
        if (Prediction::where('id',$id)->exists()) {
            try {
                $result['data'] = $this->predictionService->updatePredictionData($id, $data);
            } catch (Exception $e) {
                $result = [
                    'status' => 400,
                    'error' => $e->getMessage()
                ];
            }
        } else {
            $result = [
                'status' => 404,
                'error' => 'Not Found'
            ];
        }
        return response()->json($result, $result['status']);
    }
}
