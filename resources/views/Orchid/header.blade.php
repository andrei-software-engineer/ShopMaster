@push('head')
    <meta name="robots" content="noindex" />
    <link
          href="{{ asset('/vendor/orchid/favicon.svg') }}"
          sizes="any"
          type="image/svg+xml"
          id="favicon"
          rel="icon"
    >

    <!-- For Safari on iOS -->
    <meta name="theme-color" content="#21252a">
    
    @include("common/commonHead")

    @vite(['resources/js/appAdmin.js'])
{{-- @vite(['resources/sass/appAdmin.scss','resources/js/appAdmin.js']) --}}

@endpush

<div class="h2 fw-light d-flex align-items-center">
   <x-orchid-icon path="orchid" width="1.2em" height="1.2em"/>

    <p class="ms-3 my-0 d-none d-sm-block">
        {{ _GL('ORCHID') }}
        <small class="align-top opacity">{{ _GL('Platform') }}</small>
    </p>

</div>

<div id="popupadmin"></div>
