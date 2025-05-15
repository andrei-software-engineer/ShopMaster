@if ($objects)
    <div class="container">
      <div class="content">
        <h2 class="mb-4"><?=_GL('HOME: brand produse')?></h2>
        <div class="row">
          @foreach ($objects as $item)
            <div class="col-lg-2 col-3"><?= $item ?></div>
          @endforeach
        </div>
      </div>
    </div>
@endif
