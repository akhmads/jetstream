<?php

namespace App\Livewire\Post;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Http\Request;
use App\Models\Post;

class PostForm extends Component
{
    public $set_id;
    public $title = '';
    public $content = '';
    public $type = '';

    public function render()
    {
        return view('livewire.post.post-form');
    }

    public function mount(Request $request)
    {
        $post = Post::Find($request->id);
        $this->set_id = $post->id ?? '';
        $this->title = $post->title ?? '';
        $this->type = $post->type ?? '';
        $this->content = $post->content ?? '';
    }

    public function store()
    {
        sleep(5);
        if(empty($this->set_id))
        {
            $valid = $this->validate([
                'title' => 'required|max:255',
                'content' => 'required',
            ]);

            $slug = $slug_tmp = \Illuminate\Support\Str::slug($valid['title']);
            $post = Post::where('slug', $slug)->first('id');
            if ( isset($post->id) ) {
                $slug = '';
            }
            $extra = [
                'slug' => $slug,
                'user_id' => auth()->user()->id,
            ];

            $post = Post::create($valid + $extra);
            if(empty($slug)){
                $post->slug = $slug_tmp . '-' . $post->id;
                $post->save();
            }
        }
        else
        {
            $valid = $this->validate([
                'title' => 'required|max:255',
                'content' => 'required',
            ]);
            $code = Post::find($this->set_id);
            $code->update($valid);
        }

        $this->resetErrorBag();
        $this->dispatch('saved');
        session()->flash('success', __('Post saved'));
    }
}
