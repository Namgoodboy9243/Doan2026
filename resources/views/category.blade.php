@extends('layouts.app')

@section('title', 'PC GAMING - TTGSHOP')

@section('content')

    <!-- Breadcrumb -->
    <div class="text-sm text-gray-500 mb-4 px-2">
        Trang chủ &gt; <span class="font-bold text-gray-800 uppercase">PC Gaming</span>
    </div>

    <!-- Notice Banner -->
    <div class="bg-white p-6 rounded-lg mb-6 border border-gray-100 shadow-sm text-sm text-gray-700 leading-relaxed">
        <div class="font-bold mb-4 text-base"><span class="text-yellow-400">🌟</span> TTGShop | THÔNG BÁO CHÍNH THỨC KINH DOANH PC !</div>
        <p class="mb-4">Chào toàn thể các anh em, sau một thời gian dài ấp ủ và lên kế hoạch thì cuối cùng TTG Team cũng có cơ hội thông báo tới tất cả các anh em rằng kể từ ngày 26/12/2022 TTG sẽ chính thức kinh doanh các sản phẩm về công nghệ điện tử, cụ thể là PC Gaming - PC Workstation - Hi-end Gaming gear 🥇 Vậy nên..</p>
        <p class="mb-4"><span class="text-yellow-400">👉</span> Muốn Tìm PC Tối Ưu Về Giá - Đảm Bảo Hiệu Năng - Tiết Kiệm Thời Gian Làm Việc thì nhắn ngay 💌 TTG cân cả GIÁ & CHẤT cho anh em 💪</p>
        <p class="mb-4"><span class="text-yellow-400">👉</span> Sự ủng hộ của anh em dành cho team TTG đã đang và sẽ luôn là nguồn động lực lớn giúp team hiện thực hóa các dự định của mình. Rất mong anh em sẽ ủng hộ team TTG thật nhiều trong vai trò mới này 🤝</p>
        <p class="mb-2 text-gray-400"><span class="text-yellow-400 opacity-50">👉</span> Và cũng như thay lời tri ân tới tất cả anh em, thì chúng mình sẽ dành 10 suất áo Bomber sớm nhất cho 10 anh em BUILD máy tại TTG Shop.</p>
        <div class="text-center mt-2 cursor-pointer text-primary hover:underline font-medium">
            Xem thêm <i class="fas fa-chevron-down text-xs ml-1"></i>
        </div>
    </div>

    <div class="flex flex-col md:flex-row gap-6">
        <!-- Sidebar / Filters -->
        <div class="w-full md:w-[280px] flex-shrink-0">
            <!-- Lọc sản phẩm button -->
            <button class="w-full bg-white border border-gray-200 shadow-sm font-bold text-gray-800 py-3 px-4 mb-4 rounded flex items-center justify-center hover:text-primary transition">
                LỌC SẢN PHẨM
            </button>

            <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                <!-- Categories -->
                <div class="p-4 border-b border-gray-200">
                    <h3 class="font-bold text-gray-800 mb-3 uppercase text-sm">PC Gaming</h3>
                    <ul class="space-y-3 text-sm text-gray-700">
                        <li><a href="#" class="flex items-center hover:text-primary transition"><i class="fas fa-angle-double-right text-gray-400 mr-2 text-xs"></i> PC GAMING GIÁ RẺ</a></li>
                        <li class="border-t border-dashed border-gray-200 pt-2"><a href="#" class="flex items-center hover:text-primary transition"><i class="fas fa-angle-double-right text-gray-400 mr-2 text-xs"></i> PC STREAM GAME</a></li>
                        <li class="border-t border-dashed border-gray-200 pt-2"><a href="#" class="flex items-center hover:text-primary transition"><i class="fas fa-angle-double-right text-gray-400 mr-2 text-xs"></i> PC Core Ultra</a></li>
                        <li class="border-t border-dashed border-gray-200 pt-2"><a href="#" class="flex items-center hover:text-primary transition"><i class="fas fa-angle-double-right text-gray-400 mr-2 text-xs"></i> PC GAMING CAO CẤP</a></li>
                    </ul>
                </div>

                <!-- Price Range -->
                <div class="p-4 border-b border-gray-200">
                    <h3 class="font-bold text-gray-800 mb-3 uppercase text-sm">Khoảng giá</h3>
                    <div class="space-y-2 text-sm text-gray-700">
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">10 triệu - 15 triệu (10)</span></label>
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">15 triệu - 20 triệu (26)</span></label>
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">20 triệu - 25 triệu (42)</span></label>
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">25 triệu - 35 triệu (81)</span></label>
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">35 triệu - 45 triệu (63)</span></label>
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">45 triệu - 60 triệu (35)</span></label>
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">60 triệu - 80 triệu (24)</span></label>
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">80 triệu - 100 triệu (3)</span></label>
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">100 triệu - 150 triệu (8)</span></label>
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">150 triệu - 200 triệu (4)</span></label>
                    </div>
                </div>

                <!-- Brands -->
                <div class="p-4 border-b border-gray-200">
                    <h3 class="font-bold text-gray-800 mb-3 uppercase text-sm">Thương hiệu</h3>
                    <div class="space-y-2 text-sm text-gray-700">
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">ASUS (1)</span></label>
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">Khác (283)</span></label>
                    </div>
                </div>

                <!-- CPU -->
                <div class="p-4 border-b border-gray-200">
                    <h3 class="font-bold text-gray-800 mb-3 uppercase text-sm">Dòng CPU</h3>
                    <div class="space-y-2 text-sm text-gray-700">
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">AMD Ryzen 7 (47)</span></label>
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">AMD Ryzen 9 (28)</span></label>
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">Intel Core i3 (2)</span></label>
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">Intel Core i5 (116)</span></label>
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">Intel Core i7 (40)</span></label>
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">Intel Core i9 (6)</span></label>
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">Intel Core Ultra 5 (10)</span></label>
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">Intel Core Ultra 7 (20)</span></label>
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">Intel Core Ultra 9 (7)</span></label>
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">AMD Ryzen 5 (21)</span></label>
                    </div>
                </div>

                <!-- RAM -->
                <div class="p-4 border-b border-gray-200">
                    <h3 class="font-bold text-gray-800 mb-3 uppercase text-sm">Dung Lượng RAM</h3>
                    <div class="space-y-2 text-sm text-gray-700">
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">8GB (16)</span></label>
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">16GB (201)</span></label>
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">32GB (2x16GB) (76)</span></label>
                    </div>
                </div>

                <!-- VGA -->
                <div class="p-4 border-b border-gray-200">
                    <h3 class="font-bold text-gray-800 mb-3 uppercase text-sm">VGA</h3>
                    <div class="space-y-2 text-sm text-gray-700 max-h-56 overflow-y-auto pr-2" style="scrollbar-width: thin;">
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">NVIDIA RTX 5060 8GB (24)</span></label>
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">NVIDIA RTX 5060 Ti 8GB (17)</span></label>
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">NVIDIA RTX 5060 Ti 16GB (32)</span></label>
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">NVIDIA RTX 5070 12GB (38)</span></label>
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">NVIDIA RTX 5070 Ti 16GB (22)</span></label>
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">NVIDIA RTX 5080 16GB (19)</span></label>
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">NVIDIA RTX 5090 32GB (14)</span></label>
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">AMD RX 7600 8GB (12)</span></label>
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">AMD RX 9060 XT 8GB (6)</span></label>
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">AMD RX 9060 XT 16GB (14)</span></label>
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">AMD RX 9070 XT 16GB (20)</span></label>
                    </div>
                </div>

                <!-- HDD/SSD -->
                <div class="p-4">
                    <h3 class="font-bold text-gray-800 mb-3 uppercase text-sm">Ổ cứng</h3>
                    <div class="space-y-2 text-sm text-gray-700">
                        <label class="flex items-center cursor-pointer hover:text-primary group"><input type="checkbox" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"> <span class="group-hover:translate-x-1 transition-transform">SSD (297)</span></label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content (Product Grid) -->
        <div class="flex-1 bg-white p-5 rounded-lg border border-gray-200 shadow-sm">
            <div class="flex justify-between items-center mb-5 pb-3 border-b border-gray-200">
                <div class="font-bold text-gray-800">Tìm thấy <span class="text-blue-600">300</span> sản phẩm</div>
                <div class="flex items-center">
                    <select class="border border-gray-300 rounded px-3 py-1.5 text-sm text-gray-800 font-medium focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                        <option>Sắp xếp theo</option>
                        <option>Giá tăng dần</option>
                        <option>Giá giảm dần</option>
                        <option>Tên A-Z</option>
                    </select>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                
                <!-- Product 1 -->
                <div class="product-card border border-gray-200 rounded-lg p-3 bg-white flex flex-col relative group">
                    <span class="absolute top-2 right-2 bg-primary text-white text-xs font-bold px-2 py-1 rounded z-10">-2%</span>
                    <div class="relative overflow-hidden mb-3 h-48 flex items-center justify-center p-2">
                        <img src="https://images.unsplash.com/photo-1587831990711-23ca6441447b?auto=format&fit=crop&w=300&h=300" alt="PC Gaming" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                    </div>
                    <h3 class="text-sm font-semibold text-gray-800 mb-2 line-clamp-2 hover:text-primary cursor-pointer leading-relaxed">PC AMD GAMING PRO RYZEN 7 9850X3D - RTX...</h3>
                    <div class="mt-auto">
                        <div class="flex items-end justify-between mb-1">
                            <div class="text-primary font-bold text-lg">54.680.000₫</div>
                        </div>
                        <div class="text-gray-400 text-xs line-through mb-3">55.990.000₫</div>
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
                    <span class="absolute top-2 right-2 bg-primary text-white text-xs font-bold px-2 py-1 rounded z-10">-10%</span>
                    <div class="relative overflow-hidden mb-3 h-48 flex items-center justify-center p-2">
                        <img src="https://images.unsplash.com/photo-1593640408182-31c70c8268f5?auto=format&fit=crop&w=300&h=300" alt="PC Gaming" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                    </div>
                    <h3 class="text-sm font-semibold text-gray-800 mb-2 line-clamp-2 hover:text-primary cursor-pointer leading-relaxed">PC AMD GAMING LUXURY RYZEN 9 9950X3D2 -RTX...</h3>
                    <div class="mt-auto">
                        <div class="flex items-end justify-between mb-1">
                            <div class="text-primary font-bold text-lg">179.980.000₫</div>
                        </div>
                        <div class="text-gray-400 text-xs line-through mb-3">199.900.000₫</div>
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
                    <span class="absolute top-2 right-2 bg-primary text-white text-xs font-bold px-2 py-1 rounded z-10">-12%</span>
                    <div class="relative overflow-hidden mb-3 h-48 flex items-center justify-center p-2">
                        <img src="https://images.unsplash.com/photo-1541807084-5c52b6b3adef?auto=format&fit=crop&w=300&h=300" alt="PC Gaming" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                    </div>
                    <h3 class="text-sm font-semibold text-gray-800 mb-2 line-clamp-2 hover:text-primary cursor-pointer leading-relaxed">PC TTG ULTRA GAMING I7 14700F - 16GB DDR4 - RTX...</h3>
                    <div class="mt-auto">
                        <div class="flex items-end justify-between mb-1">
                            <div class="text-primary font-bold text-lg">26.280.000₫</div>
                        </div>
                        <div class="text-gray-400 text-xs line-through mb-3">29.990.000₫</div>
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
                    <span class="absolute top-2 right-2 bg-primary text-white text-xs font-bold px-2 py-1 rounded z-10">-9%</span>
                    <div class="relative overflow-hidden mb-3 h-48 flex items-center justify-center p-2">
                        <img src="https://images.unsplash.com/photo-1624701928517-44c8ac49d93c?auto=format&fit=crop&w=300&h=300" alt="PC Gaming" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                    </div>
                    <h3 class="text-sm font-semibold text-gray-800 mb-2 line-clamp-2 hover:text-primary cursor-pointer leading-relaxed">PC TTG ULTRA GAMING I5 14600KF - 16GB DDR4 - RT...</h3>
                    <div class="mt-auto">
                        <div class="flex items-end justify-between mb-1">
                            <div class="text-primary font-bold text-lg">23.680.000₫</div>
                        </div>
                        <div class="text-gray-400 text-xs line-through mb-3">25.990.000₫</div>
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
                    <span class="absolute top-2 right-2 bg-primary text-white text-xs font-bold px-2 py-1 rounded z-10">-19%</span>
                    <div class="relative overflow-hidden mb-3 h-48 flex items-center justify-center p-2">
                        <img src="https://images.unsplash.com/photo-1593640408182-31c70c8268f5?auto=format&fit=crop&w=300&h=300" alt="PC Gaming" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                    </div>
                    <h3 class="text-sm font-semibold text-gray-800 mb-2 line-clamp-2 hover:text-primary cursor-pointer leading-relaxed">PC GAMING ASUS ROG HATSUNE MIKU EDITION...</h3>
                    <div class="mt-auto">
                        <div class="flex items-end justify-between mb-1">
                            <div class="text-primary font-bold text-lg">146.680.000₫</div>
                        </div>
                        <div class="text-gray-400 text-xs line-through mb-3">179.990.000₫</div>
                        <div class="flex items-center justify-between">
                            <button class="flex items-center text-xs font-semibold text-gray-700 border border-gray-300 rounded px-2 py-1.5 hover:border-primary hover:text-primary hover:bg-orange-50 transition">
                                <i class="fas fa-shopping-cart text-primary mr-1"></i> THÊM VÀO GIỎ
                            </button>
                            <span class="text-green-600 bg-green-50 border border-green-100 px-2 py-1 rounded text-xs font-medium">Còn hàng</span>
                        </div>
                    </div>
                </div>

                <!-- Product 6 -->
                <div class="product-card border border-gray-200 rounded-lg p-3 bg-white flex flex-col relative group">
                    <span class="absolute top-2 right-2 bg-primary text-white text-xs font-bold px-2 py-1 rounded z-10">-5%</span>
                    <div class="relative overflow-hidden mb-3 h-48 flex items-center justify-center p-2">
                        <img src="https://images.unsplash.com/photo-1541807084-5c52b6b3adef?auto=format&fit=crop&w=300&h=300" alt="PC Gaming" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                    </div>
                    <h3 class="text-sm font-semibold text-gray-800 mb-2 line-clamp-2 hover:text-primary cursor-pointer leading-relaxed">PC TTG GAMING CORE ULTRA 7 270K PLUS - 32G...</h3>
                    <div class="mt-auto">
                        <div class="flex items-end justify-between mb-1">
                            <div class="text-primary font-bold text-lg">52.980.000₫</div>
                        </div>
                        <div class="text-gray-400 text-xs line-through mb-3">55.990.000₫</div>
                        <div class="flex items-center justify-between">
                            <button class="flex items-center text-xs font-semibold text-gray-700 border border-gray-300 rounded px-2 py-1.5 hover:border-primary hover:text-primary hover:bg-orange-50 transition">
                                <i class="fas fa-shopping-cart text-primary mr-1"></i> THÊM VÀO GIỎ
                            </button>
                            <span class="text-green-600 bg-green-50 border border-green-100 px-2 py-1 rounded text-xs font-medium">Còn hàng</span>
                        </div>
                    </div>
                </div>

                <!-- Product 7 -->
                <div class="product-card border border-gray-200 rounded-lg p-3 bg-white flex flex-col relative group">
                    <span class="absolute top-2 right-2 bg-primary text-white text-xs font-bold px-2 py-1 rounded z-10">-3%</span>
                    <div class="relative overflow-hidden mb-3 h-48 flex items-center justify-center p-2">
                        <img src="https://images.unsplash.com/photo-1587831990711-23ca6441447b?auto=format&fit=crop&w=300&h=300" alt="PC Gaming" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                    </div>
                    <h3 class="text-sm font-semibold text-gray-800 mb-2 line-clamp-2 hover:text-primary cursor-pointer leading-relaxed">PC TTG GAMING CORE ULTRA 7 270K PLUS - RTX...</h3>
                    <div class="mt-auto">
                        <div class="flex items-end justify-between mb-1">
                            <div class="text-primary font-bold text-lg">68.680.000₫</div>
                        </div>
                        <div class="text-gray-400 text-xs line-through mb-3">70.990.000₫</div>
                        <div class="flex items-center justify-between">
                            <button class="flex items-center text-xs font-semibold text-gray-700 border border-gray-300 rounded px-2 py-1.5 hover:border-primary hover:text-primary hover:bg-orange-50 transition">
                                <i class="fas fa-shopping-cart text-primary mr-1"></i> THÊM VÀO GIỎ
                            </button>
                            <span class="text-green-600 bg-green-50 border border-green-100 px-2 py-1 rounded text-xs font-medium">Còn hàng</span>
                        </div>
                    </div>
                </div>

                <!-- Product 8 -->
                <div class="product-card border border-gray-200 rounded-lg p-3 bg-white flex flex-col relative group">
                    <span class="absolute top-2 right-2 bg-primary text-white text-xs font-bold px-2 py-1 rounded z-10">-4%</span>
                    <div class="relative overflow-hidden mb-3 h-48 flex items-center justify-center p-2">
                        <img src="https://images.unsplash.com/photo-1624701928517-44c8ac49d93c?auto=format&fit=crop&w=300&h=300" alt="PC Gaming" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                    </div>
                    <h3 class="text-sm font-semibold text-gray-800 mb-2 line-clamp-2 hover:text-primary cursor-pointer leading-relaxed">PC TTG GAMING CORE ULTRA 7 270K PLUS - RTX...</h3>
                    <div class="mt-auto">
                        <div class="flex items-end justify-between mb-1">
                            <div class="text-primary font-bold text-lg">54.680.000₫</div>
                        </div>
                        <div class="text-gray-400 text-xs line-through mb-3">56.990.000₫</div>
                        <div class="flex items-center justify-between">
                            <button class="flex items-center text-xs font-semibold text-gray-700 border border-gray-300 rounded px-2 py-1.5 hover:border-primary hover:text-primary hover:bg-orange-50 transition">
                                <i class="fas fa-shopping-cart text-primary mr-1"></i> THÊM VÀO GIỎ
                            </button>
                            <span class="text-green-600 bg-green-50 border border-green-100 px-2 py-1 rounded text-xs font-medium">Còn hàng</span>
                        </div>
                    </div>
                </div>

                <!-- Product 9 -->
                <div class="product-card border border-gray-200 rounded-lg p-3 bg-white flex flex-col relative group">
                    <span class="absolute top-2 right-2 bg-primary text-white text-xs font-bold px-2 py-1 rounded z-10">-4%</span>
                    <div class="relative overflow-hidden mb-3 h-48 flex items-center justify-center p-2">
                        <img src="https://images.unsplash.com/photo-1593640408182-31c70c8268f5?auto=format&fit=crop&w=300&h=300" alt="PC Gaming" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                    </div>
                    <h3 class="text-sm font-semibold text-gray-800 mb-2 line-clamp-2 hover:text-primary cursor-pointer leading-relaxed">PC TTG GAMING CORE ULTRA 7 270K PLUS - RTX...</h3>
                    <div class="mt-auto">
                        <div class="flex items-end justify-between mb-1">
                            <div class="text-primary font-bold text-lg">46.980.000₫</div>
                        </div>
                        <div class="text-gray-400 text-xs line-through mb-3">48.990.000₫</div>
                        <div class="flex items-center justify-between">
                            <button class="flex items-center text-xs font-semibold text-gray-700 border border-gray-300 rounded px-2 py-1.5 hover:border-primary hover:text-primary hover:bg-orange-50 transition">
                                <i class="fas fa-shopping-cart text-primary mr-1"></i> THÊM VÀO GIỎ
                            </button>
                            <span class="text-green-600 bg-green-50 border border-green-100 px-2 py-1 rounded text-xs font-medium">Còn hàng</span>
                        </div>
                    </div>
                </div>

                <!-- Product 10 -->
                <div class="product-card border border-gray-200 rounded-lg p-3 bg-white flex flex-col relative group">
                    <span class="absolute top-2 right-2 bg-primary text-white text-xs font-bold px-2 py-1 rounded z-10">-5%</span>
                    <div class="relative overflow-hidden mb-3 h-48 flex items-center justify-center p-2">
                        <img src="https://images.unsplash.com/photo-1541807084-5c52b6b3adef?auto=format&fit=crop&w=300&h=300" alt="PC Gaming" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                    </div>
                    <h3 class="text-sm font-semibold text-gray-800 mb-2 line-clamp-2 hover:text-primary cursor-pointer leading-relaxed">PC TTG GAMING ULTRA 7 270K PLUS - RTX 5060 Ti...</h3>
                    <div class="mt-auto">
                        <div class="flex items-end justify-between mb-1">
                            <div class="text-primary font-bold text-lg">42.680.000₫</div>
                        </div>
                        <div class="text-gray-400 text-xs line-through mb-3">44.990.000₫</div>
                        <div class="flex items-center justify-between">
                            <button class="flex items-center text-xs font-semibold text-gray-700 border border-gray-300 rounded px-2 py-1.5 hover:border-primary hover:text-primary hover:bg-orange-50 transition">
                                <i class="fas fa-shopping-cart text-primary mr-1"></i> THÊM VÀO GIỎ
                            </button>
                            <span class="text-green-600 bg-green-50 border border-green-100 px-2 py-1 rounded text-xs font-medium">Còn hàng</span>
                        </div>
                    </div>
                </div>

                <!-- Product 11 -->
                <div class="product-card border border-gray-200 rounded-lg p-3 bg-white flex flex-col relative group">
                    <span class="absolute top-2 right-2 bg-primary text-white text-xs font-bold px-2 py-1 rounded z-10">-8%</span>
                    <div class="relative overflow-hidden mb-3 h-48 flex items-center justify-center p-2">
                        <img src="https://images.unsplash.com/photo-1587831990711-23ca6441447b?auto=format&fit=crop&w=300&h=300" alt="PC Gaming" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                    </div>
                    <h3 class="text-sm font-semibold text-gray-800 mb-2 line-clamp-2 hover:text-primary cursor-pointer leading-relaxed">PC ULTRA GAMING i5 14400F - 16GB DDR4 - RTX...</h3>
                    <div class="mt-auto">
                        <div class="flex items-end justify-between mb-1">
                            <div class="text-primary font-bold text-lg">28.480.000₫</div>
                        </div>
                        <div class="text-gray-400 text-xs line-through mb-3">30.990.000₫</div>
                        <div class="flex items-center justify-between">
                            <button class="flex items-center text-xs font-semibold text-gray-700 border border-gray-300 rounded px-2 py-1.5 hover:border-primary hover:text-primary hover:bg-orange-50 transition">
                                <i class="fas fa-shopping-cart text-primary mr-1"></i> THÊM VÀO GIỎ
                            </button>
                            <span class="text-green-600 bg-green-50 border border-green-100 px-2 py-1 rounded text-xs font-medium">Còn hàng</span>
                        </div>
                    </div>
                </div>

                <!-- Product 12 -->
                <div class="product-card border border-gray-200 rounded-lg p-3 bg-white flex flex-col relative group">
                    <span class="absolute top-2 right-2 bg-primary text-white text-xs font-bold px-2 py-1 rounded z-10">-10%</span>
                    <div class="relative overflow-hidden mb-3 h-48 flex items-center justify-center p-2">
                        <img src="https://images.unsplash.com/photo-1624701928517-44c8ac49d93c?auto=format&fit=crop&w=300&h=300" alt="PC Gaming" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                    </div>
                    <h3 class="text-sm font-semibold text-gray-800 mb-2 line-clamp-2 hover:text-primary cursor-pointer leading-relaxed">PC TTG ULTRA GAMING I5 14400F - RTX 5050 8GB...</h3>
                    <div class="mt-auto">
                        <div class="flex items-end justify-between mb-1">
                            <div class="text-primary font-bold text-lg">20.680.000₫</div>
                        </div>
                        <div class="text-gray-400 text-xs line-through mb-3">22.990.000₫</div>
                        <div class="flex items-center justify-between">
                            <button class="flex items-center text-xs font-semibold text-gray-700 border border-gray-300 rounded px-2 py-1.5 hover:border-primary hover:text-primary hover:bg-orange-50 transition">
                                <i class="fas fa-shopping-cart text-primary mr-1"></i> THÊM VÀO GIỎ
                            </button>
                            <span class="text-green-600 bg-green-50 border border-green-100 px-2 py-1 rounded text-xs font-medium">Còn hàng</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Pagination -->
            <div class="mt-8 flex justify-center pb-4">
                <nav class="flex items-center space-x-1">
                    <a href="#" class="px-3 py-2 border border-gray-300 bg-white text-gray-500 hover:bg-gray-50 rounded-l-md transition"><i class="fas fa-chevron-left text-xs"></i></a>
                    <a href="#" class="px-4 py-2 border border-primary bg-primary text-white font-medium">1</a>
                    <a href="#" class="px-4 py-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition">2</a>
                    <a href="#" class="px-4 py-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition">3</a>
                    <span class="px-4 py-2 border-t border-b border-gray-300 bg-white text-gray-500">...</span>
                    <a href="#" class="px-4 py-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition">15</a>
                    <a href="#" class="px-3 py-2 border border-gray-300 bg-white text-gray-500 hover:bg-gray-50 rounded-r-md transition"><i class="fas fa-chevron-right text-xs"></i></a>
                </nav>
            </div>
        </div>
    </div>

    <!-- Features Section (From Homepage) -->
    <section class="bg-white py-10 mt-12 rounded-lg mb-8 border border-gray-100 shadow-sm">
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
