<?php
function escape($string_input) {
  return htmlentities($string_input, ENT_QUOTES, 'UTF-8');
}
?>