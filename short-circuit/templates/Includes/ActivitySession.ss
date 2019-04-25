<div class="aside-item activity-session-widget">
	<h6 class="title">Activity Profile</h6>
	<div class="pane round content">
		<div class="inner">

            <% if $SessionActive %>
				<div class="pane head">
					<span class="as-title">$Username</span>
				</div>
				<div class="pane body">
					<p>You are currently Logged in</p>
				</div>
				<div class="pane foot">
					<ul class="section right">
						<li>$SessionEndForm</li>
						<li>
							<button>Work</button>
						</li>

					</ul>
				</div>
            <% else %>
				<div class="pane head">
					<span class="as-title">Login</span>
				</div>
				<div class="pane body">
					<p>To particpate in interactive activities on this site you must login. to create a profile simply enter your desired username and password and press login.</p>
				</div>
				<div class="pane body">
                    $SessionLoginForm
				</div>
            <% end_if %>
		</div>
	</div>
</div>