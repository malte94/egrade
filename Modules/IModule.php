<?php

/**
 * @deprecated
 * Interface IModule
 */
Interface IModule{
    public function render(array $template_vars) : string;
    public function saveModel() : bool;
    public function loadModel() : PrintTemplateModelAbstract;
}