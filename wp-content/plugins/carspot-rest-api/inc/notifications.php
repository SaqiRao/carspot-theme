<?php

// define the edit_post callback 
function carspotAPI_notifications_post_type_edit($post_id, $post, $update)
{
    if ($post->post_type == 'user_notifications' && 'publish' == $post->post_status) {
        if ($post->post_modified_gmt == $post->post_date_gmt)
            return '';
        /* Updated  Post */
        global $carspotAPI;
        $image_url = get_the_post_thumbnail_url($post_id, 'thumbnail');
        $image_full = get_the_post_thumbnail_url($post_id, 'full');

        $include_image_full = ($image_full) ? true : false;
        $include_image = ($image_url) ? true : false;
        /* topic or individual */
        $push_type = 'topic';
        $setMsgTopic = 'broadcast';
        /* User Firebase Id */
        $user_firebase_id = '';
        if ($push_type == 'individual') {
            //$firebase_meta_key = ( CARSPOT_API_REQUEST_FROM == 'ios' ) ? '_sb_user_firebase_id_ios' : '_sb_user_firebase_id';
            $user_firebase_id = get_user_meta($user_id, '_sb_user_firebase_id', true);
        }

        $firebase = new carspotAPI_firebase_notifications_class();
        $push = new carspotAPI_Push();

        $payload = array();
        /* $payload['team'] = '';  $payload['score'] = ''; */

        $title = isset($post->post_title) ? $post->post_title : get_bloginfo('name');
        $message = isset($post->post_excerpt) ? $post->post_excerpt : '';
        $push_type = isset($push_type) ? $push_type : '';

        $push->setTitle($title);
        $push->setMessage($message);
        $push->setMsgTopic($setMsgTopic);
        if ($include_image) {
            $push->setImage($image_url);
        } else {
            $push->setImage('');
        }
        if ($include_image_full) {
            $push->setImagefull($image_full);
        } else {
            $push->setImagefull('');
        }
        $push->setIsBackground(FALSE);
        $push->setPayload($payload);
        $json = '';
        $response = '';

        if ($push_type == 'topic') {
            $json = $push->getPush();
            $response = $firebase->sendToTopic('global', $json);
        } else if ($push_type == 'individual') {
            $json = $push->getPush();
            $regId = isset($user_firebase_id) ? $user_firebase_id : '';
            $response = $firebase->send($regId, $json);
        }
    }
}

add_action('save_post', 'carspotAPI_notifications_post_type_edit', 10, 3);


/* Register Custom Post Type */

function carspotAPI_notifications_post_type()
{

    $labels = array(
        'name' => _x('Notifications', 'Post Type General Name', 'carspot-rest-api'),
        'singular_name' => _x('Notification', 'Post Type Singular Name', 'carspot-rest-api'),
        'menu_name' => __('Push Notifications', 'carspot-rest-api'),
        'name_admin_bar' => __('Push Notification', 'carspot-rest-api'),
        'archives' => __('Notifications Archives', 'carspot-rest-api'),
        'attributes' => __('Notification Attributes', 'carspot-rest-api'),
        'parent_item_colon' => __('Parent Notification:', 'carspot-rest-api'),
        'all_items' => __('All Notifications', 'carspot-rest-api'),
        'add_new_item' => __('Add New Notification', 'carspot-rest-api'),
        'add_new' => __('Add New Notification', 'carspot-rest-api'),
        'new_item' => __('New Notification', 'carspot-rest-api'),
        'edit_item' => __('Edit Notification', 'carspot-rest-api'),
        'update_item' => __('Update Notification', 'carspot-rest-api'),
        'view_item' => __('View Notification', 'carspot-rest-api'),
        'view_items' => __('View Notifications', 'carspot-rest-api'),
        'search_items' => __('Search Notification', 'carspot-rest-api'),
        'not_found' => __('Not found', 'carspot-rest-api'),
        'not_found_in_trash' => __('Not found in Trash', 'carspot-rest-api'),
        'featured_image' => __('Featured Image', 'carspot-rest-api'),
        'set_featured_image' => __('Set featured image', 'carspot-rest-api'),
        'remove_featured_image' => __('Remove featured image', 'carspot-rest-api'),
        'use_featured_image' => __('Use as featured image', 'carspot-rest-api'),
        'insert_into_item' => __('Insert into Notification', 'carspot-rest-api'),
        'uploaded_to_this_item' => __('Uploaded to this item', 'carspot-rest-api'),
        'items_list' => __('Notifications list', 'carspot-rest-api'),
        'items_list_navigation' => __('Notifications list navigation', 'carspot-rest-api'),
        'filter_items_list' => __('Filter Notifications list', 'carspot-rest-api'),
    );
    $args = array(
        'label' => __('Notification', 'carspot-rest-api'),
        'description' => __('Notification Type Description', 'carspot-rest-api'),
        'labels' => $labels,
        'supports' => array('title', 'excerpt', 'thumbnail', 'revisions'),
        'hierarchical' => false,
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 25,
        'show_in_admin_bar' => false,
        'show_in_nav_menus' => false,
        'can_export' => true,
        'has_archive' => false,
        'exclude_from_search' => true,
        'publicly_queryable' => false,
        'capability_type' => 'post',
    );
    register_post_type('user_notifications', $args);
}

