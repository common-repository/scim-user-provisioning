<?php
require_once('mo-scim-user-provisioner-attribute-mapping.php');
function user_provisioning(){
    $currenttab = "";
    if ( array_key_exists( 'tab', $_GET ) ) {
        $currenttab = sanitize_text_field($_GET['tab']);
    }
    else{
        $currenttab='sp_config';
    }

    ?>

    <div id="msup_scim_up_settings">
        <div class="wrap">
        <h1> SCIM user provisioning&nbsp;
        <a class="add-new-hover add-new-h2 " style="background-color: orange !important; border-color: orange; font-size: 16px; color: #000;" href="https://plugins.miniorange.com/wordpress-user-provisioning" target="_blank"> Upgrade now </a> 

                <a class="add-new-h2" href="https://faq.miniorange.com/kb/saml-single-sign-on/" target="_blank">FAQs</a>
                <a class="add-new-h2" href="https://forum.miniorange.com/" target="_blank">Ask questions on our forum</a>
            </h1>
        </div>
        <div class="miniorange_container">
            <table style="width:100%;">
                <tr>
                    <h2 class="nav-tab-wrapper">
                        <a class="nav-tab <?php if ( $currenttab == 'sp_config' ) {
                            echo 'nav-tab-active';
                        } ?>"
                           href="admin.php?page=user_provisioning&tab=sp_config">SCIM Configuration</a>

                        <a class="nav-tab <?php if ( $currenttab == 'attribute_mapping' ) {
                            echo 'nav-tab-active';
                        } ?>"
                           href="admin.php?page=user_provisioning&tab=attribute_mapping">Attribute Mapping</a>

                        <a class="nav-tab <?php if ( $currenttab == 'troubleshooting' ) {
                            echo 'nav-tab-active';
                        } ?>"
                           href="admin.php?page=user_provisioning&tab=troubleshooting">Troubleshooting</a>
                            
                     </h2>
                    <td style="vertical-align:top;width:65%;">
                        <?php  
                        if ( $currenttab == 'sp_config' ) {
                            msup_scim_user_provisioning_configuration();
                        } elseif($currenttab == 'attribute_mapping'){
                            msup_custom_attribute_mapping();
                            msup_buddypress_attribute_mapping();
                        }elseif ( $currenttab == 'troubleshooting') {
                            scim_user_provisioning_troubleshooting();
                        }
                        ?>
                    </td>
                    <td style="vertical-align:top;padding-left:1%;">
                        <?php
                        if($currenttab=='attribute_mapping'){
                            echo msup_scim_display_attrs_list();
                        } else{
                            echo msup_support_user_provisioning();
                        }
                        ?>
                    </td>
                </tr>
            </table>
        </div>
        <?php
}
       
/*shows user plugin configuration */

