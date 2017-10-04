<?php
/* Setting Mega CLient Setting */
		echo "<h1>Confirm email was received by the user.</h1>";
		echo "<p>Warning to the user. And confirm that message was received.</p>";
?>
<TABLE WIDTH="500px" ALIGN="LEFT" cellspacing="20">
<form method="POST">
   <TR ALIGN="LEFT">
	<TH style="padding:15px; margin:15px; border-radius:5px; border: 1px solid #EEEEEE; background:#DADADA; box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);">
			<label for="awesome_text" style="color:#00408C"><b>Email Address: </b></label><br/>
			<input type="email" name="email_address" id="email_address" size="35" required><br/>
			<label for="awesome_text" style="color:#00408C"><b>Subject: </b></label><br/>
			<input type="text" name="email_subject" id="email_subject" size="50" required><br/>
			<label for="awesome_text" style="color:#00408C"><b>Message: </b></label><br/>
            <textarea name="email_message" id="email_message" rows="5" cols="48" required></textarea><br/><br/>
			<label for="awesome_text" style="color:#00408C"><b>Message Validity: </b></label><br/>
            <select name="email_valid" id="email_valid" required>
                <option value="">Select...</option>
                <option value="oneday">One Day</option>
                <option value="oneweek">One Week</option>
            </select>
            <br/><hr/>

	</TH>
   </TR>
<hr/>
   <TR>
      <TH ALIGN="LEFT">
	<input type="submit" value="Save" class="button button-primary button-large">
	</form>
      </TH>
   </TR>
</TABLE>
<hr/>
