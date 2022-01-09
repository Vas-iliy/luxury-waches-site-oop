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

                <label class="checkbox" <?if(is_array($value) && $value[1]) {echo 'style="cursor: default" id="none"'; }?>>
                    <input <?=(is_array($value) ? $value[1] : '')?> type="checkbox" name="checkbox" value="<?=$idAttr?>" <?=$checked?>><i></i><?=(is_array($value) ? $value[0] : $value)?>
                </label>
                    <?if(is_array($value) && $value[1]):?>
                        <style>
                            label#none:hover i{
                                border-color: #e5e5e5;
                            }
                        </style>
                    <?endif;?>
                <?endforeach;?>
            </div>
        </div>
    </section>
<?endforeach;?>
