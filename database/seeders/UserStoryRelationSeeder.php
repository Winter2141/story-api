<?php

namespace Database\Seeders;

use App\Models\UserStoryRelation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserStoryRelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("user_story_relations")->truncate();
        UserStoryRelation::factory()->count(1000)->create();
    }
}
