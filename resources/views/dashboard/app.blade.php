@include('dashboard.header')

<div x-cloak
  x-data="{sidebar: $persist(true), productMenu: $persist(false), settingMenu: $persist(false), sidebarWindow: new TouchSweep(sidebarWindow), }"
  class="relative flex items-start ">
  @include('dashboard.navbar')
  @include('dashboard.sidebar')
  <article :class="{'sm:pl-56': sidebar, 'sm:pl-0' : !sidebar }"
    class="flex-col w-full transition-all duration-300 sm:pl-56 md:flex md:flex-row md:min-h-screen">
    <div class="w-full max-w-screen-md px-4 py-10 text-gray-600 lg:px-10 md:max-w-full">
      @yield ('content')
    </div>
  </article>
</div>

@include('dashboard.footer')
