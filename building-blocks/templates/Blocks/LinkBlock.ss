<div class="block link-block">
	<div class="pane content rounded">
        <% if $ShowTitle %>
			<h2>$Title</h2>
        <% end_if %>
        <% if $Content %>
            $Content
        <% end_if %>
		<ul class="link-elements">
            <% if $LinkElements %>
                <% control $LinkElements %>
					<li>
                        <% if $Prompt %>
							<span class="section left link-prompt">$Prompt:</span>
                        <% end_if %>
						<a href="<% if $ClassName == "DownloadFile" %>$File.FileName<% else %>$Href<% end_if %>"
						   class="section left"
                            <% if $ClassName == "ExternalLink" %>target="_blank" <% end_if %>
                            <% if $ClassName == "DownloadFile" %>download<% end_if %>
						>
                            <% if $LeftIcon %>
								<i class="$LeftIcon section left"></i>
                            <% end_if %>
							<span class="section left"><% if $ClassName == "DownloadFile" %>$File.Name<% else %>$Name<% end_if %></span>
                            <% if $RightIcon %>
								<i class="$RightIcon section left"></i>
                            <% end_if %>
						</a>
					</li>
                <% end_control %>
            <% end_if %>
		</ul>
	</div>
</div>