<?php
return [
    '/' => 'MainController@index',
    'contacts' => 'MainController@contacts',
    'acticle/(\d+)' => 'ArticleController@show',
    'acticle/(\d+)/edit' => 'ArticleController@edit',
    'acticle/(\d+)/edit-form' => 'ArticleController@editForm',
    'pdf-article' => 'ArticleController@pdf',
    'excel-article' => 'ArticleController@excel',
];