<?if(count($pages)>0):?>

    <div class="wrap-figura-block-full">
        <div class="left-figura-full"></div>
        <div class="center-figura-full"><h3>Профессиональный<br> монтаж</h3></div>
        <div class="right-figura-full"></div>
    </div>
    <?foreach($pages as $p):?>
        <?if($p['parent']=='17'):?>
            <div class="item-right-pages">
                <a href="/pages/<?=$p['link']?>"><?=$p['name']?></a>
                <p><?=$p['desc']?></p>
            </div>
        <?endif;?>
    <?endforeach;?>

    <div class="middle-header-right-block-full"><h3>Оперативная доставка</h3></div>
    <?foreach($pages as $p):?>
        <?if($p['parent']=='16'):?>
            <div class="item-right-pages">
                <a href="/pages/<?=$p['link']?>"><?=$p['name']?></a>
                <p><?=$p['desc']?></p>
            </div>
        <?endif;?>
    <?endforeach;?>

<?endif;?>