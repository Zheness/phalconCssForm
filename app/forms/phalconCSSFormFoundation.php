<?php

class phalconCSSFormFoundation extends \Phalcon\Forms\Form {

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
     * Set the beginning of the fieldset
     * @param string $label
     * @param array $attributes
     */
    public function startFieldset($label, $attributes = []) {
        $this->_fieldsets[] = [
            $label,
            $attributes
        ];
        $this->_currentFieldset = count($this->_fieldsets) - 1;
    }

    /**
     * Set the end of the fieldset
     */
    public function endFieldset() {
        $this->_currentFieldset = NULL;
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
        $html = "<form action=\"{$this->getAction()}\" method=\"{$this->_method}\" {$enctype} {$formAttributes} class=\"{$elementClasses}\">";
        $currentFieldset = NULL;

        if (count($this->_inputElements)) {
            foreach ($this->_inputElements as $element) {
                if ($element[1] !== NULL) {
                    if ($element[1] !== $currentFieldset) {
                        if ($currentFieldset !== NULL)
                            $html .= "</fieldset>";
                        $fieldset = $this->_fieldsets[$element[1]];
                        $fieldsetAttributes = $this->_renderAttributes($fieldset[1]);
                        $html .= "<fieldset {$fieldsetAttributes}><legend>{$fieldset[0]}</legend>";
                        $currentFieldset = $element[1];
                    }
                } else {
                    if ($currentFieldset !== NULL)
                        $html .= "</fieldset>";
                }
                $html .= $this->renderElement($element[0]->getName());
                $currentFieldset = $element[1];
            }
        }
        if (count($this->_hiddenElements)) {
            foreach ($this->_hiddenElements as $element) {
                $html .= $this->renderElement($element->getName());
            }
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

        $divError = $hasMessages ? "error" : "";
        $html = "<div class=\"row\">";
        $html .= "<div class=\"large-12 columns {$divError}\">";
        $html .= "<label for=\"{$element->getName()}\">{$element->getLabel()}";
        $html .= $this->render($element->getName());
        $html .= "</label>";
        if ($hasMessages)
            $html .= "<small class=\"error\">{$messages[0]}</small>";
        $html .= "</div>";
        $html .= "</div>";
        return $html;
    }

    /**
     * Render in HTML an element of type Check
     * @param \Phalcon\Forms\ElementInterface $element
     * @return string
     */
    function _renderCheck($element) {
        $messages = $this->getMessagesFor($element->getName());
        $hasMessages = count($messages) > 0 ? TRUE : FALSE;

        $divError = $hasMessages ? "error" : "";
        $html = "<div class=\"row\">";
        $html .= "<div class=\"large-12 columns {$divError}\">";
        $html .= $this->render($element->getName());
        $html .= "<label for=\"{$element->getName()}\">{$element->getLabel()}</label>";
        if ($hasMessages)
            $html .= "<small class=\"error\">{$messages[0]}</small>";
        $html .= "</div>";
        $html .= "</div>";
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

        $divError = $hasMessages ? "error" : "";
        $html = "<div class=\"row\">";
        $html .= "<div class=\"large-12 columns {$divError}\">";
        $html .= $this->render($element->getName());
        $html .= "<label for=\"{$element->getName()}\">{$element->getLabel()}</label>";
        if ($hasMessages)
            $html .= "<small class=\"error\">{$messages[0]}</small>";
        $html .= "</div>";
        $html .= "</div>";
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
        $elementClasses = "button small secondary " . $element->getAttribute("class", "");
        $element->setAttribute("class", $elementClasses);
        $html = $this->render($element->getName());
        return $html;
    }

}
