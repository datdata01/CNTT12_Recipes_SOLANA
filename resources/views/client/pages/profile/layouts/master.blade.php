@extends('client.layouts.master')
@section('content')
    <section class="section-b-space pt-0">
        <div class="custom-container user-dashboard-section container">
            <div class="row">
                <div class="col-xl-3 col-lg-4">
                    @include('client.pages.profile.layouts.components.nav')
                </div>
                <div class="col-xl-9 col-lg-8">
                    @yield('profile')
                </div>
            </div>
        </div>
    </section>
@endsection
