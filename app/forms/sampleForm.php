<?php

class SampleForm extends phalconCSSFormNone {

    public function initialize() {
        $this->setAttributes([
            "class" => "helloWorld"
        ]);

        $this->add($this->_email());
        $this->add($this->_text());
        $this->add($this->_password());
        $this->add($this->_select());
        $this->add($this->_checkbox());
        $this->add($this->_textarea());
        $this->add($this->_hidden());
        $this->add($this->_file());
        $this->add($this->_date());
        $this->add($this->_numeric());
        $this->add($this->_radio());
        $this->add($this->_submit());
    }

    private function _email() {
        $element = new \Phalcon\Forms\Element\Email("email", [
            "required" => "required",
            "maxlength" => 65
        ]);
        $element->setLabel("Email");
        $element->addValidator(new \Phalcon\Validation\Validator\Email());
        return $element;
    }

    private function _text() {
        $element = new \Phalcon\Forms\Element\Text("text", [
            "maxlength" => 55
        ]);
        $element->setLabel("Text");
        $element->addValidator(new \Phalcon\Validation\Validator\StringLength([
            "min" => 3,
            "max" => 55
        ]));
        return $element;
    }

    private function _password() {
        $element = new \Phalcon\Forms\Element\Password("pass");
        $element->setLabel("Password");
        $element->addValidator(new \Phalcon\Validation\Validator\PresenceOf());
        return $element;
    }

    private function _select() {
        $element = new \Phalcon\Forms\Element\Select("select");
        $element->setLabel("Select");
        $element->setOptions([
            "foo" => "value 1",
            "bar" => "value 2",
        ]);
        return $element;
    }

    private function _checkbox() {
        $element = new \Phalcon\Forms\Element\Check("check");
        $element->setLabel("Check");
        return $element;
    }

    private function _textarea() {
        $element = new \Phalcon\Forms\Element\TextArea("textarea", [
            "rows" => 8,
            "cols" => 100
        ]);
        $element->setLabel("Textarea");
        $element->addValidator(new \Phalcon\Validation\Validator\PresenceOf());
        return $element;
    }

    private function _hidden() {
        $element = new \Phalcon\Forms\Element\Hidden("hidden");
        $element->setDefault("foobar");
        return $element;
    }
    
    private function _file() {
        $element = new \Phalcon\Forms\Element\File("file");
        $element->setLabel("File");
        return $element;
    }
    
    private function _date() {
        $element = new \Phalcon\Forms\Element\Date("date");
        $element->setLabel("Date");
        return $element;
    }
    
    private function _numeric() {
        $element = new \Phalcon\Forms\Element\Numeric("numeric");
        $element->setLabel("Numeric");
        return $element;
    }
    
    private function _radio() {
        $element = new \Phalcon\Forms\Element\Radio("radio");
        $element->setLabel("Radio");
        return $element;
    }

    private function _submit() {
        $element = new \Phalcon\Forms\Element\Submit("submit");
        $element->setDefault("Send");
        return $element;
    }

}
