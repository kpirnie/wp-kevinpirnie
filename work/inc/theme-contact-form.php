<?php
/** 
 * Contact Form Handler
 * 
 * Handles contact form submissions, storage, and email notifications
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 */

defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

if ( ! class_exists( 'KPT_Contact_Form' ) ) {

    class KPT_Contact_Form {

        public function init() : void {
            add_action( 'init', array( $this, 'register_cpt' ) );
            add_action( 'template_redirect', array( $this, 'process_submission' ) );
            add_action( 'admin_menu', array( $this, 'add_admin_columns' ) );
            add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
        }

        public function register_cpt() : void {
            register_post_type( 'kpt_contact', array(
                'labels' => array(
                    'name'               => 'Contact Submissions',
                    'singular_name'      => 'Contact Submission',
                    'add_new'            => 'Add New',
                    'add_new_item'       => 'Add New Submission',
                    'edit_item'          => 'View Submission',
                    'new_item'           => 'New Submission',
                    'all_items'          => 'All Submissions',
                    'view_item'          => 'View Submission',
                    'search_items'       => 'Search Submissions',
                    'not_found'          => 'No submissions found',
                    'not_found_in_trash' => 'No submissions found in trash',
                    'menu_name'          => 'Contact Form'
                ),
                'public'              => false,
                'show_ui'             => true,
                'show_in_menu'        => true,
                'menu_icon'           => 'dashicons-email',
                'capability_type'     => 'post',
                'capabilities'        => array(
                    'create_posts' => 'do_not_allow',
                ),
                'map_meta_cap'        => true,
                'supports'            => array( 'title' ),
                'has_archive'         => false,
                'rewrite'             => false,
                'publicly_queryable'  => false,
                'exclude_from_search' => true,
                'show_in_nav_menus'   => false,
                'show_in_rest'        => false,
            ) );
        }

        public function add_admin_columns() : void {
            add_filter( 'manage_kpt_contact_posts_columns', function( $columns ) {
                $new = array();
                $new['cb'] = $columns['cb'];
                $new['title'] = 'Name';
                $new['email'] = 'Email';
                $new['phone'] = 'Phone';
                $new['date'] = $columns['date'];
                return $new;
            } );

            add_action( 'manage_kpt_contact_posts_custom_column', function( $column, $post_id ) {
                switch ( $column ) {
                    case 'email':
                        echo esc_html( get_post_meta( $post_id, '_contact_email', true ) );
                        break;
                    case 'phone':
                        echo esc_html( get_post_meta( $post_id, '_contact_phone', true ) );
                        break;
                }
            }, 10, 2 );
        }

        public function add_meta_boxes() : void {
            add_meta_box(
                'contact_details',
                'Submission Details',
                array( $this, 'render_meta_box' ),
                'kpt_contact',
                'normal',
                'high'
            );
        }

        public function render_meta_box( $post ) : void {
            $first_name = get_post_meta( $post->ID, '_contact_first_name', true );
            $last_name = get_post_meta( $post->ID, '_contact_last_name', true );
            $email = get_post_meta( $post->ID, '_contact_email', true );
            $phone = get_post_meta( $post->ID, '_contact_phone', true );
            $url = get_post_meta( $post->ID, '_contact_url', true );
            $message = get_post_meta( $post->ID, '_contact_message', true );
            $ip = get_post_meta( $post->ID, '_contact_ip', true );
            $user_agent = get_post_meta( $post->ID, '_contact_user_agent', true );
            
            ?>
            <div style="padding: 10px;">
                <p><strong>First Name:</strong> <?php echo esc_html( $first_name ); ?></p>
                <p><strong>Last Name:</strong> <?php echo esc_html( $last_name ); ?></p>
                <p><strong>Email:</strong> <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></p>
                <p><strong>Phone:</strong> <?php echo esc_html( $phone ); ?></p>
                <?php if ( $url ) : ?>
                    <p><strong>Website:</strong> <a href="<?php echo esc_url( $url ); ?>" target="_blank"><?php echo esc_html( $url ); ?></a></p>
                <?php endif; ?>
                <p><strong>Message:</strong></p>
                <div style="background: #f5f5f5; padding: 15px; border-radius: 4px;">
                    <?php echo nl2br( esc_html( $message ) ); ?>
                </div>
                <hr style="margin: 20px 0;">
                <p style="font-size: 12px; color: #666;">
                    <strong>IP Address:</strong> <?php echo esc_html( $ip ); ?><br>
                    <strong>User Agent:</strong> <?php echo esc_html( $user_agent ); ?>
                </p>
            </div>
            <?php
        }

        public function process_submission() : void {

            if ( ! isset( $_POST['kpt_contact_submit'] ) || ! isset( $_POST['kpt_contact_nonce'] ) ) {
                return;
            }

            if ( ! wp_verify_nonce( $_POST['kpt_contact_nonce'], 'kpt_contact_form' ) ) {
                wp_die( 'Security check failed' );
            }

            // Honeypot check
            if ( ! empty( $_POST['website_url'] ) ) {
                wp_redirect( home_url() );
                exit;
            }

            // reCAPTCHA v3 verification
            $recaptcha_secret = KPT_Utilities::get_option( 'kpt_recaptcha_secret_key' );
            if ( $recaptcha_secret && isset( $_POST['g-recaptcha-response'] ) ) {
                $recaptcha_response = sanitize_text_field( $_POST['g-recaptcha-response'] );
                $verify_url = 'https://www.google.com/recaptcha/api/siteverify';
                
                $response = wp_remote_post( $verify_url, array(
                    'body' => array(
                        'secret' => $recaptcha_secret,
                        'response' => $recaptcha_response,
                        'remoteip' => $_SERVER['REMOTE_ADDR']
                    )
                ) );

                if ( ! is_wp_error( $response ) ) {
                    $response_body = json_decode( wp_remote_retrieve_body( $response ) );
                    if ( ! $response_body->success || $response_body->score < 0.5 ) {
                        wp_die( 'reCAPTCHA verification failed' );
                    }
                }
            }

            // Sanitize inputs
            $first_name = sanitize_text_field( $_POST['first_name'] );
            $last_name = sanitize_text_field( $_POST['last_name'] );
            $email = sanitize_email( $_POST['email'] );
            $phone = sanitize_text_field( $_POST['phone'] );
            $url = esc_url_raw( $_POST['url'] );
            $message = sanitize_textarea_field( $_POST['message'] );
            $privacy_consent = isset( $_POST['privacy_consent'] ) ? 1 : 0;

            // Validate required fields
            if ( empty( $first_name ) || empty( $last_name ) || empty( $email ) || empty( $message ) || ! $privacy_consent ) {
                wp_die( 'Please fill in all required fields and accept the privacy policy' );
            }

            if ( ! is_email( $email ) ) {
                wp_die( 'Please provide a valid email address' );
            }

            // Create submission post
            $post_id = wp_insert_post( array(
                'post_type' => 'kpt_contact',
                'post_title' => $first_name . ' ' . $last_name,
                'post_status' => 'publish',
            ) );

            if ( $post_id ) {
                // Save meta data
                update_post_meta( $post_id, '_contact_first_name', $first_name );
                update_post_meta( $post_id, '_contact_last_name', $last_name );
                update_post_meta( $post_id, '_contact_email', $email );
                update_post_meta( $post_id, '_contact_phone', $phone );
                update_post_meta( $post_id, '_contact_url', $url );
                update_post_meta( $post_id, '_contact_message', $message );
                update_post_meta( $post_id, '_contact_ip', $_SERVER['REMOTE_ADDR'] );
                update_post_meta( $post_id, '_contact_user_agent', $_SERVER['HTTP_USER_AGENT'] );

                // Send email notification
                $to = get_option( 'admin_email' );
                $subject = 'New Contact Form Submission from ' . $first_name . ' ' . $last_name;
                $body = "New contact form submission:\n\n";
                $body .= "Name: {$first_name} {$last_name}\n";
                $body .= "Email: {$email}\n";
                $body .= "Phone: {$phone}\n";
                if ( $url ) {
                    $body .= "Website: {$url}\n";
                }
                $body .= "\nMessage:\n{$message}\n\n";
                $body .= "---\n";
                $body .= "View submission: " . admin_url( 'post.php?post=' . $post_id . '&action=edit' );

                $headers = array(
                    'Content-Type: text/plain; charset=UTF-8',
                    'Reply-To: ' . $email
                );

                wp_mail( $to, $subject, $body, $headers );

                // Redirect with success message
                wp_redirect( add_query_arg( 'contact_success', '1', wp_get_referer() ) );
                exit;
            }

            wp_die( 'There was an error processing your submission. Please try again.' );
        }
    }
}
