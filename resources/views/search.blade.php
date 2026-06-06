@extends('layouts.app')

@section('title', 'Tìm kiếm Laptop - SPATACUS')

@section('content')

    <!-- Breadcrumb -->
    <div class="text-sm text-gray-500 mb-6 px-2">
        Trang chủ &gt; <span class="font-bold text-gray-800 uppercase">Tìm kiếm Laptop</span>
    </div>

    <!-- Notice Banner -->
    <div class="bg-white p-6 rounded-lg mb-6 border border-gray-100 shadow-sm text-sm text-gray-700 leading-relaxed">
        <div class="font-bold mb-2 text-base flex items-center gap-2">
            <span class="text-yellow-400 text-lg">🔍</span> 
            <span>Kết quả tìm kiếm cho từ khóa: </span>
            <span class="text-primary font-black italic">"{{ $q ?: 'Tất cả Laptop' }}"</span>
            @if(!empty($selectedCategory))
                <span class="text-gray-400 font-medium">trong danh mục</span>
                <span class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded-md font-bold border border-gray-200">
                    @if($selectedCategory === 'gaming') Laptop Gaming
                    @elseif($selectedCategory === 'van-phong') Laptop Văn Phòng
                    @elseif($selectedCategory === 'macbook') MacBook & Surface
                    @elseif($selectedCategory === 'do-hoa') Laptop Đồ Họa
                    @endif
                </span>
            @endif
        </div>
        <p class="text-gray-500">Hệ thống SPATACUS đang hiển thị các sản phẩm được truy xuất động từ cơ sở dữ liệu phù hợp với nhu cầu của bạn. Mọi sản phẩm mua tại cửa hàng đều được hỗ trợ trả góp lãi suất 0% và bảo hành vàng 24 tháng.</p>
    </div>

    <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm mb-8">
        <!-- Search Results Count -->
        <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-200">
            <div class="font-bold text-gray-800 text-base">
                Tìm thấy <span class="text-primary font-black">{{ $products->total() }}</span> sản phẩm phù hợp
            </div>
            <div>
                <a href="{{ url('index') }}" class="text-xs text-blue-600 hover:text-blue-800 font-bold flex items-center gap-1.5 hover:underline">
                    <i class="fas fa-arrow-left"></i> Quay lại trang chủ
                </a>
            </div>
        </div>

        @if($products->isEmpty())
            <!-- Empty State / No Results -->
            <div class="text-center py-16 flex flex-col items-center justify-center">
                <div class="w-24 h-24 rounded-full bg-orange-50/70 flex items-center justify-center text-primary mb-4 shadow-inner">
                    <i class="fas fa-search-minus text-4xl"></i>
                </div>
                <h3 class="text-gray-800 font-black text-lg mb-2">Không tìm thấy Laptop nào phù hợp!</h3>
                <p class="text-gray-400 text-sm mb-6 max-w-sm leading-relaxed mx-auto">
                    Rất tiếc, chúng tôi không tìm thấy dòng laptop nào phù hợp với từ khóa <strong class="text-gray-700">"{{ $q }}"</strong>. Quý khách vui lòng thử tìm kiếm lại với các cụm từ phổ biến hơn như "Lenovo", "gaming", "Thinkpad" hoặc "msi".
                </p>
                <a href="{{ url('index') }}" class="bg-primary hover:bg-orange-600 text-white font-bold px-6 py-2.5 rounded-lg transition transform hover:-translate-y-0.5 active:translate-y-0 shadow-md">
                    QUAY LẠI TRANG CHỦ
                </a>
            </div>
        @else
            <!-- Product Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="product-card border border-gray-200 rounded-lg p-3 bg-white flex flex-col relative group shadow-sm transition hover:shadow-lg">
                        @if($product->sale_price && $product->sale_price < $product->price)
                            <span class="absolute top-2 right-2 bg-primary text-white text-xs font-bold px-2 py-1 rounded z-10">
                                -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                            </span>
                        @endif
                        
                        <!-- Image Container -->
                        <a href="{{ route('product.detail', $product->id) }}" class="relative overflow-hidden mb-3 h-48 flex items-center justify-center p-2 bg-gray-50/50 rounded-md">
                            <img src="{{ (preg_match('/^https?:\/\//', $product->image) || empty($product->image)) ? ($product->image ?: 'https://images.unsplash.com/photo-1587831990711-23ca6441447b?auto=format&fit=crop&w=300&h=300') : asset('images/products/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                        </a>

                        <!-- Title -->
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
                        
                        <!-- Pricing and Actions -->
                        <div class="mt-auto">
                            @if($product->sale_price && $product->sale_price < $product->price)
                                <div class="text-primary font-black text-lg">{{ number_format($product->sale_price, 0, ',', '.') }}₫</div>
                                <div class="text-gray-400 text-xs line-through mb-3 font-semibold">{{ number_format($product->price, 0, ',', '.') }}₫</div>
                            @else
                                <div class="text-primary font-black text-lg mb-3">{{ number_format($product->price, 0, ',', '.') }}₫</div>
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

            <!-- Custom Premium Pagination Block -->
            @if($products->hasPages())
                <div class="mt-12 flex justify-center pb-4">
                    <nav class="flex items-center space-x-1">
                        {{-- Previous Page Link --}}
                        @if ($products->onFirstPage())
                            <span class="px-3 py-2 border border-gray-200 bg-gray-50 text-gray-400 rounded-l-md cursor-not-allowed"><i class="fas fa-chevron-left text-xs"></i></span>
                        @else
                            <a href="{{ $products->previousPageUrl() }}" class="px-3 py-2 border border-gray-200 bg-white text-gray-500 hover:bg-gray-50 rounded-l-md transition"><i class="fas fa-chevron-left text-xs"></i></a>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                            @if ($page == $products->currentPage())
                                <span class="px-4 py-2 border border-primary bg-primary text-white font-bold">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="px-4 py-2 border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 transition font-bold">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($products->hasMorePages())
                            <a href="{{ $products->nextPageUrl() }}" class="px-3 py-2 border border-gray-200 bg-white text-gray-500 hover:bg-gray-50 rounded-r-md transition"><i class="fas fa-chevron-right text-xs"></i></a>
                        @else
                            <span class="px-3 py-2 border border-gray-200 bg-gray-50 text-gray-400 rounded-r-md cursor-not-allowed"><i class="fas fa-chevron-right text-xs"></i></span>
                        @endif
                    </nav>
                </div>
            @endif
        @endif
    </div>

@endsection
