<div class="modal fade" id="feedbackDetailModal-{{ $feedback->id }}" tabindex="-1" role="dialog"
    aria-labelledby="feedbackDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 50%;">
        <div class="modal-content">
            <div class="modal-header d-flex">
                <h5 class="modal-title" id="feedbackDetailModalLabel">Trả lời phản hồi khách hàng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($feedback->replies->isNotEmpty())
                    @foreach ($feedback->replies as $reply)
                        <div class="d-flex align-items-center mb-2">
                            <form action="{{ route('feedback.update', $reply->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="text" class="form-control mr-2" name="comment"
                                    value="{{ $reply->comment }}">
                                <!-- Nút Sửa -->
                                <button type="submit" class="btn btn-warning btn-edit">Sửa</button>
                            </form>

                            <!-- Nút Xóa -->
                            <form class="form-delete" action="{{ route('feedback.destroy', $reply->id) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger ml-2" data-id="{{ $reply->id }}"
                                    onclick="return confirm('Có chắc chắn muốn xóa không?')">
                                    Xóa
                                </button>
                            </form>
                        </div>
                    @endforeach
                @endif

                <form action="{{ route('feedback.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="parent_feedback_id" value="{{ $feedback->id }}">
                    <input type="hidden" name="user_id" value="{{ $feedback->user_id }}">
                    <input type="hidden" name="order_item_id" value="{{ $feedback->order_item_id }}">
                    <label for="" class="form-control-label">Phản Hồi Khách hàng</label>
                    <textarea class="form-control mt-3" name="comment" cols="30" rows="5"
                        placeholder="Viết bình luận của bạn tại đây..." required></textarea>
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-success">Phản hồi khách hàng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
