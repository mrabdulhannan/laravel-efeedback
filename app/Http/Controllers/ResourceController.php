<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Resource;

class ResourceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        // $files = Storage::files('uploads'); // Change 'uploads' to your storage path
        $files = $user->resources();
        return view('admin.addresources', compact('files'));
    }
    
    public function showallfiles()
    {
        $user = auth()->user();
        // $files = Storage::files('uploads'); // Change 'uploads' to your storage path
        $files = $user->resources();
        return view('admin.allresources', compact('files'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,docx,xlsx,ppt,png,jpg,jpeg,gif|max:10240', // Adjust file types and size as needed
        ]);

        // $path = $profileImage->store('profile_images', 'public');
        $path = $request->file('file')->store('uploads','public'); // Change 'uploads' to your storage path


        $fileName = $request['file_name'];
        $filePath = $path;
        $fileData = [
            'file_name' =>  $fileName ?? "",
            'file_path' => $filePath ?? "",
        ];
        auth()->user()->resources()->create($fileData);

        return redirect()->route('file.index')->with('success', 'File uploaded successfully.');
    }

    public function destroy($id, $filename)
    {
        // dd($filename);
        Storage::delete('public/uploads/'.$filename); // Change 'uploads' to your storage path
        $category = Resource::findOrFail($id);
        $category->delete();
        
        
        return redirect()->route('showallfiles')->with('success', 'File deleted successfully.');
    }


    
}
