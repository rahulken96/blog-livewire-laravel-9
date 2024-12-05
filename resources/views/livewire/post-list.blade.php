<div class=" px-3 lg:px-7 py-6">
    <div class="flex justify-between items-center border-b border-gray-100">
        <div class="text-gray-600">
            @if($this->activeCategory || $cari)
                <button class="gray-500 text-xs mr-3" wire:click="clearFilters()">X</button>
            @endif

            @if($this->activeCategory)
                Tags Postingan :
                <x-tags wire:navigate href="{{ route('blog.index', ['category' => $this->activeCategory->slug]) }}" :textColor="$this->activeCategory->text_color" :bgColor="$this->activeCategory->bg_color">
                    {{ $this->activeCategory->title }}
                </x-tags>
            @endif

            @if($cari)
                Mencari Postingan "{{ $cari }}..."
            @endif
        </div>

        <div class="flex items-center space-x-4 font-light ">
            <button class="{{ $sort === 'desc' ? 'text-gray-900 border-b border-gray-700': 'text-gray-500' }} py-4" wire:click="setSort('desc')">Terbaru</button>
            <button class="{{ $sort === 'asc' ? 'text-gray-900 border-b border-gray-700': 'text-gray-500' }} py-4 " wire:click="setSort('asc')">Terlama</button>
        </div>
    </div>
    <div class="py-4">
        @foreach ($this->posts as $item)
            <x-posts.post-item :item="$item"/>
        @endforeach
    </div>

    <div class="my-3">
        {{ $this->posts->onEachSide(1)->links() }}
    </div>
</div>
