<?php

include_once dirname(dirname(__FILE__)) . '/public/public.php';

dump($_POST);
dump($_FILES);

?>
<form action="" method="post" enctype="multipart/form-data">
<input type="file" name="attach" />
<input type="hidden" name="story" value="story"/>
<input type="submit"/>
</form>

<!-- 

enctype="multipart/form-data"

-->