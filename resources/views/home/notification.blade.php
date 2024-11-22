<body class="bg-gray-100">

    <!-- Dropdown thông báo -->
    <div class="relative inline-block">
        <!-- Nút chuông -->
        <button class="relative text-gray-500 hover:text-gray-800 focus:outline-none" id="dropdownButton">
            <i class="fas fa-bell text-2xl"></i>
            <!-- Số lượng thông báo chưa đọc cho người dùng hiện tại -->
            @php
                $unreadNotifications = $notifications->where('user_id', Auth::id())->where('read', false);
            @endphp
            @if($unreadNotifications->count() > 0)
                <span
                    class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                    {{ $unreadNotifications->count() }}
                </span>
            @endif
        </button>

        <!-- Dropdown content -->
        <div id="dropdownContent" class="absolute right-0 mt-2 w-72 bg-white shadow-lg rounded-md z-20 hidden">
            @php
                $userNotifications = $notifications->where('user_id', Auth::id());
            @endphp
            @if($userNotifications->count() > 0)
                @foreach($userNotifications as $notification)
                    <a href="{{ route('posts.post_detail', ['id' => $notification->post_id, 'slug' => $notification->post->slug]) }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <div class="flex justify-between items-center">
                            <span class="font-medium">{{ $notification->title }}</span>
                            <small class="{{ $notification->read ? 'text-green-500' : 'text-red-500' }}">
                                {{ $notification->read ? 'Đã đọc' : 'Chưa đọc' }}
                            </small>
                        </div>
                    </a>
                @endforeach
            @else
                <div class="px-4 py-2 text-sm text-gray-500">
                    Không có thông báo mới.
                </div>
            @endif
        </div>
    </div>

    <script>
        // JavaScript để toggle dropdown khi nhấn vào nút chuông
        document.getElementById('dropdownButton').addEventListener('click', function () {
            const dropdownContent = document.getElementById('dropdownContent');
            dropdownContent.classList.toggle('hidden');
        });

        // Đóng dropdown nếu người dùng nhấn bên ngoài
        window.addEventListener('click', function (event) {
            const dropdownContent = document.getElementById('dropdownContent');
            const dropdownButton = document.getElementById('dropdownButton');
            if (!dropdownButton.contains(event.target) && !dropdownContent.contains(event.target)) {
                dropdownContent.classList.add('hidden');
            }
        });
    </script>

</body>
