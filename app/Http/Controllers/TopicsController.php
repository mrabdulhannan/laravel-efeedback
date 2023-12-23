<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topics;

class TopicsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function create(){
        return view('admin.definetopic');
    }

    public function store(Request $request){

        $user = auth()->user();

        // Create a new post for the authenticated user
        $user->definetopic()->create([
            'title'=>$request['title'],
            'groups'=>$request['groups'],
            'total_assessments'=>$request['total_assessments'],
            'start_date'=>$request['start_date'],
            'end_date'=>$request['end_date'],
            'user_id'=> $user['id'],
        ]);

        return redirect('/definecategories');
    }

    public function showalltopics(){
        return view('admin.alltopics');
    }

    public function updatetopic(Request $request, $topicId)
    {
        // Validate the incoming request data as needed
        $request->validate([
            'total_assessments' => 'integer',
            'start_date' => 'nullable|date_format:Y-m-d',
            'end_date' => 'nullable|date_format:Y-m-d',
        ]);

        // Find the topic by ID
        $topic = Topics::findOrFail($topicId);

        // dd($request->all());

        // Update the topic attributes if the corresponding input exists in the request
        if ($request->has('total_assessments')) {
            $topic->total_assessments = $request->input('total_assessments');
        }

        if ($request->has('start_date')) {
            $topic->start_date = $request->input('start_date');
        }

        if ($request->has('end_date')) {
            $topic->end_date = $request->input('end_date');
        }

        
        // dd($topic->getAttributes());
        $topic->save();

        // Redirect back or to a specific route after updating
        return redirect()->back()->with('success', 'Topic updated successfully');
    }

    public function updatetopicpost(Request $request, $topicId)
    {
        // Validate the incoming request data as needed
        $request->validate([
            'total_assessments' => 'integer',
            'start_date' => 'nullable|date_format:Y-m-d',
            'end_date' => 'nullable|date_format:Y-m-d',
        ]);

        // Find the topic by ID
        $topic = Topics::findOrFail($topicId);

        // dd($request->all());

        // Update the topic attributes if the corresponding input exists in the request
        if ($request->has('total_assessments')) {
            $topic->total_assessments = $request->input('total_assessments');
        }

        if ($request->has('start_date')) {
            $topic->start_date = $request->input('start_date');
        }

        if ($request->has('end_date')) {
            $topic->end_date = $request->input('end_date');
        }

        
        // dd($topic->getAttributes());
        $topic->save();

        // Redirect back or to a specific route after updating
        return redirect()->route('edittopic.get', ['id' => $topicId])->with('success', 'Topic updated successfully');
       
    }


    public function edittopic($id)
    {
    $topic = Topics::findOrFail($id);

    return view('admin.edittopic', ['topic' => $topic]);
    }

    public function deletetopic($id)
    {
        // Find the category by ID and delete it
        $topic = Topics::findOrFail($id);
        $topic->delete();

        return redirect()->route('alltopics')->with('success', 'Category deleted successfully');
    }
}
