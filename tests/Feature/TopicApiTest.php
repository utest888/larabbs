<?php

namespace Tests\Feature;

use App\Models\User;
use Dingo\Api\Auth\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\ActingJWTUser;

class TopicApiTest extends TestCase
{

    use ActingJWTUser;

    // protected $user;

    // public function __construct()
    // {
    //     parent::__construct();
    //     // $this->user = User::factory()->create();
    // }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        // $data = ['category_id' => 1, 'body' => 'test body', 'title' => 'test title'];

        // $token = Auth::guard('api')->fromUser($this->user);

        // $response = $this->JWTActingAs($this->user)->json('POST', '/api/topics', $data);

        // $assertData = [
        //     'category_id' => 1,
        //     'user_id' => $this->user->id,
        //     'title' => 'test title',
        //     'body' => clean('test body', 'user_topic_body'),
        // ];

        // $response->assertStatus(201)->assertJsonFragment($assertData);
        $user = User::factory()->create();
        $data = [
            'category_id' => 1,
            'user_id' => $user->id,
            'title' => 'test title',
            'body' => 'test body'
        ];

        $response = $this->JWTActingAs($user)->json('POST', '/api/topics', $data);

        $assertData = [
            'category_id' => 1,
            'user_id' => $user->id,
            'title' => 'test title',
            'body' => clean('test body', 'user_topic_body')
        ];

        $response->assertStatus(201)->assertJsonFragment($assertData);
    }
}
