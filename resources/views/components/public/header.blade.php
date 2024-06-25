@php
  $isIndex = Route::currentRouteName() == 'index';
@endphp

<div class="navigation" style="z-index: 9999">
  <button aria-label="hamburguer" type="button" class="hamburger" id="position" onclick="show()">
    <!-- <div id="bar1" class="bar"></div>
      <div id="bar2" class="bar"></div>
      <div id="bar3" class="bar"></div> -->

    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M18 2L2 18M18 18L2 2" stroke="white" stroke-width="2.66667" stroke-linecap="round" />
    </svg>
  </button>
  <nav class="menu-list">
    <ul>
      <li>
        <a href="/"
          class="font-medium font-poppins text-[14px] py-1 px-3  hover:opacity-75  {{ $pagina == 'index' ? 'text-[#FF5E14]' : '' }}">Homero</a>
      </li>
      <li>
        <a href="{{ route('catalogo', 0) }}"
          class="font-medium font-poppins text-[14px] py-1 px-3  hover:opacity-75  {{ $pagina == 'catalogo' ? 'text-[#FF5E14]' : '' }}">Catálogo</a>
      </li>
      <li>
        <a href="{{ route('contacto') }}"
          class="font-medium font-poppins text-[14px] py-1 px-3  hover:opacity-75  {{ $pagina == 'contacto' ? 'text-[#FF5E14]' : '' }}">Contacto</a>
      </li>
      <li>
        <a href="{{ route('comentario') }}"
          class="font-medium font-poppins text-[14px] py-1 px-3  hover:opacity-75  {{ $pagina == 'comentario' ? 'text-[#FF5E14]' : '' }}">Comentar</a>
      </li>
    </ul>
  </nav>
</div>


<header>
  @foreach ($datosgenerales as $item)
    <div class="bg-[#272727]">
      <div class="flex justify-center md:justify-end gap-5 w-11/12 mx-auto py-4">
        <div class="text-white font-normal font-poppins text-[14px] text-center w-full">
          {{ $item->htop }}
        </div>
      </div>
    </div>
  @endforeach
  <div class="relative">
    <div class="relative">
      <div id="header-menu"
        class="z-1 {{ $isIndex ? 'absolute' : 'relative' }} top-0 flex justify-between items-center w-[100%] px-10 py-2 z-20">
        <div class="hidden md:block">
          <a href="{{ route('index') }}">
            <img id="logo-decotab"
              src="{{ asset($isIndex ? 'images/svg/logo_decotab_header_light.svg' : 'images/svg/logo_decotab_header.svg') }}"
              alt="decotab" />
          </a>

          <!--  <p class="font-medium text-[24px] font-poppins">DecoTab</p> -->
        </div>
        <div class="hidden md:block">
          <div>
            <nav id="menu-items" class="{{ $isIndex ? 'text-white' : 'text-[#272727]' }} flex gap-5">
              <a href="{{ route('index') }}"
                class="font-medium font-poppins text-[14px] py-1 px-3 hover:opacity-75  {{ $pagina == 'index' ? 'text-[#FF5E14]' : '' }}">Home
              </a>
              <a href="{{ route('catalogo', 0) }}"
                class="font-medium font-poppins text-[14px] hover:opacity-75 py-1 px-3  {{ $pagina == 'catalogo' ? 'text-[#FF5E14]' : '' }}">Catálogo
              </a>
              <a href="{{ route('contacto') }}"
                class="font-medium font-poppins py-1 px-3  text-[14px] hover:opacity-75 {{ $pagina == 'contacto' ? 'text-[#FF5E14]' : '' }}">Contacto
              </a>

              <a href="{{ route('comentario') }}"
                class="font-medium font-poppins py-1 px-3  text-[14px] hover:opacity-75 {{ $pagina == 'comentario' ? 'text-[#FF5E14]' : '' }}">Comentar
              </a>
            </nav>
          </div>
        </div>

        <div class="flex justify-end w-full md:w-auto md:justify-center items-center gap-5">
          @if (Auth::user() == null)
            <a href="{{ route('login') }}"><img src="{{ asset('images/svg/header_user.svg') }}" alt="user" /></a>
          @else
            <div class="relative inline-flex" x-data="{ open: false }">
              <button class="inline-flex justify-center items-center group" aria-haspopup="true"
                @click.prevent="open = !open" :aria-expanded="open">
                <div class="flex items-center truncate">
                  <span id="username"
                    class="truncate ml-2 text-sm font-medium dark:text-slate-300 group-hover:opacity-75 dark:group-hover:text-slate-200 {{ $isIndex ? 'text-white' : 'text-[#272727]' }}">{{ Auth::user()->name }}</span>
                  <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-slate-400" viewBox="0 0 12 12">
                    <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                  </svg>
                </div>
              </button>
              <div
                class="origin-top-right z-10 absolute top-full min-w-44 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 py-1.5 rounded shadow-lg overflow-hidden mt-1"
                @click.outside="open = false" @keydown.escape.window="open = false" x-show="open">
                <ul>
                  <li class="hover:bg-gray-100">
                    <a class="font-medium text-sm text-black flex items-center py-1 px-3" href="{{ route('pedidos') }}"
                      @click="open = false" @focus="open = true" @focusout="open = false">Mis pedidos</a>
                  </li>
                  <li class="hover:bg-gray-100">
                    <a class="font-medium text-sm text-black flex items-center py-1 px-3"
                      href="{{ route('direccion') }}" @click="open = false" @focus="open = true"
                      @focusout="open = false">Dirección</a>
                  </li>
                  <li class="hover:bg-gray-100">
                    <a class="font-medium text-sm text-black flex items-center py-1 px-3"
                      href="{{ route('micuenta') }}" @click="open = false" @focus="open = true"
                      @focusout="open = false">Ajustes</a>
                  </li>
                  <li class="hover:bg-gray-100">
                    <form method="POST" action="{{ route('logout') }}" x-data>
                      @csrf
                      <button type="submit" class="font-medium text-sm text-black flex items-center py-1 px-3"
                        href="{{ route('logout') }}" @click.prevent="$root.submit(); open = false">
                        {{ __('Cerrar sesión') }}
                      </button>
                    </form>
                  </li>
                </ul>
              </div>
            </div>
          @endif
          <div class="bg-[#EB5D2C] flex justify-center items-center rounded-full w-7 h-7">
            <span id="itemsCount" class="text-white"></span>
          </div>

          <div class="flex justify-center items-center pl-2">
            <label for="check" class="inline-block cursor-pointer">
              <img class="bg-white rounded-lg p-1" src="{{ asset('images/svg/header_bag.svg') }}" alt="bag"
                class="max-w-full h-auto cursor-pointer" id="openCarrito" />
            </label>
            <input type="checkbox" class="bag__modal" id="check" />
            <div
              class="bag hidden absolute top-0 right-0 z-[200] md:w-[450px] cartContainer border  shadow-2xl rounded-xl  ">
              <div class="p-4 flex flex-col h-screen justify-between">
                <div class="flex justify-between ">
                  <h2 class="font-medium text-[28px] text-[#151515] pb-5">
                    Carrito
                  </h2>
                  <div id="closeCarrito" class="cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                      stroke="currentColor" class="w-6 h-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>

                  </div>


                </div>

                <div>

                </div>
                <div class="overflow-y-scroll h-auto scroll__carrito">
                  <div class="flex flex-col gap-10" id="itemsCarrito">
                  </div>
                </div>

                <div class="font-poppins flex flex-col gap-2 pt-24">

                  <div class="text-[#141718] font-medium text-[20px] flex justify-between items-center">
                    <p>Total</p>
                    <p id="itemsTotal">S/ 0.00</p>
                  </div>
                  <div>
                    <a href="/carrito"
                      class="font-semibold text-base bg-[#74A68D] py-3 px-5 rounded-2xl text-white cursor-pointer w-full inline-block text-center">
                      Checkout
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="menu-burguer" class="absolute md:hidden top-1 left-[10px] z-10" style="z-index: 999">

      {{-- <button aria-label="hamburguer" class="hamburger" onclick="show()"> --}}
      <img class="h-10 cursor-pointer" src="{{ asset('images/img/menu_hamburguer.png') }}" alt="menu hamburguesa"
        onclick="show()" />
      {{-- </button> --}}

    </div>
  </div>