add_action('init', 'carspotAPI_notifications_post_type', 0);

/**
 * @author Ravi Tamada
 * @link URL Tutorial link
 */
class carspotAPI_Push
{
    /* push message title */

    private $title;
    private $message;
    private $image;
    /* push message payload */
    private $data;
    /* flag indicating whether to show the push
      notification or not
      this flag will be useful when perform some opertation
      in background when push is recevied */
    private $is_background;
    private $is_topic;
    private $imageUrl_full;

    function __construct()
    {

    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function setImage($imageUrl)
    {
        $this->image = $imageUrl;
    }

    public function setImagefull($imageUrl_full)
    {
        $this->image_full = $imageUrl_full;
    }

    public function setPayload($data)
    {
        $this->data = $data;
    }

    public function setIsBackground($is_background)
    {
        $this->is_background = $is_background;
    }

    public function setMsgTopic($is_topic)
    {
        $this->is_msgTopic = $is_topic;
    }

    public function getPush()
    {
        $res = array();
        $res['topic'] = $this->is_msgTopic;
        $res['topic_id'] = time();
        $res['content_available'] = true;
        $res['mutable_content'] = true;
        $res['priority'] = 'high';

        $res['title'] = $this->title;
        $res['is_background'] = $this->is_background;
        $res['message'] = $this->message;
        $res['body'] = $this->message;
        $res['image'] = $this->image;
        $res['image_full'] = $this->image_full;
        $res['payload'] = $this->data;
        $res['topic'] = $this->is_msgTopic;
        $res['timestamp'] = date('Y-m-d G:i:s');

        $res['notification']['title'] = $this->title;
        $res['notification']['is_background'] = $this->is_background;
        $res['notification']['message'] = $this->message;
        $res['notification']['body'] = $this->message;
        $res['notification']['image'] = $this->image;
        $res['notification']['image_full'] = $this->image_full;
        $res['notification']['payload'] = $this->data;
        $res['notification']['topic'] = $this->is_msgTopic;
        $res['notification']['timestamp'] = date('Y-m-d G:i:s');

        $res['data']['title'] = $this->title;
        $res['data']['is_background'] = $this->is_background;
        $res['data']['message'] = $this->message;
        $res['data']['body'] = $this->message;
        $res['data']['image'] = $this->image;
        $res['data']['image_full'] = $this->image_full;
        $res['data']['payload'] = $this->data;
        $res['data']['topic'] = $this->is_msgTopic;
        $res['data']['timestamp'] = date('Y-m-d G:i:s');


        return $res;
    }

}

class carspotAPI_firebase_notifications_class
{

    public function send($to, $message)
    {
        $fields = array('to' => $to, 'notification' => $message, 'data' => $message,);
        return $this->sendPushNotification($fields);
    }

    /* Sending message to a topic by topic name */

    public function sendToTopic($to, $message)
    {
        $fields = array('to' => '/topics/' . $to, 'notification' => $message, 'data' => $message,);

        return $this->sendPushNotification($fields);
    }

    /* sending push message to multiple users by firebase registration ids */

    public function sendMultiple($registration_ids, $message)
    {
        $fields = array('to' => $registration_ids, 'notification' => $message, 'data' => $message,);
        return $this->sendPushNotification($fields);
    }

    /* function makes curl request to firebase servers */

    private function sendPushNotification($fields)
    {

        global $carspotAPI;
        $firebase_id = (isset($carspotAPI['api_firebase_id']) && $carspotAPI['api_firebase_id'] != "") ? $carspotAPI['api_firebase_id'] : '';


        /* Set POST variables */
        $url = 'https://fcm.googleapis.com/fcm/send';
        $headers = array('Authorization: key=' . $firebase_id, 'Content-Type: application/json');
        $ch = curl_init();
        /* Set the url, number of POST vars, POST data */
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        /* Disabling SSL Certificate support temporarly */
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        /* Execute post */
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        /* Close connection */
        curl_close($ch);


        return $result;
    }

}

if (isset($_GET) && @$_GET['action'] == 'edit' && @$_GET['post'] != "") {
    $postID = isset($_GET['post']) ? $_GET['post'] : 0;
    $get_post_type = get_post_type($postID);
    if ($get_post_type == "user_notifications") {
        /* This is the confirmation message that will appear. */
        $c_message = __("Are you Sure you want to send push notifications", "carspot-rest-api");

        function carspotAPI_confirm_publish()
        {

            global $c_message;
            echo '<script type = "text/javascript"><!--
                        var publish = document.getElementById("publish");
                        if (publish !== null) publish.onclick = function(){
                        return confirm("' . $c_message . '");
                        };
                        // --></script>';
        }

        add_action('admin_footer', 'carspotAPI_confirm_publish');
    }
}

add_filter('post_row_actions', 'carspotAPI_post_row_actions', 10, 1);

function carspotAPI_post_row_actions($actions)
{
    if (get_post_type() === 'user_notifications')
        unset($actions['inline hide-if-no-js']);
    return $actions;
}
