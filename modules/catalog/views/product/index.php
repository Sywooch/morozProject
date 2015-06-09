<?php
    use yii\widgets\Breadcrumbs;
    use app\components\widgets\CaruselWidget;
    $this->title = $product['name'];
    $homeimg = [];
    $imggalery = [];
    foreach($images as $i){
        if($i['chief']=='Y'){
            $homeimg[] = $i;
        }else{
            $imggalery[] = $i;
        }
    }
?>
<?php echo Breadcrumbs::widget([
    'itemTemplate' => "<li><i>{link}</i></li>\n",
    'links' => $breadcrumbs,

]);?>

<div class="wrap-figura-block">
    <div class="left-figura"></div>
    <div class="center-figura"><h1><?=$product['name']?></h1></div>
    <div class="right-figura"></div>
</div>
<div class="line-figura"></div>
<div class="wrap-product">
    <div class="wrap-images">
        <div class="home-image-product">
            <?if(count($homeimg)>0):?>
                <a href="/image/<?=$homeimg[0]['imgname']?>" data-lightbox="image-group" data-title="<?=$homeimg[0]['desc']?>"><img src="/image/<?=$homeimg[0]['imgname']?>" alt=""/></a>
            <?else:?>
                <img src="/image/p3.jpg" alt=""/>
            <?endif;?>
            <?if(count($imggalery)>0):?>
            <div class="images-galery">
                <?foreach($imggalery as $im):?>
                    <a href="/image/<?=$im['imgname']?>" data-lightbox="image-group" data-title="<?=$im['desc']?>"><img src="/image/<?=$im['imgname']?>" width="100" alt=""/></a>
                <?endforeach;?>
            </div>
            <?endif;?>
        </div>
    </div>
    <div class="wrap-product-desc">
        <div class="wrap-price-product">
            <table>
                <tr>
                    <td style="text-align: left; padding: 0 0 0 30px;"><h2 class="h2price">ЦЕНА: <span class="spanPrice"><?=$product['price']?><span class="glyphicon glyphicon-ruble"></span></span> </h2></td>
                    <td>
                        <div class="block-kol-wrap">
                            <h2>КОЛ-ВО:</h2>
                            <div class="block-kol">
                                <div class="left-col"><a href="#" class="col-minus"><span class="glyphicon glyphicon-minus"></span></a></div>
                                <div class="mid-col"><input type="text" value="1"/></div>
                                <div class="right-col"><a href="#" class="col-plus"><span class="glyphicon glyphicon-plus"></span></a></div>
                            </div>
                        </div>
                    </td>
                    <td style="text-align: right; padding: 0 30px 0 0;">
                        <button type="button" class="prcartBtn">В КОРЗИНУ</button>
                    </td>
                </tr>
            </table>

        </div>
        <?=$product['description']?>
    </div>
</div>

<?= CaruselWidget::widget(); ?>