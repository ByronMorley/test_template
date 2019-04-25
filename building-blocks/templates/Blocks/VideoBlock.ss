<div class="block video-block">
    <% if $VideoFileID %>
        <% with $VideoFile %>
		<div class="pane rounded content">
			<h2>$Title</h2>
			<h3 class="description">$Content</h3>
			<div class="video-wrapper">
				<video id="video_1" class="$Title video-js vjs-default-skin" width="640px" height="380px"
					   controls preload="none" poster='$PosterImage.Filename'>
					<source src="$MP4Video.AbsoluteURL" type="video/mp4"/>
                    <% if $WebMVideo %>
						<source src="$WebMVideo.AbsoluteURL" type="video/webm"/><% end_if %>
                    <% if $OggVideo %>
						<source src="$OggVideo.AbsoluteURL" type="video/ogg"/><% end_if %>
					<p class="vjs-no-js">
						To view this video please enable JavaScript, and consider upgrading to a web browser
						that <a href="http://videojs.com/html5-video-support/" target="_blank">supports
						HTML5 video</a>
					</p>
				</video>
			</div>
        </div>
        <% end_with %>
    <% else %>
	<div class="pane rounded content">
		<div class="video-wrapper">
			<video width="640px" height="380px"
				   controls preload="none" poster='$ThemeDir/assets/images/no-video-found.png'>
			</video>
		</div>
    </div>
    <% end_if %>
</div>