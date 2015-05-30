<?php

return new \Phalcon\Config(array(
    'application' => array(
        'controllersDir' => __DIR__ . '/../../app/controllers/',
        'viewsDir'       => __DIR__ . '/../../app/views/',
        'formsDir'     => __DIR__ . '/../../app/forms/',
        'baseUri'        => '/',
    )
));
