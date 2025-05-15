<div class="form-group">
    <label class="form-label">{{$params['title']}}</label>

    <select name="<?= $params['name'] ?>[]" id="<?= $params['id'] ?>" size="1" class="js_CA_select form-control tomselected"
        data-useselected="1" >
        <option value="0" data-href="<?= route($params['prefLink'] , ['name' =>  $params['name'],'idlparent' => -1 ])?>" data-targetid="<?= $params['targid'] ?>">
            <?= _GLA('select') ?></option>

        <?php foreach($params['objects'] as $v) { ?>

        <option value="<?= $v->id ?>" <?= $v->id == $params['selected'] ? ' selected="selected" ' : '' ?>
            data-href="<?= route($params['prefLink'],['name' =>  $params['name'], 'idlparent' => $v->id ]) ?>" data-targetid="<?= $params['targid'] ?>"><?= $v->_name ?>
        </option>
        <?php } ?>
    </select>

    <div class="my-1" id="<?= $params['targid'] ?>"><?= $params['chids'] ?></div>
</div>  