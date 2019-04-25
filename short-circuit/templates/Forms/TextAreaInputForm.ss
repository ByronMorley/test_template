<form id="TextAreaInputForm_$InputFrame.ID" name="$Form.FormName" action="$Form.FormAction" method="post"  enctype="application/x-www-form-urlencoded">
	<fieldset>
        <input type="hidden" name="FrameID" value="$InputFrame.ID" id="TextAreaInputForm_TextAreaInputForm_FrameID" class="hidden">
        <input type="hidden" name="BlockID" value="$InputBlock.ID" id="TextAreaInputForm_TextAreaInputForm_BlockID" class="hidden">
		<textarea placeholder="Write here..." name="Textarea" class="htmleditor" id="TextAreaInputForm_TextAreaInputForm_Textarea" rows="30" cols="20" tinymce="false" style="width: 100%; height:300px; margin-top:0;" data-config="default">$InputFrame.Content</textarea>
	</fieldset>
		<div class="Actions">
			<input type="button" onclick="submitAll(event, $InputBlock.ID)" name="action_SaveAll" value="Save and Close" class="action" id="TextAreaInputForm_TextAreaInputForm_action_SaveAll">
		</div>
        $Form.Fields.dataFieldByName('SecurityID')
</form>