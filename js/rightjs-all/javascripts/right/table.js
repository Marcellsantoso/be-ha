/**
 * Tables Specific Wrappers v2.2.0
 * http://rightjs.org/plugins/table
 *
 * Copyright (C) 2009-2011 Nikolay Nemshilov
 */
var Table = RightJS.Table = function (a) {
    var b = a, c = a.$, d = a.$E, e = a.isHash, f = a.isElement, g = a.Class, h = a.Object, i = a.Element, j = i.Wrappers.TABLE = new g(i, {
        extend: {
            version: "2.2.0",
            Options: {
                ascMarker: "&#x25BC;",
                descMarker: "&#x25B2;",
                algorithm: "text",
                order: "asc",
                sortedClass: "sorted"
            }
        }, initialize: function (a) {
            var b = a || {}, c = b;
            e(b) && !f(b) && (c = "table"), this.$super(c, b), this.options = h.merge(j.Options, new Function("return " + this.get("data-table")))
        }, sort: function (a, c, e) {
            var f = a instanceof i ? a : this.header().last().children("th")[a];
            if (!f)return this;
            a = f.parent().children("th").indexOf(f), c = c || (this.marker && this.marker.parent() === f ? this.marker.asc ? "desc" : "asc" : null), e = e || (f.hasClass("numeric") ? "numeric" : null), c = c || this.options.order, e = e || this.options.algorithm, sortedClass = this.options.sortedClass;
            var g = this.rows().map(function (c) {
                var d = c.children("td")[a], f = d ? d.text() : "";
                e === "numeric" && (f = b(f).toFloat());
                return {row: c, text: f}
            }), h = g[0] ? d("tr").insertTo(g[0].row, "before") : d("tr").insertTo(this.first("tbody") || this);
            typeof e !== "function" && (e = c === "asc" ? function (a, b) {
                return a.text > b.text ? 1 : a.text < b.text ? -1 : 0
            } : function (a, b) {
                return a.text > b.text ? -1 : a.text < b.text ? 1 : 0
            }), g.sort(e).reverse().each(function (a) {
                h.insert(a.row, "after")
            }), h.remove(), this.marker = (this.marker || f.first("span.sort-marker") || d("span", {"class": "sort-marker"})).update(this.options[c === "asc" ? "ascMarker" : "descMarker"]).insertTo(f, "bottom"), this.marker.asc = c === "asc", this.find("th").each(function (a) {
                a.removeClass(sortedClass)
            }), this.marker.parent().toggleClass(sortedClass);
            return this
        }, rows: function () {
            return this.find("tr").reject(function (a) {
                return a.first("th") || a.parent("tfoot")
            })
        }, header: function () {
            return this.find("tr").filter("first", "th")
        }, footer: function () {
            return this.find("tfoot > tr")
        }
    });
    c(document).onClick(function (a) {
        var b = a.find("th.sortable");
        b && b.parent("table").sort(b)
    });
    return j
}(RightJS)