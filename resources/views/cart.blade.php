@extends('layouts.app')

@section('title', 'Thông tin giỏ hàng - SPATACUS')

@section('content')

    <!-- Breadcrumb -->
    <div class="text-sm text-gray-500 mb-6 px-2">
        Trang chủ &gt; <span class="text-gray-800">Thông tin giỏ hàng</span>
    </div>

    <!-- Giỏ hàng chính -->
    @php
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
    @endphp

    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 mb-8">
        <!-- Cart Header -->
        <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
            <h1 class="text-teal-600 font-bold text-lg">Giỏ hàng</h1>
            @if(count($cart) > 0)
                <button onclick="clearCart(this)" class="text-red-500 hover:text-red-700 hover:underline text-sm font-medium transition">Xóa toàn bộ giỏ hàng</button>
            @endif
        </div>

        @forelse($cart as $key => $item)
            <!-- Cart Item -->
            <div id="cart-row-{{ $key }}" class="flex flex-col md:flex-row items-center justify-between border-b border-gray-100 pb-6 mb-6 last:border-b-0 last:pb-0 last:mb-0">
                <!-- Product Info -->
                <div class="flex items-center w-full md:w-[45%] mb-4 md:mb-0">
                    <div class="w-20 h-20 flex-shrink-0 bg-white border border-gray-200 flex items-center justify-center mr-4 p-1">
                        <img src="{{ (preg_match('/^https?:\/\//', $item['image']) || empty($item['image'])) ? ($item['image'] ?: 'https://images.unsplash.com/photo-1593640408182-31c70c8268f5?auto=format&fit=crop&w=150&h=150') : asset('images/products/' . $item['image']) }}" alt="{{ $item['name'] }}" class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="pr-4">
                        <h3 class="font-bold text-gray-800 text-sm mb-1 leading-snug">
                            <a href="{{ route('product.detail', $item['product_id']) }}" class="hover:text-primary transition">
                                {{ $item['name'] }}
                            </a>
                        </h3>
                        @if($item['cpu'] || $item['ram'] || $item['storage'] || $item['color'])
                            <div class="flex flex-wrap gap-1 mt-1 text-[10px] font-semibold">
                                @if($item['cpu']) <span class="bg-gray-100 text-gray-600 px-1.5 py-0.5 rounded border border-gray-200/50"><i class="fas fa-microchip mr-0.5 text-gray-400"></i> {{ $item['cpu'] }}</span> @endif
                                @if($item['ram']) <span class="bg-gray-100 text-gray-600 px-1.5 py-0.5 rounded border border-gray-200/50"><i class="fas fa-memory mr-0.5 text-gray-400"></i> {{ $item['ram'] }}</span> @endif
                                @if($item['storage']) <span class="bg-gray-100 text-gray-600 px-1.5 py-0.5 rounded border border-gray-200/50"><i class="fas fa-hdd mr-0.5 text-gray-400"></i> {{ $item['storage'] }}</span> @endif
                                @if($item['color']) <span class="bg-gray-100 text-gray-600 px-1.5 py-0.5 rounded border border-gray-200/50"><i class="fas fa-palette mr-0.5 text-gray-400"></i> {{ $item['color'] }}</span> @endif
                            </div>
                        @endif
                        <p class="text-xs text-gray-400 font-semibold mt-1.5">Mã SKU: <span class="text-gray-600 font-bold">{{ $item['sku'] }}</span></p>
                    </div>
                </div>

                <!-- Price & Actions -->
                <div class="flex items-center justify-between w-full md:w-[55%]">
                    <!-- Unit Price -->
                    <div class="text-gray-800 font-semibold text-sm w-1/4 text-center">
                        {{ number_format($item['price'], 0, ',', '.') }} ₫
                    </div>
                    
                    <!-- Quantity -->
                    <div class="w-1/4 flex justify-center">
                        <div class="flex border border-gray-300 rounded overflow-hidden bg-white">
                            <button onclick="updateQty('{{ $key }}', -1)" class="px-3 py-1 bg-gray-50 hover:bg-gray-200 text-gray-600 font-bold transition focus:outline-none">-</button>
                            <input id="qty-input-{{ $key }}" type="text" value="{{ $item['quantity'] }}" readonly class="w-10 text-center border-x border-gray-300 text-sm focus:outline-none bg-transparent">
                            <button onclick="updateQty('{{ $key }}', 1)" class="px-3 py-1 bg-gray-50 hover:bg-gray-200 text-gray-600 font-bold transition focus:outline-none">+</button>
                        </div>
                    </div>

                    <!-- Total Item Price -->
                    <div id="item-total-{{ $key }}" class="text-primary font-bold text-sm w-1/4 text-center">
                        {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} ₫
                    </div>

                    <!-- Delete Action -->
                    <div class="w-1/4 flex justify-end">
                        <button onclick="removeItem('{{ $key }}')" class="text-gray-400 hover:text-red-500 transition text-lg" title="Xóa sản phẩm">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12 flex flex-col items-center justify-center">
                <div class="w-24 h-24 rounded-full bg-orange-50/70 flex items-center justify-center text-primary mb-4 shadow-inner">
                    <i class="fas fa-shopping-basket text-4xl"></i>
                </div>
                <h3 class="text-gray-800 font-bold text-lg mb-2">Giỏ hàng của bạn đang trống!</h3>
                <p class="text-gray-400 text-sm mb-6 max-w-xs leading-relaxed">Hãy quay lại trang chủ và khám phá hàng ngàn dòng Laptop chính hãng cực đỉnh nhé!</p>
                <a href="{{ url('index') }}" class="bg-primary hover:bg-orange-600 text-white font-bold px-6 py-2.5 rounded-lg transition transform hover:-translate-y-0.5 active:translate-y-0 shadow-md">
                    QUAY LẠI TRANG CHỦ
                </a>
            </div>
        @endforelse

    </div>

    @if(count($cart) > 0)
    <!-- Checkout Form Section -->
    <div class="flex flex-col lg:flex-row gap-6 mb-8">
        <!-- Thông tin người mua -->
        <div class="w-full lg:w-3/5 bg-white shadow-sm border border-gray-100 rounded-lg overflow-hidden">
            <div class="bg-gray-100 px-6 py-3 border-b border-gray-200">
                <h2 class="font-bold text-gray-800 uppercase text-sm">THÔNG TIN NGƯỜI MUA</h2>
            </div>
            <div class="p-6">
                <p class="text-sm text-gray-700 mb-4 font-medium">Để tiếp tục đặt hàng, quý khách xin vui lòng nhập thông tin bên dưới</p>
                <form id="checkout-form" method="POST" action="{{ route('checkout') }}" class="space-y-4">
                    @csrf
                    <div class="flex items-center">
                        <label class="w-1/4 text-sm text-gray-700 font-bold">Họ tên<span class="text-red-500 ml-1">*</span></label>
                        <input type="text" name="name" id="name" value="{{ auth()->user()->name ?? '' }}" required class="w-3/4 border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                    </div>
                    <div class="flex items-center">
                        <label class="w-1/4 text-sm text-gray-700 font-bold">SĐT<span class="text-red-500 ml-1">*</span></label>
                        <input type="text" name="phone" id="phone" required class="w-3/4 border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                    </div>
                    <div class="flex items-center">
                        <label class="w-1/4 text-sm text-gray-700 font-bold">Email<span class="text-red-500 ml-1">*</span></label>
                        <input type="email" name="email" id="email" value="{{ auth()->user()->email ?? '' }}" required class="w-3/4 border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                    </div>
                    <div class="flex items-start">
                        <label class="w-1/4 text-sm text-gray-700 font-bold mt-2">Địa chỉ<span class="text-red-500 ml-1">*</span></label>
                        <textarea name="address_detail" id="address_detail" rows="2" required placeholder="Số nhà, tên đường, thôn/xóm..." class="w-3/4 border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary"></textarea>
                    </div>
                    <div class="flex items-center">
                        <label class="w-1/4 text-sm text-gray-700 font-bold">Tỉnh/Thành phố<span class="text-red-500 ml-1">*</span></label>
                        <select id="province" name="province" required class="w-3/4 border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-gray-600">
                            <option value="">Chọn Tỉnh/Thành phố</option>
                        </select>
                    </div>
                    <div class="flex items-center">
                        <label class="w-1/4 text-sm text-gray-700 font-bold">Quận/Huyện<span class="text-red-500 ml-1">*</span></label>
                        <select id="district" name="district" required disabled class="w-3/4 border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-gray-600 bg-gray-50 cursor-not-allowed">
                            <option value="">Chọn Quận/Huyện</option>
                        </select>
                    </div>
                    <div class="flex items-start">
                        <label class="w-1/4 text-sm text-gray-700 font-bold mt-2">Ghi chú</label>
                        <textarea name="note" id="note" rows="3" placeholder="Ghi chú về đơn hàng, thời gian giao hàng..." class="w-3/4 border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary"></textarea>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tổng tiền & Thanh toán -->
        <div class="w-full lg:w-2/5 bg-white shadow-sm border border-gray-100 rounded-lg overflow-hidden h-fit">
            <div class="bg-gray-100 px-6 py-3 border-b border-gray-200">
                <h2 class="font-bold text-gray-800 uppercase text-sm">TỔNG TIỀN</h2>
            </div>
            <div class="p-6">
                <!-- Voucher -->
                <div class="flex mb-6 border border-gray-300 rounded overflow-hidden shadow-sm">
                    <input type="text" placeholder="Mã Voucher" class="flex-1 px-4 py-2.5 text-sm focus:outline-none">
                    <button class="bg-[#1e3a8a] text-white px-5 py-2.5 text-sm font-bold hover:bg-blue-900 transition flex items-center justify-center">
                        <i class="fas fa-ticket-alt mr-2 transform -rotate-45"></i> Chọn mã voucher
                    </button>
                </div>

                <!-- Cost Breakdown -->
                <div class="space-y-3 mb-5 text-sm text-gray-700">
                    <div class="flex justify-between items-center">
                        <span>Tổng cộng</span>
                        <span id="summary-subtotal" class="font-bold">{{ number_format($subtotal, 0, ',', '.') }} ₫</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span>Giảm giá Voucher</span>
                        <span class="font-bold">0 ₫</span>
                    </div>
                    <div class="flex justify-between items-center mt-3 pt-3 border-t border-gray-200">
                        <span class="font-bold text-base text-gray-800">Thành tiền</span>
                        <div class="text-right">
                            <span id="summary-total" class="font-bold text-red-600 text-[22px] leading-tight block mb-0.5">{{ number_format($subtotal, 0, ',', '.') }} ₫</span>
                            <span class="text-[11px] text-gray-500">(Giá đã bao gồm VAT)</span>
                        </div>
                    </div>
                </div>

                <!-- Terms -->
                <div class="mb-6">
                    <label class="flex items-start cursor-pointer group">
                        <input type="checkbox" id="agree-terms" class="mt-0.5 mr-2 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4">
                        <span class="text-[13px] text-gray-800 font-bold group-hover:text-primary transition leading-tight">Tôi đã đọc và đồng ý với các Điều kiện giao dịch chung của website <span class="text-red-500">*</span></span>
                    </label>
                </div>

                <!-- Action Buttons -->
                <div class="grid grid-cols-2 gap-2">
                    <button onclick="printQuotation()" class="bg-[#051923] text-white py-3 rounded text-[13px] font-bold hover:bg-black hover:scale-[1.03] active:scale-95 transition transform duration-200 flex items-center justify-center shadow-md border border-gray-800/20">
                        <i class="fas fa-print mr-2 text-primary"></i> IN BÁO GIÁ
                    </button>
                    <button class="bg-[#051923] text-white py-3 rounded text-[13px] font-bold hover:bg-black hover:scale-[1.03] active:scale-95 transition transform duration-200 flex items-center justify-center shadow-md border border-gray-800/20">
                        <i class="fas fa-file-excel mr-2 text-green-500"></i> TẢI FILE EXCEL
                    </button>
                    <button type="submit" form="checkout-form" class="bg-[#e60000] text-white py-3 rounded text-[13px] font-bold hover:bg-red-700 hover:scale-[1.03] active:scale-95 transition transform duration-200 flex items-center justify-center shadow-md">
                        <i class="fas fa-check mr-2"></i> ĐẶT HÀNG (COD)
                    </button>
                    <button onclick="openQRModal()" type="button" class="bg-[#1e3a8a] text-white py-3 rounded text-[13px] font-bold hover:bg-blue-900 hover:scale-[1.03] active:scale-95 transition transform duration-200 flex items-center justify-center shadow-md">
                        <i class="fas fa-qrcode mr-2 text-yellow-400"></i> THANH TOÁN QR
                    </button>
                    <form id="vnpay-form" action="{{route('thanhtoan.vnpay')}}" method="POST" onsubmit="return validateVNPAY(event)">  
                        @csrf
                        <input type="hidden" name="total_amount" value="{{$subtotal}}">
                        <input type="hidden" name="order_id" id="vnpay-order-id" value="">
                        <button style='width: 216px;' name="redirect" type="submit" class="bg-white border border-gray-200 hover:bg-gray-50 text-[#005ba4] py-3 rounded text-[13px] font-bold hover:scale-[1.03] active:scale-95 transition transform duration-200 flex items-center justify-center shadow-md">
                            <img src="https://sandbox.vnpayment.vn/paymentv2/Images/brands/logo.svg" alt="VNPAY" class="h-4.5 object-contain">
                        </button>
                    </form>
                    <button class="bg-[#1e40af] text-white py-2 rounded flex flex-col items-center justify-center hover:bg-blue-800 hover:scale-[1.03] active:scale-95 transition transform duration-200 shadow-md leading-tight">
                        <div class="flex items-center text-[12px] font-bold mb-0.5"><i class="far fa-credit-card mr-1.5"></i> TRẢ GÓP QUA HỒ SƠ</div>
                        <div class="text-[9px] font-medium opacity-90">CHỈ TỪ {{ number_format(round($subtotal / 12), 0, ',', '.') }} Đ/THÁNG</div>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Features Section (From Homepage) -->
    <section class="bg-white py-10 rounded-lg mb-8 border border-gray-100 shadow-sm">
        <div class="container mx-auto px-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12 text-center divide-y md:divide-y-0 md:divide-x divide-gray-200 border-b border-gray-100 pb-10">
                <div class="px-4 py-4 md:py-0">
                    <i class="fas fa-truck text-4xl text-primary mb-4"></i>
                    <h4 class="font-bold text-gray-800 uppercase text-sm mb-1">GIAO HÀNG TOÀN QUỐC</h4>
                    <p class="text-xs text-gray-500">Giao hàng trước, trả tiền sau COD</p>
                </div>
                <div class="px-4 py-4 md:py-0">
                    <i class="fas fa-sync-alt text-4xl text-primary mb-4"></i>
                    <h4 class="font-bold text-gray-800 uppercase text-sm mb-1">ĐỔI TRẢ DỄ DÀNG</h4>
                    <p class="text-xs text-gray-500">Đổi mới trong 30 ngày đầu</p>
                </div>
                <div class="px-4 py-4 md:py-0">
                    <i class="fas fa-credit-card text-4xl text-primary mb-4"></i>
                    <h4 class="font-bold text-gray-800 uppercase text-sm mb-1">THANH TOÁN TIỆN LỢI</h4>
                    <p class="text-xs text-gray-500">Trả tiền mặt, chuyển khoản, trả góp 0%</p>
                </div>
                <div class="px-4 py-4 md:py-0">
                    <i class="fas fa-headset text-4xl text-primary mb-4"></i>
                    <h4 class="font-bold text-gray-800 uppercase text-sm mb-1">HỖ TRỢ NHIỆT TÌNH</h4>
                    <p class="text-xs text-gray-500">Tư vấn tổng đài miễn phí 24/7</p>
                </div>
            </div>

            <div class="text-center mb-8">
                <p class="text-gray-800 font-semibold mb-1">Trải nghiệm mua sắm tại <span class="text-primary font-bold">SPATACUS</span></p>
                <h2 class="text-4xl font-bold mt-2">Cam Kết 100% <span class="text-primary">Hài Lòng</span></h2>
            </div>

            <div class="max-w-4xl mx-auto space-y-3">
                <div class="border border-gray-200 p-4 rounded-lg flex justify-between items-center bg-gray-50 hover:bg-gray-100 cursor-pointer transition shadow-sm group">
                    <span class="font-semibold text-sm text-gray-800 group-hover:text-primary transition">1. Liên hệ chăm sóc khách hàng dễ dàng</span>
                    <i class="fas fa-plus text-gray-500 group-hover:text-primary transition"></i>
                </div>
                <div class="border border-gray-200 p-4 rounded-lg flex justify-between items-center bg-gray-50 hover:bg-gray-100 cursor-pointer transition shadow-sm group">
                    <span class="font-semibold text-sm text-gray-800 group-hover:text-primary transition">2. Giao hàng nhanh trong 2 giờ mà không thu thêm phí</span>
                    <i class="fas fa-plus text-gray-500 group-hover:text-primary transition"></i>
                </div>
                <div class="border border-gray-200 p-4 rounded-lg flex justify-between items-center bg-gray-50 hover:bg-gray-100 cursor-pointer transition shadow-sm group">
                    <span class="font-semibold text-sm text-gray-800 group-hover:text-primary transition">3. Miễn phí lên đời và trải nghiệm sản phẩm trong vòng 15 ngày</span>
                    <i class="fas fa-plus text-gray-500 group-hover:text-primary transition"></i>
                </div>
                <div class="border border-gray-200 p-4 rounded-lg flex justify-between items-center bg-gray-50 hover:bg-gray-100 cursor-pointer transition shadow-sm group">
                    <span class="font-semibold text-sm text-gray-800 group-hover:text-primary transition">4. Cam kết thu cũ đổi mới trọn đời với tất cả các sản phẩm Laptop chính hãng</span>
                    <i class="fas fa-plus text-gray-500 group-hover:text-primary transition"></i>
                </div>
                <div class="border border-gray-200 p-4 rounded-lg flex justify-between items-center bg-gray-50 hover:bg-gray-100 cursor-pointer transition shadow-sm group">
                    <span class="font-semibold text-sm text-gray-800 group-hover:text-primary transition">5. Cho mượn sản phẩm miễn phí thay thế trong thời gian bảo hành tại SPATACUS</span>
                    <i class="fas fa-plus text-gray-500 group-hover:text-primary transition"></i>
                </div>
            </div>
        </div>
    </section>
 
    <!-- QR Payment Modal (Hidden by default) -->
    <div id="qr-payment-modal" class="fixed inset-0 z-[9999] hidden flex items-center justify-center p-4">
        <!-- Backdrop -->
        <div onclick="cancelQRPayment()" class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity duration-300"></div>
        
        <!-- Modal Content -->
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full overflow-hidden border border-gray-100 relative z-10 transform scale-95 opacity-0 transition-all duration-300">
            
            <!-- Standard Payment Layout -->
            <div id="qr-standard-layout" class="flex flex-col md:flex-row">
                <!-- Left Side: QR Code -->
                <div class="w-full md:w-1/2 bg-gray-50 p-6 flex flex-col items-center justify-center border-b md:border-b-0 md:border-r border-gray-100">
                    <div class="text-center mb-4">
                        <h3 class="text-lg font-bold text-gray-800 uppercase tracking-wide">Mã QR Thanh Toán</h3>
                        <p class="text-[10px] text-gray-500 font-medium">Sử dụng App Ngân hàng quét mã VietQR</p>
                    </div>
                    
                    <!-- QR Frame with scanning animation -->
                    <div class="relative bg-white p-4 rounded-xl border border-gray-200 shadow-inner group">
                        <div class="absolute inset-0 border-2 border-primary rounded-xl opacity-20 group-hover:opacity-40 transition-opacity duration-300 pointer-events-none"></div>
                        <!-- VietQR Image -->
                        <img id="vietqr-img" src="" alt="VietQR Payment" class="w-48 h-48 object-contain">
                    </div>
                    
                    <!-- Status & Indicator -->
                    <div class="flex items-center gap-2 mt-4 text-xs font-semibold text-gray-600 bg-white px-3 py-1.5 rounded-full border border-gray-200">
                        <span class="w-2 h-2 rounded-full bg-green-500 animate-ping"></span>
                        <span>Hệ thống đang tự động kiểm tra...</span>
                    </div>
                </div>
                
                <!-- Right Side: Transfer details -->
                <div class="w-full md:w-1/2 p-6 flex flex-col justify-between relative">
                    <button onclick="cancelQRPayment()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                    
                    <div>
                        <h4 class="text-base font-bold text-gray-800 mb-3 pb-2 border-b border-gray-100">Thông tin chuyển khoản</h4>
                        
                        <!-- Countdown Timer -->
                        <div class="flex items-center justify-between mb-3 bg-orange-50/50 p-2.5 rounded-lg border border-orange-100">
                            <span class="text-xs text-orange-600 font-bold flex items-center"><i class="far fa-clock mr-1.5 text-sm"></i> Hạn thanh toán:</span>
                            <span id="qr-timer" class="text-sm font-black text-orange-600 font-mono">10:00</span>
                        </div>
                        
                        <!-- Realtime Testing Area (For testing simulator) -->
                        <div class="mb-3 bg-blue-50/50 p-2.5 rounded-lg border border-blue-100 text-center flex flex-col items-center justify-center">
                            <p class="text-[9px] text-blue-700 font-bold mb-1"><i class="fas fa-flask mr-1"></i> KHU VỰC THỬ NGHIỆM REALTIME QR</p>
                            <button onclick="triggerSimulatedPayment()" type="button" class="bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-bold px-2.5 py-1 rounded transition shadow-sm flex items-center justify-center">
                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-400 mr-1.5 animate-ping"></span> Giả lập quét mã thanh toán thành công
                            </button>
                        </div>
                        
                        <!-- Bank Fields -->
                        <div class="space-y-2 text-xs">
                            <div class="flex justify-between items-center bg-gray-50 p-2 rounded border border-gray-100">
                                <div>
                                    <p class="text-[9px] text-gray-400 font-medium">Ngân hàng</p>
                                    <p class="font-bold text-gray-800">MBBank (Ngân hàng Quân Đội)</p>
                                </div>
                                <img src="https://img.vietqr.io/image/mbbank-logo.png" alt="MBBank Logo" class="h-5 object-contain opacity-80">
                            </div>
                            <div class="flex justify-between items-center bg-gray-50 p-2 rounded border border-gray-100">
                                <div>
                                    <p class="text-[9px] text-gray-400 font-medium">Số tài khoản</p>
                                    <p id="qr-acc-no" class="font-bold text-gray-800 font-mono text-sm">0986552233</p>
                                </div>
                                <button onclick="copyToClipboard('0986552233', 'Số tài khoản')" class="text-blue-600 hover:text-blue-800 text-[10px] font-bold hover:underline">
                                    <i class="far fa-copy mr-1"></i> Sao chép
                                </button>
                            </div>
                            <div class="bg-gray-50 p-2 rounded border border-gray-100">
                                <p class="text-[9px] text-gray-400 font-medium">Chủ tài khoản</p>
                                <p class="font-bold text-gray-800">CÔNG TY CỔ PHẦN CÔNG NGHỆ SPATACUS</p>
                            </div>
                            <div class="bg-gray-50 p-2 rounded border border-gray-100">
                                <p class="text-[9px] text-gray-400 font-medium">Số tiền</p>
                                <p id="qr-amount-formatted" class="font-black text-primary text-sm"></p>
                            </div>
                            <div class="flex justify-between items-center bg-gray-50 p-2 rounded border border-gray-100">
                                <div>
                                    <p class="text-[9px] text-gray-400 font-medium">Nội dung chuyển khoản</p>
                                    <p id="qr-desc" class="font-bold text-gray-800 font-mono text-xs text-primary"></p>
                                </div>
                                <button id="btn-copy-desc" onclick="copyTransferDesc()" class="text-blue-600 hover:text-blue-800 text-[10px] font-bold hover:underline">
                                    <i class="far fa-copy mr-1"></i> Sao chép
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons in Modal -->
                    <div class="mt-4 space-y-1.5">
                        <button onclick="confirmQRPayment()" class="w-full bg-green-600 text-white py-2.5 rounded-lg text-xs font-bold hover:bg-green-700 hover:scale-[1.01] active:scale-95 transition transform duration-200 flex items-center justify-center shadow">
                            <i class="fas fa-check-circle mr-2 text-sm"></i> TÔI ĐÃ CHUYỂN KHOẢN THÀNH CÔNG
                        </button>
                        <button onclick="cancelQRPayment()" class="w-full bg-gray-100 text-gray-600 py-2 rounded-lg text-xs font-bold hover:bg-gray-200 transition">
                            HỦY GIAO DỊCH
                        </button>
                    </div>
                </div>
            </div>

            <!-- Success Payment Layout (Hidden by default) -->
            <div id="qr-success-layout" class="hidden flex flex-col items-center justify-center p-8 text-center bg-white min-h-[400px]">
                <!-- Checkmark Animation -->
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center text-green-500 mb-6 scale-0 transition-transform duration-500 shadow-lg border border-green-200" id="success-checkmark">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-green-600 mb-2 uppercase tracking-wide">Thanh Toán Thành Công!</h3>
                <p class="text-sm text-gray-600 font-bold max-w-md leading-relaxed mb-6">
                    Hệ thống đã nhận được tiền của Đơn hàng <strong class="text-teal-600 font-extrabold" id="success-order-id">#</strong>. Cảm ơn quý khách đã mua sắm tại SPATACUS!
                </p>
                
                <div class="flex items-center gap-2 text-xs font-semibold text-gray-500 bg-gray-50 px-4 py-2 rounded-full border border-gray-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-teal-500 animate-ping"></span>
                    <span>Đang tự động chuyển hướng về trang lịch sử đơn hàng sau <strong class="text-teal-600 font-bold" id="success-countdown">3</strong> giây...</span>
                </div>
            </div>
            
        </div>
    </div>
