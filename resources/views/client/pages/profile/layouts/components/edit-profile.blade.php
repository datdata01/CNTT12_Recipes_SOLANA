<div class="reviews-modal modal theme-modal" id="edit-profile" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Chỉnh sửa hồ sơ</h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <form action="{{ route('profile.edit-profile') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Ảnh đại diện</label>
                                @if (Auth::user()->image)
                                    <div class="profile-image">
                                        <img class="img-fluid rounded-circle"
                                            src="{{ '/storage/' . Auth::user()->image }}" width="100px">
                                    </div>
                                @else
                                    <div class="profile-image">
                                        <img class="img-fluid rounded-circle"
                                            src="/template/client/assets/images/user/12.jpg" width="100px">
                                    </div>
                                @endif
                                <input class="form-control" type="file" name="image">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Họ và tên</label>
                                <input class="form-control" type="text" name="full_name"
                                    placeholder="Nhập họ và tên của bạn."
                                    value="{{ old('full_name', Auth::user()->full_name) }}" />
                                @error('full_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Số điện thoại</label>
                                <input class="form-control" type="tel" name="phone"
                                    placeholder="Nhập số điện thoại của bạn"
                                    value="{{ old('phone', Auth::user()->phone) }}" />
                                @error('phone')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <button class="btn btn-submit" type="submit" data-bs-dismiss="modal" aria-label="Close">
                                Lưu thay đổi
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
