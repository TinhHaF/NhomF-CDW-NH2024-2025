<div class="border border-gray-300 rounded-lg p-6 bg-white shadow-lg" style="max-width: 480px;">
    <h2 class="font-bold text-2xl mb-5 text-gray-800">Bài Viết Liên Quan</h2>
    <div class="space-y-4">
        @if ($relatedPosts->isEmpty())
        <p class="text-gray-600 text-sm">Không có bài viết liên quan.</p>
        @else
        @foreach ($relatedPosts as $relatedPost)
        <div class="flex items-center bg-gray-50 rounded-lg p-4 hover:shadow-md transition-all duration-300">
            <img src="{{ asset('storage/' . $relatedPost->image) }}" alt="{{ $relatedPost->title }}" class="w-16 h-16 rounded-md object-cover mr-4">
            <div>
                <a href="{{ route('posts.post_detail', [$relatedPost->id, $relatedPost->slug]) }}" class="text-lg font-semibold text-gray-800 hover:text-blue-600 transition-all">
                    {{ $relatedPost->title }}
                </a>
                <p class="text-sm text-gray-500">{{ $relatedPost->created_at->format('d/m/Y') }}</p>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>