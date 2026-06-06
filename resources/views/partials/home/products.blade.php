<!-- LAPTOP GAMING Section -->
<section class="mb-8 bg-white p-4 rounded-lg shadow-sm border border-gray-100">
    <div class="flex items-center justify-between border-b border-gray-200 pb-0 mb-4">
        <div class="flex items-end">
            <div class="bg-primary text-white font-bold px-8 py-2 skew-bg -ml-2 mr-6 inline-block">
                <span class="unskew-text text-lg">LAPTOP GAMING BÁN CHẠY</span>
            </div>
            <div class="flex space-x-2 text-sm font-semibold text-gray-500 pb-2">
                <a href="#" class="px-3 py-1 bg-gray-100 text-gray-800 rounded">LAPTOP GAMING GIÁ RẺ</a>
                <a href="#" class="px-3 py-1 hover:text-primary transition">RTX 40 SERIES</a>
                <a href="#" class="px-3 py-1 hover:text-primary transition">CPU AMD RYZEN</a>
                <a href="#" class="px-3 py-1 hover:text-primary transition">LAPTOP HI-END</a>
            </div>
        </div>
        <a href="#" class="text-blue-600 text-sm hover:underline font-medium pb-2">Xem tất cả >></a>
    </div>

    <div class="grid grid-cols-5 gap-4">
        @forelse($gamingProducts as $product)
            <div class="product-card border border-gray-200 rounded-lg p-3 bg-white flex flex-col relative group">
                @if($product->sale_price && $product->sale_price < $product->price)
                    <span class="absolute top-2 right-2 bg-primary text-white text-xs font-bold px-2 py-1 rounded z-10">
                        -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                    </span>
                @endif
                <a href="{{ route('product.detail', $product->id) }}" class="relative overflow-hidden mb-3 h-40 flex items-center justify-center">
                    <img src="{{ (preg_match('/^https?:\/\//', $product->image) || empty($product->image)) ? ($product->image ?: 'https://images.unsplash.com/photo-1587831990711-23ca6441447b?auto=format&fit=crop&w=200&h=200') : asset('images/products/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                </a>
                <a href="{{ route('product.detail', $product->id) }}">
                    <h3 class="text-sm font-semibold text-gray-800 mb-2 line-clamp-2 hover:text-primary cursor-pointer">{{ $product->name }}</h3>
                </a>
                @if(!empty($product->cpu) || !empty($product->ram) || !empty($product->storage))
                <!-- Hộp thông số sản phẩm (Specs Box) -->
                <div class="bg-gray-50/90 border border-gray-100 rounded-md p-2 mb-3 text-[11px] text-gray-600 font-medium tracking-wide">
                    <div class="grid grid-cols-2 gap-x-2 gap-y-1">
                        @if(!empty($product->cpu))
                            <div class="flex items-center truncate">
                                <i class="fas fa-microchip text-gray-400 mr-1.5 w-3.5 text-center text-[10px]"></i>
                                <span class="truncate text-gray-700 font-semibold">{{ $product->cpu }}</span>
                            </div>
                        @endif
                        @if(!empty($product->ram))
                            <div class="flex items-center truncate">
                                <i class="fas fa-memory text-gray-400 mr-1.5 w-3.5 text-center text-[10px]"></i>
                                <span class="truncate text-gray-700 font-semibold">{{ $product->ram }}</span>
                            </div>
                        @endif
                        @if(!empty($product->storage))
                            <div class="flex items-center truncate col-span-2 mt-1 pt-1 border-t border-gray-200/50">
                                <i class="fas fa-hdd text-gray-400 mr-1.5 w-3.5 text-center text-[10px]"></i>
                                <span class="truncate text-gray-700 font-semibold">{{ $product->storage }}</span>
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
                    <div class="flex items-center justify-between">
                        <button onclick="addToCartAjax({{ $product->id }}, null, 1, this)" class="flex items-center text-xs font-semibold text-gray-700 border border-gray-300 rounded px-2 py-1.5 hover:border-primary hover:text-primary hover:bg-orange-50 transition">
                            <i class="fas fa-shopping-cart text-primary mr-1"></i> THÊM VÀO GIỎ
                        </button>
                        @if($product->status == 1)
                            <span class="text-green-600 bg-green-50 border border-green-100 px-2 py-1 rounded text-xs font-medium">Còn hàng</span>
                        @else
                            <span class="text-red-600 bg-red-50 border border-red-100 px-2 py-1 rounded text-xs font-medium">Hết hàng</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-5 text-center text-gray-500 py-8">
                Không tìm thấy sản phẩm Laptop Gaming nào.
            </div>
        @endforelse
    </div>
