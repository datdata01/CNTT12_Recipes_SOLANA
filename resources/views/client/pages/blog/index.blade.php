@extends('client.layouts.master')
@section('title', $article->title)

@push('css')
    <style>
        .post-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .top-post-title h6 {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 180px;
            margin: 0;
            font-size: 1em;
            font-weight: bold;
        }

        .post-date p {
            margin: 5px 0 0;
            color: #666;
            font-size: 0.9em;
        }

        .userImg {
            width: 40px;
            height: 40px;
            overflow: hidden;
            margin-right: 10px;
        }

        .userImg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-name h6 {
            margin-bottom: 0px;
            font-weight: 500px;
            width: 600px;
        }

        .comment-text {
            margin-left: 15px;
            margin-top: 3px;
            font-size: 17px;
        }

        .reply-btn {
            margin-left: 10px;
        }

        .reply-btn:hover {
            color: rgba(var(--theme-default), 1);
        }

        .reply-item {
            margin-left: 25px
        }

        .replies-container {

            list-style-type: none;
            /* Bỏ đánh dấu cho danh sách */
            padding: 0;
            /* Bỏ padding mặc định */
            margin: 0;
            /* Bỏ margin mặc định */
        }

        .replies-container li {

            padding-left: 0;
            /* Đặt padding bên trái cho các bình luận con bằng 0 */
            border: none;
            /* Không có đường viền cho các bình luận con */
        }

        .comment-items {
            padding-left: 0px;
            /* Xóa khoảng cách thụt vào của danh sách */
            list-style: none;
            /* Xóa dấu đầu dòng */
        }

        /* Đặt lại chiều rộng cho bình luận con */
        .comment-text {
            margin-left: 20px;
            /* Đảm bảo không có margin bên trái */
        }

        .comment-author {
            margin-bottom: 5px;
            /* Khoảng cách giữa thông tin tác giả và nội dung bình luận */
        }
    </style>
@endpush
@section('content')
    @include('client.pages.components.breadcrumb', [
        'pageHeader' => 'Bài viết',
        'parent' => [
            'route' => '',
            'name' => 'Trang chủ',
        ],
    ])


    <section class="section-b-space pt-0">
        <div class="custom-container blog-page container">
            <div class="row gy-4">
                <div class="col-xl-9 col-lg-8 col-12 ratio50_2">
                    <div class="blog-main-box blog-details">
                        <div class="blog">
                            <h4>{{ $article->title }}</h4>
                            <hr>
                            <p>{!! $article->content !!}</p>
                            <div class="comments-box">
                                <h5>Bình luận</h5>
                                <ul class="theme-scrollbar">
                                    @foreach ($comments as $comment)
                                        @include('client.pages.blog.comment_render', [
                                            'comment' => $comment,
                                        ])
                                    @endforeach
                                </ul>
                            </div>

                            @if (auth()->check())
                                <form action="{{ route('blog.comment.store', $article->id) }}" method="POST">
                                    @csrf
                                    <div class="row gy-3 message-box">
                                        <div class="col-12">
                                            <label class="form-label">Nội dung bình luận</label>
                                            <textarea class="form-control" name="comment" rows="" placeholder="Nhập nội dung của bạn" required></textarea>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn_black sm rounded"
                                                style="padding: 5px 30px;font-size: 13px;font-weight: 500;"
                                                type="submit">Đăng bình luận</button>
                                        </div>
                                    </div>
                                </form>
                            @else
                                <p>Để bình luận, bạn cần <a href="{{ route('auth.login-view') }}">đăng nhập</a>.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-4 order-lg-first col-12">
                    <div class="blog-sidebar sticky">
                        <div class="col-12">
                            <div class="sidebar-box">
                                <div class="sidebar-title">
                                    <div class="loader-line"></div>
                                    <h5> Thể loại</h5>
                                </div>
                                <ul class="categories">
                                    @foreach ($categories as $category)
                                        <li>
                                            <a href="{{ route('category-articles', $category->id) }}">
                                                <p>{{ $category->name }}&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <span style="color: red">{{ $category->articles_count }}</span>
                                                </p>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="sidebar-box mt-4">
                            <h5>Bài viết mới</h5>
                            <ul class="top-post">
                                @foreach ($latestPosts as $post)
                                    <li class="post-item">
                                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
                                        <div class="post-content d-flex flex-column">
                                            <a href="{{ route('blog.show', $post->id) }}">
                                                <div class="top-post-title">
                                                    <h6>{{ $post->title }}</h6>
                                                </div>
                                            </a>
                                            <div class="post-date">
                                                <p>{{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }}</p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chọn tất cả các nút "Trả lời"
        const replyButtons = document.querySelectorAll('.reply-btn');
        replyButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                // Kiểm tra trạng thái đăng nhập
                const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
                if (!isLoggedIn) {
                    Swal.fire({
                        title: "Bạn cần đăng nhập để thực hiện thao tác này!",
                        icon: "warning",
                        confirmButtonText: "Đăng nhập",
                        showCancelButton: true,
                        cancelButtonText: "Hủy"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('auth.login-view') }}";
                        }
                    });
                    return;
                }

                // Lấy ID của bình luận
                const commentId = this.getAttribute('data-comment-id');
                if (!commentId) return;

                // Tìm form trả lời tương ứng
                const replyForm = document.getElementById('reply-form-' + commentId);
                if (!replyForm) return;

                // Ẩn tất cả các form trả lời khác
                document.querySelectorAll('.reply-form').forEach(form => {
                    if (form !== replyForm) {
                        form.style.display = 'none';
                    }
                });

                // Toggle hiển thị form trả lời
                replyForm.style.display = replyForm.style.display === 'none' || replyForm.style
                    .display === '' ? 'block' : 'none';
            });
        });

        // Xử lý nút "Quay lại" để ẩn form trả lời
        const backButtons = document.querySelectorAll('.back-btn');
        backButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                // Lấy ID của bình luận
                const commentId = this.getAttribute('data-comment-id');
                if (!commentId) return;

                // Tìm form trả lời tương ứng và ẩn nó
                const replyForm = document.getElementById('reply-form-' + commentId);
                if (replyForm) replyForm.style.display = 'none';
            });
        });

        // Chọn tất cả các nút "Xem câu trả lời"
        const toggleReplyButtons = document.querySelectorAll('.toggle-replies-btn');
        toggleReplyButtons.forEach(button => {
            button.addEventListener('click', function() {
                const commentId = this.getAttribute('data-comment-id');
                if (!commentId) return;

                // Tìm danh sách câu trả lời tương ứng
                const repliesList = document.getElementById('replies-' + commentId);
                if (!repliesList) return;

                // Toggle hiển thị danh sách câu trả lời
                repliesList.style.display = repliesList.style.display === 'none' || repliesList
                    .style.display === '' ? 'block' : 'none';

                // Thay đổi biểu tượng mũi tên
                const arrow = this.querySelector('span');
                if (arrow) {
                    arrow.innerHTML = repliesList.style.display === 'block' ? '&#9650;' :
                        '&#9660;';
                }
            });
        });
    });
</script>
