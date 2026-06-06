<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\OrderPlaced;
use App\Events\OrderStatusUpdated;

class Homecontroller extends Controller
{
    public function index(){
        $gamingProducts = \Illuminate\Support\Facades\DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('product_variants', function($join) {
                $join->on('products.id', '=', 'product_variants.product_id')
                     ->whereRaw('product_variants.id = (SELECT MIN(id) FROM product_variants WHERE product_id = products.id)');
            })
            ->where('categories.name', 'like', '%gaming%')
            ->select('products.*', 'product_variants.cpu', 'product_variants.ram', 'product_variants.storage', 'product_variants.color')
            ->limit(10)
            ->get();
            
        $workstationProducts = \Illuminate\Support\Facades\DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('product_variants', function($join) {
                $join->on('products.id', '=', 'product_variants.product_id')
                     ->whereRaw('product_variants.id = (SELECT MIN(id) FROM product_variants WHERE product_id = products.id)');
            })
            ->where('categories.name', 'like', '%workstation%')
            ->select('products.*', 'product_variants.cpu', 'product_variants.ram', 'product_variants.storage', 'product_variants.color')
            ->limit(10)
            ->get();
        
        // Fallback if database categories do not match or are empty
        if ($gamingProducts->isEmpty()) {
            $gamingProducts = \Illuminate\Support\Facades\DB::table('products')
                ->leftJoin('product_variants', function($join) {
                    $join->on('products.id', '=', 'product_variants.product_id')
                         ->whereRaw('product_variants.id = (SELECT MIN(id) FROM product_variants WHERE product_id = products.id)');
                })
                ->select('products.*', 'product_variants.cpu', 'product_variants.ram', 'product_variants.storage', 'product_variants.color')
                ->limit(5)
                ->get();
        }
        if ($workstationProducts->isEmpty()) {
            $workstationProducts = \Illuminate\Support\Facades\DB::table('products')
                ->leftJoin('product_variants', function($join) {
                    $join->on('products.id', '=', 'product_variants.product_id')
                         ->whereRaw('product_variants.id = (SELECT MIN(id) FROM product_variants WHERE product_id = products.id)');
                })
                ->select('products.*', 'product_variants.cpu', 'product_variants.ram', 'product_variants.storage', 'product_variants.color')
                ->skip(5)
                ->limit(5)
                ->get();
            if ($workstationProducts->isEmpty()) {
                $workstationProducts = $gamingProducts;
            }
        }

        return view('index', compact('gamingProducts', 'workstationProducts'));
    }

    public function detail($id){
        $product = \Illuminate\Support\Facades\DB::table('products')
            ->where('id', $id)
            ->first();
            
        if (!$product) {
            abort(404);
        }
        
        $images = \Illuminate\Support\Facades\DB::table('product_images')
            ->where('product_id', $id)
            ->orderBy('sort_order', 'asc')
            ->get();
            
        $variants = \Illuminate\Support\Facades\DB::table('product_variants')
            ->where('product_id', $id)
            ->get();

        // Fetch related products (same category)
        $relatedProducts = \Illuminate\Support\Facades\DB::table('products')
            ->leftJoin('product_variants', function($join) {
                $join->on('products.id', '=', 'product_variants.product_id')
                     ->whereRaw('product_variants.id = (SELECT MIN(id) FROM product_variants WHERE product_id = products.id)');
            })
            ->where('products.category_id', $product->category_id)
            ->where('products.id', '<>', $id)
            ->select('products.*', 'product_variants.cpu', 'product_variants.ram', 'product_variants.storage', 'product_variants.color')
            ->limit(5)
            ->get();

        return view('product-detail', compact('product', 'images', 'variants', 'relatedProducts'));
    }

    public function category(){
        return view('category');
    }

