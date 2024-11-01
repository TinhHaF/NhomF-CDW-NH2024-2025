@if (session('success'))
<meta name="flash-success" content="{{ session('success') }}">
@endif
@if (session('error'))
<meta name="flash-error" content="{{ session('error') }}">
@endif
@if (session('warning'))
<meta name="flash-warning" content="{{ session('warning') }}">
@endif
@if (session('info'))
<meta name="flash-info" content="{{ session('info') }}">
@endif

<script src="{{ asset('js/custom.js') }}"></script>