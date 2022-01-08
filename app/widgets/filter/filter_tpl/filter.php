<?foreach ($this->groups as $id_group => $item):?>
    <section  class="sky-form">
        <h4><?=$item?></h4>
        <div class="row1 scroll-pane">
            <div class="col col-4">
                <?foreach ($this->attrs[$id_group] as $idAttr => $value):?>
                <?if(!empty($filter) && in_array($idAttr, $filter)) {
                    $checked = 'checked';
                    } else {
                        $checked = null;
                    }
                    ?>
                <label class="checkbox">
                    <input type="checkbox" name="checkbox" value="<?=$idAttr?>" <?=$checked?>><i></i><?=$value?>
                </label>
                <?endforeach;?>
            </div>
        </div>
    </section>
<?endforeach;?>
