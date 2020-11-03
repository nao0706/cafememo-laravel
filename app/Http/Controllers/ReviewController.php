<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Review;
use App\Http\Requests\ReviewRequest;
use Auth;
use Validator;

use InterventionImage;

class ReviewController extends Controller
{
   
    
    public function index()
    {
        $reviews = Review::all()->sortByDesc('created_at')->load(['user','likes']);//N+1問題対処法
        //dd($reviews);
        return view('reviews.index',compact('reviews'));
    }
    
    public function show($id)
    {
        $review = Review::where('id',$id)->where('status',1)->first();
        
        return view('reviews.show',compact('review'));
    }
    
    public function create()
    {
        return view('reviews.review');
    }
    
    public function store(ReviewRequest $request, Review $review)
    {
        $review = $request->all();
        
        
        
        if($request->hasfile('image')){
            
            $request->file('image')->store('/public/images');
            
            $data = ['user_id' => \Auth::id(), 'title' => $review['title'], 'body' => $review['body'], 'image' => $request->file('image')->hashName()];
           
        
        }else{
            $data = ['user_id' => \Auth::id(), 'title' => $review['title'], 'body' => $review['body']];
        }
        
        Review::insert($data);
        
        return redirect('/')->with('flash_message', '投稿が完了しました');
    }
    
    public function edit(Review $review)
    {
        return view('reviews.edit', compact('review'));    
    }
    
       public function update(ReviewRequest $request, Review $review)
    {
 
        $review->title = $request->title;
        $review->body = $request->body;
        /*
        if ($request->image !=null) {
            $request->image->storeAs('public/images', $user->id . '.jpg');
            $review->image = $user->id . '.jpg';
        }
        */
        $review->save();
        return redirect()->route('reviews.index');
    }
    public function destroy($review_id)
    {
        $review = Review::find($review_id);
        $review->delete();
        return redirect('/');
    }
    
    public function like(Request $request, Review $review)
    {
        $review->likes()->detach($request->user()->id);
        $review->likes()->attach($request->user()->id);

        return [
            'id' => $review->id,
            'countLikes' => $review->count_likes,
        ];
    }

    public function unlike(Request $request, Review $review)
    {
        $review->likes()->detach($request->user()->id);

        return [
            'id' => $review->id,
            'countLikes' => $review->count_likes,
        ];
    }

}
