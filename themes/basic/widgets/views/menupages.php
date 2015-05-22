<ul class="pages-menu">
    <li>
        <img src="/image/st2.jpg" alt="" class="actmenu"/> <a href="#"> О КОМПАНИИ</a>
        <ul class="child">
            <li><span class="glyphicon glyphicon-triangle-right"></span> <a href="#">One</a></li>
            <li><span class="glyphicon glyphicon-triangle-right"></span> <a href="#">Two</a></li>
            <li><span class="glyphicon glyphicon-triangle-right"></span> <a href="#">Three</a></li>
        </ul>
    </li>
    <li>
        <img src="/image/st2.jpg" alt="" class="actmenu"/> <a href="#"> ДЛЯ ПОКУПАТЕЛЕЙ</a>
        <ul class="child">
            <li><span class="glyphicon glyphicon-triangle-right"></span> <a href="#">One</a></li>
            <li><span class="glyphicon glyphicon-triangle-right"></span> <a href="#">Two</a></li>
            <li><span class="glyphicon glyphicon-triangle-right"></span> <a href="#">Three</a></li>
        </ul>
    </li>
    <li>
        <img src="/image/st2.jpg" alt="" class="actmenu"/> <a href="#"> УСЛУГИ</a>
        <ul class="child">
            <li><span class="glyphicon glyphicon-triangle-right"></span> <a href="#">One</a></li>
            <li><span class="glyphicon glyphicon-triangle-right"></span> <a href="#">Two</a></li>
            <li><span class="glyphicon glyphicon-triangle-right"></span> <a href="#">Three</a></li>
        </ul>
    </li>
</ul>
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
    });

");?>