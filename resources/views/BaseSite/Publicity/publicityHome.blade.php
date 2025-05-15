<? $id = 'adv_hometopleft'; ?>
<? // -------------------------  ?>

<div class="js_animfadecomplex home-banner" delay="<?= $_delay ?>">

    <span class="js_gotoleft arrow left"><svg class="svg-left" viewBox="0 0 512 512">
            <polygon points="352,115.4 331.3,96 160,256 331.3,416 352,396.7 201.5,256 " />
        </svg></span>


    <div class="js_animcontainer" delay="<?= $_delay ?>">
        @foreach ($objects as $k => $v)
            <div class="js_animobj image-banner" style="<?= $k ? 'opacity:0;' : '' ?> ">
                <?= $v ?>
            </div>
        @endforeach
    </div>

    <span class="js_gotoright arrow right">
        <svg class="svg-right" viewBox="0 0 512 512">
            <polygon points="160,115.4 180.7,96 352,256 180.7,416 160,396.7 310.5,256 " />
        </svg>
    </span>
</div>
<? // -------------------------  ?>
