<div class="background-image">
    <% if $SingleImage %>
        <img src="$SingleImage.Filename" class="bottom"/>
    <% else %>
        <img src="$getBackgroundImage.Filename" class="bottom"/>
    <% end_if %>
    <%if $getBackgroundImage %>
        <img src="$getBackgroundImage.Filename" class="top"/>
    <% end_if %>
    <% if $SingleImage %>
        $setBackgroundImage($SingleImage.ID)
    <% end_if %>
</div>