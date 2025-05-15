<form method="POST" action="{{ route('web.execspecialfilter') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="idspecialfilter" value="{{ $idspecialfilter }}" />
    <div class="row tab-inputs pb-0">
      <?=$filtersc?>
    </div>
    <div class="row tab-inputs">
        <div class="col-sm-4">
            <div id="homepage_specialfilter_mainc_1"><?=$mainc?></div>
        </div>
        <div class="col-sm-4">
            <div id="homepage_specialfilter_mainc_2"></div>
        </div>
        <div class="col-sm-4">
            <div id="homepage_specialfilter_mainc_3"></div>
        </div>
        

        <div class="col-sm-4">
            <div id="homepage_specialfilter_specialc_1"><?=$specialc?></div>
        </div>
        <div class="col-sm-4">
            <div id="homepage_specialfilter_specialc_2"></div>
        </div>
        
        
        <div class="col-sm-4"><button type="submit" value="{{ _GL('Cauta piese') }}">
                <div class="fas-search-icon"></div>
                <div>{{ _GL('Cauta piese') }}</div>
            </button>
        </div>
    </div>
</form>
