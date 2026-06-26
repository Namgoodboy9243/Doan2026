@extends('admin.layout.master')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h3 class="mb-2 font-weight-bold text-dark">Quản lý Bình luận & Đánh giá</h3>
        <p class="text-muted">Xem đánh giá sao, tìm kiếm nội dung phản hồi, lọc theo xếp hạng và kiểm duyệt/xóa các bình luận không phù hợp.</p>
    </div>
</div>

<div class="row mt-3">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card border-0 shadow-sm" style="border-radius: 16px; overflow: hidden; box-shadow: 0 4px 25px rgba(0,0,0,0.05) !important;">
            <div class="card-body">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
                    <div>
                        <h4 class="card-title text-dark mb-1">Danh sách Bình luận</h4>
                        <p class="card-description text-muted mb-0">
                            Hiển thị các đánh giá từ khách hàng cho từng sản phẩm.
                        </p>
                    </div>
                </div>

                <!-- Search & Filter Controls -->
                <div class="row mb-4 align-items-center">
                    <!-- Left: Search Box -->
                    <div class="col-md-5 col-sm-12">
                        <form action="{{ route('admin.comments.table') }}" method="GET" id="search-form">
                            @if(request('rating'))
                                <input type="hidden" name="rating" value="{{ request('rating') }}">
                            @endif
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Tìm theo sản phẩm, nội dung, người dùng..." value="{{ request('search') }}" style="border-radius: 8px 0 0 8px; height: 42px; border: 1px solid #cbd5e1; border-right: 0; font-size: 13px;">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit" style="border-radius: 0 8px 8px 0; height: 42px; font-weight: 600; font-size: 13px; min-width: 80px;">
                                        Tìm kiếm
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Middle: Star Rating Filter -->
                    <div class="col-md-4 col-sm-12 mt-2 mt-md-0">
                        <form action="{{ route('admin.comments.table') }}" method="GET" id="filter-form">
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            <select name="rating" id="rating-filter" class="form-control" style="height: 42px; border: 1px solid #cbd5e1; border-radius: 8px; color: #475569; font-size: 13px;" onchange="this.form.submit()">
                                <option value="">-- Lọc theo số sao --</option>
                                <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ 5 Sao</option>
                                <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ 4 Sao</option>
                                <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>⭐⭐⭐ 3 Sao</option>
                                <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>⭐⭐ 2 Sao</option>
                                <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>⭐ 1 Sao</option>
                            </select>
                        </form>
                    </div>

                    <!-- Right: Clear Filters -->
                    @if(request('search') || request('rating'))
                        <div class="col-md-3 col-sm-12 mt-2 mt-md-0 text-md-right">
                            <a href="{{ route('admin.comments.table') }}" class="btn btn-outline-danger btn-sm font-weight-bold" style="text-decoration: none; border-radius: 8px; padding: 11px 18px; font-size: 12px; transition: all 0.2s;">
                                Xóa bộ lọc X
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Table Content -->
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="bg-light text-dark">
                            <tr>
                                <th style="width: 50px;" class="text-center font-weight-bold">#</th>
                                <th style="width: 180px;" class="font-weight-bold">Khách hàng</th>
                                <th style="width: 250px;" class="font-weight-bold">Sản phẩm</th>
                                <th style="width: 120px;" class="text-center font-weight-bold">Đánh giá</th>
                                <th class="font-weight-bold">Nội dung bình luận</th>
                                <th style="width: 140px;" class="text-center font-weight-bold">Ngày gửi</th>
                                <th style="width: 90px;" class="text-center font-weight-bold">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($comments) && !$comments->isEmpty())
                                @foreach($comments as $key => $comment)
                                    <tr>
                                        <td class="text-center align-middle font-weight-bold">
                                            {{ ($comments->currentPage() - 1) * $comments->perPage() + $key + 1 }}
                                        </td>
                                        <td class="align-middle">
                                            <div style="font-weight: 600; color: #1e293b;">{{ $comment->user_name ?? 'N/A' }}</div>
                                            <div class="text-muted small" style="font-size: 11px;">{{ $comment->user_email ?? 'N/A' }}</div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                @if(isset($comment->product_image) && $comment->product_image)
                                                    <img src="{{ (preg_match('/^https?:\/\//', $comment->product_image) || empty($comment->product_image)) ? ($comment->product_image ?: 'https://images.unsplash.com/photo-1587831990711-23ca6441447b?auto=format&fit=crop&w=80&h=80') : asset('images/products/' . $comment->product_image) }}" 
                                                         alt="Product" 
                                                         style="width: 40px; height: 40px; object-fit: cover; border-radius: 6px; margin-right: 10px; border: 1px solid #e2e8f0;">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; border-radius: 6px; margin-right: 10px; border: 1px solid #e2e8f0;">
                                                        <i class="typcn typcn-image text-muted" style="font-size: 18px;"></i>
                                                    </div>
                                                @endif
                                                <div style="max-width: 190px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                    <a href="{{ route('product.detail', $comment->product_id) }}" target="_blank" class="font-weight-bold text-primary" style="text-decoration: none;">
                                                        {{ $comment->product_name ?? 'N/A' }}
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="d-inline-block px-2 py-1 bg-warning-light rounded" style="background-color: #fef3c7; border: 1px solid #fde68a; border-radius: 6px;">
                                                <span class="text-warning" style="font-size: 13px; letter-spacing: 1px; font-weight: bold;">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $comment->rating)
                                                            ★
                                                        @else
                                                            <span class="text-muted" style="color: #cbd5e1 !important;">☆</span>
                                                        @endif
                                                    @endfor
                                                </span>
                                            </div>
                                        </td>
                                        <td class="align-middle" style="max-width: 320px;">
                                            <div class="comment-content-wrapper" style="font-size: 13px; color: #334155; line-height: 1.5; word-break: break-word;">
                                                {{ $comment->content }}
                                            </div>
                                        </td>
                                        <td class="text-center align-middle text-muted" style="font-size: 12px;">
                                            {{ date('d/m/Y H:i', strtotime($comment->created_at)) }}
                                        </td>
                                        <td class="text-center align-middle">
                                            <a href="{{ route('admin.comments.delete', $comment->id) }}" 
                                               class="btn btn-sm btn-outline-danger btn-icon-text" 
                                               style="border-radius: 8px; font-weight: 600; padding: 6px 12px;"
                                               onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này?')">
                                                <i class="typcn typcn-delete-outline btn-icon-append"></i> Xóa
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-5">
                                        <i class="typcn typcn-message" style="font-size: 48px; color: #cbd5e1; display: block; margin-bottom: 10px;"></i>
                                        Không tìm thấy bình luận nào phù hợp.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if(isset($comments) && $comments->total() > 0)
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <small class="text-muted" style="font-size: 12px;">
                            Hiển thị từ {{ $comments->firstItem() }} đến {{ $comments->lastItem() }} của tổng số {{ $comments->total() }} bình luận
                        </small>
                        @if($comments->hasPages())
                            <div>
                                {{ $comments->links('pagination::bootstrap-4') }}
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Premium Pagination Custom Styles -->
<style>
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
</style>

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
