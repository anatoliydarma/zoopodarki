@extends('layouts.wide')
@section('content')

  <div class="pt-6 pb-14">
    <div class="space-y-24">

      <div class="flex flex-col max-w-screen-xl gap-8 px-4 mx-auto">
        <div class="flex flex-col items-center justify-between gap-8 md:flex-row">
          <a href="{{ route('site.category', ['catalogslug' => 'cats', 'categoryslug' => 'suhoy-korm']) }}"
            class="relative w-full py-12 overflow-hidden transition bg-yellow-300 cursor-pointer sm:text-white md:w-7/12 px-14 h-72 bg-opacity-80 rounded-3xl hover:bg-opacity-100">
            <h2 class="relative z-20 text-5xl font-bold">Сухой корм<br>для кошек</h2>
            <img src="/assets/img/home-block-one.webp" alt="Сухой корм для котов" class="absolute right-0 -bottom-4">
          </a>
          <a href="{{ route('site.category', ['catalogslug' => 'dogs', 'categoryslug' => 'odezhda-i-obuv']) }}"
            class="relative w-full py-12 overflow-hidden transition bg-blue-300 cursor-pointer sm:text-white md:w-5/12 px-14 h-72 rounded-3xl hover:bg-blue-400">
            <h2 class="relative z-20 text-5xl font-bold">Одежда<br>для<br>собак</h2>
            <img src="/assets/img/home-block-two.webp" alt="Сухой корм для кошек" class="absolute z-10 right-4 -bottom-0">
          </a>
        </div>
        <div class="flex flex-col items-center justify-between gap-8 md:flex-row ">
          <a href="{{ route('site.category', ['catalogslug' => 'cats', 'categoryslug' => 'kogtetochki-domiki-lezhanki']) }}"
            class="relative w-full py-12 overflow-hidden transition bg-orange-300 cursor-pointer sm:text-white md:w-5/12 px-14 h-72 rounded-3xl hover:bg-orange-400">
            <h2 class="relative z-20 text-5xl font-bold">Домики<br>для<br>кошек</h2>
            <img src="/assets/img/home-block-three.webp" alt="Сухой корм для кошек"
              class="absolute z-10 right-4 -bottom-0">
          </a>
          <a href="{{ route('site.category', ['catalogslug' => 'dogs', 'categoryslug' => 'suhoy-korm-1']) }}"
            class="relative w-full py-12 overflow-hidden transition bg-pink-300 cursor-pointer sm:text-white md:w-7/12 px-14 h-72 bg-opacity-80 rounded-3xl hover:bg-opacity-100">
            <h2 class="relative z-20 text-5xl font-bold">Сухой корм<br>для собак</h2>
            <img src="/assets/img/home-block-four.webp" alt="Сухой корм для собак"
              class="absolute z-10 right-6 -bottom-2">
          </a>
        </div>
      </div>

      @if ($discounts->isNotEmpty())
        <div class="max-w-screen-xl mx-auto space-y-4">
          <div class="px-4 text-2xl font-semibold">Выгодные предложения</div>
          <div class="px-4 pt-4 space-y-8 lg:px-8">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5">
              @foreach ($discounts as $discountItem)
                <div class="w-full max-w-xs mx-auto">
                  <livewire:site.card-products :product="$discountItem"
                    :catalog="$discountItem->categories[0]->catalog->slug" :category="$discountItem->categories[0]->slug"
                    :wire:key="'product-'.$discountItem->id" :catalogId="$discountItem->categories[0]->catalog->id" />
                </div>
              @endforeach
            </div>
            <div class="flex items-center justify-center w-full md:px-4 ">
              <a href="{{ route('site.discounts') }}"
                class="flex items-center justify-between gap-1 px-3 py-2 border border-gray-300 bg-gray-50 hover:bg-gray-100 rounded-2xl">
                <span>Все предложения</span>
                <x-tabler-chevron-right class="w-5 h-5" />
              </a>
            </div>
          </div>
        </div>
      @endif

      <div class="py-24 bg-yellow-100">
        <div x-data class="grid max-w-screen-xl gap-12 px-4 mx-auto sm:grid-cols-2 md:grid-cols-4">
          <div @click="$dispatch('auth')"
            class="relative flex items-center justify-center p-6 overflow-hidden text-lg leading-snug text-center transition-shadow bg-white shadow-sm rounded-3xl {{ auth() ? '' : ' cursor-pointer hover:shadow-lg' }}">
            <x-tabler-gift class="absolute z-10 w-32 h-32 text-pink-200 stroke-current -right-8 -top-0" />
            <span class="relative z-20">Скидка за первый заказ</span>
          </div>
          <div @click="$dispatch('auth')"
            class="relative flex items-center justify-center p-6 overflow-hidden text-lg leading-snug text-center transition-shadow bg-white shadow-sm rounded-3xl {{ auth() ? '' : ' cursor-pointer hover:shadow-lg' }}">
            <x-tabler-credit-card class="absolute z-10 w-32 h-32 text-pink-200 stroke-current -right-8 -top-2" />
            <span class="relative z-20">Постоянная скидка<br>по карте</span>
          </div>
          <div @click="$dispatch('auth')"
            class="relative flex items-center justify-center p-6 overflow-hidden text-lg leading-snug text-center transition-shadow bg-white shadow-sm rounded-3xl {{ auth() ? '' : ' cursor-pointer hover:shadow-lg' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
              class="absolute z-10 w-32 h-32 text-pink-200 stroke-current -right-8 top-2">
              <path class="text-pink-200" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10 22H14C19 22 21 20 21 15V9C21 4 19 2 14 2H10C5 2 3 4 3 9V15C3 20 5 22 10 22Z" />
              <path class="text-pink-200" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17.25 8.29004C14.26 5.63004 9.74 5.63004 6.75 8.29004L8.93 11.79C10.68 10.23 13.32 10.23 15.07 11.79L17.25 8.29004Z" />
            </svg>
            <span class="relative z-20">Скидка на корма<br>от 5 кг</span>
          </div>
          <div @click="$dispatch('auth')"
            class="relative flex items-center justify-center p-6 overflow-hidden text-lg leading-snug text-center transition-shadow bg-white shadow-sm rounded-3xl {{ auth() ? '' : ' cursor-pointer hover:shadow-lg' }}">
            <x-tabler-discount-2 class="absolute z-10 w-32 h-32 text-pink-200 stroke-current -right-8 -top-0" />
            <span class="relative z-20">Суммируем скидки</span>
          </div>
        </div>
      </div>

      <div class="max-w-screen-xl px-4 mx-auto space-y-4">
        <div class="gap-4 text-2xl font-semibold">Популярные бренды</div>
        <div class="px-6 py-8 space-y-8">
          <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5">
            @forelse ($brandsOffer as $brand)

              <a title="Товары бренда {{ $brand->name }}"
                href="{{ route('site.brand', ['brandslug' => $brand->slug]) }}" class="block p-2 mx-auto group ">
                @if ($brand->logo)
                  <img src="/assets/brands/{{ $brand->logo }}" alt="Товары бренда {{ $brand->name }}"
                    class="w-auto h-24 group-hover:brightness-110">
                @else
                  <span class="text-xl font-bold group-hover:text-blue-500">{{ $brand->name }}</span>
                @endif
              </a>

            @empty
            @endforelse
          </div>

          <div class="flex items-center justify-center w-full md:px-4 ">
            <a href="{{ route('site.brands') }}"
              class="flex items-center justify-between gap-1 px-3 py-2 border border-gray-300 bg-gray-50 hover:bg-gray-100 rounded-2xl">
              <span>Все бренды</span>
              <x-tabler-chevron-right class="w-5 h-5" />
            </a>
          </div>
        </div>
      </div>

      <div class="max-w-screen-xl mx-auto space-y-4 ">
        <div class="px-4 text-2xl font-semibold">Популярные товары</div>

        <div x-cloak x-data="{tab: 1}">
          <div class="flex items-center justify-between w-screen gap-6 overflow-x-auto md:px-4">
            <nav class="flex items-center justify-start flex-nowrap">
              @if ($popular1->isNotEmpty())
                <h2 x-on:click="tab = 1" data-route="description" :class="{ 'text-blue-500 border-blue-500': tab == 1 }"
                  class="block px-6 py-2 text-lg font-semibold text-gray-600 border-b-2 border-gray-200 cursor-pointer hover:text-blue-500 focus:outline-none whitespace-nowrap">
                  Наполнители для туалета
                </h2>
              @endif
              @if ($popular2->isNotEmpty())
                <h2 x-on:click="tab = 2" data-route="consist" :class="{ 'text-blue-500 border-blue-500': tab == 2 }"
                  class="block px-6 py-2 text-lg font-semibold text-gray-600 border-b-2 border-gray-200 cursor-pointer hover:text-blue-500 focus:outline-none whitespace-nowrap">
                  Амуниция для собак
                </h2>
              @endif
              @if ($popular3->isNotEmpty())
                <h2 x-on:click="tab = 3" data-route="applying" :class="{ 'text-blue-500 border-blue-500': tab == 3 }"
                  class="block px-6 py-2 text-lg font-semibold text-gray-600 border-b-2 border-gray-200 cursor-pointer hover:text-blue-500 focus:outline-none whitespace-nowrap">
                  Аквариумы для рыбок
                </h2>
              @endif
              @if ($popular4->isNotEmpty())
                <h2 x-on:click="tab = 4" data-route="applying" :class="{ 'text-blue-500 border-blue-500': tab == 4 }"
                  class="block px-6 py-2 text-lg font-semibold text-gray-600 border-b-2 border-gray-200 cursor-pointer hover:text-blue-500 focus:outline-none whitespace-nowrap">
                  Кормушки для птиц
                </h2>
              @endif
              @if ($popular5->isNotEmpty())
                <h2 x-on:click="tab = 5" data-route="applying" :class="{ 'text-blue-500 border-blue-500': tab == 4 }"
                  class="block px-6 py-2 text-lg font-semibold text-gray-600 border-b-2 border-gray-200 cursor-pointer hover:text-blue-500 focus:outline-none whitespace-nowrap">
                  Игрушки для собак
                </h2>
              @endif
            </nav>
            <div>
            </div>
          </div>

          <div class="w-full px-4">
            @if ($popular1->isNotEmpty())
              <div x-cloak :class="tab == 1 ? 'block' : 'hidden'" class="pt-6 space-y-8">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5">
                  @foreach ($popular1 as $popular1Product)
                    <div class="w-full max-w-xs mx-auto">
                      <livewire:site.card-products :product="$popular1Product"
                        :catalog="$popular1Product->categories[0]->catalog->slug"
                        :category="$popular1Product->categories[0]->slug" :wire:key="'product-'.$popular1Product->id"
                        :catalogId="$popular1Product->categories[0]->catalog->id" />
                    </div>
                  @endforeach
                </div>
                <div class="flex items-center justify-center w-full md:px-4 ">
                  <a href="{{ route('site.category', ['catalogslug' => $popular1Product->categories[0]->catalog->slug, 'categoryslug' => $popular1Product->categories[0]->slug]) }}"
                    title="Все наполнители для кошачего туалета"
                    class="flex items-center justify-between gap-1 px-3 py-2 border border-gray-300 bg-gray-50 hover:bg-gray-100 rounded-2xl">
                    <span>Все наполнители для кошачего туалета</span>
                    <x-tabler-chevron-right class="w-5 h-5" />
                  </a>
                </div>
              </div>
            @endif

            @if ($popular2->isNotEmpty())
              <div x-cloak :class="tab == 2 ? 'block' : 'hidden'" class="pt-6 space-y-8">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5">
                  @foreach ($popular2 as $popular2Product)
                    <div class="w-full max-w-xs mx-auto">
                      <livewire:site.card-products :product="$popular2Product"
                        :catalog="$popular2Product->categories[0]->catalog->slug"
                        :category="$popular2Product->categories[0]->slug" :wire:key="'product-'.$popular2Product->id"
                        :catalogId="$popular2Product->categories[0]->catalog->id" />
                    </div>
                  @endforeach
                </div>
                <div class="flex items-center justify-center w-full px-4 space-x-1">
                  <a href="{{ route('site.category', ['catalogslug' => $popular2Product->categories[0]->catalog->slug, 'categoryslug' => $popular2Product->categories[0]->slug]) }}"
                    title="Вся амуниция для собак"
                    class="flex items-center justify-between gap-1 px-3 py-2 border border-gray-300 bg-gray-50 hover:bg-gray-100 rounded-2xl">
                    <span>Вся амуниция для собак</span>
                    <x-tabler-chevron-right class="w-5 h-5" />
                  </a>
                </div>
              </div>
            @endif

            @if ($popular3->isNotEmpty())
              <div x-cloak :class="tab == 3 ? 'block' : 'hidden'" class="pt-6 space-y-8">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5">
                  @foreach ($popular3 as $popular3Product)
                    <div class="w-full max-w-xs mx-auto">
                      <livewire:site.card-products :product="$popular3Product"
                        :catalog="$popular3Product->categories[0]->catalog->slug"
                        :category="$popular3Product->categories[0]->slug" :wire:key="'product-'.$popular3Product->id"
                        :catalogId="$popular3Product->categories[0]->catalog->id" />
                    </div>
                  @endforeach
                </div>
                <div class="flex items-center justify-center w-full px-4 space-x-1">
                  <a href="{{ route('site.category', ['catalogslug' => $popular3Product->categories[0]->catalog->slug, 'categoryslug' => $popular3Product->categories[0]->slug]) }}"
                    title="Все аквариумы для рыбок"
                    class="flex items-center justify-between gap-1 px-3 py-2 border border-gray-300 bg-gray-50 hover:bg-gray-100 rounded-2xl">
                    <span>Все аквариумы для рыбок</span>
                    <x-tabler-chevron-right class="w-5 h-5" />
                  </a>
                </div>
              </div>
            @endif

            @if ($popular4->isNotEmpty())
              <div x-cloak :class="tab == 4 ? 'block' : 'hidden'" class="pt-6 space-y-8">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5">
                  @foreach ($popular4 as $popular4Product)
                    <div class="w-full max-w-xs mx-auto">
                      <livewire:site.card-products :product="$popular4Product"
                        :catalog="$popular4Product->categories[0]->catalog->slug"
                        :category="$popular4Product->categories[0]->slug" :wire:key="'product-'.$popular4Product->id"
                        :catalogId="$popular4Product->categories[0]->catalog->id" />
                    </div>
                  @endforeach
                </div>
                <div class="flex items-center justify-center w-full px-4 space-x-1">
                  <a href="{{ route('site.category', ['catalogslug' => $popular4Product->categories[0]->catalog->slug, 'categoryslug' => $popular4Product->categories[0]->slug]) }}"
                    title="Все кормушки для птиц"
                    class="flex items-center justify-between gap-1 px-3 py-2 border border-gray-300 bg-gray-50 hover:bg-gray-100 rounded-2xl">
                    <span>Все кормушки для птиц</span>
                    <x-tabler-chevron-right class="w-5 h-5" />
                  </a>
                </div>
              </div>
            @endif

            @if ($popular5->isNotEmpty())
              <div x-cloak :class="tab == 5 ? 'block' : 'hidden'" class="pt-6 space-y-8">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5">
                  @foreach ($popular5 as $popular5Product)
                    <div class="w-full max-w-xs mx-auto">
                      <livewire:site.card-products :product="$popular5Product"
                        :catalog="$popular5Product->categories[0]->catalog->slug"
                        :category="$popular5Product->categories[0]->slug" :wire:key="'product-'.$popular5Product->id"
                        :catalogId="$popular5Product->categories[0]->catalog->id" />
                    </div>
                  @endforeach
                </div>
                <div class="flex items-center justify-center w-full px-4 space-x-1">
                  <a href="{{ route('site.category', ['catalogslug' => $popular5Product->categories[0]->catalog->slug, 'categoryslug' => $popular5Product->categories[0]->slug]) }}"
                    title="Все кормушки для птиц"
                    class="flex items-center justify-between gap-1 px-3 py-2 border border-gray-300 bg-gray-50 hover:bg-gray-100 rounded-2xl">
                    <span>Все игрушки для собак</span>
                    <x-tabler-chevron-right class="w-5 h-5" />
                  </a>
                </div>
              </div>
            @endif

          </div>
        </div>

      </div>

      <div class="py-24 bg-yellow-100">
        <div class="flex flex-col items-center justify-between max-w-screen-lg gap-6 px-4 mx-auto sm:flex-row">
          <div class="flex flex-col items-center justify-center gap-4 text-lg font-bold">
            <svg class="w-12 h-12 text-orange-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <path class="stroke-current" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 14h1l2-2V2H6L3 4" />
              <path class="stroke-current" stroke-linecap=" round" stroke-linejoin="round" stroke-width="2"
                d="M2 17c0 2 1 3 3 3h1l2-2 2 2h4l2-2 2 2h1c2 0 3-1 3-3v-3h-3l-1-1v-3l1-1h1l-1-3-2-1h-2v7l-2 2h-1" />
              <path class="stroke-current" stroke-linecap=" round" stroke-linejoin="round" stroke-width="2"
                d="M8 22a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm8 0a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm6-10v2h-3l-1-1v-3l1-1h1l2 3zM2 8h6m-6 3h4m-4 3h2" />
            </svg>
            <span class="text-2xl text-gray-500">Бесплатная доставка</span>
          </div>

          <div class="flex flex-col items-center justify-center gap-4 text-lg font-bold">
            <x-tabler-shield-check class="w-12 h-12 text-blue-300" />
            <span class="text-2xl text-gray-500">Гарантия качества</span>
          </div>

          <div class="flex flex-col items-center justify-center gap-4 text-lg font-bold">
            <svg class="w-12 h-12 text-pink-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <path class="stroke-current" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M13 21h-2c-3-1-9-5-9-12 0-3 2-6 6-6l4 2a6 6 0 0 1 10 4c0 7-6 11-9 12Z" />
            </svg>
            <span class="text-2xl text-gray-500">Душевное обслуживание</span>
          </div>
        </div>
      </div>

      <div class="max-w-screen-xl px-4 mx-auto">
        <div class="flex flex-col justify-center md:flex-row ">
          <div class="w-full md:w-6/12">
            <img itemprop="image" loading="lazy"
              class="object-contain object-center w-full h-full shadow-2xl rounded-3xl "
              src="/assets/img/dogs-shelter.webp" alt="Приют для собак">
          </div>
          <div class="w-full prose sm:px-16 md:w-6/12 py-14">
            <h3 class="text-5xl font-bold text-gray-600">Помоги приюту</h3>
            <p>Помогите приобрести товары приюту, который спасает собак, оказавшихся в тяжёлой ситуации. Они искренне
              любят собак, и им нужна ваша помощь.</p>
            <div class="py-6 not-prose">
              <a href="{{ route('site.category', ['catalogslug' => 'help-shelter', 'categoryslug' => 'priyut-dlya-sobak']) }}"
                class="px-4 py-3 text-lg font-bold text-white transition-shadow bg-blue-400 rounded-2xl hover:shadow-blue-300 hover:shadow-lg ">Выбрать
                товары из списка
              </a>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

@endsection
