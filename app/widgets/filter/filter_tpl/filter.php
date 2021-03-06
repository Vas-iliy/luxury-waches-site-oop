<section class="sky-form">
    <h4>Цена</h4>
    <div class="row1 price">
        <div class="col col-4" style="display: flex">
                <input style="width: 45%;" type="text" class="price_start" name="price_start" value="<?=(!empty($price[0]) ? $price[0] : '')?>" placeholder="0 <?=$curr['symbol']?>">
                <input style="width: 45%; " type="text" class="price_end" name="price_end" value="<?=(!empty($price[1]) ? $price[1] : '')?>" placeholder="<?=(999*$curr['value'])?> <?=$curr['symbol']?>">
        </div>
    </div>
</section>
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
