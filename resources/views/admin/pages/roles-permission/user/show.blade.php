<div>
    <div class="modal fade" id="userDetailModal-{{ $user->id }}" tabindex="-1" role="dialog"
        aria-labelledby="userDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">
                <div class="modal-header d-flex">
                    <h5 class="modal-title" id="userDetailModalLabel">Chi tiết người dùng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-5 overflow-hidden d-flex justify-content-center align-items-center">
                            <img src="{{ '/Storage/' . $user->image }}" class="img-thumbnail w-100" alt="Cinque Terre">
                        </div>
                        <div class="col-sm-7">

                            <div>
                                <strong>Họ và tên: </strong>
                                <label>{{ $user->full_name }}</label>
                            </div>
                            <div>
                                <strong>Email: </strong>
                                <label>{{ $user->email }}</label>
                            </div>
                            <div>
                                <strong>Số điện thoại: </strong>
                                <label>{{ $user->phone }}</label>
                            </div>
                            <div>
                                <strong>Vai trò: </strong>
                                <label>
                                    @foreach ($user->roles as $role)
                                        <span class="badge bg-info">{{ $role->name }}</span>
                                    @endforeach
                                </label>
                            </div>
                            <div>
                                <strong>Trạng thái: </strong>
                                <label>
                                    @if ($user->status == 'ACTIVE')
                                        <span class="badge bg-primary">Hoạt động</span>
                                    @else
                                        <span class="badge bg-secondary">Ngưng hoạt động!</span>
                                    @endif
                                </label>
                            </div>
                            <div>
                                <strong>Ngày tạo: </strong>
                                <label>{{ $user->created_at }}</label>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</div>
