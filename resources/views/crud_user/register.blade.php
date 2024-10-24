<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Registration Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white w-3/4 max-w-4xl mx-auto p-8 rounded-lg shadow-lg flex">
        <div class="w-1/2">
            <div class="flex justify-between items-center mb-8">
                <button class="text-gray-500 flex-1 text-center" onclick="window.location.href='{{ route('user.login') }}'">Đăng Nhập</button>
                <button class="text-red-500 border-b-2 border-red-500 flex-1 text-center">Đăng Ký</button>
                <button class="text-black text-xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="post" action="{{ route('user.addUser') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <input class="w-full p-3 bg-gray-200 rounded" placeholder="Tên tài khoản" type="text" id="username" name="username" />
                    @if ($errors->has('username'))
                        <span class="text-danger">{{ $errors->first('username') }}</span>
                    @endif
                </div>
                <div class="mb-4">
                    <input class="w-full p-3 bg-gray-200 rounded" placeholder="Email" type="email" id="email" name="email" />
                    @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="mb-4 relative">
                    <input class="w-full p-3 bg-gray-200 rounded" placeholder="Mật Khẩu" type="password" id="password" name="password" />
                    <i class="fas fa-eye absolute right-3 top-3 text-gray-500 cursor-pointer" 
                       id="togglePassword"></i>
                    @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div>
                    <button class="w-full p-3 bg-gray-200 rounded" type="submit">Đăng Ký</button>
                </div>
            </form>
        </div>
        <div class="w-1/2 flex flex-col items-center justify-center border-l border-gray-300">
            <div class="w-32 h-32 bg-gray-200 rounded-lg flex items-center justify-center mb-4">
                <img alt="Logo" height="128"
                    src="https://storage.googleapis.com/a1aa/image/tkMOcGFkfmyvdq3JhGQHzAhhaTpAVYMnMUGYFRdsJEfj28nTA.jpg"
                    width="128" />
            </div>
            <p class="text-center italic">
                Cung Cấp Thông Tin Chuẩn Chính, Uy Tín, Nhanh Chóng Nhất mọi thời đại
            </p>
        </div>
    </div>

    <script>
        // Lấy phần tử input và icon mắt
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');

        // Thêm sự kiện click vào icon mắt
        togglePassword.addEventListener('click', function () {
            // Kiểm tra và thay đổi loại input (password/text)
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Thay đổi icon mắt (mở/đóng)
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>

</html>
