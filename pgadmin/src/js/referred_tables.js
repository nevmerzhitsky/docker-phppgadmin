$(document).ready(function() {
    function trigger() {
        if (this.popup) {
            $(this.popup).remove();
            delete this.popup;
            return;
        }
        var div = document.createElement('DIV');
        var hiddens = $('input', this);
        var lines = [];
        for (var i = 0; i < hiddens.length; i++) {
            var path = hiddens[i].name.split(".");
            lines.push("<a href='" + hiddens[i].value + "'><div class='refererrer'><b>" + path[1] + "</b>." + path[2] + "<span class='" + hiddens[i].name + "'></span></div></a>");
        }
        div.innerHTML = lines.join("\n");
        div.className = "ajax_referrers_popup small";
        $(this).after(div);
        this.popup = div;
    }
    
    $('.ajax_referrers').click(function() {
        trigger.apply(this);
    });
    
    $('.ajax_referrers_opened').each(function() {
        trigger.apply(this);
    });
});