function carspot_timerCounter_function(e) {
    jQuery(function(t) {
        var s = void 0 !== e && "" != e ? e : "clock";


        function n(e, s, n) { t(".bid_close").length > 0 && t(".bid_close").show(), n.hide() }
        var a = jQuery("#sb-bid-timezone").val();
        t("." + s).each(function(e, o) {
            var i = t(this).attr("data-rand");

            t(this).closest("div.days-" + i),
                function(e) {
                    function a(e) { return e < 10 ? "0" + e : e }
                    t.extend(!0, e, {});
                    var o = moment(),
                        i = moment.tz(e.endDate, e.timeZone).valueOf() - o.valueOf(),
                        u = moment.duration(i, "milliseconds"),
                        d = Math.floor(u.asDays()),
                        r = (t(".sub-message"), t("." + s));
                    if (i < 0) n(0, e.newSubMessage, r);
                    else {
                        d > 0 && e.days.text(a(d));
                        var c = setInterval(function() {
                            var t = (u = moment.duration(u - 1e3, "milliseconds")).hours(),
                                s = u.minutes(),
                                o = u.seconds();
                            d = Math.floor(u.asDays()), t <= 0 && s <= 0 && o <= 0 && d <= 0 && (clearInterval(c), n(0, e.newSubMessage, r)), e.days.text(a(d)), e.hours.text(a(t)), e.minutes.text(a(s)), e.seconds.text(a(o))
                        }, 1e3)
                    }
                }({ endDate: t(this).attr("data-date"), days: t(".days-" + i), hours: t(".hours-" + i), minutes: t(".minutes-" + i), seconds: t(".seconds-" + i), newSubMessage: "", timeZone: a })
        })
    })
}