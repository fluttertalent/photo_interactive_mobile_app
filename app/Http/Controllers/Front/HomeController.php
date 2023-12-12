<?php

namespace App\Http\Controllers\Front;

use App\Models\User;
use App\Models\Picture;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller{

    public function show($user_id)
    {
        $user = User::where('id', $user_id)->get();
        $pictures = Picture::where('user_id', $user_id)->get();

        $pictures = DB::select("SELECT pictures.*, COUNT(reviews.id) AS review_count, ROUND(AVG(reviews.mark), 1) AS average_mark
        FROM pictures
        LEFT JOIN reviews ON pictures.id = reviews.picture_id
        WHERE pictures.user_id = $user_id
        GROUP BY pictures.id
        ORDER BY review_count DESC;");
        
        return view('welcome')->with(['user'=>$user[0],'pictures'=>$pictures]);
    }

}