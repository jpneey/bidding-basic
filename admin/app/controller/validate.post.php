<?php

foreach($required as $field) {
    ${$field} = Sanitizer::filter($field, "post");
    if(!${$field}) { $error[] = "{$field}"; }
}

if(!empty($error)) {
    echo json_encode(array("code" => 0, "message" => "Field (".implode(", ", $error).") can't be empty."));
    die();
}