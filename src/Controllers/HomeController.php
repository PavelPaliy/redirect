<?php
namespace redirect\src\Controllers;
use redirect\src\Views\HomeViewer;
use redirect\src\Models\Generator;

class HomeController{
    public function index(){
        $home = new HomeViewer();
        $home->index();
    }
    public function store($link)
    {
        $generator = new Generator();
        if($generator->validateLink($link)==0)
            $generator->addAlias($link);
        else{
            echo $generator->getAlias($link);
        }
    }
    public function redirect($alias){
        $generator = new Generator();
        $generator->redirect($alias);
    }

}