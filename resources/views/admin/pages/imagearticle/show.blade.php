<div class="modal fade" id="imageDetailModal" tabindex="-1" role="dialog" aria-labelledby="imageDetailModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex">
                <h5 class="modal-title" id="imageDetailModalLabel">Chi tiết hình ảnh bài viết</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div>
                    <form action="{{ route('imagearticle.store') }}" method="post" enctype="multipart/form-data"
                        class="form-horizontal">
                        @csrf
                        <div class="row form-group align-items-center">
                            <div>
                                <label for="images" class="form-control-label">Thêm ảnh bài viết</label>
                            </div>
                            <div class="col-10">
                                <input type="file" id="images" name="images[]" class="form-control" multiple>
                            </div>
                            {{-- <div id="imageError"></div> --}}
                            <div class="col-2">
                                <button type="submit" class="btn btn-success btn-sm">Thêm mới</button>
                            </div>
                            <div>
                                <!-- Thông báo lỗi cho ảnh -->
                                <div id="imageErrorMessage" class="text-danger mt-2" style="display: none;">Không thành
                                    công</div>
                                <!-- Thông báo thành công -->
                                <div id="successMessage" class="text-success mt-2" style="display: none;">Hình ảnh đã
                                    được thêm mới thành công.</div>
                            </div>
                        </div>
                    </form>
                </div>

                <div>
                    <label for="images" class="form-control-label">Hình ảnh bài viết</label>
                </div>

                <div class="row mt-3">
                    <table style="table-layout: fixed; width: 100%;" class="table table-bordered">
                        <tbody id="imageTableBody">
                            @foreach ($listImageArticle as $index => $listimage)
                                @if ($index % 3 == 0)
                                    <tr>
                                @endif
                                <td class="text-center">
                                    <img src="{{ asset('storage/' . $listimage->image_url) }}" alt="image"
                                        width="100px" height="100px" style="cursor: pointer;"
                                        onclick="copyToClipboard('{{ asset('storage/' . $listimage->image_url) }}')">
                                </td>
                                @if ($index % 3 == 2 || $index == count($listImageArticle) - 1)
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageForm = document.querySelector('form[action="{{ route('imagearticle.store') }}"]');

        imageForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Ngăn chặn việc gửi form mặc định

            const formData = new FormData(imageForm);

            fetch("{{ route('imagearticle.store') }}", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        // 'X-CSRF-TOKEN': '{{ csrf_token() }}' // Thêm token CSRF để bảo mật,
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(error => Promise.reject(error));
                    }
                    return response.json();
                })
                .then(data => {
                    const successMessage = document.getElementById('successMessage');
                    const imageErrorMessage = document.getElementById('imageErrorMessage');

                    // Xóa thông báo trước đó
                    successMessage.style.display = 'none';
                    imageErrorMessage.style.display = 'none';

                    if (data.success) {
                        updateImageTable(data.images); // Cập nhật bảng ảnh
                        imageForm.reset(); // Đặt lại form
                        successMessage.style.display = 'block'; // Hiển thị thông báo thành công
                        successMessage.textContent = 'Hình ảnh đã được thêm mới thành.';

                        // Ẩn thông báo thành công sau 3 giây
                        setTimeout(() => {
                            successMessage.style.display = 'none';
                        }, 3000);
                    } else if (data.errors) {
                        // Kiểm tra và hiển thị lỗi xác thực
                        if (data.errors.images) {
                            imageErrorMessage.style.display = 'block';
                            imageErrorMessage.textContent = data.errors.images.join(
                                ', '); // Hiển thị lỗi xác thực cho trường images
                        }
                    }
                })
                .catch(error => {
                    console.error('Lỗi:', error.errors[0]);
                    alert(error.errors[0])
                });
        });

        function updateImageTable(images) {
            const tableBody = document.getElementById('imageTableBody');
            tableBody.innerHTML = ''; // Xóa các hàng hiện tại

            images.forEach((image, index) => {
                if (index % 3 === 0) { // Mỗi 3 ảnh, tạo một hàng mới
                    const row = document.createElement('tr');
                    tableBody.appendChild(row);
                }
                const cell = document.createElement('td');
                cell.className = 'text-center';
                cell.innerHTML = `
                    <img src="{{ asset('storage/') }}/${image.image_url}" alt="image" width="100px" height="100px" style="cursor: pointer;"
                         onclick="copyToClipboard('{{ asset('storage/') }}/${image.image_url}')">
                `;
                tableBody.lastChild.appendChild(cell); // Thêm ô vào hàng cuối cùng
            });
        }
    });

    // Sao chép liên kết ảnh
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert("Đã sao chép liên kết ảnh!");
        }).catch(err => {
            console.error("Lỗi khi sao chép liên kết: ", err);
        });
    }
</script>
