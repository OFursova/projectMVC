<?php
namespace Core\Controllers;

class FileController implements File
	{
        protected $filePath;

		public function __construct($filePath){
            $this->filePath = $filePath;
        }
		
		public function getPath(){
            // return realpath($this->filePath);
            return $this->filePath;
        } // путь к файлу

		public function getDir(){
            //return pathinfo($this->filePath, PATHINFO_DIRNAME);
            return dirname($this->filePath, 1);
        }  // папка файла

		public function getName(){
            return pathinfo($this->filePath, PATHINFO_FILENAME);
        } // имя файла
		public function getExt(){
            return pathinfo($this->filePath, PATHINFO_EXTENSION);
        }  // расширение файла
		public function getSize(){
            return filesize($this->filePath);
        } // размер файла
		
		public function getText(){
            $handler = fopen($this->filePath, 'r');
            $text = file_get_contents($this->filePath);
            fclose($handler);
            if (!empty($text)) {
                return $text;
            }
        } // получает текст файла
		public function setText($text){
            file_put_contents($this->filePath, $text);
        } // устанавливает текст файла

		public function appendText($text){
            $cont = $this->getText().$text;
            file_put_contents($this->filePath, $cont);
        } // добавляет текст в конец файла
		
		public function copy($copyPath){
            copy($this->filePath, $copyPath.'/'.$this->getName().'.'.$this->getExt());
        } // копирует файл

		public function delete(){
            unlink($this->filePath);
        } // удаляет файл
		public function rename($newName){
            rename($this->filePath, $this->getDir().'/'.$newName.'.'.$this->getExt());
        }   // переименовывает файл
		public function replace($newPath){
            $this->copy($newPath);
            $this->delete();
        }  // перемещает файл
	}