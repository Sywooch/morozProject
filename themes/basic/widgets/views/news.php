<div class="news-block">
    <h1>Новости компании</h1>
    <div class="slider-news">
        <?if(count($news)>0):?>
            <? foreach($news as $n):?>
            <div class="slide">
                <div class="inner-news-block">
                    <a href="/news/<?=$n['id']?>" class="news-name"><?=$n['title']?></a>
                    <p><?=$n['description']?></p>
                    <a href="/news/<?=$n['id']?>" class="view-news">подробнее</a>
                </div>
            </div>
            <?endforeach;?>
        <? endif; ?>
    </div>
</div>