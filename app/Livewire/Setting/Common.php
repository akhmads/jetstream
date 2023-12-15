<?php

namespace App\Livewire\Setting;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\Setting;

class Common extends Component
{
    public $period;

    public function render()
    {
        return view('livewire.setting.common');
    }

    public function mount(Request $request)
    {
        $this->period = config('settings.period');
    }

    public function store()
    {
        $valid = $this->validate([
            'period' => 'required',
        ]);

        $setting = Setting::query()->firstOrCreate(['key' => 'period'],['value' => $this->period ]);
        $setting->value = $this->period;
        $setting->save();

        Setting::refreshCache();

        session()->flash('success', __('Saved'));
    }
}
