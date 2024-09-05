@extends('components.public.matrix', ['pagina' => 'catalogo'])

@section('css_importados')

@stop



@section('content')
  <?php
  // Definición de la función capitalizeFirstLetter()
  // function capitalizeFirstLetter($string)
  // {
  //     return ucfirst($string);
  // }
  ?>

  <style>
    .swiper-pagination-bullet-active {
      background-color: #272727;
    }

    .swiper-pagination-bullet:not(.swiper-pagination-bullet-active) {
      background-color: #979693 !important;
    }

    .blocker {
      z-index: 20;
    }
  </style>
  @php
    $images = ['', '_ambiente'];
    $x = $product->toArray();
    $i = 1;
  @endphp
  <main class="font-poppins" id="mainSection">
    @csrf
    <section class="py-8 bg-white md:py-16 dark:bg-gray-900 antialiased">
      <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0">
        <div class="relative lg:grid lg:grid-cols-2 lg:gap-8 xl:gap-16">

          <div class="hidden md:block w-full shrink-0 max-w-md lg:max-w-lg mx-auto ">
            <div class="grid grid-cols-2 gap-4">
              @foreach ($images as $key)
                @if ($x['imagen' . $key] == null)
                  @continue
                @else
                  <div id="product-detail-image" data-slider="{{ $i }}">
                    <img class="h-[360px] w-full rounded-lg object-cover object-center bg-[#f2f2f2] border cursor-pointer"
                      src="{{ asset($x['imagen' . $key]) }}" alt="">
                  </div>
                  @php
                    $i++;
                  @endphp
                @endif
              @endforeach
              @foreach ($galery as $x)
                <div id="product-detail-image" data-slider="{{ $i }}">
                  <img class="h-[360px] w-full rounded-lg object-cover object-center bg-[#f2f2f2] border cursor-pointer"
                    src="{{ asset($x->imagen) }}" alt="{{ $product->producto }}" alt="">
                </div>
                @php
                  $i++;
                @endphp
              @endforeach
            </div>

          </div>
          <div class="relative md:hidden w-full shrink-0 max-w-md lg:max-w-lg mx-auto">
            <div id="product-swiper" style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff"
              class="swiper product-prev mb-6 h-[520px]">
              <div class="swiper-wrapper">
                @foreach ($images as $key)
                  @if ($x['imagen' . $key] == null)
                    @continue
                  @else
                    <div class="swiper-slide h-[520px]">
                      <img src="{{ asset($x['imagen' . $key]) }}" alt="{{ $product->producto }}"
                        class="mx-auto w-full h-full object-cover object-center bg-[#f2f2f2]">
                    </div>
                  @endif
                @endforeach
                @foreach ($galery as $x)
                  <div class="swiper-slide h-[520px]">
                    <img src="{{ asset($x->imagen) }}" alt="{{ $product->producto }}"
                      class="mx-auto w-full h-full object-cover object-center bg-[#f2f2f2]">
                  </div>
                @endforeach
              </div>
              <div
                class="swiper-pagination bg-[rgba(255,255,255,.7)] backdrop-blur-md rounded-full !w-max px-2 !left-[50%] !-translate-x-[50%]">
              </div>

            </div>
          </div>

          <div class="mt-6 sm:mt-8 lg:mt-0 sticky top-4 h-max">
            <p class="text-lg font-medium leading-8 text-indigo-600 mb-4">
              @php
                $productCategory = $product->categoria();
              @endphp
              <a href="/catalogo/{{ $productCategory->slug }}">{{ $productCategory->name }}</a>
              @if ($product->subcategory_id)
                @php
                  $productSubcategory = $product->subcategory();
                @endphp
                / <a
                  href="/catalogo/{{ $productCategory->slug }}/{{ $productSubcategory->slug }}">{{ $productSubcategory->name }}</a>
              @endif
            </p>
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white mb-2">
              {{ $product->producto }}
              @if ($product->color)
                - {{ $product->color }}
              @endif
            </h1>
            <div>
              <p class="mb-6 text-gray-500 dark:text-gray-400">{{ $product->extract }}</p>
            </div>
            <div class="mt-4 sm:items-center sm:gap-4 sm:flex">
              <p id='infodescuento' class="text-2xl font-extrabold text-gray-900 sm:text-3xl dark:text-white">
                @if ($product->descuento > 0)
                  S/. {{ $product->descuento }}
                  <span id='infoPrecio'
                    class="ms-2 line-through font-medium text-[20px] text-[#6C7275]">{{ $product->precio }}</span>
                @else
                  S/. {{ $product->precio }}
                @endif
              </p>
            </div>

            <table class="mt-4 w-full text-left mb-4">

              <body>
                @foreach ($especificaciones as $item)
                  <tr class="bg-white border-b border-t dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="w-0 px-2 py-1.5 font-bold text-gray-900 whitespace-nowrap dark:text-white">
                      {{ $capitalizeFirstLetter($item->tittle) }}:
                    </th>
                    <td class="px-2 py-1.5">
                      {{ $capitalizeFirstLetter($item->specifications) }}
                    </td>
                  </tr>
                @endforeach
              </body>
            </table>

            @if ($product->attributes->isNotEmpty())
              @foreach ($product->attributes->unique() as $atributo)
                <div class="block w-full">
                  <p class="font-medium text-lg leading-8 text-gray-900 mb-4">{{ $atributo->titulo }}</p>
                  <div class="text">
                    <div class="flex items-center justify-start gap-3 md:gap-6 relative mb-6 ">
                      @php
                        $attributeValues = $atributo->attributeValues->whereIn(
                            'id',
                            $product->attributes->pluck('pivot.attribute_value_id'),
                        );
                      @endphp

                      @foreach ($attributeValues as $valor)
                        <button data-ui="checked active"
                          class="p-2.5 border border-gray-200 rounded-full transition-all duration-300 hover:border-[{{ $valor->color }}33]">
                          <svg width="20" height="20" viewBox="0 0 40 40" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="20" cy="20" r="20" fill="{{ $valor->color }}" />
                          </svg>
                        </button>
                      @endforeach
                    </div>
                  </div>
                </div>
              @endforeach
            @endif

            @if ($otherProducts->isNotEmpty())
              <p class="mb-2"><b>Color</b>: {{ $product->color }}</p>
              <div class="flex flex-wrap gap-1">
                @foreach ($otherProducts as $x)
                  <a class="block" href="/producto/{{ $x->id }}" title="{{ $x->color }}" tippy>
                    <img class="w-16 h-6 shadow-sm border object-cover object-center rounded-sm"
                      src="{{ $x->image_texture ? asset($x->image_texture) : asset('images/img/cromo.jpeg') }}"
                      alt="{{ $x->producto }}">
                  </a>
                @endforeach
              </div>
            @endif

            <div class="mt-6 sm:gap-4 items-center sm:flex sm:mt-8">
              <div class="flex mb-4">
                <div class="flex justify-center items-center bg-[#F5F5F5] cursor-pointer hover:bg-slate-300">
                  <button class="py-2.5 px-5 text-lg font-semibold" id=disminuir type="button">-</button>
                </div>
                <div id=cantidadSpan
                  class="py-2.5 px-5 flex justify-center items-center bg-[#F5F5F5] text-lg font-semibold">
                  <span>1</span>
                </div>
                <div class="flex justify-center items-center bg-[#F5F5F5] cursor-pointer hover:bg-slate-300">
                  <button class="py-2.5 px-5 text-lg font-semibold" id=aumentar type="button">+</button>
                </div>
              </div>

              <button id="btnAgregarCarrito"
                class="mb-4 group py-2.5 px-5 rounded-full bg-indigo-50 text-indigo-600 font-semibold text-lg flex items-center justify-center gap-2 shadow-sm shadow-transparent transition-all duration-500 hover:bg-indigo-100 hover:shadow-indigo-200">
                <svg class="stroke-indigo-600 transition-all duration-500" width="22" height="22"
                  viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M10.7394 17.875C10.7394 18.6344 10.1062 19.25 9.32511 19.25C8.54402 19.25 7.91083 18.6344 7.91083 17.875M16.3965 17.875C16.3965 18.6344 15.7633 19.25 14.9823 19.25C14.2012 19.25 13.568 18.6344 13.568 17.875M4.1394 5.5L5.46568 12.5908C5.73339 14.0221 5.86724 14.7377 6.37649 15.1605C6.88573 15.5833 7.61377 15.5833 9.06984 15.5833H15.2379C16.6941 15.5833 17.4222 15.5833 17.9314 15.1605C18.4407 14.7376 18.5745 14.0219 18.8421 12.5906L19.3564 9.84059C19.7324 7.82973 19.9203 6.8243 19.3705 6.16215C18.8207 5.5 17.7979 5.5 15.7522 5.5H4.1394ZM4.1394 5.5L3.66797 2.75"
                    stroke="" stroke-width="1.6" stroke-linecap="round" />
                </svg>
                Agregar al carrito
              </button>
            </div>

            <hr class="my-6 md:my-8 border-gray-200 dark:border-gray-800" />

            <div class=" text-gray-500 dark:text-gray-400">
              {!! $product->description !!}
            </div>
          </div>
        </div>
      </div>
    </section>

    {{-- <section class="w-11/12 mx-auto flex flex-col md:flex-row gap-10">
      @csrf
      <div class="basis-1/2">
        <!-- grilla de productos -->
        <div class="hidden md:block">
          @php
            $cantidadGaleria = count($productosConGalerias);
          @endphp

          @if ($cantidadGaleria == 0)
            <div class="grid grid-cols-1 gap-10">
              <div class="flex flex-col items-start bg-[#F3F5F7]  rounded-2xl">
                <div class="bg-[#38CB89] rounded-md px-5 py-1 mt-[1%] ml-[1%] absolute">
                  <p class="text-white font-semibold text-[12px]">-30%</p>
                </div>

                <div class="flex justify-center w-full">

                  @if ($product->imagen)
                    <img src="{{ asset($product->imagen) }}" alt="{{ $product->name }}"
                      class="w-full  object-contain " />
                  @else
                    <img src="{{ asset('images/img/noimagen.jpg') }}" alt="imagen_alternativa"
                      class="w-full  object-contain " />
                  @endif

                </div>
              </div>
              @foreach ($productosConGalerias as $galeria)
                <div class="flex justify-center items-center rounded-2xl object-cover bg-cover"
                  style="background-image: url('{{ asset($galeria->imagen) }}')">
                  <img src="{{ asset($galeria->imagen) }}" alt="piso_flotante_laminado_2"
                    class="w-full object-cover bg-cover rounded-2xl" />
                </div>
              @endforeach


            </div>
          @else
            <div class="grid grid-cols-2 gap-10">
              <div class="flex flex-col items-start bg-[#F3F5F7]  rounded-2xl">
                <div class="bg-[#38CB89] rounded-md px-5 py-1 mt-[1%] ml-[1%] absolute">
                  <p class="text-white font-semibold text-[12px]">-30%</p>
                </div>

                <div class="flex justify-center w-full">

                  @if ($product->imagen)
                    <img src="{{ asset($product->imagen) }}" alt="{{ $product->name }}"
                      class="w-full  object-contain " />
                  @else
                    <img src="{{ asset('images/img/noimagen.jpg') }}" alt="imagen_alternativa"
                      class="w-full  object-contain " />
                  @endif

                </div>
              </div>
              @foreach ($productosConGalerias as $galeria)
                <div class="flex justify-center items-center rounded-2xl object-cover bg-cover"
                  style="background-image: url('{{ asset($galeria->imagen) }}')">
                  <img src="{{ asset($galeria->imagen) }}" alt="piso_flotante_laminado_2"
                    class="w-full object-cover bg-cover rounded-2xl" />
                </div>
              @endforeach


            </div>
          @endif
        </div>

        <!-- carrusel de productos -->
        <div class="block md:hidden">
          <div class="swiper producto-slider">
            <div class="swiper-wrapper swiper-wrapper-height">

              <div class="swiper-slide swiper-slide-flex rounded-2xl">
                <div class="flex flex-col items-start bg-[#F3F5F7] gap-12 relative">
                  <div class="bg-[#38CB89] rounded-md px-5 py-1 mt-10 ml-10 absolute">
                    <p class="text-white font-semibold text-[12px]">-30%</p>
                  </div>

                  <div class="flex justify-center w-full">
                    @if ($product->imagen)
                      <img src="{{ asset($product->imagen) }}" alt="{{ $product->name }}"
                        class="w-full  object-contain " />
                    @else
                      <img src="{{ asset('images/img/noimagen.jpg') }}" alt="imagen_alternativa"
                        class="w-full  object-contain " />
                    @endif
                  </div>
                </div>
              </div>
              @foreach ($productosConGalerias as $galeria)
                <div class="swiper-slide">
                  <div class="flex justify-center items-center">
                    <img src="{{ asset($galeria->imagen) }}" alt="{{ asset($galeria->imagen) }}" />
                  </div>
                </div>
              @endforeach



            </div>
            <div class="swiper-pagination-productos mt-10"></div>
          </div>
        </div>
      </div>
      <div class="basis-1/2 font-poppins flex flex-col gap-5">
        <div class="border-b-[1px] border-gray-300 flex flex-col gap-5">
          <h2 class="font-medium text-[40px] leading-none md:leading-tight">
            {{ $product->producto }}
          </h2>
          <p class="font-normal text-[16px]">
            {{ $product->extract }}
          </p>
          @if ($product->descuento > 0)
            <!-- validamos si tiene descuento  -->
            <p id='infodescuento' class="font-medium text-[28px] mb-5">
              s/ {{ $product->descuento }}
              <span id='infoPrecio'
                class="line-through font-medium text-[20px] text-[#6C7275]">{{ $product->precio }}</span>
            </p>
          @else
            <p id='nodescuento' class="font-medium text-[28px] mb-5">
              s/ {{ $product->precio }}

            </p>
          @endif

        </div>
        <div class="border-b-[1px] border-gray-300 flex flex-col gap-5">
          <div class="flex flex-col gap-5">
            <table class="border-collapse w-full">
              <tbody>
                @foreach ($especificaciones as $item)
                  <tr>
                    <td class="border w-1/5 border-gray-400 px-3 py-2 font-semibold text-[16px] text-gray-900">
                      {{ $capitalizeFirstLetter($item->tittle) }}:</td>
                    <td class="border w-4/5 border-gray-400 px-3 py-2 font-normal text-[15px]">
                      {{ $capitalizeFirstLetter($item->specifications) }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>


            <div class="flex flex-col gap-5 mt-3">
              <div class="md:col-span-5">

                <div class="flex gap-2 mt-2 relative mb-2 ">
                  @if ($product->attributes->isNotEmpty())
                    @foreach ($product->attributes->unique() as $atributo)
                      <div>

                        @if ($atributo->type === 'Circulos')
                          <p class="font-mediumDisplay text-text16 md:text-text20 pb-4">
                            Gama de colores:
                          </p>

                          <div class="flex gap-5 justify-start items-center">
                            @php
                              $attributeValues = $atributo->attributeValues->whereIn(
                                  'id',
                                  $product->attributes->pluck('pivot.attribute_value_id'),
                              );
                            @endphp

                            @foreach ($attributeValues as $valor)
                              <div style="background-color: {{ $valor->color }}"
                                class="colors w-12 h-12 rounded-[50%] transition">
                              </div>
                            @endforeach
                          </div>
                        @endif
                      </div>
                    @endforeach
                  @endif
                </div>
              </div>
            </div>


            <div class="flex">
              <div class="w-14 h-14 flex justify-center items-center bg-[#F5F5F5] cursor-pointer hover:bg-slate-300">
                <button id=disminuir type="button"><span class="text-[30px]">-</span></button>
              </div>
              <div id=cantidadSpan class="w-14 h-14 flex justify-center items-center bg-[#F5F5F5]">
                <span class="text-[20px]">1</span>
              </div>
              <div class="w-14 h-14 flex justify-center items-center bg-[#F5F5F5] cursor-pointer hover:bg-slate-300">
                <button id=aumentar type="button"><span class="text-[30px]">+</span></button>
              </div>
            </div>
          </div>

        </div>
        <div class="my-5 flex flex-col gap-5  border-b-[1px] border-gray-300 pb-5">
          <div class="py-2 w-full">


            <button type="button" id='btnAgregarCarrito'
              class="text-white bg-[#74A68D] w-full py-4 rounded-3xl cursor-pointer font-semibold text-[16px] inline-block text-center hover:bg-green-950">
              Agregar al carrito
            </button>

          </div>

          <div class="py-2 w-full">
            <a href="#"
              class="text-[#74A68D] bg-white w-full py-4 rounded-3xl cursor-pointer border-[1px] border-black font-semibold text-[16px] inline-block text-center hover:bg-slate-300">Comprar</a>
          </div>
        </div>
        <div class="flex flex-col">
          <div class="flex">
            <p class="font-normal text-[12px] text-[#6C7275] flex-initial w-44">
              Sku
            </p>
            <p class="font-normal text-[12px] text-[#141718]"> </p>
          </div>

          <div class="flex">
            <p class="font-normal text-[12px] text-[#6C7275] flex-initial w-44">
              Categoría
            </p>
            <p class="font-normal text-[12px] text-[#141718]">
              @if ($product->categoria->name)
                {{ $product->categoria->name }}
              @else
                S/C
              @endif
            </p>
          </div>
        </div>
      </div>
    </section> --}}

    {{-- <section class="font-poppins flex w-11/12 mx-auto my-10">
      <div class="md:basis-1/2">
        <h2 class="font-medium text-[28px] my-5 leading-none md:leading-tight">
          Información adicional
        </h2>
        <div class="flex flex-col gap-5">
          {!! $product->description !!}
        </div>
      </div>
    </section> --}}

    <section class="font-poppins">
      <div class="grid grid-cols-1 gap-12 md:gap-0 md:grid-cols-4 grid-rows-1 pt-12 w-11/12 mx-auto">
        <div class="col-span-1 md:col-span-3 order-1 md:order-1 flex flex-col gap-2">
          <h2 class="font-medium text-[36px] md:text-[40px] mt-2 leading-none md:leading-tight">
            Productos complementarios
          </h2>

          <p class="font-normal text-lg basis-3/6">
            Revisa nuestros productos complementarios y sorpréndete con su calidad. ¡Encontrarás lo mejor en
            Wall Panel en el mercado!
          </p>
        </div>

        <div class="col-span-1 md:col-span-1 order-3 md:order-2 flex justify-center items-center w-full">
          <a href="catalogo.html"
            class="font-semibold text-[16px] bg-transparent md:duration-500 py-4 px-5 rounded-3xl border-[1px] border-colorBorder flex-initial w-full md:w-56 text-center inline-block">
            Ver todo
          </a>
        </div>

        <div class="col-span-1 md:col-span-4 order-2 md:order-3">
          <!-- ---- CARRUSEL --- -->
          <div>
            {{-- <div class="swiper productos-destacados my-5">
              <div class="swiper-pagination-productos-destacados mb-80 md:mb-32"></div>
              <div class="swiper-wrapper mt-[80px]">

                @foreach ($ProdComplementarios as $item)
                  <div class="swiper-slide rounded-2xl">
                    <div class="flex flex-col relative">
                      <div
                        class="bg-[#f2f2f2] rounded-2xl pt-12 pb-5 md:pb-8 product_container basis-4/5 flex flex-col justify-center relative">
                        <div class="px-4">
                          <a
                            class="font-semibold text-[8px] md:text-[12px] bg-[#EB5D2C] py-2 px-2 flex-initial w-24 text-center text-white rounded-[5px] absolute top-[18px] z-10">
                            Nuevo
                          </a>
                        </div>
                        <div>
                          <div class="relative flex justify-center items-center">
                            @if ($item->imagen)
                              <img src="{{ asset($item->imagen) }}" alt="{{ $item->name }}"
                                class="w-full h-30 object-contain" />
                            @else
                              <img src="{{ asset('images/img/noimagen.jpg') }}" alt="imagen_alternativa"
                                class="w-full h-30 object-contain" />
                            @endif
                          </div>

                          <!-- ------ -->
                          <div class="addProduct text-center flex justify-center">
                            <a href="{{ route('producto', $item->id) }}"
                              class="font-semibold text-[9px] md:text-[16px] bg-[#74A68D] py-3 px-5 flex-initial w-32 md:w-56 text-center text-white rounded-3xl">
                              Ver producto
                            </a>
                          </div>
                        </div>
                      </div>
                      <div class="my-2 flex flex-col items-start gap-2 basis-1/5 px-2">
                        <div class="flex items-center gap-2">
                          <div class="flex gap-2 py-2">
                            <img src="./images/svg/start.svg" alt="estrella" />
                            <img src="./images/svg/start.svg" alt="estrella" />
                            <img src="./images/svg/start.svg" alt="estrella" />
                            <img src="./images/svg/start_sin_color.svg" alt="estrella" />
                            <img src="./images/svg/start_sin_color.svg" alt="estrella" />
                          </div>
                          <p class="font-semibold text-[14px] text-[#6C7275]">
                            (35)
                          </p>
                        </div>
                        <h2 class="font-semibold text-[16px] text-[#141718]">
                          {{ $item->producto }}
                        </h2>
                        <p class="font-semibold text-[14px] text-[#121212] flex gap-5">
                          @if ($item->descuento == 0)
                            <span>{{ $item->precio }}</span>
                          @else
                            <span>{{ $item->descuento }}</span>
                            <span class="font-normal text-[14px] text-[#6C7275] line-through">{{ $item->precio }}</span>
                          @endif



                        </p>
                      </div>
                    </div>
                  </div>
                @endforeach

              </div>
              <!-- <div class="swiper-pagination-productos-destacados"></div>  -->
            </div> --}}
            <div class="productos-home swiper my-5 mt-16">
              <div class="swiper-wrapper mt-2 mb-4">
                @foreach ($ProdComplementarios as $item)
                  <div class="swiper-slide rounded-2xl">
                    <x-product.container :item="$item" />
                  </div>
                @endforeach
              </div>
              <div class="swiper-scrollbar-productos-home h-2"></div>
              <div class="mt-4 text-end">
                <button type="button"
                  class="swiper-button-prev-productos-home text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-full text-sm px-4 py-2 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 ">
                  ←
                </button>
                <button type="button"
                  class="swiper-button-next-productos-home text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-full text-sm px-4 py-2 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 ">
                  →
                </button>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
  </main>

  @php
    $images = ['', '_ambiente'];
    $x = $product->toArray();
  @endphp

  <div id="product-swiper-modal" style="--swiper-navigation-color: #000; --swiper-pagination-color: #fff; display:none"
    class="modal hidden swiper product-prev mb-6 !max-w-full h-full">
    <div class="swiper-wrapper">
      @foreach ($images as $key)
        @if ($x['imagen' . $key] == null)
          @continue
        @else
          <div class="swiper-slide !w-full h-full">
            <img src="{{ asset($x['imagen' . $key]) }}" alt="{{ $product->producto }}"
              class="mx-auto w-full h-full object-contain object-center bg-black">
          </div>
        @endif
      @endforeach
      @foreach ($galery as $x)
        <div class="swiper-slide !w-full h-full">
          <img src="{{ asset($x->imagen) }}" alt="{{ $product->producto }}"
            class="mx-auto w-full h-full object-contain object-center bg-black">
        </div>
      @endforeach
    </div>
    <div
      class="swiper-pagination bg-[rgba(255,255,255,.7)] backdrop-blur-md rounded-full !w-max px-2 !left-[50%] !-translate-x-[50%]">
    </div>

  </div>



  <script src="{{ asset('js/storage.extend.js') }}"></script>

@section('scripts_importados')

  <script>
    // $(document).ready(function() {


    function capitalizeFirstLetter(string) {
      string = string.toLowerCase()
      return string.charAt(0).toUpperCase() + string.slice(1);
    }
    // })
    $('#disminuir').on('click', function() {
      let cantidad = Number($('#cantidadSpan span').text())
      if (cantidad > 0) {
        cantidad--
        $('#cantidadSpan span').text(cantidad)
      }


    })
    // cantidadSpan
    $('#aumentar').on('click', function() {
      let cantidad = Number($('#cantidadSpan span').text())
      cantidad++
      $('#cantidadSpan span').text(cantidad)

    })
  </script>
  <script>
    let articulosCarrito = [];


    function deleteOnCarBtn(id, operacion) {
      const prodRepetido = articulosCarrito.map(item => {
        if (item.id === id && item.cantidad > 0) {
          item.cantidad -= Number(1);
          return item; // retorna el objeto actualizado 
        } else {
          return item; // retorna los objetos que no son duplicados 
        }

      });
      Local.set('carrito', articulosCarrito)
      limpiarHTML()
      PintarCarrito()


    }

    function calcularTotal() {
      let articulos = Local.get('carrito')
      let total = articulos.map(item => {
        let monto
        if (Number(item.descuento) !== 0) {
          monto = item.cantidad * Number(item.descuento)
        } else {
          monto = item.cantidad * Number(item.precio)

        }
        return monto

      })
      const suma = total.reduce((total, elemento) => total + elemento, 0);

      $('#itemsTotal').text(`S/. ${suma} `)

    }

    function addOnCarBtn(id, operacion) {

      const prodRepetido = articulosCarrito.map(item => {
        if (item.id === id) {
          item.cantidad += Number(1);
          return item; // retorna el objeto actualizado 
        } else {
          return item; // retorna los objetos que no son duplicados 
        }

      });
      Local.set('carrito', articulosCarrito)
      // localStorage.setItem('carrito', JSON.stringify(articulosCarrito));
      limpiarHTML()
      PintarCarrito()


    }

    function deleteItem(id) {
      articulosCarrito = articulosCarrito.filter(objeto => objeto.id !== id);

      Local.set('carrito', articulosCarrito)
      limpiarHTML()
      PintarCarrito()
    }

    var appUrl = <?php echo json_encode($url_env); ?>;
    $(document).ready(function() {
      articulosCarrito = Local.get('carrito') || [];

      PintarCarrito();
    });

    function limpiarHTML() {
      //forma lenta 
      /* contenedorCarrito.innerHTML=''; */
      $('#itemsCarrito').html('')


    }

    $('#btnAgregarCarrito').on('click', function() {
      let url = window.location.href;
      let partesURl = url.split('/')
      let item = partesURl[partesURl.length - 1]
      let cantidad = Number($('#cantidadSpan span').text())
      item = item.replace('#', '')



      // id='nodescuento'


      $.ajax({

        url: `{{ route('carrito.buscarProducto') }}`,
        method: 'POST',
        data: {
          _token: $('input[name="_token"]').val(),
          id: item,
          cantidad

        },
        success: function(success) {
          let {
            producto,
            id,
            descuento,
            precio,
            imagen,
            color
          } = success.data
          let cantidad = Number(success.cantidad)
          let detalleProducto = {
            id,
            producto,
            descuento,
            precio,
            imagen,
            cantidad,
            color

          }
          let existeArticulo = articulosCarrito.some(item => item.id === detalleProducto.id)
          if (existeArticulo) {
            //sumar al articulo actual 
            const prodRepetido = articulosCarrito.map(item => {
              if (item.id === detalleProducto.id) {
                item.cantidad += Number(detalleProducto.cantidad);
                return item; // retorna el objeto actualizado 
              } else {
                return item; // retorna los objetos que no son duplicados 
              }

            });
          } else {
            articulosCarrito = [...articulosCarrito, detalleProducto]

          }

          Local.set('carrito', articulosCarrito)
          let itemsCarrito = $('#itemsCarrito')
          let ItemssubTotal = $('#ItemssubTotal')
          let itemsTotal = $('#itemsTotal')
          limpiarHTML()
          PintarCarrito()
          mostrarTotalItems()

          Swal.fire({

            icon: "success",
            title: `Producto agregado correctamente`,
            showConfirmButton: true


          });
        },
        error: function(error) {
          console.log(error)
        }

      })



      // articulosCarrito = {...articulosCarrito , detalleProducto }
    })
    // $('#openCarrito').on('click', function() {
    //   $('.main').addClass('blur')
    // })
    // $('#closeCarrito').on('click', function() {

    //   $('.cartContainer').addClass('hidden')
    //   $('#check').prop('checked', false);
    //   $('.main').removeClass('blur')


    // })
  </script>

  <script>
    var swiper2 = new Swiper(".product-prev", {
      loop: true,
      spaceBetween: 32,
      effect: "fade",
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
    });
  </script>

  <script type="text/javascript">
    // $('#product-swiper').on('click', (e) => {
    //   console.log(e.currentTarget)
    //   $('#product-swiper-modal').modal()
    // })

    $(document).on('click', '#product-detail-image', (e) => {
      const target = e.currentTarget
      const slider = target.getAttribute('data-slider');
      $(`[aria-label="Go to slide ${slider}"]`).trigger('click')
      $('#product-swiper-modal').modal()
    })
  </script>
@stop

@stop
