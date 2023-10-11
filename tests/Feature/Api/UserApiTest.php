<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\Fixtures\UserFixtures;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    protected string $endpoint = 'api/v1';

    public function test_store_user_validation_false()
    {
        $data = [];

        $response = $this->postJson("{$this->endpoint}/users", $data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'first_name',
                'last_name',
                'email',
                'cpf',
                'genre',
                'birthday',
            ],
        ]);
    }

    public function test_store_user_success()
    {
        $data = [
            'first_name' => UserFixtures::MATHEUS_FIRST_NAME,
            'last_name' => UserFixtures::MATHEUS_LAST_NAME,
            'email' => UserFixtures::MATHEUS_EMAIL,
            'cpf' => UserFixtures::MATHEUS_CPF,
            'genre' => UserFixtures::MATHEUS_GENRE,
            'birthday' => UserFixtures::MATHEUS_BIRTHDAY,
        ];

        $response = $this->postJson("{$this->endpoint}/users", $data);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertNotEmpty($response['data']['id']);
    }

    public function test_paginate_user_success()
    {
        User::factory(10)->create();

        $response = $this->getJson("{$this->endpoint}/users");

        $response->assertStatus(Response::HTTP_OK);
        $this->assertCount(10, $response['data']);
    }

    public function test_list_not_found()
    {
        $response = $this->getJson("{$this->endpoint}/users/invalid");

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_delete_user_success()
    {
        $user = User::factory()->user()->create();

        $response = $this->delete("{$this->endpoint}/users/{$user->id}");

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function test_find_user_success()
    {
        $user = User::factory()->user()->create();

        $response = $this->getJson("{$this->endpoint}/users/{$user->id}");

        $response->assertStatus(Response::HTTP_OK);
        $this->assertEquals($user->id, $response['data']['id']);
    }

    public function test_delete_not_found()
    {
        $response = $this->deleteJson("{$this->endpoint}/users/invalid");

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_update_not_found()
    {
        $data = [];
        $id = UserFixtures::MATHEUS_ID;

        $response = $this->putJson("{$this->endpoint}/users/{$id}", $data);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_update_user_validation_false()
    {
        $user = User::factory()->user()->create();

        $data = [
            'first_name' => '',
            'last_name' => '',
            'email' => '',
            'cpf' => '',
            'genre' => '',
            'birthday' => '',
        ];

        $response = $this->putJson("{$this->endpoint}/users/{$user->id}", $data);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'first_name',
                'last_name',
                'email',
                'cpf',
                'genre',
                'birthday',
            ],
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

    }

    public function test_update_user_success()
    {
        User::factory()->user()->create();

        $data = [
            'first_name' => 'João',
            'last_name' => UserFixtures::MATHEUS_LAST_NAME,
            'email' => UserFixtures::MATHEUS_EMAIL,
            'cpf' => UserFixtures::MATHEUS_CPF,
            'genre' => UserFixtures::MATHEUS_GENRE,
            'birthday' => UserFixtures::MATHEUS_BIRTHDAY,
        ];
        $id = UserFixtures::MATHEUS_ID;

        $response = $this->putJson("{$this->endpoint}/users/{$id}", $data);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertNotEmpty($response['data']['id']);
        $this->assertEquals('João', $response['data']['first_name']);
    }
}
