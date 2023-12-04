    @include('layouts/provider/header')

    @include('layouts/provider/sidebar')

        @include($content)

    @include('layouts/provider/footer')

@stack('scripts')
