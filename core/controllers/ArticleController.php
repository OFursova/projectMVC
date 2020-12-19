<?php
namespace Core\Controllers;

use Core\Models\Article;
use Core\Models\User;
use Core\Views\View;

class ArticleController extends Controller {

    public function show($id)
    {
       $article = Article::getById($id);
       if(!$article){
        View::render('errors/404', [], 404);
        return;
       }
       //$author = User::getById($article->user_id);
       View::render('articles/show', compact('article'));
    }

    public function edit($id)
    {
        $article = Article::getById($id);
        if(!$article){
         View::render('errors/404', [], 404);
         return;
        }
        $article->name = 'New Article'; // $_POST[]
        $article->text = 'Text for New Article';
        $this->dump($article);

        // view edit form

        //$article->save();
        //redirect
    }
}