<?php
return [
    '/' => 'MainController@index',
    'contacts' => 'MainController@contacts',
    'acticle/(\d+)' => 'ArticleController@show',
    'acticle/(\d+)/edit' => 'ArticleController@edit',
];