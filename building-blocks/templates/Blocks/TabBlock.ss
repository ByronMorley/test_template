<div class="block tab-block">
    <% if $Blocks %>
			<ul class="nav nav-tabs justify-content-end" id="nav-tab" role="tablist">
                <% control $Blocks %>
				<li class="nav-item">
					<a class="nav-link"
                       id="nav-tab-$ID"
                       data-toggle="tab"
                       href="#nav$ID"
                       role="tab"
                       aria-controls="nav$ID"
                        aria-selected="<% if $Pos ==1 %>true<% else %>false<% end_if %>" >$Title</a>
                </li>
                <% end_control %>
			</ul>
		<div class="tab-content" id="nav-tabContent">
            <% control $Blocks %>
				<div class="tab-pane fade" id="nav$ID" role="tabpanel" aria-labelledby="nav-tab-$ID">
					$Content
				</div>
            <% end_control %>
		</div>
    <% end_if %>
</div>
