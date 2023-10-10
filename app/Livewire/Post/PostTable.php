<?php

namespace App\Livewire\Post;

use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use App\Models\Post;

class PostTable extends Component
{
    use WithPagination;

    public $perPage = 5;
    public $sortColumn = "created_at";
    public $sortDir = "desc";
    public $sortLink = '';
    public $searchKeyword = '';
    public $th = [];
    public $confirmDeletion = false;
    public $set_id;

    public function mount()
    {
        $this->table();
    }

    public function render()
    {
        $post = Post::orderby($this->sortColumn,$this->sortDir)->select('*');
        if(!empty($this->searchKeyword)){
            $post->orWhere('title','like',"%".$this->searchKeyword."%");
            $post->orWhere('content','like',"%".$this->searchKeyword."%");
        }
        $posts = $post->paginate($this->perPage);

        return view('livewire.post.post-table',['posts' => $posts]);
    }

    public function updated()
    {
        $this->resetPage();
    }

    public function table()
    {
        $this->th['title'] = 'Title';
        $this->th['created_at'] = 'Created At';
    }

    public function sortOrder($columnName="")
    {
        $up = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 ml-1"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" /></svg>';
        $down = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 ml-1"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>';
        $this->th = [];

        if($this->sortDir == 'asc'){
            $this->sortDir = 'desc';
            $icon = $down;
        }else{
            $this->sortDir = 'asc';
            $icon = $up;
        }

        $this->th[Str::snake($columnName)] = Str::title($columnName) . $icon;
        $this->sortColumn = $columnName;
    }

    public function delete($id)
    {
        $this->confirmDeletion = true;
        $this->set_id = $id;
    }

    public function destroy()
    {

        Post::destroy($this->set_id);
        $this->confirmDeletion = false;
        session()->flash('success', __('Post deleted.'));
        return redirect()->to('/post');
    }
}
