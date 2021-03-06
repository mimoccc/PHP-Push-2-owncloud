<?php
/***********************************************
* File      :   config.php
* Project   :   Z-Push
* Descr     :   Main configuration file
*
* Created   :   01.10.2007
*
* Copyright 2007 - 2013 Zarafa Deutschland GmbH
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU Affero General Public License, version 3,
* as published by the Free Software Foundation with the following additional
* term according to sec. 7:
*
* According to sec. 7 of the GNU Affero General Public License, version 3,
* the terms of the AGPL are supplemented with the following terms:
*
* "Zarafa" is a registered trademark of Zarafa B.V.
* "Z-Push" is a registered trademark of Zarafa Deutschland GmbH
* The licensing of the Program under the AGPL does not imply a trademark license.
* Therefore any rights, title and interest in our trademarks remain entirely with us.
*
* However, if you propagate an unmodified version of the Program you are
* allowed to use the term "Z-Push" to indicate that you distribute the Program.
* Furthermore you may use our trademarks where it is necessary to indicate
* the intended purpose of a product or service provided you use it in accordance
* with honest practices in industrial or commercial matters.
* If you want to propagate modified versions of the Program under the name "Z-Push",
* you may only do so if you have a written permission by Zarafa Deutschland GmbH
* (to acquire a permission please contact Zarafa at trademark@zarafa.com).
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU Affero General Public License for more details.
*
* You should have received a copy of the GNU Affero General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
* Consult LICENSE file for details
************************************************/

/**********************************************************************************
 *  Default settings
 */
    // Defines the default time zone, change e.g. to "Europe/London" if necessary
    define('TIMEZONE', '');

    // Defines the base path on the server
    define('BASE_PATH', dirname($_SERVER['SCRIPT_FILENAME']). '/');

    // Try to set unlimited timeout
    define('SCRIPT_TIMEOUT', 0);

    //Max size of attachments to display inline. Default is 2 MB
    define('MAX_EMBEDDED_SIZE', 2097152);

    //limitation of qnap
    define('USE_SHARED_MEM', false);


/**********************************************************************************
 *  Default FileStateMachine settings
 */
    define('STATE_DIR', '/share/HDA_DATA/var/lib/z-push/');

   ini_set('include_path',
   BASE_PATH. "include/" . PATH_SEPARATOR .
   BASE_PATH. PATH_SEPARATOR .
   ini_get('include_path') . PATH_SEPARATOR .
   "/usr/share/php/" . PATH_SEPARATOR .
   "/usr/share/awl/inc");


/**********************************************************************************
 *  Logging settings
 *  Possible LOGLEVEL and LOGUSERLEVEL values are:
 *  LOGLEVEL_OFF            - no logging
 *  LOGLEVEL_FATAL          - log only critical errors
 *  LOGLEVEL_ERROR          - logs events which might require corrective actions
 *  LOGLEVEL_WARN           - might lead to an error or require corrective actions in the future
 *  LOGLEVEL_INFO           - usually completed actions
 *  LOGLEVEL_DEBUG          - debugging information, typically only meaningful to developers
 *  LOGLEVEL_WBXML          - also prints the WBXML sent to/from the device
 *  LOGLEVEL_DEVICEID       - also prints the device id for every log entry
 *  LOGLEVEL_WBXMLSTACK     - also prints the contents of WBXML stack
 *
 *  The verbosity increases from top to bottom. More verbose levels include less verbose
 *  ones, e.g. setting to LOGLEVEL_DEBUG will also output LOGLEVEL_FATAL, LOGLEVEL_ERROR,
 *  LOGLEVEL_WARN and LOGLEVEL_INFO level entries.
 */
    define('LOGFILEDIR', '/share/HDA_DATA/var/log/z-push/');
    define('LOGFILE', LOGFILEDIR . 'z-push.log');
    define('LOGERRORFILE', LOGFILEDIR . 'z-push-error.log');
    define('LOGLEVEL', LOGLEVEL_WARN);
    define('LOGAUTHFAIL', true);


    // To save e.g. WBXML data only for selected users, add the usernames to the array
    // The data will be saved into a dedicated file per user in the LOGFILEDIR
    // Users have to be encapusulated in quotes, several users are comma separated, like:
    //   $specialLogUsers = array('info@domain.com', 'myusername');
    define('LOGUSERLEVEL', LOGLEVEL_DEVICEID);
    $specialLogUsers = array();

    // Location of the trusted CA, e.g. '/etc/ssl/certs/EmailCA.pem'
    // Uncomment and modify the following line if the validation of the certificates fails.
    // define('CAINFO', '/etc/ssl/certs/EmailCA.pem');

