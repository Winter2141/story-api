<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoryRequest;
use App\Models\Story;
use App\Services\Interfaces\StoryService;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    private $service;
    public function __construct(StoryService $storyService)
    {
        $this->service = $storyService;
    }

    public function index(Request $request)
    {
        $stories = $this->service->doSearch($request->all())->paginate($request->get("per_page", 12));

        return response()->json($stories);
    }

    public function create(Request $request)
    {

    }

    public function store(StoryRequest $request)
    {
        try {
            $story = $this->service->doCreate($request->all());
            return response()->json(["message" => "Success."]);
        } catch (\Exception $e) {
            return response()->json(["message" => "Failed."], 400);
        }
    }

    public function show(Request $request, Story $story)
    {
        return response()->json($this->service->findById($story));
    }

    public function update(StoryRequest $request, Story $story)
    {
        try {
            $this->service->doUpdate($request->all(), $story);
            return response()->json(["message" => "Success."]);
        } catch (\Exception $e) {
            return response()->json(["message" => "Failed."], 400);
        }
    }

    public function destroy(Request $request, Story $story)
    {
        try {
            $this->service->doDelete($story);
            return response()->json(["message" => "Success."]);
        } catch (\Exception $e) {
            return response()->json(["message" => "Failed."], 400);
        }
    }
}
