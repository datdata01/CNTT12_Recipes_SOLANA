<div class="modal fade" id="EditReview-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Chỉnh sửa đánh giá</h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <form method="POST" action="{{ route('profile.feedback.update', $item->feedback->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <!-- Thông tin sản phẩm và feedback -->
                        <div class="col-12">
                            <div class="reviews-product d-flex align-items-center">
                                <img src="{{ '/storage/' . $item->productVariant->product->image }}"
                                    style="object-fit: cover;" width="100px"
                                    alt="{{ $item->productVariant->product->image }}">
                                <div style="padding:0 20px;">
                                    <h5>{{ $item->product_name }}</h5>
                                    <p class="mb-1">{{ $item->total_price }} VND</p>
                                    <!-- Hiển thị số sao hiện tại -->
@php
    $currentRating = old('rating', $item->feedback->rating); // Lấy số sao từ cơ sở dữ liệu
    $stars = range(1, 5); // Tạo mảng chứa các số sao
@endphp

<ul class="rating p-0 mb-0">
    @foreach ($stars as $i)
        <li>
            <input type="radio" id="star{{ $i }}-{{ $item->feedback->id }}" name="rating" value="{{ $i }}"
                {{ $currentRating == $i ? 'checked' : '' }} />
            <label for="star{{ $i }}-{{ $item->feedback->id }}">
                <i class="fa-solid fa-star" style="color: {{ $currentRating >= $i ? '#f39c12' : '#ddd' }}"></i> <!-- Đặt màu sao -->
            </label>
        </li>
    @endforeach
</ul>

                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="product_id" value="{{ $item->productVariant->product->id }}">
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                        <input type="hidden" name="parent_feedback_id"
                            value="{{ $item->feedback->parent_feedback_id }}">
                        <input type="hidden" name="order_item_id" value="{{ $item->id }}">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Ảnh hiện tại:</label>
                                @if($item->feedback->file_path)
                                    <div>
                                        <img src="{{ '/storage/' . $item->feedback->file_path }}" alt="Ảnh hiện tại"
                                            style="max-width: 100px; max-height: 100px; object-fit: cover;">
                                    </div>
                                @endif
                                <label class="form-label">Ảnh chỉnh sửa</label>
                                <input class="form-control" type="file" name="file_path" />
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Bình luận</label>
                                <textarea class="form-control" name="comment" cols="30" rows="5"
                                    placeholder="Viết bình luận của bạn tại đây...">{{ old('comment', $item->feedback->comment) }}</textarea>
                            </div>
                        </div>

                        <div class="col-12">
                            <button class="btn btn-submit" type="submit">
                                Lưu thay đổi
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
document.querySelectorAll('input[name="rating"]').forEach((input) => {
        const stars = input.closest('.rating').querySelectorAll('label i');

        // Thay đổi màu sao khi hover
        stars.forEach((star, index) => {
            star.addEventListener('mouseenter', () => {
                stars.forEach((s, i) => {
                    s.style.color = i <= index ? '#f39c12' : '#ddd'; // Đổi màu sao dựa trên chỉ số
                });
            });

            star.addEventListener('mouseleave', () => {
                const rating = parseInt(document.querySelector('input[name="rating"]:checked')?.value, 10) || 0; // Lấy giá trị rating đã chọn
                stars.forEach((s, i) => {
                    s.style.color = i < rating ? '#f39c12' : '#ddd'; // Đặt lại màu theo giá trị đã chọn
                });
            });
        });

        input.addEventListener('change', (event) => {
            const rating = parseInt(event.target.value, 10);
            stars.forEach((star, index) => {
                star.style.color = index < rating ? '#f39c12' : '#ddd'; // Màu vàng cho sao đã chọn, xám cho sao chưa chọn
            });
        });
    });

// Hàm cập nhật màu sắc cho các ngôi sao
function updateStars(rating, stars) {
    stars.forEach((star, index) => {
        star.style.color = index < rating ? '#f39c12' : '#ddd'; // Màu vàng cho sao đã chọn, xám cho sao chưa chọn
    });
}

$(document).ready(function () {
    $('#EditReview-modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Nút kích hoạt modal
        var feedbackId = button.data('feedback'); // Lấy ID feedback

        // Đặt màu cho các sao theo rating hiện tại
        const currentRating = {{ old('rating', $item->feedback->rating) }};
        const stars = $(this).find('.rating label i');

        // Đặt màu sắc cho các sao khi mở modal
        stars.each((index, star) => {
            star.style.color = index < currentRating ? '#f39c12' : '#ddd'; // Màu vàng cho sao đã chọn, xám cho sao chưa chọn
        });
    });
});

@if ($errors->any())
    @foreach ($errors->all() as $error)
        Swal.fire({
            title: "Lỗi!",
            text: "{{ $error }}",
            icon: "error"
        });
    @endforeach
@endif

</script>
@endpush
