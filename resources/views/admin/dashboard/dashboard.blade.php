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
                        <div class="bg-orange-400 text-white p-4 rounded shadow">
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
                        <div id="accessChart" style="height: 400px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Load Highcharts from local file -->
        <script src="{{ asset('js/highcharts.js') }}"></script>
        <script>
            Highcharts.chart('accessChart', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: 'Lượt truy cập'
                },
                xAxis: {
                    categories: {!! json_encode($dates) !!}
                },
                yAxis: {
                    title: {
                        text: 'Số lượt truy cập'
                    },
                    min: 0
                },
                series: [{
                    name: 'Lượt truy cập',
                    data: {!! json_encode($visitCounts) !!}
                }]
            });
        </script>
    </body>
@endsection