    public function search(Request $request)
    {
        $q = $request->query('q', '');
        $selectedCategory = $request->query('category', '');

        $query = \Illuminate\Support\Facades\DB::table('products')
            ->leftJoin('product_variants', function($join) {
                $join->on('products.id', '=', 'product_variants.product_id')
                     ->whereRaw('product_variants.id = (SELECT MIN(id) FROM product_variants WHERE product_id = products.id)');
            });

        if (!empty($q)) {
            $query->where(function($subQuery) use ($q) {
                $subQuery->where('products.name', 'like', '%' . $q . '%')
                         ->orWhere('products.description', 'like', '%' . $q . '%')
                         ->orWhere('product_variants.cpu', 'like', '%' . $q . '%')
                         ->orWhere('product_variants.ram', 'like', '%' . $q . '%');
            });
        }

        if (!empty($selectedCategory)) {
            if ($selectedCategory === 'gaming') {
                $query->where('products.name', 'like', '%gaming%');
            } elseif ($selectedCategory === 'van-phong') {
                $query->where(function($subQuery) {
                    $subQuery->where('products.name', 'like', '%modern%')
                             ->orWhere('products.name', 'like', '%thin%')
                             ->orWhere('products.name', 'like', '%thinkpad%')
                             ->orWhere('products.name', 'like', '%air%');
                });
            } elseif ($selectedCategory === 'macbook') {
                $query->where(function($subQuery) {
                    $subQuery->where('products.name', 'like', '%macbook%')
                             ->orWhere('products.name', 'like', '%air%')
                             ->orWhere('products.name', 'like', '%apple%');
                });
            } elseif ($selectedCategory === 'do-hoa') {
                $query->where(function($subQuery) {
                    $subQuery->where('products.name', 'like', '%pro%')
                             ->orWhere('products.name', 'like', '%legion%')
                             ->orWhere('products.name', 'like', '%zenbook%')
                             ->orWhere('products.name', 'like', '%strix%');
                });
            }
        }

        $products = $query->select('products.*', 'product_variants.cpu', 'product_variants.ram', 'product_variants.storage', 'product_variants.color', 'product_variants.sku')
            ->paginate(12)
            ->withQueryString();

        return view('search', compact('products', 'q', 'selectedCategory'));
    }

    public function suggestions(Request $request)
    {
        $q = $request->query('q', '');
        if (empty($q)) {
            return response()->json([]);
        }

        $products = \Illuminate\Support\Facades\DB::table('products')
            ->leftJoin('product_variants', function($join) {
                $join->on('products.id', '=', 'product_variants.product_id')
                     ->whereRaw('product_variants.id = (SELECT MIN(id) FROM product_variants WHERE product_id = products.id)');
            })
            ->where('products.name', 'like', '%' . $q . '%')
            ->select('products.id', 'products.name', 'products.price', 'products.sale_price', 'products.image', 'product_variants.cpu', 'product_variants.ram', 'product_variants.storage')
            ->limit(6)
            ->get();

        foreach ($products as $product) {
            $product->image_url = (preg_match('/^https?:\/\//', $product->image) || empty($product->image))
                ? ($product->image ?: 'https://images.unsplash.com/photo-1587831990711-23ca6441447b?auto=format&fit=crop&w=100&h=100')
                : asset('images/products/' . $product->image);
        }

        return response()->json($products);
    }

    public function cart(){
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }

    public function printQuotation(Request $request)
    {
        $cart = session()->get('cart', []);
        
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        // Nhận thông tin khách hàng từ Query String
        $customer = [
            'name' => $request->query('name'),
            'phone' => $request->query('phone'),
            'email' => $request->query('email'),
            'address' => $request->query('address'),
            'province' => $request->query('province'),
            'district' => $request->query('district'),
        ];

        $totalInWords = $this->convertNumberToWords($subtotal);

        return view('cart.print', compact('cart', 'subtotal', 'customer', 'totalInWords'));
    }

