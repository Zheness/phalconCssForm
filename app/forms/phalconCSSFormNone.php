<?php

class phalconCSSFormNone extends \Phalcon\Forms\Form {

    private $_method = "post";
    private $_enctype = false;
    private $_formAttributes = [];
    private $_fieldsets = [];
    private $_inputElements = [];
    private $_hiddenElements = [];
    private $_currentFieldset = NULL;

    /**
     * Set the method of the form
     * @param string $method
     */
    protected function setMethod($method) {
        $this->_method = $method;
    }

    /**
     * Set if the form will upload files
     * @param bool $upload
     */
    protected function fileUpload($upload) {
        $this->_enctype = $upload;
    }

    /**
     * Set the attributes of the form
     * @param array $attributes
     */
    protected function setAttributes($attributes) {
        $this->_formAttributes = $attributes;
    }

    /**
     * Adds an element to the form
     * @param \Phalcon\Forms\ElementInterface $element
     */
    public function add($element) {
        $type = strtolower(current(array_reverse(explode("\\", get_class($element)))));
        parent::add($element);
        if ($type == "hidden")
            $this->_hiddenElements[] = $element;
        else
            $this->_inputElements[] = [$element, $this->_currentFieldset];
    }

    /**
     * Render in HTML an element of the form
     * @param string $name
     * @return string
     */
    public function renderElement($name) {
        $element = $this->get($name);
        $type = strtolower(current(array_reverse(explode("\\", get_class($element)))));

        $method = "_render" . ucfirst($type);
        if (method_exists($this, $method))
            $html = $this->$method($element);
        else
            $html = $this->_renderDefault($element);
        return $html;
    }

    /**
     * Render in HTML all the form
     * @return string
     */
    public function renderForm() {
        $enctype = $this->_enctype ? "enctype=\"multipart/form-data\"" : "";
        $formAttributes = $this->_renderAttributes($this->_formAttributes);
        $html = "<form action=\"{$this->getAction()}\" method=\"{$this->_method}\" {$enctype} $formAttributes>";
        foreach ($this->_inputElements as $element) {
            $html .= $this->renderElement($element[0]->getName());
        }
        $html .= "</form>";
        return $html;
    }

    /**
     * Render an inline HTML string which contains attributes
     * @param array $attributes
     * @return string
     */
    private function _renderAttributes($attributes) {
        $html = "";
        if (count($attributes)) {
            foreach ($attributes as $attribute => $value) {
                $html .= " {$attribute}=\"{$value}\" ";
            }
        }
        return trim($html);
    }

    /*
     * ---------------------------------------------------
     * Elements
     * ---------------------------------------------------
     */

    /**
     * Render in HTML an element of any type
     * @param \Phalcon\Forms\ElementInterface $element
     * @return string
     */
    function _renderDefault($element) {
        $messages = $this->getMessagesFor($element->getName());
        $hasMessages = count($messages) > 0 ? TRUE : FALSE;

        $html = "<p><label for=\"{$element->getName()}\">{$element->getLabel()}</label><br/>";
        $html .= $this->render($element->getName());
        $html .= "</p>";
        if ($hasMessages)
            $html .= "<p>{$messages[0]}</p>";
        return $html;
    }

    /**
     * Render in HTML an element of type Checkobx
     * @param \Phalcon\Forms\ElementInterface $element
     * @return string
     */
    function _renderCheck($element) {
        $messages = $this->getMessagesFor($element->getName());
        $hasMessages = count($messages) > 0 ? TRUE : FALSE;

        $html = "<p>{$this->render($element->getName())} <label for=\"{$element->getName()}\">{$element->getLabel()}</label></p>";
        if ($hasMessages)
            $html .= "<p>{$messages[0]}</p>";
        return $html;
    }

    /**
     * Render in HTML an element of type Radio
     * @param \Phalcon\Forms\ElementInterface $element
     * @return string
     */
    function _renderRadio($element) {
        $messages = $this->getMessagesFor($element->getName());
        $hasMessages = count($messages) > 0 ? TRUE : FALSE;

        $html = "<p>{$this->render($element->getName())} <label for=\"{$element->getName()}\">{$element->getLabel()}</label></p>";
        if ($hasMessages)
            $html .= "<p>{$messages[0]}</p>";
        return $html;
    }

    /**
     * Render in HTML an element of type Hidden
     * @param \Phalcon\Forms\ElementInterface $element
     * @return string
     */
    function _renderHidden($element) {
        $html = $this->render($element->getName());
        return $html;
    }

    /**
     * Render in HTML an element of type Submit
     * @param \Phalcon\Forms\ElementInterface $element
     * @return string
     */
    function _renderSubmit($element) {
        $html = $this->render($element->getName());
        return $html;
    }

}
