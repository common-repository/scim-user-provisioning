=== SCIM User Sync/Provisioning ===
Contributors: miniOrange
Donate link: http://miniorange.com
Tags: User Sync,SCIM,AzureAD,Okta,Employee-directory,JumpCloud,Import-users,GoogleApps,Okta SCIM Provisioning ,AzureAD user Sync, Okta User sync, WordPress User Sync, Google-Apps User Sync, Jumpcloud User Sync, Okta to BuddyBoss sync, AzureAD to BuddyPress sync, Okta to BuddyPress sync
Requires at least: 3.7
Tested up to: 6.4.2
Requires PHP: 5.4
Stable tag: 1.1.1
License: MIT/Expat
License URI: https://docs.miniorange.com/mit-license

SCIM User Sync & User Provisioning. Create, delete, update users & automated user sync from Azure AD, Okta, Google Apps & many IDPs into WordPress.

== Description == 

SCIM User Sync/provisioning plugin provides Automated user synchronization from the identity provider to WordPress.

SCIM User Sync/provisioning provides SCIM capability to your WordPress site, converting it to a SCIM compliant endpoint which can be configured with many identity providers like Azure AD, Okta, OneLogin, G-suite / Google Apps, Centrify, JumpCloud, Keycloak, miniOrange IDP, and Custom Providers supporting SCIM protocol.

SCIM User Sync/provisioning plugin allows you to automate user creation, update and delete user information from the IDP (identity provider) in real-time to your WordPress site and automate user sync for WordPress from different IDPs.

To set up the user provisioning in your identity provider (IdP), use the SCIM endpoint from the plugin and configure the bearer token in your application. Users' feeds will be synchronized from the Identity Provider to your WordPress site instantaneously or in a time interval set in your IDP.
Our SCIM Automated User Sync/Provisioning plugin also allows real-time provisioning with custom Providers. Our User Sync/Provisioning (Auto Provisioning) plugin works with any IDP that conforms to the SCIM standard.

### REQUIREMENTS

### PHP

**Minimum PHP version: 5.4.0**

### PHP HTTP Authorization Header enable

Most of the shared hosting has disabled the **HTTP Authorization Header** by default.

To enable this option you'll need to edit your **.htaccess** file adding the following code

`
RewriteEngine on
RewriteCond %{HTTP:Authorization} ^(.*)
RewriteRule ^(.*) - [E=HTTP_AUTHORIZATION:%1]
`

#### WPENGINE

To enable this option you'll need to edit your **.htaccess** file adding the following code

`
SetEnvIf Authorization "(.*)" HTTP_AUTHORIZATION=$1

`

###Bitnami

To enable this option you'll need to edit your **/opt/bitnami/apps/wordpress/conf/htaccess.conf** file adding the following line. 

You can also check this issue using this link https://community.bitnami.com/t/need-to-pass-authorization-headers/44690

`
SetEnvIf Authorization "(.*)" HTTP_AUTHORIZATION=$1

`


== Why do you need SCIM User Sync/Provisioning-WordPress plugin? ==

If your team uses Okta, Azure AD, OneLogin, G-Suite, or Centrify for employee/User provisioning, you can use SCIM User Sync/Provisioning integration to automatically keep your WordPress employee directory/Users in sync. The SCIM push-based system treats the IdP directory as your source of truth. When changes are made in IdP, they push immediately to WordPress, so you need not worry about the WordPress employee/User directory being out of sync.

Note: You can manually create new employees/users or add employees/users from other locations while maintaining your directory sync. This feature is helpful for contractors, temps or other people who may host visitors/receive deliveries but are not core team members.


**PRE-INTEGRATED IDPs FOR PROVISIONING**

miniOrange provides pre-integrated IdPs for many applications like Azure AD, Okta, OneLogin, G-suite / Google Apps, Centrify, JumpCloud, Keycloak, miniOrange IDP, and Custom Providers. Once you configure the SCIM base URL and Bearer token in your SCIM capable Identity providers (IdPs) they can use the SCIM User Sync/Provisioning plugin for WordPress sites to update, create, delete, deactivate users automatically within seconds. (Auto User Provisioning).

* SCIM user sync/provisioning plugin works with JumpCloud and G-Suite.You can always <a href="https://www.miniorange.com/contact/">Contact Us</a>, or Email us at <a href="mailto:info@xecurify.com">info@xecurify.com</a> and we would be happy to help you out in setting up user-provisioning with SCIM supported IdP.


