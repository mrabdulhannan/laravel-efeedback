<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topics;
use Illuminate\Support\Facades\Route;

class TopicsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function create(){
        return view('admin.definetopic');
    }

    public function store(Request $request){

        // dd($request->all());
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

        return redirect('/definetopic');
    }

    public function showalltopics(){
        return view('admin.alltopics');
    }

    public function updatetopicpost(Request $request, $topicId)
    {
    
        try {
            $referringUrl = $request->headers->get('referer');
            
            // Get the path from the URL
            $path = parse_url($referringUrl, PHP_URL_PATH);
        
            // Get the route from the path
            $route = Route::getRoutes()->match(app('request')->create($path))->getName();
        } catch (\Exception $e) {
            $route = $path;
        }
        // Validate the incoming request data as needed
        $request->validate([
            'title' => 'string',
            'groups' => 'nullable|string',
            'total_assessments' => 'nullable|integer',
            'start_date' => 'nullable|date_format:Y-m-d',
            'end_date' => 'nullable|date_format:Y-m-d',
            'provided_feedback' => 'nullable|string',
            'remaining_feedback' => 'nullable|integer',
        ]);

        
        // Find the topic by ID
        $topic = Topics::findOrFail($topicId);

        

        // Update the topic attributes if the corresponding input exists in the request
        if ($request->has('title')) {
            $topic->title = $request->input('title');
        }

        if ($request->has('groups')) {
            $topic->groups = $request->input('groups');
        }

        if ($request->has('total_assessments')) {
            $topic->total_assessments = $request->input('total_assessments');
        }

        if ($request->has('start_date')) {
            $topic->start_date = $request->input('start_date');
        }

        if ($request->has('end_date')) {
            $topic->end_date = $request->input('end_date');
        }

        if ($request->has('provided_feedback')) {
            $topic->provided_feedback = $request->input('provided_feedback');
        }

        if ($request->has('remaining_feedback')) {
            $topic->remaining_feedback = $request->input('remaining_feedback');
        }


        
        // dd($topic->getAttributes());
        $topic->save();

        if($route == "home"){
            return redirect()->route('home', ['id' => $topicId])->with('success', 'Record updated successfully');
        }
        else{
            // Redirect back or to a specific route after updating
        return redirect()->route('edittopic.get', ['id' => $topicId])->with('success', 'Record updated successfully');

        }
               
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

public function updateOrder(Request $request)
{
    try {
        $order = $request->input('order');

        // Update the order of topics in the database
        foreach ($order as $index => $topicId) {
            Topics::where('id', $topicId)->update(['topic_order' => $index + 1]);
        }
    
        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        \Log::error($e->getMessage());
        return response()->json(['error' => 'Internal Server Error'], 500);
    }
}

}
