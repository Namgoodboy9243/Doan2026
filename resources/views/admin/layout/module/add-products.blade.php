@extends('admin.layout.master')

@section('content')
      <div class="main-panel">        
        <div class="content-wrapper">
          <div class="row" style="width: 1000px;">
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Thêm sản phẩm mới</h4>
                  <p class="card-description">
                    Nhập thông tin chi tiết cho sản phẩm
                  </p>
                  @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none; background-color: #fee2e2; color: #991b1b; padding: 15px 20px; margin-bottom: 25px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                      <div class="d-flex align-items-center mb-2">
                        <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #ef4444;">
                          <circle cx="12" cy="12" r="10"></circle>
                          <line x1="12" y1="8" x2="12" y2="12"></line>
                          <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        <strong style="font-size: 15px; margin-left: 8px;">Có lỗi xảy ra, vui lòng kiểm tra lại:</strong>
                      </div>
                      <ul class="mb-0 pl-4" style="font-size: 13px; line-height: 1.6;">
                        @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                        @endforeach
                      </ul>
                    </div>
                  @endif

                  @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none; background-color: #fee2e2; color: #991b1b; padding: 15px 20px; margin-bottom: 25px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                      <div class="d-flex align-items-center mb-2">
                        <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #ef4444;">
                          <circle cx="12" cy="12" r="10"></circle>
                          <line x1="12" y1="8" x2="12" y2="12"></line>
                          <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        <strong style="font-size: 15px; margin-left: 8px;">Có lỗi xảy ra, vui lòng kiểm tra lại:</strong>
                      </div>
                      <ul class="mb-0 pl-4" style="font-size: 13px; line-height: 1.6;">
                        @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                        @endforeach
                      </ul>
                    </div>
                  @endif

                  <form class="forms-sample" action="{{ route('admin.products_post.addProducts') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                      <label for="productName">Tên sản phẩm <span class="text-danger">*</span></label>
                      <input type="text" class="form-control @error('name') is-invalid @enderror" id="productName" name="name" value="{{ old('name') }}" placeholder="Nhập tên sản phẩm">
                      @error('name')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label for="productPrice">Giá sản phẩm (VNĐ) <span class="text-danger">*</span></label>
                      <input type="number" class="form-control @error('price') is-invalid @enderror" id="productPrice" name="price" value="{{ old('price') }}" placeholder="Ví dụ: 100000" min="0" oninput="if(this.value < 0) this.value = Math.abs(this.value)">
                      @error('price')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label for="productSalePrice">Giá sale (VNĐ) - Tùy chọn</label>
                      <input type="number" class="form-control @error('sale_price') is-invalid @enderror" id="productSalePrice" name="sale_price" value="{{ old('sale_price') }}" placeholder="Ví dụ: 90000" min="0" oninput="if(this.value < 0) this.value = Math.abs(this.value)">
                      @error('sale_price')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label for="productCategory">Danh mục <span class="text-danger">*</span></label>
                        <select class="form-control @error('category_id') is-invalid @enderror" id="productCategory" name="category_id">
                          <option value="">-- Chọn danh mục --</option>
                          @if($categories->count() > 0)
                            @foreach($categories as $category)
                              <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                          @else
                            <option value="">Không có danh mục nào</option>
                          @endif
                        </select>
                        @error('category_id')
                          <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                        @enderror
                      </div>
                    <div class="form-group">
                      <label for="productStatus">Trạng thái</label>
                      <select class="form-control @error('status') is-invalid @enderror" id="productStatus" name="status">
                        <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Hiển thị</option>
                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Ẩn</option>
                      </select>
                      @error('status')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label for="img">Hình ảnh sản phẩm <span class="text-danger">*</span></label>
                      <input type="file" name="image" id="img" class="file-upload-default @error('image') is-invalid @enderror" style="display: none;" onchange="previewImage(event)" accept="image/*">
                      <div class="input-group col-xs-12">
                        <input type="text" id="file-upload-info" class="form-control file-upload-info" disabled placeholder="Chọn hình ảnh tải lên">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button" onclick="document.getElementById('img').click()">Tải lên</button>
                        </span>
                      </div>
                      @error('image')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                      @enderror
                      <div class="mt-3">
                        <img id="image-preview" src="#" alt="Ảnh xem trước" style="display: none; max-width: 200px; max-height: 200px; border-radius: 8px; border: 1px solid #ddd; object-fit: cover;">
                      </div>
                    </div>
                    <div class="form-group">
                      <label style="font-weight: 600; font-size: 15px; color: #2d3748;">Bộ sưu tập ảnh chi tiết (Product Gallery)</label>
                      <p class="text-muted" style="font-size: 13px; margin-top: -5px; margin-bottom: 15px;">Thêm các hình ảnh chi tiết của sản phẩm, chỉ định loại ảnh và thứ tự hiển thị sắp xếp.</p>
                      
                      @if ($errors->has('gallery') || $errors->has('gallery.*.image') || $errors->has('gallery.*.type') || $errors->has('gallery.*.sort_order'))
                        <div class="alert alert-danger p-2" style="border-radius: 8px; font-size: 13px;">
                          Vui lòng kiểm tra lại thông tin các ảnh chi tiết bên dưới. Tất cả các thẻ ảnh đã tạo đều cần chọn tệp hình ảnh.
                        </div>
                      @endif

                      <div id="gallery-container" class="row">
                        <!-- Dynamic items will be added here -->
                      </div>

                      <div class="mt-2">
                        <button type="button" class="btn btn-outline-primary btn-sm btn-icon-text" id="btn-add-gallery-item" style="border-radius: 8px; font-weight: 600;">
                          <i class="typcn typcn-plus mr-1"></i> Thêm ảnh chi tiết
                        </button>
                      </div>
                    </div>

                    <!-- Variant Builder -->
                    <div class="form-group mt-4" style="border-top: 1px solid #e2e8f0; padding-top: 20px;">
                      <label style="font-weight: 600; font-size: 15px; color: #2d3748;">Cấu hình biến thể sản phẩm (Product Variants)</label>
                      <p class="text-muted" style="font-size: 13px; margin-top: -5px; margin-bottom: 15px;">
                        Tạo các phiên bản cấu hình khác nhau cho sản phẩm này.
                      </p>

                      <!-- Matrix Attribute Generator Controls -->
                      <div class="card mb-4 border shadow-sm" style="border-radius: 12px; background: #f8fafc;">
                        <div class="card-body p-3">
                          <h6 class="mb-3" style="font-weight: 600; font-size: 14px; color: #1e293b;">⚡ Bộ tự động sinh tổ hợp cấu hình (Variant Matrix Generator)</h6>
                          <div class="row">
                            <div class="col-md-3 col-sm-6 mb-2">
                              <label style="font-size: 11px; font-weight: 600; color: #475569; margin-bottom: 4px;">CPU (phân tách bằng dấu phẩy)</label>
                              <input type="text" id="matrix-cpu" class="form-control form-control-sm" placeholder="Ví dụ: i5, i7" style="border-radius: 6px;">
                            </div>
                            <div class="col-md-3 col-sm-6 mb-2">
                              <label style="font-size: 11px; font-weight: 600; color: #475569; margin-bottom: 4px;">RAM (phân tách bằng dấu phẩy)</label>
                              <input type="text" id="matrix-ram" class="form-control form-control-sm" placeholder="Ví dụ: 8GB, 16GB" style="border-radius: 6px;">
                            </div>
                            <div class="col-md-3 col-sm-6 mb-2">
                              <label style="font-size: 11px; font-weight: 600; color: #475569; margin-bottom: 4px;">Bộ nhớ / Ổ cứng</label>
                              <input type="text" id="matrix-storage" class="form-control form-control-sm" placeholder="Ví dụ: 512GB SSD, 1TB SSD" style="border-radius: 6px;">
                            </div>
                            <div class="col-md-3 col-sm-6 mb-2">
                              <label style="font-size: 11px; font-weight: 600; color: #475569; margin-bottom: 4px;">Màu sắc</label>
                              <input type="text" id="matrix-color" class="form-control form-control-sm" placeholder="Ví dụ: Xám, Bạc" style="border-radius: 6px; width: 200px;">
                            </div>
                          </div>
                          <div class="mt-2 text-right">
                            <button type="button" class="btn btn-primary btn-sm" id="btn-generate-matrix" style="border-radius: 6px; font-weight: 600;">
                              ⚡ Tự động sinh danh sách biến thể
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="btn-clear-variants" style="border-radius: 6px; font-weight: 600;">
                              Xóa sạch bảng
                            </button>
                          </div>
                        </div>
                      </div>

                      @if ($errors->has('variants') || $errors->has('variants.*.price') || $errors->has('variants.*.stock'))
                        <div class="alert alert-danger p-2" style="border-radius: 8px; font-size: 13px;">
                          Vui lòng kiểm tra lại thông tin các biến thể bên dưới. Đảm bảo nhập đúng giá và số lượng kho cho tất cả các biến thể đã tạo.
                        </div>
                      @endif

                      <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="variants-table" style="background: #ffffff; border-radius: 8px; overflow: hidden;">
                          <thead class="bg-light">
                            <tr>
                              <th style="font-size: 12px; font-weight: 600; color: #475569; width: 120px;">CPU</th>
                              <th style="font-size: 12px; font-weight: 600; color: #475569; width: 100px;">RAM</th>
                              <th style="font-size: 12px; font-weight: 600; color: #475569; width: 120px;">Bộ nhớ</th>
                              <th style="font-size: 12px; font-weight: 600; color: #475569; width: 100px;">Màu sắc</th>
                              <th style="font-size: 12px; font-weight: 600; color: #475569; width: 140px;">Mã kho (SKU)</th>
                              <th style="font-size: 12px; font-weight: 600; color: #475569; width: 130px;">Giá riêng (VNĐ) <span class="text-danger">*</span></th>
                              <th style="font-size: 12px; font-weight: 600; color: #475569; width: 90px;">Kho <span class="text-danger">*</span></th>
                              <th style="font-size: 12px; font-weight: 600; color: #475569; width: 70px; text-align: center;">Xóa</th>
                            </tr>
                          </thead>
                          <tbody id="variants-container">
                            <!-- Dynamic rows will be inserted here -->
                          </tbody>
                        </table>
                      </div>

                      <div class="mt-2">
                        <button type="button" class="btn btn-outline-success btn-sm btn-icon-text" id="btn-add-variant" style="border-radius: 8px; font-weight: 600;">
                          <i class="typcn typcn-plus mr-1"></i> Thêm dòng biến thể
                        </button>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="productDescription">Mô tả sản phẩm <span class="text-danger">*</span></label>
                      <textarea class="form-control @error('description') is-invalid @enderror" id="productDescription" name="description" rows="4" placeholder="Nhập mô tả sản phẩm">{{ old('description') }}</textarea>
                      @error('description')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                      @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Lưu sản phẩm</button>
                    <button type="button" class="btn btn-light">Hủy bỏ</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>

      <!-- Toast Notification for Success -->
      @if(session('success'))
      <div id="custom-toast" class="custom-toast-container">
          <div class="custom-toast-card">
              <div class="custom-toast-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                      <polyline points="22 4 12 14.01 9 11.01"></polyline>
                  </svg>
              </div>
              <div class="custom-toast-content">
                  <span class="custom-toast-title">Thành công</span>
                  <span class="custom-toast-message">{{ session('success') }}</span>
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

