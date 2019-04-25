<div class="block gallery-block">
    <% if $ShowTitle %>
        <h2>$Title</h2>
    <% end_if %>
    <div class="fotorama" data-auto="false">
    </div>
</div>
<% require css("fotorama/fotorama.css") %>
<% require javascript("fotorama/fotorama.js") %>
<script>
    $(document).ready(function () {
        $(function () {
            $('.fotorama').fotorama({
                        nav: 'thumbs',
                        width: '100%',
                        data: [
                            <% loop $GalleryImages %>
                                {
                                    img: '$Image.filename',
                                    caption: "$Caption",
                                    alt: "$Title"
                                },
                            <% end_loop %>
                        ]
                    }
            );
        });
    });
</script>