<?php if(count($rootPages)>0):?>
<ul class="pages-menu">
    <?php foreach($rootPages as $r):?>
        <li>
            <img src="/image/st2.jpg" alt="" class="actmenu"/> <a href="/pages/<?=$r['link']?>"> <?=$r['name']?></a>
            <?php if(count($pages)>0):?>
                <ul class="child">
                    <?php foreach($pages as $p):?>
                        <?php if($r['id']==$p['parent']):?>
                            <li><span class="glyphicon glyphicon-triangle-right"></span> <a href="/pages/<?=$p['link']?>"><?=$p['name']?></a></li>
                        <?php endif; ?>
                    <?php endforeach;?>
                </ul>
            <?php endif; ?>
        </li>
    <?php endforeach;?>
</ul>
<?php endif; ?>


<? $this->registerJs("

    $(function(){
        $(\".actmenu\").click(function () {
            var block = $(this);
            if(block.siblings('ul.child').css('display')==='none'){
                $('ul.child').slideUp(300);
                block.siblings('ul.child').slideDown(300);
            }else{
                $('ul.child').slideUp(300);
            }
            return false;
        });
        $(\"body\").click(function () {
            $('ul.child').slideUp(300);
        });
    });

");?>