<?php


namespace App\Services\Impl;


use App\Models\Story;
use App\Services\Interfaces\StoryService;

class StoryServiceImpl implements StoryService
{

    public function doSearch($search_params)
    {
        $data = Story::query()->with('user')->orderByDesc("updated_at");

        if(isset($search_params['keyword']) && $search_params['keyword']) {
            $data->where(function($query) use($search_params) {
                $query->where('title', "like", "%".$search_params['keyword']."%")
                        ->orWhere('content', "like", "%".$search_params['keyword']."%");
            });

        }
        return $data;
    }

    public function doCreate($params)
    {
        return Story::query()->create($params);
    }

    public function doUpdate($params, Story $story)
    {
        return $story->update($params);
    }

    public function doDelete(Story $story)
    {
        return $story->delete();
    }
}
