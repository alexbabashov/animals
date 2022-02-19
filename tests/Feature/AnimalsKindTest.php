<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Animal;

class AnimalsKindTest extends TestCase
{
    use RefreshDatabase;

    public function additionProvider()
    {
        $headers = [
            'Accept' => 'application/json',
            'Accept-Encoding' => 'gzip, deflate, br',
            'Connection' => 'keep-alive',
            'User-Agent' => 'unitTest'
        ];
        return [
            'dog'  => [
                $headers,
                [
                    'kind' => 'dog',
                    'size_max' => 100,
                    'age_max' => 77,
                    'grow_factor' => 1.2,
                    'avatar' => 'avatardog'
                ],
            ],
            'cat'  => [
                $headers,
                [
                    'kind' => 'cat',
                    'size_max' => 88,
                    'age_max' => 56,
                    'grow_factor' => 0.9,
                    'avatar' => 'avatarcat'
                ],
            ],
        ];
    }

    /**
    * @dataProvider additionProvider
    */
    public function test_animal_index($headers, $data)
    {
        $animal = Animal::factory()->create($data);

        $this->withoutExceptionHandling();
        $response = $this->withHeaders($headers)->get(route('animal.index'));

        $response->assertStatus(200); //$response->assertOk();


        $data['avatar'] = Animal::avatarURL($data['avatar']);
        $kind = [];
        $kind['error'] = null;
        $kind['data'] = [];
        $kind['data'][$data['kind']] = $data;
        $response->assertExactJson($kind);
    }

    /**
    * @dataProvider additionProvider
    */
    public function test_animal_show($headers, $data)
    {
        $animal = Animal::factory()->create($data);

        $this->withoutExceptionHandling();
        $response = $this->json('POST', route('animal.show'), ['kind' => $data['kind']]);

        $response->assertStatus(200);

        $data['avatar'] = Animal::avatarURL($data['avatar']);
        $kind = [];
        $kind['error'] = null;
        $kind['data'] = $data;
        $response->assertExactJson($kind);
    }

    public function test_example()
    {
        $this->assertTrue(true);
    }
}
