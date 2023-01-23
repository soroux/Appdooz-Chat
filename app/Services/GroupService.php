<?php

namespace App\Services;

use App\Models\Group;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Storage;

class GroupService
{
    public function showAllGroups($service_id, $withRelations, $user_id,$name, $page, $limit = 15, $sortBy = 'created_at')
    {
        $query = Group::query();
        if ($service_id) {
            $query = $query->where('service_id', $service_id);
        }
        if ($user_id) {
            $query = $query->where('user_id',$user_id);
        }
        if ($name) {
            $query = $query->where('name', 'like', '%' . $name . '%');
        }
        switch ($sortBy) {
            case 'created_at':
                $query = $query->orderBy("created_at", "desc");
                break;
            default:
                $query = $query->orderBy("created_at", "desc");
                break;
        }
        if ($withRelations) {
            $query = $query->with($withRelations);
        }
        if ($page) {
            return $query->paginate($limit);
        }

        return $query->get();
    }

    public function storeGroup(array $item)
    {
        return Group::create($item);
    }

    public function getGroup($id, $withRelations = null)
    {
        $query = Group::query();
        $query->where('id', $id);
        if ($withRelations) {
            $query = $query->with($withRelations);
        }
        return $query->first();
    }

    public function getGroupsWhereIn(array $ids, $withRelations = null)
    {
        $query = Group::query();
        $query->whereIn('id', $ids);
        if ($withRelations) {
            $query = $query->with($withRelations);
        }
        return $query->get();
    }

    public function updateGroup(array $item, $Group)
    {


        return $Group->update($item);

    }

    public function destroyGroup($Group)
    {
        return $Group->delete($Group);

    }
    public function addMember(array $item,Group $group){
        $group->members()->attach($item);
        return $group->load('types');
    }

}
