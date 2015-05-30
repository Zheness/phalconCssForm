<?php

class IndexController extends ControllerBase {

    public function indexAction() {
        $this->_getForm();
    }

    private function _getForm() {
        $sampleForm = new SampleForm();

        if ($this->request->isPost()) {
            $sampleForm->isValid($this->request->getPost());
        }

        $this->view->form = $sampleForm;
    }

}
