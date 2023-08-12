<?php


namespace App\Services\Impl;
use \App\Services\Interfaces\UserService;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserServiceImpl implements UserService
{

    public function doSearch($search_params)
    {
        $users = User::query()->orderByDesc('created_at');
        if(isset($search_params['keyword']) && $search_params['keyword']) {
            $users->where(function($query) use($search_params) {
               $query->where('name', 'like', '%'.$search_params['keyword'].'%')
                    ->orWhere('email', 'like', '%'.$search_params['keyword'].'%');
            });
        }
        return $users;
    }

    public function doCreate($params)
    {
        $params['password'] = Hash::make($params['password']);
        return User::query()->create($params);
    }

    public function doUpdate($params, User $user)
    {
        return $user->update($params);
    }

    public function doDelete(User $user)
    {
        return $user->delete();
    }

    public function findByEmail($email)
    {
        return User::query()->where('email', $email)->first();
    }

    public function getUserList()
    {
        return User::query()->where("role", 2)->get();
    }
}
