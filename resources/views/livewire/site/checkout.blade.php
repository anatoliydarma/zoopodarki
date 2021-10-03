@section('title')
  Оформление заказа
@endsection

<div class="py-4">
  <div class="justify-between block md:flex md:space-x-6">
    <div class="block w-full px-6 pt-6 pb-6 space-y-6 bg-white md:w-8/12 rounded-2xl">

      <div>
        <h3 class="block pb-4 text-2xl font-thin">Оформление заказа</h3>
        @guest
          <div x-cloak x-data class="py-4 text-sm text-gray-600">Пожалуйста, <button x-on:click="$dispatch('auth')"
              class="text-orange-500 hover:text-orange-600 focus:outline-none">
              авторизуйтесь или зарегистрируйтесь.
            </button>
          </div>
        @else

          <h4 class="text-lg font-bold">Контакты</h4>
          <div class="items-center justify-start block pt-2 space-y-6 md:space-y-0 md:space-x-6 md:flex">
            @if ($contact)
              <div
                class="items-start justify-start block w-full px-4 py-3 space-y-4 md:w-9/12 md:space-y-0 md:space-x-4 md:flex md:h-14">

                @if ($contact['name'])
                  <div>
                    <div class="text-xs text-gray-400">Имя: </div>
                    <div>{{ $contact['name'] }}</div>
                  </div>
                @endif

                @if ($contact['phone'])
                  <div class="w-32">
                    <div class="text-xs text-gray-400">Тел: </div>
                    <div>{{ $contact['phone'] }}</div>
                  </div>
                @endif

                @if ($contact['email'])
                  <div>
                    <div class="text-xs text-gray-400">Email: </div>
                    <div>{{ $contact['email'] }}</div>
                  </div>
                @endif


              </div>
            @else
              <div class="w-full md:w-9/12">
                <div>Добавьте контакт который должен получить заказ</div>
                @error('contact')
                  <div class="text-sm text-red-500">
                    Вам необходимо добавить контакты
                  </div>
                @enderror
              </div>
            @endif
            <span wire:loading wire:target="contact">Updating...</span>

            <div class="w-full md:w-3/12">
              <livewire:site.user-contacts />
            </div>

          </div>

        @endguest
      </div>

      <div x-data="{ toggle: {{ $orderType }} }">
        <h4 class="pb-2 text-lg font-bold">Способ доставки</h4>
        <div class="space-y-4">
          <div class="content-center justify-start block space-y-4 md:space-y-0 md:space-x-4 md:flex">
            <div
              class="inline-flex w-full leading-none text-gray-400 bg-gray-200 border-2 border-gray-200 rounded-2xl md:w-6/12 h-14">

              <button wire:click="getOrderType(0)" x-on:click="toggle = 0"
                :class="{ 'bg-white text-green-500': toggle === 0 }"
                class="inline-flex items-center w-6/12 px-4 py-2 transition-colors duration-300 ease-in rounded-2xl focus:outline-none hover:text-green-400">
                <svg :class="{ 'text-green-500': toggle === 0 }" class="w-8 h-6 pr-2 fill-current"
                  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                  <path
                    d="M1,12.5v5a1,1,0,0,0,1,1H3a3,3,0,0,0,6,0h6a3,3,0,0,0,6,0h1a1,1,0,0,0,1-1V5.5a3,3,0,0,0-3-3H11a3,3,0,0,0-3,3v2H6A3,3,0,0,0,3.6,8.7L1.2,11.9a.61.61,0,0,0-.07.14l-.06.11A1,1,0,0,0,1,12.5Zm16,6a1,1,0,1,1,1,1A1,1,0,0,1,17,18.5Zm-7-13a1,1,0,0,1,1-1h9a1,1,0,0,1,1,1v11h-.78a3,3,0,0,0-4.44,0H10Zm-2,6H4L5.2,9.9A1,1,0,0,1,6,9.5H8Zm-3,7a1,1,0,1,1,1,1A1,1,0,0,1,5,18.5Zm-2-5H8v2.78a3,3,0,0,0-4.22.22H3Z" />
                </svg>
                <span>Доставка</span>
              </button>
              <button wire:click="getOrderType(1)" x-on:click="toggle = 1"
                :class="{ 'bg-white text-green-500': toggle === 1 }"
                class="inline-flex items-center w-6/12 px-4 py-2 transition-colors duration-300 ease-in rounded-2xl focus:outline-none hover:text-green-400">

                <svg :class="{ 'text-green-500': toggle === 1 }" class="w-8 h-8 pr-2 fill-current"
                  xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 24 24">
                  <path
                    d="M22,16H19.82A3,3,0,0,0,20,15V10a3,3,0,0,0-3-3H11a3,3,0,0,0-3,3v5a3,3,0,0,0,.18,1H7a1,1,0,0,1-1-1V5A3,3,0,0,0,3,2H2A1,1,0,0,0,2,4H3A1,1,0,0,1,4,5V15a3,3,0,0,0,2.22,2.88,3,3,0,1,0,5.6.12h3.36a3,3,0,1,0,5.64,0H22a1,1,0,0,0,0-2ZM9,20a1,1,0,1,1,1-1A1,1,0,0,1,9,20Zm2-4a1,1,0,0,1-1-1V10a1,1,0,0,1,1-1h6a1,1,0,0,1,1,1v5a1,1,0,0,1-1,1Zm7,4a1,1,0,1,1,1-1A1,1,0,0,1,18,20Z" />
                </svg>
                <span>Самовывоз</span>
              </button>
            </div>

            <div wire:ignore class="flex items-center w-full md:w-6/12">
              <svg class="hidden w-8 h-8 pr-2 text-gray-300 fill-current md:block" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24">
                <path
                  d="M14.83,11.29,10.59,7.05a1,1,0,0,0-1.42,0,1,1,0,0,0,0,1.41L12.71,12,9.17,15.54a1,1,0,0,0,0,1.41,1,1,0,0,0,.71.29,1,1,0,0,0,.71-.29l4.24-4.24A1,1,0,0,0,14.83,11.29Z" />
              </svg>
              <div class="text-sm text-gray-400">Санкт-Петербург</div>
            </div>
          </div>

          <div class="w-full">

            <div :class="{ 'flex': toggle == 0, 'hidden': toggle == 1}"
              class="flex flex-col items-center justify-start space-y-6 md:space-y-0 md:space-x-6 md:flex-row">
              @if (!empty($address))
                <div class="flex-col items-start justify-start w-full px-4 py-3 space-y-1 md:w-9/12 h-14">
                  <div>
                    {{ $address['address'] }}
                  </div>
                  @if ($address['extra'])
                    <div class="text-xs text-gray-400">
                      , {{ $address['extra'] }}
                    </div>
                  @endif

                </div>
              @else
                <div class="w-9/12 pl-4">
                  Добавьте адрес
                  @error('address.address')
                    <div class="pt-1 text-sm text-red-500">
                      Вам необходимо добавить адрес
                    </div>
                  @enderror
                </div>
              @endif

              <div class="w-full md:w-3/12">
                <livewire:site.user-addresses />
              </div>

            </div>

            <div x-cloak :class="{ 'block': toggle == 1, 'hidden': toggle == 0}" class="w-full fadeIn">

              <div x-cloak x-data="modal">
                <div x-on:close-modal.window="close()" x-show="showModal" x-transition.opacity
                  @keydown.window.escape="close()"
                  class="fixed top-0 left-0 z-40 flex items-center justify-center w-screen h-screen bg-gray-500 bg-opacity-50"
                  role="dialog" aria-modal="true">
                  <div x-on:click.outside="close()" x-show="showModal" x-transition
                    class="absolute z-50 flex flex-col max-w-5xl bg-white md:shadow-xl md:rounded-xl">

                    <div class="absolute flex items-center justify-between top-4 left-4 md:left-auto md:right-4">
                      <button x-on:click="close()" class="link-hover">
                        <x-tabler-x class="w-6 h-6 text-gray-500 stroke-current" />
                      </button>
                    </div>

                    <livewire:site.map :checkout="true">

                  </div>
                </div>
                <div class="items-center justify-start block space-y-6 md:space-y-0 md:space-x-6 md:flex">

                  <div class="items-center justify-start block w-full px-4 md:flex md:w-9/12 h-14">
                    <div>
                      @if ($pickupStore)
                        {{ $pickupStore }}
                      @else

                        <div x-on:click="open(), $dispatch('init-map')" class="py-2 cursor-pointer">Выберите пункт
                          выдачи
                        </div>
                      @endif
                      @error('pickupStore')
                        <div class="text-sm text-red-500">
                          Вам необходимо добавить адрес
                        </div>
                      @enderror
                    </div>
                  </div>

                  <div x-on:click="open(), $dispatch('init-map')"
                    class="flex items-center justify-center w-full px-4 space-x-1 bg-gray-100 border border-gray-100 cursor-pointer md:w-3/12 hover:border-gray-300 h-14 rounded-xl">
                    <div>Пункты выдачи</div>
                    <x-tabler-chevron-right class="w-6 h-6 text-gray-400 stroke-current" />
                  </div>

                </div>
                <script>
                  document.addEventListener('alpine:initializing', () => {
                    Alpine.data('modal', () => ({
                      body: document.body,
                      showModal: false,
                      open() {
                        this.showModal = true
                        this.body.classList.add('overflow-hidden', 'pr-4');
                      },
                      close() {
                        this.showModal = false
                        this.body.classList.remove('overflow-hidden', 'pr-4');
                      },
                    }))
                  })
                </script>
              </div>
            </div>

          </div>

          <div x-cloak :class="{ 'block': toggle == 0, 'hidden': toggle == 1}"
            class="relative w-full pt-3 space-y-6 fadeIn">
            <div class="block w-full space-y-6 md:space-y-0 md:space-x-6 md:flex md:justify-between">

              <div x-data="{date: @entangle('date')}" class="w-full md:w-9/12">

                <label class="block pb-2 text-lg font-bold text-gray-700">Дата доставки</label>
                <div wire:ignore id="date" class="flex items-center justify-center w-full overflow-hidden splide">
                  <div class="flex items-center text-blue-500 splide__arrows">
                    <button class="splide__arrow splide__arrow--prev">
                      <div class="p-1 text-2xl border rounded-full hover:bg-gray-100">
                        <x-tabler-chevron-right />
                      </div>
                    </button>
                    <button class="splide__arrow splide__arrow--next">
                      <div class="p-1 text-2xl border rounded-full hover:bg-gray-100">
                        <x-tabler-chevron-right />
                      </div>
                    </button>
                  </div>
                  <div class="w-full max-w-xs md:max-w-md splide__track">
                    <ul class="border-t border-b border-r splide__list">
                      @foreach ($dates as $item)
                        <li class="relative cursor-pointer splide__slide hover:bg-gray-100"
                          :class="{ 'text-green-500': date == '{{ $item['date'] }}'}">
                          <div x-on:click="$wire.set('date', '{{ $item['date'] }}')"
                            class="block px-2 py-3 text-center border-l">
                            <div class="pb-1 font-semibold">
                              {{ $item['number'] }}
                            </div>
                            <div class="text-xs capitalize truncate"
                              :class="{ 'text-green-500' : date === '{{ $item['date'] }}' , 'text-gray-500' : date !== '{{ $item['date'] }}'}">
                              {{ $item['name'] }}
                            </div>
                          </div>
                        </li>
                      @endforeach
                    </ul>
                  </div>
                </div>
                @error('date')
                  <span class="block pt-2 pl-4 text-sm text-red-500">
                    Выберите дату доставки
                  </span>
                @enderror

                @push('footer')
                  <script src="{{ mix('js/splide.min.js') }}"></script>
                  <script>
                    document.addEventListener('DOMContentLoaded', function() {
                      new Splide('#date', {
                        fixedWidth: '5rem',
                        perMove: 2,
                        pagination: false,
                        classes: {
                          arrows: 'splide__arrows your-class-arrows',
                          arrow: 'splide__arrow your-class-arrow',
                          prev: 'splide__arrow--prev your-class-prev',
                          next: 'splide__arrow--next your-class-next',
                        },
                      }).mount();
                    });
                  </script>
                @endpush

              </div>

              <div class="w-full md:w-3/12">
                <label class="block pb-2 text-lg font-bold text-gray-700">Время доставки</label>
                <select wire:model="deliveryTime" name="deliveryTime" class="h-14 field">
                  <option value="10:00 - 16:00">10:00 - 16:00</option>
                  <option value="10:00 - 18:00">10:00 - 18:00</option>
                  <option value="12:00 - 16:00">12:00 - 16:00</option>
                  <option value="12:00 - 18:00">12:00 - 18:00</option>
                  <option value="16:00 - 20:00">16:00 - 20:00</option>
                  <option value="18:00 - 20:00">18:00 - 20:00</option>
                </select>
              </div>

            </div>
          </div>

        </div>
      </div>

      <div x-data="{payment: 'online'}" class="pt-2">
        <div class="pb-2 text-lg font-bold leading-normal text-gray-700">Вид оплаты</div>
        <div class="content-center justify-start block space-y-4 md:flex md:space-y-0 md:space-x-4">

          <div
            class="inline-flex w-full leading-none text-gray-400 bg-gray-200 border-2 border-gray-200 md:h-14 rounded-2xl md:w-6/12">
            <button wire:click="paymentType(0)" x-on:click="payment = 'online'"
              :class="{ 'bg-white text-green-500': payment == 'online' }"
              class="inline-flex items-center w-6/12 px-4 py-2 transition-colors duration-300 ease-in rounded-2xl focus:outline-none hover:text-green-400">

              <x-tabler-credit-card :class="{ 'text-green-400': payment == 'online' }"
                class="inline mr-2 stroke-current w-7 h-7" />

              <span>Оплата онлайн</span>
            </button>
            <button wire:click="paymentType(1)" x-on:click="payment = 'cash'"
              :class="{ 'bg-white text-green-500': payment == 'cash' }"
              class="flex items-center justify-center w-6/12 px-4 py-2 space-x-4 transition-colors duration-300 ease-in rounded-2xl focus:outline-none hover:text-green-400">
              <svg :class="{ 'text-green-400': payment == 'cash' }" class="w-8 h-8 fill-current"
                xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" viewBox="0 0 24 24">
                <g fill="none">
                  <path
                    d="M17 9V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2m2 4h10a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2zm7-5a2 2 0 1 1-4 0a2 2 0 0 1 4 0z"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </g>
              </svg>
              <span>Наличными <br><span class="text-xs">(при получении)</span></span>
            </button>
          </div>

          <div class="flex items-center w-full md:w-6/12">
            <svg class="hidden w-8 h-8 pr-2 text-gray-300 fill-current md:block" xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 24 24">
              <path
                d="M14.83,11.29,10.59,7.05a1,1,0,0,0-1.42,0,1,1,0,0,0,0,1.41L12.71,12,9.17,15.54a1,1,0,0,0,0,1.41,1,1,0,0,0,.71.29,1,1,0,0,0,.71-.29l4.24-4.24A1,1,0,0,0,14.83,11.29Z" />
            </svg>
            <div class="text-gray-400">
              <div :class="{ 'flex': payment == 'online', 'hidden': payment == 'cash' }" class="w-full text-sm">
                Банковской картой онлайн
              </div>
              <div x-cloak :class="{ 'flex': payment == 'cash', 'hidden': payment == 'online'}"
                class="items-center justify-end space-x-3">
                <span class="block text-sm text-right text-gray-700 ">Нужна сдача с</span>
                <div class="w-32">
                  <input wire:model="needChange" type="number" class="placeholder-gray-300 field" placeholder="500"
                    inputmode="numeric">
                </div>
                <span class="flex text-sm text-gray-700">рублей</span>
              </div>
            </div>
          </div>

        </div>
      </div>

      <div class="flex justify-between pt-2">
        <div class="w-full">
          <div class="block pb-2 text-lg font-bold text-gray-700">Комментарий к заказу</div>
          <textarea wire:model="orderComment" name="comment" rows="2" class="resize-none field"></textarea>
        </div>

      </div>

    </div>

    <div class="block w-full space-y-6 md:w-4/12">

      <div class="p-6 space-y-3 text-sm bg-white rounded-2xl">
        <div wire:ignore class="text-base text-gray-500">Ваш заказ</div>
        @if ($items)
          <div class="w-full">
            @foreach ($items as $item)
              <div class="flex items-center justify-between space-y-2 border-b border-gray-200">

                <div class="p-2">
                  <img loading="lazy" class="object-cover object-center w-12"
                    src="{{ $item->associatedModel['image'] }}" alt="">
                </div>

                <div class="w-full">
                  <div class="___class_+?96___">
                    {{ $item->name }}
                  </div>

                  <div class="flex justify-between py-2 text-xs text-gray-500">
                    <div class="flex justify-start ">
                      <span class="___class_+?99___">
                        {{ $item->quantity }} шт
                      </span>
                    </div>

                    <div class="flex justify-end w-40">
                      @if ($item->associatedModel['promotion_type'] === 0)
                        <div class="flex items-center justify-end ">
                          <div class="font-bold">
                            {{ RUB($item->getPriceSum()) }}
                          </div>

                        </div>
                      @elseif ($item->associatedModel['promotion_type'] === 2)
                        <div class="flex items-center justify-end space-x-2 ">
                          <div class="text-xs line-through">
                            {{ RUB($item->getPriceSum()) }}
                          </div>
                          <div class="font-bold text-orange-500">
                            {{ RUB($item->getPriceSumWithConditions()) }}</div>
                        </div>
                      @elseif ($item->associatedModel['promotion_type'] === 3)

                        <div class="flex items-center justify-end space-x-2 ">
                          <div class="text-xs line-through">
                            {{ RUB(discountRevert($item->price, $item->associatedModel['promotion_percent'])) }}
                          </div>
                          <div class="font-bold text-orange-500">
                            {{ RUB($item->price) }}
                          </div>
                        </div>
                      @elseif ($item->associatedModel['promotion_type'] === 4)
                        <div class="flex items-center justify-end space-x-2 ">
                          <div class="text-xs line-through">
                            {{ RUB($item->getPriceSum()) }}
                          </div>
                          <div class="font-bold text-orange-500">
                            {{ RUB($item->getPriceSumWithConditions()) }}</div>
                        </div>
                      @endif
                    </div>

                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @endif

        @if ($shelterItems)
          <div class="px-6 -mx-6 bg-gray-100">
            <div class="py-2 font-semibold">"Помоги приюту"</div>
            @foreach ($shelterItems as $shelterItem)
              <div class="flex items-center justify-between space-y-2 border-b border-gray-200">

                <div class="p-2">
                  <img loading="lazy" class="object-cover object-center w-12"
                    src="{{ $shelterItem->associatedModel['image'] }}" alt="">
                </div>

                <div class="w-full">
                  <div class="___class_+?118___">
                    {{ $shelterItem->name }}
                  </div>

                  <div class="flex justify-between py-2 text-xs text-gray-500">
                    <div class="flex justify-start ">
                      <span class="___class_+?121___">
                        {{ $shelterItem->quantity }} шт
                      </span>
                    </div>

                    <div class="flex items-center justify-end space-x-2">
                      <div class="text-xs line-through">
                        {{ RUB($shelterItem->getPriceSum()) }}
                      </div>
                      <div class="font-bold text-orange-500">
                        {{ RUB($shelterItem->getPriceSumWithConditions()) }}</div>
                    </div>

                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @endif

        @if ($firstOrder !== 0)
          <div class="flex justify-between">
            <span>Скидка за первый заказ</span>
            <span>-{{ RUB($firstOrder) }}</span>
          </div>
        @endif

        @if ($userHasDiscountOnReview)
          <div class="flex justify-between">
            <span>Скидка за отзыв</span>
            <span>-2%</span>
          </div>
        @endif

        <div class="flex justify-between text-gray-700">
          <span>Всего</span>
          <span>{{ RUB($subTotal) }}</span>
        </div>
        @if ($orderType == 0)
          <div class="flex justify-between">
            <span>Доставка</span>
            <span>{{ RUB($deliveryCost) }}</span>
          </div>
        @else
          <div class="flex justify-between">
            <span>Самовывоз</span>
            <span>бесплатно</span>
          </div>
        @endif
        @if (count($shelterItems) > 0)
          <div class="flex justify-between">
            <span>Доставка в приют</span>
            <span>{{ RUB($deliveryCostToShelter) }}</span>
          </div>
        @endif



        <div class="flex justify-between pt-2 text-lg font-bold border-t">
          <span wire:ignore>Итого</span>
          <span>{{ RUB($totalAmount) }}</span>
        </div>
      </div>

      <div class="p-6 bg-white rounded-2xl">
        <div class="space-y-4 text-gray-700">

          @if ($orderType == 1 and $date)
            <div class="flex space-x-2 text-sm">
              <span class="w-full md:w-4/6">Самовывоз на</span>
              <span class="flex justify-end w-full font-bold md:w-8/6">{{ simpleDate($date) }}</span>
            </div>
          @endif
          @if ($orderType == 1 and $pickupStore)
            <div class="space-y-2 text-sm leading-tight">
              <span class="___class_+?137___">Самовывоз из магазина: </span>
              <span class="font-bold">{{ $pickupStore }}</span>
            </div>
          @endif
          @if ($orderType == 0 and $date)
            <div class="flex space-x-2 text-sm">
              <span class="w-full md:w-4/6">Доставка на</span> <span
                class="flex justify-end w-full font-bold md:w-8/6">
                {{ simpleDate($date) }}</span>
            </div>
          @endif
          @if ($orderType == 0 and $deliveryTime and $date)
            <div class="flex space-x-2 text-sm">
              <span class="w-full md:w-4/6">Время доставки</span>
              <span class="flex justify-end w-full font-bold md:w-8/6">{{ $deliveryTime }}</span>
            </div>
          @endif

          @if ($orderPaymentType == 1)
            <div class="flex space-x-2 text-sm">
              <span class="w-full md:w-3/6">Оплата</span>
              <span class="flex justify-end w-full font-bold md:w-9/6">наличными при получении</span>
            </div>
            @if ($needChange)
              <div class="flex space-x-2 text-sm">
                <span class="w-full md:w-4/6">Сдача с</span>
                <span class="flex justify-end w-full font-bold md:w-8/6">{{ $needChange }}<span
                    class="pl-1">₽</span></span>
              </div>
            @endif
          @else
            <div class="flex space-x-2 text-sm">
              <span class="w-full md:w-3/6">Оплата</span>
              <span class="flex justify-end w-full font-bold md:w-9/6">онлайн</span>
            </div>
          @endif

          <div class="space-y-2 text-sm">
            <div class="flex justify-between ">
              <span>Количество</span>
              <span>{{ $counter }} шт</span>
            </div>
            @if ($totalWeight)
              <div class="flex justify-between">
                <span>Вес заказа</span>
                <span>{{ kg($totalWeight) }}</span>
              </div>
            @endif
          </div>
        </div>
      </div>

      <div class="sticky top-5">
        <div class="block px-6 md:px-0">

          <button wire:click="createOrder"
            class="relative w-full px-5 py-5 font-semibold text-white bg-green-500 hover:bg-green-600 rounded-2xl disabled:opacity-50 disabled:cursor-not-allowed"
            wire:loading.attr="disabled">
            <div wire:loading wire:target="createOrder" class="absolute top-4 left-4">
              <svg class="w-5 h-5 mr-3 -ml-1 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
              </svg>
            </div>
            <div>
              Оформить заказ
            </div>
          </button>

          <div class="pt-4 text-xs text-gray-500">
            Нажимая кнопку "Оформить заказ", Вы соглашаетесь c <a class="leading-tight text-green-500"
              href="#">условиями
              политики конфиденциальности</a>.
          </div>
        </div>
      </div>
    </div>

  </div>