<div class="reviews-modal modal theme-modal fade" id="edit-password" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Thay đổi mật khẩu</h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <form id="change-password-form" action="{{ route('auth.profile.change-password') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Mật khẩu hiện tại</label>
                                <input class="form-control" type="password" name="current_password"
                                       placeholder="Nhập mật khẩu hiện tại" required>
                                <small id="current_password-error" class="text-danger">
                                    @error('current_password')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Mật khẩu mới</label>
                                <input class="form-control" type="password" name="new_password"
                                       placeholder="Nhập mật khẩu mới" required>
                                <small id="new-password-error" class="text-danger">
                                    @error('new_password')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Xác nhận mật khẩu</label>
                                <input class="form-control" type="password" name="new_password_confirmation"
                                       placeholder="Nhập lại mật khẩu mới" required>
                                <small id="confirm-password-error" class="text-danger">
                                    @error('new_password_confirmation')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                        </div>
                        <div class="col-6 text-center">
                            <a href="{{ route('auth.foget-password-view') }}">Quên mật khẩu?</a>
                        </div>
                        <div class="col-6 text-center">
                            <button id="submit-button" class="btn btn-submit" type="button">Xác nhận</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Kiểm tra nếu có lỗi
@if ($errors->any())
    @foreach ($errors->all() as $error)
        Swal.fire({
            title: "Lỗi!",
            text: "{{ $error }}",
            icon: "error"
        });
    @endforeach
@endif

// Kiểm tra và ngừng nhập nếu có khoảng trắng trong mật khẩu cũ
document.querySelector('input[name="current_password"]').addEventListener('input', function () {
    const newPassword = this.value;
    const errorMessage = document.getElementById('current_password-error');

    // Kiểm tra nếu có khoảng trắng
    if (newPassword.includes(" ")) {
        this.value = newPassword.replace(" ", ""); // Loại bỏ khoảng trắng
        errorMessage.textContent = "Mật khẩu không được chứa khoảng trắng.";
    } else {
        errorMessage.textContent = ""; // Xóa thông báo lỗi nếu không có khoảng trắng
    }
});
// Kiểm tra và ngừng nhập nếu có khoảng trắng trong mật khẩu mới
document.querySelector('input[name="new_password"]').addEventListener('input', function () {
    const newPassword = this.value;
    const errorMessage = document.getElementById('new-password-error');

    // Kiểm tra nếu có khoảng trắng
    if (newPassword.includes(" ")) {
        this.value = newPassword.replace(" ", ""); // Loại bỏ khoảng trắng
        errorMessage.textContent = "Mật khẩu không được chứa khoảng trắng.";
    } else {
        errorMessage.textContent = ""; // Xóa thông báo lỗi nếu không có khoảng trắng
    }
});

// Kiểm tra và ngừng nhập nếu có khoảng trắng trong mật khẩu xác nhận
document.querySelector('input[name="new_password_confirmation"]').addEventListener('input', function () {
    const confirmPassword = this.value;
    const errorMessage = document.getElementById('confirm-password-error');

    // Kiểm tra nếu có khoảng trắng
    if (confirmPassword.includes(" ")) {
        this.value = confirmPassword.replace(" ", ""); // Loại bỏ khoảng trắng
        errorMessage.textContent = "Mật khẩu xác nhận không được chứa khoảng trắng.";
    } else {
        errorMessage.textContent = ""; // Xóa thông báo lỗi nếu không có khoảng trắng
    }
});

// Xử lý sự kiện khi nhấn nút xác nhận
document.getElementById('submit-button').addEventListener('click', function () {
    const newPassword = document.querySelector('input[name="new_password"]').value;
    const confirmPassword = document.querySelector('input[name="new_password_confirmation"]').value;

    // Kiểm tra nếu có khoảng trắng
    if (newPassword.includes(" ") || confirmPassword.includes(" ")) {
        Swal.fire("Lỗi!", "Mật khẩu không được chứa khoảng trắng.", "error");
        return;
    }

    // Kiểm tra nếu mật khẩu mới và xác nhận đúng
    if (newPassword !== confirmPassword) {
        Swal.fire("Lỗi!", "Mật khẩu mới và xác nhận không khớp!", "error");
        return;
    }

    // Hiển thị thông báo xác nhận
    Swal.fire({
        title: "Bạn có muốn lưu thay đổi không?",
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: "Có",
        denyButtonText: "Không"
    }).then((result) => {
        if (result.isConfirmed) {
            // Gửi form nếu tất cả kiểm tra đã đúng
            document.getElementById('change-password-form').submit();
        } else if (result.isDenied) {
            Swal.fire("Thay đổi không được lưu", "", "info");
        }
    });
});
</script>
