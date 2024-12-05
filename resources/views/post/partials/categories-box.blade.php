<div id="recommended-topics-box">
    <h3 class="text-lg font-semibold text-gray-900 mb-3">Rekomendasi Topik</h3>
    <div class="topics flex flex-wrap justify-start gap-2">
        @foreach ($categories as $category)
            <x-tags wire:navigate href="{{ route('blog.index', ['category' => $category->slug]) }}" :textColor="$category->text_color" :bgColor="$category->bg_color">
                {{ $category->title }}
            </x-tags>
        @endforeach
    </div>
</div>