    /**
     * Chuyển đổi số tiền thành chữ tiếng Việt
     */
    private function convertNumberToWords($number) {
        $dictionary = [
            0 => 'không',
            1 => 'một',
            2 => 'hai',
            3 => 'ba',
            4 => 'bốn',
            5 => 'năm',
            6 => 'sáu',
            7 => 'bảy',
            8 => 'tám',
            9 => 'chín'
        ];
        
        if ($number == 0) {
            return 'Không đồng';
        }
        
        $number = (string)$number;
        $len = strlen($number);
        $remainder = $len % 3;
        if ($remainder > 0) {
            $number = str_repeat('0', 3 - $remainder) . $number;
            $len = strlen($number);
        }
        
        $groups = [];
        for ($i = 0; $i < $len; $i += 3) {
            $groups[] = substr($number, $i, 3);
        }
        
        $units = ['', 'nghìn', 'triệu', 'tỷ', 'nghìn tỷ', 'triệu tỷ'];
        $words = [];
        $groupCount = count($groups);
        
        for ($i = 0; $i < $groupCount; $i++) {
            $group = $groups[$i];
            $unitIndex = $groupCount - 1 - $i;
            
            $hundred = (int)$group[0];
            $ten = (int)$group[1];
            $one = (int)$group[2];
            
            if ($hundred == 0 && $ten == 0 && $one == 0 && $groupCount > 1) {
                continue;
            }
            
            $groupWords = [];
            
            // Trăm
            if ($hundred > 0 || $i > 0) {
                $groupWords[] = $dictionary[$hundred] . ' trăm';
            }
            
            // Chục
            if ($ten == 0) {
                if ($one > 0 && ($hundred > 0 || $groupCount > 1)) {
                    $groupWords[] = 'lẻ';
                }
            } elseif ($ten == 1) {
                $groupWords[] = 'mười';
            } else {
                $groupWords[] = $dictionary[$ten] . ' mươi';
            }
            
            // Đơn vị
            if ($one > 0) {
                if ($one == 1 && $ten > 1) {
                    $groupWords[] = 'mốt';
                } elseif ($one == 5 && $ten > 0) {
                    $groupWords[] = 'lăm';
                } else {
                    $groupWords[] = $dictionary[$one];
                }
            }
            
            $groupStr = implode(' ', $groupWords);
            if ($unitIndex > 0 && $groupStr !== '') {
                $groupStr .= ' ' . $units[$unitIndex];
            }
            
            if ($groupStr !== '') {
                $words[] = $groupStr;
            }
        }
        
        $result = implode(' ', $words);
        $result = preg_replace('/\s+/', ' ', $result);
        $result = trim($result) . ' đồng chẵn';
        
        $firstChar = mb_substr($result, 0, 1);
        $then = mb_substr($result, 1);
        return mb_strtoupper($firstChar) . $then;
    }

    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $variantId = $request->input('variant_id');
        $quantity = (int) $request->input('quantity', 1);
        if ($quantity < 1) {
            $quantity = 1;
        }

        // Kiểm tra sản phẩm có tồn tại hay không
        $product = \Illuminate\Support\Facades\DB::table('products')
            ->where('id', $productId)
            ->first();

