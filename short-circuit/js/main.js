var submitAjaxForm = function (evt) {
    evt.preventDefault();
    var $form = $(evt.target);
    submit($form);
    return false;
};

var submitAll = function (evt, $id) {
    evt.preventDefault();
    $modal = $('#modal-' + $id);
    var $forms = $modal.find('form')

    $forms.each(function () {
        submit($(this));
    })

    $modal.modal('hide');
}

var submit = function ($form) {
    $.ajax({
        type: "POST",
        url: $form.attr("action"),
        data: $form.serialize(),
        success: function (data) {
            console.log('Saved Successfully');
        }
    });
}