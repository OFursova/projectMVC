<?php
return [
    '/' => 'MainController@index',
    'contacts' => 'MainController@contacts',
    'article/(\d+)' => 'ArticleController@show',
    'article/(\d+)/edit' => 'ArticleController@edit',
    'article/(\d+)/edit-form' => 'ArticleController@editForm',
    'article/add' => 'ArticleController@add',
    'article/add-form' => 'ArticleController@addForm',
    'article/(\d+)/delete' => 'ArticleController@delete',
    'pdf-article' => 'ArticleController@pdf',
    'excel-article' => 'ArticleController@excel',
];