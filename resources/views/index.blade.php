@extends('layouts.app')

@section('content')
    <!-- Main Banner Section -->
    <div class="mb-4 relative">
        <div class="bg-purple-900 rounded-lg overflow-hidden h-[450px] relative flex items-center justify-center">
             <img src="https://images.unsplash.com/photo-1587831990711-23ca6441447b?auto=format&fit=crop&q=80&w=1200&h=450" alt="PC Gaming Background" class="absolute inset-0 w-full h-full object-cover opacity-50">
             <div class="relative z-10 text-center">
                 <h2 class="text-white text-6xl font-black italic drop-shadow-lg mb-2">BUILD PC</h2>
                 <h2 class="text-white text-7xl font-black italic drop-shadow-lg mb-2">GAMING</h2>
                 <h2 class="text-primary text-6xl font-black italic drop-shadow-lg mb-4">GIÁ TỐT</h2>
                 <div class="bg-white text-primary text-2xl font-bold px-6 py-2 rounded-full inline-block uppercase mt-4">
                     Đến ngay TTGSHOP <i class="fas fa-mouse-pointer ml-2"></i>
                 </div>
             </div>
        </div>
        <div class="flex justify-center space-x-12 bg-black text-white text-sm py-2 px-4 rounded-b-lg -mt-2 relative z-20 mx-4">
            <span><i class="fas fa-hand-point-right text-primary mr-1"></i> Showroom 1 : 83-85 Thái Hà ,Đống Đa , Hà Nội</span>
            <span class="text-green-500 font-bold"><i class="fab fa-whatsapp text-lg mr-1"></i> 098.655.2233</span>
            <span><i class="fas fa-hand-point-right text-primary mr-1"></i> Showroom 2: 83A Cửu Long, P15, Q10, Hồ Chí Minh</span>
        </div>
    </div>

    <!-- Sub Banners -->
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="rounded-lg overflow-hidden bg-gray-900 h-48 relative">
            <img src="https://images.unsplash.com/photo-1593640408182-31c70c8268f5?auto=format&fit=crop&w=400&h=200" alt="PC Giả lập" class="w-full h-full object-cover opacity-60">
            <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-4">
                <h3 class="text-yellow-400 font-black text-3xl uppercase italic drop-shadow-md">PC Giả Lập</h3>
                <h3 class="text-white font-black text-3xl uppercase italic drop-shadow-md mb-2">Ảo Hóa</h3>
                <div class="flex space-x-2 mt-2">
                    <span class="w-8 h-8 bg-blue-500 rounded flex items-center justify-center text-white text-xs font-bold">NOX</span>
                    <span class="w-8 h-8 bg-red-500 rounded flex items-center justify-center text-white text-xs font-bold">LD</span>
                </div>
            </div>
        </div>
        <div class="rounded-lg overflow-hidden bg-teal-100 h-48 relative">
             <img src="https://images.unsplash.com/photo-1542393545-10f5cde2c810?auto=format&fit=crop&w=400&h=200" alt="Giới thiệu bạn mới" class="w-full h-full object-cover opacity-30">
             <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-4">
                <h3 class="text-blue-600 font-black text-2xl uppercase">Giới thiệu bạn mới</h3>
                <h4 class="text-primary font-bold text-xl mb-2">Nhận quà cả đôi</h4>
                <div class="bg-white text-blue-600 text-xs font-bold px-3 py-1 rounded-full border border-blue-200">Chiết khấu tới 2 triệu VNĐ</div>
             </div>
        </div>
        <div class="rounded-lg overflow-hidden bg-orange-500 h-48 relative">
             <img src="https://images.unsplash.com/photo-1600861194942-f883de0e20fa?auto=format&fit=crop&w=400&h=200" alt="Đổi PC" class="w-full h-full object-cover opacity-50 mix-blend-multiply">
             <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-4">
                <h3 class="text-yellow-300 font-black text-4xl uppercase italic drop-shadow-lg">ĐỔI PC</h3>
                <h4 class="text-white font-bold text-xl uppercase mb-1">Trong 7 Ngày</h4>
                <p class="text-white text-xs bg-black bg-opacity-50 px-2 py-1 rounded">Không lo chọn sai</p>
             </div>
        </div>
    </div>
    
    <!-- Deal Banner -->
    <div class="mb-8">
        <div class="bg-gradient-to-r from-blue-500 to-cyan-400 rounded-lg p-3 flex items-center justify-between shadow-md">
            <h2 class="text-yellow-300 font-black text-2xl italic uppercase drop-shadow-md ml-4">DEAL HOT MỖI NGÀY - KHUYẾN MÃI LIỀN TAY</h2>
            <button class="bg-yellow-400 text-black font-bold px-6 py-2 rounded-md uppercase hover:bg-yellow-300 mr-4">HOT SALE</button>
        </div>
    </div>

    <!-- PC GAMING Section -->
    <section class="mb-8 bg-white p-4 rounded-lg shadow-sm border border-gray-100">
        <div class="flex items-center justify-between border-b border-gray-200 pb-0 mb-4">
            <div class="flex items-end">
                <div class="bg-primary text-white font-bold px-8 py-2 skew-bg -ml-2 mr-6 inline-block">
                    <span class="unskew-text text-lg">PC GAMING</span>
                </div>
                <div class="flex space-x-2 text-sm font-semibold text-gray-500 pb-2">
                    <a href="#" class="px-3 py-1 bg-gray-100 text-gray-800 rounded">PC GAMING GIÁ RẺ</a>
                    <a href="#" class="px-3 py-1 hover:text-primary transition">PC STREAM GAME</a>
                    <a href="#" class="px-3 py-1 hover:text-primary transition">PC Core Ultra</a>
                    <a href="#" class="px-3 py-1 hover:text-primary transition">PC GAMING CAO CẤP</a>
                </div>
            </div>
            <a href="#" class="text-blue-600 text-sm hover:underline font-medium pb-2">Xem tất cả >></a>
        </div>

        <div class="grid grid-cols-5 gap-4">
            <!-- Product 1 -->
            <div class="product-card border border-gray-200 rounded-lg p-3 bg-white flex flex-col relative group">
                <span class="absolute top-2 right-2 bg-primary text-white text-xs font-bold px-2 py-1 rounded z-10">-6%</span>
                <div class="relative overflow-hidden mb-3 h-40 flex items-center justify-center">
                    <img src="https://images.unsplash.com/photo-1587831990711-23ca6441447b?auto=format&fit=crop&w=200&h=200" alt="PC Gaming" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                </div>
                <h3 class="text-sm font-semibold text-gray-800 mb-2 line-clamp-2 hover:text-primary cursor-pointer">PC TTG GAMING PRO i5 14600KF - 16GB DDR4 - RX...</h3>
                <div class="mt-auto">
                    <div class="text-primary font-bold text-lg">25.480.000₫</div>
                    <div class="text-gray-400 text-xs line-through mb-3">26.990.000₫</div>
                    <div class="flex items-center justify-between">
                        <button class="flex items-center text-xs font-semibold text-gray-700 border border-gray-300 rounded px-2 py-1.5 hover:border-primary hover:text-primary hover:bg-orange-50 transition">
                            <i class="fas fa-shopping-cart text-primary mr-1"></i> THÊM VÀO GIỎ
                        </button>
                        <span class="text-green-600 bg-green-50 border border-green-100 px-2 py-1 rounded text-xs font-medium">Còn hàng</span>
                    </div>
                </div>
            </div>
            <!-- Product 2 -->
            <div class="product-card border border-gray-200 rounded-lg p-3 bg-white flex flex-col relative group">
                <span class="absolute top-2 right-2 bg-primary text-white text-xs font-bold px-2 py-1 rounded z-10">-5%</span>
                <div class="relative overflow-hidden mb-3 h-40 flex items-center justify-center">
                    <img src="https://images.unsplash.com/photo-1593640408182-31c70c8268f5?auto=format&fit=crop&w=200&h=200" alt="PC Gaming" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                </div>
                <h3 class="text-sm font-semibold text-gray-800 mb-2 line-clamp-2 hover:text-primary cursor-pointer">PC TTG GAMING PRO i5 12400F - 16GB DDR4 - RX...</h3>
                <div class="mt-auto">
                    <div class="text-primary font-bold text-lg">21.880.000₫</div>
                    <div class="text-gray-400 text-xs line-through mb-3">22.990.000₫</div>
                    <div class="flex items-center justify-between">
                        <button class="flex items-center text-xs font-semibold text-gray-700 border border-gray-300 rounded px-2 py-1.5 hover:border-primary hover:text-primary hover:bg-orange-50 transition">
                            <i class="fas fa-shopping-cart text-primary mr-1"></i> THÊM VÀO GIỎ
                        </button>
                        <span class="text-green-600 bg-green-50 border border-green-100 px-2 py-1 rounded text-xs font-medium">Còn hàng</span>
                    </div>
                </div>
            </div>
            <!-- Product 3 -->
            <div class="product-card border border-gray-200 rounded-lg p-3 bg-white flex flex-col relative group">
                <span class="absolute top-2 right-2 bg-primary text-white text-xs font-bold px-2 py-1 rounded z-10">-8%</span>
                <div class="relative overflow-hidden mb-3 h-40 flex items-center justify-center">
                    <img src="https://images.unsplash.com/photo-1541807084-5c52b6b3adef?auto=format&fit=crop&w=200&h=200" alt="PC Gaming" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                </div>
                <h3 class="text-sm font-semibold text-gray-800 mb-2 line-clamp-2 hover:text-primary cursor-pointer">PC TTG DESIGNER -3D RENDER - EDIT VIDEO ULTR...</h3>
                <div class="mt-auto">
                    <div class="text-primary font-bold text-lg">38.680.000₫</div>
                    <div class="text-gray-400 text-xs line-through mb-3">41.990.000₫</div>
                    <div class="flex items-center justify-between">
                        <button class="flex items-center text-xs font-semibold text-gray-700 border border-gray-300 rounded px-2 py-1.5 hover:border-primary hover:text-primary hover:bg-orange-50 transition">
                            <i class="fas fa-shopping-cart text-primary mr-1"></i> THÊM VÀO GIỎ
                        </button>
                        <span class="text-green-600 bg-green-50 border border-green-100 px-2 py-1 rounded text-xs font-medium">Còn hàng</span>
                    </div>
                </div>
            </div>
            <!-- Product 4 -->
            <div class="product-card border border-gray-200 rounded-lg p-3 bg-white flex flex-col relative group">
                <span class="absolute top-2 right-2 bg-primary text-white text-xs font-bold px-2 py-1 rounded z-10">-4%</span>
                <div class="relative overflow-hidden mb-3 h-40 flex items-center justify-center">
                    <img src="https://images.unsplash.com/photo-1624701928517-44c8ac49d93c?auto=format&fit=crop&w=200&h=200" alt="PC Gaming" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                </div>
                <h3 class="text-sm font-semibold text-gray-800 mb-2 line-clamp-2 hover:text-primary cursor-pointer">PC TTG AMD GAMING RYZEN 7 9800X3D - RTX 5070 Ti...</h3>
                <div class="mt-auto">
                    <div class="text-primary font-bold text-lg">60.480.000₫</div>
                    <div class="text-gray-400 text-xs line-through mb-3">62.990.000₫</div>
                    <div class="flex items-center justify-between">
                        <button class="flex items-center text-xs font-semibold text-gray-700 border border-gray-300 rounded px-2 py-1.5 hover:border-primary hover:text-primary hover:bg-orange-50 transition">
                            <i class="fas fa-shopping-cart text-primary mr-1"></i> THÊM VÀO GIỎ
                        </button>
                        <span class="text-green-600 bg-green-50 border border-green-100 px-2 py-1 rounded text-xs font-medium">Còn hàng</span>
                    </div>
                </div>
            </div>
            <!-- Product 5 -->
            <div class="product-card border border-gray-200 rounded-lg p-3 bg-white flex flex-col relative group">
                <span class="absolute top-2 right-2 bg-primary text-white text-xs font-bold px-2 py-1 rounded z-10">-9%</span>
                <div class="relative overflow-hidden mb-3 h-40 flex items-center justify-center">
                    <img src="https://images.unsplash.com/photo-1593640408182-31c70c8268f5?auto=format&fit=crop&w=200&h=200" alt="PC Gaming" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                </div>
                <h3 class="text-sm font-semibold text-gray-800 mb-2 line-clamp-2 hover:text-primary cursor-pointer">PC TTG AMD GAMING RYZEN 7 9800X3D - RTX 5080 16G...</h3>
                <div class="mt-auto">
                    <div class="text-primary font-bold text-lg">71.680.000₫</div>
                    <div class="text-gray-400 text-xs line-through mb-3">79.990.000₫</div>
                    <div class="flex items-center justify-between">
                        <button class="flex items-center text-xs font-semibold text-gray-700 border border-gray-300 rounded px-2 py-1.5 hover:border-primary hover:text-primary hover:bg-orange-50 transition">
                            <i class="fas fa-shopping-cart text-primary mr-1"></i> THÊM VÀO GIỎ
                        </button>
                        <span class="text-green-600 bg-green-50 border border-green-100 px-2 py-1 rounded text-xs font-medium">Còn hàng</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PC WORKSTATION Section -->
    <section class="mb-8 bg-white p-4 rounded-lg shadow-sm border border-gray-100">
        <div class="flex items-center justify-between border-b border-gray-200 pb-0 mb-4">
            <div class="flex items-end">
                <div class="bg-primary text-white font-bold px-8 py-2 skew-bg -ml-2 mr-6 inline-block">
                    <span class="unskew-text text-lg">PC WORKSTATION 2D 3D</span>
                </div>
            </div>
            <a href="#" class="text-blue-600 text-sm hover:underline font-medium pb-2">Xem tất cả >></a>
        </div>

        <div class="grid grid-cols-5 gap-4">
            <!-- Product 1 -->
            <div class="product-card border border-gray-200 rounded-lg p-3 bg-white flex flex-col relative group">
                <span class="absolute top-2 right-2 bg-primary text-white text-xs font-bold px-2 py-1 rounded z-10">-8%</span>
                <div class="relative overflow-hidden mb-3 h-40 flex items-center justify-center">
                    <img src="https://images.unsplash.com/photo-1541807084-5c52b6b3adef?auto=format&fit=crop&w=200&h=200" alt="PC Workstation" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                </div>
                <h3 class="text-sm font-semibold text-gray-800 mb-2 line-clamp-2 hover:text-primary cursor-pointer">PC TTG DESIGNER -3D RENDER - EDIT VIDEO i7...</h3>
                <div class="mt-auto">
                    <div class="text-primary font-bold text-lg">37.680.000₫</div>
                    <div class="text-gray-400 text-xs line-through mb-3">40.990.000₫</div>
                    <div class="flex items-center justify-between">
                        <button class="flex items-center text-xs font-semibold text-gray-700 border border-gray-300 rounded px-2 py-1.5 hover:border-primary hover:text-primary hover:bg-orange-50 transition">
                            <i class="fas fa-shopping-cart text-primary mr-1"></i> THÊM VÀO GIỎ
                        </button>
                        <span class="text-green-600 bg-green-50 border border-green-100 px-2 py-1 rounded text-xs font-medium">Còn hàng</span>
                    </div>
                </div>
            </div>
             <!-- Product 2 -->
            <div class="product-card border border-gray-200 rounded-lg p-3 bg-white flex flex-col relative group">
                <span class="absolute top-2 right-2 bg-primary text-white text-xs font-bold px-2 py-1 rounded z-10">-8%</span>
                <div class="relative overflow-hidden mb-3 h-40 flex items-center justify-center">
                    <img src="https://images.unsplash.com/photo-1587831990711-23ca6441447b?auto=format&fit=crop&w=200&h=200" alt="PC Workstation" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                </div>
                <h3 class="text-sm font-semibold text-gray-800 mb-2 line-clamp-2 hover:text-primary cursor-pointer">PC TTG DESIGNER -3D RENDER - EDIT VIDEO ULTR...</h3>
                <div class="mt-auto">
                    <div class="text-primary font-bold text-lg">38.680.000₫</div>
                    <div class="text-gray-400 text-xs line-through mb-3">41.990.000₫</div>
                    <div class="flex items-center justify-between">
                        <button class="flex items-center text-xs font-semibold text-gray-700 border border-gray-300 rounded px-2 py-1.5 hover:border-primary hover:text-primary hover:bg-orange-50 transition">
                            <i class="fas fa-shopping-cart text-primary mr-1"></i> THÊM VÀO GIỎ
                        </button>
                        <span class="text-green-600 bg-green-50 border border-green-100 px-2 py-1 rounded text-xs font-medium">Còn hàng</span>
                    </div>
                </div>
            </div>
            <!-- Product 3 -->
            <div class="product-card border border-gray-200 rounded-lg p-3 bg-white flex flex-col relative group">
                <span class="absolute top-2 right-2 bg-primary text-white text-xs font-bold px-2 py-1 rounded z-10">-5%</span>
                <div class="relative overflow-hidden mb-3 h-40 flex items-center justify-center">
                    <img src="https://images.unsplash.com/photo-1624701928517-44c8ac49d93c?auto=format&fit=crop&w=200&h=200" alt="PC Workstation" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                </div>
                <h3 class="text-sm font-semibold text-gray-800 mb-2 line-clamp-2 hover:text-primary cursor-pointer">PC TTG DESIGNER -3D RENDER - EDIT VIDEO ULTR...</h3>
                <div class="mt-auto">
                    <div class="text-primary font-bold text-lg">36.980.000₫</div>
                    <div class="text-gray-400 text-xs line-through mb-3">38.990.000₫</div>
                    <div class="flex items-center justify-between">
                        <button class="flex items-center text-xs font-semibold text-gray-700 border border-gray-300 rounded px-2 py-1.5 hover:border-primary hover:text-primary hover:bg-orange-50 transition">
                            <i class="fas fa-shopping-cart text-primary mr-1"></i> THÊM VÀO GIỎ
                        </button>
                        <span class="text-green-600 bg-green-50 border border-green-100 px-2 py-1 rounded text-xs font-medium">Còn hàng</span>
                    </div>
                </div>
            </div>
             <!-- Product 4 -->
            <div class="product-card border border-gray-200 rounded-lg p-3 bg-white flex flex-col relative group">
                <span class="absolute top-2 right-2 bg-primary text-white text-xs font-bold px-2 py-1 rounded z-10">-2%</span>
                <div class="relative overflow-hidden mb-3 h-40 flex items-center justify-center">
                    <img src="https://images.unsplash.com/photo-1593640408182-31c70c8268f5?auto=format&fit=crop&w=200&h=200" alt="PC Workstation" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                </div>
                <h3 class="text-sm font-semibold text-gray-800 mb-2 line-clamp-2 hover:text-primary cursor-pointer">PC TTG DESIGNER -3D RENDER - EDIT VIDEO i5...</h3>
                <div class="mt-auto">
                    <div class="text-primary font-bold text-lg">34.280.000₫</div>
                    <div class="text-gray-400 text-xs line-through mb-3">34.990.000₫</div>
                    <div class="flex items-center justify-between">
                        <button class="flex items-center text-xs font-semibold text-gray-700 border border-gray-300 rounded px-2 py-1.5 hover:border-primary hover:text-primary hover:bg-orange-50 transition">
                            <i class="fas fa-shopping-cart text-primary mr-1"></i> THÊM VÀO GIỎ
                        </button>
                        <span class="text-green-600 bg-green-50 border border-green-100 px-2 py-1 rounded text-xs font-medium">Còn hàng</span>
                    </div>
                </div>
            </div>
             <!-- Product 5 -->
            <div class="product-card border border-gray-200 rounded-lg p-3 bg-white flex flex-col relative group">
                <span class="absolute top-2 right-2 bg-primary text-white text-xs font-bold px-2 py-1 rounded z-10">-3%</span>
                <div class="relative overflow-hidden mb-3 h-40 flex items-center justify-center">
                    <img src="https://images.unsplash.com/photo-1541807084-5c52b6b3adef?auto=format&fit=crop&w=200&h=200" alt="PC Workstation" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                </div>
                <h3 class="text-sm font-semibold text-gray-800 mb-2 line-clamp-2 hover:text-primary cursor-pointer">PC TTG DESIGNER -3D RENDER - EDIT VIDEO i7...</h3>
                <div class="mt-auto">
                    <div class="text-primary font-bold text-lg">47.680.000₫</div>
                    <div class="text-gray-400 text-xs line-through mb-3">48.990.000₫</div>
                    <div class="flex items-center justify-between">
                        <button class="flex items-center text-xs font-semibold text-gray-700 border border-gray-300 rounded px-2 py-1.5 hover:border-primary hover:text-primary hover:bg-orange-50 transition">
                            <i class="fas fa-shopping-cart text-primary mr-1"></i> THÊM VÀO GIỎ
                        </button>
                        <span class="text-green-600 bg-green-50 border border-green-100 px-2 py-1 rounded text-xs font-medium">Còn hàng</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="bg-white py-10 mt-12 rounded-lg mb-8 border border-gray-100 shadow-sm">
        <div class="container mx-auto px-10">
            <div class="grid grid-cols-4 gap-8 mb-12 text-center divide-x divide-gray-200 border-b border-gray-100 pb-10">
                <div class="px-4">
                    <i class="fas fa-truck text-4xl text-primary mb-4"></i>
                    <h4 class="font-bold text-gray-800 uppercase text-sm mb-1">GIAO HÀNG TOÀN QUỐC</h4>
                    <p class="text-xs text-gray-500">Giao hàng trước, trả tiền sau COD</p>
                </div>
                <div class="px-4">
                    <i class="fas fa-sync-alt text-4xl text-primary mb-4"></i>
                    <h4 class="font-bold text-gray-800 uppercase text-sm mb-1">ĐỔI TRẢ DỄ DÀNG</h4>
                    <p class="text-xs text-gray-500">Đổi mới trong 30 ngày đầu</p>
                </div>
                <div class="px-4">
                    <i class="fas fa-credit-card text-4xl text-primary mb-4"></i>
                    <h4 class="font-bold text-gray-800 uppercase text-sm mb-1">THANH TOÁN TIỆN LỢI</h4>
                    <p class="text-xs text-gray-500">Trả tiền mặt, chuyển khoản, trả góp 0%</p>
                </div>
                <div class="px-4">
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
                <div class="border border-gray-200 p-4 rounded-lg flex justify-between items-center bg-gray-50 hover:bg-gray-100 cursor-pointer transition shadow-sm">
                    <span class="font-semibold text-sm text-gray-800">1. Liên hệ chăm sóc khách hàng dễ dàng</span>
                    <i class="fas fa-plus text-gray-500"></i>
                </div>
                <div class="border border-gray-200 p-4 rounded-lg flex justify-between items-center bg-gray-50 hover:bg-gray-100 cursor-pointer transition shadow-sm">
                    <span class="font-semibold text-sm text-gray-800">2. Giao hàng nhanh trong 2 giờ mà không thu thêm phí</span>
                    <i class="fas fa-plus text-gray-500"></i>
                </div>
                <div class="border border-gray-200 p-4 rounded-lg flex justify-between items-center bg-gray-50 hover:bg-gray-100 cursor-pointer transition shadow-sm">
                    <span class="font-semibold text-sm text-gray-800">3. Miễn phí lên đời và trải nghiệm sản phẩm trong vòng 15 ngày</span>
                    <i class="fas fa-plus text-gray-500"></i>
                </div>
                <div class="border border-gray-200 p-4 rounded-lg flex justify-between items-center bg-gray-50 hover:bg-gray-100 cursor-pointer transition shadow-sm">
                    <span class="font-semibold text-sm text-gray-800">4. Cam kết thu cũ đổi mới trọn đời với tất cả các sản phẩm Gaming Gear và linh kiện máy tính</span>
                    <i class="fas fa-plus text-gray-500"></i>
                </div>
                <div class="border border-gray-200 p-4 rounded-lg flex justify-between items-center bg-gray-50 hover:bg-gray-100 cursor-pointer transition shadow-sm">
                    <span class="font-semibold text-sm text-gray-800">5. Cho mượn sản phẩm miễn phí thay thế trong thời gian bảo hành tại TTG SHOP</span>
                    <i class="fas fa-plus text-gray-500"></i>
                </div>
            </div>
        </div>
    </section>
@endsection
