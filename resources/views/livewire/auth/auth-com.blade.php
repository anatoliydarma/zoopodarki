<div x-cloak x-data="login"
  x-init="$watch('phone', value => validatePhone()), $watch('enteredOtp', value => checkUser())"
  x-on:auth.window="open()" class="{{ $currentUrl !== 'checkout' ? 'fixed z-40' : '' }}">

  @if ($currentUrl !== 'checkout')
    <div x-show="openAuthModal" x-transition.opacity
      class="fixed left-0 z-40 flex items-center justify-center w-screen h-full min-h-screen bg-gray-500 bg-opacity-50"
      role="dialog" aria-modal="true">
      <div x-on:click.outside="close()" @keydown.window.escape="openAuthModal = false"
        class="absolute z-50 flex flex-col justify-center bg-white shadow-xl rounded-2xl w-80">
  @endif

  <div class="max-w-xs">

    <div class="flex items-center justify-between px-5 py-3">
      <div>
        <button x-show="windowType === 'otp'" x-on:click="windowType = 'phone'" class="link-hover">
          <x-tabler-arrow-left class="w-6 h-6 text-gray-500 stroke-current" />
        </button>
        <button x-show="windowType === 'email'" x-on:click="windowType = 'phone'" class="link-hover">
          <x-tabler-arrow-left class="w-6 h-6 text-gray-500 stroke-current" />
        </button>
      </div>
      <div>
        @if ($currentUrl !== 'checkout')
          <button x-on:click="close()" class="link-hover">
            <x-tabler-x class="w-6 h-6 text-gray-500 stroke-current" />
          </button>
        @endif
      </div>
    </div>

    <div :class="windowType === 'phone' ? 'block' : 'hidden'">

      <div class="px-6 pb-6">
        <h2 class="pb-4 text-xl font-bold leading-tight text-center text-gray-700">
          Вход или регистрация
        </h2>
        <div class="block space-y-6">
          <div>
            <label for="phone" class="block mb-2 text-sm font-bold text-gray-700">
              Телефон
            </label>
            <div class="relative text-lg">

              <div class="absolute top-0 left-0 z-30 pt-3 pl-3 cursor-default">
                <div class="w-6 h-6 mx-auto text-gray-400 fill-current">
                  +7
                </div>
              </div>
              <input x-model="formatedPhone" x-bind:oninput="validatePhone()" wire:model.defer="phone" id="phone"
                type="text" name="phone" required inputmode="tel"
                class="w-full px-4 py-3 pl-10 font-semibold border border-gray-200 bg-gray-50 rounded-2xl focus:outline-none focus:ring focus:bg-white">
            </div>
            @error('phone')
              <p class="mt-2 text-xs italic text-red-500">
                {{ $message }}
              </p>
            @enderror
          </div>

          <div class="space-y-4">
            <button x-bind:disabled="valid === false" x-on:click="createOtp(), $nextTick(() => {
              setTimeout(() => {
                  document.getElementById('otp').focus();
              }, 300);
          })"
              class="flex items-center justify-center w-full py-4 font-bold text-white bg-green-500 border-green-500 rounded-2xl md:text-left hover:bg-green-600 hover:border-green-600">
              <span>Войти</span>
            </button>

            <div class="flex items-center justify-start space-x-2 ">
              <input wire:model.defer="subscribed" id="subscribed" aria-describedby="subscribed" type="checkbox"
                class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-orange-300">
              <label for="subscribed" class="text-sm text-gray-500">Подписаться на рассылку
                акций</label>
            </div>
          </div>
        </div>
      </div>

      <div class="px-4 pt-4 text-center border-t">
        <div x-on:click="windowType = 'email', $nextTick(() => {
          setTimeout(() => {
              document.getElementById('email').focus();
          }, 300);
      })" class="text-sm text-orange-500 cursor-pointer hover:text-orange-600">Вход по почте</div>
      </div>
      <div class="p-4 text-xs text-center text-gray-400">
        При входе или регистрации вы соглашаетесь с <a class="leading-tight text-green-500" href="/page/privacy-policy"
          target="_blank">условиями
          политики конфиденциальности</a>.
      </div>

    </div>

    <div :class="windowType === 'otp' ? 'block' : 'hidden'">
      <div class="px-6 pb-6">
        <div class="pb-4">

          <h2 class="pb-4 text-xl font-bold leading-tight text-center text-gray-700">
            Введите OTP
          </h2>

          <div class="leading-tight tetx-xs">
            Пожалуйста, введите 5-значный проверочный код, который мы отправили вам по SMS
          </div>

        </div>

        <div class="block space-y-6">

          <div>
            <div class="text-lg">
              <input x-model="enteredOtp" id="otp" type="number" name="otp" required min="5" max="5"
                autocomplete="one-time-code" inputmode="numeric"
                class="w-full px-4 py-3 font-semibold text-center border border-gray-200 bg-gray-50 rounded-2xl focus:outline-none focus:ring focus:bg-white">
            </div>
            @error('otp')
              <p class="mt-2 text-xs italic text-red-500">
                {{ $message }}
              </p>
            @enderror
          </div>

          <div>
            <button type="button" x-on:click="checkUser()"
              class="flex items-center justify-center w-full py-4 font-bold text-white bg-green-500 border-green-500 rounded-2xl md:text-left hover:bg-green-600 hover:border-green-600">
              <span>Отправить</span>
            </button>
          </div>

        </div>
      </div>
      <div class="p-4 text-center border-t">
        <div wire:click="createOtp" class="text-sm text-orange-500 cursor-pointer hover:text-orange-600">
          Не пришло? (Отправить еще раз)</div>
      </div>
    </div>

    <div :class="windowType === 'email' ? 'block' : 'hidden'">
      <div class="px-6 pt-3 pb-4">
        <h2 class="pb-4 text-xl font-bold leading-tight text-center text-gray-700">
          Вход
        </h2>
        <div class="block space-y-4">

          <div>
            <label for="email" class="block mb-2 text-sm font-bold text-gray-700">
              Электронная почта
            </label>
            <div class="relative text-lg">
              <div class="absolute top-0 left-0 z-30 pt-4 pl-3 cursor-default">
                <x-tabler-mail class="w-5 h-5 text-gray-400 stroke-current" />
              </div>
              <input wire:model.defer="email" id="email" type="email" name="email" autocomplete="email"
                inputmode="email"
                class="w-full px-4 py-3 pl-10 font-semibold border border-gray-200 bg-gray-50 rounded-2xl focus:outline-none focus:ring focus:bg-white">
            </div>
            @error('email')
              <p class="mt-2 text-xs italic text-red-500">
                {{ $message }}
              </p>
            @enderror
          </div>

          <div>
            <label for="password" class="block mb-2 text-sm font-bold text-gray-700">
              Пароль
            </label>
            <div class="relative text-base">
              <div class="absolute top-0 left-0 z-30 pt-4 pl-3 cursor-default">
                <x-tabler-lock class="w-5 h-5 text-gray-400 stroke-current" />
              </div>
              <input wire:model.defer="password" id="password" type="password" name="password"
                autocomplete="new-password"
                class="w-full px-4 py-3 pl-10 font-semibold border border-gray-200 bg-gray-50 rounded-2xl focus:outline-none focus:ring focus:bg-white">
            </div>
            @error('password')
              <p class="mt-2 text-xs italic text-red-500">
                {{ $message }}
              </p>
            @enderror
          </div>

          <div class="pt-2 space-y-4">
            <button wire:click="loginByEmail"
              class="flex items-center justify-center w-full py-4 font-bold text-white bg-green-500 border-green-500 rounded-2xl md:text-left hover:bg-green-600 hover:border-green-600">
              <span>Войти</span>
            </button>

            <a href="/password/reset"
              class="block text-sm text-center text-orange-500 cursor-pointer hover:text-orange-600">Забыли
              пароль?</a>
          </div>

        </div>
      </div>
      <div class="px-4 py-4 text-center border-t">
        <div x-on:click="windowType = 'phone'" class="text-sm text-orange-500 cursor-pointer hover:text-orange-600">Вход
          или
          регистрация по СМС</div>
      </div>
    </div>

  </div>

  @if ($currentUrl !== 'checkout')
