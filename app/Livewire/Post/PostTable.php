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
        $this->th['title'] = ['label'=>'Whatever'];
        $this->th['created_at'] = ['label'=>'Created At'];
    }

    public function sortOrder($columnName="")
    {
        $this->table();
        if($this->sortDir == 'asc'){
            $this->sortDir = 'desc';
        }else{
            $this->sortDir = 'asc';
        }

        $columnName = Str::snake($columnName);
        $this->th[$columnName] = [
            'label' => Str::title(
                $this->th[$columnName]['label'] ?? $columnName
            ),
            'sort' => $this->sortDir
        ];
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
