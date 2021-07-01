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

        $result = ['status' => 204];

        try {
            $result = $this->predictionService->getAll();
        }catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
        return response()->json($result);
//        $predictions = Prediction::orderBy('id')->get();
//        return response()->json(['prediction' => $predictions]);
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
            'event_id' ,
            'market_type',
            'prediction',
        ]);
        $result = ['status' => 204];

        try{
            $result['data'] = $this->predictionService->savePredictionData($data);
        }catch (Exception $e){
            $result = [
              'status' => 400,
              'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(int $id, Request $request)
    {

        $result = ['status'=> 204];
        $data = $request->only([
            'status' ,
        ]);

        try{
            $result['data'] = $this->predictionService->updatePredictionData((array)$id, $data);
        }catch (Exception $e){
            $result = [
                'status' => 404,
                'error' => $e->getMessage()
            ];
        }
//        dd($result,$data,$result['status']);
        return response()->json($result, $result['status']);

//        $validator = Validator::make($request->all(), [
//            'status' => 'required',
//        ]);
//
//        if ($validator->fails()) {
//            return response()->json([
//                'errors' => $validator->errors(),
//            ], 400);
//        }
//
//        $prediction = Prediction::findOrFail($id);
//        $prediction->status = $request->status;
//
//        $prediction->update();
//
//        return response()->json([
//             'status' => $prediction->status,
//        ],204);
    }
}