        if (!$product) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Sản phẩm không tồn tại.'], 404);
            }
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại.');
        }

        // Tìm variant
        $variant = null;
        if ($variantId) {
            $variant = \Illuminate\Support\Facades\DB::table('product_variants')
                ->where('id', $variantId)
                ->where('product_id', $productId)
                ->first();
        } else {
            // Nếu không truyền variant_id nhưng sản phẩm có cấu hình variant, tự động chọn cấu hình đầu tiên
            $variant = \Illuminate\Support\Facades\DB::table('product_variants')
                ->where('product_id', $productId)
                ->orderBy('id', 'asc')
                ->first();
        }

        // Thiết lập các thông số dựa trên variant hoặc sản phẩm gốc
        $price = $variant ? $variant->price : ($product->sale_price ?: $product->price);
        $sku = $variant ? $variant->sku : $product->id;
        $cpu = $variant ? $variant->cpu : null;
        $ram = $variant ? $variant->ram : null;
        $storage = $variant ? $variant->storage : null;
        $color = $variant ? $variant->color : null;

        // Khóa định danh giỏ hàng
        $cartKey = $variant ? "{$productId}_{$variant->id}" : "{$productId}";

        $cart = session()->get('cart', []);

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $quantity;
        } else {
            $cart[$cartKey] = [
                'product_id' => $product->id,
                'variant_id' => $variant ? $variant->id : null,
                'name' => $product->name,
                'image' => $product->image,
                'price' => $price,
                'sku' => $sku,
                'cpu' => $cpu,
                'ram' => $ram,
                'storage' => $storage,
                'color' => $color,
                'quantity' => $quantity
            ];
        }

        session()->put('cart', $cart);

        $totalItems = array_sum(array_column($cart, 'quantity'));

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã thêm sản phẩm vào giỏ hàng thành công!',
                'cart' => $cart,
                'total_items' => $totalItems,
                'item_added' => $cart[$cartKey]
            ]);
        }

        if ($request->input('redirect') === 'cart') {
            return redirect('cart')->with('success', 'Đã thêm sản phẩm vào giỏ hàng.');
        }

        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng.');
    }

    public function updateCart(Request $request)
    {
        $key = $request->input('key');
        $quantity = (int) $request->input('quantity', 1);

        if ($quantity < 1) {
            $quantity = 1;
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }

        $totalItems = array_sum(array_column($cart, 'quantity'));
        $itemTotal = isset($cart[$key]) ? ($cart[$key]['price'] * $cart[$key]['quantity']) : 0;
        
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã cập nhật số lượng thành công!',
                'total_items' => $totalItems,
                'item_total' => $itemTotal,
                'item_total_formatted' => number_format($itemTotal, 0, ',', '.') . ' ₫',
                'subtotal' => $subtotal,
                'subtotal_formatted' => number_format($subtotal, 0, ',', '.') . ' ₫'
            ]);
        }

        return redirect()->back()->with('success', 'Đã cập nhật giỏ hàng.');
    }

    public function removeFromCart(Request $request)
    {
        $key = $request->input('key');

        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            unset($cart[$key]);
            session()->put('cart', $cart);
        }

        $totalItems = array_sum(array_column($cart, 'quantity'));
        
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã xóa sản phẩm khỏi giỏ hàng!',
                'total_items' => $totalItems,
                'subtotal' => $subtotal,
                'subtotal_formatted' => number_format($subtotal, 0, ',', '.') . ' ₫'
            ]);
        }

        return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }

    public function clearCart(Request $request)
    {
        session()->forget('cart');

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã xóa toàn bộ giỏ hàng!',
                'total_items' => 0,
                'subtotal' => 0,
                'subtotal_formatted' => '0 ₫'
            ]);
        }

        return redirect('cart')->with('success', 'Đã xóa toàn bộ giỏ hàng.');
    }

    /**
     * Hiển thị giao diện Đăng nhập
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Xử lý Đăng nhập người dùng
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không đúng định dạng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
        ]);

        $remember = $request->has('remember');

        if (\Illuminate\Support\Facades\Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('index')->with('success', 'Đăng nhập thành công! Chào mừng bạn trở lại.');
        }

        return back()->withErrors([
            'email' => 'Tài khoản hoặc mật khẩu không chính xác!',
        ])->onlyInput('email');
    }

    /**
     * Hiển thị giao diện Đăng ký
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Xử lý Đăng ký người dùng
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên.',
            'name.max' => 'Họ tên không được vượt quá 255 ký tự.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không đúng định dạng.',
            'email.unique' => 'Địa chỉ email này đã được đăng ký sử dụng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải chứa ít nhất 6 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        \Illuminate\Support\Facades\Auth::login($user);

        return redirect('index')->with('success', 'Đăng ký tài khoản thành công! Chào mừng bạn đến với SPATACUS.');
    }

    /**
     * Xử lý Đăng xuất người dùng
     */
    public function logout(Request $request)
    {
        \Illuminate\Support\Facades\Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('index')->with('success', 'Đã đăng xuất tài khoản thành công.');
    }

    /**
     * Xử lý Đặt hàng (Checkout)
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address_detail' => 'required|string',
            'province' => 'required|string',
            'district' => 'required|string',
        ], [
            'name.required' => 'Vui lòng nhập họ tên.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'email.required' => 'Vui lòng nhập email.',
            'address_detail.required' => 'Vui lòng nhập địa chỉ cụ thể.',
            'province.required' => 'Vui lòng chọn Tỉnh/Thành phố.',
            'district.required' => 'Vui lòng chọn Quận/Huyện.',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        // 1. Kiểm tra hoặc tạo customer để lấy ID làm khóa ngoại
        $customer = \App\Models\customer::where('email', $request->email)->first();
        
        if (!$customer) {
            $customer = \App\Models\customer::where('phone', $request->phone)->first();
        }

        if (!$customer) {
            try {
                $customer = \App\Models\customer::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address_detail . ', ' . $request->district . ', ' . $request->province,
                    'password' => \Illuminate\Support\Facades\Hash::make('customer123'),
                ]);
            } catch (\Exception $e) {
                $customer = \App\Models\customer::firstOrCreate(
                    ['email' => $request->email],
                    [
                        'name' => $request->name,
                        'phone' => $request->phone . '_' . time(),
                        'address' => $request->address_detail . ', ' . $request->district . ', ' . $request->province,
                        'password' => \Illuminate\Support\Facades\Hash::make('customer123'),
                    ]
                );
            }
        } else {
            try {
                $customer->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address_detail . ', ' . $request->district . ', ' . $request->province,
                ]);
            } catch (\Exception $e) {
                $customer->update([
                    'name' => $request->name,
                    'address' => $request->address_detail . ', ' . $request->district . ', ' . $request->province,
                ]);
            }
        }

        // 2. Tạo đơn hàng (Order)
        $fullAddress = $request->address_detail . ', ' . $request->district . ', ' . $request->province;
        
        $status = 1; // Chờ xác nhận (COD)
        if (strpos($request->note, '[Thanh toán QR]') !== false) {
            $status = 5; // Chờ thanh toán
        }

        $order = \App\Models\order::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $fullAddress,
            'customer_id' => $customer->id,
            'status' => $status,
        ]);

        // 3. Tạo chi tiết đơn hàng (OrderDetails) và trừ số lượng sản phẩm trong kho (stock)
        foreach ($cart as $item) {
            \App\Models\orderDetail::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'variant_id' => $item['variant_id'] ?? null,
            ]);

            // Trừ số lượng tồn kho của biến thể
            if (!empty($item['variant_id'])) {
                \Illuminate\Support\Facades\DB::table('product_variants')
                    ->where('id', $item['variant_id'])
                    ->decrement('stock', $item['quantity']);
            } else {
                // Nếu sản phẩm không có variant_id, trừ ở variant đầu tiên của sản phẩm
                $firstVariant = \Illuminate\Support\Facades\DB::table('product_variants')
                    ->where('product_id', $item['product_id'])
                    ->orderBy('id', 'asc')
                    ->first();
                if ($firstVariant) {
                    \Illuminate\Support\Facades\DB::table('product_variants')
                        ->where('id', $firstVariant->id)
                        ->decrement('stock', $item['quantity']);
                }
            }
        }

        // 4. Phát sự kiện WebSockets báo có đơn hàng mới và xóa giỏ hàng
        event(new OrderPlaced($order));
        session()->forget('cart');

        return redirect('index')->with('success', 'Đặt hàng thành công! Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.');
    }

    /**
     * Tạo đơn hàng bằng AJAX để lấy ID đơn hàng trước khi thanh toán qua cổng ngoài (như VNPAY)
     */
    public function checkoutAjax(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address_detail' => 'required|string',
            'province' => 'required|string',
            'district' => 'required|string',
        ], [
            'name.required' => 'Vui lòng nhập họ tên.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'email.required' => 'Vui lòng nhập email.',
            'address_detail.required' => 'Vui lòng nhập địa chỉ cụ thể.',
            'province.required' => 'Vui lòng chọn Tỉnh/Thành phố.',
            'district.required' => 'Vui lòng chọn Quận/Huyện.',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return response()->json(['success' => false, 'error' => 'Giỏ hàng của bạn đang trống.'], 400);
        }

        // 1. Kiểm tra hoặc tạo customer để lấy ID làm khóa ngoại
        $customer = \App\Models\customer::where('email', $request->email)->first();
        
        if (!$customer) {
            $customer = \App\Models\customer::where('phone', $request->phone)->first();
        }

        if (!$customer) {
            try {
                $customer = \App\Models\customer::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address_detail . ', ' . $request->district . ', ' . $request->province,
                    'password' => \Illuminate\Support\Facades\Hash::make('customer123'),
                ]);
            } catch (\Exception $e) {
                $customer = \App\Models\customer::firstOrCreate(
                    ['email' => $request->email],
                    [
                        'name' => $request->name,
                        'phone' => $request->phone . '_' . time(),
                        'address' => $request->address_detail . ', ' . $request->district . ', ' . $request->province,
                        'password' => \Illuminate\Support\Facades\Hash::make('customer123'),
                    ]
                );
            }
        } else {
            try {
                $customer->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address_detail . ', ' . $request->district . ', ' . $request->province,
                ]);
            } catch (\Exception $e) {
                $customer->update([
                    'name' => $request->name,
                    'address' => $request->address_detail . ', ' . $request->district . ', ' . $request->province,
                ]);
            }
        }

        // 2. Tạo đơn hàng (Order)
        $fullAddress = $request->address_detail . ', ' . $request->district . ', ' . $request->province;
        
        $order = \App\Models\order::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $fullAddress,
            'customer_id' => $customer->id,
            'status' => 5, // Chờ thanh toán
        ]);

        // 3. Tạo chi tiết đơn hàng (OrderDetails) và trừ số lượng sản phẩm trong kho (stock)
        foreach ($cart as $item) {
            \App\Models\orderDetail::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'variant_id' => $item['variant_id'] ?? null,
            ]);

            // Trừ số lượng tồn kho của biến thể
            if (!empty($item['variant_id'])) {
                \Illuminate\Support\Facades\DB::table('product_variants')
                    ->where('id', $item['variant_id'])
                    ->decrement('stock', $item['quantity']);
            } else {
                $firstVariant = \Illuminate\Support\Facades\DB::table('product_variants')
                    ->where('product_id', $item['product_id'])
                    ->orderBy('id', 'asc')
                    ->first();
                if ($firstVariant) {
                    \Illuminate\Support\Facades\DB::table('product_variants')
                        ->where('id', $firstVariant->id)
                        ->decrement('stock', $item['quantity']);
                }
            }
        }

        // 4. Phát sự kiện WebSockets báo có đơn hàng mới và xóa giỏ hàng
        event(new OrderPlaced($order));
        session()->forget('cart');

        return response()->json([
            'success' => true,
            'order_id' => $order->id,
            'message' => 'Tạo đơn hàng thành công!'
        ]);
    }

    /**
     * Hiển thị Lịch sử đơn hàng và Theo dõi đơn hàng
     */
    public function orderHistory()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        if (!$user) {
            return redirect('login')->with('error', 'Vui lòng đăng nhập để xem lịch sử mua hàng.');
        }

        // Tìm customer tương ứng
        $customer = \App\Models\customer::where('email', $user->email)->first();

        if (!$customer) {
            $orders = collect([]);
            return view('order-history', compact('orders'));
        }

        // Lấy tất cả đơn hàng kèm chi tiết sản phẩm
        $orders = \App\Models\order::where('customer_id', $customer->id)
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($orders as $order) {
            $order->items = \Illuminate\Support\Facades\DB::table('order_details')
                ->join('products', 'order_details.product_id', '=', 'products.id')
                ->where('order_details.order_id', $order->id)
                ->select('order_details.*', 'products.name', 'products.image')
                ->get();
        }

        return view('order-history', compact('orders'));
    }

    /**
     * Hủy đơn hàng (Chỉ được hủy khi trạng thái là 1 - Chờ xác nhận)
     */
    public function cancelOrder(Request $request, $id)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        if (!$user) {
            return redirect('login')->with('error', 'Vui lòng đăng nhập để thực hiện tác vụ này.');
        }

        $customer = \App\Models\customer::where('email', $user->email)->first();
        if (!$customer) {
            return redirect()->back()->with('error', 'Không tìm thấy thông tin mua hàng.');
        }

        $order = \App\Models\order::where('id', $id)
            ->where('customer_id', $customer->id)
            ->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Đơn hàng không tồn tại.');
        }

        if ($order->status != 1 && $order->status != 5) {
            return redirect()->back()->with('error', 'Đơn hàng đã được xác nhận hoặc đang xử lý, không thể tự hủy lúc này.');
        }

        // Cập nhật trạng thái thành 0 (Đã hủy) và phát sự kiện WebSockets
        $orderModel = \App\Models\order::find($id);
        if ($orderModel) {
            $orderModel->status = 0;
            $orderModel->save();
            event(new \App\Events\OrderStatusUpdated($orderModel));
        }

        // Cộng lại số lượng tồn kho (stock) cho các biến thể trong đơn hàng
        $orderDetails = \Illuminate\Support\Facades\DB::table('order_details')
            ->where('order_id', $id)
            ->get();

        foreach ($orderDetails as $detail) {
            if (!empty($detail->variant_id)) {
                \Illuminate\Support\Facades\DB::table('product_variants')
                    ->where('id', $detail->variant_id)
                    ->increment('stock', $detail->quantity);
            } else {
                $firstVariant = \Illuminate\Support\Facades\DB::table('product_variants')
                    ->where('product_id', $detail->product_id)
                    ->orderBy('id', 'asc')
                    ->first();
                if ($firstVariant) {
                    \Illuminate\Support\Facades\DB::table('product_variants')
                        ->where('id', $firstVariant->id)
                        ->increment('stock', $detail->quantity);
                }
            }
        }

        return redirect()->back()->with('success', 'Đơn hàng #' . $id . ' đã được hủy thành công.');
    }

    public function checkoutVNpay(Request $request){
      
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    
    $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    $vnp_Returnurl = "http://localhost/example-app/public/thanhtoan";
    $vnp_TmnCode = "YAA1LM4Q";//Mã website tại VNPAY 
    $vnp_HashSecret = "FM1RH81UP077CZAPIQKP4FEERKL8LIFO"; //Chuỗi bí mật
    $startTime = date("YmdHis");
    $expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime))); 

    $vnp_TxnRef = $request->order_id; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
    $vnp_OrderInfo = 'Thanh toán hóa VNpay cho mã:'.$request->order_id;
    $vnp_OrderType = 'other';
    $vnp_Amount = $request->total_amount * 100;
    $vnp_Locale = 'vn';
    //$vnp_BankCode = 'NCB';
    $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
    //Add Params of 2.0.1 Version
    $vnp_ExpireDate = $expire;
    //Billing
   
    $inputData = array(
        "vnp_Version" => "2.1.0",
        "vnp_TmnCode" => $vnp_TmnCode,
        "vnp_Amount" => $vnp_Amount,
        "vnp_Command" => "pay",
        "vnp_CreateDate" => date('YmdHis'),
        "vnp_CurrCode" => "VND",
        "vnp_IpAddr" => $vnp_IpAddr,
        "vnp_Locale" => $vnp_Locale,
        "vnp_OrderInfo" => $vnp_OrderInfo,
        "vnp_OrderType" => $vnp_OrderType,
        "vnp_ReturnUrl" => $vnp_Returnurl,
        "vnp_TxnRef" => $vnp_TxnRef,
        "vnp_ExpireDate"=>$vnp_ExpireDate,
    );
    
    if (isset($vnp_BankCode) && $vnp_BankCode != "") {
        $inputData['vnp_BankCode'] = $vnp_BankCode;
    }
    if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
        $inputData['vnp_Bill_State'] = $vnp_Bill_State;
    }
    
    //var_dump($inputData);
