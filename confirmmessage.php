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
	add_submenu_page( $menu_slug,'System Test', 'System Test', 'manage_options', 'sysryn_tstjs', 'sysryn_tstjs' );
}
/* Determine The Time Location START */
date_default_timezone_set("America/New_York");
/* Determine The Time Location END */
function confirm_message_sent() {
        if (isset($_POST['email_address'])) {
	        echo $_POST['email_address'];
	    }
        if (isset($_POST['email_subject'])) {
	        echo $_POST['email_subject'];
	    }
	    if (isset($_POST['email_message'])) {
	        echo $_POST['email_message'];
	    }
        if (isset($_POST['email_valid'])) {
	        echo $_POST['email_valid'];
	    }
        $obj = new myemail();
        $reply = $obj->composeemail($_POST['email_address'],$_POST['email_subject'],$_POST['email_message'],$_POST['email_valid']);
        var_dump($reply); 
    
    include 'setting/sent.php';
}

/* Run JS script in Different Position in HOOK START */
// add_action( 'wp_footer', 'export_ryanEXLS');
/* Run JS script in Different Position in HOOK END */
/* Notice START */
add_action( 'admin_notices', 'email_sent_success' );
function email_sent_success() {
     if (isset($_POST['email_valid'])) {
    ?>
    <div class="notice notice-success is-dismissible">
        <p>The Email was sent!</p>
    </div>
    <?php
     }
}
/* Notice END */
/* Send Simple Email START */
class myemail {
    public $headers = 'From: Ryan Mahato <promauriya@gmail.com>';
    private function mailsent($to, $subject, $message){
        $reply = wp_mail( $to, $subject, $message, $this->headers );
        return $reply;
    }
    public function composeemail($to, $subject, $message, $timelimit){
        $reply = self::mailsent(($to, $subject, $message);
        return $reply;
    }
}
/* Send Simple Email EMD */
?>