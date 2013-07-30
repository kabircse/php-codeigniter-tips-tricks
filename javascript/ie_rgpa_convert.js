var IETranslucencyCalc = (function () {
    var form, inpRGBa, inpFilter, hexvals = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "A", "B", "C", "D", "E", "F"],
        mscss = "<span>{</span>" + "<span class=\"tab\">background: transparent;</span>" + "<span class=\"tab\">-ms-filter: \"progid:DXImageTransform.Microsoft.gradient(startColorstr=#FILTERED,endColorstr=#FILTERED)\";&nbsp;/* IE8 */</span>" + "<span class=\"tab\">&nbsp;&nbsp;&nbsp;&nbsp;filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#FILTERED,endColorstr=#FILTERED);&nbsp;&nbsp;&nbsp;/* IE6 & 7 */</span>" + "<span class=\"tab\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;zoom: 1;</span>" + "<span>}</span>",
        error = "That doesn't look like a valid RGBa or HSLa value to me.",
        setup = function () {
            form.onsubmit = function () {
                return false;
            };
            inpRGBa.onkeyup = convert;
        }, convert = function () {
            var filtered, val = inpRGBa.value,
                colorType = val.substring(0, 3),
                colorDefinition = val.match(/^(rgb|hsl)a\(((([0-9]{1,3})\s*,\s*)(([0-9]{1,3})\%?\s*,\s*)(([0-9]{1,3})\%?\s*)(,\s*((0?(\.[0-9]+)?)|(1(\.0)?))))\)/);
            if (val === "") {
                inpFilter.innerHTML = "";
            } else if (colorType === "rgb" && colorDefinition !== null && typeof colorDefinition[0] === 'string') {
                filtered = parseRGBa(colorDefinition[2]);
                inpFilter.innerHTML = mscss.replace(/FILTERED/g, filtered);
            } else if (colorType === "hsl" && colorDefinition !== null && typeof colorDefinition[0] === 'string') {
                filtered = parseHSLa(colorDefinition[2]);
                inpFilter.innerHTML = mscss.replace(/FILTERED/g, filtered);
            } else {
                inpFilter.innerHTML = error;
            }
        }, parseRGBa = function (rgba) {
            rgba = rgba.split(',');
            var a = rgba[3] || 1,
                c, current, filterValue = "";
            for (c = 0; c < 3; c++) {
                current = parseInt(rgba[c], 10);
                if (current < 0) {
                    current = 0;
                } else if (current > 255) {
                    current = 255;
                }
                filterValue += (hexvals[parseInt((current / 16), 10)] + hexvals[parseInt((current % 16), 10)]);
            }
            filterValue = getAlpha(a) + filterValue;
            return filterValue;
        }, parseHSLa = function (hsla) {
            hsla = hsla.split(',');
            var h = parseInt(hsla[0], 10),
                s = parseInt(hsla[1], 10),
                l = parseInt(hsla[2], 10),
                a = hsla[3] || 1,
                current, temp1, temp2, r, g, b, filterValue = "";
            h = (h < 0) ? 0 : ((h > 360) ? 360 : h) / 360;
            s = (s < 0) ? 0 : ((s > 100) ? 100 : s) / 100;
            l = (l < 0) ? 0 : ((l > 100) ? 100 : l) / 100;
            if (s === 0) {
                for (var x = 0; x < 3; x++) {
                    current = l * 255;
                    filterValue += (hexvals[parseInt((current / 16), 10)] + hexvals[parseInt((current % 16), 10)]);
                }
            } else {
                temp2 = (l < 0.5) ? (l * (1 + s)) : (l + s - l * s);
                temp1 = 2 * l - temp2;
                r = hueToRGB(temp1, temp2, h + 1 / 3) * 255;
                g = hueToRGB(temp1, temp2, h) * 255;
                b = hueToRGB(temp1, temp2, h - 1 / 3) * 255;
                filterValue += (hexvals[parseInt((r / 16), 10)] + hexvals[parseInt((r % 16), 10)]);
                filterValue += (hexvals[parseInt((g / 16), 10)] + hexvals[parseInt((g % 16), 10)]);
                filterValue += (hexvals[parseInt((b / 16), 10)] + hexvals[parseInt((b % 16), 10)]);
            }
            filterValue = getAlpha(a) + filterValue;
            return filterValue;
        }, hueToRGB = function (p, q, t) {
            if (t < 0) {
                t += 1;
            }
            if (t > 1) {
                t -= 1;
            }
            if (t < 1 / 6) {
                return p + (q - p) * 6 * t;
            }
            if (t < 1 / 2) {
                return q;
            }
            if (t < 2 / 3) {
                return p + (q - p) * (2 / 3 - t) * 6;
            }
            return p;
        }, getAlpha = function (alpha) {
            alpha = parseFloat(alpha, 10);
            if (alpha < 0) {
                alpha = 0;
            } else if (alpha > 1) {
                alpha = 1;
            }
            alpha = alpha * 255;
            return (hexvals[parseInt((alpha / 16), 10)] + hexvals[parseInt((alpha % 16), 10)]);
        };
    return {
        initialize: function () {
            form = document.getElementById('rgbacalc');
            inpRGBa = document.getElementById('rgba');
            inpFilter = document.getElementById('iefilter');
            if (typeof form === 'undefined' || typeof inpRGBa === 'undefined' || typeof inpFilter === 'undefined') {
                return;
            }
            setup();
        }
    };
})();
IETranslucencyCalc.initialize();
/*
<form id="rgbacalc" accept-charset="utf-8" method="get" action="./">
<label for="rgba">RGBa or HSLa Definition</label>
<fieldset><input type="text" id="rgba" value="" name="rgba"></fieldset>
<label for="iefilter">The IE Version</label>
<fieldset><div id="iefilter"></div></fieldset>
</form>
<!-- css -->
#rgbacalc{width:40em;margin:0 auto;}#rgbacalc label,#rgbacalc input,#rgbacalc div{display:block!important;float:none;width:47em;}#rgbacalc fieldset{border:1px solid #eee;width:39em;padding:0.5em;color:#c3230e;margin:0;background-color:#fff;}#rgbacalc label{margin-bottom:0.25em;white-space:nowrap;}#rgbacalc input,#rgbacalc div{margin:0em;font-family:Inconsolata,Courier,mono,monospace;color:#999;background-color:#1f1e1e;border-bottom:none;padding:0.5em;line-height:1.33;font-size:13px;}#rgbacalc div{height:8.5em;overflow:auto!important;}#rgbacalc div span{display:block;padding:0 0.5em;line-height:1.33;white-space:nowrap;}#rgbacalc div span+span{border-top:1px solid #222;}#rgbacalc div span.tab{padding-left:3em;}#rgbacalc div br{line-height:0;margin:0;padding:0;}


*/