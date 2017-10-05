<?php
/**
 * @package Confirm Message
 */
/*
Plugin Name: Confirm Message
Plugin URI: https://mauriya.me/
Description: Confirm message received.
Version: 1.0
Author: Ryan
Author URI: https://mauriya.me/
License: GPLv2 or later
Text Domain: onfirm message received
*/
add_action('admin_menu', 'confirm_message');
function confirm_message() {
    $page_title = 'Confirm Message';
    $menu_title = 'Confirm Message';
    $capability = 'edit_posts';
    $menu_slug = 'confirm_message_sent';
    $function = 'confirm_message_sent';
    $icon_url = plugins_url( 'images/sent.png', __FILE__ );
    $position = 23;

    add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
}
/* Determine The Time Location START */
date_default_timezone_set("America/New_York");
/* Determine The Time Location END */
function confirm_message_sent() {
        if (isset($_POST['email_address'])) {
	        if (isset($_POST['email_subject'])) {
	           if (isset($_POST['email_message'])) {
	               if (isset($_POST['email_valid'])) {
                        message_email($_POST['email_address'],$_POST['email_subject'],$_POST['email_message'],$_POST['email_valid']);
	               }
	           }
	        }
	    }
    
    include 'setting/sent.php';
}

/* Run JS script in Different Position in HOOK START */
// add_action( 'wp_footer', 'export_ryanEXLS');
/* Run JS script in Different Position in HOOK END */
/* Notice START */
//add_action( 'admin_notices', 'email_sent_success' );
function email_sent_success($messg) {
    ?>
    <div class="notice notice-success is-dismissible">
        <p><?php echo $messg; ?></p>
    </div>
    <?php
}
/* Notice END */
/* Sent Email Message Message START */
function message_email($to,$sub,$messg,$valie) {
    $objt = new myemail();
    $reply = $objt->composeemail($to,$sub,$messg,$valie);
    if($reply == 1) {
         email_sent_success('The Email was sent!');
    } else {
         email_sent_success('The Email not sent!');
    }
    unset($objt);
}
/* Sent Email Message Message END */
/* Send Simple Email START */
class myemail {
    public $headers = 'From: Ryan Mahato <promauriya@gmail.com>';
    private function mailsent($to, $subject, $message){
        $reply = wp_mail( $to, $subject, $message, $this->headers );
        return $reply;
    }
    public function composeemail($to, $subject, $message, $timelimit){
        $message .= '<br/> Are you interested on this Program.<br/><button onclick="'.self::nontokenlink($to,$timelimit).'yes">YES</button> <button onclick="'.self::nontokenlink($to,$timelimit).'no">NO</button>';
        $reply = self::mailsent($to, $subject, $message);
        return $reply;
    }
    /* Nonce CREATE, VERIFY and DESTROY START */
    private static function nontokenlink($to,$limit){
        global $wpdb;
        $tot = preg_replace("/[^a-zA-Z]/", "", $to);
        if($limit == 'oneday') { $hrr = 24;}
        if($limit == 'oneweek') { $hrr = 168;}
        add_filter( $tot, function () { return $hrr * HOUR_IN_SECONDS; } );
        $noncet = wp_create_nonce($tot);
        $nonce = get_option('siteurl').'/i.agreed?email='.$to.'&token='.$noncet.'&mychoice=';
        return $nonce;
    }
    /* Nonce CREATE, VERIFY and DESTROY END */
}
/* Send Simple Email END */
/* Tracking Virtual Url Active */
/* Creating Virtual File Name for API Call START */
/* External Rules: START */
add_action( 'init', 'pt_sys_API_external' );
function pt_sys_API_external()
{
    global $wp_rewrite;
    $plugin_url = plugins_url( 'url_call.php', __FILE__ );
    $plugin_url = substr( $plugin_url, strlen( home_url() ) + 1 );
    $wp_rewrite->add_external_rule( 'url_call.php$', $plugin_url );
}
/* External Rules: END */
/* Internal Rules: START */
add_action( 'init', 'pt_sys_API_internal' );
function pt_sys_API_internal()
{
    add_rewrite_rule( 'url_call.php$', 'i.agreed?email=&mychoice=&token=', 'top' );
}
add_filter( 'query_vars', 'pt_sys_query_vars' );
function pt_sys_query_vars( $query_vars )
{
    $query_vars[] = 'mychoice';
    return $query_vars;
}
add_action( 'parse_request', 'pt_sys_parse_request' );
function pt_sys_parse_request( &$wp )
{
    if ( array_key_exists( 'mychoice', $wp->query_vars ) ) {
        include 'url_call.php';
        exit();
    }
    return;
}
/* Internal Rules: END */
/* Creating Virtual File Name for API Call END */
/* Nonce VERIFY and DESTROY START */
class verifydesty {
    public $nochoice = 'We respect your choice';
    public $yeschoice = 'You are Welcome to the program. You will be contacted shortly.';
    public $permdenid = 'Permission Denied!!!';
    public function __construct($token,$email,$choice){
        $emailt = preg_replace("/[^a-zA-Z]/", "", $email);
        if (!wp_verify_nonce($token, $emailt)) {
            // This nonce is not valid.
            wp_die($this->permdenid); 
        } else {
            // This nonce is valid
            if($choice === 'yes'){
                echo $this->yeschoice;
                wp_mail( 'promauriya@gmail.com', 'New Memeber to Program', 'The new user in program is: '.$email, 'From: Ryan Mahato <promauriya@gmail.com>' );
            } 
            if($choice === 'no'){
                echo $this->nochoice;
            }
        }
    }
    public function __destruct(){}
}
/* Nonce VERIFY and DESTROY END */
/* API Authontication Check START */
function response_check(){
                if (filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
                    $obj = new verifydesty($_GET['token'],$_GET['email'],$_GET['mychoice']);
                } else {
                    echo 'No Valid Email Address';
                    http_response_code(401);
                }
}
/* API Authontication Check END */

?>