ksort($inputData);
$query = "";
$i = 0;
$hashdata = "";
foreach ($inputData as $key => $value) {
    if ($i == 1) {
        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
    } else {
        $hashdata .= urlencode($key) . "=" . urlencode($value);
        $i = 1;
    }
    $query .= urlencode($key) . "=" . urlencode($value) . '&';
}

$vnp_Url = $vnp_Url . "?" . $query;
if (isset($vnp_HashSecret)) {
    $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
}
        
        return redirect()->to($vnp_Url);
        // vui lòng tham khảo thêm tại code demo
       
    }

    /**
     * API kiểm tra trạng thái đơn hàng thời gian thực (Client Polling)
     */
    public function checkOrderStatus($id)
    {
        $order = \App\Models\order::find($id);
        if (!$order) {
            return response()->json(['paid' => false, 'error' => 'Đơn hàng không tồn tại!'], 404);
        }

        // Nếu trạng thái khác 5 (Chờ thanh toán) - nghĩa là hệ thống đã ghi nhận thanh toán thành công
        if ($order->status != 5) {
            return response()->json(['paid' => true, 'status' => $order->status]);
        }

        return response()->json(['paid' => false, 'status' => 5]);
    }

    /**
     * API giả lập nhận tiền webhook để đổi trạng thái đơn hàng phục vụ kiểm thử
     */
    public function simulatePayment($id)
    {
        $order = \App\Models\order::find($id);
        if (!$order) {
            return response()->json(['success' => false, 'error' => 'Đơn hàng không tồn tại!'], 404);
        }

        if ($order->status != 5) {
            return response()->json(['success' => false, 'message' => 'Đơn hàng này đã được xử lý thanh toán từ trước.']);
        }

        // Cập nhật trạng thái đơn hàng từ 5 (Chờ thanh toán) sang 2 (Đang chuẩn bị)
        $order->status = 2;
        $order->save();

        // Phát sự kiện cập nhật trạng thái đơn hàng thời gian thực
        event(new OrderStatusUpdated($order));

        return response()->json([
            'success' => true,
            'message' => 'Giả lập thanh toán thành công! Trạng thái Đơn hàng #' . $id . ' đã được chuyển sang Đang chuẩn bị (status = 2).'
        ]);
    }

    /**
     * Hủy đơn hàng QR, xóa khỏi database, cộng lại tồn kho và khôi phục giỏ hàng vào session
     */
    public function cancelQROrder($id)
    {
        $order = \App\Models\order::find($id);
        if (!$order) {
            return response()->json(['success' => false, 'error' => 'Đơn hàng không tồn tại!'], 404);
        }

        // Chỉ được hủy và xóa đơn hàng khi đang ở trạng thái 5 (Chờ thanh toán)
        if ($order->status != 5) {
            return response()->json(['success' => false, 'error' => 'Đơn hàng đã được thanh toán hoặc xử lý, không thể tự động xóa!'], 400);
        }

        // 1. Lấy tất cả chi tiết sản phẩm để cộng lại tồn kho và khôi phục vào session cart
        $orderDetails = \Illuminate\Support\Facades\DB::table('order_details')
            ->where('order_id', $id)
            ->get();

        $cart = [];

        foreach ($orderDetails as $detail) {
            // Cộng lại tồn kho
            if (!empty($detail->variant_id)) {
                \Illuminate\Support\Facades\DB::table('product_variants')
                    ->where('id', $detail->variant_id)
                    ->increment('stock', $detail->quantity);
            } else {
                $firstVariant = \Illuminate\Support\Facades\DB::table('product_variants')
                    ->where('product_id', $detail->product_id)
                    ->orderBy('id', 'asc')
                    ->first();
                if ($firstVariant) {
                    \Illuminate\Support\Facades\DB::table('product_variants')
                        ->where('id', $firstVariant->id)
                        ->increment('stock', $detail->quantity);
                }
            }

            // Lấy thông tin sản phẩm để khôi phục giỏ hàng
            $product = \Illuminate\Support\Facades\DB::table('products')->where('id', $detail->product_id)->first();
            if ($product) {
                $variant = null;
                if ($detail->variant_id) {
                    $variant = \Illuminate\Support\Facades\DB::table('product_variants')->where('id', $detail->variant_id)->first();
                }

                $cartKey = $detail->variant_id ? "{$detail->product_id}_{$detail->variant_id}" : "{$detail->product_id}";
                
                $cart[$cartKey] = [
                    'product_id' => $product->id,
                    'variant_id' => $detail->variant_id,
                    'name' => $product->name,
                    'image' => $product->image,
                    'price' => $detail->price,
                    'sku' => $variant ? $variant->sku : $product->id,
                    'cpu' => $variant ? $variant->cpu : null,
                    'ram' => $variant ? $variant->ram : null,
                    'storage' => $variant ? $variant->storage : null,
                    'color' => $variant ? $variant->color : null,
                    'quantity' => $detail->quantity
                ];
            }
        }

        // Khôi phục lại giỏ hàng vào session
        if (!empty($cart)) {
            session()->put('cart', $cart);
        }

        // 2. Xóa chi tiết đơn hàng
        \Illuminate\Support\Facades\DB::table('order_details')->where('order_id', $id)->delete();

        // 3. Xóa đơn hàng
        \Illuminate\Support\Facades\DB::table('orders')->where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Đã hủy giao dịch và khôi phục giỏ hàng thành công!'
        ]);
    }
}
