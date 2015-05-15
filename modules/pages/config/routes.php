<?php

return array(
    'admin/pages'=>'pages/admin/pages',
    'admin/pages/index'=>'pages/admin/pages/index',
    'admin/pages/create'=>'pages/admin/pages/create',
    'admin/pages/view'=>'pages/admin/pages/view',
    'admin/pages/update'=>'pages/admin/pages/update',
    'admin/pages/delete'=>'pages/admin/pages/delete',
    'pages/<url>'  => 'pages/default/view',
    'pages/page/<page:\d+>'  => 'pages/default/index',

);