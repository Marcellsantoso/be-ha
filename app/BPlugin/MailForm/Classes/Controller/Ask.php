<?php

/**
 * Created by PhpStorm.
 * User: MarcelSantoso
 * Date: 2/9/15
 * Time: 11:10 AM
 */
class Ask extends WebService {

	function sendQuestion ()
	{
		$message = 'Name : ' . $_POST['name'] . "\n";
		$message .= 'Email : ' . $_POST['email'] . "\n";
		$message .= 'Mobile : ' . $_POST['mobile'] . "\n";
		$message .= 'Question : ' . "\n" . $_POST['question'];

		$headers = "From: " . $_POST['email'] . "\r\n";
		$headers .= "Cc: " . $_POST['email'];
		print_r(mail(Efiwebsetting::getEmail(), 'Hulx Inquiry from ' . $_POST['name'], $message, $headers));
	}

	static function askForm ()
	{
		?>
		<div class="container">
			<div class="content inside-page collection">
				<div class="breadcrumb"><a href="<?= _SPPATH ?>">Home</a> / <span>Ask</span></div>
				<form class="form-horizontal"
				      style="margin-top: 10px;">
					<fieldset>

						<!-- Form Name -->
						<legend>Ask Us a Question</legend>

						<!-- Text input-->
						<div class="form-group">
							<label class="col-md-4 control-label">Name</label>

							<div class="col-md-5">
								<input id="input_name"
								       name="input_name"
								       type="text"
								       placeholder="Name"
								       class="form-control input-md">

							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Email</label>

							<div class="col-md-5">
								<input id="input_email"
								       name="input_email"
								       type="email"
								       placeholder="Email"
								       class="form-control input-md">

							</div>
						</div>

						<!-- Text input-->
						<div class="form-group">
							<label class="col-md-4 control-label">Mobile No.</label>

							<div class="col-md-4">
								<input id="input_mobile"
								       name="input_mobile"
								       type="text"
								       placeholder="Mobile No."
								       class="form-control input-md"
								       onkeypress="validateNumber(event)">

							</div>
						</div>

						<!-- Textarea -->
						<div class="form-group">
							<label class="col-md-4 control-label">Question</label>

							<div class="col-md-4">
								<textarea class="form-control"
								          id="input_question"
								          name="input_question"></textarea>
							</div>
						</div>
					</fieldset>
				</form>

				<div class="col-md-6 col-md-offset-3"
				     style="text-align: center">
					<div class="col-md-6 col-md-offset-3"
					     style="padding-bottom: inherit">
						<button type="button"
						        class="btn btn-success btn-block"
						        onclick="sendQuestion();">
							Send Question
						</button>
					</div>
				</div>

				<div class="col-md-6 col-md-offset-3"
				     style="margin-top: 30px;">
					<div style="height: 1px; background-color: #e5e5e5; text-align: center">
						<span style="background-color: white; position: relative; top: -0.5em; padding: 0 10px 0 10px;"
						      class="sublegend"><strong>OR</strong></span>
					</div>

					<div style="text-align: center; margin-top: 30px;">
						Contact Us at : <?= Efiwebsetting::getEmail(); ?>
					</div>

				</div>
			</div>
		</div>

		<style>
			.form-control {
				border : 1px solid #60ad4f;
			}

			.btn {
				text-transform : uppercase;
				background     : none;
				border         : 1px solid #60ad4f;
				border-radius  : 0;
				color          : #60ad4f;
				font-family    : sans-serif;
				font-size      : 12px;
				padding        : 4px 25px 2px;
				letter-spacing : 1px;
			}

			.btn:hover {
				text-transform : uppercase;
				background     : #60ad4f;
				border         : 1px solid #60ad4f;
				border-radius  : 0;
				color          : #ffffff;
				font-family    : sans-serif;
				font-size      : 12px;
				padding        : 4px 25px 2px;
				letter-spacing : 1px;
			}
		</style>

		<script>
			function validateNumber(evt) {
				var theEvent = evt || window.event;
				var key = theEvent.keyCode || theEvent.which;
				key = String.fromCharCode(key);
				var regex = /[0-9]|\./;
				if (!regex.test(key)) {
					theEvent.returnValue = false;
					if (theEvent.preventDefault) theEvent.preventDefault();
				}
			}

			function sendQuestion() {
				var name = $('#input_name').val();
				var email = $('#input_email').val();
				var mobile = $('#input_mobile').val();
				var question = $('#input_question').val();

				if (!name || !email || !mobile || !question) {
					console.log('asd');
					alert('Please fill up all fields');
				} else {
					$.post('<?=_BPATH;?>' + 'Ask/sendQuestion',
						{
							name: name,
							email: email,
							mobile: mobile,
							question: question
						}, function (data) {
							if (data) {
								document.location = '<?=_SPPATH;?>' + 'thankyou';
							}
						});
				}
			}
		</script>
	<?
	}

	static function thankyou ()
	{
		?>
		<div class="container">
			<div class="content inside-page collection">
				<div class="breadcrumb"><a href="<?= _SPPATH ?>">Home</a> / <a href="<?= _SPPATH; ?>ask">Ask</a> /
					<span>Confirmation</span></div>
				<h4 style="margin-top: 20px;">Thank You For Your Question</h4>
				We will get back to you as soon as possible.
			</div>
		</div>
	<?
	}
} 