<?php

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

test('test user can register with correct credentials', function () {
    $password = fake()->password(8, 12);
    $email = fake()->email;
    $response = $this->postJson(
        '/api/v1/auth/register',
        [
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
            'name' => fake()->name,
        ],
        [
            'Accept' => 'application/json',
        ]
    );

    $response->assertStatus(Response::HTTP_CREATED)
        ->assertJsonStructure(
            [
                'email',
                'name',
                'access_token',
            ]
        );

    $this->assertDatabaseHas('users', [
        'email' => $email,
    ]);

});

test('test user can\'t register with wrong password confirmation field', function () {
    $response = $this->postJson(
        '/api/v1/auth/register',
        [
            'email' => fake()->email,
            'password' => fake()->password(8, 12),
            'password_confirmation' => fake()->password(8, 12),
            'name' => fake()->name,
        ],
        [
            'Accept' => 'application/json',
        ]
    );


    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors('password');
});

test('user can\'t register when email is in database', function () {
    $password = fake()->password(8, 12);
    $email = fake()->email;

    User::factory()->create(['email' => $email]);

    $response = $this->postJson(
        '/api/v1/auth/register',
        [
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
            'name' => fake()->name,
        ],
        [
            'Accept' => 'application/json',
        ]
    );

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors('email');
});


test('user can log in with correct credentials', function () {
    User::factory()->create([
        'email' => 'user@example.com',
        'password' => Hash::make('correct-password'),
    ]);

    $response = $this->postJson('/api/v1/auth/login',
        [
            'email' => 'user@example.com',
            'password' => 'correct-password',
        ],
        [
            'Accept' => 'application/json',
        ]
    );

    $response->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure(
            [
                'email',
                'name',
                'access_token',
            ]
        );
});

test('user can\'t login with incorrect credentials', function () {
    User::factory()->create([
        'email' => 'user@example.com',
        'password' => Hash::make('correct-password'),
    ]);

    $response = $this->postJson('/api/v1/auth/login',
        [
            'email' => 'user@example.com',
            'password' => 'wrong-password',
        ],
        [
            'Accept' => 'application/json',
        ]
    );


    $response->assertStatus(401)
        ->assertContent('"Unauthorized"');
});

test('user can\'t login with empty email', function () {
    $response = $this->postJson('/api/v1/auth/login',
        [
            'email' => '',
            'password' => 'correct-password',
        ],
        [
            'Accept' => 'application/json',
        ]
    );

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
});

test('user can\'t login with empty password', function () {
    $response = $this->postJson('/api/v1/auth/login',
        [
            'email' => 'user@example.com',
            'password' => '',
        ],
        [
            'Accept' => 'application/json',
        ]
    );

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['password']);
});

test('user can\'t login with non-exists email', function () {
    $response = $this->postJson('/api/v1/auth/login',
        [
            'email' => 'nonexistent@example.com',
            'password' => 'correct-password',
        ],
        [
            'Accept' => 'application/json',
        ]
    );

    $response->assertStatus(401)
        ->assertContent('"Unauthorized"');
});



