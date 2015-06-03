<?php if(count($rootPages)>0):?>
    <table class="catalog-links-home">
        <tr>
            <td>
                <?$nnn=1;?>
        <?php foreach($rootPages as $r):?>
            <div class="header-links">
                <img src="/image/<?=$r['img']?>" alt=""/> <span> <?=$r['name_cat']?></span>
            </div>
            <?php if(count($pages)>0):?>
                <ul class="links-cat">
                    <?php foreach($pages as $p):?>
                        <?php if($r['id_cat']==$p['pid_cat']):?>
                            <li><span class="plus"></span><a href="/catalog/<?=$p['id_cat']?>"><?=$p['name_cat']?></a></li>
                        <?php endif; ?>
                    <?php endforeach;?>
                </ul>
            <?php endif; ?>
            <?php if($nnn%3==0):?>
                <?php if($nnn==6):?>
                    </td></tr>
                <?else:?>
                    </td></tr><tr><td>
                <?endif;?>
            <?php else:?>
                <?php if($nnn!=6):?>
                    </td><td>
                <?php endif;?>
            <?php endif;?>
            <?php $nnn++;?>
        <?php endforeach;?>
        </td></tr></table>
<?php endif; ?>

