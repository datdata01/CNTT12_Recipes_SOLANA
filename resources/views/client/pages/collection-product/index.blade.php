@extends('client.layouts.master')
@section('title')
    Danh sách sản phẩm
@endsection
@section('content')
    @include('client.pages.components.breadcrumb', [
        'pageHeader' => 'Danh sách sản phẩm',
        'parent' => [
            'route' => '',
            'name' => 'Trang chủ',
        ],
    ])
    <section class="section-b-space pt-0">
        <div class="custom-container container">
            <div class="row">
                <div class="col-3">
                    <div class="custom-accordion theme-scrollbar left-box">
                        <div class="left-accordion">
                            <h5>Back </h5><i class="back-button fa-solid fa-xmark"></i>
                        </div>
                        <div class="accordion" id="accordionPanelsStayOpenExample">
                            <div class="accordion-item">
                                <!-- Danh mục -->
                                <h2 class="accordion-header">
                                    <button class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#panelsStayOpen-collapseTwo">
                                        <span>Danh mục</span>
                                    </button>
                                </h2>
                                <div class="accordion-collapse show collapse" id="panelsStayOpen-collapseTwo">
                                    <div class="accordion-body">
                                        <ul class="catagories-side theme-scrollbar">
                                            @foreach ($categories as $category)
                                                <li>
                                                    <input class="custom-checkbox" id="category{{ $category->id }}"
                                                        type="checkbox" name="categories[]" value="{{ $category->id }}">
                                                    <label for="category{{ $category->id }}">{{ $category->name }}
                                                        ({{ $category->products_count }})</label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>


                                <!-- Thuộc tính -->
                                <h2 class="accordion-header">
                                    <button class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#panelsStayOpen-collapseOne">
                                        <span>Thuộc tính</span>
                                    </button>
                                </h2>
                                <div class="accordion-collapse show collapse" id="panelsStayOpen-collapseOne">
                                    <div class="accordion-body">
                                        @foreach ($attributes as $attribute)
                                            <!-- Hiển thị tên thuộc tính -->
                                            <h6 style="margin-left: 10px">{{ ucfirst($attribute->name) }}</h6>
                                            <div class="color-box">
                                                <!-- Lặp qua các giá trị của thuộc tính -->
                                                @foreach ($attribute->attributeValues as $attributeValue)
                                                    <div style="padding: 0 10px" class="color-item">
                                                        <input class="custom-checkbox"
                                                            id="attribute{{ $attributeValue->id }}" type="checkbox"
                                                            name="attributes[]" value="{{ $attributeValue->id }}">
                                                        <label
                                                            for="attribute{{ $attributeValue->id }}">{{ $attributeValue->name }}</label>
                                                    </div>
                                                @endforeach
                                            </div><br>
                                        @endforeach
                                    </div>
                                </div>


                                <!-- Lọc giá -->
                                <h2 class="accordion-header">
                                    <button class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#panelsStayOpen-collapseFour">
                                        <span>Giá</span>
                                    </button>
                                </h2>
                                <div class="accordion-collapse show collapse" id="panelsStayOpen-collapseFour">
                                    <div class="accordion-body">
                                        <div class="range-slider">
                                            <input class="range-slider-input" type="range" min="{{ $minPrice }}"
                                                max="{{ $maxPrice }}" step="1" value="{{ $minPrice }}"
                                                id="minRange" oninput="updateMinPriceDisplay()">
                                            <input class="range-slider-input" type="range" min="{{ $minPrice }}"
                                                max="{{ $maxPrice }}" step="1" value="{{ $maxPrice }}"
                                                id="maxRange" oninput="updateMaxPriceDisplay()">
                                        </div>
                                        <div class="range-slider-display">
                                            <span>Giá: <span
                                                    id="minPriceDisplay">{{ number_format($minPrice, 0, ',', '.') }}</span>
                                                VND</span> -
                                            <span><span
                                                    id="maxPriceDisplay">{{ number_format($maxPrice, 0, ',', '.') }}</span>
                                                VND</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tình trạng -->
                                <h2 class="accordion-header">
                                    <button class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#panelsStayOpen-collapseSix">
                                        <span>Tình trạng</span>
                                    </button>
                                </h2>
                                <div class="accordion-collapse show collapse" id="panelsStayOpen-collapseSix">
                                    <div class="accordion-body">
                                        <ul class="categories-side">
                                            <li>
                                                <input class="custom-radio" id="inStock" type="radio"
                                                    name="availability" value="in_stock" checked>
                                                <label for="inStock">Còn hàng</label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>

                            <div class="accordion-footer">
                                <button style="background-color: #c28f51; border:none" type="button"
                                    class="btn btn-secondary" onclick="handleSubmit()">Lọc</button>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header tags-header"><button class="accordion-button"><span>Vận chuyển &
                                            Giao hàng</span><span></span></button></h2>
                                <div class="accordion-collapse show collapse" id="panelsStayOpen-collapseSeven">
                                    <div class="accordion-body">
                                        <ul class="widget-card">
                                            <li><i class="iconsax" data-icon="truck-fast"></i>
                                                <div>
                                                    <h6>Vận chuyển miễn phí</h6>
                                                    <p>Miễn phí vận chuyển cho tất cả các đơn hàng tại Việt nam</p>
                                                </div>
                                            </li>
                                            <li><i class="iconsax" data-icon="headphones"></i>
                                                <div>
                                                    <h6>Hỗ trợ 24/7</h6>
                                                    <p>Miễn phí vận chuyển cho tất cả các đơn hàng tại Việt nam</p>
                                                </div>
                                            </li>
                                            <li><i class="iconsax" data-icon="exchange"></i>
                                                <div>
                                                    <h6>Đổi hàng trong 30 ngày</h6>
                                                    <p>Miễn phí vận chuyển cho tất cả các đơn hàng tại Việt nam</p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                    <div class="sticky">
                        <div style="padding-left: 800px" class="top-filter-menu">
                            <div> <a class="filter-button btn">
                                    <h6> <i class="iconsax" data-icon="filter"></i>Filter Menu </h6>
                                </a>
                                <div class="category-dropdown">
                                    <label for="cars">Sắp xếp :</label>
                                    <select class="form-select" id="cars" name="sort">
                                        <option value="name_asc">Sắp xếp A-Z</option>
                                        <option value="name_desc">Sắp xếp Z-A</option>
                                        <option value="created_at_desc">Mới nhất</option>
                                        <option value="created_at_asc">Cũ nhất</option>
                                        <option value="best_selling">Bán chạy nhất</option>
                                        <option value="least_selling">Bán ít nhất</option>
                                        <option value="price_asc">Giá từ thấp đến cao</option>
                                        <option value="price_desc">Giá từ cao đến thấp</option>
                                        <option value="rating_desc">Đánh giá từ cao đến thấp</option>
                                        <option value="rating_asc">Đánh giá từ thấp đến cao</option>

                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="notification" style="display: none; color: green; margin-bottom: 15px;"></div>
                        <div id="productList">
                            @include('client.pages.collection-product.list')
                        </div>
                        <div class="pagination-wrap">
                            <ul class="pagination">
                                @if ($products->onFirstPage())
                                    <li><span class="prev disabled"><i data-icon="chevron-left"></i></span></li>
                                @else
                                    <li><a class="prev" href="{{ $products->previousPageUrl() }}"><i class="iconsax"
                                                data-icon="chevron-left"></i></a></li>
                                @endif

                                @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                    <li class="{{ $products->currentPage() == $page ? 'active' : '' }}">
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                @if ($products->hasMorePages())
                                    <li><a class="next" href="{{ $products->nextPageUrl() }}"><i class="iconsax"
                                                data-icon="chevron-right"></i></a></li>
                                @else
                                    <li><span class="next disabled"><i data-icon="chevron-right"></i></span></li>
                                @endif
                            </ul>
                        </div>


                        <!--Pani nay thi su dung theo cai tra ra du lieu nhe-->

                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        const productRoute = '{{ url('product') }}'; // Định nghĩa route cơ bản cho sản phẩm

        function handleSubmit() {
            const selectedCategories = Array.from(document.querySelectorAll('input[name="categories[]"]:checked'))
                .map(el => el.value);
            const selectedAttributes = Array.from(document.querySelectorAll('input[name="attributes[]"]:checked'))
                .map(el => el.value);
            const minPrice = document.getElementById('minRange').value;
            const maxPrice = document.getElementById('maxRange').value;
            const sort = document.getElementById('cars').value; // Lấy giá trị từ dropdown sắp xếp

            fetch('{{ route('product.filter') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        categories: selectedCategories,
                        attributes: selectedAttributes,
                        minPrice: minPrice,
                        maxPrice: maxPrice,
                        sort: sort // Gửi thông tin sắp xếp
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(error => {
                            throw new Error(error.message || 'Lỗi không xác định')
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    const productListContainer = document.querySelector('#productList');
                    productListContainer.innerHTML = data.html; // Chèn HTML trả về từ server vào #productList

                    // Hiển thị thông báo dựa trên số lượng sản phẩm
                    const notificationContainer = document.querySelector(
                    '#notification'); // Đảm bảo có thẻ #notification trong HTML
                    if (data.count > 0) {
                        notificationContainer.innerText = `Tìm thấy ${data.count} sản phẩm phù hợp với tiêu chí lọc.`;
                        notificationContainer.style.display = 'block'; // Hiện thông báo
                    } else {
                        notificationContainer.innerText = data.message;
                        notificationContainer.style.display = 'block'; // Hiện thông báo
                    }
                })
                .catch(error => {
                    const productListContainer = document.querySelector('#productList');
                    productListContainer.innerHTML =
                        `<p>Đã xảy ra lỗi trong quá trình tải sản phẩm: ${error.message}</p>`;
                });

        }

        document.getElementById('minRange').addEventListener('input', function() {
            document.getElementById('minPriceDisplay').innerText = this.value;
        });

        document.getElementById('maxRange').addEventListener('input', function() {
            document.getElementById('maxPriceDisplay').innerText = this.value;
        });

        // Thêm sự kiện cho dropdown sắp xếp
        document.getElementById('cars').addEventListener('change', handleSubmit);
    </script>
@endsection
