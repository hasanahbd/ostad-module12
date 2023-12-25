<footer class="bg-dark text-light text-center text-lg-start">
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        © {{ date('Y') }}:
        <a class="text-light" href="{{ url('/') }}">{{ config('app.name', 'Laravel Application') }}</a>
    </div>
</footer>