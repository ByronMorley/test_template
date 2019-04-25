<div class="block word-bank-block">
	<div class="pane rounded content typography">
        <% if $ShowTitle %>
			<h2>$Title</h2>
        <% end_if %>
        <% if $Content %>
			$Content
        <% end_if %>
        $WritingFrameIcon
        <ul class="word-bank">
            <% control $Phrases %>
                <li class="phrase $Style">
                    <span>$Phrase</span>
                </li>
            <% end_control %>
        </ul>
	</div>
</div>
$WritingFrameModal