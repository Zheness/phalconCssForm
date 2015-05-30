# phalconCssForm

**Sorry for my bad english, corrections are welcome**

These classes can be used to generate a form with a CSS Framework (Bootstrap, Foundation, Pure, etc.).

## Usage

Simply create a form class and extend it with one of the class.

```php
class SampleForm extends phalconCSSFormFoundation {
    {...}
}
```

And in the view, call `renderForm()`, to generate all the form.

Clone this repo and check the sampleForm example.

## Methods

```php
// Phalcon methods

setAction($method); // Sets the action of the form
add($element); // Add an element to the form

// phalconCssForm

setMethod($method); // Sets the method of the form
fileUpload($bool); // If true, add the enctype attribute on the form

setAttributes($attributes); // Sets the attributes of the form
startFieldset($legend, $attributes); // Open a fieldset, with optionnal attributes
endFieldset(); // Close a fieldset

// Form generation

renderElement($name); // Render an element
renderForm(); // Render all the form
```

## What's next ?

I will maybe improve these classes to add more generation.

Currently, only *normal*/*stacked* form is generated. I would like generate *inline*/*horizontal* form too.

Please feel free to clone this repo and add/edit classes if you want share your work !
