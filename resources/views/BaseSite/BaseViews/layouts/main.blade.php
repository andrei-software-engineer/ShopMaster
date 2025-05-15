<!doctype html>
<html>

<head>
    @include('BaseSite.BaseViews.partials.head', $_headParams)
</head>

<body>
    <div id="messageresult"></div>
    <header><?=$_mainParams['_topContentParams']?></header>

    <div id="breadcrumb"><?=$_mainParams['_breadcrumb']?></div>

    <div id="main">
        @yield('content')
    </div>
    <footer><?=$_mainParams['_footerParams']?></footer>
    
    <div id="loadingind"  class="loading-class">
        <div class="align-loader"><div class="loader"></div></div>
    </div>

    <div class="loading-class" id="loadingind-mini" >
        <div class="align-loader"><div class="loader"></div></div>
    </div>
</body>

</html>