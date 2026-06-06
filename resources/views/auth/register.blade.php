@extends('layouts.app')

@section('title', 'Đăng ký tài khoản - SPATACUS')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center py-10 px-4">
    <!-- Register Card Container with Neon Glow and Glassmorphism -->
    <div class="w-full max-w-lg bg-darkBg text-white rounded-2xl shadow-[0_20px_50px_rgba(34,197,94,0.1)] border border-gray-800 overflow-hidden relative transform transition-all duration-300 hover:scale-[1.01]">
        
        <!-- Glowing Accent Light -->
        <div class="absolute -top-24 -left-24 w-48 h-48 bg-green-500 opacity-15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-48 h-48 bg-primary opacity-15 rounded-full blur-3xl pointer-events-none"></div>

        <!-- Card Body -->
        <div class="p-8 md:p-12 relative z-10">
            <!-- Header Text -->
            <div class="text-center mb-10">
                <h2 class="text-3xl font-black uppercase tracking-wider mb-2">
                    <span class="text-white">ĐĂNG KÝ</span>
                    <span class="text-green-500">TÀI KHOẢN</span>
                </h2>
                <p class="text-gray-400 text-xs font-semibold uppercase tracking-widest">Gia nhập cộng đồng game thủ SPATACUS</p>
            </div>

            <!-- Session Alert -->
            @if($errors->any())
                <div class="mb-6 p-4 rounded-lg bg-red-950 border border-red-800 text-red-300 text-xs font-bold flex flex-col gap-1.5">
                    <div class="flex items-center gap-2 mb-1">
                        <i class="fas fa-exclamation-circle text-base text-red-500"></i>
                        <span>Có lỗi xảy ra khi đăng ký:</span>
                    </div>
                    <ul class="list-disc list-inside pl-2 text-[11px] font-medium space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Register Form -->
            <form action="{{ url('register') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Name Input Group -->
                <div class="space-y-1.5">
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-gray-300">Họ và Tên</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 group-focus-within:text-green-500 transition-colors">
                            <i class="fas fa-user"></i>
                        </span>
                        <input type="text" name="name" id="name" 
                               value="{{ old('name') }}" required autofocus
                               placeholder="Nguyễn Văn A" 
                               class="w-full pl-11 pr-4 py-3 bg-gray-900 border border-gray-800 rounded-xl text-sm text-white placeholder-gray-600 outline-none transition duration-200 focus:border-green-500 focus:ring-1 focus:ring-green-500 focus:bg-black">
                    </div>
                </div>

                <!-- Email Input Group -->
                <div class="space-y-1.5">
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-gray-300">Địa chỉ Email</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 group-focus-within:text-green-500 transition-colors">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" name="email" id="email" 
                               value="{{ old('email') }}" required
                               placeholder="example@gmail.com" 
                               class="w-full pl-11 pr-4 py-3 bg-gray-900 border border-gray-800 rounded-xl text-sm text-white placeholder-gray-600 outline-none transition duration-200 focus:border-green-500 focus:ring-1 focus:ring-green-500 focus:bg-black">
                    </div>
                </div>

                <!-- Password Input Group -->
                <div class="space-y-1.5">
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-gray-300">Mật khẩu</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 group-focus-within:text-green-500 transition-colors">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password" id="password" required
                               placeholder="Tối thiểu 6 ký tự" 
                               class="w-full pl-11 pr-12 py-3 bg-gray-900 border border-gray-800 rounded-xl text-sm text-white placeholder-gray-600 outline-none transition duration-200 focus:border-green-500 focus:ring-1 focus:ring-green-500 focus:bg-black">
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 hover:text-green-500 transition-colors">
                            <i class="fas fa-eye" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Password Confirmation Input Group -->
                <div class="space-y-1.5">
                    <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-gray-300">Nhập lại mật khẩu</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 group-focus-within:text-green-500 transition-colors">
                            <i class="fas fa-shield-alt"></i>
                        </span>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                               placeholder="Xác nhận lại mật khẩu" 
                               class="w-full pl-11 pr-12 py-3 bg-gray-900 border border-gray-800 rounded-xl text-sm text-white placeholder-gray-600 outline-none transition duration-200 focus:border-green-500 focus:ring-1 focus:ring-green-500 focus:bg-black">
                        <button type="button" id="togglePasswordConfirm" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 hover:text-green-500 transition-colors">
                            <i class="fas fa-eye" id="togglePasswordConfirmIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Policy Agreement -->
                <div class="flex items-start pt-1">
                    <label class="relative flex items-start cursor-pointer">
                        <input type="checkbox" required class="sr-only peer">
                        <div class="w-4 h-4 mt-0.5 bg-gray-900 border border-gray-800 rounded-md peer peer-checked:bg-green-500 peer-checked:border-green-500 transition-all flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-check text-[10px] text-white hidden peer-checked:block"></i>
                        </div>
                        <span class="ml-2.5 text-xs text-gray-400 font-semibold select-none">
                            Tôi đồng ý với các <a href="#" class="text-green-500 hover:underline">Điều khoản dịch vụ</a> và <a href="#" class="text-green-500 hover:underline">Chính sách bảo mật</a> của SPATACUS.
                        </span>
                    </label>
                </div>

                <!-- Submit Button with Gradient Slide -->
                <button type="submit" 
                        class="w-full mt-4 py-3.5 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-emerald-600 hover:to-green-500 text-white rounded-xl font-bold uppercase tracking-wider text-sm shadow-lg shadow-emerald-950/50 hover:shadow-green-500/30 transform active:scale-95 transition-all duration-200 flex items-center justify-center gap-2">
                    <i class="fas fa-user-plus"></i> ĐĂNG KÝ NGAY
                </button>
            </form>

            <!-- Separator Line -->
            <div class="relative my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-800"></div>
                </div>
                <div class="relative flex justify-center text-xs">
                    <span class="px-3 bg-darkBg text-gray-500 font-bold uppercase tracking-widest">ĐÃ CÓ TÀI KHOẢN?</span>
                </div>
            </div>

            <!-- Redirect to Login -->
            <div class="text-center">
                <p class="text-xs text-gray-400 font-semibold">
                    Bạn đã đăng ký tài khoản từ trước? 
                    <a href="{{ route('login') }}" class="text-green-500 hover:underline font-extrabold ml-1 uppercase tracking-wider flex inline-flex items-center gap-1">
                        Đăng nhập ngay <i class="fas fa-sign-in-alt text-[10px]"></i>
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
        // Toggle password
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

        // Toggle password confirmation
        const passwordConfirmInput = document.getElementById('password_confirmation');
        const togglePasswordConfirmButton = document.getElementById('togglePasswordConfirm');
        const togglePasswordConfirmIcon = document.getElementById('togglePasswordConfirmIcon');

        if (togglePasswordConfirmButton && passwordConfirmInput && togglePasswordConfirmIcon) {
            togglePasswordConfirmButton.addEventListener('click', function() {
                const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordConfirmInput.setAttribute('type', type);
                
                if (type === 'password') {
                    togglePasswordConfirmIcon.classList.remove('fa-eye-slash');
                    togglePasswordConfirmIcon.classList.add('fa-eye');
                } else {
                    togglePasswordConfirmIcon.classList.remove('fa-eye');
                    togglePasswordConfirmIcon.classList.add('fa-eye-slash');
                }
            });
        }
    });
</script>
@endsection
