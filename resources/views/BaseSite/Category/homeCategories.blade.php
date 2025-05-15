@if ($objects)
    <div class="container mt-4">
        
        <div class="content">
            <h2 class="mb-4"><?=_GL('Categorii produse')?></h2>
          <div class="row">
          @foreach ($objects as $item)
              <div class="col-lg-2 col-6"><?= $item ?></div>
          @endforeach
          </div>
      </div>
    </div>
@endif
