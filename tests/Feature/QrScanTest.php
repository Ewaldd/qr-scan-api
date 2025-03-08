<?php

use App\Models\QrScan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('user can get list of QR scans', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password')
    ]);
    $token = $user->createToken('TestToken')->plainTextToken;

    QrScan::factory()->count(3)->create(['user_id' => $user->id]);

    $response = $this->getJson('/api/v1/qr-scan',
        [
            'Authorization' => 'Bearer ' . $token,
        ]
    );

    $response->assertStatus(200)
        ->assertJsonCount(3);
});

test('user can store a new QR scan', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password')
    ]);
    $token = $user->createToken('TestToken')->plainTextToken;

    $data = [
        'link' => 'https://google.com',
        'description' => 'description',
    ];

    $response = $this->postJson('/api/v1/qr-scan', $data,
        [
            'Authorization' => 'Bearer ' . $token,
        ]
    );

    $response->assertStatus(201)
        ->assertJson(
            [
                'link' => 'https://google.com',
                'description' => 'description',
            ]
        );
});

test('user can view a QR scan', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password')
    ]);

    $token = $user->createToken('TestToken')->plainTextToken;

    $qrScan = QrScan::factory()->create(['user_id' => $user->id]);

    $response = $this->getJson("/api/v1/qr-scan/{$qrScan->id}",
        [
            'Authorization' => 'Bearer ' . $token,
        ]
    );

    $response->assertStatus(200)
        ->assertJsonStructure(
            [
                'link',
                'description',
            ]
        );
});

test('user can update a QR scan', function () {

    $user = User::factory()->create([
        'password' => Hash::make('password')
    ]);
    $token = $user->createToken('TestToken')->plainTextToken;

    $qrScan = QrScan::factory()->create(['user_id' => $user->id]);

    $updateData = [
        'link' => 'https://google.com',
    ];

    $response = $this->patchJson("/api/v1/qr-scan/{$qrScan->id}", $updateData,
        [
            'Authorization' => 'Bearer ' . $token,
        ]
    );

    $response->assertStatus(200)
        ->assertJson(
            [
                'link' => 'https://google.com',
            ]
        );

    $this->assertDatabaseHas('qr_scans', [
        'id' => $qrScan->id,
        'link' => 'https://google.com',
    ]);
});

test('user can delete a QR scan', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password')
    ]);
    $token = $user->createToken('TestToken')->plainTextToken;

    $qrScan = QrScan::factory()->create(['user_id' => $user->id]);

    $response = $this->deleteJson("/api/v1/qr-scan/{$qrScan->id}", [], [
        'Authorization' => 'Bearer ' . $token,
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'message' => 'QrScan deleted successful',
        ]);

    $this->assertDatabaseMissing('qr_scans', [
        'id' => $qrScan->id,
    ]);
});

test('user can\'t store QR scan with invalid data', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password')
    ]);
    $token = $user->createToken('TestToken')->plainTextToken;


    $response = $this->postJson('/api/v1/qr-scan',
        [
            'link' => '',
        ],
        [
            'Authorization' => 'Bearer ' . $token,
        ]
    );

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['link', 'description']);
});
