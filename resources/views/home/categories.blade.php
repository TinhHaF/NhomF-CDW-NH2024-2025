<div class="container mx-auto px-4">
    <nav class="flex space-x-6 py-3">
        @foreach ($categories as $category)
            <p>{{ $category->name }}</p>
            <a href="{{ route('posts.showCate', $category->id) }}"
                class="text-gray-600 hover:text-blue-600 font-medium transition-colors duration-200">
                {{ $category->name }}
            </a>
        @endforeach
    </nav>
</div>
