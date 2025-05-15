<div class="top-tab-bar">
    @if (count($objects))
        @foreach ($objects as $k => $v)
            <div class="tab specialfiltertab_<?= $k ?> <?= $k == $selectedId ? ' selected ' : '' ?> ">
                @if ($k != $selectedId)
                    <a href="<?= route('web.specialfilter.homecontainer', $k) ?>" class="js_al"
                        data-targetid="homepage_container_specialfilter">
                @endif
                <span class="icon"></span>
                @if ($k != $selectedId)
                    </a>
                @endif
            </div>
        @endforeach
    @endif
</div>
