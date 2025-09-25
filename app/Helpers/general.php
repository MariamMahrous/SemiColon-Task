<?php

define('PAGINATION_COUNT',15);

 function saveImage($folder,$image){

    $image->store('/',$folder);
    $filename = $image->hashName();
    return $filename;
}

