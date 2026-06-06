<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>TTGSHOP | Đăng nhập Quản trị hệ thống</title>
  <meta name="description" content="Trang đăng nhập bảo mật dành cho quản trị viên hệ thống cửa hàng TTGSHOP. Vui lòng nhập thông tin để truy cập dashboard.">
  
  <!-- Modern Google Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <!-- Custom Premium Styles -->
  <style>
    :root {
      --bg-color: #0b0c10;
      --card-bg: rgba(255, 255, 255, 0.03);
      --card-border: rgba(255, 255, 255, 0.08);
      --input-bg: rgba(255, 255, 255, 0.05);
      --input-border: rgba(255, 255, 255, 0.1);
      --primary-color: #8b5cf6;
      --secondary-color: #6366f1;
      --text-main: #f3f4f6;
      --text-muted: #9ca3af;
      --error-color: #f87171;
      --error-bg: rgba(248, 113, 113, 0.1);
      --success-color: #34d399;
      --success-bg: rgba(52, 211, 153, 0.1);
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Inter', sans-serif;
      background-color: var(--bg-color);
      color: var(--text-main);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
      overflow: hidden;
    }

    /* Ambient glowing background blur nodes */
    .glow-sphere {
      position: absolute;
      border-radius: 50%;
      filter: blur(140px);
      z-index: -1;
      pointer-events: none;
      opacity: 0.65;
    }

    .sphere-1 {
      width: 400px;
      height: 400px;
      background: radial-gradient(circle, var(--primary-color) 0%, rgba(139, 92, 246, 0) 70%);
      top: -100px;
      left: -100px;
      animation: float-slow 15s infinite alternate ease-in-out;
    }

    .sphere-2 {
      width: 500px;
      height: 500px;
      background: radial-gradient(circle, var(--secondary-color) 0%, rgba(99, 102, 241, 0) 70%);
      bottom: -150px;
      right: -100px;
      animation: float-slow 20s infinite alternate-reverse ease-in-out;
    }

    @keyframes float-slow {
      0% { transform: translate(0, 0) scale(1); }
      100% { transform: translate(50px, 30px) scale(1.1); }
    }

    /* Login Card Container */
    .login-container {
      width: 100%;
      max-width: 440px;
      padding: 24px;
      z-index: 10;
    }

    .login-card {
      background: var(--card-bg);
      border: 1px solid var(--card-border);
      backdrop-filter: blur(25px);
      -webkit-backdrop-filter: blur(25px);
      border-radius: 24px;
      padding: 40px;
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
      transform: translateY(0);
      transition: all 0.4s ease;
      animation: fade-in-up 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .login-card:hover {
      box-shadow: 0 25px 60px rgba(139, 92, 246, 0.15);
      border-color: rgba(139, 92, 246, 0.2);
    }

    @keyframes fade-in-up {
      0% {
        opacity: 0;
        transform: translateY(20px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Logo & Header info */
    .login-header {
      text-align: center;
      margin-bottom: 32px;
    }

    .logo-container {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 64px;
      height: 64px;
      border-radius: 16px;
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
      margin-bottom: 16px;
      box-shadow: 0 8px 24px rgba(139, 92, 246, 0.3);
      animation: pulse-slow 3s infinite ease-in-out;
    }

    @keyframes pulse-slow {
      0%, 100% { transform: scale(1); box-shadow: 0 8px 24px rgba(139, 92, 246, 0.3); }
      50% { transform: scale(1.05); box-shadow: 0 12px 30px rgba(139, 92, 246, 0.5); }
    }

    .logo-icon {
      font-size: 28px;
      font-weight: 800;
      color: #ffffff;
      letter-spacing: -1.5px;
    }

    h1.title {
      font-size: 24px;
      font-weight: 700;
      color: var(--text-main);
      margin-bottom: 8px;
      letter-spacing: -0.5px;
    }

    .subtitle {
      font-size: 14px;
      color: var(--text-muted);
    }

    /* Notification Banner */
    .alert {
      padding: 12px 16px;
      border-radius: 12px;
      font-size: 13.5px;
      margin-bottom: 24px;
      display: flex;
      align-items: center;
      gap: 10px;
      animation: shake 0.5s ease-in-out;
    }

    .alert-error {
      color: var(--error-color);
      background-color: var(--error-bg);
      border: 1px solid rgba(248, 113, 113, 0.2);
    }

    .alert-success {
      color: var(--success-color);
      background-color: var(--success-bg);
      border: 1px solid rgba(52, 211, 153, 0.2);
    }

    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      25% { transform: translateX(-4px); }
      75% { transform: translateX(4px); }
    }

    /* Form Fields */
    .form-group {
      margin-bottom: 20px;
      position: relative;
    }

    .form-label {
      display: block;
      font-size: 13px;
      font-weight: 500;
      color: var(--text-muted);
      margin-bottom: 8px;
      letter-spacing: 0.2px;
    }

    .input-wrapper {
      position: relative;
    }

    .form-control {
      width: 100%;
      background: var(--input-bg);
      border: 1px solid var(--input-border);
      border-radius: 12px;
      padding: 14px 16px;
      color: var(--text-main);
      font-size: 14.5px;
      font-family: inherit;
      outline: none;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .form-control:focus {
      border-color: var(--primary-color);
      background: rgba(255, 255, 255, 0.08);
      box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.18);
    }

    .form-control::placeholder {
      color: rgba(255, 255, 255, 0.25);
    }

    .error-text {
      color: var(--error-color);
      font-size: 12px;
      margin-top: 6px;
      display: block;
    }

    /* Actions Checkbox & Link */
    .form-actions {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 28px;
    }

    .checkbox-container {
      display: flex;
      align-items: center;
      cursor: pointer;
      user-select: none;
      font-size: 13px;
      color: var(--text-muted);
    }

    .checkbox-container input {
      display: none;
    }

    .custom-checkbox {
      width: 18px;
      height: 18px;
      border: 1px solid var(--input-border);
      border-radius: 6px;
      margin-right: 8px;
      display: inline-flex;
      justify-content: center;
      align-items: center;
      background: var(--input-bg);
      transition: all 0.2s ease;
    }

    .checkbox-container input:checked + .custom-checkbox {
      background: var(--primary-color);
      border-color: var(--primary-color);
    }

    .checkbox-container input:checked + .custom-checkbox::after {
      content: "";
      width: 5px;
      height: 9px;
      border: solid white;
      border-width: 0 2px 2px 0;
      transform: rotate(45deg) translate(-0.5px, -1px);
    }

    .link-forgot {
      font-size: 13px;
      color: var(--primary-color);
      text-decoration: none;
      transition: color 0.2s ease;
    }

    .link-forgot:hover {
      color: var(--secondary-color);
      text-decoration: underline;
    }

    /* Submit Button */
    .btn-submit {
      width: 100%;
      background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
      border: none;
      border-radius: 12px;
      padding: 14px;
      color: #ffffff;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
      outline: none;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 0 4px 15px rgba(139, 92, 246, 0.25);
    }

    .btn-submit:hover {
      box-shadow: 0 6px 20px rgba(139, 92, 246, 0.4);
      transform: translateY(-1px);
      filter: brightness(1.08);
    }

    .btn-submit:active {
      transform: translateY(1px);
      box-shadow: 0 2px 8px rgba(139, 92, 246, 0.25);
    }

    /* Footer Shop Info */
    .login-footer {
      text-align: center;
      margin-top: 24px;
      font-size: 12.5px;
      color: rgba(255, 255, 255, 0.3);
    }

    .login-footer a {
      color: var(--text-muted);
      text-decoration: none;
      transition: color 0.2s ease;
    }

    .login-footer a:hover {
      color: var(--text-main);
    }

    /* Responsive adjusts */
    @media (max-width: 480px) {
      .login-card {
        padding: 30px 24px;
        border-radius: 20px;
      }
      h1.title {
        font-size: 21px;
      }
    }
  </style>
</head>
<body>

  <!-- Ambient light spheres -->
  <div class="glow-sphere sphere-1"></div>
  <div class="glow-sphere sphere-2"></div>

  <div class="login-container">
    <div class="login-card">
      <div class="login-header">
        <div class="logo-container">
          <span class="logo-icon">TTG</span>
        </div>
        <h1 class="title">Xin chào Admin</h1>
        <p class="subtitle">Đăng nhập tài khoản quản trị hệ thống</p>
      </div>

      <!-- Handle Session Status / Alerts -->
      @if (session('error'))
        <div class="alert alert-error" id="error_alert">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
          <span>{{ session('error') }}</span>
        </div>
      @endif

      @if (session('success'))
        <div class="alert alert-success" id="success_alert">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
          <span>{{ session('success') }}</span>
        </div>
      @endif

      <!-- Main Login Form -->
      <form action="{{ url('admin/login') }}" method="POST" autocomplete="off">
        @csrf
        
        <!-- Email Input Group -->
        <div class="form-group">
          <label for="admin_email" class="form-label">Địa chỉ Email</label>
          <div class="input-wrapper">
            <input 
              type="email" 
              name="email" 
              id="admin_email" 
              class="form-control" 
              placeholder="ten@shop.com" 
              value="{{ old('email') }}" 
              required 
              autofocus
            >
          </div>
          @error('email')
            <span class="error-text" id="email_error">{{ $message }}</span>
          @enderror
        </div>

        <!-- Password Input Group -->
        <div class="form-group">
          <label for="admin_password" class="form-label">Mật khẩu</label>
          <div class="input-wrapper">
            <input 
              type="password" 
              name="password" 
              id="admin_password" 
              class="form-control" 
              placeholder="••••••••" 
              required
            >
          </div>
          @error('password')
            <span class="error-text" id="password_error">{{ $message }}</span>
          @enderror
        </div>

        <!-- Checkbox Remember -->
        <div class="form-actions">
          <label class="checkbox-container">
            <input type="checkbox" name="remember" id="admin_remember">
            <span class="custom-checkbox"></span>
            Ghi nhớ đăng nhập
          </label>
          <a href="{{ url('index') }}" class="link-forgot">Trang chủ TTG</a>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn-submit" id="admin_login_btn">
          Đăng nhập hệ thống
        </button>
      </form>
    </div>

    <!-- Admin portal footer -->
    <div class="login-footer">
      <p>&copy; 2026 <a href="{{ url('index') }}">TTGSHOP</a>. Tất cả các quyền được bảo lưu.</p>
    </div>
  </div>

</body>
</html>
