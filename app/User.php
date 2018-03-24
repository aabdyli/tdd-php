<?php

namespace App;

use Illuminate\Support\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email',
    ];

    public function threads()
    {
        return $this->hasMany(Thread::class)->latest();
    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

    public function unredNotifications()
    {
        return $this->notifications()
                    ->whereNull('read_at');
    }

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function lastReply()
    {
        return $this->hasOne(Reply::class)->latest();
    }

    public function visitedThreadCacheKey($thread)
    {
        return sprintf("users.%s.visits.%s", $this->id, $thread->id);
    }

    public function read($thread)
    {
        cache()->forever(
            $this->visitedThreadCacheKey($thread),
            Carbon::now()
        );
    }
}
