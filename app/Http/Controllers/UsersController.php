<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Validator;

class UsersController extends Controller
{
    
    //コンストラクタ （このクラスが呼ばれると最初にこの処理をする）
    public function __construct()
    {
        // ログインしていなかったらログインページに遷移する（この処理を消すとログインしなくてもページを表示する）
        $this->middleware('auth');
    }
    public function show($user_id)
    {
        $user = User::where('id',$user_id)->firstOrFail()->load(['reviews.user','reviews.likes']);
        
        $reviews = $user->reviews->sortByDesc('created_at');
        
        return view('user/show',['user'=>$user, 'reviews'=>$reviews,]);
    }
    
     public function edit()
    {
        $user = Auth::user();
            
        return view('user/edit', ['user' => $user]);
    }
    
    public function update(Request $request)
    {
        //バリデーション（入力値チェック）
        $validator = Validator::make($request->all() , [
            'user_name' => 'required|string|max:255',
            'user_password' => 'required|string|min:6|confirmed',
            ]);

        //バリデーションの結果がエラーの場合
        if ($validator->fails())
        {
          return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        
        $user = User::find($request->id);
        $user->name = $request->user_name;
        if ($request->user_profile_photo !=null) {
            $request->user_profile_photo->storeAs('public/user_images', $user->id . '.jpg');
            $user->profile_photo = $user->id . '.jpg';
        }
        $user->password = bcrypt($request->user_password);
        $user->save();

        return redirect('/users/'.$request->id);
    }
    
        public function likes($user_id)
    {
        $user = User::where('id', $user_id)->first()->load(['likes.user', 'likes.likes']);

        $reviews = $user->likes->sortByDesc('created_at');

        return view('user.likes', ['user' => $user,'reviews' => $reviews,]);
    }
    
    public function followings($user_id)
    {
        $user = User::where('id', $user_id)->first()->load('followings.followers');

        $followings = $user->followings->sortByDesc('created_at');

        return view('user.followings', ['user' => $user,'followings' => $followings,]);
    }
    
    public function followers(string $user_id)
    {
        $user = User::where('id', $user_id)->first()->load('followers.followers');

        $followers = $user->followers->sortByDesc('created_at');

        return view('user.followers', ['user' => $user,'followers' => $followers,]);
    }
    
    public function follow(Request $request, string $user_id)
    {
        $user = User::where('id', $user_id)->first();

        if ($user->id === $request->user()->id)
        {
            return abort('404', 'Cannot follow yourself.');
        }

        $request->user()->followings()->detach($user);
        $request->user()->followings()->attach($user);

        return ['id' => $user_id];
    }
    
    public function unfollow(Request $request, string $user_id)
    {
        $user = User::where('id', $user_id)->first();

        if ($user->id === $request->user()->id)
        {
            return abort('404', 'Cannot follow yourself.');
        }

        $request->user()->followings()->detach($user);

        return ['id' => $user_id];
    }
}
