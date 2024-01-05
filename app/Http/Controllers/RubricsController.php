<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topics;
use App\Models\Rubrics;

class RubricsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function create(){
        $topics = Topics::all();

        // Assuming you have a method to get groups for each topic
        $topicGroups = Topics::pluck('groups', 'id');

        return view('admin.rubrics', compact('topics', 'topicGroups'));
    }
    public function store(Request $request){

        // dd($request->all());
        // dd($request->all());
        $user = auth()->user();

        // Create a new post for the authenticated user
        $user->definerubrics()->create([
            'title'=>$request['title'],
            'first'=>$request['first'],
            'second'=>$request['second'],
            'secondtwo'=> $request['secondtwo'],
            'third'=> $request['third'],
            'pass'=> $request['pass'],
            'fail'=> $request['fail'],
            'topic_id'=> $request['topic_id'],
        ]);

        $topicId = $request->input('topic_id');
        // return redirect('/rubrics');
        return redirect()->route('rubrics', ['active_tab' => $topicId])->with('success', 'Record Added successfully');
    }

    public function updaterubrics(Request $request, $id)
    {
        // dd($request->all());
        $rubic = Rubrics::findOrFail($id);

        $rubic->update([
            'title' => $request->input('title'),
            'first' => $request->input('first'),
            'second' => $request->input('second'),
            'secondtwo'=>$request->input('secondtwo'),
            'third'=>$request->input('third'),
            'pass'=>$request->input('pass'),
            'fail'=>$request->input('fail'),
            'topic_id'=>$request->input('topic_id')
        ]);

        $topicId = $request->input('topic_id');

        return redirect()->route('rubrics', ['active_tab' => $topicId])->with('success', 'Record updated successfully');
    }

    public function deleteRubric($id)
    {
        // Find the category by ID and delete it
        $category = Rubrics::findOrFail($id);
        $category->delete();

        return redirect()->route('rubrics')->with('success', 'Record deleted successfully');

        // return response()->json(['success' => true]);
    }
}
