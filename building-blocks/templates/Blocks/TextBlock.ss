<div class="block text-block">
    <% if $Content %>
		<div class="pane rounded content">
            <% if $ShowTitle %>
				<h2>$Title</h2>
            <% end_if %>
            $WritingFrameIcon
            $Content
		</div>
    <% end_if %>
</div>
$WritingFrameModal