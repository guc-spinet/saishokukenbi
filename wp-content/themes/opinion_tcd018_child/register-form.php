<script type="text/javascript">
window.onload=function(){
    var labels = document.getElementsByTagName('label');
    for (var i=0 ; i<=labels.length+1 ; i++){
        if ( labels[i].innerHTML === 'Confirm Password') {
            labels[i].innerHTML = 'パスワード確認';
        }
    }
}
</script>
<div class="login" id="theme-my-login<?php $template->the_instance(); ?>">
	<?php $template->the_action_template_message( 'register' ); ?>
	<?php $template->the_errors(); ?>
	<form name="registerform" id="registerform<?php $template->the_instance(); ?>" action="<?php $template->the_action_url( 'register' ); ?>" method="post">
                
                <p>
                    <label for="last_name<?php $template->the_instance(); ?>">お名前</label>
                    <input type="text" name="last_name" id="last_name<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'last_name' ); ?>" size="40" />
                </p>
                
                <p>
                    <label for="user_name_kana<?php $template->the_instance(); ?>">フリガナ</label>
                    <input type="text" name="user_name_kana" id="user_name_kana<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'user_name_kana' ); ?>" size="40" />
                </p>
                
                <p>
			<label for="user_login<?php $template->the_instance(); ?>"><?php _e( 'Username' ); ?></label>
			<input type="text" name="user_login" id="user_login<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'user_login' ); ?>" size="20" />
		</p>

		<p>
			<label for="user_email<?php $template->the_instance(); ?>"><?php _e( 'E-mail' ); ?></label>
			<input type="text" name="user_email" id="user_email<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'user_email' ); ?>" size="20" />
		</p>
                
                <p>
                    <label for="user_addr_zip<?php $template->the_instance(); ?>">郵便番号</label>
                    <input type="text" name="user_addr_zip" id="user_addr_zip<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'user_addr_zip' ); ?>" size="20" />
                </p>
                
                <p>
                    <label for="user_addr<?php $template->the_instance(); ?>">住所</label>
                    <input type="text" name="user_addr" id="user_name_kana<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'user_addr' ); ?>" size="40" />
                </p>

                <?php do_action( 'register_form' ); ?>
                
		<p id="reg_passmail<?php $template->the_instance(); ?>"><?php echo apply_filters( 'tml_register_passmail_template_message', __( 'A password will be e-mailed to you.' ) ); ?></p>
                
                <p><strong>会員規約：</strong><br />
                    会員規約の文面会員規約の文面会員規約の文面会員規約の文面会員規約の文面会員規約の文面会員規約の文面会員規約の文面</p>
                <p>
                    <label for="user_confirm<?php $template->the_instance(); ?>">
                    <input type="checkbox" name="user_confirm" id="user_confirm<?php $template->the_instance(); ?>" class="input" value="会員規約に同意" /> 会員規約に同意</label>
                </p>
        
		<p class="submit">
			<input type="submit" name="wp-submit" id="wp-submit<?php $template->the_instance(); ?>" value="<?php esc_attr_e( 'Register' ); ?>" />
			<input type="hidden" name="redirect_to" value="<?php $template->the_redirect_url( 'register' ); ?>" />
			<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
                        <input type="hidden" name="price" value="<?php echo $_SESSION['price']; ?>" />
                        <input type="hidden" name="teacher_name" value="<?php echo $_SESSION['teacher_name']; ?>" />
			<input type="hidden" name="action" value="register" />
		</p>
	</form>
	<?php $template->the_action_links( array( 'register' => false ) ); ?>
</div>
