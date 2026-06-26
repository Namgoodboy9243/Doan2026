<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>CelestialUI Admin</title>
  <!-- base:css -->
  <link rel="stylesheet" href="{{ asset('vendors/typicons.font/font/typicons.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('css/vertical-layout-light/style.css') }}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />
  <!-- WebSocket / Laravel Echo & Pusher CDN -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/7.0.3/pusher.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.iife.js"></script>
  <style>
  /* Premium Toast Container & Card Styles */
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
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(12px) saturate(180%);
      -webkit-backdrop-filter: blur(12px) saturate(180%);
      border: 1px solid rgba(255, 255, 255, 0.5);
      border-radius: 16px;
      padding: 16px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08), 0 1px 3px rgba(0, 0, 0, 0.02);
      overflow: hidden;
      position: relative;
      transform-origin: top right;
      animation: toastSlideIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
      margin-bottom: 10px;
  }
  @keyframes toastSlideIn {
      0% { opacity: 0; transform: translateY(-20px) scale(0.95); }
      100% { opacity: 1; transform: translateY(0) scale(1); }
  }
  .custom-toast-card.hide {
      animation: toastSlideOut 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
  }
  @keyframes toastSlideOut {
      0% { opacity: 1; transform: translateY(0) scale(1); }
      100% { opacity: 0; transform: translateY(-20px) scale(0.95); }
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
      font-weight: 600;
      font-size: 14px;
      color: #111827;
      margin-bottom: 2px;
  }
  .custom-toast-message {
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
      0% { transform: scaleX(1); }
      100% { transform: scaleX(0); }
  }
  </style>
  <script>
      window.Pusher = Pusher;
      Pusher.logToConsole = true; // Kích hoạt log Pusher ra Console để debug
      window.Echo = new Echo({
          broadcaster: 'pusher',
          key: '{{ config("broadcasting.connections.pusher.key") }}',
          cluster: '{{ config("broadcasting.connections.pusher.options.cluster") }}',
          wsHost: (window.location.hostname === 'localhost' || window.location.hostname === '::1') ? '127.0.0.1' : window.location.hostname,
          wsPort: {{ config("broadcasting.connections.pusher.options.port") ?? 6001 }},
          wssPort: {{ config("broadcasting.connections.pusher.options.port") ?? 6001 }},
          forceTLS: {{ config("broadcasting.connections.pusher.options.scheme") === "https" ? "true" : "false" }},
          enableStats: false,
          enabledTransports: ['ws', 'wss']
      });

      // Hàm cập nhật trạng thái hiển thị của WebSocket Badge
      function updateWSBadge(state) {
          const statusDot = document.getElementById('ws-status-dot');
          const statusText = document.getElementById('ws-status-text');
          const statusBadge = document.getElementById('ws-status-badge');
          if (statusDot && statusText && statusBadge) {
              if (state === 'connected') {
                  statusDot.style.background = '#10b981';
                  statusText.innerText = 'WS: Connected';
                  statusBadge.style.color = '#10b981';
                  statusBadge.style.background = '#dcfce7';
                  statusBadge.style.borderColor = '#bbf7d0';
              } else if (state === 'connecting') {
                  statusDot.style.background = '#f59e0b';
                  statusText.innerText = 'WS: Connecting...';
                  statusBadge.style.color = '#d97706';
                  statusBadge.style.background = '#fef3c7';
                  statusBadge.style.borderColor = '#fde68a';
              } else {
                  statusDot.style.background = '#ef4444';
                  statusText.innerText = 'WS: Disconnected (' + state + ')';
                  statusBadge.style.color = '#b91c1c';
                  statusBadge.style.background = '#fee2e2';
                  statusBadge.style.borderColor = '#fecaca';
              }
          }
      }

      // Theo dõi trạng thái thay đổi
      window.Echo.connector.pusher.connection.bind('state_change', function(states) {
          updateWSBadge(states.current);
      });

      // Hiển thị Toast thông báo phía Admin (Real-time)
      function showAdminToast(title, message, type = 'success') {
          let container = document.getElementById('custom-toast-container-global');
          if (!container) {
              container = document.createElement('div');
              container.id = 'custom-toast-container-global';
              container.className = 'custom-toast-container';
              document.body.appendChild(container);
          }

          const card = document.createElement('div');
          card.className = 'custom-toast-card ' + (type === 'error' ? 'error-toast' : '');
          
          let iconSvg = `
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                  <polyline points="22 4 12 14.01 9 11.01"></polyline>
              </svg>
          `;
          if (type !== 'success') {
              iconSvg = `
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                      <circle cx="12" cy="12" r="10"></circle>
                      <line x1="12" y1="8" x2="12" y2="12"></line>
                      <line x1="12" y1="16" x2="12.01" y2="16"></line>
                  </svg>
              `;
          }

          card.innerHTML = `
              <div class="custom-toast-icon">${iconSvg}</div>
              <div class="custom-toast-content" style="text-align: left;">
                  <span class="custom-toast-title" style="display: block;">${title}</span>
                  <span class="custom-toast-message">${message}</span>
              </div>
              <button type="button" class="custom-toast-close" onclick="this.parentElement.remove()" style="margin-left: auto;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                      <line x1="18" y1="6" x2="6" y2="18"></line>
                      <line x1="6" y1="6" x2="18" y2="18"></line>
                  </svg>
              </button>
              <div class="custom-toast-progress"></div>
          `;

          container.appendChild(card);

          // Phát âm thanh ting nhẹ báo hiệu
          try {
              const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
              const osc = audioCtx.createOscillator();
              const gain = audioCtx.createGain();
              osc.connect(gain);
              gain.connect(audioCtx.destination);
              osc.type = 'sine';
              osc.frequency.setValueAtTime(587.33, audioCtx.currentTime); // D5
              osc.frequency.setValueAtTime(880, audioCtx.currentTime + 0.12); // A5
              gain.gain.setValueAtTime(0.08, audioCtx.currentTime);
              gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.4);
              osc.start();
              osc.stop(audioCtx.currentTime + 0.4);
          } catch (e) {
              console.log('Audio context is blocked or not supported.');
          }

          setTimeout(() => {
              card.classList.add('hide');
              setTimeout(() => { card.remove(); }, 400);
          }, 4000);
      }

      // Lắng nghe sự kiện đơn hàng mới toàn cục
      document.addEventListener('DOMContentLoaded', function() {
          // Kiểm tra và cập nhật trạng thái badge kết nối ngay sau khi DOM load xong
          updateWSBadge(window.Echo.connector.pusher.connection.state);

          if (window.Echo) {
              const channel = window.Echo.channel('admin-notifications');

              const handleNewOrderGlobal = (e) => {
                  console.log('Global OrderPlaced event received:', e);
                  
                  const orderData = e.order || e;
                  const customerName = orderData.name || 'Khách hàng';
                  const orderId = orderData.id || 'Mới';

                  // 1. Cập nhật Badge số lượng thông báo trên Navbar
                  const countBadge = document.getElementById('nav-notification-count');
                  if (countBadge) {
                      let currentCount = parseInt(countBadge.innerText) || 0;
                      currentCount++;
                      countBadge.innerText = currentCount;
                      countBadge.classList.remove('d-none');
                  }

                  // 2. Thêm đơn hàng mới vào Dropdown thông báo trên Navbar
                  const itemsContainer = document.getElementById('nav-notification-items');
                  if (itemsContainer) {
                      const noNotifications = document.getElementById('nav-no-notifications');
                      if (noNotifications) noNotifications.remove();

                      const newItem = document.createElement('a');
                      newItem.className = 'dropdown-item preview-item';
                      newItem.href = `{{ route('admin.orders.table') }}?search=${orderId}`;
                      
                      const now = new Date();
                      const day = String(now.getDate()).padStart(2, '0');
                      const month = String(now.getMonth() + 1).padStart(2, '0');
                      const hours = String(now.getHours()).padStart(2, '0');
                      const minutes = String(now.getMinutes()).padStart(2, '0');
                      const formattedTime = `${day}/${month} ${hours}:${minutes}`;

                      newItem.innerHTML = `
                        <div class="preview-thumbnail">
                          <div class="preview-icon bg-warning">
                            <i class="typcn typcn-shopping-cart mx-0"></i>
                          </div>
                        </div>
                        <div class="preview-item-content">
                          <h6 class="preview-subject font-weight-normal">Đơn hàng #${orderId}</h6>
                          <p class="font-weight-light small-text mb-0 text-truncate" style="max-width: 200px;">
                            ${customerName} - ⏳ Chờ xác nhận
                          </p>
                          <small class="text-muted" style="font-size: 10px;">${formattedTime}</small>
                        </div>
                      `;
                      
                      itemsContainer.insertBefore(newItem, itemsContainer.firstChild);
                      if (itemsContainer.children.length > 5) {
                          itemsContainer.removeChild(itemsContainer.lastChild);
                      }
                  }

                  // 3. Hiển thị Toast thông báo toàn cục
                  showAdminToast('Đơn Hàng Mới!', `Khách hàng <b>${customerName}</b> vừa đặt đơn hàng #${orderId} thành công!`, 'success');
                  
                  // 4. Nếu đang ở trang Quản lý đơn hàng, reload lại sau 2.5s để cập nhật bảng dữ liệu
                  const isOrdersPage = window.location.pathname.includes('admin/orders');
                  if (isOrdersPage) {
                      setTimeout(() => {
                          window.location.reload();
                      }, 2500);
                  }

                  // 5. Cập nhật live dashboard nếu hàm updateLiveDashboard có tồn tại
                  if (typeof window.updateLiveDashboard === 'function') {
                      window.updateLiveDashboard();
                  }
              };

              const handleOrderStatusUpdatedGlobal = (e) => {
                  console.log('Global OrderStatusUpdated event received:', e);
                  
                  const orderData = e.order || e;
                  const orderId = orderData.id || 'Mới';
                  const status = parseInt(orderData.status);

                  // Chỉ tự động tải lại nếu đang ở trang Quản lý đơn hàng
                  const isOrdersPage = window.location.pathname.includes('admin/orders');
                  if (isOrdersPage) {
                      // Trạng thái: 2 (Thanh toán chuyển khoản thành công) hoặc 0 (Đã hủy)
                      if (status === 2 || status === 0) {
                          let statusText = status === 2 ? 'được thanh toán chuyển khoản thành công' : 'bị hủy';
                          
                          // Hiển thị Toast thông báo toàn cục
                          showAdminToast('Cập nhật Đơn Hàng!', `Đơn hàng #${orderId} vừa ${statusText}!`, status === 2 ? 'success' : 'error');
                          
                          // Tải lại trang sau 2.5s để cập nhật bảng dữ liệu
                          setTimeout(() => {
                              window.location.reload();
                          }, 2500);
                      }
                  }

                  // Cập nhật live dashboard nếu hàm updateLiveDashboard có tồn tại
                  if (typeof window.updateLiveDashboard === 'function') {
                      window.updateLiveDashboard();
                  }
              };

              channel.listen('.OrderPlaced', handleNewOrderGlobal)
                     .listen('OrderPlaced', handleNewOrderGlobal)
                     .listen('.App\\Events\\OrderPlaced', handleNewOrderGlobal)
                     .listen('.App.Events.OrderPlaced', handleNewOrderGlobal)
                     
                     .listen('.OrderStatusUpdated', handleOrderStatusUpdatedGlobal)
                     .listen('OrderStatusUpdated', handleOrderStatusUpdatedGlobal)
                     .listen('.App\\Events\\OrderStatusUpdated', handleOrderStatusUpdatedGlobal)
                     .listen('.App.Events.OrderStatusUpdated', handleOrderStatusUpdatedGlobal);
          }
      });
  </script>
