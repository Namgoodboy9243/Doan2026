<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TTGSHOP Template')</title>
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
</head>
<body>

    @include('partials.header')

    <main class="container mx-auto px-4 py-4">
        @yield('content')
    </main>

    @include('partials.footer')

    @yield('scripts')
</body>
</html>
