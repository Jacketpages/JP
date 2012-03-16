<?php
header('Content-type: ' . $file['Charter']['type']);
if(!isset($inpage)) header('Content-Disposition: attachment; filename="'.$file['Charter']['name'].'"');
echo $content_for_layout;
die();
?>