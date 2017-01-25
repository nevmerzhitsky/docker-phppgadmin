$(function() {
    var $tds = $('*[data-instant-filter]');
    var $div = $('#instant-filter');
    var $inp = $div.find('input');
    var $conts = $('.instant-filter-cont');
    if (!$tds.length || !$inp.length) return;

    var inpIsEmpty = true;
    function changeInpIsEmpty(empty) {
        inpIsEmpty = empty;
        if (!empty) {
            $div.removeClass('instant-filter-empty');
        } else {
            $div.addClass('instant-filter-empty');
        }
    }

    var $bestElt = null;
    function changeBestElt($elt) {
        if ($bestElt) $bestElt.removeClass('instant-filter-best');
        $bestElt = $elt;
        if ($bestElt) $bestElt.addClass('instant-filter-best');
    }

    function calcBestElt($td) {
        var $tr = $td.closest('tr');
        var $betterTd = $tr.find('.instant-filter-action-select');
        if ($betterTd.length) return $betterTd;
        return $td;
    }

    var timer = null;
    function applyDefer() {
        if (timer) clearTimeout(timer);
        timer = setTimeout(apply, 50);
    }

    function wild2re(wild) {
        var re = wild;
        re = re.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
        re = re.replace(/\\\*/g, '.*')
        re = "^" + re;
        return re;
    }

    function apply() {
        changeBestElt(null);
        $conts.hide();

        var wild = $.trim($inp.val());
        if (wild != '') {
            changeInpIsEmpty(false);
            var re = wild2re(wild);
            var shortestText = null;
            $tds.each(function() {
                var $td = $(this);
                var text = $td.attr('data-instant-filter');
                if (text.match(re)) {
                    $td.parents('.instant-filter-cont').show();
                    if (!shortestText || text.length < shortestText.length) {
                        shortestText = text;
                        changeBestElt(calcBestElt($td));
                    }
                }
            });
        } else {
            $conts.show();
        }
    }

    changeInpIsEmpty(true);
    $div.show();
    $inp.focus();
    $inp.bind('keyup', applyDefer).bind('cut', applyDefer).bind('paste', applyDefer);

    $inp.keydown(function(e) {
        if (e.keyCode == 27) {
            e.preventDefault();
            $inp.val('');
            apply();
            changeInpIsEmpty(true);
        }
        if (e.keyCode == 13 && $bestElt) {
            e.preventDefault();
            var $a = $bestElt.find('a');
            if ($a.length) $a[0].click();
        }
        if (e.keyCode == 8 && inpIsEmpty) {
            e.preventDefault();
            history.back();
        }
    });
});