function msup_scim_user_provisioning_configuration() {
    global $wpdb;

    ?>
    <div class="msup_table_layout">
        
            <div class="msup_scim_up_table_layout" style="padding-bottom:10px;!important">
                <h3>Prerequisites:
                    <span>
                    <a id = "instruct_btn" class="btn btn-primary" style= "float:right;font-size:13pt;cursor:pointer; width:5%;" onclick="collapseDiv()">
                    <?php
                    echo '
                    <img id = "img_btn" style = "width:60%;" src="'.plugins_url( 'images/down_arrow_icon.png', __FILE__ ).'" />';
                    ?>
                    </a>
                    </span>
                </h3>
                
                <div id="instructions" style="display:none;">
                    <hr>
                    <ol>
                    <li>Minimum PHP version: 5.4.0 . </li>
                    <li>Enable PHP HTTP Authorization Header</li>
                        <p>To enable this option you would need to edit your .htaccess file by adding the following code :</p>
                        <code style = "padding : 1px 5px 2px 0px">RewriteEngine on</br>RewriteCond %{HTTP:Authorization} ^(.*)</br>RewriteRule ^(.*) - [E=HTTP_AUTHORIZATION:%1]</code>
                        <p></p>
                        <b>Enable WP ENGINE</b>
                        <p>To enable this option you would need to edit your .htaccess file by adding the following code :&nbsp</p>
                        <code style = "padding : 1px 5px 2px 0px">SetEnvIf Authorization "(.*)"</br>HTTP_AUTHORIZATION=$1</code>
                        </p></p>
                        <b>Enable Bitnami</b>
                        <p>To enable this option you would need to edit your .htaccess file by adding the following code :</p>
                        <code style = "padding : 1px 5px 2px 0px">SetEnvIf Authorization "(.*)"</br>HTTP_AUTHORIZATION=$1</code>
                        <p>You can also check this issue using this <a href ="https://community.bitnami.com/t/need-to-pass-authorization-headers/44690" target="_blank">Link</a>.<p>
                    </ol>
                </div>
            </div>
            <?php           
            $scim_idp_name = !empty(get_site_option('msup_scim_idp_name')) ? get_site_option('msup_scim_idp_name') : 'okta';
        echo '  <div class="msup_scim_up_table_layout" style="padding-bottom:50px;!important">
                <div style="display:block;margin-top:10px;background-color:rgba(255, 255, 255, 255);padding:5px;border:solid 1px rgba(255, 255, 255, 255);">
                <h2>SCIM Configuration</h2><hr>';

                echo '
                <form id="msup_scim_idp_name" name="msup_scim_idp_name" method="post" action="">
                <input type="hidden" name="option" value="msup_scim_idp_name">' ;
                wp_nonce_field('msup_scim_idp_name');
                echo'
                </br>
                <table width="60%">
                <tr><td style="30%"><b>Select your Identity provider:</b></td>
                <td><select name="msup_scim_idp_name" onChange= "document.getElementById(\'msup_scim_idp_name\').submit()" style="width: 100%">
                <option value="azuread"';
                if($scim_idp_name == 'azuread')
                    echo ' selected ';
                    echo '>AzureAD</option>
                <option value="centrify"';
                if($scim_idp_name == 'centrify')
                    echo ' selected ';
                    echo'>Centrify</option>
                <option value="google-apps"';
                if($scim_idp_name == 'google-apps')
                    echo ' selected ';
                    echo '>GoogleApps</option> 
                    <option value="JumpCloud"';
                if($scim_idp_name == 'JumpCloud')
                            {echo ' selected ';}
                echo '>JumpCloud</option>
        
                <option value="MiniOrange"';
                if($scim_idp_name == 'MiniOrange')
                            {echo ' selected ';}
                echo '>MiniOrange</option>
                <option value="okta"';
                if($scim_idp_name == 'okta')
                    echo ' selected ';
                    echo '>Okta</option>
                <option value="onelogin"';
                if($scim_idp_name == 'onelogin')
                    echo ' selected ';
                    echo'>OneLogin</option>
                <option value="pingone"';
                if($scim_idp_name == 'pingone')
                    echo ' selected ';
                    echo '>PingOne</option>
                <option value="other"';
                if($scim_idp_name == 'other')
                    echo ' selected ';
                    echo '>Other</option>';
                if($scim_idp_name=='other')
                    $scim_idp_name='okta';
                    echo '>Other</option>
    </select></td> <td style="padding-left:5%"> <a class="button button-primary" id ="link_to_guide" style="margin-left :5%,margin-top:5% " 
    cursor: pointer; " href=';
    if($scim_idp_name == 'MiniOrange'){
        echo '"https://plugins.miniorange.com/wordpress-scim-user-provisioning"'; 
    } 
    else { 
        echo '"https://plugins.miniorange.com/wordpress-scim-user-provisioning-with-'.$scim_idp_name.'"';
    }
    echo 'target="_blank">Click here for guide</a> </td>
                </tr>
                <tr><td><br/></td></tr>
                <tr><td></td><td colspan="2" >';

            echo'
            </td></tr>
            </table></br>
            <b>Select your Identity Provider from the list below, and you can find the link to the guide for setting up SCIM Provisioning below.</b>
            <br/><br/>
            </form>';
            echo '
                <div id="msup_saml_idps_grid_div" style="position: relative">
                    <ul>
                        <li><a style="cursor: pointer" target="_blank" href="https://plugins.miniorange.com/wordpress-scim-user-provisioning-with-azuread"><img src="'.plugins_url( 'images/idp-guides-logos/azure-ad.png', __FILE__ ).'"/><br><h4>AzureAD</h4></a></li>
                        <li><a style="cursor: pointer" target="_blank" href="https://plugins.miniorange.com/wordpress-scim-user-provisioning-with-centrify"><img src="'.plugins_url( 'images/idp-guides-logos/centrify.png', __FILE__ ).'" /><br><h4>Centrify</h4></a></li>
                        <li><a style="cursor: pointer" target="_blank" href="https://plugins.miniorange.com/wordpress-scim-user-provisioning-with-google-apps"><img src="'.plugins_url( 'images/idp-guides-logos/google-apps.png', __FILE__ ).'" /><br><h4>GoogleApps</h4></a></li>
                        <li><a style="cursor: pointer" target="_blank" href="https://plugins.miniorange.com/wordpress-scim-user-provisioning-with-jumpcloud"><img src="'.plugins_url( 'images/idp-guides-logos/jumpCloud.png', __FILE__ ).'" /><br><h4>JumpCloud</h4></a></li>
                        <li><a style="cursor: pointer" target="_blank" href="https://plugins.miniorange.com/wordpress-scim-user-provisioning"><img src="'.plugins_url( 'images/idp-guides-logos/miniOrange.png', __FILE__ ).'" /><br><h4>MiniOrange</h4></a></li>
                        <li><a style="cursor: pointer" target="_blank" href="https://plugins.miniorange.com/wordpress-scim-user-provisioning-with-okta"><img src="'.plugins_url( 'images/idp-guides-logos/okta.png', __FILE__ ).'"/><br><h4>Okta</h4></a></li>
                        <li><a style="cursor: pointer" target="_blank" href="https://plugins.miniorange.com/wordpress-scim-user-provisioning-with-onelogin"><img src="'.plugins_url( 'images/idp-guides-logos/onelogin.png', __FILE__ ).'" /><br><h4>OneLogin</h4></a></li>
                        <li><a style="cursor: pointer" target="_blank" href="https://plugins.miniorange.com/wordpress-scim-user-provisioning-with-pingone"><img src="'.plugins_url( 'images/idp-guides-logos/pingone.png', __FILE__ ).'" /><br><h4>PingOne</h4></a></li>
                       </ul>
                </div>
            ';
      echo'     
                <form name="f" style="margin-left:6px;" method="post" action="" >
                    <input type="hidden" name="option" value="generate_new_token_option" />
                    <h3>SCIM API Credentials: </h3>
                    ';
                    wp_nonce_field('generate_new_token_option');
                    //-----------------------------------------------------
                 echo ' <table border="1" style="background-color:#FFFFFF; border:1px solid #CCCCCC; padding:0px 0px 0px 10px; margin:2px; border-collapse: collapse; width:98%">
                    <tr>
                        <td style="width:40%; padding: 15px;"><b>SCIM Base URL</b></td>';
                            echo '<td style="width:60%; padding: 15px;">'. site_url() . '/scim</td>';
                    echo '</tr>';
                    echo '<tr>
                        <td style="width:40%; padding: 15px;"><b>SCIM Bearer Token</b> <span style="padding-left:16px;"><input type="submit" class="button" value="Generate New token"></span></td>';
                        $hideToken = false;

                        $bearer_token = '';
                        if(get_site_option('msup_scim_up_bearer_token') == "")
                        {
                            $bearer_token=msup_create_bearer_token();
                        }

                        else
                        {
                            $bearer_token = '•••••••••••••••••••••••••••••••••';
                            $hideToken = true;
                        }

                        echo '<td style="width:60%; padding: 15px;" id = "copyTokenRow" value = "'.$bearer_token.'">'. $bearer_token . '';

                        if($hideToken == false){
                            echo '      <button type="button" onclick="copyToken()" id = "copyTokenButton" value = "'.$bearer_token.'"><img style = "" src="'.plugins_url( 'images/copy-icon.png', __FILE__ ).'" /></button></td>';
                        }
                        else{
                            echo '</td>';
                        }
                            
                    echo '</tr>';
                    //----------------------------
                echo '</table>';
        echo '</div></div></div></form>';
        echo '<div class="msup_scim_up_table_layout" style="padding-bottom:50px;!important">
                <div style="display:block;margin-top:10px;background-color:rgba(255, 255, 255, 255);padding:5px;border:solid 1px rgba(255, 255, 255, 255);">
                <h2>SCIM Operations</h2><hr>
                <form name="f" style="margin-left:6px;" method="post" action="" id="blockedpagesform">
                    <input type="hidden" name="option" value="" />';
                    //-----------------------------------------------------
                 echo ' <table border="1" style="background-color:#FFFFFF; border:1px solid #CCCCCC; padding:0px 0px 0px 10px; margin:2px; border-collapse: collapse; width:98%">
                    <tr>
                    <b>Provisioning:</b>
                    <ol>
                    <b>Create: </b></ol>
                    <ol>It will create user using First Name, Email and Username.<br/>
                    <b>Note: </b>If Username field is blank, it will copy email as a username, as WordPress does not accept blank Username.</ol>
                    ';

                    echo'
                    <ol><label>
                    <input type="checkbox" style="background: #DCDAD1;cursor: not-allowed;" disabled/><span style="color: red;">*</span>
                    <b>Update </b>
                    <sup style="font-size: 12px;">[Available in <a
                    href="https://plugins.miniorange.com/wordpress-user-provisioning">Premium</a> plans]</sup>
                    </ol>
                    <ol>It will update user using First Name, Email and Username.<br/>
                    <b>Note: </b>If Username field is blank, it will copy email as a username, as WordPress does not accept blank Username.</ol>
                    </br>
                    <input type="hidden" name="option" value="msup_scim_deprovision_user_option">
                    <b>De-provisioning:</b><br/><br/>
                    Enable the following option to allow de-provisioning of admin users:
                    ';
                

                    echo ' 
                    <ol><label>
                    <input type="checkbox" style="background: #DCDAD1;cursor: not-allowed;" disabled/><span style="color: red;">*</span>
                    <b>Enable De-Provisioning for Administrators &nbsp</b>
                    <sup style="font-size: 12px;">[Available in <a
                    href="https://plugins.miniorange.com/wordpress-user-provisioning">Premium</a> plans]</sup>
                    </ol>
                    <ol>
                    By default, De-provisioning will delete the users from the WordPress site.<br/>
                    Instead of this, you can enable the following option to deactivate the deprovisioned users. A deactivated user will not be able to log into the site.
                    </ol>
                    ';
                    
                    echo '
                    <ol><label>
                    <input type="checkbox" style="background: #DCDAD1;cursor: not-allowed;" disabled/><span style="color: red;">*</span>
                    <b>Deactivate Users &nbsp</b>
                    <sup style="font-size: 12px;">[Available in <a
                    href="https://plugins.miniorange.com/wordpress-user-provisioning">Premium</a> plans]</sup>
                    </ol>';
                    
                    echo '
                    <ol><label>
                    <input type="checkbox" style="background: #DCDAD1;cursor: not-allowed;" disabled/><span style="color: red;">*</span>
                    <b>Delete Users &nbsp</b>
                    <sup style="font-size: 12px;">[Available in <a
                    href="https://plugins.miniorange.com/wordpress-user-provisioning">Premium</a> plans]</sup>
                    </ol>
                    <ol>
                    It will delete user using Email and Username in Wordpress site when you de-provision the same user in your IdP.
                    </ol>
                    </form>
                    ';
                         
                    echo '</tr>';


                    
                    //----------------------------
                echo '</table>';

        echo '</div></div>';
        //--------------------------------------------------------------
    }

    function scim_user_provisioning_troubleshooting() {
    global $wpdb;
    ?>
    <div class="msup_table_layout">
            <?php
        {

        echo '<div class="msup_scim_up_table_layout" style="padding-bottom:50px;!important">
                <div style="display:block;margin-top:10px;background-color:rgba(255, 255, 255, 255);padding:5px;border:solid 1px rgba(255, 255, 255, 255);">
                <h2>Troubleshooting: </h2><hr>';
    
                 echo ' <table border="1" style="background-color:#FFFFFF; border:1px solid #CCCCCC; padding:0px 0px 0px 10px; margin:2px; border-collapse: collapse; width:98%">
                    <tr><ol><h3><li>Provisioning status is <b>Failed</b>.</li></h3><b><h3>Solution.</h3></b> Make sure you have configured the IDP correctly as per given in the IDP Settings tab.<br/>If for all users you are getting Failed status, then check if you have entered User Info(First Name, Email, Username(Optional)) correctly and added the application with default setting.<br/>If for all users you are getting provisioning as Failed, then verify App Configuration setting.</ol>';

                    echo '</tr>';
                    //----------------------------
                echo '</table>';
        echo '</div></div></div></form>';
        //-----------------
    }
}

