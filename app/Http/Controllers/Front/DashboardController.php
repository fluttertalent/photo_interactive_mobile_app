<?php

namespace App\Http\Controllers\Front;

use App\Models\User;
use App\Models\Picture;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller{

    public function getUserData(Request $request, $id){        
        try {
            $picture = Picture::findOrFail($id); 
            $user = User::findOrFail($picture->user_id);
            $user_pictures = Picture::where('user_id',$user->id)->get();            
            return response()->json(['user'=>$user, 'pictures'=>$user_pictures]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'User not found'], 404);
        }
    }

    public function getPictureTable(Request $request){

        $data = $request->all();
        $lat = $data['lat'];
        $lng = $data['lng'];

        $pictures = DB::select("
            SELECT pictures.*, users.name as userName,
            (6371 * acos(cos(radians($lat)) * cos(radians(pictures.lat)) * cos(radians(pictures.lng) - radians($lng)) + sin(radians($lat)) * sin(radians(pictures.lat)))) AS distance
            FROM pictures
            LEFT JOIN users ON users.id = pictures.user_id            
            ORDER BY pictures.date DESC, pictures.time DESC
            LIMIT 2 
        ");

        $pictures = [];

        return response()->json(['pictures'=> $pictures]);
    }
}