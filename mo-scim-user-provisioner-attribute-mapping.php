<?php
require_once('mo-scim-user-provisioner-menu-settings.php');
require_once('mo-scim-user-provisioner-save.php');

function msup_custom_attribute_mapping(){
    ?>
    <div class="msup_table_layout">
        <div class="msup_scim_up_table_layout" style="padding-bottom:10px;!important">
            <h3>Attribute Mapping</h3>
            <hr>
			Map extra IDP attributes which you wish to be included in the user profile.
            <p><b>NOTE: </b>Customized Attribute Mapping means you can map any attribute of the IDP to the attributes of <b>user-meta</b> table of your database.</p>
			<p>Enable the toggle for an attribute if you want to display it in the Wordpress <a href="' . get_admin_url() . 'users.php">Users</a> table.</p>
			<br/>

            <input type="button" name="add_attribute" value="Add Attribute" onClick="add_custom_attribute(this)" class="button button-primary button-large" disabled>
            <sup style="font-size: 12px;">
                [Available in <a href="https://plugins.miniorange.com/wordpress-user-provisioning">Premium</a> plans]
            </sup>
            <br/>
            <br/>
            <table id="myTable" width="100%" style="background-color:#FFFFFF; padding:0px 0px 0px 10px;">
                <tr>
					<td style="text-align:left;padding-left:15px"><b>Custom Attribute Name</b></td>
					<td style="padding-left:35px;"><b>Attribute Name from IDP</b></td>
					<td style="text-align: center;"><b>Show Attribute</b></td>
					<td></td>
                </tr>
                <tr>
                    <td><input type="text" name="mo_scim_custom_attribute_keys[]" placeholder="Custom attribute name" disabled></td>
                    <td><select name="mo_scim_custom_attribute_values[]" style="width:90%;" disabled><option value="">--Select an Attribute--</option></select></td>
                    <td style="text-align: center;">
                        <label class="switch">
                            <input type="checkbox" disabled>
                            <span class="slider round"></span>
                        </label>
                    </td>
                    <td><input type="button" value="X" onClick="removeRow(this)" class="button button-primary button-large" style="float:right;" disabled></td>
                </tr>
            </table>
            </br>
            <input type="submit" style="width:100px;" name="submit" value="Save"  class="button button-primary button-large" disabled>
        </div>
    </div>
    <?php    
}

function msup_buddypress_attribute_mapping(){
    ?>
    <div class="msup_table_layout">
        <div class="msup_scim_up_table_layout" style="padding-bottom:10px;!important">
            <h3>BuddyPress Custom Attributes</h3>
            <hr>
			Map SAML attribute with the BuddyPress attributes which you wish to be included in the user profile.
            <p><b>NOTE: </b>You can check the Test Configuration results to get a better idea as to which values to map here.
            Once the Test Configuration is successful you can configure Attribute Name from Test configuration window to BuddyPress.
            </p>
			<br/>

            <input type="button" name="add_attribute" value="Add Attribute" onClick="add_custom_attribute(this)" class="button button-primary button-large" disabled>
            <sup style="font-size: 12px;">
                [Available in <a href="https://plugins.miniorange.com/wordpress-user-provisioning">Premium</a> plans]
            </sup>
            <br/>
            <br/>
            <table id="myTable" width="100%" style="background-color:#FFFFFF; padding:0px 0px 0px 0px;">
                <tr>
					<td style="text-align:left"><b>Buddypress Attribute Name</b></td>
					<td style=""><b>Attribute Name from IDP</b></td>
					<td></td>
                </tr>
                <tr>
                    <td>
                        <?php
                            if (function_exists('bp_is_active')){
                                global $wpdb;
                                $bp_xprofile_fields = $wpdb->prefix . "bp_xprofile_fields";
                                $reg_bp = $wpdb->get_results( "SELECT * FROM $bp_xprofile_fields WHERE parent_id = 0;" );
                                echo '<select name="mo_scim_custom_attribute_keys_bp[]" id="mo_scim_custom_attribute_keys_bp[]" style="width:70%;" disabled>';
                                foreach ($reg_bp as $field) {
                                    echo '<option value='.$field->name.'>'.$field->name.'</option>';
                                }
                                echo '</select>';
                            }
                            
                            else{
                                echo '
                                <select name="mo_scim_custom_attribute_keys_bp[]" id="mo_scim_custom_attribute_keys_bp[]" style="width:70%;" disabled>
                                <option value="">--Select an BuddyPress Attribute--</option>
                                </select>
                                ';
                            }
                        ?>
                    </td>
                    <td><select name="mo_scim_custom_attribute_values[]" style="width:90%;" disabled><option value="">--Select an Attribute--</option></select></td>
                    <td><input type="button" value="X" onClick="removeRow(this)" class="button button-primary button-large" style="float:right;" disabled></td>
                </tr>
            </table>
            </br>
            <input type="submit" style="width:100px;" name="submit" value="Save"  class="button button-primary button-large" disabled>
        </div>
    </div>
    <?php    
}

function msup_scim_display_attrs_list() {
    echo '<div class="msup_scim_up_support_layout" style="padding-bottom:20px; padding-right:5px;">';

        echo'
        <h3>Show User Attribute when a user is created:</h3>
        <form id="msup_scim_show_attribute" name="msup_scim_show_attribute" method="post" action ="">';
        wp_nonce_field( 'msup_scim_show_attribute');
        echo'
        <input type="hidden" name="option" value="msup_scim_show_attribute">
        <label class="switch">';
            if(get_site_option( 'msup_scim_show_attribute' ) != 1){
                echo '<input type="checkbox" id="scim_test" name="msup_scim_show_attribute" onChange= "document.getElementById(\'msup_scim_show_attribute\').submit()">';
            } else{
                echo '<input type="checkbox" id="scim_test" name="msup_scim_show_attribute" onChange= "document.getElementById(\'msup_scim_show_attribute\').submit()" checked>';
            }
            echo'
            <span class="slider round"></span>
        </label>
        </form>
        </br>
        ';

    $idp_attrs = get_site_option( 'msup_scim_test_config_attrs' );
	if ( @maybe_unserialize( $idp_attrs ) ) {
		$idp_attrs = maybe_unserialize( $idp_attrs );
	}

    $json_attribute = json_encode($idp_attrs, JSON_PRETTY_PRINT);

	if ( ! empty( $idp_attrs )) {
        ?>
            <hr>
			<div id="test_user_attribute">
                <h3>Attributes received from the Identity Provider:</h3>
                <?php
                    echo '
                    <div id="test_user_attribute">';
                    echo "<pre>".$json_attribute."<pre/>";
                    echo'
                    </div>
                    </div>
                    ';
                echo '
                <input type="button" class="button-primary" value="Clear Attributes List" onclick="document.getElementById(\'msup_scim_up_clear_attribute\').submit();">
			    <p><b>NOTE :</b> Please clear this list after configuring the plugin to delete your confidential attributes.
                <br/>
			    Enable <b>Show User Attribute</b> to populate the list again when a user is created.</p>
			    <form method="post" action="" id="msup_scim_up_clear_attribute">';
                wp_nonce_field('msup_scim_up_clear_attribute');
                echo '
                    <input type="hidden" name="option" value="msup_scim_up_clear_attribute">
			    </form>
			</div>
		</div>';
	}
}
?>