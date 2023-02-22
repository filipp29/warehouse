                    
                <div class="headerBlock" style="<?= isset($style) ? $style : ""?>">
                    <div class="label">
                        <?=$label?>
                    </div>
                    <div  style="<?= isset($style) ? $style : ""?>">
                        <textarea class="docComment"  name="<?=(isset($id)) ? $id : ""?>"  id="<?=(isset($id)) ? $id : ""?>"  <?=(isset($disabled)) ? $disabled : ""?> onclick="<?=(isset($onclick)) ? $onclick : ""?>" style="<?=(isset($styleInput)) ? $styleInput : ""?>"><?=(isset($value)) ? $value : ""?></textarea>
                    </div>
                </div>    