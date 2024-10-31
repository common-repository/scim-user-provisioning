<?php
require_once("mo-scim-user-provisioner-class-customer.php");
function miniorange_save_setting_user_provisioning()
{
    $userProv = new scim_user_provisioner_add_on();
        if(msup_check_option_admin_referer('generate_new_token_option')){
            delete_site_option('msup_scim_up_bearer_token');
            update_site_option('msup_scim_up_message', 'Bearer Token refreshed successfully. Kindly configure your IDP with the new token');
            $userProv->msup_scim_up_show_success_message();
        }
        if(msup_check_option_admin_referer('msup_scim_idp_name')){
            if(isset($_POST['msup_scim_idp_name'])){
                $scim_idp_name = sanitize_text_field($_POST['msup_scim_idp_name']);
                update_site_option('msup_scim_idp_name', $scim_idp_name);
            }
            update_site_option('msup_scim_up_message', 'Configuration Saved Successfully');
            $userProv->msup_scim_up_show_success_message();
        }

        elseif ( msup_check_option_admin_referer( 'msup_scim_up_clear_attribute' ) ) {
			delete_site_option( 'msup_scim_test_config_attrs' );
		}

        elseif ( msup_check_option_admin_referer( 'msup_scim_show_attribute' ) ) {
			// if ( isset( $_POST["msup_scim_show_attribute"] ) ) {
            if ( isset( $_POST["msup_scim_show_attribute"] ) ) {    
				update_site_option( 'msup_scim_show_attribute', 1 );
			} else {
				update_site_option( 'msup_scim_show_attribute', 0 );
			}

			update_site_option( 'msup_scim_up_message','Saved' );
			$userProv->msup_scim_up_show_success_message();
		}

        else if( msup_check_option_admin_referer("msup_scim_up_contact_us_query_option") ) {

            if(!msup_scim_up_is_curl_installed()) {
                update_site_option( 'msup_scim_up_message', 'ERROR: PHP cURL extension is not installed or disabled. Query submit failed.');
                $userProv->msup_scim_up_show_error_message();
                return;
            }

            // Contact Us query
            if(isset($_POST['msup_scim_up_contact_us_email']))
                $email = sanitize_email($_POST['msup_scim_up_contact_us_email']);
            if(isset($_POST['msup_scim_up_contact_us_phone']))
                $phone = isset($_POST['msup_scim_up_contact_us_phone']);
            if(isset($_POST['msup_scim_up_contact_us_query']))
                $query = sanitize_text_field($_POST['msup_scim_up_contact_us_query']);
            $customer = new CustomerUp();
            if ( msup_scim_up_check_empty_or_null( $email ) || msup_scim_up_check_empty_or_null( $query ) ) {
                update_site_option('msup_scim_up_message', 'Please fill up Email and Query fields to submit your query.');
                $userProv->msup_scim_up_show_error_message();
            } else {
                $submited = $customer->submit_contact_us( $email, $phone, $query );
                if ( $submited == false ) {
                    update_site_option('msup_scim_up_message', 'Your query could not be submitted. Please try again.');
                    $userProv->msup_scim_up_show_error_message();
                } else {
                    update_site_option('msup_scim_up_message', 'Thanks for getting in touch! We shall get back to you shortly.');
                    $userProv->msup_scim_up_show_success_message();
                }
            }
        }

        if ( msup_check_option_admin_referer("msup_skip_feedback") ) {
                $userProv->msup_deactivate();
                update_site_option( 'msup_scim_up_message', 'Plugin deactivated successfully' );
                $userProv->msup_scim_up_show_success_message();
                

            }
            if ( msup_check_option_admin_referer("msup_feedback") ) {
                $user = wp_get_current_user();
                $message = 'Plugin Deactivated';
                $deactivate_reason_message = array_key_exists( 'msup_query_feedback', $_POST ) ? htmlspecialchars($_POST['msup_query_feedback']) : false;
                $reply_required = '';
                if(isset($_POST['msup_get_reply']))
                    $reply_required = htmlspecialchars($_POST['msup_get_reply']);
                if(empty($reply_required)){
                    $reply_required = "don't reply";
                    $message.='<b style="color:red";> &nbsp; [Reply :'.$reply_required.']</b>';
                }else{
                    $reply_required = "yes";
                    $message.='[Reply :'.$reply_required.']';
                }                
                
                $message.= ', Feedback : '.$deactivate_reason_message.'';
                 
                if (isset($_POST['rate']))
                        $rate_value = htmlspecialchars($_POST['rate']);
                
                $message.= ', [Rating :'.$rate_value.']';

                $email = $_POST['msup_query_mail'];
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $email = get_option('msup_scim_up_admin_email');
                    if(empty($email))
                        $email = $user->user_email;
                }
                $phone = get_option( 'msup_scim_up_admin_phone' );
                $customer = new CustomerUp();
                if(!is_null($customer)){
                    if(!msup_scim_up_is_curl_installed()){
                        $userProv->devativate();
                       
                    } else {
                        $submited = json_decode( $customer->send_email_alert( $email, $phone, $message ), true );
                        if ( json_last_error() == JSON_ERROR_NONE ) {
                            if ( is_array( $submited ) && array_key_exists( 'status', $submited ) && $submited['status'] == 'ERROR' ) {
                                update_option( 'msup_scim_up_message', $submited['message'] );
                                $userProv->msup_scim_up_show_error_message();

                            }
                            elseif ( $submited == false ) {

                                    update_option( 'msup_scim_up_message', 'Error while submitting the query.' );
                                    $userProv->msup_scim_up_show_error_message();
                                }
                            
                        }

                    $userProv->msup_deactivate();
                    update_site_option( 'msup_scim_up_message', 'Thank you for the feedback.' );
                    $userProv->msup_scim_up_show_success_message();
                    }
                }
            }
        

    }
function msup_check_option_admin_referer($option_name){
        return (isset($_POST['option']) and $_POST['option']==$option_name and check_admin_referer($option_name));
    }
    


function msup_scim_up_check_empty_or_null( $value ) {
        if( ! isset( $value ) || empty( $value ) ) {
            return true;
        }
        return false;
    }
    
    function msup_scim_up_is_curl_installed() {
    if  (in_array  ('curl', get_loaded_extensions())) {
        return 1;
    } else
        return 0;
}
