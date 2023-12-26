@if (Auth::user() && Auth::user()->role == 'admin')
    <x-dashboards.admin ></x-dashboards.admin>
@elseif (Auth::user() && Auth::user()->role == 'customer')
    <x-dashboards.passenger ></x-dashboards.passenger>
@endif
