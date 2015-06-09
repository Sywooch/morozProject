<?php

return array(
    'admin/catalog'=>'catalog/admin/catalog',
    'admin/catalog/index'=>'catalog/admin/catalog/index',
    'admin/catalog/create'=>'catalog/admin/catalog/create',
    'admin/catalog/view'=>'catalog/admin/catalog/view',
    'admin/catalog/update'=>'catalog/admin/catalog/update',
    'admin/catalog/delete'=>'catalog/admin/catalog/delete',
    'product/<id_cat>/<id>'  => 'catalog/product/index',
    'catalog/<url>'  => 'catalog/default/view',
    'catalog/page/<page:\d+>'  => 'catalog/default/index',
);