</head>

<body>
  <div class="row" id="proBanner">
    <div class="col-12">
    </div>
  </div>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    @include('admin.layout.module.navbar')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_settings-panel.html -->
      @include('admin.layout.module.settings-panel')
      <!-- partial -->
      <!-- partial:partials/_sidebar.html -->
      @include('admin.layout.module.sidebar')
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          @yield('content')
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        @include('admin.layout.module.footer')
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- base:js -->
  <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="{{ asset('js/off-canvas.js') }}"></script>
  <script src="{{ asset('js/hoverable-collapse.js') }}"></script>
  <script src="{{ asset('js/template.js') }}"></script>
  <script src="{{ asset('js/settings.js') }}"></script>
  <script src="{{ asset('js/todolist.js') }}"></script>
  <!-- endinject -->
  <!-- plugin js for this page -->
  <script src="{{ asset('vendors/progressbar.js/progressbar.min.js') }}"></script>
  <script src="{{ asset('vendors/chart.js/Chart.min.js') }}"></script>
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="{{ asset('js/dashboard.js') }}"></script>
  @yield('scripts')

  <!-- Floating WS Status Badge -->
  <div id="ws-status-badge" style="position: fixed; bottom: 20px; left: 20px; z-index: 999999; padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: bold; background: #fef3c7; color: #d97706; display: flex; align-items: center; gap: 6px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); border: 1px solid #fde68a; transition: all 0.3s ease;">
      <span style="width: 8px; height: 8px; border-radius: 50%; background: #f59e0b; display: inline-block; transition: background 0.3s;" id="ws-status-dot"></span>
      <span id="ws-status-text">WS: Connecting...</span>
  </div>
</body>

</html>