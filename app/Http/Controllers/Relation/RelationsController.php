<?php

namespace App\Http\Controllers\Relation;

use App\User;
use App\Http\Controllers\Controller;
use App\Models\Phone;

class RelationsController extends Controller
{

    // one to one relationship
    public function hasOneRelation() {
    $user = User::with(['phone' => function($q){
        $q ->select('code', 'phone', 'user_id');
    }])->find(1);
    // return $user -> name;
    // return $user -> phone -> code;
    // return $user -> phone;
    return response() -> json($user);
    }

    // one to one relationship reverse
    public function hasOneRelationReverse(){
        $phone = Phone::with(['user' => function($q){
            $q -> select('id', 'name');
        }])->find(1);
        // make some attribute visible
        $phone ->makeVisible(['user_id']);
        // $phone -> makeHidden(['code']);
        // return $phone -> user;
        return $phone;
    }

    // User Has Phone
    public function getUserHasPhone(){
        return User::whereHas('phone') -> get( );
    }

    // User Has Not Phone
    public function getUserNotHasPhone(){
        return User::whereDoesntHave('phone') -> get();
    }

    // Get User With Condition
    public function getUserWhereHasPhoneWithCondition(){
        return User::whereHas('phone', function($q){
            $q -> where('code' , '02');
        }) -> get( );
    }

}
