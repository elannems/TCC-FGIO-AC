<?php

/**
 * BuddyPress - Email template
 */

/*
Based on the Cerberus "Fluid" template by Ted Goas (http://tedgoas.github.io/Cerberus/).
License for the original template:


The MIT License (MIT)

Copyright (c) 2013 Ted Goas

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
the Software, and to permit persons to whom the Software is furnished to do so,
subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$settings = bp_email_get_appearance_settings();

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="<?php echo esc_attr( get_bloginfo( 'charset' ) ); ?>">
	<meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->

	<!-- CSS Reset -->
	<style type="text/css">
		/* What it does: Remove spaces around the email design added by some email clients. */
		/* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
		html,
		body {
			Margin: 0 !important;
			padding: 0 !important;
			height: 100% !important;
			width: 100% !important;
		}

		/* What it does: Stops email clients resizing small text. */
		* {
			-ms-text-size-adjust: 100%;
			-webkit-text-size-adjust: 100%;
		}

		/* What it does: Forces Outlook.com to display emails full width. */
		.ExternalClass {
			width: 100%;
		}

		/* What is does: Centers email on Android 4.4 */
		div[style*="margin: 16px 0"] {
			margin: 0 !important;
		}

		/* What it does: Stops Outlook from adding extra spacing to tables. */
		table,
		td {
			mso-table-lspace: 0pt !important;
			mso-table-rspace: 0pt !important;
		}

		/* What it does: Fixes webkit padding issue. Fix for Yahoo mail table alignment bug. Applies table-layout to the first 2 tables then removes for anything nested deeper. */
		table {
			border-spacing: 0 !important;
			border-collapse: collapse !important;
			table-layout: fixed !important;
			Margin: 0 auto !important;
		}
		table table table {
			table-layout: auto;
		}

		/* What it does: Overrides styles added when Yahoo's auto-senses a link. */
		.yshortcuts a {
			border-bottom: none !important;
		}

		/* What it does: A work-around for iOS meddling in triggered links. */
		a[x-apple-data-detectors] {
			color: inherit !important;
			text-decoration: underline !important;
		}
	</style>

</head>
<body width="100%" height="100%" bgcolor="#ffffff" style="Margin: 0;">
<table cellpadding="0" cellspacing="0" border="0" height="100%" width="100%" bgcolor="#ffffff" style="border-collapse:collapse;">
    <tr>
        <td valign="top">
	<center style="width: 100%;">

		<div style="max-width: 600px;">
			<!--[if (gte mso 9)|(IE)]>
			<table cellspacing="0" cellpadding="0" border="0" width="600" align="center">
			<tr>
			<td>
			<![endif]-->

			<!-- Email Header : BEGIN -->
			<table cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 600px; border-top: 7px solid #35bff2" bgcolor="#ffffff">
				<tr>
					<td style="text-align: center; padding: 15px 0; mso-height-rule: exactly; font-weight: bold; color: #707070; font-size: 30px">
						<?php
						do_action( 'bp_before_email_header' );

						echo bp_get_option( 'blogname' );

						do_action( 'bp_after_email_header' );
						?>
					</td>
				</tr>
			</table>
			<!-- Email Header : END -->

			<!-- Email Body : BEGIN -->
			<table cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff" width="100%" style="max-width: 600px;">

				<!-- 1 Column Text : BEGIN -->
				<tr>
					<td>
						<table cellspacing="0" cellpadding="0" border="0" width="100%">
						  <tr>
								<td style="padding: 20px; mso-height-rule: exactly; line-height: 30px; color: #707070; font-size: 14px">
									<span style="font-weight: bold; font-size: 18px" class="cne-ac-header"></span>
									<hr color="#c0c0c0">
                                                                        <p style="margin: 20px 0;" class="cnew_content"> {{{content}}} </p>
									<hr color="#c0c0c0">
                                                                        <span class="cnew_footer">
                                                                            <?php
                                                                            do_action( 'bp_before_email_footer' );
                                                                            ?>

                                                                            <span class="footer_text"><?php echo nl2br( stripslashes( $settings['footer_text'] ) ); ?></span>
                                                                            

                                                                            <?php
                                                                            do_action( 'bp_after_email_footer' );
                                                                            ?>
                                                                        </span>
								</td>
						  </tr>
						</table>
					</td>
				</tr>
				<!-- 1 Column Text : BEGIN -->

			</table>
			<!-- Email Body : END -->

			
			<!--[if (gte mso 9)|(IE)]>
			</td>
			</tr>
			</table>
			<![endif]-->
		</div>
	</center>
</td></tr></table>
</body>
</html>
