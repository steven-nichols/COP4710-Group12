<?php
function select_write_option($value, $label, $default=null){
    echo '<option value="'.$value.'"';
    if(($default == $value) || (set_value('type') == $value))
        echo ' selected="yes"';
    echo '>'.$label."</option>\n";
}
?>