= Free Features =

* **Create Users**:  You can create users by using the SCIM User Sync/Provisioning plugin supporting IdP (eg Okta, OneLogin AzureAD , Centrify and G-Suite), and then you can sync those users (user create) as configured  in IdP either real-time or one can schedule the Identity-life

* **Unlimited Users**: There is no restriction for the number of users to be updated to your WordPress site. 

* **Real-time provisioning**: Real-time provisioning permits you to update recently created or updated Identity Authentication clients without physically running a task, or waiting for a scheduled one. This proves to be useful for situations that require coordinated provisioning, similar to client self-enrollment that needs immediate system access.

* **Pre-configured IDPs**:  Since SCIM is a standard protocol one can use any SCIM supporting IdP. SCIM User Sync/Provisioning provides pre-integrated IdPs like Azure AD, Okta, OneLogin, and miniOrange IdP. The System for Cross-domain Identity Management (SCIM) is an open standard for securely synchronizing user (user sync tool) information between multiple applications.

= Premium Features =

* Includes all the Free version features

* **Delete Users**: The removal of access privilege and system resources for an employee, User, business partner for your WordPress website. It is a security process that removes access of a system to an end-user along with their data in WordPress site when you de-provision the same user in your IdP.  (User delete)

 *  Use-case: one can use this feature when a user leaves a company/organization to remove her/his data from your WordPress site.
 
* **Deactivate Users** or **Soft delete**: Deactivating a user makes a user inactive or ineffective which means that the user will not be deleted from the system but will no longer be able to log in to your WordPress website and their records can be transferred to another user.

 * Use-case: One can use this feature when the admin wants to deny access to the WordPress site but this keeps the user data in the WordPress database.

* **Update Users**: This integration allows you to automatically (Automated User Provisioning / Auto user provisioning) update the users and groups for your WordPress Website when you make updates in your identity provider. Attributes like firstName, lastName,  are automatically updated ( Auto provisioning ) in the user's profile when there are any changes in these attributes. 

* **Custom attribute mapping**: This feature allows to sync custom attributes sent by IdP in WordPress. We also give the option to show these attributes in the User table list.

**HOW WE ARE DIFFERENT**

miniOrange has various types of deployments that give the customer a safe and protective choice. We provide a reliable plugin with extended functionality in a cost-beneficial manner. Our SCIM Auto User Provisioning for WordPress sites carries a lot of features within it like modifying, creating, deleting, deactivating users. We also provide Automatically deactivated/deleted user accounts (Auto-provisioning / Automated user provisioning ) on your WordPress site feature when a user is deleted from your IdP with the best Operational Efficiency. Our continuous integration helps you to reduce. If you are looking for a greater amount of administrative control over your WordPress website in a cost-efficient manner. miniOrange offers you the best plugin with the powerful User deployment and continuous integration management feature at an affordable price.

== Integrate user provisioning with SAML and OpenID ==

* SCIM User Sync/Provisioning plugin can be integrated with SAML and OpenID plugins to provide complete Life Cycle Management. SCIM User Sync/Provisioning plugin can be integrated with JumpCloud, Okta, AzureAD, OneLogin, and G-suite along with SAML and OpenID. You can use 3rd party pre-integrated apps that support user provisioning and SSO solution using SAML and OpenID protocol.

* You can check out this link to check pre-configured apps in G-suite to enable user sync & user provisioning on your WordPress site.<a href="https://plugins.miniorange.com/wordpress-scim-user-provisioning-with-google-apps">SCIM supported apps in G-suite/</a>.

* You can check out this link to enable user sync & user provisioning in JumpCloud and WordPress. <a href="https://plugins.miniorange.com/wordpress-scim-user-provisioning-with-jumpcloud"> SCIM integration with JumpCloud </a>

* You can check out this link to enable user sync & user provisioning in Okta and WordPress. <a href="https://plugins.miniorange.com/wordpress-scim-user-provisioning-with-okta"> SCIM integration with Okta </a>

* You can check out this link to enable user sync & user provisioning in OneLogin and WordPress. <a href="https://plugins.miniorange.com/wordpress-scim-user-provisioning-with-onelogin"> SCIM integration with OneLogin </a>

* You can check out this link to enable user sync & user provisioning in AzureAD and WordPress. <a href="https://plugins.miniorange.com/wordpress-scim-user-provisioning-with-azuread"> SCIM integration with AzureAD </a>

