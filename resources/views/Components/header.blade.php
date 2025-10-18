<header
>

    <link rel="stylesheet" href="{{asset('css/header.css')}}">
    <link rel="stylesheet" href="{{asset('css/menu.css')}}">

    <script src="{{asset('js/menu.js')}}" defer></script>
    <nav>
        <ul class="tile_list">


            <x-header_tile :active="request()->is('inicio')">
                <x-slot:link>{{"/inicio"}}</x-slot:link>
                <x-slot:svg>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-home ico"
                    >
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M5 12l-2 0l9 -9l9 9l-2 0"/>
                        <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"/>
                        <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"/>
                    </svg>
                </x-slot:svg>
            </x-header_tile>
            <x-header_tile :active="request()->is('inventario')">
                <x-slot:link>{{"/inventario"}}</x-slot:link>
                <x-slot:svg>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-building-warehouse ico"
                    >
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M3 21v-13l9 -4l9 4v13"/>
                        <path d="M13 13h4v8h-10v-6h6"/>
                        <path d="M13 21v-9a1 1 0 0 0 -1 -1h-2a1 1 0 0 0 -1 1v3"/>
                    </svg>

                </x-slot:svg>
            </x-header_tile>

            <x-header_tile :active="request()->is('venta') || request()->is('venta-confirmacion')">
                <x-slot:link>{{"/venta"}}</x-slot:link>
                <x-slot:svg>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-pig-money ico"
                    >
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M15 11v.01"/>
                        <path d="M5.173 8.378a3 3 0 1 1 4.656 -1.377"/>
                        <path
                            d="M16 4v3.803a6.019 6.019 0 0 1 2.658 3.197h1.341a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-1.342c-.336 .95 -.907 1.8 -1.658 2.473v2.027a1.5 1.5 0 0 1 -3 0v-.583a6.04 6.04 0 0 1 -1 .083h-4a6.04 6.04 0 0 1 -1 -.083v.583a1.5 1.5 0 0 1 -3 0v-2l0 -.027a6 6 0 0 1 4 -10.473h2.5l4.5 -3h0z"/>
                    </svg>
                </x-slot:svg>
            </x-header_tile>

            <x-header_tile :active="request()->is('estadisticas')">

                <x-slot:link>{{"/estadisticas"}}</x-slot:link>
                <x-slot:svg>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-chart-histogram ico"
                    >
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M3 3v18h18"/>
                        <path d="M20 18v3"/>
                        <path d="M16 16v5"/>
                        <path d="M12 13v8"/>
                        <path d="M8 16v5"/>
                        <path d="M3 11c6 0 5 -5 9 -5s3 5 9 5"/>
                    </svg>
                </x-slot:svg>
            </x-header_tile>



                <li  class="tile user-tile container user-ico">

                        <svg
                            id="profileBtn"
                            xmlns="http://www.w3.org/2000/svg"
                            width="40     "
                            height="40"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="rgba(56, 38, 31, 0.8)"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-user"
                        >
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"/>
                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/>
                        </svg>

                </li>

        </ul>
    </nav>

    <div  id="profileMenu" class="menu">
        <ul class="menuOptions">
            <li>Perfil</li>
            <li><a href="/sugerencias" style="background: none; color: inherit">Sugerencias</a></li>
            <li id="temas_tile">Temas</li>
            <li>
                <a href="/logout">
                    Log out
                </a>
            </li>
        </ul>
    </div>

    <div class="temas_pick">
        <div class="container">
            <ul>
                <li>
                    Por defecto
                <div class="sample">
                    <div class="color font_color"></div>
                    <div class="color background_color"></div>
                    <div class="color third_color"></div>
                </div>
                </li>
                <li>Azul</li>
                <li>Rojo</li>
            </ul>
        </div>
    </div>
</header>
