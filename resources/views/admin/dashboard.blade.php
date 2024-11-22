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

            {{-- Top Viewed Posts Today --}}
            <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-red-500 mt-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Top 10 Bài Viết Xem Nhiều Nhất Hôm Nay</h3>
                <div class="divide-y divide-gray-200">
                    @forelse($topViewedPostsToday as $post)
                        <div class="py-3 flex justify-between items-center">
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('posts.post_detail', ['id' => $post->id, 'slug' => $post->slug]) }}"
                                    class="text-sm font-medium text-gray-900 truncate hover:text-blue-600">
                                    {{ $post->title }}
                                </a>
                                <div class="text-sm text-gray-500">
                                    {{ $post->view }} lượt xem
                                </div>
                            </div>
                            <div class="ml-2 flex-shrink-0">
                                <span class="text-sm text-gray-500">{{ $post->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">Chưa có bài viết được xem trong ngày</p>
                    @endforelse
                </div>
            </div>

            {{-- Most Viewed Post --}}

            <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-purple-500 mt-8">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Bài viết nổi bật</p>
                        <p class="text-lg font-bold text-gray-900">
                            {{ $mostViewedPost->title ?? 'Chưa có dữ liệu' }}
                        </p>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-full">
                        <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m4-4H7a2 2 0 00-2 2v8a2 2 0 002 2h10a2 2 0 002-2v-8a2 2 0 00-2-2z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-sm text-gray-600">Lượt xem: <span
                            class="font-bold">{{ $mostViewedPost->view ?? 0 }}</span></p>
                    <p class="text-sm text-gray-600">Ngày đăng:
                        <span
                            class="font-bold">{{ $mostViewedPost->created_at->format('d/m/Y') ?? 'Không xác định' }}</span>
                    </p>
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
                        type: 'line',
                        height: 300
                    },
                    title: {
                        text: `Thống kê truy cập tháng: ${@json($statistics['currentMonth'])} - ${@json($statistics['currentYear'])}`,
                        align: 'center',
                        style: {
                            fontSize: '16px',
                            fontWeight: 'bold'
                        }
                    },
                    xAxis: {
                        categories: @json($statistics['dates']), // Lấy mảng ngày từ statistics
                        tickInterval: 1,
                        gridLineWidth: 1,
                        gridLineColor: '#F0F0F0',
                        labels: {
                            style: {
                                fontSize: '11px'
                            }
                        }
                    },
                    yAxis: {
                        title: {
                            text: 'Số người truy cập',
                            style: {
                                fontSize: '12px'
                            }
                        },
                        min: 0,
                        max: 60,
                        tickInterval: 10,
                        gridLineColor: '#F0F0F0',
                        labels: {
                            style: {
                                fontSize: '11px'
                            }
                        }
                    },
                    tooltip: {
                        shared: true,
                        useHTML: true,
                        headerFormat: '<span style="font-size: 12px">{point.key}</span><br/>',
                        pointFormat: 'Tổng : <b>{point.y}</b> Lượt truy cập',
                        backgroundColor: '#FFFFFF',
                        borderWidth: 1,
                        borderColor: '#DCDBDB',
                        shadow: true,
                        style: {
                            padding: '10px'
                        }
                    },
                    plotOptions: {
                        line: {
                            color: '#3B82F6',
                            lineWidth: 2,
                            marker: {
                                enabled: true,
                                radius: 4,
                                symbol: 'circle',
                                fillColor: '#3B82F6',
                                lineWidth: 2,
                                lineColor: '#3B82F6'
                            },
                            states: {
                                hover: {
                                    lineWidth: 2
                                }
                            },
                            dataLabels: {
                                enabled: true,
                                formatter: function() {
                                    return this.y === 0 ? '' : this.y.toFixed(1);
                                },
                                style: {
                                    fontSize: '10px'
                                }
                            }
                        }
                    },
                    legend: {
                        enabled: false
                    },
                    series: [{
                        name: 'Lượt truy cập',
                        data: @json($statistics['visitCounts']) // Lấy mảng số liệu từ statistics
                    }],
                    credits: {
                        enabled: false
                    }
                });

                // Xử lý sự kiện thay đổi period
                document.getElementById('chartPeriod').addEventListener('change', function(e) {
                    const period = e.target.value;
                    fetch(`/admin/dashboard/chart-data?period=${period}`)
                        .then(response => response.json())
                        .then(data => {
                            chart.update({
                                xAxis: {
                                    categories: range(1, period)
                                },
                                series: [{
                                    data: data.visits
                                }],
                                title: {
                                    text: `Thống kê truy cập ${period === '24' ? '24 giờ' : period === '7' ? 'tuần' : 'tháng'}: ${@json($statistics['currentMonth'])}-${@json($statistics['currentYear'])}`,
                                    align: 'center',
                                    style: {
                                        fontSize: '16px',
                                        fontWeight: 'bold'
                                    }
                                }
                            });
                        })
                        .catch(error => console.error('Error:', error));
                });
                // Hàm trợ giúp để tạo phạm vi
                function range(start, end) {
                    return Array.from({
                        length: (end - start + 1)
                    }, (_, i) => start + i);
                }

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


            // window.addEventListener('beforeunload', function(event) {
            //     // Gửi yêu cầu AJAX tới server để ghi nhận lượt thoát
            //     navigator.sendBeacon('/api/track-exit', {
            //         session_id: localStorage.getItem('session_id') || '',
            //         ip_address: userIpAddress, // Bạn cần lấy IP từ backend hoặc một API
            //         user_agent: navigator.userAgent,
            //     });
            // });
        </script>
    @endpush
@endsection
