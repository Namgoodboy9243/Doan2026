@extends('layouts.app')

@section('title', 'Lịch sử mua hàng & Theo dõi đơn hàng - SPATACUS')

@section('styles')
    .status-timeline {
        position: relative;
    }
    .status-timeline::before {
        content: '';
        position: absolute;
        top: 24px;
        left: 20px;
        right: 20px;
        height: 4px;
        background-color: #e5e7eb;
        z-index: 1;
    }
    @media (max-width: 640px) {
        .status-timeline::before {
            display: none;
        }
    }
    .status-step.completed .step-icon {
        background-color: #10b981;
        color: white;
        border-color: #10b981;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.2);
    }
    .status-step.active .step-icon {
        background-color: #3b82f6;
        color: white;
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2);
    }
    .status-step.completed .step-line {
        background-color: #10b981;
    }
@endsection

@section('content')
    <!-- Breadcrumb -->
    <div class="text-sm text-gray-500 mb-6 px-2">
        <a href="{{ url('index') }}" class="hover:text-primary transition">Trang chủ</a> &gt; <span class="text-gray-800 font-medium">Lịch sử đơn hàng</span>
    </div>

    <!-- Header Section -->
    <div class="bg-gradient-to-r from-teal-700 to-[#051923] text-white p-8 rounded-2xl shadow-lg mb-8 flex flex-col md:flex-row items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight mb-2">Lịch sử mua hàng</h1>
            <p class="text-teal-100 opacity-90 max-w-md">Theo dõi chi tiết trạng thái đơn hàng của bạn, xem lại hóa đơn mua sắm và quản lý các giao dịch một cách dễ dàng.</p>
        </div>
        <div class="flex items-center gap-4 bg-white/10 px-6 py-4 rounded-xl backdrop-blur-sm border border-white/10 w-full md:w-auto">
            <div class="w-12 h-12 rounded-full bg-teal-500 flex items-center justify-center text-xl font-bold">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <h3 class="font-bold text-lg leading-tight">{{ auth()->user()->name }}</h3>
                <p class="text-xs text-teal-200 mt-0.5">{{ auth()->user()->email }}</p>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Sidebar Filters -->
        <div class="lg:col-span-1 space-y-4">
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                <h3 class="font-bold text-gray-800 text-lg mb-4 flex items-center">
                    <i class="fas fa-filter text-teal-600 mr-2"></i> Bộ lọc đơn hàng
                </h3>
                
                <!-- Search Order ID -->
                <div class="mb-4 relative">
                    <input type="text" id="order-search" placeholder="Nhập mã đơn hàng..." class="w-full border border-gray-200 rounded-lg pl-9 pr-4 py-2 text-sm focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500">
                    <i class="fas fa-search text-gray-400 absolute left-3.5 top-3 text-sm"></i>
                </div>

                <!-- Tabs Filter Buttons -->
                <div class="space-y-2" id="filter-buttons">
                    <button onclick="filterOrders('all')" class="filter-btn w-full text-left px-4 py-2.5 rounded-lg text-sm font-semibold transition bg-teal-50 text-teal-700 flex items-center justify-between">
                        <span><i class="fas fa-list-ul mr-2.5"></i>Tất cả đơn</span>
                        <span class="bg-teal-200 text-teal-800 px-2 py-0.5 rounded-full text-xs font-bold">{{ count($orders) }}</span>
                    </button>
                    <button onclick="filterOrders('1')" class="filter-btn w-full text-left px-4 py-2.5 rounded-lg text-sm font-semibold transition text-gray-600 hover:bg-gray-50 flex items-center justify-between">
                        <span><i class="fas fa-clock mr-2.5 text-orange-500"></i>Chờ xác nhận</span>
                        <span class="bg-gray-100 text-gray-800 px-2 py-0.5 rounded-full text-xs font-bold">{{ count($orders->where('status', 1)) }}</span>
                    </button>
                    <button onclick="filterOrders('5')" class="filter-btn w-full text-left px-4 py-2.5 rounded-lg text-sm font-semibold transition text-gray-600 hover:bg-gray-50 flex items-center justify-between">
                        <span><i class="fas fa-wallet mr-2.5 text-yellow-500"></i>Chờ thanh toán</span>
                        <span class="bg-gray-100 text-gray-800 px-2 py-0.5 rounded-full text-xs font-bold">{{ count($orders->where('status', 5)) }}</span>
                    </button>
                    <button onclick="filterOrders('2-3')" class="filter-btn w-full text-left px-4 py-2.5 rounded-lg text-sm font-semibold transition text-gray-600 hover:bg-gray-50 flex items-center justify-between">
                        <span><i class="fas fa-shipping-fast mr-2.5 text-blue-500"></i>Đang chuẩn bị/Giao</span>
                        <span class="bg-gray-100 text-gray-800 px-2 py-0.5 rounded-full text-xs font-bold">{{ count($orders->whereIn('status', [2, 3])) }}</span>
                    </button>
                    <button onclick="filterOrders('4')" class="filter-btn w-full text-left px-4 py-2.5 rounded-lg text-sm font-semibold transition text-gray-600 hover:bg-gray-50 flex items-center justify-between">
                        <span><i class="fas fa-check-circle mr-2.5 text-green-500"></i>Đã giao hàng</span>
                        <span class="bg-gray-100 text-gray-800 px-2 py-0.5 rounded-full text-xs font-bold">{{ count($orders->where('status', 4)) }}</span>
                    </button>
                    <button onclick="filterOrders('0')" class="filter-btn w-full text-left px-4 py-2.5 rounded-lg text-sm font-semibold transition text-gray-600 hover:bg-gray-50 flex items-center justify-between">
                        <span><i class="fas fa-times-circle mr-2.5 text-red-500"></i>Đã hủy</span>
                        <span class="bg-gray-100 text-gray-800 px-2 py-0.5 rounded-full text-xs font-bold">{{ count($orders->where('status', 0)) }}</span>
                    </button>
                </div>
            </div>

            <!-- Promotion banner -->
            <div class="bg-orange-50 p-6 rounded-xl border border-orange-100 shadow-sm relative overflow-hidden group">
                <div class="absolute -right-4 -bottom-4 text-orange-200/50 text-8xl group-hover:scale-110 transition duration-300 transform"><i class="fas fa-gift"></i></div>
                <h4 class="font-extrabold text-orange-800 text-md mb-1.5"><i class="fas fa-percent mr-2"></i>ƯU ĐÃI THÀNH VIÊN</h4>
                <p class="text-xs text-orange-700 leading-relaxed mb-3">Nhận ngay voucher giảm giá tới 500k khi hoàn thành tổng cộng 3 đơn hàng giao thành công!</p>
                <a href="{{ url('index') }}" class="text-xs font-bold text-orange-800 hover:text-orange-950 underline transition">Khám phá sản phẩm ngay &gt;</a>
            </div>
        </div>

        <!-- Orders List Container -->
        <div class="lg:col-span-3 space-y-6">
            @forelse($orders as $order)
                @php
                    // Tính tổng tiền đơn hàng
                    $orderTotal = 0;
                    foreach($order->items as $item) {
                        $orderTotal += $item->price * $item->quantity;
                    }
                @endphp
                <!-- Order Card -->
                <div class="order-card-item bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden" data-status="{{ $order->status }}" data-id="{{ $order->id }}">
                    <!-- Card Header -->
                    <div class="bg-gray-50/70 px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="flex items-center gap-2.5 flex-wrap">
                            <span class="text-sm font-bold text-gray-800 bg-gray-200/60 px-2.5 py-1 rounded">Mã ĐH: #{{ $order->id }}</span>
                            <span class="text-xs font-semibold text-gray-500"><i class="far fa-calendar-alt mr-1"></i> Ngày mua: {{ date('H:i d/m/Y', strtotime($order->created_at)) }}</span>
                        </div>
                        <div class="flex items-center">
                            @if($order->status == 1)
                                <span class="bg-orange-100 text-orange-700 font-bold px-3 py-1 rounded-full text-xs flex items-center"><span class="w-1.5 h-1.5 rounded-full bg-orange-500 mr-1.5 animate-pulse"></span> Chờ xác nhận</span>
                            @elseif($order->status == 5)
                                <span class="bg-yellow-100 text-yellow-800 font-bold px-3 py-1 rounded-full text-xs flex items-center"><span class="w-1.5 h-1.5 rounded-full bg-yellow-500 mr-1.5 animate-pulse"></span> Chờ thanh toán</span>
                            @elseif($order->status == 2)
                                <span class="bg-blue-100 text-blue-700 font-bold px-3 py-1 rounded-full text-xs flex items-center"><span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1.5 animate-pulse"></span> Đang chuẩn bị</span>
                            @elseif($order->status == 3)
                                <span class="bg-teal-100 text-teal-700 font-bold px-3 py-1 rounded-full text-xs flex items-center"><span class="w-1.5 h-1.5 rounded-full bg-teal-500 mr-1.5 animate-pulse"></span> Đang giao hàng</span>
                            @elseif($order->status == 4)
                                <span class="bg-green-100 text-green-700 font-bold px-3 py-1 rounded-full text-xs flex items-center"><i class="fas fa-check-circle mr-1"></i> Đã giao thành công</span>
                            @elseif($order->status == 0)
                                <span class="bg-red-100 text-red-700 font-bold px-3 py-1 rounded-full text-xs flex items-center"><i class="fas fa-times-circle mr-1"></i> Đã hủy</span>
                            @endif
                        </div>
                    </div>

                    <!-- Delivery Info & Timeline Tracker -->
                    <div class="p-6 border-b border-gray-50">
                        @if($order->status != 0)
                            <!-- Order Timeline Tracker -->
                            <div class="mb-8">
                                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-6">Trạng thái vận chuyển</h4>
                                <div class="status-timeline flex flex-col sm:flex-row justify-between gap-6 relative">
                                    
                                    <!-- Step 1 -->
                                    <div class="status-step flex-1 text-center relative z-10 flex sm:flex-col items-center gap-3 sm:gap-0 completed">
                                        <div class="step-icon w-10 h-10 rounded-full bg-white border-2 border-gray-200 flex items-center justify-center font-bold text-sm mb-2 transition">
                                            <i class="fas fa-file-invoice"></i>
                                        </div>
                                        <div class="sm:text-center text-left">
                                            <p class="font-bold text-gray-800 text-xs sm:text-[13px] leading-tight">Đã nhận đơn</p>
                                            <p class="text-[10px] text-gray-400 mt-0.5">Hệ thống ghi nhận</p>
                                        </div>
                                    </div>

                                    <!-- Step 2 -->
                                    <div class="status-step flex-1 text-center relative z-10 flex sm:flex-col items-center gap-3 sm:gap-0 {{ in_array($order->status, [2, 3, 4]) ? 'completed' : (in_array($order->status, [1, 5]) ? 'active' : '') }}">
                                        <div class="step-icon w-10 h-10 rounded-full bg-white border-2 border-gray-200 flex items-center justify-center font-bold text-sm mb-2 transition">
                                            <i class="fas fa-cogs"></i>
                                        </div>
                                        <div class="sm:text-center text-left">
                                            <p class="font-bold text-gray-800 text-xs sm:text-[13px] leading-tight">Đang chuẩn bị</p>
                                            <p class="text-[10px] text-gray-400 mt-0.5">Xác nhận & đóng gói</p>
                                        </div>
                                    </div>

                                    <!-- Step 3 -->
                                    <div class="status-step flex-1 text-center relative z-10 flex sm:flex-col items-center gap-3 sm:gap-0 {{ in_array($order->status, [3, 4]) ? 'completed' : ($order->status == 2 ? 'active' : '') }}">
                                        <div class="step-icon w-10 h-10 rounded-full bg-white border-2 border-gray-200 flex items-center justify-center font-bold text-sm mb-2 transition">
                                            <i class="fas fa-shipping-fast"></i>
                                        </div>
                                        <div class="sm:text-center text-left">
                                            <p class="font-bold text-gray-800 text-xs sm:text-[13px] leading-tight">Đang vận chuyển</p>
                                            <p class="text-[10px] text-gray-400 mt-0.5">Đối tác đang giao hàng</p>
                                        </div>
                                    </div>

                                    <!-- Step 4 -->
                                    <div class="status-step flex-1 text-center relative z-10 flex sm:flex-col items-center gap-3 sm:gap-0 {{ $order->status == 4 ? 'completed' : ($order->status == 3 ? 'active' : '') }}">
                                        <div class="step-icon w-10 h-10 rounded-full bg-white border-2 border-gray-200 flex items-center justify-center font-bold text-sm mb-2 transition">
                                            <i class="fas fa-check-double"></i>
                                        </div>
                                        <div class="sm:text-center text-left">
                                            <p class="font-bold text-gray-800 text-xs sm:text-[13px] leading-tight">Giao thành công</p>
                                            <p class="text-[10px] text-gray-400 mt-0.5">Khách đã ký nhận</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @else
                            <!-- Cancelled view -->
                            <div class="mb-6 bg-red-50/50 border border-red-100 rounded-lg p-4 flex items-center gap-3 text-red-800 text-sm">
                                <i class="fas fa-exclamation-triangle text-lg text-red-500"></i>
                                <div>
                                    <span class="font-bold">Đơn hàng này đã bị hủy bỏ!</span> Khách hàng hoặc quản trị viên đã hủy giao dịch này vào ngày hôm nay. Tiền hoặc Voucher (nếu có) sẽ được hoàn trả lại theo chính sách.
                                </div>
                            </div>
                        @endif

                        <!-- Shipping Info -->
                        <div class="bg-gray-50/50 rounded-xl p-4 border border-gray-100/50 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <h5 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Thông tin người nhận</h5>
                                <p class="font-bold text-gray-800">{{ $order->name }}</p>
                                <p class="text-gray-600 mt-1"><i class="fas fa-phone-alt text-gray-400 mr-1.5 text-xs"></i> {{ $order->phone }}</p>
                                <p class="text-gray-600 mt-0.5"><i class="far fa-envelope text-gray-400 mr-1.5 text-xs"></i> {{ $order->email }}</p>
                            </div>
                            <div>
                                <h5 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Địa chỉ giao hàng</h5>
                                <p class="text-gray-700 leading-normal"><i class="fas fa-map-marker-alt text-gray-400 mr-1.5 text-xs"></i> {{ $order->address }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Items ordered -->
                    <div class="divide-y divide-gray-100 bg-white/50">
                        @foreach($order->items as $item)
                            <div class="p-6 flex items-center justify-between gap-4 flex-wrap sm:flex-nowrap">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 rounded border border-gray-200 bg-white p-1 flex-shrink-0 flex items-center justify-center">
                                        <img src="{{ (preg_match('/^https?:\/\//', $item->image) || empty($item->image)) ? ($item->image ?: 'https://images.unsplash.com/photo-1593640408182-31c70c8268f5?auto=format&fit=crop&w=150&h=150') : asset('images/products/' . $item->image) }}" alt="{{ $item->name }}" class="max-w-full max-h-full object-contain">
                                    </div>
                                    <div>
                                        <h5 class="font-bold text-sm text-gray-800 hover:text-teal-600 transition">{{ $item->name }}</h5>
                                        <p class="text-xs text-gray-400 mt-1">Số lượng: <span class="font-bold text-gray-700">{{ $item->quantity }}</span></p>
                                    </div>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <span class="font-bold text-teal-600 text-sm block">{{ number_format($item->price, 0, ',', '.') }} ₫</span>
                                    <span class="text-xs text-gray-400">Thành tiền: {{ number_format($item->price * $item->quantity, 0, ',', '.') }} ₫</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Card Footer Actions & Price -->
                    <div class="bg-gray-50/50 px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            @if($order->status == 1 || $order->status == 5)
                                <!-- Hủy đơn hàng form -->
                                <form action="{{ route('order.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng #{{ $order->id }} này không?')">
                                    @csrf
                                    <button type="submit" class="bg-red-50 text-red-600 hover:bg-red-100 px-4 py-2 rounded-lg text-xs font-bold transition flex items-center">
                                        <i class="fas fa-trash-alt mr-1.5"></i> HỦY ĐƠN HÀNG
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-gray-400 italic">Mọi nhu cầu hỗ trợ vui lòng gọi tổng đài miễn phí 1800.6868</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-semibold text-gray-500">Tổng số tiền thanh toán:</span>
                            <span class="font-extrabold text-red-600 text-xl">{{ number_format($orderTotal, 0, ',', '.') }} ₫</span>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Empty state -->
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-12 text-center flex flex-col items-center justify-center">
                    <div class="w-24 h-24 rounded-full bg-teal-50 flex items-center justify-center text-teal-600 mb-6 shadow-inner text-4xl">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <h3 class="font-extrabold text-xl text-gray-800 mb-2">Bạn chưa có đơn hàng nào!</h3>
                    <p class="text-gray-400 text-sm mb-6 max-w-sm leading-relaxed">Hãy quay lại trang chủ, chọn các sản phẩm gaming gear/laptop cấu hình khủng và đặt hàng ngay hôm nay nhé!</p>
                    <a href="{{ url('index') }}" class="bg-teal-600 hover:bg-teal-700 text-white font-bold px-6 py-3 rounded-lg transition transform hover:-translate-y-0.5 active:translate-y-0 shadow-md">
                        MUA SẮM NGAY
                    </a>
                </div>
            @endforelse
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Lọc danh sách đơn hàng theo Tab
        function filterOrders(status) {
            // Thay đổi active class của các filter button
            const buttons = document.querySelectorAll('.filter-btn');
            buttons.forEach(btn => {
                btn.classList.remove('bg-teal-50', 'text-teal-700');
                btn.classList.add('text-gray-600', 'hover:bg-gray-50');
            });

            // Gán active class cho nút vừa click
            const currentTarget = event.currentTarget;
            currentTarget.classList.remove('text-gray-600', 'hover:bg-gray-50');
            currentTarget.classList.add('bg-teal-50', 'text-teal-700');

            // Ẩn/Hiện đơn hàng phù hợp
            const cards = document.querySelectorAll('.order-card-item');
            cards.forEach(card => {
                const cardStatus = card.getAttribute('data-status');
                if (status === 'all') {
                    card.style.display = 'block';
                } else if (status === '2-3') {
                    if (cardStatus == '2' || cardStatus == '3') {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                } else {
                    if (cardStatus == status) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                }
            });
        }

        // Tìm kiếm đơn hàng theo Mã ID
        document.getElementById('order-search').addEventListener('input', function() {
            const searchQuery = this.value.trim().toLowerCase();
            const cards = document.querySelectorAll('.order-card-item');

            cards.forEach(card => {
                const cardId = card.getAttribute('data-id').toLowerCase();
                if (cardId.includes(searchQuery)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
@endsection
