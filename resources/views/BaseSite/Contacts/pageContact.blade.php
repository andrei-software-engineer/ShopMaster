<section class="container">
    @if($obj)
        <h1><?= $obj->_name?></h1>
        <div class="content"><?= $obj->_description?></div>
    @endif

    <div class="row">
        <div class="col-sm-6"><?=$Formular?></div>
        <div class="col-sm-6"><?=$Maps?></div>
    </div>
</section>

