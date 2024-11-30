<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PostSearch extends Component
{
    public $cari = '';

    public function update()
    {
        $this->dispatch('cari', cari: $this->cari);
    }

    public function updatedCari()
    {
        // $this->dispatch('cari', cari : $this->cari); /* Livewire V 3.x */

        $this->emit('updatedCari', $this->cari); /* Livewire V 2.x */
    }

    public function cariPost()
    {
        $this->emit('cariPost', $this->cari); /* Livewire V 2.x */
    }

    public function render()
    {
        return view('livewire.post-search');
    }
}
