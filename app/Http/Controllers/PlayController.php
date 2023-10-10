<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Post;

class PlayController extends Controller
{
    public function index()
    {
        // $users = DB::table('users')->get(['name','email']);
        // $users = DB::table('users')->first(['name','email']);
        // $users = DB::table('users')->find(1,['name','email','id']);

        //$users = User::all()->get(['name','email']);
        //$users = User::where('id',1)->first(['name','email']);
        //$users = User::find(1,['name','email']);

        echo '<h2>Play Menu</h2>';
        echo '<ul>';
        echo '<li><a href="'.url('play/relation').'">Model Relation</a></li>';
        echo '</ul>';
    }

    public function page(Request $request)
    {
        if( $request->page == 'relation' ){
            $this->relation();
        }
    }

    public function relation()
    {
        $posts = Post::all();

        foreach( $posts as $post ){

            echo sprintf('Title : %s<br />', $post->title );
            echo sprintf('Author : %s<br />', $post->user->name );
            echo sprintf('Created At : %s<br />', $post->created_at->diffForHumans() );
            echo '<hr style="border:1px solid #eee;" />';

            // $blade .= <<<'blade'
            //     <div style="border-bottom:1px solid #eee;">
            //         <p>{{ $post->title }}</p>
            //         <p>{{ $post->user->name }}</p>
            //     </div>
            // blade;
        }
    }
}
