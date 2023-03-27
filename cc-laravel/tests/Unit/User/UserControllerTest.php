<?php

namespace Tests\Unit\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testIndex()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/api/users');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    }

    public function testIndexFilteredByName()
    {
        $user1 = User::factory()->create(['name' => 'John']);
        $user2 = User::factory()->create(['name' => 'Jane']);
        $user3 = User::factory()->create(['name' => 'Alice']);

        $response = $this->actingAs($user1)->json('GET', '/api/users?name=Jane');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                        'created_at',
                        'updated_at',
                    ]
                ]
            ])
            ->assertJsonFragment([
                'id' => $user2->id,
                'name' => $user2->name,
                'email' => $user2->email,
                'created_at' => $user2->created_at->toISOString(),
                'updated_at' => $user2->updated_at->toISOString(),
            ])
            ->assertJsonMissing([
                'data' => [
                    [
                        'id' => $user1->id,
                        'name' => $user1->name,
                        'email' => $user1->email,
                        'created_at' => $user1->created_at->toISOString(),
                        'updated_at' => $user1->updated_at->toISOString(),
                    ],
                    [
                        'id' => $user3->id,
                        'name' => $user3->name,
                        'email' => $user3->email,
                        'created_at' => $user3->created_at->toISOString(),
                        'updated_at' => $user3->updated_at->toISOString(),
                    ]
                ]
            ]);
    }

    public function testIndexFilteredByEmail()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();

        $response = $this->actingAs($user1)->json('GET', '/api/users?email=' . $user2->email);

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                        'created_at',
                        'updated_at',
                    ]
                ]
            ])
            ->assertJsonFragment([
                'id' => $user2->id,
                'name' => $user2->name,
                'email' => $user2->email,
                'created_at' => $user2->created_at->toISOString(),
                'updated_at' => $user2->updated_at->toISOString(),
            ])
            ->assertJsonMissing([
                'data' => [
                    [
                        'id' => $user1->id,
                        'name' => $user1->name,
                        'email' => $user1->email,
                        'created_at' => $user1->created_at->toISOString(),
                        'updated_at' => $user1->updated_at->toISOString(),
                    ],
                    [
                        'id' => $user3->id,
                        'name' => $user3->name,
                        'email' => $user3->email,
                        'created_at' => $user3->created_at->toISOString(),
                        'updated_at' => $user3->updated_at->toISOString(),
                    ]
                ]
            ]);
    }

    public function testStore()
    {
        $name = $this->faker->name;
        $email = $this->faker->email;
        $password = $this->faker->password;

        $userData = [
            'name' => $name,
            'email' => $email,
            'password' => $password
        ];

        $response = $this->json('POST', '/api/users', $userData);

        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'name' => $name,
                'email' => $email,
            ]
        ]);
        $this->assertInstanceOf(User::class, $response->original);
    }

    public function testShow()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/api/users/' . $user->id);

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'name' => $user->name,
                    'email' => $user->email,
                ]
            ]);
    }

    public function testUpdate()
    {
        $user = User::factory()->create();

        $newData = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $this->faker->password
        ];

        $response = $this->actingAs($user)->json('PUT', '/api/users/' . $user->id, $newData);

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'name' => $newData['name'],
                    'email' => $newData['email']
                ]
            ]);
    }

    public function testDestroy()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->delete('/api/users/' . $user->id);

        $response->assertNoContent();
    }
}
