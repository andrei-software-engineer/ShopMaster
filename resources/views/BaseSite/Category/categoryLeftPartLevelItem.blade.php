<li>
    <a href="{{ $obj->url }}" class="js_alhl <?= $isselected ? ' show-item ' : '' ?> ">
        <img src="<?= $obj->_defaultGalleryGetUrl(50) ?>" width="20" title="{{ $obj->_name }}"
            alt="{{ $obj->_name }}">
        {{ $obj->_name }}
    </a>

    @if ($childs)
        <?= $childs ?>
    @endif
</li>
