<table id="Table_01" width="711" height="371" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td background="<?=$this->config->item('base_url')?>images/email/shadow_top.png" width="706" height="4" colspan="2"></td>
		<td background="<?=$this->config->item('base_url')?>images/email/shadow_right.png" width="5" height="365" rowspan="4"></td>
	</tr>
	<tr>
		<td background="<?=$this->config->item('base_url')?>images/email/shadow_left.png" width="6" height="361" rowspan="3"></td>
		<td background="<?=$this->config->item('base_url')?>images/email/header.png" width="700" height="148"></td>
	</tr>
	<tr>
		<td style="font-family:Arial, Helvetica, sans-serif; padding-left:30px" background="<?=$this->config->item('base_url')?>images/email/content.png" width="700" height="183">
            Dear<?=$this->input->post("firstname")?> <?=$this->input->post("lastname")?>,<br><br>

			Thank you for registering at www.zingberry.com. <br>
			You may now log in using the following email and password after confirmation:<br>
			username: <?=$this->input->post("email")?><br>
			password: <?=$this->input->post("confirmpassword")?><br><br>

			You may confirm by clicking on this link or copying and pasting it in your browser:<br>

			<a href="<?=$verification_url?>"><?=$verification_url?></a></td>
	</tr>
	<tr>
		<td	background="<?=$this->config->item('base_url')?>images/footer.png" width="700" height="30"></td>
	</tr>
	<tr>
		<td background="<?=$this->config->item('base_url')?>images/shadow_bottom.png" width="711" height="6" colspan="3"></td>
	</tr>
</table>