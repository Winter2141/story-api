<?php

namespace Tests\Feature;

use App\Models\Story;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoryControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function testCreateStory()
    {
        $user = User::query()->where('id', 1)->first();
        $data = [
            "user_id" => $user->id,
            'title' => 'New Story',
            'content' => 'This is a new story content.',
            'status' => 1,
        ];

        $response = $this->actingAs($user)->postJson('/api/story', $data);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Success.',
            ]);
    }

    public function testUpdateStory()
    {
        $user = User::query()->where('id', 1)->first();
        $story = Story::factory()->create();

        $updatedData = [
            'title' => 'Updated Title',
            'content' => 'Updated content.',
            'status' => 1,
        ];

        $response = $this->actingAs($user)->putJson('/api/story/' . $story->id, $updatedData);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Success.',
            ]);
    }
    public function testListStories()
    {
        $user = User::query()->where('id', 1)->first();
        Story::factory()->count(5)->create();

        $response = $this->actingAs($user)->postJson('/api/story/list');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'content',
                        'status',
                        // ... other fields ...
                    ],
                ],
            ]);
    }

    public function testDeleteStory()
    {
        $user = User::query()->where('id', 1)->first();
        $story = Story::factory()->create();

        $response = $this->actingAs($user)->deleteJson('/api/story/' . $story->id);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Success.',
            ]);
    }

}
