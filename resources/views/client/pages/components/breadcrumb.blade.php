<!--
$pageHeader = ten cua trang
$parent['route'] = duong dan dan den trang truoc do
$parent['name'] = ten cua duong dan
-->
<section class="pb-3 pt-0">
    <div class="heading-banner">
        <div class="custom-container container">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4> {{ $pageHeader }} </h4>
                </div>
                <div class="col-sm-6">
                    <ul class="breadcrumb float-end">
                        <li class="breadcrumb-item"> <a href="{{ $parent['route'] }}"> {{ $parent['name'] }} </a></li>
                        <li class="breadcrumb-item active"> <a href="#"> {{ $pageHeader }} </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
