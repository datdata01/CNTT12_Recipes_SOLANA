<div class="left-dashboard-show"><button class="btn btn_black sm bg-primary rounded">Show
        Menu</button></div>
<div class="dashboard-left-sidebar sticky">
    <div class="profile-box">
        <div class="profile-bg-img"></div>
        <div class="dashboard-left-sidebar-close"><i class="fa-solid fa-xmark"></i></div>
        <div class="profile-contain">
            @if (Auth::user()->image)
                <div class="profile-image">
                    <img class="img-fluid" src="{{ '/storage/' . Auth::user()->image }}" alt="">
                </div>
            @else
                <div class="profile-image">
                    <img class="img-fluid" src="/template/client/assets/images/user/12.jpg" alt="">
                </div>
            @endif

            <div class="profile-name">
                <h4>{{ Auth::user()->full_name }}</h4>
                <h6>{{ Auth::user()->email }}</h6>
                <span data-bs-toggle="modal" data-bs-target="#edit-profile" title="Quick View" tabindex="0">
                    Chỉnh sửa hồ sơ
                </span>
            </div>
        </div>
    </div>
    <ul class="nav flex-column nav-pills dashboard-tab" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <li>
            <a href="{{ route('profile.infomation') }}" class="nav-link">
                <i class="iconsax" data-icon="home-1"></i>
                Thông tin cá nhân
            </a>
        </li>

        <li>
            <a href="{{ route('profile.order-history') }}" class="nav-link">
                <i class="iconsax" data-icon="receipt-square"></i>
                Lịch sử đơn hàng</a>
        </li>

        <li>
            <a href="{{ route('profile.address') }}" class="nav-link">
                <i class="iconsax" data-icon="cue-cards"></i>
                Địa chỉ
            </a>
        </li>

        <li>
            <a href="{{ route('profile.myVoucher.index') }}" class="nav-link"> <i class="iconsax" data-icon="bank-card"></i>Ưu đãi</a>
        </li>

        {{-- <li>
            <button class="nav-link" id="wishlist-tab" data-bs-toggle="pill" data-bs-target="#wishlist" role="tab"
                aria-controls="wishlist" aria-selected="false"> <i class="iconsax" data-icon="heart"></i>Wishlist
            </button>
        </li> --}}
        {{-- <li>
            <button class="nav-link" id="notifications-tab" data-bs-toggle="pill" data-bs-target="#notifications"
                role="tab" aria-controls="notifications" aria-selected="false"><i class="iconsax"
                    data-icon="lamp-2"></i>Notifications
            </button>
        </li> --}}
        {{-- <li>
            <button class="nav-link" id="saved-card-tab" data-bs-toggle="pill" data-bs-target="#saved-card" role="tab"
                aria-controls="saved-card" aria-selected="false"> <i class="iconsax" data-icon="bank-card"></i>Saved
                Card</button>
        </li> --}}

        {{-- <li>
            <button class="nav-link" id="privacy-tab" data-bs-toggle="pill" data-bs-target="#privacy" role="tab"
                aria-controls="privacy" aria-selected="false">
                <i class="iconsax" data-icon="security-user"></i>Privacy</button>
        </li> --}}
    </ul>
    <div class="logout-button" style="display: flex; justify-content: center; align-items: center;">
        <form action="{{ route('auth.logout') }}" method="POST">
            @csrf
            <button type="submit" style="width: 250px; border-radius: 20px;" class="btn btn_black sm logout-btn"
                title="Đăng xuất">
                <i class="iconsax me-1" data-icon="logout-1"></i> Đăng xuất
            </button>
        </form>
    </div>

</div>

@include('client.pages.profile.layouts.components.edit-profile')
