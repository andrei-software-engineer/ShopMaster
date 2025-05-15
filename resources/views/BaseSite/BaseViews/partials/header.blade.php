<div class="bg-gray">
    <div class="header-primary-bar container ">
        <nav class="me-auto"><?=$_topContent?></nav>
        <div class="social-media me-lg-3 me-auto"><?=$_socialMedia?></div>
        <div class="language"><?=$_language?></div>
    </div>
</div>

<div class="header-secondary-bar container">
    <?=$_logoTip?> 
    <?=$_search?> 
    <div class="nav-buttons">
        <a class="fas-telegram" href="{{_CGC('telegram top')}}"></a>
        <a class="fas-whatsapp" href="{{_CGC('whatsapp top')}}"></a>
        <a class="fas-viber" href="{{_CGC('viber top')}}"></a>
        <a class="fas-phone" href="{{_CGC('phone top config')}}">{{_GL('phone top label')}}</a>
         <div class="header-user"><?=$_login?></div>
        <div class="header-favorite"><?=$_favorite?></div>
        <div class="header-cart "><?=$_cart?></div>
    </div>
</div> 