<?php
namespace Core\Controllers;

use Core\Models\Product;
use Core\Models\Category;
use Core\Views\View;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class ProductController extends Controller {
    public function importData(){
        $message = '';
        $prod_added = 0;
        $prod_updated = 0;

        if ($_FILES['import_excel']['name'] !== '') {
            $allowed_ext = ['xls', 'xlsx', 'csv'];
            $file_arr = explode('.', $_FILES['import_excel']['name']);
            $file_ext = end($file_arr);

            if (in_array($file_ext, $allowed_ext)) {
                $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($_FILES['import_excel']['name']);
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);
                $spreadsheet = $reader->load($_FILES['import_excel']['tmp_name']);
                $data = $spreadsheet->getActiveSheet()->toArray();
                //print_r($data);
            
                foreach ($data as $row) {
                // reading column with categories and add non-existing in appropriate table
                    if (Category::findOneByColumn('name', $row[4]) == null) {
                        $category = new Category();
                        $category->name = $row[4];
                        $category->save();
                    }
                // products handling: if new (defining by sku) - add to DB, if not - updating data
                    if(Product::findOneByColumn('sku', $row[3]) == null) {
                        $product = new Product();
                        $product->name = $row[0];
                        $product->description = $row[1];
                        $product->price = $row[2];
                        $product->sku = $row[3];
                        $cat = Category::findByName($row[4]);
                        $product->category_id = $cat->id;
                        $product->save();
                        $prod_added++;
                    } else {
                        $product = Product::findOneByColumn('sku', $row[3]);
                        //var_dump($product);
                        $product->name = $row[0];
                        $product->description = $row[1];
                        $product->price = $row[2];
                        $product->sku = $row[3];
                        $cat = Category::findByName($row[4]);
                        //var_dump($cat);
                        $product->category_id = $cat->id;
                        $product->save();
                        $prod_updated++;
                    }
                    $message = '<div class="alert alert-success">Products added: '.$prod_added.'. Products updated: '.$prod_updated.'.</div>';
                }
            } else {
                $message = '<div class="alert alert-danger">Only .xls, .xlsx and .csv extentions allowed</div>';
            }
        } else {
            $message = '<div class="alert alert-danger">Please Select File</div>';
        }
        
        // after file handling show how many products have been added to DB and how many products have been updated on import page
        View::render('main/import', compact('message'));
    }
}