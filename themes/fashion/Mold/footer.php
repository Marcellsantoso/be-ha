<!-- footer -->
<div class="footer navbar-fixed-bottom"
     role="navigation">
	<div class="container">
		<div class="social pull-left">
			<a href="<?= Efiwebsetting::getFBPage(); ?>"><i class="fa fa-facebook-square"
			                                                data-toggle="tooltip"
			                                                data-placement="top"
			                                                data-original-title="facebook"></i></a>
			<a href="<?= Efiwebsetting::getInstagramPage(); ?>"><i class="fa fa-instagram"
			                                                       data-toggle="tooltip"
			                                                       data-placement="top"
			                                                       data-original-title="instagram"></i></a>
		</div>
		<div class="pull-left">
			<div class="links">
				<b>Whatsapp : </b> +62 812 398 999 62 || <b>Line : </b>santoso.marcellinus
			</div>
		</div>

	</div>
</div>

<!-- footer -->

<script src="<?= _SPPATH . _THEMEPATH ?>/assets/jquery.js"></script>

<!-- wow script -->
<script src="<?= _SPPATH . _THEMEPATH ?>/assets/wow/wow.min.js"></script>

<!-- uniform -->
<script src="<?= _SPPATH . _THEMEPATH ?>/assets/uniform/js/jquery.uniform.js"></script>

<!-- boostrap -->
<script src="<?= _SPPATH . _THEMEPATH ?>/assets/bootstrap/js/bootstrap.js"
        type="text/javascript"></script>

<!-- jquery mobile -->
<script src="<?= _SPPATH . _THEMEPATH ?>/assets/mobile/touchSwipe.min.js"></script>

<!-- jquery mobile -->
<script src="<?= _SPPATH . _THEMEPATH ?>/assets/respond/respond.js"></script>

<!-- jQuery easing plugin -->
<script src="<?= _SPPATH . _THEMEPATH ?>/assets/form/jquery.easing.min.js"
        type="text/javascript"></script>

<!-- custom script -->
<script src="<?= _SPPATH . _THEMEPATH ?>/assets/script.js"></script>

<!-- tag cloud -->
<script type="text/javascript"
        src="<?= _SPPATH . _THEMEPATH ?>/assets/jquery.tx3-tag-cloud.js"></script>

<script>
	(function (i, s, o, g, r, a, m) {
		i['GoogleAnalyticsObject'] = r;
		i[r] = i[r] || function () {
			(i[r].q = i[r].q || []).push(arguments)
		}, i[r].l = 1 * new Date();
		a = s.createElement(o),
			m = s.getElementsByTagName(o)[0];
		a.async = 1;
		a.src = g;
		m.parentNode.insertBefore(a, m)
	})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

	ga('create', 'UA-62367182-1', 'auto');
	ga('send', 'pageview');

</script>

<!-- login modal -->
<div class="modal fade"
     id="login">
	<div class="modal-dialog">
		<div class="modal-content">
			<button type="button"
			        class="close"
			        data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
			</button>

			<div class="row">
				<div>
					<h4>Sign In via Facebook</h4>

					<div class="fb-login-button"
					     data-max-rows="1"
					     data-size="large"
					     data-show-faces="true"
					     data-auto-logout-link="true"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- login modal -->

</body>
</html>





