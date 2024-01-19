<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DefineCategories;
use App\Models\Topics;
use Illuminate\Support\Facades\Route;

class CategoriesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function create($id)
    {
        $topic = Topics::find($id);
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
        try {
            $referringUrl = $request->headers->get('referer');
            
            // Get the path from the URL
            $path = parse_url($referringUrl, PHP_URL_PATH);
        
            // Get the route from the path
            $route = Route::getRoutes()->match(app('request')->create($path))->getName();
        } catch (\Exception $e) {
            $route = $path;
        }

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
        $appendedData =$request['appendedGroup'];
      
        foreach ($appendedData as $group) {
            $groupTitle = $group[0]??""; 
        
            // Insert or use the group title in the database here
        
            $titles = $group['title'];
            $descriptions = $group['description'];
        
            foreach ($titles as $index => $title) {
                // Assuming $descriptions and $titles have the same length
                $description = $descriptions[$index];
                $mainCategoryData = [
                        'title' => $title??"",
                        'description' => $description??"",
                        'group' => $groupTitle??"",
                        'topic_id' => $topicId,
                    ];
                    auth()->user()->definecategories()->create($mainCategoryData);

            }
        }
        $user = auth()->user();

    // Your PHP variables
    $values = [
        ["Content Coverage", "Excellent and thorough understanding of the reading material.  All content clearly and thoroughly explained and referenced.", "Very good understanding of the reading material.  Almost all of the content was clearly and thoroughly explained and referenced.", "Good understanding of material.  The content covered was explained clearly and referenced. ", "Some major points of the reading were not covered or covered in a limited manner.  Some explanations may be incorrect. Limited references.  ", "Limited understanding of material. Some or much of the coverage may be incorrect. Limited or poor references.", "Most to all of the content is not explained or the material is explained incorrectly. No references.", $topicId],
        ["Critical Analysis ", "Critical analysis and evaluative approach.  The presentation moves beyond the reading and adds both theoretical and real world context.  ", "Critical analysis and evaluative approach evident. Theoretical or real world context added.  ", " Critical analysis and evaluative approach evident but possibly inconsistent. Context added may be questionable.  ", "Some critical analysis attempted.  Context added may be questionable.  ", "Limited critical analysis or mainly descriptive. Limited or not context added. ", "Material was covered in a purely descriptive manner.  No further attempts to analyse the material or add context. ", $topicId],
        ["Structure", "Presentation is clearly structured and easy to follow.  Main points are evident and the presentation follows a logical progression.   ", "Presentation is mostly easy to follow.  Main points are evident and the presentation follows a logical progression.   ", "Presentation is mostly easy to follow.  Main points may not be clear.  Presentation follows a mostly logical progression.   ", "Presentation may be difficult to follow at times.  Main points are established but may not be clear.  Reasons for the structure may not be clear.  ", "Presentation is often difficult to follow.  Main points may be hazy.  Structure does not usually follow a logical pattern, jumps around. ", "Presentation lacks structure and is very difficult to follow.  Main points are not made.", $topicId],
        ["Delivery and use of powerpoint", "Vocal delivery is clear and easy to understand.  Powerpoint slides are clear and easy to see/read.  ", "Vocal delivery is mostly clear and easy to understand.  Powerpoint slides are mostly clear and easy to see/read.  ", "Speaker is occasionally hard to hear or understand.  Powerpoint is occasionally difficult to read or follow.  ", "Speaker is often hard to hear or understand.  Powerpoint is often difficult to read or follow.  ", "Speaker is very hard to hear or understand.  Powerpoint is very difficult to read or follow at times.  ", "Speaker if often unintelligible.  Powerpoint slides are unhelpful for the presentation. ", $topicId],
        ["Discussion Facilitation", "Clear and consistent effort is made to keep discussion going for the full session.  Student is well prepared to facilitate a relevant discussion of breadth and depth.  ", "Student makes a very good effort to keep discussion going.  Student has relevant questions for a solid discussion.  ", "Student makes a solid effort to keep discussion going.  Student has relevant questions prepared.  ", "Student makes effort to keep discussion going.  More, and more relevant, questions could be prepared for discussion.", "Student makes limited effort to keep discussion going.   Few or poor questions are prepared for discussion.", "Student is unprepared to facilitate discussion, makes little or no effort to keep discussion going.", $topicId]
    ];

    // Loop through the array and perform the desired actions
    foreach ($values as $data) {
        // Assuming $user is an instance of a class that has the method definerubrics()
        $user->definerubrics()->create([
            'title' => $data[0],
            'first' => $data[1],
            'second' => $data[2],
            'secondtwo' => $data[3],
            'third' => $data[4],
            'pass' => $data[5],
            'fail' => $data[6],
            'topic_id' => $data[7],
        ]);
    }

        if($route == "definetopic"){
            return redirect()->route('definetopic')->with('success', 'Categories added successfully');
        }
        else{
            return redirect()->route('definecategories', ['id' => $topicId])->with('success', 'Categories added successfully');
        }
        
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
            'title' => $request->input('title')??"",
            'description' => $request->input('description')??"",
            'group' => $request->input('group')??"",
            'topic_id'=>$request->input('topic')??"",
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
