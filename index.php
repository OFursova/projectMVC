<?php

use Core\Controllers\FileController;
use Core\Libs\Exceptions\DbException;
use Core\Libs\Exceptions\NotFoundException;
use Core\Libs\Route;
use Core\Views\View;

spl_autoload_register(function($className){
    //require_once 'core/libs/Route.php';
    $pathArr = explode('\\', $className);
    for ($i=0; $i < count($pathArr)-1; $i++) { 
        $pathArr[$i] = strtolower($pathArr[$i]);
    }
    $routeName = implode('/', $pathArr);
    require_once $routeName.'.php';
});

try {
    Route::start();
} catch (DbException $e) {
   echo $e->getMessage();
} catch (NotFoundException $e) {
    View::render('errors/404', [], 404);
}

// ============ HOMEWORK ===================== //
/*
$file = new FileController('assets/images/test.txt');
echo $file->getPath().'<br>';
echo $file->getDir().'<br>';
echo $file->getName().'<br>';
echo $file->getExt().'<br>';
$file->setText('<h1>Hello World!</h1>');
echo $file->getSize().'<br>';
echo $file->getText().'<br>';
$file->appendText('<p>I am bot!</p>');
echo $file->getSize().'<br>';
echo $file->getText().'<br>';
$file->copy('assets');
$file->rename('test1');
$file1 = new FileController('assets/images/test1.txt');
$file1->replace('assets');
$file2 = new FileController('assets/images/test1');
$file2->delete();
*/
?>
