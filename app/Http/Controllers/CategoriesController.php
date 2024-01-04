<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DefineCategories;
use App\Models\Topics;

class CategoriesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function create($id)
    {
        $topic = Topics::find($id);
        // $topics = Topics::all();

        // Assuming you have a method to get groups for each topic
        // $topicGroups = Topics::pluck('groups', 'id');



        return view('admin.definecategories', ['topic' => $topic]);
    }

    // public function store(Request $request){

    //     dd($request->all());
    //     $user = auth()->user();

    //     // Create a new post for the authenticated user
    //     $user->definecategories()->create([
    //         'title'=>$request['title'],
    //         'description'=>$request['description'],
    //         'group'=>$request['group'],
    //         'topic_id'=> $request['topic'],
    //     ]);

    //     // return redirect('/definecategories');
    //     return redirect()->route('definetopic')->with('success', 'Category added successfully');
    // }

    public function store(Request $request){
        dd($request->all());
        // echo "<pre>"; print_r($request->all()); exit();
        $topicTitle = $request['topic_title'];
        $topic = auth()->user()->definetopic()->where('title', $topicTitle)->firstOrNew();
        // dd($topicTitle);
        if (!$topic->exists) {
            // If the topic does not exist, set the title and save it to the database
            $topic->title = $topicTitle;
            $topic->save();
            
        }

        // Retrieve the topic id
        $topicId = $topic->id;
        
        // // Access the main category data
        // $mainCategoryData = [
        //     'title' => $request['title'],
        //     'description' => $request['description'],
        //     'group' => $request['group'],
        //     'topic_id' => $request['topic'],
        // ];
    
        // // Create the main category
        // $mainCategory = auth()->user()->definecategories()->create($mainCategoryData);
    
        // Access the appended data JSON string and decode it into an array
        $appendedData = json_decode($request['appendedData'], true);
    
        // Iterate through the appended data and create categories
        foreach ($appendedData as $appendedCategoryData) {
            $appendedCategoryData['topic_id'] = $topicId; // Assign the topic_id
            auth()->user()->definecategories()->create($appendedCategoryData);
        }
    
        return redirect()->route('definetopic')->with('success', 'Categories added successfully');
    }
    
    public function deleteCategory($id)
    {
        // Find the category by ID and delete it
        $category = DefineCategories::findOrFail($id);
        $category->delete();

        return redirect()->route('mycategories')->with('success', 'Category deleted successfully');
    }


    public function editCategory($id)
    {
        $category = DefineCategories::findOrFail($id);
    
        // Fetch the selected topic and its groups (or provide defaults if not found)
        $selectedTopic = Topics::find($category->topic_id);
    
        // Fetch all topics
        $topics = Topics::all();
    
        // Fetch groups for each topic
        $topicGroups = Topics::pluck('groups', 'id');
    
        return view('admin.editcategory', compact('category', 'topics', 'selectedTopic', 'topicGroups'));
    }
    
    
    
    



    public function updateCategory(Request $request, $id)
    {
        $category = DefineCategories::findOrFail($id);

        $category->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'group' => $request->input('group'),
            'topic_id'=>$request->input('topic'),
        ]);

        return redirect()->route('mycategories')->with('success', 'Category updated successfully');
    }

    public function showData(Request $request)
    {
        // Retrieve the selectedData from the query parameters
        $selectedData = json_decode($request->query('selectedData'), true);

        // Return the view with the received data
        return view('admin.previewpage', ['selectedData' => $selectedData]);
    }

}
