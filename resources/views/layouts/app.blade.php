<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SPATACUS - Siêu thị Laptop chính hãng')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#ff3d00',
                        darkBg: '#051923',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f3f4f6; }
        .nav-item:hover { color: #ff3d00; }
        .product-card:hover { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); transform: translateY(-2px); transition: all 0.3s ease; }
        .skew-bg { transform: skewX(-15deg); }
        .unskew-text { transform: skewX(15deg); display: inline-block; }
        @yield('styles')
    </style>
    <!-- WebSocket / Laravel Echo & Pusher CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/7.0.3/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.iife.js"></script>
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

        // Kiểm tra và cập nhật trạng thái ngay sau khi DOM load xong
        document.addEventListener('DOMContentLoaded', function() {
            updateWSBadge(window.Echo.connector.pusher.connection.state);
        });
    </script>
</head>
<body>

    @include('partials.header')

    <main class="container mx-auto px-4 py-4">
        @yield('content')
    </main>

    @include('partials.footer')
    <!-- Floating WS Status Badge -->
    <div id="ws-status-badge" style="position: fixed; bottom: 20px; left: 20px; z-index: 999999; padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: bold; background: #fef3c7; color: #d97706; display: flex; align-items: center; gap: 6px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); border: 1px solid #fde68a; transition: all 0.3s ease;">
        <span style="width: 8px; height: 8px; border-radius: 50%; background: #f59e0b; display: inline-block; transition: background 0.3s;" id="ws-status-dot"></span>
        <span id="ws-status-text">WS: Connecting...</span>
    </div>

    @yield('scripts')
</body>
</html>