/**********************************************************************************
 *  Mobile settings
 */
    // Device Provisioning
    define('PROVISIONING', true);

    // This option allows the 'loose enforcement' of the provisioning policies for older
    // devices which don't support provisioning (like WM 5 and HTC Android Mail) - dw2412 contribution
    // false (default) - Enforce provisioning for all devices
    // true - allow older devices, but enforce policies on devices which support it
    define('LOOSE_PROVISIONING', false);

    // Default conflict preference
    // Some devices allow to set if the server or PIM (mobile)
    // should win in case of a synchronization conflict
    //   SYNC_CONFLICT_OVERWRITE_SERVER - Server is overwritten, PIM wins
    //   SYNC_CONFLICT_OVERWRITE_PIM    - PIM is overwritten, Server wins (default)
    define('SYNC_CONFLICT_DEFAULT', SYNC_CONFLICT_OVERWRITE_PIM);

    // Global limitation of items to be synchronized
    // The mobile can define a sync back period for calendar and email items
    // For large stores with many items the time period could be limited to a max value
    // If the mobile transmits a wider time period, the defined max value is used
    // Applicable values:
    //   SYNC_FILTERTYPE_ALL (default, no limitation)
    //   SYNC_FILTERTYPE_1DAY, SYNC_FILTERTYPE_3DAYS, SYNC_FILTERTYPE_1WEEK, SYNC_FILTERTYPE_2WEEKS,
    //   SYNC_FILTERTYPE_1MONTH, SYNC_FILTERTYPE_3MONTHS, SYNC_FILTERTYPE_6MONTHS
    define('SYNC_FILTERTIME_MAX', SYNC_FILTERTYPE_ALL);

    // Interval in seconds before checking if there are changes on the server when in Ping.
    // It means the highest time span before a change is pushed to a mobile. Set it to
    // a higher value if you have a high load on the server.
    define('PING_INTERVAL', 30);

    // Interval in seconds to force a re-check of potentially missed notifications when
    // using a changes sink. Default are 300 seconds (every 5 min).
    // This can also be disabled by setting it to false
    define('SINK_FORCERECHECK', 300);

    // Set the fileas (save as) order for contacts in the webaccess/webapp/outlook.
    // It will only affect new/modified contacts on the mobile which then are synced to the server.
    // Possible values are:
    // SYNC_FILEAS_FIRSTLAST    - fileas will be "Firstname Middlename Lastname"
    // SYNC_FILEAS_LASTFIRST    - fileas will be "Lastname, Firstname Middlename"
    // SYNC_FILEAS_COMPANYONLY  - fileas will be "Company"
    // SYNC_FILEAS_COMPANYLAST  - fileas will be "Company (Lastname, Firstname Middlename)"
    // SYNC_FILEAS_COMPANYFIRST - fileas will be "Company (Firstname Middlename Lastname)"
    // SYNC_FILEAS_LASTCOMPANY  - fileas will be "Lastname, Firstname Middlename (Company)"
    // SYNC_FILEAS_FIRSTCOMPANY - fileas will be "Firstname Middlename Lastname (Company)"
    // The company-fileas will only be set if a contact has a company set. If one of
    // company-fileas is selected and a contact doesn't have a company set, it will default
    // to SYNC_FILEAS_FIRSTLAST or SYNC_FILEAS_LASTFIRST (depending on if last or first
    // option is selected for company).
    // If SYNC_FILEAS_COMPANYONLY is selected and company of the contact is not set
    // SYNC_FILEAS_LASTFIRST will be used
    define('FILEAS_ORDER', SYNC_FILEAS_LASTFIRST);

    // Amount of items to be synchronized per request
    // Normally this value is requested by the mobile. Common values are 5, 25, 50 or 100.
    // Exporting too much items can cause mobile timeout on busy systems.
    // Z-Push will use the lowest value, either set here or by the mobile.
    // default: 100 - value used if mobile does not limit amount of items
    define('SYNC_MAX_ITEMS', 100);
    
    // Require Certificate DN Match to Username
    //
    // If enabled, additional checks are performed:
    // - Validity SSL_CLIENT_V_START <= time() <= SSL_CLIENT_V_END
    // - Certificate Issuer (Optional: See SYNC_REQUIRE_CLIENT_CRT_ISSUER)
    // Example: (string) 'SSL_CLIENT_S_DN_UID'
    // Disable: (bool) false
    //define('SYNC_REQUIRE_CLIENT_CRT_USERNAME_IN', 'SSL_CLIENT_S_DN_CN');
    define('SYNC_REQUIRE_CLIENT_CRT_USERNAME_IN', false);
    
    // Require Client Certificate Issuer DN (aka Subject) (SSL_CLIENT_I_DN) to match a specific DN
    //
    // This isn't really necessary, as the Webserver already needs to trust
    // the signing CA.
    // Anyway, an attacker could have signed a client certificate by another
    // trusted CA and that can't possibly be distinguished.
    //
    // If defined, SYNC_REQUIRE_CRT_USERNAME_IN will only pass if
    // the Issuer of the Client Cert matches the given Issuer String
    // Example: (string) '/C=DE/ST=Berlin/L=Berlin/O=My Lovely Own CA/OU=Testing (CA-OU)/CN=my-lovely-own-ca.example.org/emailAddress=s.seitz@heinlein-support.de'
    // Disable: (bool) false
    //define('SYNC_REQUIRE_CLIENT_CRT_ISSUER', '/C=DE/ST=Berlin/L=Berlin/O=My Lovely Own CA/OU=Testing (CA-OU)/CN=my-lovely-own-ca.example.org/emailAddress=s.seitz@heinlein-support.de');
    define('SYNC_REQUIRE_CLIENT_CRT_ISSUER', false);


