<!-- Top Header -->
<header class="bg-white shadow-sm sticky top-0 z-50">
    <div class="container mx-auto px-4 py-3 flex items-center justify-between">
        <!-- Logo -->
        <div class="flex items-center space-x-2 w-48">
            <h1 class="text-3xl font-black italic text-gray-800"><span class="text-blue-500">S</span><span class="text-green-500">P</span><span class="text-primary">A</span><span class="text-black">TACUS</span></h1>
        </div>

        <!-- Search -->
        <form action="{{ route('search') }}" method="GET" class="flex-1 max-w-3xl mx-8 flex m-0 relative" id="header-search-form">
            <div class="flex border border-primary rounded w-full overflow-hidden">
                <select name="category" class="bg-gray-50 px-3 py-2 border-r border-gray-200 outline-none text-sm text-gray-700">
                    <option value="" {{ request('category') === '' ? 'selected' : '' }}>Tất cả Laptop</option>
                    <option value="gaming" {{ request('category') === 'gaming' ? 'selected' : '' }}>Laptop Gaming</option>
                    <option value="van-phong" {{ request('category') === 'van-phong' ? 'selected' : '' }}>Laptop Văn Phòng</option>
                    <option value="macbook" {{ request('category') === 'macbook' ? 'selected' : '' }}>MacBook & Surface</option>
                    <option value="do-hoa" {{ request('category') === 'do-hoa' ? 'selected' : '' }}>Laptop Đồ Họa</option>
                </select>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Tìm kiếm Laptop chính hãng..." class="px-4 py-2 w-full outline-none text-sm" autocomplete="off">
                <button type="submit" class="bg-primary text-white px-6 py-2 hover:bg-orange-600 transition">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <!-- Suggestion Box -->
            <div id="search-suggestions" class="absolute top-[100%] left-0 right-0 bg-white border border-gray-200 rounded-b-lg shadow-2xl mt-1 hidden z-50 max-h-96 overflow-y-auto"></div>
        </form>

        <!-- Actions -->
        <div class="flex items-center space-x-6 text-sm">
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center text-gray-600">
                    <i class="fas fa-phone-volume text-lg"></i>
                </div>
                <div>
                    <div class="font-medium text-gray-600">Hotline mua hàng</div>
                    <div class="text-gray-900 font-bold">098.655.2233</div>
                </div>
            </div>
            <div class="flex items-center space-x-2 border-l border-gray-200 pl-6">
                <div class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center text-gray-600">
                    <i class="fas fa-hand-holding-usd text-lg"></i>
                </div>
                <div>
                    <div class="font-medium text-gray-600">Hỗ trợ trả góp</div>
                    <div class="text-gray-900 font-bold">Lãi suất 0%</div>
                </div>
            </div>
            <a href="{{ url('cart') }}" class="flex items-center space-x-2 border-l border-gray-200 pl-6 hover:text-primary transition group">
                <div class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center text-gray-600 relative group-hover:border-primary group-hover:text-primary transition">
                    <i class="fas fa-shopping-cart text-lg"></i>
                    @php
                        $cartCount = array_sum(array_column(session('cart', []), 'quantity'));
                    @endphp
                    <span id="cart-badge" class="{{ $cartCount > 0 ? '' : 'hidden' }} absolute -top-1 -right-1 bg-primary text-white text-[9px] font-black rounded-full h-5 w-5 flex items-center justify-center border-2 border-white shadow-md">
                        {{ $cartCount }}
                    </span>
                </div>
                <div>
                    <div class="text-gray-900 font-bold group-hover:text-primary transition">Giỏ hàng</div>
                </div>
            </a>

            @auth
            <!-- Thành viên đã Đăng nhập (Dropdown Menu) -->
            <div class="flex items-center space-x-2 border-l border-gray-200 pl-6 relative group cursor-pointer">
                <div class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center text-gray-600 group-hover:border-primary group-hover:text-primary transition">
                    <i class="fas fa-user text-lg"></i>
                </div>
                <div>
                    <div class="font-medium text-gray-500 text-[10px] uppercase tracking-wider">Tài khoản</div>
                    <div class="text-gray-900 font-bold max-w-[90px] truncate group-hover:text-primary transition">{{ auth()->user()->name }}</div>
                </div>
                <!-- Dropdown Card -->
                <div class="absolute top-[100%] right-0 mt-1 w-56 bg-darkBg border border-gray-800 rounded-xl shadow-2xl py-3 hidden group-hover:block z-50 transform origin-top transition-all duration-300">
                    <div class="px-4 py-2 border-b border-gray-800 mb-2">
                        <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest">Đăng nhập với</p>
                        <p class="text-xs font-bold text-white truncate">{{ auth()->user()->email }}</p>
                    </div>
                    <a href="{{ url('cart') }}" class="flex items-center gap-3 px-4 py-2 text-xs text-gray-300 hover:bg-gray-900 hover:text-white transition font-medium">
                        <i class="fas fa-shopping-cart text-gray-500 w-4"></i> Giỏ hàng của tôi
                    </a>
                    <a href="{{ route('order.history') }}" class="flex items-center gap-3 px-4 py-2 text-xs text-gray-300 hover:bg-gray-900 hover:text-white transition font-medium">
                        <i class="fas fa-file-invoice text-gray-500 w-4"></i> Lịch sử đơn hàng
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="m-0" id="logout-form">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-xs text-red-500 hover:bg-red-950/30 hover:text-red-400 transition font-bold text-left border-t border-gray-800/50 mt-2 pt-2">
                            <i class="fas fa-sign-out-alt w-4"></i> Đăng xuất
                        </button>
                    </form>
                </div>
            </div>
            @else
            <!-- Khách vãng lai (Đăng nhập / Đăng ký) -->
            <a href="{{ route('login') }}" class="flex items-center space-x-2 border-l border-gray-200 pl-6 hover:text-primary transition group">
                <div class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center text-gray-600 relative group-hover:border-primary group-hover:text-primary transition">
                    <i class="fas fa-sign-in-alt text-lg"></i>
                </div>
                <div>
                    <div class="font-medium text-gray-600 group-hover:text-primary transition">Đăng nhập</div>
                    <div class="text-gray-900 font-bold group-hover:text-primary transition">Tài khoản</div>
                </div>
            </a>
            @endauth
        </div>
    </div>
    
    <div class="container mx-auto px-4 pb-2 text-xs text-gray-500 flex space-x-4 pl-64">
        <a href="#" class="hover:text-primary">Laptop Gaming</a>
        <a href="#" class="hover:text-primary">Laptop Văn Phòng</a>
        <a href="#" class="hover:text-primary">MacBook chính hãng</a>
        <a href="#" class="hover:text-primary">Laptop Đồ Họa</a>
    </div>

    <!-- Navigation -->
    <div class="border-t border-gray-200 bg-white">
        <div class="container mx-auto px-4 flex">
            <div class="bg-darkBg text-white px-6 py-3 flex items-center space-x-2 w-64 font-bold text-sm">
                <i class="fas fa-bars"></i>
                <span>DANH MỤC SẢN PHẨM</span>
            </div>
            <div class="flex items-center space-x-8 px-6 text-xs font-bold text-gray-700 uppercase">
                <a href="#" class="nav-item flex items-center"><i class="fas fa-gamepad mr-2 text-gray-400"></i> Laptop Gaming</a>
                <a href="#" class="nav-item flex items-center"><i class="fas fa-laptop mr-2 text-gray-400"></i> Ultrabook Mỏng Nhẹ</a>
                <a href="#" class="nav-item flex items-center"><i class="fas fa-palette mr-2 text-gray-400"></i> Laptop Đồ Họa</a>
                <a href="#" class="nav-item flex items-center"><i class="fab fa-apple mr-2 text-gray-400"></i> MacBook Series</a>
                <a href="#" class="nav-item flex items-center"><i class="fas fa-graduation-cap mr-2 text-gray-400"></i> Laptop Sinh Viên</a>
                <a href="#" class="nav-item flex items-center"><i class="fas fa-mouse mr-2 text-gray-400"></i> Phụ kiện Laptop</a>
            </div>
        </div>
    </div>
