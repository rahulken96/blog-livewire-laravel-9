<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class PostList extends Component
{
    use WithPagination;

    public $sort = 'desc';
    public $cari = '';

    protected $listeners = ['updatedCari']; // List event yang ditangkap (Livewire V 2.x)

    public function setSort($sort)
    {
        $this->sort = ($sort === 'desc') ? 'desc' : 'asc';
        $this->resetPage();
    }

    public function updatedCari($cari)
    {
        $this->cari = $cari;
        $this->resetPage();
    }

    public function getPostsProperty()
    {
        // return Post::published()->orderBy('published_at', $this->sort)->simplePaginate(5); /* Menampilkan pagination dengan simpel */

        return Post::published()
        ->where('title', 'like', "%{$this->cari}%")
        ->orderBy('published_at', $this->sort)
        ->paginate(5);
    }

    public function render()
    {
        return view('livewire.post-list');
    }
}
