<li class="col-12">
    <div class="comment-items d-flex flex-column" style="gap: 0px;">
        <div class="comment-author d-flex">
            <div class="userImg" style="border-radius: 50%;">
                <img src="/template/client/assets/images/user/3.jpg" alt="">
            </div>
            <div class="d-flex flex-column">
                <div class="user-name">
                    <h6>
                        {{-- Kiểm tra xem đây có phải bình luận con không --}}
                        @if ($comment->parent_comment_id)
                            {{ $comment->user->full_name }} trả lời: <strong style="color: rgb(110, 110, 238)">
                                {{ $comment->parent->user->full_name }}
                            </strong>
                        @else
                            {{ $comment->user->full_name }}
                        @endif
                    </h6>
                </div>
                <div class="comment-date">
                    {{ $comment->comment }}
                    <a href="javascript:void(0);" class="reply-btn" data-comment-id="{{ $comment->id }}">Trả lời</a>
                    @php
                        // Lấy role_id từ bảng user_roles
                        $roleIds = \DB::table('user_roles')->where('user_id', Auth::id())->pluck('role_id')->toArray();
                    @endphp
                    @if (in_array(2, $roleIds))
                        <form action="{{ route('comments.delete', $comment->id) }}" method="POST"
                            style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn link-danger ms-1"
                                onclick="return confirm('Có chắc chắn muốn xóa không?')">
                                Xóa
                            </button>
                        </form>
                    @endif

                </div>
                <span>{{ $comment->created_at->format('d/m/Y') }}</span>
            </div>
        </div>

        <div class="comment-text">
            <!-- Kiểm tra người dùng đã đăng nhập -->
            @auth
            <!-- Form trả lời bình luận -->
            <form action="{{ route('blog.comment.store', $article->id) }}" method="POST" class="reply-form"
                id="reply-form-{{ $comment->id }}" style="display: none;">
                @csrf
                <input type="hidden" name="parent_comment_id" value="{{ $comment->id }}">
                <textarea class="form-control" name="comment" rows="2" cols="50" required
                    placeholder="Nhập nội dung bình luận..."></textarea>
                <div class="text-end">
                    <button class="btn btn-primary btn-sm mt-1" type="submit">Gửi</button>
                    <button type="button" class="btn btn-secondary btn-sm back-btn mt-1"
                        data-comment-id="{{ $comment->id }}">Quay lại</button>
                </div>
            </form>
            @endauth
            <!-- Hiển thị các câu trả lời -->
            @if ($comment->replies->isNotEmpty())

            <a href="javascript:void(0);" class="toggle-replies-btn" data-comment-id="{{ $comment->id }}">
                Xem câu trả lời <span>&#9660;</span>
            </a>
            <ul class="replies-list" id="replies-{{ $comment->id }}" style="display: none;">
                @foreach ($comment->replies as $reply)
                <li>
                    @include('client.pages.blog.comment_render', ['comment' => $reply])
                </li>
                @endforeach
            </ul>

            @endif
        </div>
        
    </div>
</li>