function msup_create_bearer_token(){
            $bearer_token = bin2hex(random_bytes(32));
            update_site_option('msup_scim_up_bearer_token',convert_uuencode($bearer_token));
            return $bearer_token;
}

function msup_scim_user_provisioning_validate() {
    if(strpos($_SERVER['REQUEST_URI'], "/scim") !== false) {
        
        $get_bearer = get_site_option('msup_scim_up_bearer_token');
        $bearer_token = convert_uudecode($get_bearer);

        $bearer = getBearerToken();

        if($bearer!==$bearer_token) {
            throwError(401,'Unauthorized');
        }

        $post = file_get_contents('php://input');
        $json = json_decode($post, true);

        $scimUserId = '';
        $scimGroupId = '';
        $isUserProvsioningRequest = false;
        $isGroupProvisioningRequest = false;

        if(strpos($_SERVER['REQUEST_URI'], "/scim/Users") !== false || strpos($_SERVER['REQUEST_URI'], "/scim/v2/Users") !== false){
            $isUserProvsioningRequest = true;
			 
        }

		if(strpos($_SERVER['REQUEST_URI'], "/scim/Users/") !== false || strpos($_SERVER['REQUEST_URI'], "/scim/v2/Users/") !== false){
            $scimUserId=substr($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'], "Users/")+6);
            $externalId =$scimUserId;           
        }

        if(strpos($_SERVER['REQUEST_URI'], "/scim/Users/") !== false || strpos($_SERVER['REQUEST_URI'], "/scim/v2/Users/") !== false){
            $scimUserId=substr($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'], "Users/")+6);
        }

        if($isUserProvsioningRequest  && !empty($json)){
            msup_scim_handle_user_request($json, $scimUserId);
        }
	
        if(empty($json) && $scimUserId !=''){
            $user =get_user_by( 'id', $scimUserId );
            if($user){
                $login_value=$user->user_email?$user->user_email : $user->user_login;
                $send_query = "{
                    \"schemas\": [\"urn:ietf:params:scim:schemas:core:2.0:User\"],
                    \"id\": \"[$user->ID]\",
                    \"externalID\": \"$user->user_login\", 
                    \"meta\": {
                        \"resourceType\": \"User\"},
                    \"userName\": \"$user->user_login\",
                    \"active\": \"true\",
                    \"emails\": [{
                        \"primary\": true,
                        \"value\": \"$login_value\",
                        \"type\": \"work\"
                    }]   
                }";
                
                header("HTTP/1.1 200 OK");
                header('Content-Type: application/json;charset=utf-8');
                echo $send_query ;
                exit;
            }
            else{
                $json = '{
                    "schemas": [
                                "urn:ietf:params:scim:api:messages:2.0:Error"
                                    ],
                    "status": "404",
                    "detail": "Resource not found"
                }';
               header("HTTP/1.1 404 Not Found");
               header('Content-Type: application/json;charset=utf-8');
               echo $json ;
               exit();
            }
        }

        else {
        $vaildate ='{
                 "schemas": ["urn:ietf:params:scim:api:messages:2.0:ListResponse"],
                "totalResults": 0,
                "startIndex": 1,
                "itemsPerPage": 0,
                "Resources": []
            }';
        header("HTTP/1.1 200 OK");
        header('Content-Type: application/json;charset=utf-8');

        echo $vaildate;

        exit;
        }
    }
}

