<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-4">{{ $page->title }}</h1>

    @if($page->foto)
        <img src="{{ asset('storage/' . $page->foto) }}" alt="{{ $page->title }}" class="mb-4 rounded-lg w-full max-w-xl">
    @endif

    <p class="text-gray-600 mb-4">{{ $page->description }}</p>

    <div class="prose max-w-none">
        {!! $page->content !!}
    </div>
</div>
