<?php

class Home extends Controller
{
    public function index()
    {
       return $this->view('welcome');
    }

    public function test()
    {
       echo "Oke Test Controller";
    }
}
