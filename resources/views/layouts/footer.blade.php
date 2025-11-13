<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<script>
    const userId = '{{ Auth::id() }}';
</script>
@vite(['resources/js/app.js'])
@stack('js')
</body>
</html>
