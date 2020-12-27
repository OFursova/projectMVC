<?php
namespace Core\Controllers;

use Core\Models\Article;
use Core\Models\User;
use Core\Views\View;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
        $article->name = $_POST['name'] ? $_POST['name']: 'New Article';
        $article->text = $_POST['text'] ? $_POST['text']:'Text for New Article';
        $article->user_id = $_POST['user_id'] ? $_POST['user_id'] : 'New User';
        
        $article->save();
        $this->redirect('/');
    }

    public function editForm($id)
    {
        $article = Article::getById($id);
        if(!$article){
         View::render('errors/404', [], 404);
         return;
        }
        $users = User::findAll();
        View::render('articles/edit', compact('article', 'users'));
    }

    public function add()
    {
        $article = new Article();
        $article->id = null;
        $article->name = $_POST['name']; 
        $article->text = $_POST['text'];

        function getUserId(){
        $users = User::findAll();
        foreach ($users as $user) {
            if ($_POST['user_id'] == $user->name) {
                $id = $user->id;
            } else {
                $user = new User();
                $user->id = null;
                $user->name = $_POST['user_id'];
                $user->email = $_POST['user_id'].'@gmail.com';
                $user->password = 'password';
                $user->token = 'password';
                $user->save();
                $id = count($users);
            }
        }
        return $id;
        }
        
        $article->user_id = getUserId();

        $article->save();
        $this->redirect('/');
    }

    public function addForm()
    {
        View::render('articles/add');
    }

    public function delete($id)
    {
        $article = Article::getById($id);
        $article->delete($id);
        $this->redirect('/');
    }

    public function pdf(){
        $articles = Article::findAll();
        $html ='';
        foreach ($articles as $article) {
            $html.="<h1>{$article->name}</h1>";
            $html.="<p>{$article->text}</p>";
        }
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);
        //$mpdf->SetFooter('|Page {PAGENO} from {nbpg}|');
        $mpdf->Output();
        //$mpdf->Output('article.pdf', \Mpdf\Output\Destination::DOWNLOAD);
    }

    public function excel(){
        //header('Content-Type: application/vnd.ms-excel');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="hello world.xlsx"');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $articles = Article::findAll();
        for ($i=1; $i <= count($articles); $i++) { 
            $sheet->setCellValue('A'.$i, $articles[$i-1]->name);
            $sheet->setCellValue('B'.$i, $articles[$i-1]->text);
            $sheet->setCellValue('C'.$i, $articles[$i-1]->getAuthor()->name);
            $sheet->setCellValue('D'.$i, $articles[$i-1]->created_at);
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
}