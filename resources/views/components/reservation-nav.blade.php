@props(['activePage', 'page'])

<a href="{{ route($page) }}" @class(['py-3 col-4 btn reservation_nav', 'active2' => $activePage === $page])>
  {{ $slot }}
</a>