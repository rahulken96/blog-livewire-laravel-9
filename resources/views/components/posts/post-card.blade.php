@props(['item'])

<div>
    <a href="#">
        <div>
            <img class="w-full rounded-xl" src="{{ $item->image }}">
        </div>
    </a>
    <div class="mt-3">
        <div class="flex items-center mb-2">
            <a href="#"
                class="bg-red-600
                text-white
                rounded-xl px-3 py-1 text-sm mr-3">
                Laravel
            </a>
            <p class="text-gray-500 text-sm">{{ date('d F Y H:i', strtotime($item->published_at)) }}</p>
        </div>
        <a href="#" class="text-xl font-bold text-gray-900">{{ $item->title ?? '-' }}</a>
    </div>

</div>
