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
        $article->name = $_POST['newArticle'] ? $_POST['newArticle']: 'New Article';
        $article->text = $_POST['newArText'] ? $_POST['newArText']:'Text for New Article';
        $this->dump($article);

        // save data to db then reload
        // view edit form
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