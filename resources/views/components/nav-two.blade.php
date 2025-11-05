@props(['activePage', 'page', 'page2', 'page3'])

<a href="{{ route($page) }}">
  <h6 @class(['py-3', 'active2' => $activePage === $page || $activePage === $page2 || $activePage === $page3])> {{ $slot }} </h6>
</a>