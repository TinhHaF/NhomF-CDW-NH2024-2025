<div class="lg:w-1/3">
    {{-- Sidebar Ad --}}
    @if ($sidebarAd = App\Models\Ad::where('position', 'sidebar')->where('status', 1)->whereDate('start_date', '<=', now())->whereDate('end_date', '>=', now())->first())
        <a href="{{ $sidebarAd->url }}">
            <img src="{{ asset('uploads/ads/' . $sidebarAd->image) }}" alt="{{ $sidebarAd->title }}">
        </a>
    @endif

    <!-- Tin Nổi Bật Sidebar -->
    <div class="bg-white rounded-xl p-6 mb-8">
        <h3 class="text-xl font-bold mb-6 pb-2 border-b border-gray-200">Tin Nổi Bật</h3>
        @if (isset($featuredPosts) && $featuredPosts->count())
            @foreach ($featuredPosts->take(5) as $postf)
                <div class="mb-6 last:mb-0">
                    <a href="{{ route('posts.post_detail', ['id' => $postf->id, 'slug' => $postf->slug]) }}"
                        class="flex gap-4 hover:opacity-80 transition duration-300">
                        @if ($postf->image)
                            <img src="{{ asset('storage/' . $postf->image) }}" class="w-24 h-24 object-cover rounded-lg"
                                alt="{{ $postf->title }}">
                        @endif
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-2 leading-tight">
                                {{ Str::limit($postf->title, 60) }}
                            </h4>
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="far fa-calendar-alt mr-2"></i>
                                <span>{{ $postf->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Chuyên Mục -->
    <div class="bg-white rounded-xl p-6 mb-8">
        <h3 class="text-xl font-bold mb-6 pb-2 border-b border-gray-200">Chuyên Mục</h3>
        <div class="space-y-3">
            @foreach ($categories as $category)
                <a href="#" class="flex items-center justify-between hover:text-blue-600 transition duration-300">
                    <span> {{ $category->name }}</span>
                    <span class="bg-gray-100 px-2 py-1 rounded text-sm">{{ $category->count() }}</span>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Tags -->
    <div class="bg-white rounded-xl p-6">
        <h3 class="text-xl font-bold mb-6 pb-2 border-b border-gray-200">Tags</h3>
        <div class="flex flex-wrap gap-2">
            <a href="#" class="bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded-full text-sm transition duration-300">
                Technology
            </a>
            <a href="#" class="bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded-full text-sm transition duration-300">
                Business
            </a>
            <a href="#" class="bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded-full text-sm transition duration-300">
                Sports
            </a>
        </div>
    </div>
</div>