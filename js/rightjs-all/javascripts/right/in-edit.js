/**
 * RightJS-UI InEdit v2.2.0
 * http://rightjs.org/ui/in-edit
 *
 * Copyright (C) 2009-2011 Nikolay Nemshilov
 */
var InEdit = RightJS.InEdit = function (a, b) {
    function c(a, c) {
        c || (c = a, a = "DIV");
        var d = new b.Class(b.Element.Wrappers[a] || b.Element, {
            initialize: function (c, d) {
                this.key = c;
                var e = [{"class": "rui-" + c}];
                this instanceof b.Input || this instanceof b.Form || e.unshift(a), this.$super.apply(this, e), b.isString(d) && (d = b.$(d)), d instanceof b.Element && (this._ = d._, "$listeners"in d && (d.$listeners = d.$listeners), d = {}), this.setOptions(d, this);
                return b.Wrapper.Cache[b.$uid(this._)] = this
            }, setOptions: function (a, c) {
                c && (a = b.Object.merge(a, (new Function("return " + (c.get("data-" + this.key) || "{}")))())), a && b.Options.setOptions.call(this, b.Object.merge(this.options, a));
                return this
            }
        }), e = new b.Class(d, c);
        b.Observer.createShortcuts(e.prototype, e.EVENTS || b([]));
        return e
    }

    var d = new b.Class(b.Element, {
        initialize: function (a) {
            this.$super("div", {"class": "rui-spinner"}), this.dots = [];
            for (var c = 0; c < (a || 4); c++)this.dots.push(new b.Element("div"));
            this.dots[0].addClass("glowing"), this.insert(this.dots), b(this.shift).bind(this).periodical(300)
        }, shift: function () {
            if (this.visible()) {
                var a = this.dots.pop();
                this.dots.unshift(a), this.insert(a, "top")
            }
        }
    }), e = b, f = b.$, g = b.$w, h = b.Xhr, i = b.Object, j = b.Element, k = b.Input, l = new c("FORM", {
        extend: {
            version: "2.2.0",
            EVENTS: g("show hide send update"),
            Options: {url: null, name: "text", method: "put", type: "text", toggle: null, update: !0, Xhr: {}},
            i18n: {Save: "Save", Cancel: "Cancel"},
            current: null
        }, initialize: function (a, b) {
            this.element = f(a), this.$super("in-edit", b).set("action", this.options.url).insert([this.field = new k({
                type: this.options.type,
                name: this.options.name,
                "class": "field"
            }), this.spinner = new d(4), this.submit = new k({
                type: "submit",
                "class": "submit",
                value: l.i18n.Save
            }), this.cancel = new j("a", {
                "class": "cancel",
                href: "#",
                html: l.i18n.Cancel
            })]).onClick(this.clicked).onSubmit(this.send)
        }, show: function () {
            l.current !== this && (l.current && l.current.hide(), this.oldContent = this.element.html(), e(["file", "password"]).include(this.options.type) || this.field.setValue(this.oldContent), this.element.update(this), this.spinner.hide(), this.submit.show(), this.options.toggle && f(this.options.toggle).hide()), this.options.type !== "file" && this.field.focus(), l.current = this;
            return this.fire("show")
        }, hide: function () {
            this.element._.innerHTML = this.oldContent, this.xhr && this.xhr.cancel();
            return this.finish()
        }, send: function (a) {
            a && a.stop(), this.spinner.show().resize(this.submit.size()), this.submit.hide(), this.xhr = (new h(this.options.url, i.merge(this.options.Xhr, {
                method: this.options.method,
                spinner: this.spinner,
                onComplete: e(this.receive).bind(this)
            }))).send(this);
            return this.fire("send")
        }, finish: function () {
            this.options.toggle && f(this.options.toggle).show(), l.current = null;
            return this.fire("hide")
        }, receive: function () {
            this.options.update && (this.element.update(this.xhr.text), this.fire("update")), this.xhr = null, this.finish()
        }, clicked: function (a) {
            a.target === this.cancel && (a.stop(), this.hide())
        }
    });
    f(a).onKeydown(function (a) {
        a.keyCode === 27 && l.current && l.current.hide()
    }), j.include({
        inEdit: function (a) {
            return (new l(this, a)).show()
        }
    });
    var m = a.createElement("style"), n = a.createTextNode("div.rui-spinner,div.rui-spinner div{margin:0;padding:0;border:none;background:none;list-style:none;font-weight:normal;float:none;display:inline-block; *display:inline; *zoom:1;border-radius:.12em;-moz-border-radius:.12em;-webkit-border-radius:.12em}div.rui-spinner{text-align:center;white-space:nowrap;background:#EEE;border:1px solid #DDD;height:1.2em;padding:0 .2em}div.rui-spinner div{width:.4em;height:70%;background:#BBB;margin-left:1px}div.rui-spinner div:first-child{margin-left:0}div.rui-spinner div.glowing{background:#777}form.rui-in-edit,form.rui-in-edit .cancel{margin:0;padding:0;float:none;position:static}form.rui-in-edit{display:inline-block; *display:inline; *zoom:1;border:none;background:none}form.rui-in-edit div.rui-spinner{margin-right:.2em}form.rui-in-edit div.rui-spinner div{margin-top:.2em}form.rui-in-edit textarea.field{width:100%;margin-bottom:.5em}form.rui-in-edit .field,form.rui-in-edit .submit{margin-right:.2em}form.rui-in-edit,form.rui-in-edit .field,form.rui-in-edit .submit,form.rui-in-edit div.rui-spinner,form.rui-in-edit .cancel{vertical-align:middle}");
    m.type = "text/css", a.getElementsByTagName("head")[0].appendChild(m), m.styleSheet ? m.styleSheet.cssText = n.nodeValue : m.appendChild(n);
    return l
}(document, RightJS)