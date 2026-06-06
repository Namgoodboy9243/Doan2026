@extends('admin.layout.master')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h3 class="mb-2 font-weight-bold text-dark">Quản lý trạng thái đơn hàng</h3>
        <p class="text-muted">Quản lý trạng thái vận chuyển, xem chi tiết hóa đơn khách hàng và theo dõi doanh thu thực tế.</p>
    </div>
</div>

<!-- ==================== METRICS DASHBOARD ==================== -->
<div class="row mt-3">
    <!-- Metric 1: Total Orders -->
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-metric border-0" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border-radius: 16px; box-shadow: 0 8px 20px rgba(59, 130, 246, 0.25);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title text-white mb-0" style="font-size: 15px; font-weight: 600; opacity: 0.9;">Tổng Đơn Hàng</h4>
                    <i class="typcn typcn-clipboard" style="font-size: 24px; opacity: 0.8;"></i>
                </div>
                <div class="d-flex align-items-baseline">
                    <h2 class="mb-0 font-weight-bold text-white mr-2" style="font-size: 30px;">{{ $totalOrders }}</h2>
                    <span class="text-white-50" style="font-size: 13px;">đơn hàng</span>
                </div>
                <p class="text-white-50 mt-2 mb-0" style="font-size: 12px; font-weight: 500;">Tất cả giao dịch trên hệ thống</p>
            </div>
        </div>
    </div>

    <!-- Metric 2: Pending Confirm -->
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-metric border-0" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 16px; box-shadow: 0 8px 20px rgba(245, 158, 11, 0.25);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title text-white mb-0" style="font-size: 15px; font-weight: 600; opacity: 0.9;">Chờ Xác Nhận</h4>
                    <i class="typcn typcn-time" style="font-size: 24px; opacity: 0.8;"></i>
                </div>
                <div class="d-flex align-items-baseline justify-content-between flex-wrap gap-2">
                    <div>
                        <h2 class="mb-0 font-weight-bold text-white d-inline" style="font-size: 24px;">{{ $pendingOrders }}</h2>
                        <span class="text-white-50" style="font-size: 11px;">COD</span>
                    </div>
                    <div>
                        <h2 class="mb-0 font-weight-bold text-white d-inline" style="font-size: 24px;">{{ $pendingPaymentOrders }}</h2>
                        <span class="text-white-50" style="font-size: 11px;">Chờ CK</span>
                    </div>
                </div>
                <p class="text-white-50 mt-2 mb-0" style="font-size: 12px; font-weight: 500;">Đơn hàng COD mới & đơn hàng Online chờ thanh toán</p>
            </div>
        </div>
    </div>

    <!-- Metric 3: Processing & Delivery -->
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-metric border-0" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); border-radius: 16px; box-shadow: 0 8px 20px rgba(6, 182, 212, 0.25);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title text-white mb-0" style="font-size: 15px; font-weight: 600; opacity: 0.9;">Đang Xử Lý & Giao</h4>
                    <i class="typcn typcn-arrow-forward-outline" style="font-size: 24px; opacity: 0.8;"></i>
                </div>
                <div class="d-flex align-items-baseline justify-content-between flex-wrap gap-2">
                    <div>
                        <h2 class="mb-0 font-weight-bold text-white d-inline" style="font-size: 24px;">{{ $processingOrders }}</h2>
                        <span class="text-white-50" style="font-size: 11px;">Chuẩn bị</span>
                    </div>
                    <div>
                        <h2 class="mb-0 font-weight-bold text-white d-inline" style="font-size: 24px;">{{ $shippingOrders }}</h2>
                        <span class="text-white-50" style="font-size: 11px;">Đang giao</span>
                    </div>
                </div>
                <p class="text-white-50 mt-2 mb-0" style="font-size: 12px; font-weight: 500;">Đơn đang chuẩn bị đóng gói & đang giao hàng</p>
            </div>
        </div>
    </div>

    <!-- Metric 4: Total Revenue -->
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-metric border-0" style="background: linear-gradient(135deg, #10b981 0%, #047857 100%); border-radius: 16px; box-shadow: 0 8px 20px rgba(16, 185, 129, 0.25);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title text-white mb-0" style="font-size: 15px; font-weight: 600; opacity: 0.9;">Doanh Thu Thực Tế</h4>
                    <i class="typcn typcn-chart-bar-outline" style="font-size: 24px; opacity: 0.8;"></i>
                </div>
                <div class="d-flex align-items-baseline flex-wrap">
                    <h2 class="mb-0 font-weight-bold text-white mr-2" style="font-size: 22px;">{{ number_format($totalRevenue, 0, ',', '.') }} đ</h2>
                </div>
                <p class="text-white-50 mt-2 mb-0" style="font-size: 12px; font-weight: 500;">Từ các đơn hàng thành công (Trạng thái 4)</p>
            </div>
        </div>
    </div>
</div>

<!-- ==================== MAIN DATA SECTION ==================== -->
<div class="row mt-4">
    <div class="col-12 grid-margin stretch-card">
        <div class="card shadow-sm" style="border-radius: 16px; border: 1px solid #f1f5f9;">
            <div class="card-body p-4">
                <h4 class="card-title text-dark mb-3" style="font-size: 18px; font-weight: 700;">Danh sách hóa đơn đơn hàng</h4>
                
                <!-- Search & Filters Container -->
                <div class="row mb-4 align-items-center gap-y-2">
                    <!-- Left: Search Box -->
                    <div class="col-md-6 col-sm-12">
                        <form action="{{ route('admin.orders.table') }}" method="GET" autocomplete="off">
                            @if(request('status') !== null && request('status') !== '')
                                <input type="hidden" name="status" value="{{ request('status') }}">
                            @endif
                            <div class="input-group">
                                <input type="text" name="search" class="form-control search-input" placeholder="Tìm theo Mã ĐH, họ tên, điện thoại, email..." value="{{ request('search') }}" style="height: 44px; border: 1px solid #cbd5e1; border-radius: 8px 0 0 8px; font-size: 13px;">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit" style="border-radius: 0 8px 8px 0; height: 44px; font-weight: 600; font-size: 13px; min-width: 80px;">
                                        Tìm
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Right: Dropdown Filter by Status -->
                    <div class="col-md-4 col-sm-12">
                        <form action="{{ route('admin.orders.table') }}" method="GET">
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            <select name="status" class="form-control select-filter" style="height: 44px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 13px; color: #475569;" onchange="this.form.submit()">
                                <option value="">-- Tất cả trạng thái --</option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Chờ xác nhận (1)</option>
                                <option value="5" {{ request('status') == '5' ? 'selected' : '' }}>Chờ thanh toán (5)</option>
                                <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Đang chuẩn bị (2)</option>
                                <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>Đang vận chuyển (3)</option>
                                <option value="4" {{ request('status') == '4' ? 'selected' : '' }}>Giao thành công (4)</option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Đã hủy (0)</option>
                            </select>
                        </form>
                    </div>

                    <!-- Reset Filters Button -->
                    @if(request('search') || (request('status') !== null && request('status') !== ''))
                        <div class="col-md-2 col-sm-12 text-md-right mt-2 mt-md-0">
                            <a href="{{ route('admin.orders.table') }}" class="btn btn-outline-danger btn-sm font-weight-bold w-100" style="height: 44px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; font-size: 12px;">
                                Xóa bộ lọc X
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Responsive Table -->
                <div class="table-responsive">
                    <table class="table table-hover table-bordered border-light align-middle" style="border-collapse: separate; border-spacing: 0;">
                        <thead class="bg-light text-dark">
                            <tr>
                                <th style="border-top-left-radius: 12px; font-weight: 600; padding: 14px;">Mã ĐH</th>
                                <th style="font-weight: 600; padding: 14px;">Thông tin khách hàng</th>
                                <th style="font-weight: 600; padding: 14px;">Địa chỉ giao hàng</th>
                                <th style="font-weight: 600; padding: 14px;">Giá trị đơn</th>
                                <th style="font-weight: 600; padding: 14px; min-width: 170px;">Trạng thái cập nhật</th>
                                <th style="font-weight: 600; padding: 14px;">Ngày đặt hàng</th>
                                <th style="border-top-right-radius: 12px; font-weight: 600; padding: 14px; text-align: center;">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td class="font-weight-bold text-primary" style="padding: 14px;">#{{ $order->id }}</td>
                                    <td style="padding: 14px;">
                                        <div class="d-flex flex-column">
                                            <span class="font-weight-bold text-dark" style="font-size: 14px;">{{ $order->name }}</span>
                                            <span class="text-muted mt-1" style="font-size: 12px;"><i class="typcn typcn-phone mr-1"></i>{{ $order->phone }}</span>
                                            <span class="text-muted" style="font-size: 12px;"><i class="typcn typcn-mail mr-1"></i>{{ $order->email }}</span>
                                        </div>
                                    </td>
                                    <td class="text-wrap" style="padding: 14px; max-width: 250px; font-size: 13px; line-height: 1.5; color: #334155;">
                                        {{ $order->address }}
                                    </td>
                                    <td class="font-weight-bold text-danger" style="padding: 14px; font-size: 14px;">
                                        {{ number_format($order->total_amount, 0, ',', '.') }} đ
                                    </td>
                                    <td style="padding: 14px;">
                                        <!-- Interactive Status Selector form -->
                                        <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST" class="m-0">
                                            @csrf
                                            @php
                                                // Đặt class màu theo trạng thái hiện tại
                                                $selectColor = 'border-warning text-warning bg-warning-light';
                                                if ($order->status == 0) $selectColor = 'border-danger text-danger bg-danger-light';
                                                elseif ($order->status == 2) $selectColor = 'border-primary text-primary bg-primary-light';
                                                elseif ($order->status == 3) $selectColor = 'border-info text-info bg-info-light';
                                                elseif ($order->status == 4) $selectColor = 'border-success text-success bg-success-light';
                                            @endphp
                                            <select name="status" class="form-control form-control-sm select-status-table {{ $selectColor }}" onchange="this.form.submit()" style="border-radius: 8px; font-weight: 700; font-size: 12px; height: 35px; border-width: 1.5px; transition: all 0.2s; cursor: pointer;">
                                                <option value="1" class="text-warning font-weight-bold" {{ $order->status == 1 ? 'selected' : '' }}>⏳ Chờ xác nhận</option>
                                                <option value="5" class="text-warning font-weight-bold" {{ $order->status == 5 ? 'selected' : '' }}>💳 Chờ thanh toán</option>
                                                <option value="2" class="text-primary font-weight-bold" {{ $order->status == 2 ? 'selected' : '' }}>⚙️ Đang chuẩn bị</option>
                                                <option value="3" class="text-info font-weight-bold" {{ $order->status == 3 ? 'selected' : '' }}>🚚 Đang vận chuyển</option>
                                                <option value="4" class="text-success font-weight-bold" {{ $order->status == 4 ? 'selected' : '' }}>✅ Giao thành công</option>
                                                <option value="0" class="text-danger font-weight-bold" {{ $order->status == 0 ? 'selected' : '' }}>❌ Đã hủy</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td style="padding: 14px; font-size: 12px; color: #64748b;">
                                        {{ date('d/m/Y H:i', strtotime($order->created_at)) }}
                                    </td>
                                    <td style="padding: 14px; text-align: center;">
                                        <div class="d-flex flex-column flex-sm-row justify-content-center align-items-center">
                                            <button type="button" class="btn btn-sm btn-success text-white mr-sm-2 mb-2 mb-sm-0" onclick="openInvoiceModal({{ $order->id }})" style="border-radius: 8px; font-weight: 600; font-size: 12px; height: 32px; display: inline-flex; align-items: center; justify-content: center; min-width: 110px;">
                                                <i class="typcn typcn-eye mr-1"></i> Xem hóa đơn
                                            </button>
                                            @if($order->status == 1)
                                                <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST" class="m-0 d-inline">
                                                    @csrf
                                                    <input type="hidden" name="status" value="2">
                                                    <button type="submit" class="btn btn-sm btn-primary text-white" style="border-radius: 8px; font-weight: 700; font-size: 12px; height: 32px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border: 0; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2); display: inline-flex; align-items: center; justify-content: center; min-width: 100px;">
                                                        <i class="typcn typcn-tick mr-1" style="font-size: 14px;"></i> Duyệt đơn
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="typcn typcn-info-large mb-2" style="font-size: 40px; display: block; color: #cbd5e1;"></i>
                                        Không tìm thấy hóa đơn đơn hàng nào phù hợp với bộ lọc.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Section -->
                @if($orders->total() > 0)
                    <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
                        <small class="text-muted" style="font-size: 13px;">
                            Hiển thị từ {{ $orders->firstItem() }} đến {{ $orders->lastItem() }} của tổng số {{ $orders->total() }} hóa đơn
                        </small>
                        @if($orders->hasPages())
                            <div>
                                {{ $orders->links('pagination::bootstrap-4') }}
                            </div>
                        @endif
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>

<!-- ==================== DETAILED INVOICE MODAL (Premium design) ==================== -->
<div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="invoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 20px; border: 0; overflow: hidden; box-shadow: 0 15px 40px rgba(0,0,0,0.12);">
            
            <!-- Modal Header -->
            <div class="modal-header bg-gradient-primary text-white py-3 border-0" style="background: linear-gradient(135deg, #051923 0%, #004e64 100%);">
                <div class="d-flex flex-column text-left">
                    <h5 class="modal-title font-weight-bold text-white mb-0" id="invoiceModalLabel" style="font-size: 18px;">
                        CHI TIẾT HÓA ĐƠN ĐƠN HÀNG <span id="modal-order-id-title"></span>
                    </h5>
                    <span class="text-white-50 mt-1" style="font-size: 12px; font-weight: 500;">
                        Mua vào ngày: <span id="modal-order-date"></span>
                    </span>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="outline: none !important;">
                    <span aria-hidden="true" style="font-size: 24px;">&times;</span>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body p-4" style="background-color: #f8fafc;">
                <!-- Loading State Spinner -->
                <div id="modal-loading-spinner" class="text-center py-5">
                    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                        <span class="sr-only">Đang tải hóa đơn...</span>
                    </div>
                    <p class="text-muted mt-3 font-weight-bold" style="font-size: 14px;">Đang truy xuất thông tin đơn hàng...</p>
                </div>

                <!-- Content State -->
                <div id="modal-invoice-content" style="display: none;">
                    
                    <!-- Top Section: Customer Info Card -->
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="card h-100 border-0 shadow-sm" style="border-radius: 12px; background: #ffffff;">
                                <div class="card-body p-3">
                                    <h6 class="text-uppercase tracking-wider font-weight-bold text-primary mb-3" style="font-size: 11px;">Thông tin khách mua hàng</h6>
                                    <p class="font-weight-bold text-dark mb-1" id="modal-cust-name" style="font-size: 15px;"></p>
                                    <p class="text-muted mb-1" style="font-size: 13px;"><i class="typcn typcn-phone mr-2 text-muted"></i>Điện thoại: <span id="modal-cust-phone" class="font-weight-bold text-dark"></span></p>
                                    <p class="text-muted mb-0" style="font-size: 13px;"><i class="typcn typcn-mail mr-2 text-muted"></i>Email: <span id="modal-cust-email" class="font-weight-bold text-dark"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100 border-0 shadow-sm" style="border-radius: 12px; background: #ffffff;">
                                <div class="card-body p-3">
                                    <h6 class="text-uppercase tracking-wider font-weight-bold text-primary mb-3" style="font-size: 11px;">Địa chỉ giao nhận</h6>
                                    <p class="text-dark leading-relaxed mb-0" id="modal-cust-address" style="font-size: 13.5px; font-weight: 500;"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Middle Section: Products Receipt Table -->
                    <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden; background: #ffffff;">
                        <div class="card-header bg-white py-3 border-bottom border-light">
                            <h6 class="font-weight-bold text-dark mb-0" style="font-size: 14px;">🛍️ Danh sách sản phẩm thanh toán</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle m-0" style="border: 0;">
                                <thead class="bg-light text-muted">
                                    <tr>
                                        <th style="font-size: 12px; font-weight: 600; border: 0; padding: 12px 16px;">Sản phẩm</th>
                                        <th style="font-size: 12px; font-weight: 600; border: 0; padding: 12px 16px; text-align: center; width: 100px;">Số lượng</th>
                                        <th style="font-size: 12px; font-weight: 600; border: 0; padding: 12px 16px; text-align: right; width: 150px;">Đơn giá</th>
                                        <th style="font-size: 12px; font-weight: 600; border: 0; padding: 12px 16px; text-align: right; width: 150px;">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody id="modal-items-tbody">
                                    <!-- Dynamic rows loaded via JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Bottom Section: Billing summary & CS -->
                    <div class="row mt-4 align-items-center">
                        <div class="col-md-7 text-left text-muted">
                            <div class="p-3 bg-light rounded" style="border: 1px dashed #cbd5e1; font-size: 12.5px; line-height: 1.6;">
                                <span class="font-weight-bold text-dark d-block mb-1">📞 Hướng dẫn hỗ trợ khách hàng</span>
                                Nếu khách hàng yêu cầu hỗ trợ sửa thông tin nhận hoặc thay đổi sản phẩm, Admin có thể hủy đơn và tạo đơn thay thế hoặc liên hệ hotline kho TTGSHOP: <strong class="text-danger">1800.6868</strong>.
                            </div>
                        </div>
                        <div class="col-md-5 mt-3 mt-md-0">
                            <div class="p-3 rounded bg-white shadow-sm border border-light">
                                <div class="d-flex justify-content-between align-items-center mb-2" style="font-size: 13.5px;">
                                    <span class="text-muted">Tổng cộng hàng:</span>
                                    <span class="font-weight-bold text-dark" id="modal-subtotal-calc"></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3" style="font-size: 13.5px;">
                                    <span class="text-muted">Phí giao hàng:</span>
                                    <span class="font-weight-bold text-success">Miễn phí</span>
                                </div>
                                <hr class="my-2 border-light">
                                <div class="d-flex justify-content-between align-items-center" style="font-size: 15px;">
                                    <span class="font-weight-bold text-dark">Thực thanh toán:</span>
                                    <span class="font-weight-extrabold text-danger" id="modal-final-total" style="font-size: 18px; font-weight: 800;"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer bg-light border-0 py-3">
                <button type="button" class="btn btn-secondary px-4" data-dismiss="modal" style="border-radius: 8px; font-weight: 600;">Đóng</button>
                <button type="button" class="btn btn-primary px-4" onclick="window.print()" style="border-radius: 8px; font-weight: 600;">
                    <i class="typcn typcn-printer mr-1"></i> In hóa đơn
                </button>
            </div>

        </div>
    </div>
</div>

<!-- ==================== EMBEDDED STYLES & INTERACTION SCRIPT ==================== -->
<style>
/* Status color classes inside the select boxes */
.bg-danger-light { background-color: #fee2e2 !important; color: #ef4444 !important; }
.bg-warning-light { background-color: #fef3c7 !important; color: #d97706 !important; }
.bg-primary-light { background-color: #dbeafe !important; color: #2563eb !important; }
.bg-info-light { background-color: #ecfeff !important; color: #0891b2 !important; }
.bg-success-light { background-color: #dcfce7 !important; color: #16a34a !important; }

/* Custom animation for metric cards hover */
.card-metric {
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease;
}
.card-metric:hover {
    transform: translateY(-5px);
}
.table td, .table th {
    vertical-align: middle !important;
}
.search-input:focus, .select-filter:focus {
    border-color: #3b82f6 !important;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
}
</style>

<script>
/**
 * Mở modal chi tiết hóa đơn đơn hàng và tải dữ liệu qua AJAX
 */
function openInvoiceModal(orderId) {
    const modal = $('#invoiceModal');
    const loadingSpinner = $('#modal-loading-spinner');
    const invoiceContent = $('#modal-invoice-content');
    
    // Đặt tên tiêu đề
    $('#modal-order-id-title').text('#' + orderId);
    
    // Hiện modal
    modal.modal('show');
    
    // Hiện loading, ẩn nội dung cũ
    loadingSpinner.show();
    invoiceContent.hide();
    
    // Thực hiện gọi fetch API lấy chi tiết đơn hàng
    fetch(`{{ url('admin/orders/detail') }}/${orderId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Không thể lấy chi tiết đơn hàng.');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const order = data.order;
                const items = data.items;
                
                // Gán thông tin khách hàng
                $('#modal-order-date').text(data.created_at_formatted);
                $('#modal-cust-name').text(order.name);
                $('#modal-cust-phone').text(order.phone);
                $('#modal-cust-email').text(order.email || 'Không có');
                $('#modal-cust-address').text(order.address);
                
                // Vẽ danh sách sản phẩm
                let tbodyHtml = '';
                let grandTotal = 0;
                
                items.forEach(item => {
                    grandTotal += item.subtotal;
                    
                    tbodyHtml += `
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 12px 16px;">
                                <div class="d-flex align-items-center">
                                    <img src="${item.image_url}" alt="${item.name}" style="width: 44px; height: 44px; object-fit: contain; border-radius: 6px; margin-right: 12px; border: 1px solid #f1f5f9; background: #fff; padding: 2px;">
                                    <div>
                                        <span class="font-weight-bold text-dark d-block" style="font-size: 13.5px; max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            ${item.name}
                                        </span>
                                        <span class="text-muted" style="font-size: 11px;">Mã SP: ${item.product_id}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center font-weight-bold text-dark" style="padding: 12px 16px; font-size: 13.5px;">
                                ${item.quantity}
                            </td>
                            <td class="text-right text-muted font-weight-medium" style="padding: 12px 16px; font-size: 13.5px;">
                                ${item.price_formatted}
                            </td>
                            <td class="text-right font-weight-bold text-teal" style="padding: 12px 16px; font-size: 13.5px; color: #0d9488;">
                                ${item.subtotal_formatted}
                            </td>
                        </tr>
                    `;
                });
                
                $('#modal-items-tbody').html(tbodyHtml);
                
                // Gán tổng tiền
                const totalFormatted = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(grandTotal);
                $('#modal-subtotal-calc').text(totalFormatted);
                $('#modal-final-total').text(totalFormatted);
                
                // Ẩn spinner, hiện nội dung hóa đơn
                loadingSpinner.hide();
                invoiceContent.fadeIn(300);
            } else {
                alert('Có lỗi xảy ra: ' + data.error);
                modal.modal('hide');
            }
        })
        .catch(error => {
            console.error('Error fetching order details:', error);
            alert('Không thể kết nối máy chủ để lấy thông tin đơn hàng.');
            modal.modal('hide');
        });
}
</script>

<!-- ==================== CUSTOM TOAST ALERTS ==================== -->
@if(session('success') || session('error'))
<div id="custom-toast" class="custom-toast-container">
    <div class="custom-toast-card {{ session('error') ? 'error-toast' : '' }}">
        <div class="custom-toast-icon">
            @if(session('success'))
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            @else
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            @endif
        </div>
        <div class="custom-toast-content">
            <span class="custom-toast-title">{{ session('success') ? 'Thành công' : 'Lỗi tác vụ' }}</span>
            <span class="custom-toast-message">{{ session('success') ?? session('error') }}</span>
        </div>
        <button type="button" class="custom-toast-close" onclick="dismissToast()">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        <div class="custom-toast-progress"></div>
    </div>
</div>
@endif

<style>
/* Premium Pagination Styling */
.pagination {
    margin-bottom: 0;
    gap: 6px;
    display: flex;
    padding-left: 0;
    list-style: none;
    border-radius: 8px;
}
.page-item .page-link {
    border: 1px solid #e2e8f0;
    color: #475569;
    border-radius: 8px !important;
    padding: 8px 14px;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.2s ease;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
    background-color: #ffffff;
    display: block;
    line-height: 1.25;
}
.page-item.active .page-link {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
    border-color: transparent !important;
    color: #ffffff !important;
    box-shadow: 0 4px 10px rgba(59, 130, 246, 0.25);
}
.page-item .page-link:hover {
    background-color: #f8fafc;
    color: #1e293b;
    border-color: #cbd5e1;
    transform: translateY(-1px);
    text-decoration: none;
}
.page-item.disabled .page-link {
    background-color: #f1f5f9;
    border-color: #e2e8f0;
    color: #94a3b8;
    pointer-events: none;
}

.custom-toast-container {
    position: fixed;
    top: 30px;
    right: 30px;
    z-index: 999999;
    pointer-events: none;
}
.custom-toast-card {
    pointer-events: auto;
    display: flex;
    align-items: center;
    width: 360px;
    max-width: 90vw;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(12px) saturate(180%);
    -webkit-backdrop-filter: blur(12px) saturate(180%);
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-radius: 16px;
    padding: 16px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08), 0 1px 3px rgba(0, 0, 0, 0.02);
    overflow: hidden;
    position: relative;
    transform-origin: top right;
    animation: toastSlideIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
@keyframes toastSlideIn {
    0% { opacity: 0; transform: translateY(-20px) scale(0.95); }
    100% { opacity: 1; transform: translateY(0) scale(1); }
}
.custom-toast-card.hide {
    animation: toastSlideOut 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
@keyframes toastSlideOut {
    0% { opacity: 1; transform: translateY(0) scale(1); }
    100% { opacity: 0; transform: translateY(-20px) scale(0.95); }
}
.custom-toast-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border-radius: 10px;
    color: #ffffff;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    margin-right: 14px;
}
.error-toast .custom-toast-icon {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}
.custom-toast-content {
    display: flex;
    flex-direction: column;
    flex-grow: 1;
    margin-right: 12px;
}
.custom-toast-title {
    font-weight: 600;
    font-size: 14px;
    color: #111827;
    margin-bottom: 2px;
}
.custom-toast-message {
    font-size: 13px;
    color: #4b5563;
    line-height: 1.4;
}
.custom-toast-close {
    background: none;
    border: none;
    color: #9ca3af;
    cursor: pointer;
    padding: 4px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
    outline: none !important;
}
.custom-toast-close:hover {
    background: rgba(0, 0, 0, 0.05);
    color: #1f2937;
}
.custom-toast-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    background: linear-gradient(90deg, #10b981 0%, #34d399 100%);
    width: 100%;
    transform-origin: left;
    animation: toastProgress 4s linear forwards;
}
.error-toast .custom-toast-progress {
    background: linear-gradient(90deg, #ef4444 0%, #f87171 100%);
}
@keyframes toastProgress {
    0% { transform: scaleX(1); }
    100% { transform: scaleX(0); }
}
</style>

<script>
function dismissToast() {
    const toast = document.getElementById('custom-toast');
    if (toast) {
        const card = toast.querySelector('.custom-toast-card');
        card.classList.add('hide');
        setTimeout(() => { toast.remove(); }, 400);
    }
}
document.addEventListener('DOMContentLoaded', function() {
    const toast = document.getElementById('custom-toast');
    if (toast) {
        setTimeout(() => { dismissToast(); }, 4000);
    }
});
</script>

@endsection
