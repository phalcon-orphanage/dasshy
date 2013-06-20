
{% extends "layouts/index.volt" %}

{% block content %}

	{{ flash.output() }}

	<div align="center">

		<div class="login-signup-forms">

			<h2>Welcome!</h2>

			<ul class="nav nav-tabs">
				<li class="active"><a href="#A" data-toggle="tab" id="log-in">Log In</a></li>
				<li><a href="#B" data-toggle="tab" id="sign-up">Sign Up</a></li>
			</ul>
			<div class="tabbable">
				<div class="tab-content">

					<div class="tab-pane active" id="A">

						{{ form('login', 'autocomplete': 'off') }}

							<div class="login-form">
								<p>
									{{ loginForm.messages('login') }}
									{{ loginForm.render('login') }}
								</p>
								<p>
									{{ loginForm.messages('password') }}
									{{ loginForm.render('password') }}
								</p>
								<p>
									{{ loginForm.render('Log In') }}
								</p>
							</div>

						</form>
					</div>

					<div class="tab-pane" id="B">

						{{ form('signup', 'autocomplete': 'off') }}

							<div class="signup">
								<p>
									{{ signUpForm.messages('name') }}
									{{ signUpForm.render('name') }}
								</p>
								<p>
									{{ signUpForm.messages('login') }}
									{{ signUpForm.render('login') }}
								</p>
								<p>
									{{ signUpForm.messages('password') }}
									{{ signUpForm.render('password') }}
								</p>
								<p>
									{{ signUpForm.messages('confirmPassword') }}
									{{ signUpForm.render('confirmPassword') }}
								</p>
								<p>
									<table>
										<tr>
											<td colspan="2">{{ signUpForm.messages('terms') }}</td>
										</tr>
										<tr>
											<td>{{ signUpForm.render('terms') }}</td>
											<td>{{ signUpForm.label('terms') }}</td>
										</tr>
									</table>
								</p>
								<p>
									{{ signUpForm.render('Sign Up') }}
								</p>
							</div>

						</form>

					</div><!-- /tab-pane -->
				</div>
			</div> <!-- /tabbable -->

			<hr>

		</div> <!-- /login-signup-form -->

	</div>

	{% do assets.addJs("js/login.js") %}

{% endblock %}