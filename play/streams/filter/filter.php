<?php

// print_r( filter_list() );exit;

// Write encoded data
file_put_contents("php://filter/write=string.rot13/resource=file://D:\somefile.txt","Hello World");

// Read data and encode/decode
readfile("php://filter/read=string.toupper|string.rot13/resource=file://D:\somefile.txt");

