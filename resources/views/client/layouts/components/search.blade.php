<style>
    .iconsax {
        border: 0px;
        background-color: transparent;
    }
</style>
<div class="offcanvas offcanvas-top search-details" id="offcanvasTop" tabindex="-1" aria-labelledby="offcanvasTopLabel">
    <div class="offcanvas-header"><button class="btn-close" type="button" data-bs-dismiss="offcanvas" aria-label="Close"><i
                class="fa-solid fa-xmark"></i></button></div>
    <div class="offcanvas-body theme-scrollbar">
        <div class="container">
            <h3>Bạn Đang Cố Tìm Kiếm Cái Gì?</h3>
            <form id="searchForm" method="post">
                <div class="search-box">
                    <input type="search" name="text" placeholder="Tôi đang tìm kiếm…" />
                    <button type="submit" data-icon="search-normal-2" class="iconsax"></button>
                </div>
            </form>
            <h4>Bạn Có Thể Thích </h4>
            <div id="searchResults" class="row gy-4 ratio_square-2 preemptive-search">
                @isset($products)
                    @foreach ($products as $product)
                        <div class="col-xl-2 col-sm-4 col-6">
                            <div class="product-box-6">
                                <div class="img-wrapper">
                                    <div class="product-image"><a href="{{ route('product', $product->id) }}"> <img
                                                class="bg-img" src="{{ asset('storage/' . $product->image) }}"
                                                alt="product" /></a>
                                    </div>
                                </div>
                                <div class="product-detail">
                                    <div><a href="{{ route('product', $product->id) }}">
                                            <h6>{{ $product->name }}</h6>
                                        </a>
                                        <p>
                                            @if ($product->productVariants->count() === 1)
                                                {{ number_format($product->productVariants->first()->price, 0, ',', '.') }}₫
                                            @else
                                                {{ number_format($product->productVariants->min('price'), 0, ',', '.') }}₫ -
                                                {{ number_format($product->productVariants->max('price'), 0, ',', '.') }}₫
                                            @endif
                                        </p>
                                        <ul class="rating">
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star-half-stroke"></i></li>
                                            <li><i class="fa-regular fa-star"></i></li>
                                            <li>4+</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endisset

            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchForm = document.getElementById('searchForm');

            searchForm.addEventListener('submit', function(e) {
                e.preventDefault(); // Ngăn chặn hành động gửi form mặc định

                const formData = new FormData(searchForm);
                fetch("{{ route('search') }}", {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(products => {
                        displayProducts(products)
                    })
                    //     .then(products => {
                    //         const searchResults = document.getElementById('searchResults');
                    //         searchResults.innerHTML = ''; // Xóa các kết quả hiện tại

                    //         products.forEach(product => {
                    //             console.log(product)
                    //             searchResults.innerHTML += `
                //     <div class="col-xl-2 col-sm-4 col-6">
                //         <div class="product-box-6">
                //             <div class="img-wrapper">
                //                 <div class="product-image" style="text-align: center;">
                //                     <a href="product.html">
                //                         <img width="200px" height="250px" class="bg-img" src="{{ asset('storage/') }}/${product.image}" alt="" />
                //                     </a>
                //                 </div>
                //             </div>
                //             <div class="product-detail">
                //                 <div><a href="product.html">
                //                         <h6>${product.name}</h6>
                //                     </a>
                //                     <p> 

                //                         ${new Intl.NumberFormat().format(product.product_variants[0].price)}

                //                     </p>
                //                     <ul class="rating">
                //                         <li><i class="fa-solid fa-star"></i></li>
                //                         <li><i class="fa-solid fa-star"></i></li>
                //                         <li><i class="fa-solid fa-star"></i></li>
                //                         <li><i class="fa-solid fa-star-half-stroke"></i></li>
                //                         <li><i class="fa-regular fa-star"></i></li>
                //                         <li>4+</li>
                //                     </ul>
                //                 </div>
                //             </div>
                //         </div>
                //     </div>
                // `;
                    //         });
                    //     })
                    .catch(error => {
                        console.error('Có lỗi xảy ra:', error);
                    });
            });

            function displayProducts(products) {
                const searchResults = document.getElementById('searchResults');
                searchResults.innerHTML = ''; // Xóa các kết quả hiện tại

                products.forEach(product => {
                    const colDiv = document.createElement('div');
                    colDiv.className = 'col-xl-2 col-sm-4 col-6';

                    const productBox = document.createElement('div');
                    productBox.className = 'product-box-6';

                    const imgWrapper = document.createElement('div');
                    imgWrapper.className = 'img-wrapper';

                    const productImage = document.createElement('div');
                    productImage.className = 'product-image';
                    productImage.style.textAlignCenter = 'center';
                    const anchor = document.createElement('a');
                    anchor.href = `/product/${product.id}`;

                    const img = document.createElement('img');
                    img.className = 'bg-img';
                    img.style.width = '200px'
                    img.style.height = '250px'
                    img.src = `/storage/${product.image}`;
                    img.alt = product.name;

                    anchor.appendChild(img);
                    productImage.appendChild(anchor);
                    imgWrapper.appendChild(productImage);
                    productBox.appendChild(imgWrapper);

                    const productDetail = document.createElement('div');
                    productDetail.className = 'product-detail';
                    const detailDiv = document.createElement('div');

                    const detailAnchor = document.createElement('a');
                    detailAnchor.href = `/product/${product.id}`;

                    const h6 = document.createElement('h6');
                    h6.textContent = product.name;

                    detailAnchor.appendChild(h6);
                    detailDiv.appendChild(detailAnchor);

                    const price = document.createElement('p');
                    const prices = product.product_variants;

                    if (prices.length === 1) {
                        price.textContent = `${formatCurrency(prices[0].price)}`;
                    } else {
                        const minPrice = Math.min(...prices.map(v => v.price));
                        const maxPrice = Math.max(...prices.map(v => v.price));
                        price.textContent = `${formatCurrency(minPrice)} - ${formatCurrency(maxPrice)}`;
                    }

                    detailDiv.appendChild(price);

                    const ratingList = document.createElement('ul');
                    ratingList.className = 'rating';
                    for (let i = 0; i < 4; i++) {
                        const li = document.createElement('li');
                        const starIcon = document.createElement('i');
                        starIcon.className = 'fa-solid fa-star';
                        li.appendChild(starIcon);
                        ratingList.appendChild(li);
                    }

                    const halfStarLi = document.createElement('li');
                    const halfStarIcon = document.createElement('i');
                    halfStarIcon.className = 'fa-solid fa-star-half-stroke';
                    halfStarLi.appendChild(halfStarIcon);
                    ratingList.appendChild(halfStarLi);

                    const emptyStarLi = document.createElement('li');
                    const emptyStarIcon = document.createElement('i');
                    emptyStarIcon.className = 'fa-regular fa-star';
                    emptyStarLi.appendChild(emptyStarIcon);
                    ratingList.appendChild(emptyStarLi);

                    const ratingCountLi = document.createElement('li');
                    ratingCountLi.textContent = '4+'; // Số lượng đánh giá
                    ratingList.appendChild(ratingCountLi);

                    detailDiv.appendChild(ratingList);
                    productDetail.appendChild(detailDiv);
                    productBox.appendChild(productDetail);
                    colDiv.appendChild(productBox);

                    searchResults.appendChild(colDiv); // Thêm phần tử sản phẩm vào kết quả
                });
            }

            // Hàm định dạng giá
            function formatCurrency(amount) {
                return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + "₫";
            }
        });
    </script>
@endpush
