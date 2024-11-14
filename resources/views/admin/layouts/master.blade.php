<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @yield('title')
    </title>
    @stack('admin-css')
    @include('admin.layouts.partials.css')

</head>

<body>
    <!-- Left Panel -->
    @include('admin.layouts.partials.left-panel')
    <!-- /#left-panel -->

    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        <header id="header" class="header">
            @include('admin.layouts.partials.header')
        </header>
        <!-- /#header -->

        <!-- Content -->
        <main class="content py-3" style="min-height : 80vh">
            @yield('content')
        </main>
        <!-- /.content -->

        <div class="clearfix"></div>

        <!-- Footer -->
        <footer class="site-footer">
            @include('admin.layouts.partials.footer')
        </footer>
        <!-- /.site-footer -->

    </div>
    <!-- /#right-panel -->

    <!-- Scripts -->
    @include('admin.layouts.partials.script')
    @stack('admin-scripts')
</body>

</html>
