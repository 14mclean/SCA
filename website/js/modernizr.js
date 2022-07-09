/*! modernizr 3.6.0 (Custom Build) | MIT *
 * https://modernizr.com/download/?-prefixed-setclasses !*/
!function (e, n, t) { function r(e, n) { return typeof e === n } function o() { var e, n, t, o, i, s, a; for (var l in C) if (C.hasOwnProperty(l)) { if (e = [], n = C[l], n.name && (e.push(n.name.toLowerCase()), n.options && n.options.aliases && n.options.aliases.length)) for (t = 0; t < n.options.aliases.length; t++)e.push(n.options.aliases[t].toLowerCase()); for (o = r(n.fn, "function") ? n.fn() : n.fn, i = 0; i < e.length; i++)s = e[i], a = s.split("."), 1 === a.length ? Modernizr[a[0]] = o : (!Modernizr[a[0]] || Modernizr[a[0]] instanceof Boolean || (Modernizr[a[0]] = new Boolean(Modernizr[a[0]])), Modernizr[a[0]][a[1]] = o), h.push((o ? "" : "no-") + a.join("-")) } } function i(e) { var n = _.className, t = Modernizr._config.classPrefix || ""; if (w && (n = n.baseVal), Modernizr._config.enableJSClass) { var r = new RegExp("(^|\\s)" + t + "no-js(\\s|$)"); n = n.replace(r, "$1" + t + "js$2") } Modernizr._config.enableClasses && (n += " " + t + e.join(" " + t), w ? _.className.baseVal = n : _.className = n) } function s(e) { return e.replace(/([a-z])-([a-z])/g, function (e, n, t) { return n + t.toUpperCase() }).replace(/^-/, "") } function a(e, n) { return function () { return e.apply(n, arguments) } } function l(e, n, t) { var o; for (var i in e) if (e[i] in n) return t === !1 ? e[i] : (o = n[e[i]], r(o, "function") ? a(o, t || n) : o); return !1 } function f(e, n) { return !!~("" + e).indexOf(n) } function u() { return "function" != typeof n.createElement ? n.createElement(arguments[0]) : w ? n.createElementNS.call(n, "http://www.w3.org/2000/svg", arguments[0]) : n.createElement.apply(n, arguments) } function p(n, t, r) { var o; if ("getComputedStyle" in e) { o = getComputedStyle.call(e, n, t); var i = e.console; if (null !== o) r && (o = o.getPropertyValue(r)); else if (i) { var s = i.error ? "error" : "log"; i[s].call(i, "getComputedStyle returning null, its possible modernizr test results are inaccurate") } } else o = !t && n.currentStyle && n.currentStyle[r]; return o } function c(e) { return e.replace(/([A-Z])/g, function (e, n) { return "-" + n.toLowerCase() }).replace(/^ms-/, "-ms-") } function d() { var e = n.body; return e || (e = u(w ? "svg" : "body"), e.fake = !0), e } function m(e, t, r, o) { var i, s, a, l, f = "modernizr", p = u("div"), c = d(); if (parseInt(r, 10)) for (; r--;)a = u("div"), a.id = o ? o[r] : f + (r + 1), p.appendChild(a); return i = u("style"), i.type = "text/css", i.id = "s" + f, (c.fake ? c : p).appendChild(i), c.appendChild(p), i.styleSheet ? i.styleSheet.cssText = e : i.appendChild(n.createTextNode(e)), p.id = f, c.fake && (c.style.background = "", c.style.overflow = "hidden", l = _.style.overflow, _.style.overflow = "hidden", _.appendChild(c)), s = t(p, e), c.fake ? (c.parentNode.removeChild(c), _.style.overflow = l, _.offsetHeight) : p.parentNode.removeChild(p), !!s } function v(n, r) { var o = n.length; if ("CSS" in e && "supports" in e.CSS) { for (; o--;)if (e.CSS.supports(c(n[o]), r)) return !0; return !1 } if ("CSSSupportsRule" in e) { for (var i = []; o--;)i.push("(" + c(n[o]) + ":" + r + ")"); return i = i.join(" or "), m("@supports (" + i + ") { #modernizr { position: absolute; } }", function (e) { return "absolute" == p(e, null, "position") }) } return t } function y(e, n, o, i) { function a() { p && (delete N.style, delete N.modElem) } if (i = r(i, "undefined") ? !1 : i, !r(o, "undefined")) { var l = v(e, o); if (!r(l, "undefined")) return l } for (var p, c, d, m, y, g = ["modernizr", "tspan", "samp"]; !N.style && g.length;)p = !0, N.modElem = u(g.shift()), N.style = N.modElem.style; for (d = e.length, c = 0; d > c; c++)if (m = e[c], y = N.style[m], f(m, "-") && (m = s(m)), N.style[m] !== t) { if (i || r(o, "undefined")) return a(), "pfx" == n ? m : !0; try { N.style[m] = o } catch (h) { } if (N.style[m] != y) return a(), "pfx" == n ? m : !0 } return a(), !1 } function g(e, n, t, o, i) { var s = e.charAt(0).toUpperCase() + e.slice(1), a = (e + " " + b.join(s + " ") + s).split(" "); return r(n, "string") || r(n, "undefined") ? y(a, n, o, i) : (a = (e + " " + z.join(s + " ") + s).split(" "), l(a, n, t)) } var h = [], C = [], S = { _version: "3.6.0", _config: { classPrefix: "", enableClasses: !0, enableJSClass: !0, usePrefixes: !0 }, _q: [], on: function (e, n) { var t = this; setTimeout(function () { n(t[e]) }, 0) }, addTest: function (e, n, t) { C.push({ name: e, fn: n, options: t }) }, addAsyncTest: function (e) { C.push({ name: null, fn: e }) } }, Modernizr = function () { }; Modernizr.prototype = S, Modernizr = new Modernizr; var _ = n.documentElement, w = "svg" === _.nodeName.toLowerCase(), x = "Moz O ms Webkit", b = S._config.usePrefixes ? x.split(" ") : []; S._cssomPrefixes = b; var E = function (n) { var r, o = prefixes.length, i = e.CSSRule; if ("undefined" == typeof i) return t; if (!n) return !1; if (n = n.replace(/^@/, ""), r = n.replace(/-/g, "_").toUpperCase() + "_RULE", r in i) return "@" + n; for (var s = 0; o > s; s++) { var a = prefixes[s], l = a.toUpperCase() + "_" + r; if (l in i) return "@-" + a.toLowerCase() + "-" + n } return !1 }; S.atRule = E; var z = S._config.usePrefixes ? x.toLowerCase().split(" ") : []; S._domPrefixes = z; var P = { elem: u("modernizr") }; Modernizr._q.push(function () { delete P.elem }); var N = { style: P.elem.style }; Modernizr._q.unshift(function () { delete N.style }), S.testAllProps = g; S.prefixed = function (e, n, t) { return 0 === e.indexOf("@") ? E(e) : (-1 != e.indexOf("-") && (e = s(e)), n ? g(e, n, t) : g(e, "pfx")) }; o(), i(h), delete S.addTest, delete S.addAsyncTest; for (var j = 0; j < Modernizr._q.length; j++)Modernizr._q[j](); e.Modernizr = Modernizr }(window, document);