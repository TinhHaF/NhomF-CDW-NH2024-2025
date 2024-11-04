<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Trang Đăng Ký</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            background: linear-gradient(to right, #6b5b95, #f7b733);
        }

        .fadeIn {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .input-focus:focus {
            outline: none;
            border: 2px solid #6b5b95;
            background-color: #ffffff;
        }
    </style>
</head>

<body class="flex items-center justify-center h-screen">
    <div class="bg-white w-full max-w-3xl mx-auto p-8 rounded-lg shadow-lg fadeIn flex">
        <!-- Phần biểu mẫu -->
        <div class="w-1/2 pr-4">
            <h2 class="text-2xl font-bold text-center mb-6 text-gray-700">Đăng Ký Tài Khoản</h2>
            <div class="flex justify-between mb-8">
                <button class="text-gray-500 flex-1 text-center" onclick="window.location.href='{{ route('login') }}'">Đăng Nhập</button>
                <button class="text-red-500 border-b-2 border-red-500 flex-1 text-center font-semibold transition duration-300 hover:text-red-700 hover:border-red-700">Đăng Ký</button>
                <button class="text-black text-xl transition duration-300 hover:text-red-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="post" action="{{ route('user.addUser') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <input class="w-full p-3 bg-gray-200 rounded shadow-sm input-focus transition duration-200" placeholder="Tên tài khoản" type="text" name="username" required />
                    @if ($errors->has('username'))
                        <span class="text-red-500 text-sm">{{ $errors->first('username') }}</span>
                    @endif
                </div>
                <div class="mb-4">
                    <input class="w-full p-3 bg-gray-200 rounded shadow-sm input-focus transition duration-200" placeholder="Email" type="email" name="email" required />
                    @if ($errors->has('email'))
                        <span class="text-red-500 text-sm">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="mb-4 relative">
                    <input id="password" class="w-full p-3 bg-gray-200 rounded shadow-sm input-focus transition duration-200" placeholder="Mật Khẩu" type="password" name="password" required />
                    <i class="fas fa-eye absolute right-3 top-3 text-gray-500 cursor-pointer" id="togglePassword"></i>
                    @if ($errors->has('password'))
                        <span class="text-red-500 text-sm">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div class="mb-4 relative">
                    <input id="confirmPassword" class="w-full p-3 bg-gray-200 rounded shadow-sm input-focus transition duration-200" placeholder="Xác Nhận Mật Khẩu" type="password" name="password_confirmation" required />
                    <i class="fas fa-eye absolute right-3 top-3 text-gray-500 cursor-pointer" id="toggleConfirmPassword"></i>
                    @if ($errors->has('password_confirmation'))
                        <span class="text-red-500 text-sm">{{ $errors->first('password_confirmation') }}</span>
                    @endif
                </div>

                <div>
                    <button class="w-full p-3 bg-red-500 text-white rounded hover:bg-red-600 transition duration-300 font-semibold" type="submit">Đăng Ký</button>
                </div>
            </form>
        </div>

        <!-- Phần logo và thông điệp -->
        <div class="w-1/2 pl-4 flex flex-col items-center justify-center">
            <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center mb-4 shadow-md">
                <img alt="Logo" height="128" src="https://storage.googleapis.com/a1aa/image/tkMOcGFkfmyvdq3JhGQHzAhhaTpAVYMnMUGYFRdsJEfj28nTA.jpg" width="128" />
            </div>
            <p class="text-center italic text-gray-600">
                Cung Cấp Thông Tin Chuẩn Chính, Uy Tín, Nhanh Chóng Nhất mọi thời đại
            </p>
        </div>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirmPassword');
        const togglePassword = document.getElementById('togglePassword');
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        toggleConfirmPassword.addEventListener('click', function () {
            const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>

</html>
