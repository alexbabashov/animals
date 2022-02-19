<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\Animal;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        $headers = [
            'Accept' => 'application/json',
            'Accept-Encoding' => 'gzip, deflate, br',
            'Connection' => 'keep-alive',
            'User-Agent' => 'unitTest'
        ];
        $data = [
            'kind' => 'dog',
            'size_max' => '100',
            'age_max' => '77',
            'grow_factor' => '1.2',
            'avatar' => 'avatarpng'
        ];

        $animal = Animal::factory()->make($data);

        $this->withoutExceptionHandling();
        $response = $this->withHeaders($headers)->get(route('animal.index'));

        $response->assertStatus(200);
        $this->assertDatabaseCount('animals', 1);
        $this->assertDatabaseHas('animals', $data);
    }
}
