<?php
$ads = $ads ?? [];
?>
@if (count($ads) > 0)
    <div class="ad-banners">
        <div id="ad-container">
            <div class="ad-title" id="ad-title"></div>
            @foreach ($ads as $index => $ad)
                <a href="{{ $ad->url }}" class="ad-banner {{ $index == 0 ? 'active' : '' }}"
                    data-index="{{ $index }}" data-title="{{ $ad->title }}">
                    <img src="{{ asset($ad->image) }}" alt="{{ $ad->title }}">
                    <div class="highlight"></div> <!-- Thêm vệt sáng -->
                </a>
            @endforeach
        </div>
    </div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const adContainer = document.getElementById('ad-container');
        const ads = adContainer.querySelectorAll('.ad-banner');
        const adTitle = document.getElementById('ad-title');
        let currentAdIndex = 0;

        function createShootingStar() {
            const shootingStar = document.createElement('div');
            shootingStar.classList.add('shooting-star');

            // Vị trí ngẫu nhiên
            const randomStartX = Math.random() * window.innerWidth;
            const randomEndX = randomStartX + Math.random() * 100 - 50;
            const randomStartY = Math.random() * -50;
            const randomEndY = Math.random() * 300;

            // Thời gian ngẫu nhiên
            const randomDuration = Math.random() * 3 + 2; // 2-5 giây

            // Thêm sao băng vào container
            adContainer.appendChild(shootingStar);

            // Thiết lập hoạt ảnh
            shootingStar.style.left = `${randomStartX}px`;
            shootingStar.style.animation = `shootingStar ${randomDuration}s linear`;
            shootingStar.style.setProperty('--start-y', `${randomStartY}px`);
            shootingStar.style.setProperty('--end-x', `${randomEndX}px`);
            shootingStar.style.setProperty('--end-y', `${randomEndY}px`);

            // Xóa sao băng sau khi hoạt ảnh kết thúc
            setTimeout(() => {
                shootingStar.remove();
            }, randomDuration * 1000);
        }

        function startShootingStars() {
            setInterval(createShootingStar, 1000); // Tạo sao băng mỗi giây
        }

        function showNextAd() {
            // Ẩn quảng cáo hiện tại
            ads[currentAdIndex].classList.remove('active');

            // Chuyển sang quảng cáo tiếp theo
            currentAdIndex = (currentAdIndex + 1) % ads.length;

            // Hiển thị quảng cáo mới
            ads[currentAdIndex].classList.add('active');

            // Cập nhật title
            const title = ads[currentAdIndex].getAttribute('data-title');
            adTitle.textContent = title;
        }

        if (ads.length > 1) {
            setInterval(showNextAd, 5000);
        } else if (ads.length === 1) {
            // Khi chỉ có 1 quảng cáo, giữ hiệu ứng tiêu đề
            const title = ads[currentAdIndex].getAttribute('data-title');
            adTitle.textContent = title;
        }

        // Hiển thị tiêu đề quảng cáo ban đầu
        if (ads.length > 0) {
            const title = ads[currentAdIndex].getAttribute('data-title');
            adTitle.textContent = title;
        }

        // Bắt đầu hiệu ứng sao băng
        startShootingStars();
    });
</script>

<style>
    /* Container chính */
    #ad-container {
        position: relative;
        overflow: hidden;
        width: 100%;
        height: 300px;
        margin: 0 auto;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* Quảng cáo */
    .ad-banner {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: none;
        opacity: 0;
        transition: opacity 1s ease-in-out, transform 1s ease-in-out;
    }

    .ad-banner.active {
        display: block;
        opacity: 1;
        transform: scale(1);
        z-index: 1;
    }

    /* Hình ảnh quảng cáo */
    .ad-banner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        animation: sparkle 5s infinite linear;
    }

    /* Title hiển thị */
    .ad-title {
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
        color: #fff;
        font-size: 20px;
        font-weight: bold;
        text-shadow: 0 0 10px rgba(0, 0, 0, 0.8);
        z-index: 10;
        animation: fadeInOut 5s infinite;
    }

    /* Vệt sáng */
    .highlight {
        position: absolute;
        top: 0;
        left: -50%;
        /* Bắt đầu ngoài khung */
        width: 50%;
        height: 100%;
        background: linear-gradient(to right, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.6) 50%, rgba(255, 255, 255, 0) 100%);
        transform: skewX(-30deg);
        /* Tạo hiệu ứng chéo */
        animation: highlightMove 3s infinite;
        pointer-events: none;
        z-index: 2;
    }

    /* Hiệu ứng chuyển động vệt sáng */
    @keyframes highlightMove {
        0% {
            left: -50%;
        }

        100% {
            left: 100%;
        }
    }

    /* Sao băng */
    .shooting-star {
        position: absolute;
        width: 5px;
        height: 5px;
        background: rgba(255, 255, 255, 0.8);
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
        border-radius: 50%;
        pointer-events: none;
        z-index: 5;
        animation: shootingStar linear forwards;
    }

    @keyframes shootingStar {
        0% {
            transform: translate(var(--start-x), var(--start-y));
            opacity: 1;
        }

        100% {
            transform: translate(var(--end-x), var(--end-y));
            opacity: 0;
        }
    }

    /* Hiệu ứng fade in/out cho title */
    @keyframes fadeInOut {

        0%,
        100% {
            opacity: 0;
        }

        50% {
            opacity: 1;
        }
    }
</style>
