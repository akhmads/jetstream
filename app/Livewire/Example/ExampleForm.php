<?php

namespace App\Livewire\Example;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Example;
use App\Models\Code;


class ExampleForm extends Component
{
    use WithFileUploads;

    public $set_id;
    public $code;
    public $name;
    public $gender;
    public $birth_date;
    public $address;
    public $active;
    public $avatar;
    public $showAvatar;

    public function render()
    {
        return view('livewire.example.example-form');
    }

    public function mount(Request $request)
    {
        $example = Example::Find($request->id);
        $this->set_id = $example->id ?? '';
        $this->code = $example->code ?? '[auto]';
        $this->name = $example->name ?? '';
        $this->gender = $example->gender ?? '';
        $this->birth_date = isset($example->birth_date) ? ($example->birth_date)->format('Y-m-d') : '';
        $this->address = $example->address ?? '';
        $this->active = $example->active ?? '';
        $this->showAvatar = $example->avatar ?? '';
    }

    public function store()
    {
        if(empty($this->set_id))
        {
            $valid = $this->validate([
                'name' => 'required',
                'gender' => 'required',
                'birth_date' => 'required',
                'address' => 'required',
                'avatar' => 'required|image|max:2048|mimes:jpg,jpeg,png,webp,svg',
            ]);

            $avatar = $this->avatar->store('/', 'avatar_disk');
            unset($valid['avatar']);

            $extra['code'] = $this->autocode();
            $extra['active'] = $this->active ? 1 : 0;
            $extra['avatar'] = $avatar;
            $example = Example::create($valid + $extra);
            session()->flash('success', __('Example saved'));
            return redirect()->route('example.form',$example->id);
        }
        else
        {
            $valid = $this->validate([
                'name' => 'required',
                'gender' => 'required',
                'birth_date' => 'required',
                'address' => 'required',
                'avatar' => 'nullable|image|max:2048|mimes:jpg,jpeg,png,webp,svg',
            ]);
            $extra['active'] = $this->active ? 1 : 0;

            unset($valid['avatar']);
            if( !empty($this->avatar) ){
                $avatar = $this->avatar->store('/', 'avatar_disk');
                $extra['avatar'] = $avatar;
            }

            $example = Example::find($this->set_id);
            $example->update($valid + $extra);
            session()->flash('success', __('Example saved'));
            return redirect()->route('example.form',$example->id);
        }
    }

    protected function autocode(): string
    {
        $prefix = 'CNT/'.date('y').'/'.date('m').'/';
        Code::updateOrCreate(
            ['prefix' => $prefix],
            ['num' => DB::raw('num+1')]
        );
        $code = Code::where('prefix', $prefix)->first();
        return $code->prefix . Str::padLeft($code->num, 4, '0');
    }
}
