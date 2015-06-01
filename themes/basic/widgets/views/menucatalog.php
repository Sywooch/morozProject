<?
 use yii\widgets\Menu;
?>
<div class="forum-catalog-menu">
    <img src="/image/st1.jpg" alt=""/> <a href="#" class="link-catalog">КАТАЛОГ ТОВАРОВ</a>
</div>
<div class="forum-catalog-search">
    <input type="text" name="searchCatalog" value=""/><span class="lupa glyphicon glyphicon-search"></span>
</div>
<div style="clear: both;"></div>
<div class="categories-catalog-first">
    <ul class="ul-cat-links">
    <?php foreach ($cat as $k=>$c):?>
        <li>
            <a href="<?=$c['url'][0]?>"><span class="plus"></span> <?=$c['label']?> <span class="glyphicon glyphicon-menu-right strelka"></span></a>
            <?php if(is_array($cat[$k]['items']) && count($cat[$k]['items'])>0):?>
                <div class="child-category">
                    <?php foreach($cat[$k]['items'] as $cc):?>
                        <div class="item-ch-links">
                            <h3><a href="<?=$cc['url'][0]?>"><?=$cc['label']?></a></h3>
                            <?php if(is_array($cc['items']) && count($cc['items'])>0):?>
                                <?php
                                echo Menu::widget([
                                    'items' => $cc['items'],
                                ]);
                                ?>
                            <?php endif;?>
                        </div>
                    <?php endforeach;?>
<!--                    <div style="clear: both;"></div>-->
                </div>
            <?php endif;?>
        </li>
    <?php endforeach;?>
    </ul>
</div>
<?//vd($cat)?>


<? $this->registerJs("

    $(function(){
        var block = $('.categories-catalog-first');
        var H = $('.ul-cat-links').height();

        $(\".link-catalog\").click(function () {
            if(block.css('display')==='none'){
                block.slideDown(300);
                H = $('.ul-cat-links').height();
                $('.child-category').css({'min-height':H+2});
            }else{
                block.slideUp(300);
            }
            return false;
        });

        $('.child-category').css({'min-height':H+2});

    });



");?>