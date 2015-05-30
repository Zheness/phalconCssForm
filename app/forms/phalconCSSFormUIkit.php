<?php

trait phalconCSSFormUIkit {

    /**
     * 
     * @param \Phalcon\Forms\ElementInterface $element
     * @return bool
     */
    function _renderEmail($element) {
        $messages = $this->getMessagesFor($element->getName());
        $hasMessages = count($messages) > 0 ? TRUE : FALSE;

        $html = "<p><label for=\"{$element->getName()}\">{$element->getLabel()} aaaaaaa</label><br/>";
        $html .= $this->render($element->getName());
        $html .= "</p>";
        if ($hasMessages)
            $html .= "<p>{$messages[0]}</p>";
        return $html;
    }

}