</div>
</div>

@endif

<script>
  document.addEventListener('alpine:initializing', () => {
    Alpine.data('login', () => ({
      body: document.body,
      openAuthModal: false,
      formatedPhone: null,
      phone: null,
      valid: false,
      windowType: 'phone', // phone, otp, email
      enteredOtp: null,
      open() {
        this.openAuthModal = true
        this.enteredOtp = null
        this.windowType = 'phone'
        this.valid = false
        this.body.classList.add('overflow-hidden', 'pr-4');

      },
      close() {
        this.openAuthModal = false
        this.body.classList.remove('overflow-hidden', 'pr-4');
      },

      validatePhone() {
        if (this.formatedPhone !== null) {

          if (this.formatedPhone.length > 12) {
            this.formatedPhone = this.formatedPhone.replace(/.$/g, '').trim()
            return
          }

          str = this.formatedPhone
            .replace(/\D/g, '')
            .match(/^(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})$/)

          this.formatedPhone =
            `${str[1]}${str[2] ? `-${str[2]}` : ''}${str[3] ? `-${str[3]}` : ''}${str[4] ? `${str[4]}` : ''}`

          this.phone = this.formatedPhone.replace(/[^\w\s]/gi, '');

          if (this.phone.length === 10) {
            this.valid = true;
          } else {
            this.valid = false;
          }
        }
      },

      createOtp() {
        window.livewire.emit('createOtp', this.phone);
        this.windowType = 'otp';
      },

      checkUser() {
        if (this.enteredOtp.length > 5) {
          this.enteredOtp = this.enteredOtp.slice(0, 5);
        }

        if (this.enteredOtp.length === 5) {
          window.livewire.emit('checkUser', this.enteredOtp);
        }
      }
    }))
  })

  window.addEventListener('reloadPage', event => {
    location.reload();
  })
</script>
</div>
