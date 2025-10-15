@props(['activePage', 'page'])

<a href="{{ route($page) }}">
  <h6 @class(['py-3', 'active2' => $activePage === $page])> {{ $slot }} </h6>
</a>