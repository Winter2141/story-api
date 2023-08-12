<?php


namespace App\Services\Interfaces;


use App\Models\Story;

interface StoryService
{
    public function doSearch($search_params);
    public function doCreate($params);
    public function doUpdate($params, Story $story);
    public function doDelete(Story $story);
    public function findById(Story $story);
}
