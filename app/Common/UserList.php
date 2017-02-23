<?php

namespace App\Common;

use Illuminate\Support\Facades\DB;

trait UserList
{
    public static function userList() {
        $users = auth()->user()->get();
        $userList = [];
        $userList[0] = 'Aucun';
        foreach($users as $user){
            if($user->email && ($user->confirmed || $user->new_create_by_admin) && $user->role == 'user'){
                $userList[$user->id] = $user->email . ' | ' . $user->name;
            }
        }

        return $userList;
    }
}