function msup_scim_handle_user_request($json, $scimid){
    $username = sanitize_text_field($json['userName']);
    $givenName = sanitize_text_field($json['name']['givenName']);
    $email = sanitize_email($json['emails'][0]['value']);
    $lastName = sanitize_text_field($json['name']['familyName']);
    if(empty($username))
        $username = $email;
    $uid = username_exists($username);

    if((strpos($_SERVER['REQUEST_METHOD'], "PUT") !== false || strpos($_SERVER['REQUEST_METHOD'], "PATCH") !== false ) and !empty($scimid)) {
        wp_update_user( array('ID' => $uid, 'first_name' => $givenName,'last_name'=>$lastName) );
        if (isset($json['active']) && !empty($json['active'])){                     
            $active = $json['active'];
        }
        elseif (isset($json['Operations'][0]['path'])) {                          
            if ($json['Operations'][0]['path'] == 'active' ) {
                $active = $json['Operations'][0]['value'];
            }
        } elseif(isset($json['Operations'][0]['value']['active'])){         
            $active = $json['Operations'][0]['value']['active'];
        } else {
            $active = 'update';
        }


        $user = get_user_by('id', $scimid);
        send_user_details($user, true);

    } elseif(strpos($_SERVER['REQUEST_METHOD'], "POST") !== false)  {
        if(username_exists($username) || email_exists($email)){     
            if(username_exists($username)){
                $user = get_user_by('login', $username);
                $uid = $user->ID;
                if( !empty($email) )
                    $updated = wp_update_user( array( 'ID' => $uid, 'user_email' => $email ) );
            } else if(email_exists($email)){
                $user   = get_user_by('email', $email );
                $uid = $user->ID;
            }
            wp_update_user( array('ID' => $uid, 'first_name' => $givenName,'last_name'=>$lastName) );
            update_user_meta($uid, 'msup_scim_user_status', 'active');
            $json['id'] = $uid;
            $json['meta'] = array('resourceType' => 'User');
            $json = json_encode($json);
            header("HTTP/1.1 201 Created");
            header('Content-Type: application/json;charset=utf-8');
            echo $json;
            exit;
        } else { 
            if(get_site_option('msup_scim_show_attribute')==1)
            {
                update_site_option('msup_scim_test_config_attrs',$json);
            }
            $random_password = wp_generate_password( 10, false );
            if(isset($json['password']) and !empty($json['password'])){
                $scim_password = $json['password'];
            }
            if(!empty($scim_password))
                $random_password = $scim_password;
            $uid = wp_create_user( $username, $random_password, $email );
            if($uid){
                wp_update_user( array('ID' => $uid, 'first_name' => $givenName) );
                update_user_meta($uid, 'msup_scim_user_status', 'active');
                $json['id'] = $uid;
            $json['meta'] = array('resourceType' => 'User');
            $json = json_encode($json);
            header("HTTP/1.1 201 Created");
            header('Content-Type: application/json;charset=utf-8');
            echo $json;
            exit;
            }
        }
    }  
}

