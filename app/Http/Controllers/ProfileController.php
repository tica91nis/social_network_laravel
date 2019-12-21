<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use App\Event;

class ProfileController extends Controller
{
    public function viewProfile($id)
    {
        //Nadjemo korisnika sa zadatim id-jem
        //$user = User::find($id);  //ne mora da postoji Fk
        $user = User::findOrFail($id); //mora da postoji FK
        $event = Event::findOrFail($id);
       // echo $user->posts; //ovo posts je na osnovu metode posts() iz klase User
       $posts = $user->posts()->orderBy('created_at', 'desc')->get();
       $events= $user->events()->orderBy('date', 'asc')->get();
        return view('profile', array(
            'user'=> $user,
            'posts' => $posts,
            'events' => $events,
    ));
        
    }
}
