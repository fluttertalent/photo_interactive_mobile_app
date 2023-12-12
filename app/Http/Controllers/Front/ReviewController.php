<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Auth;
use App\Models\Review;
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
                ]);  
            
                $user = Auth::user();                
                Review::create([                  
                    'user_id' => $user->id,
                    'date' => date("Y-m-d"),
                    'mark' => $request->input('mark'),
                    'picture_id' => $request->input('picture_id'),
                    
                ]);                         
                return response()->json(['data'=>'success']);

            } catch (\Exception $e) {            
                return response()->json(['data' => 'error'], 404);
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
}