function is_admin_user($user_id){
    global $wpdb;
    $cap = get_user_meta( $user_id, $wpdb->get_blog_prefix() . 'capabilities', true );
    if ( is_array( $cap ) && !empty( $cap['administrator'] ) )
        return true;
    else
        return false;
}

function send_user_details($user, $active){
        $json = '{
            "schemas": ["urn:ietf:params:scim:schemas:core:2.0:User"],
            "id": "'.$user->ID.'",
            "userName": "'.$user->user_login.'",
            "active": '.$active.',
            "emails": [{
                "primary": true,
                "value": "'.$user->user_email.'",
                "type": "work",
                "display": "'.$user->user_email.'"
            }],
            "groups": [],
            "meta": {
                "resourceType": "User"
            }
        }';
        header("HTTP/1.1 200 OK");
        header('Content-Type: application/json;charset=utf-8');
        echo $json;
        exit;
}

function getAuthorizationHeader(){
                $headers = null;
                if (isset($_SERVER['Authorization'])) {
                    $headers = trim($_SERVER["Authorization"]);
                }
                else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
                    $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
                } elseif (function_exists('apache_request_headers')) {
                    $requestHeaders = apache_request_headers();
                    // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
                    $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
                    //print_r($requestHeaders);
                    if (isset($requestHeaders['Authorization'])) {
                        $headers = trim($requestHeaders['Authorization']);
                    }
                }
                if($headers === null){
                    throwError(401,'ERROR:0005 Authorization header missing');
                }
                return $headers;
            }

