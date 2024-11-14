<li style="width:97%">
    <div class="comment-items d-flex flex-column">
        <div class="user-content">
            <div class="user-info">
                <div class="d-flex justify-content-between gap-3">
                    <h6>
                        <i class="iconsax" data-icon="user-1"></i>
                        {{ $feedback->user->full_name }}
                    </h6>
                    <span>
                        <i class="iconsax" data-icon="clock"></i>
                        {{ $feedback->created_at }}
                    </span>
                </div>
                <ul class="rating mb p-0">
                    @php
                        $rating = $feedback->rating ? $feedback->rating : 0;
                    @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        <li>
                            <i class="fa-solid fa-star" style="color: {{ $i <= $rating ? '#f39c12' : '#000' }};"></i>
                        </li>
                    @endfor
                    <span>{{ number_format($rating, 1) }} / 5 sao</span>
                </ul>
            </div>
            <div>
                <p>{{ $feedback->comment }}</p>
                <img width="70px" src="{{ '/storage/' . $feedback->file_path }}" alt="">
            </div>

            @if (Auth::id())
                @php
                    // Lấy role_id từ bảng user_roles
                    $roleIds = \DB::table('user_roles')->where('user_id', Auth::id())->pluck('role_id')->toArray();
                @endphp
                @if (in_array(2, $roleIds))
                    <a href="javascript:void(0);" class="reply-btn mt-2" data-feedback-id="{{ $feedback->id }}">
                        <span>
                            <i class="iconsax" data-icon="undo"></i>
                            Phản hồi
                        </span>
                    </a>
                @endif
            @endif

        </div>
        <div class="comment-text">
            <!-- Form trả lời đánh giá -->
            <form action="{{ route('feedback.reply') }}" method="POST" class="reply-form"
                id="reply-form-{{ $feedback->id }}" style="display: none;">
                @csrf
                <input type="hidden" name="parent_feedback_id" value="{{ $feedback->id }}">
                <input type="hidden" name="order_item_id" value="{{ $feedback->order_item_id }}">
                <input type="hidden" name="user_id" value="{{ $feedback->user_id }}">
                <textarea class="form-control" name="comment" rows="2" cols="100" required
                    placeholder="Nhập nội dung bình luận..."></textarea>
                <div class="text-end">
                    <button class="btn btn-primary btn-sm mt-1" type="submit">Gửi</button>
                    <button type="button" class="btn btn-secondary btn-sm back-btn mt-1"
                        data-feedback-id="{{ $feedback->id }}">Quay lại</button>
                </div>
            </form>
        </div>
    </div>

    @if ($feedback->replies->isNotEmpty())
        @foreach ($feedback->replies as $reply)
<li class="reply" style="width:90%">
    <div class="comment-items">
        <div class="user-content">
            <div class="user-info">
                <div class="d-flex justify-content-between gap-3">
                    <h6>
                        <i class="iconsax" data-icon="user-1"></i>
                        Admin
                    </h6>
                    <span>
                        <i class="iconsax" data-icon="clock"></i>
                        {{ $reply->created_at }}
                    </span>
                </div>
            </div>
            <p>{{ $reply->comment }}</p>
        </div>
    </div>
</li>
@endforeach
@endif
</li>

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Sự kiện cho nút "Phản hồi" để bật/tắt form trả lời
            document.querySelectorAll(".reply-btn").forEach(button => {
                button.addEventListener("click", function() {
                    const feedbackId = this.getAttribute("data-feedback-id");
                    const form = document.getElementById(`reply-form-${feedbackId}`);
                    if (form) {
                        // Kiểm tra trạng thái hiển thị của form và thay đổi nó
                        form.style.display = form.style.display === "block" ? "none" : "block";
                    }
                });
            });
        });

        // Sự kiện cho nút "Quay lại" để ẩn form
        document.querySelectorAll(".back-btn").forEach(button => {
            button.addEventListener("click", function() {
                const feedbackId = this.getAttribute("data-feedback-id");
                const form = document.getElementById(`reply-form-${feedbackId}`);
                if (form) form.style.display = "none";
            });
        });
    </script>
@endpush