</header>
<script>
  function mostrarTotalItems() {
    let articulos = Local.get('carrito')
    let contarArticulos = articulos.reduce((total, articulo) => {
      return total + articulo.cantidad;
    }, 0);

    $('#itemsCount').text(contarArticulos)
  }
  $(document).ready(function() {
    if ({{ $isIndex }}) {
      $(window).scroll(function() {
        var scroll = $(window).scrollTop();
        var categoriasOffset = $('#categorias').offset().top;

        const headerMenu = $('#header-menu')
        const logo = $('#logo-decotab')
        const items = $('#menu-items')
        const username = $('#username')
        const burguer = $('#menu-burguer')
        if (scroll >= categoriasOffset) {
          headerMenu.removeClass('absolute bg-transparent text-white').addClass(
            'fixed top-0 bg-white shadow-lg');
          logo.attr('src', 'images/svg/logo_decotab_header.svg')
          items.removeClass('text-white').addClass('text-[#272727]')
          username.removeClass('text-white').addClass('text-[#272727]')
          burguer.removeClass('absolute').addClass('fixed')
          $('#header-menu svg').attr('stroke', '#272727');
        } else {
          headerMenu.removeClass('fixed bg-white shadow-lg').addClass('absolute bg-transparent text-white');
          logo.attr('src', 'images/svg/logo_decotab_header_light.svg')
          items.removeClass('text-[#272727]').addClass('text-white')
          username.removeClass('text-[#272727]').addClass('text-white')
          burguer.removeClass('fixed').addClass('absolute')
          $('#header-menu svg').attr('stroke', 'white');
        }
      });
    }
    mostrarTotalItems()
  })
</script>
<script src="{{ asset('js/storage.extend.js') }}"></script>
