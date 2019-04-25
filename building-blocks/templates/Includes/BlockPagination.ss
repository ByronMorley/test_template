<div class="d-flex block pagination-block">
	<ul>
		<li class="page-item"><a class="page-link" href="$Parent.Parent.Link"><%t Menu.BACK_TO_MENU %></a></li>
	</ul>
	<ul class="js-pagination pagination mx-right" id="pagination-$ID">

        <% if $Parent.Children %>
            <%--<li class="page-item start_dot"><a class="page-link " href="">...</a></li>--%>
            <% control $Parent.Children %>
				<li class="page-item <% if $LinkingMode =='current' %>active<% end_if %>">
                    <a class="page-link" href="$Link">$Pos</a>
                </li>
            <% end_control %>
			<!--<li class="page-item end_dot"><a class="page-link " href="">...</a></li>-->
        <% end_if %>
	</ul>
</div>
<script>
	$('#pagination-$ID').paginator();
</script>