@endsection

@section('scripts')
<script>
    let qrTimerInterval = null;

    // Kiểm tra thông tin người mua, tự động tạo đơn hàng vào database và chuyển hướng sang VNPAY
    function validateVNPAY(e) {
        const nameInput = document.getElementById('name');
        const phoneInput = document.getElementById('phone');
        const emailInput = document.getElementById('email');
        const addressInput = document.getElementById('address_detail');
        const provinceInput = document.getElementById('province');
        const districtInput = document.getElementById('district');
        const agreeTermsInput = document.getElementById('agree-terms');

        if (!nameInput?.value.trim() || !phoneInput?.value.trim() || !emailInput?.value.trim() || !addressInput?.value.trim() || !provinceInput?.value || !districtInput?.value) {
            e.preventDefault();
            showToast('Vui lòng nhập đầy đủ thông tin người mua hàng trước khi thanh toán qua VNPAY.', 'error');
            nameInput?.scrollIntoView({ behavior: 'smooth', block: 'center' });
            nameInput?.focus();
            return false;
        }

        if (agreeTermsInput && !agreeTermsInput.checked) {
            e.preventDefault();
            showToast('Bạn cần tích chọn đồng ý với Điều kiện giao dịch chung để tiếp tục.', 'error');
            agreeTermsInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
            
            const labelGroup = agreeTermsInput.parentElement;
            labelGroup.classList.add('scale-105', 'text-red-600', 'transition-all', 'duration-300');
            setTimeout(() => {
                labelGroup.classList.remove('scale-105', 'text-red-600');
            }, 1200);
            return false;
        }

        const vnpayOrderIdInput = document.getElementById('vnpay-order-id');
        if (vnpayOrderIdInput && vnpayOrderIdInput.value === '') {
            e.preventDefault(); // Chặn việc submit form ban đầu để gửi AJAX tạo đơn hàng trước
            
            showToast('Đang khởi tạo đơn hàng và kết nối VNPAY...', 'success');

            const checkoutForm = document.getElementById('checkout-form');
            const formData = new FormData(checkoutForm);
            
            // Đính kèm ghi chú "[Thanh toán VNPAY]" vào ghi chú đơn hàng gửi lên server
            const noteInput = document.getElementById('note');
            if (noteInput) {
                formData.set('note', `[Thanh toán VNPAY] ` + noteInput.value);
            }

            fetch('{{ route("checkout.create.ajax") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Máy chủ phản hồi lỗi.');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Đặt ID đơn hàng thật vừa tạo vào input vnpay-order-id
                    vnpayOrderIdInput.value = data.order_id;
                    
                    // Thực hiện submit form VNPAY chính thức
                    document.getElementById('vnpay-form').submit();
                } else {
                    showToast(data.error || 'Có lỗi xảy ra khi tạo đơn hàng.', 'error');
                }
            })
            .catch(error => {
                console.error('Lỗi khởi tạo đơn hàng:', error);
                showToast('Không thể kết nối máy chủ để khởi tạo đơn hàng.', 'error');
            });

            return false;
        }

        return true;
    }

    let currentOrderId = null;
    let qrPollInterval = null;

    // Mở Modal thanh toán bằng QR code
    function openQRModal() {
        const nameInput = document.getElementById('name');
        const phoneInput = document.getElementById('phone');
        const emailInput = document.getElementById('email');
        const addressInput = document.getElementById('address_detail');
        const provinceInput = document.getElementById('province');
        const districtInput = document.getElementById('district');
        const agreeTermsInput = document.getElementById('agree-terms');

        if (!nameInput?.value.trim() || !phoneInput?.value.trim() || !emailInput?.value.trim() || !addressInput?.value.trim() || !provinceInput?.value || !districtInput?.value) {
            showToast('Vui lòng nhập đầy đủ thông tin người mua hàng trước khi thực hiện thanh toán.', 'error');
            nameInput?.scrollIntoView({ behavior: 'smooth', block: 'center' });
            nameInput?.focus();
            return;
        }

        if (agreeTermsInput && !agreeTermsInput.checked) {
            showToast('Bạn cần tích chọn đồng ý với Điều kiện giao dịch chung để tiếp tục.', 'error');
            agreeTermsInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
            
            const labelGroup = agreeTermsInput.parentElement;
            labelGroup.classList.add('scale-105', 'text-red-600', 'transition-all', 'duration-300');
            setTimeout(() => {
                labelGroup.classList.remove('scale-105', 'text-red-600');
            }, 1200);
            return;
        }

        showToast('Đang khởi tạo đơn hàng thanh toán QR...', 'success');

        // Tạo đơn hàng qua AJAX trước
        const checkoutForm = document.getElementById('checkout-form');
        const formData = new FormData(checkoutForm);
        const noteInput = document.getElementById('note');
        if (noteInput) {
            formData.set('note', `[Thanh toán QR] ` + noteInput.value);
        }

        fetch('{{ route("checkout.create.ajax") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Không thể khởi tạo đơn hàng.');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                currentOrderId = data.order_id;
                const subtotal = {{ $subtotal }};
                const desc = `SPATACUS DH${currentOrderId}`;

                document.getElementById('qr-amount-formatted').innerText = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(subtotal);
                document.getElementById('qr-desc').innerText = desc;

                const bankId = 'mbbank';
                const accountNo = '0986552233';
                const template = 'compact2';
                const accountName = encodeURIComponent('CONG TY CO PHAN CONG NGHE SPATACUS');
                
                const vietQRUrl = `https://img.vietqr.io/image/${bankId}-${accountNo}-${template}.png?amount=${subtotal}&addInfo=${encodeURIComponent(desc)}&accountName=${accountName}`;
                
                document.getElementById('vietqr-img').src = vietQRUrl;

                // Đảm bảo ẩn success và hiển thị standard layout
                document.getElementById('qr-standard-layout').classList.remove('hidden');
                document.getElementById('qr-success-layout').classList.add('hidden');
                document.getElementById('success-checkmark').classList.remove('scale-100');
                document.getElementById('success-checkmark').classList.add('scale-0');

                const modal = document.getElementById('qr-payment-modal');
                const modalContent = modal.querySelector('.bg-white');
                
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modalContent.classList.remove('scale-95', 'opacity-0');
                    modalContent.classList.add('scale-100', 'opacity-100');
                }, 50);

                startQRCountdown(10 * 60);
                
                // Khởi động tiến trình Long-polling kiểm tra thanh toán
                startPaymentPolling(currentOrderId);
            } else {
                showToast(data.error || 'Có lỗi xảy ra khi tạo đơn hàng.', 'error');
            }
        })
        .catch(error => {
            console.error('Lỗi khởi tạo đơn hàng QR:', error);
            showToast('Không thể kết nối máy chủ để khởi tạo đơn hàng.', 'error');
        });
    }

    // Đóng Modal thanh toán
    function closeQRModal() {
        const modal = document.getElementById('qr-payment-modal');
        if (!modal) return;
        
        const modalContent = modal.querySelector('.bg-white');
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            if (qrTimerInterval) clearInterval(qrTimerInterval);
            if (qrPollInterval) clearInterval(qrPollInterval);
        }, 300);
    }

    // Hủy đơn hàng và khôi phục giỏ hàng qua AJAX
    function cancelQRPayment() {
        if (!currentOrderId) {
            closeQRModal();
            return;
        }

        if (!confirm('Bạn có chắc chắn muốn hủy giao dịch này không?\nĐơn hàng sẽ bị hủy và giỏ hàng của bạn sẽ được khôi phục.')) return;

        showToast('Đang hủy giao dịch và khôi phục giỏ hàng...', 'success');

        fetch(`{{ url('checkout/cancel-order') }}/${currentOrderId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Lỗi từ phía máy chủ.');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                // Tắt polling và timer
                clearInterval(qrPollInterval);
                if (qrTimerInterval) clearInterval(qrTimerInterval);
                
                closeQRModal();

                // Reload lại trang để tải lại giỏ hàng đã được khôi phục
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                showToast(data.error || 'Có lỗi xảy ra khi hủy giao dịch.', 'error');
            }
        })
        .catch(err => {
            console.error('Lỗi khi hủy đơn hàng:', err);
            showToast('Không thể kết nối máy chủ để hủy giao dịch.', 'error');
        });
    }

    // Bộ đếm ngược thời gian
    function startQRCountdown(durationSeconds) {
        if (qrTimerInterval) clearInterval(qrTimerInterval);
        
        const timerElement = document.getElementById('qr-timer');
        let timeLeft = durationSeconds;
        
        function updateTimerDisplay() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerElement.innerText = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }
        
        updateTimerDisplay();
        
        qrTimerInterval = setInterval(() => {
            timeLeft--;
            if (timeLeft <= 0) {
                clearInterval(qrTimerInterval);
                timerElement.innerText = "Hết hạn";
                showToast('Giao dịch chuyển khoản đã hết hiệu lực. Vui lòng tạo mã QR mới.', 'error');
                closeQRModal();
            } else {
                updateTimerDisplay();
            }
        }, 1000);
    }

    // Xử lý khi thanh toán thành công (được gọi từ WebSocket hoặc Polling dự phòng)
    function handlePaymentSuccess(orderId) {
        // Dừng tiến trình polling và timer
        if (qrPollInterval) clearInterval(qrPollInterval);
        if (qrTimerInterval) clearInterval(qrTimerInterval);
        
        if (window.Echo) {
            window.Echo.leave('order.' + orderId);
        }

        // Hiển thị giao diện thành công và hiệu ứng checkmark
        document.getElementById('qr-standard-layout').classList.add('hidden');
        document.getElementById('success-order-id').innerText = '#' + orderId;
        
        const successLayout = document.getElementById('qr-success-layout');
        if (successLayout) {
            successLayout.classList.remove('hidden');
        }
        
        // Phát âm thanh chime thành công
        try {
            const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            const osc = audioCtx.createOscillator();
            const gain = audioCtx.createGain();
            osc.connect(gain);
            gain.connect(audioCtx.destination);
            osc.type = 'sine';
            osc.frequency.setValueAtTime(523.25, audioCtx.currentTime); // C5
            osc.frequency.setValueAtTime(659.25, audioCtx.currentTime + 0.15); // E5
            osc.frequency.setValueAtTime(783.99, audioCtx.currentTime + 0.3); // G5
            gain.gain.setValueAtTime(0.1, audioCtx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.6);
            osc.start();
            osc.stop(audioCtx.currentTime + 0.6);
        } catch (e) {
            console.log('Chime sound not supported or blocked by browser.');
        }

        setTimeout(() => {
            const checkmark = document.getElementById('success-checkmark');
            if (checkmark) {
                checkmark.classList.remove('scale-0');
                checkmark.classList.add('scale-100');
            }
        }, 100);

        // Đếm ngược 3 giây để chuyển hướng
        let countdown = 3;
        const countdownEl = document.getElementById('success-countdown');
        const countdownInterval = setInterval(() => {
            countdown--;
            if (countdownEl) countdownEl.innerText = countdown;
            if (countdown <= 0) {
                clearInterval(countdownInterval);
                window.location.href = '{{ route("order.history") }}';
            }
        }, 1000);
    }

    // Lắng nghe cập nhật thanh toán đơn hàng (Ưu tiên WebSocket, dự phòng Polling)
    function startPaymentPolling(orderId) {
        if (qrPollInterval) clearInterval(qrPollInterval);

        // 1. Đăng ký kênh WebSocket lắng nghe sự kiện thay đổi trạng thái
        if (window.Echo) {
            console.log('Đang lắng nghe WebSocket cho Đơn hàng #' + orderId);
            window.Echo.channel('order.' + orderId)
                .listen('.OrderStatusUpdated', (e) => {
                    console.log('WebSocket Event nhận được:', e);
                    if (e.status == 2) {
                        handlePaymentSuccess(orderId);
                    }
                });
        }

        // 2. Chạy Polling song song làm cơ chế dự phòng (tần suất 4 giây)
        qrPollInterval = setInterval(() => {
            fetch(`{{ url('checkout/check-status') }}/${orderId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Lỗi truy vấn.');
                return response.json();
            })
            .then(data => {
                if (data.paid) {
                    handlePaymentSuccess(orderId);
                }
            })
            .catch(error => {
                console.warn('Lỗi kiểm tra thanh toán (Polling dự phòng):', error);
            });
        }, 4000);
    }

    // Giả lập quét mã thanh toán thành công (Cho Test)
    function triggerSimulatedPayment() {
        if (!currentOrderId) {
            showToast('Không tìm thấy đơn hàng để giả lập.', 'error');
            return;
        }

        showToast('Đang gửi tín hiệu giả lập thanh toán ngân hàng...', 'success');

        fetch(`{{ url('checkout/simulate-payment') }}/${currentOrderId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
            } else {
                showToast(data.error || data.message || 'Lỗi giả lập thanh toán.', 'error');
            }
        })
        .catch(err => {
            console.error('Lỗi giả lập:', err);
            showToast('Không thể gửi yêu cầu giả lập đến server.', 'error');
        });
    }

    // Sao chép nội dung vào Clipboard
    function copyToClipboard(text, fieldName) {
        navigator.clipboard.writeText(text).then(() => {
            showToast(`Đã sao chép ${fieldName} thành công!`, 'success');
        }).catch(err => {
            console.error('Lỗi sao chép:', err);
            showToast('Không thể sao chép tự động. Vui lòng tự sao chép thủ công.', 'error');
        });
    }

    // Sao chép nội dung chuyển khoản nhanh
    function copyTransferDesc() {
        const descText = document.getElementById('qr-desc').innerText;
        copyToClipboard(descText, 'Nội dung chuyển khoản');
    }

    // Xác nhận đã thanh toán thành công và tự động submit đơn hàng
    function confirmQRPayment() {
        if (!confirm('Bạn có chắc chắn đã thực hiện chuyển khoản thành công?\nChúng tôi sẽ xác minh giao dịch ngay sau khi nhận được thông tin từ Ngân hàng.')) return;
        
        // Gọi giả lập thanh toán trực tiếp để đồng bộ nhanh
        triggerSimulatedPayment();
    }

    // In báo giá chi tiết sản phẩm kèm thông tin người mua hàng
    function printQuotation() {
        const name = encodeURIComponent(document.getElementById('name')?.value || '');
        const phone = encodeURIComponent(document.getElementById('phone')?.value || '');
        const email = encodeURIComponent(document.getElementById('email')?.value || '');
        const address = encodeURIComponent(document.getElementById('address_detail')?.value || '');
        const province = encodeURIComponent(document.getElementById('province')?.value || '');
        const district = encodeURIComponent(document.getElementById('district')?.value || '');
        
        const printUrl = '{{ route("cart.print") }}' + 
            `?name=${name}&phone=${phone}&email=${email}&address=${address}&province=${province}&district=${district}`;
        
        window.open(printUrl, '_blank');
    }

    // Cập nhật số lượng qua AJAX
    function updateQty(key, amount) {
        const qtyInput = document.getElementById('qty-input-' + key);
        if (!qtyInput) return;

        let currentQty = parseInt(qtyInput.value) || 1;
        let newQty = currentQty + amount;
        if (newQty < 1) return; // Không cho phép nhỏ hơn 1

        // Thay đổi tạm thời trên UI trước
        qtyInput.value = newQty;

        const formData = new FormData();
        formData.append('key', key);
        formData.append('quantity', newQty);
        formData.append('_token', '{{ csrf_token() }}');

        fetch('{{ route("cart.update") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Mạng lỗi.');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Cập nhật thành tiền của dòng sản phẩm đó
                const itemTotal = document.getElementById('item-total-' + key);
                if (itemTotal) {
                    itemTotal.innerText = data.item_total_formatted;
                }

                // Cập nhật phần tổng cộng ở sidebar
                const summarySubtotal = document.getElementById('summary-subtotal');
                if (summarySubtotal) {
                    summarySubtotal.innerText = data.subtotal_formatted;
                }

                const summaryTotal = document.getElementById('summary-total');
                if (summaryTotal) {
                    summaryTotal.innerText = data.subtotal_formatted;
                }

                // Cập nhật badge giỏ hàng trên header
                const badge = document.getElementById('cart-badge');
                if (badge) {
                    badge.innerText = data.total_items;
                    if (data.total_items > 0) {
                        badge.classList.remove('hidden');
                    } else {
                        badge.classList.add('hidden');
                    }
                }
            } else {
                showToast(data.error || 'Có lỗi xảy ra khi cập nhật.', 'error');
                qtyInput.value = currentQty; // Phục hồi lại số lượng cũ
            }
        })
        .catch(error => {
            console.error('Lỗi cập nhật giỏ hàng:', error);
            showToast('Không thể kết nối đến máy chủ.', 'error');
            qtyInput.value = currentQty; // Phục hồi lại số lượng cũ
        });
    }

    // Xóa một sản phẩm qua AJAX
    function removeItem(key) {
        if (!confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) return;

        const formData = new FormData();
        formData.append('key', key);
        formData.append('_token', '{{ csrf_token() }}');

        fetch('{{ route("cart.remove") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Mạng lỗi.');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Hiệu ứng mờ dần rồi xóa hàng trong bảng
                const row = document.getElementById('cart-row-' + key);
                if (row) {
                    row.classList.add('opacity-0');
                    row.style.transition = 'all 0.3s ease';
                    setTimeout(() => {
                        row.remove();
                        // Nếu giỏ hàng trống hoàn toàn, reload trang để vẽ lại giao diện trống
                        if (data.total_items === 0) {
                            window.location.reload();
                        }
                    }, 300);
                }

                // Cập nhật lại tổng tiền ở sidebar
                const summarySubtotal = document.getElementById('summary-subtotal');
                if (summarySubtotal) {
                    summarySubtotal.innerText = data.subtotal_formatted;
                }

                const summaryTotal = document.getElementById('summary-total');
                if (summaryTotal) {
                    summaryTotal.innerText = data.subtotal_formatted;
                }

                // Cập nhật số lượng badge
                const badge = document.getElementById('cart-badge');
                if (badge) {
                    badge.innerText = data.total_items;
                    if (data.total_items > 0) {
                        badge.classList.remove('hidden');
                    } else {
                        badge.classList.add('hidden');
                    }
                }

                showToast('Đã xóa sản phẩm khỏi giỏ hàng.', 'success');
            } else {
                showToast(data.error || 'Có lỗi xảy ra khi xóa.', 'error');
            }
        })
        .catch(error => {
            console.error('Lỗi xóa sản phẩm:', error);
            showToast('Không thể kết nối đến máy chủ.', 'error');
        });
    }

    // Xóa toàn bộ giỏ hàng
    function clearCart(buttonElement) {
        if (!confirm('Bạn có chắc chắn muốn xóa toàn bộ giỏ hàng?')) return;

        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');

        fetch('{{ route("cart.clear") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Mạng lỗi.');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                showToast(data.error || 'Có lỗi xảy ra.', 'error');
            }
        })
        .catch(error => {
            console.error('Lỗi khi làm trống giỏ hàng:', error);
            showToast('Không thể kết nối đến máy chủ.', 'error');
        });
    }

    // Tự động tải danh sách Tỉnh/Thành phố và Quận/Huyện mới nhất từ API
    document.addEventListener("DOMContentLoaded", function() {
        // Validate checkbox đồng ý điều khoản trước khi đặt hàng
        const checkoutForm = document.getElementById('checkout-form');
        if (checkoutForm) {
            checkoutForm.addEventListener('submit', function(e) {
                const agreeTerms = document.getElementById('agree-terms');
                if (agreeTerms && !agreeTerms.checked) {
                    e.preventDefault();
                    showToast('Vui lòng tích chọn đồng ý với Điều kiện giao dịch chung để đặt hàng.', 'error');
                    
                    // Cuộn mượt tới checkbox điều khoản
                    agreeTerms.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    
                    // Thêm hiệu ứng lắc nhẹ gây chú ý cho người dùng
                    const labelGroup = agreeTerms.parentElement;
                    labelGroup.classList.add('scale-105', 'text-red-600', 'transition-all', 'duration-300');
                    setTimeout(() => {
                        labelGroup.classList.remove('scale-105', 'text-red-600');
                    }, 1200);
                }
            });
        }

        const provinceSelect = document.getElementById('province');
        const districtSelect = document.getElementById('district');

        if (!provinceSelect || !districtSelect) return;

        // Tải danh sách Tỉnh/Thành phố
        fetch('https://esgoo.net/api-tinhthanh/1/0.htm')
            .then(response => response.json())
            .then(data => {
                if (data.error === 0) {
                    let html = '<option value="">Chọn Tỉnh/Thành phố</option>';
                    data.data.forEach(item => {
                        html += `<option value="${item.full_name}" data-id="${item.id}">${item.full_name}</option>`;
                    });
                    provinceSelect.innerHTML = html;
                } else {
                    throw new Error('API return error');
                }
            })
            .catch(error => {
                console.error('Lỗi tải danh sách tỉnh thành, chuyển sang fallback:', error);
                // Danh sách 63 tỉnh thành Việt Nam mới nhất làm dự phòng (fallback) để luôn hoạt động ngay cả khi mất mạng hoặc API lỗi
                const fallbackProvinces = [
                    { id: "01", name: "Thành phố Hà Nội" },
                    { id: "79", name: "Thành phố Hồ Chí Minh" },
                    { id: "48", name: "Thành phố Đà Nẵng" },
                    { id: "31", name: "Thành phố Hải Phòng" },
                    { id: "92", name: "Thành phố Cần Thơ" },
                    { id: "74", name: "Tỉnh Bình Dương" },
                    { id: "75", name: "Tỉnh Đồng Nai" },
                    { id: "77", name: "Tỉnh Bà Rịa - Vũng Tàu" },
                    { id: "91", name: "Tỉnh Kiên Giang" },
                    { id: "93", name: "Tỉnh Hậu Giang" },
                    { id: "94", name: "Tỉnh Sóc Trăng" },
                    { id: "95", name: "Tỉnh Bạc Liêu" },
                    { id: "96", name: "Tỉnh Cà Mau" },
                    { id: "80", name: "Tỉnh Long An" },
                    { id: "82", name: "Tỉnh Tiền Giang" },
                    { id: "83", name: "Tỉnh Bến Tre" },
                    { id: "84", name: "Tỉnh Trà Vinh" },
                    { id: "86", name: "Tỉnh Vĩnh Long" },
                    { id: "87", name: "Tỉnh Đồng Tháp" },
                    { id: "89", name: "Tỉnh An Giang" },
                    { id: "70", name: "Tỉnh Tây Ninh" },
                    { id: "72", name: "Tỉnh Bình Phước" },
                    { id: "68", name: "Tỉnh Lâm Đồng" },
                    { id: "67", name: "Tỉnh Đắk Nông" },
                    { id: "66", name: "Tỉnh Đắk Lắk" },
                    { id: "64", name: "Tỉnh Gia Lai" },
                    { id: "62", name: "Tỉnh Kon Tum" },
                    { id: "60", name: "Tỉnh Bình Thuận" },
                    { id: "58", name: "Tỉnh Ninh Thuận" },
                    { id: "56", name: "Tỉnh Khánh Hòa" },
                    { id: "54", name: "Tỉnh Phú Yên" },
                    { id: "52", name: "Tỉnh Bình Định" },
                    { id: "51", name: "Tỉnh Quảng Ngãi" },
                    { id: "49", name: "Tỉnh Quảng Nam" },
                    { id: "46", name: "Tỉnh Thừa Thiên Huế" },
                    { id: "45", name: "Tỉnh Quảng Trị" },
                    { id: "44", name: "Tỉnh Quảng Bình" },
                    { id: "42", name: "Tỉnh Hà Tĩnh" },
                    { id: "40", name: "Tỉnh Nghệ An" },
                    { id: "38", name: "Tỉnh Thanh Hóa" },
                    { id: "37", name: "Tỉnh Ninh Bình" },
                    { id: "36", name: "Tỉnh Nam Định" },
                    { id: "35", name: "Tỉnh Hà Nam" },
                    { id: "34", name: "Tỉnh Thái Bình" },
                    { id: "33", name: "Tỉnh Hưng Yên" },
                    { id: "30", name: "Tỉnh Hải Dương" },
                    { id: "27", name: "Tỉnh Bắc Ninh" },
                    { id: "26", name: "Tỉnh Vĩnh Phúc" },
                    { id: "25", name: "Tỉnh Phú Thọ" },
                    { id: "24", name: "Tỉnh Bắc Giang" },
                    { id: "22", name: "Tỉnh Quảng Ninh" },
                    { id: "20", name: "Tỉnh Lạng Sơn" },
                    { id: "19", name: "Tỉnh Thái Nguyên" },
                    { id: "17", name: "Tỉnh Tuyên Quang" },
                    { id: "15", name: "Tỉnh Yên Bái" },
                    { id: "14", name: "Tỉnh Hòa Bình" },
                    { id: "12", name: "Tỉnh Lai Châu" },
                    { id: "11", name: "Tỉnh Điện Biên" },
                    { id: "10", name: "Tỉnh Sơn La" },
                    { id: "08", name: "Tỉnh Tuyên Quang" },
                    { id: "06", name: "Tỉnh Bắc Kạn" },
                    { id: "04", name: "Tỉnh Cao Bằng" },
                    { id: "02", name: "Tỉnh Hà Giang" }
                ];
                let html = '<option value="">Chọn Tỉnh/Thành phố</option>';
                fallbackProvinces.sort((a, b) => a.name.localeCompare(b.name, 'vi')).forEach(item => {
                    html += `<option value="${item.name}" data-id="${item.id}">${item.name}</option>`;
                });
                provinceSelect.innerHTML = html;
            });

        // Lắng nghe sự kiện thay đổi Tỉnh/Thành phố
        provinceSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const provinceId = selectedOption ? selectedOption.getAttribute('data-id') : '';

            // Reset dropdown Quận/Huyện
            districtSelect.innerHTML = '<option value="">Chọn Quận/Huyện</option>';
            
            if (!provinceId) {
                districtSelect.disabled = true;
                districtSelect.classList.add('bg-gray-50', 'cursor-not-allowed');
                districtSelect.classList.remove('bg-white');
                return;
            }

            // Kích hoạt dropdown Quận/Huyện
            districtSelect.disabled = false;
            districtSelect.classList.remove('bg-gray-50', 'cursor-not-allowed');
            districtSelect.classList.add('bg-white');

            // Tải danh sách Quận/Huyện dựa trên ID Tỉnh/Thành phố đã chọn
            fetch(`https://esgoo.net/api-tinhthanh/2/${provinceId}.htm`)
                .then(response => response.json())
                .then(data => {
                    if (data.error === 0) {
                        let html = '<option value="">Chọn Quận/Huyện</option>';
                        data.data.forEach(item => {
                            html += `<option value="${item.full_name}">${item.full_name}</option>`;
                        });
                        districtSelect.innerHTML = html;
                    } else {
                        throw new Error('API return error');
                    }
                })
                .catch(error => {
                    console.error('Lỗi tải danh sách quận huyện:', error);
                    // Dành cho trường hợp offline hoặc API lỗi, cho phép người dùng chọn tùy chọn nhập thủ công hoặc báo lỗi nhẹ nhàng
                    districtSelect.innerHTML = '<option value="">Chọn Quận/Huyện (Lỗi tải, vui lòng nhập ở Địa Chỉ cụ thể)</option>';
                });
        });
    });
</script>
@endsection
