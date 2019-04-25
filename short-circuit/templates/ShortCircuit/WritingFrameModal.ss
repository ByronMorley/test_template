<% if $InputFrames %>
<div id="modal-$Block.ID" class="modal fade" role="dialog">
	<div class="modal-dialog  modal-lg">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Writing Frame</h4>
			</div>
			<div class="modal-body">
				<div class="">
					<ul class="pane round top nav nav-tabs " id="nav-tab" role="tablist">
                        <% control  $InputFrames %>
							<li class="nav-item">
								<a class="nav-link <% if $First %>active show<% end_if %>"
								   id="nav-tab-$ID"
								   data-toggle="tab"
								   href="#nav$ID"
								   role="tab"
								   aria-controls="nav$ID"
								   aria-selected="<% if $First %>true<% else %>false<% end_if %>">$Title</a>
							</li>
                        <% end_control %>
					</ul>
					<div class="tab-content" id="writingFrameTabs">
                        <% control $InputFrames %>
							<div class="tab-pane fade <% if $First %>active show<% end_if %>" id="nav$ID" role="tabpanel"
								 aria-labelledby="nav-tab-$ID">
								<div class="setup-text">
                                    <% if $SetupText %>$SetupText<% end_if %>
								</div>
                                $TextAreaInputForm
							</div>
                        <% end_control %>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<% end_if %>

