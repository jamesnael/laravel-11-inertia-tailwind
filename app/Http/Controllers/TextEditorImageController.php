<?php 
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class TextEditorImageController extends Controller
{
    public function storeImage(Request $request) {
        $request->validate([
            'file' => 'required|max:3072|mimes:jpg,jpeg,png',
        ]);

        if ($request->hasFile('file')) {
            $file_name = uniqid() . '.webp';
            $img       = Image::make($request->file('file'))->encode('webp');
            $img->save(public_path('/media/' . $file_name));

            $url = asset('media/' . $file_name);
            return response()->json(['fileName' => $file_name, 'uploaded'=> 1, 'url' => $url]);
        }
    }
}