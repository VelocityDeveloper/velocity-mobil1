<?php
add_action("init", "velocity_start_session", 1);
function velocity_start_session(){
    if (!session_id())
        session_start();
}

add_action('wp_ajax_nopriv_onsubmit', 'onsubmit_ajax');
add_action('wp_ajax_onsubmit', 'onsubmit_ajax');
function onsubmit_ajax() {
    $params         = $_POST['data'];
    $session        = $_SESSION['code'];
    $namatoko       = get_bloginfo('name');
    $emailtoko      = get_bloginfo('admin_email');
    
    parse_str($params, $output);

    echo '<div class="alert alert-success" role="alert">';
        echo 'Terimakasih '.$output['nama'].', Permintaan sudah terkirim, kami segera menghubungi anda.';
    echo '</div>';
    
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: '.$namatoko.' <'.$emailtoko.'>';
    $subject = 'Halo, Ada order dari '.$output['nama'].' dari website '.$namatoko;
    
    $body = '<div style="color: #333; margin:0 auto; padding: 20px; max-width:500px;border: 1px solid #333;text-align:left">Halo,';
    $body .= '<h4>Berikut pesan masuk dari website '.$namatoko.'</h4>';
    $body .= '<table style="width:100%"><tbody>';
        $body .= '<tr>';
            $body .= '<td>Nama </td>';
            $body .= '<td>';
                $body .= $output['nama'];
            $body .= '</td>';
        $body .= '</tr>';
        $body .= '<tr>';
            $body .= '<td>No HP </td>';
            $body .= '<td>';
                $body .= $output['hp'];
            $body .= '</td>';
        $body .= '</tr>';
        $body .= '<tr>';
            $body .= '<td>Email </td>';
            $body .= '<td>';
                $body .= $output['email'];
            $body .= '</td>';
        $body .= '</tr>';
        $body .= '<tr>';
            $body .= '<td>Pesan </td>';
            $body .= '<td>';
                $body .= $output['pesan'];
            $body .= '</td>';
        $body .= '</tr>';

    $body .= '</tbody></table></div>';
    $body .= '<style>tr:nth-child(even){background-color: #f2f2f2;}#customers tr:hover {background-color: #ddd;}</style>';
    // echo $body.''.$emailtoko;
    //admin 
    wp_mail( $emailtoko, $subject, $body, $headers );

    wp_die();
}

add_filter( 'wp_mail_from_name', 'velocity_mail_name' );
function velocity_mail_name( $email ){
    return get_bloginfo('name'); // new email name from sender.
}

add_filter( 'wp_mail_from', 'velocity_mail_from' );
function velocity_mail_from ($email ){
    $input        = get_site_url();
    $input      = trim($input, '/');

    // If scheme not included, prepend it
    if (!preg_match('#^http(s)?://#', $input)) {
        $input = 'http://' . $input;
    }
    
    $urlParts = parse_url($input);
    $domain = preg_replace('/^www\./', '', $urlParts['host']);
    return 'dealer@'.$domain; // new email address from sender.
}