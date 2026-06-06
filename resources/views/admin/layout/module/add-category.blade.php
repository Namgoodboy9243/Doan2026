@extends('admin.layout.master')

@section('content')
      <div class="main-panel">        
        <div class="content-wrapper">
          <div class="row">
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Thêm danh mục mới</h4>
                  <p class="card-description">
                    Nhập thông tin chi tiết cho danh mục sản phẩm
                  </p>
                  <form action="{{ route('admin.category_post.addCategory') }}" method="POST" class="forms-sample">
                    @csrf
                    <div class="form-group">
                      <label for="categoryName">Tên danh mục</label>
                      <input type="text" class="form-control @error('name') is-invalid @enderror" id="categoryName" name="name" value="{{ old('name') }}" placeholder="Nhập tên danh mục">
                      @error('name')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label for="categoryStatus">Trạng thái</label>
                      <select class="form-control @error('status') is-invalid @enderror" id="categoryStatus" name="status">
                        <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Hiển thị</option>
                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Ẩn</option>
                      </select>
                      @error('status')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                      @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Lưu danh mục</button>
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
@endsection
