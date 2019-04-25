<footer>
    <div id="container">
    <div class="translation text-center">
        <% control $Translations %>
            <a href="$Link" hreflang="$Locale.RFC1766" title="$Title" class="$Locale.RFC1766 change-language">
                <p style="color: white"><% if $IsEnglish%>
                    Welsh
                <% else %>
                    Saesneg<% end_if %></p>
            </a>
        <% end_control %>

    </div>

    <div class = "container text-center">

        <a style="float: left; margin-left: 30px";
            <% if $IsEnglish%>
           href="acknowledgement">Acknowledgement
            <% else %>
                href="cydnabyddiaethau">Cydnabyddiaethau<% end_if %> </a>

        <a style= "float: right; margin-right: 30px; color: white">GowerProject © 2019</a>


    </div>

    </div>

</footer>