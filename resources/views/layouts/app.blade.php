<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        th {
            width: 120px;
            height: 40px;
            background-color: pink;
        }
        th,td {
            padding: 5px;
        }
    </style>

<script type="text/javascript">
	function clearFormAll() {
	    for (var i=0; i<document.forms.length; ++i) {
	        clearForm(document.forms[i]);
	    }
	}
	function clearForm(form) {
	    for(var i=0; i<form.elements.length; ++i) {
	        clearElement(form.elements[i]);
	    }
	}
	function clearElement(element) {
	    switch(element.type) {
	        case "hidden":
	        case "submit":
	        case "reset":
	        case "button":
	        case "image":
	            return;
	        case "file":
	            return;
	        case "text":
	        case "password":
	        case "textarea":
	            element.value = "";
	            return;
	        case "checkbox":
	        case "radio":
	            element.checked = false;
	            return;
	        case "select-one":
	        case "select-multiple":
	            element.selectedIndex = 0;
	            return;
	        default:
	    }
	}
	</script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ route('ecsite.menu') }}">
                    {{ config('app.name', 'BookStore') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item" style="padding-right: 30px;">
                            <!-- 日付表示 -->
                            {{ date("Y/m/d H:i") }}
                        </li>
                        <!-- Authentication Links -->
                        @if(session()->has('name'))
                        <li class="nav-item">
                            <label>「{{ session()->get('name') }}」さん</label>
                        </li>
                        @else
                        <li class="nav-item">
                            <label>「ゲスト」さん</label>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
	            <div class="row">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
</body>
</html>
