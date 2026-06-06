<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Admincontroller extends Controller
{
  public function showLogin() {
      if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->is_admin == 1) {
          return redirect('/admin');
      }
      return view('admin.auth.login');
  }

  public function login(Request $request) {
      $credentials = $request->validate([
          'email' => 'required|email',
          'password' => 'required',
      ], [
          'email.required' => 'Vui lòng nhập email đăng nhập.',
          'email.email' => 'Email không đúng định dạng.',
          'password.required' => 'Vui lòng nhập mật khẩu.',
      ]);

      $remember = $request->has('remember');

      if (\Illuminate\Support\Facades\Auth::attempt($credentials, $remember)) {
          $user = \Illuminate\Support\Facades\Auth::user();
          if ($user->is_admin == 1) {
              $request->session()->regenerate();
              return redirect('/admin')->with('success', 'Đăng nhập trang quản trị thành công!');
          } else {
              \Illuminate\Support\Facades\Auth::logout();
              return back()->withErrors([
                  'email' => 'Tài khoản của bạn không có quyền truy cập trang quản trị!',
              ])->onlyInput('email');
          }
      }

      return back()->withErrors([
          'email' => 'Tài khoản hoặc mật khẩu không chính xác!',
      ])->onlyInput('email');
  }

  public function logout(Request $request) {
      \Illuminate\Support\Facades\Auth::logout();

      $request->session()->invalidate();
      $request->session()->regenerateToken();

      return redirect()->route('admin.login')->with('success', 'Đăng xuất tài khoản quản trị thành công.');
  }

 public function admin(){
    
    return view('admin.layout.index');
 }
  public function products_table(Request $request){
    $query = DB::table('products')
    ->select('products.*', 'categories.name as category_name', DB::raw('COALESCE((SELECT SUM(stock) FROM product_variants WHERE product_variants.product_id = products.id), 0) as total_stock'))
    ->join('categories', 'products.category_id', '=', 'categories.id');

    if ($request->has('search') && !empty($request->query('search'))) {
      $query->where('products.name', 'like', '%' . $request->query('search') . '%');
    }

    if ($request->has('category_id') && !empty($request->query('category_id'))) {
      $query->where('products.category_id', '=', $request->query('category_id'));
    }

    $products = $query->paginate(5)->withQueryString();

    $productIds = $products->pluck('id')->toArray();
    $productImages = DB::table('product_images')
    ->whereIn('product_id', $productIds)
    ->orderBy('sort_order', 'asc')
    ->get()
    ->groupBy('product_id');

    $productVariants = DB::table('product_variants')
    ->whereIn('product_id', $productIds)
    ->get()
    ->groupBy('product_id');

    $categories = DB::table('categories')->get();

    return view('admin.layout.module.product-table', compact('products', 'productImages', 'productVariants', 'categories'));
  }

  public function productSuggestions(Request $request){
    $search = $request->query('q', '');
    if (empty($search)) {
      return response()->json([]);
    }
    
    $products = DB::table('products')
    ->select('id', 'name', 'price', 'image')
    ->where('name', 'like', '%' . $search . '%')
    ->limit(6)
    ->get();

    return response()->json($products);
  }

 public function addProducts(){
    $categories = DB::table('categories')->get();
    return view('admin.layout.module.add-products', compact('categories'));
 }
 public function addCategory(){
    return view('admin.layout.module.add-category');
 }
 public function addCategoryPost(Request $request){
  $validatedData = $request->validate([
    'name' => 'required|string|max:255',
    'status' => 'required|in:1,0',
  ], [
    'name.required' => 'Vui lòng nhập tên danh mục.',
    'name.string' => 'Tên danh mục phải là chuỗi ký tự.',
    'name.max' => 'Tên danh mục không được vượt quá 255 ký tự.',
    'status.required' => 'Vui lòng chọn trạng thái danh mục.',
    'status.in' => 'Trạng thái danh mục không hợp lệ.',
  ]);
  
  DB::table('categories')->insert([
    'name' => $validatedData['name'],
    'status' => $validatedData['status'],
  ]);
  
  return redirect()->route('admin.category.addCategory')->with('success', 'Danh mục đã được thêm thành công!');
}
public function addProductsPost(Request $request){
  $validatedData = $request->validate([
    'name' => 'required|string|max:255',
    'price' => 'required|numeric|min:0',
    'sale_price' => 'nullable|numeric|min:0',
    'category_id' => 'required|exists:categories,id',
    'status' => 'required|in:1,0',
    'description' => 'nullable|string',
    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    'gallery' => 'nullable|array',
    'gallery.*.image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    'gallery.*.type' => 'required|integer|in:1,2',
    'gallery.*.sort_order' => 'required|integer|min:0',
    'variants' => 'nullable|array',
    'variants.*.sku' => 'nullable|string|max:100',
    'variants.*.cpu' => 'nullable|string|max:100',
    'variants.*.ram' => 'nullable|string|max:50',
    'variants.*.storage' => 'nullable|string|max:100',
    'variants.*.color' => 'nullable|string|max:50',
    'variants.*.price' => 'required|numeric|min:0',
    'variants.*.stock' => 'required|integer|min:0',
  ], [
    'name.required' => 'Vui lòng nhập tên sản phẩm.',
    'name.string' => 'Tên sản phẩm phải là chuỗi ký tự.',
    'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',
    'price.required' => 'Vui lòng nhập giá sản phẩm.',
    'price.numeric' => 'Giá sản phẩm phải là số.',
    'price.min' => 'Giá sản phẩm không được nhỏ hơn 0.',
    'sale_price.numeric' => 'Giá khuyến mãi phải là số.',
    'sale_price.min' => 'Giá khuyến mãi không được nhỏ hơn 0.',
    'category_id.required' => 'Vui lòng chọn danh mục sản phẩm.',
    'category_id.exists' => 'Danh mục sản phẩm không tồn tại.',
    'status.required' => 'Vui lòng chọn trạng thái sản phẩm.',
    'status.in' => 'Trạng thái sản phẩm không hợp lệ.',
    'description.string' => 'Mô tả sản phẩm phải là chuỗi ký tự.',
    'image.image' => 'Tập tin tải lên phải là hình ảnh.',
    'image.mimes' => 'Hình ảnh phải có định dạng jpeg, png, jpg hoặc gif.',
    'image.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
    'gallery.*.image.required' => 'Vui lòng chọn hình ảnh cho dòng ảnh chi tiết.',
    'gallery.*.image.image' => 'Tập tin chi tiết tải lên phải là hình ảnh.',
    'gallery.*.image.mimes' => 'Hình ảnh chi tiết phải có định dạng jpeg, png, jpg hoặc gif.',
    'gallery.*.image.max' => 'Kích thước hình ảnh chi tiết không được vượt quá 2MB.',
    'gallery.*.type.required' => 'Vui lòng chọn loại ảnh.',
    'gallery.*.sort_order.required' => 'Vui lòng nhập thứ tự hiển thị.',
    'variants.*.price.required' => 'Vui lòng nhập giá cho tất cả các biến thể.',
    'variants.*.price.numeric' => 'Giá biến thể phải là số.',
    'variants.*.price.min' => 'Giá biến thể không được nhỏ hơn 0.',
    'variants.*.stock.required' => 'Vui lòng nhập số lượng kho cho tất cả các biến thể.',
    'variants.*.stock.integer' => 'Số lượng kho biến thể phải là số nguyên.',
    'variants.*.stock.min' => 'Số lượng kho biến thể không được nhỏ hơn 0.',
  ]);
  
  $imageName = null;
  if ($request->hasFile('image')) {
    $image = $request->file('image');
    $imageName = time() . '.' . $image->getClientOriginalExtension();
    $image->move(public_path('images/products'), $imageName);
  }
  
  $productId = DB::table('products')->insertGetId([
    'name' => $validatedData['name'],
    'price' => $validatedData['price'],
    'sale_price' => $validatedData['sale_price'] ?? null,
    'category_id' => $validatedData['category_id'],
    'status' => $validatedData['status'],
    'description' => $validatedData['description'] ?? null,
    'image' => $imageName,
  ]);

  if ($request->has('gallery')) {
    foreach ($request->input('gallery') as $index => $data) {
      if ($request->hasFile("gallery.$index.image")) {
        $file = $request->file("gallery.$index.image");
        $detailName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images/products/details'), $detailName);
        DB::table('product_images')->insert([
          'product_id' => $productId,
          'image' => $detailName,
          'type' => $data['type'],
          'sort_order' => $data['sort_order'],
          'created_at' => now(),
          'updated_at' => now(),
        ]);
      }
    }
  }

  if ($request->has('variants')) {
    foreach ($request->input('variants') as $data) {
      DB::table('product_variants')->insert([
        'product_id' => $productId,
        'sku' => $data['sku'] ?? null,
        'cpu' => $data['cpu'] ?? null,
        'ram' => $data['ram'] ?? null,
        'storage' => $data['storage'] ?? null,
        'color' => $data['color'] ?? null,
        'price' => $data['price'],
        'stock' => $data['stock'] ?? 0,
        'created_at' => now(),
        'updated_at' => now(),
      ]);
    }
  }

  return redirect()->route('admin.products.addProducts')->with('success', 'Sản phẩm và các biến thể đã được thêm thành công!');
}

