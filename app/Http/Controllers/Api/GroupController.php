<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupRequests\StoreGroupRequest;
use App\Http\Requests\GroupRequests\UpdateGroupRequest;
use App\Http\Resources\GroupResources\GroupCollection;
use App\Http\Resources\GroupResources\GroupResource;
use App\Models\Group;
use App\Services\GroupService;
use Illuminate\Http\Request;


/**
 * @group group management
 *
 * APIs for managing Groups
 */
class GroupController extends Controller
{

    /**
     * @var GroupService
     */
    private $groupService;

    public function __construct(GroupService $groupService)
    {
        $this->groupService = $groupService;
    }

        /**
     * Display a listing of the resource.
     *
     * @bodyParam name string The name of the application. Example: test
     * @bodyParam user_id int The id of the user. Example: 1
     * @bodyParam service_id int The id of the service. Example: 1
     * @bodyParam withRelations array The array of the requested relations. Example: creator
     * @bodyParam page int page number. Example: 1
     * @bodyParam limit int per page results. Example: 15
     * @bodyParam sortBy string requested sort by. Example: created_at
     * @return GroupCollection
     */
    public function index(Request $request)
    {
        //
        $groups = $this->groupService->showAllGroups($request->service_id, $request->withRelations, $request->name, $request->user_id, $request->page, $request->limit, $request->sortBy);
        return new GroupCollection($groups);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\GroupRequests\StoreGroupRequest  $request
     * @return GroupResource
     */
    public function store(StoreGroupRequest $request)
    {
        //
        $input = $request->all();
        $group = $this->groupService->storeGroup($input);
        return new GroupResource($group);
    }

    /**
     * Display the specified resource.
     *
     * @bodyParam withRelations array The array of the requested relations. Example: creator
     *
     * @param \App\Models\Service $service
     * @return GroupResource
     */
    public function show(Group $group, Request $request)
    {
        //
        $group = $this->groupService->getGroup($group->id, $request->withRelations);
        return new GroupResource($group);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\GroupRequests\UpdateGroupRequest  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
        //
        $input = $request->all();

        $this->groupService->updateGroup($input, $group);
        return  response()->json('success',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Group $group)
    {
        //
        $this->groupService->destroyGroup($group);
        return response()->json('success', 200);
    }
}
