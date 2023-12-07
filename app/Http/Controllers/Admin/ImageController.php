<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Picture;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImageController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pictures = Picture::all();
        return view('admin.image.view')->with('pictures', $pictures);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
       
        $picture = Picture::find($id);
     
            // Delete pictures               
            if ($picture->delete()) {
                Picture::where('id', $id)->delete();
                if(!empty($picture->url)){
                    if(Storage::disk('public')->exists($picture->url)){                            
                        Storage::delete('public/images/'.$picture->url);                            
                    }
                }
                Session::flash('flash_title', 'Success');
                Session::flash('flash_message', 'The picture has been deleted.');

                return redirect('/admin/image');
            } else {
                Session::flash('flash_title', 'Success');
                Session::flash('flash_message', 'Sorry, this picture could not be deleted.');
            }
          
        return redirect()
            ->back();  
    }
}
