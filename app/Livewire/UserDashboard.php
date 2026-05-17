<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;

class UserDashboard extends Component
{
    public $view;

    #[Url]
    public function setView($viewName)
    {
        $allowed = ['main', 'reserve', 'my-cells', 'history', 'statistic'];
        $this->view = in_array($viewName, $allowed) ? $viewName : 'main';
    }

    public function mount()
    {
        if (blank($this->view)) {
            $this->view = 'main';
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.user-dashboard');
    }
}
