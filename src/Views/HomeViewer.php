<?php


namespace redirect\src\Views;


class HomeViewer
{
    public function index(){
        $loader = new \Twig\Loader\FilesystemLoader("/var/www/redirect.loc/src/Views/Templates");
        $twig = new \Twig\Environment($loader);
        echo $twig->render('index.html');
    }
}