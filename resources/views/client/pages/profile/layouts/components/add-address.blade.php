<div class="reviews-modal modal theme-modal fade" id="add-address-modal" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Thêm mới địa chỉ giao hàng</h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <form id="addressForm" action="{{ route('profile.createUserAddress') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <input type="hidden" name="user_id">
                        
                        <!-- Họ và tên -->
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Họ và tên</label>
                                <input class="form-control" id="name" type="text" name="name" placeholder="Nhập họ và tên." value="{{ old('name') }}">
                                <span class="text-danger" id="nameError"></span>
                            </div>
                        </div>

                        <!-- Số điện thoại -->
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Số điện thoại</label>
                                <input class="form-control" id="phone" type="text" name="phone" placeholder="Nhập số điện thoại." value="{{ old('phone') }}">
                                <span class="text-danger" id="phoneError"></span>
                            </div>
                        </div>

                        <!-- Tỉnh/Thành phố -->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="provinceAdd">Chọn Tỉnh/Thành phố</label>
                                <select class="form-control" id="provinceAdd" name="province_id">
                                    <option value="">Chọn Tỉnh/Thành phố</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}" {{ old('province_id') == $province->id ? 'selected' : '' }}>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="provinceError"></span>
                            </div>

                            <!-- Huyện/Quận -->
                            <div class="form-group">
                                <label for="districtAdd">Chọn Huyện/Quận</label>
                                <select class="form-control" id="districtAdd" name="district_id">
                                    <option value="">Chọn Huyện/Quận</option>
                                </select>
                                <span class="text-danger" id="districtError"></span>
                            </div>

                            <!-- Xã/Phường -->
                            <div class="form-group">
                                <label for="wardAdd">Chọn Xã/Phường</label>
                                <select class="form-control" id="wardAdd" name="ward_id">
                                    <option value="">Chọn Xã/Phường</option>
                                </select>
                                <span class="text-danger" id="wardError"></span>
                            </div>

                            <!-- Nhập địa chỉ -->
                            <div class="form-group">
                                <label for="address-detail">Nhập địa chỉ chi tiết</label>
                                <input class="form-control" type="text" id="address_detail" name="address_detail" placeholder="Nhập địa chỉ chi tiết" value="{{ old('address_detail') }}">
                                <span class="text-danger" id="addressDetailError"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-center align-items-center mt-4">
                        <button class="btn btn-submit" type="submit">Thêm mới</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.querySelector("#addressForm");

        form.addEventListener("submit", function (e) {
            // Prevent form submission
            e.preventDefault();

            // Clear previous error messages
            document.querySelectorAll(".text-danger").forEach((el) => el.textContent = "");

            // Field validation
            let hasErrors = false;
            const fields = [
                { id: 'name', message: 'Vui lòng nhập họ và tên' },
                { id: 'phone', message: 'Vui lòng nhập số điện thoại' },
                { id: 'provinceAdd', message: 'Vui lòng chọn Tỉnh/Thành phố' },
                { id: 'districtAdd', message: 'Vui lòng chọn Huyện/Quận' },
                { id: 'wardAdd', message: 'Vui lòng chọn Xã/Phường' },
                { id: 'address_detail', message: 'Vui lòng nhập địa chỉ chi tiết' }
            ];

            fields.forEach((field) => {
                const input = document.getElementById(field.id);
                if (input && input.value.trim() === '') {
                    hasErrors = true;
                    document.getElementById(field.id + 'Error').textContent = field.message;
                }
            });

            // Submit form if no errors
            if (!hasErrors) {
                form.submit(); // Submit the form if all fields are valid
            }
        });
    });
</script>
