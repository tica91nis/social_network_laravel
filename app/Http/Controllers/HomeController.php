<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post; //ukljucujemo model

use Auth; //Klasa za logovanog korisnika

use App\User; //dodajemo klasu user

use App\Event; //ukljucimo model event

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts=Post::orderBy('created_at', 'desc')->get();
        $events=Event::orderBy('date', 'asc')->get();
        //var_dump($posts);
        $user=Auth::user();
        $following=$user->following; //ovo vraca nis objekata
        $followers=$user->followers;

        //odredjujemo mutual, following, followers, others
        $followingIds=$user->following->pluck('id')->toArray(); //pluck se koristi da se od svih koje pratim izvadi samo id
        //id svih korinika koje pratim

        $followerIds=$user->followers->pluck('id')->toArray(); //id svih onih koji me prate

        $mutualIds =
            array_intersect($followingIds, $followerIds); //id uzajamnih prijatelja

        $followingIds = array_diff($followingIds, $mutualIds);
        $followerIds = array_diff($followerIds, $mutualIds);

        $mutuals = User::whereIn('id', $mutualIds)->orderBy('name')->get(); //user-> get je select* from users
        
        $followers = User::whereIn('id', $followerIds)->orderBy('name')->get();
        $following = User::whereIn('id', $followingIds)->orderBy('name')->get();
        $others = User::whereNotIn('id',
                array_merge($mutualIds, $followerIds, $followingIds, array($user->id)))->orderBy('name')->get();
        //echo $followers;


        return view('home', array('objave' => $posts, 
                                    'events' => $events,
                                    'following' => $following, 
                                    'followers' => $followers, 
                                    'mutuals' => $mutuals,
                                    'others' => $others,
                                    ));
    }

    public function publish()
    {
        //$_POST['content'] - obican php ali sada drugacije
        $content = request('content'); //ovo je u laravelu, preko request mogu da se dohvate post varijable
        // echo Auth::user(); //logovani korisnik
        $id = Auth::user()->id; //id logovanog korisnika

        if(empty($content))
        {
        return redirect('/home')
        ->with('error', 'Post cannot be published!'); 
        }
        else
        {
        //Ubaciti novi red u tableu posts
        //1) Kreirati novi objekat klase Post
        //2) Popunimo polja ovom objektu --id polje nismo u obavezi da popunjavamo zato sto je autoincrement
        //3) Pozvati metodu save()

        $post = new Post; //konstruktor bez parametara moze i bez zagrada znaci moza i sa $post=new Post();
        $post->user_id = $id;
        $post->content = $content; //sadrzaj is textarea
        $post->save();

        //redirekcija na home page
        return redirect('/home')
        ->with('success', 'Post published!'); //metoda with ima dva parametra, prvi koji je tip poruke, znaci sta da ispise kada unesemo komentar
        }
        
    }

    public function deletePost($post)
    {
        $post->delete();
        return redirect('/home')
        ->with('message', 'Post deleated!');
    }
   /* public function followUser($id)
    {
    $user = User::find($id);
    if(!$user) {
    
     return redirect()->back()->with('error', 'User does not exist.'); 
    }

    $user->followers()->attach(auth()->user()->id);
    return redirect()->back()->with('success', 'Successfully followed the user.');
    }*/
}
