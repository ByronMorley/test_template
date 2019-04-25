<div class="block logo-block">
    <% if $Logos %>
		<div class="pane rounded content">
            <% if $ShowTitle %>
				<h2>$Title</h2>
            <% end_if %>
			<ul class="logo-set $alignment">
                <% control $Logos %>
					<li><img style="max-height:$Top.MaxHeight;" src="$Image.filename" alt="$Title"/></li>
                <% end_control %>
			</ul>
		</div>
    <% end_if %>
</div>