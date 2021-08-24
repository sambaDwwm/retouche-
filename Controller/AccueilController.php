<?php

namespace Controller;

use Controller\BaseController;

class AccueilController extends BaseController
{

    public function index()
    {
        $this->afficherVue();
    }
}
