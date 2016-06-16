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
            $userList[$user->id] = $user->email . ' | ' . $user->name;
        }

        return $userList;
    }
}