<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Thêm FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Căn chỉnh cho dropdown */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        /* Nút chuông */
        .dropbtn {
            background-color: transparent;
            border: none;
            font-size: 20px;
            cursor: pointer;
            position: relative;
        }

        /* Số lượng thông báo chưa đọc */
        .notification-count {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 0.2em 0.5em;
            font-size: 0.7em;
            font-weight: bold;
        }

        /* Dropdown content */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 200px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            max-height: 300px;
            /* Giới hạn chiều cao tối đa của dropdown */
            overflow-y: auto;
            /* Hiển thị thanh cuộn khi quá nhiều thông báo */
            border-radius: 8px;
            margin-top: 5px;
            transition: max-height 0.3s ease-out, padding 0.3s ease-out;
            /* Hiệu ứng kéo xuống */
            padding: 0;
        }

        /* Các link trong dropdown */
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            font-size: 14px;
            transition: background-color 0.3s;
            border-bottom: 1px solid #ddd;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        /* Giới hạn chiều cao cho dropdown */
        .dropdown-content a:last-child {
            border-bottom: none;
        }

        /* Mở dropdown khi nhấn */
        .dropdown.open .dropdown-content {
            display: block;
            max-height: 300px;
            /* Khi mở, chiều cao tối đa */
            padding: 12px 0;
            /* Thêm padding khi mở */
        }
    </style>
</head>

<body>

    <!-- Dropdown thông báo -->
    <div class="dropdown">
        <button class="dropbtn">
            <i class="fas fa-bell"></i>
            <!-- Hiển thị số lượng thông báo chưa đọc -->
            @if($notifications->where('read', false)->count() > 0)
                <span class="notification-count">
                    {{ $notifications->where('read', false)->count() }}
                </span>
            @endif
        </button>
        <div class="dropdown-content">
            @if($notifications->count() > 0)
                @foreach($notifications as $notification)
                    <a
                        href="{{ route('posts.post_detail', ['id' => $notification->post_id, 'slug' => $notification->post->slug]) }}">
                        {{ $notification->title }} -
                        <small>{{ $notification->read ? 'Đã đọc' : 'Chưa đọc' }}</small>
                    </a>
                @endforeach
            @else
                <a href="#">Không có thông báo mới.</a>
            @endif
        </div>
    </div>

    <script>
        // JavaScript để toggle dropdown khi nhấn vào nút chuông
        document.querySelector('.dropbtn').addEventListener('click', function (event) {
            let dropdown = document.querySelector('.dropdown');
            let dropdownContent = document.querySelector('.dropdown-content');
            // Toggle class 'open' để kích hoạt hiệu ứng kéo xuống
            dropdown.classList.toggle('open');
        });

        // Đóng dropdown nếu người dùng nhấn bên ngoài
        window.addEventListener('click', function (event) {
            let dropdown = document.querySelector('.dropdown');
            let dropdownContent = document.querySelector('.dropdown-content');
            if (!dropdown.contains(event.target)) {
                dropdown.classList.remove('open'); // Đóng dropdown nếu nhấn ngoài
            }
        });
    </script>
</body>

</html>