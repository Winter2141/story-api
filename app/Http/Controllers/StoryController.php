<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\StoryService;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    private $service;
    public function __construct(StoryService $storyService)
    {
        $this->service = $storyService;
    }

    public function storyList(Request $request)
    {
        $stories = $this->service->doSearch($request->all())->paginate($request->get("per_page", 10));

        return response()->json($stories);
    }
}
