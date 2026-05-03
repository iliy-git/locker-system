<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
class UserDashboard extends Component
{
    public $view = 'reserve';

    protected $queryString = ['view'];

    public function setView($viewName)
    {
        $this->view = $viewName;
    }
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.user-dashboard');
    }
}
