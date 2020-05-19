<?php
/* check plugin install */
function azpswc_is_plugins_active( $pl_file_path = NULL ){
    $installed_plugins_list = get_plugins();
    return isset( $installed_plugins_list[$pl_file_path] );
}

/* Add inline CSS */
function azpswc_add_inline_css($property, $opt_name,  $selectors = array() ){
    $value = azpswc_get_option($opt_name, 'azpswc_settings_styling');

    if($value){
        $selectors = implode(',', $selectors);
        return "$selectors{
            $property: {$value};
        }";
    }

    return null;
}