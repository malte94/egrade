<?php
Interface IPrintTemplate
{
    public function render() : bool;
    public function output() : string;
}