<?php

/**
 * User: lsky
 * Date: 2016. 11. 4.
 * Time: PM 2:46
 */
class Real20ServiceController extends WebServiceController
{

    public function readmeAction()
    {
        $this->view->define("index","layout/layout.null.html");
        $this->view->define(array("content"=>"content/real20Service/readme.html"));
        $this->display();
    }

}