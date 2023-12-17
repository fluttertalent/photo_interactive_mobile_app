<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller{

    public function sendReview(Request $request){        
        if(Auth::check()){
            try {
                
                $request->validate([
                    'mark' => 'required',
                    'picture_id' => 'required',
                    'comment' => 'required'                
                ]);  
            
                $user = Auth::user();                
                Review::create([                  
                    'user_id' => $user->id,
                    'date' => date("Y-m-d"),
                    'mark' => $request->input('mark'),
                    'picture_id' => $request->input('picture_id'),
                    'comment' => $request->input('comment')                    
                ]);                             
                return response()->json(['data'=>'success']);

            } catch (\Exception $e) {                        
                return response()->json(['data' => 'error', 'message'=>$e->getMessage()], 404);
            }
        }
        return response()->json(['data' => 'unauthorized']);        
    }
    

    public function rankingView(Request $request){    
        if(Auth::check()){ 
            return view('review');
        }
        return redirect()->route('login')
            ->withErrors([
            'email' => 'Please login to see the ranking of users.',
        ])->onlyInput('email');
    }

    public function ranking(Request $request){
        if(Auth::check()){
            $method = $request->query('method');
            
            $users = [];
            if($method == 'week'){
                $users = DB::select("
                    SELECT *,
                    (review_count * 0.6) + (mark * 0.4) AS score
                    FROM (
                        SELECT users.*,
                        COUNT(reviews.id) AS review_count, ROUND(AVG(reviews.mark), 1) AS mark
                        FROM users
                        LEFT JOIN reviews
                        ON users.id = reviews.user_id
                        WHERE reviews.date >= NOW() - INTERVAL 1 WEEK 
                        GROUP BY users.id
                    ) AS user_reviews
                    ORDER BY score DESC;
                ");
            }else if($method == 'total'){
                $users = DB::select("
                    SELECT *,
                    (review_count * 0.6) + (mark * 0.4) AS score
                    FROM (
                        SELECT users.*,
                        COUNT(reviews.id) AS review_count, ROUND(AVG(reviews.mark), 1) AS mark
                        FROM users
                        LEFT JOIN reviews
                        ON users.id = reviews.user_id
                        GROUP BY users.id
                    ) AS user_reviews
                    ORDER BY score DESC;
                ");
            }else if($method == 'month'){
                $users = DB::select("
                    SELECT *,
                    (review_count * 0.6) + (mark * 0.4) AS score
                    FROM (
                        SELECT users.*,
                        COUNT(reviews.id) AS review_count, ROUND(AVG(reviews.mark), 1) AS mark
                        FROM users
                        LEFT JOIN reviews
                        ON users.id = reviews.user_id
                        WHERE reviews.date >= NOW() - INTERVAL 1 MONTH 
                        GROUP BY users.id
                    ) AS user_reviews
                    ORDER BY score DESC;
                ");
            }else if($method == 'year'){
                $users = DB::select("
                    SELECT *,
                    (review_count * 0.6) + (mark * 0.4) AS score
                    FROM (
                        SELECT users.*,
                        COUNT(reviews.id) AS review_count, ROUND(AVG(reviews.mark), 1) AS mark
                        FROM users
                        LEFT JOIN reviews
                        ON users.id = reviews.user_id
                        WHERE reviews.date >= NOW() - INTERVAL 1 YEAR 
                        GROUP BY users.id
                    ) AS user_reviews
                    ORDER BY score DESC;
                ");
            }
            ;

            return response()->json(['users' => $users]);
        }
        return redirect()->route('login')
            ->withErrors([
            'email' => 'Please login to access to photo page.',
        ])->onlyInput('email');
    }
    
    public function pictureRanking(Request $request){
        if(Auth::check()){ 
            $pictures = DB::select("
                    SELECT *,
                    (review_count * 0.6) + (mark * 0.4) AS score
                    FROM (
                        SELECT pictures.*,
                        COUNT(reviews.id) AS review_count, ROUND(AVG(reviews.mark), 1) AS mark
                        FROM pictures
                        LEFT JOIN reviews
                        ON pictures.id = reviews.picture_id                        
                        GROUP BY pictures.id
                    ) AS picture_reviews
                    ORDER BY score DESC;
            ");
            
        }
        return redirect()->route('login')
            ->withErrors([
            'email' => 'Please login to see the ranking of users.',
        ])->onlyInput('email');
    }

    public function getReviewPictures(Request $request, $user_id){
        if(Auth::check()){
            
            $user = User::where('id', $user_id)->get();
            $pictures = DB::select("
                    SELECT *,
                    (review_count * 0.6) + (mark * 0.4) AS score
                    FROM (
                        SELECT pictures.*,
                        COUNT(reviews.id) AS review_count, ROUND(AVG(reviews.mark), 1) AS mark
                        FROM pictures
                        LEFT JOIN reviews
                        ON pictures.id = reviews.picture_id       
                        WHERE pictures.user_id = $user_id                 
                        GROUP BY pictures.id
                    ) AS picture_reviews
                    ORDER BY score DESC;
            ");
            return view('picreview')->with(['user'=>$user,  'pictures'=>$pictures]);
        }
        return redirect()->route('login')
            ->withErrors([
            'email' => 'Please login to see the reviews of the user.',
        ])->onlyInput('email');
    }

    public function getComments(Request $request){
        if(Auth::check()){
            $picture_id = $request->query('id');
            $comments = DB::select("                   
                        SELECT reviews.*,
                        users.avatar AS avatar,
                        users.name as name
                        FROM reviews
                        LEFT JOIN users
                        ON users.id = reviews.user_id       
                        WHERE reviews.picture_id = $picture_id               
                        ORDER BY reviews.date DESC;
            ");
            return response()->json(["comments" => $comments]);
        }
        return redirect()->route('login')
            ->withErrors([
            'email' => 'Please login to see the comments of the picture.',
        ])->onlyInput('email');
    }
}