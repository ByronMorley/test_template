<div class="block image-block">
	<div class="pane round content">
        <% if $ShowTitle %>
			<h2>$Title</h2>
        <% end_if %>
        <% if $Photo %>
		<div class="image-wrapper">
				<img src="<% if $isGif($Photo.Link) %>$Photo.Link<% else %>$Photo.ScaleWidth(800).Link<% end_if %>" class="$width $align <% if $border %>border<% end_if %>"
                     alt="<% if $alt %>$alt<% else %>$Photo.Name<% end_if %>"/>
        <% if $highResImage %>
			<div class="hi-res-download">
				<a class="hi-res-download-link" href="$Photo.Link" target="_blank"><%t BuildingBlocks.HiResImage %></a>
			</div>
        <% end_if %>
	</div>
        <% if $caption %>
			<div class="caption">$caption</div>
        <% end_if %>
        <% end_if %>
	</div>
</div>