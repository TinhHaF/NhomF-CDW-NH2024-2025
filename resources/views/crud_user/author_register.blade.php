<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">Đăng ký trở thành Tác giả</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('update_auth') }}">
                @csrf
                <!-- Pen Name -->
                <div class="mb-3">
                    <label for="pen_name" class="form-label">Bút danh</label>
                    <input type="text" class="form-control" id="pen_name" name="pen_name" placeholder="Nhập bút danh của bạn" required>
                </div>
                
                <!-- Biography -->
                <div class="mb-3">
                    <label for="biography" class="form-label">Tiểu sử</label>
                    <textarea class="form-control" id="biography" name="biography" rows="5" placeholder="Giới thiệu về bạn" required></textarea>
                </div>

                <!-- Submit Button -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">Gửi yêu cầu</button>
                </div>
                <a href="{{ route('user.profile') }}">Quay lai</a>
            </form>
        </div>
    </div>
</div>