<?php
return [
    '/' => 'MainController@index',
    'contacts' => 'MainController@contacts',
    'acticle/(\d+)' => 'ArticleController@show',
];