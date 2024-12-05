@props(['item'])

<div {{ $attributes }}>
    <a href="#">
        <div>
            <img class="w-full rounded-xl" src="{{ $item->getThumbnailImage() }}">
        </div>
    </a>
    <div class="mt-3">
        <div class="flex items-center mb-2 gap-x-2">
            @if(!empty($item->categories))
                @php $category = $item->categories->first() @endphp

                <x-tags
                wire:navigate href="{{ route('blog.index', ['category' => $category->slug]) }}"
                :textColor="$category->text_color" :bgColor="$category->bg_color">
                    {{ $category->title }}
                </x-tags>
            @endif

            <p class="text-gray-500 text-sm">{{ date('d F Y H:i', strtotime($item->published_at)) }}</p>
        </div>
        <a href="#" class="text-xl font-bold text-gray-900">{{ $item->title ?? '-' }}</a>
    </div>

</div>
