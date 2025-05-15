<select name="{{$name}}[]" class="<?=($needNext) ? ' js_CA_select ' : '' ?>" data-useselected="1" data-oneach="1">
    <option value=""
        data-href="<?= route($route, ['level' => $nextlevel, 'idparentcategory' => 0]) ?>"
        data-targetid="{{$targetid}}"><?= _GL($keyLabel) ?></option>
    @foreach ($objects as $v)
        <option value={{ $v->id }}
            data-href="<?= route($route, ['level' => $nextlevel, 'idparentcategory' => $v->id]) ?>"
            data-targetid="{{$targetid}}">{{ $v->_name }}</option>
    @endforeach
</select>
