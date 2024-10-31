<?php

if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit();

delete_site_option('msup_scim_up_host_name');
delete_site_option('msup_scim_up_message');
delete_site_option('msup_scim_up_error_message');
delete_site_option('msup_scim_idp_name');
delete_site_option('msup_scim_up_bearer_token');