/**********************************************************************************
 *  Backend settings
 */
    // The data providers that we are using (see configuration below)
    define('BACKEND_PROVIDER', "BackendCombined");

    // ************************
    //  BackendIMAP settings
    // ************************
    // Defines the server to which we want to connect
    define('IMAP_SERVER', 'imap.someserve.com');
    // connecting to default port (143)
    define('IMAP_PORT', 993);
    // best cross-platform compatibility (see http://php.net/imap_open for options)
    //define('IMAP_OPTIONS', '/notls/norsh');
    define('IMAP_OPTIONS', '/ssl/notls/norsh/novalidate-cert');
    // overwrite the "from" header if it isn't set when sending emails
    // options: 'username'    - the username will be set (usefull if your login is equal to your emailaddress)
    //        'domain'    - the value of the "domain" field is used
    //        '@mydomain.com' - the username is used and the given string will be appended
    define('IMAP_DEFAULTFROM', '');
    // copy outgoing mail to this folder. If not set z-push will try the default folders
    define('IMAP_SENTFOLDER', '');
    // forward messages inline (default false - as attachment)
    define('IMAP_INLINE_FORWARD', true);
    // use imap_mail() to send emails (default) - if false mail() is used
    define('IMAP_USE_IMAPMAIL', true);
    /* END fmbiete's contribution r1527, ZP-319 */
    // to append a string to the username which can be useful if, for example the 3rd party imap 
    // loginname is the email address and your CalDAV / CardDAV backend can't handle usernames formated as emailadresses
    // so for login the domainpart of the email address will be added.
    // this has to be reflected in backend/imap.php
    define ('IMAP_USERNAMEEXTENSION', '');


    // ************************
    //  BackendMaildir settings
    // ************************
    define('MAILDIR_BASE', '/tmp');
    define('MAILDIR_SUBDIR', 'Maildir');

    // **********************
    //  BackendVCardDir settings
    // **********************
    define('VCARDDIR_DIR', '/home/%u/.kde/share/apps/kabc/stdvcf');
    
    // **********************
    //  BackendCalDAV settings
    // **********************
    define('CALDAV_SERVER', 'http://localhost');
    define('CALDAV_PORT', '80');
    define('CALDAV_PATH', '/owncloud/remote.php/caldav/calendars/%u/');
    define('CALDAV_PERSONAL', 'defaultcalendar'); //Personal CalDAV folder

    // ************************
    //  BackendCardDAV_OC5 settings
    // ************************
    // Server protocol: http or https
    define('CARDDAV_PROTOCOL_OC5', 'http');
    // Server name
    define('CARDDAV_SERVER_OC5', 'localhost');
    // Server port
    define('CARDDAV_PORT_OC5', '80');
    // Server path to the addressbook
    // %u: replaced with the username
    // %d: replaced with the domain
    define('CARDDAV_PATH_OC5', '/owncloud/remote.php/carddav/addressbooks/%u/');
    // Contact addressbook name
    // %u: replaced with the username
    // %d: replaced with the domain
    define('CARDDAV_CONTACTS_FOLDER_NAME_OC5', 'contacts'); //Personal Adress book to sync (only 1)
    // always override the FN value with the value generated in FILEAS_ORDER (true), or 
    // just create it according to the FILEAS_ORDER rule, if the value is empty (false) 
    define('CARDDAV_FILEAS_ALLWAYSOVERRIDE_OC5', true);
    // for readonly szenarios set to 'true'
    define('CARDDAV_READONLY_OC5', false);
    // set if the CardDAV backend is queried on each AS pin or only on AS FORCECHECK s. AS config
    // only sync on forcecheck saves server resources. Default is 'true'
    define('CARDDAV_SYNC_ON_PING_OC5', true);


    // **********************
    //  BackendCardDAV settings
    // **********************
    define('CARDDAV_SERVER', 'http://contacts.domain.com');
    define('CARDDAV_PORT', '80');
    define('CARDDAV_PATH', '/caldav.php/%u/');
    define('CARDDAV_PRINCIPAL', 'addresses'); //Personal CardDAV folder

    
    // **********************
    //  BackendLDAP settings
    // **********************
    define('LDAP_SERVER', 'localhost');
    define('LDAP_SERVER_PORT', '389');
    define('LDAP_USER_DN', 'uid=%u,ou=mailaccount,dc=phppush,dc=com');
    define('LDAP_BASE_DNS', 'Contacts:ou=addressbook,uid=%u,ou=mailaccount,dc=phppush,dc=com'); //Multiple values separator is |



