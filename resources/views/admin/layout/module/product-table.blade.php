@extends('admin.layout.master')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row" style="width: 1060px;">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Danh sách sản phẩm</h4>
                        <p class="card-description">
                            Quản lý tất cả sản phẩm trong hệ thống
                        </p>

                        <!-- Search & Filter Controls (Separated) -->
                        <div class="row mb-4 align-items-center">
                            <!-- Left: Search Box -->
                            <div class="col-md-5 col-sm-12 position-relative">
                                <form action="{{ route('admin.products.table') }}" method="GET" id="search-form" autocomplete="off">
                                    @if(request('category_id'))
                                        <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                                    @endif
                                    <div class="input-group">
                                        <input type="text" name="search" id="search-input" class="form-control" placeholder="Tìm kiếm sản phẩm theo tên..." value="{{ request('search') }}" style="border-radius: 8px 0 0 8px; height: 40px; border: 1px solid #cbd5e1; border-right: 0; font-size: 13px;">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit" style="border-radius: 0 8px 8px 0; height: 40px; font-weight: 600; font-size: 13px; min-width: 70px;">
                                                Tìm
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <!-- Suggestions Box -->
                                <div id="suggestions-box" class="shadow-lg border bg-white w-100 position-absolute" style="display: none; z-index: 1050; border-radius: 8px; overflow: hidden; margin-top: 2px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
                                </div>
                            </div>

                            <!-- Middle: Category Filter -->
                            <div class="col-md-4 col-sm-12 mt-2 mt-md-0">
                                <form action="{{ route('admin.products.table') }}" method="GET" id="filter-form">
                                    @if(request('search'))
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                    @endif
                                    <select name="category_id" id="category-filter" class="form-control" style="height: 40px; border: 1px solid #cbd5e1; border-radius: 8px; color: #475569; font-size: 13px;" onchange="this.form.submit()">
                                        <option value="">-- Lọc theo danh mục --</option>
                                        @if(isset($categories))
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                                    {{ $cat->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </form>
                            </div>

                            <!-- Right: Clear Active Filters Indicator -->
                            @if(request('search') || request('category_id'))
                                <div class="col-md-3 col-sm-12 mt-2 mt-md-0 text-md-right">
                                    <a href="{{ route('admin.products.table') }}" class="btn btn-outline-danger btn-sm font-weight-bold" style="text-decoration: none; border-radius: 8px; padding: 10px 16px; font-size: 12px; transition: all 0.2s;">
                                        Xóa bộ lọc X
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div class="table-responsive pt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Hình ảnh</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Danh mục</th>
                                        <th>Giá (VNĐ)</th>
                                        <th>Giá Sale (VNĐ)</th>
                                        <th class="text-center">Tổng số lượng</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($products) && !$products->isEmpty())
                                        @foreach($products as $key => $product)
                                        <tr>
                                            <td>{{ ($products->currentPage() - 1) * $products->perPage() + $key + 1 }}</td>
                                            <td>
                                                @if(isset($product->image) && $product->image)
                                                    <img src="{{ asset('images/products/' . $product->image) }}" alt="image" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                                @else
                                                    <span class="text-muted">Không có ảnh</span>
                                                @endif
                                            </td>
                                            <td>{{ $product->name ?? 'N/A' }}</td>
                                            <td>{{ $product->category_name ?? 'N/A' }}</td>
                                            <td>{{ isset($product->price) ? number_format($product->price, 0, ',', '.') . ' đ' : 'N/A' }}</td>
                                            <td>
                                                @if(isset($product->sale_price) && $product->sale_price)
                                                    {{ number_format($product->sale_price, 0, ',', '.') }} đ
                                                @else
                                                    <span class="text-muted">Không</span>
                                                @endif
                                            </td>
                                            <td class="text-center font-weight-bold">
                                                @if($product->total_stock > 10)
                                                    <span class="badge badge-success" style="font-weight: 600; font-size: 12px; padding: 5px 10px; border-radius: 6px;">{{ $product->total_stock }}</span>
                                                @elseif($product->total_stock > 0)
                                                    <span class="badge badge-warning text-white" style="font-weight: 600; font-size: 12px; padding: 5px 10px; border-radius: 6px;">{{ $product->total_stock }} (Sắp hết)</span>
                                                @else
                                                    <span class="badge badge-danger" style="font-weight: 600; font-size: 12px; padding: 5px 10px; border-radius: 6px;">Hết hàng</span>
                                                @endif
                                            </td>
                                            <td style="width: 300px;">
                                                <button type="button" class="btn btn-sm btn-success btn-icon-text text-white mr-1" data-toggle="modal" data-target="#detailModal-{{ $product->id }}">
                                                    <i class="typcn typcn-document-text btn-icon-append"></i> Xem chi tiết
                                                </button>
                                                <button type="button" class="btn btn-sm btn-warning btn-icon-text text-white mr-1" data-toggle="modal" data-target="#galleryModal-{{ $product->id }}">
                                                    <i class="typcn typcn-image btn-icon-append"></i> Ảnh chi tiết
                                                </button>
                                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-info btn-icon-text mr-1" style="   width: 126px; margin-top:10px">
                                                    <i class="typcn typcn-edit btn-icon-append"></i> Sửa
                                                </a>
                                                <a href="{{ route('admin.products.delete', $product->id) }}" class="btn btn-sm btn-danger btn-icon-text" style="   width: 126px; margin-top:10px;" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                                    <i class="typcn typcn-delete-outline btn-icon-append"></i> Xóa
                                                </a>

                                                <!-- Modal Gallery for Product -->
                                                <div class="modal fade text-left" id="galleryModal-{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="galleryModalLabel-{{ $product->id }}" aria-hidden="true">
                                                  <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content" style="border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                                                      <div class="modal-header bg-primary text-white py-3">
                                                        <h5 class="modal-title" id="galleryModalLabel-{{ $product->id }}" style="font-weight: 600;">
                                                          Bộ sưu tập ảnh: {{ $product->name }}
                                                        </h5>
                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true">&times;</span>
                                                        </button>
                                                      </div>
                                                      <div class="modal-body p-4" style="background: #f8fafc;">
                                                        @php
                                                          $imgs = isset($productImages) ? ($productImages[$product->id] ?? collect()) : collect();
                                                        @endphp
                                                        
                                                        @if($imgs->count() > 0)
                                                          <div class="row">
                                                            @foreach($imgs as $img)
                                                              <div class="col-md-4 mb-3">
                                                                <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
                                                                  <div style="height: 180px; position: relative;">
                                                                    <img src="{{ asset('images/products/details/' . $img->image) }}" alt="Ảnh chi tiết" style="width: 100%; height: 100%; object-fit: cover;">
                                                                    <span class="badge {{ $img->type == 2 ? 'badge-warning' : 'badge-info' }}" style="position: absolute; bottom: 8px; left: 8px; font-size: 11px; padding: 4px 8px; border-radius: 6px;">
                                                                      {{ $img->type == 2 ? 'Banner/Quảng cáo' : 'Ảnh chi tiết' }}
                                                                    </span>
                                                                    <span class="badge badge-dark" style="position: absolute; bottom: 8px; right: 8px; font-size: 11px; padding: 4px 8px; border-radius: 6px;">
                                                                      Thứ tự: {{ $img->sort_order }}
                                                                    </span>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                            @endforeach
                                                          </div>
                                                        @else
                                                          <div class="text-center py-5 text-muted">
                                                            <i class="typcn typcn-image" style="font-size: 48px; color: #cbd5e1;"></i>
                                                            <p class="mt-2" style="font-size: 15px;">Sản phẩm này chưa có ảnh chi tiết nào.</p>
                                                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary btn-sm mt-2" style="border-radius: 8px;">
                                                              Đến trang sửa để thêm ảnh
                                                            </a>
                                                          </div>
                                                        @endif
                                                      </div>
                                                      <div class="modal-footer border-top-0 bg-light py-2">
                                                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" style="border-radius: 8px;">Đóng</button>
                                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-info btn-sm text-white" style="border-radius: 8px;">
                                                          Chỉnh sửa bộ sưu tập
                                                        </a>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>

                                                <!-- Modal Product Details -->
                                                <div class="modal fade text-left" id="detailModal-{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel-{{ $product->id }}" aria-hidden="true">
                                                  <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content" style="border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                                                      <div class="modal-header bg-success text-white py-3">
                                                        <h5 class="modal-title" id="detailModalLabel-{{ $product->id }}" style="font-weight: 600;">
                                                          Chi tiết sản phẩm: {{ $product->name }}
                                                        </h5>
                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true">&times;</span>
                                                        </button>
                                                      </div>
                                                      <div class="modal-body p-4" style="background: #f8fafc;">
                                                        <div class="row mb-4">
                                                          <!-- Main Product info -->
                                                          <div class="col-md-4 text-center mb-3">
                                                            <div class="card border p-2" style="border-radius: 12px; background: #ffffff;">
                                                              @if($product->image)
                                                                <img src="{{ asset('images/products/' . $product->image) }}" alt="Ảnh chính" style="width: 100%; max-height: 200px; object-fit: contain; border-radius: 8px;">
                                                              @else
                                                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 180px; border-radius: 8px;">
                                                                  <i class="typcn typcn-image text-muted" style="font-size: 40px;"></i>
                                                                </div>
                                                              @endif
                                                              <h6 class="mt-3 mb-1" style="font-weight: 600; color: #1e293b;">Ảnh chính đại diện</h6>
                                                            </div>
                                                          </div>
                                                          <div class="col-md-8">
                                                            <div class="table-responsive">
                                                              <table class="table table-bordered table-sm table-striped" style="background: #ffffff;">
                                                                <tbody>
                                                                  <tr>
                                                                    <td style="font-weight: 600; width: 120px;">Tên sản phẩm</td>
                                                                    <td>{{ $product->name }}</td>
                                                                  </tr>
                                                                  <tr>
                                                                    <td style="font-weight: 600;">Danh mục</td>
                                                                    <td><span class="badge badge-info">{{ $product->category_name ?? 'N/A' }}</span></td>
                                                                  </tr>
                                                                  <tr>
                                                                    <td style="font-weight: 600;">Giá gốc</td>
                                                                    <td class="text-danger" style="font-weight: 600;">{{ isset($product->price) ? number_format($product->price, 0, ',', '.') . ' đ' : 'N/A' }}</td>
                                                                  </tr>
                                                                  <tr>
                                                                    <td style="font-weight: 600;">Giá sale</td>
                                                                    <td class="text-success" style="font-weight: 600;">
                                                                      @if(isset($product->sale_price) && $product->sale_price)
                                                                        {{ number_format($product->sale_price, 0, ',', '.') }} đ
                                                                      @else
                                                                        <span class="text-muted">Không khuyến mãi</span>
                                                                      @endif
                                                                    </td>
                                                                  </tr>
                                                                  <tr>
                                                                    <td style="font-weight: 600;">Trạng thái</td>
                                                                    <td>
                                                                      <span class="badge {{ $product->status == 1 ? 'badge-success' : 'badge-secondary' }}">
                                                                        {{ $product->status == 1 ? 'Hiển thị' : 'Ẩn' }}
                                                                      </span>
                                                                    </td>
                                                                  </tr>
                                                                </tbody>
                                                              </table>
                                                            </div>
                                                          </div>
                                                        </div>

                                                        <!-- Variants Section -->
                                                        <div class="card border shadow-sm p-3" style="border-radius: 12px; background: #ffffff;">
                                                          <h6 style="font-weight: 600; font-size: 14px; color: #1e293b;" class="mb-3">
                                                            ⚙️ Danh sách các biến thể cấu hình (Variants)
                                                          </h6>
                                                          
                                                          @php
                                                            $vars = isset($productVariants) ? ($productVariants[$product->id] ?? collect()) : collect();
                                                          @endphp

                                                          @if($vars->count() > 0)
                                                            <div class="table-responsive">
                                                              <table class="table table-bordered table-sm table-striped">
                                                                <thead class="bg-light">
                                                                  <tr>
                                                                    <th>SKU</th>
                                                                    <th>CPU</th>
                                                                    <th>RAM</th>
                                                                    <th>Ổ cứng</th>
                                                                    <th>Màu sắc</th>
                                                                    <th style="width: 120px;">Giá riêng (VNĐ)</th>
                                                                    <th style="width: 80px;">Kho</th>
                                                                  </tr>
                                                                </thead>
                                                                <tbody>
                                                                  @foreach($vars as $v)
                                                                    <tr>
                                                                      <td style="font-weight: 600; font-size: 12px;">{{ $v->sku ?? 'N/A' }}</td>
                                                                      <td>{{ $v->cpu ?? '-' }}</td>
                                                                      <td>{{ $v->ram ?? '-' }}</td>
                                                                      <td>{{ $v->storage ?? '-' }}</td>
                                                                      <td>{{ $v->color ?? '-' }}</td>
                                                                      <td style="font-weight: 600; color: #dc3545;">{{ number_format($v->price, 0, ',', '.') }} đ</td>
                                                                      <td style="font-weight: 600; color: #28a745;">{{ $v->stock }}</td>
                                                                    </tr>
                                                                  @endforeach
                                                                </tbody>
                                                              </table>
                                                            </div>
                                                          @else
                                                            <div class="text-center py-4 bg-light" style="border-radius: 8px;">
                                                              <i class="typcn typcn-info-large text-muted" style="font-size: 32px;"></i>
                                                              <p class="mb-0 text-muted mt-2">Sản phẩm này chưa cấu hình biến thể.</p>
                                                              <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary mt-2" style="border-radius: 6px;">
                                                                Đến trang cấu hình biến thể
                                                              </a>
                                                            </div>
                                                          @endif
                                                        </div>

                                                        <!-- Description -->
                                                        <div class="mt-4">
                                                          <h6 style="font-weight: 600; font-size: 14px; color: #1e293b;" class="mb-2">Mô tả sản phẩm</h6>
                                                          <div class="p-3 border bg-white" style="border-radius: 10px; max-height: 150px; overflow-y: auto; font-size: 13px; color: #475569; line-height: 1.6;">
                                                            {!! nl2br(e($product->description ?? 'Không có mô tả sản phẩm.')) !!}
                                                          </div>
                                                        </div>

                                                      </div>
                                                      <div class="modal-footer border-top-0 bg-light py-2">
                                                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" style="border-radius: 8px;">Đóng</button>
                                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-info btn-sm text-white" style="border-radius: 8px;">
                                                          Chỉnh sửa sản phẩm
                                                        </a>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">Chưa có sản phẩm nào trong hệ thống.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- Phân trang -->
                        @if(isset($products) && $products->total() > 0)
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <small class="text-muted">
                                    Hiển thị từ {{ $products->firstItem() }} đến {{ $products->lastItem() }} của tổng số {{ $products->total() }} sản phẩm
                                </small>
                                @if($products->hasPages())
                                    <div>
                                        {{ $products->links('pagination::bootstrap-4') }}
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Search Autocomplete Custom Styles & Script -->
    <style>
    .suggestion-item:hover {
        background-color: #f1f5f9 !important;
        cursor: pointer;
    }
    .suggestion-item img {
        transition: transform 0.2s;
    }
    .suggestion-item:hover img {
        transform: scale(1.05);
    }
    #suggestions-box {
        max-height: 320px;
        overflow-y: auto;
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');
        const suggestionsBox = document.getElementById('suggestions-box');
        let debounceTimer;

        if (searchInput && suggestionsBox) {
            searchInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                const query = this.value.trim();

                if (query.length < 2) {
                    suggestionsBox.style.display = 'none';
                    suggestionsBox.innerHTML = '';
                    return;
                }

                debounceTimer = setTimeout(() => {
                    fetch(`{{ route('admin.products.suggestions') }}?q=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length === 0) {
                                suggestionsBox.innerHTML = '<div class="p-3 text-muted text-center" style="font-size: 13px;">Không tìm thấy sản phẩm nào</div>';
                                suggestionsBox.style.display = 'block';
                                return;
                            }

                            let html = '<div class="list-group list-group-flush">';
                            data.forEach(item => {
                                const priceFormatted = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(item.price);
                                const imgUrl = item.image ? `/images/products/${item.image}` : '';
                                const imgHtml = imgUrl 
                                    ? `<img src="${imgUrl}" style="width: 36px; height: 36px; object-fit: cover; border-radius: 6px; margin-right: 12px; border: 1px solid #e2e8f0;">` 
                                    : `<div class="bg-light d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; border-radius: 6px; margin-right: 12px; border: 1px solid #e2e8f0;"><i class="typcn typcn-image text-muted" style="font-size: 18px;"></i></div>`;
                                
                                html += `
                                    <a href="#" class="list-group-item list-group-item-action d-flex align-items-center py-2 px-3 suggestion-item" data-name="${item.name.replace(/"/g, '&quot;')}" style="border: 0; border-bottom: 1px solid #f1f5f9; text-decoration: none; color: inherit; transition: background 0.2s;">
                                        ${imgHtml}
                                        <div style="flex-grow: 1; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; font-size: 13px;">
                                            <div style="font-weight: 600; color: #1e293b; text-overflow: ellipsis; overflow: hidden; margin-bottom: 2px;">${item.name}</div>
                                            <span class="text-danger" style="font-size: 11px; font-weight: 600;">${priceFormatted}</span>
                                        </div>
                                    </a>
                                `;
                            });
                            html += '</div>';
                            suggestionsBox.innerHTML = html;
                            suggestionsBox.style.display = 'block';

                            // Add click event handlers to suggestions
                            const items = suggestionsBox.querySelectorAll('.suggestion-item');
                            items.forEach(item => {
                                item.addEventListener('click', function(e) {
                                    e.preventDefault();
                                    searchInput.value = this.getAttribute('data-name');
                                    suggestionsBox.style.display = 'none';
                                    document.getElementById('search-form').submit();
                                });
                            });
                        })
                        .catch(error => {
                            console.error('Error fetching autocomplete suggestions:', error);
                        });
                }, 250); // 250ms debounce
            });

            // Close suggestion box if clicked outside
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                    suggestionsBox.style.display = 'none';
                }
            });

            // Show suggestions again on focus if not empty
            searchInput.addEventListener('focus', function() {
                if (this.value.trim().length >= 2 && suggestionsBox.children.length > 0) {
                    suggestionsBox.style.display = 'block';
                }
            });
        }
    });
    </script>

      <!-- Toast Notification for Success / Error -->
      @if(session('success') || session('error'))
      <div id="custom-toast" class="custom-toast-container">
          <div class="custom-toast-card {{ session('error') ? 'error-toast' : '' }}">
              <div class="custom-toast-icon">
                  @if(session('success'))
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                          <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                          <polyline points="22 4 12 14.01 9 11.01"></polyline>
                      </svg>
                  @else
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                          <circle cx="12" cy="12" r="10"></circle>
                          <line x1="12" y1="8" x2="12" y2="12"></line>
                          <line x1="12" y1="16" x2="12.01" y2="16"></line>
                      </svg>
                  @endif
              </div>
              <div class="custom-toast-content">
                  <span class="custom-toast-title">{{ session('success') ? 'Thành công' : 'Lỗi' }}</span>
                  <span class="custom-toast-message">{{ session('success') ?? session('error') }}</span>
              </div>
              <button type="button" class="custom-toast-close" onclick="dismissToast()">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                      <line x1="18" y1="6" x2="6" y2="18"></line>
                      <line x1="6" y1="6" x2="18" y2="18"></line>
                  </svg>
              </button>
              <div class="custom-toast-progress"></div>
          </div>
      </div>

      <style>
/* Premium Pagination Styling */
.pagination {
    margin-bottom: 0;
    gap: 6px;
    display: flex;
    padding-left: 0;
    list-style: none;
    border-radius: 8px;
}
.page-item .page-link {
    border: 1px solid #e2e8f0;
    color: #475569;
    border-radius: 8px !important;
    padding: 8px 14px;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.2s ease;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
    background-color: #ffffff;
    display: block;
    line-height: 1.25;
}
.page-item.active .page-link {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
    border-color: transparent !important;
    color: #ffffff !important;
    box-shadow: 0 4px 10px rgba(59, 130, 246, 0.25);
}
.page-item .page-link:hover {
    background-color: #f8fafc;
    color: #1e293b;
    border-color: #cbd5e1;
    transform: translateY(-1px);
    text-decoration: none;
}
.page-item.disabled .page-link {
    background-color: #f1f5f9;
    border-color: #e2e8f0;
    color: #94a3b8;
    pointer-events: none;
}

      .custom-toast-container {
          position: fixed;
          top: 30px;
          right: 30px;
          z-index: 999999;
          pointer-events: none;
      }
      .custom-toast-card {
          pointer-events: auto;
          display: flex;
          align-items: center;
          width: 360px;
          max-width: 90vw;
          background: rgba(255, 255, 255, 0.85);
          backdrop-filter: blur(12px) saturate(180%);
          -webkit-backdrop-filter: blur(12px) saturate(180%);
          border: 1px solid rgba(255, 255, 255, 0.5);
          border-radius: 16px;
          padding: 16px;
          box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08), 
                      0 1px 3px rgba(0, 0, 0, 0.02),
                      inset 0 0 0 1px rgba(255, 255, 255, 0.5);
          overflow: hidden;
          position: relative;
          transform-origin: top right;
          animation: toastSlideIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
          transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
      }
      @keyframes toastSlideIn {
          0% {
              opacity: 0;
              transform: translateY(-20px) scale(0.95);
          }
          100% {
              opacity: 1;
              transform: translateY(0) scale(1);
          }
      }
      @keyframes toastSlideOut {
          0% {
              opacity: 1;
              transform: translateY(0) scale(1);
          }
          100% {
              opacity: 0;
              transform: translateY(-20px) scale(0.95);
          }
      }
      .custom-toast-card.hide {
          animation: toastSlideOut 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
      }
      .custom-toast-icon {
          display: flex;
          align-items: center;
          justify-content: center;
          width: 36px;
          height: 36px;
          background: linear-gradient(135deg, #10b981 0%, #059669 100%);
          border-radius: 10px;
          color: #ffffff;
          flex-shrink: 0;
          box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
          margin-right: 14px;
      }
      .error-toast .custom-toast-icon {
          background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
          box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
      }
      .custom-toast-content {
          display: flex;
          flex-direction: column;
          flex-grow: 1;
          margin-right: 12px;
      }
      .custom-toast-title {
          font-family: system-ui, -apple-system, sans-serif;
          font-weight: 600;
          font-size: 14px;
          color: #111827;
          margin-bottom: 2px;
      }
      .custom-toast-message {
          font-family: system-ui, -apple-system, sans-serif;
          font-size: 13px;
          color: #4b5563;
          line-height: 1.4;
      }
      .custom-toast-close {
          background: none;
          border: none;
          color: #9ca3af;
          cursor: pointer;
          padding: 4px;
          border-radius: 50%;
          display: flex;
          align-items: center;
          justify-content: center;
          transition: all 0.2s;
          outline: none !important;
      }
      .custom-toast-close:hover {
          background: rgba(0, 0, 0, 0.05);
          color: #1f2937;
      }
      .custom-toast-progress {
          position: absolute;
          bottom: 0;
          left: 0;
          height: 3px;
          background: linear-gradient(90deg, #10b981 0%, #34d399 100%);
          width: 100%;
          transform-origin: left;
          animation: toastProgress 4s linear forwards;
      }
      .error-toast .custom-toast-progress {
          background: linear-gradient(90deg, #ef4444 0%, #f87171 100%);
      }
      @keyframes toastProgress {
          0% {
              transform: scaleX(1);
          }
          100% {
              transform: scaleX(0);
          }
      }
      </style>

      <script>
          function dismissToast() {
              const toast = document.getElementById('custom-toast');
              if (toast) {
                  const card = toast.querySelector('.custom-toast-card');
                  card.classList.add('hide');
                  setTimeout(() => {
                      toast.remove();
                  }, 400);
              }
          }
          document.addEventListener('DOMContentLoaded', function() {
              const toast = document.getElementById('custom-toast');
              if (toast) {
                  setTimeout(() => {
                      dismissToast();
                  }, 4000);
              }
          });
      </script>
      @endif
@endsection
