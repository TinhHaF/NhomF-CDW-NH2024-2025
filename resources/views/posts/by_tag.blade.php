@include('home.nav')
@include('components.notifications')

<div class="container mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-extrabold text-gray-900 mb-6 border-b-2 pb-2">
        Bài viết liên quan đến tag:
        <span class="text-blue-600">{{ $tag->name }}</span>
    </h1>

    @if ($posts->count())
        <!-- Grid bài viết -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($posts as $post)
                <div class="group bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <a href="{{ route('posts.post_detail', ['id' => $post->id, 'slug' => $post->slug]) }}">
                        <!-- Ảnh bài viết -->
                        <div class="relative w-full h-48 rounded-lg overflow-hidden">
                            <img src="{{ isset($post->image) && file_exists(public_path('storage/' . $post->image)) ? asset('storage/' . $post->image) : asset('images/no-image-available.jpg') }}"
                                alt="{{ $post->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>

                        <!-- Nội dung bài viết -->
                        <h2
                            class="text-lg font-semibold text-gray-800 mt-4 group-hover:text-blue-600 transition duration-300">
                            {{ Str::limit($post->title, 50) }}
                        </h2>
                        <p class="text-sm text-gray-500 mt-2 flex items-center">
                            <i class="far fa-calendar-alt mr-2"></i>
                            {{ $post->created_at->format('d/m/Y') }}
                        </p>
                    </a>
                </div>
            @endforeach
        </div>

        <!-- Phân trang -->
        <div class="mt-10">
            {{ $posts->links('pagination::tailwind') }}
        </div>
    @else
        <!-- Không có bài viết -->
        <div class="bg-yellow-100 text-yellow-800 p-4 rounded-md text-center">
            <p class="text-lg font-semibold">Không có bài viết nào liên quan đến tag này.</p>
        </div>
    @endif
</div>

{{-- @include('home.sidebar') --}}
@include('home.footer')
