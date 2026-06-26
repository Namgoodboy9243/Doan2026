@extends('admin.layout.master')

@section('content')
          <!-- Tiêu đề chào mừng Admin -->
          <div class="row mb-4">
            <div class="col-sm-8">
              <h3 class="mb-1 font-weight-bold text-dark" style="font-family: 'Segoe UI', sans-serif;">Xin chào, {{ auth()->user()->name }}!</h3>
              <p class="text-muted mb-0">Hệ thống đang hoạt động ổn định. Số liệu thống kê được đồng bộ thời gian thực.</p>
            </div>
            <div class="col-sm-4 text-sm-right mt-2 mt-sm-0">
              <div class="badge badge-outline-secondary px-3 py-2 font-weight-semibold" style="border-radius: 20px; font-size: 11px;">
                <i class="typcn typcn-calendar-outline mr-1"></i> Hôm nay: {{ date('d/m/Y') }}
              </div>
            </div>
          </div>

          <!-- Hệ thống 3 thẻ thống kê (Real-time Metrics Cards) -->
          <div class="row mb-3">
            <!-- Thẻ 1: Tổng tồn kho -->
            <div class="col-xl-4 col-md-6 grid-margin stretch-card">
              <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #051923 0%, #17374a 100%); border-radius: 12px; min-height: 120px;">
                <div class="card-body text-white">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <p class="text-white-50 mb-1 font-weight-bold" style="font-size: 10px; letter-spacing: 1px; text-transform: uppercase;">Laptop trong kho</p>
                      <h2 class="mb-0 font-weight-bold text-white" id="stat-total-stock" style="font-size: 28px;">{{ number_format($stats['total_stock'], 0, ',', '.') }}</h2>
                      <small class="text-white-50" style="font-size: 11px;">Tổng số máy của tất cả biến thể</small>
                    </div>
                    <div class="p-3 rounded" style="background: rgba(255,255,255,0.12); border-radius: 10px;">
                      <i class="typcn typcn-archive text-white" style="font-size: 32px; line-height: 1;"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Thẻ 2: Sản phẩm đã bán trong tháng -->
            <div class="col-xl-4 col-md-6 grid-margin stretch-card">
              <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #d35400 0%, #f39c12 100%); border-radius: 12px; min-height: 120px;">
                <div class="card-body text-white">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <p class="text-white-50 mb-1 font-weight-bold" style="font-size: 10px; letter-spacing: 1px; text-transform: uppercase;">Đã bán tháng này</p>
                      <h2 class="mb-0 font-weight-bold text-white" id="stat-sold-this-month" style="font-size: 28px;">{{ number_format($stats['sold_this_month'], 0, ',', '.') }}</h2>
                      <small class="text-white-50" style="font-size: 11px;">Đơn hàng Đang chuẩn bị / Đang giao / Đã giao</small>
                    </div>
                    <div class="p-3 rounded" style="background: rgba(255,255,255,0.12); border-radius: 10px;">
                      <i class="typcn typcn-shopping-cart text-white" style="font-size: 32px; line-height: 1;"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Thẻ 3: Doanh thu của tháng -->
            <div class="col-xl-4 col-md-12 grid-margin stretch-card">
              <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #1b5e20 0%, #4caf50 100%); border-radius: 12px; min-height: 120px;">
                <div class="card-body text-white">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <p class="text-white-50 mb-1 font-weight-bold" style="font-size: 10px; letter-spacing: 1px; text-transform: uppercase;">Doanh thu tháng này</p>
                      <h2 class="mb-0 font-weight-bold text-white" id="stat-revenue-this-month" style="font-size: 26px;">{{ $stats['revenue_this_month_formatted'] }}</h2>
                      <small class="text-white-50" style="font-size: 11px;">Đồng bộ với các cổng thanh toán</small>
                    </div>
                    <div class="p-3 rounded" style="background: rgba(255,255,255,0.12); border-radius: 10px;">
                      <i class="typcn typcn-calculator text-white" style="font-size: 32px; line-height: 1;"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Biểu đồ phân tích Live so sánh 6 tháng gần nhất -->
          <div class="row mb-4">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card shadow-sm border-0" style="border-radius: 12px;">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                    <div>
                      <h4 class="card-title mb-1 font-weight-bold text-dark" style="font-size: 16px;">Phân Tích Hoạt Động Kinh Doanh</h4>
                      <p class="text-muted mb-0" style="font-size: 12px;" id="chart-sub-title">Đang hiển thị so sánh 6 tháng gần nhất (Cập nhật Live ⚡)</p>
                    </div>
                    <div class="d-flex align-items-center mt-2 mt-md-0" style="gap: 10px;">
                      <!-- Nhóm nút chuyển đổi chế độ xem -->
                      <div class="btn-group" role="group" style="box-shadow: 0 2px 5px rgba(0,0,0,0.05); border-radius: 8px; overflow: hidden; border: 1px solid #cbd5e1;">
                        <button type="button" class="btn btn-sm btn-light font-weight-bold px-3 py-2" id="btn-view-month" onclick="switchChartView('current_month')" style="font-size: 11px; border: 0; outline: none;">Tháng này (Theo ngày)</button>
                        <button type="button" class="btn btn-sm btn-dark font-weight-bold px-3 py-2" id="btn-view-six-months" onclick="switchChartView('six_months')" style="font-size: 11px; border: 0; outline: none;">6 tháng gần nhất</button>
                      </div>
                      <div class="badge badge-success px-3 py-2 font-weight-bold" style="font-size: 11px; border-radius: 20px; background-color: #dcfce7; color: #15803d; border: 1px solid #bbf7d0;">
                        <i class="fas fa-sync mr-1"></i> Tự động đồng bộ
                      </div>
                    </div>
                  </div>
                  <div class="chart-container" style="position: relative; height: 350px; width: 100%;">
                    <canvas id="adminLiveDashboardChart"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Bảng đơn hàng gần đây -->
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card shadow-sm border-0" style="border-radius: 12px;">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0 font-weight-bold text-dark" style="font-size: 16px;">Giao Dịch Gần Đây</h4>
                    <a href="{{ route('admin.orders.table') }}" class="btn btn-sm btn-primary font-weight-bold" style="border-radius: 6px;">Xem tất cả đơn hàng</a>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-hover align-middle">
                      <thead class="table-light">
                        <tr class="text-secondary" style="font-size: 12px; font-weight: bold;">
                          <th>MÃ ĐƠN</th>
                          <th>KHÁCH HÀNG</th>
                          <th>SỐ ĐIỆN THOẠI</th>
                          <th class="text-center">SỐ LƯỢNG</th>
                          <th>TỔNG TIỀN</th>
                          <th>TRẠNG THÁI</th>
                          <th>NGÀY ĐẶT HÀNG</th>
                          <th>HÀNH ĐỘNG</th>
                        </tr>
                      </thead>
                      <tbody id="recent-orders-tbody">
                        @forelse($stats['recent_orders'] as $order)
                        <tr>
                          <td class="font-weight-bold text-primary">#{{ $order->id }}</td>
                          <td>
                            <div class="d-flex align-items-center">
                              <div class="bg-light p-2 rounded-circle mr-2 text-secondary" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                <i class="typcn typcn-user text-sm"></i>
                              </div>
                              <div>
                                <div class="font-weight-bold text-dark" style="font-size: 13px;">{{ $order->name }}</div>
                                <small class="text-muted" style="font-size: 11px;">{{ $order->email ?: 'Không có email' }}</small>
                              </div>
                            </div>
                          </td>
                          <td class="font-weight-medium text-secondary" style="font-size: 13px;">{{ $order->phone ?: 'N/A' }}</td>
                          <td class="text-center font-weight-bold text-dark" style="font-size: 13px;">{{ $order->items_count }} SP</td>
                          <td class="font-weight-bold" style="color: #1e3a8a; font-size: 13px;">{{ number_format($order->total_amount, 0, ',', '.') }} ₫</td>
                          <td>
                            @if($order->status == 1)
                              <span class="badge font-weight-bold" style="background-color: #fef3c7; color: #d97706; border: 1px solid #fde68a;">⏳ Chờ xác nhận</span>
                            @elseif($order->status == 5)
                              <span class="badge font-weight-bold" style="background-color: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd;">💳 Chờ thanh toán QR</span>
                            @elseif($order->status == 2)
                              <span class="badge font-weight-bold" style="background-color: #dcfce7; color: #15803d; border: 1px solid #bbf7d0;">📦 Đang chuẩn bị</span>
                            @elseif($order->status == 3)
                              <span class="badge font-weight-bold" style="background-color: #e0e7ff; color: #4338ca; border: 1px solid #c7d2fe;">🚚 Đang giao</span>
                            @elseif($order->status == 4)
                              <span class="badge font-weight-bold" style="background-color: #dcfce7; color: #16a34a; border: 1px solid #bbf7d0;">✅ Đã giao</span>
                            @elseif($order->status == 0)
                              <span class="badge font-weight-bold" style="background-color: #fee2e2; color: #b91c1c; border: 1px solid #fecaca;">❌ Đã hủy</span>
                            @endif
                          </td>
                          <td class="text-muted" style="font-size: 12px;">{{ date('H:i d/m/Y', strtotime($order->created_at)) }}</td>
                          <td>
                            <a href="{{ route('admin.orders.table') }}?search={{ $order->id }}" class="btn btn-sm btn-light font-weight-bold text-primary border" style="border-radius: 6px;">
                              <i class="typcn typcn-eye mr-1"></i> Chi tiết
                            </a>
                          </td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="8" class="text-center text-muted font-weight-bold py-4">Chưa có đơn hàng nào</td>
                        </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        console.log("Dashboard Chart script: DOMContentLoaded fired.");
        var chartCanvas = document.getElementById("adminLiveDashboardChart");
        var chartContainer = chartCanvas ? chartCanvas.parentNode : null;
        if (!chartContainer) {
            console.error("Dashboard Chart Error: Canvas element 'adminLiveDashboardChart' not found!");
            return;
        }

        try {
            var ctx = chartCanvas.getContext("2d");
            if (typeof Chart === 'undefined') {
                throw new Error("Thư viện Chart.js chưa được tải thành công. Vui lòng kiểm tra lại asset/vendors/chart.js/Chart.min.js.");
            }

            // Dữ liệu bộ đệm trong bộ nhớ (được truyền từ PHP sang ban đầu)
            var chartDataSixMonths = {
                labels: {!! json_encode($stats['chart_six_months']['labels']) !!},
                revenue: {!! json_encode($stats['chart_six_months']['revenue']) !!},
                sold: {!! json_encode($stats['chart_six_months']['sold']) !!}
            };

            var chartDataCurrentMonth = {
                labels: {!! json_encode($stats['chart_current_month']['labels']) !!},
                revenue: {!! json_encode($stats['chart_current_month']['revenue']) !!},
                sold: {!! json_encode($stats['chart_current_month']['sold']) !!}
            };

            var currentViewMode = 'six_months'; // Chế độ hiển thị mặc định

            // Khởi tạo biểu đồ kết hợp (Bar + Line Chart) bằng Chart.js v2
            window.myLiveChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartDataSixMonths.labels,
                    datasets: [
                        {
                            label: 'Doanh thu (Triệu ₫)',
                            type: 'line',
                            data: chartDataSixMonths.revenue,
                            fill: false,
                            borderColor: '#10b981',
                            backgroundColor: '#10b981',
                            borderWidth: 3.5,
                            pointBackgroundColor: '#10b981',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 1.5,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            yAxisID: 'y-axis-2',
                            tension: 0.25
                        },
                        {
                            label: 'Số lượng bán (Cái)',
                            type: 'bar',
                            data: chartDataSixMonths.sold,
                            backgroundColor: 'rgba(5, 25, 35, 0.75)',
                            borderColor: '#051923',
                            borderWidth: 1,
                            yAxisID: 'y-axis-1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        yAxes: [
                            {
                                id: 'y-axis-1',
                                type: 'linear',
                                position: 'left',
                                ticks: {
                                    beginAtZero: true,
                                    fontColor: '#4b5563',
                                    fontSize: 11
                                },
                                gridLines: {
                                    drawBorder: false,
                                    color: 'rgba(0,0,0,0.06)'
                                },
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Số lượng sản phẩm (Cái)',
                                    fontColor: '#4b5563',
                                    fontWeight: 'bold'
                                }
                            },
                            {
                                id: 'y-axis-2',
                                type: 'linear',
                                position: 'right',
                                ticks: {
                                    beginAtZero: true,
                                    fontColor: '#10b981',
                                    fontSize: 11
                                },
                                gridLines: {
                                    drawOnChartArea: false,
                                    drawBorder: false
                                },
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Doanh thu (Triệu VNĐ)',
                                    fontColor: '#10b981',
                                    fontWeight: 'bold'
                                }
                            }
                        ],
                        xAxes: [
                            {
                                gridLines: {
                                    display: false
                                },
                                ticks: {
                                    fontColor: '#4b5563',
                                    fontSize: 11
                                }
                            }
                        ]
                    },
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            boxWidth: 12,
                            fontFamily: '"Segoe UI", Tahoma, Geneva, Verdana, sans-serif',
                            fontSize: 12,
                            fontColor: '#374151',
                            padding: 15
                        }
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(17, 24, 39, 0.95)',
                        titleFontFamily: '"Segoe UI", sans-serif',
                        titleFontSize: 13,
                        titleFontColor: '#ffffff',
                        bodyFontFamily: '"Segoe UI", sans-serif',
                        bodyFontSize: 12,
                        bodyFontColor: '#ffffff',
                        borderColor: 'rgba(255, 255, 255, 0.1)',
                        borderWidth: 1,
                        cornerRadius: 8,
                        padding: 12
                    }
                }
            });

            // Hàm chuyển đổi chế độ xem biểu đồ
            window.switchChartView = function(mode) {
                currentViewMode = mode;
                
                const btnMonth = document.getElementById('btn-view-month');
                const btnSixMonths = document.getElementById('btn-view-six-months');
                const subTitle = document.getElementById('chart-sub-title');
                
                if (mode === 'current_month') {
                    btnMonth.className = 'btn btn-sm btn-dark font-weight-bold px-3 py-2';
                    btnSixMonths.className = 'btn btn-sm btn-light font-weight-bold px-3 py-2';
                    subTitle.innerText = 'Đang hiển thị doanh số hàng ngày trong tháng hiện tại (Cập nhật Live ⚡)';
                    
                    window.myLiveChart.data.labels = chartDataCurrentMonth.labels;
                    window.myLiveChart.data.datasets[0].data = chartDataCurrentMonth.revenue;
                    window.myLiveChart.data.datasets[1].data = chartDataCurrentMonth.sold;
                } else {
                    btnMonth.className = 'btn btn-sm btn-light font-weight-bold px-3 py-2';
                    btnSixMonths.className = 'btn btn-sm btn-dark font-weight-bold px-3 py-2';
                    subTitle.innerText = 'Đang hiển thị so sánh 6 tháng gần nhất (Cập nhật Live ⚡)';
                    
                    window.myLiveChart.data.labels = chartDataSixMonths.labels;
                    window.myLiveChart.data.datasets[0].data = chartDataSixMonths.revenue;
                    window.myLiveChart.data.datasets[1].data = chartDataSixMonths.sold;
                }
                
                window.myLiveChart.update();
            };

            // Đăng ký hàm cập nhật live vào đối tượng window để gọi từ các sự kiện Echo trong master layout
            window.updateLiveDashboard = function() {
                console.log("WebSockets: Nhận sự kiện đơn hàng. Đang gọi API cập nhật biểu đồ và số liệu...");
                
                // Xoay icon đồng bộ để hiển thị trạng thái loading
                const syncIcon = document.querySelector('.badge-success i');
                if (syncIcon) syncIcon.classList.add('fa-spin');

                fetch("{{ route('admin.api.dashboard_stats') }}")
                    .then(response => {
                        if (!response.ok) throw new Error("API Lỗi");
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            var stats = data.stats;
                            
                            // 1. Cập nhật các thẻ số liệu
                            document.getElementById('stat-total-stock').innerText = new Intl.NumberFormat('vi-VN').format(stats.total_stock);
                            document.getElementById('stat-sold-this-month').innerText = new Intl.NumberFormat('vi-VN').format(stats.sold_this_month);
                            document.getElementById('stat-revenue-this-month').innerText = stats.revenue_this_month_formatted;

                            // 2. Cập nhật bộ đệm dữ liệu trong bộ nhớ
                            chartDataSixMonths = stats.chart_six_months;
                            chartDataCurrentMonth = stats.chart_current_month;

                            // 3. Cập nhật biểu đồ theo chế độ xem hiện tại
                            if (currentViewMode === 'current_month') {
                                window.myLiveChart.data.labels = chartDataCurrentMonth.labels;
                                window.myLiveChart.data.datasets[0].data = chartDataCurrentMonth.revenue;
                                window.myLiveChart.data.datasets[1].data = chartDataCurrentMonth.sold;
                            } else {
                                window.myLiveChart.data.labels = chartDataSixMonths.labels;
                                window.myLiveChart.data.datasets[0].data = chartDataSixMonths.revenue;
                                window.myLiveChart.data.datasets[1].data = chartDataSixMonths.sold;
                            }
                            
                            // 4. Render lại biểu đồ với hiệu ứng mượt
                            window.myLiveChart.update();

                            // 5. Cập nhật lại bảng đơn hàng gần đây
                            updateRecentOrdersTable(stats.recent_orders);
                            
                            console.log("Thống kê đã được cập nhật thành công!");
                        }
                    })
                    .catch(err => {
                        console.error("Lỗi khi cập nhật dữ liệu tự động:", err);
                    })
                    .finally(() => {
                        if (syncIcon) {
                            setTimeout(() => {
                                syncIcon.classList.remove('fa-spin');
                            }, 500);
                        }
                    });
            };

            // Hàm cập nhật danh sách đơn hàng gần đây qua DOM
            function updateRecentOrdersTable(orders) {
                const tbody = document.getElementById('recent-orders-tbody');
                if (!tbody) return;

                if (orders.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="8" class="text-center text-muted font-weight-bold py-4">Chưa có đơn hàng nào</td></tr>';
                    return;
                }

                let html = '';
                orders.forEach(order => {
                    let statusBadge = '';
                    if (order.status == 1) {
                        statusBadge = '<span class="badge font-weight-bold" style="background-color: #fef3c7; color: #d97706; border: 1px solid #fde68a;">⏳ Chờ xác nhận</span>';
                    } else if (order.status == 5) {
                        statusBadge = '<span class="badge font-weight-bold" style="background-color: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd;">💳 Chờ thanh toán QR</span>';
                    } else if (order.status == 2) {
                        statusBadge = '<span class="badge font-weight-bold" style="background-color: #dcfce7; color: #15803d; border: 1px solid #bbf7d0;">📦 Đang chuẩn bị</span>';
                    } else if (order.status == 3) {
                        statusBadge = '<span class="badge font-weight-bold" style="background-color: #e0e7ff; color: #4338ca; border: 1px solid #c7d2fe;">🚚 Đang giao</span>';
                    } else if (order.status == 4) {
                        statusBadge = '<span class="badge font-weight-bold" style="background-color: #dcfce7; color: #16a34a; border: 1px solid #bbf7d0;">✅ Đã giao</span>';
                    } else if (order.status == 0) {
                        statusBadge = '<span class="badge font-weight-bold" style="background-color: #fee2e2; color: #b91c1c; border: 1px solid #fecaca;">❌ Đã hủy</span>';
                    }

                    // Format ngày đặt hàng
                    const dateStr = new Date(order.created_at).toLocaleString('vi-VN', {
                        hour: '2-digit',
                        minute: '2-digit',
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric'
                    }).replace(',', '');

                    const totalAmountStr = new Intl.NumberFormat('vi-VN').format(order.total_amount) + ' ₫';

                    html += `
                    <tr>
                      <td class="font-weight-bold text-primary">#${order.id}</td>
                      <td>
                        <div class="d-flex align-items-center">
                          <div class="bg-light p-2 rounded-circle mr-2 text-secondary" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                            <i class="typcn typcn-user text-sm"></i>
                          </div>
                          <div>
                            <div class="font-weight-bold text-dark" style="font-size: 13px;">${order.name}</div>
                            <small class="text-muted" style="font-size: 11px;">${order.email || 'Không có email'}</small>
                          </div>
                        </div>
                      </td>
                      <td class="font-weight-medium text-secondary" style="font-size: 13px;">${order.phone || 'N/A'}</td>
                      <td class="text-center font-weight-bold text-dark" style="font-size: 13px;">${order.items_count} SP</td>
                      <td class="font-weight-bold" style="color: #1e3a8a; font-size: 13px;">${totalAmountStr}</td>
                      <td>${statusBadge}</td>
                      <td class="text-muted" style="font-size: 12px;">${dateStr}</td>
                      <td>
                        <a href="{{ route('admin.orders.table') }}?search=${order.id}" class="btn btn-sm btn-light font-weight-bold text-primary border" style="border-radius: 6px;">
                          <i class="typcn typcn-eye mr-1"></i> Chi tiết
                        </a>
                      </td>
                    </tr>
                    `;
                });
                tbody.innerHTML = html;
            }
        } catch (e) {
            console.error("Dashboard Chart Error:", e);
            var errDiv = document.createElement('div');
            errDiv.className = 'alert alert-danger mt-3';
            errDiv.style.borderRadius = '8px';
            errDiv.innerHTML = `<strong>Lỗi hiển thị biểu đồ:</strong> ${e.message}<br><small>Vui lòng ấn Ctrl + F5 để làm sạch bộ nhớ cache trình duyệt, hoặc kiểm tra kết nối internet.</small>`;
            chartContainer.appendChild(errDiv);
        }
    });
</script>
@endsection
