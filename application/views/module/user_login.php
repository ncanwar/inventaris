<?php
$this->form_validation->set_rules('f_username', 'Username', 'trim|xss_clean|encode_php_tags|required|alpha|min_length[3]|max_length[20]');
$this->form_validation->set_rules('f_password', 'Password', 'trim|xss_clean|encode_php_tags|required|alpha_numeric|callback_checkuser');

if ($this->form_validation->run() == TRUE) {

	redirect(base_url());

} else {

	if(form_error('f_username') || form_error('f_password') || $this->session->flashdata('message')) {
		$flashmessage['f_username']=form_error('f_username', '<i>', '</i>');
		$flashmessage['f_password']=form_error('f_password', '<i>', '</i>');
		$flashmessage['message']=$this->session->flashdata('message');
		echo '<div id="message"><ul>';
		foreach ($flashmessage as $key => $value){
			echo !empty($flashmessage[$key]) ? '<li>'.$flashmessage[$key].'</li>' : '';
		}
		echo '</ul></div>';
	}

	echo form_open(current_url());
	$f_username = array(
	'name' => 'f_username',
	'maxlength' => '20',
	'value' => set_value('f_username', isset($default['f_username']) ? $default['f_username'] : '')
	);
	echo '<p class="baris_form"><label>Username : </label>'.form_input($f_username).'</p>';

	$f_password = array(
	'name' => 'f_password',
	'type' => 'password',
 	'value' => set_value('password', isset($default['f_password']) ? $default['f_password'] : '')
	);
	echo '<p class="baris_form"><label>Password : </label>'.form_input($f_password).'</p>';
	
	echo '<p class="submit">'.form_submit('submit', ' Login ').'</p>';

	echo form_close();
}