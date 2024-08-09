<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserDictionary;
use App\Models\Word;
use App\Models\Language;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserDictionaryControllerTest extends TestCase
{
    use RefreshDatabase;

    final protected function setUp(): void
    {

        parent::setUp();
        $this->user = User::factory()->create();
        $this->language = Language::factory()->create();
        $this->word = Word::factory()->create();
        $this->actingAs($this->user, 'sanctum');
    }

    final public function testShow(): void
    {
        $userDictionary = UserDictionary::factory()->create(['user_id' => $this->user->id, 'word_id' => $this->word->id]);

        $response = $this->getJson("/api/user_dictionary/{$userDictionary->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $userDictionary->id,
                'user_id' => $userDictionary->user_id,
                'word_id' => $userDictionary->word_id,
                'level_of_knowing' => $userDictionary->level_of_knowing,
                'stability' => $userDictionary->stability,
            ]);
    }

    final public function testShowDenied(): void
    {
        // use another user
        $anotherUser = User::factory()->create();
        $userDictionary = UserDictionary::factory()->create(['user_id' => $anotherUser->id, 'word_id' => $this->word->id]);

        $response = $this->getJson("/api/user_dictionary/{$userDictionary->id}");

        $response->assertStatus(403);
    }

    final public function testIndex(): void
    {
        // also check current user cannot see another user's dictionary
        $anotherUser = User::factory()->create();
        $anotherUserDictionary = UserDictionary::factory()->create(['user_id' => $anotherUser->id, 'word_id' => $this->word->id]);
        UserDictionary::factory()->create(['user_id' => $this->user->id, 'word_id' => $this->word->id]);

        $data = ['language_from' => $this->language->symbol];
        $response = $this->getJson('/api/user_dictionary/' . '?' . http_build_query($data));

        $response->assertStatus(200)
            ->assertJsonMissing(['id' => $anotherUserDictionary->id])
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'user_id',
                    'word_id',
                    'level_of_knowing',
                    'stability',
                ],
            ]);
    }

    final public function testStore(): void
    {
        $data = [
            'word_id' => $this->word->id,
            'level_of_knowing' => 3,
            'stability' => 4,
        ];

        $response = $this->postJson('/api/user_dictionary', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment($data);
    }

    final public function testUpdate(): void
    {
        $userDictionary = UserDictionary::factory()->create(['user_id' => $this->user->id, 'word_id' => $this->word->id]);

        $data = [
            'stability' => 6,
        ];

        $data2 = [
            'level_of_knowing' => 7,
        ];

        $response = $this->putJson("/api/user_dictionary/{$userDictionary->id}", $data);
        $response2 = $this->putJson("/api/user_dictionary/{$userDictionary->id}", $data2);

        $response->assertStatus(200)
                 ->assertJsonFragment($data);

        $response2->assertStatus(200)
                    ->assertJsonFragment($data2);
    }

    final public function testUpdateDenied(): void
    {
        // use another user
        $anotherUser = User::factory()->create();
        $userDictionary = UserDictionary::factory()->create(['user_id' => $anotherUser->id, 'word_id' => $this->word->id]);

        $data = [
            'stability' => 6,
        ];

        $response = $this->putJson("/api/user_dictionary/{$userDictionary->id}", $data);

        $response->assertStatus(403);
    }

    final public function testDestroy(): void
    {
        $userDictionary = UserDictionary::factory()->create(['user_id' => $this->user->id, 'word_id' => $this->word->id]);

        $response = $this->deleteJson("/api/user_dictionary/{$userDictionary->id}");

        $response->assertStatus(200);
    }

    final public function testDestroyDenied(): void
    {
        // use another user
        $anotherUser = User::factory()->create();
        $userDictionary = UserDictionary::factory()->create(['user_id' => $anotherUser->id, 'word_id' => $this->word->id]);

        $response = $this->deleteJson("/api/user_dictionary/{$userDictionary->id}");

        $response->assertStatus(403);
    }
}
