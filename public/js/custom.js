function previewFile() {
    const preview = document.getElementById("previewImage");
    const file = document.getElementById("image").files[0];
    const reader = new FileReader();

    reader.onloadend = function () {
        preview.src = reader.result;
        preview.style.display = "block"; // Hiện thị hình ảnh
    };

    if (file) {
        reader.readAsDataURL(file); // Đọc hình ảnh
    } else {
        preview.src = ""; // Nếu không có hình ảnh, ẩn hình
        preview.style.display = "none"; // Ẩn hình ảnh
    }
}

// Kéo và thả hình ảnh
const dropArea = document.querySelector(".bg-gray-100");
dropArea.addEventListener("dragover", (event) => {
    event.preventDefault();
    dropArea.classList.add("bg-gray-300"); // Thay đổi màu nền khi kéo vào
});

dropArea.addEventListener("dragleave", () => {
    dropArea.classList.remove("bg-gray-300"); // Khôi phục màu nền khi không kéo vào
});

dropArea.addEventListener("drop", (event) => {
    event.preventDefault();
    dropArea.classList.remove("bg-gray-300"); // Khôi phục màu nền

    const files = event.dataTransfer.files;
    if (files.length > 0) {
        document.getElementById("image").files = files; // Gán các tệp vào input
        previewFile(); // Hiển thị hình ảnh
    }
});

// Xóa tất cả bài viết được chọn
function confirmBulkDelete() {
    const selectedPosts = document.querySelectorAll(
        'input[name="post_ids[]"]:checked'
    );
    if (selectedPosts.length > 0) {
        if (confirm("Bạn có chắc chắn muốn xóa các bài viết đã chọn?")) {
            document.getElementById("bulkDeleteForm").submit();
        }
    } else {
        alert("Vui lòng chọn ít nhất một bài viết để xóa.");
    }
}
console.log("custom.js đã được kết nối thành công!");

// Hiển thị hình ảnh xem trước
function previewFile() {
    const preview = document.getElementById("previewImage");
    const file = document.getElementById("image").files[0];
    const reader = new FileReader();

    reader.onloadend = function () {
        preview.src = reader.result; // Cập nhật src của img với kết quả từ FileReader
    };

    if (file) {
        reader.readAsDataURL(file); // Đọc dữ liệu hình ảnh
    } else {
        preview.src = "{{ asset('images/no-image-available.jpg') }}"; // Hiển thị hình ảnh "No image available"
    }
}
// dropdown sidebar
$(document).ready(function () {
    // Khi nhấn vào mục có data-toggle là 'dropdown'
    $('[data-toggle="dropdown"]').click(function () {
        // Tìm danh sách ul bên trong mục cha và toggle ẩn/hiện
        $(this).next("ul").toggleClass("hidden");

        // Thay đổi biểu tượng mũi tên (chevron)
        $(this).find(".fa-chevron-up").toggleClass("rotate-180");
    });
});

// Thống kê
// document.addEventListener("DOMContentLoaded", function () {
//     // const chartData = @json($chartData);

//     const options = {
//         chart: {
//             type: "line",
//             height: 350,
//         },
//         series: [
//             {
//                 name: "Lượt truy cập",
//                 data: chartData.map((item) => item.visits),
//             },
//         ],
//         xaxis: {
//             categories: chartData.map((item) => item.date),
//         },
//     };

//     const chart = new ApexCharts(
//         document.querySelector("#chart-container"),
//         options
//     );
//     chart.render();
// });

const ctx = document.getElementById("accessChart").getContext("2d");
const accessChart = new Chart(ctx, {
    type: "line", // Bạn có thể thay đổi loại biểu đồ (bar, line, pie, ...)
    data: {
        labels: ["Tuần 1", "Tuần 2", "Tuần 3", "Tuần 4"], // Nhãn cho các tuần
        datasets: [
            {
                label: "Truy cập",
                data: [150, 200, 250, 300], // Dữ liệu truy cập cho từng tuần
                backgroundColor: "rgba(75, 192, 192, 0.2)",
                borderColor: "rgba(75, 192, 192, 1)",
                borderWidth: 1,
            },
        ],
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
            },
        },
    },
});


async function fetchStats() {
    const onlineUsersResponse = await fetch('/api/online-users');
    const onlineUsers = await onlineUsersResponse.json();

    const weeklyVisitsResponse = await fetch('/api/weekly-visits');
    const weeklyVisits = await weeklyVisitsResponse.json();

    const monthlyVisitsResponse = await fetch('/api/monthly-visits');
    const monthlyVisits = await monthlyVisitsResponse.json();

    const totalVisitsResponse = await fetch('/api/total-visits');
    const totalVisits = await totalVisitsResponse.json();

    document.querySelector('#online-users').innerText = onlineUsers.count;
    document.querySelector('#weekly-visits').innerText = weeklyVisits.count;
    document.querySelector('#monthly-visits').innerText = monthlyVisits.count;
    document.querySelector('#total-visits').innerText = totalVisits.count;
}

fetchStats();