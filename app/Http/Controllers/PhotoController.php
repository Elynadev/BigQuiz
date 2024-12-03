<?php
 
namespace App\Http\Controllers;
 
use App\Http\Requests\ImagesRequest;
use Illuminate\View\View;

class PhotoController extends Controller
{
 
    public function create(): View
    {
        return view('photo');
    }
 
    public function store(ImagesRequest $request): View
    {
        $request->image->store(config('images.path'), 'public');
         
        return view('photo_ok');
    }
}