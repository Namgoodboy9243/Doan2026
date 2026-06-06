<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báo giá giỏ hàng - SPATACUS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#ff3d00',
                        darkBg: '#051923',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            color: #1f2937;
            background-color: #f3f4f6;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .print-container {
            background-color: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            margin: 20px auto;
        }

        @media print {
            body {
                background-color: #ffffff;
                color: #000000;
            }
            .print-container {
                box-shadow: none;
                margin: 0;
                width: 100%;
                min-height: auto;
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
            @page {
                size: A4;
                margin: 15mm 15mm 15mm 15mm;
            }
        }
    </style>
</head>
<body class="bg-gray-100 py-6">

    <!-- Action Bar (Sticky at top, hidden on print) -->
    <div class="no-print fixed top-0 left-0 right-0 bg-white shadow-md z-50 px-6 py-4 flex justify-between items-center max-w-4xl mx-auto rounded-b-xl border border-t-0 border-gray-200">
        <div class="flex items-center space-x-3">
            <a href="{{ route('cart') }}" class="flex items-center text-sm font-semibold text-gray-600 hover:text-primary transition">
                <i class="fas fa-arrow-left mr-2"></i> Quay lại giỏ hàng
            </a>
        </div>
        <div class="flex items-center space-x-2">
            <button onclick="window.print()" class="bg-primary text-white px-5 py-2.5 rounded-lg text-sm font-bold hover:bg-orange-600 transition flex items-center shadow-md">
                <i class="fas fa-print mr-2"></i> In báo giá này
            </button>
        </div>
    </div>

    <!-- Print Template container -->
    <div class="print-container mt-16 md:mt-20">
        
        <!-- Header -->
        <div class="flex justify-between items-start border-b-2 border-primary pb-6 mb-6">
            <!-- Shop Info -->
            <div class="space-y-1.5 max-w-[65%]">
                <h1 class="text-3xl font-black italic text-gray-800 leading-none mb-2"><span class="text-blue-500">S</span><span class="text-green-500">P</span><span class="text-primary">A</span><span class="text-black">TACUS</span></h1>
                <p class="text-xs text-gray-500 font-medium">Hệ thống phân phối Laptop Gaming, Laptop Văn Phòng & Ultrabook chính hãng</p>
                <div class="text-[11px] text-gray-600 space-y-0.5 pt-1">
                    <p><i class="fas fa-map-marker-alt text-primary/70 mr-1.5 w-3.5"></i> <strong>Địa chỉ:</strong> Số 12, ngõ 34, đường Hoàng Quốc Việt, Cầu Giấy, Hà Nội</p>
                    <p><i class="fas fa-phone-volume text-primary/70 mr-1.5 w-3.5"></i> <strong>Hotline:</strong> 098.655.2233 | <strong>Website:</strong> spatacus.vn</p>
                    <p><i class="fas fa-envelope text-primary/70 mr-1.5 w-3.5"></i> <strong>Email:</strong> sales@spatacus.vn</p>
                </div>
            </div>
            
            <!-- Quotation Metadata -->
            <div class="text-right space-y-1">
                <h2 class="text-xl font-bold text-gray-800 tracking-wide">BÁO GIÁ CHI TIẾT</h2>
                <p class="text-xs text-gray-500">Mã số: <span class="font-semibold text-gray-800">BG-{{ date('ymd') }}-{{ rand(1000, 9999) }}</span></p>
                <p class="text-xs text-gray-500">Ngày tạo: <span class="font-semibold text-gray-800">{{ date('d/m/Y') }}</span></p>
                <p class="text-xs text-gray-500">Hiệu lực: <span class="font-medium text-gray-800">15 ngày</span></p>
            </div>
        </div>

        <!-- Title Banner -->
        <div class="text-center my-6">
            <h3 class="text-2xl font-extrabold text-gray-800 uppercase tracking-widest leading-none">BẢNG BÁO GIÁ THIẾT BỊ</h3>
            <div class="w-16 h-0.5 bg-primary mx-auto mt-2.5"></div>
        </div>

        <!-- Customer Section -->
        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200/80 mb-6 text-xs grid grid-cols-2 gap-4">
            <div>
                <h4 class="font-bold text-gray-800 uppercase tracking-wider mb-2 border-b border-gray-200 pb-1">Thông tin khách hàng</h4>
                <div class="space-y-1.5 text-gray-700">
                    <p><strong>Khách hàng:</strong> {{ $customer['name'] ?: 'Khách hàng vãng lai' }}</p>
                    <p><strong>Số điện thoại:</strong> {{ $customer['phone'] ?: 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ $customer['email'] ?: 'N/A' }}</p>
                </div>
            </div>
            <div>
                <h4 class="font-bold text-gray-800 uppercase tracking-wider mb-2 border-b border-gray-200 pb-1">Địa chỉ giao hàng</h4>
                <div class="space-y-1.5 text-gray-700">
                    @if($customer['address'])
                        <p><strong>Địa chỉ:</strong> {{ $customer['address'] }}</p>
                    @endif
                    @if($customer['district'] || $customer['province'])
                        <p><strong>Khu vực:</strong> {{ implode(', ', array_filter([$customer['district'], $customer['province']])) }}</p>
                    @endif
                    @if(!$customer['address'] && !$customer['district'] && !$customer['province'])
                        <p class="text-gray-400 italic">Chưa cập nhật thông tin địa chỉ</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Products Table -->
        <div class="border border-gray-200 rounded-lg overflow-hidden mb-6">
            <table class="w-full text-[11px] text-left">
                <thead class="bg-gray-100 border-b border-gray-200 text-gray-800 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="px-3 py-2.5 text-center w-10">STT</th>
                        <th class="px-3 py-2.5">Tên sản phẩm & Cấu hình chi tiết</th>
                        <th class="px-3 py-2.5 w-24 text-center">Mã SKU</th>
                        <th class="px-3 py-2.5 w-28 text-right">Đơn giá</th>
                        <th class="px-3 py-2.5 w-16 text-center">Số lượng</th>
                        <th class="px-3 py-2.5 w-28 text-right">Thành tiền</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-gray-700">
                    @php $idx = 1; @endphp
                    @foreach($cart as $item)
                        <tr>
                            <td class="px-3 py-3 text-center font-medium">{{ $idx++ }}</td>
                            <td class="px-3 py-3">
                                <div class="font-bold text-gray-900 text-xs leading-normal mb-1">{{ $item['name'] }}</div>
                                @if($item['cpu'] || $item['ram'] || $item['storage'] || $item['color'])
                                    <div class="text-[9px] text-gray-500 font-semibold flex flex-wrap gap-x-2 gap-y-0.5">
                                        @if($item['cpu']) <span><i class="fas fa-microchip mr-0.5"></i> {{ $item['cpu'] }}</span> @endif
                                        @if($item['ram']) <span><i class="fas fa-memory mr-0.5"></i> {{ $item['ram'] }}</span> @endif
                                        @if($item['storage']) <span><i class="fas fa-hdd mr-0.5"></i> {{ $item['storage'] }}</span> @endif
                                        @if($item['color']) <span><i class="fas fa-palette mr-0.5"></i> {{ $item['color'] }}</span> @endif
                                    </div>
                                @endif
                            </td>
                            <td class="px-3 py-3 text-center font-mono font-bold text-gray-500 text-[10px]">{{ $item['sku'] }}</td>
                            <td class="px-3 py-3 text-right font-medium">{{ number_format($item['price'], 0, ',', '.') }} ₫</td>
                            <td class="px-3 py-3 text-center font-bold">{{ $item['quantity'] }}</td>
                            <td class="px-3 py-3 text-right font-bold text-gray-900">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} ₫</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pricing Summary -->
        <div class="flex justify-end mb-8 text-xs">
            <div class="w-80 space-y-2 text-gray-700 border-t border-gray-100 pt-3">
                <div class="flex justify-between font-medium">
                    <span>Tổng tiền sản phẩm:</span>
                    <span>{{ number_format($subtotal, 0, ',', '.') }} ₫</span>
                </div>
                <div class="flex justify-between font-medium">
                    <span>Thuế giá trị gia tăng (VAT):</span>
                    <span>Đã bao gồm VAT</span>
                </div>
                <div class="flex justify-between font-medium">
                    <span>Chiết khấu Voucher:</span>
                    <span>0 ₫</span>
                </div>
                <div class="flex justify-between font-bold text-base text-gray-900 border-t border-gray-200 pt-2">
                    <span>Tổng cộng:</span>
                    <span class="text-primary text-[15px]">{{ number_format($subtotal, 0, ',', '.') }} ₫</span>
                </div>
            </div>
        </div>

        <!-- Word representation of amount -->
        <div class="bg-gray-50 rounded-lg p-3.5 border border-dashed border-gray-300 text-xs mb-8 flex items-start">
            <i class="fas fa-spell-check text-primary mt-0.5 mr-2 text-sm"></i>
            <div>
                <strong class="text-gray-800">Số tiền bằng chữ: </strong>
                <span class="text-gray-900 font-bold italic">{{ $totalInWords }}</span>
            </div>
        </div>

        <!-- Terms and Notes -->
        <div class="text-[10px] text-gray-500 space-y-1 border-t border-gray-100 pt-4 mb-10 leading-relaxed">
            <p class="font-bold text-gray-700 uppercase tracking-wider text-[11px] mb-1">Ghi chú & Điều khoản kèm theo:</p>
            <p>1. Báo giá này có hiệu lực trong vòng 15 ngày kể từ ngày ban hành.</p>
            <p>2. Giá bán đã bao gồm thuế giá trị gia tăng (VAT) và bảo hành chính hãng theo tiêu chuẩn nhà sản xuất.</p>
            <p>3. SPATACUS hỗ trợ giao hàng miễn phí trong bán kính 10km và đổi mới sản phẩm lỗi trong vòng 30 ngày.</p>
        </div>

        <!-- Signature Section -->
        <div class="grid grid-cols-2 gap-4 text-center text-xs mt-12 mb-6">
            <div class="space-y-16">
                <div>
                    <h5 class="font-bold text-gray-800">ĐẠI DIỆN KHÁCH HÀNG</h5>
                    <p class="text-[10px] text-gray-400 mt-0.5 italic">(Ký, ghi rõ họ tên)</p>
                </div>
                <div class="h-6"></div>
            </div>
            <div class="space-y-16">
                <div>
                    <h5 class="font-bold text-gray-800 uppercase">ĐẠI DIỆN SPATACUS</h5>
                    <p class="text-[10px] text-gray-400 mt-0.5 italic">(Ký tên và đóng dấu)</p>
                </div>
                <div class="h-6"></div>
            </div>
        </div>

    </div>

    <script>
        // Tự động gọi hộp thoại in khi trang tải hoàn tất
        window.addEventListener('DOMContentLoaded', () => {
            // Đợi 800ms để đảm bảo các font và hình ảnh tải đầy đủ
            setTimeout(() => {
                window.print();
            }, 800);
        });
    </script>
</body>
</html>
