<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Review extends Model
{
  
  public function user(): BelongsTo
  {
    return $this->belongsTo('App\User');
  }
   
  public function likes(): BelongsToMany
  {
    return $this->belongsToMany('App\User', 'likes')->withTimestamps();
  }
  
  public function isLikedBy(?User $user): bool
    {
        return $user
            ? (bool)$this->likes->where('id', $user->id)->count()
            : false;
    }
    
    public function getCountLikesAttribute():int
    {
      return $this->likes->count();
    }
   
   /*
  
  public function likes()
  {
    return $this->hasMany('App\Like');
  }
  /*
   Public function likedBy($user)
  {
    return Like::where('user_id', $user->id)->where('review_id', $this->id);
  }
  
 /* public function comments()
  {
    return $this->hasMany('App\Comment');
  }
  
  */
}