public function editProduct($id){
  $product = DB::table('products')->where('id', $id)->first();
  if (!$product) {
      return redirect()->route('admin.products.table')->with('error', 'Sản phẩm không tồn tại!');
  }
  $categories = DB::table('categories')->get();
  $detailImages = DB::table('product_images')->where('product_id', $id)->get();
  $variants = DB::table('product_variants')->where('product_id', $id)->get();
  return view('admin.layout.module.edit-products', compact('product', 'categories', 'detailImages', 'variants'));
}

public function editProductPost(Request $request, $id){
  $validatedData = $request->validate([
    'name' => 'required|string|max:255',
    'price' => 'required|numeric|min:0',
    'sale_price' => 'nullable|numeric|min:0',
    'category_id' => 'required|exists:categories,id',
    'status' => 'required|in:1,0',
    'description' => 'nullable|string',
    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    'gallery' => 'nullable|array',
    'gallery.*.image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    'gallery.*.type' => 'required|integer|in:1,2',
    'gallery.*.sort_order' => 'required|integer|min:0',
    'existing_gallery' => 'nullable|array',
    'existing_gallery.*.type' => 'required|integer|in:1,2',
    'existing_gallery.*.sort_order' => 'required|integer|min:0',
    'existing_variants' => 'nullable|array',
    'existing_variants.*.sku' => 'nullable|string|max:100',
    'existing_variants.*.cpu' => 'nullable|string|max:100',
    'existing_variants.*.ram' => 'nullable|string|max:50',
    'existing_variants.*.storage' => 'nullable|string|max:100',
    'existing_variants.*.color' => 'nullable|string|max:50',
    'existing_variants.*.price' => 'required|numeric|min:0',
    'existing_variants.*.stock' => 'required|integer|min:0',
    'variants' => 'nullable|array',
    'variants.*.sku' => 'nullable|string|max:100',
    'variants.*.cpu' => 'nullable|string|max:100',
    'variants.*.ram' => 'nullable|string|max:50',
    'variants.*.storage' => 'nullable|string|max:100',
    'variants.*.color' => 'nullable|string|max:50',
    'variants.*.price' => 'required|numeric|min:0',
    'variants.*.stock' => 'required|integer|min:0',
  ], [
    'name.required' => 'Vui lòng nhập tên sản phẩm.',
    'name.string' => 'Tên sản phẩm phải là chuỗi ký tự.',
    'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',
    'price.required' => 'Vui lòng nhập giá sản phẩm.',
    'price.numeric' => 'Giá sản phẩm phải là số.',
    'price.min' => 'Giá sản phẩm không được nhỏ hơn 0.',
    'sale_price.numeric' => 'Giá khuyến mãi phải là số.',
    'sale_price.min' => 'Giá khuyến mãi không được nhỏ hơn 0.',
    'category_id.required' => 'Vui lòng chọn danh mục sản phẩm.',
    'category_id.exists' => 'Danh mục sản phẩm không tồn tại.',
    'status.required' => 'Vui lòng chọn trạng thái sản phẩm.',
    'status.in' => 'Trái thái sản phẩm không hợp lệ.',
    'description.string' => 'Mô tả sản phẩm phải là chuỗi ký tự.',
    'image.image' => 'Tập tin tải lên phải là hình ảnh.',
    'image.mimes' => 'Hình ảnh phải có định dạng jpeg, png, jpg hoặc gif.',
    'image.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
    'gallery.*.image.required' => 'Vui lòng chọn hình ảnh cho dòng ảnh chi tiết.',
    'gallery.*.image.image' => 'Tập tin chi tiết tải lên phải là hình ảnh.',
    'gallery.*.image.mimes' => 'Hình ảnh chi tiết phải có định dạng jpeg, png, jpg hoặc gif.',
    'gallery.*.image.max' => 'Kích thước hình ảnh chi tiết không được vượt quá 2MB.',
    'gallery.*.type.required' => 'Vui lòng chọn loại ảnh mới.',
    'gallery.*.sort_order.required' => 'Vui lòng nhập thứ tự hiển thị của ảnh mới.',
    'existing_variants.*.price.required' => 'Vui lòng nhập giá cho tất cả các biến thể cũ.',
    'existing_variants.*.price.numeric' => 'Giá biến thể cũ phải là số.',
    'existing_variants.*.price.min' => 'Giá biến thể cũ không được nhỏ hơn 0.',
    'existing_variants.*.stock.required' => 'Vui lòng nhập số lượng kho cho tất cả các biến thể cũ.',
    'existing_variants.*.stock.integer' => 'Số lượng kho biến thể cũ phải là số nguyên.',
    'existing_variants.*.stock.min' => 'Số lượng kho biến thể cũ không được nhỏ hơn 0.',
    'variants.*.price.required' => 'Vui lòng nhập giá cho tất cả các biến thể mới.',
    'variants.*.price.numeric' => 'Giá biến thể mới phải là số.',
    'variants.*.price.min' => 'Giá biến thể mới không được nhỏ hơn 0.',
    'variants.*.stock.required' => 'Vui lòng nhập số lượng kho cho tất cả các biến thể mới.',
    'variants.*.stock.integer' => 'Số lượng kho biến thể mới phải là số nguyên.',
    'variants.*.stock.min' => 'Số lượng kho biến thể mới không được nhỏ hơn 0.',
  ]);

  $product = DB::table('products')->where('id', $id)->first();
  if (!$product) {
      return redirect()->route('admin.products.table')->with('error', 'Sản phẩm không tồn tại!');
  }

  $imageName = $product->image;
  if ($request->hasFile('image')) {
    if ($imageName && file_exists(public_path('images/products/' . $imageName))) {
        @unlink(public_path('images/products/' . $imageName));
    }
    $image = $request->file('image');
    $imageName = time() . '.' . $image->getClientOriginalExtension();
    $image->move(public_path('images/products'), $imageName);
  }

  DB::table('products')->where('id', $id)->update([
    'name' => $validatedData['name'],
    'price' => $validatedData['price'],
    'sale_price' => $validatedData['sale_price'] ?? null,
    'category_id' => $validatedData['category_id'],
    'status' => $validatedData['status'],
    'description' => $validatedData['description'] ?? null,
    'image' => $imageName,
  ]);

  // Update existing gallery items
  if ($request->has('existing_gallery')) {
    foreach ($request->input('existing_gallery') as $imgId => $data) {
      DB::table('product_images')->where('id', $imgId)->update([
        'type' => $data['type'],
        'sort_order' => $data['sort_order'],
        'updated_at' => now(),
      ]);
    }
  }

  // Insert new gallery items
  if ($request->has('gallery')) {
    foreach ($request->input('gallery') as $index => $data) {
      if ($request->hasFile("gallery.$index.image")) {
        $file = $request->file("gallery.$index.image");
        $detailName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images/products/details'), $detailName);
        DB::table('product_images')->insert([
          'product_id' => $id,
          'image' => $detailName,
          'type' => $data['type'],
          'sort_order' => $data['sort_order'],
          'created_at' => now(),
          'updated_at' => now(),
        ]);
      }
    }
  }

  // Update existing variants
  if ($request->has('existing_variants')) {
    foreach ($request->input('existing_variants') as $varId => $data) {
      DB::table('product_variants')->where('id', $varId)->update([
        'sku' => $data['sku'] ?? null,
        'cpu' => $data['cpu'] ?? null,
        'ram' => $data['ram'] ?? null,
        'storage' => $data['storage'] ?? null,
        'color' => $data['color'] ?? null,
        'price' => $data['price'],
        'stock' => $data['stock'] ?? 0,
        'updated_at' => now(),
      ]);
    }
  }

  // Insert new variants
  if ($request->has('variants')) {
    foreach ($request->input('variants') as $data) {
      DB::table('product_variants')->insert([
        'product_id' => $id,
        'sku' => $data['sku'] ?? null,
        'cpu' => $data['cpu'] ?? null,
        'ram' => $data['ram'] ?? null,
        'storage' => $data['storage'] ?? null,
        'color' => $data['color'] ?? null,
        'price' => $data['price'],
        'stock' => $data['stock'] ?? 0,
        'created_at' => now(),
        'updated_at' => now(),
      ]);
    }
  }

  return redirect()->route('admin.products.table')->with('success', 'Sản phẩm đã được cập nhật thành công!');
}

