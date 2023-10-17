<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dreamer;
use App\Http\Requests\Dreamer\StoreRequest;
use App\Http\Requests\Dreamer\ChangeGroupRequest;



class DreamerController extends Controller
{
    /**
     * Display a listing of dreamers.
     *
     * @return \Illuminate\Http\Dreamer
     */
    public function index()
    {
        return response(Dreamer::all(), 200);
    }

    /**
     * Store a newly created dreamer.
     *
     * @param  \Illuminate\Http\StoreRequest  $request
     * @return \Illuminate\Http\Dreamer
     */
    public function store(StoreRequest $request)
    {
        $dreamer           = new Dreamer;
        $dreamer->name     = $request->name;
        $dreamer->birthdate     = $request->birthdate;
        $dreamer->group_id     = $request->group_id?: null ;
        $dreamer->user_id  = auth()->user()->id;
        $dreamer->save();

        return response($dreamer, 201);
    }

    /**
     * Display the specified dreamer.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Dreamer
     */
    public function show($id)
    {
        return response(Dreamer::find($id), 200);

    }

    /**
     * Update the specified dreamer.
     *
     * @param  \Illuminate\Http\ChangeGroupRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Dreamer
     */
    public function update(ChangeGroupRequest $request, $id)
    {
        $dreamer = Dreamer::find($id);
        $dreamer->update($request->all());
        return response($dreamer, 200);
        
    }

    /**
     * Remove the specified dreamer.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Dreamer
     */
    public function destroy($id)
    {
        Dreamer::destroy($id);
        return response(['messege' => 'Dreamer deleted!'], 200);
    }

    /**
     * change group of dreamer
     *
     * @param  \Illuminate\Http\ChangeGroupRequest  $request
     * @return \Illuminate\Http\Dreamer
     */
    public function changeGroup(ChangeGroupRequest $request, $id)
    {
        $dreamer = Dreamer::find($id);
        $dreamer->group_id = $request->group_id;
        $dreamer->update();
        return response($dreamer, 200);

    }
}
