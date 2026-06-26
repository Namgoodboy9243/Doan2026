@extends('layouts.app')

@section('title', $categoryName . ' - SPATACUS')

@section('content')

    <!-- Breadcrumb -->
    <div class="text-sm text-gray-500 mb-4 px-2">
        Trang chủ &gt; <span class="font-bold text-gray-800 uppercase">{{ $categoryName }}</span>
    </div>

    <!-- Notice Banner -->
    <div class="bg-white p-6 rounded-lg mb-6 border border-gray-100 shadow-sm text-sm text-gray-700 leading-relaxed">
        <div class="font-bold mb-4 text-base"><span class="text-yellow-400">🌟</span> SPATACUS | HỆ THỐNG PHÂN PHỐI {{ mb_strtoupper($categoryName) }} CHÍNH HÃNG!</div>
        <p class="mb-4">Chào toàn thể các anh em yêu công nghệ, siêu thị chuyên biệt **Spatacus Laptop** là nơi phân phối các sản phẩm công nghệ đỉnh cao, tập trung hoàn toàn vào các dòng Laptop Gaming, Laptop Văn Phòng, Ultrabook Mỏng Nhẹ & MacBook Series chính hãng với giá tốt nhất thị trường 🥇</p>
        <p class="mb-4"><span class="text-yellow-400">👉</span> Bạn muốn tìm dòng Laptop mỏng nhẹ, tối ưu về giá hay một cỗ máy Gaming chiến game đỉnh cao? Nhắn tin ngay 💌 Spatacus Laptop sẵn sàng tư vấn cấu hình phù hợp và hỗ trợ trả góp 0% nhanh gọn 💪</p>
        <p class="mb-4"><span class="text-yellow-400">👉</span> Mọi sản phẩm bán ra đều được tặng kèm bộ quà tặng cực chất: Balo chống sốc cao cấp + Chuột không dây chính hãng + Lót chuột size lớn 🤝</p>
        <p class="mb-2 text-gray-400"><span class="text-yellow-400 opacity-50">👉</span> Và đặc biệt, để tri ân khách hàng, chúng mình sẽ dành tặng 10 chiếc áo khoác Bomber giới hạn độc quyền cho 10 khách hàng đầu tiên đặt mua Laptop tại SPATACUS.</p>
    </div>

    <div class="flex flex-col md:flex-row gap-6">
        <!-- Sidebar / Filters Form -->
        <form action="{{ url('category') }}" method="GET" id="filter-form" class="w-full md:w-[280px] flex-shrink-0">
            <input type="hidden" name="type" value="{{ $type }}">
            <input type="hidden" name="sort" id="sort-hidden-input" value="{{ $sort }}">

            <button type="submit" class="w-full bg-primary text-white font-bold py-3 px-4 mb-4 rounded flex items-center justify-center hover:bg-orange-600 transition shadow-md uppercase text-sm tracking-wider">
                <i class="fas fa-filter mr-2"></i> LỌC SẢN PHẨM
            </button>

            <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                <!-- Categories -->
                <div class="p-4 border-b border-gray-200">
                    <h3 class="font-bold text-gray-800 mb-3 uppercase text-xs tracking-wider">Dòng Laptop</h3>
                    <ul class="space-y-3 text-sm text-gray-700">
                        <li><a href="{{ url('category?type=gaming') }}" class="flex items-center hover:text-primary transition {{ $type === 'gaming' ? 'text-primary font-bold' : '' }}"><i class="fas fa-angle-double-right text-gray-400 mr-2 text-xs"></i> LAPTOP GAMING</a></li>
                        <li class="border-t border-dashed border-gray-200 pt-2"><a href="{{ url('category?type=van-phong') }}" class="flex items-center hover:text-primary transition {{ $type === 'van-phong' ? 'text-primary font-bold' : '' }}"><i class="fas fa-angle-double-right text-gray-400 mr-2 text-xs"></i> ULTRABOOK MỎNG NHẸ</a></li>
                        <li class="border-t border-dashed border-gray-200 pt-2"><a href="{{ url('category?type=do-hoa') }}" class="flex items-center hover:text-primary transition {{ $type === 'do-hoa' ? 'text-primary font-bold' : '' }}"><i class="fas fa-angle-double-right text-gray-400 mr-2 text-xs"></i> LAPTOP ĐỒ HỌA & WORKSTATION</a></li>
                        <li class="border-t border-dashed border-gray-200 pt-2"><a href="{{ url('category?type=macbook') }}" class="flex items-center hover:text-primary transition {{ $type === 'macbook' ? 'text-primary font-bold' : '' }}"><i class="fas fa-angle-double-right text-gray-400 mr-2 text-xs"></i> MACBOOK & SURFACE</a></li>
                    </ul>
                </div>

                <!-- Price Range -->
                <div class="p-4 border-b border-gray-200">
                    <h3 class="font-bold text-gray-800 mb-3 uppercase text-xs tracking-wider">Khoảng giá</h3>
                    <div class="space-y-2 text-sm text-gray-700">
                        @php
                            $ranges = [
                                '0-15' => 'Dưới 15 triệu',
                                '15-20' => '15 triệu - 20 triệu',
                                '20-25' => '20 triệu - 25 triệu',
                                '25-35' => '25 triệu - 35 triệu',
                                '35-45' => '35 triệu - 45 triệu',
                                '45-60' => '45 triệu - 60 triệu',
                                '60-80' => '60 triệu - 80 triệu',
                                '80-100' => '80 triệu - 100 triệu',
                                '100-150' => '100 triệu - 150 triệu',
                                'above-150' => 'Trên 150 triệu'
                            ];
                        @endphp
                        @foreach($ranges as $val => $label)
                            <label class="flex items-center cursor-pointer hover:text-primary group">
                                <input type="checkbox" name="price_ranges[]" value="{{ $val }}" onchange="submitFilterForm()" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4" {{ in_array($val, $selectedPrices) ? 'checked' : '' }}>
                                <span class="group-hover:translate-x-1 transition-transform">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Brands -->
                <div class="p-4 border-b border-gray-200">
                    <h3 class="font-bold text-gray-800 mb-3 uppercase text-xs tracking-wider">Thương hiệu</h3>
                    <div class="space-y-2 text-sm text-gray-700">
                        @foreach($brandCounts as $brand => $count)
                            @if($count > 0 || in_array($brand, $selectedBrands))
                            <label class="flex items-center cursor-pointer hover:text-primary group">
                                <input type="checkbox" name="brands[]" value="{{ $brand }}" onchange="submitFilterForm()" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4" {{ in_array($brand, $selectedBrands) ? 'checked' : '' }}>
                                <span class="group-hover:translate-x-1 transition-transform">{{ $brand }} ({{ $count }})</span>
                            </label>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- CPU -->
                <div class="p-4 border-b border-gray-200">
                    <h3 class="font-bold text-gray-800 mb-3 uppercase text-xs tracking-wider">Dòng CPU</h3>
                    <div class="space-y-2 text-sm text-gray-700 max-h-56 overflow-y-auto pr-2" style="scrollbar-width: thin;">
                        @foreach($cpuCounts as $cpu => $count)
                            @if($count > 0 || in_array($cpu, $selectedCpus))
                            <label class="flex items-center cursor-pointer hover:text-primary group">
                                <input type="checkbox" name="cpus[]" value="{{ $cpu }}" onchange="submitFilterForm()" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4" {{ in_array($cpu, $selectedCpus) ? 'checked' : '' }}>
                                <span class="group-hover:translate-x-1 transition-transform">{{ $cpu }} ({{ $count }})</span>
                            </label>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- RAM -->
                <div class="p-4">
                    <h3 class="font-bold text-gray-800 mb-3 uppercase text-xs tracking-wider">Dung Lượng RAM</h3>
                    <div class="space-y-2 text-sm text-gray-700">
                        @foreach($ramCounts as $ram => $count)
                            @if($count > 0 || in_array($ram, $selectedRams))
                            <label class="flex items-center cursor-pointer hover:text-primary group">
                                <input type="checkbox" name="rams[]" value="{{ $ram }}" onchange="submitFilterForm()" class="mr-3 rounded border-gray-300 text-primary focus:ring-primary w-4 h-4" {{ in_array($ram, $selectedRams) ? 'checked' : '' }}>
                                <span class="group-hover:translate-x-1 transition-transform">{{ $ram }} ({{ $count }})</span>
                            </label>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </form>

        <!-- Main Content (Product Grid) -->
        <div class="flex-grow bg-white p-5 rounded-lg border border-gray-200 shadow-sm">
            <div class="flex justify-between items-center mb-5 pb-3 border-b border-gray-200">
                <div class="font-bold text-gray-800">Tìm thấy <span class="text-primary font-black">{{ $products->total() }}</span> sản phẩm</div>
                <div class="flex items-center">
                    <select onchange="updateSort(this.value)" class="border border-gray-300 rounded px-3 py-1.5 text-sm text-gray-800 font-medium focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                        <option value="" {{ $sort === '' ? 'selected' : '' }}>Sắp xếp theo</option>
                        <option value="price-asc" {{ $sort === 'price-asc' ? 'selected' : '' }}>Giá tăng dần</option>
                        <option value="price-desc" {{ $sort === 'price-desc' ? 'selected' : '' }}>Giá giảm dần</option>
                        <option value="name-asc" {{ $sort === 'name-asc' ? 'selected' : '' }}>Tên A-Z</option>
                    </select>
                </div>
            </div>

            <!-- Product Grid -->
            @if($products->isEmpty())
                <div class="text-center py-16 flex flex-col items-center justify-center">
                    <div class="w-24 h-24 rounded-full bg-orange-50/70 flex items-center justify-center text-primary mb-4 shadow-inner">
                        <i class="fas fa-search-minus text-4xl"></i>
                    </div>
                    <h3 class="text-gray-800 font-black text-lg mb-2">Không tìm thấy sản phẩm nào!</h3>
                    <p class="text-gray-400 text-sm mb-6 max-w-sm leading-relaxed mx-auto">
                        Thử điều chỉnh bộ lọc hoặc chọn dòng sản phẩm khác để xem thêm kết quả phù hợp.
                    </p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    @foreach($products as $product)
                        <div class="product-card border border-gray-200 rounded-lg p-3 bg-white flex flex-col relative group shadow-sm transition hover:shadow-lg">
                            @if($product->sale_price && $product->sale_price < $product->price)
                                <span class="absolute top-2 right-2 bg-primary text-white text-xs font-bold px-2 py-1 rounded z-10">
                                    -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                                </span>
                            @endif
                            <a href="{{ route('product.detail', $product->id) }}" class="relative overflow-hidden mb-3 h-48 flex items-center justify-center p-2 bg-gray-50/50 rounded-md">
                                <img src="{{ (preg_match('/^https?:\/\//', $product->image) || empty($product->image)) ? ($product->image ?: 'https://images.unsplash.com/photo-1587831990711-23ca6441447b?auto=format&fit=crop&w=300&h=300') : asset('images/products/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                            </a>
                            <a href="{{ route('product.detail', $product->id) }}">
                                <h3 class="text-sm font-bold text-gray-800 mb-2 line-clamp-2 hover:text-primary cursor-pointer leading-snug">{{ $product->name }}</h3>
                            </a>
                            
                            <!-- Specs Box -->
                            @if(!empty($product->cpu) || !empty($product->ram) || !empty($product->storage) || !empty($product->color))
                            <div class="bg-gray-50 border border-gray-100 rounded-md p-2 mb-3 text-[11px] text-gray-600 font-medium tracking-wide">
                                <div class="grid grid-cols-2 gap-x-2 gap-y-1">
                                    @if(!empty($product->cpu))
                                        <div class="flex items-center truncate">
                                            <i class="fas fa-microchip text-gray-400 mr-1.5 w-3.5 text-center text-[10px]"></i>
                                            <span class="truncate text-gray-700 font-bold">{{ $product->cpu }}</span>
                                        </div>
                                    @endif
                                    @if(!empty($product->ram))
                                        <div class="flex items-center truncate">
                                            <i class="fas fa-memory text-gray-400 mr-1.5 w-3.5 text-center text-[10px]"></i>
                                            <span class="truncate text-gray-700 font-bold">{{ $product->ram }}</span>
                                        </div>
                                    @endif
                                    @if(!empty($product->storage))
                                        <div class="flex items-center truncate col-span-2 mt-1 pt-1 border-t border-gray-200/50">
                                            <i class="fas fa-hdd text-gray-400 mr-1.5 w-3.5 text-center text-[10px]"></i>
                                            <span class="truncate text-gray-700 font-bold">{{ $product->storage }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <div class="mt-auto">
                                @if($product->sale_price && $product->sale_price < $product->price)
                                    <div class="text-primary font-bold text-lg">{{ number_format($product->sale_price, 0, ',', '.') }}₫</div>
                                    <div class="text-gray-400 text-xs line-through mb-3">{{ number_format($product->price, 0, ',', '.') }}₫</div>
                                @else
                                    <div class="text-primary font-bold text-lg mb-3">{{ number_format($product->price, 0, ',', '.') }}₫</div>
                                @endif
                                <div class="flex items-center justify-between mt-2 pt-2 border-t border-gray-100">
                                    <button onclick="addToCartAjax({{ $product->id }}, null, 1, this)" class="flex items-center text-[11px] font-black text-gray-700 border border-gray-300 rounded px-2.5 py-1.5 hover:border-primary hover:text-primary hover:bg-orange-50 transition uppercase">
                                        <i class="fas fa-shopping-cart text-primary mr-1"></i> Thêm vào giỏ
                                    </button>
                                    @if($product->status == 1)
                                        <span class="text-green-600 bg-green-50 border border-green-100 px-2 py-0.5 rounded text-[10px] font-bold">Còn hàng</span>
                                    @else
                                        <span class="text-red-600 bg-red-50 border border-red-100 px-2 py-0.5 rounded text-[10px] font-bold">Hết hàng</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Custom Pagination -->
                @if($products->hasPages())
                    <div class="mt-12 flex justify-center pb-4">
                        <nav class="flex items-center space-x-1">
                            {{-- Previous Page Link --}}
                            @if ($products->onFirstPage())
                                <span class="px-3 py-2 border border-gray-200 bg-gray-55 text-gray-400 rounded-l-md cursor-not-allowed"><i class="fas fa-chevron-left text-xs"></i></span>
                            @else
                                <a href="{{ $products->previousPageUrl() }}" class="px-3 py-2 border border-gray-200 bg-white text-gray-500 hover:bg-gray-55 rounded-l-md transition"><i class="fas fa-chevron-left text-xs"></i></a>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                @if ($page == $products->currentPage())
                                    <span class="px-4 py-2 border border-primary bg-primary text-white font-bold">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="px-4 py-2 border border-gray-200 bg-white text-gray-700 hover:bg-gray-55 transition font-bold">{{ $page }}</a>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($products->hasMorePages())
                                <a href="{{ $products->nextPageUrl() }}" class="px-3 py-2 border border-gray-200 bg-white text-gray-500 hover:bg-gray-55 rounded-r-md transition"><i class="fas fa-chevron-right text-xs"></i></a>
                            @else
                                <span class="px-3 py-2 border border-gray-200 bg-gray-55 text-gray-400 rounded-r-md cursor-not-allowed"><i class="fas fa-chevron-right text-xs"></i></span>
                            @endif
                        </nav>
                    </div>
                @endif
            @endif
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
                <p class="text-gray-800 font-semibold mb-1">Trải nghiệm mua sắm tại <span class="text-primary font-bold">SPATACUS</span></p>
                <h2 class="text-4xl font-bold mt-2">Cam Kết 100% <span class="text-primary">Hài Lòng</span></h2>
            </div>
        </div>
    </section>

    <script>
        function submitFilterForm() {
            document.getElementById('filter-form').submit();
        }

        function updateSort(val) {
            document.getElementById('sort-hidden-input').value = val;
            submitFilterForm();
        }
    </script>

@endsection
