<?php

use Jenssegers\Blade\Blade;

class Controller {
    
    protected function model($model)
    {
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }

    protected function view($view, $data = [])
    {
        $view = str_replace('.', '/', $view);
        $blade = new Blade('../app/views', '../app/cache');
        return $blade->make($view, compact('data'));
    }

}