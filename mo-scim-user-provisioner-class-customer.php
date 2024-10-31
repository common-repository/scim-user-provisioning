<?php
/** miniOrange's SCIM User Provisioning plugin allows User Provisioning to Wordpress using SCIM standard. 
 Copyright (C) 2015  miniOrange

 This program is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 3 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program.  If not, see <http://www.gnu.org/licenses/>
 * @package         miniOrange SCIM User Provisioner
 * @license        http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 */
/**
 * This library is miniOrange Authentication Service.
 *
 * Contains Request Calls to Customer service.
 */

class CustomerUp
{
    public $email;
    public $phone;

    private $defaultCustomerKey = "16555";
    private $defaultApiKey = "fFd2XcvTGDemZvbw1bcUesNJWEqKbbUq";

    
    function submit_contact_us($email, $phone, $query)
    {
        $current_user = wp_get_current_user();
        $query = '[WP SCIM User Provisioning Plugin] ' . $query;
        $fields = array (
                'firstName' => $current_user->user_firstname,
                'lastName' => $current_user->user_lastname,
                'company' => $_SERVER ['SERVER_NAME'],
                'email' => $email,
                'phone' => $phone,
                'query' => $query
        );
        $field_string = json_encode($fields);

        $url = get_site_option('msup_scim_up_host_name') . '/moas/rest/customer/contact-us';

        $headers = array("Content-Type"=>"application/json","charset"=>"UTF-8","Authorization"=>"Basic");
        $args = array(
            'method' => 'POST',
            'body' => $field_string,
            'timeout' => '5',
            'redirection' => '5',
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => $headers
        );
         $response = wp_remote_post($url, $args);
        if(!is_wp_error($response)){            
            return true;
        } else {
            return false;
        }

    }
    function send_email_alert($email,$phone,$message, $demsup_request=false){

        $url = get_site_option('msup_scim_up_host_name') . '/moas/api/notify/send';

        $customerKey = $this->defaultCustomerKey;
        $apiKey =  $this->defaultApiKey;

        $currentTimeInMillis = self::get_timestamp();
        $currentTimeInMillis = number_format ( $currentTimeInMillis, 0, '', '' );
        $stringToHash       = $customerKey .  $currentTimeInMillis . $apiKey;
        $hashValue          = hash("sha512", $stringToHash);
        $fromEmail          = 'no-reply@xecurify.com';
        $subject            = "Feedback: WordPress SCIM User Provisioning";
        if($demsup_request)
            $subject = "DEMO Request:SCIM User Provisioning";
        $site_url=site_url();

        global $user;
        $user         = wp_get_current_user();


        $query        = '[SCIM User Provisioning: ]: ' . $message;


        $content='<div >Hello, <br><br>First Name :'.$user->user_firstname.'<br><br>Last  Name :'.$user->user_lastname.'   <br><br>Company :<a href="'.$_SERVER['SERVER_NAME'].'" target="_blank" >'.$_SERVER['SERVER_NAME'].'</a><br><br>Phone Number :'.$phone.'<br><br>Email :<a href="mailto:'.$email.'" target="_blank">'.$email.'</a><br><br>Query :'.$query.'</div>';


        $fields = array(
            'customerKey'   => $customerKey,
            'sendEmail'     => true,
            'email'         => array(
                'customerKey'   => $customerKey,
                'fromEmail'     => $fromEmail,
                'bccEmail'      => $fromEmail,
                'fromName'      => 'Xecurify',
                'toEmail'       => 'info@xecurify.com',
                'toName'        => 'samlsupport@xecurify.com',
                'bccEmail'      => 'samlsupport@xecurify.com',
                'subject'       => $subject,
                'content'       => $content
            ),
        );
        $field_string = json_encode($fields);

        $headers = array(
            "Content-Type" => "application/json",
            "Customer-Key" => $customerKey,
            "Timestamp" => $currentTimeInMillis,
            "Authorization" => $hashValue
        );
        $args = array(
            'method' => 'POST',
            'body' => $field_string,
            'timeout' => '5',
            'redirection' => '5',
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => $headers
        );

        $response = self::msup_scim_up_wp_remote_post($url, $args);
        return $response['body'];

    }
function get_timestamp() 
{
        $url = get_site_option('msup_scim_up_host_name'). '/moas/rest/mobile/get-timestamp';
        $response = self::msup_scim_up_wp_remote_post($url);
        return $response['body'];

    }

 function msup_scim_up_wp_remote_post($url, $args = array()){
        $response = wp_remote_post($url, $args);
        if(!is_wp_error($response)){            
            return $response;
        } else {
            $show_message = new scim_user_provisioner_add_on();
            update_site_option('msup_scim_up_message', 'Unable to connect to the Internet. Please try again.');
            $show_message->msup_scim_show_error_message();
        }
    }
 

}