function throwError( $statusCode,$description ) {
        header( "Content-Type: application/json",true,$statusCode );
        exit( json_encode( array(
            'schemas' => array( "urn:ietf:params:scim:api:messages:2.0:Error" ),
            'detail'  => $description,
            'status'  => $statusCode
        ) ) );
    }

function getBearerToken() {
    $headers = getAuthorizationHeader();
    if (!empty($headers)) {
        if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
            return $matches[1];
        }
    }
    return null;
}

function msup_support_user_provisioning() {
    ?>
    <div class="msup_scim_up_support_layout">
        <div>
            <h3>Support</h3>
            <p>Need any help? We can help you with configuring your Identity Provider. Just send us a query and we will
                get back to you soon.</p>
            <form method="post" action="">
                <?php wp_nonce_field('msup_scim_up_contact_us_query_option');?>
                <input type="hidden" name="option" value="msup_scim_up_contact_us_query_option"/>
                <table class="msup_scim_up_settings_table">
                    <tr>
                        <td><input style="width:95%" type="email" class="msup_scim_up_table_textbox" required
                                   name="msup_scim_up_contact_us_email"
                                   value="<?php echo get_site_option( "msup_scim_up_admin_email" ); ?>"
                                   placeholder="Enter your email"></td>
                    </tr>
                    <tr>
                        <td><input type="tel" style="width:95%" id="contact_us_phone"
                                   pattern="[\+]\d{11,14}|[\+]\d{1,4}[\s]\d{9,10}" class="msup_scim_up_table_textbox"
                                   name="msup_scim_up_contact_us_phone"
                                   value="<?php echo get_site_option( 'msup_scim_up_admin_phone' ); ?>"
                                   placeholder="Enter your phone"></td>
                    </tr>
                    <tr>
                        <td><textarea class="msup_scim_up_table_textbox" style="width:95%" onkeypress="msup_scim_up_valid_query(this)"
                                      onkeyup="msup_scim_up_valid_query(this)" onblur="msup_scim_up_valid_query(this)" required
                                      name="msup_scim_up_contact_us_query" rows="4" style="resize: vertical;"
                                      placeholder="Write your query here"></textarea></td>
                    </tr>
                </table>
                <div style="text-align:center;">
                    <input type="submit" name="submit" style="margin:15px; width:120px;"
                           class="button button-primary button-large"/>
                </div>
            </form>
        </div>
    </div>
    <?php
        $imgpathDown = plugins_url( 'images/down_arrow_icon.png', __FILE__ );
        $imgpathUp = plugins_url( 'images/up_arrow_icon.png', __FILE__ );
    ?>
    <script>
    function collapseDiv(){
        const targetDiv = document.getElementById("instructions");
        const img_btn = document.getElementById("img_btn");

        if (targetDiv.style.display !== "none") {
            targetDiv.style.display = "none";
            var x = "<?php echo $imgpathDown;?>";
            img_btn.src = x;
        } else {
            targetDiv.style.display = "block";
            var y = "<?php echo $imgpathUp;?>";
            img_btn.src = y;
        }
    }

    function copyToken() {
        var copyText = document.getElementById("copyTokenButton").value;
        navigator.clipboard.writeText(copyText);
    }

    function myFunction() {
        var x = document.getElementById("msup_scim_idp_name").value;
        if (x=='other'){
            x='onelogin';
        }
        document.getElementById("link_to_guide").href = "https://plugins.miniorange.com/wordpress-scim-user-provisioning-with-"+x;
    }

    jQuery("#contact_us_phone").intlTelInput();
    jQuery("#phone_contact").intlTelInput();

    function msup_scim_up_valid_query(f) {
        !(/^[a-zA-Z?,.\(\)\/@ 0-9]*$/).test(f.value) ? f.value = f.value.replace(
        /[^a-zA-Z?,.\(\)\/@ 0-9]/, '') : null;
    }
    </script>
<?php    
}?>
