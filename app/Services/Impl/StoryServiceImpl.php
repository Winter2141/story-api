<?php


namespace App\Services\Impl;


use App\Models\Story;
use App\Models\UserStoryRelation;
use App\Services\Interfaces\StoryService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StoryServiceImpl implements StoryService
{

    public function doSearch($search_params)
    {
        $user = Auth::user();
        $data = Story::query()->with('user')->orderByDesc("updated_at");

        if($user->role == 2) {
            $data->where(function($q) use ($user) {
                $q->whereHas("user_relations", function ($query) use($user) {
                    $query->where("user_id", $user->id);
                })
                    ->orWhere('status', 2);
            });
        }

        if(isset($search_params['keyword']) && $search_params['keyword']) {
            $data->where(function($query) use($search_params) {
                $query->where('title', "like", "%".$search_params['keyword']."%")
                        ->orWhere('content', "like", "%".$search_params['keyword']."%");
            });

        }
        if(isset($search_params['own_type']) && $search_params['own_type'] && $search_params['own_type'] == 2) {
            $data->where('status', 1);
        }
        return $data;
    }

    public function doCreate($params)
    {
        $user = Auth::user();
        $params['user_id'] = $user->id;
        Log::debug("CREATE::::", [$user, $params]);
        $story = Story::query()->create($params);
        $relation_params['story_id'] = $story->id;
        $relation_params['user_id'] = $user->id;
        UserStoryRelation::query()->create($relation_params);
        if(isset($params['relations'])) {
            $this->updateRelations($params['relations'], $story);
        }
        return $story;
    }

    public function updateRelations($params, Story $story)
    {
        if(is_array($params) && count($params))
        {
            foreach ($params as $param)
            {
                if(!UserStoryRelation::query()->where('story_id', $story->id)->where('user_id', $param)->exists()) {
                    $relation_params['story_id'] = $story->id;
                    $relation_params['user_id'] = $param;
                    UserStoryRelation::query()->create($relation_params);
                }
            }
            UserStoryRelation::query()->whereNotIn("user_id", $params)->where("user_id", "<>", $story->user_id)->delete();
        }
    }

    public function doUpdate($params, Story $story)
    {
        if(isset($params['relations'])) {
            $this->updateRelations($params['relations'], $story);
        }
        return $story->update($params);
    }

    public function doDelete(Story $story)
    {
        $user = Auth::user();
        if($user->role == 1) {
            return $story->delete();
        }
        return null;
    }

    public function findById(Story $story)
    {
        return Story::with("user_relations")->where('id', $story->id)->first();
    }
}
