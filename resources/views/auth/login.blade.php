@extends('layouts.app')

@section('title', 'Đăng nhập tài khoản - SPATACUS')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-10 px-4">
    <!-- Login Card Container with Neon Glow and Glassmorphism -->
    <div class="w-full max-w-lg bg-darkBg text-white rounded-2xl shadow-[0_20px_50px_rgba(255,61,0,0.15)] border border-gray-800 overflow-hidden relative transform transition-all duration-300 hover:scale-[1.01]">
        
        <!-- Glowing Accent Light -->
        <div class="absolute -top-24 -left-24 w-48 h-48 bg-primary opacity-20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-48 h-48 bg-green-500 opacity-10 rounded-full blur-3xl pointer-events-none"></div>
 
        <!-- Card Body -->
        <div class="p-8 md:p-12 relative z-10">
            <!-- Header Text -->
            <div class="text-center mb-10">
                <h2 class="text-3xl font-black uppercase tracking-wider mb-2">
                    <span class="text-white">ĐĂNG NHẬP</span>
                    <span class="text-primary">SPATACUS</span>
                </h2>
                <p class="text-gray-400 text-xs font-semibold uppercase tracking-widest">Hệ thống phân phối PC cao cấp</p>
            </div>

            <!-- Session Alert for Custom Redirect Message -->
            @if(session('error'))
                <div class="mb-6 p-4 rounded-lg bg-red-950 border border-red-800 text-red-300 text-xs font-bold flex items-center gap-3">
                    <i class="fas fa-exclamation-circle text-base text-red-500"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-6 p-4 rounded-lg bg-green-950 border border-green-800 text-green-300 text-xs font-bold flex items-center gap-3">
                    <i class="fas fa-check-circle text-base text-green-500"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ url('login') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Email Input Group -->
                <div class="space-y-2">
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-gray-300">Địa chỉ Email</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 group-focus-within:text-primary transition-colors">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" name="email" id="email" 
                               value="{{ old('email') }}" required autofocus
                               placeholder="example@gmail.com" 
                               class="w-full pl-11 pr-4 py-3 bg-gray-900 border border-gray-800 rounded-xl text-sm text-white placeholder-gray-600 outline-none transition duration-200 focus:border-primary focus:ring-1 focus:ring-primary focus:bg-black @error('email') border-red-500 @enderror">
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs font-semibold mt-1 pl-1 flex items-center gap-1">
                            <i class="fas fa-info-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password Input Group -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-xs font-bold uppercase tracking-wider text-gray-300">Mật khẩu</label>
                        <a href="#" class="text-xs text-primary hover:underline font-bold">Quên mật khẩu?</a>
                    </div>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 group-focus-within:text-primary transition-colors">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password" id="password" required
                               placeholder="••••••••" 
                               class="w-full pl-11 pr-12 py-3 bg-gray-900 border border-gray-800 rounded-xl text-sm text-white placeholder-gray-600 outline-none transition duration-200 focus:border-primary focus:ring-1 focus:ring-primary focus:bg-black @error('password') border-red-500 @enderror">
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 hover:text-primary transition-colors">
                            <i class="fas fa-eye" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs font-semibold mt-1 pl-1 flex items-center gap-1">
                            <i class="fas fa-info-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Remember Me Checkbox -->
                <div class="flex items-center">
                    <label class="relative flex items-center cursor-pointer">
                        <input type="checkbox" name="remember" id="remember" 
                               class="sr-only peer">
                        <div class="w-4 h-4 bg-gray-900 border border-gray-800 rounded-md peer peer-checked:bg-primary peer-checked:border-primary transition-all flex items-center justify-center">
                            <i class="fas fa-check text-[10px] text-white hidden peer-checked:block"></i>
                        </div>
                        <span class="ml-2.5 text-xs text-gray-400 font-semibold select-none">Ghi nhớ đăng nhập</span>
                    </label>
                </div>

                <!-- Submit Button with Gradient Slide -->
                <button type="submit" 
                        class="w-full py-3.5 bg-gradient-to-r from-primary to-orange-600 hover:from-orange-600 hover:to-primary text-white rounded-xl font-bold uppercase tracking-wider text-sm shadow-lg shadow-orange-950/50 hover:shadow-orange-600/30 transform active:scale-95 transition-all duration-200 flex items-center justify-center gap-2">
                    <i class="fas fa-sign-in-alt"></i> ĐĂNG NHẬP NGAY
                </button>
            </form>

            <!-- Separator Line -->
            <div class="relative my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-800"></div>
                </div>
                <div class="relative flex justify-center text-xs">
                    <span class="px-3 bg-darkBg text-gray-500 font-bold uppercase tracking-widest">HOẶC</span>
                </div>
            </div>

            <!-- Redirect to Register -->
            <div class="text-center">
                <p class="text-xs text-gray-400 font-semibold">
                    Bạn chưa có tài khoản? 
                    <a href="{{ route('register') }}" class="text-primary hover:underline font-extrabold ml-1 uppercase tracking-wider flex inline-flex items-center gap-1">
                        Đăng ký tài khoản mới <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const passwordInput = document.getElementById('password');
        const togglePasswordButton = document.getElementById('togglePassword');
        const togglePasswordIcon = document.getElementById('togglePasswordIcon');

        if (togglePasswordButton && passwordInput && togglePasswordIcon) {
            togglePasswordButton.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                if (type === 'password') {
                    togglePasswordIcon.classList.remove('fa-eye-slash');
                    togglePasswordIcon.classList.add('fa-eye');
                } else {
                    togglePasswordIcon.classList.remove('fa-eye');
                    togglePasswordIcon.classList.add('fa-eye-slash');
                }
            });
        }
    });
</script>
@endsection
