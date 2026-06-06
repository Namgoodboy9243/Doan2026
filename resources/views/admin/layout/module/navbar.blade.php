    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="index.html"><img src="{{ asset('images/logo.svg') }}" alt="logo" /></a>
        <a class="navbar-brand brand-logo-mini" href="index.html"><img src="{{ asset('images/logo-mini.svg') }}" alt="logo" /></a>
        <button class="navbar-toggler navbar-toggler align-self-center d-none d-lg-flex" type="button"
          data-toggle="minimize">
          <span class="typcn typcn-th-menu"></span>
        </button>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <ul class="navbar-nav mr-lg-2">
          <li class="nav-item  d-none d-lg-flex">
            <a class="nav-link" href="#">
              Calendar
            </a>
          </li>
          <li class="nav-item  d-none d-lg-flex">
            <a class="nav-link active" href="#">
              Statistic
            </a>
          </li>
          <li class="nav-item  d-none d-lg-flex">
            <a class="nav-link" href="#">
              Employee
            </a>
          </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item d-none d-lg-flex  mr-2">
            <a class="nav-link" href="#">
              Help
            </a>
          </li>
          <li class="nav-item dropdown d-flex">
            <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center"
              id="messageDropdown" href="#" data-toggle="dropdown">
              <i class="typcn typcn-message-typing"></i>
              <span class="count bg-success">2</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
              aria-labelledby="messageDropdown">
              <p class="mb-0 font-weight-normal float-left dropdown-header">Messages</p>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <img src="{{ asset('images/faces/face4.jpg') }}" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content flex-grow">
                  <h6 class="preview-subject ellipsis font-weight-normal">David Grey
                  </h6>
                  <p class="font-weight-light small-text mb-0">
                    The meeting is cancelled
                  </p>
                </div>
              </a>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <img src="{{ asset('images/faces/face2.jpg') }}" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content flex-grow">
                  <h6 class="preview-subject ellipsis font-weight-normal">Tim Cook
                  </h6>
                  <p class="font-weight-light small-text mb-0">
                    New product launch
                  </p>
                </div>
              </a>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <img src="{{ asset('images/faces/face3.jpg') }}" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content flex-grow">
                  <h6 class="preview-subject ellipsis font-weight-normal"> Johnson
                  </h6>
                  <p class="font-weight-light small-text mb-0">
                    Upcoming board meeting
                  </p>
                </div>
              </a>
            </div>
          </li>
          @php
              $pendingOrdersCount = \Illuminate\Support\Facades\DB::table('orders')
                  ->where('status', 1)
                  ->count();
              $recentOrdersForNav = \Illuminate\Support\Facades\DB::table('orders')
                  ->orderBy('created_at', 'desc')
                  ->limit(5)
                  ->get();
          @endphp
          <li class="nav-item dropdown  d-flex">
            <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center"
              id="notificationDropdown" href="#" data-toggle="dropdown">
              <i class="typcn typcn-bell mr-0"></i>
              @if($pendingOrdersCount > 0)
                <span class="count bg-danger" id="nav-notification-count">{{ $pendingOrdersCount }}</span>
              @else
                <span class="count bg-danger d-none" id="nav-notification-count">0</span>
              @endif
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
              aria-labelledby="notificationDropdown" id="nav-notification-list" style="width: 320px; max-height: 400px; overflow-y: auto;">
              <p class="mb-0 font-weight-normal float-left dropdown-header">Đơn hàng mới</p>
              
              <div id="nav-notification-items">
                @forelse($recentOrdersForNav as $order)
                <a class="dropdown-item preview-item" href="{{ route('admin.orders.table') }}?search={{ $order->id }}">
                  <div class="preview-thumbnail">
                    @php
                      $iconBg = 'bg-warning';
                      if ($order->status == 4) $iconBg = 'bg-success';
                      elseif ($order->status == 0) $iconBg = 'bg-danger';
                      elseif ($order->status == 2) $iconBg = 'bg-primary';
                      elseif ($order->status == 3) $iconBg = 'bg-info';
                    @endphp
                    <div class="preview-icon {{ $iconBg }}">
                      <i class="typcn typcn-shopping-cart mx-0"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <h6 class="preview-subject font-weight-normal">Đơn hàng #{{ $order->id }}</h6>
                    <p class="font-weight-light small-text mb-0 text-truncate" style="max-width: 200px;">
                      {{ $order->name }} - 
                      @if($order->status == 1) ⏳ Chờ xác nhận
                      @elseif($order->status == 5) 💳 Chờ CK
                      @elseif($order->status == 2) ⚙️ Đang chuẩn bị
                      @elseif($order->status == 3) 🚚 Đang giao
                      @elseif($order->status == 4) ✅ Giao thành công
                      @else ❌ Đã hủy
                      @endif
                    </p>
                    <small class="text-muted" style="font-size: 10px;">{{ date('d/m H:i', strtotime($order->created_at)) }}</small>
                  </div>
                </a>
                @empty
                <div class="text-center py-3 text-muted" id="nav-no-notifications">
                  <small>Không có đơn hàng nào.</small>
                </div>
                @endforelse
              </div>
              <a class="dropdown-item text-center py-2 border-top" href="{{ route('admin.orders.table') }}">
                <small class="font-weight-bold text-primary">Xem tất cả đơn hàng</small>
              </a>
            </div>
          </li>
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle  pl-0 pr-0" href="#" data-toggle="dropdown" id="profileDropdown">
              <i class="typcn typcn-user-outline mr-0"></i>
              <span class="nav-profile-name" id="admin_profile_name">{{ Auth::user()->name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item" href="{{ url('index') }}">
                <i class="typcn typcn-home text-primary"></i>
                Trang chủ TTG
              </a>
              <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();" id="admin_logout_btn">
                <i class="typcn typcn-power text-primary"></i>
                Đăng xuất
              </a>
              <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none" style="display: none;">
                @csrf
              </form>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
          data-toggle="offcanvas">
          <span class="typcn typcn-th-menu"></span>
        </button>
      </div>
    </nav>
