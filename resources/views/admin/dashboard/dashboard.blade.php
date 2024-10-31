@extends('admin.layout')
@section('content')
    <body class="bg-gray-100">
        <div class="flex flex-col md:flex-row">
            <!-- Main Content -->
            <div class="w-full md:w-5/5">
                <!-- Content -->
                <div class="flex-1 p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold">Dashboard</h1>
                    </div>

                    <div class="grid grid-cols-4 gap-4 mb-6 text-center">
                        <div class="bg-orange-400 text-white p-4 rounded shadow ">
                            <div class="flex items-center">
                                <i class="fas fa-user mr-2"></i>
                                <span>Đang online</span>
                            </div>
                            <div class="text-2xl font-bold">{{ $onlineUsers }}</div>
                        </div>
                        <div class="bg-green-500 text-white p-4 rounded shadow">
                            <div class="flex items-center">
                                <i class="fas fa-users mr-2"></i>
                                <span>Truy cập tuần</span>
                            </div>
                            <div class="text-2xl font-bold">{{ $weeklyVisits }}</div>
                        </div>
                        <div class="bg-red-500 text-white p-4 rounded shadow">
                            <div class="flex items-center">
                                <i class="fas fa-users mr-2"></i>
                                <span>Truy cập tháng</span>
                            </div>
                            <div class="text-2xl font-bold">{{ $monthlyVisits }}</div>
                        </div>
                        <div class="bg-blue-500 text-white p-4 rounded shadow">
                            <div class="flex items-center">
                                <i class="fas fa-chart-bar mr-2"></i>
                                <span>Tổng truy cập</span>
                            </div>
                            <div class="text-2xl font-bold">{{ $totalVisits }}</div>
                        </div>
                    </div>


                </div>
                <div class="bg-white p-6 rounded shadow">
                    <h2 class="text-xl font-bold mb-4">Thống kê truy cập tháng 10/2024</h2>
                    <div id="chart-container">
                        <canvas id="accessChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            var ctx = document.getElementById('accessChart').getContext('2d');
            var accessChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($dates) !!},
                    datasets: [{
                        label: 'Lượt truy cập',
                        data: {!! json_encode($visitCounts) !!},
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>

    </body>
@endsection