/**********************************************************************************
 *  Search provider settings
 *
 *  Alternative backend to perform SEARCH requests (GAL search)
 *  By default the main Backend defines the preferred search functionality.
 *  If set, the Search Provider will always be preferred.
 *  Use 'BackendSearchLDAP' to search in a LDAP directory (see backend/searchldap/config.php)
 */
    define('SEARCH_PROVIDER', '');
    // Time in seconds for the server search. Setting it too high might result in timeout.
    // Setting it too low might not return all results. Default is 10.
    define('SEARCH_WAIT', 10);
    // The maximum number of results to send to the client. Setting it too high
    // might result in timeout. Default is 10.
    define('SEARCH_MAXRESULTS', 10);


/**********************************************************************************
 *  Synchronize additional folders to all mobiles
 *
 *  With this feature, special folders can be synchronized to all mobiles.
 *  This is useful for e.g. global company contacts.
 *
 *  This feature is supported only by certain devices, like iPhones.
 *  Check the compatibility list for supported devices:
 *      http://z-push.sf.net/compatibility
 *
 *  To synchronize a folder, add a section setting all parameters as below:
 *      store:      the ressource where the folder is located.
 *                  Zarafa users use 'SYSTEM' for the 'Public Folder'
 *      folderid:   folder id of the folder to be synchronized
 *      name:       name to be displayed on the mobile device
 *      type:       supported types are:
 *                      SYNC_FOLDER_TYPE_USER_CONTACT
 *                      SYNC_FOLDER_TYPE_USER_APPOINTMENT
 *                      SYNC_FOLDER_TYPE_USER_TASK
 *                      SYNC_FOLDER_TYPE_USER_MAIL
 *
 *  Additional notes:
 *  - on Zarafa systems use backend/zarafa/listfolders.php script to get a list
 *    of available folders
 *
 *  - all Z-Push users must have full writing permissions (secretary rights) so
 *    the configured folders can be synchronized to the mobile
 *
 *  - this feature is only partly suitable for multi-tenancy environments,
 *    as ALL users from ALL tenents need access to the configured store & folder.
 *    When configuring a public folder, this will cause problems, as each user has
 *    a different public folder in his tenant, so the folder are not available.

 *  - changing this configuration could cause HIGH LOAD on the system, as all
 *    connected devices will be updated and load the data contained in the
 *    added/modified folders.
 */

    $additionalFolders = array(
        // demo entry for the synchronization of contacts from the public folder.
        // uncomment (remove '/*' '*/') and fill in the folderid
/*
        array(
            'store'     => "SYSTEM",
            'folderid'  => "",
            'name'      => "Public Contacts",
            'type'      => SYNC_FOLDER_TYPE_USER_CONTACT,
        ),
*/
    );

?>
