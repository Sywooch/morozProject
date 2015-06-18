<style>
    table.cart-table-goods{
        width: 100%;
        border-collapse: collapse;
        border: none;
    }
    table.cart-table-goods tr:nth-child(odd){
        background-color:  #f2f2f2;
    }
    table.cart-table-goods tr:nth-child(even){
        background-color:  #fff;
    }
    table.cart-table-goods tr:hover{
        background-color:  #fef7de;
    }
    table.cart-table-goods th{
        font-weight: 500;
        text-align: center;
        padding: 8px;
        background-color:  #fff;
        font-size: 12px;
    }
    table.cart-table-goods th.cart-name{
        text-align: left;
    }
    table.cart-table-goods td{
        border-top:  #e2e2e2 solid 1px;
        margin: 5px;
        text-align: center;
        padding: 8px;
    }
    table.cart-table-goods td.cart-name{
        text-align: left;
    }
    table.cart-table-goods td.cart-price,
    table.cart-table-goods td.cart-count,
    table.cart-table-goods td.cart-sum{
        border-left:  #e2e2e2 solid 1px;
    }

    table.cart-table-goods tr td.cart_itogo{
        background: #fff;
        text-align: right;

    }
    table.cart-table-goods td.cart-price span.cart-price-val,
    table.cart-table-goods td.cart-sum span.cart-sum-val {
        font-weight: 500;
        font-size: 23px;
        color: #8d340e;
    }
    table.cart-table-goods td.cart-price span,
    table.cart-table-goods td.cart-sum span{
        color: #3a3939;
        font-size: 16px;
    }
</style>
<h1>Ваш заказ # <?=$order_id?></h1>
<table  class="cart-table-goods">
    <tr>
        <th class="cart-name">Наименование</th>
        <th>Цена за ед., руб.</th>
        <th>Количество</th>
        <th >Стоимость, руб.</th>
    </tr>
    <?foreach($goods as $g):?>
        <?php $all_sum = $all_sum + $g['price']*$g['count'];?>

        <tr class="table-item-goods">
            <td class="cart-name">
                <?=$g['name']?>
            </td>
            <td class="cart-sum">
                <span class="cart-sum-val"><?=$g['price']?></span>
            </td>
            <td class="cart-count">
                <?=$g['count']?>
            </td>
            <td class="cart-sum">
                <span class="cart-sum-val"><?=$g['price']*$g['count']?></span>
            </td>
        </tr>
    <?endforeach;?>
    <tr>
        <td colspan="6" class="cart_itogo">
            <div  class="all-sum"> Сумма доставки: <?=$delivery_sum;?> руб. Итого: <span id="all-sum-val"><?=$all_sum+$delivery_sum;?></span> руб.</div>
        </td>
    </tr>
</table>