<div class="reviews-modal modal theme-modal fade" id="edit-box-{{ $addressUser->id }}" tabindex="-1" role="dialog"
    aria-modal="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Chỉnh sửa địa chỉ giao hàng</h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <form action="{{ route('profile.address.update', $addressUser->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <input type="hidden" name="user_id">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Họ và tên</label>
                                <input class="form-control" type="text" name="name" placeholder="Nhập họ và tên."
                                    value="{{ $addressUser->name }}">
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Số điện thoại</label>
                                <input class="form-control" type="number" name="phone" placeholder="Nhập số điện thoại."
                                    value="{{ $addressUser->phone }}">
                                @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <!-- Tỉnh/Thành phố -->
                            <div class="form-group">
                                <label for="province">Chọn Tỉnh/Thành phố</label>
                                <select class="form-control province" id="province" name="province_id" required>
                                    <option value="">Chọn Tỉnh/Thành phố</option>
                                    @foreach($provinces as $province)
                                    <option value="{{ $province->id }}"
                                        {{ $addressUser->province_id == $province->id ? 'selected' : '' }}>
                                        {{ $province->name }}</option>
                                    @endforeach
                                </select>
                                @error('province_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Huyện/Quận -->
                            <div class="form-group ">
                                <label for="district">Chọn Huyện/Quận</label>
                                <select class="form-control district" id="district" name="district_id" required>
                                    <option value="{{ $addressUser->district_id }}">{{ $addressUser->district->name }}
                                    </option>
                                </select>
                                @error('district_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Xã/Phường -->
                            <div class="form-group ">
                                <label for="ward">Chọn Xã/Phường</label>
                                <select class="form-control ward" id="ward" name="ward_id" required>
                                    <option value="{{ $addressUser->ward_id }}">{{ $addressUser->ward->name }}</option>
                                </select>
                                @error('ward_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Nhập địa chỉ -->
                            <div class="form-group">
                                <label for="address-detail">Nhập địa chỉ chi tiết</label>
                                <input class="form-control" type="text" id="address-detail" name="address_detail"
                                    placeholder="Nhập địa chỉ chi tiết" value="{{ $addressUser->address_detail}}">
                                @error('address_detail')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button class="btn btn-submit" type="submit" data-bs-dismiss="modal" aria-label="Close">
                            Cập nhật
                        </button>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>