* You can check out this link to enable user sync & user provisioning in PingOne and WordPress. <a href="https://plugins.miniorange.com/wordpress-scim-user-provisioning-with-pingone"> SCIM integration with PingOne </a>




== DOCUMENTATION ==
 
Our SCIM User Sync/Provisioning (User Account Management) plugin for WordPress comes with a great number of setup guidelines with ensured content, expectations to make sure you don't get lost along the way.
<a href ="https://plugins.miniorange.com/wordpress-user-provisioning" > https://plugins.miniorange.com/wordpress-user-provisioning</a>


== CONTRIBUTED BY MINIORANGE ==

SCIM User Sync/Provisioning for WordPress is built by miniOrange. We create high-quality WordPress plugins that help you grow your WordPress sites.

Check out our website for other plugins <a href= "https://plugins.miniorange.com/">https://plugins.miniorange.com/ </a> or click here to see all our listed WordPress plugins.


== CONTACT SUPPORT == 

If you are still nervous about your website security or how the plugin would work for you specifically, customized solutions and Active support are available. You can always <a href="https://www.miniorange.com/contact/">Contact Us</a>, or Email us at <a href="mailto:info@xecurify.com">info@xecurify.com</a> and we would be happy to help you out.

== Installation ==

= From WordPress.org =
1. Download miniOrange SCIM User Sync/Provisioning.
2. Unzip and upload the `SCIM User Sync/Provisioning` directory to your `/wp-content/plugins/` directory.
3. Activate SCIM User Sync/Provisioning from your Plugins page.

= From your WordPress dashboard =
1. Visit `Plugins > Add New`.
2. Search for `miniOrange SCIM User Sync/Provisioning`. Find and Install `SCIM User Sync/Provisioning`.
3. Activate the plugin from your Plugins page.

= For any query/problem/request =
Visit Help & FAQ section in the plugin OR email us at <a href="mailto:info@xecurify.com">info@xecurify.com</a> or <a href="http://miniorange.com/contact">Contact us</a>. You can also submit your query from the plugin's configuration page.

== Changelog ==

= 0.0.50 =
* Initial version
= 1.0.1 =
* Added feedback and support
= 1.0.2 =
* Fixed guide link issue
= 1.0.3 =
* Added documentation to integrate PingOne as SCIM Client.
= 1.0.4 =
* Added support of WordPress 5.7
= 1.0.5 =
* Added support of On-demand provisioning for Azure AD
= 1.0.6 =
* Added support of Last-name attribute field during the user creation for AzureAD, Okta and OneLogin.
= 1.0.8 =
* Minor Bug fixes.
* Compatibility with WordPress 5.9.
* UI changes for IDP guides.
* Show JSON received from IDP in attribute mapping tab
= 1.0.9 =
* Added documentation for JumpCloud as IDP
* Added documentation for miniOrange as IDP
= 1.1.0 =
* Changed errors for cases where bearer token was missing or incorrect.
* Incorrect bearer token throws error "Unauthorized" with status code 401 while header missing throws "ERROR:0005 Authorization header missing"
= 1.1.1 =
* Tested plugin with WordPress 6.4.2
* Updated version number

== Upgrade Notice ==

= 0.0.50 =
* Initial version
= 1.0.1 =
* Added feedback and support
= 1.0.2 =
* Fixed guide link issue
= 1.0.3 =
* Added documentation to integrate PingOne as SCIM Client.
= 1.0.4 =
* Added support of WordPress 5.7
= 1.0.5 =
* Added support of On-demand provisioning for Azure AD
= 1.0.6 =
* Added support of Last-name attribute field during the user creation for AzureAD, Okta and OneLogin.
= 1.0.7 =
* Resolved the bug where miniOrange User Provisioning CSS was disabling the Radio button.
= 1.0.8 =
* Minor Bug fixes.
* compatibility with WordPress 5.9
* UI changes for IDP guides.
* Show JSON received from IDP in attribute mapping tab
= 1.0.9 =
* Added documentation for JumpCloud as IDP
* Added documentation for miniOrange as IDP
= 1.1.0 =
* Changed errors for cases where bearer token was missing or incorrect.
* Incorrect bearer token throws error "Unauthorized" with status code 401 while header missing throws "ERROR:0005 Authorization header missing"
= 1.1.1 =
* Tested plugin with WordPress 6.4.2
* Updated version number