<?php

namespace App\Http\Controllers;

use App\Models\Taske;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Taske::query();

        foreach(request('filter', []) as $filter => $value){
            $query->orWhere($filter, $value);
        }
        
        $taskes = $query->orderBy('due_date', 'asc')
            ->paginate(15)->appends(request()->except('page'));

        return $taskes;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['user_id'] = auth()->user()->id;
        $request->validate([
            'description' => ['required','string'],
            'due_date' => ['required','string'],
            'finished' => 'max:2',
            'user_id' => 'required'
        ]);

        return Taske::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Taske::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $taske = Taske::find($id);

        if(auth()->user()->id != $taske->user_id){
            abort(401);
        }
        
        
        $request->validate([
            'description' => 'required'
        ]);

        $taske->update($request->all());

        return $taske;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $taske = Taske::find($id);

        // return $taske;
        if(auth()->user()->id != $taske->user_id){
            abort(401);
        }
        Taske::destroy($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $description
     * @return \Illuminate\Http\Response
     */
    public function search($description)
    {
        return Taske::where('description', 'LIKE', "%{$description}%")->paginate(15);
        
    }
}
