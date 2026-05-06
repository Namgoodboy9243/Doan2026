@extends('layouts.app')

@section('title', 'Thông tin giỏ hàng - TTGSHOP')

@section('content')

    <!-- Breadcrumb -->
    <div class="text-sm text-gray-500 mb-6 px-2">
        Trang chủ &gt; <span class="text-gray-800">Thông tin giỏ hàng</span>
    </div>

    <!-- Giỏ hàng chính -->
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 mb-8">
        <!-- Cart Header -->
        <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
            <h1 class="text-teal-600 font-bold text-lg">Giỏ hàng</h1>
            <button class="text-red-500 hover:text-red-700 hover:underline text-sm font-medium transition">Xóa toàn bộ giỏ hàng</button>
        </div>

        <!-- Cart Item -->
        <div class="flex flex-col md:flex-row items-center justify-between border-b border-gray-100 pb-6 mb-6">
            <!-- Product Info -->
            <div class="flex items-center w-full md:w-[45%] mb-4 md:mb-0">
                <div class="w-20 h-20 flex-shrink-0 bg-white border border-gray-200 flex items-center justify-center mr-4 p-1">
                    <img src="https://images.unsplash.com/photo-1593640408182-31c70c8268f5?auto=format&fit=crop&w=150&h=150" alt="PC Gaming" class="max-w-full max-h-full object-contain">
                </div>
                <div class="pr-4">
                    <h3 class="font-bold text-gray-800 text-sm mb-1 leading-snug">PC AMD GAMING LUXURY RYZEN 9 9950X3D2 -RTX 5090 32GB OC</h3>
                    <p class="text-sm text-gray-800 font-medium">Bảo hành: <span class="text-red-500">36 Tháng</span></p>
                </div>
            </div>

            <!-- Price & Actions -->
            <div class="flex items-center justify-between w-full md:w-[55%]">
                <!-- Unit Price -->
                <div class="text-gray-800 font-medium text-sm w-1/4 text-center">
                    179.980.000 đ
                </div>
                
                <!-- Quantity -->
                <div class="w-1/4 flex justify-center">
                    <div class="flex border border-gray-300 rounded overflow-hidden">
                        <button class="px-3 py-1 bg-gray-50 hover:bg-gray-200 text-gray-600 font-bold transition focus:outline-none">-</button>
                        <input type="text" value="1" class="w-10 text-center border-x border-gray-300 text-sm focus:outline-none focus:ring-1 focus:ring-primary">
                        <button class="px-3 py-1 bg-gray-50 hover:bg-gray-200 text-gray-600 font-bold transition focus:outline-none">+</button>
                    </div>
                </div>

                <!-- Total Item Price -->
                <div class="text-gray-800 font-bold text-sm w-1/4 text-center">
                    179.980.000 đ
                </div>

                <!-- Delete Action -->
                <div class="w-1/4 flex justify-end">
                    <button class="text-gray-500 hover:text-red-500 transition text-lg" title="Xóa sản phẩm">
                        <i class="far fa-trash-alt"></i>
                    </button>
                </div>
            </div>
        </div>

    </div>

    <!-- Checkout Form Section -->
    <div class="flex flex-col lg:flex-row gap-6 mb-8">
        <!-- Thông tin người mua -->
        <div class="w-full lg:w-3/5 bg-white shadow-sm border border-gray-100 rounded-lg overflow-hidden">
            <div class="bg-gray-100 px-6 py-3 border-b border-gray-200">
                <h2 class="font-bold text-gray-800 uppercase text-sm">THÔNG TIN NGƯỜI MUA</h2>
            </div>
            <div class="p-6">
                <p class="text-sm text-gray-700 mb-4 font-medium">Để tiếp tục đặt hàng, quý khách xin vui lòng nhập thông tin bên dưới</p>
                <form class="space-y-4">
                    <div class="flex items-center">
                        <label class="w-1/4 text-sm text-gray-700 font-bold">Họ tên<span class="text-red-500 ml-1">*</span></label>
                        <input type="text" class="w-3/4 border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                    </div>
                    <div class="flex items-center">
                        <label class="w-1/4 text-sm text-gray-700 font-bold">SĐT<span class="text-red-500 ml-1">*</span></label>
                        <input type="text" class="w-3/4 border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                    </div>
                    <div class="flex items-center">
                        <label class="w-1/4 text-sm text-gray-700 font-bold">Email<span class="text-red-500 ml-1">*</span></label>
                        <input type="email" class="w-3/4 border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                    </div>
                    <div class="flex items-start">
                        <label class="w-1/4 text-sm text-gray-700 font-bold mt-2">Địa chỉ<span class="text-red-500 ml-1">*</span></label>
                        <textarea rows="2" class="w-3/4 border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary"></textarea>
                    </div>
                    <div class="flex items-center">
                        <label class="w-1/4 text-sm text-gray-700 font-bold">Tỉnh/Thành phố<span class="text-red-500 ml-1">*</span></label>
                        <select class="w-3/4 border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-gray-600">
                            <option>Chọn Tỉnh/Thành phố</option>
                        </select>
                    </div>
                    <div class="flex items-center">
                        <label class="w-1/4 text-sm text-gray-700 font-bold">Quận/Huyện<span class="text-red-500 ml-1">*</span></label>
                        <select class="w-3/4 border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-gray-600">
                            <option>Chọn Quận/Huyện</option>
                        </select>
                    </div>
                    <div class="flex items-start">
                        <label class="w-1/4 text-sm text-gray-700 font-bold mt-2">Ghi chú</label>
                        <textarea rows="3" class="w-3/4 border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary"></textarea>
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
                        <span class="font-bold">179.980.000 đ</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span>Giảm giá Voucher</span>
                        <span class="font-bold">0 đ</span>
                    </div>
                    <div class="flex justify-between items-center mt-3 pt-3 border-t border-gray-200">
                        <span class="font-bold text-base text-gray-800">Thành tiền</span>
                        <div class="text-right">
                            <span class="font-bold text-red-600 text-[22px] leading-tight block mb-0.5">179.980.000 đ</span>
                            <span class="text-[11px] text-gray-500">(Giá đã bao gồm VAT)</span>
                        </div>
                    </div>
                </div>

                <!-- Terms -->
                <div class="mb-6">
                    <label class="flex items-start cursor-pointer group">
                        <input type="checkbox" class="mt-0.5 mr-2 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4">
                        <span class="text-[13px] text-gray-800 font-bold group-hover:text-primary transition leading-tight">Tôi đã đọc và đồng ý với các Điều kiện giao dịch chung của website</span>
                    </label>
                </div>

                <!-- Action Buttons -->
                <div class="grid grid-cols-2 gap-2">
                    <button class="bg-[#051923] text-white py-3 rounded text-[13px] font-bold hover:bg-black transition flex items-center justify-center shadow">
                        <i class="fas fa-print mr-2"></i> IN BÁO GIÁ
                    </button>
                    <button class="bg-[#051923] text-white py-3 rounded text-[13px] font-bold hover:bg-black transition flex items-center justify-center shadow">
                        <i class="fas fa-file-excel mr-2"></i> TẢI FILE EXCEL
                    </button>
                    <button class="bg-[#e60000] text-white py-3 rounded text-[13px] font-bold hover:bg-red-700 transition flex items-center justify-center shadow">
                        <i class="fas fa-check mr-2"></i> ĐẶT HÀNG
                    </button>
                    <button class="bg-[#1e40af] text-white py-2 rounded flex flex-col items-center justify-center hover:bg-blue-800 transition shadow leading-tight">
                        <div class="flex items-center text-[13px] font-bold mb-0.5"><i class="far fa-credit-card mr-2"></i> TRẢ GÓP QUA HỒ SƠ</div>
                        <div class="text-[10px] font-medium opacity-90">CHỈ TỪ 23.997.334 Đ/THÁNG</div>
                    </button>
                </div>
            </div>
        </div>
    </div>

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
                <p class="text-gray-800 font-semibold mb-1">Trải nghiệm mua sắm tại <span class="text-primary font-bold">TTG SHOP</span></p>
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
                    <span class="font-semibold text-sm text-gray-800 group-hover:text-primary transition">4. Cam kết thu cũ đổi mới trọn đời với tất cả các sản phẩm Gaming Gear và linh kiện máy tính</span>
                    <i class="fas fa-plus text-gray-500 group-hover:text-primary transition"></i>
                </div>
                <div class="border border-gray-200 p-4 rounded-lg flex justify-between items-center bg-gray-50 hover:bg-gray-100 cursor-pointer transition shadow-sm group">
                    <span class="font-semibold text-sm text-gray-800 group-hover:text-primary transition">5. Cho mượn sản phẩm miễn phí thay thế trong thời gian bảo hành tại TTG SHOP</span>
                    <i class="fas fa-plus text-gray-500 group-hover:text-primary transition"></i>
                </div>
            </div>
        </div>
    </section>

@endsection
