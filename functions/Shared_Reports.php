<?php

class Shared_Reports_Class extends Page {

    public function __construct() {
        parent::__construct($this);
        $this->render();
    }

    public function render() {

    $this->view("Shared_Reports.html")->display(
        [

        ]);
    }
}

?>