</section>

<!-- LAPTOP VĂN PHÒNG & ULTRABOOK Section -->
<section class="mb-8 bg-white p-4 rounded-lg shadow-sm border border-gray-100">
    <div class="flex items-center justify-between border-b border-gray-200 pb-0 mb-4">
        <div class="flex items-end">
            <div class="bg-primary text-white font-bold px-8 py-2 skew-bg -ml-2 mr-6 inline-block">
                <span class="unskew-text text-lg">LAPTOP VĂN PHÒNG & ULTRABOOK CAO CẤP</span>
            </div>
        </div>
        <a href="#" class="text-blue-600 text-sm hover:underline font-medium pb-2">Xem tất cả >></a>
    </div>

    <div class="grid grid-cols-5 gap-4">
        @forelse($workstationProducts as $product)
            <div class="product-card border border-gray-200 rounded-lg p-3 bg-white flex flex-col relative group">
                @if($product->sale_price && $product->sale_price < $product->price)
                    <span class="absolute top-2 right-2 bg-primary text-white text-xs font-bold px-2 py-1 rounded z-10">
                        -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                    </span>
                @endif
                <a href="{{ route('product.detail', $product->id) }}" class="relative overflow-hidden mb-3 h-40 flex items-center justify-center">
                    <img src="{{ (preg_match('/^https?:\/\//', $product->image) || empty($product->image)) ? ($product->image ?: 'https://images.unsplash.com/photo-1541807084-5c52b6b3adef?auto=format&fit=crop&w=200&h=200') : asset('images/products/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                </a>
                <a href="{{ route('product.detail', $product->id) }}">
                    <h3 class="text-sm font-semibold text-gray-800 mb-2 line-clamp-2 hover:text-primary cursor-pointer">{{ $product->name }}</h3>
                </a>
                @if(!empty($product->cpu) || !empty($product->ram) || !empty($product->storage))
                <!-- Hộp thông số sản phẩm (Specs Box) -->
                <div class="bg-gray-50/90 border border-gray-100 rounded-md p-2 mb-3 text-[11px] text-gray-600 font-medium tracking-wide">
                    <div class="grid grid-cols-2 gap-x-2 gap-y-1">
                        @if(!empty($product->cpu))
                            <div class="flex items-center truncate">
                                <i class="fas fa-microchip text-gray-400 mr-1.5 w-3.5 text-center text-[10px]"></i>
                                <span class="truncate text-gray-700 font-semibold">{{ $product->cpu }}</span>
                            </div>
                        @endif
                        @if(!empty($product->ram))
                            <div class="flex items-center truncate">
                                <i class="fas fa-memory text-gray-400 mr-1.5 w-3.5 text-center text-[10px]"></i>
                                <span class="truncate text-gray-700 font-semibold">{{ $product->ram }}</span>
                            </div>
                        @endif
                        @if(!empty($product->storage))
                            <div class="flex items-center truncate col-span-2 mt-1 pt-1 border-t border-gray-200/50">
                                <i class="fas fa-hdd text-gray-400 mr-1.5 w-3.5 text-center text-[10px]"></i>
                                <span class="truncate text-gray-700 font-semibold">{{ $product->storage }}</span>
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
                    <div class="flex items-center justify-between">
                        <button onclick="addToCartAjax({{ $product->id }}, null, 1, this)" class="flex items-center text-xs font-semibold text-gray-700 border border-gray-300 rounded px-2 py-1.5 hover:border-primary hover:text-primary hover:bg-orange-50 transition">
                            <i class="fas fa-shopping-cart text-primary mr-1"></i> THÊM VÀO GIỎ
                        </button>
                        @if($product->status == 1)
                            <span class="text-green-600 bg-green-50 border border-green-100 px-2 py-1 rounded text-xs font-medium">Còn hàng</span>
                        @else
                            <span class="text-red-600 bg-red-50 border border-red-100 px-2 py-1 rounded text-xs font-medium">Hết hàng</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-5 text-center text-gray-500 py-8">
                Không tìm thấy sản phẩm Laptop Văn Phòng/Ultrabook nào.
            </div>
        @endforelse
    </div>
</section>
