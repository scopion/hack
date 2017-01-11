You can login as anyone without knowing password because of incorrect usage of wp_set_auth_cookie().

<?php
if($_POST['email']=='') die(); //判断email	

$user_id = username_exists( $_POST['username'] ); //获取user_id

if(!$user_id){
	$user_id=email_exists($_POST['email']);
	if(!$user_id){
		$random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );  //如果没有user_id就随机生成密码
		$user_id= wp_create_user( $_POST['username'], $random_password, $_POST['email'] );
		$full_name=explode(' ', $_POST['name']);
		$firstName=(isset($full_name[0]))?$full_name[0]:'';
		$lastName=(isset($full_name[1]))?$full_name[1]:'';
		wp_update_user(
			array(
			'ID' => $user_id,
			'first_name'=>$firstName,
			'last_name'=>$lastName,
			'display_name' => $_POST['name'],
			'role' => 'subscriber'
			)
		);
	}
}

$user_info = get_userdata($user_id);

if ( !is_user_logged_in() ) {
	wp_set_current_user( $user_id, $user_info->user_login );
	wp_set_auth_cookie( $user_id );
	do_action( 'wp_login', $user_info->user_login );
}
?>

可随意输入user_id登陆