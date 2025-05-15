<div class="container">    
    <div class="content">
        <h2 class="mb-4"><?=_GL('homeProductVisited')?></h2>
        <div class="row">
        @foreach ($objects as $v)
            <div class="col-sm-2"><?=$v?></div>
        @endforeach
        </div>
    </div>
</div>