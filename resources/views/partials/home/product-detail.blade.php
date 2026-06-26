<!-- Breadcrumbs -->
<nav class="flex text-xs font-semibold text-gray-500 mb-6 py-2 px-3 bg-white rounded-md border border-gray-100 shadow-sm">
    <a href="{{ route('product.detail', $product->id) }}" class="hover:text-primary transition">Trang chủ</a>
    <span class="mx-2 text-gray-400">/</span>
    <span class="text-gray-400">Chi tiết sản phẩm</span>
    <span class="mx-2 text-gray-400">/</span>
    <span class="text-gray-800 truncate font-bold">{{ $product->name }}</span>
</nav>

<!-- Main Details -->
<div class="grid grid-cols-1 md:grid-cols-12 gap-8 mb-8">
    <!-- Left Column: Image Gallery -->
    <div class="md:col-span-5 bg-white p-4 rounded-lg shadow-sm border border-gray-100">
        <!-- Main Image Container -->
        <div class="relative overflow-hidden border border-gray-100 rounded-lg h-96 flex items-center justify-center bg-white group mb-4">
            <img id="main-image" 
                 src="{{ (preg_match('/^https?:\/\//', $product->image) || empty($product->image)) ? ($product->image ?: 'https://images.unsplash.com/photo-1587831990711-23ca6441447b?auto=format&fit=crop&w=600&h=600') : asset('images/products/' . $product->image) }}" 
                 alt="{{ $product->name }}" 
                 class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-105">
            
            @if($product->sale_price && $product->sale_price < $product->price)
                <span class="absolute top-3 left-3 bg-primary text-white text-xs font-bold px-2.5 py-1 rounded shadow-sm">
                    GIẢM {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                </span>
            @endif
        </div>

        <!-- Thumbnail Slider -->
        <div class="flex gap-2 overflow-x-auto pb-1 scrollbar-thin">
            <!-- First Thumbnail: Main Product Image -->
            <div class="thumbnail-item border-2 border-primary rounded p-1 w-16 h-16 flex-shrink-0 cursor-pointer bg-white flex items-center justify-center transition" 
                 onclick="changeImage(this, '{{ (preg_match('/^https?:\/\//', $product->image) || empty($product->image)) ? ($product->image ?: 'https://images.unsplash.com/photo-1587831990711-23ca6441447b?auto=format&fit=crop&w=600&h=600') : asset('images/products/' . $product->image) }}')">
                <img src="{{ (preg_match('/^https?:\/\//', $product->image) || empty($product->image)) ? ($product->image ?: 'https://images.unsplash.com/photo-1587831990711-23ca6441447b?auto=format&fit=crop&w=100&h=100') : asset('images/products/' . $product->image) }}" class="w-full h-full object-contain">
            </div>

            <!-- Additional Images from DB -->
            @foreach($images as $img)
                <div class="thumbnail-item border border-gray-200 hover:border-primary rounded p-1 w-16 h-16 flex-shrink-0 cursor-pointer bg-white flex items-center justify-center transition" 
                     onclick="changeImage(this, '{{ preg_match('/^https?:\/\//', $img->image) ? $img->image : asset('images/products/' . $img->image) }}')">
                    <img src="{{ preg_match('/^https?:\/\//', $img->image) ? $img->image : asset('images/products/' . $img->image) }}" class="w-full h-full object-contain">
                </div>
            @endforeach
        </div>
    </div>

    <!-- Right Column: Product Info & Purchase options -->
    <div class="md:col-span-7 bg-white p-6 rounded-lg shadow-sm border border-gray-100 flex flex-col">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
        
        <div class="flex items-center gap-4 text-xs font-semibold text-gray-500 mb-4 pb-4 border-b border-gray-100">
            <div class="flex text-yellow-400 gap-0.5">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= floor($averageRating))
                        <i class="fas fa-star"></i>
                    @elseif($i - $averageRating < 1 && $i - $averageRating > 0)
                        <i class="fas fa-star-half-alt"></i>
                    @else
                        <i class="far fa-star text-gray-300"></i>
                    @endif
                @endfor
            </div>
            <span>|</span>
            <span class="text-gray-700 font-bold">{{ number_format($averageRating, 1) }} ({{ $commentsCount }} đánh giá)</span>
            <span>|</span>
            <span id="stock-badge" class="text-green-600 bg-green-50 border border-green-100 px-2 py-0.5 rounded font-bold">Còn hàng</span>
        </div>

        <!-- Prices -->
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100/50 mb-6">
            <div class="flex items-end gap-3 mb-1">
                <span id="display-price" class="text-3xl font-black text-primary">
                    {{ number_format($product->sale_price ?: $product->price, 0, ',', '.') }}₫
                </span>
                @if($product->sale_price && $product->sale_price < $product->price)
                    <span class="text-sm font-semibold text-gray-400 line-through mb-1">
                        {{ number_format($product->price, 0, ',', '.') }}₫
                    </span>
                @endif
            </div>
            <span class="text-[10px] text-gray-400 font-bold tracking-wider">MÃ SKU: <span id="display-sku" class="text-gray-600 font-black">{{ $product->id }}</span></span>
        </div>

        <!-- Variant Selector -->
        @if($variants->isNotEmpty())
            <div class="mb-6">
                <h3 class="text-xs font-black text-gray-900 uppercase tracking-wider mb-3">Chọn phiên bản cấu hình:</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach($variants as $index => $variant)
                        <div class="variant-card border {{ $index === 0 ? 'border-primary bg-orange-50/20' : 'border-gray-200 hover:border-primary/50' }} rounded-lg p-3 cursor-pointer transition relative flex flex-col justify-between" 
                             onclick="selectVariant(this, {{ $variant->id }})">
                            
                            @if($index === 0)
                                <div class="absolute -top-1.5 -right-1.5 bg-primary text-white text-[8px] font-black px-1.5 py-0.5 rounded-full shadow-sm">
                                    ĐANG CHỌN
                                </div>
                            @endif

                            <div>
                                <span class="text-[10px] text-gray-400 font-black tracking-widest block uppercase mb-1">{{ $variant->sku }}</span>
                                <div class="text-xs font-bold text-gray-800 space-y-1">
                                    @if($variant->cpu)
                                        <div class="flex items-center"><i class="fas fa-microchip text-gray-400 mr-2 w-3 text-center text-[10px]"></i> {{ $variant->cpu }}</div>
                                    @endif
                                    @if($variant->ram)
                                        <div class="flex items-center"><i class="fas fa-memory text-gray-400 mr-2 w-3 text-center text-[10px]"></i> {{ $variant->ram }}</div>
                                    @endif
                                    @if($variant->storage)
                                        <div class="flex items-center"><i class="fas fa-hdd text-gray-400 mr-2 w-3 text-center text-[10px]"></i> {{ $variant->storage }}</div>
                                    @endif
                                    @if($variant->color)
                                        <div class="flex items-center"><i class="fas fa-palette text-gray-400 mr-2 w-3 text-center text-[10px]"></i> Màu: {{ $variant->color }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-3 pt-2 border-t border-gray-100 flex items-center justify-between">
                                <span class="text-xs text-gray-400 font-semibold">Giá phiên bản:</span>
                                <span class="text-sm font-black text-primary">{{ number_format($variant->price, 0, ',', '.') }}₫</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Trust Features -->
        <div class="grid grid-cols-3 gap-2 py-3 px-2 border-y border-gray-100 text-center text-[10px] font-semibold text-gray-600 mb-6 bg-slate-50 rounded-md">
            <div>
                <i class="fas fa-shield-alt text-primary mb-1 text-sm"></i>
                <p>100% Chính Hãng</p>
            </div>
            <div>
                <i class="fas fa-truck text-primary mb-1 text-sm"></i>
                <p>Giao Hàng Miễn Phí</p>
            </div>
            <div>
                <i class="fas fa-history text-primary mb-1 text-sm"></i>
                <p>7 Ngày Đổi Trả</p>
            </div>
        </div>

        <!-- Add to Cart & Buy -->
        <div class="mt-auto space-y-3">
            <div class="flex items-center gap-3">
                <span class="text-xs font-black text-gray-500 uppercase tracking-widest">Số lượng:</span>
                <div class="flex items-center border border-gray-300 rounded-md">
                    <button class="px-3 py-1 text-gray-600 hover:text-primary transition font-bold" onclick="changeQty(-1)">-</button>
                    <input id="quantity" type="number" value="1" min="1" class="w-12 text-center text-xs font-bold text-gray-800 bg-transparent border-none focus:outline-none">
                    <button class="px-3 py-1 text-gray-600 hover:text-primary transition font-bold" onclick="changeQty(1)">+</button>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                <button onclick="buyNow(this)" class="w-full bg-gradient-to-r from-red-600 to-primary text-white py-3 rounded-lg font-bold text-sm shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5 active:translate-y-0 duration-150">
                    <i class="fas fa-bolt mr-1.5"></i> MUA NGAY GIÁ RẺ
                </button>
                <button onclick="addToCartAjax({{ $product->id }}, selectedVariantId, parseInt(document.getElementById('quantity').value), this)" class="w-full border border-primary text-primary hover:bg-orange-50/50 py-3 rounded-lg font-bold text-sm transition transform hover:-translate-y-0.5 active:translate-y-0 duration-150">
                    <i class="fas fa-shopping-cart mr-1.5"></i> THÊM VÀO GIỎ
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Tabs Details & Description -->
<div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-8">
    <div class="border-b border-gray-200 pb-3 mb-5">
        <h2 class="text-sm font-black text-gray-900 uppercase tracking-wider border-b-2 border-primary pb-3 inline-block">Đặc điểm nổi bật & Thông số kĩ thuật</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Description -->
        <div class="lg:col-span-7">
            <h3 class="text-sm font-bold text-gray-900 mb-3">Mô tả sản phẩm</h3>
            <div class="text-sm text-gray-700 leading-relaxed whitespace-pre-line bg-gray-50/50 p-4 rounded-lg border border-gray-100">
                {{ $product->description ?: 'Không có mô tả cho sản phẩm này.' }}
            </div>
        </div>

        <!-- Specifications Table -->
        <div class="lg:col-span-5 bg-white">
            <h3 class="text-sm font-bold text-gray-900 mb-3">Thông số kỹ thuật</h3>
            <div class="border border-gray-100 rounded-lg overflow-hidden shadow-sm text-xs">
                <table class="w-full border-collapse">
                    <tbody>
                        <tr class="bg-gray-50">
                            <td class="px-4 py-2.5 font-bold text-gray-500 w-1/3 border-b border-gray-100">Tên máy</td>
                            <td class="px-4 py-2.5 font-bold text-gray-800 border-b border-gray-100">{{ $product->name }}</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2.5 font-bold text-gray-500 border-b border-gray-100">CPU</td>
                            <td id="spec-cpu" class="px-4 py-2.5 font-semibold text-gray-700 border-b border-gray-100">{{ $variants->first()->cpu ?? 'Chưa xác định' }}</td>
                        </tr>
                        <tr class="bg-gray-50">
                            <td class="px-4 py-2.5 font-bold text-gray-500 border-b border-gray-100">RAM</td>
                            <td id="spec-ram" class="px-4 py-2.5 font-semibold text-gray-700 border-b border-gray-100">{{ $variants->first()->ram ?? 'Chưa xác định' }}</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2.5 font-bold text-gray-500 border-b border-gray-100">Ổ cứng</td>
                            <td id="spec-storage" class="px-4 py-2.5 font-semibold text-gray-700 border-b border-gray-100">{{ $variants->first()->storage ?? 'Chưa xác định' }}</td>
                        </tr>
                        <tr class="bg-gray-50">
                            <td class="px-4 py-2.5 font-bold text-gray-500 border-b border-gray-100">Màu sắc</td>
                            <td id="spec-color" class="px-4 py-2.5 font-semibold text-gray-700 border-b border-gray-100">{{ $variants->first()->color ?? 'Chưa xác định' }}</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2.5 font-bold text-gray-500 border-b border-gray-100">Mã máy (SKU)</td>
                            <td id="spec-sku" class="px-4 py-2.5 font-semibold text-gray-700 border-b border-gray-100">{{ $variants->first()->sku ?? $product->id }}</td>
                        </tr>
                        <tr class="bg-gray-50">
                            <td class="px-4 py-2.5 font-bold text-gray-500">Tồn kho</td>
                            <td id="spec-stock" class="px-4 py-2.5 font-semibold text-gray-700">{{ isset($variants->first()->stock) ? ($variants->first()->stock . ' cái') : 'Chưa cập nhật' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Related Products -->
@if($relatedProducts->isNotEmpty())
    <div class="mb-8 bg-white p-4 rounded-lg shadow-sm border border-gray-100">
        <div class="border-b border-gray-200 pb-2 mb-4">
            <h2 class="text-sm font-black text-gray-900 uppercase tracking-wider inline-block">Sản phẩm tương tự</h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            @foreach($relatedProducts as $relProduct)
                <div class="product-card border border-gray-200 rounded-lg p-3 bg-white flex flex-col relative group">
                    @if($relProduct->sale_price && $relProduct->sale_price < $relProduct->price)
                        <span class="absolute top-2 right-2 bg-primary text-white text-xs font-bold px-2 py-1 rounded z-10">
                            -{{ round((($relProduct->price - $relProduct->sale_price) / $relProduct->price) * 100) }}%
                        </span>
                    @endif
                    <a href="{{ route('product.detail', $relProduct->id) }}" class="relative overflow-hidden mb-3 h-32 flex items-center justify-center">
                        <img src="{{ (preg_match('/^https?:\/\//', $relProduct->image) || empty($relProduct->image)) ? ($relProduct->image ?: 'https://images.unsplash.com/photo-1587831990711-23ca6441447b?auto=format&fit=crop&w=200&h=200') : asset('images/products/' . $relProduct->image) }}" alt="{{ $relProduct->name }}" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                    </a>
                    
                    <a href="{{ route('product.detail', $relProduct->id) }}">
                        <h3 class="text-xs font-bold text-gray-800 mb-2 line-clamp-2 hover:text-primary cursor-pointer">{{ $relProduct->name }}</h3>
                    </a>

                    @if(!empty($relProduct->cpu) || !empty($relProduct->ram) || !empty($relProduct->storage))
                        <!-- Hộp thông số -->
                        <div class="bg-gray-50/90 border border-gray-100 rounded p-1.5 mb-2.5 text-[9px] text-gray-600 font-medium tracking-wide">
                            <div class="grid grid-cols-2 gap-1 mb-1">
                                @if(!empty($relProduct->cpu))
                                    <div class="flex items-center truncate"><i class="fas fa-microchip text-gray-400 mr-1 w-2.5 text-[8px] text-center"></i><span class="truncate font-semibold">{{ $relProduct->cpu }}</span></div>
                                @endif
                                @if(!empty($relProduct->ram))
                                    <div class="flex items-center truncate"><i class="fas fa-memory text-gray-400 mr-1 w-2.5 text-[8px] text-center"></i><span class="truncate font-semibold">{{ $relProduct->ram }}</span></div>
                                @endif
                            </div>
                            @if(!empty($relProduct->storage))
                                <div class="flex items-center truncate pt-0.5 border-t border-gray-200/50"><i class="fas fa-hdd text-gray-400 mr-1 w-2.5 text-[8px] text-center"></i><span class="truncate font-semibold">{{ $relProduct->storage }}</span></div>
                            @endif
                        </div>
                    @endif

                    <div class="mt-auto">
                        @if($relProduct->sale_price && $relProduct->sale_price < $relProduct->price)
                            <div class="text-primary font-bold text-sm">{{ number_format($relProduct->sale_price, 0, ',', '.') }}₫</div>
                            <div class="text-gray-400 text-[10px] line-through">{{ number_format($relProduct->price, 0, ',', '.') }}₫</div>
                        @else
                            <div class="text-primary font-bold text-sm">{{ number_format($relProduct->price, 0, ',', '.') }}₫</div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

<!-- Đánh giá & Bình luận sản phẩm -->
<div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-8">
    <div class="border-b border-gray-200 pb-3 mb-5">
        <h2 class="text-sm font-black text-gray-900 uppercase tracking-wider border-b-2 border-primary pb-3 inline-block">Đánh giá & Bình luận từ khách hàng</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-8">
        <!-- Review Summary -->
        <div class="lg:col-span-4 bg-gray-50/50 p-6 rounded-xl border border-gray-100 text-center flex flex-col justify-center items-center">
            <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Đánh giá trung bình</h3>
            <span class="text-5xl font-black text-gray-900 leading-none mb-2">{{ number_format($averageRating, 1) }}</span>
            <div class="flex text-yellow-400 text-lg mb-2 gap-0.5">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= floor($averageRating))
                        <i class="fas fa-star"></i>
                    @elseif($i - $averageRating < 1 && $i - $averageRating > 0)
                        <i class="fas fa-star-half-alt"></i>
                    @else
                        <i class="far fa-star text-gray-300"></i>
                    @endif
                @endfor
            </div>
            <p class="text-xs text-gray-500 font-medium mb-6">({{ $commentsCount }} lượt đánh giá thực tế)</p>

            <!-- Star progress bars -->
            <div class="w-full space-y-2 text-xs font-semibold text-gray-600">
                @for($star = 5; $star >= 1; $star--)
                    @php
                        $count = $ratingDistribution[$star] ?? 0;
                        $pct = $commentsCount > 0 ? round(($count / $commentsCount) * 100) : 0;
                    @endphp
                    <div class="flex items-center gap-2">
                        <span class="w-3 text-right">{{ $star }}</span>
                        <i class="fas fa-star text-yellow-400 text-[10px]"></i>
                        <div class="flex-grow bg-gray-200 rounded-full h-2 overflow-hidden">
                            <div class="bg-primary h-full rounded-full transition-all duration-500" style="width: {{ $pct }}%"></div>
                        </div>
                        <span class="w-8 text-right text-gray-400 font-bold">{{ $pct }}%</span>
                    </div>
                @endfor
            </div>
        </div>

        <!-- Comments List -->
        <div class="lg:col-span-8 flex flex-col">
            <h3 class="text-sm font-bold text-gray-900 mb-4 flex items-center">
                <i class="far fa-comments text-primary mr-2 text-base"></i> Khách hàng nói gì về sản phẩm này?
            </h3>
            
            <div class="space-y-4 max-h-[420px] overflow-y-auto pr-2 scrollbar-thin">
                @forelse($comments as $comment)
                    <div class="bg-white border border-gray-100 p-4 rounded-xl shadow-sm hover:shadow transition duration-200">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center gap-3">
                                @php
                                    $initial = strtoupper(substr($comment->user_name, 0, 1));
                                    $bgColors = ['bg-orange-500', 'bg-blue-500', 'bg-green-500', 'bg-purple-500', 'bg-pink-500', 'bg-indigo-500'];
                                    $avatarBg = $bgColors[ord($initial) % count($bgColors)];
                                @endphp
                                <div class="{{ $avatarBg }} text-white text-xs font-black rounded-full w-8 h-8 flex items-center justify-center shadow-inner">
                                    {{ $initial }}
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-gray-800">{{ $comment->user_name }}</h4>
                                    <div class="flex text-yellow-400 text-[10px] gap-0.5 mt-0.5">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $comment->rating)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star text-gray-200"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <span class="text-[10px] text-gray-400 font-semibold">
                                {{ date('d/m/Y H:i', strtotime($comment->created_at)) }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-600 leading-relaxed pl-11">{{ $comment->content }}</p>
                    </div>
                @empty
                    <div class="text-center py-12 bg-gray-50/50 rounded-xl border border-dashed border-gray-200 text-gray-400 font-bold">
                        <i class="far fa-comment-dots text-gray-300 text-3xl mb-2 block"></i>
                        Chưa có đánh giá nào cho sản phẩm này. Hãy là người đầu tiên đánh giá!
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Review Form -->
    <div class="mt-6 pt-6 border-t border-gray-100">
        @auth
            <h3 class="text-sm font-bold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-pen-fancy text-primary mr-2"></i> Viết đánh giá của bạn
            </h3>

            <form action="{{ route('product.comment.add', $product->id) }}" method="POST" class="space-y-4">
                @csrf
                <div class="flex items-center gap-4">
                    <span class="text-xs font-bold text-gray-600">Chọn số sao đánh giá:</span>
                    <div class="flex gap-1 star-rating-selector text-gray-300 text-xl cursor-pointer">
                        <i class="fas fa-star hover:text-yellow-400 transition" data-value="1"></i>
                        <i class="fas fa-star hover:text-yellow-400 transition" data-value="2"></i>
                        <i class="fas fa-star hover:text-yellow-400 transition" data-value="3"></i>
                        <i class="fas fa-star hover:text-yellow-400 transition" data-value="4"></i>
                        <i class="fas fa-star hover:text-yellow-400 transition" data-value="5"></i>
                    </div>
                    <input type="hidden" name="rating" id="rating-input" value="5">
                    <span id="rating-text" class="text-xs text-yellow-600 font-bold bg-yellow-50 px-2.5 py-0.5 rounded border border-yellow-100">5 sao - Rất hài lòng</span>
                </div>

                <div class="relative">
                    <textarea name="content" rows="3" placeholder="Chia sẻ cảm nhận của bạn về sản phẩm này (cấu hình, hiệu năng, đóng gói, giao hàng...)..." class="w-full text-xs text-gray-800 placeholder-gray-400 border border-gray-200 focus:border-primary focus:ring-1 focus:ring-primary rounded-xl p-4 pr-12 focus:outline-none transition" required></textarea>
                    <button type="submit" class="absolute bottom-3 right-3 bg-primary text-white font-bold text-xs px-4 py-2 rounded-lg shadow hover:bg-orange-600 transition flex items-center gap-1.5">
                        <i class="fas fa-paper-plane"></i> GỬI ĐÁNH GIÁ
                    </button>
                </div>
            </form>
        @else
            <div class="bg-orange-50/20 border border-orange-100 p-5 rounded-xl text-center">
                <i class="fas fa-user-lock text-orange-400 text-2xl mb-2 block"></i>
                <p class="text-xs text-gray-600 font-bold mb-3">Vui lòng đăng nhập để gửi đánh giá và nhận xét của bạn về sản phẩm này!</p>
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center bg-primary hover:bg-orange-600 text-white font-bold text-xs px-5 py-2.5 rounded-lg shadow transition">
                    <i class="fas fa-sign-in-alt mr-1.5"></i> ĐĂNG NHẬP NGAY
                </a>
            </div>
        @endauth
    </div>
</div>

<!-- Dynamic Scripts -->
<script>
    // Embed variants JSON safely
    const variants = {!! json_encode($variants) !!};
    let selectedVariantId = null;

    // Initialize with first variant if exists
    if(variants.length > 0) {
        selectedVariantId = variants[0].id;
    }

    // Change main image from thumbnails
    function changeImage(element, imageUrl) {
        document.getElementById('main-image').src = imageUrl;
        
        // Remove active styling from other thumbnails
        document.querySelectorAll('.thumbnail-item').forEach(item => {
            item.classList.remove('border-primary');
            item.classList.add('border-gray-200');
        });
        
        // Add active styling
        element.classList.add('border-primary');
        element.classList.remove('border-gray-200');
    }

    // Handle variant selection
    function selectVariant(element, variantId) {
        const variant = variants.find(v => v.id === variantId);
        if(!variant) return;

        selectedVariantId = variantId;

        // Update border styles for variants
        document.querySelectorAll('.variant-card').forEach(card => {
            card.classList.remove('border-primary', 'bg-orange-50/20');
            card.classList.add('border-gray-200');
            // Remove the absolute "DANG CHON" tag
            const activeTag = card.querySelector('.bg-primary');
            if (activeTag) activeTag.remove();
        });

        element.classList.add('border-primary', 'bg-orange-50/20');
        element.classList.remove('border-gray-200');

        // Add the "DANG CHON" tag to the selected element
        const tag = document.createElement('div');
        tag.className = 'absolute -top-1.5 -right-1.5 bg-primary text-white text-[8px] font-black px-1.5 py-0.5 rounded-full shadow-sm';
        tag.innerText = 'ĐANG CHỌN';
        element.appendChild(tag);

        // Update pricing and details on UI dynamically with transitions
        const displayPrice = document.getElementById('display-price');
        displayPrice.classList.add('opacity-40');
        setTimeout(() => {
            displayPrice.innerText = new Intl.NumberFormat('vi-VN').format(variant.price) + '₫';
            displayPrice.classList.remove('opacity-40');
        }, 100);

        document.getElementById('display-sku').innerText = variant.sku || variant.id;

        // Update specifications table
        document.getElementById('spec-cpu').innerText = variant.cpu || 'Chưa xác định';
        document.getElementById('spec-ram').innerText = variant.ram || 'Chưa xác định';
        document.getElementById('spec-storage').innerText = variant.storage || 'Chưa xác định';
        document.getElementById('spec-color').innerText = variant.color || 'Chưa xác định';
        document.getElementById('spec-sku').innerText = variant.sku || variant.id;
        document.getElementById('spec-stock').innerText = variant.stock + ' cái';

        // Update stock badge
        const badge = document.getElementById('stock-badge');
        if(variant.stock > 0) {
            badge.innerText = 'Còn hàng';
            badge.className = 'text-green-600 bg-green-50 border border-green-100 px-2 py-0.5 rounded font-bold';
        } else {
            badge.innerText = 'Hết hàng';
            badge.className = 'text-red-600 bg-red-50 border border-red-100 px-2 py-0.5 rounded font-bold';
        }
    }

    // Change quantity
    function changeQty(amount) {
        const qtyInput = document.getElementById('quantity');
        let currentQty = parseInt(qtyInput.value);
        if(isNaN(currentQty)) currentQty = 1;
        
        let newQty = currentQty + amount;
        if(newQty < 1) newQty = 1;
        qtyInput.value = newQty;
    }

    // Handle Buy Now (adds to cart and redirects immediately to /cart)
    function buyNow(buttonElement) {
        const qtyInput = document.getElementById('quantity');
        let qty = parseInt(qtyInput.value) || 1;

        let originalContent = '';
        if (buttonElement) {
            originalContent = buttonElement.innerHTML;
            buttonElement.disabled = true;
            buttonElement.innerHTML = '<i class="fas fa-spinner fa-spin mr-1.5"></i> ĐANG XỬ LÝ...';
        }

        const formData = new FormData();
        formData.append('product_id', {{ $product->id }});
        if (selectedVariantId) {
            formData.append('variant_id', selectedVariantId);
        }
        formData.append('quantity', qty);
        formData.append('_token', '{{ csrf_token() }}');

        fetch('{{ route("cart.add") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Lỗi máy chủ khi thêm sản phẩm.');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                window.location.href = '{{ url("cart") }}';
            } else {
                showToast(data.error || 'Có lỗi xảy ra.', 'error');
                if (buttonElement) {
                    buttonElement.disabled = false;
                    buttonElement.innerHTML = originalContent;
                }
            }
        })
        .catch(error => {
            console.error('Error buy now:', error);
            showToast('Không thể kết nối đến máy chủ. Vui lòng thử lại sau!', 'error');
            if (buttonElement) {
                buttonElement.disabled = false;
                buttonElement.innerHTML = originalContent;
            }
        });
    }

    // Handle Interactive Star Rating Form
    const stars = document.querySelectorAll('.star-rating-selector i');
    const ratingInput = document.getElementById('rating-input');
    const ratingText = document.getElementById('rating-text');
    const starTexts = {
        1: '1 sao - Rất tệ',
        2: '2 sao - Tệ',
        3: '3 sao - Bình thường',
        4: '4 sao - Tốt',
        5: '5 sao - Rất hài lòng'
    };

    if (stars.length > 0 && ratingInput) {
        function highlightStars(count) {
            stars.forEach((star, idx) => {
                if (idx < count) {
                    star.classList.remove('text-gray-300');
                    star.classList.add('text-yellow-400');
                } else {
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-300');
                }
            });
        }

        highlightStars(5);

        stars.forEach(star => {
            star.addEventListener('click', function() {
                const val = parseInt(this.getAttribute('data-value'));
                ratingInput.value = val;
                highlightStars(val);
                ratingText.innerText = starTexts[val];
            });

            star.addEventListener('mouseenter', function() {
                const val = parseInt(this.getAttribute('data-value'));
                highlightStars(val);
            });
        });

        const selectorContainer = document.querySelector('.star-rating-selector');
        if (selectorContainer) {
            selectorContainer.addEventListener('mouseleave', function() {
                const currentVal = parseInt(ratingInput.value);
                highlightStars(currentVal);
            });
        }
    }
</script>