<script>
    function previewImage(event) {
        var input = event.target;
        var info = document.getElementById('file-upload-info');
        var preview = document.getElementById('image-preview');
        
        if (input.files && input.files[0]) {
            info.value = input.files[0].name;
            var reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            info.value = '';
            preview.src = '#';
            preview.style.display = 'none';
        }
    }

    var galleryIndex = 0;

    function addGalleryItemHtml(index, type = '1', sortOrder = '', hasError = false) {
        var borderStyle = hasError ? 'border-color: #f87171 !important;' : '';
        var boxBorderStyle = hasError ? 'border: 2px dashed #f87171; background: #fff5f5;' : 'border: 2px dashed #cbd5e1; background: #f8fafc;';
        var placeholderContent = hasError 
            ? `<div id="gallery-placeholder-${index}" class="text-danger d-flex flex-column align-items-center"><i class="typcn typcn-image" style="font-size: 32px; color: #ef4444;"></i><span style="font-size: 12px; font-weight: 600;">Chọn lại hình ảnh *</span></div>`
            : `<div id="gallery-placeholder-${index}" class="text-muted d-flex flex-column align-items-center"><i class="typcn typcn-image" style="font-size: 32px; color: #94a3b8;"></i><span style="font-size: 12px; color: #64748b;">Chọn hình ảnh</span></div>`;

        return `
            <div class="col-md-6 col-lg-4 mb-3 gallery-item" id="gallery-item-${index}">
              <div class="card h-100 shadow-sm border" style="border-radius: 12px; overflow: hidden; background: #fcfcfc; ${borderStyle}">
                <div class="card-body p-3 d-flex flex-column justify-content-between">
                  
                  <!-- Upload area and preview -->
                  <div class="text-center mb-3">
                    <input type="file" name="gallery[${index}][image]" id="gallery-file-${index}" class="gallery-file-input" style="display: none;" onchange="previewGalleryItemImage(this, ${index})" accept="image/*">
                    <div class="gallery-image-upload-box mx-auto" onclick="document.getElementById('gallery-file-${index}').click()" style="width: 100%; height: 150px; border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center; cursor: pointer; overflow: hidden; transition: all 0.2s; ${boxBorderStyle}">
                      <img id="gallery-preview-${index}" src="#" alt="Xem trước" style="display: none; width: 100%; height: 100%; object-fit: cover;">
                      ${placeholderContent}
                    </div>
                  </div>
                  
                  <!-- Dropdown and Order input -->
                  <div>
                    <div class="form-group mb-2">
                      <label style="font-size: 12px; font-weight: 600; color: #475569;">Loại ảnh</label>
                      <select name="gallery[${index}][type]" class="form-control form-control-sm" style="border-radius: 6px; height: 34px;">
                        <option value="1" ${type == '1' ? 'selected' : ''}>Ảnh chi tiết</option>
                        <option value="2" ${type == '2' ? 'selected' : ''}>Ảnh banner/quảng cáo</option>
                      </select>
                    </div>
                    
                    <div class="form-group mb-3">
                      <label style="font-size: 12px; font-weight: 600; color: #475569;">Thứ tự sắp xếp</label>
                      <input type="number" name="gallery[${index}][sort_order]" class="form-control form-control-sm" value="${sortOrder !== '' ? sortOrder : index}" min="0" style="border-radius: 6px; height: 34px;">
                    </div>
                  </div>

                  <!-- Delete Button -->
                  <div class="text-right">
                    <button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="removeGalleryItem(${index})" style="border-radius: 6px;">
                      Xóa ảnh này
                    </button>
                  </div>

                </div>
              </div>
            </div>
        `;
    }

    document.getElementById('btn-add-gallery-item').addEventListener('click', function() {
        var container = document.getElementById('gallery-container');
        container.insertAdjacentHTML('beforeend', addGalleryItemHtml(galleryIndex));
        galleryIndex++;
    });

    function previewGalleryItemImage(input, index) {
        var preview = document.getElementById('gallery-preview-' + index);
        var placeholder = document.getElementById('gallery-placeholder-' + index);
        
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                if (placeholder) {
                    placeholder.style.display = 'none';
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeGalleryItem(index) {
        var item = document.getElementById('gallery-item-' + index);
        if (item) {
            item.remove();
        }
    }

    var variantIndex = 0;

    function addVariantRowHtml(index, cpu = '', ram = '', storage = '', color = '', sku = '', price = '', stock = '0') {
        return `
            <tr id="variant-row-${index}">
              <td>
                <input type="text" name="variants[${index}][cpu]" class="form-control form-control-sm" value="${cpu}" placeholder="e.g. i5, i7" style="border-radius: 4px;">
              </td>
              <td>
                <input type="text" name="variants[${index}][ram]" class="form-control form-control-sm" value="${ram}" placeholder="e.g. 8GB, 16GB" style="border-radius: 4px;">
              </td>
              <td>
                <input type="text" name="variants[${index}][storage]" class="form-control form-control-sm" value="${storage}" placeholder="e.g. 256GB SSD" style="border-radius: 4px;">
              </td>
              <td>
                <input type="text" name="variants[${index}][color]" class="form-control form-control-sm" value="${color}" placeholder="e.g. Xám, Bạc" style="border-radius: 4px;">
              </td>
              <td>
                <input type="text" name="variants[${index}][sku]" class="form-control form-control-sm" value="${sku}" placeholder="e.g. SKU-DELL" style="border-radius: 4px;">
              </td>
              <td>
                <input type="number" name="variants[${index}][price]" class="form-control form-control-sm" value="${price}" min="0" placeholder="Nhập giá" required style="border-radius: 4px;">
              </td>
              <td>
                <input type="number" name="variants[${index}][stock]" class="form-control form-control-sm" value="${stock}" min="0" required style="border-radius: 4px;">
              </td>
              <td class="text-center">
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeVariantRow(${index})" style="padding: 4px 8px; border-radius: 4px;">
                  &times;
                </button>
              </td>
            </tr>
        `;
    }

    document.getElementById('btn-add-variant').addEventListener('click', function() {
        var container = document.getElementById('variants-container');
        container.insertAdjacentHTML('beforeend', addVariantRowHtml(variantIndex));
        variantIndex++;
    });

    function removeVariantRow(index) {
        var row = document.getElementById('variant-row-' + index);
        if (row) {
            row.remove();
        }
    }

    document.getElementById('btn-clear-variants').addEventListener('click', function() {
        if(confirm('Bạn có chắc chắn muốn xóa tất cả các dòng biến thể hiện tại?')) {
            document.getElementById('variants-container').innerHTML = '';
            variantIndex = 0;
        }
    });

    document.getElementById('btn-generate-matrix').addEventListener('click', function() {
        var cpusStr = document.getElementById('matrix-cpu').value.trim();
        var ramsStr = document.getElementById('matrix-ram').value.trim();
        var storagesStr = document.getElementById('matrix-storage').value.trim();
        var colorsStr = document.getElementById('matrix-color').value.trim();

        if (!cpusStr && !ramsStr && !storagesStr && !colorsStr) {
            alert('Vui lòng nhập ít nhất một giá trị thuộc tính để tự động sinh.');
            return;
        }

        var parseInput = function(str) {
            if (!str) return [];
            return str.split(',').map(function(item) { return item.trim(); }).filter(function(item) { return item.length > 0; });
        };

        var cpus = parseInput(cpusStr);
        var rams = parseInput(ramsStr);
        var storages = parseInput(storagesStr);
        var colors = parseInput(colorsStr);

        var lists = [];
        if (cpus.length > 0) lists.push(cpus.map(function(v) { return { key: 'cpu', value: v }; }));
        if (rams.length > 0) lists.push(rams.map(function(v) { return { key: 'ram', value: v }; }));
        if (storages.length > 0) lists.push(storages.map(function(v) { return { key: 'storage', value: v }; }));
        if (colors.length > 0) lists.push(colors.map(function(v) { return { key: 'color', value: v }; }));

        if (lists.length === 0) return;

        // Cartesian product
        var combinations = lists.reduce(function(a, b) {
            var r = [];
            a.forEach(function(a_item) {
                b.forEach(function(b_item) {
                    r.push(a_item.concat([b_item]));
                });
            });
            return r;
        }, [[]]);

        var container = document.getElementById('variants-container');
        
        // Ask to merge or overwrite
        var overwrite = true;
        if (container.children.length > 0) {
            overwrite = confirm('Đã có biến thể tồn tại trong bảng. Bạn muốn xóa bảng cũ và tạo mới toàn bộ (OK) hay giữ lại bảng cũ và thêm tiếp (Cancel)?');
        }

        if (overwrite) {
            container.innerHTML = '';
            variantIndex = 0;
        }

        var productName = document.getElementById('productName') ? document.getElementById('productName').value : '';
        var nameSlug = productName.trim().toUpperCase().replace(/[^A-Z0-9]/g, '-').replace(/-+/g, '-').substring(0, 12);
        if (nameSlug.endsWith('-')) nameSlug = nameSlug.slice(0, -1);

        combinations.forEach(function(combo) {
            var cpu = '', ram = '', storage = '', color = '';
            combo.forEach(function(item) {
                if (item.key === 'cpu') cpu = item.value;
                if (item.key === 'ram') ram = item.value;
                if (item.key === 'storage') storage = item.value;
                if (item.key === 'color') color = item.value;
            });

            var attrParts = [];
            if (cpu) attrParts.push(cpu.toUpperCase().replace(/[^A-Z0-9]/g, ''));
            if (ram) attrParts.push(ram.toUpperCase().replace(/[^A-Z0-9]/g, ''));
            if (storage) attrParts.push(storage.toUpperCase().replace(/[^A-Z0-9]/g, ''));
            if (color) attrParts.push(color.toUpperCase().replace(/[^A-Z0-9]/g, ''));

            var sku = (nameSlug ? nameSlug + '-' : '') + attrParts.join('-');

            container.insertAdjacentHTML('beforeend', addVariantRowHtml(
                variantIndex, cpu, ram, storage, color, sku, '', '0'
            ));
            variantIndex++;
        });
    });

    // Restore old inputs on validation fail
    document.addEventListener('DOMContentLoaded', function() {
        // Restore gallery
        var oldGallery = @json(old('gallery', []));
        if (oldGallery && Object.keys(oldGallery).length > 0) {
            var galleryContainer = document.getElementById('gallery-container');
            Object.keys(oldGallery).forEach(function(key) {
                var item = oldGallery[key];
                // Show as error border since file upload is lost on redirect back
                galleryContainer.insertAdjacentHTML('beforeend', addGalleryItemHtml(
                    galleryIndex, item.type, item.sort_order, true
                ));
                galleryIndex++;
            });
        }

        // Restore variants
        var oldVariants = @json(old('variants', []));
        if (oldVariants && Object.keys(oldVariants).length > 0) {
            var variantsContainer = document.getElementById('variants-container');
            Object.keys(oldVariants).forEach(function(key) {
                var item = oldVariants[key];
                variantsContainer.insertAdjacentHTML('beforeend', addVariantRowHtml(
                    variantIndex, 
                    item.cpu || '', 
                    item.ram || '', 
                    item.storage || '', 
                    item.color || '', 
                    item.sku || '', 
                    item.price || '', 
                    item.stock || '0'
                ));
                variantIndex++;
            });
        }

        // Trigger error toast if any
        @if ($errors->any())
            if (typeof showAdminToast === 'function') {
                showAdminToast('Lỗi nhập liệu', 'Vui lòng kiểm tra lại các thông tin màu đỏ trên form!', 'error');
            }
        @endif
    });
</script>
@endsection