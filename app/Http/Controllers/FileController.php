<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Http\Request;

class FileController extends Controller
{
    function getFile($filename){
    	$file=Storage::disk('public')->get($filename);
 
		return (new Response($file, 200));
            //   ->header('Content-Type', 'image/jpeg');
    }
    public function getDownload($filename){
        $filepath = public_path('uploads\\');
        return Response()->download($filepath . $filename);
    }
    function getFiles($filename){
    	$files = Storage::files("public");
        $images=array();
        foreach ($files as $key => $value) {
            $value= str_replace("public/","",$value);
            array_push($images,$value);
        }
        return view('show', ['images' => $images]);
    }
}
