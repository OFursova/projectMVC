<?php
namespace Core\Controllers;

use Core\Views\View;

class ArticleController extends Controller {

    public function show($id)
    {
       $article = $this->db->query('SELECT * FROM articles WHERE id=:id', ['id' => $id])[0];
       if(!$article){
        View::render('errors/404', [], 404);
        return;
       }
       View::render('articles/show', compact('article'));
    }
}