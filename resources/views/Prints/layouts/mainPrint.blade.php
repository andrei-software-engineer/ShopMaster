<!doctype html>
<html>


<head>
    @include('Prints.partials.head', $_mainParams['_headParams'])
    @vite('resources/css/appPrint.css')
</head>

<body>
    <div class="nav">
        
        <header class="row">
            @include('Prints.partials.header', $_mainParams['_topContentParams'])
        </header>

        <div id="main" class="row">
            @yield('content')
        </div>

        <footer class="row">
            @include('Prints.partials.footer', $_mainParams['_footerParams'])
        </footer>
    </div>

</body>

</html>
