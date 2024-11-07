@extends('admin.layout')
@section('content')
    <div class="min-h-screen bg-gray-100">
        <div class="p-6">
            {{-- Thống kê tổng quan --}}
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Thống kê truy cập</h1>
                <p class="text-sm text-gray-600">Cập nhật lần cuối: {{ now()->format('H:i d/m/Y') }}</p>
            </div>

            {{-- Card Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                {{-- Online Users --}}
                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-orange-400">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Đang trực tuyến</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($statistics['onlineUsers']) }}</p>
                        </div>
                        <div class="p-3 bg-orange-100 rounded-full">
                            <svg class="w-6 h-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm text-gray-600">15 phút qua</p>
                    </div>
                </div>

                {{-- Weekly Visits --}}
                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Truy cập tuần</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($statistics['weeklyVisits']) }}</p>
                        </div>
                        <div class="p-3 bg-green-100 rounded-full">
                            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm text-gray-600">7 ngày qua</p>
                    </div>
                </div>

                {{-- Monthly Visits --}}
                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-red-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Truy cập tháng</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($statistics['monthlyVisits']) }}
                            </p>
                        </div>
                        <div class="p-3 bg-red-100 rounded-full">
                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm text-gray-600">30 ngày qua</p>
                    </div>
                </div>

                {{-- Total Visits --}}
                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Tổng truy cập</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($statistics['totalVisits']) }}</p>
                        </div>
                        <div class="p-3 bg-blue-100 rounded-full">
                            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm text-gray-600">Từ khi bắt đầu</p>
                    </div>
                </div>
            </div>

            {{-- Chart Section --}}
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">Biểu đồ truy cập</h2>
                    <select id="chartPeriod"
                        class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        <option value="30">30 ngày</option>
                        <option value="7">7 ngày</option>
                        <option value="24">24 giờ</option>
                    </select>
                </div>
                {{-- Lịch sử truy cập --}}
                <div id="visitChart" style="height: 300px; width: 100%;"></div>
            </div>

            {{-- Browser & Device Stats --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Thống kê trình duyệt</h3>
                    <div id="browserChart" style="height: 300px;"></div>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Thống kê thiết bị</h3>
                    <div id="deviceChart" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Cấu hình chung cho Highcharts
                Highcharts.setOptions({
                    lang: {
                        thousandsSep: '.',
                        numericSymbols: ['K', 'M', 'B', 'T']
                    },
                    colors: ['#3B82F6', '#10B981', '#EF4444', '#F59E0B', '#6366F1']
                });

                // Biểu đồ truy cập
                Highcharts.chart('visitChart', {
                    chart: {
                        type: 'line'
                    },
                    title: {
                        text: 'Lượt truy cập trong 30 ngày'
                    },
                    xAxis: {
                        categories: @json($statistics['dates']) // Truy cập vào 'dates' trong mảng statistics
                    },
                    yAxis: {
                        title: {
                            text: 'Lượt truy cập'
                        }
                    },
                    series: [{
                        name: 'Lượt truy cập',
                        data: @json($statistics['visitCounts']) // Truy cập vào 'visitCounts' trong mảng statistics
                    }],
                    credits: {
                        enabled: false
                    }
                });

                // Xử lý thay đổi khoảng thời gian
                document.getElementById('chartPeriod').addEventListener('change', function(e) {
                    const period = e.target.value;
                    fetch(`/admin/analytics/chart-data?period=${period}`)
                        .then(response => {
                            if (!response.ok) throw new Error('Network response was not ok');
                            return response.json();
                        })
                        .then(data => {
                            visitChart.update({
                                xAxis: {
                                    categories: data.dates
                                },
                                series: [{
                                    data: data.visitCounts
                                }]
                            }, true);
                        })
                        .catch(error => console.error('Fetch error:', error));
                });

                // Biểu đồ trình duyệt
                Highcharts.chart('browserChart', {
                    chart: {
                        type: 'pie'
                    },
                    title: {
                        text: null
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '<b>{point.name}</b>: {point.percentage:.1f}%'
                            }
                        }
                    },
                    series: [{
                        name: 'Trình duyệt',
                        data: @json($statistics['browserStats'])
                    }],
                    credits: {
                        enabled: false
                    }
                });

                // Biểu đồ thiết bị
                Highcharts.chart('deviceChart', {
                    chart: {
                        type: 'pie'
                    },
                    title: {
                        text: null
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '<b>{point.name}</b>: {point.percentage:.1f}%'
                            }
                        }
                    },
                    series: [{
                        name: 'Thiết bị',
                        data: @json($statistics['deviceStats'])
                    }],
                    credits: {
                        enabled: false
                    }
                });

            });
        </script>
    @endpush
@endsection
