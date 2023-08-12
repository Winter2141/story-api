<?php


namespace App\Services\Interfaces;


use App\Models\User;

interface UserService
{
    public function doSearch($search_params);
    public function doCreate($params);
    public function doUpdate($params, User $user);
    public function doDelete(User $user);

    public function findByEmail($email);
    public function getUserList();

}