public function deleteProduct($id){
  $product = DB::table('products')->where('id', $id)->first();
  if ($product) {
      if ($product->image && file_exists(public_path('images/products/' . $product->image))) {
          @unlink(public_path('images/products/' . $product->image));
      }
      $detailImages = DB::table('product_images')->where('product_id', $id)->get();
      foreach ($detailImages as $img) {
          if ($img->image && file_exists(public_path('images/products/details/' . $img->image))) {
              @unlink(public_path('images/products/details/' . $img->image));
          }
      }
      
      // Delete child records to bypass foreign key constraints
      DB::table('product_images')->where('product_id', $id)->delete();
      DB::table('product_variants')->where('product_id', $id)->delete();
      
      DB::table('products')->where('id', $id)->delete();
      return redirect()->route('admin.products.table')->with('success', 'Sản phẩm và các thông tin liên quan đã được xóa thành công!');
  }
  return redirect()->route('admin.products.table')->with('error', 'Sản phẩm không tồn tại!');
}

public function deleteDetailImage($id) {
  $img = DB::table('product_images')->where('id', $id)->first();
  if ($img) {
      if ($img->image && file_exists(public_path('images/products/details/' . $img->image))) {
          @unlink(public_path('images/products/details/' . $img->image));
      }
      DB::table('product_images')->where('id', $id)->delete();
      return redirect()->back()->with('success', 'Ảnh chi tiết đã được xóa thành công!');
  }
  return redirect()->back()->with('error', 'Ảnh chi tiết không tồn tại!');
}

  public function deleteVariant($id) {
    $variant = DB::table('product_variants')->where('id', $id)->first();
    if ($variant) {
        DB::table('product_variants')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Biến thể đã được xóa thành công!');
    }
    return redirect()->back()->with('error', 'Biến thể không tồn tại!');
  }

  /**
   * Hiển thị danh sách đơn hàng Admin, kèm tìm kiếm, bộ lọc trạng thái và thống kê số liệu
   */
  public function orders_table(Request $request) {
      $query = DB::table('orders')
          ->select('orders.*', 'customers.name as customer_db_name')
          ->leftJoin('customers', 'orders.customer_id', '=', 'customers.id');

      // Tìm kiếm theo Mã ĐH, Họ tên, Số điện thoại, Email
      if ($request->has('search') && !empty($request->query('search'))) {
          $search = $request->query('search');
          $query->where(function($q) use ($search) {
              $q->where('orders.id', 'like', '%' . $search . '%')
                ->orWhere('orders.name', 'like', '%' . $search . '%')
                ->orWhere('orders.phone', 'like', '%' . $search . '%')
                ->orWhere('orders.email', 'like', '%' . $search . '%');
          });
      }

      // Lọc theo trạng thái đơn hàng
      if ($request->has('status') && $request->query('status') !== null && $request->query('status') !== '') {
          $query->where('orders.status', '=', $request->query('status'));
      }

      // Phân trang đơn hàng
      $orders = $query->orderBy('orders.created_at', 'desc')
          ->paginate(10)
          ->withQueryString();

      // Nạp chi tiết sản phẩm cho từng đơn hàng (tránh N+1 hoặc dùng cho render blade modal)
      foreach ($orders as $order) {
          $order->items = DB::table('order_details')
              ->join('products', 'order_details.product_id', '=', 'products.id')
              ->where('order_details.order_id', $order->id)
              ->select('order_details.*', 'products.name', 'products.image')
              ->get();
              
          // Tính tổng tiền đơn hàng
          $order->total_amount = $order->items->sum(function($item) {
              return $item->price * $item->quantity;
          });
      }

      // Tính toán số liệu thống kê (Metrics)
      $totalOrders = DB::table('orders')->count();
      $pendingOrders = DB::table('orders')->where('status', 1)->count();
      $pendingPaymentOrders = DB::table('orders')->where('status', 5)->count();
      $processingOrders = DB::table('orders')->where('status', 2)->count();
      $shippingOrders = DB::table('orders')->where('status', 3)->count();
      $completedOrders = DB::table('orders')->where('status', 4)->count();
      $cancelledOrders = DB::table('orders')->where('status', 0)->count();
      
      // Tính doanh thu từ các đơn hàng giao thành công (status = 4)
      $totalRevenue = DB::table('order_details')
          ->join('orders', 'order_details.order_id', '=', 'orders.id')
          ->where('orders.status', 4)
          ->selectRaw('SUM(order_details.price * order_details.quantity) as revenue')
          ->first()->revenue ?? 0;

      return view('admin.layout.module.order-table', compact(
          'orders', 
          'totalOrders', 
          'pendingOrders', 
          'pendingPaymentOrders', 
          'processingOrders',
          'shippingOrders', 
          'completedOrders', 
          'cancelledOrders', 
          'totalRevenue'
      ));
  }

  /**
   * Cập nhật trạng thái đơn hàng an toàn
   */
  public function update_order_status(Request $request, $id) {
      $validated = $request->validate([
          'status' => 'required|integer|in:0,1,2,3,4,5'
      ], [
          'status.required' => 'Vui lòng chọn trạng thái.',
          'status.in' => 'Trạng thái đơn hàng không hợp lệ.'
      ]);

      $order = DB::table('orders')->where('id', $id)->first();
      if (!$order) {
          return redirect()->back()->with('error', 'Đơn hàng không tồn tại!');
      }

      $oldStatus = $order->status;
      $newStatus = (int)$validated['status'];

      // Thực hiện cập nhật trạng thái và phát sự kiện WebSockets
      $orderModel = \App\Models\order::find($id);
      if ($orderModel) {
          $orderModel->status = $newStatus;
          $orderModel->save();
          event(new \App\Events\OrderStatusUpdated($orderModel));
      }

      // Xử lý cập nhật tồn kho dựa trên sự thay đổi trạng thái
      if ($oldStatus != 0 && $newStatus == 0) {
          // Trạng thái cũ đang hoạt động -> Trạng thái mới là Đã hủy (0): Cộng lại kho
          $orderDetails = DB::table('order_details')->where('order_id', $id)->get();
          foreach ($orderDetails as $detail) {
              if (!empty($detail->variant_id)) {
                  DB::table('product_variants')
                      ->where('id', $detail->variant_id)
                      ->increment('stock', $detail->quantity);
              } else {
                  $firstVariant = DB::table('product_variants')
                      ->where('product_id', $detail->product_id)
                      ->orderBy('id', 'asc')
                      ->first();
                  if ($firstVariant) {
                      DB::table('product_variants')
                          ->where('id', $firstVariant->id)
                          ->increment('stock', $detail->quantity);
                  }
              }
          }
      } elseif ($oldStatus == 0 && $newStatus != 0) {
          // Trạng thái cũ là Đã hủy (0) -> Trạng thái mới hoạt động trở lại: Trừ lại kho
          $orderDetails = DB::table('order_details')->where('order_id', $id)->get();
          foreach ($orderDetails as $detail) {
              if (!empty($detail->variant_id)) {
                  DB::table('product_variants')
                      ->where('id', $detail->variant_id)
                      ->decrement('stock', $detail->quantity);
              } else {
                  $firstVariant = DB::table('product_variants')
                      ->where('product_id', $detail->product_id)
                      ->orderBy('id', 'asc')
                      ->first();
                  if ($firstVariant) {
                      DB::table('product_variants')
                          ->where('id', $firstVariant->id)
                          ->decrement('stock', $detail->quantity);
                  }
              }
          }
      }

      return redirect()->back()->with('success', 'Đã cập nhật trạng thái đơn hàng #' . $id . ' thành công!');
  }

  /**
   * Trả về JSON thông tin đơn hàng và chi tiết sản phẩm phục vụ gọi AJAX
   */
  public function order_detail_json($id) {
      $order = DB::table('orders')
          ->select('orders.*', 'customers.name as customer_db_name')
          ->leftJoin('customers', 'orders.customer_id', '=', 'customers.id')
          ->where('orders.id', $id)
          ->first();

      if (!$order) {
          return response()->json(['error' => 'Đơn hàng không tồn tại!'], 404);
      }

      $items = DB::table('order_details')
          ->join('products', 'order_details.product_id', '=', 'products.id')
          ->where('order_details.order_id', $id)
          ->select('order_details.*', 'products.name', 'products.image')
          ->get();

      // Định dạng giá tiền
      foreach ($items as $item) {
          $item->price_formatted = number_format($item->price, 0, ',', '.') . ' đ';
          $item->subtotal = $item->price * $item->quantity;
          $item->subtotal_formatted = number_format($item->subtotal, 0, ',', '.') . ' đ';
          $item->image_url = (preg_match('/^https?:\/\//', $item->image) || empty($item->image)) 
              ? ($item->image ?: 'https://images.unsplash.com/photo-1593640408182-31c70c8268f5?auto=format&fit=crop&w=150&h=150') 
              : asset('images/products/' . $item->image);
      }

      return response()->json([
          'success' => true,
          'order' => $order,
          'items' => $items,
          'created_at_formatted' => date('d/m/Y H:i', strtotime($order->created_at))
      ]);
  }
}