</header>

<!-- Toast Container -->
<div id="toast-container" class="fixed bottom-5 right-5 z-[9999] flex flex-col gap-3 pointer-events-none"></div>

<script>
    function showToast(message, type = 'success') {
        const container = document.getElementById('toast-container');
        if (!container) return;

        const toast = document.createElement('div');
        toast.className = 'transform translate-y-4 opacity-0 transition-all duration-300 pointer-events-auto bg-white border-l-4 ' + 
            (type === 'success' ? 'border-primary' : 'border-red-500') + 
            ' shadow-xl rounded-r-lg p-4 flex items-center gap-3 min-w-[320px] max-w-md';
        
        let icon = '<i class="fas fa-check-circle text-primary text-lg"></i>';
        if (type === 'error') {
            icon = '<i class="fas fa-exclamation-circle text-red-500 text-lg"></i>';
        }

        toast.innerHTML = `
            <div class="flex-shrink-0">${icon}</div>
            <div class="flex-grow">
                <p class="text-xs font-bold text-gray-800">${message}</p>
            </div>
            <button class="text-gray-400 hover:text-gray-600 transition" onclick="this.parentElement.remove()">
                <i class="fas fa-times text-xs"></i>
            </button>
        `;

        container.appendChild(toast);

        // Kích hoạt hiệu ứng xuất hiện
        setTimeout(() => {
            toast.classList.remove('translate-y-4', 'opacity-0');
        }, 10);

        // Tự động biến mất sau 4 giây
        setTimeout(() => {
            toast.classList.add('translate-y-4', 'opacity-0');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 4000);
    }

    // Hàm gọi AJAX thêm vào giỏ hàng toàn cục
    function addToCartAjax(productId, variantId = null, quantity = 1, buttonElement = null) {
        // Hiển thị trạng thái tải (loading) trên nút nếu được cung cấp
        let originalContent = '';
        if (buttonElement) {
            originalContent = buttonElement.innerHTML;
            buttonElement.disabled = true;
            buttonElement.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> ĐANG THÊM...';
        }

        // Chuẩn bị dữ liệu
        const formData = new FormData();
        formData.append('product_id', productId);
        if (variantId) {
            formData.append('variant_id', variantId);
        }
        formData.append('quantity', quantity);
        formData.append('_token', '{{ csrf_token() }}');

        fetch('{{ route("cart.add") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (response.status === 401) {
                return response.json().then(data => {
                    throw { status: 401, message: data.error || 'Vui lòng đăng nhập để mua sắm!', redirect: data.redirect };
                });
            }
            if (!response.ok) {
                throw new Error('Sản phẩm không hợp lệ hoặc lỗi máy chủ.');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Cập nhật số lượng trên badge ở header
                const badge = document.getElementById('cart-badge');
                if (badge) {
                    badge.innerText = data.total_items;
                    badge.classList.remove('hidden');
                }
                
                // Hiển thị Toast thông báo thành công
                showToast(data.message || 'Đã thêm sản phẩm vào giỏ hàng thành công!', 'success');
            } else {
                showToast(data.error || 'Có lỗi xảy ra khi thêm sản phẩm.', 'error');
            }
        })
        .catch(error => {
            console.error('Lỗi khi thêm vào giỏ hàng:', error);
            if (error.status === 401) {
                showToast(error.message, 'error');
                if (error.redirect) {
                    setTimeout(() => {
                        window.location.href = error.redirect;
                    }, 1500);
                }
            } else {
                showToast(error.message || 'Không thể kết nối đến máy chủ. Vui lòng thử lại sau!', 'error');
            }
        })
        .finally(() => {
            // Khôi phục trạng thái nút ban đầu
            if (buttonElement) {
                buttonElement.disabled = false;
                buttonElement.innerHTML = originalContent;
            }
        });
    }

    // Tự động kích hoạt Toast thông báo cho các chuyển hướng (Redirects)
    document.addEventListener("DOMContentLoaded", function() {
        @if(session('success'))
            showToast("{{ session('success') }}", "success");
        @endif
        @if(session('error'))
            showToast("{{ session('error') }}", "error");
        @endif

        // Dynamic search suggestions logic
        const searchInput = document.querySelector('input[name="q"]');
        const suggestionsBox = document.getElementById('search-suggestions');
        const searchForm = document.getElementById('header-search-form');
        let debounceTimeout = null;

        if (searchInput && suggestionsBox) {
            searchInput.addEventListener('input', function() {
                const query = this.value.trim();
                
                clearTimeout(debounceTimeout);

                if (query.length < 2) {
                    suggestionsBox.innerHTML = '';
                    suggestionsBox.classList.add('hidden');
                    return;
                }

                debounceTimeout = setTimeout(() => {
                    fetch(`{{ url('search/suggestions') }}?q=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length === 0) {
                                suggestionsBox.innerHTML = `
                                    <div class="p-4 text-xs font-bold text-gray-500 text-center">
                                        <i class="fas fa-info-circle mr-1.5 text-gray-400"></i> Không tìm thấy Laptop nào phù hợp
                                    </div>
                                `;
                                suggestionsBox.classList.remove('hidden');
                                return;
                            }

                            let html = '';
                            data.forEach(product => {
                                const formattedPrice = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(product.sale_price || product.price);
                                const originalPriceHtml = (product.sale_price && product.sale_price < product.price) 
                                    ? `<span class="text-[10px] text-gray-400 line-through ml-2 font-medium">${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(product.price)}</span>`
                                    : '';
                                
                                const specsHtml = (product.cpu || product.ram || product.storage)
                                    ? `<p class="text-[10px] text-gray-500 font-semibold mt-0.5 truncate">
                                         ${product.cpu ? `<i class="fas fa-microchip mr-0.5 text-gray-400"></i> ${product.cpu}` : ''}
                                         ${product.ram ? ` <i class="fas fa-memory ml-1.5 mr-0.5 text-gray-400"></i> ${product.ram}` : ''}
                                         ${product.storage ? ` <i class="fas fa-hdd ml-1.5 mr-0.5 text-gray-400"></i> ${product.storage}` : ''}
                                       </p>`
                                    : '';

                                html += `
                                    <a href="{{ url('product') }}/${product.id}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50 transition border-b border-gray-100 last:border-b-0 group text-left">
                                        <div class="w-10 h-10 flex-shrink-0 bg-white border border-gray-200 rounded flex items-center justify-center p-0.5">
                                            <img src="${product.image_url}" alt="${product.name}" class="max-w-full max-h-full object-contain">
                                        </div>
                                        <div class="flex-grow min-w-0">
                                            <h4 class="text-xs font-bold text-gray-800 truncate group-hover:text-primary transition leading-snug">${product.name}</h4>
                                            ${specsHtml}
                                            <div class="flex items-baseline mt-0.5">
                                                <span class="text-primary font-black text-xs">${formattedPrice}</span>
                                                ${originalPriceHtml}
                                            </div>
                                        </div>
                                    </a>
                                `;
                            });

                            // Link to see all results
                            html += `
                                <a href="javascript:void(0)" onclick="document.getElementById('header-search-form').submit()" class="block text-center py-2 bg-gray-50 hover:bg-gray-100 text-xs font-bold text-[#1e3a8a] transition border-t border-gray-100">
                                    Xem tất cả kết quả cho "${query}" <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            `;

                            suggestionsBox.innerHTML = html;
                            suggestionsBox.classList.remove('hidden');
                        })
                        .catch(err => {
                            console.error('Error fetching suggestions:', err);
                        });
                }, 200); // 200ms debounce
            });

            // Close suggestions when clicking outside
            document.addEventListener('click', function(e) {
                if (!searchForm.contains(e.target)) {
                    suggestionsBox.classList.add('hidden');
                }
            });

            // Re-show suggestions if input is focused and has text
            searchInput.addEventListener('focus', function() {
                if (this.value.trim().length >= 2 && suggestionsBox.innerHTML !== '') {
                    suggestionsBox.classList.remove('hidden');
                }
            });
        }
    });
</script>
