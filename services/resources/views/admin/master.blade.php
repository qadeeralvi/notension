
    @include('layouts/admin/header')

    @include('layouts/admin/sidebar')

        @include($content)


    @include('layouts/admin/footer')

@stack('scripts')
