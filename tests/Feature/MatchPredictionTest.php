<?php

namespace Tests\Feature;

use App\Models\Prediction;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MatchPredictionTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_basic_request()
    {
        $predict = $this->createPrediction();

        $this->json('GET', '/api/v1/predictions',)
            ->assertStatus(200)
            ->assertJsonFragment([
                "id" => $predict->id,
                "event_id" => $predict->event_id,
                "market_type" => $predict->market_type,
                "prediction" => $predict->prediction,
                "status" => $predict->status,
                "created_at" => $predict->created_at,
                "updated_at" => $predict->updated_at
            ]);
    }

    public function test_store_valid_api_request()
    {
        $data = [
            'event_id' => '123',
            'market_type' => 'correct_score',
            'prediction' => '3:2',
        ];
        $this->withoutExceptionHandling();


        $this->json('POST', '/api/v1/predictions', $data)
            ->assertStatus(204);
    }

    public function test_store_if_fails()
    {
        $data = [
            'event_id' => 'fs',
            'market_type' => 'lalalala',
            'prediction' => '?',
        ];
        $this->withoutExceptionHandling();


        $this->json('POST', '/api/v1/predictions', $data)
            ->assertStatus(400);
    }

    public function test_update_valid_api_request()
    {
        $this->withoutExceptionHandling();

        $prediction = $this->createPrediction();

        $prediction_id = $prediction->id; // or  $prediction_id = $this->prediction()->id;

        $updatedData = [
            'status' => 'win',
        ];

        $this->json('PUT', route('prediction.update', $prediction_id), $updatedData)
            ->assertStatus(204);
    }

    public function test_update_if_fails()
    {
        $this->withoutExceptionHandling();

        $prediction = $this->createPrediction();
        $prediction_id = $prediction->id; // or  $prediction_id = $this->prediction()->id;

        $updatedData = [
            'status' => 'lalala',
        ];

        $this->json('PUT', route('prediction.update', $prediction_id), $updatedData)
            ->assertStatus(400);
    }

    public function test_update_if_exist()
    {

        $prediction = $this->createPrediction();

        $prediction_id = $prediction->id; // or  $prediction_id = $this->prediction()->id;

        $prediction = Prediction::where('id', $prediction_id)->exists();

        $updatedData = [
            'status' => 'win',
        ];
        $this->json('PUT', route('prediction.update', !$prediction), $updatedData)
            ->assertStatus(404);
    }

    function createPrediction(): Prediction
    {
        return Prediction::factory()->create();
    }
}

