<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Http\Requests\Group\StoreRequest;


class GroupController extends Controller
{
    /**
     * Display a listing of groups.
     *
     * @return \Illuminate\Http\Group
     */
    public function index()
    {
        return response(Group::all(), 200);
    }

    /**
     * Store a newly created group.
     *
     * @param  \Illuminate\Http\StoreRequest  $request
     * @return \Illuminate\Http\Group
     */
    public function store(StoreRequest $request)
    {
        $group           = new Group;
        $group->name     = $request->name;
        $group->user_id  = auth()->user()->id;
        $group->save();

        return response($group, 201);
    }

    /**
     * Display the specified group.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Group
     */
    public function show($id)
    {
        return response(Group::find($id), 200);

    }

    /**
     * Update the specified group.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Group
     */
    public function update(Request $request, $id)
    {
        $group = Group::find($id);
        $group->update($request->all());
        return response($group, 200);
        
    }

    /**
     * Remove the specified group.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Group
     */
    public function destroy($id)
    {
        Group::destroy($id);
        return response(['messege' => 'Group deleted!'], 200);
    }

    /**
     * Search for specified group for user
     *
     * @param  int  $user
     * @return \Illuminate\Http\Group
     */
    public function searchForUser($user)
    {
        $group = Group::where('user_id', $user)->with('dreamers')->get();

        return response($group, 200);

    }
}
