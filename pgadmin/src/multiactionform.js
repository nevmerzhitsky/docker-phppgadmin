function checkAll(formId, bool) {

    var inputs = document.getElementById(formId).getElementsByTagName('input');

    for (var i=0; i<inputs.length; i++) {
        if (inputs[i].type == 'checkbox')
            inputs[i].checked = bool;
    }
}
