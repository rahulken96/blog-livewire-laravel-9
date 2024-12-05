<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;

class PostList extends Component
{
    use WithPagination;

    public $sort = 'desc';
    public $cari = '';
    public $category = '';

    protected $listeners = ['updatedCari', 'cariPost', 'activeCategory']; // List event yang ditangkap (Livewire V 2.x)

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

    public function clearFilters()
    {
        $this->cari = '';
        $this->category = '';
        $this->resetPage();
    }

    public function cariPost($cari)
    {
        $this->cari = $cari;
        $this->resetPage();
    }

    public function getPostsProperty()
    {
        // return Post::published()->orderBy('published_at', $this->sort)->simplePaginate(5); /* Menampilkan pagination dengan simpel */

        return Post::published()
        ->where('title', 'like', "%{$this->cari}%")
        ->when($this->activeCategory, function ($query) {
            $query->withCategory($this->category);
        })
        ->orderBy('published_at', $this->sort)
        ->paginate(5);
    }

    public function getActiveCategoryProperty()
    {
        return Category::where('slug', $this->category)->first();
    }

    public function render()
    {
        return view('livewire.post-list');
    }
}
