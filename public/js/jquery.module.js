//#region node_modules/jquery/dist-module/jquery.module.js
/*!
* jQuery JavaScript Library v4.0.0
* https://jquery.com/
*
* Copyright OpenJS Foundation and other contributors
* Released under the MIT license
* https://jquery.com/license/
*
* Date: 2026-01-18T00:20Z
*/
function jQueryFactory(window, noGlobal) {
	if (typeof window === "undefined" || !window.document) throw new Error("jQuery requires a window with a document");
	var arr = [];
	var getProto = Object.getPrototypeOf;
	var slice = arr.slice;
	var flat = arr.flat ? function(array) {
		return arr.flat.call(array);
	} : function(array) {
		return arr.concat.apply([], array);
	};
	var push = arr.push;
	var indexOf = arr.indexOf;
	var class2type = {};
	var toString = class2type.toString;
	var hasOwn = class2type.hasOwnProperty;
	var fnToString = hasOwn.toString;
	var ObjectFunctionString = fnToString.call(Object);
	var support = {};
	function toType(obj) {
		if (obj == null) return obj + "";
		return typeof obj === "object" ? class2type[toString.call(obj)] || "object" : typeof obj;
	}
	function isWindow(obj) {
		return obj != null && obj === obj.window;
	}
	function isArrayLike(obj) {
		var length = !!obj && obj.length, type = toType(obj);
		if (typeof obj === "function" || isWindow(obj)) return false;
		return type === "array" || length === 0 || typeof length === "number" && length > 0 && length - 1 in obj;
	}
	var document$1 = window.document;
	var preservedScriptAttributes = {
		type: true,
		src: true,
		nonce: true,
		noModule: true
	};
	function DOMEval(code, node, doc) {
		doc = doc || document$1;
		var i, script = doc.createElement("script");
		script.text = code;
		for (i in preservedScriptAttributes) if (node && node[i]) script[i] = node[i];
		if (doc.head.appendChild(script).parentNode) script.parentNode.removeChild(script);
	}
	var version = "4.0.0", rhtmlSuffix = /HTML$/i, jQuery = function(selector, context) {
		return new jQuery.fn.init(selector, context);
	};
	jQuery.fn = jQuery.prototype = {
		jquery: version,
		constructor: jQuery,
		length: 0,
		toArray: function() {
			return slice.call(this);
		},
		get: function(num) {
			if (num == null) return slice.call(this);
			return num < 0 ? this[num + this.length] : this[num];
		},
		pushStack: function(elems) {
			var ret = jQuery.merge(this.constructor(), elems);
			ret.prevObject = this;
			return ret;
		},
		each: function(callback) {
			return jQuery.each(this, callback);
		},
		map: function(callback) {
			return this.pushStack(jQuery.map(this, function(elem, i) {
				return callback.call(elem, i, elem);
			}));
		},
		slice: function() {
			return this.pushStack(slice.apply(this, arguments));
		},
		first: function() {
			return this.eq(0);
		},
		last: function() {
			return this.eq(-1);
		},
		even: function() {
			return this.pushStack(jQuery.grep(this, function(_elem, i) {
				return (i + 1) % 2;
			}));
		},
		odd: function() {
			return this.pushStack(jQuery.grep(this, function(_elem, i) {
				return i % 2;
			}));
		},
		eq: function(i) {
			var len = this.length, j = +i + (i < 0 ? len : 0);
			return this.pushStack(j >= 0 && j < len ? [this[j]] : []);
		},
		end: function() {
			return this.prevObject || this.constructor();
		}
	};
	jQuery.extend = jQuery.fn.extend = function() {
		var options, name, src, copy, copyIsArray, clone, target = arguments[0] || {}, i = 1, length = arguments.length, deep = false;
		if (typeof target === "boolean") {
			deep = target;
			target = arguments[i] || {};
			i++;
		}
		if (typeof target !== "object" && typeof target !== "function") target = {};
		if (i === length) {
			target = this;
			i--;
		}
		for (; i < length; i++) if ((options = arguments[i]) != null) for (name in options) {
			copy = options[name];
			if (name === "__proto__" || target === copy) continue;
			if (deep && copy && (jQuery.isPlainObject(copy) || (copyIsArray = Array.isArray(copy)))) {
				src = target[name];
				if (copyIsArray && !Array.isArray(src)) clone = [];
				else if (!copyIsArray && !jQuery.isPlainObject(src)) clone = {};
				else clone = src;
				copyIsArray = false;
				target[name] = jQuery.extend(deep, clone, copy);
			} else if (copy !== void 0) target[name] = copy;
		}
		return target;
	};
	jQuery.extend({
		expando: "jQuery" + (version + Math.random()).replace(/\D/g, ""),
		isReady: true,
		error: function(msg) {
			throw new Error(msg);
		},
		noop: function() {},
		isPlainObject: function(obj) {
			var proto, Ctor;
			if (!obj || toString.call(obj) !== "[object Object]") return false;
			proto = getProto(obj);
			if (!proto) return true;
			Ctor = hasOwn.call(proto, "constructor") && proto.constructor;
			return typeof Ctor === "function" && fnToString.call(Ctor) === ObjectFunctionString;
		},
		isEmptyObject: function(obj) {
			var name;
			for (name in obj) return false;
			return true;
		},
		globalEval: function(code, options, doc) {
			DOMEval(code, { nonce: options && options.nonce }, doc);
		},
		each: function(obj, callback) {
			var length, i = 0;
			if (isArrayLike(obj)) {
				length = obj.length;
				for (; i < length; i++) if (callback.call(obj[i], i, obj[i]) === false) break;
			} else for (i in obj) if (callback.call(obj[i], i, obj[i]) === false) break;
			return obj;
		},
		text: function(elem) {
			var node, ret = "", i = 0, nodeType = elem.nodeType;
			if (!nodeType) while (node = elem[i++]) ret += jQuery.text(node);
			if (nodeType === 1 || nodeType === 11) return elem.textContent;
			if (nodeType === 9) return elem.documentElement.textContent;
			if (nodeType === 3 || nodeType === 4) return elem.nodeValue;
			return ret;
		},
		makeArray: function(arr, results) {
			var ret = results || [];
			if (arr != null) {
				if (isArrayLike(Object(arr))) jQuery.merge(ret, typeof arr === "string" ? [arr] : arr);
				else push.call(ret, arr);
			}
			return ret;
		},
		inArray: function(elem, arr, i) {
			return arr == null ? -1 : indexOf.call(arr, elem, i);
		},
		isXMLDoc: function(elem) {
			var namespace = elem && elem.namespaceURI, docElem = elem && (elem.ownerDocument || elem).documentElement;
			return !rhtmlSuffix.test(namespace || docElem && docElem.nodeName || "HTML");
		},
		contains: function(a, b) {
			var bup = b && b.parentNode;
			return a === bup || !!(bup && bup.nodeType === 1 && (a.contains ? a.contains(bup) : a.compareDocumentPosition && a.compareDocumentPosition(bup) & 16));
		},
		merge: function(first, second) {
			var len = +second.length, j = 0, i = first.length;
			for (; j < len; j++) first[i++] = second[j];
			first.length = i;
			return first;
		},
		grep: function(elems, callback, invert) {
			var callbackInverse, matches = [], i = 0, length = elems.length, callbackExpect = !invert;
			for (; i < length; i++) {
				callbackInverse = !callback(elems[i], i);
				if (callbackInverse !== callbackExpect) matches.push(elems[i]);
			}
			return matches;
		},
		map: function(elems, callback, arg) {
			var length, value, i = 0, ret = [];
			if (isArrayLike(elems)) {
				length = elems.length;
				for (; i < length; i++) {
					value = callback(elems[i], i, arg);
					if (value != null) ret.push(value);
				}
			} else for (i in elems) {
				value = callback(elems[i], i, arg);
				if (value != null) ret.push(value);
			}
			return flat(ret);
		},
		guid: 1,
		support
	});
	if (typeof Symbol === "function") jQuery.fn[Symbol.iterator] = arr[Symbol.iterator];
	jQuery.each("Boolean Number String Function Array Date RegExp Object Error Symbol".split(" "), function(_i, name) {
		class2type["[object " + name + "]"] = name.toLowerCase();
	});
	function nodeName(elem, name) {
		return elem.nodeName && elem.nodeName.toLowerCase() === name.toLowerCase();
	}
	var pop = arr.pop;
	var whitespace = "[\\x20\\t\\r\\n\\f]";
	var isIE = document$1.documentMode;
	var rbuggyQSA = isIE && new RegExp(":enabled|:disabled|\\[" + whitespace + "*name" + whitespace + "*=" + whitespace + "*(?:''|\"\")");
	var rtrimCSS = new RegExp("^" + whitespace + "+|((?:^|[^\\\\])(?:\\\\.)*)" + whitespace + "+$", "g");
	var identifier = "(?:\\\\[\\da-fA-F]{1,6}" + whitespace + "?|\\\\[^\\r\\n\\f]|[\\w-]|[^\0-\\x7f])+";
	var rleadingCombinator = new RegExp("^" + whitespace + "*([>+~]|" + whitespace + ")" + whitespace + "*");
	var rdescend = new RegExp(whitespace + "|>");
	var rsibling = /[+~]/;
	var documentElement$1 = document$1.documentElement;
	var matches = documentElement$1.matches || documentElement$1.msMatchesSelector;
	/**
	* Create key-value caches of limited size
	* @returns {function(string, object)} Returns the Object data after storing it on itself with
	*	property name the (space-suffixed) string and (if the cache is larger than Expr.cacheLength)
	*	deleting the oldest entry
	*/
	function createCache() {
		var keys = [];
		function cache(key, value) {
			if (keys.push(key + " ") > jQuery.expr.cacheLength) delete cache[keys.shift()];
			return cache[key + " "] = value;
		}
		return cache;
	}
	/**
	* Checks a node for validity as a jQuery selector context
	* @param {Element|Object=} context
	* @returns {Element|Object|Boolean} The input node if acceptable, otherwise a falsy value
	*/
	function testContext(context) {
		return context && typeof context.getElementsByTagName !== "undefined" && context;
	}
	var attributes = "\\[" + whitespace + "*(" + identifier + ")(?:" + whitespace + "*([*^$|!~]?=)" + whitespace + "*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|(" + identifier + "))|)" + whitespace + "*\\]";
	var pseudos = ":(" + identifier + ")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|" + attributes + ")*)|.*)\\)|)";
	var filterMatchExpr = {
		ID: new RegExp("^#(" + identifier + ")"),
		CLASS: new RegExp("^\\.(" + identifier + ")"),
		TAG: new RegExp("^(" + identifier + "|[*])"),
		ATTR: new RegExp("^" + attributes),
		PSEUDO: new RegExp("^" + pseudos),
		CHILD: new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" + whitespace + "*(even|odd|(([+-]|)(\\d*)n|)" + whitespace + "*(?:([+-]|)" + whitespace + "*(\\d+)|))" + whitespace + "*\\)|)", "i")
	};
	var rpseudo = new RegExp(pseudos);
	var runescape = new RegExp("\\\\[\\da-fA-F]{1,6}" + whitespace + "?|\\\\([^\\r\\n\\f])", "g"), funescape = function(escape, nonHex) {
		var high = "0x" + escape.slice(1) - 65536;
		if (nonHex) return nonHex;
		return high < 0 ? String.fromCharCode(high + 65536) : String.fromCharCode(high >> 10 | 55296, high & 1023 | 56320);
	};
	function unescapeSelector(sel) {
		return sel.replace(runescape, funescape);
	}
	function selectorError(msg) {
		jQuery.error("Syntax error, unrecognized expression: " + msg);
	}
	var rcomma = new RegExp("^" + whitespace + "*," + whitespace + "*");
	var tokenCache = createCache();
	function tokenize(selector, parseOnly) {
		var matched, match, tokens, type, soFar, groups, preFilters, cached = tokenCache[selector + " "];
		if (cached) return parseOnly ? 0 : cached.slice(0);
		soFar = selector;
		groups = [];
		preFilters = jQuery.expr.preFilter;
		while (soFar) {
			if (!matched || (match = rcomma.exec(soFar))) {
				if (match) soFar = soFar.slice(match[0].length) || soFar;
				groups.push(tokens = []);
			}
			matched = false;
			if (match = rleadingCombinator.exec(soFar)) {
				matched = match.shift();
				tokens.push({
					value: matched,
					type: match[0].replace(rtrimCSS, " ")
				});
				soFar = soFar.slice(matched.length);
			}
			for (type in filterMatchExpr) if ((match = jQuery.expr.match[type].exec(soFar)) && (!preFilters[type] || (match = preFilters[type](match)))) {
				matched = match.shift();
				tokens.push({
					value: matched,
					type,
					matches: match
				});
				soFar = soFar.slice(matched.length);
			}
			if (!matched) break;
		}
		if (parseOnly) return soFar.length;
		return soFar ? selectorError(selector) : tokenCache(selector, groups).slice(0);
	}
	var preFilter = {
		ATTR: function(match) {
			match[1] = unescapeSelector(match[1]);
			match[3] = unescapeSelector(match[3] || match[4] || match[5] || "");
			if (match[2] === "~=") match[3] = " " + match[3] + " ";
			return match.slice(0, 4);
		},
		CHILD: function(match) {
			match[1] = match[1].toLowerCase();
			if (match[1].slice(0, 3) === "nth") {
				if (!match[3]) selectorError(match[0]);
				match[4] = +(match[4] ? match[5] + (match[6] || 1) : 2 * (match[3] === "even" || match[3] === "odd"));
				match[5] = +(match[7] + match[8] || match[3] === "odd");
			} else if (match[3]) selectorError(match[0]);
			return match;
		},
		PSEUDO: function(match) {
			var excess, unquoted = !match[6] && match[2];
			if (filterMatchExpr.CHILD.test(match[0])) return null;
			if (match[3]) match[2] = match[4] || match[5] || "";
			else if (unquoted && rpseudo.test(unquoted) && (excess = tokenize(unquoted, true)) && (excess = unquoted.indexOf(")", unquoted.length - excess) - unquoted.length)) {
				match[0] = match[0].slice(0, excess);
				match[2] = unquoted.slice(0, excess);
			}
			return match.slice(0, 3);
		}
	};
	function toSelector(tokens) {
		var i = 0, len = tokens.length, selector = "";
		for (; i < len; i++) selector += tokens[i].value;
		return selector;
	}
	function access(elems, fn, key, value, chainable, emptyGet, raw) {
		var i = 0, len = elems.length, bulk = key == null;
		if (toType(key) === "object") {
			chainable = true;
			for (i in key) access(elems, fn, i, key[i], true, emptyGet, raw);
		} else if (value !== void 0) {
			chainable = true;
			if (typeof value !== "function") raw = true;
			if (bulk) {
				if (raw) {
					fn.call(elems, value);
					fn = null;
				} else {
					bulk = fn;
					fn = function(elem, _key, value) {
						return bulk.call(jQuery(elem), value);
					};
				}
			}
			if (fn) for (; i < len; i++) fn(elems[i], key, raw ? value : value.call(elems[i], i, fn(elems[i], key)));
		}
		if (chainable) return elems;
		if (bulk) return fn.call(elems);
		return len ? fn(elems[0], key) : emptyGet;
	}
	var rnothtmlwhite = /[^\x20\t\r\n\f]+/g;
	jQuery.fn.extend({
		attr: function(name, value) {
			return access(this, jQuery.attr, name, value, arguments.length > 1);
		},
		removeAttr: function(name) {
			return this.each(function() {
				jQuery.removeAttr(this, name);
			});
		}
	});
	jQuery.extend({
		attr: function(elem, name, value) {
			var ret, hooks, nType = elem.nodeType;
			if (nType === 3 || nType === 8 || nType === 2) return;
			if (typeof elem.getAttribute === "undefined") return jQuery.prop(elem, name, value);
			if (nType !== 1 || !jQuery.isXMLDoc(elem)) hooks = jQuery.attrHooks[name.toLowerCase()];
			if (value !== void 0) {
				if (value === null || value === false && name.toLowerCase().indexOf("aria-") !== 0) {
					jQuery.removeAttr(elem, name);
					return;
				}
				if (hooks && "set" in hooks && (ret = hooks.set(elem, value, name)) !== void 0) return ret;
				elem.setAttribute(name, value);
				return value;
			}
			if (hooks && "get" in hooks && (ret = hooks.get(elem, name)) !== null) return ret;
			ret = elem.getAttribute(name);
			return ret == null ? void 0 : ret;
		},
		attrHooks: {},
		removeAttr: function(elem, value) {
			var name, i = 0, attrNames = value && value.match(rnothtmlwhite);
			if (attrNames && elem.nodeType === 1) while (name = attrNames[i++]) elem.removeAttribute(name);
		}
	});
	if (isIE) jQuery.attrHooks.type = { set: function(elem, value) {
		if (value === "radio" && nodeName(elem, "input")) {
			var val = elem.value;
			elem.setAttribute("type", value);
			if (val) elem.value = val;
			return value;
		}
	} };
	var rcssescape = /([\0-\x1f\x7f]|^-?\d)|^-$|[^\x80-\uFFFF\w-]/g;
	function fcssescape(ch, asCodePoint) {
		if (asCodePoint) {
			if (ch === "\0") return "�";
			return ch.slice(0, -1) + "\\" + ch.charCodeAt(ch.length - 1).toString(16) + " ";
		}
		return "\\" + ch;
	}
	jQuery.escapeSelector = function(sel) {
		return (sel + "").replace(rcssescape, fcssescape);
	};
	var sort = arr.sort;
	var splice = arr.splice;
	var hasDuplicate;
	function sortOrder(a, b) {
		if (a === b) {
			hasDuplicate = true;
			return 0;
		}
		var compare = !a.compareDocumentPosition - !b.compareDocumentPosition;
		if (compare) return compare;
		compare = (a.ownerDocument || a) == (b.ownerDocument || b) ? a.compareDocumentPosition(b) : 1;
		if (compare & 1) {
			if (a == document$1 || a.ownerDocument == document$1 && jQuery.contains(document$1, a)) return -1;
			if (b == document$1 || b.ownerDocument == document$1 && jQuery.contains(document$1, b)) return 1;
			return 0;
		}
		return compare & 4 ? -1 : 1;
	}
	/**
	* Document sorting and removing duplicates
	* @param {ArrayLike} results
	*/
	jQuery.uniqueSort = function(results) {
		var elem, duplicates = [], j = 0, i = 0;
		hasDuplicate = false;
		sort.call(results, sortOrder);
		if (hasDuplicate) {
			while (elem = results[i++]) if (elem === results[i]) j = duplicates.push(i);
			while (j--) splice.call(results, duplicates[j], 1);
		}
		return results;
	};
	jQuery.fn.uniqueSort = function() {
		return this.pushStack(jQuery.uniqueSort(slice.apply(this)));
	};
	var i, outermostContext, document, documentElement, documentIsHTML, dirruns = 0, done = 0, classCache = createCache(), compilerCache = createCache(), nonnativeSelectorCache = createCache(), rwhitespace = new RegExp(whitespace + "+", "g"), ridentifier = new RegExp("^" + identifier + "$"), matchExpr = jQuery.extend({ needsContext: new RegExp("^" + whitespace + "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + whitespace + "*((?:-\\d)?\\d*)" + whitespace + "*\\)|)(?=[^-]|$)", "i") }, filterMatchExpr), rinputs = /^(?:input|select|textarea|button)$/i, rheader = /^h\d$/i, rquickExpr$1 = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/, unloadHandler = function() {
		setDocument();
	}, inDisabledFieldset = addCombinator(function(elem) {
		return elem.disabled === true && nodeName(elem, "fieldset");
	}, {
		dir: "parentNode",
		next: "legend"
	});
	function find(selector, context, results, seed) {
		var m, i, elem, nid, match, groups, newSelector, newContext = context && context.ownerDocument, nodeType = context ? context.nodeType : 9;
		results = results || [];
		if (typeof selector !== "string" || !selector || nodeType !== 1 && nodeType !== 9 && nodeType !== 11) return results;
		if (!seed) {
			setDocument(context);
			context = context || document;
			if (documentIsHTML) {
				if (nodeType !== 11 && (match = rquickExpr$1.exec(selector))) {
					if (m = match[1]) {
						if (nodeType === 9) {
							if (elem = context.getElementById(m)) push.call(results, elem);
							return results;
						} else if (newContext && (elem = newContext.getElementById(m)) && jQuery.contains(context, elem)) {
							push.call(results, elem);
							return results;
						}
					} else if (match[2]) {
						push.apply(results, context.getElementsByTagName(selector));
						return results;
					} else if ((m = match[3]) && context.getElementsByClassName) {
						push.apply(results, context.getElementsByClassName(m));
						return results;
					}
				}
				if (!nonnativeSelectorCache[selector + " "] && (!rbuggyQSA || !rbuggyQSA.test(selector))) {
					newSelector = selector;
					newContext = context;
					if (nodeType === 1 && (rdescend.test(selector) || rleadingCombinator.test(selector))) {
						newContext = rsibling.test(selector) && testContext(context.parentNode) || context;
						if (newContext != context || isIE) {
							if (nid = context.getAttribute("id")) nid = jQuery.escapeSelector(nid);
							else context.setAttribute("id", nid = jQuery.expando);
						}
						groups = tokenize(selector);
						i = groups.length;
						while (i--) groups[i] = (nid ? "#" + nid : ":scope") + " " + toSelector(groups[i]);
						newSelector = groups.join(",");
					}
					try {
						push.apply(results, newContext.querySelectorAll(newSelector));
						return results;
					} catch (qsaError) {
						nonnativeSelectorCache(selector, true);
					} finally {
						if (nid === jQuery.expando) context.removeAttribute("id");
					}
				}
			}
		}
		return select(selector.replace(rtrimCSS, "$1"), context, results, seed);
	}
	/**
	* Mark a function for special use by jQuery selector module
	* @param {Function} fn The function to mark
	*/
	function markFunction(fn) {
		fn[jQuery.expando] = true;
		return fn;
	}
	/**
	* Returns a function to use in pseudos for input types
	* @param {String} type
	*/
	function createInputPseudo(type) {
		return function(elem) {
			return nodeName(elem, "input") && elem.type === type;
		};
	}
	/**
	* Returns a function to use in pseudos for buttons
	* @param {String} type
	*/
	function createButtonPseudo(type) {
		return function(elem) {
			return (nodeName(elem, "input") || nodeName(elem, "button")) && elem.type === type;
		};
	}
	/**
	* Returns a function to use in pseudos for :enabled/:disabled
	* @param {Boolean} disabled true for :disabled; false for :enabled
	*/
	function createDisabledPseudo(disabled) {
		return function(elem) {
			if ("form" in elem) {
				if (elem.parentNode && elem.disabled === false) {
					if ("label" in elem) {
						if ("label" in elem.parentNode) return elem.parentNode.disabled === disabled;
						else return elem.disabled === disabled;
					}
					return elem.isDisabled === disabled || elem.isDisabled !== !disabled && inDisabledFieldset(elem) === disabled;
				}
				return elem.disabled === disabled;
			} else if ("label" in elem) return elem.disabled === disabled;
			return false;
		};
	}
	/**
	* Returns a function to use in pseudos for positionals
	* @param {Function} fn
	*/
	function createPositionalPseudo(fn) {
		return markFunction(function(argument) {
			argument = +argument;
			return markFunction(function(seed, matches) {
				var j, matchIndexes = fn([], seed.length, argument), i = matchIndexes.length;
				while (i--) if (seed[j = matchIndexes[i]]) seed[j] = !(matches[j] = seed[j]);
			});
		});
	}
	/**
	* Sets document-related variables once based on the current document
	* @param {Element|Object} [node] An element or document object to use to set the document
	*/
	function setDocument(node) {
		var subWindow, doc = node ? node.ownerDocument || node : document$1;
		if (doc == document || doc.nodeType !== 9) return;
		document = doc;
		documentElement = document.documentElement;
		documentIsHTML = !jQuery.isXMLDoc(document);
		if (isIE && document$1 != document && (subWindow = document.defaultView) && subWindow.top !== subWindow) subWindow.addEventListener("unload", unloadHandler);
	}
	find.matches = function(expr, elements) {
		return find(expr, null, null, elements);
	};
	find.matchesSelector = function(elem, expr) {
		setDocument(elem);
		if (documentIsHTML && !nonnativeSelectorCache[expr + " "] && (!rbuggyQSA || !rbuggyQSA.test(expr))) try {
			return matches.call(elem, expr);
		} catch (e) {
			nonnativeSelectorCache(expr, true);
		}
		return find(expr, document, null, [elem]).length > 0;
	};
	jQuery.expr = {
		cacheLength: 50,
		createPseudo: markFunction,
		match: matchExpr,
		find: {
			ID: function(id, context) {
				if (typeof context.getElementById !== "undefined" && documentIsHTML) {
					var elem = context.getElementById(id);
					return elem ? [elem] : [];
				}
			},
			TAG: function(tag, context) {
				if (typeof context.getElementsByTagName !== "undefined") return context.getElementsByTagName(tag);
				else return context.querySelectorAll(tag);
			},
			CLASS: function(className, context) {
				if (typeof context.getElementsByClassName !== "undefined" && documentIsHTML) return context.getElementsByClassName(className);
			}
		},
		relative: {
			">": {
				dir: "parentNode",
				first: true
			},
			" ": { dir: "parentNode" },
			"+": {
				dir: "previousSibling",
				first: true
			},
			"~": { dir: "previousSibling" }
		},
		preFilter,
		filter: {
			ID: function(id) {
				var attrId = unescapeSelector(id);
				return function(elem) {
					return elem.getAttribute("id") === attrId;
				};
			},
			TAG: function(nodeNameSelector) {
				var expectedNodeName = unescapeSelector(nodeNameSelector).toLowerCase();
				return nodeNameSelector === "*" ? function() {
					return true;
				} : function(elem) {
					return nodeName(elem, expectedNodeName);
				};
			},
			CLASS: function(className) {
				var pattern = classCache[className + " "];
				return pattern || (pattern = new RegExp("(^|" + whitespace + ")" + className + "(" + whitespace + "|$)")) && classCache(className, function(elem) {
					return pattern.test(typeof elem.className === "string" && elem.className || typeof elem.getAttribute !== "undefined" && elem.getAttribute("class") || "");
				});
			},
			ATTR: function(name, operator, check) {
				return function(elem) {
					var result = jQuery.attr(elem, name);
					if (result == null) return operator === "!=";
					if (!operator) return true;
					result += "";
					if (operator === "=") return result === check;
					if (operator === "!=") return result !== check;
					if (operator === "^=") return check && result.indexOf(check) === 0;
					if (operator === "*=") return check && result.indexOf(check) > -1;
					if (operator === "$=") return check && result.slice(-check.length) === check;
					if (operator === "~=") return (" " + result.replace(rwhitespace, " ") + " ").indexOf(check) > -1;
					if (operator === "|=") return result === check || result.slice(0, check.length + 1) === check + "-";
					return false;
				};
			},
			CHILD: function(type, what, _argument, first, last) {
				var simple = type.slice(0, 3) !== "nth", forward = type.slice(-4) !== "last", ofType = what === "of-type";
				return first === 1 && last === 0 ? function(elem) {
					return !!elem.parentNode;
				} : function(elem, _context, xml) {
					var cache, outerCache, node, nodeIndex, start, dir = simple !== forward ? "nextSibling" : "previousSibling", parent = elem.parentNode, name = ofType && elem.nodeName.toLowerCase(), useCache = !xml && !ofType, diff = false;
					if (parent) {
						if (simple) {
							while (dir) {
								node = elem;
								while (node = node[dir]) if (ofType ? nodeName(node, name) : node.nodeType === 1) return false;
								start = dir = type === "only" && !start && "nextSibling";
							}
							return true;
						}
						start = [forward ? parent.firstChild : parent.lastChild];
						if (forward && useCache) {
							outerCache = parent[jQuery.expando] || (parent[jQuery.expando] = {});
							cache = outerCache[type] || [];
							nodeIndex = cache[0] === dirruns && cache[1];
							diff = nodeIndex && cache[2];
							node = nodeIndex && parent.childNodes[nodeIndex];
							while (node = ++nodeIndex && node && node[dir] || (diff = nodeIndex = 0) || start.pop()) if (node.nodeType === 1 && ++diff && node === elem) {
								outerCache[type] = [
									dirruns,
									nodeIndex,
									diff
								];
								break;
							}
						} else {
							if (useCache) {
								outerCache = elem[jQuery.expando] || (elem[jQuery.expando] = {});
								cache = outerCache[type] || [];
								nodeIndex = cache[0] === dirruns && cache[1];
								diff = nodeIndex;
							}
							if (diff === false) {
								while (node = ++nodeIndex && node && node[dir] || (diff = nodeIndex = 0) || start.pop()) if ((ofType ? nodeName(node, name) : node.nodeType === 1) && ++diff) {
									if (useCache) {
										outerCache = node[jQuery.expando] || (node[jQuery.expando] = {});
										outerCache[type] = [dirruns, diff];
									}
									if (node === elem) break;
								}
							}
						}
						diff -= last;
						return diff === first || diff % first === 0 && diff / first >= 0;
					}
				};
			},
			PSEUDO: function(pseudo, argument) {
				var fn = jQuery.expr.pseudos[pseudo] || jQuery.expr.setFilters[pseudo.toLowerCase()] || selectorError("unsupported pseudo: " + pseudo);
				if (fn[jQuery.expando]) return fn(argument);
				return fn;
			}
		},
		pseudos: {
			not: markFunction(function(selector) {
				var input = [], results = [], matcher = compile(selector.replace(rtrimCSS, "$1"));
				return matcher[jQuery.expando] ? markFunction(function(seed, matches, _context, xml) {
					var elem, unmatched = matcher(seed, null, xml, []), i = seed.length;
					while (i--) if (elem = unmatched[i]) seed[i] = !(matches[i] = elem);
				}) : function(elem, _context, xml) {
					input[0] = elem;
					matcher(input, null, xml, results);
					input[0] = null;
					return !results.pop();
				};
			}),
			has: markFunction(function(selector) {
				return function(elem) {
					return find(selector, elem).length > 0;
				};
			}),
			contains: markFunction(function(text) {
				text = unescapeSelector(text);
				return function(elem) {
					return (elem.textContent || jQuery.text(elem)).indexOf(text) > -1;
				};
			}),
			lang: markFunction(function(lang) {
				if (!ridentifier.test(lang || "")) selectorError("unsupported lang: " + lang);
				lang = unescapeSelector(lang).toLowerCase();
				return function(elem) {
					var elemLang;
					do
						if (elemLang = documentIsHTML ? elem.lang : elem.getAttribute("xml:lang") || elem.getAttribute("lang")) {
							elemLang = elemLang.toLowerCase();
							return elemLang === lang || elemLang.indexOf(lang + "-") === 0;
						}
					while ((elem = elem.parentNode) && elem.nodeType === 1);
					return false;
				};
			}),
			target: function(elem) {
				var hash = window.location && window.location.hash;
				return hash && hash.slice(1) === elem.id;
			},
			root: function(elem) {
				return elem === documentElement;
			},
			focus: function(elem) {
				return elem === document.activeElement && document.hasFocus() && !!(elem.type || elem.href || ~elem.tabIndex);
			},
			enabled: createDisabledPseudo(false),
			disabled: createDisabledPseudo(true),
			checked: function(elem) {
				return nodeName(elem, "input") && !!elem.checked || nodeName(elem, "option") && !!elem.selected;
			},
			selected: function(elem) {
				if (isIE && elem.parentNode) elem.parentNode.selectedIndex;
				return elem.selected === true;
			},
			empty: function(elem) {
				for (elem = elem.firstChild; elem; elem = elem.nextSibling) if (elem.nodeType < 6) return false;
				return true;
			},
			parent: function(elem) {
				return !jQuery.expr.pseudos.empty(elem);
			},
			header: function(elem) {
				return rheader.test(elem.nodeName);
			},
			input: function(elem) {
				return rinputs.test(elem.nodeName);
			},
			button: function(elem) {
				return nodeName(elem, "input") && elem.type === "button" || nodeName(elem, "button");
			},
			text: function(elem) {
				return nodeName(elem, "input") && elem.type === "text";
			},
			first: createPositionalPseudo(function() {
				return [0];
			}),
			last: createPositionalPseudo(function(_matchIndexes, length) {
				return [length - 1];
			}),
			eq: createPositionalPseudo(function(_matchIndexes, length, argument) {
				return [argument < 0 ? argument + length : argument];
			}),
			even: createPositionalPseudo(function(matchIndexes, length) {
				var i = 0;
				for (; i < length; i += 2) matchIndexes.push(i);
				return matchIndexes;
			}),
			odd: createPositionalPseudo(function(matchIndexes, length) {
				var i = 1;
				for (; i < length; i += 2) matchIndexes.push(i);
				return matchIndexes;
			}),
			lt: createPositionalPseudo(function(matchIndexes, length, argument) {
				var i;
				if (argument < 0) i = argument + length;
				else if (argument > length) i = length;
				else i = argument;
				for (; --i >= 0;) matchIndexes.push(i);
				return matchIndexes;
			}),
			gt: createPositionalPseudo(function(matchIndexes, length, argument) {
				var i = argument < 0 ? argument + length : argument;
				for (; ++i < length;) matchIndexes.push(i);
				return matchIndexes;
			})
		}
	};
	jQuery.expr.pseudos.nth = jQuery.expr.pseudos.eq;
	for (i in {
		radio: true,
		checkbox: true,
		file: true,
		password: true,
		image: true
	}) jQuery.expr.pseudos[i] = createInputPseudo(i);
	for (i in {
		submit: true,
		reset: true
	}) jQuery.expr.pseudos[i] = createButtonPseudo(i);
	function setFilters() {}
	setFilters.prototype = jQuery.expr.pseudos;
	jQuery.expr.setFilters = new setFilters();
	function addCombinator(matcher, combinator, base) {
		var dir = combinator.dir, skip = combinator.next, key = skip || dir, checkNonElements = base && key === "parentNode", doneName = done++;
		return combinator.first ? function(elem, context, xml) {
			while (elem = elem[dir]) if (elem.nodeType === 1 || checkNonElements) return matcher(elem, context, xml);
			return false;
		} : function(elem, context, xml) {
			var oldCache, outerCache, newCache = [dirruns, doneName];
			if (xml) {
				while (elem = elem[dir]) if (elem.nodeType === 1 || checkNonElements) {
					if (matcher(elem, context, xml)) return true;
				}
			} else while (elem = elem[dir]) if (elem.nodeType === 1 || checkNonElements) {
				outerCache = elem[jQuery.expando] || (elem[jQuery.expando] = {});
				if (skip && nodeName(elem, skip)) elem = elem[dir] || elem;
				else if ((oldCache = outerCache[key]) && oldCache[0] === dirruns && oldCache[1] === doneName) return newCache[2] = oldCache[2];
				else {
					outerCache[key] = newCache;
					if (newCache[2] = matcher(elem, context, xml)) return true;
				}
			}
			return false;
		};
	}
	function elementMatcher(matchers) {
		return matchers.length > 1 ? function(elem, context, xml) {
			var i = matchers.length;
			while (i--) if (!matchers[i](elem, context, xml)) return false;
			return true;
		} : matchers[0];
	}
	function multipleContexts(selector, contexts, results) {
		var i = 0, len = contexts.length;
		for (; i < len; i++) find(selector, contexts[i], results);
		return results;
	}
	function condense(unmatched, map, filter, context, xml) {
		var elem, newUnmatched = [], i = 0, len = unmatched.length, mapped = map != null;
		for (; i < len; i++) if (elem = unmatched[i]) {
			if (!filter || filter(elem, context, xml)) {
				newUnmatched.push(elem);
				if (mapped) map.push(i);
			}
		}
		return newUnmatched;
	}
	function setMatcher(preFilter, selector, matcher, postFilter, postFinder, postSelector) {
		if (postFilter && !postFilter[jQuery.expando]) postFilter = setMatcher(postFilter);
		if (postFinder && !postFinder[jQuery.expando]) postFinder = setMatcher(postFinder, postSelector);
		return markFunction(function(seed, results, context, xml) {
			var temp, i, elem, matcherOut, preMap = [], postMap = [], preexisting = results.length, elems = seed || multipleContexts(selector || "*", context.nodeType ? [context] : context, []), matcherIn = preFilter && (seed || !selector) ? condense(elems, preMap, preFilter, context, xml) : elems;
			if (matcher) {
				matcherOut = postFinder || (seed ? preFilter : preexisting || postFilter) ? [] : results;
				matcher(matcherIn, matcherOut, context, xml);
			} else matcherOut = matcherIn;
			if (postFilter) {
				temp = condense(matcherOut, postMap);
				postFilter(temp, [], context, xml);
				i = temp.length;
				while (i--) if (elem = temp[i]) matcherOut[postMap[i]] = !(matcherIn[postMap[i]] = elem);
			}
			if (seed) {
				if (postFinder || preFilter) {
					if (postFinder) {
						temp = [];
						i = matcherOut.length;
						while (i--) if (elem = matcherOut[i]) temp.push(matcherIn[i] = elem);
						postFinder(null, matcherOut = [], temp, xml);
					}
					i = matcherOut.length;
					while (i--) if ((elem = matcherOut[i]) && (temp = postFinder ? indexOf.call(seed, elem) : preMap[i]) > -1) seed[temp] = !(results[temp] = elem);
				}
			} else {
				matcherOut = condense(matcherOut === results ? matcherOut.splice(preexisting, matcherOut.length) : matcherOut);
				if (postFinder) postFinder(null, results, matcherOut, xml);
				else push.apply(results, matcherOut);
			}
		});
	}
	function matcherFromTokens(tokens) {
		var checkContext, matcher, j, len = tokens.length, leadingRelative = jQuery.expr.relative[tokens[0].type], implicitRelative = leadingRelative || jQuery.expr.relative[" "], i = leadingRelative ? 1 : 0, matchContext = addCombinator(function(elem) {
			return elem === checkContext;
		}, implicitRelative, true), matchAnyContext = addCombinator(function(elem) {
			return indexOf.call(checkContext, elem) > -1;
		}, implicitRelative, true), matchers = [function(elem, context, xml) {
			var ret = !leadingRelative && (xml || context != outermostContext) || ((checkContext = context).nodeType ? matchContext(elem, context, xml) : matchAnyContext(elem, context, xml));
			checkContext = null;
			return ret;
		}];
		for (; i < len; i++) if (matcher = jQuery.expr.relative[tokens[i].type]) matchers = [addCombinator(elementMatcher(matchers), matcher)];
		else {
			matcher = jQuery.expr.filter[tokens[i].type].apply(null, tokens[i].matches);
			if (matcher[jQuery.expando]) {
				j = ++i;
				for (; j < len; j++) if (jQuery.expr.relative[tokens[j].type]) break;
				return setMatcher(i > 1 && elementMatcher(matchers), i > 1 && toSelector(tokens.slice(0, i - 1).concat({ value: tokens[i - 2].type === " " ? "*" : "" })).replace(rtrimCSS, "$1"), matcher, i < j && matcherFromTokens(tokens.slice(i, j)), j < len && matcherFromTokens(tokens = tokens.slice(j)), j < len && toSelector(tokens));
			}
			matchers.push(matcher);
		}
		return elementMatcher(matchers);
	}
	function matcherFromGroupMatchers(elementMatchers, setMatchers) {
		var bySet = setMatchers.length > 0, byElement = elementMatchers.length > 0, superMatcher = function(seed, context, xml, results, outermost) {
			var elem, j, matcher, matchedCount = 0, i = "0", unmatched = seed && [], setMatched = [], contextBackup = outermostContext, elems = seed || byElement && jQuery.expr.find.TAG("*", outermost), dirrunsUnique = dirruns += contextBackup == null ? 1 : Math.random() || .1;
			if (outermost) outermostContext = context == document || context || outermost;
			for (; (elem = elems[i]) != null; i++) {
				if (byElement && elem) {
					j = 0;
					if (!context && elem.ownerDocument != document) {
						setDocument(elem);
						xml = !documentIsHTML;
					}
					while (matcher = elementMatchers[j++]) if (matcher(elem, context || document, xml)) {
						push.call(results, elem);
						break;
					}
					if (outermost) dirruns = dirrunsUnique;
				}
				if (bySet) {
					if (elem = !matcher && elem) matchedCount--;
					if (seed) unmatched.push(elem);
				}
			}
			matchedCount += i;
			if (bySet && i !== matchedCount) {
				j = 0;
				while (matcher = setMatchers[j++]) matcher(unmatched, setMatched, context, xml);
				if (seed) {
					if (matchedCount > 0) {
						while (i--) if (!(unmatched[i] || setMatched[i])) setMatched[i] = pop.call(results);
					}
					setMatched = condense(setMatched);
				}
				push.apply(results, setMatched);
				if (outermost && !seed && setMatched.length > 0 && matchedCount + setMatchers.length > 1) jQuery.uniqueSort(results);
			}
			if (outermost) {
				dirruns = dirrunsUnique;
				outermostContext = contextBackup;
			}
			return unmatched;
		};
		return bySet ? markFunction(superMatcher) : superMatcher;
	}
	function compile(selector, match) {
		var i, setMatchers = [], elementMatchers = [], cached = compilerCache[selector + " "];
		if (!cached) {
			if (!match) match = tokenize(selector);
			i = match.length;
			while (i--) {
				cached = matcherFromTokens(match[i]);
				if (cached[jQuery.expando]) setMatchers.push(cached);
				else elementMatchers.push(cached);
			}
			cached = compilerCache(selector, matcherFromGroupMatchers(elementMatchers, setMatchers));
			cached.selector = selector;
		}
		return cached;
	}
	/**
	* A low-level selection function that works with jQuery's compiled
	*  selector functions
	* @param {String|Function} selector A selector or a pre-compiled
	*  selector function built with jQuery selector compile
	* @param {Element} context
	* @param {Array} [results]
	* @param {Array} [seed] A set of elements to match against
	*/
	function select(selector, context, results, seed) {
		var i, tokens, token, type, find, compiled = typeof selector === "function" && selector, match = !seed && tokenize(selector = compiled.selector || selector);
		results = results || [];
		if (match.length === 1) {
			tokens = match[0] = match[0].slice(0);
			if (tokens.length > 2 && (token = tokens[0]).type === "ID" && context.nodeType === 9 && documentIsHTML && jQuery.expr.relative[tokens[1].type]) {
				context = (jQuery.expr.find.ID(unescapeSelector(token.matches[0]), context) || [])[0];
				if (!context) return results;
				else if (compiled) context = context.parentNode;
				selector = selector.slice(tokens.shift().value.length);
			}
			i = matchExpr.needsContext.test(selector) ? 0 : tokens.length;
			while (i--) {
				token = tokens[i];
				if (jQuery.expr.relative[type = token.type]) break;
				if (find = jQuery.expr.find[type]) {
					if (seed = find(unescapeSelector(token.matches[0]), rsibling.test(tokens[0].type) && testContext(context.parentNode) || context)) {
						tokens.splice(i, 1);
						selector = seed.length && toSelector(tokens);
						if (!selector) {
							push.apply(results, seed);
							return results;
						}
						break;
					}
				}
			}
		}
		(compiled || compile(selector, match))(seed, context, !documentIsHTML, results, !context || rsibling.test(selector) && testContext(context.parentNode) || context);
		return results;
	}
	setDocument();
	jQuery.find = find;
	find.compile = compile;
	find.select = select;
	find.setDocument = setDocument;
	find.tokenize = tokenize;
	function dir(elem, dir, until) {
		var matched = [], truncate = until !== void 0;
		while ((elem = elem[dir]) && elem.nodeType !== 9) if (elem.nodeType === 1) {
			if (truncate && jQuery(elem).is(until)) break;
			matched.push(elem);
		}
		return matched;
	}
	function siblings(n, elem) {
		var matched = [];
		for (; n; n = n.nextSibling) if (n.nodeType === 1 && n !== elem) matched.push(n);
		return matched;
	}
	var rneedsContext = jQuery.expr.match.needsContext;
	var rsingleTag = /^<([a-z][^\/\0>:\x20\t\r\n\f]*)[\x20\t\r\n\f]*\/?>(?:<\/\1>|)$/i;
	function isObviousHtml(input) {
		return input[0] === "<" && input[input.length - 1] === ">" && input.length >= 3;
	}
	function winnow(elements, qualifier, not) {
		if (typeof qualifier === "function") return jQuery.grep(elements, function(elem, i) {
			return !!qualifier.call(elem, i, elem) !== not;
		});
		if (qualifier.nodeType) return jQuery.grep(elements, function(elem) {
			return elem === qualifier !== not;
		});
		if (typeof qualifier !== "string") return jQuery.grep(elements, function(elem) {
			return indexOf.call(qualifier, elem) > -1 !== not;
		});
		return jQuery.filter(qualifier, elements, not);
	}
	jQuery.filter = function(expr, elems, not) {
		var elem = elems[0];
		if (not) expr = ":not(" + expr + ")";
		if (elems.length === 1 && elem.nodeType === 1) return jQuery.find.matchesSelector(elem, expr) ? [elem] : [];
		return jQuery.find.matches(expr, jQuery.grep(elems, function(elem) {
			return elem.nodeType === 1;
		}));
	};
	jQuery.fn.extend({
		find: function(selector) {
			var i, ret, len = this.length, self = this;
			if (typeof selector !== "string") return this.pushStack(jQuery(selector).filter(function() {
				for (i = 0; i < len; i++) if (jQuery.contains(self[i], this)) return true;
			}));
			ret = this.pushStack([]);
			for (i = 0; i < len; i++) jQuery.find(selector, self[i], ret);
			return len > 1 ? jQuery.uniqueSort(ret) : ret;
		},
		filter: function(selector) {
			return this.pushStack(winnow(this, selector || [], false));
		},
		not: function(selector) {
			return this.pushStack(winnow(this, selector || [], true));
		},
		is: function(selector) {
			return !!winnow(this, typeof selector === "string" && rneedsContext.test(selector) ? jQuery(selector) : selector || [], false).length;
		}
	});
	var rootjQuery, rquickExpr = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]+))$/, init = jQuery.fn.init = function(selector, context) {
		var match, elem;
		if (!selector) return this;
		if (selector.nodeType) {
			this[0] = selector;
			this.length = 1;
			return this;
		} else if (typeof selector === "function") return rootjQuery.ready !== void 0 ? rootjQuery.ready(selector) : selector(jQuery);
		else {
			match = selector + "";
			if (isObviousHtml(match)) match = [
				null,
				selector,
				null
			];
			else if (typeof selector === "string") match = rquickExpr.exec(selector);
			else return jQuery.makeArray(selector, this);
			if (match && (match[1] || !context)) {
				if (match[1]) {
					context = context instanceof jQuery ? context[0] : context;
					jQuery.merge(this, jQuery.parseHTML(match[1], context && context.nodeType ? context.ownerDocument || context : document$1, true));
					if (rsingleTag.test(match[1]) && jQuery.isPlainObject(context)) for (match in context) if (typeof this[match] === "function") this[match](context[match]);
					else this.attr(match, context[match]);
					return this;
				} else {
					elem = document$1.getElementById(match[2]);
					if (elem) {
						this[0] = elem;
						this.length = 1;
					}
					return this;
				}
			} else if (!context || context.jquery) return (context || rootjQuery).find(selector);
			else return this.constructor(context).find(selector);
		}
	};
	init.prototype = jQuery.fn;
	rootjQuery = jQuery(document$1);
	var rparentsprev = /^(?:parents|prev(?:Until|All))/, guaranteedUnique = {
		children: true,
		contents: true,
		next: true,
		prev: true
	};
	jQuery.fn.extend({
		has: function(target) {
			var targets = jQuery(target, this), l = targets.length;
			return this.filter(function() {
				var i = 0;
				for (; i < l; i++) if (jQuery.contains(this, targets[i])) return true;
			});
		},
		closest: function(selectors, context) {
			var cur, i = 0, l = this.length, matched = [], targets = typeof selectors !== "string" && jQuery(selectors);
			if (!rneedsContext.test(selectors)) {
				for (; i < l; i++) for (cur = this[i]; cur && cur !== context; cur = cur.parentNode) if (cur.nodeType < 11 && (targets ? targets.index(cur) > -1 : cur.nodeType === 1 && jQuery.find.matchesSelector(cur, selectors))) {
					matched.push(cur);
					break;
				}
			}
			return this.pushStack(matched.length > 1 ? jQuery.uniqueSort(matched) : matched);
		},
		index: function(elem) {
			if (!elem) return this[0] && this[0].parentNode ? this.first().prevAll().length : -1;
			if (typeof elem === "string") return indexOf.call(jQuery(elem), this[0]);
			return indexOf.call(this, elem.jquery ? elem[0] : elem);
		},
		add: function(selector, context) {
			return this.pushStack(jQuery.uniqueSort(jQuery.merge(this.get(), jQuery(selector, context))));
		},
		addBack: function(selector) {
			return this.add(selector == null ? this.prevObject : this.prevObject.filter(selector));
		}
	});
	function sibling(cur, dir) {
		while ((cur = cur[dir]) && cur.nodeType !== 1);
		return cur;
	}
	jQuery.each({
		parent: function(elem) {
			var parent = elem.parentNode;
			return parent && parent.nodeType !== 11 ? parent : null;
		},
		parents: function(elem) {
			return dir(elem, "parentNode");
		},
		parentsUntil: function(elem, _i, until) {
			return dir(elem, "parentNode", until);
		},
		next: function(elem) {
			return sibling(elem, "nextSibling");
		},
		prev: function(elem) {
			return sibling(elem, "previousSibling");
		},
		nextAll: function(elem) {
			return dir(elem, "nextSibling");
		},
		prevAll: function(elem) {
			return dir(elem, "previousSibling");
		},
		nextUntil: function(elem, _i, until) {
			return dir(elem, "nextSibling", until);
		},
		prevUntil: function(elem, _i, until) {
			return dir(elem, "previousSibling", until);
		},
		siblings: function(elem) {
			return siblings((elem.parentNode || {}).firstChild, elem);
		},
		children: function(elem) {
			return siblings(elem.firstChild);
		},
		contents: function(elem) {
			if (elem.contentDocument != null && getProto(elem.contentDocument)) return elem.contentDocument;
			if (nodeName(elem, "template")) elem = elem.content || elem;
			return jQuery.merge([], elem.childNodes);
		}
	}, function(name, fn) {
		jQuery.fn[name] = function(until, selector) {
			var matched = jQuery.map(this, fn, until);
			if (name.slice(-5) !== "Until") selector = until;
			if (selector && typeof selector === "string") matched = jQuery.filter(selector, matched);
			if (this.length > 1) {
				if (!guaranteedUnique[name]) jQuery.uniqueSort(matched);
				if (rparentsprev.test(name)) matched.reverse();
			}
			return this.pushStack(matched);
		};
	});
	function createOptions(options) {
		var object = {};
		jQuery.each(options.match(rnothtmlwhite) || [], function(_, flag) {
			object[flag] = true;
		});
		return object;
	}
	jQuery.Callbacks = function(options) {
		options = typeof options === "string" ? createOptions(options) : jQuery.extend({}, options);
		var firing, memory, fired, locked, list = [], queue = [], firingIndex = -1, fire = function() {
			locked = locked || options.once;
			fired = firing = true;
			for (; queue.length; firingIndex = -1) {
				memory = queue.shift();
				while (++firingIndex < list.length) if (list[firingIndex].apply(memory[0], memory[1]) === false && options.stopOnFalse) {
					firingIndex = list.length;
					memory = false;
				}
			}
			if (!options.memory) memory = false;
			firing = false;
			if (locked) {
				if (memory) list = [];
				else list = "";
			}
		}, self = {
			add: function() {
				if (list) {
					if (memory && !firing) {
						firingIndex = list.length - 1;
						queue.push(memory);
					}
					(function add(args) {
						jQuery.each(args, function(_, arg) {
							if (typeof arg === "function") {
								if (!options.unique || !self.has(arg)) list.push(arg);
							} else if (arg && arg.length && toType(arg) !== "string") add(arg);
						});
					})(arguments);
					if (memory && !firing) fire();
				}
				return this;
			},
			remove: function() {
				jQuery.each(arguments, function(_, arg) {
					var index;
					while ((index = jQuery.inArray(arg, list, index)) > -1) {
						list.splice(index, 1);
						if (index <= firingIndex) firingIndex--;
					}
				});
				return this;
			},
			has: function(fn) {
				return fn ? jQuery.inArray(fn, list) > -1 : list.length > 0;
			},
			empty: function() {
				if (list) list = [];
				return this;
			},
			disable: function() {
				locked = queue = [];
				list = memory = "";
				return this;
			},
			disabled: function() {
				return !list;
			},
			lock: function() {
				locked = queue = [];
				if (!memory && !firing) list = memory = "";
				return this;
			},
			locked: function() {
				return !!locked;
			},
			fireWith: function(context, args) {
				if (!locked) {
					args = args || [];
					args = [context, args.slice ? args.slice() : args];
					queue.push(args);
					if (!firing) fire();
				}
				return this;
			},
			fire: function() {
				self.fireWith(this, arguments);
				return this;
			},
			fired: function() {
				return !!fired;
			}
		};
		return self;
	};
	function Identity(v) {
		return v;
	}
	function Thrower(ex) {
		throw ex;
	}
	function adoptValue(value, resolve, reject, noValue) {
		var method;
		try {
			if (value && typeof (method = value.promise) === "function") method.call(value).done(resolve).fail(reject);
			else if (value && typeof (method = value.then) === "function") method.call(value, resolve, reject);
			else resolve.apply(void 0, [value].slice(noValue));
		} catch (value) {
			reject(value);
		}
	}
	jQuery.extend({
		Deferred: function(func) {
			var tuples = [
				[
					"notify",
					"progress",
					jQuery.Callbacks("memory"),
					jQuery.Callbacks("memory"),
					2
				],
				[
					"resolve",
					"done",
					jQuery.Callbacks("once memory"),
					jQuery.Callbacks("once memory"),
					0,
					"resolved"
				],
				[
					"reject",
					"fail",
					jQuery.Callbacks("once memory"),
					jQuery.Callbacks("once memory"),
					1,
					"rejected"
				]
			], state = "pending", promise = {
				state: function() {
					return state;
				},
				always: function() {
					deferred.done(arguments).fail(arguments);
					return this;
				},
				catch: function(fn) {
					return promise.then(null, fn);
				},
				pipe: function() {
					var fns = arguments;
					return jQuery.Deferred(function(newDefer) {
						jQuery.each(tuples, function(_i, tuple) {
							var fn = typeof fns[tuple[4]] === "function" && fns[tuple[4]];
							deferred[tuple[1]](function() {
								var returned = fn && fn.apply(this, arguments);
								if (returned && typeof returned.promise === "function") returned.promise().progress(newDefer.notify).done(newDefer.resolve).fail(newDefer.reject);
								else newDefer[tuple[0] + "With"](this, fn ? [returned] : arguments);
							});
						});
						fns = null;
					}).promise();
				},
				then: function(onFulfilled, onRejected, onProgress) {
					var maxDepth = 0;
					function resolve(depth, deferred, handler, special) {
						return function() {
							var that = this, args = arguments, mightThrow = function() {
								var returned, then;
								if (depth < maxDepth) return;
								returned = handler.apply(that, args);
								if (returned === deferred.promise()) throw new TypeError("Thenable self-resolution");
								then = returned && (typeof returned === "object" || typeof returned === "function") && returned.then;
								if (typeof then === "function") {
									if (special) then.call(returned, resolve(maxDepth, deferred, Identity, special), resolve(maxDepth, deferred, Thrower, special));
									else {
										maxDepth++;
										then.call(returned, resolve(maxDepth, deferred, Identity, special), resolve(maxDepth, deferred, Thrower, special), resolve(maxDepth, deferred, Identity, deferred.notifyWith));
									}
								} else {
									if (handler !== Identity) {
										that = void 0;
										args = [returned];
									}
									(special || deferred.resolveWith)(that, args);
								}
							}, process = special ? mightThrow : function() {
								try {
									mightThrow();
								} catch (e) {
									if (jQuery.Deferred.exceptionHook) jQuery.Deferred.exceptionHook(e, process.error);
									if (depth + 1 >= maxDepth) {
										if (handler !== Thrower) {
											that = void 0;
											args = [e];
										}
										deferred.rejectWith(that, args);
									}
								}
							};
							if (depth) process();
							else {
								if (jQuery.Deferred.getErrorHook) process.error = jQuery.Deferred.getErrorHook();
								window.setTimeout(process);
							}
						};
					}
					return jQuery.Deferred(function(newDefer) {
						tuples[0][3].add(resolve(0, newDefer, typeof onProgress === "function" ? onProgress : Identity, newDefer.notifyWith));
						tuples[1][3].add(resolve(0, newDefer, typeof onFulfilled === "function" ? onFulfilled : Identity));
						tuples[2][3].add(resolve(0, newDefer, typeof onRejected === "function" ? onRejected : Thrower));
					}).promise();
				},
				promise: function(obj) {
					return obj != null ? jQuery.extend(obj, promise) : promise;
				}
			}, deferred = {};
			jQuery.each(tuples, function(i, tuple) {
				var list = tuple[2], stateString = tuple[5];
				promise[tuple[1]] = list.add;
				if (stateString) list.add(function() {
					state = stateString;
				}, tuples[3 - i][2].disable, tuples[3 - i][3].disable, tuples[0][2].lock, tuples[0][3].lock);
				list.add(tuple[3].fire);
				deferred[tuple[0]] = function() {
					deferred[tuple[0] + "With"](this === deferred ? void 0 : this, arguments);
					return this;
				};
				deferred[tuple[0] + "With"] = list.fireWith;
			});
			promise.promise(deferred);
			if (func) func.call(deferred, deferred);
			return deferred;
		},
		when: function(singleValue) {
			var remaining = arguments.length, i = remaining, resolveContexts = Array(i), resolveValues = slice.call(arguments), primary = jQuery.Deferred(), updateFunc = function(i) {
				return function(value) {
					resolveContexts[i] = this;
					resolveValues[i] = arguments.length > 1 ? slice.call(arguments) : value;
					if (!--remaining) primary.resolveWith(resolveContexts, resolveValues);
				};
			};
			if (remaining <= 1) {
				adoptValue(singleValue, primary.done(updateFunc(i)).resolve, primary.reject, !remaining);
				if (primary.state() === "pending" || typeof (resolveValues[i] && resolveValues[i].then) === "function") return primary.then();
			}
			while (i--) adoptValue(resolveValues[i], updateFunc(i), primary.reject);
			return primary.promise();
		}
	});
	var rerrorNames = /^(Eval|Internal|Range|Reference|Syntax|Type|URI)Error$/;
	jQuery.Deferred.exceptionHook = function(error, asyncError) {
		if (error && rerrorNames.test(error.name)) window.console.warn("jQuery.Deferred exception", error, asyncError);
	};
	jQuery.readyException = function(error) {
		window.setTimeout(function() {
			throw error;
		});
	};
	var readyList = jQuery.Deferred();
	jQuery.fn.ready = function(fn) {
		readyList.then(fn).catch(function(error) {
			jQuery.readyException(error);
		});
		return this;
	};
	jQuery.extend({
		isReady: false,
		readyWait: 1,
		ready: function(wait) {
			if (wait === true ? --jQuery.readyWait : jQuery.isReady) return;
			jQuery.isReady = true;
			if (wait !== true && --jQuery.readyWait > 0) return;
			readyList.resolveWith(document$1, [jQuery]);
		}
	});
	jQuery.ready.then = readyList.then;
	function completed() {
		document$1.removeEventListener("DOMContentLoaded", completed);
		window.removeEventListener("load", completed);
		jQuery.ready();
	}
	if (document$1.readyState !== "loading") window.setTimeout(jQuery.ready);
	else {
		document$1.addEventListener("DOMContentLoaded", completed);
		window.addEventListener("load", completed);
	}
	var rdashAlpha = /-([a-z])/g;
	function fcamelCase(_all, letter) {
		return letter.toUpperCase();
	}
	function camelCase(string) {
		return string.replace(rdashAlpha, fcamelCase);
	}
	/**
	* Determines whether an object can have data
	*/
	function acceptData(owner) {
		return owner.nodeType === 1 || owner.nodeType === 9 || !+owner.nodeType;
	}
	function Data() {
		this.expando = jQuery.expando + Data.uid++;
	}
	Data.uid = 1;
	Data.prototype = {
		cache: function(owner) {
			var value = owner[this.expando];
			if (!value) {
				value = Object.create(null);
				if (acceptData(owner)) {
					if (owner.nodeType) owner[this.expando] = value;
					else Object.defineProperty(owner, this.expando, {
						value,
						configurable: true
					});
				}
			}
			return value;
		},
		set: function(owner, data, value) {
			var prop, cache = this.cache(owner);
			if (typeof data === "string") cache[camelCase(data)] = value;
			else for (prop in data) cache[camelCase(prop)] = data[prop];
			return value;
		},
		get: function(owner, key) {
			return key === void 0 ? this.cache(owner) : owner[this.expando] && owner[this.expando][camelCase(key)];
		},
		access: function(owner, key, value) {
			if (key === void 0 || key && typeof key === "string" && value === void 0) return this.get(owner, key);
			this.set(owner, key, value);
			return value !== void 0 ? value : key;
		},
		remove: function(owner, key) {
			var i, cache = owner[this.expando];
			if (cache === void 0) return;
			if (key !== void 0) {
				if (Array.isArray(key)) key = key.map(camelCase);
				else {
					key = camelCase(key);
					key = key in cache ? [key] : key.match(rnothtmlwhite) || [];
				}
				i = key.length;
				while (i--) delete cache[key[i]];
			}
			if (key === void 0 || jQuery.isEmptyObject(cache)) {
				if (owner.nodeType) owner[this.expando] = void 0;
				else delete owner[this.expando];
			}
		},
		hasData: function(owner) {
			var cache = owner[this.expando];
			return cache !== void 0 && !jQuery.isEmptyObject(cache);
		}
	};
	var dataPriv = new Data();
	var dataUser = new Data();
	var rbrace = /^(?:\{[\w\W]*\}|\[[\w\W]*\])$/, rmultiDash = /[A-Z]/g;
	function getData(data) {
		if (data === "true") return true;
		if (data === "false") return false;
		if (data === "null") return null;
		if (data === +data + "") return +data;
		if (rbrace.test(data)) return JSON.parse(data);
		return data;
	}
	function dataAttr(elem, key, data) {
		var name;
		if (data === void 0 && elem.nodeType === 1) {
			name = "data-" + key.replace(rmultiDash, "-$&").toLowerCase();
			data = elem.getAttribute(name);
			if (typeof data === "string") {
				try {
					data = getData(data);
				} catch (e) {}
				dataUser.set(elem, key, data);
			} else data = void 0;
		}
		return data;
	}
	jQuery.extend({
		hasData: function(elem) {
			return dataUser.hasData(elem) || dataPriv.hasData(elem);
		},
		data: function(elem, name, data) {
			return dataUser.access(elem, name, data);
		},
		removeData: function(elem, name) {
			dataUser.remove(elem, name);
		},
		_data: function(elem, name, data) {
			return dataPriv.access(elem, name, data);
		},
		_removeData: function(elem, name) {
			dataPriv.remove(elem, name);
		}
	});
	jQuery.fn.extend({
		data: function(key, value) {
			var i, name, data, elem = this[0], attrs = elem && elem.attributes;
			if (key === void 0) {
				if (this.length) {
					data = dataUser.get(elem);
					if (elem.nodeType === 1 && !dataPriv.get(elem, "hasDataAttrs")) {
						i = attrs.length;
						while (i--) if (attrs[i]) {
							name = attrs[i].name;
							if (name.indexOf("data-") === 0) {
								name = camelCase(name.slice(5));
								dataAttr(elem, name, data[name]);
							}
						}
						dataPriv.set(elem, "hasDataAttrs", true);
					}
				}
				return data;
			}
			if (typeof key === "object") return this.each(function() {
				dataUser.set(this, key);
			});
			return access(this, function(value) {
				var data;
				if (elem && value === void 0) {
					data = dataUser.get(elem, key);
					if (data !== void 0) return data;
					data = dataAttr(elem, key);
					if (data !== void 0) return data;
					return;
				}
				this.each(function() {
					dataUser.set(this, key, value);
				});
			}, null, value, arguments.length > 1, null, true);
		},
		removeData: function(key) {
			return this.each(function() {
				dataUser.remove(this, key);
			});
		}
	});
	jQuery.extend({
		queue: function(elem, type, data) {
			var queue;
			if (elem) {
				type = (type || "fx") + "queue";
				queue = dataPriv.get(elem, type);
				if (data) {
					if (!queue || Array.isArray(data)) queue = dataPriv.set(elem, type, jQuery.makeArray(data));
					else queue.push(data);
				}
				return queue || [];
			}
		},
		dequeue: function(elem, type) {
			type = type || "fx";
			var queue = jQuery.queue(elem, type), startLength = queue.length, fn = queue.shift(), hooks = jQuery._queueHooks(elem, type), next = function() {
				jQuery.dequeue(elem, type);
			};
			if (fn === "inprogress") {
				fn = queue.shift();
				startLength--;
			}
			if (fn) {
				if (type === "fx") queue.unshift("inprogress");
				delete hooks.stop;
				fn.call(elem, next, hooks);
			}
			if (!startLength && hooks) hooks.empty.fire();
		},
		_queueHooks: function(elem, type) {
			var key = type + "queueHooks";
			return dataPriv.get(elem, key) || dataPriv.set(elem, key, { empty: jQuery.Callbacks("once memory").add(function() {
				dataPriv.remove(elem, [type + "queue", key]);
			}) });
		}
	});
	jQuery.fn.extend({
		queue: function(type, data) {
			var setter = 2;
			if (typeof type !== "string") {
				data = type;
				type = "fx";
				setter--;
			}
			if (arguments.length < setter) return jQuery.queue(this[0], type);
			return data === void 0 ? this : this.each(function() {
				var queue = jQuery.queue(this, type, data);
				jQuery._queueHooks(this, type);
				if (type === "fx" && queue[0] !== "inprogress") jQuery.dequeue(this, type);
			});
		},
		dequeue: function(type) {
			return this.each(function() {
				jQuery.dequeue(this, type);
			});
		},
		clearQueue: function(type) {
			return this.queue(type || "fx", []);
		},
		promise: function(type, obj) {
			var tmp, count = 1, defer = jQuery.Deferred(), elements = this, i = this.length, resolve = function() {
				if (!--count) defer.resolveWith(elements, [elements]);
			};
			if (typeof type !== "string") {
				obj = type;
				type = void 0;
			}
			type = type || "fx";
			while (i--) {
				tmp = dataPriv.get(elements[i], type + "queueHooks");
				if (tmp && tmp.empty) {
					count++;
					tmp.empty.add(resolve);
				}
			}
			resolve();
			return defer.promise(obj);
		}
	});
	var pnum = /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source;
	var rcssNum = new RegExp("^(?:([+-])=|)(" + pnum + ")([a-z%]*)$", "i");
	var cssExpand = [
		"Top",
		"Right",
		"Bottom",
		"Left"
	];
	function isHiddenWithinTree(elem, el) {
		elem = el || elem;
		return elem.style.display === "none" || elem.style.display === "" && jQuery.css(elem, "display") === "none";
	}
	var ralphaStart = /^[a-z]/, rautoPx = /^(?:Border(?:Top|Right|Bottom|Left)?(?:Width|)|(?:Margin|Padding)?(?:Top|Right|Bottom|Left)?|(?:Min|Max)?(?:Width|Height))$/;
	function isAutoPx(prop) {
		return ralphaStart.test(prop) && rautoPx.test(prop[0].toUpperCase() + prop.slice(1));
	}
	function adjustCSS(elem, prop, valueParts, tween) {
		var adjusted, scale, maxIterations = 20, currentValue = tween ? function() {
			return tween.cur();
		} : function() {
			return jQuery.css(elem, prop, "");
		}, initial = currentValue(), unit = valueParts && valueParts[3] || (isAutoPx(prop) ? "px" : ""), initialInUnit = elem.nodeType && (!isAutoPx(prop) || unit !== "px" && +initial) && rcssNum.exec(jQuery.css(elem, prop));
		if (initialInUnit && initialInUnit[3] !== unit) {
			initial = initial / 2;
			unit = unit || initialInUnit[3];
			initialInUnit = +initial || 1;
			while (maxIterations--) {
				jQuery.style(elem, prop, initialInUnit + unit);
				if ((1 - scale) * (1 - (scale = currentValue() / initial || .5)) <= 0) maxIterations = 0;
				initialInUnit = initialInUnit / scale;
			}
			initialInUnit = initialInUnit * 2;
			jQuery.style(elem, prop, initialInUnit + unit);
			valueParts = valueParts || [];
		}
		if (valueParts) {
			initialInUnit = +initialInUnit || +initial || 0;
			adjusted = valueParts[1] ? initialInUnit + (valueParts[1] + 1) * valueParts[2] : +valueParts[2];
			if (tween) {
				tween.unit = unit;
				tween.start = initialInUnit;
				tween.end = adjusted;
			}
		}
		return adjusted;
	}
	var rmsPrefix = /^-ms-/;
	function cssCamelCase(string) {
		return camelCase(string.replace(rmsPrefix, "ms-"));
	}
	var defaultDisplayMap = {};
	function getDefaultDisplay(elem) {
		var temp, doc = elem.ownerDocument, nodeName = elem.nodeName, display = defaultDisplayMap[nodeName];
		if (display) return display;
		temp = doc.body.appendChild(doc.createElement(nodeName));
		display = jQuery.css(temp, "display");
		temp.parentNode.removeChild(temp);
		if (display === "none") display = "block";
		defaultDisplayMap[nodeName] = display;
		return display;
	}
	function showHide(elements, show) {
		var display, elem, values = [], index = 0, length = elements.length;
		for (; index < length; index++) {
			elem = elements[index];
			if (!elem.style) continue;
			display = elem.style.display;
			if (show) {
				if (display === "none") {
					values[index] = dataPriv.get(elem, "display") || null;
					if (!values[index]) elem.style.display = "";
				}
				if (elem.style.display === "" && isHiddenWithinTree(elem)) values[index] = getDefaultDisplay(elem);
			} else if (display !== "none") {
				values[index] = "none";
				dataPriv.set(elem, "display", display);
			}
		}
		for (index = 0; index < length; index++) if (values[index] != null) elements[index].style.display = values[index];
		return elements;
	}
	jQuery.fn.extend({
		show: function() {
			return showHide(this, true);
		},
		hide: function() {
			return showHide(this);
		},
		toggle: function(state) {
			if (typeof state === "boolean") return state ? this.show() : this.hide();
			return this.each(function() {
				if (isHiddenWithinTree(this)) jQuery(this).show();
				else jQuery(this).hide();
			});
		}
	});
	var isAttached = function(elem) {
		return jQuery.contains(elem.ownerDocument, elem) || elem.getRootNode(composed) === elem.ownerDocument;
	}, composed = { composed: true };
	if (!documentElement$1.getRootNode) isAttached = function(elem) {
		return jQuery.contains(elem.ownerDocument, elem);
	};
	var rtagName = /<([a-z][^\/\0>\x20\t\r\n\f]*)/i;
	var wrapMap = {
		thead: ["table"],
		col: ["colgroup", "table"],
		tr: ["tbody", "table"],
		td: [
			"tr",
			"tbody",
			"table"
		]
	};
	wrapMap.tbody = wrapMap.tfoot = wrapMap.colgroup = wrapMap.caption = wrapMap.thead;
	wrapMap.th = wrapMap.td;
	function getAll(context, tag) {
		var ret;
		if (typeof context.getElementsByTagName !== "undefined") ret = arr.slice.call(context.getElementsByTagName(tag || "*"));
		else if (typeof context.querySelectorAll !== "undefined") ret = context.querySelectorAll(tag || "*");
		else ret = [];
		if (tag === void 0 || tag && nodeName(context, tag)) return jQuery.merge([context], ret);
		return ret;
	}
	var rscriptType = /^$|^module$|\/(?:java|ecma)script/i;
	function setGlobalEval(elems, refElements) {
		var i = 0, l = elems.length;
		for (; i < l; i++) dataPriv.set(elems[i], "globalEval", !refElements || dataPriv.get(refElements[i], "globalEval"));
	}
	var rhtml = /<|&#?\w+;/;
	function buildFragment(elems, context, scripts, selection, ignored) {
		var elem, tmp, tag, wrap, attached, j, fragment = context.createDocumentFragment(), nodes = [], i = 0, l = elems.length;
		for (; i < l; i++) {
			elem = elems[i];
			if (elem || elem === 0) {
				if (toType(elem) === "object" && (elem.nodeType || isArrayLike(elem))) jQuery.merge(nodes, elem.nodeType ? [elem] : elem);
				else if (!rhtml.test(elem)) nodes.push(context.createTextNode(elem));
				else {
					tmp = tmp || fragment.appendChild(context.createElement("div"));
					tag = (rtagName.exec(elem) || ["", ""])[1].toLowerCase();
					wrap = wrapMap[tag] || arr;
					j = wrap.length;
					while (--j > -1) tmp = tmp.appendChild(context.createElement(wrap[j]));
					tmp.innerHTML = jQuery.htmlPrefilter(elem);
					jQuery.merge(nodes, tmp.childNodes);
					tmp = fragment.firstChild;
					tmp.textContent = "";
				}
			}
		}
		fragment.textContent = "";
		i = 0;
		while (elem = nodes[i++]) {
			if (selection && jQuery.inArray(elem, selection) > -1) {
				if (ignored) ignored.push(elem);
				continue;
			}
			attached = isAttached(elem);
			tmp = getAll(fragment.appendChild(elem), "script");
			if (attached) setGlobalEval(tmp);
			if (scripts) {
				j = 0;
				while (elem = tmp[j++]) if (rscriptType.test(elem.type || "")) scripts.push(elem);
			}
		}
		return fragment;
	}
	function disableScript(elem) {
		elem.type = (elem.getAttribute("type") !== null) + "/" + elem.type;
		return elem;
	}
	function restoreScript(elem) {
		if ((elem.type || "").slice(0, 5) === "true/") elem.type = elem.type.slice(5);
		else elem.removeAttribute("type");
		return elem;
	}
	function domManip(collection, args, callback, ignored) {
		args = flat(args);
		var fragment, first, scripts, hasScripts, node, doc, i = 0, l = collection.length, iNoClone = l - 1, value = args[0];
		if (typeof value === "function") return collection.each(function(index) {
			var self = collection.eq(index);
			args[0] = value.call(this, index, self.html());
			domManip(self, args, callback, ignored);
		});
		if (l) {
			fragment = buildFragment(args, collection[0].ownerDocument, false, collection, ignored);
			first = fragment.firstChild;
			if (fragment.childNodes.length === 1) fragment = first;
			if (first || ignored) {
				scripts = jQuery.map(getAll(fragment, "script"), disableScript);
				hasScripts = scripts.length;
				for (; i < l; i++) {
					node = fragment;
					if (i !== iNoClone) {
						node = jQuery.clone(node, true, true);
						if (hasScripts) jQuery.merge(scripts, getAll(node, "script"));
					}
					callback.call(collection[i], node, i);
				}
				if (hasScripts) {
					doc = scripts[scripts.length - 1].ownerDocument;
					jQuery.map(scripts, restoreScript);
					for (i = 0; i < hasScripts; i++) {
						node = scripts[i];
						if (rscriptType.test(node.type || "") && !dataPriv.get(node, "globalEval") && jQuery.contains(doc, node)) {
							if (node.src && (node.type || "").toLowerCase() !== "module") {
								if (jQuery._evalUrl && !node.noModule) jQuery._evalUrl(node.src, {
									nonce: node.nonce,
									crossOrigin: node.crossOrigin
								}, doc);
							} else DOMEval(node.textContent, node, doc);
						}
					}
				}
			}
		}
		return collection;
	}
	var rcheckableType = /^(?:checkbox|radio)$/i;
	var rtypenamespace = /^([^.]*)(?:\.(.+)|)/;
	function returnTrue() {
		return true;
	}
	function returnFalse() {
		return false;
	}
	function on(elem, types, selector, data, fn, one) {
		var origFn, type;
		if (typeof types === "object") {
			if (typeof selector !== "string") {
				data = data || selector;
				selector = void 0;
			}
			for (type in types) on(elem, type, selector, data, types[type], one);
			return elem;
		}
		if (data == null && fn == null) {
			fn = selector;
			data = selector = void 0;
		} else if (fn == null) {
			if (typeof selector === "string") {
				fn = data;
				data = void 0;
			} else {
				fn = data;
				data = selector;
				selector = void 0;
			}
		}
		if (fn === false) fn = returnFalse;
		else if (!fn) return elem;
		if (one === 1) {
			origFn = fn;
			fn = function(event) {
				jQuery().off(event);
				return origFn.apply(this, arguments);
			};
			fn.guid = origFn.guid || (origFn.guid = jQuery.guid++);
		}
		return elem.each(function() {
			jQuery.event.add(this, types, fn, data, selector);
		});
	}
	jQuery.event = {
		add: function(elem, types, handler, data, selector) {
			var handleObjIn, eventHandle, tmp, events, t, handleObj, special, handlers, type, namespaces, origType, elemData = dataPriv.get(elem);
			if (!acceptData(elem)) return;
			if (handler.handler) {
				handleObjIn = handler;
				handler = handleObjIn.handler;
				selector = handleObjIn.selector;
			}
			if (selector) jQuery.find.matchesSelector(documentElement$1, selector);
			if (!handler.guid) handler.guid = jQuery.guid++;
			if (!(events = elemData.events)) events = elemData.events = Object.create(null);
			if (!(eventHandle = elemData.handle)) eventHandle = elemData.handle = function(e) {
				return typeof jQuery !== "undefined" && jQuery.event.triggered !== e.type ? jQuery.event.dispatch.apply(elem, arguments) : void 0;
			};
			types = (types || "").match(rnothtmlwhite) || [""];
			t = types.length;
			while (t--) {
				tmp = rtypenamespace.exec(types[t]) || [];
				type = origType = tmp[1];
				namespaces = (tmp[2] || "").split(".").sort();
				if (!type) continue;
				special = jQuery.event.special[type] || {};
				type = (selector ? special.delegateType : special.bindType) || type;
				special = jQuery.event.special[type] || {};
				handleObj = jQuery.extend({
					type,
					origType,
					data,
					handler,
					guid: handler.guid,
					selector,
					needsContext: selector && jQuery.expr.match.needsContext.test(selector),
					namespace: namespaces.join(".")
				}, handleObjIn);
				if (!(handlers = events[type])) {
					handlers = events[type] = [];
					handlers.delegateCount = 0;
					if (!special.setup || special.setup.call(elem, data, namespaces, eventHandle) === false) {
						if (elem.addEventListener) elem.addEventListener(type, eventHandle);
					}
				}
				if (special.add) {
					special.add.call(elem, handleObj);
					if (!handleObj.handler.guid) handleObj.handler.guid = handler.guid;
				}
				if (selector) handlers.splice(handlers.delegateCount++, 0, handleObj);
				else handlers.push(handleObj);
			}
		},
		remove: function(elem, types, handler, selector, mappedTypes) {
			var j, origCount, tmp, events, t, handleObj, special, handlers, type, namespaces, origType, elemData = dataPriv.hasData(elem) && dataPriv.get(elem);
			if (!elemData || !(events = elemData.events)) return;
			types = (types || "").match(rnothtmlwhite) || [""];
			t = types.length;
			while (t--) {
				tmp = rtypenamespace.exec(types[t]) || [];
				type = origType = tmp[1];
				namespaces = (tmp[2] || "").split(".").sort();
				if (!type) {
					for (type in events) jQuery.event.remove(elem, type + types[t], handler, selector, true);
					continue;
				}
				special = jQuery.event.special[type] || {};
				type = (selector ? special.delegateType : special.bindType) || type;
				handlers = events[type] || [];
				tmp = tmp[2] && new RegExp("(^|\\.)" + namespaces.join("\\.(?:.*\\.|)") + "(\\.|$)");
				origCount = j = handlers.length;
				while (j--) {
					handleObj = handlers[j];
					if ((mappedTypes || origType === handleObj.origType) && (!handler || handler.guid === handleObj.guid) && (!tmp || tmp.test(handleObj.namespace)) && (!selector || selector === handleObj.selector || selector === "**" && handleObj.selector)) {
						handlers.splice(j, 1);
						if (handleObj.selector) handlers.delegateCount--;
						if (special.remove) special.remove.call(elem, handleObj);
					}
				}
				if (origCount && !handlers.length) {
					if (!special.teardown || special.teardown.call(elem, namespaces, elemData.handle) === false) jQuery.removeEvent(elem, type, elemData.handle);
					delete events[type];
				}
			}
			if (jQuery.isEmptyObject(events)) dataPriv.remove(elem, "handle events");
		},
		dispatch: function(nativeEvent) {
			var i, j, ret, matched, handleObj, handlerQueue, args = new Array(arguments.length), event = jQuery.event.fix(nativeEvent), handlers = (dataPriv.get(this, "events") || Object.create(null))[event.type] || [], special = jQuery.event.special[event.type] || {};
			args[0] = event;
			for (i = 1; i < arguments.length; i++) args[i] = arguments[i];
			event.delegateTarget = this;
			if (special.preDispatch && special.preDispatch.call(this, event) === false) return;
			handlerQueue = jQuery.event.handlers.call(this, event, handlers);
			i = 0;
			while ((matched = handlerQueue[i++]) && !event.isPropagationStopped()) {
				event.currentTarget = matched.elem;
				j = 0;
				while ((handleObj = matched.handlers[j++]) && !event.isImmediatePropagationStopped()) if (!event.rnamespace || handleObj.namespace === false || event.rnamespace.test(handleObj.namespace)) {
					event.handleObj = handleObj;
					event.data = handleObj.data;
					ret = ((jQuery.event.special[handleObj.origType] || {}).handle || handleObj.handler).apply(matched.elem, args);
					if (ret !== void 0) {
						if ((event.result = ret) === false) {
							event.preventDefault();
							event.stopPropagation();
						}
					}
				}
			}
			if (special.postDispatch) special.postDispatch.call(this, event);
			return event.result;
		},
		handlers: function(event, handlers) {
			var i, handleObj, sel, matchedHandlers, matchedSelectors, handlerQueue = [], delegateCount = handlers.delegateCount, cur = event.target;
			if (delegateCount && !(event.type === "click" && event.button >= 1)) {
				for (; cur !== this; cur = cur.parentNode || this) if (cur.nodeType === 1 && !(event.type === "click" && cur.disabled === true)) {
					matchedHandlers = [];
					matchedSelectors = {};
					for (i = 0; i < delegateCount; i++) {
						handleObj = handlers[i];
						sel = handleObj.selector + " ";
						if (matchedSelectors[sel] === void 0) matchedSelectors[sel] = handleObj.needsContext ? jQuery(sel, this).index(cur) > -1 : jQuery.find(sel, this, null, [cur]).length;
						if (matchedSelectors[sel]) matchedHandlers.push(handleObj);
					}
					if (matchedHandlers.length) handlerQueue.push({
						elem: cur,
						handlers: matchedHandlers
					});
				}
			}
			cur = this;
			if (delegateCount < handlers.length) handlerQueue.push({
				elem: cur,
				handlers: handlers.slice(delegateCount)
			});
			return handlerQueue;
		},
		addProp: function(name, hook) {
			Object.defineProperty(jQuery.Event.prototype, name, {
				enumerable: true,
				configurable: true,
				get: typeof hook === "function" ? function() {
					if (this.originalEvent) return hook(this.originalEvent);
				} : function() {
					if (this.originalEvent) return this.originalEvent[name];
				},
				set: function(value) {
					Object.defineProperty(this, name, {
						enumerable: true,
						configurable: true,
						writable: true,
						value
					});
				}
			});
		},
		fix: function(originalEvent) {
			return originalEvent[jQuery.expando] ? originalEvent : new jQuery.Event(originalEvent);
		},
		special: jQuery.extend(Object.create(null), {
			load: { noBubble: true },
			click: {
				setup: function(data) {
					var el = this || data;
					if (rcheckableType.test(el.type) && el.click && nodeName(el, "input")) leverageNative(el, "click", true);
					return false;
				},
				trigger: function(data) {
					var el = this || data;
					if (rcheckableType.test(el.type) && el.click && nodeName(el, "input")) leverageNative(el, "click");
					return true;
				},
				_default: function(event) {
					var target = event.target;
					return rcheckableType.test(target.type) && target.click && nodeName(target, "input") && dataPriv.get(target, "click") || nodeName(target, "a");
				}
			},
			beforeunload: { postDispatch: function(event) {
				if (event.result !== void 0) event.preventDefault();
			} }
		})
	};
	function leverageNative(el, type, isSetup) {
		if (!isSetup) {
			if (dataPriv.get(el, type) === void 0) jQuery.event.add(el, type, returnTrue);
			return;
		}
		dataPriv.set(el, type, false);
		jQuery.event.add(el, type, {
			namespace: false,
			handler: function(event) {
				var result, saved = dataPriv.get(this, type);
				if (event.isTrigger & 1 && this[type]) {
					if (!saved.length) {
						saved = slice.call(arguments);
						dataPriv.set(this, type, saved);
						this[type]();
						result = dataPriv.get(this, type);
						dataPriv.set(this, type, false);
						if (saved !== result) {
							event.stopImmediatePropagation();
							event.preventDefault();
							return result && result.value;
						}
					} else if ((jQuery.event.special[type] || {}).delegateType) event.stopPropagation();
				} else if (saved.length) {
					dataPriv.set(this, type, { value: jQuery.event.trigger(saved[0], saved.slice(1), this) });
					event.stopPropagation();
					event.isImmediatePropagationStopped = returnTrue;
				}
			}
		});
	}
	jQuery.removeEvent = function(elem, type, handle) {
		if (elem.removeEventListener) elem.removeEventListener(type, handle);
	};
	jQuery.Event = function(src, props) {
		if (!(this instanceof jQuery.Event)) return new jQuery.Event(src, props);
		if (src && src.type) {
			this.originalEvent = src;
			this.type = src.type;
			this.isDefaultPrevented = src.defaultPrevented ? returnTrue : returnFalse;
			this.target = src.target;
			this.currentTarget = src.currentTarget;
			this.relatedTarget = src.relatedTarget;
		} else this.type = src;
		if (props) jQuery.extend(this, props);
		this.timeStamp = src && src.timeStamp || Date.now();
		this[jQuery.expando] = true;
	};
	jQuery.Event.prototype = {
		constructor: jQuery.Event,
		isDefaultPrevented: returnFalse,
		isPropagationStopped: returnFalse,
		isImmediatePropagationStopped: returnFalse,
		isSimulated: false,
		preventDefault: function() {
			var e = this.originalEvent;
			this.isDefaultPrevented = returnTrue;
			if (e && !this.isSimulated) e.preventDefault();
		},
		stopPropagation: function() {
			var e = this.originalEvent;
			this.isPropagationStopped = returnTrue;
			if (e && !this.isSimulated) e.stopPropagation();
		},
		stopImmediatePropagation: function() {
			var e = this.originalEvent;
			this.isImmediatePropagationStopped = returnTrue;
			if (e && !this.isSimulated) e.stopImmediatePropagation();
			this.stopPropagation();
		}
	};
	jQuery.each({
		altKey: true,
		bubbles: true,
		cancelable: true,
		changedTouches: true,
		ctrlKey: true,
		detail: true,
		eventPhase: true,
		metaKey: true,
		pageX: true,
		pageY: true,
		shiftKey: true,
		view: true,
		"char": true,
		code: true,
		charCode: true,
		key: true,
		keyCode: true,
		button: true,
		buttons: true,
		clientX: true,
		clientY: true,
		offsetX: true,
		offsetY: true,
		pointerId: true,
		pointerType: true,
		screenX: true,
		screenY: true,
		targetTouches: true,
		toElement: true,
		touches: true,
		which: true
	}, jQuery.event.addProp);
	jQuery.each({
		focus: "focusin",
		blur: "focusout"
	}, function(type, delegateType) {
		function focusMappedHandler(nativeEvent) {
			var event = jQuery.event.fix(nativeEvent);
			event.type = nativeEvent.type === "focusin" ? "focus" : "blur";
			event.isSimulated = true;
			if (event.target === event.currentTarget) dataPriv.get(this, "handle")(event);
		}
		jQuery.event.special[type] = {
			setup: function() {
				leverageNative(this, type, true);
				if (isIE) this.addEventListener(delegateType, focusMappedHandler);
				else return false;
			},
			trigger: function() {
				leverageNative(this, type);
				return true;
			},
			teardown: function() {
				if (isIE) this.removeEventListener(delegateType, focusMappedHandler);
				else return false;
			},
			_default: function(event) {
				return dataPriv.get(event.target, type);
			},
			delegateType
		};
	});
	jQuery.each({
		mouseenter: "mouseover",
		mouseleave: "mouseout",
		pointerenter: "pointerover",
		pointerleave: "pointerout"
	}, function(orig, fix) {
		jQuery.event.special[orig] = {
			delegateType: fix,
			bindType: fix,
			handle: function(event) {
				var ret, target = this, related = event.relatedTarget, handleObj = event.handleObj;
				if (!related || related !== target && !jQuery.contains(target, related)) {
					event.type = handleObj.origType;
					ret = handleObj.handler.apply(this, arguments);
					event.type = fix;
				}
				return ret;
			}
		};
	});
	jQuery.fn.extend({
		on: function(types, selector, data, fn) {
			return on(this, types, selector, data, fn);
		},
		one: function(types, selector, data, fn) {
			return on(this, types, selector, data, fn, 1);
		},
		off: function(types, selector, fn) {
			var handleObj, type;
			if (types && types.preventDefault && types.handleObj) {
				handleObj = types.handleObj;
				jQuery(types.delegateTarget).off(handleObj.namespace ? handleObj.origType + "." + handleObj.namespace : handleObj.origType, handleObj.selector, handleObj.handler);
				return this;
			}
			if (typeof types === "object") {
				for (type in types) this.off(type, selector, types[type]);
				return this;
			}
			if (selector === false || typeof selector === "function") {
				fn = selector;
				selector = void 0;
			}
			if (fn === false) fn = returnFalse;
			return this.each(function() {
				jQuery.event.remove(this, types, fn, selector);
			});
		}
	});
	var rnoInnerhtml = /<script|<style|<link/i;
	function manipulationTarget(elem, content) {
		if (nodeName(elem, "table") && nodeName(content.nodeType !== 11 ? content : content.firstChild, "tr")) return jQuery(elem).children("tbody")[0] || elem;
		return elem;
	}
	function cloneCopyEvent(src, dest) {
		var type, i, l, events = dataPriv.get(src, "events");
		if (dest.nodeType !== 1) return;
		if (events) {
			dataPriv.remove(dest, "handle events");
			for (type in events) for (i = 0, l = events[type].length; i < l; i++) jQuery.event.add(dest, type, events[type][i]);
		}
		if (dataUser.hasData(src)) dataUser.set(dest, jQuery.extend({}, dataUser.get(src)));
	}
	function remove(elem, selector, keepData) {
		var node, nodes = selector ? jQuery.filter(selector, elem) : elem, i = 0;
		for (; (node = nodes[i]) != null; i++) {
			if (!keepData && node.nodeType === 1) jQuery.cleanData(getAll(node));
			if (node.parentNode) {
				if (keepData && isAttached(node)) setGlobalEval(getAll(node, "script"));
				node.parentNode.removeChild(node);
			}
		}
		return elem;
	}
	jQuery.extend({
		htmlPrefilter: function(html) {
			return html;
		},
		clone: function(elem, dataAndEvents, deepDataAndEvents) {
			var i, l, srcElements, destElements, clone = elem.cloneNode(true), inPage = isAttached(elem);
			if (isIE && (elem.nodeType === 1 || elem.nodeType === 11) && !jQuery.isXMLDoc(elem)) {
				destElements = getAll(clone);
				srcElements = getAll(elem);
				for (i = 0, l = srcElements.length; i < l; i++) if (nodeName(destElements[i], "textarea")) destElements[i].defaultValue = srcElements[i].defaultValue;
			}
			if (dataAndEvents) {
				if (deepDataAndEvents) {
					srcElements = srcElements || getAll(elem);
					destElements = destElements || getAll(clone);
					for (i = 0, l = srcElements.length; i < l; i++) cloneCopyEvent(srcElements[i], destElements[i]);
				} else cloneCopyEvent(elem, clone);
			}
			destElements = getAll(clone, "script");
			if (destElements.length > 0) setGlobalEval(destElements, !inPage && getAll(elem, "script"));
			return clone;
		},
		cleanData: function(elems) {
			var data, elem, type, special = jQuery.event.special, i = 0;
			for (; (elem = elems[i]) !== void 0; i++) if (acceptData(elem)) {
				if (data = elem[dataPriv.expando]) {
					if (data.events) for (type in data.events) if (special[type]) jQuery.event.remove(elem, type);
					else jQuery.removeEvent(elem, type, data.handle);
					elem[dataPriv.expando] = void 0;
				}
				if (elem[dataUser.expando]) elem[dataUser.expando] = void 0;
			}
		}
	});
	jQuery.fn.extend({
		detach: function(selector) {
			return remove(this, selector, true);
		},
		remove: function(selector) {
			return remove(this, selector);
		},
		text: function(value) {
			return access(this, function(value) {
				return value === void 0 ? jQuery.text(this) : this.empty().each(function() {
					if (this.nodeType === 1 || this.nodeType === 11 || this.nodeType === 9) this.textContent = value;
				});
			}, null, value, arguments.length);
		},
		append: function() {
			return domManip(this, arguments, function(elem) {
				if (this.nodeType === 1 || this.nodeType === 11 || this.nodeType === 9) manipulationTarget(this, elem).appendChild(elem);
			});
		},
		prepend: function() {
			return domManip(this, arguments, function(elem) {
				if (this.nodeType === 1 || this.nodeType === 11 || this.nodeType === 9) {
					var target = manipulationTarget(this, elem);
					target.insertBefore(elem, target.firstChild);
				}
			});
		},
		before: function() {
			return domManip(this, arguments, function(elem) {
				if (this.parentNode) this.parentNode.insertBefore(elem, this);
			});
		},
		after: function() {
			return domManip(this, arguments, function(elem) {
				if (this.parentNode) this.parentNode.insertBefore(elem, this.nextSibling);
			});
		},
		empty: function() {
			var elem, i = 0;
			for (; (elem = this[i]) != null; i++) if (elem.nodeType === 1) {
				jQuery.cleanData(getAll(elem, false));
				elem.textContent = "";
			}
			return this;
		},
		clone: function(dataAndEvents, deepDataAndEvents) {
			dataAndEvents = dataAndEvents == null ? false : dataAndEvents;
			deepDataAndEvents = deepDataAndEvents == null ? dataAndEvents : deepDataAndEvents;
			return this.map(function() {
				return jQuery.clone(this, dataAndEvents, deepDataAndEvents);
			});
		},
		html: function(value) {
			return access(this, function(value) {
				var elem = this[0] || {}, i = 0, l = this.length;
				if (value === void 0 && elem.nodeType === 1) return elem.innerHTML;
				if (typeof value === "string" && !rnoInnerhtml.test(value) && !wrapMap[(rtagName.exec(value) || ["", ""])[1].toLowerCase()]) {
					value = jQuery.htmlPrefilter(value);
					try {
						for (; i < l; i++) {
							elem = this[i] || {};
							if (elem.nodeType === 1) {
								jQuery.cleanData(getAll(elem, false));
								elem.innerHTML = value;
							}
						}
						elem = 0;
					} catch (e) {}
				}
				if (elem) this.empty().append(value);
			}, null, value, arguments.length);
		},
		replaceWith: function() {
			var ignored = [];
			return domManip(this, arguments, function(elem) {
				var parent = this.parentNode;
				if (jQuery.inArray(this, ignored) < 0) {
					jQuery.cleanData(getAll(this));
					if (parent) parent.replaceChild(elem, this);
				}
			}, ignored);
		}
	});
	jQuery.each({
		appendTo: "append",
		prependTo: "prepend",
		insertBefore: "before",
		insertAfter: "after",
		replaceAll: "replaceWith"
	}, function(name, original) {
		jQuery.fn[name] = function(selector) {
			var elems, ret = [], insert = jQuery(selector), last = insert.length - 1, i = 0;
			for (; i <= last; i++) {
				elems = i === last ? this : this.clone(true);
				jQuery(insert[i])[original](elems);
				push.apply(ret, elems);
			}
			return this.pushStack(ret);
		};
	});
	var rnumnonpx = new RegExp("^(" + pnum + ")(?!px)[a-z%]+$", "i");
	var rcustomProp = /^--/;
	function getStyles(elem) {
		var view = elem.ownerDocument.defaultView;
		if (!view) view = window;
		return view.getComputedStyle(elem);
	}
	function swap(elem, options, callback) {
		var ret, name, old = {};
		for (name in options) {
			old[name] = elem.style[name];
			elem.style[name] = options[name];
		}
		ret = callback.call(elem);
		for (name in options) elem.style[name] = old[name];
		return ret;
	}
	function curCSS(elem, name, computed) {
		var ret, isCustomProp = rcustomProp.test(name);
		computed = computed || getStyles(elem);
		if (computed) {
			ret = computed.getPropertyValue(name) || computed[name];
			if (isCustomProp && ret) ret = ret.replace(rtrimCSS, "$1") || void 0;
			if (ret === "" && !isAttached(elem)) ret = jQuery.style(elem, name);
		}
		return ret !== void 0 ? ret + "" : ret;
	}
	var cssPrefixes = [
		"Webkit",
		"Moz",
		"ms"
	], emptyStyle = document$1.createElement("div").style;
	function vendorPropName(name) {
		var capName = name[0].toUpperCase() + name.slice(1), i = cssPrefixes.length;
		while (i--) {
			name = cssPrefixes[i] + capName;
			if (name in emptyStyle) return name;
		}
	}
	function finalPropName(name) {
		if (name in emptyStyle) return name;
		return vendorPropName(name) || name;
	}
	var reliableTrDimensionsVal, reliableColDimensionsVal, table = document$1.createElement("table");
	function computeTableStyleTests() {
		if (!table || !table.style) return;
		var trStyle, col = document$1.createElement("col"), tr = document$1.createElement("tr"), td = document$1.createElement("td");
		table.style.cssText = "position:absolute;left:-11111px;border-collapse:separate;border-spacing:0";
		tr.style.cssText = "box-sizing:content-box;border:1px solid;height:1px";
		td.style.cssText = "height:9px;width:9px;padding:0";
		col.span = 2;
		documentElement$1.appendChild(table).appendChild(col).parentNode.appendChild(tr).appendChild(td).parentNode.appendChild(td.cloneNode(true));
		if (table.offsetWidth === 0) {
			documentElement$1.removeChild(table);
			return;
		}
		trStyle = window.getComputedStyle(tr);
		reliableColDimensionsVal = isIE || Math.round(parseFloat(window.getComputedStyle(col).width)) === 18;
		reliableTrDimensionsVal = Math.round(parseFloat(trStyle.height) + parseFloat(trStyle.borderTopWidth) + parseFloat(trStyle.borderBottomWidth)) === tr.offsetHeight;
		documentElement$1.removeChild(table);
		table = null;
	}
	jQuery.extend(support, {
		reliableTrDimensions: function() {
			computeTableStyleTests();
			return reliableTrDimensionsVal;
		},
		reliableColDimensions: function() {
			computeTableStyleTests();
			return reliableColDimensionsVal;
		}
	});
	var cssShow = {
		position: "absolute",
		visibility: "hidden",
		display: "block"
	}, cssNormalTransform = {
		letterSpacing: "0",
		fontWeight: "400"
	};
	function setPositiveNumber(_elem, value, subtract) {
		var matches = rcssNum.exec(value);
		return matches ? Math.max(0, matches[2] - (subtract || 0)) + (matches[3] || "px") : value;
	}
	function boxModelAdjustment(elem, dimension, box, isBorderBox, styles, computedVal) {
		var i = dimension === "width" ? 1 : 0, extra = 0, delta = 0, marginDelta = 0;
		if (box === (isBorderBox ? "border" : "content")) return 0;
		for (; i < 4; i += 2) {
			if (box === "margin") marginDelta += jQuery.css(elem, box + cssExpand[i], true, styles);
			if (!isBorderBox) {
				delta += jQuery.css(elem, "padding" + cssExpand[i], true, styles);
				if (box !== "padding") delta += jQuery.css(elem, "border" + cssExpand[i] + "Width", true, styles);
				else extra += jQuery.css(elem, "border" + cssExpand[i] + "Width", true, styles);
			} else {
				if (box === "content") delta -= jQuery.css(elem, "padding" + cssExpand[i], true, styles);
				if (box !== "margin") delta -= jQuery.css(elem, "border" + cssExpand[i] + "Width", true, styles);
			}
		}
		if (!isBorderBox && computedVal >= 0) delta += Math.max(0, Math.ceil(elem["offset" + dimension[0].toUpperCase() + dimension.slice(1)] - computedVal - delta - extra - .5)) || 0;
		return delta + marginDelta;
	}
	function getWidthOrHeight(elem, dimension, extra) {
		var styles = getStyles(elem), isBorderBox = (isIE || extra) && jQuery.css(elem, "boxSizing", false, styles) === "border-box", valueIsBorderBox = isBorderBox, val = curCSS(elem, dimension, styles), offsetProp = "offset" + dimension[0].toUpperCase() + dimension.slice(1);
		if (rnumnonpx.test(val)) {
			if (!extra) return val;
			val = "auto";
		}
		if ((val === "auto" || isIE && isBorderBox || !support.reliableColDimensions() && nodeName(elem, "col") || !support.reliableTrDimensions() && nodeName(elem, "tr")) && elem.getClientRects().length) {
			isBorderBox = jQuery.css(elem, "boxSizing", false, styles) === "border-box";
			valueIsBorderBox = offsetProp in elem;
			if (valueIsBorderBox) val = elem[offsetProp];
		}
		val = parseFloat(val) || 0;
		return val + boxModelAdjustment(elem, dimension, extra || (isBorderBox ? "border" : "content"), valueIsBorderBox, styles, val) + "px";
	}
	jQuery.extend({
		cssHooks: {},
		style: function(elem, name, value, extra) {
			if (!elem || elem.nodeType === 3 || elem.nodeType === 8 || !elem.style) return;
			var ret, type, hooks, origName = cssCamelCase(name), isCustomProp = rcustomProp.test(name), style = elem.style;
			if (!isCustomProp) name = finalPropName(origName);
			hooks = jQuery.cssHooks[name] || jQuery.cssHooks[origName];
			if (value !== void 0) {
				type = typeof value;
				if (type === "string" && (ret = rcssNum.exec(value)) && ret[1]) {
					value = adjustCSS(elem, name, ret);
					type = "number";
				}
				if (value == null || value !== value) return;
				if (type === "number") value += ret && ret[3] || (isAutoPx(origName) ? "px" : "");
				if (isIE && value === "" && name.indexOf("background") === 0) style[name] = "inherit";
				if (!hooks || !("set" in hooks) || (value = hooks.set(elem, value, extra)) !== void 0) {
					if (isCustomProp) style.setProperty(name, value);
					else style[name] = value;
				}
			} else {
				if (hooks && "get" in hooks && (ret = hooks.get(elem, false, extra)) !== void 0) return ret;
				return style[name];
			}
		},
		css: function(elem, name, extra, styles) {
			var val, num, hooks, origName = cssCamelCase(name);
			if (!rcustomProp.test(name)) name = finalPropName(origName);
			hooks = jQuery.cssHooks[name] || jQuery.cssHooks[origName];
			if (hooks && "get" in hooks) val = hooks.get(elem, true, extra);
			if (val === void 0) val = curCSS(elem, name, styles);
			if (val === "normal" && name in cssNormalTransform) val = cssNormalTransform[name];
			if (extra === "" || extra) {
				num = parseFloat(val);
				return extra === true || isFinite(num) ? num || 0 : val;
			}
			return val;
		}
	});
	jQuery.each(["height", "width"], function(_i, dimension) {
		jQuery.cssHooks[dimension] = {
			get: function(elem, computed, extra) {
				if (computed) return jQuery.css(elem, "display") === "none" ? swap(elem, cssShow, function() {
					return getWidthOrHeight(elem, dimension, extra);
				}) : getWidthOrHeight(elem, dimension, extra);
			},
			set: function(elem, value, extra) {
				var matches, styles = getStyles(elem), isBorderBox = extra && jQuery.css(elem, "boxSizing", false, styles) === "border-box", subtract = extra ? boxModelAdjustment(elem, dimension, extra, isBorderBox, styles) : 0;
				if (subtract && (matches = rcssNum.exec(value)) && (matches[3] || "px") !== "px") {
					elem.style[dimension] = value;
					value = jQuery.css(elem, dimension);
				}
				return setPositiveNumber(elem, value, subtract);
			}
		};
	});
	jQuery.each({
		margin: "",
		padding: "",
		border: "Width"
	}, function(prefix, suffix) {
		jQuery.cssHooks[prefix + suffix] = { expand: function(value) {
			var i = 0, expanded = {}, parts = typeof value === "string" ? value.split(" ") : [value];
			for (; i < 4; i++) expanded[prefix + cssExpand[i] + suffix] = parts[i] || parts[i - 2] || parts[0];
			return expanded;
		} };
		if (prefix !== "margin") jQuery.cssHooks[prefix + suffix].set = setPositiveNumber;
	});
	jQuery.fn.extend({ css: function(name, value) {
		return access(this, function(elem, name, value) {
			var styles, len, map = {}, i = 0;
			if (Array.isArray(name)) {
				styles = getStyles(elem);
				len = name.length;
				for (; i < len; i++) map[name[i]] = jQuery.css(elem, name[i], false, styles);
				return map;
			}
			return value !== void 0 ? jQuery.style(elem, name, value) : jQuery.css(elem, name);
		}, name, value, arguments.length > 1);
	} });
	function Tween(elem, options, prop, end, easing) {
		return new Tween.prototype.init(elem, options, prop, end, easing);
	}
	jQuery.Tween = Tween;
	Tween.prototype = {
		constructor: Tween,
		init: function(elem, options, prop, end, easing, unit) {
			this.elem = elem;
			this.prop = prop;
			this.easing = easing || jQuery.easing._default;
			this.options = options;
			this.start = this.now = this.cur();
			this.end = end;
			this.unit = unit || (isAutoPx(prop) ? "px" : "");
		},
		cur: function() {
			var hooks = Tween.propHooks[this.prop];
			return hooks && hooks.get ? hooks.get(this) : Tween.propHooks._default.get(this);
		},
		run: function(percent) {
			var eased, hooks = Tween.propHooks[this.prop];
			if (this.options.duration) this.pos = eased = jQuery.easing[this.easing](percent, this.options.duration * percent, 0, 1, this.options.duration);
			else this.pos = eased = percent;
			this.now = (this.end - this.start) * eased + this.start;
			if (this.options.step) this.options.step.call(this.elem, this.now, this);
			if (hooks && hooks.set) hooks.set(this);
			else Tween.propHooks._default.set(this);
			return this;
		}
	};
	Tween.prototype.init.prototype = Tween.prototype;
	Tween.propHooks = { _default: {
		get: function(tween) {
			var result;
			if (tween.elem.nodeType !== 1 || tween.elem[tween.prop] != null && tween.elem.style[tween.prop] == null) return tween.elem[tween.prop];
			result = jQuery.css(tween.elem, tween.prop, "");
			return !result || result === "auto" ? 0 : result;
		},
		set: function(tween) {
			if (jQuery.fx.step[tween.prop]) jQuery.fx.step[tween.prop](tween);
			else if (tween.elem.nodeType === 1 && (jQuery.cssHooks[tween.prop] || tween.elem.style[finalPropName(tween.prop)] != null)) jQuery.style(tween.elem, tween.prop, tween.now + tween.unit);
			else tween.elem[tween.prop] = tween.now;
		}
	} };
	jQuery.easing = {
		linear: function(p) {
			return p;
		},
		swing: function(p) {
			return .5 - Math.cos(p * Math.PI) / 2;
		},
		_default: "swing"
	};
	jQuery.fx = Tween.prototype.init;
	jQuery.fx.step = {};
	var fxNow, inProgress, rfxtypes = /^(?:toggle|show|hide)$/, rrun = /queueHooks$/;
	function schedule() {
		if (inProgress) {
			if (document$1.hidden === false && window.requestAnimationFrame) window.requestAnimationFrame(schedule);
			else window.setTimeout(schedule, 13);
			jQuery.fx.tick();
		}
	}
	function createFxNow() {
		window.setTimeout(function() {
			fxNow = void 0;
		});
		return fxNow = Date.now();
	}
	function genFx(type, includeWidth) {
		var which, i = 0, attrs = { height: type };
		includeWidth = includeWidth ? 1 : 0;
		for (; i < 4; i += 2 - includeWidth) {
			which = cssExpand[i];
			attrs["margin" + which] = attrs["padding" + which] = type;
		}
		if (includeWidth) attrs.opacity = attrs.width = type;
		return attrs;
	}
	function createTween(value, prop, animation) {
		var tween, collection = (Animation.tweeners[prop] || []).concat(Animation.tweeners["*"]), index = 0, length = collection.length;
		for (; index < length; index++) if (tween = collection[index].call(animation, prop, value)) return tween;
	}
	function defaultPrefilter(elem, props, opts) {
		var prop, value, toggle, hooks, oldfire, propTween, restoreDisplay, display, isBox = "width" in props || "height" in props, anim = this, orig = {}, style = elem.style, hidden = elem.nodeType && isHiddenWithinTree(elem), dataShow = dataPriv.get(elem, "fxshow");
		if (!opts.queue) {
			hooks = jQuery._queueHooks(elem, "fx");
			if (hooks.unqueued == null) {
				hooks.unqueued = 0;
				oldfire = hooks.empty.fire;
				hooks.empty.fire = function() {
					if (!hooks.unqueued) oldfire();
				};
			}
			hooks.unqueued++;
			anim.always(function() {
				anim.always(function() {
					hooks.unqueued--;
					if (!jQuery.queue(elem, "fx").length) hooks.empty.fire();
				});
			});
		}
		for (prop in props) {
			value = props[prop];
			if (rfxtypes.test(value)) {
				delete props[prop];
				toggle = toggle || value === "toggle";
				if (value === (hidden ? "hide" : "show")) {
					if (value === "show" && dataShow && dataShow[prop] !== void 0) hidden = true;
					else continue;
				}
				orig[prop] = dataShow && dataShow[prop] || jQuery.style(elem, prop);
			}
		}
		propTween = !jQuery.isEmptyObject(props);
		if (!propTween && jQuery.isEmptyObject(orig)) return;
		if (isBox && elem.nodeType === 1) {
			opts.overflow = [
				style.overflow,
				style.overflowX,
				style.overflowY
			];
			restoreDisplay = dataShow && dataShow.display;
			if (restoreDisplay == null) restoreDisplay = dataPriv.get(elem, "display");
			display = jQuery.css(elem, "display");
			if (display === "none") {
				if (restoreDisplay) display = restoreDisplay;
				else {
					showHide([elem], true);
					restoreDisplay = elem.style.display || restoreDisplay;
					display = jQuery.css(elem, "display");
					showHide([elem]);
				}
			}
			if (display === "inline" || display === "inline-block" && restoreDisplay != null) {
				if (jQuery.css(elem, "float") === "none") {
					if (!propTween) {
						anim.done(function() {
							style.display = restoreDisplay;
						});
						if (restoreDisplay == null) {
							display = style.display;
							restoreDisplay = display === "none" ? "" : display;
						}
					}
					style.display = "inline-block";
				}
			}
		}
		if (opts.overflow) {
			style.overflow = "hidden";
			anim.always(function() {
				style.overflow = opts.overflow[0];
				style.overflowX = opts.overflow[1];
				style.overflowY = opts.overflow[2];
			});
		}
		propTween = false;
		for (prop in orig) {
			if (!propTween) {
				if (dataShow) {
					if ("hidden" in dataShow) hidden = dataShow.hidden;
				} else dataShow = dataPriv.set(elem, "fxshow", { display: restoreDisplay });
				if (toggle) dataShow.hidden = !hidden;
				if (hidden) showHide([elem], true);
				anim.done(function() {
					if (!hidden) showHide([elem]);
					dataPriv.remove(elem, "fxshow");
					for (prop in orig) jQuery.style(elem, prop, orig[prop]);
				});
			}
			propTween = createTween(hidden ? dataShow[prop] : 0, prop, anim);
			if (!(prop in dataShow)) {
				dataShow[prop] = propTween.start;
				if (hidden) {
					propTween.end = propTween.start;
					propTween.start = 0;
				}
			}
		}
	}
	function propFilter(props, specialEasing) {
		var index, name, easing, value, hooks;
		for (index in props) {
			name = cssCamelCase(index);
			easing = specialEasing[name];
			value = props[index];
			if (Array.isArray(value)) {
				easing = value[1];
				value = props[index] = value[0];
			}
			if (index !== name) {
				props[name] = value;
				delete props[index];
			}
			hooks = jQuery.cssHooks[name];
			if (hooks && "expand" in hooks) {
				value = hooks.expand(value);
				delete props[name];
				for (index in value) if (!(index in props)) {
					props[index] = value[index];
					specialEasing[index] = easing;
				}
			} else specialEasing[name] = easing;
		}
	}
	function Animation(elem, properties, options) {
		var result, stopped, index = 0, length = Animation.prefilters.length, deferred = jQuery.Deferred().always(function() {
			delete tick.elem;
		}), tick = function() {
			if (stopped) return false;
			var currentTime = fxNow || createFxNow(), remaining = Math.max(0, animation.startTime + animation.duration - currentTime), percent = 1 - (remaining / animation.duration || 0), index = 0, length = animation.tweens.length;
			for (; index < length; index++) animation.tweens[index].run(percent);
			deferred.notifyWith(elem, [
				animation,
				percent,
				remaining
			]);
			if (percent < 1 && length) return remaining;
			if (!length) deferred.notifyWith(elem, [
				animation,
				1,
				0
			]);
			deferred.resolveWith(elem, [animation]);
			return false;
		}, animation = deferred.promise({
			elem,
			props: jQuery.extend({}, properties),
			opts: jQuery.extend(true, {
				specialEasing: {},
				easing: jQuery.easing._default
			}, options),
			originalProperties: properties,
			originalOptions: options,
			startTime: fxNow || createFxNow(),
			duration: options.duration,
			tweens: [],
			createTween: function(prop, end) {
				var tween = jQuery.Tween(elem, animation.opts, prop, end, animation.opts.specialEasing[prop] || animation.opts.easing);
				animation.tweens.push(tween);
				return tween;
			},
			stop: function(gotoEnd) {
				var index = 0, length = gotoEnd ? animation.tweens.length : 0;
				if (stopped) return this;
				stopped = true;
				for (; index < length; index++) animation.tweens[index].run(1);
				if (gotoEnd) {
					deferred.notifyWith(elem, [
						animation,
						1,
						0
					]);
					deferred.resolveWith(elem, [animation, gotoEnd]);
				} else deferred.rejectWith(elem, [animation, gotoEnd]);
				return this;
			}
		}), props = animation.props;
		propFilter(props, animation.opts.specialEasing);
		for (; index < length; index++) {
			result = Animation.prefilters[index].call(animation, elem, props, animation.opts);
			if (result) {
				if (typeof result.stop === "function") jQuery._queueHooks(animation.elem, animation.opts.queue).stop = result.stop.bind(result);
				return result;
			}
		}
		jQuery.map(props, createTween, animation);
		if (typeof animation.opts.start === "function") animation.opts.start.call(elem, animation);
		animation.progress(animation.opts.progress).done(animation.opts.done, animation.opts.complete).fail(animation.opts.fail).always(animation.opts.always);
		jQuery.fx.timer(jQuery.extend(tick, {
			elem,
			anim: animation,
			queue: animation.opts.queue
		}));
		return animation;
	}
	jQuery.Animation = jQuery.extend(Animation, {
		tweeners: { "*": [function(prop, value) {
			var tween = this.createTween(prop, value);
			adjustCSS(tween.elem, prop, rcssNum.exec(value), tween);
			return tween;
		}] },
		tweener: function(props, callback) {
			if (typeof props === "function") {
				callback = props;
				props = ["*"];
			} else props = props.match(rnothtmlwhite);
			var prop, index = 0, length = props.length;
			for (; index < length; index++) {
				prop = props[index];
				Animation.tweeners[prop] = Animation.tweeners[prop] || [];
				Animation.tweeners[prop].unshift(callback);
			}
		},
		prefilters: [defaultPrefilter],
		prefilter: function(callback, prepend) {
			if (prepend) Animation.prefilters.unshift(callback);
			else Animation.prefilters.push(callback);
		}
	});
	jQuery.speed = function(speed, easing, fn) {
		var opt = speed && typeof speed === "object" ? jQuery.extend({}, speed) : {
			complete: fn || easing || typeof speed === "function" && speed,
			duration: speed,
			easing: fn && easing || easing && typeof easing !== "function" && easing
		};
		if (jQuery.fx.off) opt.duration = 0;
		else if (typeof opt.duration !== "number") {
			if (opt.duration in jQuery.fx.speeds) opt.duration = jQuery.fx.speeds[opt.duration];
			else opt.duration = jQuery.fx.speeds._default;
		}
		if (opt.queue == null || opt.queue === true) opt.queue = "fx";
		opt.old = opt.complete;
		opt.complete = function() {
			if (typeof opt.old === "function") opt.old.call(this);
			if (opt.queue) jQuery.dequeue(this, opt.queue);
		};
		return opt;
	};
	jQuery.fn.extend({
		fadeTo: function(speed, to, easing, callback) {
			return this.filter(isHiddenWithinTree).css("opacity", 0).show().end().animate({ opacity: to }, speed, easing, callback);
		},
		animate: function(prop, speed, easing, callback) {
			var empty = jQuery.isEmptyObject(prop), optall = jQuery.speed(speed, easing, callback), doAnimation = function() {
				var anim = Animation(this, jQuery.extend({}, prop), optall);
				if (empty || dataPriv.get(this, "finish")) anim.stop(true);
			};
			doAnimation.finish = doAnimation;
			return empty || optall.queue === false ? this.each(doAnimation) : this.queue(optall.queue, doAnimation);
		},
		stop: function(type, clearQueue, gotoEnd) {
			var stopQueue = function(hooks) {
				var stop = hooks.stop;
				delete hooks.stop;
				stop(gotoEnd);
			};
			if (typeof type !== "string") {
				gotoEnd = clearQueue;
				clearQueue = type;
				type = void 0;
			}
			if (clearQueue) this.queue(type || "fx", []);
			return this.each(function() {
				var dequeue = true, index = type != null && type + "queueHooks", timers = jQuery.timers, data = dataPriv.get(this);
				if (index) {
					if (data[index] && data[index].stop) stopQueue(data[index]);
				} else for (index in data) if (data[index] && data[index].stop && rrun.test(index)) stopQueue(data[index]);
				for (index = timers.length; index--;) if (timers[index].elem === this && (type == null || timers[index].queue === type)) {
					timers[index].anim.stop(gotoEnd);
					dequeue = false;
					timers.splice(index, 1);
				}
				if (dequeue || !gotoEnd) jQuery.dequeue(this, type);
			});
		},
		finish: function(type) {
			if (type !== false) type = type || "fx";
			return this.each(function() {
				var index, data = dataPriv.get(this), queue = data[type + "queue"], hooks = data[type + "queueHooks"], timers = jQuery.timers, length = queue ? queue.length : 0;
				data.finish = true;
				jQuery.queue(this, type, []);
				if (hooks && hooks.stop) hooks.stop.call(this, true);
				for (index = timers.length; index--;) if (timers[index].elem === this && timers[index].queue === type) {
					timers[index].anim.stop(true);
					timers.splice(index, 1);
				}
				for (index = 0; index < length; index++) if (queue[index] && queue[index].finish) queue[index].finish.call(this);
				delete data.finish;
			});
		}
	});
	jQuery.each([
		"toggle",
		"show",
		"hide"
	], function(_i, name) {
		var cssFn = jQuery.fn[name];
		jQuery.fn[name] = function(speed, easing, callback) {
			return speed == null || typeof speed === "boolean" ? cssFn.apply(this, arguments) : this.animate(genFx(name, true), speed, easing, callback);
		};
	});
	jQuery.each({
		slideDown: genFx("show"),
		slideUp: genFx("hide"),
		slideToggle: genFx("toggle"),
		fadeIn: { opacity: "show" },
		fadeOut: { opacity: "hide" },
		fadeToggle: { opacity: "toggle" }
	}, function(name, props) {
		jQuery.fn[name] = function(speed, easing, callback) {
			return this.animate(props, speed, easing, callback);
		};
	});
	jQuery.timers = [];
	jQuery.fx.tick = function() {
		var timer, i = 0, timers = jQuery.timers;
		fxNow = Date.now();
		for (; i < timers.length; i++) {
			timer = timers[i];
			if (!timer() && timers[i] === timer) timers.splice(i--, 1);
		}
		if (!timers.length) jQuery.fx.stop();
		fxNow = void 0;
	};
	jQuery.fx.timer = function(timer) {
		jQuery.timers.push(timer);
		jQuery.fx.start();
	};
	jQuery.fx.start = function() {
		if (inProgress) return;
		inProgress = true;
		schedule();
	};
	jQuery.fx.stop = function() {
		inProgress = null;
	};
	jQuery.fx.speeds = {
		slow: 600,
		fast: 200,
		_default: 400
	};
	jQuery.fn.delay = function(time, type) {
		time = jQuery.fx ? jQuery.fx.speeds[time] || time : time;
		type = type || "fx";
		return this.queue(type, function(next, hooks) {
			var timeout = window.setTimeout(next, time);
			hooks.stop = function() {
				window.clearTimeout(timeout);
			};
		});
	};
	var rfocusable = /^(?:input|select|textarea|button)$/i, rclickable = /^(?:a|area)$/i;
	jQuery.fn.extend({
		prop: function(name, value) {
			return access(this, jQuery.prop, name, value, arguments.length > 1);
		},
		removeProp: function(name) {
			return this.each(function() {
				delete this[jQuery.propFix[name] || name];
			});
		}
	});
	jQuery.extend({
		prop: function(elem, name, value) {
			var ret, hooks, nType = elem.nodeType;
			if (nType === 3 || nType === 8 || nType === 2) return;
			if (nType !== 1 || !jQuery.isXMLDoc(elem)) {
				name = jQuery.propFix[name] || name;
				hooks = jQuery.propHooks[name];
			}
			if (value !== void 0) {
				if (hooks && "set" in hooks && (ret = hooks.set(elem, value, name)) !== void 0) return ret;
				return elem[name] = value;
			}
			if (hooks && "get" in hooks && (ret = hooks.get(elem, name)) !== null) return ret;
			return elem[name];
		},
		propHooks: { tabIndex: { get: function(elem) {
			var tabindex = elem.getAttribute("tabindex");
			if (tabindex) return parseInt(tabindex, 10);
			if (rfocusable.test(elem.nodeName) || rclickable.test(elem.nodeName) && elem.href) return 0;
			return -1;
		} } },
		propFix: {
			"for": "htmlFor",
			"class": "className"
		}
	});
	if (isIE) jQuery.propHooks.selected = {
		get: function(elem) {
			var parent = elem.parentNode;
			if (parent && parent.parentNode) parent.parentNode.selectedIndex;
			return null;
		},
		set: function(elem) {
			var parent = elem.parentNode;
			if (parent) {
				parent.selectedIndex;
				if (parent.parentNode) parent.parentNode.selectedIndex;
			}
		}
	};
	jQuery.each([
		"tabIndex",
		"readOnly",
		"maxLength",
		"cellSpacing",
		"cellPadding",
		"rowSpan",
		"colSpan",
		"useMap",
		"frameBorder",
		"contentEditable"
	], function() {
		jQuery.propFix[this.toLowerCase()] = this;
	});
	function stripAndCollapse(value) {
		return (value.match(rnothtmlwhite) || []).join(" ");
	}
	function getClass(elem) {
		return elem.getAttribute && elem.getAttribute("class") || "";
	}
	function classesToArray(value) {
		if (Array.isArray(value)) return value;
		if (typeof value === "string") return value.match(rnothtmlwhite) || [];
		return [];
	}
	jQuery.fn.extend({
		addClass: function(value) {
			var classNames, cur, curValue, className, i, finalValue;
			if (typeof value === "function") return this.each(function(j) {
				jQuery(this).addClass(value.call(this, j, getClass(this)));
			});
			classNames = classesToArray(value);
			if (classNames.length) return this.each(function() {
				curValue = getClass(this);
				cur = this.nodeType === 1 && " " + stripAndCollapse(curValue) + " ";
				if (cur) {
					for (i = 0; i < classNames.length; i++) {
						className = classNames[i];
						if (cur.indexOf(" " + className + " ") < 0) cur += className + " ";
					}
					finalValue = stripAndCollapse(cur);
					if (curValue !== finalValue) this.setAttribute("class", finalValue);
				}
			});
			return this;
		},
		removeClass: function(value) {
			var classNames, cur, curValue, className, i, finalValue;
			if (typeof value === "function") return this.each(function(j) {
				jQuery(this).removeClass(value.call(this, j, getClass(this)));
			});
			if (!arguments.length) return this.attr("class", "");
			classNames = classesToArray(value);
			if (classNames.length) return this.each(function() {
				curValue = getClass(this);
				cur = this.nodeType === 1 && " " + stripAndCollapse(curValue) + " ";
				if (cur) {
					for (i = 0; i < classNames.length; i++) {
						className = classNames[i];
						while (cur.indexOf(" " + className + " ") > -1) cur = cur.replace(" " + className + " ", " ");
					}
					finalValue = stripAndCollapse(cur);
					if (curValue !== finalValue) this.setAttribute("class", finalValue);
				}
			});
			return this;
		},
		toggleClass: function(value, stateVal) {
			var classNames, className, i, self;
			if (typeof value === "function") return this.each(function(i) {
				jQuery(this).toggleClass(value.call(this, i, getClass(this), stateVal), stateVal);
			});
			if (typeof stateVal === "boolean") return stateVal ? this.addClass(value) : this.removeClass(value);
			classNames = classesToArray(value);
			if (classNames.length) return this.each(function() {
				self = jQuery(this);
				for (i = 0; i < classNames.length; i++) {
					className = classNames[i];
					if (self.hasClass(className)) self.removeClass(className);
					else self.addClass(className);
				}
			});
			return this;
		},
		hasClass: function(selector) {
			var className, elem, i = 0;
			className = " " + selector + " ";
			while (elem = this[i++]) if (elem.nodeType === 1 && (" " + stripAndCollapse(getClass(elem)) + " ").indexOf(className) > -1) return true;
			return false;
		}
	});
	jQuery.fn.extend({ val: function(value) {
		var hooks, ret, valueIsFunction, elem = this[0];
		if (!arguments.length) {
			if (elem) {
				hooks = jQuery.valHooks[elem.type] || jQuery.valHooks[elem.nodeName.toLowerCase()];
				if (hooks && "get" in hooks && (ret = hooks.get(elem, "value")) !== void 0) return ret;
				ret = elem.value;
				return ret == null ? "" : ret;
			}
			return;
		}
		valueIsFunction = typeof value === "function";
		return this.each(function(i) {
			var val;
			if (this.nodeType !== 1) return;
			if (valueIsFunction) val = value.call(this, i, jQuery(this).val());
			else val = value;
			if (val == null) val = "";
			else if (typeof val === "number") val += "";
			else if (Array.isArray(val)) val = jQuery.map(val, function(value) {
				return value == null ? "" : value + "";
			});
			hooks = jQuery.valHooks[this.type] || jQuery.valHooks[this.nodeName.toLowerCase()];
			if (!hooks || !("set" in hooks) || hooks.set(this, val, "value") === void 0) this.value = val;
		});
	} });
	jQuery.extend({ valHooks: { select: {
		get: function(elem) {
			var value, option, i, options = elem.options, index = elem.selectedIndex, one = elem.type === "select-one", values = one ? null : [], max = one ? index + 1 : options.length;
			if (index < 0) i = max;
			else i = one ? index : 0;
			for (; i < max; i++) {
				option = options[i];
				if (option.selected && !option.disabled && (!option.parentNode.disabled || !nodeName(option.parentNode, "optgroup"))) {
					value = jQuery(option).val();
					if (one) return value;
					values.push(value);
				}
			}
			return values;
		},
		set: function(elem, value) {
			var optionSet, option, options = elem.options, values = jQuery.makeArray(value), i = options.length;
			while (i--) {
				option = options[i];
				if (option.selected = jQuery.inArray(jQuery(option).val(), values) > -1) optionSet = true;
			}
			if (!optionSet) elem.selectedIndex = -1;
			return values;
		}
	} } });
	if (isIE) jQuery.valHooks.option = { get: function(elem) {
		var val = elem.getAttribute("value");
		return val != null ? val : stripAndCollapse(jQuery.text(elem));
	} };
	jQuery.each(["radio", "checkbox"], function() {
		jQuery.valHooks[this] = { set: function(elem, value) {
			if (Array.isArray(value)) return elem.checked = jQuery.inArray(jQuery(elem).val(), value) > -1;
		} };
	});
	var rfocusMorph = /^(?:focusinfocus|focusoutblur)$/, stopPropagationCallback = function(e) {
		e.stopPropagation();
	};
	jQuery.extend(jQuery.event, {
		trigger: function(event, data, elem, onlyHandlers) {
			var i, cur, tmp, bubbleType, ontype, handle, special, lastElement, eventPath = [elem || document$1], type = hasOwn.call(event, "type") ? event.type : event, namespaces = hasOwn.call(event, "namespace") ? event.namespace.split(".") : [];
			cur = lastElement = tmp = elem = elem || document$1;
			if (elem.nodeType === 3 || elem.nodeType === 8) return;
			if (rfocusMorph.test(type + jQuery.event.triggered)) return;
			if (type.indexOf(".") > -1) {
				namespaces = type.split(".");
				type = namespaces.shift();
				namespaces.sort();
			}
			ontype = type.indexOf(":") < 0 && "on" + type;
			event = event[jQuery.expando] ? event : new jQuery.Event(type, typeof event === "object" && event);
			event.isTrigger = onlyHandlers ? 2 : 3;
			event.namespace = namespaces.join(".");
			event.rnamespace = event.namespace ? new RegExp("(^|\\.)" + namespaces.join("\\.(?:.*\\.|)") + "(\\.|$)") : null;
			event.result = void 0;
			if (!event.target) event.target = elem;
			data = data == null ? [event] : jQuery.makeArray(data, [event]);
			special = jQuery.event.special[type] || {};
			if (!onlyHandlers && special.trigger && special.trigger.apply(elem, data) === false) return;
			if (!onlyHandlers && !special.noBubble && !isWindow(elem)) {
				bubbleType = special.delegateType || type;
				if (!rfocusMorph.test(bubbleType + type)) cur = cur.parentNode;
				for (; cur; cur = cur.parentNode) {
					eventPath.push(cur);
					tmp = cur;
				}
				if (tmp === (elem.ownerDocument || document$1)) eventPath.push(tmp.defaultView || tmp.parentWindow || window);
			}
			i = 0;
			while ((cur = eventPath[i++]) && !event.isPropagationStopped()) {
				lastElement = cur;
				event.type = i > 1 ? bubbleType : special.bindType || type;
				handle = (dataPriv.get(cur, "events") || Object.create(null))[event.type] && dataPriv.get(cur, "handle");
				if (handle) handle.apply(cur, data);
				handle = ontype && cur[ontype];
				if (handle && handle.apply && acceptData(cur)) {
					event.result = handle.apply(cur, data);
					if (event.result === false) event.preventDefault();
				}
			}
			event.type = type;
			if (!onlyHandlers && !event.isDefaultPrevented()) {
				if ((!special._default || special._default.apply(eventPath.pop(), data) === false) && acceptData(elem)) {
					if (ontype && typeof elem[type] === "function" && !isWindow(elem)) {
						tmp = elem[ontype];
						if (tmp) elem[ontype] = null;
						jQuery.event.triggered = type;
						if (event.isPropagationStopped()) lastElement.addEventListener(type, stopPropagationCallback);
						elem[type]();
						if (event.isPropagationStopped()) lastElement.removeEventListener(type, stopPropagationCallback);
						jQuery.event.triggered = void 0;
						if (tmp) elem[ontype] = tmp;
					}
				}
			}
			return event.result;
		},
		simulate: function(type, elem, event) {
			var e = jQuery.extend(new jQuery.Event(), event, {
				type,
				isSimulated: true
			});
			jQuery.event.trigger(e, null, elem);
		}
	});
	jQuery.fn.extend({
		trigger: function(type, data) {
			return this.each(function() {
				jQuery.event.trigger(type, data, this);
			});
		},
		triggerHandler: function(type, data) {
			var elem = this[0];
			if (elem) return jQuery.event.trigger(type, data, elem, true);
		}
	});
	var location = window.location;
	var nonce = { guid: Date.now() };
	var rquery = /\?/;
	jQuery.parseXML = function(data) {
		var xml, parserErrorElem;
		if (!data || typeof data !== "string") return null;
		try {
			xml = new window.DOMParser().parseFromString(data, "text/xml");
		} catch (e) {}
		parserErrorElem = xml && xml.getElementsByTagName("parsererror")[0];
		if (!xml || parserErrorElem) jQuery.error("Invalid XML: " + (parserErrorElem ? jQuery.map(parserErrorElem.childNodes, function(el) {
			return el.textContent;
		}).join("\n") : data));
		return xml;
	};
	var rbracket = /\[\]$/, rCRLF = /\r?\n/g, rsubmitterTypes = /^(?:submit|button|image|reset|file)$/i, rsubmittable = /^(?:input|select|textarea|keygen)/i;
	function buildParams(prefix, obj, traditional, add) {
		var name;
		if (Array.isArray(obj)) jQuery.each(obj, function(i, v) {
			if (traditional || rbracket.test(prefix)) add(prefix, v);
			else buildParams(prefix + "[" + (typeof v === "object" && v != null ? i : "") + "]", v, traditional, add);
		});
		else if (!traditional && toType(obj) === "object") for (name in obj) buildParams(prefix + "[" + name + "]", obj[name], traditional, add);
		else add(prefix, obj);
	}
	jQuery.param = function(a, traditional) {
		var prefix, s = [], add = function(key, valueOrFunction) {
			var value = typeof valueOrFunction === "function" ? valueOrFunction() : valueOrFunction;
			s[s.length] = encodeURIComponent(key) + "=" + encodeURIComponent(value == null ? "" : value);
		};
		if (a == null) return "";
		if (Array.isArray(a) || a.jquery && !jQuery.isPlainObject(a)) jQuery.each(a, function() {
			add(this.name, this.value);
		});
		else for (prefix in a) buildParams(prefix, a[prefix], traditional, add);
		return s.join("&");
	};
	jQuery.fn.extend({
		serialize: function() {
			return jQuery.param(this.serializeArray());
		},
		serializeArray: function() {
			return this.map(function() {
				var elements = jQuery.prop(this, "elements");
				return elements ? jQuery.makeArray(elements) : this;
			}).filter(function() {
				var type = this.type;
				return this.name && !jQuery(this).is(":disabled") && rsubmittable.test(this.nodeName) && !rsubmitterTypes.test(type) && (this.checked || !rcheckableType.test(type));
			}).map(function(_i, elem) {
				var val = jQuery(this).val();
				if (val == null) return null;
				if (Array.isArray(val)) return jQuery.map(val, function(val) {
					return {
						name: elem.name,
						value: val.replace(rCRLF, "\r\n")
					};
				});
				return {
					name: elem.name,
					value: val.replace(rCRLF, "\r\n")
				};
			}).get();
		}
	});
	var r20 = /%20/g, rhash = /#.*$/, rantiCache = /([?&])_=[^&]*/, rheaders = /^(.*?):[ \t]*([^\r\n]*)$/gm, rlocalProtocol = /^(?:about|app|app-storage|.+-extension|file|res|widget):$/, rnoContent = /^(?:GET|HEAD)$/, rprotocol = /^\/\//, prefilters = {}, transports = {}, allTypes = "*/".concat("*"), originAnchor = document$1.createElement("a");
	originAnchor.href = location.href;
	function addToPrefiltersOrTransports(structure) {
		return function(dataTypeExpression, func) {
			if (typeof dataTypeExpression !== "string") {
				func = dataTypeExpression;
				dataTypeExpression = "*";
			}
			var dataType, i = 0, dataTypes = dataTypeExpression.toLowerCase().match(rnothtmlwhite) || [];
			if (typeof func === "function") while (dataType = dataTypes[i++]) if (dataType[0] === "+") {
				dataType = dataType.slice(1) || "*";
				(structure[dataType] = structure[dataType] || []).unshift(func);
			} else (structure[dataType] = structure[dataType] || []).push(func);
		};
	}
	function inspectPrefiltersOrTransports(structure, options, originalOptions, jqXHR) {
		var inspected = {}, seekingTransport = structure === transports;
		function inspect(dataType) {
			var selected;
			inspected[dataType] = true;
			jQuery.each(structure[dataType] || [], function(_, prefilterOrFactory) {
				var dataTypeOrTransport = prefilterOrFactory(options, originalOptions, jqXHR);
				if (typeof dataTypeOrTransport === "string" && !seekingTransport && !inspected[dataTypeOrTransport]) {
					options.dataTypes.unshift(dataTypeOrTransport);
					inspect(dataTypeOrTransport);
					return false;
				} else if (seekingTransport) return !(selected = dataTypeOrTransport);
			});
			return selected;
		}
		return inspect(options.dataTypes[0]) || !inspected["*"] && inspect("*");
	}
	function ajaxExtend(target, src) {
		var key, deep, flatOptions = jQuery.ajaxSettings.flatOptions || {};
		for (key in src) if (src[key] !== void 0) (flatOptions[key] ? target : deep || (deep = {}))[key] = src[key];
		if (deep) jQuery.extend(true, target, deep);
		return target;
	}
	function ajaxHandleResponses(s, jqXHR, responses) {
		var ct, type, finalDataType, firstDataType, contents = s.contents, dataTypes = s.dataTypes;
		while (dataTypes[0] === "*") {
			dataTypes.shift();
			if (ct === void 0) ct = s.mimeType || jqXHR.getResponseHeader("Content-Type");
		}
		if (ct) {
			for (type in contents) if (contents[type] && contents[type].test(ct)) {
				dataTypes.unshift(type);
				break;
			}
		}
		if (dataTypes[0] in responses) finalDataType = dataTypes[0];
		else {
			for (type in responses) {
				if (!dataTypes[0] || s.converters[type + " " + dataTypes[0]]) {
					finalDataType = type;
					break;
				}
				if (!firstDataType) firstDataType = type;
			}
			finalDataType = finalDataType || firstDataType;
		}
		if (finalDataType) {
			if (finalDataType !== dataTypes[0]) dataTypes.unshift(finalDataType);
			return responses[finalDataType];
		}
	}
	function ajaxConvert(s, response, jqXHR, isSuccess) {
		var conv2, current, conv, tmp, prev, converters = {}, dataTypes = s.dataTypes.slice();
		if (dataTypes[1]) for (conv in s.converters) converters[conv.toLowerCase()] = s.converters[conv];
		current = dataTypes.shift();
		while (current) {
			if (s.responseFields[current]) jqXHR[s.responseFields[current]] = response;
			if (!prev && isSuccess && s.dataFilter) response = s.dataFilter(response, s.dataType);
			prev = current;
			current = dataTypes.shift();
			if (current) {
				if (current === "*") current = prev;
				else if (prev !== "*" && prev !== current) {
					conv = converters[prev + " " + current] || converters["* " + current];
					if (!conv) for (conv2 in converters) {
						tmp = conv2.split(" ");
						if (tmp[1] === current) {
							conv = converters[prev + " " + tmp[0]] || converters["* " + tmp[0]];
							if (conv) {
								if (conv === true) conv = converters[conv2];
								else if (converters[conv2] !== true) {
									current = tmp[0];
									dataTypes.unshift(tmp[1]);
								}
								break;
							}
						}
					}
					if (conv !== true) {
						if (conv && s.throws) response = conv(response);
						else try {
							response = conv(response);
						} catch (e) {
							return {
								state: "parsererror",
								error: conv ? e : "No conversion from " + prev + " to " + current
							};
						}
					}
				}
			}
		}
		return {
			state: "success",
			data: response
		};
	}
	jQuery.extend({
		active: 0,
		lastModified: {},
		etag: {},
		ajaxSettings: {
			url: location.href,
			type: "GET",
			isLocal: rlocalProtocol.test(location.protocol),
			global: true,
			processData: true,
			async: true,
			contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			accepts: {
				"*": allTypes,
				text: "text/plain",
				html: "text/html",
				xml: "application/xml, text/xml",
				json: "application/json, text/javascript"
			},
			contents: {
				xml: /\bxml\b/,
				html: /\bhtml/,
				json: /\bjson\b/
			},
			responseFields: {
				xml: "responseXML",
				text: "responseText",
				json: "responseJSON"
			},
			converters: {
				"* text": String,
				"text html": true,
				"text json": JSON.parse,
				"text xml": jQuery.parseXML
			},
			flatOptions: {
				url: true,
				context: true
			}
		},
		ajaxSetup: function(target, settings) {
			return settings ? ajaxExtend(ajaxExtend(target, jQuery.ajaxSettings), settings) : ajaxExtend(jQuery.ajaxSettings, target);
		},
		ajaxPrefilter: addToPrefiltersOrTransports(prefilters),
		ajaxTransport: addToPrefiltersOrTransports(transports),
		ajax: function(url, options) {
			if (typeof url === "object") {
				options = url;
				url = void 0;
			}
			options = options || {};
			var transport, cacheURL, responseHeadersString, responseHeaders, timeoutTimer, urlAnchor, completed, fireGlobals, i, uncached, s = jQuery.ajaxSetup({}, options), callbackContext = s.context || s, globalEventContext = s.context && (callbackContext.nodeType || callbackContext.jquery) ? jQuery(callbackContext) : jQuery.event, deferred = jQuery.Deferred(), completeDeferred = jQuery.Callbacks("once memory"), statusCode = s.statusCode || {}, requestHeaders = {}, requestHeadersNames = {}, strAbort = "canceled", jqXHR = {
				readyState: 0,
				getResponseHeader: function(key) {
					var match;
					if (completed) {
						if (!responseHeaders) {
							responseHeaders = {};
							while (match = rheaders.exec(responseHeadersString)) responseHeaders[match[1].toLowerCase() + " "] = (responseHeaders[match[1].toLowerCase() + " "] || []).concat(match[2]);
						}
						match = responseHeaders[key.toLowerCase() + " "];
					}
					return match == null ? null : match.join(", ");
				},
				getAllResponseHeaders: function() {
					return completed ? responseHeadersString : null;
				},
				setRequestHeader: function(name, value) {
					if (completed == null) {
						name = requestHeadersNames[name.toLowerCase()] = requestHeadersNames[name.toLowerCase()] || name;
						requestHeaders[name] = value;
					}
					return this;
				},
				overrideMimeType: function(type) {
					if (completed == null) s.mimeType = type;
					return this;
				},
				statusCode: function(map) {
					var code;
					if (map) {
						if (completed) jqXHR.always(map[jqXHR.status]);
						else for (code in map) statusCode[code] = [statusCode[code], map[code]];
					}
					return this;
				},
				abort: function(statusText) {
					var finalText = statusText || strAbort;
					if (transport) transport.abort(finalText);
					done(0, finalText);
					return this;
				}
			};
			deferred.promise(jqXHR);
			s.url = ((url || s.url || location.href) + "").replace(rprotocol, location.protocol + "//");
			s.type = options.method || options.type || s.method || s.type;
			s.dataTypes = (s.dataType || "*").toLowerCase().match(rnothtmlwhite) || [""];
			if (s.crossDomain == null) {
				urlAnchor = document$1.createElement("a");
				try {
					urlAnchor.href = s.url;
					urlAnchor.href = urlAnchor.href;
					s.crossDomain = originAnchor.protocol + "//" + originAnchor.host !== urlAnchor.protocol + "//" + urlAnchor.host;
				} catch (e) {
					s.crossDomain = true;
				}
			}
			inspectPrefiltersOrTransports(prefilters, s, options, jqXHR);
			if (s.data && s.processData && typeof s.data !== "string") s.data = jQuery.param(s.data, s.traditional);
			if (completed) return jqXHR;
			fireGlobals = jQuery.event && s.global;
			if (fireGlobals && jQuery.active++ === 0) jQuery.event.trigger("ajaxStart");
			s.type = s.type.toUpperCase();
			s.hasContent = !rnoContent.test(s.type);
			cacheURL = s.url.replace(rhash, "");
			if (!s.hasContent) {
				uncached = s.url.slice(cacheURL.length);
				if (s.data && (s.processData || typeof s.data === "string")) {
					cacheURL += (rquery.test(cacheURL) ? "&" : "?") + s.data;
					delete s.data;
				}
				if (s.cache === false) {
					cacheURL = cacheURL.replace(rantiCache, "$1");
					uncached = (rquery.test(cacheURL) ? "&" : "?") + "_=" + nonce.guid++ + uncached;
				}
				s.url = cacheURL + uncached;
			} else if (s.data && s.processData && (s.contentType || "").indexOf("application/x-www-form-urlencoded") === 0) s.data = s.data.replace(r20, "+");
			if (s.ifModified) {
				if (jQuery.lastModified[cacheURL]) jqXHR.setRequestHeader("If-Modified-Since", jQuery.lastModified[cacheURL]);
				if (jQuery.etag[cacheURL]) jqXHR.setRequestHeader("If-None-Match", jQuery.etag[cacheURL]);
			}
			if (s.data && s.hasContent && s.contentType !== false || options.contentType) jqXHR.setRequestHeader("Content-Type", s.contentType);
			jqXHR.setRequestHeader("Accept", s.dataTypes[0] && s.accepts[s.dataTypes[0]] ? s.accepts[s.dataTypes[0]] + (s.dataTypes[0] !== "*" ? ", " + allTypes + "; q=0.01" : "") : s.accepts["*"]);
			for (i in s.headers) jqXHR.setRequestHeader(i, s.headers[i]);
			if (s.beforeSend && (s.beforeSend.call(callbackContext, jqXHR, s) === false || completed)) return jqXHR.abort();
			strAbort = "abort";
			completeDeferred.add(s.complete);
			jqXHR.done(s.success);
			jqXHR.fail(s.error);
			transport = inspectPrefiltersOrTransports(transports, s, options, jqXHR);
			if (!transport) done(-1, "No Transport");
			else {
				jqXHR.readyState = 1;
				if (fireGlobals) globalEventContext.trigger("ajaxSend", [jqXHR, s]);
				if (completed) return jqXHR;
				if (s.async && s.timeout > 0) timeoutTimer = window.setTimeout(function() {
					jqXHR.abort("timeout");
				}, s.timeout);
				try {
					completed = false;
					transport.send(requestHeaders, done);
				} catch (e) {
					if (completed) throw e;
					done(-1, e);
				}
			}
			function done(status, nativeStatusText, responses, headers) {
				var isSuccess, success, error, response, modified, statusText = nativeStatusText;
				if (completed) return;
				completed = true;
				if (timeoutTimer) window.clearTimeout(timeoutTimer);
				transport = void 0;
				responseHeadersString = headers || "";
				jqXHR.readyState = status > 0 ? 4 : 0;
				isSuccess = status >= 200 && status < 300 || status === 304;
				if (responses) response = ajaxHandleResponses(s, jqXHR, responses);
				if (!isSuccess && jQuery.inArray("script", s.dataTypes) > -1 && jQuery.inArray("json", s.dataTypes) < 0) s.converters["text script"] = function() {};
				response = ajaxConvert(s, response, jqXHR, isSuccess);
				if (isSuccess) {
					if (s.ifModified) {
						modified = jqXHR.getResponseHeader("Last-Modified");
						if (modified) jQuery.lastModified[cacheURL] = modified;
						modified = jqXHR.getResponseHeader("etag");
						if (modified) jQuery.etag[cacheURL] = modified;
					}
					if (status === 204 || s.type === "HEAD") statusText = "nocontent";
					else if (status === 304) statusText = "notmodified";
					else {
						statusText = response.state;
						success = response.data;
						error = response.error;
						isSuccess = !error;
					}
				} else {
					error = statusText;
					if (status || !statusText) {
						statusText = "error";
						if (status < 0) status = 0;
					}
				}
				jqXHR.status = status;
				jqXHR.statusText = (nativeStatusText || statusText) + "";
				if (isSuccess) deferred.resolveWith(callbackContext, [
					success,
					statusText,
					jqXHR
				]);
				else deferred.rejectWith(callbackContext, [
					jqXHR,
					statusText,
					error
				]);
				jqXHR.statusCode(statusCode);
				statusCode = void 0;
				if (fireGlobals) globalEventContext.trigger(isSuccess ? "ajaxSuccess" : "ajaxError", [
					jqXHR,
					s,
					isSuccess ? success : error
				]);
				completeDeferred.fireWith(callbackContext, [jqXHR, statusText]);
				if (fireGlobals) {
					globalEventContext.trigger("ajaxComplete", [jqXHR, s]);
					if (!--jQuery.active) jQuery.event.trigger("ajaxStop");
				}
			}
			return jqXHR;
		},
		getJSON: function(url, data, callback) {
			return jQuery.get(url, data, callback, "json");
		},
		getScript: function(url, callback) {
			return jQuery.get(url, void 0, callback, "script");
		}
	});
	jQuery.each(["get", "post"], function(_i, method) {
		jQuery[method] = function(url, data, callback, type) {
			if (typeof data === "function" || data === null) {
				type = type || callback;
				callback = data;
				data = void 0;
			}
			return jQuery.ajax(jQuery.extend({
				url,
				type: method,
				dataType: type,
				data,
				success: callback
			}, jQuery.isPlainObject(url) && url));
		};
	});
	jQuery.ajaxPrefilter(function(s) {
		var i;
		for (i in s.headers) if (i.toLowerCase() === "content-type") s.contentType = s.headers[i] || "";
	});
	jQuery._evalUrl = function(url, options, doc) {
		return jQuery.ajax({
			url,
			type: "GET",
			dataType: "script",
			cache: true,
			async: false,
			global: false,
			scriptAttrs: options.crossOrigin ? { "crossOrigin": options.crossOrigin } : void 0,
			converters: { "text script": function() {} },
			dataFilter: function(response) {
				jQuery.globalEval(response, options, doc);
			}
		});
	};
	jQuery.fn.extend({
		wrapAll: function(html) {
			var wrap;
			if (this[0]) {
				if (typeof html === "function") html = html.call(this[0]);
				wrap = jQuery(html, this[0].ownerDocument).eq(0).clone(true);
				if (this[0].parentNode) wrap.insertBefore(this[0]);
				wrap.map(function() {
					var elem = this;
					while (elem.firstElementChild) elem = elem.firstElementChild;
					return elem;
				}).append(this);
			}
			return this;
		},
		wrapInner: function(html) {
			if (typeof html === "function") return this.each(function(i) {
				jQuery(this).wrapInner(html.call(this, i));
			});
			return this.each(function() {
				var self = jQuery(this), contents = self.contents();
				if (contents.length) contents.wrapAll(html);
				else self.append(html);
			});
		},
		wrap: function(html) {
			var htmlIsFunction = typeof html === "function";
			return this.each(function(i) {
				jQuery(this).wrapAll(htmlIsFunction ? html.call(this, i) : html);
			});
		},
		unwrap: function(selector) {
			this.parent(selector).not("body").each(function() {
				jQuery(this).replaceWith(this.childNodes);
			});
			return this;
		}
	});
	jQuery.expr.pseudos.hidden = function(elem) {
		return !jQuery.expr.pseudos.visible(elem);
	};
	jQuery.expr.pseudos.visible = function(elem) {
		return !!(elem.offsetWidth || elem.offsetHeight || elem.getClientRects().length);
	};
	jQuery.ajaxSettings.xhr = function() {
		return new window.XMLHttpRequest();
	};
	var xhrSuccessStatus = { 0: 200 };
	jQuery.ajaxTransport(function(options) {
		var callback;
		return {
			send: function(headers, complete) {
				var i, xhr = options.xhr();
				xhr.open(options.type, options.url, options.async, options.username, options.password);
				if (options.xhrFields) for (i in options.xhrFields) xhr[i] = options.xhrFields[i];
				if (options.mimeType && xhr.overrideMimeType) xhr.overrideMimeType(options.mimeType);
				if (!options.crossDomain && !headers["X-Requested-With"]) headers["X-Requested-With"] = "XMLHttpRequest";
				for (i in headers) xhr.setRequestHeader(i, headers[i]);
				callback = function(type) {
					return function() {
						if (callback) {
							callback = xhr.onload = xhr.onerror = xhr.onabort = xhr.ontimeout = null;
							if (type === "abort") xhr.abort();
							else if (type === "error") complete(xhr.status, xhr.statusText);
							else complete(xhrSuccessStatus[xhr.status] || xhr.status, xhr.statusText, (xhr.responseType || "text") === "text" ? { text: xhr.responseText } : { binary: xhr.response }, xhr.getAllResponseHeaders());
						}
					};
				};
				xhr.onload = callback();
				xhr.onabort = xhr.onerror = xhr.ontimeout = callback("error");
				callback = callback("abort");
				try {
					xhr.send(options.hasContent && options.data || null);
				} catch (e) {
					if (callback) throw e;
				}
			},
			abort: function() {
				if (callback) callback();
			}
		};
	});
	function canUseScriptTag(s) {
		return s.scriptAttrs || !s.headers && (s.crossDomain || s.async && jQuery.inArray("json", s.dataTypes) < 0);
	}
	jQuery.ajaxSetup({
		accepts: { script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript" },
		converters: { "text script": function(text) {
			jQuery.globalEval(text);
			return text;
		} }
	});
	jQuery.ajaxPrefilter("script", function(s) {
		if (s.cache === void 0) s.cache = false;
		if (canUseScriptTag(s)) s.type = "GET";
	});
	jQuery.ajaxTransport("script", function(s) {
		if (canUseScriptTag(s)) {
			var script, callback;
			return {
				send: function(_, complete) {
					script = jQuery("<script>").attr(s.scriptAttrs || {}).prop({
						charset: s.scriptCharset,
						src: s.url
					}).on("load error", callback = function(evt) {
						script.remove();
						callback = null;
						if (evt) complete(evt.type === "error" ? 404 : 200, evt.type);
					});
					document$1.head.appendChild(script[0]);
				},
				abort: function() {
					if (callback) callback();
				}
			};
		}
	});
	var oldCallbacks = [], rjsonp = /(=)\?(?=&|$)|\?\?/;
	jQuery.ajaxSetup({
		jsonp: "callback",
		jsonpCallback: function() {
			var callback = oldCallbacks.pop() || jQuery.expando + "_" + nonce.guid++;
			this[callback] = true;
			return callback;
		}
	});
	jQuery.ajaxPrefilter("jsonp", function(s, originalSettings, jqXHR) {
		var callbackName, overwritten, responseContainer, jsonProp = s.jsonp !== false && (rjsonp.test(s.url) ? "url" : typeof s.data === "string" && (s.contentType || "").indexOf("application/x-www-form-urlencoded") === 0 && rjsonp.test(s.data) && "data");
		callbackName = s.jsonpCallback = typeof s.jsonpCallback === "function" ? s.jsonpCallback() : s.jsonpCallback;
		if (jsonProp) s[jsonProp] = s[jsonProp].replace(rjsonp, "$1" + callbackName);
		else if (s.jsonp !== false) s.url += (rquery.test(s.url) ? "&" : "?") + s.jsonp + "=" + callbackName;
		s.converters["script json"] = function() {
			if (!responseContainer) jQuery.error(callbackName + " was not called");
			return responseContainer[0];
		};
		s.dataTypes[0] = "json";
		overwritten = window[callbackName];
		window[callbackName] = function() {
			responseContainer = arguments;
		};
		jqXHR.always(function() {
			if (overwritten === void 0) jQuery(window).removeProp(callbackName);
			else window[callbackName] = overwritten;
			if (s[callbackName]) {
				s.jsonpCallback = originalSettings.jsonpCallback;
				oldCallbacks.push(callbackName);
			}
			if (responseContainer && typeof overwritten === "function") overwritten(responseContainer[0]);
			responseContainer = overwritten = void 0;
		});
		return "script";
	});
	jQuery.ajaxPrefilter(function(s, origOptions) {
		if (typeof s.data !== "string" && !jQuery.isPlainObject(s.data) && !Array.isArray(s.data) && !("processData" in origOptions)) s.processData = false;
		if (s.data instanceof window.FormData) s.contentType = false;
	});
	jQuery.parseHTML = function(data, context, keepScripts) {
		if (typeof data !== "string" && !isObviousHtml(data + "")) return [];
		if (typeof context === "boolean") {
			keepScripts = context;
			context = false;
		}
		var parsed, scripts;
		if (!context) context = new window.DOMParser().parseFromString("", "text/html");
		parsed = rsingleTag.exec(data);
		scripts = !keepScripts && [];
		if (parsed) return [context.createElement(parsed[1])];
		parsed = buildFragment([data], context, scripts);
		if (scripts && scripts.length) jQuery(scripts).remove();
		return jQuery.merge([], parsed.childNodes);
	};
	/**
	* Load a url into a page
	*/
	jQuery.fn.load = function(url, params, callback) {
		var selector, type, response, self = this, off = url.indexOf(" ");
		if (off > -1) {
			selector = stripAndCollapse(url.slice(off));
			url = url.slice(0, off);
		}
		if (typeof params === "function") {
			callback = params;
			params = void 0;
		} else if (params && typeof params === "object") type = "POST";
		if (self.length > 0) jQuery.ajax({
			url,
			type: type || "GET",
			dataType: "html",
			data: params
		}).done(function(responseText) {
			response = arguments;
			self.html(selector ? jQuery("<div>").append(jQuery.parseHTML(responseText)).find(selector) : responseText);
		}).always(callback && function(jqXHR, status) {
			self.each(function() {
				callback.apply(this, response || [
					jqXHR.responseText,
					status,
					jqXHR
				]);
			});
		});
		return this;
	};
	jQuery.expr.pseudos.animated = function(elem) {
		return jQuery.grep(jQuery.timers, function(fn) {
			return elem === fn.elem;
		}).length;
	};
	jQuery.offset = { setOffset: function(elem, options, i) {
		var curPosition, curLeft, curCSSTop, curTop, curOffset, curCSSLeft, calculatePosition, position = jQuery.css(elem, "position"), curElem = jQuery(elem), props = {};
		if (position === "static") elem.style.position = "relative";
		curOffset = curElem.offset();
		curCSSTop = jQuery.css(elem, "top");
		curCSSLeft = jQuery.css(elem, "left");
		calculatePosition = (position === "absolute" || position === "fixed") && (curCSSTop + curCSSLeft).indexOf("auto") > -1;
		if (calculatePosition) {
			curPosition = curElem.position();
			curTop = curPosition.top;
			curLeft = curPosition.left;
		} else {
			curTop = parseFloat(curCSSTop) || 0;
			curLeft = parseFloat(curCSSLeft) || 0;
		}
		if (typeof options === "function") options = options.call(elem, i, jQuery.extend({}, curOffset));
		if (options.top != null) props.top = options.top - curOffset.top + curTop;
		if (options.left != null) props.left = options.left - curOffset.left + curLeft;
		if ("using" in options) options.using.call(elem, props);
		else curElem.css(props);
	} };
	jQuery.fn.extend({
		offset: function(options) {
			if (arguments.length) return options === void 0 ? this : this.each(function(i) {
				jQuery.offset.setOffset(this, options, i);
			});
			var rect, win, elem = this[0];
			if (!elem) return;
			if (!elem.getClientRects().length) return {
				top: 0,
				left: 0
			};
			rect = elem.getBoundingClientRect();
			win = elem.ownerDocument.defaultView;
			return {
				top: rect.top + win.pageYOffset,
				left: rect.left + win.pageXOffset
			};
		},
		position: function() {
			if (!this[0]) return;
			var offsetParent, offset, doc, elem = this[0], parentOffset = {
				top: 0,
				left: 0
			};
			if (jQuery.css(elem, "position") === "fixed") offset = elem.getBoundingClientRect();
			else {
				offset = this.offset();
				doc = elem.ownerDocument;
				offsetParent = elem.offsetParent || doc.documentElement;
				while (offsetParent && offsetParent !== doc.documentElement && jQuery.css(offsetParent, "position") === "static") offsetParent = offsetParent.offsetParent || doc.documentElement;
				if (offsetParent && offsetParent !== elem && offsetParent.nodeType === 1 && jQuery.css(offsetParent, "position") !== "static") {
					parentOffset = jQuery(offsetParent).offset();
					parentOffset.top += jQuery.css(offsetParent, "borderTopWidth", true);
					parentOffset.left += jQuery.css(offsetParent, "borderLeftWidth", true);
				}
			}
			return {
				top: offset.top - parentOffset.top - jQuery.css(elem, "marginTop", true),
				left: offset.left - parentOffset.left - jQuery.css(elem, "marginLeft", true)
			};
		},
		offsetParent: function() {
			return this.map(function() {
				var offsetParent = this.offsetParent;
				while (offsetParent && jQuery.css(offsetParent, "position") === "static") offsetParent = offsetParent.offsetParent;
				return offsetParent || documentElement$1;
			});
		}
	});
	jQuery.each({
		scrollLeft: "pageXOffset",
		scrollTop: "pageYOffset"
	}, function(method, prop) {
		var top = "pageYOffset" === prop;
		jQuery.fn[method] = function(val) {
			return access(this, function(elem, method, val) {
				var win;
				if (isWindow(elem)) win = elem;
				else if (elem.nodeType === 9) win = elem.defaultView;
				if (val === void 0) return win ? win[prop] : elem[method];
				if (win) win.scrollTo(!top ? val : win.pageXOffset, top ? val : win.pageYOffset);
				else elem[method] = val;
			}, method, val, arguments.length);
		};
	});
	jQuery.each({
		Height: "height",
		Width: "width"
	}, function(name, type) {
		jQuery.each({
			padding: "inner" + name,
			content: type,
			"": "outer" + name
		}, function(defaultExtra, funcName) {
			jQuery.fn[funcName] = function(margin, value) {
				var chainable = arguments.length && (defaultExtra || typeof margin !== "boolean"), extra = defaultExtra || (margin === true || value === true ? "margin" : "border");
				return access(this, function(elem, type, value) {
					var doc;
					if (isWindow(elem)) return funcName.indexOf("outer") === 0 ? elem["inner" + name] : elem.document.documentElement["client" + name];
					if (elem.nodeType === 9) {
						doc = elem.documentElement;
						return Math.max(elem.body["scroll" + name], doc["scroll" + name], elem.body["offset" + name], doc["offset" + name], doc["client" + name]);
					}
					return value === void 0 ? jQuery.css(elem, type, extra) : jQuery.style(elem, type, value, extra);
				}, type, chainable ? margin : void 0, chainable);
			};
		});
	});
	jQuery.each([
		"ajaxStart",
		"ajaxStop",
		"ajaxComplete",
		"ajaxError",
		"ajaxSuccess",
		"ajaxSend"
	], function(_i, type) {
		jQuery.fn[type] = function(fn) {
			return this.on(type, fn);
		};
	});
	jQuery.fn.extend({
		bind: function(types, data, fn) {
			return this.on(types, null, data, fn);
		},
		unbind: function(types, fn) {
			return this.off(types, null, fn);
		},
		delegate: function(selector, types, data, fn) {
			return this.on(types, selector, data, fn);
		},
		undelegate: function(selector, types, fn) {
			return arguments.length === 1 ? this.off(selector, "**") : this.off(types, selector || "**", fn);
		},
		hover: function(fnOver, fnOut) {
			return this.on("mouseenter", fnOver).on("mouseleave", fnOut || fnOver);
		}
	});
	jQuery.each("blur focus focusin focusout resize scroll click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup contextmenu".split(" "), function(_i, name) {
		jQuery.fn[name] = function(data, fn) {
			return arguments.length > 0 ? this.on(name, null, data, fn) : this.trigger(name);
		};
	});
	jQuery.proxy = function(fn, context) {
		var tmp, args, proxy;
		if (typeof context === "string") {
			tmp = fn[context];
			context = fn;
			fn = tmp;
		}
		if (typeof fn !== "function") return;
		args = slice.call(arguments, 2);
		proxy = function() {
			return fn.apply(context || this, args.concat(slice.call(arguments)));
		};
		proxy.guid = fn.guid = fn.guid || jQuery.guid++;
		return proxy;
	};
	jQuery.holdReady = function(hold) {
		if (hold) jQuery.readyWait++;
		else jQuery.ready(true);
	};
	jQuery.expr[":"] = jQuery.expr.filters = jQuery.expr.pseudos;
	if (typeof define === "function" && define.amd) define("jquery", [], function() {
		return jQuery;
	});
	var _jQuery = window.jQuery, _$ = window.$;
	jQuery.noConflict = function(deep) {
		if (window.$ === jQuery) window.$ = _$;
		if (deep && window.jQuery === jQuery) window.jQuery = _jQuery;
		return jQuery;
	};
	if (typeof noGlobal === "undefined") window.jQuery = window.$ = jQuery;
	return jQuery;
}
var jQuery = jQueryFactory(window, true);
//#endregion
export { jQuery as t };

//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoianF1ZXJ5Lm1vZHVsZS5qcyIsIm5hbWVzIjpbXSwic291cmNlcyI6WyIuLi8uLi9ub2RlX21vZHVsZXMvanF1ZXJ5L2Rpc3QtbW9kdWxlL2pxdWVyeS5tb2R1bGUuanMiXSwic291cmNlc0NvbnRlbnQiOlsiLyohXG4gKiBqUXVlcnkgSmF2YVNjcmlwdCBMaWJyYXJ5IHY0LjAuMFxuICogaHR0cHM6Ly9qcXVlcnkuY29tL1xuICpcbiAqIENvcHlyaWdodCBPcGVuSlMgRm91bmRhdGlvbiBhbmQgb3RoZXIgY29udHJpYnV0b3JzXG4gKiBSZWxlYXNlZCB1bmRlciB0aGUgTUlUIGxpY2Vuc2VcbiAqIGh0dHBzOi8vanF1ZXJ5LmNvbS9saWNlbnNlL1xuICpcbiAqIERhdGU6IDIwMjYtMDEtMThUMDA6MjBaXG4gKi9cbi8vIEZvciBFQ01BU2NyaXB0IG1vZHVsZSBlbnZpcm9ubWVudHMgd2hlcmUgYSBwcm9wZXIgYHdpbmRvd2Bcbi8vIGlzIHByZXNlbnQsIGV4ZWN1dGUgdGhlIGZhY3RvcnkgYW5kIGdldCBqUXVlcnkuXG5mdW5jdGlvbiBqUXVlcnlGYWN0b3J5KCB3aW5kb3csIG5vR2xvYmFsICkge1xuXG5pZiAoIHR5cGVvZiB3aW5kb3cgPT09IFwidW5kZWZpbmVkXCIgfHwgIXdpbmRvdy5kb2N1bWVudCApIHtcblx0dGhyb3cgbmV3IEVycm9yKCBcImpRdWVyeSByZXF1aXJlcyBhIHdpbmRvdyB3aXRoIGEgZG9jdW1lbnRcIiApO1xufVxuXG52YXIgYXJyID0gW107XG5cbnZhciBnZXRQcm90byA9IE9iamVjdC5nZXRQcm90b3R5cGVPZjtcblxudmFyIHNsaWNlID0gYXJyLnNsaWNlO1xuXG4vLyBTdXBwb3J0OiBJRSAxMStcbi8vIElFIGRvZXNuJ3QgaGF2ZSBBcnJheSNmbGF0OyBwcm92aWRlIGEgZmFsbGJhY2suXG52YXIgZmxhdCA9IGFyci5mbGF0ID8gZnVuY3Rpb24oIGFycmF5ICkge1xuXHRyZXR1cm4gYXJyLmZsYXQuY2FsbCggYXJyYXkgKTtcbn0gOiBmdW5jdGlvbiggYXJyYXkgKSB7XG5cdHJldHVybiBhcnIuY29uY2F0LmFwcGx5KCBbXSwgYXJyYXkgKTtcbn07XG5cbnZhciBwdXNoID0gYXJyLnB1c2g7XG5cbnZhciBpbmRleE9mID0gYXJyLmluZGV4T2Y7XG5cbi8vIFtbQ2xhc3NdXSAtPiB0eXBlIHBhaXJzXG52YXIgY2xhc3MydHlwZSA9IHt9O1xuXG52YXIgdG9TdHJpbmcgPSBjbGFzczJ0eXBlLnRvU3RyaW5nO1xuXG52YXIgaGFzT3duID0gY2xhc3MydHlwZS5oYXNPd25Qcm9wZXJ0eTtcblxudmFyIGZuVG9TdHJpbmcgPSBoYXNPd24udG9TdHJpbmc7XG5cbnZhciBPYmplY3RGdW5jdGlvblN0cmluZyA9IGZuVG9TdHJpbmcuY2FsbCggT2JqZWN0ICk7XG5cbi8vIEFsbCBzdXBwb3J0IHRlc3RzIGFyZSBkZWZpbmVkIGluIHRoZWlyIHJlc3BlY3RpdmUgbW9kdWxlcy5cbnZhciBzdXBwb3J0ID0ge307XG5cbmZ1bmN0aW9uIHRvVHlwZSggb2JqICkge1xuXHRpZiAoIG9iaiA9PSBudWxsICkge1xuXHRcdHJldHVybiBvYmogKyBcIlwiO1xuXHR9XG5cblx0cmV0dXJuIHR5cGVvZiBvYmogPT09IFwib2JqZWN0XCIgP1xuXHRcdGNsYXNzMnR5cGVbIHRvU3RyaW5nLmNhbGwoIG9iaiApIF0gfHwgXCJvYmplY3RcIiA6XG5cdFx0dHlwZW9mIG9iajtcbn1cblxuZnVuY3Rpb24gaXNXaW5kb3coIG9iaiApIHtcblx0cmV0dXJuIG9iaiAhPSBudWxsICYmIG9iaiA9PT0gb2JqLndpbmRvdztcbn1cblxuZnVuY3Rpb24gaXNBcnJheUxpa2UoIG9iaiApIHtcblxuXHR2YXIgbGVuZ3RoID0gISFvYmogJiYgb2JqLmxlbmd0aCxcblx0XHR0eXBlID0gdG9UeXBlKCBvYmogKTtcblxuXHRpZiAoIHR5cGVvZiBvYmogPT09IFwiZnVuY3Rpb25cIiB8fCBpc1dpbmRvdyggb2JqICkgKSB7XG5cdFx0cmV0dXJuIGZhbHNlO1xuXHR9XG5cblx0cmV0dXJuIHR5cGUgPT09IFwiYXJyYXlcIiB8fCBsZW5ndGggPT09IDAgfHxcblx0XHR0eXBlb2YgbGVuZ3RoID09PSBcIm51bWJlclwiICYmIGxlbmd0aCA+IDAgJiYgKCBsZW5ndGggLSAxICkgaW4gb2JqO1xufVxuXG52YXIgZG9jdW1lbnQkMSA9IHdpbmRvdy5kb2N1bWVudDtcblxudmFyIHByZXNlcnZlZFNjcmlwdEF0dHJpYnV0ZXMgPSB7XG5cdHR5cGU6IHRydWUsXG5cdHNyYzogdHJ1ZSxcblx0bm9uY2U6IHRydWUsXG5cdG5vTW9kdWxlOiB0cnVlXG59O1xuXG5mdW5jdGlvbiBET01FdmFsKCBjb2RlLCBub2RlLCBkb2MgKSB7XG5cdGRvYyA9IGRvYyB8fCBkb2N1bWVudCQxO1xuXG5cdHZhciBpLFxuXHRcdHNjcmlwdCA9IGRvYy5jcmVhdGVFbGVtZW50KCBcInNjcmlwdFwiICk7XG5cblx0c2NyaXB0LnRleHQgPSBjb2RlO1xuXHRmb3IgKCBpIGluIHByZXNlcnZlZFNjcmlwdEF0dHJpYnV0ZXMgKSB7XG5cdFx0aWYgKCBub2RlICYmIG5vZGVbIGkgXSApIHtcblx0XHRcdHNjcmlwdFsgaSBdID0gbm9kZVsgaSBdO1xuXHRcdH1cblx0fVxuXG5cdGlmICggZG9jLmhlYWQuYXBwZW5kQ2hpbGQoIHNjcmlwdCApLnBhcmVudE5vZGUgKSB7XG5cdFx0c2NyaXB0LnBhcmVudE5vZGUucmVtb3ZlQ2hpbGQoIHNjcmlwdCApO1xuXHR9XG59XG5cbnZhciB2ZXJzaW9uID0gXCI0LjAuMFwiLFxuXG5cdHJodG1sU3VmZml4ID0gL0hUTUwkL2ksXG5cblx0Ly8gRGVmaW5lIGEgbG9jYWwgY29weSBvZiBqUXVlcnlcblx0alF1ZXJ5ID0gZnVuY3Rpb24oIHNlbGVjdG9yLCBjb250ZXh0ICkge1xuXG5cdFx0Ly8gVGhlIGpRdWVyeSBvYmplY3QgaXMgYWN0dWFsbHkganVzdCB0aGUgaW5pdCBjb25zdHJ1Y3RvciAnZW5oYW5jZWQnXG5cdFx0Ly8gTmVlZCBpbml0IGlmIGpRdWVyeSBpcyBjYWxsZWQgKGp1c3QgYWxsb3cgZXJyb3IgdG8gYmUgdGhyb3duIGlmIG5vdCBpbmNsdWRlZClcblx0XHRyZXR1cm4gbmV3IGpRdWVyeS5mbi5pbml0KCBzZWxlY3RvciwgY29udGV4dCApO1xuXHR9O1xuXG5qUXVlcnkuZm4gPSBqUXVlcnkucHJvdG90eXBlID0ge1xuXG5cdC8vIFRoZSBjdXJyZW50IHZlcnNpb24gb2YgalF1ZXJ5IGJlaW5nIHVzZWRcblx0anF1ZXJ5OiB2ZXJzaW9uLFxuXG5cdGNvbnN0cnVjdG9yOiBqUXVlcnksXG5cblx0Ly8gVGhlIGRlZmF1bHQgbGVuZ3RoIG9mIGEgalF1ZXJ5IG9iamVjdCBpcyAwXG5cdGxlbmd0aDogMCxcblxuXHR0b0FycmF5OiBmdW5jdGlvbigpIHtcblx0XHRyZXR1cm4gc2xpY2UuY2FsbCggdGhpcyApO1xuXHR9LFxuXG5cdC8vIEdldCB0aGUgTnRoIGVsZW1lbnQgaW4gdGhlIG1hdGNoZWQgZWxlbWVudCBzZXQgT1Jcblx0Ly8gR2V0IHRoZSB3aG9sZSBtYXRjaGVkIGVsZW1lbnQgc2V0IGFzIGEgY2xlYW4gYXJyYXlcblx0Z2V0OiBmdW5jdGlvbiggbnVtICkge1xuXG5cdFx0Ly8gUmV0dXJuIGFsbCB0aGUgZWxlbWVudHMgaW4gYSBjbGVhbiBhcnJheVxuXHRcdGlmICggbnVtID09IG51bGwgKSB7XG5cdFx0XHRyZXR1cm4gc2xpY2UuY2FsbCggdGhpcyApO1xuXHRcdH1cblxuXHRcdC8vIFJldHVybiBqdXN0IHRoZSBvbmUgZWxlbWVudCBmcm9tIHRoZSBzZXRcblx0XHRyZXR1cm4gbnVtIDwgMCA/IHRoaXNbIG51bSArIHRoaXMubGVuZ3RoIF0gOiB0aGlzWyBudW0gXTtcblx0fSxcblxuXHQvLyBUYWtlIGFuIGFycmF5IG9mIGVsZW1lbnRzIGFuZCBwdXNoIGl0IG9udG8gdGhlIHN0YWNrXG5cdC8vIChyZXR1cm5pbmcgdGhlIG5ldyBtYXRjaGVkIGVsZW1lbnQgc2V0KVxuXHRwdXNoU3RhY2s6IGZ1bmN0aW9uKCBlbGVtcyApIHtcblxuXHRcdC8vIEJ1aWxkIGEgbmV3IGpRdWVyeSBtYXRjaGVkIGVsZW1lbnQgc2V0XG5cdFx0dmFyIHJldCA9IGpRdWVyeS5tZXJnZSggdGhpcy5jb25zdHJ1Y3RvcigpLCBlbGVtcyApO1xuXG5cdFx0Ly8gQWRkIHRoZSBvbGQgb2JqZWN0IG9udG8gdGhlIHN0YWNrIChhcyBhIHJlZmVyZW5jZSlcblx0XHRyZXQucHJldk9iamVjdCA9IHRoaXM7XG5cblx0XHQvLyBSZXR1cm4gdGhlIG5ld2x5LWZvcm1lZCBlbGVtZW50IHNldFxuXHRcdHJldHVybiByZXQ7XG5cdH0sXG5cblx0Ly8gRXhlY3V0ZSBhIGNhbGxiYWNrIGZvciBldmVyeSBlbGVtZW50IGluIHRoZSBtYXRjaGVkIHNldC5cblx0ZWFjaDogZnVuY3Rpb24oIGNhbGxiYWNrICkge1xuXHRcdHJldHVybiBqUXVlcnkuZWFjaCggdGhpcywgY2FsbGJhY2sgKTtcblx0fSxcblxuXHRtYXA6IGZ1bmN0aW9uKCBjYWxsYmFjayApIHtcblx0XHRyZXR1cm4gdGhpcy5wdXNoU3RhY2soIGpRdWVyeS5tYXAoIHRoaXMsIGZ1bmN0aW9uKCBlbGVtLCBpICkge1xuXHRcdFx0cmV0dXJuIGNhbGxiYWNrLmNhbGwoIGVsZW0sIGksIGVsZW0gKTtcblx0XHR9ICkgKTtcblx0fSxcblxuXHRzbGljZTogZnVuY3Rpb24oKSB7XG5cdFx0cmV0dXJuIHRoaXMucHVzaFN0YWNrKCBzbGljZS5hcHBseSggdGhpcywgYXJndW1lbnRzICkgKTtcblx0fSxcblxuXHRmaXJzdDogZnVuY3Rpb24oKSB7XG5cdFx0cmV0dXJuIHRoaXMuZXEoIDAgKTtcblx0fSxcblxuXHRsYXN0OiBmdW5jdGlvbigpIHtcblx0XHRyZXR1cm4gdGhpcy5lcSggLTEgKTtcblx0fSxcblxuXHRldmVuOiBmdW5jdGlvbigpIHtcblx0XHRyZXR1cm4gdGhpcy5wdXNoU3RhY2soIGpRdWVyeS5ncmVwKCB0aGlzLCBmdW5jdGlvbiggX2VsZW0sIGkgKSB7XG5cdFx0XHRyZXR1cm4gKCBpICsgMSApICUgMjtcblx0XHR9ICkgKTtcblx0fSxcblxuXHRvZGQ6IGZ1bmN0aW9uKCkge1xuXHRcdHJldHVybiB0aGlzLnB1c2hTdGFjayggalF1ZXJ5LmdyZXAoIHRoaXMsIGZ1bmN0aW9uKCBfZWxlbSwgaSApIHtcblx0XHRcdHJldHVybiBpICUgMjtcblx0XHR9ICkgKTtcblx0fSxcblxuXHRlcTogZnVuY3Rpb24oIGkgKSB7XG5cdFx0dmFyIGxlbiA9IHRoaXMubGVuZ3RoLFxuXHRcdFx0aiA9ICtpICsgKCBpIDwgMCA/IGxlbiA6IDAgKTtcblx0XHRyZXR1cm4gdGhpcy5wdXNoU3RhY2soIGogPj0gMCAmJiBqIDwgbGVuID8gWyB0aGlzWyBqIF0gXSA6IFtdICk7XG5cdH0sXG5cblx0ZW5kOiBmdW5jdGlvbigpIHtcblx0XHRyZXR1cm4gdGhpcy5wcmV2T2JqZWN0IHx8IHRoaXMuY29uc3RydWN0b3IoKTtcblx0fVxufTtcblxualF1ZXJ5LmV4dGVuZCA9IGpRdWVyeS5mbi5leHRlbmQgPSBmdW5jdGlvbigpIHtcblx0dmFyIG9wdGlvbnMsIG5hbWUsIHNyYywgY29weSwgY29weUlzQXJyYXksIGNsb25lLFxuXHRcdHRhcmdldCA9IGFyZ3VtZW50c1sgMCBdIHx8IHt9LFxuXHRcdGkgPSAxLFxuXHRcdGxlbmd0aCA9IGFyZ3VtZW50cy5sZW5ndGgsXG5cdFx0ZGVlcCA9IGZhbHNlO1xuXG5cdC8vIEhhbmRsZSBhIGRlZXAgY29weSBzaXR1YXRpb25cblx0aWYgKCB0eXBlb2YgdGFyZ2V0ID09PSBcImJvb2xlYW5cIiApIHtcblx0XHRkZWVwID0gdGFyZ2V0O1xuXG5cdFx0Ly8gU2tpcCB0aGUgYm9vbGVhbiBhbmQgdGhlIHRhcmdldFxuXHRcdHRhcmdldCA9IGFyZ3VtZW50c1sgaSBdIHx8IHt9O1xuXHRcdGkrKztcblx0fVxuXG5cdC8vIEhhbmRsZSBjYXNlIHdoZW4gdGFyZ2V0IGlzIGEgc3RyaW5nIG9yIHNvbWV0aGluZyAocG9zc2libGUgaW4gZGVlcCBjb3B5KVxuXHRpZiAoIHR5cGVvZiB0YXJnZXQgIT09IFwib2JqZWN0XCIgJiYgdHlwZW9mIHRhcmdldCAhPT0gXCJmdW5jdGlvblwiICkge1xuXHRcdHRhcmdldCA9IHt9O1xuXHR9XG5cblx0Ly8gRXh0ZW5kIGpRdWVyeSBpdHNlbGYgaWYgb25seSBvbmUgYXJndW1lbnQgaXMgcGFzc2VkXG5cdGlmICggaSA9PT0gbGVuZ3RoICkge1xuXHRcdHRhcmdldCA9IHRoaXM7XG5cdFx0aS0tO1xuXHR9XG5cblx0Zm9yICggOyBpIDwgbGVuZ3RoOyBpKysgKSB7XG5cblx0XHQvLyBPbmx5IGRlYWwgd2l0aCBub24tbnVsbC91bmRlZmluZWQgdmFsdWVzXG5cdFx0aWYgKCAoIG9wdGlvbnMgPSBhcmd1bWVudHNbIGkgXSApICE9IG51bGwgKSB7XG5cblx0XHRcdC8vIEV4dGVuZCB0aGUgYmFzZSBvYmplY3Rcblx0XHRcdGZvciAoIG5hbWUgaW4gb3B0aW9ucyApIHtcblx0XHRcdFx0Y29weSA9IG9wdGlvbnNbIG5hbWUgXTtcblxuXHRcdFx0XHQvLyBQcmV2ZW50IE9iamVjdC5wcm90b3R5cGUgcG9sbHV0aW9uXG5cdFx0XHRcdC8vIFByZXZlbnQgbmV2ZXItZW5kaW5nIGxvb3Bcblx0XHRcdFx0aWYgKCBuYW1lID09PSBcIl9fcHJvdG9fX1wiIHx8IHRhcmdldCA9PT0gY29weSApIHtcblx0XHRcdFx0XHRjb250aW51ZTtcblx0XHRcdFx0fVxuXG5cdFx0XHRcdC8vIFJlY3Vyc2UgaWYgd2UncmUgbWVyZ2luZyBwbGFpbiBvYmplY3RzIG9yIGFycmF5c1xuXHRcdFx0XHRpZiAoIGRlZXAgJiYgY29weSAmJiAoIGpRdWVyeS5pc1BsYWluT2JqZWN0KCBjb3B5ICkgfHxcblx0XHRcdFx0XHQoIGNvcHlJc0FycmF5ID0gQXJyYXkuaXNBcnJheSggY29weSApICkgKSApIHtcblx0XHRcdFx0XHRzcmMgPSB0YXJnZXRbIG5hbWUgXTtcblxuXHRcdFx0XHRcdC8vIEVuc3VyZSBwcm9wZXIgdHlwZSBmb3IgdGhlIHNvdXJjZSB2YWx1ZVxuXHRcdFx0XHRcdGlmICggY29weUlzQXJyYXkgJiYgIUFycmF5LmlzQXJyYXkoIHNyYyApICkge1xuXHRcdFx0XHRcdFx0Y2xvbmUgPSBbXTtcblx0XHRcdFx0XHR9IGVsc2UgaWYgKCAhY29weUlzQXJyYXkgJiYgIWpRdWVyeS5pc1BsYWluT2JqZWN0KCBzcmMgKSApIHtcblx0XHRcdFx0XHRcdGNsb25lID0ge307XG5cdFx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHRcdGNsb25lID0gc3JjO1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0XHRjb3B5SXNBcnJheSA9IGZhbHNlO1xuXG5cdFx0XHRcdFx0Ly8gTmV2ZXIgbW92ZSBvcmlnaW5hbCBvYmplY3RzLCBjbG9uZSB0aGVtXG5cdFx0XHRcdFx0dGFyZ2V0WyBuYW1lIF0gPSBqUXVlcnkuZXh0ZW5kKCBkZWVwLCBjbG9uZSwgY29weSApO1xuXG5cdFx0XHRcdC8vIERvbid0IGJyaW5nIGluIHVuZGVmaW5lZCB2YWx1ZXNcblx0XHRcdFx0fSBlbHNlIGlmICggY29weSAhPT0gdW5kZWZpbmVkICkge1xuXHRcdFx0XHRcdHRhcmdldFsgbmFtZSBdID0gY29weTtcblx0XHRcdFx0fVxuXHRcdFx0fVxuXHRcdH1cblx0fVxuXG5cdC8vIFJldHVybiB0aGUgbW9kaWZpZWQgb2JqZWN0XG5cdHJldHVybiB0YXJnZXQ7XG59O1xuXG5qUXVlcnkuZXh0ZW5kKCB7XG5cblx0Ly8gVW5pcXVlIGZvciBlYWNoIGNvcHkgb2YgalF1ZXJ5IG9uIHRoZSBwYWdlXG5cdGV4cGFuZG86IFwialF1ZXJ5XCIgKyAoIHZlcnNpb24gKyBNYXRoLnJhbmRvbSgpICkucmVwbGFjZSggL1xcRC9nLCBcIlwiICksXG5cblx0Ly8gQXNzdW1lIGpRdWVyeSBpcyByZWFkeSB3aXRob3V0IHRoZSByZWFkeSBtb2R1bGVcblx0aXNSZWFkeTogdHJ1ZSxcblxuXHRlcnJvcjogZnVuY3Rpb24oIG1zZyApIHtcblx0XHR0aHJvdyBuZXcgRXJyb3IoIG1zZyApO1xuXHR9LFxuXG5cdG5vb3A6IGZ1bmN0aW9uKCkge30sXG5cblx0aXNQbGFpbk9iamVjdDogZnVuY3Rpb24oIG9iaiApIHtcblx0XHR2YXIgcHJvdG8sIEN0b3I7XG5cblx0XHQvLyBEZXRlY3Qgb2J2aW91cyBuZWdhdGl2ZXNcblx0XHQvLyBVc2UgdG9TdHJpbmcgaW5zdGVhZCBvZiBqUXVlcnkudHlwZSB0byBjYXRjaCBob3N0IG9iamVjdHNcblx0XHRpZiAoICFvYmogfHwgdG9TdHJpbmcuY2FsbCggb2JqICkgIT09IFwiW29iamVjdCBPYmplY3RdXCIgKSB7XG5cdFx0XHRyZXR1cm4gZmFsc2U7XG5cdFx0fVxuXG5cdFx0cHJvdG8gPSBnZXRQcm90byggb2JqICk7XG5cblx0XHQvLyBPYmplY3RzIHdpdGggbm8gcHJvdG90eXBlIChlLmcuLCBgT2JqZWN0LmNyZWF0ZSggbnVsbCApYCkgYXJlIHBsYWluXG5cdFx0aWYgKCAhcHJvdG8gKSB7XG5cdFx0XHRyZXR1cm4gdHJ1ZTtcblx0XHR9XG5cblx0XHQvLyBPYmplY3RzIHdpdGggcHJvdG90eXBlIGFyZSBwbGFpbiBpZmYgdGhleSB3ZXJlIGNvbnN0cnVjdGVkIGJ5IGEgZ2xvYmFsIE9iamVjdCBmdW5jdGlvblxuXHRcdEN0b3IgPSBoYXNPd24uY2FsbCggcHJvdG8sIFwiY29uc3RydWN0b3JcIiApICYmIHByb3RvLmNvbnN0cnVjdG9yO1xuXHRcdHJldHVybiB0eXBlb2YgQ3RvciA9PT0gXCJmdW5jdGlvblwiICYmIGZuVG9TdHJpbmcuY2FsbCggQ3RvciApID09PSBPYmplY3RGdW5jdGlvblN0cmluZztcblx0fSxcblxuXHRpc0VtcHR5T2JqZWN0OiBmdW5jdGlvbiggb2JqICkge1xuXHRcdHZhciBuYW1lO1xuXG5cdFx0Zm9yICggbmFtZSBpbiBvYmogKSB7XG5cdFx0XHRyZXR1cm4gZmFsc2U7XG5cdFx0fVxuXHRcdHJldHVybiB0cnVlO1xuXHR9LFxuXG5cdC8vIEV2YWx1YXRlcyBhIHNjcmlwdCBpbiBhIHByb3ZpZGVkIGNvbnRleHQ7IGZhbGxzIGJhY2sgdG8gdGhlIGdsb2JhbCBvbmVcblx0Ly8gaWYgbm90IHNwZWNpZmllZC5cblx0Z2xvYmFsRXZhbDogZnVuY3Rpb24oIGNvZGUsIG9wdGlvbnMsIGRvYyApIHtcblx0XHRET01FdmFsKCBjb2RlLCB7IG5vbmNlOiBvcHRpb25zICYmIG9wdGlvbnMubm9uY2UgfSwgZG9jICk7XG5cdH0sXG5cblx0ZWFjaDogZnVuY3Rpb24oIG9iaiwgY2FsbGJhY2sgKSB7XG5cdFx0dmFyIGxlbmd0aCwgaSA9IDA7XG5cblx0XHRpZiAoIGlzQXJyYXlMaWtlKCBvYmogKSApIHtcblx0XHRcdGxlbmd0aCA9IG9iai5sZW5ndGg7XG5cdFx0XHRmb3IgKCA7IGkgPCBsZW5ndGg7IGkrKyApIHtcblx0XHRcdFx0aWYgKCBjYWxsYmFjay5jYWxsKCBvYmpbIGkgXSwgaSwgb2JqWyBpIF0gKSA9PT0gZmFsc2UgKSB7XG5cdFx0XHRcdFx0YnJlYWs7XG5cdFx0XHRcdH1cblx0XHRcdH1cblx0XHR9IGVsc2Uge1xuXHRcdFx0Zm9yICggaSBpbiBvYmogKSB7XG5cdFx0XHRcdGlmICggY2FsbGJhY2suY2FsbCggb2JqWyBpIF0sIGksIG9ialsgaSBdICkgPT09IGZhbHNlICkge1xuXHRcdFx0XHRcdGJyZWFrO1xuXHRcdFx0XHR9XG5cdFx0XHR9XG5cdFx0fVxuXG5cdFx0cmV0dXJuIG9iajtcblx0fSxcblxuXG5cdC8vIFJldHJpZXZlIHRoZSB0ZXh0IHZhbHVlIG9mIGFuIGFycmF5IG9mIERPTSBub2Rlc1xuXHR0ZXh0OiBmdW5jdGlvbiggZWxlbSApIHtcblx0XHR2YXIgbm9kZSxcblx0XHRcdHJldCA9IFwiXCIsXG5cdFx0XHRpID0gMCxcblx0XHRcdG5vZGVUeXBlID0gZWxlbS5ub2RlVHlwZTtcblxuXHRcdGlmICggIW5vZGVUeXBlICkge1xuXG5cdFx0XHQvLyBJZiBubyBub2RlVHlwZSwgdGhpcyBpcyBleHBlY3RlZCB0byBiZSBhbiBhcnJheVxuXHRcdFx0d2hpbGUgKCAoIG5vZGUgPSBlbGVtWyBpKysgXSApICkge1xuXG5cdFx0XHRcdC8vIERvIG5vdCB0cmF2ZXJzZSBjb21tZW50IG5vZGVzXG5cdFx0XHRcdHJldCArPSBqUXVlcnkudGV4dCggbm9kZSApO1xuXHRcdFx0fVxuXHRcdH1cblx0XHRpZiAoIG5vZGVUeXBlID09PSAxIHx8IG5vZGVUeXBlID09PSAxMSApIHtcblx0XHRcdHJldHVybiBlbGVtLnRleHRDb250ZW50O1xuXHRcdH1cblx0XHRpZiAoIG5vZGVUeXBlID09PSA5ICkge1xuXHRcdFx0cmV0dXJuIGVsZW0uZG9jdW1lbnRFbGVtZW50LnRleHRDb250ZW50O1xuXHRcdH1cblx0XHRpZiAoIG5vZGVUeXBlID09PSAzIHx8IG5vZGVUeXBlID09PSA0ICkge1xuXHRcdFx0cmV0dXJuIGVsZW0ubm9kZVZhbHVlO1xuXHRcdH1cblxuXHRcdC8vIERvIG5vdCBpbmNsdWRlIGNvbW1lbnQgb3IgcHJvY2Vzc2luZyBpbnN0cnVjdGlvbiBub2Rlc1xuXG5cdFx0cmV0dXJuIHJldDtcblx0fSxcblxuXG5cdC8vIHJlc3VsdHMgaXMgZm9yIGludGVybmFsIHVzYWdlIG9ubHlcblx0bWFrZUFycmF5OiBmdW5jdGlvbiggYXJyLCByZXN1bHRzICkge1xuXHRcdHZhciByZXQgPSByZXN1bHRzIHx8IFtdO1xuXG5cdFx0aWYgKCBhcnIgIT0gbnVsbCApIHtcblx0XHRcdGlmICggaXNBcnJheUxpa2UoIE9iamVjdCggYXJyICkgKSApIHtcblx0XHRcdFx0alF1ZXJ5Lm1lcmdlKCByZXQsXG5cdFx0XHRcdFx0dHlwZW9mIGFyciA9PT0gXCJzdHJpbmdcIiA/XG5cdFx0XHRcdFx0XHRbIGFyciBdIDogYXJyXG5cdFx0XHRcdCk7XG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRwdXNoLmNhbGwoIHJldCwgYXJyICk7XG5cdFx0XHR9XG5cdFx0fVxuXG5cdFx0cmV0dXJuIHJldDtcblx0fSxcblxuXHRpbkFycmF5OiBmdW5jdGlvbiggZWxlbSwgYXJyLCBpICkge1xuXHRcdHJldHVybiBhcnIgPT0gbnVsbCA/IC0xIDogaW5kZXhPZi5jYWxsKCBhcnIsIGVsZW0sIGkgKTtcblx0fSxcblxuXHRpc1hNTERvYzogZnVuY3Rpb24oIGVsZW0gKSB7XG5cdFx0dmFyIG5hbWVzcGFjZSA9IGVsZW0gJiYgZWxlbS5uYW1lc3BhY2VVUkksXG5cdFx0XHRkb2NFbGVtID0gZWxlbSAmJiAoIGVsZW0ub3duZXJEb2N1bWVudCB8fCBlbGVtICkuZG9jdW1lbnRFbGVtZW50O1xuXG5cdFx0Ly8gQXNzdW1lIEhUTUwgd2hlbiBkb2N1bWVudEVsZW1lbnQgZG9lc24ndCB5ZXQgZXhpc3QsIHN1Y2ggYXMgaW5zaWRlXG5cdFx0Ly8gZG9jdW1lbnQgZnJhZ21lbnRzLlxuXHRcdHJldHVybiAhcmh0bWxTdWZmaXgudGVzdCggbmFtZXNwYWNlIHx8IGRvY0VsZW0gJiYgZG9jRWxlbS5ub2RlTmFtZSB8fCBcIkhUTUxcIiApO1xuXHR9LFxuXG5cdC8vIE5vdGU6IGFuIGVsZW1lbnQgZG9lcyBub3QgY29udGFpbiBpdHNlbGZcblx0Y29udGFpbnM6IGZ1bmN0aW9uKCBhLCBiICkge1xuXHRcdHZhciBidXAgPSBiICYmIGIucGFyZW50Tm9kZTtcblxuXHRcdHJldHVybiBhID09PSBidXAgfHwgISEoIGJ1cCAmJiBidXAubm9kZVR5cGUgPT09IDEgJiYgKFxuXG5cdFx0XHQvLyBTdXBwb3J0OiBJRSA5IC0gMTErXG5cdFx0XHQvLyBJRSBkb2Vzbid0IGhhdmUgYGNvbnRhaW5zYCBvbiBTVkcuXG5cdFx0XHRhLmNvbnRhaW5zID9cblx0XHRcdFx0YS5jb250YWlucyggYnVwICkgOlxuXHRcdFx0XHRhLmNvbXBhcmVEb2N1bWVudFBvc2l0aW9uICYmIGEuY29tcGFyZURvY3VtZW50UG9zaXRpb24oIGJ1cCApICYgMTZcblx0XHQpICk7XG5cdH0sXG5cblx0bWVyZ2U6IGZ1bmN0aW9uKCBmaXJzdCwgc2Vjb25kICkge1xuXHRcdHZhciBsZW4gPSArc2Vjb25kLmxlbmd0aCxcblx0XHRcdGogPSAwLFxuXHRcdFx0aSA9IGZpcnN0Lmxlbmd0aDtcblxuXHRcdGZvciAoIDsgaiA8IGxlbjsgaisrICkge1xuXHRcdFx0Zmlyc3RbIGkrKyBdID0gc2Vjb25kWyBqIF07XG5cdFx0fVxuXG5cdFx0Zmlyc3QubGVuZ3RoID0gaTtcblxuXHRcdHJldHVybiBmaXJzdDtcblx0fSxcblxuXHRncmVwOiBmdW5jdGlvbiggZWxlbXMsIGNhbGxiYWNrLCBpbnZlcnQgKSB7XG5cdFx0dmFyIGNhbGxiYWNrSW52ZXJzZSxcblx0XHRcdG1hdGNoZXMgPSBbXSxcblx0XHRcdGkgPSAwLFxuXHRcdFx0bGVuZ3RoID0gZWxlbXMubGVuZ3RoLFxuXHRcdFx0Y2FsbGJhY2tFeHBlY3QgPSAhaW52ZXJ0O1xuXG5cdFx0Ly8gR28gdGhyb3VnaCB0aGUgYXJyYXksIG9ubHkgc2F2aW5nIHRoZSBpdGVtc1xuXHRcdC8vIHRoYXQgcGFzcyB0aGUgdmFsaWRhdG9yIGZ1bmN0aW9uXG5cdFx0Zm9yICggOyBpIDwgbGVuZ3RoOyBpKysgKSB7XG5cdFx0XHRjYWxsYmFja0ludmVyc2UgPSAhY2FsbGJhY2soIGVsZW1zWyBpIF0sIGkgKTtcblx0XHRcdGlmICggY2FsbGJhY2tJbnZlcnNlICE9PSBjYWxsYmFja0V4cGVjdCApIHtcblx0XHRcdFx0bWF0Y2hlcy5wdXNoKCBlbGVtc1sgaSBdICk7XG5cdFx0XHR9XG5cdFx0fVxuXG5cdFx0cmV0dXJuIG1hdGNoZXM7XG5cdH0sXG5cblx0Ly8gYXJnIGlzIGZvciBpbnRlcm5hbCB1c2FnZSBvbmx5XG5cdG1hcDogZnVuY3Rpb24oIGVsZW1zLCBjYWxsYmFjaywgYXJnICkge1xuXHRcdHZhciBsZW5ndGgsIHZhbHVlLFxuXHRcdFx0aSA9IDAsXG5cdFx0XHRyZXQgPSBbXTtcblxuXHRcdC8vIEdvIHRocm91Z2ggdGhlIGFycmF5LCB0cmFuc2xhdGluZyBlYWNoIG9mIHRoZSBpdGVtcyB0byB0aGVpciBuZXcgdmFsdWVzXG5cdFx0aWYgKCBpc0FycmF5TGlrZSggZWxlbXMgKSApIHtcblx0XHRcdGxlbmd0aCA9IGVsZW1zLmxlbmd0aDtcblx0XHRcdGZvciAoIDsgaSA8IGxlbmd0aDsgaSsrICkge1xuXHRcdFx0XHR2YWx1ZSA9IGNhbGxiYWNrKCBlbGVtc1sgaSBdLCBpLCBhcmcgKTtcblxuXHRcdFx0XHRpZiAoIHZhbHVlICE9IG51bGwgKSB7XG5cdFx0XHRcdFx0cmV0LnB1c2goIHZhbHVlICk7XG5cdFx0XHRcdH1cblx0XHRcdH1cblxuXHRcdC8vIEdvIHRocm91Z2ggZXZlcnkga2V5IG9uIHRoZSBvYmplY3QsXG5cdFx0fSBlbHNlIHtcblx0XHRcdGZvciAoIGkgaW4gZWxlbXMgKSB7XG5cdFx0XHRcdHZhbHVlID0gY2FsbGJhY2soIGVsZW1zWyBpIF0sIGksIGFyZyApO1xuXG5cdFx0XHRcdGlmICggdmFsdWUgIT0gbnVsbCApIHtcblx0XHRcdFx0XHRyZXQucHVzaCggdmFsdWUgKTtcblx0XHRcdFx0fVxuXHRcdFx0fVxuXHRcdH1cblxuXHRcdC8vIEZsYXR0ZW4gYW55IG5lc3RlZCBhcnJheXNcblx0XHRyZXR1cm4gZmxhdCggcmV0ICk7XG5cdH0sXG5cblx0Ly8gQSBnbG9iYWwgR1VJRCBjb3VudGVyIGZvciBvYmplY3RzXG5cdGd1aWQ6IDEsXG5cblx0Ly8galF1ZXJ5LnN1cHBvcnQgaXMgbm90IHVzZWQgaW4gQ29yZSBidXQgb3RoZXIgcHJvamVjdHMgYXR0YWNoIHRoZWlyXG5cdC8vIHByb3BlcnRpZXMgdG8gaXQgc28gaXQgbmVlZHMgdG8gZXhpc3QuXG5cdHN1cHBvcnQ6IHN1cHBvcnRcbn0gKTtcblxuaWYgKCB0eXBlb2YgU3ltYm9sID09PSBcImZ1bmN0aW9uXCIgKSB7XG5cdGpRdWVyeS5mblsgU3ltYm9sLml0ZXJhdG9yIF0gPSBhcnJbIFN5bWJvbC5pdGVyYXRvciBdO1xufVxuXG4vLyBQb3B1bGF0ZSB0aGUgY2xhc3MydHlwZSBtYXBcbmpRdWVyeS5lYWNoKCBcIkJvb2xlYW4gTnVtYmVyIFN0cmluZyBGdW5jdGlvbiBBcnJheSBEYXRlIFJlZ0V4cCBPYmplY3QgRXJyb3IgU3ltYm9sXCIuc3BsaXQoIFwiIFwiICksXG5cdGZ1bmN0aW9uKCBfaSwgbmFtZSApIHtcblx0XHRjbGFzczJ0eXBlWyBcIltvYmplY3QgXCIgKyBuYW1lICsgXCJdXCIgXSA9IG5hbWUudG9Mb3dlckNhc2UoKTtcblx0fSApO1xuXG5mdW5jdGlvbiBub2RlTmFtZSggZWxlbSwgbmFtZSApIHtcblx0cmV0dXJuIGVsZW0ubm9kZU5hbWUgJiYgZWxlbS5ub2RlTmFtZS50b0xvd2VyQ2FzZSgpID09PSBuYW1lLnRvTG93ZXJDYXNlKCk7XG59XG5cbnZhciBwb3AgPSBhcnIucG9wO1xuXG4vLyBodHRwczovL3d3dy53My5vcmcvVFIvY3NzMy1zZWxlY3RvcnMvI3doaXRlc3BhY2VcbnZhciB3aGl0ZXNwYWNlID0gXCJbXFxcXHgyMFxcXFx0XFxcXHJcXFxcblxcXFxmXVwiO1xuXG52YXIgaXNJRSA9IGRvY3VtZW50JDEuZG9jdW1lbnRNb2RlO1xuXG52YXIgcmJ1Z2d5UVNBID0gaXNJRSAmJiBuZXcgUmVnRXhwKFxuXG5cdC8vIFN1cHBvcnQ6IElFIDkgLSAxMStcblx0Ly8gSUUncyA6ZGlzYWJsZWQgc2VsZWN0b3IgZG9lcyBub3QgcGljayB1cCB0aGUgY2hpbGRyZW4gb2YgZGlzYWJsZWQgZmllbGRzZXRzXG5cdFwiOmVuYWJsZWR8OmRpc2FibGVkfFwiICtcblxuXHQvLyBTdXBwb3J0OiBJRSAxMStcblx0Ly8gSUUgMTEgZG9lc24ndCBmaW5kIGVsZW1lbnRzIG9uIGEgYFtuYW1lPScnXWAgcXVlcnkgaW4gc29tZSBjYXNlcy5cblx0Ly8gQWRkaW5nIGEgdGVtcG9yYXJ5IGF0dHJpYnV0ZSB0byB0aGUgZG9jdW1lbnQgYmVmb3JlIHRoZSBzZWxlY3Rpb24gd29ya3Ncblx0Ly8gYXJvdW5kIHRoZSBpc3N1ZS5cblx0XCJcXFxcW1wiICsgd2hpdGVzcGFjZSArIFwiKm5hbWVcIiArIHdoaXRlc3BhY2UgKyBcIio9XCIgK1xuXHR3aGl0ZXNwYWNlICsgXCIqKD86Jyd8XFxcIlxcXCIpXCJcblxuKTtcblxudmFyIHJ0cmltQ1NTID0gbmV3IFJlZ0V4cChcblx0XCJeXCIgKyB3aGl0ZXNwYWNlICsgXCIrfCgoPzpefFteXFxcXFxcXFxdKSg/OlxcXFxcXFxcLikqKVwiICsgd2hpdGVzcGFjZSArIFwiKyRcIixcblx0XCJnXCJcbik7XG5cbi8vIGh0dHBzOi8vd3d3LnczLm9yZy9UUi9jc3Mtc3ludGF4LTMvI2lkZW50LXRva2VuLWRpYWdyYW1cbnZhciBpZGVudGlmaWVyID0gXCIoPzpcXFxcXFxcXFtcXFxcZGEtZkEtRl17MSw2fVwiICsgd2hpdGVzcGFjZSArXG5cdFwiP3xcXFxcXFxcXFteXFxcXHJcXFxcblxcXFxmXXxbXFxcXHctXXxbXlxcMC1cXFxceDdmXSkrXCI7XG5cbnZhciBybGVhZGluZ0NvbWJpbmF0b3IgPSBuZXcgUmVnRXhwKCBcIl5cIiArIHdoaXRlc3BhY2UgKyBcIiooWz4rfl18XCIgK1xuXHR3aGl0ZXNwYWNlICsgXCIpXCIgKyB3aGl0ZXNwYWNlICsgXCIqXCIgKTtcblxudmFyIHJkZXNjZW5kID0gbmV3IFJlZ0V4cCggd2hpdGVzcGFjZSArIFwifD5cIiApO1xuXG52YXIgcnNpYmxpbmcgPSAvWyt+XS87XG5cbnZhciBkb2N1bWVudEVsZW1lbnQkMSA9IGRvY3VtZW50JDEuZG9jdW1lbnRFbGVtZW50O1xuXG4vLyBTdXBwb3J0OiBJRSA5IC0gMTErXG4vLyBJRSByZXF1aXJlcyBhIHByZWZpeC5cbnZhciBtYXRjaGVzID0gZG9jdW1lbnRFbGVtZW50JDEubWF0Y2hlcyB8fCBkb2N1bWVudEVsZW1lbnQkMS5tc01hdGNoZXNTZWxlY3RvcjtcblxuLyoqXG4gKiBDcmVhdGUga2V5LXZhbHVlIGNhY2hlcyBvZiBsaW1pdGVkIHNpemVcbiAqIEByZXR1cm5zIHtmdW5jdGlvbihzdHJpbmcsIG9iamVjdCl9IFJldHVybnMgdGhlIE9iamVjdCBkYXRhIGFmdGVyIHN0b3JpbmcgaXQgb24gaXRzZWxmIHdpdGhcbiAqXHRwcm9wZXJ0eSBuYW1lIHRoZSAoc3BhY2Utc3VmZml4ZWQpIHN0cmluZyBhbmQgKGlmIHRoZSBjYWNoZSBpcyBsYXJnZXIgdGhhbiBFeHByLmNhY2hlTGVuZ3RoKVxuICpcdGRlbGV0aW5nIHRoZSBvbGRlc3QgZW50cnlcbiAqL1xuZnVuY3Rpb24gY3JlYXRlQ2FjaGUoKSB7XG5cdHZhciBrZXlzID0gW107XG5cblx0ZnVuY3Rpb24gY2FjaGUoIGtleSwgdmFsdWUgKSB7XG5cblx0XHQvLyBVc2UgKGtleSArIFwiIFwiKSB0byBhdm9pZCBjb2xsaXNpb24gd2l0aCBuYXRpdmUgcHJvdG90eXBlIHByb3BlcnRpZXNcblx0XHQvLyAoc2VlIGh0dHBzOi8vZ2l0aHViLmNvbS9qcXVlcnkvc2l6emxlL2lzc3Vlcy8xNTcpXG5cdFx0aWYgKCBrZXlzLnB1c2goIGtleSArIFwiIFwiICkgPiBqUXVlcnkuZXhwci5jYWNoZUxlbmd0aCApIHtcblxuXHRcdFx0Ly8gT25seSBrZWVwIHRoZSBtb3N0IHJlY2VudCBlbnRyaWVzXG5cdFx0XHRkZWxldGUgY2FjaGVbIGtleXMuc2hpZnQoKSBdO1xuXHRcdH1cblx0XHRyZXR1cm4gKCBjYWNoZVsga2V5ICsgXCIgXCIgXSA9IHZhbHVlICk7XG5cdH1cblx0cmV0dXJuIGNhY2hlO1xufVxuXG4vKipcbiAqIENoZWNrcyBhIG5vZGUgZm9yIHZhbGlkaXR5IGFzIGEgalF1ZXJ5IHNlbGVjdG9yIGNvbnRleHRcbiAqIEBwYXJhbSB7RWxlbWVudHxPYmplY3Q9fSBjb250ZXh0XG4gKiBAcmV0dXJucyB7RWxlbWVudHxPYmplY3R8Qm9vbGVhbn0gVGhlIGlucHV0IG5vZGUgaWYgYWNjZXB0YWJsZSwgb3RoZXJ3aXNlIGEgZmFsc3kgdmFsdWVcbiAqL1xuZnVuY3Rpb24gdGVzdENvbnRleHQoIGNvbnRleHQgKSB7XG5cdHJldHVybiBjb250ZXh0ICYmIHR5cGVvZiBjb250ZXh0LmdldEVsZW1lbnRzQnlUYWdOYW1lICE9PSBcInVuZGVmaW5lZFwiICYmIGNvbnRleHQ7XG59XG5cbi8vIEF0dHJpYnV0ZSBzZWxlY3RvcnM6IGh0dHBzOi8vd3d3LnczLm9yZy9UUi9zZWxlY3RvcnMvI2F0dHJpYnV0ZS1zZWxlY3RvcnNcbnZhciBhdHRyaWJ1dGVzID0gXCJcXFxcW1wiICsgd2hpdGVzcGFjZSArIFwiKihcIiArIGlkZW50aWZpZXIgKyBcIikoPzpcIiArIHdoaXRlc3BhY2UgK1xuXG5cdC8vIE9wZXJhdG9yIChjYXB0dXJlIDIpXG5cdFwiKihbKl4kfCF+XT89KVwiICsgd2hpdGVzcGFjZSArXG5cblx0Ly8gXCJBdHRyaWJ1dGUgdmFsdWVzIG11c3QgYmUgQ1NTIGlkZW50aWZpZXJzIFtjYXB0dXJlIDVdIG9yIHN0cmluZ3MgW2NhcHR1cmUgMyBvciBjYXB0dXJlIDRdXCJcblx0XCIqKD86JygoPzpcXFxcXFxcXC58W15cXFxcXFxcXCddKSopJ3xcXFwiKCg/OlxcXFxcXFxcLnxbXlxcXFxcXFxcXFxcIl0pKilcXFwifChcIiArIGlkZW50aWZpZXIgKyBcIikpfClcIiArXG5cdHdoaXRlc3BhY2UgKyBcIipcXFxcXVwiO1xuXG52YXIgcHNldWRvcyA9IFwiOihcIiArIGlkZW50aWZpZXIgKyBcIikoPzpcXFxcKChcIiArXG5cblx0Ly8gVG8gcmVkdWNlIHRoZSBudW1iZXIgb2Ygc2VsZWN0b3JzIG5lZWRpbmcgdG9rZW5pemUgaW4gdGhlIHByZUZpbHRlciwgcHJlZmVyIGFyZ3VtZW50czpcblx0Ly8gMS4gcXVvdGVkIChjYXB0dXJlIDM7IGNhcHR1cmUgNCBvciBjYXB0dXJlIDUpXG5cdFwiKCcoKD86XFxcXFxcXFwufFteXFxcXFxcXFwnXSkqKSd8XFxcIigoPzpcXFxcXFxcXC58W15cXFxcXFxcXFxcXCJdKSopXFxcIil8XCIgK1xuXG5cdC8vIDIuIHNpbXBsZSAoY2FwdHVyZSA2KVxuXHRcIigoPzpcXFxcXFxcXC58W15cXFxcXFxcXCgpW1xcXFxdXXxcIiArIGF0dHJpYnV0ZXMgKyBcIikqKXxcIiArXG5cblx0Ly8gMy4gYW55dGhpbmcgZWxzZSAoY2FwdHVyZSAyKVxuXHRcIi4qXCIgK1xuXHRcIilcXFxcKXwpXCI7XG5cbnZhciBmaWx0ZXJNYXRjaEV4cHIgPSB7XG5cdElEOiBuZXcgUmVnRXhwKCBcIl4jKFwiICsgaWRlbnRpZmllciArIFwiKVwiICksXG5cdENMQVNTOiBuZXcgUmVnRXhwKCBcIl5cXFxcLihcIiArIGlkZW50aWZpZXIgKyBcIilcIiApLFxuXHRUQUc6IG5ldyBSZWdFeHAoIFwiXihcIiArIGlkZW50aWZpZXIgKyBcInxbKl0pXCIgKSxcblx0QVRUUjogbmV3IFJlZ0V4cCggXCJeXCIgKyBhdHRyaWJ1dGVzICksXG5cdFBTRVVETzogbmV3IFJlZ0V4cCggXCJeXCIgKyBwc2V1ZG9zICksXG5cdENISUxEOiBuZXcgUmVnRXhwKFxuXHRcdFwiXjoob25seXxmaXJzdHxsYXN0fG50aHxudGgtbGFzdCktKGNoaWxkfG9mLXR5cGUpKD86XFxcXChcIiArXG5cdFx0d2hpdGVzcGFjZSArIFwiKihldmVufG9kZHwoKFsrLV18KShcXFxcZCopbnwpXCIgKyB3aGl0ZXNwYWNlICsgXCIqKD86KFsrLV18KVwiICtcblx0XHR3aGl0ZXNwYWNlICsgXCIqKFxcXFxkKyl8KSlcIiArIHdoaXRlc3BhY2UgKyBcIipcXFxcKXwpXCIsIFwiaVwiIClcbn07XG5cbnZhciBycHNldWRvID0gbmV3IFJlZ0V4cCggcHNldWRvcyApO1xuXG4vLyBDU1MgZXNjYXBlc1xuLy8gaHR0cHM6Ly93d3cudzMub3JnL1RSL0NTUzIxL3N5bmRhdGEuaHRtbCNlc2NhcGVkLWNoYXJhY3RlcnNcblxudmFyIHJ1bmVzY2FwZSA9IG5ldyBSZWdFeHAoIFwiXFxcXFxcXFxbXFxcXGRhLWZBLUZdezEsNn1cIiArIHdoaXRlc3BhY2UgK1xuXHRcIj98XFxcXFxcXFwoW15cXFxcclxcXFxuXFxcXGZdKVwiLCBcImdcIiApLFxuXHRmdW5lc2NhcGUgPSBmdW5jdGlvbiggZXNjYXBlLCBub25IZXggKSB7XG5cdFx0dmFyIGhpZ2ggPSBcIjB4XCIgKyBlc2NhcGUuc2xpY2UoIDEgKSAtIDB4MTAwMDA7XG5cblx0XHRpZiAoIG5vbkhleCApIHtcblxuXHRcdFx0Ly8gU3RyaXAgdGhlIGJhY2tzbGFzaCBwcmVmaXggZnJvbSBhIG5vbi1oZXggZXNjYXBlIHNlcXVlbmNlXG5cdFx0XHRyZXR1cm4gbm9uSGV4O1xuXHRcdH1cblxuXHRcdC8vIFJlcGxhY2UgYSBoZXhhZGVjaW1hbCBlc2NhcGUgc2VxdWVuY2Ugd2l0aCB0aGUgZW5jb2RlZCBVbmljb2RlIGNvZGUgcG9pbnRcblx0XHQvLyBTdXBwb3J0OiBJRSA8PTExK1xuXHRcdC8vIEZvciB2YWx1ZXMgb3V0c2lkZSB0aGUgQmFzaWMgTXVsdGlsaW5ndWFsIFBsYW5lIChCTVApLCBtYW51YWxseSBjb25zdHJ1Y3QgYVxuXHRcdC8vIHN1cnJvZ2F0ZSBwYWlyXG5cdFx0cmV0dXJuIGhpZ2ggPCAwID9cblx0XHRcdFN0cmluZy5mcm9tQ2hhckNvZGUoIGhpZ2ggKyAweDEwMDAwICkgOlxuXHRcdFx0U3RyaW5nLmZyb21DaGFyQ29kZSggaGlnaCA+PiAxMCB8IDB4RDgwMCwgaGlnaCAmIDB4M0ZGIHwgMHhEQzAwICk7XG5cdH07XG5cbmZ1bmN0aW9uIHVuZXNjYXBlU2VsZWN0b3IoIHNlbCApIHtcblx0cmV0dXJuIHNlbC5yZXBsYWNlKCBydW5lc2NhcGUsIGZ1bmVzY2FwZSApO1xufVxuXG5mdW5jdGlvbiBzZWxlY3RvckVycm9yKCBtc2cgKSB7XG5cdGpRdWVyeS5lcnJvciggXCJTeW50YXggZXJyb3IsIHVucmVjb2duaXplZCBleHByZXNzaW9uOiBcIiArIG1zZyApO1xufVxuXG52YXIgcmNvbW1hID0gbmV3IFJlZ0V4cCggXCJeXCIgKyB3aGl0ZXNwYWNlICsgXCIqLFwiICsgd2hpdGVzcGFjZSArIFwiKlwiICk7XG5cbnZhciB0b2tlbkNhY2hlID0gY3JlYXRlQ2FjaGUoKTtcblxuZnVuY3Rpb24gdG9rZW5pemUoIHNlbGVjdG9yLCBwYXJzZU9ubHkgKSB7XG5cdHZhciBtYXRjaGVkLCBtYXRjaCwgdG9rZW5zLCB0eXBlLFxuXHRcdHNvRmFyLCBncm91cHMsIHByZUZpbHRlcnMsXG5cdFx0Y2FjaGVkID0gdG9rZW5DYWNoZVsgc2VsZWN0b3IgKyBcIiBcIiBdO1xuXG5cdGlmICggY2FjaGVkICkge1xuXHRcdHJldHVybiBwYXJzZU9ubHkgPyAwIDogY2FjaGVkLnNsaWNlKCAwICk7XG5cdH1cblxuXHRzb0ZhciA9IHNlbGVjdG9yO1xuXHRncm91cHMgPSBbXTtcblx0cHJlRmlsdGVycyA9IGpRdWVyeS5leHByLnByZUZpbHRlcjtcblxuXHR3aGlsZSAoIHNvRmFyICkge1xuXG5cdFx0Ly8gQ29tbWEgYW5kIGZpcnN0IHJ1blxuXHRcdGlmICggIW1hdGNoZWQgfHwgKCBtYXRjaCA9IHJjb21tYS5leGVjKCBzb0ZhciApICkgKSB7XG5cdFx0XHRpZiAoIG1hdGNoICkge1xuXG5cdFx0XHRcdC8vIERvbid0IGNvbnN1bWUgdHJhaWxpbmcgY29tbWFzIGFzIHZhbGlkXG5cdFx0XHRcdHNvRmFyID0gc29GYXIuc2xpY2UoIG1hdGNoWyAwIF0ubGVuZ3RoICkgfHwgc29GYXI7XG5cdFx0XHR9XG5cdFx0XHRncm91cHMucHVzaCggKCB0b2tlbnMgPSBbXSApICk7XG5cdFx0fVxuXG5cdFx0bWF0Y2hlZCA9IGZhbHNlO1xuXG5cdFx0Ly8gQ29tYmluYXRvcnNcblx0XHRpZiAoICggbWF0Y2ggPSBybGVhZGluZ0NvbWJpbmF0b3IuZXhlYyggc29GYXIgKSApICkge1xuXHRcdFx0bWF0Y2hlZCA9IG1hdGNoLnNoaWZ0KCk7XG5cdFx0XHR0b2tlbnMucHVzaCgge1xuXHRcdFx0XHR2YWx1ZTogbWF0Y2hlZCxcblxuXHRcdFx0XHQvLyBDYXN0IGRlc2NlbmRhbnQgY29tYmluYXRvcnMgdG8gc3BhY2Vcblx0XHRcdFx0dHlwZTogbWF0Y2hbIDAgXS5yZXBsYWNlKCBydHJpbUNTUywgXCIgXCIgKVxuXHRcdFx0fSApO1xuXHRcdFx0c29GYXIgPSBzb0Zhci5zbGljZSggbWF0Y2hlZC5sZW5ndGggKTtcblx0XHR9XG5cblx0XHQvLyBGaWx0ZXJzXG5cdFx0Zm9yICggdHlwZSBpbiBmaWx0ZXJNYXRjaEV4cHIgKSB7XG5cdFx0XHRpZiAoICggbWF0Y2ggPSBqUXVlcnkuZXhwci5tYXRjaFsgdHlwZSBdLmV4ZWMoIHNvRmFyICkgKSAmJiAoICFwcmVGaWx0ZXJzWyB0eXBlIF0gfHxcblx0XHRcdFx0KCBtYXRjaCA9IHByZUZpbHRlcnNbIHR5cGUgXSggbWF0Y2ggKSApICkgKSB7XG5cdFx0XHRcdG1hdGNoZWQgPSBtYXRjaC5zaGlmdCgpO1xuXHRcdFx0XHR0b2tlbnMucHVzaCgge1xuXHRcdFx0XHRcdHZhbHVlOiBtYXRjaGVkLFxuXHRcdFx0XHRcdHR5cGU6IHR5cGUsXG5cdFx0XHRcdFx0bWF0Y2hlczogbWF0Y2hcblx0XHRcdFx0fSApO1xuXHRcdFx0XHRzb0ZhciA9IHNvRmFyLnNsaWNlKCBtYXRjaGVkLmxlbmd0aCApO1xuXHRcdFx0fVxuXHRcdH1cblxuXHRcdGlmICggIW1hdGNoZWQgKSB7XG5cdFx0XHRicmVhaztcblx0XHR9XG5cdH1cblxuXHQvLyBSZXR1cm4gdGhlIGxlbmd0aCBvZiB0aGUgaW52YWxpZCBleGNlc3Ncblx0Ly8gaWYgd2UncmUganVzdCBwYXJzaW5nXG5cdC8vIE90aGVyd2lzZSwgdGhyb3cgYW4gZXJyb3Igb3IgcmV0dXJuIHRva2Vuc1xuXHRpZiAoIHBhcnNlT25seSApIHtcblx0XHRyZXR1cm4gc29GYXIubGVuZ3RoO1xuXHR9XG5cblx0cmV0dXJuIHNvRmFyID9cblx0XHRzZWxlY3RvckVycm9yKCBzZWxlY3RvciApIDpcblxuXHRcdC8vIENhY2hlIHRoZSB0b2tlbnNcblx0XHR0b2tlbkNhY2hlKCBzZWxlY3RvciwgZ3JvdXBzICkuc2xpY2UoIDAgKTtcbn1cblxudmFyIHByZUZpbHRlciA9IHtcblx0QVRUUjogZnVuY3Rpb24oIG1hdGNoICkge1xuXHRcdG1hdGNoWyAxIF0gPSB1bmVzY2FwZVNlbGVjdG9yKCBtYXRjaFsgMSBdICk7XG5cblx0XHQvLyBNb3ZlIHRoZSBnaXZlbiB2YWx1ZSB0byBtYXRjaFszXSB3aGV0aGVyIHF1b3RlZCBvciB1bnF1b3RlZFxuXHRcdG1hdGNoWyAzIF0gPSB1bmVzY2FwZVNlbGVjdG9yKCBtYXRjaFsgMyBdIHx8IG1hdGNoWyA0IF0gfHwgbWF0Y2hbIDUgXSB8fCBcIlwiICk7XG5cblx0XHRpZiAoIG1hdGNoWyAyIF0gPT09IFwifj1cIiApIHtcblx0XHRcdG1hdGNoWyAzIF0gPSBcIiBcIiArIG1hdGNoWyAzIF0gKyBcIiBcIjtcblx0XHR9XG5cblx0XHRyZXR1cm4gbWF0Y2guc2xpY2UoIDAsIDQgKTtcblx0fSxcblxuXHRDSElMRDogZnVuY3Rpb24oIG1hdGNoICkge1xuXG5cdFx0LyogbWF0Y2hlcyBmcm9tIGZpbHRlck1hdGNoRXhwcltcIkNISUxEXCJdXG5cdFx0XHQxIHR5cGUgKG9ubHl8bnRofC4uLilcblx0XHRcdDIgd2hhdCAoY2hpbGR8b2YtdHlwZSlcblx0XHRcdDMgYXJndW1lbnQgKGV2ZW58b2RkfFxcZCp8XFxkKm4oWystXVxcZCspP3wuLi4pXG5cdFx0XHQ0IHhuLWNvbXBvbmVudCBvZiB4bit5IGFyZ3VtZW50IChbKy1dP1xcZCpufClcblx0XHRcdDUgc2lnbiBvZiB4bi1jb21wb25lbnRcblx0XHRcdDYgeCBvZiB4bi1jb21wb25lbnRcblx0XHRcdDcgc2lnbiBvZiB5LWNvbXBvbmVudFxuXHRcdFx0OCB5IG9mIHktY29tcG9uZW50XG5cdFx0Ki9cblx0XHRtYXRjaFsgMSBdID0gbWF0Y2hbIDEgXS50b0xvd2VyQ2FzZSgpO1xuXG5cdFx0aWYgKCBtYXRjaFsgMSBdLnNsaWNlKCAwLCAzICkgPT09IFwibnRoXCIgKSB7XG5cblx0XHRcdC8vIG50aC0qIHJlcXVpcmVzIGFyZ3VtZW50XG5cdFx0XHRpZiAoICFtYXRjaFsgMyBdICkge1xuXHRcdFx0XHRzZWxlY3RvckVycm9yKCBtYXRjaFsgMCBdICk7XG5cdFx0XHR9XG5cblx0XHRcdC8vIG51bWVyaWMgeCBhbmQgeSBwYXJhbWV0ZXJzIGZvciBqUXVlcnkuZXhwci5maWx0ZXIuQ0hJTERcblx0XHRcdC8vIHJlbWVtYmVyIHRoYXQgZmFsc2UvdHJ1ZSBjYXN0IHJlc3BlY3RpdmVseSB0byAwLzFcblx0XHRcdG1hdGNoWyA0IF0gPSArKCBtYXRjaFsgNCBdID9cblx0XHRcdFx0bWF0Y2hbIDUgXSArICggbWF0Y2hbIDYgXSB8fCAxICkgOlxuXHRcdFx0XHQyICogKCBtYXRjaFsgMyBdID09PSBcImV2ZW5cIiB8fCBtYXRjaFsgMyBdID09PSBcIm9kZFwiIClcblx0XHRcdCk7XG5cdFx0XHRtYXRjaFsgNSBdID0gKyggKCBtYXRjaFsgNyBdICsgbWF0Y2hbIDggXSApIHx8IG1hdGNoWyAzIF0gPT09IFwib2RkXCIgKTtcblxuXHRcdC8vIG90aGVyIHR5cGVzIHByb2hpYml0IGFyZ3VtZW50c1xuXHRcdH0gZWxzZSBpZiAoIG1hdGNoWyAzIF0gKSB7XG5cdFx0XHRzZWxlY3RvckVycm9yKCBtYXRjaFsgMCBdICk7XG5cdFx0fVxuXG5cdFx0cmV0dXJuIG1hdGNoO1xuXHR9LFxuXG5cdFBTRVVETzogZnVuY3Rpb24oIG1hdGNoICkge1xuXHRcdHZhciBleGNlc3MsXG5cdFx0XHR1bnF1b3RlZCA9ICFtYXRjaFsgNiBdICYmIG1hdGNoWyAyIF07XG5cblx0XHRpZiAoIGZpbHRlck1hdGNoRXhwci5DSElMRC50ZXN0KCBtYXRjaFsgMCBdICkgKSB7XG5cdFx0XHRyZXR1cm4gbnVsbDtcblx0XHR9XG5cblx0XHQvLyBBY2NlcHQgcXVvdGVkIGFyZ3VtZW50cyBhcy1pc1xuXHRcdGlmICggbWF0Y2hbIDMgXSApIHtcblx0XHRcdG1hdGNoWyAyIF0gPSBtYXRjaFsgNCBdIHx8IG1hdGNoWyA1IF0gfHwgXCJcIjtcblxuXHRcdC8vIFN0cmlwIGV4Y2VzcyBjaGFyYWN0ZXJzIGZyb20gdW5xdW90ZWQgYXJndW1lbnRzXG5cdFx0fSBlbHNlIGlmICggdW5xdW90ZWQgJiYgcnBzZXVkby50ZXN0KCB1bnF1b3RlZCApICYmXG5cblx0XHRcdC8vIEdldCBleGNlc3MgZnJvbSB0b2tlbml6ZSAocmVjdXJzaXZlbHkpXG5cdFx0XHQoIGV4Y2VzcyA9IHRva2VuaXplKCB1bnF1b3RlZCwgdHJ1ZSApICkgJiZcblxuXHRcdFx0Ly8gYWR2YW5jZSB0byB0aGUgbmV4dCBjbG9zaW5nIHBhcmVudGhlc2lzXG5cdFx0XHQoIGV4Y2VzcyA9IHVucXVvdGVkLmluZGV4T2YoIFwiKVwiLCB1bnF1b3RlZC5sZW5ndGggLSBleGNlc3MgKSAtXG5cdFx0XHRcdHVucXVvdGVkLmxlbmd0aCApICkge1xuXG5cdFx0XHQvLyBleGNlc3MgaXMgYSBuZWdhdGl2ZSBpbmRleFxuXHRcdFx0bWF0Y2hbIDAgXSA9IG1hdGNoWyAwIF0uc2xpY2UoIDAsIGV4Y2VzcyApO1xuXHRcdFx0bWF0Y2hbIDIgXSA9IHVucXVvdGVkLnNsaWNlKCAwLCBleGNlc3MgKTtcblx0XHR9XG5cblx0XHQvLyBSZXR1cm4gb25seSBjYXB0dXJlcyBuZWVkZWQgYnkgdGhlIHBzZXVkbyBmaWx0ZXIgbWV0aG9kICh0eXBlIGFuZCBhcmd1bWVudClcblx0XHRyZXR1cm4gbWF0Y2guc2xpY2UoIDAsIDMgKTtcblx0fVxufTtcblxuZnVuY3Rpb24gdG9TZWxlY3RvciggdG9rZW5zICkge1xuXHR2YXIgaSA9IDAsXG5cdFx0bGVuID0gdG9rZW5zLmxlbmd0aCxcblx0XHRzZWxlY3RvciA9IFwiXCI7XG5cdGZvciAoIDsgaSA8IGxlbjsgaSsrICkge1xuXHRcdHNlbGVjdG9yICs9IHRva2Vuc1sgaSBdLnZhbHVlO1xuXHR9XG5cdHJldHVybiBzZWxlY3Rvcjtcbn1cblxuLy8gTXVsdGlmdW5jdGlvbmFsIG1ldGhvZCB0byBnZXQgYW5kIHNldCB2YWx1ZXMgb2YgYSBjb2xsZWN0aW9uXG4vLyBUaGUgdmFsdWUvcyBjYW4gb3B0aW9uYWxseSBiZSBleGVjdXRlZCBpZiBpdCdzIGEgZnVuY3Rpb25cbmZ1bmN0aW9uIGFjY2VzcyggZWxlbXMsIGZuLCBrZXksIHZhbHVlLCBjaGFpbmFibGUsIGVtcHR5R2V0LCByYXcgKSB7XG5cdHZhciBpID0gMCxcblx0XHRsZW4gPSBlbGVtcy5sZW5ndGgsXG5cdFx0YnVsayA9IGtleSA9PSBudWxsO1xuXG5cdC8vIFNldHMgbWFueSB2YWx1ZXNcblx0aWYgKCB0b1R5cGUoIGtleSApID09PSBcIm9iamVjdFwiICkge1xuXHRcdGNoYWluYWJsZSA9IHRydWU7XG5cdFx0Zm9yICggaSBpbiBrZXkgKSB7XG5cdFx0XHRhY2Nlc3MoIGVsZW1zLCBmbiwgaSwga2V5WyBpIF0sIHRydWUsIGVtcHR5R2V0LCByYXcgKTtcblx0XHR9XG5cblx0Ly8gU2V0cyBvbmUgdmFsdWVcblx0fSBlbHNlIGlmICggdmFsdWUgIT09IHVuZGVmaW5lZCApIHtcblx0XHRjaGFpbmFibGUgPSB0cnVlO1xuXG5cdFx0aWYgKCB0eXBlb2YgdmFsdWUgIT09IFwiZnVuY3Rpb25cIiApIHtcblx0XHRcdHJhdyA9IHRydWU7XG5cdFx0fVxuXG5cdFx0aWYgKCBidWxrICkge1xuXG5cdFx0XHQvLyBCdWxrIG9wZXJhdGlvbnMgcnVuIGFnYWluc3QgdGhlIGVudGlyZSBzZXRcblx0XHRcdGlmICggcmF3ICkge1xuXHRcdFx0XHRmbi5jYWxsKCBlbGVtcywgdmFsdWUgKTtcblx0XHRcdFx0Zm4gPSBudWxsO1xuXG5cdFx0XHQvLyAuLi5leGNlcHQgd2hlbiBleGVjdXRpbmcgZnVuY3Rpb24gdmFsdWVzXG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRidWxrID0gZm47XG5cdFx0XHRcdGZuID0gZnVuY3Rpb24oIGVsZW0sIF9rZXksIHZhbHVlICkge1xuXHRcdFx0XHRcdHJldHVybiBidWxrLmNhbGwoIGpRdWVyeSggZWxlbSApLCB2YWx1ZSApO1xuXHRcdFx0XHR9O1xuXHRcdFx0fVxuXHRcdH1cblxuXHRcdGlmICggZm4gKSB7XG5cdFx0XHRmb3IgKCA7IGkgPCBsZW47IGkrKyApIHtcblx0XHRcdFx0Zm4oXG5cdFx0XHRcdFx0ZWxlbXNbIGkgXSwga2V5LCByYXcgP1xuXHRcdFx0XHRcdFx0dmFsdWUgOlxuXHRcdFx0XHRcdFx0dmFsdWUuY2FsbCggZWxlbXNbIGkgXSwgaSwgZm4oIGVsZW1zWyBpIF0sIGtleSApIClcblx0XHRcdFx0KTtcblx0XHRcdH1cblx0XHR9XG5cdH1cblxuXHRpZiAoIGNoYWluYWJsZSApIHtcblx0XHRyZXR1cm4gZWxlbXM7XG5cdH1cblxuXHQvLyBHZXRzXG5cdGlmICggYnVsayApIHtcblx0XHRyZXR1cm4gZm4uY2FsbCggZWxlbXMgKTtcblx0fVxuXG5cdHJldHVybiBsZW4gPyBmbiggZWxlbXNbIDAgXSwga2V5ICkgOiBlbXB0eUdldDtcbn1cblxuLy8gT25seSBjb3VudCBIVE1MIHdoaXRlc3BhY2Vcbi8vIE90aGVyIHdoaXRlc3BhY2Ugc2hvdWxkIGNvdW50IGluIHZhbHVlc1xuLy8gaHR0cHM6Ly9pbmZyYS5zcGVjLndoYXR3Zy5vcmcvI2FzY2lpLXdoaXRlc3BhY2VcbnZhciBybm90aHRtbHdoaXRlID0gL1teXFx4MjBcXHRcXHJcXG5cXGZdKy9nO1xuXG5qUXVlcnkuZm4uZXh0ZW5kKCB7XG5cdGF0dHI6IGZ1bmN0aW9uKCBuYW1lLCB2YWx1ZSApIHtcblx0XHRyZXR1cm4gYWNjZXNzKCB0aGlzLCBqUXVlcnkuYXR0ciwgbmFtZSwgdmFsdWUsIGFyZ3VtZW50cy5sZW5ndGggPiAxICk7XG5cdH0sXG5cblx0cmVtb3ZlQXR0cjogZnVuY3Rpb24oIG5hbWUgKSB7XG5cdFx0cmV0dXJuIHRoaXMuZWFjaCggZnVuY3Rpb24oKSB7XG5cdFx0XHRqUXVlcnkucmVtb3ZlQXR0ciggdGhpcywgbmFtZSApO1xuXHRcdH0gKTtcblx0fVxufSApO1xuXG5qUXVlcnkuZXh0ZW5kKCB7XG5cdGF0dHI6IGZ1bmN0aW9uKCBlbGVtLCBuYW1lLCB2YWx1ZSApIHtcblx0XHR2YXIgcmV0LCBob29rcyxcblx0XHRcdG5UeXBlID0gZWxlbS5ub2RlVHlwZTtcblxuXHRcdC8vIERvbid0IGdldC9zZXQgYXR0cmlidXRlcyBvbiB0ZXh0LCBjb21tZW50IGFuZCBhdHRyaWJ1dGUgbm9kZXNcblx0XHRpZiAoIG5UeXBlID09PSAzIHx8IG5UeXBlID09PSA4IHx8IG5UeXBlID09PSAyICkge1xuXHRcdFx0cmV0dXJuO1xuXHRcdH1cblxuXHRcdC8vIEZhbGxiYWNrIHRvIHByb3Agd2hlbiBhdHRyaWJ1dGVzIGFyZSBub3Qgc3VwcG9ydGVkXG5cdFx0aWYgKCB0eXBlb2YgZWxlbS5nZXRBdHRyaWJ1dGUgPT09IFwidW5kZWZpbmVkXCIgKSB7XG5cdFx0XHRyZXR1cm4galF1ZXJ5LnByb3AoIGVsZW0sIG5hbWUsIHZhbHVlICk7XG5cdFx0fVxuXG5cdFx0Ly8gQXR0cmlidXRlIGhvb2tzIGFyZSBkZXRlcm1pbmVkIGJ5IHRoZSBsb3dlcmNhc2UgdmVyc2lvblxuXHRcdC8vIEdyYWIgbmVjZXNzYXJ5IGhvb2sgaWYgb25lIGlzIGRlZmluZWRcblx0XHRpZiAoIG5UeXBlICE9PSAxIHx8ICFqUXVlcnkuaXNYTUxEb2MoIGVsZW0gKSApIHtcblx0XHRcdGhvb2tzID0galF1ZXJ5LmF0dHJIb29rc1sgbmFtZS50b0xvd2VyQ2FzZSgpIF07XG5cdFx0fVxuXG5cdFx0aWYgKCB2YWx1ZSAhPT0gdW5kZWZpbmVkICkge1xuXHRcdFx0aWYgKCB2YWx1ZSA9PT0gbnVsbCB8fFxuXG5cdFx0XHRcdC8vIEZvciBjb21wYXQgd2l0aCBwcmV2aW91cyBoYW5kbGluZyBvZiBib29sZWFuIGF0dHJpYnV0ZXMsXG5cdFx0XHRcdC8vIHJlbW92ZSB3aGVuIGBmYWxzZWAgcGFzc2VkLiBGb3IgQVJJQSBhdHRyaWJ1dGVzIC1cblx0XHRcdFx0Ly8gbWFueSBvZiB3aGljaCByZWNvZ25pemUgYSBgXCJmYWxzZVwiYCB2YWx1ZSAtIGNvbnRpbnVlIHRvXG5cdFx0XHRcdC8vIHNldCB0aGUgYFwiZmFsc2VcImAgdmFsdWUgYXMgalF1ZXJ5IDw0IGRpZC5cblx0XHRcdFx0KCB2YWx1ZSA9PT0gZmFsc2UgJiYgbmFtZS50b0xvd2VyQ2FzZSgpLmluZGV4T2YoIFwiYXJpYS1cIiApICE9PSAwICkgKSB7XG5cblx0XHRcdFx0alF1ZXJ5LnJlbW92ZUF0dHIoIGVsZW0sIG5hbWUgKTtcblx0XHRcdFx0cmV0dXJuO1xuXHRcdFx0fVxuXG5cdFx0XHRpZiAoIGhvb2tzICYmIFwic2V0XCIgaW4gaG9va3MgJiZcblx0XHRcdFx0KCByZXQgPSBob29rcy5zZXQoIGVsZW0sIHZhbHVlLCBuYW1lICkgKSAhPT0gdW5kZWZpbmVkICkge1xuXHRcdFx0XHRyZXR1cm4gcmV0O1xuXHRcdFx0fVxuXG5cdFx0XHRlbGVtLnNldEF0dHJpYnV0ZSggbmFtZSwgdmFsdWUgKTtcblx0XHRcdHJldHVybiB2YWx1ZTtcblx0XHR9XG5cblx0XHRpZiAoIGhvb2tzICYmIFwiZ2V0XCIgaW4gaG9va3MgJiYgKCByZXQgPSBob29rcy5nZXQoIGVsZW0sIG5hbWUgKSApICE9PSBudWxsICkge1xuXHRcdFx0cmV0dXJuIHJldDtcblx0XHR9XG5cblx0XHRyZXQgPSBlbGVtLmdldEF0dHJpYnV0ZSggbmFtZSApO1xuXG5cdFx0Ly8gTm9uLWV4aXN0ZW50IGF0dHJpYnV0ZXMgcmV0dXJuIG51bGwsIHdlIG5vcm1hbGl6ZSB0byB1bmRlZmluZWRcblx0XHRyZXR1cm4gcmV0ID09IG51bGwgPyB1bmRlZmluZWQgOiByZXQ7XG5cdH0sXG5cblx0YXR0ckhvb2tzOiB7fSxcblxuXHRyZW1vdmVBdHRyOiBmdW5jdGlvbiggZWxlbSwgdmFsdWUgKSB7XG5cdFx0dmFyIG5hbWUsXG5cdFx0XHRpID0gMCxcblxuXHRcdFx0Ly8gQXR0cmlidXRlIG5hbWVzIGNhbiBjb250YWluIG5vbi1IVE1MIHdoaXRlc3BhY2UgY2hhcmFjdGVyc1xuXHRcdFx0Ly8gaHR0cHM6Ly9odG1sLnNwZWMud2hhdHdnLm9yZy9tdWx0aXBhZ2Uvc3ludGF4Lmh0bWwjYXR0cmlidXRlcy0yXG5cdFx0XHRhdHRyTmFtZXMgPSB2YWx1ZSAmJiB2YWx1ZS5tYXRjaCggcm5vdGh0bWx3aGl0ZSApO1xuXG5cdFx0aWYgKCBhdHRyTmFtZXMgJiYgZWxlbS5ub2RlVHlwZSA9PT0gMSApIHtcblx0XHRcdHdoaWxlICggKCBuYW1lID0gYXR0ck5hbWVzWyBpKysgXSApICkge1xuXHRcdFx0XHRlbGVtLnJlbW92ZUF0dHJpYnV0ZSggbmFtZSApO1xuXHRcdFx0fVxuXHRcdH1cblx0fVxufSApO1xuXG4vLyBTdXBwb3J0OiBJRSA8PTExK1xuLy8gQW4gaW5wdXQgbG9zZXMgaXRzIHZhbHVlIGFmdGVyIGJlY29taW5nIGEgcmFkaW9cbmlmICggaXNJRSApIHtcblx0alF1ZXJ5LmF0dHJIb29rcy50eXBlID0ge1xuXHRcdHNldDogZnVuY3Rpb24oIGVsZW0sIHZhbHVlICkge1xuXHRcdFx0aWYgKCB2YWx1ZSA9PT0gXCJyYWRpb1wiICYmIG5vZGVOYW1lKCBlbGVtLCBcImlucHV0XCIgKSApIHtcblx0XHRcdFx0dmFyIHZhbCA9IGVsZW0udmFsdWU7XG5cdFx0XHRcdGVsZW0uc2V0QXR0cmlidXRlKCBcInR5cGVcIiwgdmFsdWUgKTtcblx0XHRcdFx0aWYgKCB2YWwgKSB7XG5cdFx0XHRcdFx0ZWxlbS52YWx1ZSA9IHZhbDtcblx0XHRcdFx0fVxuXHRcdFx0XHRyZXR1cm4gdmFsdWU7XG5cdFx0XHR9XG5cdFx0fVxuXHR9O1xufVxuXG4vLyBDU1Mgc3RyaW5nL2lkZW50aWZpZXIgc2VyaWFsaXphdGlvblxuLy8gaHR0cHM6Ly9kcmFmdHMuY3Nzd2cub3JnL2Nzc29tLyNjb21tb24tc2VyaWFsaXppbmctaWRpb21zXG52YXIgcmNzc2VzY2FwZSA9IC8oW1xcMC1cXHgxZlxceDdmXXxeLT9cXGQpfF4tJHxbXlxceDgwLVxcdUZGRkZcXHctXS9nO1xuXG5mdW5jdGlvbiBmY3NzZXNjYXBlKCBjaCwgYXNDb2RlUG9pbnQgKSB7XG5cdGlmICggYXNDb2RlUG9pbnQgKSB7XG5cblx0XHQvLyBVKzAwMDAgTlVMTCBiZWNvbWVzIFUrRkZGRCBSRVBMQUNFTUVOVCBDSEFSQUNURVJcblx0XHRpZiAoIGNoID09PSBcIlxcMFwiICkge1xuXHRcdFx0cmV0dXJuIFwiXFx1RkZGRFwiO1xuXHRcdH1cblxuXHRcdC8vIENvbnRyb2wgY2hhcmFjdGVycyBhbmQgKGRlcGVuZGVudCB1cG9uIHBvc2l0aW9uKSBudW1iZXJzIGdldCBlc2NhcGVkIGFzIGNvZGUgcG9pbnRzXG5cdFx0cmV0dXJuIGNoLnNsaWNlKCAwLCAtMSApICsgXCJcXFxcXCIgKyBjaC5jaGFyQ29kZUF0KCBjaC5sZW5ndGggLSAxICkudG9TdHJpbmcoIDE2ICkgKyBcIiBcIjtcblx0fVxuXG5cdC8vIE90aGVyIHBvdGVudGlhbGx5LXNwZWNpYWwgQVNDSUkgY2hhcmFjdGVycyBnZXQgYmFja3NsYXNoLWVzY2FwZWRcblx0cmV0dXJuIFwiXFxcXFwiICsgY2g7XG59XG5cbmpRdWVyeS5lc2NhcGVTZWxlY3RvciA9IGZ1bmN0aW9uKCBzZWwgKSB7XG5cdHJldHVybiAoIHNlbCArIFwiXCIgKS5yZXBsYWNlKCByY3NzZXNjYXBlLCBmY3NzZXNjYXBlICk7XG59O1xuXG52YXIgc29ydCA9IGFyci5zb3J0O1xuXG52YXIgc3BsaWNlID0gYXJyLnNwbGljZTtcblxudmFyIGhhc0R1cGxpY2F0ZTtcblxuLy8gRG9jdW1lbnQgb3JkZXIgc29ydGluZ1xuZnVuY3Rpb24gc29ydE9yZGVyKCBhLCBiICkge1xuXG5cdC8vIEZsYWcgZm9yIGR1cGxpY2F0ZSByZW1vdmFsXG5cdGlmICggYSA9PT0gYiApIHtcblx0XHRoYXNEdXBsaWNhdGUgPSB0cnVlO1xuXHRcdHJldHVybiAwO1xuXHR9XG5cblx0Ly8gU29ydCBvbiBtZXRob2QgZXhpc3RlbmNlIGlmIG9ubHkgb25lIGlucHV0IGhhcyBjb21wYXJlRG9jdW1lbnRQb3NpdGlvblxuXHR2YXIgY29tcGFyZSA9ICFhLmNvbXBhcmVEb2N1bWVudFBvc2l0aW9uIC0gIWIuY29tcGFyZURvY3VtZW50UG9zaXRpb247XG5cdGlmICggY29tcGFyZSApIHtcblx0XHRyZXR1cm4gY29tcGFyZTtcblx0fVxuXG5cdC8vIENhbGN1bGF0ZSBwb3NpdGlvbiBpZiBib3RoIGlucHV0cyBiZWxvbmcgdG8gdGhlIHNhbWUgZG9jdW1lbnRcblx0Ly8gU3VwcG9ydDogSUUgMTErXG5cdC8vIElFIHNvbWV0aW1lcyB0aHJvd3MgYSBcIlBlcm1pc3Npb24gZGVuaWVkXCIgZXJyb3Igd2hlbiBzdHJpY3QtY29tcGFyaW5nXG5cdC8vIHR3byBkb2N1bWVudHM7IHNoYWxsb3cgY29tcGFyaXNvbnMgd29yay5cblx0Ly8gZXNsaW50LWRpc2FibGUtbmV4dC1saW5lIGVxZXFlcVxuXHRjb21wYXJlID0gKCBhLm93bmVyRG9jdW1lbnQgfHwgYSApID09ICggYi5vd25lckRvY3VtZW50IHx8IGIgKSA/XG5cdFx0YS5jb21wYXJlRG9jdW1lbnRQb3NpdGlvbiggYiApIDpcblxuXHRcdC8vIE90aGVyd2lzZSB3ZSBrbm93IHRoZXkgYXJlIGRpc2Nvbm5lY3RlZFxuXHRcdDE7XG5cblx0Ly8gRGlzY29ubmVjdGVkIG5vZGVzXG5cdGlmICggY29tcGFyZSAmIDEgKSB7XG5cblx0XHQvLyBDaG9vc2UgdGhlIGZpcnN0IGVsZW1lbnQgdGhhdCBpcyByZWxhdGVkIHRvIHRoZSBkb2N1bWVudFxuXHRcdC8vIFN1cHBvcnQ6IElFIDExK1xuXHRcdC8vIElFIHNvbWV0aW1lcyB0aHJvd3MgYSBcIlBlcm1pc3Npb24gZGVuaWVkXCIgZXJyb3Igd2hlbiBzdHJpY3QtY29tcGFyaW5nXG5cdFx0Ly8gdHdvIGRvY3VtZW50czsgc2hhbGxvdyBjb21wYXJpc29ucyB3b3JrLlxuXHRcdC8vIGVzbGludC1kaXNhYmxlLW5leHQtbGluZSBlcWVxZXFcblx0XHRpZiAoIGEgPT0gZG9jdW1lbnQkMSB8fCBhLm93bmVyRG9jdW1lbnQgPT0gZG9jdW1lbnQkMSAmJlxuXHRcdFx0alF1ZXJ5LmNvbnRhaW5zKCBkb2N1bWVudCQxLCBhICkgKSB7XG5cdFx0XHRyZXR1cm4gLTE7XG5cdFx0fVxuXG5cdFx0Ly8gU3VwcG9ydDogSUUgMTErXG5cdFx0Ly8gSUUgc29tZXRpbWVzIHRocm93cyBhIFwiUGVybWlzc2lvbiBkZW5pZWRcIiBlcnJvciB3aGVuIHN0cmljdC1jb21wYXJpbmdcblx0XHQvLyB0d28gZG9jdW1lbnRzOyBzaGFsbG93IGNvbXBhcmlzb25zIHdvcmsuXG5cdFx0Ly8gZXNsaW50LWRpc2FibGUtbmV4dC1saW5lIGVxZXFlcVxuXHRcdGlmICggYiA9PSBkb2N1bWVudCQxIHx8IGIub3duZXJEb2N1bWVudCA9PSBkb2N1bWVudCQxICYmXG5cdFx0XHRqUXVlcnkuY29udGFpbnMoIGRvY3VtZW50JDEsIGIgKSApIHtcblx0XHRcdHJldHVybiAxO1xuXHRcdH1cblxuXHRcdC8vIE1haW50YWluIG9yaWdpbmFsIG9yZGVyXG5cdFx0cmV0dXJuIDA7XG5cdH1cblxuXHRyZXR1cm4gY29tcGFyZSAmIDQgPyAtMSA6IDE7XG59XG5cbi8qKlxuICogRG9jdW1lbnQgc29ydGluZyBhbmQgcmVtb3ZpbmcgZHVwbGljYXRlc1xuICogQHBhcmFtIHtBcnJheUxpa2V9IHJlc3VsdHNcbiAqL1xualF1ZXJ5LnVuaXF1ZVNvcnQgPSBmdW5jdGlvbiggcmVzdWx0cyApIHtcblx0dmFyIGVsZW0sXG5cdFx0ZHVwbGljYXRlcyA9IFtdLFxuXHRcdGogPSAwLFxuXHRcdGkgPSAwO1xuXG5cdGhhc0R1cGxpY2F0ZSA9IGZhbHNlO1xuXG5cdHNvcnQuY2FsbCggcmVzdWx0cywgc29ydE9yZGVyICk7XG5cblx0aWYgKCBoYXNEdXBsaWNhdGUgKSB7XG5cdFx0d2hpbGUgKCAoIGVsZW0gPSByZXN1bHRzWyBpKysgXSApICkge1xuXHRcdFx0aWYgKCBlbGVtID09PSByZXN1bHRzWyBpIF0gKSB7XG5cdFx0XHRcdGogPSBkdXBsaWNhdGVzLnB1c2goIGkgKTtcblx0XHRcdH1cblx0XHR9XG5cdFx0d2hpbGUgKCBqLS0gKSB7XG5cdFx0XHRzcGxpY2UuY2FsbCggcmVzdWx0cywgZHVwbGljYXRlc1sgaiBdLCAxICk7XG5cdFx0fVxuXHR9XG5cblx0cmV0dXJuIHJlc3VsdHM7XG59O1xuXG5qUXVlcnkuZm4udW5pcXVlU29ydCA9IGZ1bmN0aW9uKCkge1xuXHRyZXR1cm4gdGhpcy5wdXNoU3RhY2soIGpRdWVyeS51bmlxdWVTb3J0KCBzbGljZS5hcHBseSggdGhpcyApICkgKTtcbn07XG5cbnZhciBpLFxuXHRvdXRlcm1vc3RDb250ZXh0LFxuXG5cdC8vIExvY2FsIGRvY3VtZW50IHZhcnNcblx0ZG9jdW1lbnQsXG5cdGRvY3VtZW50RWxlbWVudCxcblx0ZG9jdW1lbnRJc0hUTUwsXG5cblx0Ly8gSW5zdGFuY2Utc3BlY2lmaWMgZGF0YVxuXHRkaXJydW5zID0gMCxcblx0ZG9uZSA9IDAsXG5cdGNsYXNzQ2FjaGUgPSBjcmVhdGVDYWNoZSgpLFxuXHRjb21waWxlckNhY2hlID0gY3JlYXRlQ2FjaGUoKSxcblx0bm9ubmF0aXZlU2VsZWN0b3JDYWNoZSA9IGNyZWF0ZUNhY2hlKCksXG5cblx0Ly8gUmVndWxhciBleHByZXNzaW9uc1xuXG5cdC8vIExlYWRpbmcgYW5kIG5vbi1lc2NhcGVkIHRyYWlsaW5nIHdoaXRlc3BhY2UsIGNhcHR1cmluZyBzb21lIG5vbi13aGl0ZXNwYWNlIGNoYXJhY3RlcnMgcHJlY2VkaW5nIHRoZSBsYXR0ZXJcblx0cndoaXRlc3BhY2UgPSBuZXcgUmVnRXhwKCB3aGl0ZXNwYWNlICsgXCIrXCIsIFwiZ1wiICksXG5cblx0cmlkZW50aWZpZXIgPSBuZXcgUmVnRXhwKCBcIl5cIiArIGlkZW50aWZpZXIgKyBcIiRcIiApLFxuXG5cdG1hdGNoRXhwciA9IGpRdWVyeS5leHRlbmQoIHtcblxuXHRcdC8vIEZvciB1c2UgaW4gbGlicmFyaWVzIGltcGxlbWVudGluZyAuaXMoKVxuXHRcdC8vIFdlIHVzZSB0aGlzIGZvciBQT1MgbWF0Y2hpbmcgaW4gYHNlbGVjdGBcblx0XHRuZWVkc0NvbnRleHQ6IG5ldyBSZWdFeHAoIFwiXlwiICsgd2hpdGVzcGFjZSArXG5cdFx0XHRcIipbPit+XXw6KGV2ZW58b2RkfGVxfGd0fGx0fG50aHxmaXJzdHxsYXN0KSg/OlxcXFwoXCIgKyB3aGl0ZXNwYWNlICtcblx0XHRcdFwiKigoPzotXFxcXGQpP1xcXFxkKilcIiArIHdoaXRlc3BhY2UgKyBcIipcXFxcKXwpKD89W14tXXwkKVwiLCBcImlcIiApXG5cdH0sIGZpbHRlck1hdGNoRXhwciApLFxuXG5cdHJpbnB1dHMgPSAvXig/OmlucHV0fHNlbGVjdHx0ZXh0YXJlYXxidXR0b24pJC9pLFxuXHRyaGVhZGVyID0gL15oXFxkJC9pLFxuXG5cdC8vIEVhc2lseS1wYXJzZWFibGUvcmV0cmlldmFibGUgSUQgb3IgVEFHIG9yIENMQVNTIHNlbGVjdG9yc1xuXHRycXVpY2tFeHByJDEgPSAvXig/OiMoW1xcdy1dKyl8KFxcdyspfFxcLihbXFx3LV0rKSkkLyxcblxuXHQvLyBVc2VkIGZvciBpZnJhbWVzOyBzZWUgYHNldERvY3VtZW50YC5cblx0Ly8gU3VwcG9ydDogSUUgOSAtIDExK1xuXHQvLyBSZW1vdmluZyB0aGUgZnVuY3Rpb24gd3JhcHBlciBjYXVzZXMgYSBcIlBlcm1pc3Npb24gRGVuaWVkXCJcblx0Ly8gZXJyb3IgaW4gSUUuXG5cdHVubG9hZEhhbmRsZXIgPSBmdW5jdGlvbigpIHtcblx0XHRzZXREb2N1bWVudCgpO1xuXHR9LFxuXG5cdGluRGlzYWJsZWRGaWVsZHNldCA9IGFkZENvbWJpbmF0b3IoXG5cdFx0ZnVuY3Rpb24oIGVsZW0gKSB7XG5cdFx0XHRyZXR1cm4gZWxlbS5kaXNhYmxlZCA9PT0gdHJ1ZSAmJiBub2RlTmFtZSggZWxlbSwgXCJmaWVsZHNldFwiICk7XG5cdFx0fSxcblx0XHR7IGRpcjogXCJwYXJlbnROb2RlXCIsIG5leHQ6IFwibGVnZW5kXCIgfVxuXHQpO1xuXG5mdW5jdGlvbiBmaW5kKCBzZWxlY3RvciwgY29udGV4dCwgcmVzdWx0cywgc2VlZCApIHtcblx0dmFyIG0sIGksIGVsZW0sIG5pZCwgbWF0Y2gsIGdyb3VwcywgbmV3U2VsZWN0b3IsXG5cdFx0bmV3Q29udGV4dCA9IGNvbnRleHQgJiYgY29udGV4dC5vd25lckRvY3VtZW50LFxuXG5cdFx0Ly8gbm9kZVR5cGUgZGVmYXVsdHMgdG8gOSwgc2luY2UgY29udGV4dCBkZWZhdWx0cyB0byBkb2N1bWVudFxuXHRcdG5vZGVUeXBlID0gY29udGV4dCA/IGNvbnRleHQubm9kZVR5cGUgOiA5O1xuXG5cdHJlc3VsdHMgPSByZXN1bHRzIHx8IFtdO1xuXG5cdC8vIFJldHVybiBlYXJseSBmcm9tIGNhbGxzIHdpdGggaW52YWxpZCBzZWxlY3RvciBvciBjb250ZXh0XG5cdGlmICggdHlwZW9mIHNlbGVjdG9yICE9PSBcInN0cmluZ1wiIHx8ICFzZWxlY3RvciB8fFxuXHRcdG5vZGVUeXBlICE9PSAxICYmIG5vZGVUeXBlICE9PSA5ICYmIG5vZGVUeXBlICE9PSAxMSApIHtcblxuXHRcdHJldHVybiByZXN1bHRzO1xuXHR9XG5cblx0Ly8gVHJ5IHRvIHNob3J0Y3V0IGZpbmQgb3BlcmF0aW9ucyAoYXMgb3Bwb3NlZCB0byBmaWx0ZXJzKSBpbiBIVE1MIGRvY3VtZW50c1xuXHRpZiAoICFzZWVkICkge1xuXHRcdHNldERvY3VtZW50KCBjb250ZXh0ICk7XG5cdFx0Y29udGV4dCA9IGNvbnRleHQgfHwgZG9jdW1lbnQ7XG5cblx0XHRpZiAoIGRvY3VtZW50SXNIVE1MICkge1xuXG5cdFx0XHQvLyBJZiB0aGUgc2VsZWN0b3IgaXMgc3VmZmljaWVudGx5IHNpbXBsZSwgdHJ5IHVzaW5nIGEgXCJnZXQqQnkqXCIgRE9NIG1ldGhvZFxuXHRcdFx0Ly8gKGV4Y2VwdGluZyBEb2N1bWVudEZyYWdtZW50IGNvbnRleHQsIHdoZXJlIHRoZSBtZXRob2RzIGRvbid0IGV4aXN0KVxuXHRcdFx0aWYgKCBub2RlVHlwZSAhPT0gMTEgJiYgKCBtYXRjaCA9IHJxdWlja0V4cHIkMS5leGVjKCBzZWxlY3RvciApICkgKSB7XG5cblx0XHRcdFx0Ly8gSUQgc2VsZWN0b3Jcblx0XHRcdFx0aWYgKCAoIG0gPSBtYXRjaFsgMSBdICkgKSB7XG5cblx0XHRcdFx0XHQvLyBEb2N1bWVudCBjb250ZXh0XG5cdFx0XHRcdFx0aWYgKCBub2RlVHlwZSA9PT0gOSApIHtcblx0XHRcdFx0XHRcdGlmICggKCBlbGVtID0gY29udGV4dC5nZXRFbGVtZW50QnlJZCggbSApICkgKSB7XG5cdFx0XHRcdFx0XHRcdHB1c2guY2FsbCggcmVzdWx0cywgZWxlbSApO1xuXHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdFx0cmV0dXJuIHJlc3VsdHM7XG5cblx0XHRcdFx0XHQvLyBFbGVtZW50IGNvbnRleHRcblx0XHRcdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRcdFx0aWYgKCBuZXdDb250ZXh0ICYmICggZWxlbSA9IG5ld0NvbnRleHQuZ2V0RWxlbWVudEJ5SWQoIG0gKSApICYmXG5cdFx0XHRcdFx0XHRcdGpRdWVyeS5jb250YWlucyggY29udGV4dCwgZWxlbSApICkge1xuXG5cdFx0XHRcdFx0XHRcdHB1c2guY2FsbCggcmVzdWx0cywgZWxlbSApO1xuXHRcdFx0XHRcdFx0XHRyZXR1cm4gcmVzdWx0cztcblx0XHRcdFx0XHRcdH1cblx0XHRcdFx0XHR9XG5cblx0XHRcdFx0Ly8gVHlwZSBzZWxlY3RvclxuXHRcdFx0XHR9IGVsc2UgaWYgKCBtYXRjaFsgMiBdICkge1xuXHRcdFx0XHRcdHB1c2guYXBwbHkoIHJlc3VsdHMsIGNvbnRleHQuZ2V0RWxlbWVudHNCeVRhZ05hbWUoIHNlbGVjdG9yICkgKTtcblx0XHRcdFx0XHRyZXR1cm4gcmVzdWx0cztcblxuXHRcdFx0XHQvLyBDbGFzcyBzZWxlY3RvclxuXHRcdFx0XHR9IGVsc2UgaWYgKCAoIG0gPSBtYXRjaFsgMyBdICkgJiYgY29udGV4dC5nZXRFbGVtZW50c0J5Q2xhc3NOYW1lICkge1xuXHRcdFx0XHRcdHB1c2guYXBwbHkoIHJlc3VsdHMsIGNvbnRleHQuZ2V0RWxlbWVudHNCeUNsYXNzTmFtZSggbSApICk7XG5cdFx0XHRcdFx0cmV0dXJuIHJlc3VsdHM7XG5cdFx0XHRcdH1cblx0XHRcdH1cblxuXHRcdFx0Ly8gVGFrZSBhZHZhbnRhZ2Ugb2YgcXVlcnlTZWxlY3RvckFsbFxuXHRcdFx0aWYgKCAhbm9ubmF0aXZlU2VsZWN0b3JDYWNoZVsgc2VsZWN0b3IgKyBcIiBcIiBdICYmXG5cdFx0XHRcdCggIXJidWdneVFTQSB8fCAhcmJ1Z2d5UVNBLnRlc3QoIHNlbGVjdG9yICkgKSApIHtcblxuXHRcdFx0XHRuZXdTZWxlY3RvciA9IHNlbGVjdG9yO1xuXHRcdFx0XHRuZXdDb250ZXh0ID0gY29udGV4dDtcblxuXHRcdFx0XHQvLyBxU0EgY29uc2lkZXJzIGVsZW1lbnRzIG91dHNpZGUgYSBzY29waW5nIHJvb3Qgd2hlbiBldmFsdWF0aW5nIGNoaWxkIG9yXG5cdFx0XHRcdC8vIGRlc2NlbmRhbnQgY29tYmluYXRvcnMsIHdoaWNoIGlzIG5vdCB3aGF0IHdlIHdhbnQuXG5cdFx0XHRcdC8vIEluIHN1Y2ggY2FzZXMsIHdlIHdvcmsgYXJvdW5kIHRoZSBiZWhhdmlvciBieSBwcmVmaXhpbmcgZXZlcnkgc2VsZWN0b3IgaW4gdGhlXG5cdFx0XHRcdC8vIGxpc3Qgd2l0aCBhbiBJRCBzZWxlY3RvciByZWZlcmVuY2luZyB0aGUgc2NvcGUgY29udGV4dC5cblx0XHRcdFx0Ly8gVGhlIHRlY2huaXF1ZSBoYXMgdG8gYmUgdXNlZCBhcyB3ZWxsIHdoZW4gYSBsZWFkaW5nIGNvbWJpbmF0b3IgaXMgdXNlZFxuXHRcdFx0XHQvLyBhcyBzdWNoIHNlbGVjdG9ycyBhcmUgbm90IHJlY29nbml6ZWQgYnkgcXVlcnlTZWxlY3RvckFsbC5cblx0XHRcdFx0Ly8gVGhhbmtzIHRvIEFuZHJldyBEdXBvbnQgZm9yIHRoaXMgdGVjaG5pcXVlLlxuXHRcdFx0XHRpZiAoIG5vZGVUeXBlID09PSAxICYmXG5cdFx0XHRcdFx0KCByZGVzY2VuZC50ZXN0KCBzZWxlY3RvciApIHx8IHJsZWFkaW5nQ29tYmluYXRvci50ZXN0KCBzZWxlY3RvciApICkgKSB7XG5cblx0XHRcdFx0XHQvLyBFeHBhbmQgY29udGV4dCBmb3Igc2libGluZyBzZWxlY3RvcnNcblx0XHRcdFx0XHRuZXdDb250ZXh0ID0gcnNpYmxpbmcudGVzdCggc2VsZWN0b3IgKSAmJlxuXHRcdFx0XHRcdFx0dGVzdENvbnRleHQoIGNvbnRleHQucGFyZW50Tm9kZSApIHx8XG5cdFx0XHRcdFx0XHRjb250ZXh0O1xuXG5cdFx0XHRcdFx0Ly8gT3V0c2lkZSBvZiBJRSwgaWYgd2UncmUgbm90IGNoYW5naW5nIHRoZSBjb250ZXh0IHdlIGNhblxuXHRcdFx0XHRcdC8vIHVzZSA6c2NvcGUgaW5zdGVhZCBvZiBhbiBJRC5cblx0XHRcdFx0XHQvLyBTdXBwb3J0OiBJRSAxMStcblx0XHRcdFx0XHQvLyBJRSBzb21ldGltZXMgdGhyb3dzIGEgXCJQZXJtaXNzaW9uIGRlbmllZFwiIGVycm9yIHdoZW4gc3RyaWN0LWNvbXBhcmluZ1xuXHRcdFx0XHRcdC8vIHR3byBkb2N1bWVudHM7IHNoYWxsb3cgY29tcGFyaXNvbnMgd29yay5cblx0XHRcdFx0XHQvLyBlc2xpbnQtZGlzYWJsZS1uZXh0LWxpbmUgZXFlcWVxXG5cdFx0XHRcdFx0aWYgKCBuZXdDb250ZXh0ICE9IGNvbnRleHQgfHwgaXNJRSApIHtcblxuXHRcdFx0XHRcdFx0Ly8gQ2FwdHVyZSB0aGUgY29udGV4dCBJRCwgc2V0dGluZyBpdCBmaXJzdCBpZiBuZWNlc3Nhcnlcblx0XHRcdFx0XHRcdGlmICggKCBuaWQgPSBjb250ZXh0LmdldEF0dHJpYnV0ZSggXCJpZFwiICkgKSApIHtcblx0XHRcdFx0XHRcdFx0bmlkID0galF1ZXJ5LmVzY2FwZVNlbGVjdG9yKCBuaWQgKTtcblx0XHRcdFx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdFx0XHRcdGNvbnRleHQuc2V0QXR0cmlidXRlKCBcImlkXCIsICggbmlkID0galF1ZXJ5LmV4cGFuZG8gKSApO1xuXHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdH1cblxuXHRcdFx0XHRcdC8vIFByZWZpeCBldmVyeSBzZWxlY3RvciBpbiB0aGUgbGlzdFxuXHRcdFx0XHRcdGdyb3VwcyA9IHRva2VuaXplKCBzZWxlY3RvciApO1xuXHRcdFx0XHRcdGkgPSBncm91cHMubGVuZ3RoO1xuXHRcdFx0XHRcdHdoaWxlICggaS0tICkge1xuXHRcdFx0XHRcdFx0Z3JvdXBzWyBpIF0gPSAoIG5pZCA/IFwiI1wiICsgbmlkIDogXCI6c2NvcGVcIiApICsgXCIgXCIgK1xuXHRcdFx0XHRcdFx0XHR0b1NlbGVjdG9yKCBncm91cHNbIGkgXSApO1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0XHRuZXdTZWxlY3RvciA9IGdyb3Vwcy5qb2luKCBcIixcIiApO1xuXHRcdFx0XHR9XG5cblx0XHRcdFx0dHJ5IHtcblx0XHRcdFx0XHRwdXNoLmFwcGx5KCByZXN1bHRzLFxuXHRcdFx0XHRcdFx0bmV3Q29udGV4dC5xdWVyeVNlbGVjdG9yQWxsKCBuZXdTZWxlY3RvciApXG5cdFx0XHRcdFx0KTtcblx0XHRcdFx0XHRyZXR1cm4gcmVzdWx0cztcblx0XHRcdFx0fSBjYXRjaCAoIHFzYUVycm9yICkge1xuXHRcdFx0XHRcdG5vbm5hdGl2ZVNlbGVjdG9yQ2FjaGUoIHNlbGVjdG9yLCB0cnVlICk7XG5cdFx0XHRcdH0gZmluYWxseSB7XG5cdFx0XHRcdFx0aWYgKCBuaWQgPT09IGpRdWVyeS5leHBhbmRvICkge1xuXHRcdFx0XHRcdFx0Y29udGV4dC5yZW1vdmVBdHRyaWJ1dGUoIFwiaWRcIiApO1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0fVxuXHRcdFx0fVxuXHRcdH1cblx0fVxuXG5cdC8vIEFsbCBvdGhlcnNcblx0cmV0dXJuIHNlbGVjdCggc2VsZWN0b3IucmVwbGFjZSggcnRyaW1DU1MsIFwiJDFcIiApLCBjb250ZXh0LCByZXN1bHRzLCBzZWVkICk7XG59XG5cbi8qKlxuICogTWFyayBhIGZ1bmN0aW9uIGZvciBzcGVjaWFsIHVzZSBieSBqUXVlcnkgc2VsZWN0b3IgbW9kdWxlXG4gKiBAcGFyYW0ge0Z1bmN0aW9ufSBmbiBUaGUgZnVuY3Rpb24gdG8gbWFya1xuICovXG5mdW5jdGlvbiBtYXJrRnVuY3Rpb24oIGZuICkge1xuXHRmblsgalF1ZXJ5LmV4cGFuZG8gXSA9IHRydWU7XG5cdHJldHVybiBmbjtcbn1cblxuLyoqXG4gKiBSZXR1cm5zIGEgZnVuY3Rpb24gdG8gdXNlIGluIHBzZXVkb3MgZm9yIGlucHV0IHR5cGVzXG4gKiBAcGFyYW0ge1N0cmluZ30gdHlwZVxuICovXG5mdW5jdGlvbiBjcmVhdGVJbnB1dFBzZXVkbyggdHlwZSApIHtcblx0cmV0dXJuIGZ1bmN0aW9uKCBlbGVtICkge1xuXHRcdHJldHVybiBub2RlTmFtZSggZWxlbSwgXCJpbnB1dFwiICkgJiYgZWxlbS50eXBlID09PSB0eXBlO1xuXHR9O1xufVxuXG4vKipcbiAqIFJldHVybnMgYSBmdW5jdGlvbiB0byB1c2UgaW4gcHNldWRvcyBmb3IgYnV0dG9uc1xuICogQHBhcmFtIHtTdHJpbmd9IHR5cGVcbiAqL1xuZnVuY3Rpb24gY3JlYXRlQnV0dG9uUHNldWRvKCB0eXBlICkge1xuXHRyZXR1cm4gZnVuY3Rpb24oIGVsZW0gKSB7XG5cdFx0cmV0dXJuICggbm9kZU5hbWUoIGVsZW0sIFwiaW5wdXRcIiApIHx8IG5vZGVOYW1lKCBlbGVtLCBcImJ1dHRvblwiICkgKSAmJlxuXHRcdFx0ZWxlbS50eXBlID09PSB0eXBlO1xuXHR9O1xufVxuXG4vKipcbiAqIFJldHVybnMgYSBmdW5jdGlvbiB0byB1c2UgaW4gcHNldWRvcyBmb3IgOmVuYWJsZWQvOmRpc2FibGVkXG4gKiBAcGFyYW0ge0Jvb2xlYW59IGRpc2FibGVkIHRydWUgZm9yIDpkaXNhYmxlZDsgZmFsc2UgZm9yIDplbmFibGVkXG4gKi9cbmZ1bmN0aW9uIGNyZWF0ZURpc2FibGVkUHNldWRvKCBkaXNhYmxlZCApIHtcblxuXHQvLyBLbm93biA6ZGlzYWJsZWQgZmFsc2UgcG9zaXRpdmVzOiBmaWVsZHNldFtkaXNhYmxlZF0gPiBsZWdlbmQ6bnRoLW9mLXR5cGUobisyKSA6Y2FuLWRpc2FibGVcblx0cmV0dXJuIGZ1bmN0aW9uKCBlbGVtICkge1xuXG5cdFx0Ly8gT25seSBjZXJ0YWluIGVsZW1lbnRzIGNhbiBtYXRjaCA6ZW5hYmxlZCBvciA6ZGlzYWJsZWRcblx0XHQvLyBodHRwczovL2h0bWwuc3BlYy53aGF0d2cub3JnL211bHRpcGFnZS9zY3JpcHRpbmcuaHRtbCNzZWxlY3Rvci1lbmFibGVkXG5cdFx0Ly8gaHR0cHM6Ly9odG1sLnNwZWMud2hhdHdnLm9yZy9tdWx0aXBhZ2Uvc2NyaXB0aW5nLmh0bWwjc2VsZWN0b3ItZGlzYWJsZWRcblx0XHRpZiAoIFwiZm9ybVwiIGluIGVsZW0gKSB7XG5cblx0XHRcdC8vIENoZWNrIGZvciBpbmhlcml0ZWQgZGlzYWJsZWRuZXNzIG9uIHJlbGV2YW50IG5vbi1kaXNhYmxlZCBlbGVtZW50czpcblx0XHRcdC8vICogbGlzdGVkIGZvcm0tYXNzb2NpYXRlZCBlbGVtZW50cyBpbiBhIGRpc2FibGVkIGZpZWxkc2V0XG5cdFx0XHQvLyAgIGh0dHBzOi8vaHRtbC5zcGVjLndoYXR3Zy5vcmcvbXVsdGlwYWdlL2Zvcm1zLmh0bWwjY2F0ZWdvcnktbGlzdGVkXG5cdFx0XHQvLyAgIGh0dHBzOi8vaHRtbC5zcGVjLndoYXR3Zy5vcmcvbXVsdGlwYWdlL2Zvcm1zLmh0bWwjY29uY2VwdC1mZS1kaXNhYmxlZFxuXHRcdFx0Ly8gKiBvcHRpb24gZWxlbWVudHMgaW4gYSBkaXNhYmxlZCBvcHRncm91cFxuXHRcdFx0Ly8gICBodHRwczovL2h0bWwuc3BlYy53aGF0d2cub3JnL211bHRpcGFnZS9mb3Jtcy5odG1sI2NvbmNlcHQtb3B0aW9uLWRpc2FibGVkXG5cdFx0XHQvLyBBbGwgc3VjaCBlbGVtZW50cyBoYXZlIGEgXCJmb3JtXCIgcHJvcGVydHkuXG5cdFx0XHRpZiAoIGVsZW0ucGFyZW50Tm9kZSAmJiBlbGVtLmRpc2FibGVkID09PSBmYWxzZSApIHtcblxuXHRcdFx0XHQvLyBPcHRpb24gZWxlbWVudHMgZGVmZXIgdG8gYSBwYXJlbnQgb3B0Z3JvdXAgaWYgcHJlc2VudFxuXHRcdFx0XHRpZiAoIFwibGFiZWxcIiBpbiBlbGVtICkge1xuXHRcdFx0XHRcdGlmICggXCJsYWJlbFwiIGluIGVsZW0ucGFyZW50Tm9kZSApIHtcblx0XHRcdFx0XHRcdHJldHVybiBlbGVtLnBhcmVudE5vZGUuZGlzYWJsZWQgPT09IGRpc2FibGVkO1xuXHRcdFx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdFx0XHRyZXR1cm4gZWxlbS5kaXNhYmxlZCA9PT0gZGlzYWJsZWQ7XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHR9XG5cblx0XHRcdFx0Ly8gU3VwcG9ydDogSUUgNiAtIDExK1xuXHRcdFx0XHQvLyBVc2UgdGhlIGlzRGlzYWJsZWQgc2hvcnRjdXQgcHJvcGVydHkgdG8gY2hlY2sgZm9yIGRpc2FibGVkIGZpZWxkc2V0IGFuY2VzdG9yc1xuXHRcdFx0XHRyZXR1cm4gZWxlbS5pc0Rpc2FibGVkID09PSBkaXNhYmxlZCB8fFxuXG5cdFx0XHRcdFx0Ly8gV2hlcmUgdGhlcmUgaXMgbm8gaXNEaXNhYmxlZCwgY2hlY2sgbWFudWFsbHlcblx0XHRcdFx0XHRlbGVtLmlzRGlzYWJsZWQgIT09ICFkaXNhYmxlZCAmJlxuXHRcdFx0XHRcdFx0aW5EaXNhYmxlZEZpZWxkc2V0KCBlbGVtICkgPT09IGRpc2FibGVkO1xuXHRcdFx0fVxuXG5cdFx0XHRyZXR1cm4gZWxlbS5kaXNhYmxlZCA9PT0gZGlzYWJsZWQ7XG5cblx0XHQvLyBUcnkgdG8gd2lubm93IG91dCBlbGVtZW50cyB0aGF0IGNhbid0IGJlIGRpc2FibGVkIGJlZm9yZSB0cnVzdGluZyB0aGUgZGlzYWJsZWQgcHJvcGVydHkuXG5cdFx0Ly8gU29tZSB2aWN0aW1zIGdldCBjYXVnaHQgaW4gb3VyIG5ldCAobGFiZWwsIGxlZ2VuZCwgbWVudSwgdHJhY2spLCBidXQgaXQgc2hvdWxkbid0XG5cdFx0Ly8gZXZlbiBleGlzdCBvbiB0aGVtLCBsZXQgYWxvbmUgaGF2ZSBhIGJvb2xlYW4gdmFsdWUuXG5cdFx0fSBlbHNlIGlmICggXCJsYWJlbFwiIGluIGVsZW0gKSB7XG5cdFx0XHRyZXR1cm4gZWxlbS5kaXNhYmxlZCA9PT0gZGlzYWJsZWQ7XG5cdFx0fVxuXG5cdFx0Ly8gUmVtYWluaW5nIGVsZW1lbnRzIGFyZSBuZWl0aGVyIDplbmFibGVkIG5vciA6ZGlzYWJsZWRcblx0XHRyZXR1cm4gZmFsc2U7XG5cdH07XG59XG5cbi8qKlxuICogUmV0dXJucyBhIGZ1bmN0aW9uIHRvIHVzZSBpbiBwc2V1ZG9zIGZvciBwb3NpdGlvbmFsc1xuICogQHBhcmFtIHtGdW5jdGlvbn0gZm5cbiAqL1xuZnVuY3Rpb24gY3JlYXRlUG9zaXRpb25hbFBzZXVkbyggZm4gKSB7XG5cdHJldHVybiBtYXJrRnVuY3Rpb24oIGZ1bmN0aW9uKCBhcmd1bWVudCApIHtcblx0XHRhcmd1bWVudCA9ICthcmd1bWVudDtcblx0XHRyZXR1cm4gbWFya0Z1bmN0aW9uKCBmdW5jdGlvbiggc2VlZCwgbWF0Y2hlcyApIHtcblx0XHRcdHZhciBqLFxuXHRcdFx0XHRtYXRjaEluZGV4ZXMgPSBmbiggW10sIHNlZWQubGVuZ3RoLCBhcmd1bWVudCApLFxuXHRcdFx0XHRpID0gbWF0Y2hJbmRleGVzLmxlbmd0aDtcblxuXHRcdFx0Ly8gTWF0Y2ggZWxlbWVudHMgZm91bmQgYXQgdGhlIHNwZWNpZmllZCBpbmRleGVzXG5cdFx0XHR3aGlsZSAoIGktLSApIHtcblx0XHRcdFx0aWYgKCBzZWVkWyAoIGogPSBtYXRjaEluZGV4ZXNbIGkgXSApIF0gKSB7XG5cdFx0XHRcdFx0c2VlZFsgaiBdID0gISggbWF0Y2hlc1sgaiBdID0gc2VlZFsgaiBdICk7XG5cdFx0XHRcdH1cblx0XHRcdH1cblx0XHR9ICk7XG5cdH0gKTtcbn1cblxuLyoqXG4gKiBTZXRzIGRvY3VtZW50LXJlbGF0ZWQgdmFyaWFibGVzIG9uY2UgYmFzZWQgb24gdGhlIGN1cnJlbnQgZG9jdW1lbnRcbiAqIEBwYXJhbSB7RWxlbWVudHxPYmplY3R9IFtub2RlXSBBbiBlbGVtZW50IG9yIGRvY3VtZW50IG9iamVjdCB0byB1c2UgdG8gc2V0IHRoZSBkb2N1bWVudFxuICovXG5mdW5jdGlvbiBzZXREb2N1bWVudCggbm9kZSApIHtcblx0dmFyIHN1YldpbmRvdyxcblx0XHRkb2MgPSBub2RlID8gbm9kZS5vd25lckRvY3VtZW50IHx8IG5vZGUgOiBkb2N1bWVudCQxO1xuXG5cdC8vIFJldHVybiBlYXJseSBpZiBkb2MgaXMgaW52YWxpZCBvciBhbHJlYWR5IHNlbGVjdGVkXG5cdC8vIFN1cHBvcnQ6IElFIDExK1xuXHQvLyBJRSBzb21ldGltZXMgdGhyb3dzIGEgXCJQZXJtaXNzaW9uIGRlbmllZFwiIGVycm9yIHdoZW4gc3RyaWN0LWNvbXBhcmluZ1xuXHQvLyB0d28gZG9jdW1lbnRzOyBzaGFsbG93IGNvbXBhcmlzb25zIHdvcmsuXG5cdC8vIGVzbGludC1kaXNhYmxlLW5leHQtbGluZSBlcWVxZXFcblx0aWYgKCBkb2MgPT0gZG9jdW1lbnQgfHwgZG9jLm5vZGVUeXBlICE9PSA5ICkge1xuXHRcdHJldHVybjtcblx0fVxuXG5cdC8vIFVwZGF0ZSBnbG9iYWwgdmFyaWFibGVzXG5cdGRvY3VtZW50ID0gZG9jO1xuXHRkb2N1bWVudEVsZW1lbnQgPSBkb2N1bWVudC5kb2N1bWVudEVsZW1lbnQ7XG5cdGRvY3VtZW50SXNIVE1MID0gIWpRdWVyeS5pc1hNTERvYyggZG9jdW1lbnQgKTtcblxuXHQvLyBTdXBwb3J0OiBJRSA5IC0gMTErXG5cdC8vIEFjY2Vzc2luZyBpZnJhbWUgZG9jdW1lbnRzIGFmdGVyIHVubG9hZCB0aHJvd3MgXCJwZXJtaXNzaW9uIGRlbmllZFwiIGVycm9ycyAoc2VlIHRyYWMtMTM5MzYpXG5cdC8vIFN1cHBvcnQ6IElFIDExK1xuXHQvLyBJRSBzb21ldGltZXMgdGhyb3dzIGEgXCJQZXJtaXNzaW9uIGRlbmllZFwiIGVycm9yIHdoZW4gc3RyaWN0LWNvbXBhcmluZ1xuXHQvLyB0d28gZG9jdW1lbnRzOyBzaGFsbG93IGNvbXBhcmlzb25zIHdvcmsuXG5cdC8vIGVzbGludC1kaXNhYmxlLW5leHQtbGluZSBlcWVxZXFcblx0aWYgKCBpc0lFICYmIGRvY3VtZW50JDEgIT0gZG9jdW1lbnQgJiZcblx0XHQoIHN1YldpbmRvdyA9IGRvY3VtZW50LmRlZmF1bHRWaWV3ICkgJiYgc3ViV2luZG93LnRvcCAhPT0gc3ViV2luZG93ICkge1xuXHRcdHN1YldpbmRvdy5hZGRFdmVudExpc3RlbmVyKCBcInVubG9hZFwiLCB1bmxvYWRIYW5kbGVyICk7XG5cdH1cbn1cblxuZmluZC5tYXRjaGVzID0gZnVuY3Rpb24oIGV4cHIsIGVsZW1lbnRzICkge1xuXHRyZXR1cm4gZmluZCggZXhwciwgbnVsbCwgbnVsbCwgZWxlbWVudHMgKTtcbn07XG5cbmZpbmQubWF0Y2hlc1NlbGVjdG9yID0gZnVuY3Rpb24oIGVsZW0sIGV4cHIgKSB7XG5cdHNldERvY3VtZW50KCBlbGVtICk7XG5cblx0aWYgKCBkb2N1bWVudElzSFRNTCAmJlxuXHRcdCFub25uYXRpdmVTZWxlY3RvckNhY2hlWyBleHByICsgXCIgXCIgXSAmJlxuXHRcdCggIXJidWdneVFTQSB8fCAhcmJ1Z2d5UVNBLnRlc3QoIGV4cHIgKSApICkge1xuXG5cdFx0dHJ5IHtcblx0XHRcdHJldHVybiBtYXRjaGVzLmNhbGwoIGVsZW0sIGV4cHIgKTtcblx0XHR9IGNhdGNoICggZSApIHtcblx0XHRcdG5vbm5hdGl2ZVNlbGVjdG9yQ2FjaGUoIGV4cHIsIHRydWUgKTtcblx0XHR9XG5cdH1cblxuXHRyZXR1cm4gZmluZCggZXhwciwgZG9jdW1lbnQsIG51bGwsIFsgZWxlbSBdICkubGVuZ3RoID4gMDtcbn07XG5cbmpRdWVyeS5leHByID0ge1xuXG5cdC8vIENhbiBiZSBhZGp1c3RlZCBieSB0aGUgdXNlclxuXHRjYWNoZUxlbmd0aDogNTAsXG5cblx0Y3JlYXRlUHNldWRvOiBtYXJrRnVuY3Rpb24sXG5cblx0bWF0Y2g6IG1hdGNoRXhwcixcblxuXHRmaW5kOiB7XG5cdFx0SUQ6IGZ1bmN0aW9uKCBpZCwgY29udGV4dCApIHtcblx0XHRcdGlmICggdHlwZW9mIGNvbnRleHQuZ2V0RWxlbWVudEJ5SWQgIT09IFwidW5kZWZpbmVkXCIgJiYgZG9jdW1lbnRJc0hUTUwgKSB7XG5cdFx0XHRcdHZhciBlbGVtID0gY29udGV4dC5nZXRFbGVtZW50QnlJZCggaWQgKTtcblx0XHRcdFx0cmV0dXJuIGVsZW0gPyBbIGVsZW0gXSA6IFtdO1xuXHRcdFx0fVxuXHRcdH0sXG5cblx0XHRUQUc6IGZ1bmN0aW9uKCB0YWcsIGNvbnRleHQgKSB7XG5cdFx0XHRpZiAoIHR5cGVvZiBjb250ZXh0LmdldEVsZW1lbnRzQnlUYWdOYW1lICE9PSBcInVuZGVmaW5lZFwiICkge1xuXHRcdFx0XHRyZXR1cm4gY29udGV4dC5nZXRFbGVtZW50c0J5VGFnTmFtZSggdGFnICk7XG5cblx0XHRcdFx0Ly8gRG9jdW1lbnRGcmFnbWVudCBub2RlcyBkb24ndCBoYXZlIGdFQlROXG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRyZXR1cm4gY29udGV4dC5xdWVyeVNlbGVjdG9yQWxsKCB0YWcgKTtcblx0XHRcdH1cblx0XHR9LFxuXG5cdFx0Q0xBU1M6IGZ1bmN0aW9uKCBjbGFzc05hbWUsIGNvbnRleHQgKSB7XG5cdFx0XHRpZiAoIHR5cGVvZiBjb250ZXh0LmdldEVsZW1lbnRzQnlDbGFzc05hbWUgIT09IFwidW5kZWZpbmVkXCIgJiYgZG9jdW1lbnRJc0hUTUwgKSB7XG5cdFx0XHRcdHJldHVybiBjb250ZXh0LmdldEVsZW1lbnRzQnlDbGFzc05hbWUoIGNsYXNzTmFtZSApO1xuXHRcdFx0fVxuXHRcdH1cblx0fSxcblxuXHRyZWxhdGl2ZToge1xuXHRcdFwiPlwiOiB7IGRpcjogXCJwYXJlbnROb2RlXCIsIGZpcnN0OiB0cnVlIH0sXG5cdFx0XCIgXCI6IHsgZGlyOiBcInBhcmVudE5vZGVcIiB9LFxuXHRcdFwiK1wiOiB7IGRpcjogXCJwcmV2aW91c1NpYmxpbmdcIiwgZmlyc3Q6IHRydWUgfSxcblx0XHRcIn5cIjogeyBkaXI6IFwicHJldmlvdXNTaWJsaW5nXCIgfVxuXHR9LFxuXG5cdHByZUZpbHRlcjogcHJlRmlsdGVyLFxuXG5cdGZpbHRlcjoge1xuXHRcdElEOiBmdW5jdGlvbiggaWQgKSB7XG5cdFx0XHR2YXIgYXR0cklkID0gdW5lc2NhcGVTZWxlY3RvciggaWQgKTtcblx0XHRcdHJldHVybiBmdW5jdGlvbiggZWxlbSApIHtcblx0XHRcdFx0cmV0dXJuIGVsZW0uZ2V0QXR0cmlidXRlKCBcImlkXCIgKSA9PT0gYXR0cklkO1xuXHRcdFx0fTtcblx0XHR9LFxuXG5cdFx0VEFHOiBmdW5jdGlvbiggbm9kZU5hbWVTZWxlY3RvciApIHtcblx0XHRcdHZhciBleHBlY3RlZE5vZGVOYW1lID0gdW5lc2NhcGVTZWxlY3Rvciggbm9kZU5hbWVTZWxlY3RvciApLnRvTG93ZXJDYXNlKCk7XG5cdFx0XHRyZXR1cm4gbm9kZU5hbWVTZWxlY3RvciA9PT0gXCIqXCIgP1xuXG5cdFx0XHRcdGZ1bmN0aW9uKCkge1xuXHRcdFx0XHRcdHJldHVybiB0cnVlO1xuXHRcdFx0XHR9IDpcblxuXHRcdFx0XHRmdW5jdGlvbiggZWxlbSApIHtcblx0XHRcdFx0XHRyZXR1cm4gbm9kZU5hbWUoIGVsZW0sIGV4cGVjdGVkTm9kZU5hbWUgKTtcblx0XHRcdFx0fTtcblx0XHR9LFxuXG5cdFx0Q0xBU1M6IGZ1bmN0aW9uKCBjbGFzc05hbWUgKSB7XG5cdFx0XHR2YXIgcGF0dGVybiA9IGNsYXNzQ2FjaGVbIGNsYXNzTmFtZSArIFwiIFwiIF07XG5cblx0XHRcdHJldHVybiBwYXR0ZXJuIHx8XG5cdFx0XHRcdCggcGF0dGVybiA9IG5ldyBSZWdFeHAoIFwiKF58XCIgKyB3aGl0ZXNwYWNlICsgXCIpXCIgKyBjbGFzc05hbWUgK1xuXHRcdFx0XHRcdFwiKFwiICsgd2hpdGVzcGFjZSArIFwifCQpXCIgKSApICYmXG5cdFx0XHRcdGNsYXNzQ2FjaGUoIGNsYXNzTmFtZSwgZnVuY3Rpb24oIGVsZW0gKSB7XG5cdFx0XHRcdFx0cmV0dXJuIHBhdHRlcm4udGVzdChcblx0XHRcdFx0XHRcdHR5cGVvZiBlbGVtLmNsYXNzTmFtZSA9PT0gXCJzdHJpbmdcIiAmJiBlbGVtLmNsYXNzTmFtZSB8fFxuXHRcdFx0XHRcdFx0XHR0eXBlb2YgZWxlbS5nZXRBdHRyaWJ1dGUgIT09IFwidW5kZWZpbmVkXCIgJiZcblx0XHRcdFx0XHRcdFx0XHRlbGVtLmdldEF0dHJpYnV0ZSggXCJjbGFzc1wiICkgfHxcblx0XHRcdFx0XHRcdFx0XCJcIlxuXHRcdFx0XHRcdCk7XG5cdFx0XHRcdH0gKTtcblx0XHR9LFxuXG5cdFx0QVRUUjogZnVuY3Rpb24oIG5hbWUsIG9wZXJhdG9yLCBjaGVjayApIHtcblx0XHRcdHJldHVybiBmdW5jdGlvbiggZWxlbSApIHtcblx0XHRcdFx0dmFyIHJlc3VsdCA9IGpRdWVyeS5hdHRyKCBlbGVtLCBuYW1lICk7XG5cblx0XHRcdFx0aWYgKCByZXN1bHQgPT0gbnVsbCApIHtcblx0XHRcdFx0XHRyZXR1cm4gb3BlcmF0b3IgPT09IFwiIT1cIjtcblx0XHRcdFx0fVxuXHRcdFx0XHRpZiAoICFvcGVyYXRvciApIHtcblx0XHRcdFx0XHRyZXR1cm4gdHJ1ZTtcblx0XHRcdFx0fVxuXG5cdFx0XHRcdHJlc3VsdCArPSBcIlwiO1xuXG5cdFx0XHRcdGlmICggb3BlcmF0b3IgPT09IFwiPVwiICkge1xuXHRcdFx0XHRcdHJldHVybiByZXN1bHQgPT09IGNoZWNrO1xuXHRcdFx0XHR9XG5cdFx0XHRcdGlmICggb3BlcmF0b3IgPT09IFwiIT1cIiApIHtcblx0XHRcdFx0XHRyZXR1cm4gcmVzdWx0ICE9PSBjaGVjaztcblx0XHRcdFx0fVxuXHRcdFx0XHRpZiAoIG9wZXJhdG9yID09PSBcIl49XCIgKSB7XG5cdFx0XHRcdFx0cmV0dXJuIGNoZWNrICYmIHJlc3VsdC5pbmRleE9mKCBjaGVjayApID09PSAwO1xuXHRcdFx0XHR9XG5cdFx0XHRcdGlmICggb3BlcmF0b3IgPT09IFwiKj1cIiApIHtcblx0XHRcdFx0XHRyZXR1cm4gY2hlY2sgJiYgcmVzdWx0LmluZGV4T2YoIGNoZWNrICkgPiAtMTtcblx0XHRcdFx0fVxuXHRcdFx0XHRpZiAoIG9wZXJhdG9yID09PSBcIiQ9XCIgKSB7XG5cdFx0XHRcdFx0cmV0dXJuIGNoZWNrICYmIHJlc3VsdC5zbGljZSggLWNoZWNrLmxlbmd0aCApID09PSBjaGVjaztcblx0XHRcdFx0fVxuXHRcdFx0XHRpZiAoIG9wZXJhdG9yID09PSBcIn49XCIgKSB7XG5cdFx0XHRcdFx0cmV0dXJuICggXCIgXCIgKyByZXN1bHQucmVwbGFjZSggcndoaXRlc3BhY2UsIFwiIFwiICkgKyBcIiBcIiApXG5cdFx0XHRcdFx0XHQuaW5kZXhPZiggY2hlY2sgKSA+IC0xO1xuXHRcdFx0XHR9XG5cdFx0XHRcdGlmICggb3BlcmF0b3IgPT09IFwifD1cIiApIHtcblx0XHRcdFx0XHRyZXR1cm4gcmVzdWx0ID09PSBjaGVjayB8fCByZXN1bHQuc2xpY2UoIDAsIGNoZWNrLmxlbmd0aCArIDEgKSA9PT0gY2hlY2sgKyBcIi1cIjtcblx0XHRcdFx0fVxuXG5cdFx0XHRcdHJldHVybiBmYWxzZTtcblx0XHRcdH07XG5cdFx0fSxcblxuXHRcdENISUxEOiBmdW5jdGlvbiggdHlwZSwgd2hhdCwgX2FyZ3VtZW50LCBmaXJzdCwgbGFzdCApIHtcblx0XHRcdHZhciBzaW1wbGUgPSB0eXBlLnNsaWNlKCAwLCAzICkgIT09IFwibnRoXCIsXG5cdFx0XHRcdGZvcndhcmQgPSB0eXBlLnNsaWNlKCAtNCApICE9PSBcImxhc3RcIixcblx0XHRcdFx0b2ZUeXBlID0gd2hhdCA9PT0gXCJvZi10eXBlXCI7XG5cblx0XHRcdHJldHVybiBmaXJzdCA9PT0gMSAmJiBsYXN0ID09PSAwID9cblxuXHRcdFx0XHQvLyBTaG9ydGN1dCBmb3IgOm50aC0qKG4pXG5cdFx0XHRcdGZ1bmN0aW9uKCBlbGVtICkge1xuXHRcdFx0XHRcdHJldHVybiAhIWVsZW0ucGFyZW50Tm9kZTtcblx0XHRcdFx0fSA6XG5cblx0XHRcdFx0ZnVuY3Rpb24oIGVsZW0sIF9jb250ZXh0LCB4bWwgKSB7XG5cdFx0XHRcdFx0dmFyIGNhY2hlLCBvdXRlckNhY2hlLCBub2RlLCBub2RlSW5kZXgsIHN0YXJ0LFxuXHRcdFx0XHRcdFx0ZGlyID0gc2ltcGxlICE9PSBmb3J3YXJkID8gXCJuZXh0U2libGluZ1wiIDogXCJwcmV2aW91c1NpYmxpbmdcIixcblx0XHRcdFx0XHRcdHBhcmVudCA9IGVsZW0ucGFyZW50Tm9kZSxcblx0XHRcdFx0XHRcdG5hbWUgPSBvZlR5cGUgJiYgZWxlbS5ub2RlTmFtZS50b0xvd2VyQ2FzZSgpLFxuXHRcdFx0XHRcdFx0dXNlQ2FjaGUgPSAheG1sICYmICFvZlR5cGUsXG5cdFx0XHRcdFx0XHRkaWZmID0gZmFsc2U7XG5cblx0XHRcdFx0XHRpZiAoIHBhcmVudCApIHtcblxuXHRcdFx0XHRcdFx0Ly8gOihmaXJzdHxsYXN0fG9ubHkpLShjaGlsZHxvZi10eXBlKVxuXHRcdFx0XHRcdFx0aWYgKCBzaW1wbGUgKSB7XG5cdFx0XHRcdFx0XHRcdHdoaWxlICggZGlyICkge1xuXHRcdFx0XHRcdFx0XHRcdG5vZGUgPSBlbGVtO1xuXHRcdFx0XHRcdFx0XHRcdHdoaWxlICggKCBub2RlID0gbm9kZVsgZGlyIF0gKSApIHtcblx0XHRcdFx0XHRcdFx0XHRcdGlmICggb2ZUeXBlID9cblx0XHRcdFx0XHRcdFx0XHRcdFx0bm9kZU5hbWUoIG5vZGUsIG5hbWUgKSA6XG5cdFx0XHRcdFx0XHRcdFx0XHRcdG5vZGUubm9kZVR5cGUgPT09IDEgKSB7XG5cblx0XHRcdFx0XHRcdFx0XHRcdFx0cmV0dXJuIGZhbHNlO1xuXHRcdFx0XHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdFx0XHRcdH1cblxuXHRcdFx0XHRcdFx0XHRcdC8vIFJldmVyc2UgZGlyZWN0aW9uIGZvciA6b25seS0qIChpZiB3ZSBoYXZlbid0IHlldCBkb25lIHNvKVxuXHRcdFx0XHRcdFx0XHRcdHN0YXJ0ID0gZGlyID0gdHlwZSA9PT0gXCJvbmx5XCIgJiYgIXN0YXJ0ICYmIFwibmV4dFNpYmxpbmdcIjtcblx0XHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdFx0XHRyZXR1cm4gdHJ1ZTtcblx0XHRcdFx0XHRcdH1cblxuXHRcdFx0XHRcdFx0c3RhcnQgPSBbIGZvcndhcmQgPyBwYXJlbnQuZmlyc3RDaGlsZCA6IHBhcmVudC5sYXN0Q2hpbGQgXTtcblxuXHRcdFx0XHRcdFx0Ly8gbm9uLXhtbCA6bnRoLWNoaWxkKC4uLikgc3RvcmVzIGNhY2hlIGRhdGEgb24gYHBhcmVudGBcblx0XHRcdFx0XHRcdGlmICggZm9yd2FyZCAmJiB1c2VDYWNoZSApIHtcblxuXHRcdFx0XHRcdFx0XHQvLyBTZWVrIGBlbGVtYCBmcm9tIGEgcHJldmlvdXNseS1jYWNoZWQgaW5kZXhcblx0XHRcdFx0XHRcdFx0b3V0ZXJDYWNoZSA9IHBhcmVudFsgalF1ZXJ5LmV4cGFuZG8gXSB8fFxuXHRcdFx0XHRcdFx0XHRcdCggcGFyZW50WyBqUXVlcnkuZXhwYW5kbyBdID0ge30gKTtcblx0XHRcdFx0XHRcdFx0Y2FjaGUgPSBvdXRlckNhY2hlWyB0eXBlIF0gfHwgW107XG5cdFx0XHRcdFx0XHRcdG5vZGVJbmRleCA9IGNhY2hlWyAwIF0gPT09IGRpcnJ1bnMgJiYgY2FjaGVbIDEgXTtcblx0XHRcdFx0XHRcdFx0ZGlmZiA9IG5vZGVJbmRleCAmJiBjYWNoZVsgMiBdO1xuXHRcdFx0XHRcdFx0XHRub2RlID0gbm9kZUluZGV4ICYmIHBhcmVudC5jaGlsZE5vZGVzWyBub2RlSW5kZXggXTtcblxuXHRcdFx0XHRcdFx0XHR3aGlsZSAoICggbm9kZSA9ICsrbm9kZUluZGV4ICYmIG5vZGUgJiYgbm9kZVsgZGlyIF0gfHxcblxuXHRcdFx0XHRcdFx0XHRcdC8vIEZhbGxiYWNrIHRvIHNlZWtpbmcgYGVsZW1gIGZyb20gdGhlIHN0YXJ0XG5cdFx0XHRcdFx0XHRcdFx0KCBkaWZmID0gbm9kZUluZGV4ID0gMCApIHx8IHN0YXJ0LnBvcCgpICkgKSB7XG5cblx0XHRcdFx0XHRcdFx0XHQvLyBXaGVuIGZvdW5kLCBjYWNoZSBpbmRleGVzIG9uIGBwYXJlbnRgIGFuZCBicmVha1xuXHRcdFx0XHRcdFx0XHRcdGlmICggbm9kZS5ub2RlVHlwZSA9PT0gMSAmJiArK2RpZmYgJiYgbm9kZSA9PT0gZWxlbSApIHtcblx0XHRcdFx0XHRcdFx0XHRcdG91dGVyQ2FjaGVbIHR5cGUgXSA9IFsgZGlycnVucywgbm9kZUluZGV4LCBkaWZmIF07XG5cdFx0XHRcdFx0XHRcdFx0XHRicmVhaztcblx0XHRcdFx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0XHRcdH1cblxuXHRcdFx0XHRcdFx0fSBlbHNlIHtcblxuXHRcdFx0XHRcdFx0XHQvLyBVc2UgcHJldmlvdXNseS1jYWNoZWQgZWxlbWVudCBpbmRleCBpZiBhdmFpbGFibGVcblx0XHRcdFx0XHRcdFx0aWYgKCB1c2VDYWNoZSApIHtcblx0XHRcdFx0XHRcdFx0XHRvdXRlckNhY2hlID0gZWxlbVsgalF1ZXJ5LmV4cGFuZG8gXSB8fFxuXHRcdFx0XHRcdFx0XHRcdFx0KCBlbGVtWyBqUXVlcnkuZXhwYW5kbyBdID0ge30gKTtcblx0XHRcdFx0XHRcdFx0XHRjYWNoZSA9IG91dGVyQ2FjaGVbIHR5cGUgXSB8fCBbXTtcblx0XHRcdFx0XHRcdFx0XHRub2RlSW5kZXggPSBjYWNoZVsgMCBdID09PSBkaXJydW5zICYmIGNhY2hlWyAxIF07XG5cdFx0XHRcdFx0XHRcdFx0ZGlmZiA9IG5vZGVJbmRleDtcblx0XHRcdFx0XHRcdFx0fVxuXG5cdFx0XHRcdFx0XHRcdC8vIHhtbCA6bnRoLWNoaWxkKC4uLilcblx0XHRcdFx0XHRcdFx0Ly8gb3IgOm50aC1sYXN0LWNoaWxkKC4uLikgb3IgOm50aCgtbGFzdCk/LW9mLXR5cGUoLi4uKVxuXHRcdFx0XHRcdFx0XHRpZiAoIGRpZmYgPT09IGZhbHNlICkge1xuXG5cdFx0XHRcdFx0XHRcdFx0Ly8gVXNlIHRoZSBzYW1lIGxvb3AgYXMgYWJvdmUgdG8gc2VlayBgZWxlbWAgZnJvbSB0aGUgc3RhcnRcblx0XHRcdFx0XHRcdFx0XHR3aGlsZSAoICggbm9kZSA9ICsrbm9kZUluZGV4ICYmIG5vZGUgJiYgbm9kZVsgZGlyIF0gfHxcblx0XHRcdFx0XHRcdFx0XHRcdCggZGlmZiA9IG5vZGVJbmRleCA9IDAgKSB8fCBzdGFydC5wb3AoKSApICkge1xuXG5cdFx0XHRcdFx0XHRcdFx0XHRpZiAoICggb2ZUeXBlID9cblx0XHRcdFx0XHRcdFx0XHRcdFx0bm9kZU5hbWUoIG5vZGUsIG5hbWUgKSA6XG5cdFx0XHRcdFx0XHRcdFx0XHRcdG5vZGUubm9kZVR5cGUgPT09IDEgKSAmJlxuXHRcdFx0XHRcdFx0XHRcdFx0XHQrK2RpZmYgKSB7XG5cblx0XHRcdFx0XHRcdFx0XHRcdFx0Ly8gQ2FjaGUgdGhlIGluZGV4IG9mIGVhY2ggZW5jb3VudGVyZWQgZWxlbWVudFxuXHRcdFx0XHRcdFx0XHRcdFx0XHRpZiAoIHVzZUNhY2hlICkge1xuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdG91dGVyQ2FjaGUgPSBub2RlWyBqUXVlcnkuZXhwYW5kbyBdIHx8XG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHQoIG5vZGVbIGpRdWVyeS5leHBhbmRvIF0gPSB7fSApO1xuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdG91dGVyQ2FjaGVbIHR5cGUgXSA9IFsgZGlycnVucywgZGlmZiBdO1xuXHRcdFx0XHRcdFx0XHRcdFx0XHR9XG5cblx0XHRcdFx0XHRcdFx0XHRcdFx0aWYgKCBub2RlID09PSBlbGVtICkge1xuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdGJyZWFrO1xuXHRcdFx0XHRcdFx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0XHR9XG5cblx0XHRcdFx0XHRcdC8vIEluY29ycG9yYXRlIHRoZSBvZmZzZXQsIHRoZW4gY2hlY2sgYWdhaW5zdCBjeWNsZSBzaXplXG5cdFx0XHRcdFx0XHRkaWZmIC09IGxhc3Q7XG5cdFx0XHRcdFx0XHRyZXR1cm4gZGlmZiA9PT0gZmlyc3QgfHwgKCBkaWZmICUgZmlyc3QgPT09IDAgJiYgZGlmZiAvIGZpcnN0ID49IDAgKTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH07XG5cdFx0fSxcblxuXHRcdFBTRVVETzogZnVuY3Rpb24oIHBzZXVkbywgYXJndW1lbnQgKSB7XG5cblx0XHRcdC8vIHBzZXVkby1jbGFzcyBuYW1lcyBhcmUgY2FzZS1pbnNlbnNpdGl2ZVxuXHRcdFx0Ly8gaHR0cHM6Ly93d3cudzMub3JnL1RSL3NlbGVjdG9ycy8jcHNldWRvLWNsYXNzZXNcblx0XHRcdC8vIFByaW9yaXRpemUgYnkgY2FzZSBzZW5zaXRpdml0eSBpbiBjYXNlIGN1c3RvbSBwc2V1ZG9zIGFyZSBhZGRlZCB3aXRoIHVwcGVyY2FzZSBsZXR0ZXJzXG5cdFx0XHQvLyBSZW1lbWJlciB0aGF0IHNldEZpbHRlcnMgaW5oZXJpdHMgZnJvbSBwc2V1ZG9zXG5cdFx0XHR2YXIgZm4gPSBqUXVlcnkuZXhwci5wc2V1ZG9zWyBwc2V1ZG8gXSB8fFxuXHRcdFx0XHRqUXVlcnkuZXhwci5zZXRGaWx0ZXJzWyBwc2V1ZG8udG9Mb3dlckNhc2UoKSBdIHx8XG5cdFx0XHRcdHNlbGVjdG9yRXJyb3IoIFwidW5zdXBwb3J0ZWQgcHNldWRvOiBcIiArIHBzZXVkbyApO1xuXG5cdFx0XHQvLyBUaGUgdXNlciBtYXkgdXNlIGNyZWF0ZVBzZXVkbyB0byBpbmRpY2F0ZSB0aGF0XG5cdFx0XHQvLyBhcmd1bWVudHMgYXJlIG5lZWRlZCB0byBjcmVhdGUgdGhlIGZpbHRlciBmdW5jdGlvblxuXHRcdFx0Ly8ganVzdCBhcyBqUXVlcnkgZG9lc1xuXHRcdFx0aWYgKCBmblsgalF1ZXJ5LmV4cGFuZG8gXSApIHtcblx0XHRcdFx0cmV0dXJuIGZuKCBhcmd1bWVudCApO1xuXHRcdFx0fVxuXG5cdFx0XHRyZXR1cm4gZm47XG5cdFx0fVxuXHR9LFxuXG5cdHBzZXVkb3M6IHtcblxuXHRcdC8vIFBvdGVudGlhbGx5IGNvbXBsZXggcHNldWRvc1xuXHRcdG5vdDogbWFya0Z1bmN0aW9uKCBmdW5jdGlvbiggc2VsZWN0b3IgKSB7XG5cblx0XHRcdC8vIFRyaW0gdGhlIHNlbGVjdG9yIHBhc3NlZCB0byBjb21waWxlXG5cdFx0XHQvLyB0byBhdm9pZCB0cmVhdGluZyBsZWFkaW5nIGFuZCB0cmFpbGluZ1xuXHRcdFx0Ly8gc3BhY2VzIGFzIGNvbWJpbmF0b3JzXG5cdFx0XHR2YXIgaW5wdXQgPSBbXSxcblx0XHRcdFx0cmVzdWx0cyA9IFtdLFxuXHRcdFx0XHRtYXRjaGVyID0gY29tcGlsZSggc2VsZWN0b3IucmVwbGFjZSggcnRyaW1DU1MsIFwiJDFcIiApICk7XG5cblx0XHRcdHJldHVybiBtYXRjaGVyWyBqUXVlcnkuZXhwYW5kbyBdID9cblx0XHRcdFx0bWFya0Z1bmN0aW9uKCBmdW5jdGlvbiggc2VlZCwgbWF0Y2hlcywgX2NvbnRleHQsIHhtbCApIHtcblx0XHRcdFx0XHR2YXIgZWxlbSxcblx0XHRcdFx0XHRcdHVubWF0Y2hlZCA9IG1hdGNoZXIoIHNlZWQsIG51bGwsIHhtbCwgW10gKSxcblx0XHRcdFx0XHRcdGkgPSBzZWVkLmxlbmd0aDtcblxuXHRcdFx0XHRcdC8vIE1hdGNoIGVsZW1lbnRzIHVubWF0Y2hlZCBieSBgbWF0Y2hlcmBcblx0XHRcdFx0XHR3aGlsZSAoIGktLSApIHtcblx0XHRcdFx0XHRcdGlmICggKCBlbGVtID0gdW5tYXRjaGVkWyBpIF0gKSApIHtcblx0XHRcdFx0XHRcdFx0c2VlZFsgaSBdID0gISggbWF0Y2hlc1sgaSBdID0gZWxlbSApO1xuXHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdH1cblx0XHRcdFx0fSApIDpcblx0XHRcdFx0ZnVuY3Rpb24oIGVsZW0sIF9jb250ZXh0LCB4bWwgKSB7XG5cdFx0XHRcdFx0aW5wdXRbIDAgXSA9IGVsZW07XG5cdFx0XHRcdFx0bWF0Y2hlciggaW5wdXQsIG51bGwsIHhtbCwgcmVzdWx0cyApO1xuXG5cdFx0XHRcdFx0Ly8gRG9uJ3Qga2VlcCB0aGUgZWxlbWVudFxuXHRcdFx0XHRcdC8vIChzZWUgaHR0cHM6Ly9naXRodWIuY29tL2pxdWVyeS9zaXp6bGUvaXNzdWVzLzI5OSlcblx0XHRcdFx0XHRpbnB1dFsgMCBdID0gbnVsbDtcblx0XHRcdFx0XHRyZXR1cm4gIXJlc3VsdHMucG9wKCk7XG5cdFx0XHRcdH07XG5cdFx0fSApLFxuXG5cdFx0aGFzOiBtYXJrRnVuY3Rpb24oIGZ1bmN0aW9uKCBzZWxlY3RvciApIHtcblx0XHRcdHJldHVybiBmdW5jdGlvbiggZWxlbSApIHtcblx0XHRcdFx0cmV0dXJuIGZpbmQoIHNlbGVjdG9yLCBlbGVtICkubGVuZ3RoID4gMDtcblx0XHRcdH07XG5cdFx0fSApLFxuXG5cdFx0Y29udGFpbnM6IG1hcmtGdW5jdGlvbiggZnVuY3Rpb24oIHRleHQgKSB7XG5cdFx0XHR0ZXh0ID0gdW5lc2NhcGVTZWxlY3RvciggdGV4dCApO1xuXHRcdFx0cmV0dXJuIGZ1bmN0aW9uKCBlbGVtICkge1xuXHRcdFx0XHRyZXR1cm4gKCBlbGVtLnRleHRDb250ZW50IHx8IGpRdWVyeS50ZXh0KCBlbGVtICkgKS5pbmRleE9mKCB0ZXh0ICkgPiAtMTtcblx0XHRcdH07XG5cdFx0fSApLFxuXG5cdFx0Ly8gXCJXaGV0aGVyIGFuIGVsZW1lbnQgaXMgcmVwcmVzZW50ZWQgYnkgYSA6bGFuZygpIHNlbGVjdG9yXG5cdFx0Ly8gaXMgYmFzZWQgc29sZWx5IG9uIHRoZSBlbGVtZW50J3MgbGFuZ3VhZ2UgdmFsdWVcblx0XHQvLyBiZWluZyBlcXVhbCB0byB0aGUgaWRlbnRpZmllciBDLFxuXHRcdC8vIG9yIGJlZ2lubmluZyB3aXRoIHRoZSBpZGVudGlmaWVyIEMgaW1tZWRpYXRlbHkgZm9sbG93ZWQgYnkgXCItXCIuXG5cdFx0Ly8gVGhlIG1hdGNoaW5nIG9mIEMgYWdhaW5zdCB0aGUgZWxlbWVudCdzIGxhbmd1YWdlIHZhbHVlIGlzIHBlcmZvcm1lZCBjYXNlLWluc2Vuc2l0aXZlbHkuXG5cdFx0Ly8gVGhlIGlkZW50aWZpZXIgQyBkb2VzIG5vdCBoYXZlIHRvIGJlIGEgdmFsaWQgbGFuZ3VhZ2UgbmFtZS5cIlxuXHRcdC8vIGh0dHBzOi8vd3d3LnczLm9yZy9UUi9zZWxlY3RvcnMvI2xhbmctcHNldWRvXG5cdFx0bGFuZzogbWFya0Z1bmN0aW9uKCBmdW5jdGlvbiggbGFuZyApIHtcblxuXHRcdFx0Ly8gbGFuZyB2YWx1ZSBtdXN0IGJlIGEgdmFsaWQgaWRlbnRpZmllclxuXHRcdFx0aWYgKCAhcmlkZW50aWZpZXIudGVzdCggbGFuZyB8fCBcIlwiICkgKSB7XG5cdFx0XHRcdHNlbGVjdG9yRXJyb3IoIFwidW5zdXBwb3J0ZWQgbGFuZzogXCIgKyBsYW5nICk7XG5cdFx0XHR9XG5cdFx0XHRsYW5nID0gdW5lc2NhcGVTZWxlY3RvciggbGFuZyApLnRvTG93ZXJDYXNlKCk7XG5cdFx0XHRyZXR1cm4gZnVuY3Rpb24oIGVsZW0gKSB7XG5cdFx0XHRcdHZhciBlbGVtTGFuZztcblx0XHRcdFx0ZG8ge1xuXHRcdFx0XHRcdGlmICggKCBlbGVtTGFuZyA9IGRvY3VtZW50SXNIVE1MID9cblx0XHRcdFx0XHRcdGVsZW0ubGFuZyA6XG5cdFx0XHRcdFx0XHRlbGVtLmdldEF0dHJpYnV0ZSggXCJ4bWw6bGFuZ1wiICkgfHwgZWxlbS5nZXRBdHRyaWJ1dGUoIFwibGFuZ1wiICkgKSApIHtcblxuXHRcdFx0XHRcdFx0ZWxlbUxhbmcgPSBlbGVtTGFuZy50b0xvd2VyQ2FzZSgpO1xuXHRcdFx0XHRcdFx0cmV0dXJuIGVsZW1MYW5nID09PSBsYW5nIHx8IGVsZW1MYW5nLmluZGV4T2YoIGxhbmcgKyBcIi1cIiApID09PSAwO1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0fSB3aGlsZSAoICggZWxlbSA9IGVsZW0ucGFyZW50Tm9kZSApICYmIGVsZW0ubm9kZVR5cGUgPT09IDEgKTtcblx0XHRcdFx0cmV0dXJuIGZhbHNlO1xuXHRcdFx0fTtcblx0XHR9ICksXG5cblx0XHQvLyBNaXNjZWxsYW5lb3VzXG5cdFx0dGFyZ2V0OiBmdW5jdGlvbiggZWxlbSApIHtcblx0XHRcdHZhciBoYXNoID0gd2luZG93LmxvY2F0aW9uICYmIHdpbmRvdy5sb2NhdGlvbi5oYXNoO1xuXHRcdFx0cmV0dXJuIGhhc2ggJiYgaGFzaC5zbGljZSggMSApID09PSBlbGVtLmlkO1xuXHRcdH0sXG5cblx0XHRyb290OiBmdW5jdGlvbiggZWxlbSApIHtcblx0XHRcdHJldHVybiBlbGVtID09PSBkb2N1bWVudEVsZW1lbnQ7XG5cdFx0fSxcblxuXHRcdGZvY3VzOiBmdW5jdGlvbiggZWxlbSApIHtcblx0XHRcdHJldHVybiBlbGVtID09PSBkb2N1bWVudC5hY3RpdmVFbGVtZW50ICYmXG5cdFx0XHRcdGRvY3VtZW50Lmhhc0ZvY3VzKCkgJiZcblx0XHRcdFx0ISEoIGVsZW0udHlwZSB8fCBlbGVtLmhyZWYgfHwgfmVsZW0udGFiSW5kZXggKTtcblx0XHR9LFxuXG5cdFx0Ly8gQm9vbGVhbiBwcm9wZXJ0aWVzXG5cdFx0ZW5hYmxlZDogY3JlYXRlRGlzYWJsZWRQc2V1ZG8oIGZhbHNlICksXG5cdFx0ZGlzYWJsZWQ6IGNyZWF0ZURpc2FibGVkUHNldWRvKCB0cnVlICksXG5cblx0XHRjaGVja2VkOiBmdW5jdGlvbiggZWxlbSApIHtcblxuXHRcdFx0Ly8gSW4gQ1NTMywgOmNoZWNrZWQgc2hvdWxkIHJldHVybiBib3RoIGNoZWNrZWQgYW5kIHNlbGVjdGVkIGVsZW1lbnRzXG5cdFx0XHQvLyBodHRwczovL3d3dy53My5vcmcvVFIvMjAxMS9SRUMtY3NzMy1zZWxlY3RvcnMtMjAxMTA5MjkvI2NoZWNrZWRcblx0XHRcdHJldHVybiAoIG5vZGVOYW1lKCBlbGVtLCBcImlucHV0XCIgKSAmJiAhIWVsZW0uY2hlY2tlZCApIHx8XG5cdFx0XHRcdCggbm9kZU5hbWUoIGVsZW0sIFwib3B0aW9uXCIgKSAmJiAhIWVsZW0uc2VsZWN0ZWQgKTtcblx0XHR9LFxuXG5cdFx0c2VsZWN0ZWQ6IGZ1bmN0aW9uKCBlbGVtICkge1xuXG5cdFx0XHQvLyBTdXBwb3J0OiBJRSA8PTExK1xuXHRcdFx0Ly8gQWNjZXNzaW5nIHRoZSBzZWxlY3RlZEluZGV4IHByb3BlcnR5XG5cdFx0XHQvLyBmb3JjZXMgdGhlIGJyb3dzZXIgdG8gdHJlYXQgdGhlIGRlZmF1bHQgb3B0aW9uIGFzXG5cdFx0XHQvLyBzZWxlY3RlZCB3aGVuIGluIGFuIG9wdGdyb3VwLlxuXHRcdFx0aWYgKCBpc0lFICYmIGVsZW0ucGFyZW50Tm9kZSApIHtcblx0XHRcdFx0Ly8gZXNsaW50LWRpc2FibGUtbmV4dC1saW5lIG5vLXVudXNlZC1leHByZXNzaW9uc1xuXHRcdFx0XHRlbGVtLnBhcmVudE5vZGUuc2VsZWN0ZWRJbmRleDtcblx0XHRcdH1cblxuXHRcdFx0cmV0dXJuIGVsZW0uc2VsZWN0ZWQgPT09IHRydWU7XG5cdFx0fSxcblxuXHRcdC8vIENvbnRlbnRzXG5cdFx0ZW1wdHk6IGZ1bmN0aW9uKCBlbGVtICkge1xuXG5cdFx0XHQvLyBodHRwczovL3d3dy53My5vcmcvVFIvc2VsZWN0b3JzLyNlbXB0eS1wc2V1ZG9cblx0XHRcdC8vIDplbXB0eSBpcyBuZWdhdGVkIGJ5IGVsZW1lbnQgKDEpIG9yIGNvbnRlbnQgbm9kZXMgKHRleHQ6IDM7IGNkYXRhOiA0OyBlbnRpdHkgcmVmOiA1KSxcblx0XHRcdC8vICAgYnV0IG5vdCBieSBvdGhlcnMgKGNvbW1lbnQ6IDg7IHByb2Nlc3NpbmcgaW5zdHJ1Y3Rpb246IDc7IGV0Yy4pXG5cdFx0XHQvLyBub2RlVHlwZSA8IDYgd29ya3MgYmVjYXVzZSBhdHRyaWJ1dGVzICgyKSBkbyBub3QgYXBwZWFyIGFzIGNoaWxkcmVuXG5cdFx0XHRmb3IgKCBlbGVtID0gZWxlbS5maXJzdENoaWxkOyBlbGVtOyBlbGVtID0gZWxlbS5uZXh0U2libGluZyApIHtcblx0XHRcdFx0aWYgKCBlbGVtLm5vZGVUeXBlIDwgNiApIHtcblx0XHRcdFx0XHRyZXR1cm4gZmFsc2U7XG5cdFx0XHRcdH1cblx0XHRcdH1cblx0XHRcdHJldHVybiB0cnVlO1xuXHRcdH0sXG5cblx0XHRwYXJlbnQ6IGZ1bmN0aW9uKCBlbGVtICkge1xuXHRcdFx0cmV0dXJuICFqUXVlcnkuZXhwci5wc2V1ZG9zLmVtcHR5KCBlbGVtICk7XG5cdFx0fSxcblxuXHRcdC8vIEVsZW1lbnQvaW5wdXQgdHlwZXNcblx0XHRoZWFkZXI6IGZ1bmN0aW9uKCBlbGVtICkge1xuXHRcdFx0cmV0dXJuIHJoZWFkZXIudGVzdCggZWxlbS5ub2RlTmFtZSApO1xuXHRcdH0sXG5cblx0XHRpbnB1dDogZnVuY3Rpb24oIGVsZW0gKSB7XG5cdFx0XHRyZXR1cm4gcmlucHV0cy50ZXN0KCBlbGVtLm5vZGVOYW1lICk7XG5cdFx0fSxcblxuXHRcdGJ1dHRvbjogZnVuY3Rpb24oIGVsZW0gKSB7XG5cdFx0XHRyZXR1cm4gbm9kZU5hbWUoIGVsZW0sIFwiaW5wdXRcIiApICYmIGVsZW0udHlwZSA9PT0gXCJidXR0b25cIiB8fFxuXHRcdFx0XHRub2RlTmFtZSggZWxlbSwgXCJidXR0b25cIiApO1xuXHRcdH0sXG5cblx0XHR0ZXh0OiBmdW5jdGlvbiggZWxlbSApIHtcblx0XHRcdHJldHVybiBub2RlTmFtZSggZWxlbSwgXCJpbnB1dFwiICkgJiYgZWxlbS50eXBlID09PSBcInRleHRcIjtcblx0XHR9LFxuXG5cdFx0Ly8gUG9zaXRpb24taW4tY29sbGVjdGlvblxuXHRcdGZpcnN0OiBjcmVhdGVQb3NpdGlvbmFsUHNldWRvKCBmdW5jdGlvbigpIHtcblx0XHRcdHJldHVybiBbIDAgXTtcblx0XHR9ICksXG5cblx0XHRsYXN0OiBjcmVhdGVQb3NpdGlvbmFsUHNldWRvKCBmdW5jdGlvbiggX21hdGNoSW5kZXhlcywgbGVuZ3RoICkge1xuXHRcdFx0cmV0dXJuIFsgbGVuZ3RoIC0gMSBdO1xuXHRcdH0gKSxcblxuXHRcdGVxOiBjcmVhdGVQb3NpdGlvbmFsUHNldWRvKCBmdW5jdGlvbiggX21hdGNoSW5kZXhlcywgbGVuZ3RoLCBhcmd1bWVudCApIHtcblx0XHRcdHJldHVybiBbIGFyZ3VtZW50IDwgMCA/IGFyZ3VtZW50ICsgbGVuZ3RoIDogYXJndW1lbnQgXTtcblx0XHR9ICksXG5cblx0XHRldmVuOiBjcmVhdGVQb3NpdGlvbmFsUHNldWRvKCBmdW5jdGlvbiggbWF0Y2hJbmRleGVzLCBsZW5ndGggKSB7XG5cdFx0XHR2YXIgaSA9IDA7XG5cdFx0XHRmb3IgKCA7IGkgPCBsZW5ndGg7IGkgKz0gMiApIHtcblx0XHRcdFx0bWF0Y2hJbmRleGVzLnB1c2goIGkgKTtcblx0XHRcdH1cblx0XHRcdHJldHVybiBtYXRjaEluZGV4ZXM7XG5cdFx0fSApLFxuXG5cdFx0b2RkOiBjcmVhdGVQb3NpdGlvbmFsUHNldWRvKCBmdW5jdGlvbiggbWF0Y2hJbmRleGVzLCBsZW5ndGggKSB7XG5cdFx0XHR2YXIgaSA9IDE7XG5cdFx0XHRmb3IgKCA7IGkgPCBsZW5ndGg7IGkgKz0gMiApIHtcblx0XHRcdFx0bWF0Y2hJbmRleGVzLnB1c2goIGkgKTtcblx0XHRcdH1cblx0XHRcdHJldHVybiBtYXRjaEluZGV4ZXM7XG5cdFx0fSApLFxuXG5cdFx0bHQ6IGNyZWF0ZVBvc2l0aW9uYWxQc2V1ZG8oIGZ1bmN0aW9uKCBtYXRjaEluZGV4ZXMsIGxlbmd0aCwgYXJndW1lbnQgKSB7XG5cdFx0XHR2YXIgaTtcblxuXHRcdFx0aWYgKCBhcmd1bWVudCA8IDAgKSB7XG5cdFx0XHRcdGkgPSBhcmd1bWVudCArIGxlbmd0aDtcblx0XHRcdH0gZWxzZSBpZiAoIGFyZ3VtZW50ID4gbGVuZ3RoICkge1xuXHRcdFx0XHRpID0gbGVuZ3RoO1xuXHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0aSA9IGFyZ3VtZW50O1xuXHRcdFx0fVxuXG5cdFx0XHRmb3IgKCA7IC0taSA+PSAwOyApIHtcblx0XHRcdFx0bWF0Y2hJbmRleGVzLnB1c2goIGkgKTtcblx0XHRcdH1cblx0XHRcdHJldHVybiBtYXRjaEluZGV4ZXM7XG5cdFx0fSApLFxuXG5cdFx0Z3Q6IGNyZWF0ZVBvc2l0aW9uYWxQc2V1ZG8oIGZ1bmN0aW9uKCBtYXRjaEluZGV4ZXMsIGxlbmd0aCwgYXJndW1lbnQgKSB7XG5cdFx0XHR2YXIgaSA9IGFyZ3VtZW50IDwgMCA/IGFyZ3VtZW50ICsgbGVuZ3RoIDogYXJndW1lbnQ7XG5cdFx0XHRmb3IgKCA7ICsraSA8IGxlbmd0aDsgKSB7XG5cdFx0XHRcdG1hdGNoSW5kZXhlcy5wdXNoKCBpICk7XG5cdFx0XHR9XG5cdFx0XHRyZXR1cm4gbWF0Y2hJbmRleGVzO1xuXHRcdH0gKVxuXHR9XG59O1xuXG5qUXVlcnkuZXhwci5wc2V1ZG9zLm50aCA9IGpRdWVyeS5leHByLnBzZXVkb3MuZXE7XG5cbi8vIEFkZCBidXR0b24vaW5wdXQgdHlwZSBwc2V1ZG9zXG5mb3IgKCBpIGluIHsgcmFkaW86IHRydWUsIGNoZWNrYm94OiB0cnVlLCBmaWxlOiB0cnVlLCBwYXNzd29yZDogdHJ1ZSwgaW1hZ2U6IHRydWUgfSApIHtcblx0alF1ZXJ5LmV4cHIucHNldWRvc1sgaSBdID0gY3JlYXRlSW5wdXRQc2V1ZG8oIGkgKTtcbn1cbmZvciAoIGkgaW4geyBzdWJtaXQ6IHRydWUsIHJlc2V0OiB0cnVlIH0gKSB7XG5cdGpRdWVyeS5leHByLnBzZXVkb3NbIGkgXSA9IGNyZWF0ZUJ1dHRvblBzZXVkbyggaSApO1xufVxuXG4vLyBFYXN5IEFQSSBmb3IgY3JlYXRpbmcgbmV3IHNldEZpbHRlcnNcbmZ1bmN0aW9uIHNldEZpbHRlcnMoKSB7fVxuc2V0RmlsdGVycy5wcm90b3R5cGUgPSBqUXVlcnkuZXhwci5wc2V1ZG9zO1xualF1ZXJ5LmV4cHIuc2V0RmlsdGVycyA9IG5ldyBzZXRGaWx0ZXJzKCk7XG5cbmZ1bmN0aW9uIGFkZENvbWJpbmF0b3IoIG1hdGNoZXIsIGNvbWJpbmF0b3IsIGJhc2UgKSB7XG5cdHZhciBkaXIgPSBjb21iaW5hdG9yLmRpcixcblx0XHRza2lwID0gY29tYmluYXRvci5uZXh0LFxuXHRcdGtleSA9IHNraXAgfHwgZGlyLFxuXHRcdGNoZWNrTm9uRWxlbWVudHMgPSBiYXNlICYmIGtleSA9PT0gXCJwYXJlbnROb2RlXCIsXG5cdFx0ZG9uZU5hbWUgPSBkb25lKys7XG5cblx0cmV0dXJuIGNvbWJpbmF0b3IuZmlyc3QgP1xuXG5cdFx0Ly8gQ2hlY2sgYWdhaW5zdCBjbG9zZXN0IGFuY2VzdG9yL3ByZWNlZGluZyBlbGVtZW50XG5cdFx0ZnVuY3Rpb24oIGVsZW0sIGNvbnRleHQsIHhtbCApIHtcblx0XHRcdHdoaWxlICggKCBlbGVtID0gZWxlbVsgZGlyIF0gKSApIHtcblx0XHRcdFx0aWYgKCBlbGVtLm5vZGVUeXBlID09PSAxIHx8IGNoZWNrTm9uRWxlbWVudHMgKSB7XG5cdFx0XHRcdFx0cmV0dXJuIG1hdGNoZXIoIGVsZW0sIGNvbnRleHQsIHhtbCApO1xuXHRcdFx0XHR9XG5cdFx0XHR9XG5cdFx0XHRyZXR1cm4gZmFsc2U7XG5cdFx0fSA6XG5cblx0XHQvLyBDaGVjayBhZ2FpbnN0IGFsbCBhbmNlc3Rvci9wcmVjZWRpbmcgZWxlbWVudHNcblx0XHRmdW5jdGlvbiggZWxlbSwgY29udGV4dCwgeG1sICkge1xuXHRcdFx0dmFyIG9sZENhY2hlLCBvdXRlckNhY2hlLFxuXHRcdFx0XHRuZXdDYWNoZSA9IFsgZGlycnVucywgZG9uZU5hbWUgXTtcblxuXHRcdFx0Ly8gV2UgY2FuJ3Qgc2V0IGFyYml0cmFyeSBkYXRhIG9uIFhNTCBub2Rlcywgc28gdGhleSBkb24ndCBiZW5lZml0IGZyb20gY29tYmluYXRvciBjYWNoaW5nXG5cdFx0XHRpZiAoIHhtbCApIHtcblx0XHRcdFx0d2hpbGUgKCAoIGVsZW0gPSBlbGVtWyBkaXIgXSApICkge1xuXHRcdFx0XHRcdGlmICggZWxlbS5ub2RlVHlwZSA9PT0gMSB8fCBjaGVja05vbkVsZW1lbnRzICkge1xuXHRcdFx0XHRcdFx0aWYgKCBtYXRjaGVyKCBlbGVtLCBjb250ZXh0LCB4bWwgKSApIHtcblx0XHRcdFx0XHRcdFx0cmV0dXJuIHRydWU7XG5cdFx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHR9XG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHR3aGlsZSAoICggZWxlbSA9IGVsZW1bIGRpciBdICkgKSB7XG5cdFx0XHRcdFx0aWYgKCBlbGVtLm5vZGVUeXBlID09PSAxIHx8IGNoZWNrTm9uRWxlbWVudHMgKSB7XG5cdFx0XHRcdFx0XHRvdXRlckNhY2hlID0gZWxlbVsgalF1ZXJ5LmV4cGFuZG8gXSB8fCAoIGVsZW1bIGpRdWVyeS5leHBhbmRvIF0gPSB7fSApO1xuXG5cdFx0XHRcdFx0XHRpZiAoIHNraXAgJiYgbm9kZU5hbWUoIGVsZW0sIHNraXAgKSApIHtcblx0XHRcdFx0XHRcdFx0ZWxlbSA9IGVsZW1bIGRpciBdIHx8IGVsZW07XG5cdFx0XHRcdFx0XHR9IGVsc2UgaWYgKCAoIG9sZENhY2hlID0gb3V0ZXJDYWNoZVsga2V5IF0gKSAmJlxuXHRcdFx0XHRcdFx0XHRvbGRDYWNoZVsgMCBdID09PSBkaXJydW5zICYmIG9sZENhY2hlWyAxIF0gPT09IGRvbmVOYW1lICkge1xuXG5cdFx0XHRcdFx0XHRcdC8vIEFzc2lnbiB0byBuZXdDYWNoZSBzbyByZXN1bHRzIGJhY2stcHJvcGFnYXRlIHRvIHByZXZpb3VzIGVsZW1lbnRzXG5cdFx0XHRcdFx0XHRcdHJldHVybiAoIG5ld0NhY2hlWyAyIF0gPSBvbGRDYWNoZVsgMiBdICk7XG5cdFx0XHRcdFx0XHR9IGVsc2Uge1xuXG5cdFx0XHRcdFx0XHRcdC8vIFJldXNlIG5ld2NhY2hlIHNvIHJlc3VsdHMgYmFjay1wcm9wYWdhdGUgdG8gcHJldmlvdXMgZWxlbWVudHNcblx0XHRcdFx0XHRcdFx0b3V0ZXJDYWNoZVsga2V5IF0gPSBuZXdDYWNoZTtcblxuXHRcdFx0XHRcdFx0XHQvLyBBIG1hdGNoIG1lYW5zIHdlJ3JlIGRvbmU7IGEgZmFpbCBtZWFucyB3ZSBoYXZlIHRvIGtlZXAgY2hlY2tpbmdcblx0XHRcdFx0XHRcdFx0aWYgKCAoIG5ld0NhY2hlWyAyIF0gPSBtYXRjaGVyKCBlbGVtLCBjb250ZXh0LCB4bWwgKSApICkge1xuXHRcdFx0XHRcdFx0XHRcdHJldHVybiB0cnVlO1xuXHRcdFx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHR9XG5cdFx0XHR9XG5cdFx0XHRyZXR1cm4gZmFsc2U7XG5cdFx0fTtcbn1cblxuZnVuY3Rpb24gZWxlbWVudE1hdGNoZXIoIG1hdGNoZXJzICkge1xuXHRyZXR1cm4gbWF0Y2hlcnMubGVuZ3RoID4gMSA/XG5cdFx0ZnVuY3Rpb24oIGVsZW0sIGNvbnRleHQsIHhtbCApIHtcblx0XHRcdHZhciBpID0gbWF0Y2hlcnMubGVuZ3RoO1xuXHRcdFx0d2hpbGUgKCBpLS0gKSB7XG5cdFx0XHRcdGlmICggIW1hdGNoZXJzWyBpIF0oIGVsZW0sIGNvbnRleHQsIHhtbCApICkge1xuXHRcdFx0XHRcdHJldHVybiBmYWxzZTtcblx0XHRcdFx0fVxuXHRcdFx0fVxuXHRcdFx0cmV0dXJuIHRydWU7XG5cdFx0fSA6XG5cdFx0bWF0Y2hlcnNbIDAgXTtcbn1cblxuZnVuY3Rpb24gbXVsdGlwbGVDb250ZXh0cyggc2VsZWN0b3IsIGNvbnRleHRzLCByZXN1bHRzICkge1xuXHR2YXIgaSA9IDAsXG5cdFx0bGVuID0gY29udGV4dHMubGVuZ3RoO1xuXHRmb3IgKCA7IGkgPCBsZW47IGkrKyApIHtcblx0XHRmaW5kKCBzZWxlY3RvciwgY29udGV4dHNbIGkgXSwgcmVzdWx0cyApO1xuXHR9XG5cdHJldHVybiByZXN1bHRzO1xufVxuXG5mdW5jdGlvbiBjb25kZW5zZSggdW5tYXRjaGVkLCBtYXAsIGZpbHRlciwgY29udGV4dCwgeG1sICkge1xuXHR2YXIgZWxlbSxcblx0XHRuZXdVbm1hdGNoZWQgPSBbXSxcblx0XHRpID0gMCxcblx0XHRsZW4gPSB1bm1hdGNoZWQubGVuZ3RoLFxuXHRcdG1hcHBlZCA9IG1hcCAhPSBudWxsO1xuXG5cdGZvciAoIDsgaSA8IGxlbjsgaSsrICkge1xuXHRcdGlmICggKCBlbGVtID0gdW5tYXRjaGVkWyBpIF0gKSApIHtcblx0XHRcdGlmICggIWZpbHRlciB8fCBmaWx0ZXIoIGVsZW0sIGNvbnRleHQsIHhtbCApICkge1xuXHRcdFx0XHRuZXdVbm1hdGNoZWQucHVzaCggZWxlbSApO1xuXHRcdFx0XHRpZiAoIG1hcHBlZCApIHtcblx0XHRcdFx0XHRtYXAucHVzaCggaSApO1xuXHRcdFx0XHR9XG5cdFx0XHR9XG5cdFx0fVxuXHR9XG5cblx0cmV0dXJuIG5ld1VubWF0Y2hlZDtcbn1cblxuZnVuY3Rpb24gc2V0TWF0Y2hlciggcHJlRmlsdGVyLCBzZWxlY3RvciwgbWF0Y2hlciwgcG9zdEZpbHRlciwgcG9zdEZpbmRlciwgcG9zdFNlbGVjdG9yICkge1xuXHRpZiAoIHBvc3RGaWx0ZXIgJiYgIXBvc3RGaWx0ZXJbIGpRdWVyeS5leHBhbmRvIF0gKSB7XG5cdFx0cG9zdEZpbHRlciA9IHNldE1hdGNoZXIoIHBvc3RGaWx0ZXIgKTtcblx0fVxuXHRpZiAoIHBvc3RGaW5kZXIgJiYgIXBvc3RGaW5kZXJbIGpRdWVyeS5leHBhbmRvIF0gKSB7XG5cdFx0cG9zdEZpbmRlciA9IHNldE1hdGNoZXIoIHBvc3RGaW5kZXIsIHBvc3RTZWxlY3RvciApO1xuXHR9XG5cdHJldHVybiBtYXJrRnVuY3Rpb24oIGZ1bmN0aW9uKCBzZWVkLCByZXN1bHRzLCBjb250ZXh0LCB4bWwgKSB7XG5cdFx0dmFyIHRlbXAsIGksIGVsZW0sIG1hdGNoZXJPdXQsXG5cdFx0XHRwcmVNYXAgPSBbXSxcblx0XHRcdHBvc3RNYXAgPSBbXSxcblx0XHRcdHByZWV4aXN0aW5nID0gcmVzdWx0cy5sZW5ndGgsXG5cblx0XHRcdC8vIEdldCBpbml0aWFsIGVsZW1lbnRzIGZyb20gc2VlZCBvciBjb250ZXh0XG5cdFx0XHRlbGVtcyA9IHNlZWQgfHxcblx0XHRcdFx0bXVsdGlwbGVDb250ZXh0cyggc2VsZWN0b3IgfHwgXCIqXCIsXG5cdFx0XHRcdFx0Y29udGV4dC5ub2RlVHlwZSA/IFsgY29udGV4dCBdIDogY29udGV4dCwgW10gKSxcblxuXHRcdFx0Ly8gUHJlZmlsdGVyIHRvIGdldCBtYXRjaGVyIGlucHV0LCBwcmVzZXJ2aW5nIGEgbWFwIGZvciBzZWVkLXJlc3VsdHMgc3luY2hyb25pemF0aW9uXG5cdFx0XHRtYXRjaGVySW4gPSBwcmVGaWx0ZXIgJiYgKCBzZWVkIHx8ICFzZWxlY3RvciApID9cblx0XHRcdFx0Y29uZGVuc2UoIGVsZW1zLCBwcmVNYXAsIHByZUZpbHRlciwgY29udGV4dCwgeG1sICkgOlxuXHRcdFx0XHRlbGVtcztcblxuXHRcdGlmICggbWF0Y2hlciApIHtcblxuXHRcdFx0Ly8gSWYgd2UgaGF2ZSBhIHBvc3RGaW5kZXIsIG9yIGZpbHRlcmVkIHNlZWQsIG9yIG5vbi1zZWVkIHBvc3RGaWx0ZXJcblx0XHRcdC8vIG9yIHByZWV4aXN0aW5nIHJlc3VsdHMsXG5cdFx0XHRtYXRjaGVyT3V0ID0gcG9zdEZpbmRlciB8fCAoIHNlZWQgPyBwcmVGaWx0ZXIgOiBwcmVleGlzdGluZyB8fCBwb3N0RmlsdGVyICkgP1xuXG5cdFx0XHRcdC8vIC4uLmludGVybWVkaWF0ZSBwcm9jZXNzaW5nIGlzIG5lY2Vzc2FyeVxuXHRcdFx0XHRbXSA6XG5cblx0XHRcdFx0Ly8gLi4ub3RoZXJ3aXNlIHVzZSByZXN1bHRzIGRpcmVjdGx5XG5cdFx0XHRcdHJlc3VsdHM7XG5cblx0XHRcdC8vIEZpbmQgcHJpbWFyeSBtYXRjaGVzXG5cdFx0XHRtYXRjaGVyKCBtYXRjaGVySW4sIG1hdGNoZXJPdXQsIGNvbnRleHQsIHhtbCApO1xuXHRcdH0gZWxzZSB7XG5cdFx0XHRtYXRjaGVyT3V0ID0gbWF0Y2hlckluO1xuXHRcdH1cblxuXHRcdC8vIEFwcGx5IHBvc3RGaWx0ZXJcblx0XHRpZiAoIHBvc3RGaWx0ZXIgKSB7XG5cdFx0XHR0ZW1wID0gY29uZGVuc2UoIG1hdGNoZXJPdXQsIHBvc3RNYXAgKTtcblx0XHRcdHBvc3RGaWx0ZXIoIHRlbXAsIFtdLCBjb250ZXh0LCB4bWwgKTtcblxuXHRcdFx0Ly8gVW4tbWF0Y2ggZmFpbGluZyBlbGVtZW50cyBieSBtb3ZpbmcgdGhlbSBiYWNrIHRvIG1hdGNoZXJJblxuXHRcdFx0aSA9IHRlbXAubGVuZ3RoO1xuXHRcdFx0d2hpbGUgKCBpLS0gKSB7XG5cdFx0XHRcdGlmICggKCBlbGVtID0gdGVtcFsgaSBdICkgKSB7XG5cdFx0XHRcdFx0bWF0Y2hlck91dFsgcG9zdE1hcFsgaSBdIF0gPSAhKCBtYXRjaGVySW5bIHBvc3RNYXBbIGkgXSBdID0gZWxlbSApO1xuXHRcdFx0XHR9XG5cdFx0XHR9XG5cdFx0fVxuXG5cdFx0aWYgKCBzZWVkICkge1xuXHRcdFx0aWYgKCBwb3N0RmluZGVyIHx8IHByZUZpbHRlciApIHtcblx0XHRcdFx0aWYgKCBwb3N0RmluZGVyICkge1xuXG5cdFx0XHRcdFx0Ly8gR2V0IHRoZSBmaW5hbCBtYXRjaGVyT3V0IGJ5IGNvbmRlbnNpbmcgdGhpcyBpbnRlcm1lZGlhdGUgaW50byBwb3N0RmluZGVyIGNvbnRleHRzXG5cdFx0XHRcdFx0dGVtcCA9IFtdO1xuXHRcdFx0XHRcdGkgPSBtYXRjaGVyT3V0Lmxlbmd0aDtcblx0XHRcdFx0XHR3aGlsZSAoIGktLSApIHtcblx0XHRcdFx0XHRcdGlmICggKCBlbGVtID0gbWF0Y2hlck91dFsgaSBdICkgKSB7XG5cblx0XHRcdFx0XHRcdFx0Ly8gUmVzdG9yZSBtYXRjaGVySW4gc2luY2UgZWxlbSBpcyBub3QgeWV0IGEgZmluYWwgbWF0Y2hcblx0XHRcdFx0XHRcdFx0dGVtcC5wdXNoKCAoIG1hdGNoZXJJblsgaSBdID0gZWxlbSApICk7XG5cdFx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHRcdHBvc3RGaW5kZXIoIG51bGwsICggbWF0Y2hlck91dCA9IFtdICksIHRlbXAsIHhtbCApO1xuXHRcdFx0XHR9XG5cblx0XHRcdFx0Ly8gTW92ZSBtYXRjaGVkIGVsZW1lbnRzIGZyb20gc2VlZCB0byByZXN1bHRzIHRvIGtlZXAgdGhlbSBzeW5jaHJvbml6ZWRcblx0XHRcdFx0aSA9IG1hdGNoZXJPdXQubGVuZ3RoO1xuXHRcdFx0XHR3aGlsZSAoIGktLSApIHtcblx0XHRcdFx0XHRpZiAoICggZWxlbSA9IG1hdGNoZXJPdXRbIGkgXSApICYmXG5cdFx0XHRcdFx0XHQoIHRlbXAgPSBwb3N0RmluZGVyID8gaW5kZXhPZi5jYWxsKCBzZWVkLCBlbGVtICkgOiBwcmVNYXBbIGkgXSApID4gLTEgKSB7XG5cblx0XHRcdFx0XHRcdHNlZWRbIHRlbXAgXSA9ICEoIHJlc3VsdHNbIHRlbXAgXSA9IGVsZW0gKTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH1cblx0XHRcdH1cblxuXHRcdC8vIEFkZCBlbGVtZW50cyB0byByZXN1bHRzLCB0aHJvdWdoIHBvc3RGaW5kZXIgaWYgZGVmaW5lZFxuXHRcdH0gZWxzZSB7XG5cdFx0XHRtYXRjaGVyT3V0ID0gY29uZGVuc2UoXG5cdFx0XHRcdG1hdGNoZXJPdXQgPT09IHJlc3VsdHMgP1xuXHRcdFx0XHRcdG1hdGNoZXJPdXQuc3BsaWNlKCBwcmVleGlzdGluZywgbWF0Y2hlck91dC5sZW5ndGggKSA6XG5cdFx0XHRcdFx0bWF0Y2hlck91dFxuXHRcdFx0KTtcblx0XHRcdGlmICggcG9zdEZpbmRlciApIHtcblx0XHRcdFx0cG9zdEZpbmRlciggbnVsbCwgcmVzdWx0cywgbWF0Y2hlck91dCwgeG1sICk7XG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRwdXNoLmFwcGx5KCByZXN1bHRzLCBtYXRjaGVyT3V0ICk7XG5cdFx0XHR9XG5cdFx0fVxuXHR9ICk7XG59XG5cbmZ1bmN0aW9uIG1hdGNoZXJGcm9tVG9rZW5zKCB0b2tlbnMgKSB7XG5cdHZhciBjaGVja0NvbnRleHQsIG1hdGNoZXIsIGosXG5cdFx0bGVuID0gdG9rZW5zLmxlbmd0aCxcblx0XHRsZWFkaW5nUmVsYXRpdmUgPSBqUXVlcnkuZXhwci5yZWxhdGl2ZVsgdG9rZW5zWyAwIF0udHlwZSBdLFxuXHRcdGltcGxpY2l0UmVsYXRpdmUgPSBsZWFkaW5nUmVsYXRpdmUgfHwgalF1ZXJ5LmV4cHIucmVsYXRpdmVbIFwiIFwiIF0sXG5cdFx0aSA9IGxlYWRpbmdSZWxhdGl2ZSA/IDEgOiAwLFxuXG5cdFx0Ly8gVGhlIGZvdW5kYXRpb25hbCBtYXRjaGVyIGVuc3VyZXMgdGhhdCBlbGVtZW50cyBhcmUgcmVhY2hhYmxlIGZyb20gdG9wLWxldmVsIGNvbnRleHQocylcblx0XHRtYXRjaENvbnRleHQgPSBhZGRDb21iaW5hdG9yKCBmdW5jdGlvbiggZWxlbSApIHtcblx0XHRcdHJldHVybiBlbGVtID09PSBjaGVja0NvbnRleHQ7XG5cdFx0fSwgaW1wbGljaXRSZWxhdGl2ZSwgdHJ1ZSApLFxuXHRcdG1hdGNoQW55Q29udGV4dCA9IGFkZENvbWJpbmF0b3IoIGZ1bmN0aW9uKCBlbGVtICkge1xuXHRcdFx0cmV0dXJuIGluZGV4T2YuY2FsbCggY2hlY2tDb250ZXh0LCBlbGVtICkgPiAtMTtcblx0XHR9LCBpbXBsaWNpdFJlbGF0aXZlLCB0cnVlICksXG5cdFx0bWF0Y2hlcnMgPSBbIGZ1bmN0aW9uKCBlbGVtLCBjb250ZXh0LCB4bWwgKSB7XG5cblx0XHRcdC8vIFN1cHBvcnQ6IElFIDExK1xuXHRcdFx0Ly8gSUUgc29tZXRpbWVzIHRocm93cyBhIFwiUGVybWlzc2lvbiBkZW5pZWRcIiBlcnJvciB3aGVuIHN0cmljdC1jb21wYXJpbmdcblx0XHRcdC8vIHR3byBkb2N1bWVudHM7IHNoYWxsb3cgY29tcGFyaXNvbnMgd29yay5cblx0XHRcdC8vIGVzbGludC1kaXNhYmxlLW5leHQtbGluZSBlcWVxZXFcblx0XHRcdHZhciByZXQgPSAoICFsZWFkaW5nUmVsYXRpdmUgJiYgKCB4bWwgfHwgY29udGV4dCAhPSBvdXRlcm1vc3RDb250ZXh0ICkgKSB8fCAoXG5cdFx0XHRcdCggY2hlY2tDb250ZXh0ID0gY29udGV4dCApLm5vZGVUeXBlID9cblx0XHRcdFx0XHRtYXRjaENvbnRleHQoIGVsZW0sIGNvbnRleHQsIHhtbCApIDpcblx0XHRcdFx0XHRtYXRjaEFueUNvbnRleHQoIGVsZW0sIGNvbnRleHQsIHhtbCApICk7XG5cblx0XHRcdC8vIEF2b2lkIGhhbmdpbmcgb250byBlbGVtZW50XG5cdFx0XHQvLyAoc2VlIGh0dHBzOi8vZ2l0aHViLmNvbS9qcXVlcnkvc2l6emxlL2lzc3Vlcy8yOTkpXG5cdFx0XHRjaGVja0NvbnRleHQgPSBudWxsO1xuXHRcdFx0cmV0dXJuIHJldDtcblx0XHR9IF07XG5cblx0Zm9yICggOyBpIDwgbGVuOyBpKysgKSB7XG5cdFx0aWYgKCAoIG1hdGNoZXIgPSBqUXVlcnkuZXhwci5yZWxhdGl2ZVsgdG9rZW5zWyBpIF0udHlwZSBdICkgKSB7XG5cdFx0XHRtYXRjaGVycyA9IFsgYWRkQ29tYmluYXRvciggZWxlbWVudE1hdGNoZXIoIG1hdGNoZXJzICksIG1hdGNoZXIgKSBdO1xuXHRcdH0gZWxzZSB7XG5cdFx0XHRtYXRjaGVyID0galF1ZXJ5LmV4cHIuZmlsdGVyWyB0b2tlbnNbIGkgXS50eXBlIF0uYXBwbHkoIG51bGwsIHRva2Vuc1sgaSBdLm1hdGNoZXMgKTtcblxuXHRcdFx0Ly8gUmV0dXJuIHNwZWNpYWwgdXBvbiBzZWVpbmcgYSBwb3NpdGlvbmFsIG1hdGNoZXJcblx0XHRcdGlmICggbWF0Y2hlclsgalF1ZXJ5LmV4cGFuZG8gXSApIHtcblxuXHRcdFx0XHQvLyBGaW5kIHRoZSBuZXh0IHJlbGF0aXZlIG9wZXJhdG9yIChpZiBhbnkpIGZvciBwcm9wZXIgaGFuZGxpbmdcblx0XHRcdFx0aiA9ICsraTtcblx0XHRcdFx0Zm9yICggOyBqIDwgbGVuOyBqKysgKSB7XG5cdFx0XHRcdFx0aWYgKCBqUXVlcnkuZXhwci5yZWxhdGl2ZVsgdG9rZW5zWyBqIF0udHlwZSBdICkge1xuXHRcdFx0XHRcdFx0YnJlYWs7XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHR9XG5cdFx0XHRcdHJldHVybiBzZXRNYXRjaGVyKFxuXHRcdFx0XHRcdGkgPiAxICYmIGVsZW1lbnRNYXRjaGVyKCBtYXRjaGVycyApLFxuXHRcdFx0XHRcdGkgPiAxICYmIHRvU2VsZWN0b3IoXG5cblx0XHRcdFx0XHRcdC8vIElmIHRoZSBwcmVjZWRpbmcgdG9rZW4gd2FzIGEgZGVzY2VuZGFudCBjb21iaW5hdG9yLCBpbnNlcnQgYW4gaW1wbGljaXQgYW55LWVsZW1lbnQgYCpgXG5cdFx0XHRcdFx0XHR0b2tlbnMuc2xpY2UoIDAsIGkgLSAxIClcblx0XHRcdFx0XHRcdFx0LmNvbmNhdCggeyB2YWx1ZTogdG9rZW5zWyBpIC0gMiBdLnR5cGUgPT09IFwiIFwiID8gXCIqXCIgOiBcIlwiIH0gKVxuXHRcdFx0XHRcdCkucmVwbGFjZSggcnRyaW1DU1MsIFwiJDFcIiApLFxuXHRcdFx0XHRcdG1hdGNoZXIsXG5cdFx0XHRcdFx0aSA8IGogJiYgbWF0Y2hlckZyb21Ub2tlbnMoIHRva2Vucy5zbGljZSggaSwgaiApICksXG5cdFx0XHRcdFx0aiA8IGxlbiAmJiBtYXRjaGVyRnJvbVRva2VucyggKCB0b2tlbnMgPSB0b2tlbnMuc2xpY2UoIGogKSApICksXG5cdFx0XHRcdFx0aiA8IGxlbiAmJiB0b1NlbGVjdG9yKCB0b2tlbnMgKVxuXHRcdFx0XHQpO1xuXHRcdFx0fVxuXHRcdFx0bWF0Y2hlcnMucHVzaCggbWF0Y2hlciApO1xuXHRcdH1cblx0fVxuXG5cdHJldHVybiBlbGVtZW50TWF0Y2hlciggbWF0Y2hlcnMgKTtcbn1cblxuZnVuY3Rpb24gbWF0Y2hlckZyb21Hcm91cE1hdGNoZXJzKCBlbGVtZW50TWF0Y2hlcnMsIHNldE1hdGNoZXJzICkge1xuXHR2YXIgYnlTZXQgPSBzZXRNYXRjaGVycy5sZW5ndGggPiAwLFxuXHRcdGJ5RWxlbWVudCA9IGVsZW1lbnRNYXRjaGVycy5sZW5ndGggPiAwLFxuXHRcdHN1cGVyTWF0Y2hlciA9IGZ1bmN0aW9uKCBzZWVkLCBjb250ZXh0LCB4bWwsIHJlc3VsdHMsIG91dGVybW9zdCApIHtcblx0XHRcdHZhciBlbGVtLCBqLCBtYXRjaGVyLFxuXHRcdFx0XHRtYXRjaGVkQ291bnQgPSAwLFxuXHRcdFx0XHRpID0gXCIwXCIsXG5cdFx0XHRcdHVubWF0Y2hlZCA9IHNlZWQgJiYgW10sXG5cdFx0XHRcdHNldE1hdGNoZWQgPSBbXSxcblx0XHRcdFx0Y29udGV4dEJhY2t1cCA9IG91dGVybW9zdENvbnRleHQsXG5cblx0XHRcdFx0Ly8gV2UgbXVzdCBhbHdheXMgaGF2ZSBlaXRoZXIgc2VlZCBlbGVtZW50cyBvciBvdXRlcm1vc3QgY29udGV4dFxuXHRcdFx0XHRlbGVtcyA9IHNlZWQgfHwgYnlFbGVtZW50ICYmIGpRdWVyeS5leHByLmZpbmQuVEFHKCBcIipcIiwgb3V0ZXJtb3N0ICksXG5cblx0XHRcdFx0Ly8gVXNlIGludGVnZXIgZGlycnVucyBpZmYgdGhpcyBpcyB0aGUgb3V0ZXJtb3N0IG1hdGNoZXJcblx0XHRcdFx0ZGlycnVuc1VuaXF1ZSA9ICggZGlycnVucyArPSBjb250ZXh0QmFja3VwID09IG51bGwgPyAxIDogTWF0aC5yYW5kb20oKSB8fCAwLjEgKTtcblxuXHRcdFx0aWYgKCBvdXRlcm1vc3QgKSB7XG5cblx0XHRcdFx0Ly8gU3VwcG9ydDogSUUgMTErXG5cdFx0XHRcdC8vIElFIHNvbWV0aW1lcyB0aHJvd3MgYSBcIlBlcm1pc3Npb24gZGVuaWVkXCIgZXJyb3Igd2hlbiBzdHJpY3QtY29tcGFyaW5nXG5cdFx0XHRcdC8vIHR3byBkb2N1bWVudHM7IHNoYWxsb3cgY29tcGFyaXNvbnMgd29yay5cblx0XHRcdFx0Ly8gZXNsaW50LWRpc2FibGUtbmV4dC1saW5lIGVxZXFlcVxuXHRcdFx0XHRvdXRlcm1vc3RDb250ZXh0ID0gY29udGV4dCA9PSBkb2N1bWVudCB8fCBjb250ZXh0IHx8IG91dGVybW9zdDtcblx0XHRcdH1cblxuXHRcdFx0Ly8gQWRkIGVsZW1lbnRzIHBhc3NpbmcgZWxlbWVudE1hdGNoZXJzIGRpcmVjdGx5IHRvIHJlc3VsdHNcblx0XHRcdGZvciAoIDsgKCBlbGVtID0gZWxlbXNbIGkgXSApICE9IG51bGw7IGkrKyApIHtcblx0XHRcdFx0aWYgKCBieUVsZW1lbnQgJiYgZWxlbSApIHtcblx0XHRcdFx0XHRqID0gMDtcblxuXHRcdFx0XHRcdC8vIFN1cHBvcnQ6IElFIDExK1xuXHRcdFx0XHRcdC8vIElFIHNvbWV0aW1lcyB0aHJvd3MgYSBcIlBlcm1pc3Npb24gZGVuaWVkXCIgZXJyb3Igd2hlbiBzdHJpY3QtY29tcGFyaW5nXG5cdFx0XHRcdFx0Ly8gdHdvIGRvY3VtZW50czsgc2hhbGxvdyBjb21wYXJpc29ucyB3b3JrLlxuXHRcdFx0XHRcdC8vIGVzbGludC1kaXNhYmxlLW5leHQtbGluZSBlcWVxZXFcblx0XHRcdFx0XHRpZiAoICFjb250ZXh0ICYmIGVsZW0ub3duZXJEb2N1bWVudCAhPSBkb2N1bWVudCApIHtcblx0XHRcdFx0XHRcdHNldERvY3VtZW50KCBlbGVtICk7XG5cdFx0XHRcdFx0XHR4bWwgPSAhZG9jdW1lbnRJc0hUTUw7XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHRcdHdoaWxlICggKCBtYXRjaGVyID0gZWxlbWVudE1hdGNoZXJzWyBqKysgXSApICkge1xuXHRcdFx0XHRcdFx0aWYgKCBtYXRjaGVyKCBlbGVtLCBjb250ZXh0IHx8IGRvY3VtZW50LCB4bWwgKSApIHtcblx0XHRcdFx0XHRcdFx0cHVzaC5jYWxsKCByZXN1bHRzLCBlbGVtICk7XG5cdFx0XHRcdFx0XHRcdGJyZWFrO1xuXHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdH1cblx0XHRcdFx0XHRpZiAoIG91dGVybW9zdCApIHtcblx0XHRcdFx0XHRcdGRpcnJ1bnMgPSBkaXJydW5zVW5pcXVlO1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0fVxuXG5cdFx0XHRcdC8vIFRyYWNrIHVubWF0Y2hlZCBlbGVtZW50cyBmb3Igc2V0IGZpbHRlcnNcblx0XHRcdFx0aWYgKCBieVNldCApIHtcblxuXHRcdFx0XHRcdC8vIFRoZXkgd2lsbCBoYXZlIGdvbmUgdGhyb3VnaCBhbGwgcG9zc2libGUgbWF0Y2hlcnNcblx0XHRcdFx0XHRpZiAoICggZWxlbSA9ICFtYXRjaGVyICYmIGVsZW0gKSApIHtcblx0XHRcdFx0XHRcdG1hdGNoZWRDb3VudC0tO1xuXHRcdFx0XHRcdH1cblxuXHRcdFx0XHRcdC8vIExlbmd0aGVuIHRoZSBhcnJheSBmb3IgZXZlcnkgZWxlbWVudCwgbWF0Y2hlZCBvciBub3Rcblx0XHRcdFx0XHRpZiAoIHNlZWQgKSB7XG5cdFx0XHRcdFx0XHR1bm1hdGNoZWQucHVzaCggZWxlbSApO1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0fVxuXHRcdFx0fVxuXG5cdFx0XHQvLyBgaWAgaXMgbm93IHRoZSBjb3VudCBvZiBlbGVtZW50cyB2aXNpdGVkIGFib3ZlLCBhbmQgYWRkaW5nIGl0IHRvIGBtYXRjaGVkQ291bnRgXG5cdFx0XHQvLyBtYWtlcyB0aGUgbGF0dGVyIG5vbm5lZ2F0aXZlLlxuXHRcdFx0bWF0Y2hlZENvdW50ICs9IGk7XG5cblx0XHRcdC8vIEFwcGx5IHNldCBmaWx0ZXJzIHRvIHVubWF0Y2hlZCBlbGVtZW50c1xuXHRcdFx0Ly8gTk9URTogVGhpcyBjYW4gYmUgc2tpcHBlZCBpZiB0aGVyZSBhcmUgbm8gdW5tYXRjaGVkIGVsZW1lbnRzIChpLmUuLCBgbWF0Y2hlZENvdW50YFxuXHRcdFx0Ly8gZXF1YWxzIGBpYCksIHVubGVzcyB3ZSBkaWRuJ3QgdmlzaXQgX2FueV8gZWxlbWVudHMgaW4gdGhlIGFib3ZlIGxvb3AgYmVjYXVzZSB3ZSBoYXZlXG5cdFx0XHQvLyBubyBlbGVtZW50IG1hdGNoZXJzIGFuZCBubyBzZWVkLlxuXHRcdFx0Ly8gSW5jcmVtZW50aW5nIGFuIGluaXRpYWxseS1zdHJpbmcgXCIwXCIgYGlgIGFsbG93cyBgaWAgdG8gcmVtYWluIGEgc3RyaW5nIG9ubHkgaW4gdGhhdFxuXHRcdFx0Ly8gY2FzZSwgd2hpY2ggd2lsbCByZXN1bHQgaW4gYSBcIjAwXCIgYG1hdGNoZWRDb3VudGAgdGhhdCBkaWZmZXJzIGZyb20gYGlgIGJ1dCBpcyBhbHNvXG5cdFx0XHQvLyBudW1lcmljYWxseSB6ZXJvLlxuXHRcdFx0aWYgKCBieVNldCAmJiBpICE9PSBtYXRjaGVkQ291bnQgKSB7XG5cdFx0XHRcdGogPSAwO1xuXHRcdFx0XHR3aGlsZSAoICggbWF0Y2hlciA9IHNldE1hdGNoZXJzWyBqKysgXSApICkge1xuXHRcdFx0XHRcdG1hdGNoZXIoIHVubWF0Y2hlZCwgc2V0TWF0Y2hlZCwgY29udGV4dCwgeG1sICk7XG5cdFx0XHRcdH1cblxuXHRcdFx0XHRpZiAoIHNlZWQgKSB7XG5cblx0XHRcdFx0XHQvLyBSZWludGVncmF0ZSBlbGVtZW50IG1hdGNoZXMgdG8gZWxpbWluYXRlIHRoZSBuZWVkIGZvciBzb3J0aW5nXG5cdFx0XHRcdFx0aWYgKCBtYXRjaGVkQ291bnQgPiAwICkge1xuXHRcdFx0XHRcdFx0d2hpbGUgKCBpLS0gKSB7XG5cdFx0XHRcdFx0XHRcdGlmICggISggdW5tYXRjaGVkWyBpIF0gfHwgc2V0TWF0Y2hlZFsgaSBdICkgKSB7XG5cdFx0XHRcdFx0XHRcdFx0c2V0TWF0Y2hlZFsgaSBdID0gcG9wLmNhbGwoIHJlc3VsdHMgKTtcblx0XHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdH1cblxuXHRcdFx0XHRcdC8vIERpc2NhcmQgaW5kZXggcGxhY2Vob2xkZXIgdmFsdWVzIHRvIGdldCBvbmx5IGFjdHVhbCBtYXRjaGVzXG5cdFx0XHRcdFx0c2V0TWF0Y2hlZCA9IGNvbmRlbnNlKCBzZXRNYXRjaGVkICk7XG5cdFx0XHRcdH1cblxuXHRcdFx0XHQvLyBBZGQgbWF0Y2hlcyB0byByZXN1bHRzXG5cdFx0XHRcdHB1c2guYXBwbHkoIHJlc3VsdHMsIHNldE1hdGNoZWQgKTtcblxuXHRcdFx0XHQvLyBTZWVkbGVzcyBzZXQgbWF0Y2hlcyBzdWNjZWVkaW5nIG11bHRpcGxlIHN1Y2Nlc3NmdWwgbWF0Y2hlcnMgc3RpcHVsYXRlIHNvcnRpbmdcblx0XHRcdFx0aWYgKCBvdXRlcm1vc3QgJiYgIXNlZWQgJiYgc2V0TWF0Y2hlZC5sZW5ndGggPiAwICYmXG5cdFx0XHRcdFx0KCBtYXRjaGVkQ291bnQgKyBzZXRNYXRjaGVycy5sZW5ndGggKSA+IDEgKSB7XG5cblx0XHRcdFx0XHRqUXVlcnkudW5pcXVlU29ydCggcmVzdWx0cyApO1xuXHRcdFx0XHR9XG5cdFx0XHR9XG5cblx0XHRcdC8vIE92ZXJyaWRlIG1hbmlwdWxhdGlvbiBvZiBnbG9iYWxzIGJ5IG5lc3RlZCBtYXRjaGVyc1xuXHRcdFx0aWYgKCBvdXRlcm1vc3QgKSB7XG5cdFx0XHRcdGRpcnJ1bnMgPSBkaXJydW5zVW5pcXVlO1xuXHRcdFx0XHRvdXRlcm1vc3RDb250ZXh0ID0gY29udGV4dEJhY2t1cDtcblx0XHRcdH1cblxuXHRcdFx0cmV0dXJuIHVubWF0Y2hlZDtcblx0XHR9O1xuXG5cdHJldHVybiBieVNldCA/XG5cdFx0bWFya0Z1bmN0aW9uKCBzdXBlck1hdGNoZXIgKSA6XG5cdFx0c3VwZXJNYXRjaGVyO1xufVxuXG5mdW5jdGlvbiBjb21waWxlKCBzZWxlY3RvciwgbWF0Y2ggLyogSW50ZXJuYWwgVXNlIE9ubHkgKi8gKSB7XG5cdHZhciBpLFxuXHRcdHNldE1hdGNoZXJzID0gW10sXG5cdFx0ZWxlbWVudE1hdGNoZXJzID0gW10sXG5cdFx0Y2FjaGVkID0gY29tcGlsZXJDYWNoZVsgc2VsZWN0b3IgKyBcIiBcIiBdO1xuXG5cdGlmICggIWNhY2hlZCApIHtcblxuXHRcdC8vIEdlbmVyYXRlIGEgZnVuY3Rpb24gb2YgcmVjdXJzaXZlIGZ1bmN0aW9ucyB0aGF0IGNhbiBiZSB1c2VkIHRvIGNoZWNrIGVhY2ggZWxlbWVudFxuXHRcdGlmICggIW1hdGNoICkge1xuXHRcdFx0bWF0Y2ggPSB0b2tlbml6ZSggc2VsZWN0b3IgKTtcblx0XHR9XG5cdFx0aSA9IG1hdGNoLmxlbmd0aDtcblx0XHR3aGlsZSAoIGktLSApIHtcblx0XHRcdGNhY2hlZCA9IG1hdGNoZXJGcm9tVG9rZW5zKCBtYXRjaFsgaSBdICk7XG5cdFx0XHRpZiAoIGNhY2hlZFsgalF1ZXJ5LmV4cGFuZG8gXSApIHtcblx0XHRcdFx0c2V0TWF0Y2hlcnMucHVzaCggY2FjaGVkICk7XG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRlbGVtZW50TWF0Y2hlcnMucHVzaCggY2FjaGVkICk7XG5cdFx0XHR9XG5cdFx0fVxuXG5cdFx0Ly8gQ2FjaGUgdGhlIGNvbXBpbGVkIGZ1bmN0aW9uXG5cdFx0Y2FjaGVkID0gY29tcGlsZXJDYWNoZSggc2VsZWN0b3IsXG5cdFx0XHRtYXRjaGVyRnJvbUdyb3VwTWF0Y2hlcnMoIGVsZW1lbnRNYXRjaGVycywgc2V0TWF0Y2hlcnMgKSApO1xuXG5cdFx0Ly8gU2F2ZSBzZWxlY3RvciBhbmQgdG9rZW5pemF0aW9uXG5cdFx0Y2FjaGVkLnNlbGVjdG9yID0gc2VsZWN0b3I7XG5cdH1cblx0cmV0dXJuIGNhY2hlZDtcbn1cblxuLyoqXG4gKiBBIGxvdy1sZXZlbCBzZWxlY3Rpb24gZnVuY3Rpb24gdGhhdCB3b3JrcyB3aXRoIGpRdWVyeSdzIGNvbXBpbGVkXG4gKiAgc2VsZWN0b3IgZnVuY3Rpb25zXG4gKiBAcGFyYW0ge1N0cmluZ3xGdW5jdGlvbn0gc2VsZWN0b3IgQSBzZWxlY3RvciBvciBhIHByZS1jb21waWxlZFxuICogIHNlbGVjdG9yIGZ1bmN0aW9uIGJ1aWx0IHdpdGggalF1ZXJ5IHNlbGVjdG9yIGNvbXBpbGVcbiAqIEBwYXJhbSB7RWxlbWVudH0gY29udGV4dFxuICogQHBhcmFtIHtBcnJheX0gW3Jlc3VsdHNdXG4gKiBAcGFyYW0ge0FycmF5fSBbc2VlZF0gQSBzZXQgb2YgZWxlbWVudHMgdG8gbWF0Y2ggYWdhaW5zdFxuICovXG5mdW5jdGlvbiBzZWxlY3QoIHNlbGVjdG9yLCBjb250ZXh0LCByZXN1bHRzLCBzZWVkICkge1xuXHR2YXIgaSwgdG9rZW5zLCB0b2tlbiwgdHlwZSwgZmluZCxcblx0XHRjb21waWxlZCA9IHR5cGVvZiBzZWxlY3RvciA9PT0gXCJmdW5jdGlvblwiICYmIHNlbGVjdG9yLFxuXHRcdG1hdGNoID0gIXNlZWQgJiYgdG9rZW5pemUoICggc2VsZWN0b3IgPSBjb21waWxlZC5zZWxlY3RvciB8fCBzZWxlY3RvciApICk7XG5cblx0cmVzdWx0cyA9IHJlc3VsdHMgfHwgW107XG5cblx0Ly8gVHJ5IHRvIG1pbmltaXplIG9wZXJhdGlvbnMgaWYgdGhlcmUgaXMgb25seSBvbmUgc2VsZWN0b3IgaW4gdGhlIGxpc3QgYW5kIG5vIHNlZWRcblx0Ly8gKHRoZSBsYXR0ZXIgb2Ygd2hpY2ggZ3VhcmFudGVlcyB1cyBjb250ZXh0KVxuXHRpZiAoIG1hdGNoLmxlbmd0aCA9PT0gMSApIHtcblxuXHRcdC8vIFJlZHVjZSBjb250ZXh0IGlmIHRoZSBsZWFkaW5nIGNvbXBvdW5kIHNlbGVjdG9yIGlzIGFuIElEXG5cdFx0dG9rZW5zID0gbWF0Y2hbIDAgXSA9IG1hdGNoWyAwIF0uc2xpY2UoIDAgKTtcblx0XHRpZiAoIHRva2Vucy5sZW5ndGggPiAyICYmICggdG9rZW4gPSB0b2tlbnNbIDAgXSApLnR5cGUgPT09IFwiSURcIiAmJlxuXHRcdFx0XHRjb250ZXh0Lm5vZGVUeXBlID09PSA5ICYmIGRvY3VtZW50SXNIVE1MICYmXG5cdFx0XHRcdGpRdWVyeS5leHByLnJlbGF0aXZlWyB0b2tlbnNbIDEgXS50eXBlIF0gKSB7XG5cblx0XHRcdGNvbnRleHQgPSAoIGpRdWVyeS5leHByLmZpbmQuSUQoXG5cdFx0XHRcdHVuZXNjYXBlU2VsZWN0b3IoIHRva2VuLm1hdGNoZXNbIDAgXSApLFxuXHRcdFx0XHRjb250ZXh0XG5cdFx0XHQpIHx8IFtdIClbIDAgXTtcblx0XHRcdGlmICggIWNvbnRleHQgKSB7XG5cdFx0XHRcdHJldHVybiByZXN1bHRzO1xuXG5cdFx0XHQvLyBQcmVjb21waWxlZCBtYXRjaGVycyB3aWxsIHN0aWxsIHZlcmlmeSBhbmNlc3RyeSwgc28gc3RlcCB1cCBhIGxldmVsXG5cdFx0XHR9IGVsc2UgaWYgKCBjb21waWxlZCApIHtcblx0XHRcdFx0Y29udGV4dCA9IGNvbnRleHQucGFyZW50Tm9kZTtcblx0XHRcdH1cblxuXHRcdFx0c2VsZWN0b3IgPSBzZWxlY3Rvci5zbGljZSggdG9rZW5zLnNoaWZ0KCkudmFsdWUubGVuZ3RoICk7XG5cdFx0fVxuXG5cdFx0Ly8gRmV0Y2ggYSBzZWVkIHNldCBmb3IgcmlnaHQtdG8tbGVmdCBtYXRjaGluZ1xuXHRcdGkgPSBtYXRjaEV4cHIubmVlZHNDb250ZXh0LnRlc3QoIHNlbGVjdG9yICkgPyAwIDogdG9rZW5zLmxlbmd0aDtcblx0XHR3aGlsZSAoIGktLSApIHtcblx0XHRcdHRva2VuID0gdG9rZW5zWyBpIF07XG5cblx0XHRcdC8vIEFib3J0IGlmIHdlIGhpdCBhIGNvbWJpbmF0b3Jcblx0XHRcdGlmICggalF1ZXJ5LmV4cHIucmVsYXRpdmVbICggdHlwZSA9IHRva2VuLnR5cGUgKSBdICkge1xuXHRcdFx0XHRicmVhaztcblx0XHRcdH1cblx0XHRcdGlmICggKCBmaW5kID0galF1ZXJ5LmV4cHIuZmluZFsgdHlwZSBdICkgKSB7XG5cblx0XHRcdFx0Ly8gU2VhcmNoLCBleHBhbmRpbmcgY29udGV4dCBmb3IgbGVhZGluZyBzaWJsaW5nIGNvbWJpbmF0b3JzXG5cdFx0XHRcdGlmICggKCBzZWVkID0gZmluZChcblx0XHRcdFx0XHR1bmVzY2FwZVNlbGVjdG9yKCB0b2tlbi5tYXRjaGVzWyAwIF0gKSxcblx0XHRcdFx0XHRyc2libGluZy50ZXN0KCB0b2tlbnNbIDAgXS50eXBlICkgJiZcblx0XHRcdFx0XHRcdHRlc3RDb250ZXh0KCBjb250ZXh0LnBhcmVudE5vZGUgKSB8fCBjb250ZXh0XG5cdFx0XHRcdCkgKSApIHtcblxuXHRcdFx0XHRcdC8vIElmIHNlZWQgaXMgZW1wdHkgb3Igbm8gdG9rZW5zIHJlbWFpbiwgd2UgY2FuIHJldHVybiBlYXJseVxuXHRcdFx0XHRcdHRva2Vucy5zcGxpY2UoIGksIDEgKTtcblx0XHRcdFx0XHRzZWxlY3RvciA9IHNlZWQubGVuZ3RoICYmIHRvU2VsZWN0b3IoIHRva2VucyApO1xuXHRcdFx0XHRcdGlmICggIXNlbGVjdG9yICkge1xuXHRcdFx0XHRcdFx0cHVzaC5hcHBseSggcmVzdWx0cywgc2VlZCApO1xuXHRcdFx0XHRcdFx0cmV0dXJuIHJlc3VsdHM7XG5cdFx0XHRcdFx0fVxuXG5cdFx0XHRcdFx0YnJlYWs7XG5cdFx0XHRcdH1cblx0XHRcdH1cblx0XHR9XG5cdH1cblxuXHQvLyBDb21waWxlIGFuZCBleGVjdXRlIGEgZmlsdGVyaW5nIGZ1bmN0aW9uIGlmIG9uZSBpcyBub3QgcHJvdmlkZWRcblx0Ly8gUHJvdmlkZSBgbWF0Y2hgIHRvIGF2b2lkIHJldG9rZW5pemF0aW9uIGlmIHdlIG1vZGlmaWVkIHRoZSBzZWxlY3RvciBhYm92ZVxuXHQoIGNvbXBpbGVkIHx8IGNvbXBpbGUoIHNlbGVjdG9yLCBtYXRjaCApICkoXG5cdFx0c2VlZCxcblx0XHRjb250ZXh0LFxuXHRcdCFkb2N1bWVudElzSFRNTCxcblx0XHRyZXN1bHRzLFxuXHRcdCFjb250ZXh0IHx8IHJzaWJsaW5nLnRlc3QoIHNlbGVjdG9yICkgJiYgdGVzdENvbnRleHQoIGNvbnRleHQucGFyZW50Tm9kZSApIHx8IGNvbnRleHRcblx0KTtcblx0cmV0dXJuIHJlc3VsdHM7XG59XG5cbi8vIEluaXRpYWxpemUgYWdhaW5zdCB0aGUgZGVmYXVsdCBkb2N1bWVudFxuc2V0RG9jdW1lbnQoKTtcblxualF1ZXJ5LmZpbmQgPSBmaW5kO1xuXG4vLyBUaGVzZSBoYXZlIGFsd2F5cyBiZWVuIHByaXZhdGUsIGJ1dCB0aGV5IHVzZWQgdG8gYmUgZG9jdW1lbnRlZCBhcyBwYXJ0IG9mXG4vLyBTaXp6bGUgc28gbGV0J3MgbWFpbnRhaW4gdGhlbSBmb3Igbm93IGZvciBiYWNrd2FyZHMgY29tcGF0aWJpbGl0eSBwdXJwb3Nlcy5cbmZpbmQuY29tcGlsZSA9IGNvbXBpbGU7XG5maW5kLnNlbGVjdCA9IHNlbGVjdDtcbmZpbmQuc2V0RG9jdW1lbnQgPSBzZXREb2N1bWVudDtcbmZpbmQudG9rZW5pemUgPSB0b2tlbml6ZTtcblxuZnVuY3Rpb24gZGlyKCBlbGVtLCBkaXIsIHVudGlsICkge1xuXHR2YXIgbWF0Y2hlZCA9IFtdLFxuXHRcdHRydW5jYXRlID0gdW50aWwgIT09IHVuZGVmaW5lZDtcblxuXHR3aGlsZSAoICggZWxlbSA9IGVsZW1bIGRpciBdICkgJiYgZWxlbS5ub2RlVHlwZSAhPT0gOSApIHtcblx0XHRpZiAoIGVsZW0ubm9kZVR5cGUgPT09IDEgKSB7XG5cdFx0XHRpZiAoIHRydW5jYXRlICYmIGpRdWVyeSggZWxlbSApLmlzKCB1bnRpbCApICkge1xuXHRcdFx0XHRicmVhaztcblx0XHRcdH1cblx0XHRcdG1hdGNoZWQucHVzaCggZWxlbSApO1xuXHRcdH1cblx0fVxuXHRyZXR1cm4gbWF0Y2hlZDtcbn1cblxuZnVuY3Rpb24gc2libGluZ3MoIG4sIGVsZW0gKSB7XG5cdHZhciBtYXRjaGVkID0gW107XG5cblx0Zm9yICggOyBuOyBuID0gbi5uZXh0U2libGluZyApIHtcblx0XHRpZiAoIG4ubm9kZVR5cGUgPT09IDEgJiYgbiAhPT0gZWxlbSApIHtcblx0XHRcdG1hdGNoZWQucHVzaCggbiApO1xuXHRcdH1cblx0fVxuXG5cdHJldHVybiBtYXRjaGVkO1xufVxuXG52YXIgcm5lZWRzQ29udGV4dCA9IGpRdWVyeS5leHByLm1hdGNoLm5lZWRzQ29udGV4dDtcblxuLy8gcnNpbmdsZVRhZyBtYXRjaGVzIGEgc3RyaW5nIGNvbnNpc3Rpbmcgb2YgYSBzaW5nbGUgSFRNTCBlbGVtZW50IHdpdGggbm8gYXR0cmlidXRlc1xuLy8gYW5kIGNhcHR1cmVzIHRoZSBlbGVtZW50J3MgbmFtZVxudmFyIHJzaW5nbGVUYWcgPSAvXjwoW2Etel1bXlxcL1xcMD46XFx4MjBcXHRcXHJcXG5cXGZdKilbXFx4MjBcXHRcXHJcXG5cXGZdKlxcLz8+KD86PFxcL1xcMT58KSQvaTtcblxuZnVuY3Rpb24gaXNPYnZpb3VzSHRtbCggaW5wdXQgKSB7XG5cdHJldHVybiBpbnB1dFsgMCBdID09PSBcIjxcIiAmJlxuXHRcdGlucHV0WyBpbnB1dC5sZW5ndGggLSAxIF0gPT09IFwiPlwiICYmXG5cdFx0aW5wdXQubGVuZ3RoID49IDM7XG59XG5cbi8vIEltcGxlbWVudCB0aGUgaWRlbnRpY2FsIGZ1bmN0aW9uYWxpdHkgZm9yIGZpbHRlciBhbmQgbm90XG5mdW5jdGlvbiB3aW5ub3coIGVsZW1lbnRzLCBxdWFsaWZpZXIsIG5vdCApIHtcblx0aWYgKCB0eXBlb2YgcXVhbGlmaWVyID09PSBcImZ1bmN0aW9uXCIgKSB7XG5cdFx0cmV0dXJuIGpRdWVyeS5ncmVwKCBlbGVtZW50cywgZnVuY3Rpb24oIGVsZW0sIGkgKSB7XG5cdFx0XHRyZXR1cm4gISFxdWFsaWZpZXIuY2FsbCggZWxlbSwgaSwgZWxlbSApICE9PSBub3Q7XG5cdFx0fSApO1xuXHR9XG5cblx0Ly8gU2luZ2xlIGVsZW1lbnRcblx0aWYgKCBxdWFsaWZpZXIubm9kZVR5cGUgKSB7XG5cdFx0cmV0dXJuIGpRdWVyeS5ncmVwKCBlbGVtZW50cywgZnVuY3Rpb24oIGVsZW0gKSB7XG5cdFx0XHRyZXR1cm4gKCBlbGVtID09PSBxdWFsaWZpZXIgKSAhPT0gbm90O1xuXHRcdH0gKTtcblx0fVxuXG5cdC8vIEFycmF5bGlrZSBvZiBlbGVtZW50cyAoalF1ZXJ5LCBhcmd1bWVudHMsIEFycmF5KVxuXHRpZiAoIHR5cGVvZiBxdWFsaWZpZXIgIT09IFwic3RyaW5nXCIgKSB7XG5cdFx0cmV0dXJuIGpRdWVyeS5ncmVwKCBlbGVtZW50cywgZnVuY3Rpb24oIGVsZW0gKSB7XG5cdFx0XHRyZXR1cm4gKCBpbmRleE9mLmNhbGwoIHF1YWxpZmllciwgZWxlbSApID4gLTEgKSAhPT0gbm90O1xuXHRcdH0gKTtcblx0fVxuXG5cdC8vIEZpbHRlcmVkIGRpcmVjdGx5IGZvciBib3RoIHNpbXBsZSBhbmQgY29tcGxleCBzZWxlY3RvcnNcblx0cmV0dXJuIGpRdWVyeS5maWx0ZXIoIHF1YWxpZmllciwgZWxlbWVudHMsIG5vdCApO1xufVxuXG5qUXVlcnkuZmlsdGVyID0gZnVuY3Rpb24oIGV4cHIsIGVsZW1zLCBub3QgKSB7XG5cdHZhciBlbGVtID0gZWxlbXNbIDAgXTtcblxuXHRpZiAoIG5vdCApIHtcblx0XHRleHByID0gXCI6bm90KFwiICsgZXhwciArIFwiKVwiO1xuXHR9XG5cblx0aWYgKCBlbGVtcy5sZW5ndGggPT09IDEgJiYgZWxlbS5ub2RlVHlwZSA9PT0gMSApIHtcblx0XHRyZXR1cm4galF1ZXJ5LmZpbmQubWF0Y2hlc1NlbGVjdG9yKCBlbGVtLCBleHByICkgPyBbIGVsZW0gXSA6IFtdO1xuXHR9XG5cblx0cmV0dXJuIGpRdWVyeS5maW5kLm1hdGNoZXMoIGV4cHIsIGpRdWVyeS5ncmVwKCBlbGVtcywgZnVuY3Rpb24oIGVsZW0gKSB7XG5cdFx0cmV0dXJuIGVsZW0ubm9kZVR5cGUgPT09IDE7XG5cdH0gKSApO1xufTtcblxualF1ZXJ5LmZuLmV4dGVuZCgge1xuXHRmaW5kOiBmdW5jdGlvbiggc2VsZWN0b3IgKSB7XG5cdFx0dmFyIGksIHJldCxcblx0XHRcdGxlbiA9IHRoaXMubGVuZ3RoLFxuXHRcdFx0c2VsZiA9IHRoaXM7XG5cblx0XHRpZiAoIHR5cGVvZiBzZWxlY3RvciAhPT0gXCJzdHJpbmdcIiApIHtcblx0XHRcdHJldHVybiB0aGlzLnB1c2hTdGFjayggalF1ZXJ5KCBzZWxlY3RvciApLmZpbHRlciggZnVuY3Rpb24oKSB7XG5cdFx0XHRcdGZvciAoIGkgPSAwOyBpIDwgbGVuOyBpKysgKSB7XG5cdFx0XHRcdFx0aWYgKCBqUXVlcnkuY29udGFpbnMoIHNlbGZbIGkgXSwgdGhpcyApICkge1xuXHRcdFx0XHRcdFx0cmV0dXJuIHRydWU7XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHR9XG5cdFx0XHR9ICkgKTtcblx0XHR9XG5cblx0XHRyZXQgPSB0aGlzLnB1c2hTdGFjayggW10gKTtcblxuXHRcdGZvciAoIGkgPSAwOyBpIDwgbGVuOyBpKysgKSB7XG5cdFx0XHRqUXVlcnkuZmluZCggc2VsZWN0b3IsIHNlbGZbIGkgXSwgcmV0ICk7XG5cdFx0fVxuXG5cdFx0cmV0dXJuIGxlbiA+IDEgPyBqUXVlcnkudW5pcXVlU29ydCggcmV0ICkgOiByZXQ7XG5cdH0sXG5cdGZpbHRlcjogZnVuY3Rpb24oIHNlbGVjdG9yICkge1xuXHRcdHJldHVybiB0aGlzLnB1c2hTdGFjayggd2lubm93KCB0aGlzLCBzZWxlY3RvciB8fCBbXSwgZmFsc2UgKSApO1xuXHR9LFxuXHRub3Q6IGZ1bmN0aW9uKCBzZWxlY3RvciApIHtcblx0XHRyZXR1cm4gdGhpcy5wdXNoU3RhY2soIHdpbm5vdyggdGhpcywgc2VsZWN0b3IgfHwgW10sIHRydWUgKSApO1xuXHR9LFxuXHRpczogZnVuY3Rpb24oIHNlbGVjdG9yICkge1xuXHRcdHJldHVybiAhIXdpbm5vdyhcblx0XHRcdHRoaXMsXG5cblx0XHRcdC8vIElmIHRoaXMgaXMgYSBwb3NpdGlvbmFsL3JlbGF0aXZlIHNlbGVjdG9yLCBjaGVjayBtZW1iZXJzaGlwIGluIHRoZSByZXR1cm5lZCBzZXRcblx0XHRcdC8vIHNvICQoXCJwOmZpcnN0XCIpLmlzKFwicDpsYXN0XCIpIHdvbid0IHJldHVybiB0cnVlIGZvciBhIGRvYyB3aXRoIHR3byBcInBcIi5cblx0XHRcdHR5cGVvZiBzZWxlY3RvciA9PT0gXCJzdHJpbmdcIiAmJiBybmVlZHNDb250ZXh0LnRlc3QoIHNlbGVjdG9yICkgP1xuXHRcdFx0XHRqUXVlcnkoIHNlbGVjdG9yICkgOlxuXHRcdFx0XHRzZWxlY3RvciB8fCBbXSxcblx0XHRcdGZhbHNlXG5cdFx0KS5sZW5ndGg7XG5cdH1cbn0gKTtcblxuLy8gSW5pdGlhbGl6ZSBhIGpRdWVyeSBvYmplY3RcblxuLy8gQSBjZW50cmFsIHJlZmVyZW5jZSB0byB0aGUgcm9vdCBqUXVlcnkoZG9jdW1lbnQpXG52YXIgcm9vdGpRdWVyeSxcblxuXHQvLyBBIHNpbXBsZSB3YXkgdG8gY2hlY2sgZm9yIEhUTUwgc3RyaW5nc1xuXHQvLyBQcmlvcml0aXplICNpZCBvdmVyIDx0YWc+IHRvIGF2b2lkIFhTUyB2aWEgbG9jYXRpb24uaGFzaCAodHJhYy05NTIxKVxuXHQvLyBTdHJpY3QgSFRNTCByZWNvZ25pdGlvbiAodHJhYy0xMTI5MDogbXVzdCBzdGFydCB3aXRoIDwpXG5cdC8vIFNob3J0Y3V0IHNpbXBsZSAjaWQgY2FzZSBmb3Igc3BlZWRcblx0cnF1aWNrRXhwciA9IC9eKD86XFxzKig8W1xcd1xcV10rPilbXj5dKnwjKFtcXHctXSspKSQvLFxuXG5cdGluaXQgPSBqUXVlcnkuZm4uaW5pdCA9IGZ1bmN0aW9uKCBzZWxlY3RvciwgY29udGV4dCApIHtcblx0XHR2YXIgbWF0Y2gsIGVsZW07XG5cblx0XHQvLyBIQU5ETEU6ICQoXCJcIiksICQobnVsbCksICQodW5kZWZpbmVkKSwgJChmYWxzZSlcblx0XHRpZiAoICFzZWxlY3RvciApIHtcblx0XHRcdHJldHVybiB0aGlzO1xuXHRcdH1cblxuXHRcdC8vIEhBTkRMRTogJChET01FbGVtZW50KVxuXHRcdGlmICggc2VsZWN0b3Iubm9kZVR5cGUgKSB7XG5cdFx0XHR0aGlzWyAwIF0gPSBzZWxlY3Rvcjtcblx0XHRcdHRoaXMubGVuZ3RoID0gMTtcblx0XHRcdHJldHVybiB0aGlzO1xuXG5cdFx0Ly8gSEFORExFOiAkKGZ1bmN0aW9uKVxuXHRcdC8vIFNob3J0Y3V0IGZvciBkb2N1bWVudCByZWFkeVxuXHRcdH0gZWxzZSBpZiAoIHR5cGVvZiBzZWxlY3RvciA9PT0gXCJmdW5jdGlvblwiICkge1xuXHRcdFx0cmV0dXJuIHJvb3RqUXVlcnkucmVhZHkgIT09IHVuZGVmaW5lZCA/XG5cdFx0XHRcdHJvb3RqUXVlcnkucmVhZHkoIHNlbGVjdG9yICkgOlxuXG5cdFx0XHRcdC8vIEV4ZWN1dGUgaW1tZWRpYXRlbHkgaWYgcmVhZHkgaXMgbm90IHByZXNlbnRcblx0XHRcdFx0c2VsZWN0b3IoIGpRdWVyeSApO1xuXG5cdFx0fSBlbHNlIHtcblxuXHRcdFx0Ly8gSGFuZGxlIG9idmlvdXMgSFRNTCBzdHJpbmdzXG5cdFx0XHRtYXRjaCA9IHNlbGVjdG9yICsgXCJcIjtcblx0XHRcdGlmICggaXNPYnZpb3VzSHRtbCggbWF0Y2ggKSApIHtcblxuXHRcdFx0XHQvLyBBc3N1bWUgdGhhdCBzdHJpbmdzIHRoYXQgc3RhcnQgYW5kIGVuZCB3aXRoIDw+IGFyZSBIVE1MIGFuZCBza2lwXG5cdFx0XHRcdC8vIHRoZSByZWdleCBjaGVjay4gVGhpcyBhbHNvIGhhbmRsZXMgYnJvd3Nlci1zdXBwb3J0ZWQgSFRNTCB3cmFwcGVyc1xuXHRcdFx0XHQvLyBsaWtlIFRydXN0ZWRIVE1MLlxuXHRcdFx0XHRtYXRjaCA9IFsgbnVsbCwgc2VsZWN0b3IsIG51bGwgXTtcblxuXHRcdFx0Ly8gSGFuZGxlIEhUTUwgc3RyaW5ncyBvciBzZWxlY3RvcnNcblx0XHRcdH0gZWxzZSBpZiAoIHR5cGVvZiBzZWxlY3RvciA9PT0gXCJzdHJpbmdcIiApIHtcblx0XHRcdFx0bWF0Y2ggPSBycXVpY2tFeHByLmV4ZWMoIHNlbGVjdG9yICk7XG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRyZXR1cm4galF1ZXJ5Lm1ha2VBcnJheSggc2VsZWN0b3IsIHRoaXMgKTtcblx0XHRcdH1cblxuXHRcdFx0Ly8gTWF0Y2ggaHRtbCBvciBtYWtlIHN1cmUgbm8gY29udGV4dCBpcyBzcGVjaWZpZWQgZm9yICNpZFxuXHRcdFx0Ly8gTm90ZTogbWF0Y2hbMV0gbWF5IGJlIGEgc3RyaW5nIG9yIGEgVHJ1c3RlZEhUTUwgd3JhcHBlclxuXHRcdFx0aWYgKCBtYXRjaCAmJiAoIG1hdGNoWyAxIF0gfHwgIWNvbnRleHQgKSApIHtcblxuXHRcdFx0XHQvLyBIQU5ETEU6ICQoaHRtbCkgLT4gJChhcnJheSlcblx0XHRcdFx0aWYgKCBtYXRjaFsgMSBdICkge1xuXHRcdFx0XHRcdGNvbnRleHQgPSBjb250ZXh0IGluc3RhbmNlb2YgalF1ZXJ5ID8gY29udGV4dFsgMCBdIDogY29udGV4dDtcblxuXHRcdFx0XHRcdC8vIE9wdGlvbiB0byBydW4gc2NyaXB0cyBpcyB0cnVlIGZvciBiYWNrLWNvbXBhdFxuXHRcdFx0XHRcdC8vIEludGVudGlvbmFsbHkgbGV0IHRoZSBlcnJvciBiZSB0aHJvd24gaWYgcGFyc2VIVE1MIGlzIG5vdCBwcmVzZW50XG5cdFx0XHRcdFx0alF1ZXJ5Lm1lcmdlKCB0aGlzLCBqUXVlcnkucGFyc2VIVE1MKFxuXHRcdFx0XHRcdFx0bWF0Y2hbIDEgXSxcblx0XHRcdFx0XHRcdGNvbnRleHQgJiYgY29udGV4dC5ub2RlVHlwZSA/IGNvbnRleHQub3duZXJEb2N1bWVudCB8fCBjb250ZXh0IDogZG9jdW1lbnQkMSxcblx0XHRcdFx0XHRcdHRydWVcblx0XHRcdFx0XHQpICk7XG5cblx0XHRcdFx0XHQvLyBIQU5ETEU6ICQoaHRtbCwgcHJvcHMpXG5cdFx0XHRcdFx0aWYgKCByc2luZ2xlVGFnLnRlc3QoIG1hdGNoWyAxIF0gKSAmJiBqUXVlcnkuaXNQbGFpbk9iamVjdCggY29udGV4dCApICkge1xuXHRcdFx0XHRcdFx0Zm9yICggbWF0Y2ggaW4gY29udGV4dCApIHtcblxuXHRcdFx0XHRcdFx0XHQvLyBQcm9wZXJ0aWVzIG9mIGNvbnRleHQgYXJlIGNhbGxlZCBhcyBtZXRob2RzIGlmIHBvc3NpYmxlXG5cdFx0XHRcdFx0XHRcdGlmICggdHlwZW9mIHRoaXNbIG1hdGNoIF0gPT09IFwiZnVuY3Rpb25cIiApIHtcblx0XHRcdFx0XHRcdFx0XHR0aGlzWyBtYXRjaCBdKCBjb250ZXh0WyBtYXRjaCBdICk7XG5cblx0XHRcdFx0XHRcdFx0Ly8gLi4uYW5kIG90aGVyd2lzZSBzZXQgYXMgYXR0cmlidXRlc1xuXHRcdFx0XHRcdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRcdFx0XHRcdHRoaXMuYXR0ciggbWF0Y2gsIGNvbnRleHRbIG1hdGNoIF0gKTtcblx0XHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdH1cblxuXHRcdFx0XHRcdHJldHVybiB0aGlzO1xuXG5cdFx0XHRcdC8vIEhBTkRMRTogJCgjaWQpXG5cdFx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdFx0ZWxlbSA9IGRvY3VtZW50JDEuZ2V0RWxlbWVudEJ5SWQoIG1hdGNoWyAyIF0gKTtcblxuXHRcdFx0XHRcdGlmICggZWxlbSApIHtcblxuXHRcdFx0XHRcdFx0Ly8gSW5qZWN0IHRoZSBlbGVtZW50IGRpcmVjdGx5IGludG8gdGhlIGpRdWVyeSBvYmplY3Rcblx0XHRcdFx0XHRcdHRoaXNbIDAgXSA9IGVsZW07XG5cdFx0XHRcdFx0XHR0aGlzLmxlbmd0aCA9IDE7XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHRcdHJldHVybiB0aGlzO1xuXHRcdFx0XHR9XG5cblx0XHRcdC8vIEhBTkRMRTogJChleHByKSAmICQoZXhwciwgJCguLi4pKVxuXHRcdFx0fSBlbHNlIGlmICggIWNvbnRleHQgfHwgY29udGV4dC5qcXVlcnkgKSB7XG5cdFx0XHRcdHJldHVybiAoIGNvbnRleHQgfHwgcm9vdGpRdWVyeSApLmZpbmQoIHNlbGVjdG9yICk7XG5cblx0XHRcdC8vIEhBTkRMRTogJChleHByLCBjb250ZXh0KVxuXHRcdFx0Ly8gKHdoaWNoIGlzIGp1c3QgZXF1aXZhbGVudCB0bzogJChjb250ZXh0KS5maW5kKGV4cHIpXG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRyZXR1cm4gdGhpcy5jb25zdHJ1Y3RvciggY29udGV4dCApLmZpbmQoIHNlbGVjdG9yICk7XG5cdFx0XHR9XG5cdFx0fVxuXG5cdH07XG5cbi8vIEdpdmUgdGhlIGluaXQgZnVuY3Rpb24gdGhlIGpRdWVyeSBwcm90b3R5cGUgZm9yIGxhdGVyIGluc3RhbnRpYXRpb25cbmluaXQucHJvdG90eXBlID0galF1ZXJ5LmZuO1xuXG4vLyBJbml0aWFsaXplIGNlbnRyYWwgcmVmZXJlbmNlXG5yb290alF1ZXJ5ID0galF1ZXJ5KCBkb2N1bWVudCQxICk7XG5cbnZhciBycGFyZW50c3ByZXYgPSAvXig/OnBhcmVudHN8cHJldig/OlVudGlsfEFsbCkpLyxcblxuXHQvLyBNZXRob2RzIGd1YXJhbnRlZWQgdG8gcHJvZHVjZSBhIHVuaXF1ZSBzZXQgd2hlbiBzdGFydGluZyBmcm9tIGEgdW5pcXVlIHNldFxuXHRndWFyYW50ZWVkVW5pcXVlID0ge1xuXHRcdGNoaWxkcmVuOiB0cnVlLFxuXHRcdGNvbnRlbnRzOiB0cnVlLFxuXHRcdG5leHQ6IHRydWUsXG5cdFx0cHJldjogdHJ1ZVxuXHR9O1xuXG5qUXVlcnkuZm4uZXh0ZW5kKCB7XG5cdGhhczogZnVuY3Rpb24oIHRhcmdldCApIHtcblx0XHR2YXIgdGFyZ2V0cyA9IGpRdWVyeSggdGFyZ2V0LCB0aGlzICksXG5cdFx0XHRsID0gdGFyZ2V0cy5sZW5ndGg7XG5cblx0XHRyZXR1cm4gdGhpcy5maWx0ZXIoIGZ1bmN0aW9uKCkge1xuXHRcdFx0dmFyIGkgPSAwO1xuXHRcdFx0Zm9yICggOyBpIDwgbDsgaSsrICkge1xuXHRcdFx0XHRpZiAoIGpRdWVyeS5jb250YWlucyggdGhpcywgdGFyZ2V0c1sgaSBdICkgKSB7XG5cdFx0XHRcdFx0cmV0dXJuIHRydWU7XG5cdFx0XHRcdH1cblx0XHRcdH1cblx0XHR9ICk7XG5cdH0sXG5cblx0Y2xvc2VzdDogZnVuY3Rpb24oIHNlbGVjdG9ycywgY29udGV4dCApIHtcblx0XHR2YXIgY3VyLFxuXHRcdFx0aSA9IDAsXG5cdFx0XHRsID0gdGhpcy5sZW5ndGgsXG5cdFx0XHRtYXRjaGVkID0gW10sXG5cdFx0XHR0YXJnZXRzID0gdHlwZW9mIHNlbGVjdG9ycyAhPT0gXCJzdHJpbmdcIiAmJiBqUXVlcnkoIHNlbGVjdG9ycyApO1xuXG5cdFx0Ly8gUG9zaXRpb25hbCBzZWxlY3RvcnMgbmV2ZXIgbWF0Y2gsIHNpbmNlIHRoZXJlJ3Mgbm8gX3NlbGVjdGlvbl8gY29udGV4dFxuXHRcdGlmICggIXJuZWVkc0NvbnRleHQudGVzdCggc2VsZWN0b3JzICkgKSB7XG5cdFx0XHRmb3IgKCA7IGkgPCBsOyBpKysgKSB7XG5cdFx0XHRcdGZvciAoIGN1ciA9IHRoaXNbIGkgXTsgY3VyICYmIGN1ciAhPT0gY29udGV4dDsgY3VyID0gY3VyLnBhcmVudE5vZGUgKSB7XG5cblx0XHRcdFx0XHQvLyBBbHdheXMgc2tpcCBkb2N1bWVudCBmcmFnbWVudHNcblx0XHRcdFx0XHRpZiAoIGN1ci5ub2RlVHlwZSA8IDExICYmICggdGFyZ2V0cyA/XG5cdFx0XHRcdFx0XHR0YXJnZXRzLmluZGV4KCBjdXIgKSA+IC0xIDpcblxuXHRcdFx0XHRcdFx0Ly8gRG9uJ3QgcGFzcyBub24tZWxlbWVudHMgdG8galF1ZXJ5I2ZpbmRcblx0XHRcdFx0XHRcdGN1ci5ub2RlVHlwZSA9PT0gMSAmJlxuXHRcdFx0XHRcdFx0XHRqUXVlcnkuZmluZC5tYXRjaGVzU2VsZWN0b3IoIGN1ciwgc2VsZWN0b3JzICkgKSApIHtcblxuXHRcdFx0XHRcdFx0bWF0Y2hlZC5wdXNoKCBjdXIgKTtcblx0XHRcdFx0XHRcdGJyZWFrO1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0fVxuXHRcdFx0fVxuXHRcdH1cblxuXHRcdHJldHVybiB0aGlzLnB1c2hTdGFjayggbWF0Y2hlZC5sZW5ndGggPiAxID8galF1ZXJ5LnVuaXF1ZVNvcnQoIG1hdGNoZWQgKSA6IG1hdGNoZWQgKTtcblx0fSxcblxuXHQvLyBEZXRlcm1pbmUgdGhlIHBvc2l0aW9uIG9mIGFuIGVsZW1lbnQgd2l0aGluIHRoZSBzZXRcblx0aW5kZXg6IGZ1bmN0aW9uKCBlbGVtICkge1xuXG5cdFx0Ly8gTm8gYXJndW1lbnQsIHJldHVybiBpbmRleCBpbiBwYXJlbnRcblx0XHRpZiAoICFlbGVtICkge1xuXHRcdFx0cmV0dXJuICggdGhpc1sgMCBdICYmIHRoaXNbIDAgXS5wYXJlbnROb2RlICkgPyB0aGlzLmZpcnN0KCkucHJldkFsbCgpLmxlbmd0aCA6IC0xO1xuXHRcdH1cblxuXHRcdC8vIEluZGV4IGluIHNlbGVjdG9yXG5cdFx0aWYgKCB0eXBlb2YgZWxlbSA9PT0gXCJzdHJpbmdcIiApIHtcblx0XHRcdHJldHVybiBpbmRleE9mLmNhbGwoIGpRdWVyeSggZWxlbSApLCB0aGlzWyAwIF0gKTtcblx0XHR9XG5cblx0XHQvLyBMb2NhdGUgdGhlIHBvc2l0aW9uIG9mIHRoZSBkZXNpcmVkIGVsZW1lbnRcblx0XHRyZXR1cm4gaW5kZXhPZi5jYWxsKCB0aGlzLFxuXG5cdFx0XHQvLyBJZiBpdCByZWNlaXZlcyBhIGpRdWVyeSBvYmplY3QsIHRoZSBmaXJzdCBlbGVtZW50IGlzIHVzZWRcblx0XHRcdGVsZW0uanF1ZXJ5ID8gZWxlbVsgMCBdIDogZWxlbVxuXHRcdCk7XG5cdH0sXG5cblx0YWRkOiBmdW5jdGlvbiggc2VsZWN0b3IsIGNvbnRleHQgKSB7XG5cdFx0cmV0dXJuIHRoaXMucHVzaFN0YWNrKFxuXHRcdFx0alF1ZXJ5LnVuaXF1ZVNvcnQoXG5cdFx0XHRcdGpRdWVyeS5tZXJnZSggdGhpcy5nZXQoKSwgalF1ZXJ5KCBzZWxlY3RvciwgY29udGV4dCApIClcblx0XHRcdClcblx0XHQpO1xuXHR9LFxuXG5cdGFkZEJhY2s6IGZ1bmN0aW9uKCBzZWxlY3RvciApIHtcblx0XHRyZXR1cm4gdGhpcy5hZGQoIHNlbGVjdG9yID09IG51bGwgP1xuXHRcdFx0dGhpcy5wcmV2T2JqZWN0IDogdGhpcy5wcmV2T2JqZWN0LmZpbHRlciggc2VsZWN0b3IgKVxuXHRcdCk7XG5cdH1cbn0gKTtcblxuZnVuY3Rpb24gc2libGluZyggY3VyLCBkaXIgKSB7XG5cdHdoaWxlICggKCBjdXIgPSBjdXJbIGRpciBdICkgJiYgY3VyLm5vZGVUeXBlICE9PSAxICkge31cblx0cmV0dXJuIGN1cjtcbn1cblxualF1ZXJ5LmVhY2goIHtcblx0cGFyZW50OiBmdW5jdGlvbiggZWxlbSApIHtcblx0XHR2YXIgcGFyZW50ID0gZWxlbS5wYXJlbnROb2RlO1xuXHRcdHJldHVybiBwYXJlbnQgJiYgcGFyZW50Lm5vZGVUeXBlICE9PSAxMSA/IHBhcmVudCA6IG51bGw7XG5cdH0sXG5cdHBhcmVudHM6IGZ1bmN0aW9uKCBlbGVtICkge1xuXHRcdHJldHVybiBkaXIoIGVsZW0sIFwicGFyZW50Tm9kZVwiICk7XG5cdH0sXG5cdHBhcmVudHNVbnRpbDogZnVuY3Rpb24oIGVsZW0sIF9pLCB1bnRpbCApIHtcblx0XHRyZXR1cm4gZGlyKCBlbGVtLCBcInBhcmVudE5vZGVcIiwgdW50aWwgKTtcblx0fSxcblx0bmV4dDogZnVuY3Rpb24oIGVsZW0gKSB7XG5cdFx0cmV0dXJuIHNpYmxpbmcoIGVsZW0sIFwibmV4dFNpYmxpbmdcIiApO1xuXHR9LFxuXHRwcmV2OiBmdW5jdGlvbiggZWxlbSApIHtcblx0XHRyZXR1cm4gc2libGluZyggZWxlbSwgXCJwcmV2aW91c1NpYmxpbmdcIiApO1xuXHR9LFxuXHRuZXh0QWxsOiBmdW5jdGlvbiggZWxlbSApIHtcblx0XHRyZXR1cm4gZGlyKCBlbGVtLCBcIm5leHRTaWJsaW5nXCIgKTtcblx0fSxcblx0cHJldkFsbDogZnVuY3Rpb24oIGVsZW0gKSB7XG5cdFx0cmV0dXJuIGRpciggZWxlbSwgXCJwcmV2aW91c1NpYmxpbmdcIiApO1xuXHR9LFxuXHRuZXh0VW50aWw6IGZ1bmN0aW9uKCBlbGVtLCBfaSwgdW50aWwgKSB7XG5cdFx0cmV0dXJuIGRpciggZWxlbSwgXCJuZXh0U2libGluZ1wiLCB1bnRpbCApO1xuXHR9LFxuXHRwcmV2VW50aWw6IGZ1bmN0aW9uKCBlbGVtLCBfaSwgdW50aWwgKSB7XG5cdFx0cmV0dXJuIGRpciggZWxlbSwgXCJwcmV2aW91c1NpYmxpbmdcIiwgdW50aWwgKTtcblx0fSxcblx0c2libGluZ3M6IGZ1bmN0aW9uKCBlbGVtICkge1xuXHRcdHJldHVybiBzaWJsaW5ncyggKCBlbGVtLnBhcmVudE5vZGUgfHwge30gKS5maXJzdENoaWxkLCBlbGVtICk7XG5cdH0sXG5cdGNoaWxkcmVuOiBmdW5jdGlvbiggZWxlbSApIHtcblx0XHRyZXR1cm4gc2libGluZ3MoIGVsZW0uZmlyc3RDaGlsZCApO1xuXHR9LFxuXHRjb250ZW50czogZnVuY3Rpb24oIGVsZW0gKSB7XG5cdFx0aWYgKCBlbGVtLmNvbnRlbnREb2N1bWVudCAhPSBudWxsICYmXG5cblx0XHRcdC8vIFN1cHBvcnQ6IElFIDExK1xuXHRcdFx0Ly8gPG9iamVjdD4gZWxlbWVudHMgd2l0aCBubyBgZGF0YWAgYXR0cmlidXRlIGhhcyBhbiBvYmplY3Rcblx0XHRcdC8vIGBjb250ZW50RG9jdW1lbnRgIHdpdGggYSBgbnVsbGAgcHJvdG90eXBlLlxuXHRcdFx0Z2V0UHJvdG8oIGVsZW0uY29udGVudERvY3VtZW50ICkgKSB7XG5cblx0XHRcdHJldHVybiBlbGVtLmNvbnRlbnREb2N1bWVudDtcblx0XHR9XG5cblx0XHQvLyBTdXBwb3J0OiBJRSA5IC0gMTErXG5cdFx0Ly8gVHJlYXQgdGhlIHRlbXBsYXRlIGVsZW1lbnQgYXMgYSByZWd1bGFyIG9uZSBpbiBicm93c2VycyB0aGF0XG5cdFx0Ly8gZG9uJ3Qgc3VwcG9ydCBpdC5cblx0XHRpZiAoIG5vZGVOYW1lKCBlbGVtLCBcInRlbXBsYXRlXCIgKSApIHtcblx0XHRcdGVsZW0gPSBlbGVtLmNvbnRlbnQgfHwgZWxlbTtcblx0XHR9XG5cblx0XHRyZXR1cm4galF1ZXJ5Lm1lcmdlKCBbXSwgZWxlbS5jaGlsZE5vZGVzICk7XG5cdH1cbn0sIGZ1bmN0aW9uKCBuYW1lLCBmbiApIHtcblx0alF1ZXJ5LmZuWyBuYW1lIF0gPSBmdW5jdGlvbiggdW50aWwsIHNlbGVjdG9yICkge1xuXHRcdHZhciBtYXRjaGVkID0galF1ZXJ5Lm1hcCggdGhpcywgZm4sIHVudGlsICk7XG5cblx0XHRpZiAoIG5hbWUuc2xpY2UoIC01ICkgIT09IFwiVW50aWxcIiApIHtcblx0XHRcdHNlbGVjdG9yID0gdW50aWw7XG5cdFx0fVxuXG5cdFx0aWYgKCBzZWxlY3RvciAmJiB0eXBlb2Ygc2VsZWN0b3IgPT09IFwic3RyaW5nXCIgKSB7XG5cdFx0XHRtYXRjaGVkID0galF1ZXJ5LmZpbHRlciggc2VsZWN0b3IsIG1hdGNoZWQgKTtcblx0XHR9XG5cblx0XHRpZiAoIHRoaXMubGVuZ3RoID4gMSApIHtcblxuXHRcdFx0Ly8gUmVtb3ZlIGR1cGxpY2F0ZXNcblx0XHRcdGlmICggIWd1YXJhbnRlZWRVbmlxdWVbIG5hbWUgXSApIHtcblx0XHRcdFx0alF1ZXJ5LnVuaXF1ZVNvcnQoIG1hdGNoZWQgKTtcblx0XHRcdH1cblxuXHRcdFx0Ly8gUmV2ZXJzZSBvcmRlciBmb3IgcGFyZW50cyogYW5kIHByZXYtZGVyaXZhdGl2ZXNcblx0XHRcdGlmICggcnBhcmVudHNwcmV2LnRlc3QoIG5hbWUgKSApIHtcblx0XHRcdFx0bWF0Y2hlZC5yZXZlcnNlKCk7XG5cdFx0XHR9XG5cdFx0fVxuXG5cdFx0cmV0dXJuIHRoaXMucHVzaFN0YWNrKCBtYXRjaGVkICk7XG5cdH07XG59ICk7XG5cbi8vIENvbnZlcnQgU3RyaW5nLWZvcm1hdHRlZCBvcHRpb25zIGludG8gT2JqZWN0LWZvcm1hdHRlZCBvbmVzXG5mdW5jdGlvbiBjcmVhdGVPcHRpb25zKCBvcHRpb25zICkge1xuXHR2YXIgb2JqZWN0ID0ge307XG5cdGpRdWVyeS5lYWNoKCBvcHRpb25zLm1hdGNoKCBybm90aHRtbHdoaXRlICkgfHwgW10sIGZ1bmN0aW9uKCBfLCBmbGFnICkge1xuXHRcdG9iamVjdFsgZmxhZyBdID0gdHJ1ZTtcblx0fSApO1xuXHRyZXR1cm4gb2JqZWN0O1xufVxuXG4vKlxuICogQ3JlYXRlIGEgY2FsbGJhY2sgbGlzdCB1c2luZyB0aGUgZm9sbG93aW5nIHBhcmFtZXRlcnM6XG4gKlxuICpcdG9wdGlvbnM6IGFuIG9wdGlvbmFsIGxpc3Qgb2Ygc3BhY2Utc2VwYXJhdGVkIG9wdGlvbnMgdGhhdCB3aWxsIGNoYW5nZSBob3dcbiAqXHRcdFx0dGhlIGNhbGxiYWNrIGxpc3QgYmVoYXZlcyBvciBhIG1vcmUgdHJhZGl0aW9uYWwgb3B0aW9uIG9iamVjdFxuICpcbiAqIEJ5IGRlZmF1bHQgYSBjYWxsYmFjayBsaXN0IHdpbGwgYWN0IGxpa2UgYW4gZXZlbnQgY2FsbGJhY2sgbGlzdCBhbmQgY2FuIGJlXG4gKiBcImZpcmVkXCIgbXVsdGlwbGUgdGltZXMuXG4gKlxuICogUG9zc2libGUgb3B0aW9uczpcbiAqXG4gKlx0b25jZTpcdFx0XHR3aWxsIGVuc3VyZSB0aGUgY2FsbGJhY2sgbGlzdCBjYW4gb25seSBiZSBmaXJlZCBvbmNlIChsaWtlIGEgRGVmZXJyZWQpXG4gKlxuICpcdG1lbW9yeTpcdFx0XHR3aWxsIGtlZXAgdHJhY2sgb2YgcHJldmlvdXMgdmFsdWVzIGFuZCB3aWxsIGNhbGwgYW55IGNhbGxiYWNrIGFkZGVkXG4gKlx0XHRcdFx0XHRhZnRlciB0aGUgbGlzdCBoYXMgYmVlbiBmaXJlZCByaWdodCBhd2F5IHdpdGggdGhlIGxhdGVzdCBcIm1lbW9yaXplZFwiXG4gKlx0XHRcdFx0XHR2YWx1ZXMgKGxpa2UgYSBEZWZlcnJlZClcbiAqXG4gKlx0dW5pcXVlOlx0XHRcdHdpbGwgZW5zdXJlIGEgY2FsbGJhY2sgY2FuIG9ubHkgYmUgYWRkZWQgb25jZSAobm8gZHVwbGljYXRlIGluIHRoZSBsaXN0KVxuICpcbiAqXHRzdG9wT25GYWxzZTpcdGludGVycnVwdCBjYWxsaW5ncyB3aGVuIGEgY2FsbGJhY2sgcmV0dXJucyBmYWxzZVxuICpcbiAqL1xualF1ZXJ5LkNhbGxiYWNrcyA9IGZ1bmN0aW9uKCBvcHRpb25zICkge1xuXG5cdC8vIENvbnZlcnQgb3B0aW9ucyBmcm9tIFN0cmluZy1mb3JtYXR0ZWQgdG8gT2JqZWN0LWZvcm1hdHRlZCBpZiBuZWVkZWRcblx0Ly8gKHdlIGNoZWNrIGluIGNhY2hlIGZpcnN0KVxuXHRvcHRpb25zID0gdHlwZW9mIG9wdGlvbnMgPT09IFwic3RyaW5nXCIgP1xuXHRcdGNyZWF0ZU9wdGlvbnMoIG9wdGlvbnMgKSA6XG5cdFx0alF1ZXJ5LmV4dGVuZCgge30sIG9wdGlvbnMgKTtcblxuXHR2YXIgLy8gRmxhZyB0byBrbm93IGlmIGxpc3QgaXMgY3VycmVudGx5IGZpcmluZ1xuXHRcdGZpcmluZyxcblxuXHRcdC8vIExhc3QgZmlyZSB2YWx1ZSBmb3Igbm9uLWZvcmdldHRhYmxlIGxpc3RzXG5cdFx0bWVtb3J5LFxuXG5cdFx0Ly8gRmxhZyB0byBrbm93IGlmIGxpc3Qgd2FzIGFscmVhZHkgZmlyZWRcblx0XHRmaXJlZCxcblxuXHRcdC8vIEZsYWcgdG8gcHJldmVudCBmaXJpbmdcblx0XHRsb2NrZWQsXG5cblx0XHQvLyBBY3R1YWwgY2FsbGJhY2sgbGlzdFxuXHRcdGxpc3QgPSBbXSxcblxuXHRcdC8vIFF1ZXVlIG9mIGV4ZWN1dGlvbiBkYXRhIGZvciByZXBlYXRhYmxlIGxpc3RzXG5cdFx0cXVldWUgPSBbXSxcblxuXHRcdC8vIEluZGV4IG9mIGN1cnJlbnRseSBmaXJpbmcgY2FsbGJhY2sgKG1vZGlmaWVkIGJ5IGFkZC9yZW1vdmUgYXMgbmVlZGVkKVxuXHRcdGZpcmluZ0luZGV4ID0gLTEsXG5cblx0XHQvLyBGaXJlIGNhbGxiYWNrc1xuXHRcdGZpcmUgPSBmdW5jdGlvbigpIHtcblxuXHRcdFx0Ly8gRW5mb3JjZSBzaW5nbGUtZmlyaW5nXG5cdFx0XHRsb2NrZWQgPSBsb2NrZWQgfHwgb3B0aW9ucy5vbmNlO1xuXG5cdFx0XHQvLyBFeGVjdXRlIGNhbGxiYWNrcyBmb3IgYWxsIHBlbmRpbmcgZXhlY3V0aW9ucyxcblx0XHRcdC8vIHJlc3BlY3RpbmcgZmlyaW5nSW5kZXggb3ZlcnJpZGVzIGFuZCBydW50aW1lIGNoYW5nZXNcblx0XHRcdGZpcmVkID0gZmlyaW5nID0gdHJ1ZTtcblx0XHRcdGZvciAoIDsgcXVldWUubGVuZ3RoOyBmaXJpbmdJbmRleCA9IC0xICkge1xuXHRcdFx0XHRtZW1vcnkgPSBxdWV1ZS5zaGlmdCgpO1xuXHRcdFx0XHR3aGlsZSAoICsrZmlyaW5nSW5kZXggPCBsaXN0Lmxlbmd0aCApIHtcblxuXHRcdFx0XHRcdC8vIFJ1biBjYWxsYmFjayBhbmQgY2hlY2sgZm9yIGVhcmx5IHRlcm1pbmF0aW9uXG5cdFx0XHRcdFx0aWYgKCBsaXN0WyBmaXJpbmdJbmRleCBdLmFwcGx5KCBtZW1vcnlbIDAgXSwgbWVtb3J5WyAxIF0gKSA9PT0gZmFsc2UgJiZcblx0XHRcdFx0XHRcdG9wdGlvbnMuc3RvcE9uRmFsc2UgKSB7XG5cblx0XHRcdFx0XHRcdC8vIEp1bXAgdG8gZW5kIGFuZCBmb3JnZXQgdGhlIGRhdGEgc28gLmFkZCBkb2Vzbid0IHJlLWZpcmVcblx0XHRcdFx0XHRcdGZpcmluZ0luZGV4ID0gbGlzdC5sZW5ndGg7XG5cdFx0XHRcdFx0XHRtZW1vcnkgPSBmYWxzZTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH1cblx0XHRcdH1cblxuXHRcdFx0Ly8gRm9yZ2V0IHRoZSBkYXRhIGlmIHdlJ3JlIGRvbmUgd2l0aCBpdFxuXHRcdFx0aWYgKCAhb3B0aW9ucy5tZW1vcnkgKSB7XG5cdFx0XHRcdG1lbW9yeSA9IGZhbHNlO1xuXHRcdFx0fVxuXG5cdFx0XHRmaXJpbmcgPSBmYWxzZTtcblxuXHRcdFx0Ly8gQ2xlYW4gdXAgaWYgd2UncmUgZG9uZSBmaXJpbmcgZm9yIGdvb2Rcblx0XHRcdGlmICggbG9ja2VkICkge1xuXG5cdFx0XHRcdC8vIEtlZXAgYW4gZW1wdHkgbGlzdCBpZiB3ZSBoYXZlIGRhdGEgZm9yIGZ1dHVyZSBhZGQgY2FsbHNcblx0XHRcdFx0aWYgKCBtZW1vcnkgKSB7XG5cdFx0XHRcdFx0bGlzdCA9IFtdO1xuXG5cdFx0XHRcdC8vIE90aGVyd2lzZSwgdGhpcyBvYmplY3QgaXMgc3BlbnRcblx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHRsaXN0ID0gXCJcIjtcblx0XHRcdFx0fVxuXHRcdFx0fVxuXHRcdH0sXG5cblx0XHQvLyBBY3R1YWwgQ2FsbGJhY2tzIG9iamVjdFxuXHRcdHNlbGYgPSB7XG5cblx0XHRcdC8vIEFkZCBhIGNhbGxiYWNrIG9yIGEgY29sbGVjdGlvbiBvZiBjYWxsYmFja3MgdG8gdGhlIGxpc3Rcblx0XHRcdGFkZDogZnVuY3Rpb24oKSB7XG5cdFx0XHRcdGlmICggbGlzdCApIHtcblxuXHRcdFx0XHRcdC8vIElmIHdlIGhhdmUgbWVtb3J5IGZyb20gYSBwYXN0IHJ1biwgd2Ugc2hvdWxkIGZpcmUgYWZ0ZXIgYWRkaW5nXG5cdFx0XHRcdFx0aWYgKCBtZW1vcnkgJiYgIWZpcmluZyApIHtcblx0XHRcdFx0XHRcdGZpcmluZ0luZGV4ID0gbGlzdC5sZW5ndGggLSAxO1xuXHRcdFx0XHRcdFx0cXVldWUucHVzaCggbWVtb3J5ICk7XG5cdFx0XHRcdFx0fVxuXG5cdFx0XHRcdFx0KCBmdW5jdGlvbiBhZGQoIGFyZ3MgKSB7XG5cdFx0XHRcdFx0XHRqUXVlcnkuZWFjaCggYXJncywgZnVuY3Rpb24oIF8sIGFyZyApIHtcblx0XHRcdFx0XHRcdFx0aWYgKCB0eXBlb2YgYXJnID09PSBcImZ1bmN0aW9uXCIgKSB7XG5cdFx0XHRcdFx0XHRcdFx0aWYgKCAhb3B0aW9ucy51bmlxdWUgfHwgIXNlbGYuaGFzKCBhcmcgKSApIHtcblx0XHRcdFx0XHRcdFx0XHRcdGxpc3QucHVzaCggYXJnICk7XG5cdFx0XHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdFx0XHR9IGVsc2UgaWYgKCBhcmcgJiYgYXJnLmxlbmd0aCAmJiB0b1R5cGUoIGFyZyApICE9PSBcInN0cmluZ1wiICkge1xuXG5cdFx0XHRcdFx0XHRcdFx0Ly8gSW5zcGVjdCByZWN1cnNpdmVseVxuXHRcdFx0XHRcdFx0XHRcdGFkZCggYXJnICk7XG5cdFx0XHRcdFx0XHRcdH1cblx0XHRcdFx0XHRcdH0gKTtcblx0XHRcdFx0XHR9ICkoIGFyZ3VtZW50cyApO1xuXG5cdFx0XHRcdFx0aWYgKCBtZW1vcnkgJiYgIWZpcmluZyApIHtcblx0XHRcdFx0XHRcdGZpcmUoKTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH1cblx0XHRcdFx0cmV0dXJuIHRoaXM7XG5cdFx0XHR9LFxuXG5cdFx0XHQvLyBSZW1vdmUgYSBjYWxsYmFjayBmcm9tIHRoZSBsaXN0XG5cdFx0XHRyZW1vdmU6IGZ1bmN0aW9uKCkge1xuXHRcdFx0XHRqUXVlcnkuZWFjaCggYXJndW1lbnRzLCBmdW5jdGlvbiggXywgYXJnICkge1xuXHRcdFx0XHRcdHZhciBpbmRleDtcblx0XHRcdFx0XHR3aGlsZSAoICggaW5kZXggPSBqUXVlcnkuaW5BcnJheSggYXJnLCBsaXN0LCBpbmRleCApICkgPiAtMSApIHtcblx0XHRcdFx0XHRcdGxpc3Quc3BsaWNlKCBpbmRleCwgMSApO1xuXG5cdFx0XHRcdFx0XHQvLyBIYW5kbGUgZmlyaW5nIGluZGV4ZXNcblx0XHRcdFx0XHRcdGlmICggaW5kZXggPD0gZmlyaW5nSW5kZXggKSB7XG5cdFx0XHRcdFx0XHRcdGZpcmluZ0luZGV4LS07XG5cdFx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHR9ICk7XG5cdFx0XHRcdHJldHVybiB0aGlzO1xuXHRcdFx0fSxcblxuXHRcdFx0Ly8gQ2hlY2sgaWYgYSBnaXZlbiBjYWxsYmFjayBpcyBpbiB0aGUgbGlzdC5cblx0XHRcdC8vIElmIG5vIGFyZ3VtZW50IGlzIGdpdmVuLCByZXR1cm4gd2hldGhlciBvciBub3QgbGlzdCBoYXMgY2FsbGJhY2tzIGF0dGFjaGVkLlxuXHRcdFx0aGFzOiBmdW5jdGlvbiggZm4gKSB7XG5cdFx0XHRcdHJldHVybiBmbiA/XG5cdFx0XHRcdFx0alF1ZXJ5LmluQXJyYXkoIGZuLCBsaXN0ICkgPiAtMSA6XG5cdFx0XHRcdFx0bGlzdC5sZW5ndGggPiAwO1xuXHRcdFx0fSxcblxuXHRcdFx0Ly8gUmVtb3ZlIGFsbCBjYWxsYmFja3MgZnJvbSB0aGUgbGlzdFxuXHRcdFx0ZW1wdHk6IGZ1bmN0aW9uKCkge1xuXHRcdFx0XHRpZiAoIGxpc3QgKSB7XG5cdFx0XHRcdFx0bGlzdCA9IFtdO1xuXHRcdFx0XHR9XG5cdFx0XHRcdHJldHVybiB0aGlzO1xuXHRcdFx0fSxcblxuXHRcdFx0Ly8gRGlzYWJsZSAuZmlyZSBhbmQgLmFkZFxuXHRcdFx0Ly8gQWJvcnQgYW55IGN1cnJlbnQvcGVuZGluZyBleGVjdXRpb25zXG5cdFx0XHQvLyBDbGVhciBhbGwgY2FsbGJhY2tzIGFuZCB2YWx1ZXNcblx0XHRcdGRpc2FibGU6IGZ1bmN0aW9uKCkge1xuXHRcdFx0XHRsb2NrZWQgPSBxdWV1ZSA9IFtdO1xuXHRcdFx0XHRsaXN0ID0gbWVtb3J5ID0gXCJcIjtcblx0XHRcdFx0cmV0dXJuIHRoaXM7XG5cdFx0XHR9LFxuXHRcdFx0ZGlzYWJsZWQ6IGZ1bmN0aW9uKCkge1xuXHRcdFx0XHRyZXR1cm4gIWxpc3Q7XG5cdFx0XHR9LFxuXG5cdFx0XHQvLyBEaXNhYmxlIC5maXJlXG5cdFx0XHQvLyBBbHNvIGRpc2FibGUgLmFkZCB1bmxlc3Mgd2UgaGF2ZSBtZW1vcnkgKHNpbmNlIGl0IHdvdWxkIGhhdmUgbm8gZWZmZWN0KVxuXHRcdFx0Ly8gQWJvcnQgYW55IHBlbmRpbmcgZXhlY3V0aW9uc1xuXHRcdFx0bG9jazogZnVuY3Rpb24oKSB7XG5cdFx0XHRcdGxvY2tlZCA9IHF1ZXVlID0gW107XG5cdFx0XHRcdGlmICggIW1lbW9yeSAmJiAhZmlyaW5nICkge1xuXHRcdFx0XHRcdGxpc3QgPSBtZW1vcnkgPSBcIlwiO1xuXHRcdFx0XHR9XG5cdFx0XHRcdHJldHVybiB0aGlzO1xuXHRcdFx0fSxcblx0XHRcdGxvY2tlZDogZnVuY3Rpb24oKSB7XG5cdFx0XHRcdHJldHVybiAhIWxvY2tlZDtcblx0XHRcdH0sXG5cblx0XHRcdC8vIENhbGwgYWxsIGNhbGxiYWNrcyB3aXRoIHRoZSBnaXZlbiBjb250ZXh0IGFuZCBhcmd1bWVudHNcblx0XHRcdGZpcmVXaXRoOiBmdW5jdGlvbiggY29udGV4dCwgYXJncyApIHtcblx0XHRcdFx0aWYgKCAhbG9ja2VkICkge1xuXHRcdFx0XHRcdGFyZ3MgPSBhcmdzIHx8IFtdO1xuXHRcdFx0XHRcdGFyZ3MgPSBbIGNvbnRleHQsIGFyZ3Muc2xpY2UgPyBhcmdzLnNsaWNlKCkgOiBhcmdzIF07XG5cdFx0XHRcdFx0cXVldWUucHVzaCggYXJncyApO1xuXHRcdFx0XHRcdGlmICggIWZpcmluZyApIHtcblx0XHRcdFx0XHRcdGZpcmUoKTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH1cblx0XHRcdFx0cmV0dXJuIHRoaXM7XG5cdFx0XHR9LFxuXG5cdFx0XHQvLyBDYWxsIGFsbCB0aGUgY2FsbGJhY2tzIHdpdGggdGhlIGdpdmVuIGFyZ3VtZW50c1xuXHRcdFx0ZmlyZTogZnVuY3Rpb24oKSB7XG5cdFx0XHRcdHNlbGYuZmlyZVdpdGgoIHRoaXMsIGFyZ3VtZW50cyApO1xuXHRcdFx0XHRyZXR1cm4gdGhpcztcblx0XHRcdH0sXG5cblx0XHRcdC8vIFRvIGtub3cgaWYgdGhlIGNhbGxiYWNrcyBoYXZlIGFscmVhZHkgYmVlbiBjYWxsZWQgYXQgbGVhc3Qgb25jZVxuXHRcdFx0ZmlyZWQ6IGZ1bmN0aW9uKCkge1xuXHRcdFx0XHRyZXR1cm4gISFmaXJlZDtcblx0XHRcdH1cblx0XHR9O1xuXG5cdHJldHVybiBzZWxmO1xufTtcblxuZnVuY3Rpb24gSWRlbnRpdHkoIHYgKSB7XG5cdHJldHVybiB2O1xufVxuZnVuY3Rpb24gVGhyb3dlciggZXggKSB7XG5cdHRocm93IGV4O1xufVxuXG5mdW5jdGlvbiBhZG9wdFZhbHVlKCB2YWx1ZSwgcmVzb2x2ZSwgcmVqZWN0LCBub1ZhbHVlICkge1xuXHR2YXIgbWV0aG9kO1xuXG5cdHRyeSB7XG5cblx0XHQvLyBDaGVjayBmb3IgcHJvbWlzZSBhc3BlY3QgZmlyc3QgdG8gcHJpdmlsZWdlIHN5bmNocm9ub3VzIGJlaGF2aW9yXG5cdFx0aWYgKCB2YWx1ZSAmJiB0eXBlb2YoIG1ldGhvZCA9IHZhbHVlLnByb21pc2UgKSA9PT0gXCJmdW5jdGlvblwiICkge1xuXHRcdFx0bWV0aG9kLmNhbGwoIHZhbHVlICkuZG9uZSggcmVzb2x2ZSApLmZhaWwoIHJlamVjdCApO1xuXG5cdFx0Ly8gT3RoZXIgdGhlbmFibGVzXG5cdFx0fSBlbHNlIGlmICggdmFsdWUgJiYgdHlwZW9mKCBtZXRob2QgPSB2YWx1ZS50aGVuICkgPT09IFwiZnVuY3Rpb25cIiApIHtcblx0XHRcdG1ldGhvZC5jYWxsKCB2YWx1ZSwgcmVzb2x2ZSwgcmVqZWN0ICk7XG5cblx0XHQvLyBPdGhlciBub24tdGhlbmFibGVzXG5cdFx0fSBlbHNlIHtcblxuXHRcdFx0Ly8gQ29udHJvbCBgcmVzb2x2ZWAgYXJndW1lbnRzIGJ5IGxldHRpbmcgQXJyYXkjc2xpY2UgY2FzdCBib29sZWFuIGBub1ZhbHVlYCB0byBpbnRlZ2VyOlxuXHRcdFx0Ly8gKiBmYWxzZTogWyB2YWx1ZSBdLnNsaWNlKCAwICkgPT4gcmVzb2x2ZSggdmFsdWUgKVxuXHRcdFx0Ly8gKiB0cnVlOiBbIHZhbHVlIF0uc2xpY2UoIDEgKSA9PiByZXNvbHZlKClcblx0XHRcdHJlc29sdmUuYXBwbHkoIHVuZGVmaW5lZCwgWyB2YWx1ZSBdLnNsaWNlKCBub1ZhbHVlICkgKTtcblx0XHR9XG5cblx0Ly8gRm9yIFByb21pc2VzL0ErLCBjb252ZXJ0IGV4Y2VwdGlvbnMgaW50byByZWplY3Rpb25zXG5cdC8vIFNpbmNlIGpRdWVyeS53aGVuIGRvZXNuJ3QgdW53cmFwIHRoZW5hYmxlcywgd2UgY2FuIHNraXAgdGhlIGV4dHJhIGNoZWNrcyBhcHBlYXJpbmcgaW5cblx0Ly8gRGVmZXJyZWQjdGhlbiB0byBjb25kaXRpb25hbGx5IHN1cHByZXNzIHJlamVjdGlvbi5cblx0fSBjYXRjaCAoIHZhbHVlICkge1xuXHRcdHJlamVjdCggdmFsdWUgKTtcblx0fVxufVxuXG5qUXVlcnkuZXh0ZW5kKCB7XG5cblx0RGVmZXJyZWQ6IGZ1bmN0aW9uKCBmdW5jICkge1xuXHRcdHZhciB0dXBsZXMgPSBbXG5cblx0XHRcdFx0Ly8gYWN0aW9uLCBhZGQgbGlzdGVuZXIsIGNhbGxiYWNrcyxcblx0XHRcdFx0Ly8gLi4uIC50aGVuIGhhbmRsZXJzLCBhcmd1bWVudCBpbmRleCwgW2ZpbmFsIHN0YXRlXVxuXHRcdFx0XHRbIFwibm90aWZ5XCIsIFwicHJvZ3Jlc3NcIiwgalF1ZXJ5LkNhbGxiYWNrcyggXCJtZW1vcnlcIiApLFxuXHRcdFx0XHRcdGpRdWVyeS5DYWxsYmFja3MoIFwibWVtb3J5XCIgKSwgMiBdLFxuXHRcdFx0XHRbIFwicmVzb2x2ZVwiLCBcImRvbmVcIiwgalF1ZXJ5LkNhbGxiYWNrcyggXCJvbmNlIG1lbW9yeVwiICksXG5cdFx0XHRcdFx0alF1ZXJ5LkNhbGxiYWNrcyggXCJvbmNlIG1lbW9yeVwiICksIDAsIFwicmVzb2x2ZWRcIiBdLFxuXHRcdFx0XHRbIFwicmVqZWN0XCIsIFwiZmFpbFwiLCBqUXVlcnkuQ2FsbGJhY2tzKCBcIm9uY2UgbWVtb3J5XCIgKSxcblx0XHRcdFx0XHRqUXVlcnkuQ2FsbGJhY2tzKCBcIm9uY2UgbWVtb3J5XCIgKSwgMSwgXCJyZWplY3RlZFwiIF1cblx0XHRcdF0sXG5cdFx0XHRzdGF0ZSA9IFwicGVuZGluZ1wiLFxuXHRcdFx0cHJvbWlzZSA9IHtcblx0XHRcdFx0c3RhdGU6IGZ1bmN0aW9uKCkge1xuXHRcdFx0XHRcdHJldHVybiBzdGF0ZTtcblx0XHRcdFx0fSxcblx0XHRcdFx0YWx3YXlzOiBmdW5jdGlvbigpIHtcblx0XHRcdFx0XHRkZWZlcnJlZC5kb25lKCBhcmd1bWVudHMgKS5mYWlsKCBhcmd1bWVudHMgKTtcblx0XHRcdFx0XHRyZXR1cm4gdGhpcztcblx0XHRcdFx0fSxcblx0XHRcdFx0Y2F0Y2g6IGZ1bmN0aW9uKCBmbiApIHtcblx0XHRcdFx0XHRyZXR1cm4gcHJvbWlzZS50aGVuKCBudWxsLCBmbiApO1xuXHRcdFx0XHR9LFxuXG5cdFx0XHRcdC8vIEtlZXAgcGlwZSBmb3IgYmFjay1jb21wYXRcblx0XHRcdFx0cGlwZTogZnVuY3Rpb24oIC8qIGZuRG9uZSwgZm5GYWlsLCBmblByb2dyZXNzICovICkge1xuXHRcdFx0XHRcdHZhciBmbnMgPSBhcmd1bWVudHM7XG5cblx0XHRcdFx0XHRyZXR1cm4galF1ZXJ5LkRlZmVycmVkKCBmdW5jdGlvbiggbmV3RGVmZXIgKSB7XG5cdFx0XHRcdFx0XHRqUXVlcnkuZWFjaCggdHVwbGVzLCBmdW5jdGlvbiggX2ksIHR1cGxlICkge1xuXG5cdFx0XHRcdFx0XHRcdC8vIE1hcCB0dXBsZXMgKHByb2dyZXNzLCBkb25lLCBmYWlsKSB0byBhcmd1bWVudHMgKGRvbmUsIGZhaWwsIHByb2dyZXNzKVxuXHRcdFx0XHRcdFx0XHR2YXIgZm4gPSB0eXBlb2YgZm5zWyB0dXBsZVsgNCBdIF0gPT09IFwiZnVuY3Rpb25cIiAmJlxuXHRcdFx0XHRcdFx0XHRcdGZuc1sgdHVwbGVbIDQgXSBdO1xuXG5cdFx0XHRcdFx0XHRcdC8vIGRlZmVycmVkLnByb2dyZXNzKGZ1bmN0aW9uKCkgeyBiaW5kIHRvIG5ld0RlZmVyIG9yIG5ld0RlZmVyLm5vdGlmeSB9KVxuXHRcdFx0XHRcdFx0XHQvLyBkZWZlcnJlZC5kb25lKGZ1bmN0aW9uKCkgeyBiaW5kIHRvIG5ld0RlZmVyIG9yIG5ld0RlZmVyLnJlc29sdmUgfSlcblx0XHRcdFx0XHRcdFx0Ly8gZGVmZXJyZWQuZmFpbChmdW5jdGlvbigpIHsgYmluZCB0byBuZXdEZWZlciBvciBuZXdEZWZlci5yZWplY3QgfSlcblx0XHRcdFx0XHRcdFx0ZGVmZXJyZWRbIHR1cGxlWyAxIF0gXSggZnVuY3Rpb24oKSB7XG5cdFx0XHRcdFx0XHRcdFx0dmFyIHJldHVybmVkID0gZm4gJiYgZm4uYXBwbHkoIHRoaXMsIGFyZ3VtZW50cyApO1xuXHRcdFx0XHRcdFx0XHRcdGlmICggcmV0dXJuZWQgJiYgdHlwZW9mIHJldHVybmVkLnByb21pc2UgPT09IFwiZnVuY3Rpb25cIiApIHtcblx0XHRcdFx0XHRcdFx0XHRcdHJldHVybmVkLnByb21pc2UoKVxuXHRcdFx0XHRcdFx0XHRcdFx0XHQucHJvZ3Jlc3MoIG5ld0RlZmVyLm5vdGlmeSApXG5cdFx0XHRcdFx0XHRcdFx0XHRcdC5kb25lKCBuZXdEZWZlci5yZXNvbHZlIClcblx0XHRcdFx0XHRcdFx0XHRcdFx0LmZhaWwoIG5ld0RlZmVyLnJlamVjdCApO1xuXHRcdFx0XHRcdFx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdFx0XHRcdFx0XHRuZXdEZWZlclsgdHVwbGVbIDAgXSArIFwiV2l0aFwiIF0oXG5cdFx0XHRcdFx0XHRcdFx0XHRcdHRoaXMsXG5cdFx0XHRcdFx0XHRcdFx0XHRcdGZuID8gWyByZXR1cm5lZCBdIDogYXJndW1lbnRzXG5cdFx0XHRcdFx0XHRcdFx0XHQpO1xuXHRcdFx0XHRcdFx0XHRcdH1cblx0XHRcdFx0XHRcdFx0fSApO1xuXHRcdFx0XHRcdFx0fSApO1xuXHRcdFx0XHRcdFx0Zm5zID0gbnVsbDtcblx0XHRcdFx0XHR9ICkucHJvbWlzZSgpO1xuXHRcdFx0XHR9LFxuXHRcdFx0XHR0aGVuOiBmdW5jdGlvbiggb25GdWxmaWxsZWQsIG9uUmVqZWN0ZWQsIG9uUHJvZ3Jlc3MgKSB7XG5cdFx0XHRcdFx0dmFyIG1heERlcHRoID0gMDtcblx0XHRcdFx0XHRmdW5jdGlvbiByZXNvbHZlKCBkZXB0aCwgZGVmZXJyZWQsIGhhbmRsZXIsIHNwZWNpYWwgKSB7XG5cdFx0XHRcdFx0XHRyZXR1cm4gZnVuY3Rpb24oKSB7XG5cdFx0XHRcdFx0XHRcdHZhciB0aGF0ID0gdGhpcyxcblx0XHRcdFx0XHRcdFx0XHRhcmdzID0gYXJndW1lbnRzLFxuXHRcdFx0XHRcdFx0XHRcdG1pZ2h0VGhyb3cgPSBmdW5jdGlvbigpIHtcblx0XHRcdFx0XHRcdFx0XHRcdHZhciByZXR1cm5lZCwgdGhlbjtcblxuXHRcdFx0XHRcdFx0XHRcdFx0Ly8gU3VwcG9ydDogUHJvbWlzZXMvQSsgc2VjdGlvbiAyLjMuMy4zLjNcblx0XHRcdFx0XHRcdFx0XHRcdC8vIGh0dHBzOi8vcHJvbWlzZXNhcGx1cy5jb20vI3BvaW50LTU5XG5cdFx0XHRcdFx0XHRcdFx0XHQvLyBJZ25vcmUgZG91YmxlLXJlc29sdXRpb24gYXR0ZW1wdHNcblx0XHRcdFx0XHRcdFx0XHRcdGlmICggZGVwdGggPCBtYXhEZXB0aCApIHtcblx0XHRcdFx0XHRcdFx0XHRcdFx0cmV0dXJuO1xuXHRcdFx0XHRcdFx0XHRcdFx0fVxuXG5cdFx0XHRcdFx0XHRcdFx0XHRyZXR1cm5lZCA9IGhhbmRsZXIuYXBwbHkoIHRoYXQsIGFyZ3MgKTtcblxuXHRcdFx0XHRcdFx0XHRcdFx0Ly8gU3VwcG9ydDogUHJvbWlzZXMvQSsgc2VjdGlvbiAyLjMuMVxuXHRcdFx0XHRcdFx0XHRcdFx0Ly8gaHR0cHM6Ly9wcm9taXNlc2FwbHVzLmNvbS8jcG9pbnQtNDhcblx0XHRcdFx0XHRcdFx0XHRcdGlmICggcmV0dXJuZWQgPT09IGRlZmVycmVkLnByb21pc2UoKSApIHtcblx0XHRcdFx0XHRcdFx0XHRcdFx0dGhyb3cgbmV3IFR5cGVFcnJvciggXCJUaGVuYWJsZSBzZWxmLXJlc29sdXRpb25cIiApO1xuXHRcdFx0XHRcdFx0XHRcdFx0fVxuXG5cdFx0XHRcdFx0XHRcdFx0XHQvLyBTdXBwb3J0OiBQcm9taXNlcy9BKyBzZWN0aW9ucyAyLjMuMy4xLCAzLjVcblx0XHRcdFx0XHRcdFx0XHRcdC8vIGh0dHBzOi8vcHJvbWlzZXNhcGx1cy5jb20vI3BvaW50LTU0XG5cdFx0XHRcdFx0XHRcdFx0XHQvLyBodHRwczovL3Byb21pc2VzYXBsdXMuY29tLyNwb2ludC03NVxuXHRcdFx0XHRcdFx0XHRcdFx0Ly8gUmV0cmlldmUgYHRoZW5gIG9ubHkgb25jZVxuXHRcdFx0XHRcdFx0XHRcdFx0dGhlbiA9IHJldHVybmVkICYmXG5cblx0XHRcdFx0XHRcdFx0XHRcdFx0Ly8gU3VwcG9ydDogUHJvbWlzZXMvQSsgc2VjdGlvbiAyLjMuNFxuXHRcdFx0XHRcdFx0XHRcdFx0XHQvLyBodHRwczovL3Byb21pc2VzYXBsdXMuY29tLyNwb2ludC02NFxuXHRcdFx0XHRcdFx0XHRcdFx0XHQvLyBPbmx5IGNoZWNrIG9iamVjdHMgYW5kIGZ1bmN0aW9ucyBmb3IgdGhlbmFiaWxpdHlcblx0XHRcdFx0XHRcdFx0XHRcdFx0KCB0eXBlb2YgcmV0dXJuZWQgPT09IFwib2JqZWN0XCIgfHxcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHR0eXBlb2YgcmV0dXJuZWQgPT09IFwiZnVuY3Rpb25cIiApICYmXG5cdFx0XHRcdFx0XHRcdFx0XHRcdHJldHVybmVkLnRoZW47XG5cblx0XHRcdFx0XHRcdFx0XHRcdC8vIEhhbmRsZSBhIHJldHVybmVkIHRoZW5hYmxlXG5cdFx0XHRcdFx0XHRcdFx0XHRpZiAoIHR5cGVvZiB0aGVuID09PSBcImZ1bmN0aW9uXCIgKSB7XG5cblx0XHRcdFx0XHRcdFx0XHRcdFx0Ly8gU3BlY2lhbCBwcm9jZXNzb3JzIChub3RpZnkpIGp1c3Qgd2FpdCBmb3IgcmVzb2x1dGlvblxuXHRcdFx0XHRcdFx0XHRcdFx0XHRpZiAoIHNwZWNpYWwgKSB7XG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0dGhlbi5jYWxsKFxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0cmV0dXJuZWQsXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRyZXNvbHZlKCBtYXhEZXB0aCwgZGVmZXJyZWQsIElkZW50aXR5LCBzcGVjaWFsICksXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRyZXNvbHZlKCBtYXhEZXB0aCwgZGVmZXJyZWQsIFRocm93ZXIsIHNwZWNpYWwgKVxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdCk7XG5cblx0XHRcdFx0XHRcdFx0XHRcdFx0Ly8gTm9ybWFsIHByb2Nlc3NvcnMgKHJlc29sdmUpIGFsc28gaG9vayBpbnRvIHByb2dyZXNzXG5cdFx0XHRcdFx0XHRcdFx0XHRcdH0gZWxzZSB7XG5cblx0XHRcdFx0XHRcdFx0XHRcdFx0XHQvLyAuLi5hbmQgZGlzcmVnYXJkIG9sZGVyIHJlc29sdXRpb24gdmFsdWVzXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0bWF4RGVwdGgrKztcblxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdHRoZW4uY2FsbChcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdHJldHVybmVkLFxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0cmVzb2x2ZSggbWF4RGVwdGgsIGRlZmVycmVkLCBJZGVudGl0eSwgc3BlY2lhbCApLFxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0cmVzb2x2ZSggbWF4RGVwdGgsIGRlZmVycmVkLCBUaHJvd2VyLCBzcGVjaWFsICksXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRyZXNvbHZlKCBtYXhEZXB0aCwgZGVmZXJyZWQsIElkZW50aXR5LFxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRkZWZlcnJlZC5ub3RpZnlXaXRoIClcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHQpO1xuXHRcdFx0XHRcdFx0XHRcdFx0XHR9XG5cblx0XHRcdFx0XHRcdFx0XHRcdC8vIEhhbmRsZSBhbGwgb3RoZXIgcmV0dXJuZWQgdmFsdWVzXG5cdFx0XHRcdFx0XHRcdFx0XHR9IGVsc2Uge1xuXG5cdFx0XHRcdFx0XHRcdFx0XHRcdC8vIE9ubHkgc3Vic3RpdHV0ZSBoYW5kbGVycyBwYXNzIG9uIGNvbnRleHRcblx0XHRcdFx0XHRcdFx0XHRcdFx0Ly8gYW5kIG11bHRpcGxlIHZhbHVlcyAobm9uLXNwZWMgYmVoYXZpb3IpXG5cdFx0XHRcdFx0XHRcdFx0XHRcdGlmICggaGFuZGxlciAhPT0gSWRlbnRpdHkgKSB7XG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0dGhhdCA9IHVuZGVmaW5lZDtcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRhcmdzID0gWyByZXR1cm5lZCBdO1xuXHRcdFx0XHRcdFx0XHRcdFx0XHR9XG5cblx0XHRcdFx0XHRcdFx0XHRcdFx0Ly8gUHJvY2VzcyB0aGUgdmFsdWUocylcblx0XHRcdFx0XHRcdFx0XHRcdFx0Ly8gRGVmYXVsdCBwcm9jZXNzIGlzIHJlc29sdmVcblx0XHRcdFx0XHRcdFx0XHRcdFx0KCBzcGVjaWFsIHx8IGRlZmVycmVkLnJlc29sdmVXaXRoICkoIHRoYXQsIGFyZ3MgKTtcblx0XHRcdFx0XHRcdFx0XHRcdH1cblx0XHRcdFx0XHRcdFx0XHR9LFxuXG5cdFx0XHRcdFx0XHRcdFx0Ly8gT25seSBub3JtYWwgcHJvY2Vzc29ycyAocmVzb2x2ZSkgY2F0Y2ggYW5kIHJlamVjdCBleGNlcHRpb25zXG5cdFx0XHRcdFx0XHRcdFx0cHJvY2VzcyA9IHNwZWNpYWwgP1xuXHRcdFx0XHRcdFx0XHRcdFx0bWlnaHRUaHJvdyA6XG5cdFx0XHRcdFx0XHRcdFx0XHRmdW5jdGlvbigpIHtcblx0XHRcdFx0XHRcdFx0XHRcdFx0dHJ5IHtcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRtaWdodFRocm93KCk7XG5cdFx0XHRcdFx0XHRcdFx0XHRcdH0gY2F0Y2ggKCBlICkge1xuXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0aWYgKCBqUXVlcnkuRGVmZXJyZWQuZXhjZXB0aW9uSG9vayApIHtcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdGpRdWVyeS5EZWZlcnJlZC5leGNlcHRpb25Ib29rKCBlLFxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRwcm9jZXNzLmVycm9yICk7XG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0fVxuXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0Ly8gU3VwcG9ydDogUHJvbWlzZXMvQSsgc2VjdGlvbiAyLjMuMy4zLjQuMVxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdC8vIGh0dHBzOi8vcHJvbWlzZXNhcGx1cy5jb20vI3BvaW50LTYxXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0Ly8gSWdub3JlIHBvc3QtcmVzb2x1dGlvbiBleGNlcHRpb25zXG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0aWYgKCBkZXB0aCArIDEgPj0gbWF4RGVwdGggKSB7XG5cblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdC8vIE9ubHkgc3Vic3RpdHV0ZSBoYW5kbGVycyBwYXNzIG9uIGNvbnRleHRcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdC8vIGFuZCBtdWx0aXBsZSB2YWx1ZXMgKG5vbi1zcGVjIGJlaGF2aW9yKVxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0aWYgKCBoYW5kbGVyICE9PSBUaHJvd2VyICkge1xuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHR0aGF0ID0gdW5kZWZpbmVkO1xuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRhcmdzID0gWyBlIF07XG5cdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHR9XG5cblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdGRlZmVycmVkLnJlamVjdFdpdGgoIHRoYXQsIGFyZ3MgKTtcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0XHRcdFx0XHRcdH1cblx0XHRcdFx0XHRcdFx0XHRcdH07XG5cblx0XHRcdFx0XHRcdFx0Ly8gU3VwcG9ydDogUHJvbWlzZXMvQSsgc2VjdGlvbiAyLjMuMy4zLjFcblx0XHRcdFx0XHRcdFx0Ly8gaHR0cHM6Ly9wcm9taXNlc2FwbHVzLmNvbS8jcG9pbnQtNTdcblx0XHRcdFx0XHRcdFx0Ly8gUmUtcmVzb2x2ZSBwcm9taXNlcyBpbW1lZGlhdGVseSB0byBkb2RnZSBmYWxzZSByZWplY3Rpb24gZnJvbVxuXHRcdFx0XHRcdFx0XHQvLyBzdWJzZXF1ZW50IGVycm9yc1xuXHRcdFx0XHRcdFx0XHRpZiAoIGRlcHRoICkge1xuXHRcdFx0XHRcdFx0XHRcdHByb2Nlc3MoKTtcblx0XHRcdFx0XHRcdFx0fSBlbHNlIHtcblxuXHRcdFx0XHRcdFx0XHRcdC8vIENhbGwgYW4gb3B0aW9uYWwgaG9vayB0byByZWNvcmQgdGhlIGVycm9yLCBpbiBjYXNlIG9mIGV4Y2VwdGlvblxuXHRcdFx0XHRcdFx0XHRcdC8vIHNpbmNlIGl0J3Mgb3RoZXJ3aXNlIGxvc3Qgd2hlbiBleGVjdXRpb24gZ29lcyBhc3luY1xuXHRcdFx0XHRcdFx0XHRcdGlmICggalF1ZXJ5LkRlZmVycmVkLmdldEVycm9ySG9vayApIHtcblx0XHRcdFx0XHRcdFx0XHRcdHByb2Nlc3MuZXJyb3IgPSBqUXVlcnkuRGVmZXJyZWQuZ2V0RXJyb3JIb29rKCk7XG5cdFx0XHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdFx0XHRcdHdpbmRvdy5zZXRUaW1lb3V0KCBwcm9jZXNzICk7XG5cdFx0XHRcdFx0XHRcdH1cblx0XHRcdFx0XHRcdH07XG5cdFx0XHRcdFx0fVxuXG5cdFx0XHRcdFx0cmV0dXJuIGpRdWVyeS5EZWZlcnJlZCggZnVuY3Rpb24oIG5ld0RlZmVyICkge1xuXG5cdFx0XHRcdFx0XHQvLyBwcm9ncmVzc19oYW5kbGVycy5hZGQoIC4uLiApXG5cdFx0XHRcdFx0XHR0dXBsZXNbIDAgXVsgMyBdLmFkZChcblx0XHRcdFx0XHRcdFx0cmVzb2x2ZShcblx0XHRcdFx0XHRcdFx0XHQwLFxuXHRcdFx0XHRcdFx0XHRcdG5ld0RlZmVyLFxuXHRcdFx0XHRcdFx0XHRcdHR5cGVvZiBvblByb2dyZXNzID09PSBcImZ1bmN0aW9uXCIgP1xuXHRcdFx0XHRcdFx0XHRcdFx0b25Qcm9ncmVzcyA6XG5cdFx0XHRcdFx0XHRcdFx0XHRJZGVudGl0eSxcblx0XHRcdFx0XHRcdFx0XHRuZXdEZWZlci5ub3RpZnlXaXRoXG5cdFx0XHRcdFx0XHRcdClcblx0XHRcdFx0XHRcdCk7XG5cblx0XHRcdFx0XHRcdC8vIGZ1bGZpbGxlZF9oYW5kbGVycy5hZGQoIC4uLiApXG5cdFx0XHRcdFx0XHR0dXBsZXNbIDEgXVsgMyBdLmFkZChcblx0XHRcdFx0XHRcdFx0cmVzb2x2ZShcblx0XHRcdFx0XHRcdFx0XHQwLFxuXHRcdFx0XHRcdFx0XHRcdG5ld0RlZmVyLFxuXHRcdFx0XHRcdFx0XHRcdHR5cGVvZiBvbkZ1bGZpbGxlZCA9PT0gXCJmdW5jdGlvblwiID9cblx0XHRcdFx0XHRcdFx0XHRcdG9uRnVsZmlsbGVkIDpcblx0XHRcdFx0XHRcdFx0XHRcdElkZW50aXR5XG5cdFx0XHRcdFx0XHRcdClcblx0XHRcdFx0XHRcdCk7XG5cblx0XHRcdFx0XHRcdC8vIHJlamVjdGVkX2hhbmRsZXJzLmFkZCggLi4uIClcblx0XHRcdFx0XHRcdHR1cGxlc1sgMiBdWyAzIF0uYWRkKFxuXHRcdFx0XHRcdFx0XHRyZXNvbHZlKFxuXHRcdFx0XHRcdFx0XHRcdDAsXG5cdFx0XHRcdFx0XHRcdFx0bmV3RGVmZXIsXG5cdFx0XHRcdFx0XHRcdFx0dHlwZW9mIG9uUmVqZWN0ZWQgPT09IFwiZnVuY3Rpb25cIiA/XG5cdFx0XHRcdFx0XHRcdFx0XHRvblJlamVjdGVkIDpcblx0XHRcdFx0XHRcdFx0XHRcdFRocm93ZXJcblx0XHRcdFx0XHRcdFx0KVxuXHRcdFx0XHRcdFx0KTtcblx0XHRcdFx0XHR9ICkucHJvbWlzZSgpO1xuXHRcdFx0XHR9LFxuXG5cdFx0XHRcdC8vIEdldCBhIHByb21pc2UgZm9yIHRoaXMgZGVmZXJyZWRcblx0XHRcdFx0Ly8gSWYgb2JqIGlzIHByb3ZpZGVkLCB0aGUgcHJvbWlzZSBhc3BlY3QgaXMgYWRkZWQgdG8gdGhlIG9iamVjdFxuXHRcdFx0XHRwcm9taXNlOiBmdW5jdGlvbiggb2JqICkge1xuXHRcdFx0XHRcdHJldHVybiBvYmogIT0gbnVsbCA/IGpRdWVyeS5leHRlbmQoIG9iaiwgcHJvbWlzZSApIDogcHJvbWlzZTtcblx0XHRcdFx0fVxuXHRcdFx0fSxcblx0XHRcdGRlZmVycmVkID0ge307XG5cblx0XHQvLyBBZGQgbGlzdC1zcGVjaWZpYyBtZXRob2RzXG5cdFx0alF1ZXJ5LmVhY2goIHR1cGxlcywgZnVuY3Rpb24oIGksIHR1cGxlICkge1xuXHRcdFx0dmFyIGxpc3QgPSB0dXBsZVsgMiBdLFxuXHRcdFx0XHRzdGF0ZVN0cmluZyA9IHR1cGxlWyA1IF07XG5cblx0XHRcdC8vIHByb21pc2UucHJvZ3Jlc3MgPSBsaXN0LmFkZFxuXHRcdFx0Ly8gcHJvbWlzZS5kb25lID0gbGlzdC5hZGRcblx0XHRcdC8vIHByb21pc2UuZmFpbCA9IGxpc3QuYWRkXG5cdFx0XHRwcm9taXNlWyB0dXBsZVsgMSBdIF0gPSBsaXN0LmFkZDtcblxuXHRcdFx0Ly8gSGFuZGxlIHN0YXRlXG5cdFx0XHRpZiAoIHN0YXRlU3RyaW5nICkge1xuXHRcdFx0XHRsaXN0LmFkZChcblx0XHRcdFx0XHRmdW5jdGlvbigpIHtcblxuXHRcdFx0XHRcdFx0Ly8gc3RhdGUgPSBcInJlc29sdmVkXCIgKGkuZS4sIGZ1bGZpbGxlZClcblx0XHRcdFx0XHRcdC8vIHN0YXRlID0gXCJyZWplY3RlZFwiXG5cdFx0XHRcdFx0XHRzdGF0ZSA9IHN0YXRlU3RyaW5nO1xuXHRcdFx0XHRcdH0sXG5cblx0XHRcdFx0XHQvLyByZWplY3RlZF9jYWxsYmFja3MuZGlzYWJsZVxuXHRcdFx0XHRcdC8vIGZ1bGZpbGxlZF9jYWxsYmFja3MuZGlzYWJsZVxuXHRcdFx0XHRcdHR1cGxlc1sgMyAtIGkgXVsgMiBdLmRpc2FibGUsXG5cblx0XHRcdFx0XHQvLyByZWplY3RlZF9oYW5kbGVycy5kaXNhYmxlXG5cdFx0XHRcdFx0Ly8gZnVsZmlsbGVkX2hhbmRsZXJzLmRpc2FibGVcblx0XHRcdFx0XHR0dXBsZXNbIDMgLSBpIF1bIDMgXS5kaXNhYmxlLFxuXG5cdFx0XHRcdFx0Ly8gcHJvZ3Jlc3NfY2FsbGJhY2tzLmxvY2tcblx0XHRcdFx0XHR0dXBsZXNbIDAgXVsgMiBdLmxvY2ssXG5cblx0XHRcdFx0XHQvLyBwcm9ncmVzc19oYW5kbGVycy5sb2NrXG5cdFx0XHRcdFx0dHVwbGVzWyAwIF1bIDMgXS5sb2NrXG5cdFx0XHRcdCk7XG5cdFx0XHR9XG5cblx0XHRcdC8vIHByb2dyZXNzX2hhbmRsZXJzLmZpcmVcblx0XHRcdC8vIGZ1bGZpbGxlZF9oYW5kbGVycy5maXJlXG5cdFx0XHQvLyByZWplY3RlZF9oYW5kbGVycy5maXJlXG5cdFx0XHRsaXN0LmFkZCggdHVwbGVbIDMgXS5maXJlICk7XG5cblx0XHRcdC8vIGRlZmVycmVkLm5vdGlmeSA9IGZ1bmN0aW9uKCkgeyBkZWZlcnJlZC5ub3RpZnlXaXRoKC4uLikgfVxuXHRcdFx0Ly8gZGVmZXJyZWQucmVzb2x2ZSA9IGZ1bmN0aW9uKCkgeyBkZWZlcnJlZC5yZXNvbHZlV2l0aCguLi4pIH1cblx0XHRcdC8vIGRlZmVycmVkLnJlamVjdCA9IGZ1bmN0aW9uKCkgeyBkZWZlcnJlZC5yZWplY3RXaXRoKC4uLikgfVxuXHRcdFx0ZGVmZXJyZWRbIHR1cGxlWyAwIF0gXSA9IGZ1bmN0aW9uKCkge1xuXHRcdFx0XHRkZWZlcnJlZFsgdHVwbGVbIDAgXSArIFwiV2l0aFwiIF0oIHRoaXMgPT09IGRlZmVycmVkID8gdW5kZWZpbmVkIDogdGhpcywgYXJndW1lbnRzICk7XG5cdFx0XHRcdHJldHVybiB0aGlzO1xuXHRcdFx0fTtcblxuXHRcdFx0Ly8gZGVmZXJyZWQubm90aWZ5V2l0aCA9IGxpc3QuZmlyZVdpdGhcblx0XHRcdC8vIGRlZmVycmVkLnJlc29sdmVXaXRoID0gbGlzdC5maXJlV2l0aFxuXHRcdFx0Ly8gZGVmZXJyZWQucmVqZWN0V2l0aCA9IGxpc3QuZmlyZVdpdGhcblx0XHRcdGRlZmVycmVkWyB0dXBsZVsgMCBdICsgXCJXaXRoXCIgXSA9IGxpc3QuZmlyZVdpdGg7XG5cdFx0fSApO1xuXG5cdFx0Ly8gTWFrZSB0aGUgZGVmZXJyZWQgYSBwcm9taXNlXG5cdFx0cHJvbWlzZS5wcm9taXNlKCBkZWZlcnJlZCApO1xuXG5cdFx0Ly8gQ2FsbCBnaXZlbiBmdW5jIGlmIGFueVxuXHRcdGlmICggZnVuYyApIHtcblx0XHRcdGZ1bmMuY2FsbCggZGVmZXJyZWQsIGRlZmVycmVkICk7XG5cdFx0fVxuXG5cdFx0Ly8gQWxsIGRvbmUhXG5cdFx0cmV0dXJuIGRlZmVycmVkO1xuXHR9LFxuXG5cdC8vIERlZmVycmVkIGhlbHBlclxuXHR3aGVuOiBmdW5jdGlvbiggc2luZ2xlVmFsdWUgKSB7XG5cdFx0dmFyXG5cblx0XHRcdC8vIGNvdW50IG9mIHVuY29tcGxldGVkIHN1Ym9yZGluYXRlc1xuXHRcdFx0cmVtYWluaW5nID0gYXJndW1lbnRzLmxlbmd0aCxcblxuXHRcdFx0Ly8gY291bnQgb2YgdW5wcm9jZXNzZWQgYXJndW1lbnRzXG5cdFx0XHRpID0gcmVtYWluaW5nLFxuXG5cdFx0XHQvLyBzdWJvcmRpbmF0ZSBmdWxmaWxsbWVudCBkYXRhXG5cdFx0XHRyZXNvbHZlQ29udGV4dHMgPSBBcnJheSggaSApLFxuXHRcdFx0cmVzb2x2ZVZhbHVlcyA9IHNsaWNlLmNhbGwoIGFyZ3VtZW50cyApLFxuXG5cdFx0XHQvLyB0aGUgcHJpbWFyeSBEZWZlcnJlZFxuXHRcdFx0cHJpbWFyeSA9IGpRdWVyeS5EZWZlcnJlZCgpLFxuXG5cdFx0XHQvLyBzdWJvcmRpbmF0ZSBjYWxsYmFjayBmYWN0b3J5XG5cdFx0XHR1cGRhdGVGdW5jID0gZnVuY3Rpb24oIGkgKSB7XG5cdFx0XHRcdHJldHVybiBmdW5jdGlvbiggdmFsdWUgKSB7XG5cdFx0XHRcdFx0cmVzb2x2ZUNvbnRleHRzWyBpIF0gPSB0aGlzO1xuXHRcdFx0XHRcdHJlc29sdmVWYWx1ZXNbIGkgXSA9IGFyZ3VtZW50cy5sZW5ndGggPiAxID8gc2xpY2UuY2FsbCggYXJndW1lbnRzICkgOiB2YWx1ZTtcblx0XHRcdFx0XHRpZiAoICEoIC0tcmVtYWluaW5nICkgKSB7XG5cdFx0XHRcdFx0XHRwcmltYXJ5LnJlc29sdmVXaXRoKCByZXNvbHZlQ29udGV4dHMsIHJlc29sdmVWYWx1ZXMgKTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH07XG5cdFx0XHR9O1xuXG5cdFx0Ly8gU2luZ2xlLSBhbmQgZW1wdHkgYXJndW1lbnRzIGFyZSBhZG9wdGVkIGxpa2UgUHJvbWlzZS5yZXNvbHZlXG5cdFx0aWYgKCByZW1haW5pbmcgPD0gMSApIHtcblx0XHRcdGFkb3B0VmFsdWUoIHNpbmdsZVZhbHVlLCBwcmltYXJ5LmRvbmUoIHVwZGF0ZUZ1bmMoIGkgKSApLnJlc29sdmUsIHByaW1hcnkucmVqZWN0LFxuXHRcdFx0XHQhcmVtYWluaW5nICk7XG5cblx0XHRcdC8vIFVzZSAudGhlbigpIHRvIHVud3JhcCBzZWNvbmRhcnkgdGhlbmFibGVzIChjZi4gZ2gtMzAwMClcblx0XHRcdGlmICggcHJpbWFyeS5zdGF0ZSgpID09PSBcInBlbmRpbmdcIiB8fFxuXHRcdFx0XHR0eXBlb2YoIHJlc29sdmVWYWx1ZXNbIGkgXSAmJiByZXNvbHZlVmFsdWVzWyBpIF0udGhlbiApID09PSBcImZ1bmN0aW9uXCIgKSB7XG5cblx0XHRcdFx0cmV0dXJuIHByaW1hcnkudGhlbigpO1xuXHRcdFx0fVxuXHRcdH1cblxuXHRcdC8vIE11bHRpcGxlIGFyZ3VtZW50cyBhcmUgYWdncmVnYXRlZCBsaWtlIFByb21pc2UuYWxsIGFycmF5IGVsZW1lbnRzXG5cdFx0d2hpbGUgKCBpLS0gKSB7XG5cdFx0XHRhZG9wdFZhbHVlKCByZXNvbHZlVmFsdWVzWyBpIF0sIHVwZGF0ZUZ1bmMoIGkgKSwgcHJpbWFyeS5yZWplY3QgKTtcblx0XHR9XG5cblx0XHRyZXR1cm4gcHJpbWFyeS5wcm9taXNlKCk7XG5cdH1cbn0gKTtcblxuLy8gVGhlc2UgdXN1YWxseSBpbmRpY2F0ZSBhIHByb2dyYW1tZXIgbWlzdGFrZSBkdXJpbmcgZGV2ZWxvcG1lbnQsXG4vLyB3YXJuIGFib3V0IHRoZW0gQVNBUCByYXRoZXIgdGhhbiBzd2FsbG93aW5nIHRoZW0gYnkgZGVmYXVsdC5cbnZhciByZXJyb3JOYW1lcyA9IC9eKEV2YWx8SW50ZXJuYWx8UmFuZ2V8UmVmZXJlbmNlfFN5bnRheHxUeXBlfFVSSSlFcnJvciQvO1xuXG4vLyBJZiBgalF1ZXJ5LkRlZmVycmVkLmdldEVycm9ySG9va2AgaXMgZGVmaW5lZCwgYGFzeW5jRXJyb3JgIGlzIGFuIGVycm9yXG4vLyBjYXB0dXJlZCBiZWZvcmUgdGhlIGFzeW5jIGJhcnJpZXIgdG8gZ2V0IHRoZSBvcmlnaW5hbCBlcnJvciBjYXVzZVxuLy8gd2hpY2ggbWF5IG90aGVyd2lzZSBiZSBoaWRkZW4uXG5qUXVlcnkuRGVmZXJyZWQuZXhjZXB0aW9uSG9vayA9IGZ1bmN0aW9uKCBlcnJvciwgYXN5bmNFcnJvciApIHtcblxuXHRpZiAoIGVycm9yICYmIHJlcnJvck5hbWVzLnRlc3QoIGVycm9yLm5hbWUgKSApIHtcblx0XHR3aW5kb3cuY29uc29sZS53YXJuKFxuXHRcdFx0XCJqUXVlcnkuRGVmZXJyZWQgZXhjZXB0aW9uXCIsXG5cdFx0XHRlcnJvcixcblx0XHRcdGFzeW5jRXJyb3Jcblx0XHQpO1xuXHR9XG59O1xuXG5qUXVlcnkucmVhZHlFeGNlcHRpb24gPSBmdW5jdGlvbiggZXJyb3IgKSB7XG5cdHdpbmRvdy5zZXRUaW1lb3V0KCBmdW5jdGlvbigpIHtcblx0XHR0aHJvdyBlcnJvcjtcblx0fSApO1xufTtcblxuLy8gVGhlIGRlZmVycmVkIHVzZWQgb24gRE9NIHJlYWR5XG52YXIgcmVhZHlMaXN0ID0galF1ZXJ5LkRlZmVycmVkKCk7XG5cbmpRdWVyeS5mbi5yZWFkeSA9IGZ1bmN0aW9uKCBmbiApIHtcblxuXHRyZWFkeUxpc3Rcblx0XHQudGhlbiggZm4gKVxuXG5cdFx0Ly8gV3JhcCBqUXVlcnkucmVhZHlFeGNlcHRpb24gaW4gYSBmdW5jdGlvbiBzbyB0aGF0IHRoZSBsb29rdXBcblx0XHQvLyBoYXBwZW5zIGF0IHRoZSB0aW1lIG9mIGVycm9yIGhhbmRsaW5nIGluc3RlYWQgb2YgY2FsbGJhY2tcblx0XHQvLyByZWdpc3RyYXRpb24uXG5cdFx0LmNhdGNoKCBmdW5jdGlvbiggZXJyb3IgKSB7XG5cdFx0XHRqUXVlcnkucmVhZHlFeGNlcHRpb24oIGVycm9yICk7XG5cdFx0fSApO1xuXG5cdHJldHVybiB0aGlzO1xufTtcblxualF1ZXJ5LmV4dGVuZCgge1xuXG5cdC8vIElzIHRoZSBET00gcmVhZHkgdG8gYmUgdXNlZD8gU2V0IHRvIHRydWUgb25jZSBpdCBvY2N1cnMuXG5cdGlzUmVhZHk6IGZhbHNlLFxuXG5cdC8vIEEgY291bnRlciB0byB0cmFjayBob3cgbWFueSBpdGVtcyB0byB3YWl0IGZvciBiZWZvcmVcblx0Ly8gdGhlIHJlYWR5IGV2ZW50IGZpcmVzLiBTZWUgdHJhYy02NzgxXG5cdHJlYWR5V2FpdDogMSxcblxuXHQvLyBIYW5kbGUgd2hlbiB0aGUgRE9NIGlzIHJlYWR5XG5cdHJlYWR5OiBmdW5jdGlvbiggd2FpdCApIHtcblxuXHRcdC8vIEFib3J0IGlmIHRoZXJlIGFyZSBwZW5kaW5nIGhvbGRzIG9yIHdlJ3JlIGFscmVhZHkgcmVhZHlcblx0XHRpZiAoIHdhaXQgPT09IHRydWUgPyAtLWpRdWVyeS5yZWFkeVdhaXQgOiBqUXVlcnkuaXNSZWFkeSApIHtcblx0XHRcdHJldHVybjtcblx0XHR9XG5cblx0XHQvLyBSZW1lbWJlciB0aGF0IHRoZSBET00gaXMgcmVhZHlcblx0XHRqUXVlcnkuaXNSZWFkeSA9IHRydWU7XG5cblx0XHQvLyBJZiBhIG5vcm1hbCBET00gUmVhZHkgZXZlbnQgZmlyZWQsIGRlY3JlbWVudCwgYW5kIHdhaXQgaWYgbmVlZCBiZVxuXHRcdGlmICggd2FpdCAhPT0gdHJ1ZSAmJiAtLWpRdWVyeS5yZWFkeVdhaXQgPiAwICkge1xuXHRcdFx0cmV0dXJuO1xuXHRcdH1cblxuXHRcdC8vIElmIHRoZXJlIGFyZSBmdW5jdGlvbnMgYm91bmQsIHRvIGV4ZWN1dGVcblx0XHRyZWFkeUxpc3QucmVzb2x2ZVdpdGgoIGRvY3VtZW50JDEsIFsgalF1ZXJ5IF0gKTtcblx0fVxufSApO1xuXG5qUXVlcnkucmVhZHkudGhlbiA9IHJlYWR5TGlzdC50aGVuO1xuXG4vLyBUaGUgcmVhZHkgZXZlbnQgaGFuZGxlciBhbmQgc2VsZiBjbGVhbnVwIG1ldGhvZFxuZnVuY3Rpb24gY29tcGxldGVkKCkge1xuXHRkb2N1bWVudCQxLnJlbW92ZUV2ZW50TGlzdGVuZXIoIFwiRE9NQ29udGVudExvYWRlZFwiLCBjb21wbGV0ZWQgKTtcblx0d2luZG93LnJlbW92ZUV2ZW50TGlzdGVuZXIoIFwibG9hZFwiLCBjb21wbGV0ZWQgKTtcblx0alF1ZXJ5LnJlYWR5KCk7XG59XG5cbi8vIENhdGNoIGNhc2VzIHdoZXJlICQoZG9jdW1lbnQpLnJlYWR5KCkgaXMgY2FsbGVkXG4vLyBhZnRlciB0aGUgYnJvd3NlciBldmVudCBoYXMgYWxyZWFkeSBvY2N1cnJlZC5cbmlmICggZG9jdW1lbnQkMS5yZWFkeVN0YXRlICE9PSBcImxvYWRpbmdcIiApIHtcblxuXHQvLyBIYW5kbGUgaXQgYXN5bmNocm9ub3VzbHkgdG8gYWxsb3cgc2NyaXB0cyB0aGUgb3Bwb3J0dW5pdHkgdG8gZGVsYXkgcmVhZHlcblx0d2luZG93LnNldFRpbWVvdXQoIGpRdWVyeS5yZWFkeSApO1xuXG59IGVsc2Uge1xuXG5cdC8vIFVzZSB0aGUgaGFuZHkgZXZlbnQgY2FsbGJhY2tcblx0ZG9jdW1lbnQkMS5hZGRFdmVudExpc3RlbmVyKCBcIkRPTUNvbnRlbnRMb2FkZWRcIiwgY29tcGxldGVkICk7XG5cblx0Ly8gQSBmYWxsYmFjayB0byB3aW5kb3cub25sb2FkLCB0aGF0IHdpbGwgYWx3YXlzIHdvcmtcblx0d2luZG93LmFkZEV2ZW50TGlzdGVuZXIoIFwibG9hZFwiLCBjb21wbGV0ZWQgKTtcbn1cblxuLy8gTWF0Y2hlcyBkYXNoZWQgc3RyaW5nIGZvciBjYW1lbGl6aW5nXG52YXIgcmRhc2hBbHBoYSA9IC8tKFthLXpdKS9nO1xuXG4vLyBVc2VkIGJ5IGNhbWVsQ2FzZSBhcyBjYWxsYmFjayB0byByZXBsYWNlKClcbmZ1bmN0aW9uIGZjYW1lbENhc2UoIF9hbGwsIGxldHRlciApIHtcblx0cmV0dXJuIGxldHRlci50b1VwcGVyQ2FzZSgpO1xufVxuXG4vLyBDb252ZXJ0IGRhc2hlZCB0byBjYW1lbENhc2VcbmZ1bmN0aW9uIGNhbWVsQ2FzZSggc3RyaW5nICkge1xuXHRyZXR1cm4gc3RyaW5nLnJlcGxhY2UoIHJkYXNoQWxwaGEsIGZjYW1lbENhc2UgKTtcbn1cblxuLyoqXG4gKiBEZXRlcm1pbmVzIHdoZXRoZXIgYW4gb2JqZWN0IGNhbiBoYXZlIGRhdGFcbiAqL1xuZnVuY3Rpb24gYWNjZXB0RGF0YSggb3duZXIgKSB7XG5cblx0Ly8gQWNjZXB0cyBvbmx5OlxuXHQvLyAgLSBOb2RlXG5cdC8vICAgIC0gTm9kZS5FTEVNRU5UX05PREVcblx0Ly8gICAgLSBOb2RlLkRPQ1VNRU5UX05PREVcblx0Ly8gIC0gT2JqZWN0XG5cdC8vICAgIC0gQW55XG5cdHJldHVybiBvd25lci5ub2RlVHlwZSA9PT0gMSB8fCBvd25lci5ub2RlVHlwZSA9PT0gOSB8fCAhKCArb3duZXIubm9kZVR5cGUgKTtcbn1cblxuZnVuY3Rpb24gRGF0YSgpIHtcblx0dGhpcy5leHBhbmRvID0galF1ZXJ5LmV4cGFuZG8gKyBEYXRhLnVpZCsrO1xufVxuXG5EYXRhLnVpZCA9IDE7XG5cbkRhdGEucHJvdG90eXBlID0ge1xuXG5cdGNhY2hlOiBmdW5jdGlvbiggb3duZXIgKSB7XG5cblx0XHQvLyBDaGVjayBpZiB0aGUgb3duZXIgb2JqZWN0IGFscmVhZHkgaGFzIGEgY2FjaGVcblx0XHR2YXIgdmFsdWUgPSBvd25lclsgdGhpcy5leHBhbmRvIF07XG5cblx0XHQvLyBJZiBub3QsIGNyZWF0ZSBvbmVcblx0XHRpZiAoICF2YWx1ZSApIHtcblx0XHRcdHZhbHVlID0gT2JqZWN0LmNyZWF0ZSggbnVsbCApO1xuXG5cdFx0XHQvLyBXZSBjYW4gYWNjZXB0IGRhdGEgZm9yIG5vbi1lbGVtZW50IG5vZGVzIGluIG1vZGVybiBicm93c2Vycyxcblx0XHRcdC8vIGJ1dCB3ZSBzaG91bGQgbm90LCBzZWUgdHJhYy04MzM1LlxuXHRcdFx0Ly8gQWx3YXlzIHJldHVybiBhbiBlbXB0eSBvYmplY3QuXG5cdFx0XHRpZiAoIGFjY2VwdERhdGEoIG93bmVyICkgKSB7XG5cblx0XHRcdFx0Ly8gSWYgaXQgaXMgYSBub2RlIHVubGlrZWx5IHRvIGJlIHN0cmluZ2lmeS1lZCBvciBsb29wZWQgb3ZlclxuXHRcdFx0XHQvLyB1c2UgcGxhaW4gYXNzaWdubWVudFxuXHRcdFx0XHRpZiAoIG93bmVyLm5vZGVUeXBlICkge1xuXHRcdFx0XHRcdG93bmVyWyB0aGlzLmV4cGFuZG8gXSA9IHZhbHVlO1xuXG5cdFx0XHRcdC8vIE90aGVyd2lzZSBzZWN1cmUgaXQgaW4gYSBub24tZW51bWVyYWJsZSBwcm9wZXJ0eVxuXHRcdFx0XHQvLyBjb25maWd1cmFibGUgbXVzdCBiZSB0cnVlIHRvIGFsbG93IHRoZSBwcm9wZXJ0eSB0byBiZVxuXHRcdFx0XHQvLyBkZWxldGVkIHdoZW4gZGF0YSBpcyByZW1vdmVkXG5cdFx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KCBvd25lciwgdGhpcy5leHBhbmRvLCB7XG5cdFx0XHRcdFx0XHR2YWx1ZTogdmFsdWUsXG5cdFx0XHRcdFx0XHRjb25maWd1cmFibGU6IHRydWVcblx0XHRcdFx0XHR9ICk7XG5cdFx0XHRcdH1cblx0XHRcdH1cblx0XHR9XG5cblx0XHRyZXR1cm4gdmFsdWU7XG5cdH0sXG5cdHNldDogZnVuY3Rpb24oIG93bmVyLCBkYXRhLCB2YWx1ZSApIHtcblx0XHR2YXIgcHJvcCxcblx0XHRcdGNhY2hlID0gdGhpcy5jYWNoZSggb3duZXIgKTtcblxuXHRcdC8vIEhhbmRsZTogWyBvd25lciwga2V5LCB2YWx1ZSBdIGFyZ3Ncblx0XHQvLyBBbHdheXMgdXNlIGNhbWVsQ2FzZSBrZXkgKGdoLTIyNTcpXG5cdFx0aWYgKCB0eXBlb2YgZGF0YSA9PT0gXCJzdHJpbmdcIiApIHtcblx0XHRcdGNhY2hlWyBjYW1lbENhc2UoIGRhdGEgKSBdID0gdmFsdWU7XG5cblx0XHQvLyBIYW5kbGU6IFsgb3duZXIsIHsgcHJvcGVydGllcyB9IF0gYXJnc1xuXHRcdH0gZWxzZSB7XG5cblx0XHRcdC8vIENvcHkgdGhlIHByb3BlcnRpZXMgb25lLWJ5LW9uZSB0byB0aGUgY2FjaGUgb2JqZWN0XG5cdFx0XHRmb3IgKCBwcm9wIGluIGRhdGEgKSB7XG5cdFx0XHRcdGNhY2hlWyBjYW1lbENhc2UoIHByb3AgKSBdID0gZGF0YVsgcHJvcCBdO1xuXHRcdFx0fVxuXHRcdH1cblx0XHRyZXR1cm4gdmFsdWU7XG5cdH0sXG5cdGdldDogZnVuY3Rpb24oIG93bmVyLCBrZXkgKSB7XG5cdFx0cmV0dXJuIGtleSA9PT0gdW5kZWZpbmVkID9cblx0XHRcdHRoaXMuY2FjaGUoIG93bmVyICkgOlxuXG5cdFx0XHQvLyBBbHdheXMgdXNlIGNhbWVsQ2FzZSBrZXkgKGdoLTIyNTcpXG5cdFx0XHRvd25lclsgdGhpcy5leHBhbmRvIF0gJiYgb3duZXJbIHRoaXMuZXhwYW5kbyBdWyBjYW1lbENhc2UoIGtleSApIF07XG5cdH0sXG5cdGFjY2VzczogZnVuY3Rpb24oIG93bmVyLCBrZXksIHZhbHVlICkge1xuXG5cdFx0Ly8gSW4gY2FzZXMgd2hlcmUgZWl0aGVyOlxuXHRcdC8vXG5cdFx0Ly8gICAxLiBObyBrZXkgd2FzIHNwZWNpZmllZFxuXHRcdC8vICAgMi4gQSBzdHJpbmcga2V5IHdhcyBzcGVjaWZpZWQsIGJ1dCBubyB2YWx1ZSBwcm92aWRlZFxuXHRcdC8vXG5cdFx0Ly8gVGFrZSB0aGUgXCJyZWFkXCIgcGF0aCBhbmQgYWxsb3cgdGhlIGdldCBtZXRob2QgdG8gZGV0ZXJtaW5lXG5cdFx0Ly8gd2hpY2ggdmFsdWUgdG8gcmV0dXJuLCByZXNwZWN0aXZlbHkgZWl0aGVyOlxuXHRcdC8vXG5cdFx0Ly8gICAxLiBUaGUgZW50aXJlIGNhY2hlIG9iamVjdFxuXHRcdC8vICAgMi4gVGhlIGRhdGEgc3RvcmVkIGF0IHRoZSBrZXlcblx0XHQvL1xuXHRcdGlmICgga2V5ID09PSB1bmRlZmluZWQgfHxcblx0XHRcdFx0KCAoIGtleSAmJiB0eXBlb2Yga2V5ID09PSBcInN0cmluZ1wiICkgJiYgdmFsdWUgPT09IHVuZGVmaW5lZCApICkge1xuXG5cdFx0XHRyZXR1cm4gdGhpcy5nZXQoIG93bmVyLCBrZXkgKTtcblx0XHR9XG5cblx0XHQvLyBXaGVuIHRoZSBrZXkgaXMgbm90IGEgc3RyaW5nLCBvciBib3RoIGEga2V5IGFuZCB2YWx1ZVxuXHRcdC8vIGFyZSBzcGVjaWZpZWQsIHNldCBvciBleHRlbmQgKGV4aXN0aW5nIG9iamVjdHMpIHdpdGggZWl0aGVyOlxuXHRcdC8vXG5cdFx0Ly8gICAxLiBBbiBvYmplY3Qgb2YgcHJvcGVydGllc1xuXHRcdC8vICAgMi4gQSBrZXkgYW5kIHZhbHVlXG5cdFx0Ly9cblx0XHR0aGlzLnNldCggb3duZXIsIGtleSwgdmFsdWUgKTtcblxuXHRcdC8vIFNpbmNlIHRoZSBcInNldFwiIHBhdGggY2FuIGhhdmUgdHdvIHBvc3NpYmxlIGVudHJ5IHBvaW50c1xuXHRcdC8vIHJldHVybiB0aGUgZXhwZWN0ZWQgZGF0YSBiYXNlZCBvbiB3aGljaCBwYXRoIHdhcyB0YWtlblsqXVxuXHRcdHJldHVybiB2YWx1ZSAhPT0gdW5kZWZpbmVkID8gdmFsdWUgOiBrZXk7XG5cdH0sXG5cdHJlbW92ZTogZnVuY3Rpb24oIG93bmVyLCBrZXkgKSB7XG5cdFx0dmFyIGksXG5cdFx0XHRjYWNoZSA9IG93bmVyWyB0aGlzLmV4cGFuZG8gXTtcblxuXHRcdGlmICggY2FjaGUgPT09IHVuZGVmaW5lZCApIHtcblx0XHRcdHJldHVybjtcblx0XHR9XG5cblx0XHRpZiAoIGtleSAhPT0gdW5kZWZpbmVkICkge1xuXG5cdFx0XHQvLyBTdXBwb3J0IGFycmF5IG9yIHNwYWNlIHNlcGFyYXRlZCBzdHJpbmcgb2Yga2V5c1xuXHRcdFx0aWYgKCBBcnJheS5pc0FycmF5KCBrZXkgKSApIHtcblxuXHRcdFx0XHQvLyBJZiBrZXkgaXMgYW4gYXJyYXkgb2Yga2V5cy4uLlxuXHRcdFx0XHQvLyBXZSBhbHdheXMgc2V0IGNhbWVsQ2FzZSBrZXlzLCBzbyByZW1vdmUgdGhhdC5cblx0XHRcdFx0a2V5ID0ga2V5Lm1hcCggY2FtZWxDYXNlICk7XG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRrZXkgPSBjYW1lbENhc2UoIGtleSApO1xuXG5cdFx0XHRcdC8vIElmIGEga2V5IHdpdGggdGhlIHNwYWNlcyBleGlzdHMsIHVzZSBpdC5cblx0XHRcdFx0Ly8gT3RoZXJ3aXNlLCBjcmVhdGUgYW4gYXJyYXkgYnkgbWF0Y2hpbmcgbm9uLXdoaXRlc3BhY2Vcblx0XHRcdFx0a2V5ID0ga2V5IGluIGNhY2hlID9cblx0XHRcdFx0XHRbIGtleSBdIDpcblx0XHRcdFx0XHQoIGtleS5tYXRjaCggcm5vdGh0bWx3aGl0ZSApIHx8IFtdICk7XG5cdFx0XHR9XG5cblx0XHRcdGkgPSBrZXkubGVuZ3RoO1xuXG5cdFx0XHR3aGlsZSAoIGktLSApIHtcblx0XHRcdFx0ZGVsZXRlIGNhY2hlWyBrZXlbIGkgXSBdO1xuXHRcdFx0fVxuXHRcdH1cblxuXHRcdC8vIFJlbW92ZSB0aGUgZXhwYW5kbyBpZiB0aGVyZSdzIG5vIG1vcmUgZGF0YVxuXHRcdGlmICgga2V5ID09PSB1bmRlZmluZWQgfHwgalF1ZXJ5LmlzRW1wdHlPYmplY3QoIGNhY2hlICkgKSB7XG5cblx0XHRcdC8vIFN1cHBvcnQ6IENocm9tZSA8PTM1IC0gNDUrXG5cdFx0XHQvLyBXZWJraXQgJiBCbGluayBwZXJmb3JtYW5jZSBzdWZmZXJzIHdoZW4gZGVsZXRpbmcgcHJvcGVydGllc1xuXHRcdFx0Ly8gZnJvbSBET00gbm9kZXMsIHNvIHNldCB0byB1bmRlZmluZWQgaW5zdGVhZFxuXHRcdFx0Ly8gaHR0cHM6Ly9idWdzLmNocm9taXVtLm9yZy9wL2Nocm9taXVtL2lzc3Vlcy9kZXRhaWw/aWQ9Mzc4NjA3IChidWcgcmVzdHJpY3RlZClcblx0XHRcdGlmICggb3duZXIubm9kZVR5cGUgKSB7XG5cdFx0XHRcdG93bmVyWyB0aGlzLmV4cGFuZG8gXSA9IHVuZGVmaW5lZDtcblx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdGRlbGV0ZSBvd25lclsgdGhpcy5leHBhbmRvIF07XG5cdFx0XHR9XG5cdFx0fVxuXHR9LFxuXHRoYXNEYXRhOiBmdW5jdGlvbiggb3duZXIgKSB7XG5cdFx0dmFyIGNhY2hlID0gb3duZXJbIHRoaXMuZXhwYW5kbyBdO1xuXHRcdHJldHVybiBjYWNoZSAhPT0gdW5kZWZpbmVkICYmICFqUXVlcnkuaXNFbXB0eU9iamVjdCggY2FjaGUgKTtcblx0fVxufTtcblxudmFyIGRhdGFQcml2ID0gbmV3IERhdGEoKTtcblxudmFyIGRhdGFVc2VyID0gbmV3IERhdGEoKTtcblxuLy9cdEltcGxlbWVudGF0aW9uIFN1bW1hcnlcbi8vXG4vL1x0MS4gRW5mb3JjZSBBUEkgc3VyZmFjZSBhbmQgc2VtYW50aWMgY29tcGF0aWJpbGl0eSB3aXRoIDEuOS54IGJyYW5jaFxuLy9cdDIuIEltcHJvdmUgdGhlIG1vZHVsZSdzIG1haW50YWluYWJpbGl0eSBieSByZWR1Y2luZyB0aGUgc3RvcmFnZVxuLy9cdFx0cGF0aHMgdG8gYSBzaW5nbGUgbWVjaGFuaXNtLlxuLy9cdDMuIFVzZSB0aGUgc2FtZSBzaW5nbGUgbWVjaGFuaXNtIHRvIHN1cHBvcnQgXCJwcml2YXRlXCIgYW5kIFwidXNlclwiIGRhdGEuXG4vL1x0NC4gX05ldmVyXyBleHBvc2UgXCJwcml2YXRlXCIgZGF0YSB0byB1c2VyIGNvZGUgKFRPRE86IERyb3AgX2RhdGEsIF9yZW1vdmVEYXRhKVxuLy9cdDUuIEF2b2lkIGV4cG9zaW5nIGltcGxlbWVudGF0aW9uIGRldGFpbHMgb24gdXNlciBvYmplY3RzIChlZy4gZXhwYW5kbyBwcm9wZXJ0aWVzKVxuLy9cdDYuIFByb3ZpZGUgYSBjbGVhciBwYXRoIGZvciBpbXBsZW1lbnRhdGlvbiB1cGdyYWRlIHRvIFdlYWtNYXAgaW4gMjAxNFxuXG52YXIgcmJyYWNlID0gL14oPzpcXHtbXFx3XFxXXSpcXH18XFxbW1xcd1xcV10qXFxdKSQvLFxuXHRybXVsdGlEYXNoID0gL1tBLVpdL2c7XG5cbmZ1bmN0aW9uIGdldERhdGEoIGRhdGEgKSB7XG5cdGlmICggZGF0YSA9PT0gXCJ0cnVlXCIgKSB7XG5cdFx0cmV0dXJuIHRydWU7XG5cdH1cblxuXHRpZiAoIGRhdGEgPT09IFwiZmFsc2VcIiApIHtcblx0XHRyZXR1cm4gZmFsc2U7XG5cdH1cblxuXHRpZiAoIGRhdGEgPT09IFwibnVsbFwiICkge1xuXHRcdHJldHVybiBudWxsO1xuXHR9XG5cblx0Ly8gT25seSBjb252ZXJ0IHRvIGEgbnVtYmVyIGlmIGl0IGRvZXNuJ3QgY2hhbmdlIHRoZSBzdHJpbmdcblx0aWYgKCBkYXRhID09PSArZGF0YSArIFwiXCIgKSB7XG5cdFx0cmV0dXJuICtkYXRhO1xuXHR9XG5cblx0aWYgKCByYnJhY2UudGVzdCggZGF0YSApICkge1xuXHRcdHJldHVybiBKU09OLnBhcnNlKCBkYXRhICk7XG5cdH1cblxuXHRyZXR1cm4gZGF0YTtcbn1cblxuZnVuY3Rpb24gZGF0YUF0dHIoIGVsZW0sIGtleSwgZGF0YSApIHtcblx0dmFyIG5hbWU7XG5cblx0Ly8gSWYgbm90aGluZyB3YXMgZm91bmQgaW50ZXJuYWxseSwgdHJ5IHRvIGZldGNoIGFueVxuXHQvLyBkYXRhIGZyb20gdGhlIEhUTUw1IGRhdGEtKiBhdHRyaWJ1dGVcblx0aWYgKCBkYXRhID09PSB1bmRlZmluZWQgJiYgZWxlbS5ub2RlVHlwZSA9PT0gMSApIHtcblx0XHRuYW1lID0gXCJkYXRhLVwiICsga2V5LnJlcGxhY2UoIHJtdWx0aURhc2gsIFwiLSQmXCIgKS50b0xvd2VyQ2FzZSgpO1xuXHRcdGRhdGEgPSBlbGVtLmdldEF0dHJpYnV0ZSggbmFtZSApO1xuXG5cdFx0aWYgKCB0eXBlb2YgZGF0YSA9PT0gXCJzdHJpbmdcIiApIHtcblx0XHRcdHRyeSB7XG5cdFx0XHRcdGRhdGEgPSBnZXREYXRhKCBkYXRhICk7XG5cdFx0XHR9IGNhdGNoICggZSApIHt9XG5cblx0XHRcdC8vIE1ha2Ugc3VyZSB3ZSBzZXQgdGhlIGRhdGEgc28gaXQgaXNuJ3QgY2hhbmdlZCBsYXRlclxuXHRcdFx0ZGF0YVVzZXIuc2V0KCBlbGVtLCBrZXksIGRhdGEgKTtcblx0XHR9IGVsc2Uge1xuXHRcdFx0ZGF0YSA9IHVuZGVmaW5lZDtcblx0XHR9XG5cdH1cblx0cmV0dXJuIGRhdGE7XG59XG5cbmpRdWVyeS5leHRlbmQoIHtcblx0aGFzRGF0YTogZnVuY3Rpb24oIGVsZW0gKSB7XG5cdFx0cmV0dXJuIGRhdGFVc2VyLmhhc0RhdGEoIGVsZW0gKSB8fCBkYXRhUHJpdi5oYXNEYXRhKCBlbGVtICk7XG5cdH0sXG5cblx0ZGF0YTogZnVuY3Rpb24oIGVsZW0sIG5hbWUsIGRhdGEgKSB7XG5cdFx0cmV0dXJuIGRhdGFVc2VyLmFjY2VzcyggZWxlbSwgbmFtZSwgZGF0YSApO1xuXHR9LFxuXG5cdHJlbW92ZURhdGE6IGZ1bmN0aW9uKCBlbGVtLCBuYW1lICkge1xuXHRcdGRhdGFVc2VyLnJlbW92ZSggZWxlbSwgbmFtZSApO1xuXHR9LFxuXG5cdC8vIFRPRE86IE5vdyB0aGF0IGFsbCBjYWxscyB0byBfZGF0YSBhbmQgX3JlbW92ZURhdGEgaGF2ZSBiZWVuIHJlcGxhY2VkXG5cdC8vIHdpdGggZGlyZWN0IGNhbGxzIHRvIGRhdGFQcml2IG1ldGhvZHMsIHRoZXNlIGNhbiBiZSBkZXByZWNhdGVkLlxuXHRfZGF0YTogZnVuY3Rpb24oIGVsZW0sIG5hbWUsIGRhdGEgKSB7XG5cdFx0cmV0dXJuIGRhdGFQcml2LmFjY2VzcyggZWxlbSwgbmFtZSwgZGF0YSApO1xuXHR9LFxuXG5cdF9yZW1vdmVEYXRhOiBmdW5jdGlvbiggZWxlbSwgbmFtZSApIHtcblx0XHRkYXRhUHJpdi5yZW1vdmUoIGVsZW0sIG5hbWUgKTtcblx0fVxufSApO1xuXG5qUXVlcnkuZm4uZXh0ZW5kKCB7XG5cdGRhdGE6IGZ1bmN0aW9uKCBrZXksIHZhbHVlICkge1xuXHRcdHZhciBpLCBuYW1lLCBkYXRhLFxuXHRcdFx0ZWxlbSA9IHRoaXNbIDAgXSxcblx0XHRcdGF0dHJzID0gZWxlbSAmJiBlbGVtLmF0dHJpYnV0ZXM7XG5cblx0XHQvLyBHZXRzIGFsbCB2YWx1ZXNcblx0XHRpZiAoIGtleSA9PT0gdW5kZWZpbmVkICkge1xuXHRcdFx0aWYgKCB0aGlzLmxlbmd0aCApIHtcblx0XHRcdFx0ZGF0YSA9IGRhdGFVc2VyLmdldCggZWxlbSApO1xuXG5cdFx0XHRcdGlmICggZWxlbS5ub2RlVHlwZSA9PT0gMSAmJiAhZGF0YVByaXYuZ2V0KCBlbGVtLCBcImhhc0RhdGFBdHRyc1wiICkgKSB7XG5cdFx0XHRcdFx0aSA9IGF0dHJzLmxlbmd0aDtcblx0XHRcdFx0XHR3aGlsZSAoIGktLSApIHtcblxuXHRcdFx0XHRcdFx0Ly8gU3VwcG9ydDogSUUgMTErXG5cdFx0XHRcdFx0XHQvLyBUaGUgYXR0cnMgZWxlbWVudHMgY2FuIGJlIG51bGwgKHRyYWMtMTQ4OTQpXG5cdFx0XHRcdFx0XHRpZiAoIGF0dHJzWyBpIF0gKSB7XG5cdFx0XHRcdFx0XHRcdG5hbWUgPSBhdHRyc1sgaSBdLm5hbWU7XG5cdFx0XHRcdFx0XHRcdGlmICggbmFtZS5pbmRleE9mKCBcImRhdGEtXCIgKSA9PT0gMCApIHtcblx0XHRcdFx0XHRcdFx0XHRuYW1lID0gY2FtZWxDYXNlKCBuYW1lLnNsaWNlKCA1ICkgKTtcblx0XHRcdFx0XHRcdFx0XHRkYXRhQXR0ciggZWxlbSwgbmFtZSwgZGF0YVsgbmFtZSBdICk7XG5cdFx0XHRcdFx0XHRcdH1cblx0XHRcdFx0XHRcdH1cblx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0ZGF0YVByaXYuc2V0KCBlbGVtLCBcImhhc0RhdGFBdHRyc1wiLCB0cnVlICk7XG5cdFx0XHRcdH1cblx0XHRcdH1cblxuXHRcdFx0cmV0dXJuIGRhdGE7XG5cdFx0fVxuXG5cdFx0Ly8gU2V0cyBtdWx0aXBsZSB2YWx1ZXNcblx0XHRpZiAoIHR5cGVvZiBrZXkgPT09IFwib2JqZWN0XCIgKSB7XG5cdFx0XHRyZXR1cm4gdGhpcy5lYWNoKCBmdW5jdGlvbigpIHtcblx0XHRcdFx0ZGF0YVVzZXIuc2V0KCB0aGlzLCBrZXkgKTtcblx0XHRcdH0gKTtcblx0XHR9XG5cblx0XHRyZXR1cm4gYWNjZXNzKCB0aGlzLCBmdW5jdGlvbiggdmFsdWUgKSB7XG5cdFx0XHR2YXIgZGF0YTtcblxuXHRcdFx0Ly8gVGhlIGNhbGxpbmcgalF1ZXJ5IG9iamVjdCAoZWxlbWVudCBtYXRjaGVzKSBpcyBub3QgZW1wdHlcblx0XHRcdC8vIChhbmQgdGhlcmVmb3JlIGhhcyBhbiBlbGVtZW50IGFwcGVhcnMgYXQgdGhpc1sgMCBdKSBhbmQgdGhlXG5cdFx0XHQvLyBgdmFsdWVgIHBhcmFtZXRlciB3YXMgbm90IHVuZGVmaW5lZC4gQW4gZW1wdHkgalF1ZXJ5IG9iamVjdFxuXHRcdFx0Ly8gd2lsbCByZXN1bHQgaW4gYHVuZGVmaW5lZGAgZm9yIGVsZW0gPSB0aGlzWyAwIF0gd2hpY2ggd2lsbFxuXHRcdFx0Ly8gdGhyb3cgYW4gZXhjZXB0aW9uIGlmIGFuIGF0dGVtcHQgdG8gcmVhZCBhIGRhdGEgY2FjaGUgaXMgbWFkZS5cblx0XHRcdGlmICggZWxlbSAmJiB2YWx1ZSA9PT0gdW5kZWZpbmVkICkge1xuXG5cdFx0XHRcdC8vIEF0dGVtcHQgdG8gZ2V0IGRhdGEgZnJvbSB0aGUgY2FjaGVcblx0XHRcdFx0Ly8gVGhlIGtleSB3aWxsIGFsd2F5cyBiZSBjYW1lbENhc2VkIGluIERhdGFcblx0XHRcdFx0ZGF0YSA9IGRhdGFVc2VyLmdldCggZWxlbSwga2V5ICk7XG5cdFx0XHRcdGlmICggZGF0YSAhPT0gdW5kZWZpbmVkICkge1xuXHRcdFx0XHRcdHJldHVybiBkYXRhO1xuXHRcdFx0XHR9XG5cblx0XHRcdFx0Ly8gQXR0ZW1wdCB0byBcImRpc2NvdmVyXCIgdGhlIGRhdGEgaW5cblx0XHRcdFx0Ly8gSFRNTDUgY3VzdG9tIGRhdGEtKiBhdHRyc1xuXHRcdFx0XHRkYXRhID0gZGF0YUF0dHIoIGVsZW0sIGtleSApO1xuXHRcdFx0XHRpZiAoIGRhdGEgIT09IHVuZGVmaW5lZCApIHtcblx0XHRcdFx0XHRyZXR1cm4gZGF0YTtcblx0XHRcdFx0fVxuXG5cdFx0XHRcdC8vIFdlIHRyaWVkIHJlYWxseSBoYXJkLCBidXQgdGhlIGRhdGEgZG9lc24ndCBleGlzdC5cblx0XHRcdFx0cmV0dXJuO1xuXHRcdFx0fVxuXG5cdFx0XHQvLyBTZXQgdGhlIGRhdGEuLi5cblx0XHRcdHRoaXMuZWFjaCggZnVuY3Rpb24oKSB7XG5cblx0XHRcdFx0Ly8gV2UgYWx3YXlzIHN0b3JlIHRoZSBjYW1lbENhc2VkIGtleVxuXHRcdFx0XHRkYXRhVXNlci5zZXQoIHRoaXMsIGtleSwgdmFsdWUgKTtcblx0XHRcdH0gKTtcblx0XHR9LCBudWxsLCB2YWx1ZSwgYXJndW1lbnRzLmxlbmd0aCA+IDEsIG51bGwsIHRydWUgKTtcblx0fSxcblxuXHRyZW1vdmVEYXRhOiBmdW5jdGlvbigga2V5ICkge1xuXHRcdHJldHVybiB0aGlzLmVhY2goIGZ1bmN0aW9uKCkge1xuXHRcdFx0ZGF0YVVzZXIucmVtb3ZlKCB0aGlzLCBrZXkgKTtcblx0XHR9ICk7XG5cdH1cbn0gKTtcblxualF1ZXJ5LmV4dGVuZCgge1xuXHRxdWV1ZTogZnVuY3Rpb24oIGVsZW0sIHR5cGUsIGRhdGEgKSB7XG5cdFx0dmFyIHF1ZXVlO1xuXG5cdFx0aWYgKCBlbGVtICkge1xuXHRcdFx0dHlwZSA9ICggdHlwZSB8fCBcImZ4XCIgKSArIFwicXVldWVcIjtcblx0XHRcdHF1ZXVlID0gZGF0YVByaXYuZ2V0KCBlbGVtLCB0eXBlICk7XG5cblx0XHRcdC8vIFNwZWVkIHVwIGRlcXVldWUgYnkgZ2V0dGluZyBvdXQgcXVpY2tseSBpZiB0aGlzIGlzIGp1c3QgYSBsb29rdXBcblx0XHRcdGlmICggZGF0YSApIHtcblx0XHRcdFx0aWYgKCAhcXVldWUgfHwgQXJyYXkuaXNBcnJheSggZGF0YSApICkge1xuXHRcdFx0XHRcdHF1ZXVlID0gZGF0YVByaXYuc2V0KCBlbGVtLCB0eXBlLCBqUXVlcnkubWFrZUFycmF5KCBkYXRhICkgKTtcblx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHRxdWV1ZS5wdXNoKCBkYXRhICk7XG5cdFx0XHRcdH1cblx0XHRcdH1cblx0XHRcdHJldHVybiBxdWV1ZSB8fCBbXTtcblx0XHR9XG5cdH0sXG5cblx0ZGVxdWV1ZTogZnVuY3Rpb24oIGVsZW0sIHR5cGUgKSB7XG5cdFx0dHlwZSA9IHR5cGUgfHwgXCJmeFwiO1xuXG5cdFx0dmFyIHF1ZXVlID0galF1ZXJ5LnF1ZXVlKCBlbGVtLCB0eXBlICksXG5cdFx0XHRzdGFydExlbmd0aCA9IHF1ZXVlLmxlbmd0aCxcblx0XHRcdGZuID0gcXVldWUuc2hpZnQoKSxcblx0XHRcdGhvb2tzID0galF1ZXJ5Ll9xdWV1ZUhvb2tzKCBlbGVtLCB0eXBlICksXG5cdFx0XHRuZXh0ID0gZnVuY3Rpb24oKSB7XG5cdFx0XHRcdGpRdWVyeS5kZXF1ZXVlKCBlbGVtLCB0eXBlICk7XG5cdFx0XHR9O1xuXG5cdFx0Ly8gSWYgdGhlIGZ4IHF1ZXVlIGlzIGRlcXVldWVkLCBhbHdheXMgcmVtb3ZlIHRoZSBwcm9ncmVzcyBzZW50aW5lbFxuXHRcdGlmICggZm4gPT09IFwiaW5wcm9ncmVzc1wiICkge1xuXHRcdFx0Zm4gPSBxdWV1ZS5zaGlmdCgpO1xuXHRcdFx0c3RhcnRMZW5ndGgtLTtcblx0XHR9XG5cblx0XHRpZiAoIGZuICkge1xuXG5cdFx0XHQvLyBBZGQgYSBwcm9ncmVzcyBzZW50aW5lbCB0byBwcmV2ZW50IHRoZSBmeCBxdWV1ZSBmcm9tIGJlaW5nXG5cdFx0XHQvLyBhdXRvbWF0aWNhbGx5IGRlcXVldWVkXG5cdFx0XHRpZiAoIHR5cGUgPT09IFwiZnhcIiApIHtcblx0XHRcdFx0cXVldWUudW5zaGlmdCggXCJpbnByb2dyZXNzXCIgKTtcblx0XHRcdH1cblxuXHRcdFx0Ly8gQ2xlYXIgdXAgdGhlIGxhc3QgcXVldWUgc3RvcCBmdW5jdGlvblxuXHRcdFx0ZGVsZXRlIGhvb2tzLnN0b3A7XG5cdFx0XHRmbi5jYWxsKCBlbGVtLCBuZXh0LCBob29rcyApO1xuXHRcdH1cblxuXHRcdGlmICggIXN0YXJ0TGVuZ3RoICYmIGhvb2tzICkge1xuXHRcdFx0aG9va3MuZW1wdHkuZmlyZSgpO1xuXHRcdH1cblx0fSxcblxuXHQvLyBOb3QgcHVibGljIC0gZ2VuZXJhdGUgYSBxdWV1ZUhvb2tzIG9iamVjdCwgb3IgcmV0dXJuIHRoZSBjdXJyZW50IG9uZVxuXHRfcXVldWVIb29rczogZnVuY3Rpb24oIGVsZW0sIHR5cGUgKSB7XG5cdFx0dmFyIGtleSA9IHR5cGUgKyBcInF1ZXVlSG9va3NcIjtcblx0XHRyZXR1cm4gZGF0YVByaXYuZ2V0KCBlbGVtLCBrZXkgKSB8fCBkYXRhUHJpdi5zZXQoIGVsZW0sIGtleSwge1xuXHRcdFx0ZW1wdHk6IGpRdWVyeS5DYWxsYmFja3MoIFwib25jZSBtZW1vcnlcIiApLmFkZCggZnVuY3Rpb24oKSB7XG5cdFx0XHRcdGRhdGFQcml2LnJlbW92ZSggZWxlbSwgWyB0eXBlICsgXCJxdWV1ZVwiLCBrZXkgXSApO1xuXHRcdFx0fSApXG5cdFx0fSApO1xuXHR9XG59ICk7XG5cbmpRdWVyeS5mbi5leHRlbmQoIHtcblx0cXVldWU6IGZ1bmN0aW9uKCB0eXBlLCBkYXRhICkge1xuXHRcdHZhciBzZXR0ZXIgPSAyO1xuXG5cdFx0aWYgKCB0eXBlb2YgdHlwZSAhPT0gXCJzdHJpbmdcIiApIHtcblx0XHRcdGRhdGEgPSB0eXBlO1xuXHRcdFx0dHlwZSA9IFwiZnhcIjtcblx0XHRcdHNldHRlci0tO1xuXHRcdH1cblxuXHRcdGlmICggYXJndW1lbnRzLmxlbmd0aCA8IHNldHRlciApIHtcblx0XHRcdHJldHVybiBqUXVlcnkucXVldWUoIHRoaXNbIDAgXSwgdHlwZSApO1xuXHRcdH1cblxuXHRcdHJldHVybiBkYXRhID09PSB1bmRlZmluZWQgP1xuXHRcdFx0dGhpcyA6XG5cdFx0XHR0aGlzLmVhY2goIGZ1bmN0aW9uKCkge1xuXHRcdFx0XHR2YXIgcXVldWUgPSBqUXVlcnkucXVldWUoIHRoaXMsIHR5cGUsIGRhdGEgKTtcblxuXHRcdFx0XHQvLyBFbnN1cmUgYSBob29rcyBmb3IgdGhpcyBxdWV1ZVxuXHRcdFx0XHRqUXVlcnkuX3F1ZXVlSG9va3MoIHRoaXMsIHR5cGUgKTtcblxuXHRcdFx0XHRpZiAoIHR5cGUgPT09IFwiZnhcIiAmJiBxdWV1ZVsgMCBdICE9PSBcImlucHJvZ3Jlc3NcIiApIHtcblx0XHRcdFx0XHRqUXVlcnkuZGVxdWV1ZSggdGhpcywgdHlwZSApO1xuXHRcdFx0XHR9XG5cdFx0XHR9ICk7XG5cdH0sXG5cdGRlcXVldWU6IGZ1bmN0aW9uKCB0eXBlICkge1xuXHRcdHJldHVybiB0aGlzLmVhY2goIGZ1bmN0aW9uKCkge1xuXHRcdFx0alF1ZXJ5LmRlcXVldWUoIHRoaXMsIHR5cGUgKTtcblx0XHR9ICk7XG5cdH0sXG5cdGNsZWFyUXVldWU6IGZ1bmN0aW9uKCB0eXBlICkge1xuXHRcdHJldHVybiB0aGlzLnF1ZXVlKCB0eXBlIHx8IFwiZnhcIiwgW10gKTtcblx0fSxcblxuXHQvLyBHZXQgYSBwcm9taXNlIHJlc29sdmVkIHdoZW4gcXVldWVzIG9mIGEgY2VydGFpbiB0eXBlXG5cdC8vIGFyZSBlbXB0aWVkIChmeCBpcyB0aGUgdHlwZSBieSBkZWZhdWx0KVxuXHRwcm9taXNlOiBmdW5jdGlvbiggdHlwZSwgb2JqICkge1xuXHRcdHZhciB0bXAsXG5cdFx0XHRjb3VudCA9IDEsXG5cdFx0XHRkZWZlciA9IGpRdWVyeS5EZWZlcnJlZCgpLFxuXHRcdFx0ZWxlbWVudHMgPSB0aGlzLFxuXHRcdFx0aSA9IHRoaXMubGVuZ3RoLFxuXHRcdFx0cmVzb2x2ZSA9IGZ1bmN0aW9uKCkge1xuXHRcdFx0XHRpZiAoICEoIC0tY291bnQgKSApIHtcblx0XHRcdFx0XHRkZWZlci5yZXNvbHZlV2l0aCggZWxlbWVudHMsIFsgZWxlbWVudHMgXSApO1xuXHRcdFx0XHR9XG5cdFx0XHR9O1xuXG5cdFx0aWYgKCB0eXBlb2YgdHlwZSAhPT0gXCJzdHJpbmdcIiApIHtcblx0XHRcdG9iaiA9IHR5cGU7XG5cdFx0XHR0eXBlID0gdW5kZWZpbmVkO1xuXHRcdH1cblx0XHR0eXBlID0gdHlwZSB8fCBcImZ4XCI7XG5cblx0XHR3aGlsZSAoIGktLSApIHtcblx0XHRcdHRtcCA9IGRhdGFQcml2LmdldCggZWxlbWVudHNbIGkgXSwgdHlwZSArIFwicXVldWVIb29rc1wiICk7XG5cdFx0XHRpZiAoIHRtcCAmJiB0bXAuZW1wdHkgKSB7XG5cdFx0XHRcdGNvdW50Kys7XG5cdFx0XHRcdHRtcC5lbXB0eS5hZGQoIHJlc29sdmUgKTtcblx0XHRcdH1cblx0XHR9XG5cdFx0cmVzb2x2ZSgpO1xuXHRcdHJldHVybiBkZWZlci5wcm9taXNlKCBvYmogKTtcblx0fVxufSApO1xuXG52YXIgcG51bSA9IC9bKy1dPyg/OlxcZCpcXC58KVxcZCsoPzpbZUVdWystXT9cXGQrfCkvLnNvdXJjZTtcblxudmFyIHJjc3NOdW0gPSBuZXcgUmVnRXhwKCBcIl4oPzooWystXSk9fCkoXCIgKyBwbnVtICsgXCIpKFthLXolXSopJFwiLCBcImlcIiApO1xuXG52YXIgY3NzRXhwYW5kID0gWyBcIlRvcFwiLCBcIlJpZ2h0XCIsIFwiQm90dG9tXCIsIFwiTGVmdFwiIF07XG5cbi8vIGlzSGlkZGVuV2l0aGluVHJlZSByZXBvcnRzIGlmIGFuIGVsZW1lbnQgaGFzIGEgbm9uLVwibm9uZVwiIGRpc3BsYXkgc3R5bGUgKGlubGluZSBhbmQvb3Jcbi8vIHRocm91Z2ggdGhlIENTUyBjYXNjYWRlKSwgd2hpY2ggaXMgdXNlZnVsIGluIGRlY2lkaW5nIHdoZXRoZXIgb3Igbm90IHRvIG1ha2UgaXQgdmlzaWJsZS5cbi8vIEl0IGRpZmZlcnMgZnJvbSB0aGUgOmhpZGRlbiBzZWxlY3RvciAoalF1ZXJ5LmV4cHIucHNldWRvcy5oaWRkZW4pIGluIHR3byBpbXBvcnRhbnQgd2F5czpcbi8vICogQSBoaWRkZW4gYW5jZXN0b3IgZG9lcyBub3QgZm9yY2UgYW4gZWxlbWVudCB0byBiZSBjbGFzc2lmaWVkIGFzIGhpZGRlbi5cbi8vICogQmVpbmcgZGlzY29ubmVjdGVkIGZyb20gdGhlIGRvY3VtZW50IGRvZXMgbm90IGZvcmNlIGFuIGVsZW1lbnQgdG8gYmUgY2xhc3NpZmllZCBhcyBoaWRkZW4uXG4vLyBUaGVzZSBkaWZmZXJlbmNlcyBpbXByb3ZlIHRoZSBiZWhhdmlvciBvZiAudG9nZ2xlKCkgZXQgYWwuIHdoZW4gYXBwbGllZCB0byBlbGVtZW50cyB0aGF0IGFyZVxuLy8gZGV0YWNoZWQgb3IgY29udGFpbmVkIHdpdGhpbiBoaWRkZW4gYW5jZXN0b3JzIChnaC0yNDA0LCBnaC0yODYzKS5cbmZ1bmN0aW9uIGlzSGlkZGVuV2l0aGluVHJlZSggZWxlbSwgZWwgKSB7XG5cblx0Ly8gaXNIaWRkZW5XaXRoaW5UcmVlIG1pZ2h0IGJlIGNhbGxlZCBmcm9tIGpRdWVyeSNmaWx0ZXIgZnVuY3Rpb247XG5cdC8vIGluIHRoYXQgY2FzZSwgZWxlbWVudCB3aWxsIGJlIHNlY29uZCBhcmd1bWVudFxuXHRlbGVtID0gZWwgfHwgZWxlbTtcblxuXHQvLyBJbmxpbmUgc3R5bGUgdHJ1bXBzIGFsbFxuXHRyZXR1cm4gZWxlbS5zdHlsZS5kaXNwbGF5ID09PSBcIm5vbmVcIiB8fFxuXHRcdGVsZW0uc3R5bGUuZGlzcGxheSA9PT0gXCJcIiAmJlxuXHRcdGpRdWVyeS5jc3MoIGVsZW0sIFwiZGlzcGxheVwiICkgPT09IFwibm9uZVwiO1xufVxuXG52YXIgcmFscGhhU3RhcnQgPSAvXlthLXpdLyxcblxuXHQvLyBUaGUgcmVnZXggdmlzdWFsaXplZDpcblx0Ly9cblx0Ly8gICAgICAgICAgICAgICAgICAgICAgICAgLy0tLS0tLS0tLS1cXFxuXHQvLyAgICAgICAgICAgICAgICAgICAgICAgIHwgICAgICAgICAgICB8ICAgIC8tLS0tLS0tXFxcblx0Ly8gICAgICAgICAgICAgICAgICAgICAgICB8ICAvIFRvcCAgXFwgIHwgICB8ICAgICAgICAgfFxuXHQvLyAgICAgICAgIC8tLS0gQm9yZGVyIC0tLSstfCBSaWdodCAgfC0rLS0tKy0gV2lkdGggLSstLS1cXFxuXHQvLyAgICAgICAgfCAgICAgICAgICAgICAgICAgfCBCb3R0b20gfCAgICAgICAgICAgICAgICAgICAgfFxuXHQvLyAgICAgICAgfCAgICAgICAgICAgICAgICAgIFxcIExlZnQgLyAgICAgICAgICAgICAgICAgICAgIHxcblx0Ly8gICAgICAgIHwgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHxcblx0Ly8gICAgICAgIHwgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAvLS0tLS0tLS0tLVxcICAgICB8XG5cdC8vICAgICAgICB8ICAgICAgICAgIC8tLS0tLS0tLS0tLS0tXFwgICAgfCAgICAgICAgICAgIHwgICAgfC0gRU5EXG5cdC8vICAgICAgICB8ICAgICAgICAgfCAgICAgICAgICAgICAgIHwgICB8ICAvIFRvcCAgXFwgIHwgICAgfFxuXHQvLyAgICAgICAgfCAgICAgICAgIHwgIC8gTWFyZ2luICBcXCAgfCAgIHwgfCBSaWdodCAgfCB8ICAgIHxcblx0Ly8gICAgICAgIHwtLS0tLS0tLS0rLXwgICAgICAgICAgIHwtKy0tLSstfCBCb3R0b20gfC0rLS0tLXxcblx0Ly8gICAgICAgIHwgICAgICAgICAgICBcXCBQYWRkaW5nIC8gICAgICAgICBcXCBMZWZ0IC8gICAgICAgfFxuXHQvLyBCRUdJTiAtfCAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfFxuXHQvLyAgICAgICAgfCAgICAgICAgICAgICAgICAvLS0tLS0tLS0tXFwgICAgICAgICAgICAgICAgICAgIHxcblx0Ly8gICAgICAgIHwgICAgICAgICAgICAgICB8ICAgICAgICAgICB8ICAgICAgICAgICAgICAgICAgIHxcblx0Ly8gICAgICAgIHwgICAgICAgICAgICAgICB8ICAvIE1pbiBcXCAgfCAgICAvIFdpZHRoICBcXCAgICAgfFxuXHQvLyAgICAgICAgIFxcLS0tLS0tLS0tLS0tLS0rLXwgICAgICAgfC0rLS0tfCAgICAgICAgICB8LS0tL1xuXHQvLyAgICAgICAgICAgICAgICAgICAgICAgICAgIFxcIE1heCAvICAgICAgIFxcIEhlaWdodCAvXG5cdHJhdXRvUHggPSAvXig/OkJvcmRlcig/OlRvcHxSaWdodHxCb3R0b218TGVmdCk/KD86V2lkdGh8KXwoPzpNYXJnaW58UGFkZGluZyk/KD86VG9wfFJpZ2h0fEJvdHRvbXxMZWZ0KT98KD86TWlufE1heCk/KD86V2lkdGh8SGVpZ2h0KSkkLztcblxuZnVuY3Rpb24gaXNBdXRvUHgoIHByb3AgKSB7XG5cblx0Ly8gVGhlIGZpcnN0IHRlc3QgaXMgdXNlZCB0byBlbnN1cmUgdGhhdDpcblx0Ly8gMS4gVGhlIHByb3Agc3RhcnRzIHdpdGggYSBsb3dlcmNhc2UgbGV0dGVyIChhcyB3ZSB1cHBlcmNhc2UgaXQgZm9yIHRoZSBzZWNvbmQgcmVnZXgpLlxuXHQvLyAyLiBUaGUgcHJvcCBpcyBub3QgZW1wdHkuXG5cdHJldHVybiByYWxwaGFTdGFydC50ZXN0KCBwcm9wICkgJiZcblx0XHRyYXV0b1B4LnRlc3QoIHByb3BbIDAgXS50b1VwcGVyQ2FzZSgpICsgcHJvcC5zbGljZSggMSApICk7XG59XG5cbmZ1bmN0aW9uIGFkanVzdENTUyggZWxlbSwgcHJvcCwgdmFsdWVQYXJ0cywgdHdlZW4gKSB7XG5cdHZhciBhZGp1c3RlZCwgc2NhbGUsXG5cdFx0bWF4SXRlcmF0aW9ucyA9IDIwLFxuXHRcdGN1cnJlbnRWYWx1ZSA9IHR3ZWVuID9cblx0XHRcdGZ1bmN0aW9uKCkge1xuXHRcdFx0XHRyZXR1cm4gdHdlZW4uY3VyKCk7XG5cdFx0XHR9IDpcblx0XHRcdGZ1bmN0aW9uKCkge1xuXHRcdFx0XHRyZXR1cm4galF1ZXJ5LmNzcyggZWxlbSwgcHJvcCwgXCJcIiApO1xuXHRcdFx0fSxcblx0XHRpbml0aWFsID0gY3VycmVudFZhbHVlKCksXG5cdFx0dW5pdCA9IHZhbHVlUGFydHMgJiYgdmFsdWVQYXJ0c1sgMyBdIHx8ICggaXNBdXRvUHgoIHByb3AgKSA/IFwicHhcIiA6IFwiXCIgKSxcblxuXHRcdC8vIFN0YXJ0aW5nIHZhbHVlIGNvbXB1dGF0aW9uIGlzIHJlcXVpcmVkIGZvciBwb3RlbnRpYWwgdW5pdCBtaXNtYXRjaGVzXG5cdFx0aW5pdGlhbEluVW5pdCA9IGVsZW0ubm9kZVR5cGUgJiZcblx0XHRcdCggIWlzQXV0b1B4KCBwcm9wICkgfHwgdW5pdCAhPT0gXCJweFwiICYmICtpbml0aWFsICkgJiZcblx0XHRcdHJjc3NOdW0uZXhlYyggalF1ZXJ5LmNzcyggZWxlbSwgcHJvcCApICk7XG5cblx0aWYgKCBpbml0aWFsSW5Vbml0ICYmIGluaXRpYWxJblVuaXRbIDMgXSAhPT0gdW5pdCApIHtcblxuXHRcdC8vIFN1cHBvcnQ6IEZpcmVmb3ggPD01NCAtIDY2K1xuXHRcdC8vIEhhbHZlIHRoZSBpdGVyYXRpb24gdGFyZ2V0IHZhbHVlIHRvIHByZXZlbnQgaW50ZXJmZXJlbmNlIGZyb20gQ1NTIHVwcGVyIGJvdW5kcyAoZ2gtMjE0NClcblx0XHRpbml0aWFsID0gaW5pdGlhbCAvIDI7XG5cblx0XHQvLyBUcnVzdCB1bml0cyByZXBvcnRlZCBieSBqUXVlcnkuY3NzXG5cdFx0dW5pdCA9IHVuaXQgfHwgaW5pdGlhbEluVW5pdFsgMyBdO1xuXG5cdFx0Ly8gSXRlcmF0aXZlbHkgYXBwcm94aW1hdGUgZnJvbSBhIG5vbnplcm8gc3RhcnRpbmcgcG9pbnRcblx0XHRpbml0aWFsSW5Vbml0ID0gK2luaXRpYWwgfHwgMTtcblxuXHRcdHdoaWxlICggbWF4SXRlcmF0aW9ucy0tICkge1xuXG5cdFx0XHQvLyBFdmFsdWF0ZSBhbmQgdXBkYXRlIG91ciBiZXN0IGd1ZXNzIChkb3VibGluZyBndWVzc2VzIHRoYXQgemVybyBvdXQpLlxuXHRcdFx0Ly8gRmluaXNoIGlmIHRoZSBzY2FsZSBlcXVhbHMgb3IgY3Jvc3NlcyAxIChtYWtpbmcgdGhlIG9sZCpuZXcgcHJvZHVjdCBub24tcG9zaXRpdmUpLlxuXHRcdFx0alF1ZXJ5LnN0eWxlKCBlbGVtLCBwcm9wLCBpbml0aWFsSW5Vbml0ICsgdW5pdCApO1xuXHRcdFx0aWYgKCAoIDEgLSBzY2FsZSApICogKCAxIC0gKCBzY2FsZSA9IGN1cnJlbnRWYWx1ZSgpIC8gaW5pdGlhbCB8fCAwLjUgKSApIDw9IDAgKSB7XG5cdFx0XHRcdG1heEl0ZXJhdGlvbnMgPSAwO1xuXHRcdFx0fVxuXHRcdFx0aW5pdGlhbEluVW5pdCA9IGluaXRpYWxJblVuaXQgLyBzY2FsZTtcblxuXHRcdH1cblxuXHRcdGluaXRpYWxJblVuaXQgPSBpbml0aWFsSW5Vbml0ICogMjtcblx0XHRqUXVlcnkuc3R5bGUoIGVsZW0sIHByb3AsIGluaXRpYWxJblVuaXQgKyB1bml0ICk7XG5cblx0XHQvLyBNYWtlIHN1cmUgd2UgdXBkYXRlIHRoZSB0d2VlbiBwcm9wZXJ0aWVzIGxhdGVyIG9uXG5cdFx0dmFsdWVQYXJ0cyA9IHZhbHVlUGFydHMgfHwgW107XG5cdH1cblxuXHRpZiAoIHZhbHVlUGFydHMgKSB7XG5cdFx0aW5pdGlhbEluVW5pdCA9ICtpbml0aWFsSW5Vbml0IHx8ICtpbml0aWFsIHx8IDA7XG5cblx0XHQvLyBBcHBseSByZWxhdGl2ZSBvZmZzZXQgKCs9Ly09KSBpZiBzcGVjaWZpZWRcblx0XHRhZGp1c3RlZCA9IHZhbHVlUGFydHNbIDEgXSA/XG5cdFx0XHRpbml0aWFsSW5Vbml0ICsgKCB2YWx1ZVBhcnRzWyAxIF0gKyAxICkgKiB2YWx1ZVBhcnRzWyAyIF0gOlxuXHRcdFx0K3ZhbHVlUGFydHNbIDIgXTtcblx0XHRpZiAoIHR3ZWVuICkge1xuXHRcdFx0dHdlZW4udW5pdCA9IHVuaXQ7XG5cdFx0XHR0d2Vlbi5zdGFydCA9IGluaXRpYWxJblVuaXQ7XG5cdFx0XHR0d2Vlbi5lbmQgPSBhZGp1c3RlZDtcblx0XHR9XG5cdH1cblx0cmV0dXJuIGFkanVzdGVkO1xufVxuXG4vLyBNYXRjaGVzIGRhc2hlZCBzdHJpbmcgZm9yIGNhbWVsaXppbmdcbnZhciBybXNQcmVmaXggPSAvXi1tcy0vO1xuXG4vLyBDb252ZXJ0IGRhc2hlZCB0byBjYW1lbENhc2UsIGhhbmRsZSB2ZW5kb3IgcHJlZml4ZXMuXG4vLyBVc2VkIGJ5IHRoZSBjc3MgJiBlZmZlY3RzIG1vZHVsZXMuXG4vLyBTdXBwb3J0OiBJRSA8PTkgLSAxMStcbi8vIE1pY3Jvc29mdCBmb3Jnb3QgdG8gaHVtcCB0aGVpciB2ZW5kb3IgcHJlZml4ICh0cmFjLTk1NzIpXG5mdW5jdGlvbiBjc3NDYW1lbENhc2UoIHN0cmluZyApIHtcblx0cmV0dXJuIGNhbWVsQ2FzZSggc3RyaW5nLnJlcGxhY2UoIHJtc1ByZWZpeCwgXCJtcy1cIiApICk7XG59XG5cbnZhciBkZWZhdWx0RGlzcGxheU1hcCA9IHt9O1xuXG5mdW5jdGlvbiBnZXREZWZhdWx0RGlzcGxheSggZWxlbSApIHtcblx0dmFyIHRlbXAsXG5cdFx0ZG9jID0gZWxlbS5vd25lckRvY3VtZW50LFxuXHRcdG5vZGVOYW1lID0gZWxlbS5ub2RlTmFtZSxcblx0XHRkaXNwbGF5ID0gZGVmYXVsdERpc3BsYXlNYXBbIG5vZGVOYW1lIF07XG5cblx0aWYgKCBkaXNwbGF5ICkge1xuXHRcdHJldHVybiBkaXNwbGF5O1xuXHR9XG5cblx0dGVtcCA9IGRvYy5ib2R5LmFwcGVuZENoaWxkKCBkb2MuY3JlYXRlRWxlbWVudCggbm9kZU5hbWUgKSApO1xuXHRkaXNwbGF5ID0galF1ZXJ5LmNzcyggdGVtcCwgXCJkaXNwbGF5XCIgKTtcblxuXHR0ZW1wLnBhcmVudE5vZGUucmVtb3ZlQ2hpbGQoIHRlbXAgKTtcblxuXHRpZiAoIGRpc3BsYXkgPT09IFwibm9uZVwiICkge1xuXHRcdGRpc3BsYXkgPSBcImJsb2NrXCI7XG5cdH1cblx0ZGVmYXVsdERpc3BsYXlNYXBbIG5vZGVOYW1lIF0gPSBkaXNwbGF5O1xuXG5cdHJldHVybiBkaXNwbGF5O1xufVxuXG5mdW5jdGlvbiBzaG93SGlkZSggZWxlbWVudHMsIHNob3cgKSB7XG5cdHZhciBkaXNwbGF5LCBlbGVtLFxuXHRcdHZhbHVlcyA9IFtdLFxuXHRcdGluZGV4ID0gMCxcblx0XHRsZW5ndGggPSBlbGVtZW50cy5sZW5ndGg7XG5cblx0Ly8gRGV0ZXJtaW5lIG5ldyBkaXNwbGF5IHZhbHVlIGZvciBlbGVtZW50cyB0aGF0IG5lZWQgdG8gY2hhbmdlXG5cdGZvciAoIDsgaW5kZXggPCBsZW5ndGg7IGluZGV4KysgKSB7XG5cdFx0ZWxlbSA9IGVsZW1lbnRzWyBpbmRleCBdO1xuXHRcdGlmICggIWVsZW0uc3R5bGUgKSB7XG5cdFx0XHRjb250aW51ZTtcblx0XHR9XG5cblx0XHRkaXNwbGF5ID0gZWxlbS5zdHlsZS5kaXNwbGF5O1xuXHRcdGlmICggc2hvdyApIHtcblxuXHRcdFx0Ly8gU2luY2Ugd2UgZm9yY2UgdmlzaWJpbGl0eSB1cG9uIGNhc2NhZGUtaGlkZGVuIGVsZW1lbnRzLCBhbiBpbW1lZGlhdGUgKGFuZCBzbG93KVxuXHRcdFx0Ly8gY2hlY2sgaXMgcmVxdWlyZWQgaW4gdGhpcyBmaXJzdCBsb29wIHVubGVzcyB3ZSBoYXZlIGEgbm9uZW1wdHkgZGlzcGxheSB2YWx1ZSAoZWl0aGVyXG5cdFx0XHQvLyBpbmxpbmUgb3IgYWJvdXQtdG8tYmUtcmVzdG9yZWQpXG5cdFx0XHRpZiAoIGRpc3BsYXkgPT09IFwibm9uZVwiICkge1xuXHRcdFx0XHR2YWx1ZXNbIGluZGV4IF0gPSBkYXRhUHJpdi5nZXQoIGVsZW0sIFwiZGlzcGxheVwiICkgfHwgbnVsbDtcblx0XHRcdFx0aWYgKCAhdmFsdWVzWyBpbmRleCBdICkge1xuXHRcdFx0XHRcdGVsZW0uc3R5bGUuZGlzcGxheSA9IFwiXCI7XG5cdFx0XHRcdH1cblx0XHRcdH1cblx0XHRcdGlmICggZWxlbS5zdHlsZS5kaXNwbGF5ID09PSBcIlwiICYmIGlzSGlkZGVuV2l0aGluVHJlZSggZWxlbSApICkge1xuXHRcdFx0XHR2YWx1ZXNbIGluZGV4IF0gPSBnZXREZWZhdWx0RGlzcGxheSggZWxlbSApO1xuXHRcdFx0fVxuXHRcdH0gZWxzZSB7XG5cdFx0XHRpZiAoIGRpc3BsYXkgIT09IFwibm9uZVwiICkge1xuXHRcdFx0XHR2YWx1ZXNbIGluZGV4IF0gPSBcIm5vbmVcIjtcblxuXHRcdFx0XHQvLyBSZW1lbWJlciB3aGF0IHdlJ3JlIG92ZXJ3cml0aW5nXG5cdFx0XHRcdGRhdGFQcml2LnNldCggZWxlbSwgXCJkaXNwbGF5XCIsIGRpc3BsYXkgKTtcblx0XHRcdH1cblx0XHR9XG5cdH1cblxuXHQvLyBTZXQgdGhlIGRpc3BsYXkgb2YgdGhlIGVsZW1lbnRzIGluIGEgc2Vjb25kIGxvb3AgdG8gYXZvaWQgY29uc3RhbnQgcmVmbG93XG5cdGZvciAoIGluZGV4ID0gMDsgaW5kZXggPCBsZW5ndGg7IGluZGV4KysgKSB7XG5cdFx0aWYgKCB2YWx1ZXNbIGluZGV4IF0gIT0gbnVsbCApIHtcblx0XHRcdGVsZW1lbnRzWyBpbmRleCBdLnN0eWxlLmRpc3BsYXkgPSB2YWx1ZXNbIGluZGV4IF07XG5cdFx0fVxuXHR9XG5cblx0cmV0dXJuIGVsZW1lbnRzO1xufVxuXG5qUXVlcnkuZm4uZXh0ZW5kKCB7XG5cdHNob3c6IGZ1bmN0aW9uKCkge1xuXHRcdHJldHVybiBzaG93SGlkZSggdGhpcywgdHJ1ZSApO1xuXHR9LFxuXHRoaWRlOiBmdW5jdGlvbigpIHtcblx0XHRyZXR1cm4gc2hvd0hpZGUoIHRoaXMgKTtcblx0fSxcblx0dG9nZ2xlOiBmdW5jdGlvbiggc3RhdGUgKSB7XG5cdFx0aWYgKCB0eXBlb2Ygc3RhdGUgPT09IFwiYm9vbGVhblwiICkge1xuXHRcdFx0cmV0dXJuIHN0YXRlID8gdGhpcy5zaG93KCkgOiB0aGlzLmhpZGUoKTtcblx0XHR9XG5cblx0XHRyZXR1cm4gdGhpcy5lYWNoKCBmdW5jdGlvbigpIHtcblx0XHRcdGlmICggaXNIaWRkZW5XaXRoaW5UcmVlKCB0aGlzICkgKSB7XG5cdFx0XHRcdGpRdWVyeSggdGhpcyApLnNob3coKTtcblx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdGpRdWVyeSggdGhpcyApLmhpZGUoKTtcblx0XHRcdH1cblx0XHR9ICk7XG5cdH1cbn0gKTtcblxudmFyIGlzQXR0YWNoZWQgPSBmdW5jdGlvbiggZWxlbSApIHtcblx0XHRyZXR1cm4galF1ZXJ5LmNvbnRhaW5zKCBlbGVtLm93bmVyRG9jdW1lbnQsIGVsZW0gKSB8fFxuXHRcdFx0ZWxlbS5nZXRSb290Tm9kZSggY29tcG9zZWQgKSA9PT0gZWxlbS5vd25lckRvY3VtZW50O1xuXHR9LFxuXHRjb21wb3NlZCA9IHsgY29tcG9zZWQ6IHRydWUgfTtcblxuLy8gU3VwcG9ydDogSUUgOSAtIDExK1xuLy8gQ2hlY2sgYXR0YWNobWVudCBhY3Jvc3Mgc2hhZG93IERPTSBib3VuZGFyaWVzIHdoZW4gcG9zc2libGUgKGdoLTM1MDQpLlxuLy8gUHJvdmlkZSBhIGZhbGxiYWNrIGZvciBicm93c2VycyB3aXRob3V0IFNoYWRvdyBET00gdjEgc3VwcG9ydC5cbmlmICggIWRvY3VtZW50RWxlbWVudCQxLmdldFJvb3ROb2RlICkge1xuXHRpc0F0dGFjaGVkID0gZnVuY3Rpb24oIGVsZW0gKSB7XG5cdFx0cmV0dXJuIGpRdWVyeS5jb250YWlucyggZWxlbS5vd25lckRvY3VtZW50LCBlbGVtICk7XG5cdH07XG59XG5cbi8vIHJ0YWdOYW1lIGNhcHR1cmVzIHRoZSBuYW1lIGZyb20gdGhlIGZpcnN0IHN0YXJ0IHRhZyBpbiBhIHN0cmluZyBvZiBIVE1MXG4vLyBodHRwczovL2h0bWwuc3BlYy53aGF0d2cub3JnL211bHRpcGFnZS9zeW50YXguaHRtbCN0YWctb3Blbi1zdGF0ZVxuLy8gaHR0cHM6Ly9odG1sLnNwZWMud2hhdHdnLm9yZy9tdWx0aXBhZ2Uvc3ludGF4Lmh0bWwjdGFnLW5hbWUtc3RhdGVcbnZhciBydGFnTmFtZSA9IC88KFthLXpdW15cXC9cXDA+XFx4MjBcXHRcXHJcXG5cXGZdKikvaTtcblxudmFyIHdyYXBNYXAgPSB7XG5cblx0Ly8gVGFibGUgcGFydHMgbmVlZCB0byBiZSB3cmFwcGVkIHdpdGggYDx0YWJsZT5gIG9yIHRoZXkncmVcblx0Ly8gc3RyaXBwZWQgdG8gdGhlaXIgY29udGVudHMgd2hlbiBwdXQgaW4gYSBkaXYuXG5cdC8vIFhIVE1MIHBhcnNlcnMgZG8gbm90IG1hZ2ljYWxseSBpbnNlcnQgZWxlbWVudHMgaW4gdGhlXG5cdC8vIHNhbWUgd2F5IHRoYXQgdGFnIHNvdXAgcGFyc2VycyBkbywgc28gd2UgY2Fubm90IHNob3J0ZW5cblx0Ly8gdGhpcyBieSBvbWl0dGluZyA8dGJvZHk+IG9yIG90aGVyIHJlcXVpcmVkIGVsZW1lbnRzLlxuXHR0aGVhZDogWyBcInRhYmxlXCIgXSxcblx0Y29sOiBbIFwiY29sZ3JvdXBcIiwgXCJ0YWJsZVwiIF0sXG5cdHRyOiBbIFwidGJvZHlcIiwgXCJ0YWJsZVwiIF0sXG5cdHRkOiBbIFwidHJcIiwgXCJ0Ym9keVwiLCBcInRhYmxlXCIgXVxufTtcblxud3JhcE1hcC50Ym9keSA9IHdyYXBNYXAudGZvb3QgPSB3cmFwTWFwLmNvbGdyb3VwID0gd3JhcE1hcC5jYXB0aW9uID0gd3JhcE1hcC50aGVhZDtcbndyYXBNYXAudGggPSB3cmFwTWFwLnRkO1xuXG5mdW5jdGlvbiBnZXRBbGwoIGNvbnRleHQsIHRhZyApIHtcblxuXHQvLyBTdXBwb3J0OiBJRSA8PTkgLSAxMStcblx0Ly8gVXNlIHR5cGVvZiB0byBhdm9pZCB6ZXJvLWFyZ3VtZW50IG1ldGhvZCBpbnZvY2F0aW9uIG9uIGhvc3Qgb2JqZWN0cyAodHJhYy0xNTE1MSlcblx0dmFyIHJldDtcblxuXHRpZiAoIHR5cGVvZiBjb250ZXh0LmdldEVsZW1lbnRzQnlUYWdOYW1lICE9PSBcInVuZGVmaW5lZFwiICkge1xuXG5cdFx0Ly8gVXNlIHNsaWNlIHRvIHNuYXBzaG90IHRoZSBsaXZlIGNvbGxlY3Rpb24gZnJvbSBnRUJUTlxuXHRcdHJldCA9IGFyci5zbGljZS5jYWxsKCBjb250ZXh0LmdldEVsZW1lbnRzQnlUYWdOYW1lKCB0YWcgfHwgXCIqXCIgKSApO1xuXG5cdH0gZWxzZSBpZiAoIHR5cGVvZiBjb250ZXh0LnF1ZXJ5U2VsZWN0b3JBbGwgIT09IFwidW5kZWZpbmVkXCIgKSB7XG5cdFx0cmV0ID0gY29udGV4dC5xdWVyeVNlbGVjdG9yQWxsKCB0YWcgfHwgXCIqXCIgKTtcblxuXHR9IGVsc2Uge1xuXHRcdHJldCA9IFtdO1xuXHR9XG5cblx0aWYgKCB0YWcgPT09IHVuZGVmaW5lZCB8fCB0YWcgJiYgbm9kZU5hbWUoIGNvbnRleHQsIHRhZyApICkge1xuXHRcdHJldHVybiBqUXVlcnkubWVyZ2UoIFsgY29udGV4dCBdLCByZXQgKTtcblx0fVxuXG5cdHJldHVybiByZXQ7XG59XG5cbnZhciByc2NyaXB0VHlwZSA9IC9eJHxebW9kdWxlJHxcXC8oPzpqYXZhfGVjbWEpc2NyaXB0L2k7XG5cbi8vIE1hcmsgc2NyaXB0cyBhcyBoYXZpbmcgYWxyZWFkeSBiZWVuIGV2YWx1YXRlZFxuZnVuY3Rpb24gc2V0R2xvYmFsRXZhbCggZWxlbXMsIHJlZkVsZW1lbnRzICkge1xuXHR2YXIgaSA9IDAsXG5cdFx0bCA9IGVsZW1zLmxlbmd0aDtcblxuXHRmb3IgKCA7IGkgPCBsOyBpKysgKSB7XG5cdFx0ZGF0YVByaXYuc2V0KFxuXHRcdFx0ZWxlbXNbIGkgXSxcblx0XHRcdFwiZ2xvYmFsRXZhbFwiLFxuXHRcdFx0IXJlZkVsZW1lbnRzIHx8IGRhdGFQcml2LmdldCggcmVmRWxlbWVudHNbIGkgXSwgXCJnbG9iYWxFdmFsXCIgKVxuXHRcdCk7XG5cdH1cbn1cblxudmFyIHJodG1sID0gLzx8JiM/XFx3KzsvO1xuXG5mdW5jdGlvbiBidWlsZEZyYWdtZW50KCBlbGVtcywgY29udGV4dCwgc2NyaXB0cywgc2VsZWN0aW9uLCBpZ25vcmVkICkge1xuXHR2YXIgZWxlbSwgdG1wLCB0YWcsIHdyYXAsIGF0dGFjaGVkLCBqLFxuXHRcdGZyYWdtZW50ID0gY29udGV4dC5jcmVhdGVEb2N1bWVudEZyYWdtZW50KCksXG5cdFx0bm9kZXMgPSBbXSxcblx0XHRpID0gMCxcblx0XHRsID0gZWxlbXMubGVuZ3RoO1xuXG5cdGZvciAoIDsgaSA8IGw7IGkrKyApIHtcblx0XHRlbGVtID0gZWxlbXNbIGkgXTtcblxuXHRcdGlmICggZWxlbSB8fCBlbGVtID09PSAwICkge1xuXG5cdFx0XHQvLyBBZGQgbm9kZXMgZGlyZWN0bHlcblx0XHRcdGlmICggdG9UeXBlKCBlbGVtICkgPT09IFwib2JqZWN0XCIgJiYgKCBlbGVtLm5vZGVUeXBlIHx8IGlzQXJyYXlMaWtlKCBlbGVtICkgKSApIHtcblx0XHRcdFx0alF1ZXJ5Lm1lcmdlKCBub2RlcywgZWxlbS5ub2RlVHlwZSA/IFsgZWxlbSBdIDogZWxlbSApO1xuXG5cdFx0XHQvLyBDb252ZXJ0IG5vbi1odG1sIGludG8gYSB0ZXh0IG5vZGVcblx0XHRcdH0gZWxzZSBpZiAoICFyaHRtbC50ZXN0KCBlbGVtICkgKSB7XG5cdFx0XHRcdG5vZGVzLnB1c2goIGNvbnRleHQuY3JlYXRlVGV4dE5vZGUoIGVsZW0gKSApO1xuXG5cdFx0XHQvLyBDb252ZXJ0IGh0bWwgaW50byBET00gbm9kZXNcblx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdHRtcCA9IHRtcCB8fCBmcmFnbWVudC5hcHBlbmRDaGlsZCggY29udGV4dC5jcmVhdGVFbGVtZW50KCBcImRpdlwiICkgKTtcblxuXHRcdFx0XHQvLyBEZXNlcmlhbGl6ZSBhIHN0YW5kYXJkIHJlcHJlc2VudGF0aW9uXG5cdFx0XHRcdHRhZyA9ICggcnRhZ05hbWUuZXhlYyggZWxlbSApIHx8IFsgXCJcIiwgXCJcIiBdIClbIDEgXS50b0xvd2VyQ2FzZSgpO1xuXHRcdFx0XHR3cmFwID0gd3JhcE1hcFsgdGFnIF0gfHwgYXJyO1xuXG5cdFx0XHRcdC8vIENyZWF0ZSB3cmFwcGVycyAmIGRlc2NlbmQgaW50byB0aGVtLlxuXHRcdFx0XHRqID0gd3JhcC5sZW5ndGg7XG5cdFx0XHRcdHdoaWxlICggLS1qID4gLTEgKSB7XG5cdFx0XHRcdFx0dG1wID0gdG1wLmFwcGVuZENoaWxkKCBjb250ZXh0LmNyZWF0ZUVsZW1lbnQoIHdyYXBbIGogXSApICk7XG5cdFx0XHRcdH1cblxuXHRcdFx0XHR0bXAuaW5uZXJIVE1MID0galF1ZXJ5Lmh0bWxQcmVmaWx0ZXIoIGVsZW0gKTtcblxuXHRcdFx0XHRqUXVlcnkubWVyZ2UoIG5vZGVzLCB0bXAuY2hpbGROb2RlcyApO1xuXG5cdFx0XHRcdC8vIFJlbWVtYmVyIHRoZSB0b3AtbGV2ZWwgY29udGFpbmVyXG5cdFx0XHRcdHRtcCA9IGZyYWdtZW50LmZpcnN0Q2hpbGQ7XG5cblx0XHRcdFx0Ly8gRW5zdXJlIHRoZSBjcmVhdGVkIG5vZGVzIGFyZSBvcnBoYW5lZCAodHJhYy0xMjM5Milcblx0XHRcdFx0dG1wLnRleHRDb250ZW50ID0gXCJcIjtcblx0XHRcdH1cblx0XHR9XG5cdH1cblxuXHQvLyBSZW1vdmUgd3JhcHBlciBmcm9tIGZyYWdtZW50XG5cdGZyYWdtZW50LnRleHRDb250ZW50ID0gXCJcIjtcblxuXHRpID0gMDtcblx0d2hpbGUgKCAoIGVsZW0gPSBub2Rlc1sgaSsrIF0gKSApIHtcblxuXHRcdC8vIFNraXAgZWxlbWVudHMgYWxyZWFkeSBpbiB0aGUgY29udGV4dCBjb2xsZWN0aW9uICh0cmFjLTQwODcpXG5cdFx0aWYgKCBzZWxlY3Rpb24gJiYgalF1ZXJ5LmluQXJyYXkoIGVsZW0sIHNlbGVjdGlvbiApID4gLTEgKSB7XG5cdFx0XHRpZiAoIGlnbm9yZWQgKSB7XG5cdFx0XHRcdGlnbm9yZWQucHVzaCggZWxlbSApO1xuXHRcdFx0fVxuXHRcdFx0Y29udGludWU7XG5cdFx0fVxuXG5cdFx0YXR0YWNoZWQgPSBpc0F0dGFjaGVkKCBlbGVtICk7XG5cblx0XHQvLyBBcHBlbmQgdG8gZnJhZ21lbnRcblx0XHR0bXAgPSBnZXRBbGwoIGZyYWdtZW50LmFwcGVuZENoaWxkKCBlbGVtICksIFwic2NyaXB0XCIgKTtcblxuXHRcdC8vIFByZXNlcnZlIHNjcmlwdCBldmFsdWF0aW9uIGhpc3Rvcnlcblx0XHRpZiAoIGF0dGFjaGVkICkge1xuXHRcdFx0c2V0R2xvYmFsRXZhbCggdG1wICk7XG5cdFx0fVxuXG5cdFx0Ly8gQ2FwdHVyZSBleGVjdXRhYmxlc1xuXHRcdGlmICggc2NyaXB0cyApIHtcblx0XHRcdGogPSAwO1xuXHRcdFx0d2hpbGUgKCAoIGVsZW0gPSB0bXBbIGorKyBdICkgKSB7XG5cdFx0XHRcdGlmICggcnNjcmlwdFR5cGUudGVzdCggZWxlbS50eXBlIHx8IFwiXCIgKSApIHtcblx0XHRcdFx0XHRzY3JpcHRzLnB1c2goIGVsZW0gKTtcblx0XHRcdFx0fVxuXHRcdFx0fVxuXHRcdH1cblx0fVxuXG5cdHJldHVybiBmcmFnbWVudDtcbn1cblxuLy8gUmVwbGFjZS9yZXN0b3JlIHRoZSB0eXBlIGF0dHJpYnV0ZSBvZiBzY3JpcHQgZWxlbWVudHMgZm9yIHNhZmUgRE9NIG1hbmlwdWxhdGlvblxuZnVuY3Rpb24gZGlzYWJsZVNjcmlwdCggZWxlbSApIHtcblx0ZWxlbS50eXBlID0gKCBlbGVtLmdldEF0dHJpYnV0ZSggXCJ0eXBlXCIgKSAhPT0gbnVsbCApICsgXCIvXCIgKyBlbGVtLnR5cGU7XG5cdHJldHVybiBlbGVtO1xufVxuZnVuY3Rpb24gcmVzdG9yZVNjcmlwdCggZWxlbSApIHtcblx0aWYgKCAoIGVsZW0udHlwZSB8fCBcIlwiICkuc2xpY2UoIDAsIDUgKSA9PT0gXCJ0cnVlL1wiICkge1xuXHRcdGVsZW0udHlwZSA9IGVsZW0udHlwZS5zbGljZSggNSApO1xuXHR9IGVsc2Uge1xuXHRcdGVsZW0ucmVtb3ZlQXR0cmlidXRlKCBcInR5cGVcIiApO1xuXHR9XG5cblx0cmV0dXJuIGVsZW07XG59XG5cbmZ1bmN0aW9uIGRvbU1hbmlwKCBjb2xsZWN0aW9uLCBhcmdzLCBjYWxsYmFjaywgaWdub3JlZCApIHtcblxuXHQvLyBGbGF0dGVuIGFueSBuZXN0ZWQgYXJyYXlzXG5cdGFyZ3MgPSBmbGF0KCBhcmdzICk7XG5cblx0dmFyIGZyYWdtZW50LCBmaXJzdCwgc2NyaXB0cywgaGFzU2NyaXB0cywgbm9kZSwgZG9jLFxuXHRcdGkgPSAwLFxuXHRcdGwgPSBjb2xsZWN0aW9uLmxlbmd0aCxcblx0XHRpTm9DbG9uZSA9IGwgLSAxLFxuXHRcdHZhbHVlID0gYXJnc1sgMCBdLFxuXHRcdHZhbHVlSXNGdW5jdGlvbiA9IHR5cGVvZiB2YWx1ZSA9PT0gXCJmdW5jdGlvblwiO1xuXG5cdGlmICggdmFsdWVJc0Z1bmN0aW9uICkge1xuXHRcdHJldHVybiBjb2xsZWN0aW9uLmVhY2goIGZ1bmN0aW9uKCBpbmRleCApIHtcblx0XHRcdHZhciBzZWxmID0gY29sbGVjdGlvbi5lcSggaW5kZXggKTtcblx0XHRcdGFyZ3NbIDAgXSA9IHZhbHVlLmNhbGwoIHRoaXMsIGluZGV4LCBzZWxmLmh0bWwoKSApO1xuXHRcdFx0ZG9tTWFuaXAoIHNlbGYsIGFyZ3MsIGNhbGxiYWNrLCBpZ25vcmVkICk7XG5cdFx0fSApO1xuXHR9XG5cblx0aWYgKCBsICkge1xuXHRcdGZyYWdtZW50ID0gYnVpbGRGcmFnbWVudCggYXJncywgY29sbGVjdGlvblsgMCBdLm93bmVyRG9jdW1lbnQsIGZhbHNlLCBjb2xsZWN0aW9uLCBpZ25vcmVkICk7XG5cdFx0Zmlyc3QgPSBmcmFnbWVudC5maXJzdENoaWxkO1xuXG5cdFx0aWYgKCBmcmFnbWVudC5jaGlsZE5vZGVzLmxlbmd0aCA9PT0gMSApIHtcblx0XHRcdGZyYWdtZW50ID0gZmlyc3Q7XG5cdFx0fVxuXG5cdFx0Ly8gUmVxdWlyZSBlaXRoZXIgbmV3IGNvbnRlbnQgb3IgYW4gaW50ZXJlc3QgaW4gaWdub3JlZCBlbGVtZW50cyB0byBpbnZva2UgdGhlIGNhbGxiYWNrXG5cdFx0aWYgKCBmaXJzdCB8fCBpZ25vcmVkICkge1xuXHRcdFx0c2NyaXB0cyA9IGpRdWVyeS5tYXAoIGdldEFsbCggZnJhZ21lbnQsIFwic2NyaXB0XCIgKSwgZGlzYWJsZVNjcmlwdCApO1xuXHRcdFx0aGFzU2NyaXB0cyA9IHNjcmlwdHMubGVuZ3RoO1xuXG5cdFx0XHQvLyBVc2UgdGhlIG9yaWdpbmFsIGZyYWdtZW50IGZvciB0aGUgbGFzdCBpdGVtXG5cdFx0XHQvLyBpbnN0ZWFkIG9mIHRoZSBmaXJzdCBiZWNhdXNlIGl0IGNhbiBlbmQgdXBcblx0XHRcdC8vIGJlaW5nIGVtcHRpZWQgaW5jb3JyZWN0bHkgaW4gY2VydGFpbiBzaXR1YXRpb25zICh0cmFjLTgwNzApLlxuXHRcdFx0Zm9yICggOyBpIDwgbDsgaSsrICkge1xuXHRcdFx0XHRub2RlID0gZnJhZ21lbnQ7XG5cblx0XHRcdFx0aWYgKCBpICE9PSBpTm9DbG9uZSApIHtcblx0XHRcdFx0XHRub2RlID0galF1ZXJ5LmNsb25lKCBub2RlLCB0cnVlLCB0cnVlICk7XG5cblx0XHRcdFx0XHQvLyBLZWVwIHJlZmVyZW5jZXMgdG8gY2xvbmVkIHNjcmlwdHMgZm9yIGxhdGVyIHJlc3RvcmF0aW9uXG5cdFx0XHRcdFx0aWYgKCBoYXNTY3JpcHRzICkge1xuXHRcdFx0XHRcdFx0alF1ZXJ5Lm1lcmdlKCBzY3JpcHRzLCBnZXRBbGwoIG5vZGUsIFwic2NyaXB0XCIgKSApO1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0fVxuXG5cdFx0XHRcdGNhbGxiYWNrLmNhbGwoIGNvbGxlY3Rpb25bIGkgXSwgbm9kZSwgaSApO1xuXHRcdFx0fVxuXG5cdFx0XHRpZiAoIGhhc1NjcmlwdHMgKSB7XG5cdFx0XHRcdGRvYyA9IHNjcmlwdHNbIHNjcmlwdHMubGVuZ3RoIC0gMSBdLm93bmVyRG9jdW1lbnQ7XG5cblx0XHRcdFx0Ly8gUmUtZW5hYmxlIHNjcmlwdHNcblx0XHRcdFx0alF1ZXJ5Lm1hcCggc2NyaXB0cywgcmVzdG9yZVNjcmlwdCApO1xuXG5cdFx0XHRcdC8vIEV2YWx1YXRlIGV4ZWN1dGFibGUgc2NyaXB0cyBvbiBmaXJzdCBkb2N1bWVudCBpbnNlcnRpb25cblx0XHRcdFx0Zm9yICggaSA9IDA7IGkgPCBoYXNTY3JpcHRzOyBpKysgKSB7XG5cdFx0XHRcdFx0bm9kZSA9IHNjcmlwdHNbIGkgXTtcblx0XHRcdFx0XHRpZiAoIHJzY3JpcHRUeXBlLnRlc3QoIG5vZGUudHlwZSB8fCBcIlwiICkgJiZcblx0XHRcdFx0XHRcdCFkYXRhUHJpdi5nZXQoIG5vZGUsIFwiZ2xvYmFsRXZhbFwiICkgJiZcblx0XHRcdFx0XHRcdGpRdWVyeS5jb250YWlucyggZG9jLCBub2RlICkgKSB7XG5cblx0XHRcdFx0XHRcdGlmICggbm9kZS5zcmMgJiYgKCBub2RlLnR5cGUgfHwgXCJcIiApLnRvTG93ZXJDYXNlKCkgICE9PSBcIm1vZHVsZVwiICkge1xuXG5cdFx0XHRcdFx0XHRcdC8vIE9wdGlvbmFsIEFKQVggZGVwZW5kZW5jeSwgYnV0IHdvbid0IHJ1biBzY3JpcHRzIGlmIG5vdCBwcmVzZW50XG5cdFx0XHRcdFx0XHRcdGlmICggalF1ZXJ5Ll9ldmFsVXJsICYmICFub2RlLm5vTW9kdWxlICkge1xuXHRcdFx0XHRcdFx0XHRcdGpRdWVyeS5fZXZhbFVybCggbm9kZS5zcmMsIHtcblx0XHRcdFx0XHRcdFx0XHRcdG5vbmNlOiBub2RlLm5vbmNlLFxuXHRcdFx0XHRcdFx0XHRcdFx0Y3Jvc3NPcmlnaW46IG5vZGUuY3Jvc3NPcmlnaW5cblx0XHRcdFx0XHRcdFx0XHR9LCBkb2MgKTtcblx0XHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHRcdFx0RE9NRXZhbCggbm9kZS50ZXh0Q29udGVudCwgbm9kZSwgZG9jICk7XG5cdFx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHR9XG5cdFx0XHR9XG5cdFx0fVxuXHR9XG5cblx0cmV0dXJuIGNvbGxlY3Rpb247XG59XG5cbnZhciByY2hlY2thYmxlVHlwZSA9IC9eKD86Y2hlY2tib3h8cmFkaW8pJC9pO1xuXG52YXIgcnR5cGVuYW1lc3BhY2UgPSAvXihbXi5dKikoPzpcXC4oLispfCkvO1xuXG5mdW5jdGlvbiByZXR1cm5UcnVlKCkge1xuXHRyZXR1cm4gdHJ1ZTtcbn1cblxuZnVuY3Rpb24gcmV0dXJuRmFsc2UoKSB7XG5cdHJldHVybiBmYWxzZTtcbn1cblxuZnVuY3Rpb24gb24oIGVsZW0sIHR5cGVzLCBzZWxlY3RvciwgZGF0YSwgZm4sIG9uZSApIHtcblx0dmFyIG9yaWdGbiwgdHlwZTtcblxuXHQvLyBUeXBlcyBjYW4gYmUgYSBtYXAgb2YgdHlwZXMvaGFuZGxlcnNcblx0aWYgKCB0eXBlb2YgdHlwZXMgPT09IFwib2JqZWN0XCIgKSB7XG5cblx0XHQvLyAoIHR5cGVzLU9iamVjdCwgc2VsZWN0b3IsIGRhdGEgKVxuXHRcdGlmICggdHlwZW9mIHNlbGVjdG9yICE9PSBcInN0cmluZ1wiICkge1xuXG5cdFx0XHQvLyAoIHR5cGVzLU9iamVjdCwgZGF0YSApXG5cdFx0XHRkYXRhID0gZGF0YSB8fCBzZWxlY3Rvcjtcblx0XHRcdHNlbGVjdG9yID0gdW5kZWZpbmVkO1xuXHRcdH1cblx0XHRmb3IgKCB0eXBlIGluIHR5cGVzICkge1xuXHRcdFx0b24oIGVsZW0sIHR5cGUsIHNlbGVjdG9yLCBkYXRhLCB0eXBlc1sgdHlwZSBdLCBvbmUgKTtcblx0XHR9XG5cdFx0cmV0dXJuIGVsZW07XG5cdH1cblxuXHRpZiAoIGRhdGEgPT0gbnVsbCAmJiBmbiA9PSBudWxsICkge1xuXG5cdFx0Ly8gKCB0eXBlcywgZm4gKVxuXHRcdGZuID0gc2VsZWN0b3I7XG5cdFx0ZGF0YSA9IHNlbGVjdG9yID0gdW5kZWZpbmVkO1xuXHR9IGVsc2UgaWYgKCBmbiA9PSBudWxsICkge1xuXHRcdGlmICggdHlwZW9mIHNlbGVjdG9yID09PSBcInN0cmluZ1wiICkge1xuXG5cdFx0XHQvLyAoIHR5cGVzLCBzZWxlY3RvciwgZm4gKVxuXHRcdFx0Zm4gPSBkYXRhO1xuXHRcdFx0ZGF0YSA9IHVuZGVmaW5lZDtcblx0XHR9IGVsc2Uge1xuXG5cdFx0XHQvLyAoIHR5cGVzLCBkYXRhLCBmbiApXG5cdFx0XHRmbiA9IGRhdGE7XG5cdFx0XHRkYXRhID0gc2VsZWN0b3I7XG5cdFx0XHRzZWxlY3RvciA9IHVuZGVmaW5lZDtcblx0XHR9XG5cdH1cblx0aWYgKCBmbiA9PT0gZmFsc2UgKSB7XG5cdFx0Zm4gPSByZXR1cm5GYWxzZTtcblx0fSBlbHNlIGlmICggIWZuICkge1xuXHRcdHJldHVybiBlbGVtO1xuXHR9XG5cblx0aWYgKCBvbmUgPT09IDEgKSB7XG5cdFx0b3JpZ0ZuID0gZm47XG5cdFx0Zm4gPSBmdW5jdGlvbiggZXZlbnQgKSB7XG5cblx0XHRcdC8vIENhbiB1c2UgYW4gZW1wdHkgc2V0LCBzaW5jZSBldmVudCBjb250YWlucyB0aGUgaW5mb1xuXHRcdFx0alF1ZXJ5KCkub2ZmKCBldmVudCApO1xuXHRcdFx0cmV0dXJuIG9yaWdGbi5hcHBseSggdGhpcywgYXJndW1lbnRzICk7XG5cdFx0fTtcblxuXHRcdC8vIFVzZSBzYW1lIGd1aWQgc28gY2FsbGVyIGNhbiByZW1vdmUgdXNpbmcgb3JpZ0ZuXG5cdFx0Zm4uZ3VpZCA9IG9yaWdGbi5ndWlkIHx8ICggb3JpZ0ZuLmd1aWQgPSBqUXVlcnkuZ3VpZCsrICk7XG5cdH1cblx0cmV0dXJuIGVsZW0uZWFjaCggZnVuY3Rpb24oKSB7XG5cdFx0alF1ZXJ5LmV2ZW50LmFkZCggdGhpcywgdHlwZXMsIGZuLCBkYXRhLCBzZWxlY3RvciApO1xuXHR9ICk7XG59XG5cbi8qXG4gKiBIZWxwZXIgZnVuY3Rpb25zIGZvciBtYW5hZ2luZyBldmVudHMgLS0gbm90IHBhcnQgb2YgdGhlIHB1YmxpYyBpbnRlcmZhY2UuXG4gKiBQcm9wcyB0byBEZWFuIEVkd2FyZHMnIGFkZEV2ZW50IGxpYnJhcnkgZm9yIG1hbnkgb2YgdGhlIGlkZWFzLlxuICovXG5qUXVlcnkuZXZlbnQgPSB7XG5cblx0YWRkOiBmdW5jdGlvbiggZWxlbSwgdHlwZXMsIGhhbmRsZXIsIGRhdGEsIHNlbGVjdG9yICkge1xuXG5cdFx0dmFyIGhhbmRsZU9iakluLCBldmVudEhhbmRsZSwgdG1wLFxuXHRcdFx0ZXZlbnRzLCB0LCBoYW5kbGVPYmosXG5cdFx0XHRzcGVjaWFsLCBoYW5kbGVycywgdHlwZSwgbmFtZXNwYWNlcywgb3JpZ1R5cGUsXG5cdFx0XHRlbGVtRGF0YSA9IGRhdGFQcml2LmdldCggZWxlbSApO1xuXG5cdFx0Ly8gT25seSBhdHRhY2ggZXZlbnRzIHRvIG9iamVjdHMgdGhhdCBhY2NlcHQgZGF0YVxuXHRcdGlmICggIWFjY2VwdERhdGEoIGVsZW0gKSApIHtcblx0XHRcdHJldHVybjtcblx0XHR9XG5cblx0XHQvLyBDYWxsZXIgY2FuIHBhc3MgaW4gYW4gb2JqZWN0IG9mIGN1c3RvbSBkYXRhIGluIGxpZXUgb2YgdGhlIGhhbmRsZXJcblx0XHRpZiAoIGhhbmRsZXIuaGFuZGxlciApIHtcblx0XHRcdGhhbmRsZU9iakluID0gaGFuZGxlcjtcblx0XHRcdGhhbmRsZXIgPSBoYW5kbGVPYmpJbi5oYW5kbGVyO1xuXHRcdFx0c2VsZWN0b3IgPSBoYW5kbGVPYmpJbi5zZWxlY3Rvcjtcblx0XHR9XG5cblx0XHQvLyBFbnN1cmUgdGhhdCBpbnZhbGlkIHNlbGVjdG9ycyB0aHJvdyBleGNlcHRpb25zIGF0IGF0dGFjaCB0aW1lXG5cdFx0Ly8gRXZhbHVhdGUgYWdhaW5zdCBkb2N1bWVudEVsZW1lbnQgaW4gY2FzZSBlbGVtIGlzIGEgbm9uLWVsZW1lbnQgbm9kZSAoZS5nLiwgZG9jdW1lbnQpXG5cdFx0aWYgKCBzZWxlY3RvciApIHtcblx0XHRcdGpRdWVyeS5maW5kLm1hdGNoZXNTZWxlY3RvciggZG9jdW1lbnRFbGVtZW50JDEsIHNlbGVjdG9yICk7XG5cdFx0fVxuXG5cdFx0Ly8gTWFrZSBzdXJlIHRoYXQgdGhlIGhhbmRsZXIgaGFzIGEgdW5pcXVlIElELCB1c2VkIHRvIGZpbmQvcmVtb3ZlIGl0IGxhdGVyXG5cdFx0aWYgKCAhaGFuZGxlci5ndWlkICkge1xuXHRcdFx0aGFuZGxlci5ndWlkID0galF1ZXJ5Lmd1aWQrKztcblx0XHR9XG5cblx0XHQvLyBJbml0IHRoZSBlbGVtZW50J3MgZXZlbnQgc3RydWN0dXJlIGFuZCBtYWluIGhhbmRsZXIsIGlmIHRoaXMgaXMgdGhlIGZpcnN0XG5cdFx0aWYgKCAhKCBldmVudHMgPSBlbGVtRGF0YS5ldmVudHMgKSApIHtcblx0XHRcdGV2ZW50cyA9IGVsZW1EYXRhLmV2ZW50cyA9IE9iamVjdC5jcmVhdGUoIG51bGwgKTtcblx0XHR9XG5cdFx0aWYgKCAhKCBldmVudEhhbmRsZSA9IGVsZW1EYXRhLmhhbmRsZSApICkge1xuXHRcdFx0ZXZlbnRIYW5kbGUgPSBlbGVtRGF0YS5oYW5kbGUgPSBmdW5jdGlvbiggZSApIHtcblxuXHRcdFx0XHQvLyBEaXNjYXJkIHRoZSBzZWNvbmQgZXZlbnQgb2YgYSBqUXVlcnkuZXZlbnQudHJpZ2dlcigpIGFuZFxuXHRcdFx0XHQvLyB3aGVuIGFuIGV2ZW50IGlzIGNhbGxlZCBhZnRlciBhIHBhZ2UgaGFzIHVubG9hZGVkXG5cdFx0XHRcdHJldHVybiB0eXBlb2YgalF1ZXJ5ICE9PSBcInVuZGVmaW5lZFwiICYmIGpRdWVyeS5ldmVudC50cmlnZ2VyZWQgIT09IGUudHlwZSA/XG5cdFx0XHRcdFx0alF1ZXJ5LmV2ZW50LmRpc3BhdGNoLmFwcGx5KCBlbGVtLCBhcmd1bWVudHMgKSA6IHVuZGVmaW5lZDtcblx0XHRcdH07XG5cdFx0fVxuXG5cdFx0Ly8gSGFuZGxlIG11bHRpcGxlIGV2ZW50cyBzZXBhcmF0ZWQgYnkgYSBzcGFjZVxuXHRcdHR5cGVzID0gKCB0eXBlcyB8fCBcIlwiICkubWF0Y2goIHJub3RodG1sd2hpdGUgKSB8fCBbIFwiXCIgXTtcblx0XHR0ID0gdHlwZXMubGVuZ3RoO1xuXHRcdHdoaWxlICggdC0tICkge1xuXHRcdFx0dG1wID0gcnR5cGVuYW1lc3BhY2UuZXhlYyggdHlwZXNbIHQgXSApIHx8IFtdO1xuXHRcdFx0dHlwZSA9IG9yaWdUeXBlID0gdG1wWyAxIF07XG5cdFx0XHRuYW1lc3BhY2VzID0gKCB0bXBbIDIgXSB8fCBcIlwiICkuc3BsaXQoIFwiLlwiICkuc29ydCgpO1xuXG5cdFx0XHQvLyBUaGVyZSAqbXVzdCogYmUgYSB0eXBlLCBubyBhdHRhY2hpbmcgbmFtZXNwYWNlLW9ubHkgaGFuZGxlcnNcblx0XHRcdGlmICggIXR5cGUgKSB7XG5cdFx0XHRcdGNvbnRpbnVlO1xuXHRcdFx0fVxuXG5cdFx0XHQvLyBJZiBldmVudCBjaGFuZ2VzIGl0cyB0eXBlLCB1c2UgdGhlIHNwZWNpYWwgZXZlbnQgaGFuZGxlcnMgZm9yIHRoZSBjaGFuZ2VkIHR5cGVcblx0XHRcdHNwZWNpYWwgPSBqUXVlcnkuZXZlbnQuc3BlY2lhbFsgdHlwZSBdIHx8IHt9O1xuXG5cdFx0XHQvLyBJZiBzZWxlY3RvciBkZWZpbmVkLCBkZXRlcm1pbmUgc3BlY2lhbCBldmVudCBhcGkgdHlwZSwgb3RoZXJ3aXNlIGdpdmVuIHR5cGVcblx0XHRcdHR5cGUgPSAoIHNlbGVjdG9yID8gc3BlY2lhbC5kZWxlZ2F0ZVR5cGUgOiBzcGVjaWFsLmJpbmRUeXBlICkgfHwgdHlwZTtcblxuXHRcdFx0Ly8gVXBkYXRlIHNwZWNpYWwgYmFzZWQgb24gbmV3bHkgcmVzZXQgdHlwZVxuXHRcdFx0c3BlY2lhbCA9IGpRdWVyeS5ldmVudC5zcGVjaWFsWyB0eXBlIF0gfHwge307XG5cblx0XHRcdC8vIGhhbmRsZU9iaiBpcyBwYXNzZWQgdG8gYWxsIGV2ZW50IGhhbmRsZXJzXG5cdFx0XHRoYW5kbGVPYmogPSBqUXVlcnkuZXh0ZW5kKCB7XG5cdFx0XHRcdHR5cGU6IHR5cGUsXG5cdFx0XHRcdG9yaWdUeXBlOiBvcmlnVHlwZSxcblx0XHRcdFx0ZGF0YTogZGF0YSxcblx0XHRcdFx0aGFuZGxlcjogaGFuZGxlcixcblx0XHRcdFx0Z3VpZDogaGFuZGxlci5ndWlkLFxuXHRcdFx0XHRzZWxlY3Rvcjogc2VsZWN0b3IsXG5cdFx0XHRcdG5lZWRzQ29udGV4dDogc2VsZWN0b3IgJiYgalF1ZXJ5LmV4cHIubWF0Y2gubmVlZHNDb250ZXh0LnRlc3QoIHNlbGVjdG9yICksXG5cdFx0XHRcdG5hbWVzcGFjZTogbmFtZXNwYWNlcy5qb2luKCBcIi5cIiApXG5cdFx0XHR9LCBoYW5kbGVPYmpJbiApO1xuXG5cdFx0XHQvLyBJbml0IHRoZSBldmVudCBoYW5kbGVyIHF1ZXVlIGlmIHdlJ3JlIHRoZSBmaXJzdFxuXHRcdFx0aWYgKCAhKCBoYW5kbGVycyA9IGV2ZW50c1sgdHlwZSBdICkgKSB7XG5cdFx0XHRcdGhhbmRsZXJzID0gZXZlbnRzWyB0eXBlIF0gPSBbXTtcblx0XHRcdFx0aGFuZGxlcnMuZGVsZWdhdGVDb3VudCA9IDA7XG5cblx0XHRcdFx0Ly8gT25seSB1c2UgYWRkRXZlbnRMaXN0ZW5lciBpZiB0aGUgc3BlY2lhbCBldmVudHMgaGFuZGxlciByZXR1cm5zIGZhbHNlXG5cdFx0XHRcdGlmICggIXNwZWNpYWwuc2V0dXAgfHxcblx0XHRcdFx0XHRzcGVjaWFsLnNldHVwLmNhbGwoIGVsZW0sIGRhdGEsIG5hbWVzcGFjZXMsIGV2ZW50SGFuZGxlICkgPT09IGZhbHNlICkge1xuXG5cdFx0XHRcdFx0aWYgKCBlbGVtLmFkZEV2ZW50TGlzdGVuZXIgKSB7XG5cdFx0XHRcdFx0XHRlbGVtLmFkZEV2ZW50TGlzdGVuZXIoIHR5cGUsIGV2ZW50SGFuZGxlICk7XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHR9XG5cdFx0XHR9XG5cblx0XHRcdGlmICggc3BlY2lhbC5hZGQgKSB7XG5cdFx0XHRcdHNwZWNpYWwuYWRkLmNhbGwoIGVsZW0sIGhhbmRsZU9iaiApO1xuXG5cdFx0XHRcdGlmICggIWhhbmRsZU9iai5oYW5kbGVyLmd1aWQgKSB7XG5cdFx0XHRcdFx0aGFuZGxlT2JqLmhhbmRsZXIuZ3VpZCA9IGhhbmRsZXIuZ3VpZDtcblx0XHRcdFx0fVxuXHRcdFx0fVxuXG5cdFx0XHQvLyBBZGQgdG8gdGhlIGVsZW1lbnQncyBoYW5kbGVyIGxpc3QsIGRlbGVnYXRlcyBpbiBmcm9udFxuXHRcdFx0aWYgKCBzZWxlY3RvciApIHtcblx0XHRcdFx0aGFuZGxlcnMuc3BsaWNlKCBoYW5kbGVycy5kZWxlZ2F0ZUNvdW50KyssIDAsIGhhbmRsZU9iaiApO1xuXHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0aGFuZGxlcnMucHVzaCggaGFuZGxlT2JqICk7XG5cdFx0XHR9XG5cdFx0fVxuXG5cdH0sXG5cblx0Ly8gRGV0YWNoIGFuIGV2ZW50IG9yIHNldCBvZiBldmVudHMgZnJvbSBhbiBlbGVtZW50XG5cdHJlbW92ZTogZnVuY3Rpb24oIGVsZW0sIHR5cGVzLCBoYW5kbGVyLCBzZWxlY3RvciwgbWFwcGVkVHlwZXMgKSB7XG5cblx0XHR2YXIgaiwgb3JpZ0NvdW50LCB0bXAsXG5cdFx0XHRldmVudHMsIHQsIGhhbmRsZU9iaixcblx0XHRcdHNwZWNpYWwsIGhhbmRsZXJzLCB0eXBlLCBuYW1lc3BhY2VzLCBvcmlnVHlwZSxcblx0XHRcdGVsZW1EYXRhID0gZGF0YVByaXYuaGFzRGF0YSggZWxlbSApICYmIGRhdGFQcml2LmdldCggZWxlbSApO1xuXG5cdFx0aWYgKCAhZWxlbURhdGEgfHwgISggZXZlbnRzID0gZWxlbURhdGEuZXZlbnRzICkgKSB7XG5cdFx0XHRyZXR1cm47XG5cdFx0fVxuXG5cdFx0Ly8gT25jZSBmb3IgZWFjaCB0eXBlLm5hbWVzcGFjZSBpbiB0eXBlczsgdHlwZSBtYXkgYmUgb21pdHRlZFxuXHRcdHR5cGVzID0gKCB0eXBlcyB8fCBcIlwiICkubWF0Y2goIHJub3RodG1sd2hpdGUgKSB8fCBbIFwiXCIgXTtcblx0XHR0ID0gdHlwZXMubGVuZ3RoO1xuXHRcdHdoaWxlICggdC0tICkge1xuXHRcdFx0dG1wID0gcnR5cGVuYW1lc3BhY2UuZXhlYyggdHlwZXNbIHQgXSApIHx8IFtdO1xuXHRcdFx0dHlwZSA9IG9yaWdUeXBlID0gdG1wWyAxIF07XG5cdFx0XHRuYW1lc3BhY2VzID0gKCB0bXBbIDIgXSB8fCBcIlwiICkuc3BsaXQoIFwiLlwiICkuc29ydCgpO1xuXG5cdFx0XHQvLyBVbmJpbmQgYWxsIGV2ZW50cyAob24gdGhpcyBuYW1lc3BhY2UsIGlmIHByb3ZpZGVkKSBmb3IgdGhlIGVsZW1lbnRcblx0XHRcdGlmICggIXR5cGUgKSB7XG5cdFx0XHRcdGZvciAoIHR5cGUgaW4gZXZlbnRzICkge1xuXHRcdFx0XHRcdGpRdWVyeS5ldmVudC5yZW1vdmUoIGVsZW0sIHR5cGUgKyB0eXBlc1sgdCBdLCBoYW5kbGVyLCBzZWxlY3RvciwgdHJ1ZSApO1xuXHRcdFx0XHR9XG5cdFx0XHRcdGNvbnRpbnVlO1xuXHRcdFx0fVxuXG5cdFx0XHRzcGVjaWFsID0galF1ZXJ5LmV2ZW50LnNwZWNpYWxbIHR5cGUgXSB8fCB7fTtcblx0XHRcdHR5cGUgPSAoIHNlbGVjdG9yID8gc3BlY2lhbC5kZWxlZ2F0ZVR5cGUgOiBzcGVjaWFsLmJpbmRUeXBlICkgfHwgdHlwZTtcblx0XHRcdGhhbmRsZXJzID0gZXZlbnRzWyB0eXBlIF0gfHwgW107XG5cdFx0XHR0bXAgPSB0bXBbIDIgXSAmJlxuXHRcdFx0XHRuZXcgUmVnRXhwKCBcIihefFxcXFwuKVwiICsgbmFtZXNwYWNlcy5qb2luKCBcIlxcXFwuKD86LipcXFxcLnwpXCIgKSArIFwiKFxcXFwufCQpXCIgKTtcblxuXHRcdFx0Ly8gUmVtb3ZlIG1hdGNoaW5nIGV2ZW50c1xuXHRcdFx0b3JpZ0NvdW50ID0gaiA9IGhhbmRsZXJzLmxlbmd0aDtcblx0XHRcdHdoaWxlICggai0tICkge1xuXHRcdFx0XHRoYW5kbGVPYmogPSBoYW5kbGVyc1sgaiBdO1xuXG5cdFx0XHRcdGlmICggKCBtYXBwZWRUeXBlcyB8fCBvcmlnVHlwZSA9PT0gaGFuZGxlT2JqLm9yaWdUeXBlICkgJiZcblx0XHRcdFx0XHQoICFoYW5kbGVyIHx8IGhhbmRsZXIuZ3VpZCA9PT0gaGFuZGxlT2JqLmd1aWQgKSAmJlxuXHRcdFx0XHRcdCggIXRtcCB8fCB0bXAudGVzdCggaGFuZGxlT2JqLm5hbWVzcGFjZSApICkgJiZcblx0XHRcdFx0XHQoICFzZWxlY3RvciB8fCBzZWxlY3RvciA9PT0gaGFuZGxlT2JqLnNlbGVjdG9yIHx8XG5cdFx0XHRcdFx0XHRzZWxlY3RvciA9PT0gXCIqKlwiICYmIGhhbmRsZU9iai5zZWxlY3RvciApICkge1xuXHRcdFx0XHRcdGhhbmRsZXJzLnNwbGljZSggaiwgMSApO1xuXG5cdFx0XHRcdFx0aWYgKCBoYW5kbGVPYmouc2VsZWN0b3IgKSB7XG5cdFx0XHRcdFx0XHRoYW5kbGVycy5kZWxlZ2F0ZUNvdW50LS07XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHRcdGlmICggc3BlY2lhbC5yZW1vdmUgKSB7XG5cdFx0XHRcdFx0XHRzcGVjaWFsLnJlbW92ZS5jYWxsKCBlbGVtLCBoYW5kbGVPYmogKTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH1cblx0XHRcdH1cblxuXHRcdFx0Ly8gUmVtb3ZlIGdlbmVyaWMgZXZlbnQgaGFuZGxlciBpZiB3ZSByZW1vdmVkIHNvbWV0aGluZyBhbmQgbm8gbW9yZSBoYW5kbGVycyBleGlzdFxuXHRcdFx0Ly8gKGF2b2lkcyBwb3RlbnRpYWwgZm9yIGVuZGxlc3MgcmVjdXJzaW9uIGR1cmluZyByZW1vdmFsIG9mIHNwZWNpYWwgZXZlbnQgaGFuZGxlcnMpXG5cdFx0XHRpZiAoIG9yaWdDb3VudCAmJiAhaGFuZGxlcnMubGVuZ3RoICkge1xuXHRcdFx0XHRpZiAoICFzcGVjaWFsLnRlYXJkb3duIHx8XG5cdFx0XHRcdFx0c3BlY2lhbC50ZWFyZG93bi5jYWxsKCBlbGVtLCBuYW1lc3BhY2VzLCBlbGVtRGF0YS5oYW5kbGUgKSA9PT0gZmFsc2UgKSB7XG5cblx0XHRcdFx0XHRqUXVlcnkucmVtb3ZlRXZlbnQoIGVsZW0sIHR5cGUsIGVsZW1EYXRhLmhhbmRsZSApO1xuXHRcdFx0XHR9XG5cblx0XHRcdFx0ZGVsZXRlIGV2ZW50c1sgdHlwZSBdO1xuXHRcdFx0fVxuXHRcdH1cblxuXHRcdC8vIFJlbW92ZSBkYXRhIGFuZCB0aGUgZXhwYW5kbyBpZiBpdCdzIG5vIGxvbmdlciB1c2VkXG5cdFx0aWYgKCBqUXVlcnkuaXNFbXB0eU9iamVjdCggZXZlbnRzICkgKSB7XG5cdFx0XHRkYXRhUHJpdi5yZW1vdmUoIGVsZW0sIFwiaGFuZGxlIGV2ZW50c1wiICk7XG5cdFx0fVxuXHR9LFxuXG5cdGRpc3BhdGNoOiBmdW5jdGlvbiggbmF0aXZlRXZlbnQgKSB7XG5cblx0XHR2YXIgaSwgaiwgcmV0LCBtYXRjaGVkLCBoYW5kbGVPYmosIGhhbmRsZXJRdWV1ZSxcblx0XHRcdGFyZ3MgPSBuZXcgQXJyYXkoIGFyZ3VtZW50cy5sZW5ndGggKSxcblxuXHRcdFx0Ly8gTWFrZSBhIHdyaXRhYmxlIGpRdWVyeS5FdmVudCBmcm9tIHRoZSBuYXRpdmUgZXZlbnQgb2JqZWN0XG5cdFx0XHRldmVudCA9IGpRdWVyeS5ldmVudC5maXgoIG5hdGl2ZUV2ZW50ICksXG5cblx0XHRcdGhhbmRsZXJzID0gKFxuXHRcdFx0XHRkYXRhUHJpdi5nZXQoIHRoaXMsIFwiZXZlbnRzXCIgKSB8fCBPYmplY3QuY3JlYXRlKCBudWxsIClcblx0XHRcdClbIGV2ZW50LnR5cGUgXSB8fCBbXSxcblx0XHRcdHNwZWNpYWwgPSBqUXVlcnkuZXZlbnQuc3BlY2lhbFsgZXZlbnQudHlwZSBdIHx8IHt9O1xuXG5cdFx0Ly8gVXNlIHRoZSBmaXgtZWQgalF1ZXJ5LkV2ZW50IHJhdGhlciB0aGFuIHRoZSAocmVhZC1vbmx5KSBuYXRpdmUgZXZlbnRcblx0XHRhcmdzWyAwIF0gPSBldmVudDtcblxuXHRcdGZvciAoIGkgPSAxOyBpIDwgYXJndW1lbnRzLmxlbmd0aDsgaSsrICkge1xuXHRcdFx0YXJnc1sgaSBdID0gYXJndW1lbnRzWyBpIF07XG5cdFx0fVxuXG5cdFx0ZXZlbnQuZGVsZWdhdGVUYXJnZXQgPSB0aGlzO1xuXG5cdFx0Ly8gQ2FsbCB0aGUgcHJlRGlzcGF0Y2ggaG9vayBmb3IgdGhlIG1hcHBlZCB0eXBlLCBhbmQgbGV0IGl0IGJhaWwgaWYgZGVzaXJlZFxuXHRcdGlmICggc3BlY2lhbC5wcmVEaXNwYXRjaCAmJiBzcGVjaWFsLnByZURpc3BhdGNoLmNhbGwoIHRoaXMsIGV2ZW50ICkgPT09IGZhbHNlICkge1xuXHRcdFx0cmV0dXJuO1xuXHRcdH1cblxuXHRcdC8vIERldGVybWluZSBoYW5kbGVyc1xuXHRcdGhhbmRsZXJRdWV1ZSA9IGpRdWVyeS5ldmVudC5oYW5kbGVycy5jYWxsKCB0aGlzLCBldmVudCwgaGFuZGxlcnMgKTtcblxuXHRcdC8vIFJ1biBkZWxlZ2F0ZXMgZmlyc3Q7IHRoZXkgbWF5IHdhbnQgdG8gc3RvcCBwcm9wYWdhdGlvbiBiZW5lYXRoIHVzXG5cdFx0aSA9IDA7XG5cdFx0d2hpbGUgKCAoIG1hdGNoZWQgPSBoYW5kbGVyUXVldWVbIGkrKyBdICkgJiYgIWV2ZW50LmlzUHJvcGFnYXRpb25TdG9wcGVkKCkgKSB7XG5cdFx0XHRldmVudC5jdXJyZW50VGFyZ2V0ID0gbWF0Y2hlZC5lbGVtO1xuXG5cdFx0XHRqID0gMDtcblx0XHRcdHdoaWxlICggKCBoYW5kbGVPYmogPSBtYXRjaGVkLmhhbmRsZXJzWyBqKysgXSApICYmXG5cdFx0XHRcdCFldmVudC5pc0ltbWVkaWF0ZVByb3BhZ2F0aW9uU3RvcHBlZCgpICkge1xuXG5cdFx0XHRcdC8vIElmIHRoZSBldmVudCBpcyBuYW1lc3BhY2VkLCB0aGVuIGVhY2ggaGFuZGxlciBpcyBvbmx5IGludm9rZWQgaWYgaXQgaXNcblx0XHRcdFx0Ly8gc3BlY2lhbGx5IHVuaXZlcnNhbCBvciBpdHMgbmFtZXNwYWNlcyBhcmUgYSBzdXBlcnNldCBvZiB0aGUgZXZlbnQncy5cblx0XHRcdFx0aWYgKCAhZXZlbnQucm5hbWVzcGFjZSB8fCBoYW5kbGVPYmoubmFtZXNwYWNlID09PSBmYWxzZSB8fFxuXHRcdFx0XHRcdGV2ZW50LnJuYW1lc3BhY2UudGVzdCggaGFuZGxlT2JqLm5hbWVzcGFjZSApICkge1xuXG5cdFx0XHRcdFx0ZXZlbnQuaGFuZGxlT2JqID0gaGFuZGxlT2JqO1xuXHRcdFx0XHRcdGV2ZW50LmRhdGEgPSBoYW5kbGVPYmouZGF0YTtcblxuXHRcdFx0XHRcdHJldCA9ICggKCBqUXVlcnkuZXZlbnQuc3BlY2lhbFsgaGFuZGxlT2JqLm9yaWdUeXBlIF0gfHwge30gKS5oYW5kbGUgfHxcblx0XHRcdFx0XHRcdGhhbmRsZU9iai5oYW5kbGVyICkuYXBwbHkoIG1hdGNoZWQuZWxlbSwgYXJncyApO1xuXG5cdFx0XHRcdFx0aWYgKCByZXQgIT09IHVuZGVmaW5lZCApIHtcblx0XHRcdFx0XHRcdGlmICggKCBldmVudC5yZXN1bHQgPSByZXQgKSA9PT0gZmFsc2UgKSB7XG5cdFx0XHRcdFx0XHRcdGV2ZW50LnByZXZlbnREZWZhdWx0KCk7XG5cdFx0XHRcdFx0XHRcdGV2ZW50LnN0b3BQcm9wYWdhdGlvbigpO1xuXHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdH1cblx0XHRcdFx0fVxuXHRcdFx0fVxuXHRcdH1cblxuXHRcdC8vIENhbGwgdGhlIHBvc3REaXNwYXRjaCBob29rIGZvciB0aGUgbWFwcGVkIHR5cGVcblx0XHRpZiAoIHNwZWNpYWwucG9zdERpc3BhdGNoICkge1xuXHRcdFx0c3BlY2lhbC5wb3N0RGlzcGF0Y2guY2FsbCggdGhpcywgZXZlbnQgKTtcblx0XHR9XG5cblx0XHRyZXR1cm4gZXZlbnQucmVzdWx0O1xuXHR9LFxuXG5cdGhhbmRsZXJzOiBmdW5jdGlvbiggZXZlbnQsIGhhbmRsZXJzICkge1xuXHRcdHZhciBpLCBoYW5kbGVPYmosIHNlbCwgbWF0Y2hlZEhhbmRsZXJzLCBtYXRjaGVkU2VsZWN0b3JzLFxuXHRcdFx0aGFuZGxlclF1ZXVlID0gW10sXG5cdFx0XHRkZWxlZ2F0ZUNvdW50ID0gaGFuZGxlcnMuZGVsZWdhdGVDb3VudCxcblx0XHRcdGN1ciA9IGV2ZW50LnRhcmdldDtcblxuXHRcdC8vIEZpbmQgZGVsZWdhdGUgaGFuZGxlcnNcblx0XHRpZiAoIGRlbGVnYXRlQ291bnQgJiZcblxuXHRcdFx0Ly8gU3VwcG9ydDogRmlyZWZveCA8PTQyIC0gNjYrXG5cdFx0XHQvLyBTdXBwcmVzcyBzcGVjLXZpb2xhdGluZyBjbGlja3MgaW5kaWNhdGluZyBhIG5vbi1wcmltYXJ5IHBvaW50ZXIgYnV0dG9uICh0cmFjLTM4NjEpXG5cdFx0XHQvLyBodHRwczovL3d3dy53My5vcmcvVFIvRE9NLUxldmVsLTMtRXZlbnRzLyNldmVudC10eXBlLWNsaWNrXG5cdFx0XHQvLyBTdXBwb3J0OiBJRSAxMStcblx0XHRcdC8vIC4uLmJ1dCBub3QgYXJyb3cga2V5IFwiY2xpY2tzXCIgb2YgcmFkaW8gaW5wdXRzLCB3aGljaCBjYW4gaGF2ZSBgYnV0dG9uYCAtMSAoZ2gtMjM0Mylcblx0XHRcdCEoIGV2ZW50LnR5cGUgPT09IFwiY2xpY2tcIiAmJiBldmVudC5idXR0b24gPj0gMSApICkge1xuXG5cdFx0XHRmb3IgKCA7IGN1ciAhPT0gdGhpczsgY3VyID0gY3VyLnBhcmVudE5vZGUgfHwgdGhpcyApIHtcblxuXHRcdFx0XHQvLyBEb24ndCBjaGVjayBub24tZWxlbWVudHMgKHRyYWMtMTMyMDgpXG5cdFx0XHRcdC8vIERvbid0IHByb2Nlc3MgY2xpY2tzIG9uIGRpc2FibGVkIGVsZW1lbnRzICh0cmFjLTY5MTEsIHRyYWMtODE2NSwgdHJhYy0xMTM4MiwgdHJhYy0xMTc2NClcblx0XHRcdFx0aWYgKCBjdXIubm9kZVR5cGUgPT09IDEgJiYgISggZXZlbnQudHlwZSA9PT0gXCJjbGlja1wiICYmIGN1ci5kaXNhYmxlZCA9PT0gdHJ1ZSApICkge1xuXHRcdFx0XHRcdG1hdGNoZWRIYW5kbGVycyA9IFtdO1xuXHRcdFx0XHRcdG1hdGNoZWRTZWxlY3RvcnMgPSB7fTtcblx0XHRcdFx0XHRmb3IgKCBpID0gMDsgaSA8IGRlbGVnYXRlQ291bnQ7IGkrKyApIHtcblx0XHRcdFx0XHRcdGhhbmRsZU9iaiA9IGhhbmRsZXJzWyBpIF07XG5cblx0XHRcdFx0XHRcdC8vIERvbid0IGNvbmZsaWN0IHdpdGggT2JqZWN0LnByb3RvdHlwZSBwcm9wZXJ0aWVzICh0cmFjLTEzMjAzKVxuXHRcdFx0XHRcdFx0c2VsID0gaGFuZGxlT2JqLnNlbGVjdG9yICsgXCIgXCI7XG5cblx0XHRcdFx0XHRcdGlmICggbWF0Y2hlZFNlbGVjdG9yc1sgc2VsIF0gPT09IHVuZGVmaW5lZCApIHtcblx0XHRcdFx0XHRcdFx0bWF0Y2hlZFNlbGVjdG9yc1sgc2VsIF0gPSBoYW5kbGVPYmoubmVlZHNDb250ZXh0ID9cblx0XHRcdFx0XHRcdFx0XHRqUXVlcnkoIHNlbCwgdGhpcyApLmluZGV4KCBjdXIgKSA+IC0xIDpcblx0XHRcdFx0XHRcdFx0XHRqUXVlcnkuZmluZCggc2VsLCB0aGlzLCBudWxsLCBbIGN1ciBdICkubGVuZ3RoO1xuXHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdFx0aWYgKCBtYXRjaGVkU2VsZWN0b3JzWyBzZWwgXSApIHtcblx0XHRcdFx0XHRcdFx0bWF0Y2hlZEhhbmRsZXJzLnB1c2goIGhhbmRsZU9iaiApO1xuXHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdH1cblx0XHRcdFx0XHRpZiAoIG1hdGNoZWRIYW5kbGVycy5sZW5ndGggKSB7XG5cdFx0XHRcdFx0XHRoYW5kbGVyUXVldWUucHVzaCggeyBlbGVtOiBjdXIsIGhhbmRsZXJzOiBtYXRjaGVkSGFuZGxlcnMgfSApO1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0fVxuXHRcdFx0fVxuXHRcdH1cblxuXHRcdC8vIEFkZCB0aGUgcmVtYWluaW5nIChkaXJlY3RseS1ib3VuZCkgaGFuZGxlcnNcblx0XHRjdXIgPSB0aGlzO1xuXHRcdGlmICggZGVsZWdhdGVDb3VudCA8IGhhbmRsZXJzLmxlbmd0aCApIHtcblx0XHRcdGhhbmRsZXJRdWV1ZS5wdXNoKCB7IGVsZW06IGN1ciwgaGFuZGxlcnM6IGhhbmRsZXJzLnNsaWNlKCBkZWxlZ2F0ZUNvdW50ICkgfSApO1xuXHRcdH1cblxuXHRcdHJldHVybiBoYW5kbGVyUXVldWU7XG5cdH0sXG5cblx0YWRkUHJvcDogZnVuY3Rpb24oIG5hbWUsIGhvb2sgKSB7XG5cdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KCBqUXVlcnkuRXZlbnQucHJvdG90eXBlLCBuYW1lLCB7XG5cdFx0XHRlbnVtZXJhYmxlOiB0cnVlLFxuXHRcdFx0Y29uZmlndXJhYmxlOiB0cnVlLFxuXG5cdFx0XHRnZXQ6IHR5cGVvZiBob29rID09PSBcImZ1bmN0aW9uXCIgP1xuXHRcdFx0XHRmdW5jdGlvbigpIHtcblx0XHRcdFx0XHRpZiAoIHRoaXMub3JpZ2luYWxFdmVudCApIHtcblx0XHRcdFx0XHRcdHJldHVybiBob29rKCB0aGlzLm9yaWdpbmFsRXZlbnQgKTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH0gOlxuXHRcdFx0XHRmdW5jdGlvbigpIHtcblx0XHRcdFx0XHRpZiAoIHRoaXMub3JpZ2luYWxFdmVudCApIHtcblx0XHRcdFx0XHRcdHJldHVybiB0aGlzLm9yaWdpbmFsRXZlbnRbIG5hbWUgXTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH0sXG5cblx0XHRcdHNldDogZnVuY3Rpb24oIHZhbHVlICkge1xuXHRcdFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoIHRoaXMsIG5hbWUsIHtcblx0XHRcdFx0XHRlbnVtZXJhYmxlOiB0cnVlLFxuXHRcdFx0XHRcdGNvbmZpZ3VyYWJsZTogdHJ1ZSxcblx0XHRcdFx0XHR3cml0YWJsZTogdHJ1ZSxcblx0XHRcdFx0XHR2YWx1ZTogdmFsdWVcblx0XHRcdFx0fSApO1xuXHRcdFx0fVxuXHRcdH0gKTtcblx0fSxcblxuXHRmaXg6IGZ1bmN0aW9uKCBvcmlnaW5hbEV2ZW50ICkge1xuXHRcdHJldHVybiBvcmlnaW5hbEV2ZW50WyBqUXVlcnkuZXhwYW5kbyBdID9cblx0XHRcdG9yaWdpbmFsRXZlbnQgOlxuXHRcdFx0bmV3IGpRdWVyeS5FdmVudCggb3JpZ2luYWxFdmVudCApO1xuXHR9LFxuXG5cdHNwZWNpYWw6IGpRdWVyeS5leHRlbmQoIE9iamVjdC5jcmVhdGUoIG51bGwgKSwge1xuXHRcdGxvYWQ6IHtcblxuXHRcdFx0Ly8gUHJldmVudCB0cmlnZ2VyZWQgaW1hZ2UubG9hZCBldmVudHMgZnJvbSBidWJibGluZyB0byB3aW5kb3cubG9hZFxuXHRcdFx0bm9CdWJibGU6IHRydWVcblx0XHR9LFxuXHRcdGNsaWNrOiB7XG5cblx0XHRcdC8vIFV0aWxpemUgbmF0aXZlIGV2ZW50IHRvIGVuc3VyZSBjb3JyZWN0IHN0YXRlIGZvciBjaGVja2FibGUgaW5wdXRzXG5cdFx0XHRzZXR1cDogZnVuY3Rpb24oIGRhdGEgKSB7XG5cblx0XHRcdFx0Ly8gRm9yIG11dHVhbCBjb21wcmVzc2liaWxpdHkgd2l0aCBfZGVmYXVsdCwgcmVwbGFjZSBgdGhpc2AgYWNjZXNzIHdpdGggYSBsb2NhbCB2YXIuXG5cdFx0XHRcdC8vIGB8fCBkYXRhYCBpcyBkZWFkIGNvZGUgbWVhbnQgb25seSB0byBwcmVzZXJ2ZSB0aGUgdmFyaWFibGUgdGhyb3VnaCBtaW5pZmljYXRpb24uXG5cdFx0XHRcdHZhciBlbCA9IHRoaXMgfHwgZGF0YTtcblxuXHRcdFx0XHQvLyBDbGFpbSB0aGUgZmlyc3QgaGFuZGxlclxuXHRcdFx0XHRpZiAoIHJjaGVja2FibGVUeXBlLnRlc3QoIGVsLnR5cGUgKSAmJlxuXHRcdFx0XHRcdGVsLmNsaWNrICYmIG5vZGVOYW1lKCBlbCwgXCJpbnB1dFwiICkgKSB7XG5cblx0XHRcdFx0XHQvLyBkYXRhUHJpdi5zZXQoIGVsLCBcImNsaWNrXCIsIC4uLiApXG5cdFx0XHRcdFx0bGV2ZXJhZ2VOYXRpdmUoIGVsLCBcImNsaWNrXCIsIHRydWUgKTtcblx0XHRcdFx0fVxuXG5cdFx0XHRcdC8vIFJldHVybiBmYWxzZSB0byBhbGxvdyBub3JtYWwgcHJvY2Vzc2luZyBpbiB0aGUgY2FsbGVyXG5cdFx0XHRcdHJldHVybiBmYWxzZTtcblx0XHRcdH0sXG5cdFx0XHR0cmlnZ2VyOiBmdW5jdGlvbiggZGF0YSApIHtcblxuXHRcdFx0XHQvLyBGb3IgbXV0dWFsIGNvbXByZXNzaWJpbGl0eSB3aXRoIF9kZWZhdWx0LCByZXBsYWNlIGB0aGlzYCBhY2Nlc3Mgd2l0aCBhIGxvY2FsIHZhci5cblx0XHRcdFx0Ly8gYHx8IGRhdGFgIGlzIGRlYWQgY29kZSBtZWFudCBvbmx5IHRvIHByZXNlcnZlIHRoZSB2YXJpYWJsZSB0aHJvdWdoIG1pbmlmaWNhdGlvbi5cblx0XHRcdFx0dmFyIGVsID0gdGhpcyB8fCBkYXRhO1xuXG5cdFx0XHRcdC8vIEZvcmNlIHNldHVwIGJlZm9yZSB0cmlnZ2VyaW5nIGEgY2xpY2tcblx0XHRcdFx0aWYgKCByY2hlY2thYmxlVHlwZS50ZXN0KCBlbC50eXBlICkgJiZcblx0XHRcdFx0XHRlbC5jbGljayAmJiBub2RlTmFtZSggZWwsIFwiaW5wdXRcIiApICkge1xuXG5cdFx0XHRcdFx0bGV2ZXJhZ2VOYXRpdmUoIGVsLCBcImNsaWNrXCIgKTtcblx0XHRcdFx0fVxuXG5cdFx0XHRcdC8vIFJldHVybiBub24tZmFsc2UgdG8gYWxsb3cgbm9ybWFsIGV2ZW50LXBhdGggcHJvcGFnYXRpb25cblx0XHRcdFx0cmV0dXJuIHRydWU7XG5cdFx0XHR9LFxuXG5cdFx0XHQvLyBGb3IgY3Jvc3MtYnJvd3NlciBjb25zaXN0ZW5jeSwgc3VwcHJlc3MgbmF0aXZlIC5jbGljaygpIG9uIGxpbmtzXG5cdFx0XHQvLyBBbHNvIHByZXZlbnQgaXQgaWYgd2UncmUgY3VycmVudGx5IGluc2lkZSBhIGxldmVyYWdlZCBuYXRpdmUtZXZlbnQgc3RhY2tcblx0XHRcdF9kZWZhdWx0OiBmdW5jdGlvbiggZXZlbnQgKSB7XG5cdFx0XHRcdHZhciB0YXJnZXQgPSBldmVudC50YXJnZXQ7XG5cdFx0XHRcdHJldHVybiByY2hlY2thYmxlVHlwZS50ZXN0KCB0YXJnZXQudHlwZSApICYmXG5cdFx0XHRcdFx0dGFyZ2V0LmNsaWNrICYmIG5vZGVOYW1lKCB0YXJnZXQsIFwiaW5wdXRcIiApICYmXG5cdFx0XHRcdFx0ZGF0YVByaXYuZ2V0KCB0YXJnZXQsIFwiY2xpY2tcIiApIHx8XG5cdFx0XHRcdFx0bm9kZU5hbWUoIHRhcmdldCwgXCJhXCIgKTtcblx0XHRcdH1cblx0XHR9LFxuXG5cdFx0YmVmb3JldW5sb2FkOiB7XG5cdFx0XHRwb3N0RGlzcGF0Y2g6IGZ1bmN0aW9uKCBldmVudCApIHtcblx0XHRcdFx0aWYgKCBldmVudC5yZXN1bHQgIT09IHVuZGVmaW5lZCApIHtcblxuXHRcdFx0XHRcdC8vIFNldHRpbmcgYGV2ZW50Lm9yaWdpbmFsRXZlbnQucmV0dXJuVmFsdWVgIGluIG1vZGVyblxuXHRcdFx0XHRcdC8vIGJyb3dzZXJzIGRvZXMgdGhlIHNhbWUgYXMganVzdCBjYWxsaW5nIGBwcmV2ZW50RGVmYXVsdCgpYCxcblx0XHRcdFx0XHQvLyB0aGUgYnJvd3NlcnMgaWdub3JlIHRoZSB2YWx1ZSBhbnl3YXkuXG5cdFx0XHRcdFx0Ly8gSW5jaWRlbnRhbGx5LCBJRSAxMSBpcyB0aGUgb25seSBicm93c2VyIGZyb20gb3VyIHN1cHBvcnRlZFxuXHRcdFx0XHRcdC8vIG9uZXMgd2hpY2ggcmVzcGVjdHMgdGhlIHZhbHVlIHJldHVybmVkIGZyb20gYSBgYmVmb3JldW5sb2FkYFxuXHRcdFx0XHRcdC8vIGhhbmRsZXIgYXR0YWNoZWQgYnkgYGFkZEV2ZW50TGlzdGVuZXJgOyBvdGhlciBicm93c2VycyBkb1xuXHRcdFx0XHRcdC8vIHNvIG9ubHkgZm9yIGlubGluZSBoYW5kbGVycywgc28gbm90IHNldHRpbmcgdGhlIHZhbHVlXG5cdFx0XHRcdFx0Ly8gZGlyZWN0bHkgc2hvdWxkbid0IHJlZHVjZSBhbnkgZnVuY3Rpb25hbGl0eS5cblx0XHRcdFx0XHRldmVudC5wcmV2ZW50RGVmYXVsdCgpO1xuXHRcdFx0XHR9XG5cdFx0XHR9XG5cdFx0fVxuXHR9IClcbn07XG5cbi8vIEVuc3VyZSB0aGUgcHJlc2VuY2Ugb2YgYW4gZXZlbnQgbGlzdGVuZXIgdGhhdCBoYW5kbGVzIG1hbnVhbGx5LXRyaWdnZXJlZFxuLy8gc3ludGhldGljIGV2ZW50cyBieSBpbnRlcnJ1cHRpbmcgcHJvZ3Jlc3MgdW50aWwgcmVpbnZva2VkIGluIHJlc3BvbnNlIHRvXG4vLyAqbmF0aXZlKiBldmVudHMgdGhhdCBpdCBmaXJlcyBkaXJlY3RseSwgZW5zdXJpbmcgdGhhdCBzdGF0ZSBjaGFuZ2VzIGhhdmVcbi8vIGFscmVhZHkgb2NjdXJyZWQgYmVmb3JlIG90aGVyIGxpc3RlbmVycyBhcmUgaW52b2tlZC5cbmZ1bmN0aW9uIGxldmVyYWdlTmF0aXZlKCBlbCwgdHlwZSwgaXNTZXR1cCApIHtcblxuXHQvLyBNaXNzaW5nIGBpc1NldHVwYCBpbmRpY2F0ZXMgYSB0cmlnZ2VyIGNhbGwsIHdoaWNoIG11c3QgZm9yY2Ugc2V0dXAgdGhyb3VnaCBqUXVlcnkuZXZlbnQuYWRkXG5cdGlmICggIWlzU2V0dXAgKSB7XG5cdFx0aWYgKCBkYXRhUHJpdi5nZXQoIGVsLCB0eXBlICkgPT09IHVuZGVmaW5lZCApIHtcblx0XHRcdGpRdWVyeS5ldmVudC5hZGQoIGVsLCB0eXBlLCByZXR1cm5UcnVlICk7XG5cdFx0fVxuXHRcdHJldHVybjtcblx0fVxuXG5cdC8vIFJlZ2lzdGVyIHRoZSBjb250cm9sbGVyIGFzIGEgc3BlY2lhbCB1bml2ZXJzYWwgaGFuZGxlciBmb3IgYWxsIGV2ZW50IG5hbWVzcGFjZXNcblx0ZGF0YVByaXYuc2V0KCBlbCwgdHlwZSwgZmFsc2UgKTtcblx0alF1ZXJ5LmV2ZW50LmFkZCggZWwsIHR5cGUsIHtcblx0XHRuYW1lc3BhY2U6IGZhbHNlLFxuXHRcdGhhbmRsZXI6IGZ1bmN0aW9uKCBldmVudCApIHtcblx0XHRcdHZhciByZXN1bHQsXG5cdFx0XHRcdHNhdmVkID0gZGF0YVByaXYuZ2V0KCB0aGlzLCB0eXBlICk7XG5cblx0XHRcdC8vIFRoaXMgY29udHJvbGxlciBmdW5jdGlvbiBpcyBpbnZva2VkIHVuZGVyIG11bHRpcGxlIGNpcmN1bXN0YW5jZXMsXG5cdFx0XHQvLyBkaWZmZXJlbnRpYXRlZCBieSB0aGUgc3RvcmVkIHZhbHVlIGluIGBzYXZlZGA6XG5cdFx0XHQvLyAxLiBGb3IgYW4gb3V0ZXIgc3ludGhldGljIGAudHJpZ2dlcigpYGVkIGV2ZW50IChkZXRlY3RlZCBieVxuXHRcdFx0Ly8gICAgYGV2ZW50LmlzVHJpZ2dlciAmIDFgIGFuZCBub24tYXJyYXkgYHNhdmVkYCksIGl0IHJlY29yZHMgYXJndW1lbnRzXG5cdFx0XHQvLyAgICBhcyBhbiBhcnJheSBhbmQgZmlyZXMgYW4gW2lubmVyXSBuYXRpdmUgZXZlbnQgdG8gcHJvbXB0IHN0YXRlXG5cdFx0XHQvLyAgICBjaGFuZ2VzIHRoYXQgc2hvdWxkIGJlIG9ic2VydmVkIGJ5IHJlZ2lzdGVyZWQgbGlzdGVuZXJzIChzdWNoIGFzXG5cdFx0XHQvLyAgICBjaGVja2JveCB0b2dnbGluZyBhbmQgZm9jdXMgdXBkYXRpbmcpLCB0aGVuIGNsZWFycyB0aGUgc3RvcmVkIHZhbHVlLlxuXHRcdFx0Ly8gMi4gRm9yIGFuIFtpbm5lcl0gbmF0aXZlIGV2ZW50IChkZXRlY3RlZCBieSBgc2F2ZWRgIGJlaW5nXG5cdFx0XHQvLyAgICBhbiBhcnJheSksIGl0IHRyaWdnZXJzIGFuIGlubmVyIHN5bnRoZXRpYyBldmVudCwgcmVjb3JkcyB0aGVcblx0XHRcdC8vICAgIHJlc3VsdCwgYW5kIHByZWVtcHRzIHByb3BhZ2F0aW9uIHRvIGZ1cnRoZXIgalF1ZXJ5IGxpc3RlbmVycy5cblx0XHRcdC8vIDMuIEZvciBhbiBpbm5lciBzeW50aGV0aWMgZXZlbnQgKGRldGVjdGVkIGJ5IGBldmVudC5pc1RyaWdnZXIgJiAxYCBhbmRcblx0XHRcdC8vICAgIGFycmF5IGBzYXZlZGApLCBpdCBwcmV2ZW50cyBkb3VibGUtcHJvcGFnYXRpb24gb2Ygc3Vycm9nYXRlIGV2ZW50c1xuXHRcdFx0Ly8gICAgYnV0IG90aGVyd2lzZSBhbGxvd3MgZXZlcnl0aGluZyB0byBwcm9jZWVkIChwYXJ0aWN1bGFybHkgaW5jbHVkaW5nXG5cdFx0XHQvLyAgICBmdXJ0aGVyIGxpc3RlbmVycykuXG5cdFx0XHQvLyBQb3NzaWJsZSBgc2F2ZWRgIGRhdGEgc2hhcGVzOiBgWy4uLl0sIGB7IHZhbHVlIH1gLCBgZmFsc2VgLlxuXHRcdFx0aWYgKCAoIGV2ZW50LmlzVHJpZ2dlciAmIDEgKSAmJiB0aGlzWyB0eXBlIF0gKSB7XG5cblx0XHRcdFx0Ly8gSW50ZXJydXB0IHByb2Nlc3Npbmcgb2YgdGhlIG91dGVyIHN5bnRoZXRpYyAudHJpZ2dlcigpZWQgZXZlbnRcblx0XHRcdFx0aWYgKCAhc2F2ZWQubGVuZ3RoICkge1xuXG5cdFx0XHRcdFx0Ly8gU3RvcmUgYXJndW1lbnRzIGZvciB1c2Ugd2hlbiBoYW5kbGluZyB0aGUgaW5uZXIgbmF0aXZlIGV2ZW50XG5cdFx0XHRcdFx0Ly8gVGhlcmUgd2lsbCBhbHdheXMgYmUgYXQgbGVhc3Qgb25lIGFyZ3VtZW50IChhbiBldmVudCBvYmplY3QpLFxuXHRcdFx0XHRcdC8vIHNvIHRoaXMgYXJyYXkgd2lsbCBub3QgYmUgY29uZnVzZWQgd2l0aCBhIGxlZnRvdmVyIGNhcHR1cmUgb2JqZWN0LlxuXHRcdFx0XHRcdHNhdmVkID0gc2xpY2UuY2FsbCggYXJndW1lbnRzICk7XG5cdFx0XHRcdFx0ZGF0YVByaXYuc2V0KCB0aGlzLCB0eXBlLCBzYXZlZCApO1xuXG5cdFx0XHRcdFx0Ly8gVHJpZ2dlciB0aGUgbmF0aXZlIGV2ZW50IGFuZCBjYXB0dXJlIGl0cyByZXN1bHRcblx0XHRcdFx0XHR0aGlzWyB0eXBlIF0oKTtcblx0XHRcdFx0XHRyZXN1bHQgPSBkYXRhUHJpdi5nZXQoIHRoaXMsIHR5cGUgKTtcblx0XHRcdFx0XHRkYXRhUHJpdi5zZXQoIHRoaXMsIHR5cGUsIGZhbHNlICk7XG5cblx0XHRcdFx0XHRpZiAoIHNhdmVkICE9PSByZXN1bHQgKSB7XG5cblx0XHRcdFx0XHRcdC8vIENhbmNlbCB0aGUgb3V0ZXIgc3ludGhldGljIGV2ZW50XG5cdFx0XHRcdFx0XHRldmVudC5zdG9wSW1tZWRpYXRlUHJvcGFnYXRpb24oKTtcblx0XHRcdFx0XHRcdGV2ZW50LnByZXZlbnREZWZhdWx0KCk7XG5cblx0XHRcdFx0XHRcdC8vIFN1cHBvcnQ6IENocm9tZSA4Nitcblx0XHRcdFx0XHRcdC8vIEluIENocm9tZSwgaWYgYW4gZWxlbWVudCBoYXZpbmcgYSBmb2N1c291dCBoYW5kbGVyIGlzXG5cdFx0XHRcdFx0XHQvLyBibHVycmVkIGJ5IGNsaWNraW5nIG91dHNpZGUgb2YgaXQsIGl0IGludm9rZXMgdGhlIGhhbmRsZXJcblx0XHRcdFx0XHRcdC8vIHN5bmNocm9ub3VzbHkuIElmIHRoYXQgaGFuZGxlciBjYWxscyBgLnJlbW92ZSgpYCBvblxuXHRcdFx0XHRcdFx0Ly8gdGhlIGVsZW1lbnQsIHRoZSBkYXRhIGlzIGNsZWFyZWQsIGxlYXZpbmcgYHJlc3VsdGBcblx0XHRcdFx0XHRcdC8vIHVuZGVmaW5lZC4gV2UgbmVlZCB0byBndWFyZCBhZ2FpbnN0IHRoaXMuXG5cdFx0XHRcdFx0XHRyZXR1cm4gcmVzdWx0ICYmIHJlc3VsdC52YWx1ZTtcblx0XHRcdFx0XHR9XG5cblx0XHRcdFx0Ly8gSWYgdGhpcyBpcyBhbiBpbm5lciBzeW50aGV0aWMgZXZlbnQgZm9yIGFuIGV2ZW50IHdpdGggYSBidWJibGluZ1xuXHRcdFx0XHQvLyBzdXJyb2dhdGUgKGZvY3VzIG9yIGJsdXIpLCBhc3N1bWUgdGhhdCB0aGUgc3Vycm9nYXRlIGFscmVhZHlcblx0XHRcdFx0Ly8gcHJvcGFnYXRlZCBmcm9tIHRyaWdnZXJpbmcgdGhlIG5hdGl2ZSBldmVudCBhbmQgcHJldmVudCB0aGF0XG5cdFx0XHRcdC8vIGZyb20gaGFwcGVuaW5nIGFnYWluIGhlcmUuXG5cdFx0XHRcdH0gZWxzZSBpZiAoICggalF1ZXJ5LmV2ZW50LnNwZWNpYWxbIHR5cGUgXSB8fCB7fSApLmRlbGVnYXRlVHlwZSApIHtcblx0XHRcdFx0XHRldmVudC5zdG9wUHJvcGFnYXRpb24oKTtcblx0XHRcdFx0fVxuXG5cdFx0XHQvLyBJZiB0aGlzIGlzIGEgbmF0aXZlIGV2ZW50IHRyaWdnZXJlZCBhYm92ZSwgZXZlcnl0aGluZyBpcyBub3cgaW4gb3JkZXIuXG5cdFx0XHQvLyBGaXJlIGFuIGlubmVyIHN5bnRoZXRpYyBldmVudCB3aXRoIHRoZSBvcmlnaW5hbCBhcmd1bWVudHMuXG5cdFx0XHR9IGVsc2UgaWYgKCBzYXZlZC5sZW5ndGggKSB7XG5cblx0XHRcdFx0Ly8gLi4uYW5kIGNhcHR1cmUgdGhlIHJlc3VsdFxuXHRcdFx0XHRkYXRhUHJpdi5zZXQoIHRoaXMsIHR5cGUsIHtcblx0XHRcdFx0XHR2YWx1ZTogalF1ZXJ5LmV2ZW50LnRyaWdnZXIoXG5cdFx0XHRcdFx0XHRzYXZlZFsgMCBdLFxuXHRcdFx0XHRcdFx0c2F2ZWQuc2xpY2UoIDEgKSxcblx0XHRcdFx0XHRcdHRoaXNcblx0XHRcdFx0XHQpXG5cdFx0XHRcdH0gKTtcblxuXHRcdFx0XHQvLyBBYm9ydCBoYW5kbGluZyBvZiB0aGUgbmF0aXZlIGV2ZW50IGJ5IGFsbCBqUXVlcnkgaGFuZGxlcnMgd2hpbGUgYWxsb3dpbmdcblx0XHRcdFx0Ly8gbmF0aXZlIGhhbmRsZXJzIG9uIHRoZSBzYW1lIGVsZW1lbnQgdG8gcnVuLiBPbiB0YXJnZXQsIHRoaXMgaXMgYWNoaWV2ZWRcblx0XHRcdFx0Ly8gYnkgc3RvcHBpbmcgaW1tZWRpYXRlIHByb3BhZ2F0aW9uIGp1c3Qgb24gdGhlIGpRdWVyeSBldmVudC4gSG93ZXZlcixcblx0XHRcdFx0Ly8gdGhlIG5hdGl2ZSBldmVudCBpcyByZS13cmFwcGVkIGJ5IGEgalF1ZXJ5IG9uZSBvbiBlYWNoIGxldmVsIG9mIHRoZVxuXHRcdFx0XHQvLyBwcm9wYWdhdGlvbiBzbyB0aGUgb25seSB3YXkgdG8gc3RvcCBpdCBmb3IgalF1ZXJ5IGlzIHRvIHN0b3AgaXQgZm9yXG5cdFx0XHRcdC8vIGV2ZXJ5b25lIHZpYSBuYXRpdmUgYHN0b3BQcm9wYWdhdGlvbigpYC4gVGhpcyBpcyBub3QgYSBwcm9ibGVtIGZvclxuXHRcdFx0XHQvLyBmb2N1cy9ibHVyIHdoaWNoIGRvbid0IGJ1YmJsZSwgYnV0IGl0IGRvZXMgYWxzbyBzdG9wIGNsaWNrIG9uIGNoZWNrYm94ZXNcblx0XHRcdFx0Ly8gYW5kIHJhZGlvcy4gV2UgYWNjZXB0IHRoaXMgbGltaXRhdGlvbi5cblx0XHRcdFx0ZXZlbnQuc3RvcFByb3BhZ2F0aW9uKCk7XG5cdFx0XHRcdGV2ZW50LmlzSW1tZWRpYXRlUHJvcGFnYXRpb25TdG9wcGVkID0gcmV0dXJuVHJ1ZTtcblx0XHRcdH1cblx0XHR9XG5cdH0gKTtcbn1cblxualF1ZXJ5LnJlbW92ZUV2ZW50ID0gZnVuY3Rpb24oIGVsZW0sIHR5cGUsIGhhbmRsZSApIHtcblxuXHQvLyBUaGlzIFwiaWZcIiBpcyBuZWVkZWQgZm9yIHBsYWluIG9iamVjdHNcblx0aWYgKCBlbGVtLnJlbW92ZUV2ZW50TGlzdGVuZXIgKSB7XG5cdFx0ZWxlbS5yZW1vdmVFdmVudExpc3RlbmVyKCB0eXBlLCBoYW5kbGUgKTtcblx0fVxufTtcblxualF1ZXJ5LkV2ZW50ID0gZnVuY3Rpb24oIHNyYywgcHJvcHMgKSB7XG5cblx0Ly8gQWxsb3cgaW5zdGFudGlhdGlvbiB3aXRob3V0IHRoZSAnbmV3JyBrZXl3b3JkXG5cdGlmICggISggdGhpcyBpbnN0YW5jZW9mIGpRdWVyeS5FdmVudCApICkge1xuXHRcdHJldHVybiBuZXcgalF1ZXJ5LkV2ZW50KCBzcmMsIHByb3BzICk7XG5cdH1cblxuXHQvLyBFdmVudCBvYmplY3Rcblx0aWYgKCBzcmMgJiYgc3JjLnR5cGUgKSB7XG5cdFx0dGhpcy5vcmlnaW5hbEV2ZW50ID0gc3JjO1xuXHRcdHRoaXMudHlwZSA9IHNyYy50eXBlO1xuXG5cdFx0Ly8gRXZlbnRzIGJ1YmJsaW5nIHVwIHRoZSBkb2N1bWVudCBtYXkgaGF2ZSBiZWVuIG1hcmtlZCBhcyBwcmV2ZW50ZWRcblx0XHQvLyBieSBhIGhhbmRsZXIgbG93ZXIgZG93biB0aGUgdHJlZTsgcmVmbGVjdCB0aGUgY29ycmVjdCB2YWx1ZS5cblx0XHR0aGlzLmlzRGVmYXVsdFByZXZlbnRlZCA9IHNyYy5kZWZhdWx0UHJldmVudGVkID9cblx0XHRcdHJldHVyblRydWUgOlxuXHRcdFx0cmV0dXJuRmFsc2U7XG5cblx0XHQvLyBDcmVhdGUgdGFyZ2V0IHByb3BlcnRpZXNcblx0XHR0aGlzLnRhcmdldCA9IHNyYy50YXJnZXQ7XG5cdFx0dGhpcy5jdXJyZW50VGFyZ2V0ID0gc3JjLmN1cnJlbnRUYXJnZXQ7XG5cdFx0dGhpcy5yZWxhdGVkVGFyZ2V0ID0gc3JjLnJlbGF0ZWRUYXJnZXQ7XG5cblx0Ly8gRXZlbnQgdHlwZVxuXHR9IGVsc2Uge1xuXHRcdHRoaXMudHlwZSA9IHNyYztcblx0fVxuXG5cdC8vIFB1dCBleHBsaWNpdGx5IHByb3ZpZGVkIHByb3BlcnRpZXMgb250byB0aGUgZXZlbnQgb2JqZWN0XG5cdGlmICggcHJvcHMgKSB7XG5cdFx0alF1ZXJ5LmV4dGVuZCggdGhpcywgcHJvcHMgKTtcblx0fVxuXG5cdC8vIENyZWF0ZSBhIHRpbWVzdGFtcCBpZiBpbmNvbWluZyBldmVudCBkb2Vzbid0IGhhdmUgb25lXG5cdHRoaXMudGltZVN0YW1wID0gc3JjICYmIHNyYy50aW1lU3RhbXAgfHwgRGF0ZS5ub3coKTtcblxuXHQvLyBNYXJrIGl0IGFzIGZpeGVkXG5cdHRoaXNbIGpRdWVyeS5leHBhbmRvIF0gPSB0cnVlO1xufTtcblxuLy8galF1ZXJ5LkV2ZW50IGlzIGJhc2VkIG9uIERPTTMgRXZlbnRzIGFzIHNwZWNpZmllZCBieSB0aGUgRUNNQVNjcmlwdCBMYW5ndWFnZSBCaW5kaW5nXG4vLyBodHRwczovL3d3dy53My5vcmcvVFIvMjAwMy9XRC1ET00tTGV2ZWwtMy1FdmVudHMtMjAwMzAzMzEvZWNtYS1zY3JpcHQtYmluZGluZy5odG1sXG5qUXVlcnkuRXZlbnQucHJvdG90eXBlID0ge1xuXHRjb25zdHJ1Y3RvcjogalF1ZXJ5LkV2ZW50LFxuXHRpc0RlZmF1bHRQcmV2ZW50ZWQ6IHJldHVybkZhbHNlLFxuXHRpc1Byb3BhZ2F0aW9uU3RvcHBlZDogcmV0dXJuRmFsc2UsXG5cdGlzSW1tZWRpYXRlUHJvcGFnYXRpb25TdG9wcGVkOiByZXR1cm5GYWxzZSxcblx0aXNTaW11bGF0ZWQ6IGZhbHNlLFxuXG5cdHByZXZlbnREZWZhdWx0OiBmdW5jdGlvbigpIHtcblx0XHR2YXIgZSA9IHRoaXMub3JpZ2luYWxFdmVudDtcblxuXHRcdHRoaXMuaXNEZWZhdWx0UHJldmVudGVkID0gcmV0dXJuVHJ1ZTtcblxuXHRcdGlmICggZSAmJiAhdGhpcy5pc1NpbXVsYXRlZCApIHtcblx0XHRcdGUucHJldmVudERlZmF1bHQoKTtcblx0XHR9XG5cdH0sXG5cdHN0b3BQcm9wYWdhdGlvbjogZnVuY3Rpb24oKSB7XG5cdFx0dmFyIGUgPSB0aGlzLm9yaWdpbmFsRXZlbnQ7XG5cblx0XHR0aGlzLmlzUHJvcGFnYXRpb25TdG9wcGVkID0gcmV0dXJuVHJ1ZTtcblxuXHRcdGlmICggZSAmJiAhdGhpcy5pc1NpbXVsYXRlZCApIHtcblx0XHRcdGUuc3RvcFByb3BhZ2F0aW9uKCk7XG5cdFx0fVxuXHR9LFxuXHRzdG9wSW1tZWRpYXRlUHJvcGFnYXRpb246IGZ1bmN0aW9uKCkge1xuXHRcdHZhciBlID0gdGhpcy5vcmlnaW5hbEV2ZW50O1xuXG5cdFx0dGhpcy5pc0ltbWVkaWF0ZVByb3BhZ2F0aW9uU3RvcHBlZCA9IHJldHVyblRydWU7XG5cblx0XHRpZiAoIGUgJiYgIXRoaXMuaXNTaW11bGF0ZWQgKSB7XG5cdFx0XHRlLnN0b3BJbW1lZGlhdGVQcm9wYWdhdGlvbigpO1xuXHRcdH1cblxuXHRcdHRoaXMuc3RvcFByb3BhZ2F0aW9uKCk7XG5cdH1cbn07XG5cbi8vIEluY2x1ZGVzIGFsbCBjb21tb24gZXZlbnQgcHJvcHMgaW5jbHVkaW5nIEtleUV2ZW50IGFuZCBNb3VzZUV2ZW50IHNwZWNpZmljIHByb3BzXG5qUXVlcnkuZWFjaCgge1xuXHRhbHRLZXk6IHRydWUsXG5cdGJ1YmJsZXM6IHRydWUsXG5cdGNhbmNlbGFibGU6IHRydWUsXG5cdGNoYW5nZWRUb3VjaGVzOiB0cnVlLFxuXHRjdHJsS2V5OiB0cnVlLFxuXHRkZXRhaWw6IHRydWUsXG5cdGV2ZW50UGhhc2U6IHRydWUsXG5cdG1ldGFLZXk6IHRydWUsXG5cdHBhZ2VYOiB0cnVlLFxuXHRwYWdlWTogdHJ1ZSxcblx0c2hpZnRLZXk6IHRydWUsXG5cdHZpZXc6IHRydWUsXG5cdFwiY2hhclwiOiB0cnVlLFxuXHRjb2RlOiB0cnVlLFxuXHRjaGFyQ29kZTogdHJ1ZSxcblx0a2V5OiB0cnVlLFxuXHRrZXlDb2RlOiB0cnVlLFxuXHRidXR0b246IHRydWUsXG5cdGJ1dHRvbnM6IHRydWUsXG5cdGNsaWVudFg6IHRydWUsXG5cdGNsaWVudFk6IHRydWUsXG5cdG9mZnNldFg6IHRydWUsXG5cdG9mZnNldFk6IHRydWUsXG5cdHBvaW50ZXJJZDogdHJ1ZSxcblx0cG9pbnRlclR5cGU6IHRydWUsXG5cdHNjcmVlblg6IHRydWUsXG5cdHNjcmVlblk6IHRydWUsXG5cdHRhcmdldFRvdWNoZXM6IHRydWUsXG5cdHRvRWxlbWVudDogdHJ1ZSxcblx0dG91Y2hlczogdHJ1ZSxcblx0d2hpY2g6IHRydWVcbn0sIGpRdWVyeS5ldmVudC5hZGRQcm9wICk7XG5cbmpRdWVyeS5lYWNoKCB7IGZvY3VzOiBcImZvY3VzaW5cIiwgYmx1cjogXCJmb2N1c291dFwiIH0sIGZ1bmN0aW9uKCB0eXBlLCBkZWxlZ2F0ZVR5cGUgKSB7XG5cblx0Ly8gU3VwcG9ydDogSUUgMTErXG5cdC8vIEF0dGFjaCBhIHNpbmdsZSBmb2N1c2luL2ZvY3Vzb3V0IGhhbmRsZXIgb24gdGhlIGRvY3VtZW50IHdoaWxlIHNvbWVvbmUgd2FudHMgZm9jdXMvYmx1ci5cblx0Ly8gVGhpcyBpcyBiZWNhdXNlIHRoZSBmb3JtZXIgYXJlIHN5bmNocm9ub3VzIGluIElFIHdoaWxlIHRoZSBsYXR0ZXIgYXJlIGFzeW5jLiBJbiBvdGhlclxuXHQvLyBicm93c2VycywgYWxsIHRob3NlIGhhbmRsZXJzIGFyZSBpbnZva2VkIHN5bmNocm9ub3VzbHkuXG5cdGZ1bmN0aW9uIGZvY3VzTWFwcGVkSGFuZGxlciggbmF0aXZlRXZlbnQgKSB7XG5cblx0XHQvLyBgZXZlbnRIYW5kbGVgIHdvdWxkIGFscmVhZHkgd3JhcCB0aGUgZXZlbnQsIGJ1dCB3ZSBuZWVkIHRvIGNoYW5nZSB0aGUgYHR5cGVgIGhlcmUuXG5cdFx0dmFyIGV2ZW50ID0galF1ZXJ5LmV2ZW50LmZpeCggbmF0aXZlRXZlbnQgKTtcblx0XHRldmVudC50eXBlID0gbmF0aXZlRXZlbnQudHlwZSA9PT0gXCJmb2N1c2luXCIgPyBcImZvY3VzXCIgOiBcImJsdXJcIjtcblx0XHRldmVudC5pc1NpbXVsYXRlZCA9IHRydWU7XG5cblx0XHQvLyBmb2N1cy9ibHVyIGRvbid0IGJ1YmJsZSB3aGlsZSBmb2N1c2luL2ZvY3Vzb3V0IGRvOyBzaW11bGF0ZSB0aGUgZm9ybWVyIGJ5IG9ubHlcblx0XHQvLyBpbnZva2luZyB0aGUgaGFuZGxlciBhdCB0aGUgbG93ZXIgbGV2ZWwuXG5cdFx0aWYgKCBldmVudC50YXJnZXQgPT09IGV2ZW50LmN1cnJlbnRUYXJnZXQgKSB7XG5cblx0XHRcdC8vIFRoZSBzZXR1cCBwYXJ0IGNhbGxzIGBsZXZlcmFnZU5hdGl2ZWAsIHdoaWNoLCBpbiB0dXJuLCBjYWxsc1xuXHRcdFx0Ly8gYGpRdWVyeS5ldmVudC5hZGRgLCBzbyBldmVudCBoYW5kbGUgd2lsbCBhbHJlYWR5IGhhdmUgYmVlbiBzZXRcblx0XHRcdC8vIGJ5IHRoaXMgcG9pbnQuXG5cdFx0XHRkYXRhUHJpdi5nZXQoIHRoaXMsIFwiaGFuZGxlXCIgKSggZXZlbnQgKTtcblx0XHR9XG5cdH1cblxuXHRqUXVlcnkuZXZlbnQuc3BlY2lhbFsgdHlwZSBdID0ge1xuXG5cdFx0Ly8gVXRpbGl6ZSBuYXRpdmUgZXZlbnQgaWYgcG9zc2libGUgc28gYmx1ci9mb2N1cyBzZXF1ZW5jZSBpcyBjb3JyZWN0XG5cdFx0c2V0dXA6IGZ1bmN0aW9uKCkge1xuXG5cdFx0XHQvLyBDbGFpbSB0aGUgZmlyc3QgaGFuZGxlclxuXHRcdFx0Ly8gZGF0YVByaXYuc2V0KCB0aGlzLCBcImZvY3VzXCIsIC4uLiApXG5cdFx0XHQvLyBkYXRhUHJpdi5zZXQoIHRoaXMsIFwiYmx1clwiLCAuLi4gKVxuXHRcdFx0bGV2ZXJhZ2VOYXRpdmUoIHRoaXMsIHR5cGUsIHRydWUgKTtcblxuXHRcdFx0aWYgKCBpc0lFICkge1xuXHRcdFx0XHR0aGlzLmFkZEV2ZW50TGlzdGVuZXIoIGRlbGVnYXRlVHlwZSwgZm9jdXNNYXBwZWRIYW5kbGVyICk7XG5cdFx0XHR9IGVsc2Uge1xuXG5cdFx0XHRcdC8vIFJldHVybiBmYWxzZSB0byBhbGxvdyBub3JtYWwgcHJvY2Vzc2luZyBpbiB0aGUgY2FsbGVyXG5cdFx0XHRcdHJldHVybiBmYWxzZTtcblx0XHRcdH1cblx0XHR9LFxuXHRcdHRyaWdnZXI6IGZ1bmN0aW9uKCkge1xuXG5cdFx0XHQvLyBGb3JjZSBzZXR1cCBiZWZvcmUgdHJpZ2dlclxuXHRcdFx0bGV2ZXJhZ2VOYXRpdmUoIHRoaXMsIHR5cGUgKTtcblxuXHRcdFx0Ly8gUmV0dXJuIG5vbi1mYWxzZSB0byBhbGxvdyBub3JtYWwgZXZlbnQtcGF0aCBwcm9wYWdhdGlvblxuXHRcdFx0cmV0dXJuIHRydWU7XG5cdFx0fSxcblxuXHRcdHRlYXJkb3duOiBmdW5jdGlvbigpIHtcblx0XHRcdGlmICggaXNJRSApIHtcblx0XHRcdFx0dGhpcy5yZW1vdmVFdmVudExpc3RlbmVyKCBkZWxlZ2F0ZVR5cGUsIGZvY3VzTWFwcGVkSGFuZGxlciApO1xuXHRcdFx0fSBlbHNlIHtcblxuXHRcdFx0XHQvLyBSZXR1cm4gZmFsc2UgdG8gaW5kaWNhdGUgc3RhbmRhcmQgdGVhcmRvd24gc2hvdWxkIGJlIGFwcGxpZWRcblx0XHRcdFx0cmV0dXJuIGZhbHNlO1xuXHRcdFx0fVxuXHRcdH0sXG5cblx0XHQvLyBTdXBwcmVzcyBuYXRpdmUgZm9jdXMgb3IgYmx1ciBpZiB3ZSdyZSBjdXJyZW50bHkgaW5zaWRlXG5cdFx0Ly8gYSBsZXZlcmFnZWQgbmF0aXZlLWV2ZW50IHN0YWNrXG5cdFx0X2RlZmF1bHQ6IGZ1bmN0aW9uKCBldmVudCApIHtcblx0XHRcdHJldHVybiBkYXRhUHJpdi5nZXQoIGV2ZW50LnRhcmdldCwgdHlwZSApO1xuXHRcdH0sXG5cblx0XHRkZWxlZ2F0ZVR5cGU6IGRlbGVnYXRlVHlwZVxuXHR9O1xufSApO1xuXG4vLyBDcmVhdGUgbW91c2VlbnRlci9sZWF2ZSBldmVudHMgdXNpbmcgbW91c2VvdmVyL291dCBhbmQgZXZlbnQtdGltZSBjaGVja3Ncbi8vIHNvIHRoYXQgZXZlbnQgZGVsZWdhdGlvbiB3b3JrcyBpbiBqUXVlcnkuXG4vLyBEbyB0aGUgc2FtZSBmb3IgcG9pbnRlcmVudGVyL3BvaW50ZXJsZWF2ZSBhbmQgcG9pbnRlcm92ZXIvcG9pbnRlcm91dFxualF1ZXJ5LmVhY2goIHtcblx0bW91c2VlbnRlcjogXCJtb3VzZW92ZXJcIixcblx0bW91c2VsZWF2ZTogXCJtb3VzZW91dFwiLFxuXHRwb2ludGVyZW50ZXI6IFwicG9pbnRlcm92ZXJcIixcblx0cG9pbnRlcmxlYXZlOiBcInBvaW50ZXJvdXRcIlxufSwgZnVuY3Rpb24oIG9yaWcsIGZpeCApIHtcblx0alF1ZXJ5LmV2ZW50LnNwZWNpYWxbIG9yaWcgXSA9IHtcblx0XHRkZWxlZ2F0ZVR5cGU6IGZpeCxcblx0XHRiaW5kVHlwZTogZml4LFxuXG5cdFx0aGFuZGxlOiBmdW5jdGlvbiggZXZlbnQgKSB7XG5cdFx0XHR2YXIgcmV0LFxuXHRcdFx0XHR0YXJnZXQgPSB0aGlzLFxuXHRcdFx0XHRyZWxhdGVkID0gZXZlbnQucmVsYXRlZFRhcmdldCxcblx0XHRcdFx0aGFuZGxlT2JqID0gZXZlbnQuaGFuZGxlT2JqO1xuXG5cdFx0XHQvLyBGb3IgbW91c2VlbnRlci9sZWF2ZSBjYWxsIHRoZSBoYW5kbGVyIGlmIHJlbGF0ZWQgaXMgb3V0c2lkZSB0aGUgdGFyZ2V0LlxuXHRcdFx0Ly8gTkI6IE5vIHJlbGF0ZWRUYXJnZXQgaWYgdGhlIG1vdXNlIGxlZnQvZW50ZXJlZCB0aGUgYnJvd3NlciB3aW5kb3dcblx0XHRcdGlmICggIXJlbGF0ZWQgfHwgKCByZWxhdGVkICE9PSB0YXJnZXQgJiYgIWpRdWVyeS5jb250YWlucyggdGFyZ2V0LCByZWxhdGVkICkgKSApIHtcblx0XHRcdFx0ZXZlbnQudHlwZSA9IGhhbmRsZU9iai5vcmlnVHlwZTtcblx0XHRcdFx0cmV0ID0gaGFuZGxlT2JqLmhhbmRsZXIuYXBwbHkoIHRoaXMsIGFyZ3VtZW50cyApO1xuXHRcdFx0XHRldmVudC50eXBlID0gZml4O1xuXHRcdFx0fVxuXHRcdFx0cmV0dXJuIHJldDtcblx0XHR9XG5cdH07XG59ICk7XG5cbmpRdWVyeS5mbi5leHRlbmQoIHtcblxuXHRvbjogZnVuY3Rpb24oIHR5cGVzLCBzZWxlY3RvciwgZGF0YSwgZm4gKSB7XG5cdFx0cmV0dXJuIG9uKCB0aGlzLCB0eXBlcywgc2VsZWN0b3IsIGRhdGEsIGZuICk7XG5cdH0sXG5cdG9uZTogZnVuY3Rpb24oIHR5cGVzLCBzZWxlY3RvciwgZGF0YSwgZm4gKSB7XG5cdFx0cmV0dXJuIG9uKCB0aGlzLCB0eXBlcywgc2VsZWN0b3IsIGRhdGEsIGZuLCAxICk7XG5cdH0sXG5cdG9mZjogZnVuY3Rpb24oIHR5cGVzLCBzZWxlY3RvciwgZm4gKSB7XG5cdFx0dmFyIGhhbmRsZU9iaiwgdHlwZTtcblx0XHRpZiAoIHR5cGVzICYmIHR5cGVzLnByZXZlbnREZWZhdWx0ICYmIHR5cGVzLmhhbmRsZU9iaiApIHtcblxuXHRcdFx0Ly8gKCBldmVudCApICBkaXNwYXRjaGVkIGpRdWVyeS5FdmVudFxuXHRcdFx0aGFuZGxlT2JqID0gdHlwZXMuaGFuZGxlT2JqO1xuXHRcdFx0alF1ZXJ5KCB0eXBlcy5kZWxlZ2F0ZVRhcmdldCApLm9mZihcblx0XHRcdFx0aGFuZGxlT2JqLm5hbWVzcGFjZSA/XG5cdFx0XHRcdFx0aGFuZGxlT2JqLm9yaWdUeXBlICsgXCIuXCIgKyBoYW5kbGVPYmoubmFtZXNwYWNlIDpcblx0XHRcdFx0XHRoYW5kbGVPYmoub3JpZ1R5cGUsXG5cdFx0XHRcdGhhbmRsZU9iai5zZWxlY3Rvcixcblx0XHRcdFx0aGFuZGxlT2JqLmhhbmRsZXJcblx0XHRcdCk7XG5cdFx0XHRyZXR1cm4gdGhpcztcblx0XHR9XG5cdFx0aWYgKCB0eXBlb2YgdHlwZXMgPT09IFwib2JqZWN0XCIgKSB7XG5cblx0XHRcdC8vICggdHlwZXMtb2JqZWN0IFssIHNlbGVjdG9yXSApXG5cdFx0XHRmb3IgKCB0eXBlIGluIHR5cGVzICkge1xuXHRcdFx0XHR0aGlzLm9mZiggdHlwZSwgc2VsZWN0b3IsIHR5cGVzWyB0eXBlIF0gKTtcblx0XHRcdH1cblx0XHRcdHJldHVybiB0aGlzO1xuXHRcdH1cblx0XHRpZiAoIHNlbGVjdG9yID09PSBmYWxzZSB8fCB0eXBlb2Ygc2VsZWN0b3IgPT09IFwiZnVuY3Rpb25cIiApIHtcblxuXHRcdFx0Ly8gKCB0eXBlcyBbLCBmbl0gKVxuXHRcdFx0Zm4gPSBzZWxlY3Rvcjtcblx0XHRcdHNlbGVjdG9yID0gdW5kZWZpbmVkO1xuXHRcdH1cblx0XHRpZiAoIGZuID09PSBmYWxzZSApIHtcblx0XHRcdGZuID0gcmV0dXJuRmFsc2U7XG5cdFx0fVxuXHRcdHJldHVybiB0aGlzLmVhY2goIGZ1bmN0aW9uKCkge1xuXHRcdFx0alF1ZXJ5LmV2ZW50LnJlbW92ZSggdGhpcywgdHlwZXMsIGZuLCBzZWxlY3RvciApO1xuXHRcdH0gKTtcblx0fVxufSApO1xuXG52YXJcblxuXHQvLyBTdXBwb3J0OiBJRSA8PTEwIC0gMTErXG5cdC8vIEluIElFIHVzaW5nIHJlZ2V4IGdyb3VwcyBoZXJlIGNhdXNlcyBzZXZlcmUgc2xvd2Rvd25zLlxuXHRybm9Jbm5lcmh0bWwgPSAvPHNjcmlwdHw8c3R5bGV8PGxpbmsvaTtcblxuLy8gUHJlZmVyIGEgdGJvZHkgb3ZlciBpdHMgcGFyZW50IHRhYmxlIGZvciBjb250YWluaW5nIG5ldyByb3dzXG5mdW5jdGlvbiBtYW5pcHVsYXRpb25UYXJnZXQoIGVsZW0sIGNvbnRlbnQgKSB7XG5cdGlmICggbm9kZU5hbWUoIGVsZW0sIFwidGFibGVcIiApICYmXG5cdFx0bm9kZU5hbWUoIGNvbnRlbnQubm9kZVR5cGUgIT09IDExID8gY29udGVudCA6IGNvbnRlbnQuZmlyc3RDaGlsZCwgXCJ0clwiICkgKSB7XG5cblx0XHRyZXR1cm4galF1ZXJ5KCBlbGVtICkuY2hpbGRyZW4oIFwidGJvZHlcIiApWyAwIF0gfHwgZWxlbTtcblx0fVxuXG5cdHJldHVybiBlbGVtO1xufVxuXG5mdW5jdGlvbiBjbG9uZUNvcHlFdmVudCggc3JjLCBkZXN0ICkge1xuXHR2YXIgdHlwZSwgaSwgbCxcblx0XHRldmVudHMgPSBkYXRhUHJpdi5nZXQoIHNyYywgXCJldmVudHNcIiApO1xuXG5cdGlmICggZGVzdC5ub2RlVHlwZSAhPT0gMSApIHtcblx0XHRyZXR1cm47XG5cdH1cblxuXHQvLyAxLiBDb3B5IHByaXZhdGUgZGF0YTogZXZlbnRzLCBoYW5kbGVycywgZXRjLlxuXHRpZiAoIGV2ZW50cyApIHtcblx0XHRkYXRhUHJpdi5yZW1vdmUoIGRlc3QsIFwiaGFuZGxlIGV2ZW50c1wiICk7XG5cdFx0Zm9yICggdHlwZSBpbiBldmVudHMgKSB7XG5cdFx0XHRmb3IgKCBpID0gMCwgbCA9IGV2ZW50c1sgdHlwZSBdLmxlbmd0aDsgaSA8IGw7IGkrKyApIHtcblx0XHRcdFx0alF1ZXJ5LmV2ZW50LmFkZCggZGVzdCwgdHlwZSwgZXZlbnRzWyB0eXBlIF1bIGkgXSApO1xuXHRcdFx0fVxuXHRcdH1cblx0fVxuXG5cdC8vIDIuIENvcHkgdXNlciBkYXRhXG5cdGlmICggZGF0YVVzZXIuaGFzRGF0YSggc3JjICkgKSB7XG5cdFx0ZGF0YVVzZXIuc2V0KCBkZXN0LCBqUXVlcnkuZXh0ZW5kKCB7fSwgZGF0YVVzZXIuZ2V0KCBzcmMgKSApICk7XG5cdH1cbn1cblxuZnVuY3Rpb24gcmVtb3ZlKCBlbGVtLCBzZWxlY3Rvciwga2VlcERhdGEgKSB7XG5cdHZhciBub2RlLFxuXHRcdG5vZGVzID0gc2VsZWN0b3IgPyBqUXVlcnkuZmlsdGVyKCBzZWxlY3RvciwgZWxlbSApIDogZWxlbSxcblx0XHRpID0gMDtcblxuXHRmb3IgKCA7ICggbm9kZSA9IG5vZGVzWyBpIF0gKSAhPSBudWxsOyBpKysgKSB7XG5cdFx0aWYgKCAha2VlcERhdGEgJiYgbm9kZS5ub2RlVHlwZSA9PT0gMSApIHtcblx0XHRcdGpRdWVyeS5jbGVhbkRhdGEoIGdldEFsbCggbm9kZSApICk7XG5cdFx0fVxuXG5cdFx0aWYgKCBub2RlLnBhcmVudE5vZGUgKSB7XG5cdFx0XHRpZiAoIGtlZXBEYXRhICYmIGlzQXR0YWNoZWQoIG5vZGUgKSApIHtcblx0XHRcdFx0c2V0R2xvYmFsRXZhbCggZ2V0QWxsKCBub2RlLCBcInNjcmlwdFwiICkgKTtcblx0XHRcdH1cblx0XHRcdG5vZGUucGFyZW50Tm9kZS5yZW1vdmVDaGlsZCggbm9kZSApO1xuXHRcdH1cblx0fVxuXG5cdHJldHVybiBlbGVtO1xufVxuXG5qUXVlcnkuZXh0ZW5kKCB7XG5cdGh0bWxQcmVmaWx0ZXI6IGZ1bmN0aW9uKCBodG1sICkge1xuXHRcdHJldHVybiBodG1sO1xuXHR9LFxuXG5cdGNsb25lOiBmdW5jdGlvbiggZWxlbSwgZGF0YUFuZEV2ZW50cywgZGVlcERhdGFBbmRFdmVudHMgKSB7XG5cdFx0dmFyIGksIGwsIHNyY0VsZW1lbnRzLCBkZXN0RWxlbWVudHMsXG5cdFx0XHRjbG9uZSA9IGVsZW0uY2xvbmVOb2RlKCB0cnVlICksXG5cdFx0XHRpblBhZ2UgPSBpc0F0dGFjaGVkKCBlbGVtICk7XG5cblx0XHQvLyBGaXggSUUgY2xvbmluZyBpc3N1ZXNcblx0XHRpZiAoIGlzSUUgJiYgKCBlbGVtLm5vZGVUeXBlID09PSAxIHx8IGVsZW0ubm9kZVR5cGUgPT09IDExICkgJiZcblx0XHRcdFx0IWpRdWVyeS5pc1hNTERvYyggZWxlbSApICkge1xuXG5cdFx0XHQvLyBXZSBlc2NoZXcgalF1ZXJ5I2ZpbmQgaGVyZSBmb3IgcGVyZm9ybWFuY2UgcmVhc29uczpcblx0XHRcdC8vIGh0dHBzOi8vanNwZXJmLmNvbS9nZXRhbGwtdnMtc2l6emxlLzJcblx0XHRcdGRlc3RFbGVtZW50cyA9IGdldEFsbCggY2xvbmUgKTtcblx0XHRcdHNyY0VsZW1lbnRzID0gZ2V0QWxsKCBlbGVtICk7XG5cblx0XHRcdGZvciAoIGkgPSAwLCBsID0gc3JjRWxlbWVudHMubGVuZ3RoOyBpIDwgbDsgaSsrICkge1xuXG5cdFx0XHRcdC8vIFN1cHBvcnQ6IElFIDw9MTErXG5cdFx0XHRcdC8vIElFIGZhaWxzIHRvIHNldCB0aGUgZGVmYXVsdFZhbHVlIHRvIHRoZSBjb3JyZWN0IHZhbHVlIHdoZW5cblx0XHRcdFx0Ly8gY2xvbmluZyB0ZXh0YXJlYXMuXG5cdFx0XHRcdGlmICggbm9kZU5hbWUoIGRlc3RFbGVtZW50c1sgaSBdLCBcInRleHRhcmVhXCIgKSApIHtcblx0XHRcdFx0XHRkZXN0RWxlbWVudHNbIGkgXS5kZWZhdWx0VmFsdWUgPSBzcmNFbGVtZW50c1sgaSBdLmRlZmF1bHRWYWx1ZTtcblx0XHRcdFx0fVxuXHRcdFx0fVxuXHRcdH1cblxuXHRcdC8vIENvcHkgdGhlIGV2ZW50cyBmcm9tIHRoZSBvcmlnaW5hbCB0byB0aGUgY2xvbmVcblx0XHRpZiAoIGRhdGFBbmRFdmVudHMgKSB7XG5cdFx0XHRpZiAoIGRlZXBEYXRhQW5kRXZlbnRzICkge1xuXHRcdFx0XHRzcmNFbGVtZW50cyA9IHNyY0VsZW1lbnRzIHx8IGdldEFsbCggZWxlbSApO1xuXHRcdFx0XHRkZXN0RWxlbWVudHMgPSBkZXN0RWxlbWVudHMgfHwgZ2V0QWxsKCBjbG9uZSApO1xuXG5cdFx0XHRcdGZvciAoIGkgPSAwLCBsID0gc3JjRWxlbWVudHMubGVuZ3RoOyBpIDwgbDsgaSsrICkge1xuXHRcdFx0XHRcdGNsb25lQ29weUV2ZW50KCBzcmNFbGVtZW50c1sgaSBdLCBkZXN0RWxlbWVudHNbIGkgXSApO1xuXHRcdFx0XHR9XG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRjbG9uZUNvcHlFdmVudCggZWxlbSwgY2xvbmUgKTtcblx0XHRcdH1cblx0XHR9XG5cblx0XHQvLyBQcmVzZXJ2ZSBzY3JpcHQgZXZhbHVhdGlvbiBoaXN0b3J5XG5cdFx0ZGVzdEVsZW1lbnRzID0gZ2V0QWxsKCBjbG9uZSwgXCJzY3JpcHRcIiApO1xuXHRcdGlmICggZGVzdEVsZW1lbnRzLmxlbmd0aCA+IDAgKSB7XG5cdFx0XHRzZXRHbG9iYWxFdmFsKCBkZXN0RWxlbWVudHMsICFpblBhZ2UgJiYgZ2V0QWxsKCBlbGVtLCBcInNjcmlwdFwiICkgKTtcblx0XHR9XG5cblx0XHQvLyBSZXR1cm4gdGhlIGNsb25lZCBzZXRcblx0XHRyZXR1cm4gY2xvbmU7XG5cdH0sXG5cblx0Y2xlYW5EYXRhOiBmdW5jdGlvbiggZWxlbXMgKSB7XG5cdFx0dmFyIGRhdGEsIGVsZW0sIHR5cGUsXG5cdFx0XHRzcGVjaWFsID0galF1ZXJ5LmV2ZW50LnNwZWNpYWwsXG5cdFx0XHRpID0gMDtcblxuXHRcdGZvciAoIDsgKCBlbGVtID0gZWxlbXNbIGkgXSApICE9PSB1bmRlZmluZWQ7IGkrKyApIHtcblx0XHRcdGlmICggYWNjZXB0RGF0YSggZWxlbSApICkge1xuXHRcdFx0XHRpZiAoICggZGF0YSA9IGVsZW1bIGRhdGFQcml2LmV4cGFuZG8gXSApICkge1xuXHRcdFx0XHRcdGlmICggZGF0YS5ldmVudHMgKSB7XG5cdFx0XHRcdFx0XHRmb3IgKCB0eXBlIGluIGRhdGEuZXZlbnRzICkge1xuXHRcdFx0XHRcdFx0XHRpZiAoIHNwZWNpYWxbIHR5cGUgXSApIHtcblx0XHRcdFx0XHRcdFx0XHRqUXVlcnkuZXZlbnQucmVtb3ZlKCBlbGVtLCB0eXBlICk7XG5cblx0XHRcdFx0XHRcdFx0Ly8gVGhpcyBpcyBhIHNob3J0Y3V0IHRvIGF2b2lkIGpRdWVyeS5ldmVudC5yZW1vdmUncyBvdmVyaGVhZFxuXHRcdFx0XHRcdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRcdFx0XHRcdGpRdWVyeS5yZW1vdmVFdmVudCggZWxlbSwgdHlwZSwgZGF0YS5oYW5kbGUgKTtcblx0XHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdH1cblxuXHRcdFx0XHRcdC8vIFN1cHBvcnQ6IENocm9tZSA8PTM1IC0gNDUrXG5cdFx0XHRcdFx0Ly8gQXNzaWduIHVuZGVmaW5lZCBpbnN0ZWFkIG9mIHVzaW5nIGRlbGV0ZSwgc2VlIERhdGEjcmVtb3ZlXG5cdFx0XHRcdFx0ZWxlbVsgZGF0YVByaXYuZXhwYW5kbyBdID0gdW5kZWZpbmVkO1xuXHRcdFx0XHR9XG5cdFx0XHRcdGlmICggZWxlbVsgZGF0YVVzZXIuZXhwYW5kbyBdICkge1xuXG5cdFx0XHRcdFx0Ly8gU3VwcG9ydDogQ2hyb21lIDw9MzUgLSA0NStcblx0XHRcdFx0XHQvLyBBc3NpZ24gdW5kZWZpbmVkIGluc3RlYWQgb2YgdXNpbmcgZGVsZXRlLCBzZWUgRGF0YSNyZW1vdmVcblx0XHRcdFx0XHRlbGVtWyBkYXRhVXNlci5leHBhbmRvIF0gPSB1bmRlZmluZWQ7XG5cdFx0XHRcdH1cblx0XHRcdH1cblx0XHR9XG5cdH1cbn0gKTtcblxualF1ZXJ5LmZuLmV4dGVuZCgge1xuXHRkZXRhY2g6IGZ1bmN0aW9uKCBzZWxlY3RvciApIHtcblx0XHRyZXR1cm4gcmVtb3ZlKCB0aGlzLCBzZWxlY3RvciwgdHJ1ZSApO1xuXHR9LFxuXG5cdHJlbW92ZTogZnVuY3Rpb24oIHNlbGVjdG9yICkge1xuXHRcdHJldHVybiByZW1vdmUoIHRoaXMsIHNlbGVjdG9yICk7XG5cdH0sXG5cblx0dGV4dDogZnVuY3Rpb24oIHZhbHVlICkge1xuXHRcdHJldHVybiBhY2Nlc3MoIHRoaXMsIGZ1bmN0aW9uKCB2YWx1ZSApIHtcblx0XHRcdHJldHVybiB2YWx1ZSA9PT0gdW5kZWZpbmVkID9cblx0XHRcdFx0alF1ZXJ5LnRleHQoIHRoaXMgKSA6XG5cdFx0XHRcdHRoaXMuZW1wdHkoKS5lYWNoKCBmdW5jdGlvbigpIHtcblx0XHRcdFx0XHRpZiAoIHRoaXMubm9kZVR5cGUgPT09IDEgfHwgdGhpcy5ub2RlVHlwZSA9PT0gMTEgfHwgdGhpcy5ub2RlVHlwZSA9PT0gOSApIHtcblx0XHRcdFx0XHRcdHRoaXMudGV4dENvbnRlbnQgPSB2YWx1ZTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH0gKTtcblx0XHR9LCBudWxsLCB2YWx1ZSwgYXJndW1lbnRzLmxlbmd0aCApO1xuXHR9LFxuXG5cdGFwcGVuZDogZnVuY3Rpb24oKSB7XG5cdFx0cmV0dXJuIGRvbU1hbmlwKCB0aGlzLCBhcmd1bWVudHMsIGZ1bmN0aW9uKCBlbGVtICkge1xuXHRcdFx0aWYgKCB0aGlzLm5vZGVUeXBlID09PSAxIHx8IHRoaXMubm9kZVR5cGUgPT09IDExIHx8IHRoaXMubm9kZVR5cGUgPT09IDkgKSB7XG5cdFx0XHRcdHZhciB0YXJnZXQgPSBtYW5pcHVsYXRpb25UYXJnZXQoIHRoaXMsIGVsZW0gKTtcblx0XHRcdFx0dGFyZ2V0LmFwcGVuZENoaWxkKCBlbGVtICk7XG5cdFx0XHR9XG5cdFx0fSApO1xuXHR9LFxuXG5cdHByZXBlbmQ6IGZ1bmN0aW9uKCkge1xuXHRcdHJldHVybiBkb21NYW5pcCggdGhpcywgYXJndW1lbnRzLCBmdW5jdGlvbiggZWxlbSApIHtcblx0XHRcdGlmICggdGhpcy5ub2RlVHlwZSA9PT0gMSB8fCB0aGlzLm5vZGVUeXBlID09PSAxMSB8fCB0aGlzLm5vZGVUeXBlID09PSA5ICkge1xuXHRcdFx0XHR2YXIgdGFyZ2V0ID0gbWFuaXB1bGF0aW9uVGFyZ2V0KCB0aGlzLCBlbGVtICk7XG5cdFx0XHRcdHRhcmdldC5pbnNlcnRCZWZvcmUoIGVsZW0sIHRhcmdldC5maXJzdENoaWxkICk7XG5cdFx0XHR9XG5cdFx0fSApO1xuXHR9LFxuXG5cdGJlZm9yZTogZnVuY3Rpb24oKSB7XG5cdFx0cmV0dXJuIGRvbU1hbmlwKCB0aGlzLCBhcmd1bWVudHMsIGZ1bmN0aW9uKCBlbGVtICkge1xuXHRcdFx0aWYgKCB0aGlzLnBhcmVudE5vZGUgKSB7XG5cdFx0XHRcdHRoaXMucGFyZW50Tm9kZS5pbnNlcnRCZWZvcmUoIGVsZW0sIHRoaXMgKTtcblx0XHRcdH1cblx0XHR9ICk7XG5cdH0sXG5cblx0YWZ0ZXI6IGZ1bmN0aW9uKCkge1xuXHRcdHJldHVybiBkb21NYW5pcCggdGhpcywgYXJndW1lbnRzLCBmdW5jdGlvbiggZWxlbSApIHtcblx0XHRcdGlmICggdGhpcy5wYXJlbnROb2RlICkge1xuXHRcdFx0XHR0aGlzLnBhcmVudE5vZGUuaW5zZXJ0QmVmb3JlKCBlbGVtLCB0aGlzLm5leHRTaWJsaW5nICk7XG5cdFx0XHR9XG5cdFx0fSApO1xuXHR9LFxuXG5cdGVtcHR5OiBmdW5jdGlvbigpIHtcblx0XHR2YXIgZWxlbSxcblx0XHRcdGkgPSAwO1xuXG5cdFx0Zm9yICggOyAoIGVsZW0gPSB0aGlzWyBpIF0gKSAhPSBudWxsOyBpKysgKSB7XG5cdFx0XHRpZiAoIGVsZW0ubm9kZVR5cGUgPT09IDEgKSB7XG5cblx0XHRcdFx0Ly8gUHJldmVudCBtZW1vcnkgbGVha3Ncblx0XHRcdFx0alF1ZXJ5LmNsZWFuRGF0YSggZ2V0QWxsKCBlbGVtLCBmYWxzZSApICk7XG5cblx0XHRcdFx0Ly8gUmVtb3ZlIGFueSByZW1haW5pbmcgbm9kZXNcblx0XHRcdFx0ZWxlbS50ZXh0Q29udGVudCA9IFwiXCI7XG5cdFx0XHR9XG5cdFx0fVxuXG5cdFx0cmV0dXJuIHRoaXM7XG5cdH0sXG5cblx0Y2xvbmU6IGZ1bmN0aW9uKCBkYXRhQW5kRXZlbnRzLCBkZWVwRGF0YUFuZEV2ZW50cyApIHtcblx0XHRkYXRhQW5kRXZlbnRzID0gZGF0YUFuZEV2ZW50cyA9PSBudWxsID8gZmFsc2UgOiBkYXRhQW5kRXZlbnRzO1xuXHRcdGRlZXBEYXRhQW5kRXZlbnRzID0gZGVlcERhdGFBbmRFdmVudHMgPT0gbnVsbCA/IGRhdGFBbmRFdmVudHMgOiBkZWVwRGF0YUFuZEV2ZW50cztcblxuXHRcdHJldHVybiB0aGlzLm1hcCggZnVuY3Rpb24oKSB7XG5cdFx0XHRyZXR1cm4galF1ZXJ5LmNsb25lKCB0aGlzLCBkYXRhQW5kRXZlbnRzLCBkZWVwRGF0YUFuZEV2ZW50cyApO1xuXHRcdH0gKTtcblx0fSxcblxuXHRodG1sOiBmdW5jdGlvbiggdmFsdWUgKSB7XG5cdFx0cmV0dXJuIGFjY2VzcyggdGhpcywgZnVuY3Rpb24oIHZhbHVlICkge1xuXHRcdFx0dmFyIGVsZW0gPSB0aGlzWyAwIF0gfHwge30sXG5cdFx0XHRcdGkgPSAwLFxuXHRcdFx0XHRsID0gdGhpcy5sZW5ndGg7XG5cblx0XHRcdGlmICggdmFsdWUgPT09IHVuZGVmaW5lZCAmJiBlbGVtLm5vZGVUeXBlID09PSAxICkge1xuXHRcdFx0XHRyZXR1cm4gZWxlbS5pbm5lckhUTUw7XG5cdFx0XHR9XG5cblx0XHRcdC8vIFNlZSBpZiB3ZSBjYW4gdGFrZSBhIHNob3J0Y3V0IGFuZCBqdXN0IHVzZSBpbm5lckhUTUxcblx0XHRcdGlmICggdHlwZW9mIHZhbHVlID09PSBcInN0cmluZ1wiICYmICFybm9Jbm5lcmh0bWwudGVzdCggdmFsdWUgKSAmJlxuXHRcdFx0XHQhd3JhcE1hcFsgKCBydGFnTmFtZS5leGVjKCB2YWx1ZSApIHx8IFsgXCJcIiwgXCJcIiBdIClbIDEgXS50b0xvd2VyQ2FzZSgpIF0gKSB7XG5cblx0XHRcdFx0dmFsdWUgPSBqUXVlcnkuaHRtbFByZWZpbHRlciggdmFsdWUgKTtcblxuXHRcdFx0XHR0cnkge1xuXHRcdFx0XHRcdGZvciAoIDsgaSA8IGw7IGkrKyApIHtcblx0XHRcdFx0XHRcdGVsZW0gPSB0aGlzWyBpIF0gfHwge307XG5cblx0XHRcdFx0XHRcdC8vIFJlbW92ZSBlbGVtZW50IG5vZGVzIGFuZCBwcmV2ZW50IG1lbW9yeSBsZWFrc1xuXHRcdFx0XHRcdFx0aWYgKCBlbGVtLm5vZGVUeXBlID09PSAxICkge1xuXHRcdFx0XHRcdFx0XHRqUXVlcnkuY2xlYW5EYXRhKCBnZXRBbGwoIGVsZW0sIGZhbHNlICkgKTtcblx0XHRcdFx0XHRcdFx0ZWxlbS5pbm5lckhUTUwgPSB2YWx1ZTtcblx0XHRcdFx0XHRcdH1cblx0XHRcdFx0XHR9XG5cblx0XHRcdFx0XHRlbGVtID0gMDtcblxuXHRcdFx0XHQvLyBJZiB1c2luZyBpbm5lckhUTUwgdGhyb3dzIGFuIGV4Y2VwdGlvbiwgdXNlIHRoZSBmYWxsYmFjayBtZXRob2Rcblx0XHRcdFx0fSBjYXRjaCAoIGUgKSB7fVxuXHRcdFx0fVxuXG5cdFx0XHRpZiAoIGVsZW0gKSB7XG5cdFx0XHRcdHRoaXMuZW1wdHkoKS5hcHBlbmQoIHZhbHVlICk7XG5cdFx0XHR9XG5cdFx0fSwgbnVsbCwgdmFsdWUsIGFyZ3VtZW50cy5sZW5ndGggKTtcblx0fSxcblxuXHRyZXBsYWNlV2l0aDogZnVuY3Rpb24oKSB7XG5cdFx0dmFyIGlnbm9yZWQgPSBbXTtcblxuXHRcdC8vIE1ha2UgdGhlIGNoYW5nZXMsIHJlcGxhY2luZyBlYWNoIG5vbi1pZ25vcmVkIGNvbnRleHQgZWxlbWVudCB3aXRoIHRoZSBuZXcgY29udGVudFxuXHRcdHJldHVybiBkb21NYW5pcCggdGhpcywgYXJndW1lbnRzLCBmdW5jdGlvbiggZWxlbSApIHtcblx0XHRcdHZhciBwYXJlbnQgPSB0aGlzLnBhcmVudE5vZGU7XG5cblx0XHRcdGlmICggalF1ZXJ5LmluQXJyYXkoIHRoaXMsIGlnbm9yZWQgKSA8IDAgKSB7XG5cdFx0XHRcdGpRdWVyeS5jbGVhbkRhdGEoIGdldEFsbCggdGhpcyApICk7XG5cdFx0XHRcdGlmICggcGFyZW50ICkge1xuXHRcdFx0XHRcdHBhcmVudC5yZXBsYWNlQ2hpbGQoIGVsZW0sIHRoaXMgKTtcblx0XHRcdFx0fVxuXHRcdFx0fVxuXG5cdFx0Ly8gRm9yY2UgY2FsbGJhY2sgaW52b2NhdGlvblxuXHRcdH0sIGlnbm9yZWQgKTtcblx0fVxufSApO1xuXG5qUXVlcnkuZWFjaCgge1xuXHRhcHBlbmRUbzogXCJhcHBlbmRcIixcblx0cHJlcGVuZFRvOiBcInByZXBlbmRcIixcblx0aW5zZXJ0QmVmb3JlOiBcImJlZm9yZVwiLFxuXHRpbnNlcnRBZnRlcjogXCJhZnRlclwiLFxuXHRyZXBsYWNlQWxsOiBcInJlcGxhY2VXaXRoXCJcbn0sIGZ1bmN0aW9uKCBuYW1lLCBvcmlnaW5hbCApIHtcblx0alF1ZXJ5LmZuWyBuYW1lIF0gPSBmdW5jdGlvbiggc2VsZWN0b3IgKSB7XG5cdFx0dmFyIGVsZW1zLFxuXHRcdFx0cmV0ID0gW10sXG5cdFx0XHRpbnNlcnQgPSBqUXVlcnkoIHNlbGVjdG9yICksXG5cdFx0XHRsYXN0ID0gaW5zZXJ0Lmxlbmd0aCAtIDEsXG5cdFx0XHRpID0gMDtcblxuXHRcdGZvciAoIDsgaSA8PSBsYXN0OyBpKysgKSB7XG5cdFx0XHRlbGVtcyA9IGkgPT09IGxhc3QgPyB0aGlzIDogdGhpcy5jbG9uZSggdHJ1ZSApO1xuXHRcdFx0alF1ZXJ5KCBpbnNlcnRbIGkgXSApWyBvcmlnaW5hbCBdKCBlbGVtcyApO1xuXHRcdFx0cHVzaC5hcHBseSggcmV0LCBlbGVtcyApO1xuXHRcdH1cblxuXHRcdHJldHVybiB0aGlzLnB1c2hTdGFjayggcmV0ICk7XG5cdH07XG59ICk7XG5cbnZhciBybnVtbm9ucHggPSBuZXcgUmVnRXhwKCBcIl4oXCIgKyBwbnVtICsgXCIpKD8hcHgpW2EteiVdKyRcIiwgXCJpXCIgKTtcblxudmFyIHJjdXN0b21Qcm9wID0gL14tLS87XG5cbmZ1bmN0aW9uIGdldFN0eWxlcyggZWxlbSApIHtcblxuXHQvLyBTdXBwb3J0OiBJRSA8PTExKyAodHJhYy0xNDE1MClcblx0Ly8gSW4gSUUgcG9wdXAncyBgd2luZG93YCBpcyB0aGUgb3BlbmVyIHdpbmRvdyB3aGljaCBtYWtlcyBgd2luZG93LmdldENvbXB1dGVkU3R5bGUoIGVsZW0gKWBcblx0Ly8gYnJlYWsuIFVzaW5nIGBlbGVtLm93bmVyRG9jdW1lbnQuZGVmYXVsdFZpZXdgIGF2b2lkcyB0aGUgaXNzdWUuXG5cdHZhciB2aWV3ID0gZWxlbS5vd25lckRvY3VtZW50LmRlZmF1bHRWaWV3O1xuXG5cdC8vIGBkb2N1bWVudC5pbXBsZW1lbnRhdGlvbi5jcmVhdGVIVE1MRG9jdW1lbnQoIFwiXCIgKWAgaGFzIGEgYG51bGxgIGBkZWZhdWx0Vmlld2Bcblx0Ly8gcHJvcGVydHk7IGNoZWNrIGBkZWZhdWx0Vmlld2AgdHJ1dGhpbmVzcyB0byBmYWxsYmFjayB0byB3aW5kb3cgaW4gc3VjaCBhIGNhc2UuXG5cdGlmICggIXZpZXcgKSB7XG5cdFx0dmlldyA9IHdpbmRvdztcblx0fVxuXG5cdHJldHVybiB2aWV3LmdldENvbXB1dGVkU3R5bGUoIGVsZW0gKTtcbn1cblxuLy8gQSBtZXRob2QgZm9yIHF1aWNrbHkgc3dhcHBpbmcgaW4vb3V0IENTUyBwcm9wZXJ0aWVzIHRvIGdldCBjb3JyZWN0IGNhbGN1bGF0aW9ucy5cbmZ1bmN0aW9uIHN3YXAoIGVsZW0sIG9wdGlvbnMsIGNhbGxiYWNrICkge1xuXHR2YXIgcmV0LCBuYW1lLFxuXHRcdG9sZCA9IHt9O1xuXG5cdC8vIFJlbWVtYmVyIHRoZSBvbGQgdmFsdWVzLCBhbmQgaW5zZXJ0IHRoZSBuZXcgb25lc1xuXHRmb3IgKCBuYW1lIGluIG9wdGlvbnMgKSB7XG5cdFx0b2xkWyBuYW1lIF0gPSBlbGVtLnN0eWxlWyBuYW1lIF07XG5cdFx0ZWxlbS5zdHlsZVsgbmFtZSBdID0gb3B0aW9uc1sgbmFtZSBdO1xuXHR9XG5cblx0cmV0ID0gY2FsbGJhY2suY2FsbCggZWxlbSApO1xuXG5cdC8vIFJldmVydCB0aGUgb2xkIHZhbHVlc1xuXHRmb3IgKCBuYW1lIGluIG9wdGlvbnMgKSB7XG5cdFx0ZWxlbS5zdHlsZVsgbmFtZSBdID0gb2xkWyBuYW1lIF07XG5cdH1cblxuXHRyZXR1cm4gcmV0O1xufVxuXG5mdW5jdGlvbiBjdXJDU1MoIGVsZW0sIG5hbWUsIGNvbXB1dGVkICkge1xuXHR2YXIgcmV0LFxuXHRcdGlzQ3VzdG9tUHJvcCA9IHJjdXN0b21Qcm9wLnRlc3QoIG5hbWUgKTtcblxuXHRjb21wdXRlZCA9IGNvbXB1dGVkIHx8IGdldFN0eWxlcyggZWxlbSApO1xuXG5cdC8vIGdldFByb3BlcnR5VmFsdWUgaXMgbmVlZGVkIGZvciBgLmNzcygnLS1jdXN0b21Qcm9wZXJ0eScpYCAoZ2gtMzE0NClcblx0aWYgKCBjb21wdXRlZCApIHtcblxuXHRcdC8vIEEgZmFsbGJhY2sgdG8gZGlyZWN0IHByb3BlcnR5IGFjY2VzcyBpcyBuZWVkZWQgYXMgYGNvbXB1dGVkYCwgYmVpbmdcblx0XHQvLyB0aGUgb3V0cHV0IG9mIGBnZXRDb21wdXRlZFN0eWxlYCwgY29udGFpbnMgY2FtZWxDYXNlZCBrZXlzIGFuZFxuXHRcdC8vIGBnZXRQcm9wZXJ0eVZhbHVlYCByZXF1aXJlcyBrZWJhYi1jYXNlIG9uZXMuXG5cdFx0Ly9cblx0XHQvLyBTdXBwb3J0OiBJRSA8PTkgLSAxMStcblx0XHQvLyBJRSBvbmx5IHN1cHBvcnRzIGBcImZsb2F0XCJgIGluIGBnZXRQcm9wZXJ0eVZhbHVlYDsgaW4gY29tcHV0ZWQgc3R5bGVzXG5cdFx0Ly8gaXQncyBvbmx5IGF2YWlsYWJsZSBhcyBgXCJjc3NGbG9hdFwiYC4gV2Ugbm8gbG9uZ2VyIG1vZGlmeSBwcm9wZXJ0aWVzXG5cdFx0Ly8gc2VudCB0byBgLmNzcygpYCBhcGFydCBmcm9tIGNhbWVsQ2FzaW5nLCBzbyB3ZSBuZWVkIHRvIGNoZWNrIGJvdGguXG5cdFx0Ly8gTm9ybWFsbHksIHRoaXMgd291bGQgY3JlYXRlIGRpZmZlcmVuY2UgaW4gYmVoYXZpb3I6IGlmXG5cdFx0Ly8gYGdldFByb3BlcnR5VmFsdWVgIHJldHVybnMgYW4gZW1wdHkgc3RyaW5nLCB0aGUgdmFsdWUgcmV0dXJuZWRcblx0XHQvLyBieSBgLmNzcygpYCB3b3VsZCBiZSBgdW5kZWZpbmVkYC4gVGhpcyBpcyB1c3VhbGx5IHRoZSBjYXNlIGZvclxuXHRcdC8vIGRpc2Nvbm5lY3RlZCBlbGVtZW50cy4gSG93ZXZlciwgaW4gSUUgZXZlbiBkaXNjb25uZWN0ZWQgZWxlbWVudHNcblx0XHQvLyB3aXRoIG5vIHN0eWxlcyByZXR1cm4gYFwibm9uZVwiYCBmb3IgYGdldFByb3BlcnR5VmFsdWUoIFwiZmxvYXRcIiApYFxuXHRcdHJldCA9IGNvbXB1dGVkLmdldFByb3BlcnR5VmFsdWUoIG5hbWUgKSB8fCBjb21wdXRlZFsgbmFtZSBdO1xuXG5cdFx0aWYgKCBpc0N1c3RvbVByb3AgJiYgcmV0ICkge1xuXG5cdFx0XHQvLyBTdXBwb3J0OiBGaXJlZm94IDEwNSAtIDEzNStcblx0XHRcdC8vIFNwZWMgcmVxdWlyZXMgdHJpbW1pbmcgd2hpdGVzcGFjZSBmb3IgY3VzdG9tIHByb3BlcnRpZXMgKGdoLTQ5MjYpLlxuXHRcdFx0Ly8gRmlyZWZveCBvbmx5IHRyaW1zIGxlYWRpbmcgd2hpdGVzcGFjZS5cblx0XHRcdC8vXG5cdFx0XHQvLyBGYWxsIGJhY2sgdG8gYHVuZGVmaW5lZGAgaWYgZW1wdHkgc3RyaW5nIHJldHVybmVkLlxuXHRcdFx0Ly8gVGhpcyBjb2xsYXBzZXMgYSBtaXNzaW5nIGRlZmluaXRpb24gd2l0aCBwcm9wZXJ0eSBkZWZpbmVkXG5cdFx0XHQvLyBhbmQgc2V0IHRvIGFuIGVtcHR5IHN0cmluZyBidXQgdGhlcmUncyBubyBzdGFuZGFyZCBBUElcblx0XHRcdC8vIGFsbG93aW5nIHVzIHRvIGRpZmZlcmVudGlhdGUgdGhlbSB3aXRob3V0IGEgcGVyZm9ybWFuY2UgcGVuYWx0eVxuXHRcdFx0Ly8gYW5kIHJldHVybmluZyBgdW5kZWZpbmVkYCBhbGlnbnMgd2l0aCBvbGRlciBqUXVlcnkuXG5cdFx0XHQvL1xuXHRcdFx0Ly8gcnRyaW1DU1MgdHJlYXRzIFUrMDAwRCBDQVJSSUFHRSBSRVRVUk4gYW5kIFUrMDAwQyBGT1JNIEZFRURcblx0XHRcdC8vIGFzIHdoaXRlc3BhY2Ugd2hpbGUgQ1NTIGRvZXMgbm90LCBidXQgdGhpcyBpcyBub3QgYSBwcm9ibGVtXG5cdFx0XHQvLyBiZWNhdXNlIENTUyBwcmVwcm9jZXNzaW5nIHJlcGxhY2VzIHRoZW0gd2l0aCBVKzAwMEEgTElORSBGRUVEXG5cdFx0XHQvLyAod2hpY2ggKmlzKiBDU1Mgd2hpdGVzcGFjZSlcblx0XHRcdC8vIGh0dHBzOi8vd3d3LnczLm9yZy9UUi9jc3Mtc3ludGF4LTMvI2lucHV0LXByZXByb2Nlc3Npbmdcblx0XHRcdHJldCA9IHJldC5yZXBsYWNlKCBydHJpbUNTUywgXCIkMVwiICkgfHwgdW5kZWZpbmVkO1xuXHRcdH1cblxuXHRcdGlmICggcmV0ID09PSBcIlwiICYmICFpc0F0dGFjaGVkKCBlbGVtICkgKSB7XG5cdFx0XHRyZXQgPSBqUXVlcnkuc3R5bGUoIGVsZW0sIG5hbWUgKTtcblx0XHR9XG5cdH1cblxuXHRyZXR1cm4gcmV0ICE9PSB1bmRlZmluZWQgP1xuXG5cdFx0Ly8gU3VwcG9ydDogSUUgPD05IC0gMTErXG5cdFx0Ly8gSUUgcmV0dXJucyB6SW5kZXggdmFsdWUgYXMgYW4gaW50ZWdlci5cblx0XHRyZXQgKyBcIlwiIDpcblx0XHRyZXQ7XG59XG5cbnZhciBjc3NQcmVmaXhlcyA9IFsgXCJXZWJraXRcIiwgXCJNb3pcIiwgXCJtc1wiIF0sXG5cdGVtcHR5U3R5bGUgPSBkb2N1bWVudCQxLmNyZWF0ZUVsZW1lbnQoIFwiZGl2XCIgKS5zdHlsZTtcblxuLy8gUmV0dXJuIGEgdmVuZG9yLXByZWZpeGVkIHByb3BlcnR5IG9yIHVuZGVmaW5lZFxuZnVuY3Rpb24gdmVuZG9yUHJvcE5hbWUoIG5hbWUgKSB7XG5cblx0Ly8gQ2hlY2sgZm9yIHZlbmRvciBwcmVmaXhlZCBuYW1lc1xuXHR2YXIgY2FwTmFtZSA9IG5hbWVbIDAgXS50b1VwcGVyQ2FzZSgpICsgbmFtZS5zbGljZSggMSApLFxuXHRcdGkgPSBjc3NQcmVmaXhlcy5sZW5ndGg7XG5cblx0d2hpbGUgKCBpLS0gKSB7XG5cdFx0bmFtZSA9IGNzc1ByZWZpeGVzWyBpIF0gKyBjYXBOYW1lO1xuXHRcdGlmICggbmFtZSBpbiBlbXB0eVN0eWxlICkge1xuXHRcdFx0cmV0dXJuIG5hbWU7XG5cdFx0fVxuXHR9XG59XG5cbi8vIFJldHVybiBhIHBvdGVudGlhbGx5LW1hcHBlZCB2ZW5kb3IgcHJlZml4ZWQgcHJvcGVydHlcbmZ1bmN0aW9uIGZpbmFsUHJvcE5hbWUoIG5hbWUgKSB7XG5cdGlmICggbmFtZSBpbiBlbXB0eVN0eWxlICkge1xuXHRcdHJldHVybiBuYW1lO1xuXHR9XG5cdHJldHVybiB2ZW5kb3JQcm9wTmFtZSggbmFtZSApIHx8IG5hbWU7XG59XG5cbnZhciByZWxpYWJsZVRyRGltZW5zaW9uc1ZhbCwgcmVsaWFibGVDb2xEaW1lbnNpb25zVmFsLFxuXHR0YWJsZSA9IGRvY3VtZW50JDEuY3JlYXRlRWxlbWVudCggXCJ0YWJsZVwiICk7XG5cbi8vIEV4ZWN1dGluZyB0YWJsZSB0ZXN0cyByZXF1aXJlcyBvbmx5IG9uZSBsYXlvdXQsIHNvIHRoZXkncmUgZXhlY3V0ZWRcbi8vIGF0IHRoZSBzYW1lIHRpbWUgdG8gc2F2ZSB0aGUgc2Vjb25kIGNvbXB1dGF0aW9uLlxuZnVuY3Rpb24gY29tcHV0ZVRhYmxlU3R5bGVUZXN0cygpIHtcblx0aWYgKFxuXG5cdFx0Ly8gVGhpcyBpcyBhIHNpbmdsZXRvbiwgd2UgbmVlZCB0byBleGVjdXRlIGl0IG9ubHkgb25jZVxuXHRcdCF0YWJsZSB8fFxuXG5cdFx0Ly8gRmluaXNoIGVhcmx5IGluIGxpbWl0ZWQgKG5vbi1icm93c2VyKSBlbnZpcm9ubWVudHNcblx0XHQhdGFibGUuc3R5bGVcblx0KSB7XG5cdFx0cmV0dXJuO1xuXHR9XG5cblx0dmFyIHRyU3R5bGUsXG5cdFx0Y29sID0gZG9jdW1lbnQkMS5jcmVhdGVFbGVtZW50KCBcImNvbFwiICksXG5cdFx0dHIgPSBkb2N1bWVudCQxLmNyZWF0ZUVsZW1lbnQoIFwidHJcIiApLFxuXHRcdHRkID0gZG9jdW1lbnQkMS5jcmVhdGVFbGVtZW50KCBcInRkXCIgKTtcblxuXHR0YWJsZS5zdHlsZS5jc3NUZXh0ID0gXCJwb3NpdGlvbjphYnNvbHV0ZTtsZWZ0Oi0xMTExMXB4O1wiICtcblx0XHRcImJvcmRlci1jb2xsYXBzZTpzZXBhcmF0ZTtib3JkZXItc3BhY2luZzowXCI7XG5cdHRyLnN0eWxlLmNzc1RleHQgPSBcImJveC1zaXppbmc6Y29udGVudC1ib3g7Ym9yZGVyOjFweCBzb2xpZDtoZWlnaHQ6MXB4XCI7XG5cdHRkLnN0eWxlLmNzc1RleHQgPSBcImhlaWdodDo5cHg7d2lkdGg6OXB4O3BhZGRpbmc6MFwiO1xuXG5cdGNvbC5zcGFuID0gMjtcblxuXHRkb2N1bWVudEVsZW1lbnQkMVxuXHRcdC5hcHBlbmRDaGlsZCggdGFibGUgKVxuXHRcdC5hcHBlbmRDaGlsZCggY29sIClcblx0XHQucGFyZW50Tm9kZVxuXHRcdC5hcHBlbmRDaGlsZCggdHIgKVxuXHRcdC5hcHBlbmRDaGlsZCggdGQgKVxuXHRcdC5wYXJlbnROb2RlXG5cdFx0LmFwcGVuZENoaWxkKCB0ZC5jbG9uZU5vZGUoIHRydWUgKSApO1xuXG5cdC8vIERvbid0IHJ1biB1bnRpbCB3aW5kb3cgaXMgdmlzaWJsZVxuXHRpZiAoIHRhYmxlLm9mZnNldFdpZHRoID09PSAwICkge1xuXHRcdGRvY3VtZW50RWxlbWVudCQxLnJlbW92ZUNoaWxkKCB0YWJsZSApO1xuXHRcdHJldHVybjtcblx0fVxuXG5cdHRyU3R5bGUgPSB3aW5kb3cuZ2V0Q29tcHV0ZWRTdHlsZSggdHIgKTtcblxuXHQvLyBTdXBwb3J0OiBGaXJlZm94IDEzNStcblx0Ly8gRmlyZWZveCBhbHdheXMgcmVwb3J0cyBjb21wdXRlZCB3aWR0aCBhcyBpZiBgc3BhbmAgd2FzIDEuXG5cdC8vIFN1cHBvcnQ6IFNhZmFyaSAxOC4zK1xuXHQvLyBJbiBTYWZhcmksIGNvbXB1dGVkIHdpZHRoIGZvciBjb2x1bW5zIGlzIGFsd2F5cyAwLlxuXHQvLyBJbiBib3RoIHRoZXNlIGJyb3dzZXJzLCB1c2luZyBgb2Zmc2V0V2lkdGhgIHNvbHZlcyB0aGUgaXNzdWUuXG5cdC8vIFN1cHBvcnQ6IElFIDExK1xuXHQvLyBJbiBJRSwgYDxjb2w+YCBjb21wdXRlZCB3aWR0aCBpcyBgXCJhdXRvXCJgIHVubGVzcyBgd2lkdGhgIGlzIHNldFxuXHQvLyBleHBsaWNpdGx5IHZpYSBDU1Mgc28gbWVhc3VyZW1lbnRzIHRoZXJlIHJlbWFpbiBpbmNvcnJlY3QuIEJlY2F1c2Ugb2Zcblx0Ly8gdGhlIGxhY2sgb2YgYSBwcm9wZXIgd29ya2Fyb3VuZCwgd2UgYWNjZXB0IHRoaXMgbGltaXRhdGlvbiwgdHJlYXRpbmdcblx0Ly8gSUUgYXMgcGFzc2luZyB0aGUgdGVzdC5cblx0cmVsaWFibGVDb2xEaW1lbnNpb25zVmFsID0gaXNJRSB8fCBNYXRoLnJvdW5kKCBwYXJzZUZsb2F0KFxuXHRcdHdpbmRvdy5nZXRDb21wdXRlZFN0eWxlKCBjb2wgKS53aWR0aCApXG5cdCkgPT09IDE4O1xuXG5cdC8vIFN1cHBvcnQ6IElFIDEwIC0gMTErXG5cdC8vIElFIG1pc3JlcG9ydHMgYGdldENvbXB1dGVkU3R5bGVgIG9mIHRhYmxlIHJvd3Mgd2l0aCB3aWR0aC9oZWlnaHRcblx0Ly8gc2V0IGluIENTUyB3aGlsZSBgb2Zmc2V0KmAgcHJvcGVydGllcyByZXBvcnQgY29ycmVjdCB2YWx1ZXMuXG5cdC8vIFN1cHBvcnQ6IEZpcmVmb3ggNzAgLSAxMzUrXG5cdC8vIE9ubHkgRmlyZWZveCBpbmNsdWRlcyBib3JkZXIgd2lkdGhzXG5cdC8vIGluIGNvbXB1dGVkIGRpbWVuc2lvbnMgZm9yIHRhYmxlIHJvd3MuIChnaC00NTI5KVxuXHRyZWxpYWJsZVRyRGltZW5zaW9uc1ZhbCA9IE1hdGgucm91bmQoIHBhcnNlRmxvYXQoIHRyU3R5bGUuaGVpZ2h0ICkgK1xuXHRcdHBhcnNlRmxvYXQoIHRyU3R5bGUuYm9yZGVyVG9wV2lkdGggKSArXG5cdFx0cGFyc2VGbG9hdCggdHJTdHlsZS5ib3JkZXJCb3R0b21XaWR0aCApICkgPT09IHRyLm9mZnNldEhlaWdodDtcblxuXHRkb2N1bWVudEVsZW1lbnQkMS5yZW1vdmVDaGlsZCggdGFibGUgKTtcblxuXHQvLyBOdWxsaWZ5IHRoZSB0YWJsZSBzbyBpdCB3b3VsZG4ndCBiZSBzdG9yZWQgaW4gdGhlIG1lbW9yeTtcblx0Ly8gaXQgd2lsbCBhbHNvIGJlIGEgc2lnbiB0aGF0IGNoZWNrcyB3ZXJlIGFscmVhZHkgcGVyZm9ybWVkLlxuXHR0YWJsZSA9IG51bGw7XG59XG5cbmpRdWVyeS5leHRlbmQoIHN1cHBvcnQsIHtcblx0cmVsaWFibGVUckRpbWVuc2lvbnM6IGZ1bmN0aW9uKCkge1xuXHRcdGNvbXB1dGVUYWJsZVN0eWxlVGVzdHMoKTtcblx0XHRyZXR1cm4gcmVsaWFibGVUckRpbWVuc2lvbnNWYWw7XG5cdH0sXG5cblx0cmVsaWFibGVDb2xEaW1lbnNpb25zOiBmdW5jdGlvbigpIHtcblx0XHRjb21wdXRlVGFibGVTdHlsZVRlc3RzKCk7XG5cdFx0cmV0dXJuIHJlbGlhYmxlQ29sRGltZW5zaW9uc1ZhbDtcblx0fVxufSApO1xuXG52YXIgY3NzU2hvdyA9IHsgcG9zaXRpb246IFwiYWJzb2x1dGVcIiwgdmlzaWJpbGl0eTogXCJoaWRkZW5cIiwgZGlzcGxheTogXCJibG9ja1wiIH0sXG5cdGNzc05vcm1hbFRyYW5zZm9ybSA9IHtcblx0XHRsZXR0ZXJTcGFjaW5nOiBcIjBcIixcblx0XHRmb250V2VpZ2h0OiBcIjQwMFwiXG5cdH07XG5cbmZ1bmN0aW9uIHNldFBvc2l0aXZlTnVtYmVyKCBfZWxlbSwgdmFsdWUsIHN1YnRyYWN0ICkge1xuXG5cdC8vIEFueSByZWxhdGl2ZSAoKy8tKSB2YWx1ZXMgaGF2ZSBhbHJlYWR5IGJlZW5cblx0Ly8gbm9ybWFsaXplZCBhdCB0aGlzIHBvaW50XG5cdHZhciBtYXRjaGVzID0gcmNzc051bS5leGVjKCB2YWx1ZSApO1xuXHRyZXR1cm4gbWF0Y2hlcyA/XG5cblx0XHQvLyBHdWFyZCBhZ2FpbnN0IHVuZGVmaW5lZCBcInN1YnRyYWN0XCIsIGUuZy4sIHdoZW4gdXNlZCBhcyBpbiBjc3NIb29rc1xuXHRcdE1hdGgubWF4KCAwLCBtYXRjaGVzWyAyIF0gLSAoIHN1YnRyYWN0IHx8IDAgKSApICsgKCBtYXRjaGVzWyAzIF0gfHwgXCJweFwiICkgOlxuXHRcdHZhbHVlO1xufVxuXG5mdW5jdGlvbiBib3hNb2RlbEFkanVzdG1lbnQoIGVsZW0sIGRpbWVuc2lvbiwgYm94LCBpc0JvcmRlckJveCwgc3R5bGVzLCBjb21wdXRlZFZhbCApIHtcblx0dmFyIGkgPSBkaW1lbnNpb24gPT09IFwid2lkdGhcIiA/IDEgOiAwLFxuXHRcdGV4dHJhID0gMCxcblx0XHRkZWx0YSA9IDAsXG5cdFx0bWFyZ2luRGVsdGEgPSAwO1xuXG5cdC8vIEFkanVzdG1lbnQgbWF5IG5vdCBiZSBuZWNlc3Nhcnlcblx0aWYgKCBib3ggPT09ICggaXNCb3JkZXJCb3ggPyBcImJvcmRlclwiIDogXCJjb250ZW50XCIgKSApIHtcblx0XHRyZXR1cm4gMDtcblx0fVxuXG5cdGZvciAoIDsgaSA8IDQ7IGkgKz0gMiApIHtcblxuXHRcdC8vIEJvdGggYm94IG1vZGVscyBleGNsdWRlIG1hcmdpblxuXHRcdC8vIENvdW50IG1hcmdpbiBkZWx0YSBzZXBhcmF0ZWx5IHRvIG9ubHkgYWRkIGl0IGFmdGVyIHNjcm9sbCBndXR0ZXIgYWRqdXN0bWVudC5cblx0XHQvLyBUaGlzIGlzIG5lZWRlZCB0byBtYWtlIG5lZ2F0aXZlIG1hcmdpbnMgd29yayB3aXRoIGBvdXRlckhlaWdodCggdHJ1ZSApYCAoZ2gtMzk4MikuXG5cdFx0aWYgKCBib3ggPT09IFwibWFyZ2luXCIgKSB7XG5cdFx0XHRtYXJnaW5EZWx0YSArPSBqUXVlcnkuY3NzKCBlbGVtLCBib3ggKyBjc3NFeHBhbmRbIGkgXSwgdHJ1ZSwgc3R5bGVzICk7XG5cdFx0fVxuXG5cdFx0Ly8gSWYgd2UgZ2V0IGhlcmUgd2l0aCBhIGNvbnRlbnQtYm94LCB3ZSdyZSBzZWVraW5nIFwicGFkZGluZ1wiIG9yIFwiYm9yZGVyXCIgb3IgXCJtYXJnaW5cIlxuXHRcdGlmICggIWlzQm9yZGVyQm94ICkge1xuXG5cdFx0XHQvLyBBZGQgcGFkZGluZ1xuXHRcdFx0ZGVsdGEgKz0galF1ZXJ5LmNzcyggZWxlbSwgXCJwYWRkaW5nXCIgKyBjc3NFeHBhbmRbIGkgXSwgdHJ1ZSwgc3R5bGVzICk7XG5cblx0XHRcdC8vIEZvciBcImJvcmRlclwiIG9yIFwibWFyZ2luXCIsIGFkZCBib3JkZXJcblx0XHRcdGlmICggYm94ICE9PSBcInBhZGRpbmdcIiApIHtcblx0XHRcdFx0ZGVsdGEgKz0galF1ZXJ5LmNzcyggZWxlbSwgXCJib3JkZXJcIiArIGNzc0V4cGFuZFsgaSBdICsgXCJXaWR0aFwiLCB0cnVlLCBzdHlsZXMgKTtcblxuXHRcdFx0Ly8gQnV0IHN0aWxsIGtlZXAgdHJhY2sgb2YgaXQgb3RoZXJ3aXNlXG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRleHRyYSArPSBqUXVlcnkuY3NzKCBlbGVtLCBcImJvcmRlclwiICsgY3NzRXhwYW5kWyBpIF0gKyBcIldpZHRoXCIsIHRydWUsIHN0eWxlcyApO1xuXHRcdFx0fVxuXG5cdFx0Ly8gSWYgd2UgZ2V0IGhlcmUgd2l0aCBhIGJvcmRlci1ib3ggKGNvbnRlbnQgKyBwYWRkaW5nICsgYm9yZGVyKSwgd2UncmUgc2Vla2luZyBcImNvbnRlbnRcIiBvclxuXHRcdC8vIFwicGFkZGluZ1wiIG9yIFwibWFyZ2luXCJcblx0XHR9IGVsc2Uge1xuXG5cdFx0XHQvLyBGb3IgXCJjb250ZW50XCIsIHN1YnRyYWN0IHBhZGRpbmdcblx0XHRcdGlmICggYm94ID09PSBcImNvbnRlbnRcIiApIHtcblx0XHRcdFx0ZGVsdGEgLT0galF1ZXJ5LmNzcyggZWxlbSwgXCJwYWRkaW5nXCIgKyBjc3NFeHBhbmRbIGkgXSwgdHJ1ZSwgc3R5bGVzICk7XG5cdFx0XHR9XG5cblx0XHRcdC8vIEZvciBcImNvbnRlbnRcIiBvciBcInBhZGRpbmdcIiwgc3VidHJhY3QgYm9yZGVyXG5cdFx0XHRpZiAoIGJveCAhPT0gXCJtYXJnaW5cIiApIHtcblx0XHRcdFx0ZGVsdGEgLT0galF1ZXJ5LmNzcyggZWxlbSwgXCJib3JkZXJcIiArIGNzc0V4cGFuZFsgaSBdICsgXCJXaWR0aFwiLCB0cnVlLCBzdHlsZXMgKTtcblx0XHRcdH1cblx0XHR9XG5cdH1cblxuXHQvLyBBY2NvdW50IGZvciBwb3NpdGl2ZSBjb250ZW50LWJveCBzY3JvbGwgZ3V0dGVyIHdoZW4gcmVxdWVzdGVkIGJ5IHByb3ZpZGluZyBjb21wdXRlZFZhbFxuXHRpZiAoICFpc0JvcmRlckJveCAmJiBjb21wdXRlZFZhbCA+PSAwICkge1xuXG5cdFx0Ly8gb2Zmc2V0V2lkdGgvb2Zmc2V0SGVpZ2h0IGlzIGEgcm91bmRlZCBzdW0gb2YgY29udGVudCwgcGFkZGluZywgc2Nyb2xsIGd1dHRlciwgYW5kIGJvcmRlclxuXHRcdC8vIEFzc3VtaW5nIGludGVnZXIgc2Nyb2xsIGd1dHRlciwgc3VidHJhY3QgdGhlIHJlc3QgYW5kIHJvdW5kIGRvd25cblx0XHRkZWx0YSArPSBNYXRoLm1heCggMCwgTWF0aC5jZWlsKFxuXHRcdFx0ZWxlbVsgXCJvZmZzZXRcIiArIGRpbWVuc2lvblsgMCBdLnRvVXBwZXJDYXNlKCkgKyBkaW1lbnNpb24uc2xpY2UoIDEgKSBdIC1cblx0XHRcdGNvbXB1dGVkVmFsIC1cblx0XHRcdGRlbHRhIC1cblx0XHRcdGV4dHJhIC1cblx0XHRcdDAuNVxuXG5cdFx0Ly8gSWYgb2Zmc2V0V2lkdGgvb2Zmc2V0SGVpZ2h0IGlzIHVua25vd24sIHRoZW4gd2UgY2FuJ3QgZGV0ZXJtaW5lIGNvbnRlbnQtYm94IHNjcm9sbCBndXR0ZXJcblx0XHQvLyBVc2UgYW4gZXhwbGljaXQgemVybyB0byBhdm9pZCBOYU4gKGdoLTM5NjQpXG5cdFx0KSApIHx8IDA7XG5cdH1cblxuXHRyZXR1cm4gZGVsdGEgKyBtYXJnaW5EZWx0YTtcbn1cblxuZnVuY3Rpb24gZ2V0V2lkdGhPckhlaWdodCggZWxlbSwgZGltZW5zaW9uLCBleHRyYSApIHtcblxuXHQvLyBTdGFydCB3aXRoIGNvbXB1dGVkIHN0eWxlXG5cdHZhciBzdHlsZXMgPSBnZXRTdHlsZXMoIGVsZW0gKSxcblxuXHRcdC8vIFRvIGF2b2lkIGZvcmNpbmcgYSByZWZsb3csIG9ubHkgZmV0Y2ggYm94U2l6aW5nIGlmIHdlIG5lZWQgaXQgKGdoLTQzMjIpLlxuXHRcdC8vIEZha2UgY29udGVudC1ib3ggdW50aWwgd2Uga25vdyBpdCdzIG5lZWRlZCB0byBrbm93IHRoZSB0cnVlIHZhbHVlLlxuXHRcdGJveFNpemluZ05lZWRlZCA9IGlzSUUgfHwgZXh0cmEsXG5cdFx0aXNCb3JkZXJCb3ggPSBib3hTaXppbmdOZWVkZWQgJiZcblx0XHRcdGpRdWVyeS5jc3MoIGVsZW0sIFwiYm94U2l6aW5nXCIsIGZhbHNlLCBzdHlsZXMgKSA9PT0gXCJib3JkZXItYm94XCIsXG5cdFx0dmFsdWVJc0JvcmRlckJveCA9IGlzQm9yZGVyQm94LFxuXG5cdFx0dmFsID0gY3VyQ1NTKCBlbGVtLCBkaW1lbnNpb24sIHN0eWxlcyApLFxuXHRcdG9mZnNldFByb3AgPSBcIm9mZnNldFwiICsgZGltZW5zaW9uWyAwIF0udG9VcHBlckNhc2UoKSArIGRpbWVuc2lvbi5zbGljZSggMSApO1xuXG5cdC8vIFJldHVybiBhIGNvbmZvdW5kaW5nIG5vbi1waXhlbCB2YWx1ZSBvciBmZWlnbiBpZ25vcmFuY2UsIGFzIGFwcHJvcHJpYXRlLlxuXHRpZiAoIHJudW1ub25weC50ZXN0KCB2YWwgKSApIHtcblx0XHRpZiAoICFleHRyYSApIHtcblx0XHRcdHJldHVybiB2YWw7XG5cdFx0fVxuXHRcdHZhbCA9IFwiYXV0b1wiO1xuXHR9XG5cblxuXHRpZiAoXG5cdFx0KFxuXG5cdFx0XHQvLyBGYWxsIGJhY2sgdG8gb2Zmc2V0V2lkdGgvb2Zmc2V0SGVpZ2h0IHdoZW4gdmFsdWUgaXMgXCJhdXRvXCJcblx0XHRcdC8vIFRoaXMgaGFwcGVucyBmb3IgaW5saW5lIGVsZW1lbnRzIHdpdGggbm8gZXhwbGljaXQgc2V0dGluZyAoZ2gtMzU3MSlcblx0XHRcdHZhbCA9PT0gXCJhdXRvXCIgfHxcblxuXHRcdFx0Ly8gU3VwcG9ydDogSUUgOSAtIDExK1xuXHRcdFx0Ly8gVXNlIG9mZnNldFdpZHRoL29mZnNldEhlaWdodCBmb3Igd2hlbiBib3ggc2l6aW5nIGlzIHVucmVsaWFibGUuXG5cdFx0XHQvLyBJbiB0aG9zZSBjYXNlcywgdGhlIGNvbXB1dGVkIHZhbHVlIGNhbiBiZSB0cnVzdGVkIHRvIGJlIGJvcmRlci1ib3guXG5cdFx0XHQoIGlzSUUgJiYgaXNCb3JkZXJCb3ggKSB8fFxuXG5cdFx0XHQoICFzdXBwb3J0LnJlbGlhYmxlQ29sRGltZW5zaW9ucygpICYmIG5vZGVOYW1lKCBlbGVtLCBcImNvbFwiICkgKSB8fFxuXG5cdFx0XHQoICFzdXBwb3J0LnJlbGlhYmxlVHJEaW1lbnNpb25zKCkgJiYgbm9kZU5hbWUoIGVsZW0sIFwidHJcIiApIClcblx0XHQpICYmXG5cblx0XHQvLyBNYWtlIHN1cmUgdGhlIGVsZW1lbnQgaXMgdmlzaWJsZSAmIGNvbm5lY3RlZFxuXHRcdGVsZW0uZ2V0Q2xpZW50UmVjdHMoKS5sZW5ndGggKSB7XG5cblx0XHRpc0JvcmRlckJveCA9IGpRdWVyeS5jc3MoIGVsZW0sIFwiYm94U2l6aW5nXCIsIGZhbHNlLCBzdHlsZXMgKSA9PT0gXCJib3JkZXItYm94XCI7XG5cblx0XHQvLyBXaGVyZSBhdmFpbGFibGUsIG9mZnNldFdpZHRoL29mZnNldEhlaWdodCBhcHByb3hpbWF0ZSBib3JkZXIgYm94IGRpbWVuc2lvbnMuXG5cdFx0Ly8gV2hlcmUgbm90IGF2YWlsYWJsZSAoZS5nLiwgU1ZHKSwgYXNzdW1lIHVucmVsaWFibGUgYm94LXNpemluZyBhbmQgaW50ZXJwcmV0IHRoZVxuXHRcdC8vIHJldHJpZXZlZCB2YWx1ZSBhcyBhIGNvbnRlbnQgYm94IGRpbWVuc2lvbi5cblx0XHR2YWx1ZUlzQm9yZGVyQm94ID0gb2Zmc2V0UHJvcCBpbiBlbGVtO1xuXHRcdGlmICggdmFsdWVJc0JvcmRlckJveCApIHtcblx0XHRcdHZhbCA9IGVsZW1bIG9mZnNldFByb3AgXTtcblx0XHR9XG5cdH1cblxuXHQvLyBOb3JtYWxpemUgXCJcIiBhbmQgYXV0b1xuXHR2YWwgPSBwYXJzZUZsb2F0KCB2YWwgKSB8fCAwO1xuXG5cdC8vIEFkanVzdCBmb3IgdGhlIGVsZW1lbnQncyBib3ggbW9kZWxcblx0cmV0dXJuICggdmFsICtcblx0XHRib3hNb2RlbEFkanVzdG1lbnQoXG5cdFx0XHRlbGVtLFxuXHRcdFx0ZGltZW5zaW9uLFxuXHRcdFx0ZXh0cmEgfHwgKCBpc0JvcmRlckJveCA/IFwiYm9yZGVyXCIgOiBcImNvbnRlbnRcIiApLFxuXHRcdFx0dmFsdWVJc0JvcmRlckJveCxcblx0XHRcdHN0eWxlcyxcblxuXHRcdFx0Ly8gUHJvdmlkZSB0aGUgY3VycmVudCBjb21wdXRlZCBzaXplIHRvIHJlcXVlc3Qgc2Nyb2xsIGd1dHRlciBjYWxjdWxhdGlvbiAoZ2gtMzU4OSlcblx0XHRcdHZhbFxuXHRcdClcblx0KSArIFwicHhcIjtcbn1cblxualF1ZXJ5LmV4dGVuZCgge1xuXG5cdC8vIEFkZCBpbiBzdHlsZSBwcm9wZXJ0eSBob29rcyBmb3Igb3ZlcnJpZGluZyB0aGUgZGVmYXVsdFxuXHQvLyBiZWhhdmlvciBvZiBnZXR0aW5nIGFuZCBzZXR0aW5nIGEgc3R5bGUgcHJvcGVydHlcblx0Y3NzSG9va3M6IHt9LFxuXG5cdC8vIEdldCBhbmQgc2V0IHRoZSBzdHlsZSBwcm9wZXJ0eSBvbiBhIERPTSBOb2RlXG5cdHN0eWxlOiBmdW5jdGlvbiggZWxlbSwgbmFtZSwgdmFsdWUsIGV4dHJhICkge1xuXG5cdFx0Ly8gRG9uJ3Qgc2V0IHN0eWxlcyBvbiB0ZXh0IGFuZCBjb21tZW50IG5vZGVzXG5cdFx0aWYgKCAhZWxlbSB8fCBlbGVtLm5vZGVUeXBlID09PSAzIHx8IGVsZW0ubm9kZVR5cGUgPT09IDggfHwgIWVsZW0uc3R5bGUgKSB7XG5cdFx0XHRyZXR1cm47XG5cdFx0fVxuXG5cdFx0Ly8gTWFrZSBzdXJlIHRoYXQgd2UncmUgd29ya2luZyB3aXRoIHRoZSByaWdodCBuYW1lXG5cdFx0dmFyIHJldCwgdHlwZSwgaG9va3MsXG5cdFx0XHRvcmlnTmFtZSA9IGNzc0NhbWVsQ2FzZSggbmFtZSApLFxuXHRcdFx0aXNDdXN0b21Qcm9wID0gcmN1c3RvbVByb3AudGVzdCggbmFtZSApLFxuXHRcdFx0c3R5bGUgPSBlbGVtLnN0eWxlO1xuXG5cdFx0Ly8gTWFrZSBzdXJlIHRoYXQgd2UncmUgd29ya2luZyB3aXRoIHRoZSByaWdodCBuYW1lLiBXZSBkb24ndFxuXHRcdC8vIHdhbnQgdG8gcXVlcnkgdGhlIHZhbHVlIGlmIGl0IGlzIGEgQ1NTIGN1c3RvbSBwcm9wZXJ0eVxuXHRcdC8vIHNpbmNlIHRoZXkgYXJlIHVzZXItZGVmaW5lZC5cblx0XHRpZiAoICFpc0N1c3RvbVByb3AgKSB7XG5cdFx0XHRuYW1lID0gZmluYWxQcm9wTmFtZSggb3JpZ05hbWUgKTtcblx0XHR9XG5cblx0XHQvLyBHZXRzIGhvb2sgZm9yIHRoZSBwcmVmaXhlZCB2ZXJzaW9uLCB0aGVuIHVucHJlZml4ZWQgdmVyc2lvblxuXHRcdGhvb2tzID0galF1ZXJ5LmNzc0hvb2tzWyBuYW1lIF0gfHwgalF1ZXJ5LmNzc0hvb2tzWyBvcmlnTmFtZSBdO1xuXG5cdFx0Ly8gQ2hlY2sgaWYgd2UncmUgc2V0dGluZyBhIHZhbHVlXG5cdFx0aWYgKCB2YWx1ZSAhPT0gdW5kZWZpbmVkICkge1xuXHRcdFx0dHlwZSA9IHR5cGVvZiB2YWx1ZTtcblxuXHRcdFx0Ly8gQ29udmVydCBcIis9XCIgb3IgXCItPVwiIHRvIHJlbGF0aXZlIG51bWJlcnMgKHRyYWMtNzM0NSlcblx0XHRcdGlmICggdHlwZSA9PT0gXCJzdHJpbmdcIiAmJiAoIHJldCA9IHJjc3NOdW0uZXhlYyggdmFsdWUgKSApICYmIHJldFsgMSBdICkge1xuXHRcdFx0XHR2YWx1ZSA9IGFkanVzdENTUyggZWxlbSwgbmFtZSwgcmV0ICk7XG5cblx0XHRcdFx0Ly8gRml4ZXMgYnVnIHRyYWMtOTIzN1xuXHRcdFx0XHR0eXBlID0gXCJudW1iZXJcIjtcblx0XHRcdH1cblxuXHRcdFx0Ly8gTWFrZSBzdXJlIHRoYXQgbnVsbCBhbmQgTmFOIHZhbHVlcyBhcmVuJ3Qgc2V0ICh0cmFjLTcxMTYpXG5cdFx0XHRpZiAoIHZhbHVlID09IG51bGwgfHwgdmFsdWUgIT09IHZhbHVlICkge1xuXHRcdFx0XHRyZXR1cm47XG5cdFx0XHR9XG5cblx0XHRcdC8vIElmIHRoZSB2YWx1ZSBpcyBhIG51bWJlciwgYWRkIGBweGAgZm9yIGNlcnRhaW4gQ1NTIHByb3BlcnRpZXNcblx0XHRcdGlmICggdHlwZSA9PT0gXCJudW1iZXJcIiApIHtcblx0XHRcdFx0dmFsdWUgKz0gcmV0ICYmIHJldFsgMyBdIHx8ICggaXNBdXRvUHgoIG9yaWdOYW1lICkgPyBcInB4XCIgOiBcIlwiICk7XG5cdFx0XHR9XG5cblx0XHRcdC8vIFN1cHBvcnQ6IElFIDw9OSAtIDExK1xuXHRcdFx0Ly8gYmFja2dyb3VuZC0qIHByb3BzIG9mIGEgY2xvbmVkIGVsZW1lbnQgYWZmZWN0IHRoZSBzb3VyY2UgZWxlbWVudCAodHJhYy04OTA4KVxuXHRcdFx0aWYgKCBpc0lFICYmIHZhbHVlID09PSBcIlwiICYmIG5hbWUuaW5kZXhPZiggXCJiYWNrZ3JvdW5kXCIgKSA9PT0gMCApIHtcblx0XHRcdFx0c3R5bGVbIG5hbWUgXSA9IFwiaW5oZXJpdFwiO1xuXHRcdFx0fVxuXG5cdFx0XHQvLyBJZiBhIGhvb2sgd2FzIHByb3ZpZGVkLCB1c2UgdGhhdCB2YWx1ZSwgb3RoZXJ3aXNlIGp1c3Qgc2V0IHRoZSBzcGVjaWZpZWQgdmFsdWVcblx0XHRcdGlmICggIWhvb2tzIHx8ICEoIFwic2V0XCIgaW4gaG9va3MgKSB8fFxuXHRcdFx0XHQoIHZhbHVlID0gaG9va3Muc2V0KCBlbGVtLCB2YWx1ZSwgZXh0cmEgKSApICE9PSB1bmRlZmluZWQgKSB7XG5cblx0XHRcdFx0aWYgKCBpc0N1c3RvbVByb3AgKSB7XG5cdFx0XHRcdFx0c3R5bGUuc2V0UHJvcGVydHkoIG5hbWUsIHZhbHVlICk7XG5cdFx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdFx0c3R5bGVbIG5hbWUgXSA9IHZhbHVlO1xuXHRcdFx0XHR9XG5cdFx0XHR9XG5cblx0XHR9IGVsc2Uge1xuXG5cdFx0XHQvLyBJZiBhIGhvb2sgd2FzIHByb3ZpZGVkIGdldCB0aGUgbm9uLWNvbXB1dGVkIHZhbHVlIGZyb20gdGhlcmVcblx0XHRcdGlmICggaG9va3MgJiYgXCJnZXRcIiBpbiBob29rcyAmJlxuXHRcdFx0XHQoIHJldCA9IGhvb2tzLmdldCggZWxlbSwgZmFsc2UsIGV4dHJhICkgKSAhPT0gdW5kZWZpbmVkICkge1xuXG5cdFx0XHRcdHJldHVybiByZXQ7XG5cdFx0XHR9XG5cblx0XHRcdC8vIE90aGVyd2lzZSBqdXN0IGdldCB0aGUgdmFsdWUgZnJvbSB0aGUgc3R5bGUgb2JqZWN0XG5cdFx0XHRyZXR1cm4gc3R5bGVbIG5hbWUgXTtcblx0XHR9XG5cdH0sXG5cblx0Y3NzOiBmdW5jdGlvbiggZWxlbSwgbmFtZSwgZXh0cmEsIHN0eWxlcyApIHtcblx0XHR2YXIgdmFsLCBudW0sIGhvb2tzLFxuXHRcdFx0b3JpZ05hbWUgPSBjc3NDYW1lbENhc2UoIG5hbWUgKSxcblx0XHRcdGlzQ3VzdG9tUHJvcCA9IHJjdXN0b21Qcm9wLnRlc3QoIG5hbWUgKTtcblxuXHRcdC8vIE1ha2Ugc3VyZSB0aGF0IHdlJ3JlIHdvcmtpbmcgd2l0aCB0aGUgcmlnaHQgbmFtZS4gV2UgZG9uJ3Rcblx0XHQvLyB3YW50IHRvIG1vZGlmeSB0aGUgdmFsdWUgaWYgaXQgaXMgYSBDU1MgY3VzdG9tIHByb3BlcnR5XG5cdFx0Ly8gc2luY2UgdGhleSBhcmUgdXNlci1kZWZpbmVkLlxuXHRcdGlmICggIWlzQ3VzdG9tUHJvcCApIHtcblx0XHRcdG5hbWUgPSBmaW5hbFByb3BOYW1lKCBvcmlnTmFtZSApO1xuXHRcdH1cblxuXHRcdC8vIFRyeSBwcmVmaXhlZCBuYW1lIGZvbGxvd2VkIGJ5IHRoZSB1bnByZWZpeGVkIG5hbWVcblx0XHRob29rcyA9IGpRdWVyeS5jc3NIb29rc1sgbmFtZSBdIHx8IGpRdWVyeS5jc3NIb29rc1sgb3JpZ05hbWUgXTtcblxuXHRcdC8vIElmIGEgaG9vayB3YXMgcHJvdmlkZWQgZ2V0IHRoZSBjb21wdXRlZCB2YWx1ZSBmcm9tIHRoZXJlXG5cdFx0aWYgKCBob29rcyAmJiBcImdldFwiIGluIGhvb2tzICkge1xuXHRcdFx0dmFsID0gaG9va3MuZ2V0KCBlbGVtLCB0cnVlLCBleHRyYSApO1xuXHRcdH1cblxuXHRcdC8vIE90aGVyd2lzZSwgaWYgYSB3YXkgdG8gZ2V0IHRoZSBjb21wdXRlZCB2YWx1ZSBleGlzdHMsIHVzZSB0aGF0XG5cdFx0aWYgKCB2YWwgPT09IHVuZGVmaW5lZCApIHtcblx0XHRcdHZhbCA9IGN1ckNTUyggZWxlbSwgbmFtZSwgc3R5bGVzICk7XG5cdFx0fVxuXG5cdFx0Ly8gQ29udmVydCBcIm5vcm1hbFwiIHRvIGNvbXB1dGVkIHZhbHVlXG5cdFx0aWYgKCB2YWwgPT09IFwibm9ybWFsXCIgJiYgbmFtZSBpbiBjc3NOb3JtYWxUcmFuc2Zvcm0gKSB7XG5cdFx0XHR2YWwgPSBjc3NOb3JtYWxUcmFuc2Zvcm1bIG5hbWUgXTtcblx0XHR9XG5cblx0XHQvLyBNYWtlIG51bWVyaWMgaWYgZm9yY2VkIG9yIGEgcXVhbGlmaWVyIHdhcyBwcm92aWRlZCBhbmQgdmFsIGxvb2tzIG51bWVyaWNcblx0XHRpZiAoIGV4dHJhID09PSBcIlwiIHx8IGV4dHJhICkge1xuXHRcdFx0bnVtID0gcGFyc2VGbG9hdCggdmFsICk7XG5cdFx0XHRyZXR1cm4gZXh0cmEgPT09IHRydWUgfHwgaXNGaW5pdGUoIG51bSApID8gbnVtIHx8IDAgOiB2YWw7XG5cdFx0fVxuXG5cdFx0cmV0dXJuIHZhbDtcblx0fVxufSApO1xuXG5qUXVlcnkuZWFjaCggWyBcImhlaWdodFwiLCBcIndpZHRoXCIgXSwgZnVuY3Rpb24oIF9pLCBkaW1lbnNpb24gKSB7XG5cdGpRdWVyeS5jc3NIb29rc1sgZGltZW5zaW9uIF0gPSB7XG5cdFx0Z2V0OiBmdW5jdGlvbiggZWxlbSwgY29tcHV0ZWQsIGV4dHJhICkge1xuXHRcdFx0aWYgKCBjb21wdXRlZCApIHtcblxuXHRcdFx0XHQvLyBFbGVtZW50cyB3aXRoIGBkaXNwbGF5OiBub25lYCBjYW4gaGF2ZSBkaW1lbnNpb24gaW5mbyBpZlxuXHRcdFx0XHQvLyB3ZSBpbnZpc2libHkgc2hvdyB0aGVtLlxuXHRcdFx0XHRyZXR1cm4galF1ZXJ5LmNzcyggZWxlbSwgXCJkaXNwbGF5XCIgKSA9PT0gXCJub25lXCIgP1xuXHRcdFx0XHRcdHN3YXAoIGVsZW0sIGNzc1Nob3csIGZ1bmN0aW9uKCkge1xuXHRcdFx0XHRcdFx0cmV0dXJuIGdldFdpZHRoT3JIZWlnaHQoIGVsZW0sIGRpbWVuc2lvbiwgZXh0cmEgKTtcblx0XHRcdFx0XHR9ICkgOlxuXHRcdFx0XHRcdGdldFdpZHRoT3JIZWlnaHQoIGVsZW0sIGRpbWVuc2lvbiwgZXh0cmEgKTtcblx0XHRcdH1cblx0XHR9LFxuXG5cdFx0c2V0OiBmdW5jdGlvbiggZWxlbSwgdmFsdWUsIGV4dHJhICkge1xuXHRcdFx0dmFyIG1hdGNoZXMsXG5cdFx0XHRcdHN0eWxlcyA9IGdldFN0eWxlcyggZWxlbSApLFxuXG5cdFx0XHRcdC8vIFRvIGF2b2lkIGZvcmNpbmcgYSByZWZsb3csIG9ubHkgZmV0Y2ggYm94U2l6aW5nIGlmIHdlIG5lZWQgaXQgKGdoLTM5OTEpXG5cdFx0XHRcdGlzQm9yZGVyQm94ID0gZXh0cmEgJiZcblx0XHRcdFx0XHRqUXVlcnkuY3NzKCBlbGVtLCBcImJveFNpemluZ1wiLCBmYWxzZSwgc3R5bGVzICkgPT09IFwiYm9yZGVyLWJveFwiLFxuXHRcdFx0XHRzdWJ0cmFjdCA9IGV4dHJhID9cblx0XHRcdFx0XHRib3hNb2RlbEFkanVzdG1lbnQoXG5cdFx0XHRcdFx0XHRlbGVtLFxuXHRcdFx0XHRcdFx0ZGltZW5zaW9uLFxuXHRcdFx0XHRcdFx0ZXh0cmEsXG5cdFx0XHRcdFx0XHRpc0JvcmRlckJveCxcblx0XHRcdFx0XHRcdHN0eWxlc1xuXHRcdFx0XHRcdCkgOlxuXHRcdFx0XHRcdDA7XG5cblx0XHRcdC8vIENvbnZlcnQgdG8gcGl4ZWxzIGlmIHZhbHVlIGFkanVzdG1lbnQgaXMgbmVlZGVkXG5cdFx0XHRpZiAoIHN1YnRyYWN0ICYmICggbWF0Y2hlcyA9IHJjc3NOdW0uZXhlYyggdmFsdWUgKSApICYmXG5cdFx0XHRcdCggbWF0Y2hlc1sgMyBdIHx8IFwicHhcIiApICE9PSBcInB4XCIgKSB7XG5cblx0XHRcdFx0ZWxlbS5zdHlsZVsgZGltZW5zaW9uIF0gPSB2YWx1ZTtcblx0XHRcdFx0dmFsdWUgPSBqUXVlcnkuY3NzKCBlbGVtLCBkaW1lbnNpb24gKTtcblx0XHRcdH1cblxuXHRcdFx0cmV0dXJuIHNldFBvc2l0aXZlTnVtYmVyKCBlbGVtLCB2YWx1ZSwgc3VidHJhY3QgKTtcblx0XHR9XG5cdH07XG59ICk7XG5cbi8vIFRoZXNlIGhvb2tzIGFyZSB1c2VkIGJ5IGFuaW1hdGUgdG8gZXhwYW5kIHByb3BlcnRpZXNcbmpRdWVyeS5lYWNoKCB7XG5cdG1hcmdpbjogXCJcIixcblx0cGFkZGluZzogXCJcIixcblx0Ym9yZGVyOiBcIldpZHRoXCJcbn0sIGZ1bmN0aW9uKCBwcmVmaXgsIHN1ZmZpeCApIHtcblx0alF1ZXJ5LmNzc0hvb2tzWyBwcmVmaXggKyBzdWZmaXggXSA9IHtcblx0XHRleHBhbmQ6IGZ1bmN0aW9uKCB2YWx1ZSApIHtcblx0XHRcdHZhciBpID0gMCxcblx0XHRcdFx0ZXhwYW5kZWQgPSB7fSxcblxuXHRcdFx0XHQvLyBBc3N1bWVzIGEgc2luZ2xlIG51bWJlciBpZiBub3QgYSBzdHJpbmdcblx0XHRcdFx0cGFydHMgPSB0eXBlb2YgdmFsdWUgPT09IFwic3RyaW5nXCIgPyB2YWx1ZS5zcGxpdCggXCIgXCIgKSA6IFsgdmFsdWUgXTtcblxuXHRcdFx0Zm9yICggOyBpIDwgNDsgaSsrICkge1xuXHRcdFx0XHRleHBhbmRlZFsgcHJlZml4ICsgY3NzRXhwYW5kWyBpIF0gKyBzdWZmaXggXSA9XG5cdFx0XHRcdFx0cGFydHNbIGkgXSB8fCBwYXJ0c1sgaSAtIDIgXSB8fCBwYXJ0c1sgMCBdO1xuXHRcdFx0fVxuXG5cdFx0XHRyZXR1cm4gZXhwYW5kZWQ7XG5cdFx0fVxuXHR9O1xuXG5cdGlmICggcHJlZml4ICE9PSBcIm1hcmdpblwiICkge1xuXHRcdGpRdWVyeS5jc3NIb29rc1sgcHJlZml4ICsgc3VmZml4IF0uc2V0ID0gc2V0UG9zaXRpdmVOdW1iZXI7XG5cdH1cbn0gKTtcblxualF1ZXJ5LmZuLmV4dGVuZCgge1xuXHRjc3M6IGZ1bmN0aW9uKCBuYW1lLCB2YWx1ZSApIHtcblx0XHRyZXR1cm4gYWNjZXNzKCB0aGlzLCBmdW5jdGlvbiggZWxlbSwgbmFtZSwgdmFsdWUgKSB7XG5cdFx0XHR2YXIgc3R5bGVzLCBsZW4sXG5cdFx0XHRcdG1hcCA9IHt9LFxuXHRcdFx0XHRpID0gMDtcblxuXHRcdFx0aWYgKCBBcnJheS5pc0FycmF5KCBuYW1lICkgKSB7XG5cdFx0XHRcdHN0eWxlcyA9IGdldFN0eWxlcyggZWxlbSApO1xuXHRcdFx0XHRsZW4gPSBuYW1lLmxlbmd0aDtcblxuXHRcdFx0XHRmb3IgKCA7IGkgPCBsZW47IGkrKyApIHtcblx0XHRcdFx0XHRtYXBbIG5hbWVbIGkgXSBdID0galF1ZXJ5LmNzcyggZWxlbSwgbmFtZVsgaSBdLCBmYWxzZSwgc3R5bGVzICk7XG5cdFx0XHRcdH1cblxuXHRcdFx0XHRyZXR1cm4gbWFwO1xuXHRcdFx0fVxuXG5cdFx0XHRyZXR1cm4gdmFsdWUgIT09IHVuZGVmaW5lZCA/XG5cdFx0XHRcdGpRdWVyeS5zdHlsZSggZWxlbSwgbmFtZSwgdmFsdWUgKSA6XG5cdFx0XHRcdGpRdWVyeS5jc3MoIGVsZW0sIG5hbWUgKTtcblx0XHR9LCBuYW1lLCB2YWx1ZSwgYXJndW1lbnRzLmxlbmd0aCA+IDEgKTtcblx0fVxufSApO1xuXG5mdW5jdGlvbiBUd2VlbiggZWxlbSwgb3B0aW9ucywgcHJvcCwgZW5kLCBlYXNpbmcgKSB7XG5cdHJldHVybiBuZXcgVHdlZW4ucHJvdG90eXBlLmluaXQoIGVsZW0sIG9wdGlvbnMsIHByb3AsIGVuZCwgZWFzaW5nICk7XG59XG5qUXVlcnkuVHdlZW4gPSBUd2VlbjtcblxuVHdlZW4ucHJvdG90eXBlID0ge1xuXHRjb25zdHJ1Y3RvcjogVHdlZW4sXG5cdGluaXQ6IGZ1bmN0aW9uKCBlbGVtLCBvcHRpb25zLCBwcm9wLCBlbmQsIGVhc2luZywgdW5pdCApIHtcblx0XHR0aGlzLmVsZW0gPSBlbGVtO1xuXHRcdHRoaXMucHJvcCA9IHByb3A7XG5cdFx0dGhpcy5lYXNpbmcgPSBlYXNpbmcgfHwgalF1ZXJ5LmVhc2luZy5fZGVmYXVsdDtcblx0XHR0aGlzLm9wdGlvbnMgPSBvcHRpb25zO1xuXHRcdHRoaXMuc3RhcnQgPSB0aGlzLm5vdyA9IHRoaXMuY3VyKCk7XG5cdFx0dGhpcy5lbmQgPSBlbmQ7XG5cdFx0dGhpcy51bml0ID0gdW5pdCB8fCAoIGlzQXV0b1B4KCBwcm9wICkgPyBcInB4XCIgOiBcIlwiICk7XG5cdH0sXG5cdGN1cjogZnVuY3Rpb24oKSB7XG5cdFx0dmFyIGhvb2tzID0gVHdlZW4ucHJvcEhvb2tzWyB0aGlzLnByb3AgXTtcblxuXHRcdHJldHVybiBob29rcyAmJiBob29rcy5nZXQgP1xuXHRcdFx0aG9va3MuZ2V0KCB0aGlzICkgOlxuXHRcdFx0VHdlZW4ucHJvcEhvb2tzLl9kZWZhdWx0LmdldCggdGhpcyApO1xuXHR9LFxuXHRydW46IGZ1bmN0aW9uKCBwZXJjZW50ICkge1xuXHRcdHZhciBlYXNlZCxcblx0XHRcdGhvb2tzID0gVHdlZW4ucHJvcEhvb2tzWyB0aGlzLnByb3AgXTtcblxuXHRcdGlmICggdGhpcy5vcHRpb25zLmR1cmF0aW9uICkge1xuXHRcdFx0dGhpcy5wb3MgPSBlYXNlZCA9IGpRdWVyeS5lYXNpbmdbIHRoaXMuZWFzaW5nIF0oXG5cdFx0XHRcdHBlcmNlbnQsIHRoaXMub3B0aW9ucy5kdXJhdGlvbiAqIHBlcmNlbnQsIDAsIDEsIHRoaXMub3B0aW9ucy5kdXJhdGlvblxuXHRcdFx0KTtcblx0XHR9IGVsc2Uge1xuXHRcdFx0dGhpcy5wb3MgPSBlYXNlZCA9IHBlcmNlbnQ7XG5cdFx0fVxuXHRcdHRoaXMubm93ID0gKCB0aGlzLmVuZCAtIHRoaXMuc3RhcnQgKSAqIGVhc2VkICsgdGhpcy5zdGFydDtcblxuXHRcdGlmICggdGhpcy5vcHRpb25zLnN0ZXAgKSB7XG5cdFx0XHR0aGlzLm9wdGlvbnMuc3RlcC5jYWxsKCB0aGlzLmVsZW0sIHRoaXMubm93LCB0aGlzICk7XG5cdFx0fVxuXG5cdFx0aWYgKCBob29rcyAmJiBob29rcy5zZXQgKSB7XG5cdFx0XHRob29rcy5zZXQoIHRoaXMgKTtcblx0XHR9IGVsc2Uge1xuXHRcdFx0VHdlZW4ucHJvcEhvb2tzLl9kZWZhdWx0LnNldCggdGhpcyApO1xuXHRcdH1cblx0XHRyZXR1cm4gdGhpcztcblx0fVxufTtcblxuVHdlZW4ucHJvdG90eXBlLmluaXQucHJvdG90eXBlID0gVHdlZW4ucHJvdG90eXBlO1xuXG5Ud2Vlbi5wcm9wSG9va3MgPSB7XG5cdF9kZWZhdWx0OiB7XG5cdFx0Z2V0OiBmdW5jdGlvbiggdHdlZW4gKSB7XG5cdFx0XHR2YXIgcmVzdWx0O1xuXG5cdFx0XHQvLyBVc2UgYSBwcm9wZXJ0eSBvbiB0aGUgZWxlbWVudCBkaXJlY3RseSB3aGVuIGl0IGlzIG5vdCBhIERPTSBlbGVtZW50LFxuXHRcdFx0Ly8gb3Igd2hlbiB0aGVyZSBpcyBubyBtYXRjaGluZyBzdHlsZSBwcm9wZXJ0eSB0aGF0IGV4aXN0cy5cblx0XHRcdGlmICggdHdlZW4uZWxlbS5ub2RlVHlwZSAhPT0gMSB8fFxuXHRcdFx0XHR0d2Vlbi5lbGVtWyB0d2Vlbi5wcm9wIF0gIT0gbnVsbCAmJiB0d2Vlbi5lbGVtLnN0eWxlWyB0d2Vlbi5wcm9wIF0gPT0gbnVsbCApIHtcblx0XHRcdFx0cmV0dXJuIHR3ZWVuLmVsZW1bIHR3ZWVuLnByb3AgXTtcblx0XHRcdH1cblxuXHRcdFx0Ly8gUGFzc2luZyBhbiBlbXB0eSBzdHJpbmcgYXMgYSAzcmQgcGFyYW1ldGVyIHRvIC5jc3Mgd2lsbCBhdXRvbWF0aWNhbGx5XG5cdFx0XHQvLyBhdHRlbXB0IGEgcGFyc2VGbG9hdCBhbmQgZmFsbGJhY2sgdG8gYSBzdHJpbmcgaWYgdGhlIHBhcnNlIGZhaWxzLlxuXHRcdFx0Ly8gU2ltcGxlIHZhbHVlcyBzdWNoIGFzIFwiMTBweFwiIGFyZSBwYXJzZWQgdG8gRmxvYXQ7XG5cdFx0XHQvLyBjb21wbGV4IHZhbHVlcyBzdWNoIGFzIFwicm90YXRlKDFyYWQpXCIgYXJlIHJldHVybmVkIGFzLWlzLlxuXHRcdFx0cmVzdWx0ID0galF1ZXJ5LmNzcyggdHdlZW4uZWxlbSwgdHdlZW4ucHJvcCwgXCJcIiApO1xuXG5cdFx0XHQvLyBFbXB0eSBzdHJpbmdzLCBudWxsLCB1bmRlZmluZWQgYW5kIFwiYXV0b1wiIGFyZSBjb252ZXJ0ZWQgdG8gMC5cblx0XHRcdHJldHVybiAhcmVzdWx0IHx8IHJlc3VsdCA9PT0gXCJhdXRvXCIgPyAwIDogcmVzdWx0O1xuXHRcdH0sXG5cdFx0c2V0OiBmdW5jdGlvbiggdHdlZW4gKSB7XG5cblx0XHRcdC8vIFVzZSBzdGVwIGhvb2sgZm9yIGJhY2sgY29tcGF0LlxuXHRcdFx0Ly8gVXNlIGNzc0hvb2sgaWYgaXRzIHRoZXJlLlxuXHRcdFx0Ly8gVXNlIC5zdHlsZSBpZiBhdmFpbGFibGUgYW5kIHVzZSBwbGFpbiBwcm9wZXJ0aWVzIHdoZXJlIGF2YWlsYWJsZS5cblx0XHRcdGlmICggalF1ZXJ5LmZ4LnN0ZXBbIHR3ZWVuLnByb3AgXSApIHtcblx0XHRcdFx0alF1ZXJ5LmZ4LnN0ZXBbIHR3ZWVuLnByb3AgXSggdHdlZW4gKTtcblx0XHRcdH0gZWxzZSBpZiAoIHR3ZWVuLmVsZW0ubm9kZVR5cGUgPT09IDEgJiYgKFxuXHRcdFx0XHRqUXVlcnkuY3NzSG9va3NbIHR3ZWVuLnByb3AgXSB8fFxuXHRcdFx0XHRcdHR3ZWVuLmVsZW0uc3R5bGVbIGZpbmFsUHJvcE5hbWUoIHR3ZWVuLnByb3AgKSBdICE9IG51bGwgKSApIHtcblx0XHRcdFx0alF1ZXJ5LnN0eWxlKCB0d2Vlbi5lbGVtLCB0d2Vlbi5wcm9wLCB0d2Vlbi5ub3cgKyB0d2Vlbi51bml0ICk7XG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHR0d2Vlbi5lbGVtWyB0d2Vlbi5wcm9wIF0gPSB0d2Vlbi5ub3c7XG5cdFx0XHR9XG5cdFx0fVxuXHR9XG59O1xuXG5qUXVlcnkuZWFzaW5nID0ge1xuXHRsaW5lYXI6IGZ1bmN0aW9uKCBwICkge1xuXHRcdHJldHVybiBwO1xuXHR9LFxuXHRzd2luZzogZnVuY3Rpb24oIHAgKSB7XG5cdFx0cmV0dXJuIDAuNSAtIE1hdGguY29zKCBwICogTWF0aC5QSSApIC8gMjtcblx0fSxcblx0X2RlZmF1bHQ6IFwic3dpbmdcIlxufTtcblxualF1ZXJ5LmZ4ID0gVHdlZW4ucHJvdG90eXBlLmluaXQ7XG5cbi8vIEJhY2sgY29tcGF0IDwxLjggZXh0ZW5zaW9uIHBvaW50XG5qUXVlcnkuZnguc3RlcCA9IHt9O1xuXG52YXJcblx0ZnhOb3csIGluUHJvZ3Jlc3MsXG5cdHJmeHR5cGVzID0gL14oPzp0b2dnbGV8c2hvd3xoaWRlKSQvLFxuXHRycnVuID0gL3F1ZXVlSG9va3MkLztcblxuZnVuY3Rpb24gc2NoZWR1bGUoKSB7XG5cdGlmICggaW5Qcm9ncmVzcyApIHtcblx0XHRpZiAoIGRvY3VtZW50JDEuaGlkZGVuID09PSBmYWxzZSAmJiB3aW5kb3cucmVxdWVzdEFuaW1hdGlvbkZyYW1lICkge1xuXHRcdFx0d2luZG93LnJlcXVlc3RBbmltYXRpb25GcmFtZSggc2NoZWR1bGUgKTtcblx0XHR9IGVsc2Uge1xuXHRcdFx0d2luZG93LnNldFRpbWVvdXQoIHNjaGVkdWxlLCAxMyApO1xuXHRcdH1cblxuXHRcdGpRdWVyeS5meC50aWNrKCk7XG5cdH1cbn1cblxuLy8gQW5pbWF0aW9ucyBjcmVhdGVkIHN5bmNocm9ub3VzbHkgd2lsbCBydW4gc3luY2hyb25vdXNseVxuZnVuY3Rpb24gY3JlYXRlRnhOb3coKSB7XG5cdHdpbmRvdy5zZXRUaW1lb3V0KCBmdW5jdGlvbigpIHtcblx0XHRmeE5vdyA9IHVuZGVmaW5lZDtcblx0fSApO1xuXHRyZXR1cm4gKCBmeE5vdyA9IERhdGUubm93KCkgKTtcbn1cblxuLy8gR2VuZXJhdGUgcGFyYW1ldGVycyB0byBjcmVhdGUgYSBzdGFuZGFyZCBhbmltYXRpb25cbmZ1bmN0aW9uIGdlbkZ4KCB0eXBlLCBpbmNsdWRlV2lkdGggKSB7XG5cdHZhciB3aGljaCxcblx0XHRpID0gMCxcblx0XHRhdHRycyA9IHsgaGVpZ2h0OiB0eXBlIH07XG5cblx0Ly8gSWYgd2UgaW5jbHVkZSB3aWR0aCwgc3RlcCB2YWx1ZSBpcyAxIHRvIGRvIGFsbCBjc3NFeHBhbmQgdmFsdWVzLFxuXHQvLyBvdGhlcndpc2Ugc3RlcCB2YWx1ZSBpcyAyIHRvIHNraXAgb3ZlciBMZWZ0IGFuZCBSaWdodFxuXHRpbmNsdWRlV2lkdGggPSBpbmNsdWRlV2lkdGggPyAxIDogMDtcblx0Zm9yICggOyBpIDwgNDsgaSArPSAyIC0gaW5jbHVkZVdpZHRoICkge1xuXHRcdHdoaWNoID0gY3NzRXhwYW5kWyBpIF07XG5cdFx0YXR0cnNbIFwibWFyZ2luXCIgKyB3aGljaCBdID0gYXR0cnNbIFwicGFkZGluZ1wiICsgd2hpY2ggXSA9IHR5cGU7XG5cdH1cblxuXHRpZiAoIGluY2x1ZGVXaWR0aCApIHtcblx0XHRhdHRycy5vcGFjaXR5ID0gYXR0cnMud2lkdGggPSB0eXBlO1xuXHR9XG5cblx0cmV0dXJuIGF0dHJzO1xufVxuXG5mdW5jdGlvbiBjcmVhdGVUd2VlbiggdmFsdWUsIHByb3AsIGFuaW1hdGlvbiApIHtcblx0dmFyIHR3ZWVuLFxuXHRcdGNvbGxlY3Rpb24gPSAoIEFuaW1hdGlvbi50d2VlbmVyc1sgcHJvcCBdIHx8IFtdICkuY29uY2F0KCBBbmltYXRpb24udHdlZW5lcnNbIFwiKlwiIF0gKSxcblx0XHRpbmRleCA9IDAsXG5cdFx0bGVuZ3RoID0gY29sbGVjdGlvbi5sZW5ndGg7XG5cdGZvciAoIDsgaW5kZXggPCBsZW5ndGg7IGluZGV4KysgKSB7XG5cdFx0aWYgKCAoIHR3ZWVuID0gY29sbGVjdGlvblsgaW5kZXggXS5jYWxsKCBhbmltYXRpb24sIHByb3AsIHZhbHVlICkgKSApIHtcblxuXHRcdFx0Ly8gV2UncmUgZG9uZSB3aXRoIHRoaXMgcHJvcGVydHlcblx0XHRcdHJldHVybiB0d2Vlbjtcblx0XHR9XG5cdH1cbn1cblxuZnVuY3Rpb24gZGVmYXVsdFByZWZpbHRlciggZWxlbSwgcHJvcHMsIG9wdHMgKSB7XG5cdHZhciBwcm9wLCB2YWx1ZSwgdG9nZ2xlLCBob29rcywgb2xkZmlyZSwgcHJvcFR3ZWVuLCByZXN0b3JlRGlzcGxheSwgZGlzcGxheSxcblx0XHRpc0JveCA9IFwid2lkdGhcIiBpbiBwcm9wcyB8fCBcImhlaWdodFwiIGluIHByb3BzLFxuXHRcdGFuaW0gPSB0aGlzLFxuXHRcdG9yaWcgPSB7fSxcblx0XHRzdHlsZSA9IGVsZW0uc3R5bGUsXG5cdFx0aGlkZGVuID0gZWxlbS5ub2RlVHlwZSAmJiBpc0hpZGRlbldpdGhpblRyZWUoIGVsZW0gKSxcblx0XHRkYXRhU2hvdyA9IGRhdGFQcml2LmdldCggZWxlbSwgXCJmeHNob3dcIiApO1xuXG5cdC8vIFF1ZXVlLXNraXBwaW5nIGFuaW1hdGlvbnMgaGlqYWNrIHRoZSBmeCBob29rc1xuXHRpZiAoICFvcHRzLnF1ZXVlICkge1xuXHRcdGhvb2tzID0galF1ZXJ5Ll9xdWV1ZUhvb2tzKCBlbGVtLCBcImZ4XCIgKTtcblx0XHRpZiAoIGhvb2tzLnVucXVldWVkID09IG51bGwgKSB7XG5cdFx0XHRob29rcy51bnF1ZXVlZCA9IDA7XG5cdFx0XHRvbGRmaXJlID0gaG9va3MuZW1wdHkuZmlyZTtcblx0XHRcdGhvb2tzLmVtcHR5LmZpcmUgPSBmdW5jdGlvbigpIHtcblx0XHRcdFx0aWYgKCAhaG9va3MudW5xdWV1ZWQgKSB7XG5cdFx0XHRcdFx0b2xkZmlyZSgpO1xuXHRcdFx0XHR9XG5cdFx0XHR9O1xuXHRcdH1cblx0XHRob29rcy51bnF1ZXVlZCsrO1xuXG5cdFx0YW5pbS5hbHdheXMoIGZ1bmN0aW9uKCkge1xuXG5cdFx0XHQvLyBFbnN1cmUgdGhlIGNvbXBsZXRlIGhhbmRsZXIgaXMgY2FsbGVkIGJlZm9yZSB0aGlzIGNvbXBsZXRlc1xuXHRcdFx0YW5pbS5hbHdheXMoIGZ1bmN0aW9uKCkge1xuXHRcdFx0XHRob29rcy51bnF1ZXVlZC0tO1xuXHRcdFx0XHRpZiAoICFqUXVlcnkucXVldWUoIGVsZW0sIFwiZnhcIiApLmxlbmd0aCApIHtcblx0XHRcdFx0XHRob29rcy5lbXB0eS5maXJlKCk7XG5cdFx0XHRcdH1cblx0XHRcdH0gKTtcblx0XHR9ICk7XG5cdH1cblxuXHQvLyBEZXRlY3Qgc2hvdy9oaWRlIGFuaW1hdGlvbnNcblx0Zm9yICggcHJvcCBpbiBwcm9wcyApIHtcblx0XHR2YWx1ZSA9IHByb3BzWyBwcm9wIF07XG5cdFx0aWYgKCByZnh0eXBlcy50ZXN0KCB2YWx1ZSApICkge1xuXHRcdFx0ZGVsZXRlIHByb3BzWyBwcm9wIF07XG5cdFx0XHR0b2dnbGUgPSB0b2dnbGUgfHwgdmFsdWUgPT09IFwidG9nZ2xlXCI7XG5cdFx0XHRpZiAoIHZhbHVlID09PSAoIGhpZGRlbiA/IFwiaGlkZVwiIDogXCJzaG93XCIgKSApIHtcblxuXHRcdFx0XHQvLyBQcmV0ZW5kIHRvIGJlIGhpZGRlbiBpZiB0aGlzIGlzIGEgXCJzaG93XCIgYW5kXG5cdFx0XHRcdC8vIHRoZXJlIGlzIHN0aWxsIGRhdGEgZnJvbSBhIHN0b3BwZWQgc2hvdy9oaWRlXG5cdFx0XHRcdGlmICggdmFsdWUgPT09IFwic2hvd1wiICYmIGRhdGFTaG93ICYmIGRhdGFTaG93WyBwcm9wIF0gIT09IHVuZGVmaW5lZCApIHtcblx0XHRcdFx0XHRoaWRkZW4gPSB0cnVlO1xuXG5cdFx0XHRcdC8vIElnbm9yZSBhbGwgb3RoZXIgbm8tb3Agc2hvdy9oaWRlIGRhdGFcblx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHRjb250aW51ZTtcblx0XHRcdFx0fVxuXHRcdFx0fVxuXHRcdFx0b3JpZ1sgcHJvcCBdID0gZGF0YVNob3cgJiYgZGF0YVNob3dbIHByb3AgXSB8fCBqUXVlcnkuc3R5bGUoIGVsZW0sIHByb3AgKTtcblx0XHR9XG5cdH1cblxuXHQvLyBCYWlsIG91dCBpZiB0aGlzIGlzIGEgbm8tb3AgbGlrZSAuaGlkZSgpLmhpZGUoKVxuXHRwcm9wVHdlZW4gPSAhalF1ZXJ5LmlzRW1wdHlPYmplY3QoIHByb3BzICk7XG5cdGlmICggIXByb3BUd2VlbiAmJiBqUXVlcnkuaXNFbXB0eU9iamVjdCggb3JpZyApICkge1xuXHRcdHJldHVybjtcblx0fVxuXG5cdC8vIFJlc3RyaWN0IFwib3ZlcmZsb3dcIiBhbmQgXCJkaXNwbGF5XCIgc3R5bGVzIGR1cmluZyBib3ggYW5pbWF0aW9uc1xuXHRpZiAoIGlzQm94ICYmIGVsZW0ubm9kZVR5cGUgPT09IDEgKSB7XG5cblx0XHQvLyBTdXBwb3J0OiBJRSA8PTkgLSAxMStcblx0XHQvLyBSZWNvcmQgYWxsIDMgb3ZlcmZsb3cgYXR0cmlidXRlcyBiZWNhdXNlIElFIGRvZXMgbm90IGluZmVyIHRoZSBzaG9ydGhhbmRcblx0XHQvLyBmcm9tIGlkZW50aWNhbGx5LXZhbHVlZCBvdmVyZmxvd1ggYW5kIG92ZXJmbG93WS5cblx0XHRvcHRzLm92ZXJmbG93ID0gWyBzdHlsZS5vdmVyZmxvdywgc3R5bGUub3ZlcmZsb3dYLCBzdHlsZS5vdmVyZmxvd1kgXTtcblxuXHRcdC8vIElkZW50aWZ5IGEgZGlzcGxheSB0eXBlLCBwcmVmZXJyaW5nIG9sZCBzaG93L2hpZGUgZGF0YSBvdmVyIHRoZSBDU1MgY2FzY2FkZVxuXHRcdHJlc3RvcmVEaXNwbGF5ID0gZGF0YVNob3cgJiYgZGF0YVNob3cuZGlzcGxheTtcblx0XHRpZiAoIHJlc3RvcmVEaXNwbGF5ID09IG51bGwgKSB7XG5cdFx0XHRyZXN0b3JlRGlzcGxheSA9IGRhdGFQcml2LmdldCggZWxlbSwgXCJkaXNwbGF5XCIgKTtcblx0XHR9XG5cdFx0ZGlzcGxheSA9IGpRdWVyeS5jc3MoIGVsZW0sIFwiZGlzcGxheVwiICk7XG5cdFx0aWYgKCBkaXNwbGF5ID09PSBcIm5vbmVcIiApIHtcblx0XHRcdGlmICggcmVzdG9yZURpc3BsYXkgKSB7XG5cdFx0XHRcdGRpc3BsYXkgPSByZXN0b3JlRGlzcGxheTtcblx0XHRcdH0gZWxzZSB7XG5cblx0XHRcdFx0Ly8gR2V0IG5vbmVtcHR5IHZhbHVlKHMpIGJ5IHRlbXBvcmFyaWx5IGZvcmNpbmcgdmlzaWJpbGl0eVxuXHRcdFx0XHRzaG93SGlkZSggWyBlbGVtIF0sIHRydWUgKTtcblx0XHRcdFx0cmVzdG9yZURpc3BsYXkgPSBlbGVtLnN0eWxlLmRpc3BsYXkgfHwgcmVzdG9yZURpc3BsYXk7XG5cdFx0XHRcdGRpc3BsYXkgPSBqUXVlcnkuY3NzKCBlbGVtLCBcImRpc3BsYXlcIiApO1xuXHRcdFx0XHRzaG93SGlkZSggWyBlbGVtIF0gKTtcblx0XHRcdH1cblx0XHR9XG5cblx0XHQvLyBBbmltYXRlIGlubGluZSBlbGVtZW50cyBhcyBpbmxpbmUtYmxvY2tcblx0XHRpZiAoIGRpc3BsYXkgPT09IFwiaW5saW5lXCIgfHwgZGlzcGxheSA9PT0gXCJpbmxpbmUtYmxvY2tcIiAmJiByZXN0b3JlRGlzcGxheSAhPSBudWxsICkge1xuXHRcdFx0aWYgKCBqUXVlcnkuY3NzKCBlbGVtLCBcImZsb2F0XCIgKSA9PT0gXCJub25lXCIgKSB7XG5cblx0XHRcdFx0Ly8gUmVzdG9yZSB0aGUgb3JpZ2luYWwgZGlzcGxheSB2YWx1ZSBhdCB0aGUgZW5kIG9mIHB1cmUgc2hvdy9oaWRlIGFuaW1hdGlvbnNcblx0XHRcdFx0aWYgKCAhcHJvcFR3ZWVuICkge1xuXHRcdFx0XHRcdGFuaW0uZG9uZSggZnVuY3Rpb24oKSB7XG5cdFx0XHRcdFx0XHRzdHlsZS5kaXNwbGF5ID0gcmVzdG9yZURpc3BsYXk7XG5cdFx0XHRcdFx0fSApO1xuXHRcdFx0XHRcdGlmICggcmVzdG9yZURpc3BsYXkgPT0gbnVsbCApIHtcblx0XHRcdFx0XHRcdGRpc3BsYXkgPSBzdHlsZS5kaXNwbGF5O1xuXHRcdFx0XHRcdFx0cmVzdG9yZURpc3BsYXkgPSBkaXNwbGF5ID09PSBcIm5vbmVcIiA/IFwiXCIgOiBkaXNwbGF5O1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0fVxuXHRcdFx0XHRzdHlsZS5kaXNwbGF5ID0gXCJpbmxpbmUtYmxvY2tcIjtcblx0XHRcdH1cblx0XHR9XG5cdH1cblxuXHRpZiAoIG9wdHMub3ZlcmZsb3cgKSB7XG5cdFx0c3R5bGUub3ZlcmZsb3cgPSBcImhpZGRlblwiO1xuXHRcdGFuaW0uYWx3YXlzKCBmdW5jdGlvbigpIHtcblx0XHRcdHN0eWxlLm92ZXJmbG93ID0gb3B0cy5vdmVyZmxvd1sgMCBdO1xuXHRcdFx0c3R5bGUub3ZlcmZsb3dYID0gb3B0cy5vdmVyZmxvd1sgMSBdO1xuXHRcdFx0c3R5bGUub3ZlcmZsb3dZID0gb3B0cy5vdmVyZmxvd1sgMiBdO1xuXHRcdH0gKTtcblx0fVxuXG5cdC8vIEltcGxlbWVudCBzaG93L2hpZGUgYW5pbWF0aW9uc1xuXHRwcm9wVHdlZW4gPSBmYWxzZTtcblx0Zm9yICggcHJvcCBpbiBvcmlnICkge1xuXG5cdFx0Ly8gR2VuZXJhbCBzaG93L2hpZGUgc2V0dXAgZm9yIHRoaXMgZWxlbWVudCBhbmltYXRpb25cblx0XHRpZiAoICFwcm9wVHdlZW4gKSB7XG5cdFx0XHRpZiAoIGRhdGFTaG93ICkge1xuXHRcdFx0XHRpZiAoIFwiaGlkZGVuXCIgaW4gZGF0YVNob3cgKSB7XG5cdFx0XHRcdFx0aGlkZGVuID0gZGF0YVNob3cuaGlkZGVuO1xuXHRcdFx0XHR9XG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRkYXRhU2hvdyA9IGRhdGFQcml2LnNldCggZWxlbSwgXCJmeHNob3dcIiwgeyBkaXNwbGF5OiByZXN0b3JlRGlzcGxheSB9ICk7XG5cdFx0XHR9XG5cblx0XHRcdC8vIFN0b3JlIGhpZGRlbi92aXNpYmxlIGZvciB0b2dnbGUgc28gYC5zdG9wKCkudG9nZ2xlKClgIFwicmV2ZXJzZXNcIlxuXHRcdFx0aWYgKCB0b2dnbGUgKSB7XG5cdFx0XHRcdGRhdGFTaG93LmhpZGRlbiA9ICFoaWRkZW47XG5cdFx0XHR9XG5cblx0XHRcdC8vIFNob3cgZWxlbWVudHMgYmVmb3JlIGFuaW1hdGluZyB0aGVtXG5cdFx0XHRpZiAoIGhpZGRlbiApIHtcblx0XHRcdFx0c2hvd0hpZGUoIFsgZWxlbSBdLCB0cnVlICk7XG5cdFx0XHR9XG5cblx0XHRcdC8vIGVzbGludC1kaXNhYmxlLW5leHQtbGluZSBuby1sb29wLWZ1bmNcblx0XHRcdGFuaW0uZG9uZSggZnVuY3Rpb24oKSB7XG5cblx0XHRcdFx0Ly8gVGhlIGZpbmFsIHN0ZXAgb2YgYSBcImhpZGVcIiBhbmltYXRpb24gaXMgYWN0dWFsbHkgaGlkaW5nIHRoZSBlbGVtZW50XG5cdFx0XHRcdGlmICggIWhpZGRlbiApIHtcblx0XHRcdFx0XHRzaG93SGlkZSggWyBlbGVtIF0gKTtcblx0XHRcdFx0fVxuXHRcdFx0XHRkYXRhUHJpdi5yZW1vdmUoIGVsZW0sIFwiZnhzaG93XCIgKTtcblx0XHRcdFx0Zm9yICggcHJvcCBpbiBvcmlnICkge1xuXHRcdFx0XHRcdGpRdWVyeS5zdHlsZSggZWxlbSwgcHJvcCwgb3JpZ1sgcHJvcCBdICk7XG5cdFx0XHRcdH1cblx0XHRcdH0gKTtcblx0XHR9XG5cblx0XHQvLyBQZXItcHJvcGVydHkgc2V0dXBcblx0XHRwcm9wVHdlZW4gPSBjcmVhdGVUd2VlbiggaGlkZGVuID8gZGF0YVNob3dbIHByb3AgXSA6IDAsIHByb3AsIGFuaW0gKTtcblx0XHRpZiAoICEoIHByb3AgaW4gZGF0YVNob3cgKSApIHtcblx0XHRcdGRhdGFTaG93WyBwcm9wIF0gPSBwcm9wVHdlZW4uc3RhcnQ7XG5cdFx0XHRpZiAoIGhpZGRlbiApIHtcblx0XHRcdFx0cHJvcFR3ZWVuLmVuZCA9IHByb3BUd2Vlbi5zdGFydDtcblx0XHRcdFx0cHJvcFR3ZWVuLnN0YXJ0ID0gMDtcblx0XHRcdH1cblx0XHR9XG5cdH1cbn1cblxuZnVuY3Rpb24gcHJvcEZpbHRlciggcHJvcHMsIHNwZWNpYWxFYXNpbmcgKSB7XG5cdHZhciBpbmRleCwgbmFtZSwgZWFzaW5nLCB2YWx1ZSwgaG9va3M7XG5cblx0Ly8gY2FtZWxDYXNlLCBzcGVjaWFsRWFzaW5nIGFuZCBleHBhbmQgY3NzSG9vayBwYXNzXG5cdGZvciAoIGluZGV4IGluIHByb3BzICkge1xuXHRcdG5hbWUgPSBjc3NDYW1lbENhc2UoIGluZGV4ICk7XG5cdFx0ZWFzaW5nID0gc3BlY2lhbEVhc2luZ1sgbmFtZSBdO1xuXHRcdHZhbHVlID0gcHJvcHNbIGluZGV4IF07XG5cdFx0aWYgKCBBcnJheS5pc0FycmF5KCB2YWx1ZSApICkge1xuXHRcdFx0ZWFzaW5nID0gdmFsdWVbIDEgXTtcblx0XHRcdHZhbHVlID0gcHJvcHNbIGluZGV4IF0gPSB2YWx1ZVsgMCBdO1xuXHRcdH1cblxuXHRcdGlmICggaW5kZXggIT09IG5hbWUgKSB7XG5cdFx0XHRwcm9wc1sgbmFtZSBdID0gdmFsdWU7XG5cdFx0XHRkZWxldGUgcHJvcHNbIGluZGV4IF07XG5cdFx0fVxuXG5cdFx0aG9va3MgPSBqUXVlcnkuY3NzSG9va3NbIG5hbWUgXTtcblx0XHRpZiAoIGhvb2tzICYmIFwiZXhwYW5kXCIgaW4gaG9va3MgKSB7XG5cdFx0XHR2YWx1ZSA9IGhvb2tzLmV4cGFuZCggdmFsdWUgKTtcblx0XHRcdGRlbGV0ZSBwcm9wc1sgbmFtZSBdO1xuXG5cdFx0XHQvLyBOb3QgcXVpdGUgJC5leHRlbmQsIHRoaXMgd29uJ3Qgb3ZlcndyaXRlIGV4aXN0aW5nIGtleXMuXG5cdFx0XHQvLyBSZXVzaW5nICdpbmRleCcgYmVjYXVzZSB3ZSBoYXZlIHRoZSBjb3JyZWN0IFwibmFtZVwiXG5cdFx0XHRmb3IgKCBpbmRleCBpbiB2YWx1ZSApIHtcblx0XHRcdFx0aWYgKCAhKCBpbmRleCBpbiBwcm9wcyApICkge1xuXHRcdFx0XHRcdHByb3BzWyBpbmRleCBdID0gdmFsdWVbIGluZGV4IF07XG5cdFx0XHRcdFx0c3BlY2lhbEVhc2luZ1sgaW5kZXggXSA9IGVhc2luZztcblx0XHRcdFx0fVxuXHRcdFx0fVxuXHRcdH0gZWxzZSB7XG5cdFx0XHRzcGVjaWFsRWFzaW5nWyBuYW1lIF0gPSBlYXNpbmc7XG5cdFx0fVxuXHR9XG59XG5cbmZ1bmN0aW9uIEFuaW1hdGlvbiggZWxlbSwgcHJvcGVydGllcywgb3B0aW9ucyApIHtcblx0dmFyIHJlc3VsdCxcblx0XHRzdG9wcGVkLFxuXHRcdGluZGV4ID0gMCxcblx0XHRsZW5ndGggPSBBbmltYXRpb24ucHJlZmlsdGVycy5sZW5ndGgsXG5cdFx0ZGVmZXJyZWQgPSBqUXVlcnkuRGVmZXJyZWQoKS5hbHdheXMoIGZ1bmN0aW9uKCkge1xuXG5cdFx0XHQvLyBEb24ndCBtYXRjaCBlbGVtIGluIHRoZSA6YW5pbWF0ZWQgc2VsZWN0b3Jcblx0XHRcdGRlbGV0ZSB0aWNrLmVsZW07XG5cdFx0fSApLFxuXHRcdHRpY2sgPSBmdW5jdGlvbigpIHtcblx0XHRcdGlmICggc3RvcHBlZCApIHtcblx0XHRcdFx0cmV0dXJuIGZhbHNlO1xuXHRcdFx0fVxuXHRcdFx0dmFyIGN1cnJlbnRUaW1lID0gZnhOb3cgfHwgY3JlYXRlRnhOb3coKSxcblx0XHRcdFx0cmVtYWluaW5nID0gTWF0aC5tYXgoIDAsIGFuaW1hdGlvbi5zdGFydFRpbWUgKyBhbmltYXRpb24uZHVyYXRpb24gLSBjdXJyZW50VGltZSApLFxuXG5cdFx0XHRcdHBlcmNlbnQgPSAxIC0gKCByZW1haW5pbmcgLyBhbmltYXRpb24uZHVyYXRpb24gfHwgMCApLFxuXHRcdFx0XHRpbmRleCA9IDAsXG5cdFx0XHRcdGxlbmd0aCA9IGFuaW1hdGlvbi50d2VlbnMubGVuZ3RoO1xuXG5cdFx0XHRmb3IgKCA7IGluZGV4IDwgbGVuZ3RoOyBpbmRleCsrICkge1xuXHRcdFx0XHRhbmltYXRpb24udHdlZW5zWyBpbmRleCBdLnJ1biggcGVyY2VudCApO1xuXHRcdFx0fVxuXG5cdFx0XHRkZWZlcnJlZC5ub3RpZnlXaXRoKCBlbGVtLCBbIGFuaW1hdGlvbiwgcGVyY2VudCwgcmVtYWluaW5nIF0gKTtcblxuXHRcdFx0Ly8gSWYgdGhlcmUncyBtb3JlIHRvIGRvLCB5aWVsZFxuXHRcdFx0aWYgKCBwZXJjZW50IDwgMSAmJiBsZW5ndGggKSB7XG5cdFx0XHRcdHJldHVybiByZW1haW5pbmc7XG5cdFx0XHR9XG5cblx0XHRcdC8vIElmIHRoaXMgd2FzIGFuIGVtcHR5IGFuaW1hdGlvbiwgc3ludGhlc2l6ZSBhIGZpbmFsIHByb2dyZXNzIG5vdGlmaWNhdGlvblxuXHRcdFx0aWYgKCAhbGVuZ3RoICkge1xuXHRcdFx0XHRkZWZlcnJlZC5ub3RpZnlXaXRoKCBlbGVtLCBbIGFuaW1hdGlvbiwgMSwgMCBdICk7XG5cdFx0XHR9XG5cblx0XHRcdC8vIFJlc29sdmUgdGhlIGFuaW1hdGlvbiBhbmQgcmVwb3J0IGl0cyBjb25jbHVzaW9uXG5cdFx0XHRkZWZlcnJlZC5yZXNvbHZlV2l0aCggZWxlbSwgWyBhbmltYXRpb24gXSApO1xuXHRcdFx0cmV0dXJuIGZhbHNlO1xuXHRcdH0sXG5cdFx0YW5pbWF0aW9uID0gZGVmZXJyZWQucHJvbWlzZSgge1xuXHRcdFx0ZWxlbTogZWxlbSxcblx0XHRcdHByb3BzOiBqUXVlcnkuZXh0ZW5kKCB7fSwgcHJvcGVydGllcyApLFxuXHRcdFx0b3B0czogalF1ZXJ5LmV4dGVuZCggdHJ1ZSwge1xuXHRcdFx0XHRzcGVjaWFsRWFzaW5nOiB7fSxcblx0XHRcdFx0ZWFzaW5nOiBqUXVlcnkuZWFzaW5nLl9kZWZhdWx0XG5cdFx0XHR9LCBvcHRpb25zICksXG5cdFx0XHRvcmlnaW5hbFByb3BlcnRpZXM6IHByb3BlcnRpZXMsXG5cdFx0XHRvcmlnaW5hbE9wdGlvbnM6IG9wdGlvbnMsXG5cdFx0XHRzdGFydFRpbWU6IGZ4Tm93IHx8IGNyZWF0ZUZ4Tm93KCksXG5cdFx0XHRkdXJhdGlvbjogb3B0aW9ucy5kdXJhdGlvbixcblx0XHRcdHR3ZWVuczogW10sXG5cdFx0XHRjcmVhdGVUd2VlbjogZnVuY3Rpb24oIHByb3AsIGVuZCApIHtcblx0XHRcdFx0dmFyIHR3ZWVuID0galF1ZXJ5LlR3ZWVuKCBlbGVtLCBhbmltYXRpb24ub3B0cywgcHJvcCwgZW5kLFxuXHRcdFx0XHRcdGFuaW1hdGlvbi5vcHRzLnNwZWNpYWxFYXNpbmdbIHByb3AgXSB8fCBhbmltYXRpb24ub3B0cy5lYXNpbmcgKTtcblx0XHRcdFx0YW5pbWF0aW9uLnR3ZWVucy5wdXNoKCB0d2VlbiApO1xuXHRcdFx0XHRyZXR1cm4gdHdlZW47XG5cdFx0XHR9LFxuXHRcdFx0c3RvcDogZnVuY3Rpb24oIGdvdG9FbmQgKSB7XG5cdFx0XHRcdHZhciBpbmRleCA9IDAsXG5cblx0XHRcdFx0XHQvLyBJZiB3ZSBhcmUgZ29pbmcgdG8gdGhlIGVuZCwgd2Ugd2FudCB0byBydW4gYWxsIHRoZSB0d2VlbnNcblx0XHRcdFx0XHQvLyBvdGhlcndpc2Ugd2Ugc2tpcCB0aGlzIHBhcnRcblx0XHRcdFx0XHRsZW5ndGggPSBnb3RvRW5kID8gYW5pbWF0aW9uLnR3ZWVucy5sZW5ndGggOiAwO1xuXHRcdFx0XHRpZiAoIHN0b3BwZWQgKSB7XG5cdFx0XHRcdFx0cmV0dXJuIHRoaXM7XG5cdFx0XHRcdH1cblx0XHRcdFx0c3RvcHBlZCA9IHRydWU7XG5cdFx0XHRcdGZvciAoIDsgaW5kZXggPCBsZW5ndGg7IGluZGV4KysgKSB7XG5cdFx0XHRcdFx0YW5pbWF0aW9uLnR3ZWVuc1sgaW5kZXggXS5ydW4oIDEgKTtcblx0XHRcdFx0fVxuXG5cdFx0XHRcdC8vIFJlc29sdmUgd2hlbiB3ZSBwbGF5ZWQgdGhlIGxhc3QgZnJhbWU7IG90aGVyd2lzZSwgcmVqZWN0XG5cdFx0XHRcdGlmICggZ290b0VuZCApIHtcblx0XHRcdFx0XHRkZWZlcnJlZC5ub3RpZnlXaXRoKCBlbGVtLCBbIGFuaW1hdGlvbiwgMSwgMCBdICk7XG5cdFx0XHRcdFx0ZGVmZXJyZWQucmVzb2x2ZVdpdGgoIGVsZW0sIFsgYW5pbWF0aW9uLCBnb3RvRW5kIF0gKTtcblx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHRkZWZlcnJlZC5yZWplY3RXaXRoKCBlbGVtLCBbIGFuaW1hdGlvbiwgZ290b0VuZCBdICk7XG5cdFx0XHRcdH1cblx0XHRcdFx0cmV0dXJuIHRoaXM7XG5cdFx0XHR9XG5cdFx0fSApLFxuXHRcdHByb3BzID0gYW5pbWF0aW9uLnByb3BzO1xuXG5cdHByb3BGaWx0ZXIoIHByb3BzLCBhbmltYXRpb24ub3B0cy5zcGVjaWFsRWFzaW5nICk7XG5cblx0Zm9yICggOyBpbmRleCA8IGxlbmd0aDsgaW5kZXgrKyApIHtcblx0XHRyZXN1bHQgPSBBbmltYXRpb24ucHJlZmlsdGVyc1sgaW5kZXggXS5jYWxsKCBhbmltYXRpb24sIGVsZW0sIHByb3BzLCBhbmltYXRpb24ub3B0cyApO1xuXHRcdGlmICggcmVzdWx0ICkge1xuXHRcdFx0aWYgKCB0eXBlb2YgcmVzdWx0LnN0b3AgPT09IFwiZnVuY3Rpb25cIiApIHtcblx0XHRcdFx0alF1ZXJ5Ll9xdWV1ZUhvb2tzKCBhbmltYXRpb24uZWxlbSwgYW5pbWF0aW9uLm9wdHMucXVldWUgKS5zdG9wID1cblx0XHRcdFx0XHRyZXN1bHQuc3RvcC5iaW5kKCByZXN1bHQgKTtcblx0XHRcdH1cblx0XHRcdHJldHVybiByZXN1bHQ7XG5cdFx0fVxuXHR9XG5cblx0alF1ZXJ5Lm1hcCggcHJvcHMsIGNyZWF0ZVR3ZWVuLCBhbmltYXRpb24gKTtcblxuXHRpZiAoIHR5cGVvZiBhbmltYXRpb24ub3B0cy5zdGFydCA9PT0gXCJmdW5jdGlvblwiICkge1xuXHRcdGFuaW1hdGlvbi5vcHRzLnN0YXJ0LmNhbGwoIGVsZW0sIGFuaW1hdGlvbiApO1xuXHR9XG5cblx0Ly8gQXR0YWNoIGNhbGxiYWNrcyBmcm9tIG9wdGlvbnNcblx0YW5pbWF0aW9uXG5cdFx0LnByb2dyZXNzKCBhbmltYXRpb24ub3B0cy5wcm9ncmVzcyApXG5cdFx0LmRvbmUoIGFuaW1hdGlvbi5vcHRzLmRvbmUsIGFuaW1hdGlvbi5vcHRzLmNvbXBsZXRlIClcblx0XHQuZmFpbCggYW5pbWF0aW9uLm9wdHMuZmFpbCApXG5cdFx0LmFsd2F5cyggYW5pbWF0aW9uLm9wdHMuYWx3YXlzICk7XG5cblx0alF1ZXJ5LmZ4LnRpbWVyKFxuXHRcdGpRdWVyeS5leHRlbmQoIHRpY2ssIHtcblx0XHRcdGVsZW06IGVsZW0sXG5cdFx0XHRhbmltOiBhbmltYXRpb24sXG5cdFx0XHRxdWV1ZTogYW5pbWF0aW9uLm9wdHMucXVldWVcblx0XHR9IClcblx0KTtcblxuXHRyZXR1cm4gYW5pbWF0aW9uO1xufVxuXG5qUXVlcnkuQW5pbWF0aW9uID0galF1ZXJ5LmV4dGVuZCggQW5pbWF0aW9uLCB7XG5cblx0dHdlZW5lcnM6IHtcblx0XHRcIipcIjogWyBmdW5jdGlvbiggcHJvcCwgdmFsdWUgKSB7XG5cdFx0XHR2YXIgdHdlZW4gPSB0aGlzLmNyZWF0ZVR3ZWVuKCBwcm9wLCB2YWx1ZSApO1xuXHRcdFx0YWRqdXN0Q1NTKCB0d2Vlbi5lbGVtLCBwcm9wLCByY3NzTnVtLmV4ZWMoIHZhbHVlICksIHR3ZWVuICk7XG5cdFx0XHRyZXR1cm4gdHdlZW47XG5cdFx0fSBdXG5cdH0sXG5cblx0dHdlZW5lcjogZnVuY3Rpb24oIHByb3BzLCBjYWxsYmFjayApIHtcblx0XHRpZiAoIHR5cGVvZiBwcm9wcyA9PT0gXCJmdW5jdGlvblwiICkge1xuXHRcdFx0Y2FsbGJhY2sgPSBwcm9wcztcblx0XHRcdHByb3BzID0gWyBcIipcIiBdO1xuXHRcdH0gZWxzZSB7XG5cdFx0XHRwcm9wcyA9IHByb3BzLm1hdGNoKCBybm90aHRtbHdoaXRlICk7XG5cdFx0fVxuXG5cdFx0dmFyIHByb3AsXG5cdFx0XHRpbmRleCA9IDAsXG5cdFx0XHRsZW5ndGggPSBwcm9wcy5sZW5ndGg7XG5cblx0XHRmb3IgKCA7IGluZGV4IDwgbGVuZ3RoOyBpbmRleCsrICkge1xuXHRcdFx0cHJvcCA9IHByb3BzWyBpbmRleCBdO1xuXHRcdFx0QW5pbWF0aW9uLnR3ZWVuZXJzWyBwcm9wIF0gPSBBbmltYXRpb24udHdlZW5lcnNbIHByb3AgXSB8fCBbXTtcblx0XHRcdEFuaW1hdGlvbi50d2VlbmVyc1sgcHJvcCBdLnVuc2hpZnQoIGNhbGxiYWNrICk7XG5cdFx0fVxuXHR9LFxuXG5cdHByZWZpbHRlcnM6IFsgZGVmYXVsdFByZWZpbHRlciBdLFxuXG5cdHByZWZpbHRlcjogZnVuY3Rpb24oIGNhbGxiYWNrLCBwcmVwZW5kICkge1xuXHRcdGlmICggcHJlcGVuZCApIHtcblx0XHRcdEFuaW1hdGlvbi5wcmVmaWx0ZXJzLnVuc2hpZnQoIGNhbGxiYWNrICk7XG5cdFx0fSBlbHNlIHtcblx0XHRcdEFuaW1hdGlvbi5wcmVmaWx0ZXJzLnB1c2goIGNhbGxiYWNrICk7XG5cdFx0fVxuXHR9XG59ICk7XG5cbmpRdWVyeS5zcGVlZCA9IGZ1bmN0aW9uKCBzcGVlZCwgZWFzaW5nLCBmbiApIHtcblx0dmFyIG9wdCA9IHNwZWVkICYmIHR5cGVvZiBzcGVlZCA9PT0gXCJvYmplY3RcIiA/IGpRdWVyeS5leHRlbmQoIHt9LCBzcGVlZCApIDoge1xuXHRcdGNvbXBsZXRlOiBmbiB8fCBlYXNpbmcgfHxcblx0XHRcdHR5cGVvZiBzcGVlZCA9PT0gXCJmdW5jdGlvblwiICYmIHNwZWVkLFxuXHRcdGR1cmF0aW9uOiBzcGVlZCxcblx0XHRlYXNpbmc6IGZuICYmIGVhc2luZyB8fCBlYXNpbmcgJiYgdHlwZW9mIGVhc2luZyAhPT0gXCJmdW5jdGlvblwiICYmIGVhc2luZ1xuXHR9O1xuXG5cdC8vIEdvIHRvIHRoZSBlbmQgc3RhdGUgaWYgZnggYXJlIG9mZlxuXHRpZiAoIGpRdWVyeS5meC5vZmYgKSB7XG5cdFx0b3B0LmR1cmF0aW9uID0gMDtcblxuXHR9IGVsc2Uge1xuXHRcdGlmICggdHlwZW9mIG9wdC5kdXJhdGlvbiAhPT0gXCJudW1iZXJcIiApIHtcblx0XHRcdGlmICggb3B0LmR1cmF0aW9uIGluIGpRdWVyeS5meC5zcGVlZHMgKSB7XG5cdFx0XHRcdG9wdC5kdXJhdGlvbiA9IGpRdWVyeS5meC5zcGVlZHNbIG9wdC5kdXJhdGlvbiBdO1xuXG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRvcHQuZHVyYXRpb24gPSBqUXVlcnkuZnguc3BlZWRzLl9kZWZhdWx0O1xuXHRcdFx0fVxuXHRcdH1cblx0fVxuXG5cdC8vIE5vcm1hbGl6ZSBvcHQucXVldWUgLSB0cnVlL3VuZGVmaW5lZC9udWxsIC0+IFwiZnhcIlxuXHRpZiAoIG9wdC5xdWV1ZSA9PSBudWxsIHx8IG9wdC5xdWV1ZSA9PT0gdHJ1ZSApIHtcblx0XHRvcHQucXVldWUgPSBcImZ4XCI7XG5cdH1cblxuXHQvLyBRdWV1ZWluZ1xuXHRvcHQub2xkID0gb3B0LmNvbXBsZXRlO1xuXG5cdG9wdC5jb21wbGV0ZSA9IGZ1bmN0aW9uKCkge1xuXHRcdGlmICggdHlwZW9mIG9wdC5vbGQgPT09IFwiZnVuY3Rpb25cIiApIHtcblx0XHRcdG9wdC5vbGQuY2FsbCggdGhpcyApO1xuXHRcdH1cblxuXHRcdGlmICggb3B0LnF1ZXVlICkge1xuXHRcdFx0alF1ZXJ5LmRlcXVldWUoIHRoaXMsIG9wdC5xdWV1ZSApO1xuXHRcdH1cblx0fTtcblxuXHRyZXR1cm4gb3B0O1xufTtcblxualF1ZXJ5LmZuLmV4dGVuZCgge1xuXHRmYWRlVG86IGZ1bmN0aW9uKCBzcGVlZCwgdG8sIGVhc2luZywgY2FsbGJhY2sgKSB7XG5cblx0XHQvLyBTaG93IGFueSBoaWRkZW4gZWxlbWVudHMgYWZ0ZXIgc2V0dGluZyBvcGFjaXR5IHRvIDBcblx0XHRyZXR1cm4gdGhpcy5maWx0ZXIoIGlzSGlkZGVuV2l0aGluVHJlZSApLmNzcyggXCJvcGFjaXR5XCIsIDAgKS5zaG93KClcblxuXHRcdFx0Ly8gQW5pbWF0ZSB0byB0aGUgdmFsdWUgc3BlY2lmaWVkXG5cdFx0XHQuZW5kKCkuYW5pbWF0ZSggeyBvcGFjaXR5OiB0byB9LCBzcGVlZCwgZWFzaW5nLCBjYWxsYmFjayApO1xuXHR9LFxuXHRhbmltYXRlOiBmdW5jdGlvbiggcHJvcCwgc3BlZWQsIGVhc2luZywgY2FsbGJhY2sgKSB7XG5cdFx0dmFyIGVtcHR5ID0galF1ZXJ5LmlzRW1wdHlPYmplY3QoIHByb3AgKSxcblx0XHRcdG9wdGFsbCA9IGpRdWVyeS5zcGVlZCggc3BlZWQsIGVhc2luZywgY2FsbGJhY2sgKSxcblx0XHRcdGRvQW5pbWF0aW9uID0gZnVuY3Rpb24oKSB7XG5cblx0XHRcdFx0Ly8gT3BlcmF0ZSBvbiBhIGNvcHkgb2YgcHJvcCBzbyBwZXItcHJvcGVydHkgZWFzaW5nIHdvbid0IGJlIGxvc3Rcblx0XHRcdFx0dmFyIGFuaW0gPSBBbmltYXRpb24oIHRoaXMsIGpRdWVyeS5leHRlbmQoIHt9LCBwcm9wICksIG9wdGFsbCApO1xuXG5cdFx0XHRcdC8vIEVtcHR5IGFuaW1hdGlvbnMsIG9yIGZpbmlzaGluZyByZXNvbHZlcyBpbW1lZGlhdGVseVxuXHRcdFx0XHRpZiAoIGVtcHR5IHx8IGRhdGFQcml2LmdldCggdGhpcywgXCJmaW5pc2hcIiApICkge1xuXHRcdFx0XHRcdGFuaW0uc3RvcCggdHJ1ZSApO1xuXHRcdFx0XHR9XG5cdFx0XHR9O1xuXG5cdFx0ZG9BbmltYXRpb24uZmluaXNoID0gZG9BbmltYXRpb247XG5cblx0XHRyZXR1cm4gZW1wdHkgfHwgb3B0YWxsLnF1ZXVlID09PSBmYWxzZSA/XG5cdFx0XHR0aGlzLmVhY2goIGRvQW5pbWF0aW9uICkgOlxuXHRcdFx0dGhpcy5xdWV1ZSggb3B0YWxsLnF1ZXVlLCBkb0FuaW1hdGlvbiApO1xuXHR9LFxuXHRzdG9wOiBmdW5jdGlvbiggdHlwZSwgY2xlYXJRdWV1ZSwgZ290b0VuZCApIHtcblx0XHR2YXIgc3RvcFF1ZXVlID0gZnVuY3Rpb24oIGhvb2tzICkge1xuXHRcdFx0dmFyIHN0b3AgPSBob29rcy5zdG9wO1xuXHRcdFx0ZGVsZXRlIGhvb2tzLnN0b3A7XG5cdFx0XHRzdG9wKCBnb3RvRW5kICk7XG5cdFx0fTtcblxuXHRcdGlmICggdHlwZW9mIHR5cGUgIT09IFwic3RyaW5nXCIgKSB7XG5cdFx0XHRnb3RvRW5kID0gY2xlYXJRdWV1ZTtcblx0XHRcdGNsZWFyUXVldWUgPSB0eXBlO1xuXHRcdFx0dHlwZSA9IHVuZGVmaW5lZDtcblx0XHR9XG5cdFx0aWYgKCBjbGVhclF1ZXVlICkge1xuXHRcdFx0dGhpcy5xdWV1ZSggdHlwZSB8fCBcImZ4XCIsIFtdICk7XG5cdFx0fVxuXG5cdFx0cmV0dXJuIHRoaXMuZWFjaCggZnVuY3Rpb24oKSB7XG5cdFx0XHR2YXIgZGVxdWV1ZSA9IHRydWUsXG5cdFx0XHRcdGluZGV4ID0gdHlwZSAhPSBudWxsICYmIHR5cGUgKyBcInF1ZXVlSG9va3NcIixcblx0XHRcdFx0dGltZXJzID0galF1ZXJ5LnRpbWVycyxcblx0XHRcdFx0ZGF0YSA9IGRhdGFQcml2LmdldCggdGhpcyApO1xuXG5cdFx0XHRpZiAoIGluZGV4ICkge1xuXHRcdFx0XHRpZiAoIGRhdGFbIGluZGV4IF0gJiYgZGF0YVsgaW5kZXggXS5zdG9wICkge1xuXHRcdFx0XHRcdHN0b3BRdWV1ZSggZGF0YVsgaW5kZXggXSApO1xuXHRcdFx0XHR9XG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRmb3IgKCBpbmRleCBpbiBkYXRhICkge1xuXHRcdFx0XHRcdGlmICggZGF0YVsgaW5kZXggXSAmJiBkYXRhWyBpbmRleCBdLnN0b3AgJiYgcnJ1bi50ZXN0KCBpbmRleCApICkge1xuXHRcdFx0XHRcdFx0c3RvcFF1ZXVlKCBkYXRhWyBpbmRleCBdICk7XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHR9XG5cdFx0XHR9XG5cblx0XHRcdGZvciAoIGluZGV4ID0gdGltZXJzLmxlbmd0aDsgaW5kZXgtLTsgKSB7XG5cdFx0XHRcdGlmICggdGltZXJzWyBpbmRleCBdLmVsZW0gPT09IHRoaXMgJiZcblx0XHRcdFx0XHQoIHR5cGUgPT0gbnVsbCB8fCB0aW1lcnNbIGluZGV4IF0ucXVldWUgPT09IHR5cGUgKSApIHtcblxuXHRcdFx0XHRcdHRpbWVyc1sgaW5kZXggXS5hbmltLnN0b3AoIGdvdG9FbmQgKTtcblx0XHRcdFx0XHRkZXF1ZXVlID0gZmFsc2U7XG5cdFx0XHRcdFx0dGltZXJzLnNwbGljZSggaW5kZXgsIDEgKTtcblx0XHRcdFx0fVxuXHRcdFx0fVxuXG5cdFx0XHQvLyBTdGFydCB0aGUgbmV4dCBpbiB0aGUgcXVldWUgaWYgdGhlIGxhc3Qgc3RlcCB3YXNuJ3QgZm9yY2VkLlxuXHRcdFx0Ly8gVGltZXJzIGN1cnJlbnRseSB3aWxsIGNhbGwgdGhlaXIgY29tcGxldGUgY2FsbGJhY2tzLCB3aGljaFxuXHRcdFx0Ly8gd2lsbCBkZXF1ZXVlIGJ1dCBvbmx5IGlmIHRoZXkgd2VyZSBnb3RvRW5kLlxuXHRcdFx0aWYgKCBkZXF1ZXVlIHx8ICFnb3RvRW5kICkge1xuXHRcdFx0XHRqUXVlcnkuZGVxdWV1ZSggdGhpcywgdHlwZSApO1xuXHRcdFx0fVxuXHRcdH0gKTtcblx0fSxcblx0ZmluaXNoOiBmdW5jdGlvbiggdHlwZSApIHtcblx0XHRpZiAoIHR5cGUgIT09IGZhbHNlICkge1xuXHRcdFx0dHlwZSA9IHR5cGUgfHwgXCJmeFwiO1xuXHRcdH1cblx0XHRyZXR1cm4gdGhpcy5lYWNoKCBmdW5jdGlvbigpIHtcblx0XHRcdHZhciBpbmRleCxcblx0XHRcdFx0ZGF0YSA9IGRhdGFQcml2LmdldCggdGhpcyApLFxuXHRcdFx0XHRxdWV1ZSA9IGRhdGFbIHR5cGUgKyBcInF1ZXVlXCIgXSxcblx0XHRcdFx0aG9va3MgPSBkYXRhWyB0eXBlICsgXCJxdWV1ZUhvb2tzXCIgXSxcblx0XHRcdFx0dGltZXJzID0galF1ZXJ5LnRpbWVycyxcblx0XHRcdFx0bGVuZ3RoID0gcXVldWUgPyBxdWV1ZS5sZW5ndGggOiAwO1xuXG5cdFx0XHQvLyBFbmFibGUgZmluaXNoaW5nIGZsYWcgb24gcHJpdmF0ZSBkYXRhXG5cdFx0XHRkYXRhLmZpbmlzaCA9IHRydWU7XG5cblx0XHRcdC8vIEVtcHR5IHRoZSBxdWV1ZSBmaXJzdFxuXHRcdFx0alF1ZXJ5LnF1ZXVlKCB0aGlzLCB0eXBlLCBbXSApO1xuXG5cdFx0XHRpZiAoIGhvb2tzICYmIGhvb2tzLnN0b3AgKSB7XG5cdFx0XHRcdGhvb2tzLnN0b3AuY2FsbCggdGhpcywgdHJ1ZSApO1xuXHRcdFx0fVxuXG5cdFx0XHQvLyBMb29rIGZvciBhbnkgYWN0aXZlIGFuaW1hdGlvbnMsIGFuZCBmaW5pc2ggdGhlbVxuXHRcdFx0Zm9yICggaW5kZXggPSB0aW1lcnMubGVuZ3RoOyBpbmRleC0tOyApIHtcblx0XHRcdFx0aWYgKCB0aW1lcnNbIGluZGV4IF0uZWxlbSA9PT0gdGhpcyAmJiB0aW1lcnNbIGluZGV4IF0ucXVldWUgPT09IHR5cGUgKSB7XG5cdFx0XHRcdFx0dGltZXJzWyBpbmRleCBdLmFuaW0uc3RvcCggdHJ1ZSApO1xuXHRcdFx0XHRcdHRpbWVycy5zcGxpY2UoIGluZGV4LCAxICk7XG5cdFx0XHRcdH1cblx0XHRcdH1cblxuXHRcdFx0Ly8gTG9vayBmb3IgYW55IGFuaW1hdGlvbnMgaW4gdGhlIG9sZCBxdWV1ZSBhbmQgZmluaXNoIHRoZW1cblx0XHRcdGZvciAoIGluZGV4ID0gMDsgaW5kZXggPCBsZW5ndGg7IGluZGV4KysgKSB7XG5cdFx0XHRcdGlmICggcXVldWVbIGluZGV4IF0gJiYgcXVldWVbIGluZGV4IF0uZmluaXNoICkge1xuXHRcdFx0XHRcdHF1ZXVlWyBpbmRleCBdLmZpbmlzaC5jYWxsKCB0aGlzICk7XG5cdFx0XHRcdH1cblx0XHRcdH1cblxuXHRcdFx0Ly8gVHVybiBvZmYgZmluaXNoaW5nIGZsYWdcblx0XHRcdGRlbGV0ZSBkYXRhLmZpbmlzaDtcblx0XHR9ICk7XG5cdH1cbn0gKTtcblxualF1ZXJ5LmVhY2goIFsgXCJ0b2dnbGVcIiwgXCJzaG93XCIsIFwiaGlkZVwiIF0sIGZ1bmN0aW9uKCBfaSwgbmFtZSApIHtcblx0dmFyIGNzc0ZuID0galF1ZXJ5LmZuWyBuYW1lIF07XG5cdGpRdWVyeS5mblsgbmFtZSBdID0gZnVuY3Rpb24oIHNwZWVkLCBlYXNpbmcsIGNhbGxiYWNrICkge1xuXHRcdHJldHVybiBzcGVlZCA9PSBudWxsIHx8IHR5cGVvZiBzcGVlZCA9PT0gXCJib29sZWFuXCIgP1xuXHRcdFx0Y3NzRm4uYXBwbHkoIHRoaXMsIGFyZ3VtZW50cyApIDpcblx0XHRcdHRoaXMuYW5pbWF0ZSggZ2VuRngoIG5hbWUsIHRydWUgKSwgc3BlZWQsIGVhc2luZywgY2FsbGJhY2sgKTtcblx0fTtcbn0gKTtcblxuLy8gR2VuZXJhdGUgc2hvcnRjdXRzIGZvciBjdXN0b20gYW5pbWF0aW9uc1xualF1ZXJ5LmVhY2goIHtcblx0c2xpZGVEb3duOiBnZW5GeCggXCJzaG93XCIgKSxcblx0c2xpZGVVcDogZ2VuRngoIFwiaGlkZVwiICksXG5cdHNsaWRlVG9nZ2xlOiBnZW5GeCggXCJ0b2dnbGVcIiApLFxuXHRmYWRlSW46IHsgb3BhY2l0eTogXCJzaG93XCIgfSxcblx0ZmFkZU91dDogeyBvcGFjaXR5OiBcImhpZGVcIiB9LFxuXHRmYWRlVG9nZ2xlOiB7IG9wYWNpdHk6IFwidG9nZ2xlXCIgfVxufSwgZnVuY3Rpb24oIG5hbWUsIHByb3BzICkge1xuXHRqUXVlcnkuZm5bIG5hbWUgXSA9IGZ1bmN0aW9uKCBzcGVlZCwgZWFzaW5nLCBjYWxsYmFjayApIHtcblx0XHRyZXR1cm4gdGhpcy5hbmltYXRlKCBwcm9wcywgc3BlZWQsIGVhc2luZywgY2FsbGJhY2sgKTtcblx0fTtcbn0gKTtcblxualF1ZXJ5LnRpbWVycyA9IFtdO1xualF1ZXJ5LmZ4LnRpY2sgPSBmdW5jdGlvbigpIHtcblx0dmFyIHRpbWVyLFxuXHRcdGkgPSAwLFxuXHRcdHRpbWVycyA9IGpRdWVyeS50aW1lcnM7XG5cblx0ZnhOb3cgPSBEYXRlLm5vdygpO1xuXG5cdGZvciAoIDsgaSA8IHRpbWVycy5sZW5ndGg7IGkrKyApIHtcblx0XHR0aW1lciA9IHRpbWVyc1sgaSBdO1xuXG5cdFx0Ly8gUnVuIHRoZSB0aW1lciBhbmQgc2FmZWx5IHJlbW92ZSBpdCB3aGVuIGRvbmUgKGFsbG93aW5nIGZvciBleHRlcm5hbCByZW1vdmFsKVxuXHRcdGlmICggIXRpbWVyKCkgJiYgdGltZXJzWyBpIF0gPT09IHRpbWVyICkge1xuXHRcdFx0dGltZXJzLnNwbGljZSggaS0tLCAxICk7XG5cdFx0fVxuXHR9XG5cblx0aWYgKCAhdGltZXJzLmxlbmd0aCApIHtcblx0XHRqUXVlcnkuZnguc3RvcCgpO1xuXHR9XG5cdGZ4Tm93ID0gdW5kZWZpbmVkO1xufTtcblxualF1ZXJ5LmZ4LnRpbWVyID0gZnVuY3Rpb24oIHRpbWVyICkge1xuXHRqUXVlcnkudGltZXJzLnB1c2goIHRpbWVyICk7XG5cdGpRdWVyeS5meC5zdGFydCgpO1xufTtcblxualF1ZXJ5LmZ4LnN0YXJ0ID0gZnVuY3Rpb24oKSB7XG5cdGlmICggaW5Qcm9ncmVzcyApIHtcblx0XHRyZXR1cm47XG5cdH1cblxuXHRpblByb2dyZXNzID0gdHJ1ZTtcblx0c2NoZWR1bGUoKTtcbn07XG5cbmpRdWVyeS5meC5zdG9wID0gZnVuY3Rpb24oKSB7XG5cdGluUHJvZ3Jlc3MgPSBudWxsO1xufTtcblxualF1ZXJ5LmZ4LnNwZWVkcyA9IHtcblx0c2xvdzogNjAwLFxuXHRmYXN0OiAyMDAsXG5cblx0Ly8gRGVmYXVsdCBzcGVlZFxuXHRfZGVmYXVsdDogNDAwXG59O1xuXG4vLyBCYXNlZCBvZmYgb2YgdGhlIHBsdWdpbiBieSBDbGludCBIZWxmZXJzLCB3aXRoIHBlcm1pc3Npb24uXG5qUXVlcnkuZm4uZGVsYXkgPSBmdW5jdGlvbiggdGltZSwgdHlwZSApIHtcblx0dGltZSA9IGpRdWVyeS5meCA/IGpRdWVyeS5meC5zcGVlZHNbIHRpbWUgXSB8fCB0aW1lIDogdGltZTtcblx0dHlwZSA9IHR5cGUgfHwgXCJmeFwiO1xuXG5cdHJldHVybiB0aGlzLnF1ZXVlKCB0eXBlLCBmdW5jdGlvbiggbmV4dCwgaG9va3MgKSB7XG5cdFx0dmFyIHRpbWVvdXQgPSB3aW5kb3cuc2V0VGltZW91dCggbmV4dCwgdGltZSApO1xuXHRcdGhvb2tzLnN0b3AgPSBmdW5jdGlvbigpIHtcblx0XHRcdHdpbmRvdy5jbGVhclRpbWVvdXQoIHRpbWVvdXQgKTtcblx0XHR9O1xuXHR9ICk7XG59O1xuXG52YXIgcmZvY3VzYWJsZSA9IC9eKD86aW5wdXR8c2VsZWN0fHRleHRhcmVhfGJ1dHRvbikkL2ksXG5cdHJjbGlja2FibGUgPSAvXig/OmF8YXJlYSkkL2k7XG5cbmpRdWVyeS5mbi5leHRlbmQoIHtcblx0cHJvcDogZnVuY3Rpb24oIG5hbWUsIHZhbHVlICkge1xuXHRcdHJldHVybiBhY2Nlc3MoIHRoaXMsIGpRdWVyeS5wcm9wLCBuYW1lLCB2YWx1ZSwgYXJndW1lbnRzLmxlbmd0aCA+IDEgKTtcblx0fSxcblxuXHRyZW1vdmVQcm9wOiBmdW5jdGlvbiggbmFtZSApIHtcblx0XHRyZXR1cm4gdGhpcy5lYWNoKCBmdW5jdGlvbigpIHtcblx0XHRcdGRlbGV0ZSB0aGlzWyBqUXVlcnkucHJvcEZpeFsgbmFtZSBdIHx8IG5hbWUgXTtcblx0XHR9ICk7XG5cdH1cbn0gKTtcblxualF1ZXJ5LmV4dGVuZCgge1xuXHRwcm9wOiBmdW5jdGlvbiggZWxlbSwgbmFtZSwgdmFsdWUgKSB7XG5cdFx0dmFyIHJldCwgaG9va3MsXG5cdFx0XHRuVHlwZSA9IGVsZW0ubm9kZVR5cGU7XG5cblx0XHQvLyBEb24ndCBnZXQvc2V0IHByb3BlcnRpZXMgb24gdGV4dCwgY29tbWVudCBhbmQgYXR0cmlidXRlIG5vZGVzXG5cdFx0aWYgKCBuVHlwZSA9PT0gMyB8fCBuVHlwZSA9PT0gOCB8fCBuVHlwZSA9PT0gMiApIHtcblx0XHRcdHJldHVybjtcblx0XHR9XG5cblx0XHRpZiAoIG5UeXBlICE9PSAxIHx8ICFqUXVlcnkuaXNYTUxEb2MoIGVsZW0gKSApIHtcblxuXHRcdFx0Ly8gRml4IG5hbWUgYW5kIGF0dGFjaCBob29rc1xuXHRcdFx0bmFtZSA9IGpRdWVyeS5wcm9wRml4WyBuYW1lIF0gfHwgbmFtZTtcblx0XHRcdGhvb2tzID0galF1ZXJ5LnByb3BIb29rc1sgbmFtZSBdO1xuXHRcdH1cblxuXHRcdGlmICggdmFsdWUgIT09IHVuZGVmaW5lZCApIHtcblx0XHRcdGlmICggaG9va3MgJiYgXCJzZXRcIiBpbiBob29rcyAmJlxuXHRcdFx0XHQoIHJldCA9IGhvb2tzLnNldCggZWxlbSwgdmFsdWUsIG5hbWUgKSApICE9PSB1bmRlZmluZWQgKSB7XG5cdFx0XHRcdHJldHVybiByZXQ7XG5cdFx0XHR9XG5cblx0XHRcdHJldHVybiAoIGVsZW1bIG5hbWUgXSA9IHZhbHVlICk7XG5cdFx0fVxuXG5cdFx0aWYgKCBob29rcyAmJiBcImdldFwiIGluIGhvb2tzICYmICggcmV0ID0gaG9va3MuZ2V0KCBlbGVtLCBuYW1lICkgKSAhPT0gbnVsbCApIHtcblx0XHRcdHJldHVybiByZXQ7XG5cdFx0fVxuXG5cdFx0cmV0dXJuIGVsZW1bIG5hbWUgXTtcblx0fSxcblxuXHRwcm9wSG9va3M6IHtcblx0XHR0YWJJbmRleDoge1xuXHRcdFx0Z2V0OiBmdW5jdGlvbiggZWxlbSApIHtcblxuXHRcdFx0XHQvLyBTdXBwb3J0OiBJRSA8PTkgLSAxMStcblx0XHRcdFx0Ly8gZWxlbS50YWJJbmRleCBkb2Vzbid0IGFsd2F5cyByZXR1cm4gdGhlXG5cdFx0XHRcdC8vIGNvcnJlY3QgdmFsdWUgd2hlbiBpdCBoYXNuJ3QgYmVlbiBleHBsaWNpdGx5IHNldFxuXHRcdFx0XHQvLyBVc2UgcHJvcGVyIGF0dHJpYnV0ZSByZXRyaWV2YWwgKHRyYWMtMTIwNzIpXG5cdFx0XHRcdHZhciB0YWJpbmRleCA9IGVsZW0uZ2V0QXR0cmlidXRlKCBcInRhYmluZGV4XCIgKTtcblxuXHRcdFx0XHRpZiAoIHRhYmluZGV4ICkge1xuXHRcdFx0XHRcdHJldHVybiBwYXJzZUludCggdGFiaW5kZXgsIDEwICk7XG5cdFx0XHRcdH1cblxuXHRcdFx0XHRpZiAoXG5cdFx0XHRcdFx0cmZvY3VzYWJsZS50ZXN0KCBlbGVtLm5vZGVOYW1lICkgfHxcblxuXHRcdFx0XHRcdC8vIGhyZWYtbGVzcyBhbmNob3IncyBgdGFiSW5kZXhgIHByb3BlcnR5IHZhbHVlIGlzIGAwYCBhbmRcblx0XHRcdFx0XHQvLyB0aGUgYHRhYmluZGV4YCBhdHRyaWJ1dGUgdmFsdWU6IGBudWxsYC4gV2Ugd2FudCBgLTFgLlxuXHRcdFx0XHRcdHJjbGlja2FibGUudGVzdCggZWxlbS5ub2RlTmFtZSApICYmIGVsZW0uaHJlZlxuXHRcdFx0XHQpIHtcblx0XHRcdFx0XHRyZXR1cm4gMDtcblx0XHRcdFx0fVxuXG5cdFx0XHRcdHJldHVybiAtMTtcblx0XHRcdH1cblx0XHR9XG5cdH0sXG5cblx0cHJvcEZpeDoge1xuXHRcdFwiZm9yXCI6IFwiaHRtbEZvclwiLFxuXHRcdFwiY2xhc3NcIjogXCJjbGFzc05hbWVcIlxuXHR9XG59ICk7XG5cbi8vIFN1cHBvcnQ6IElFIDw9MTErXG4vLyBBY2Nlc3NpbmcgdGhlIHNlbGVjdGVkSW5kZXggcHJvcGVydHkgZm9yY2VzIHRoZSBicm93c2VyIHRvIHJlc3BlY3Rcbi8vIHNldHRpbmcgc2VsZWN0ZWQgb24gdGhlIG9wdGlvbi4gVGhlIGdldHRlciBlbnN1cmVzIGEgZGVmYXVsdCBvcHRpb25cbi8vIGlzIHNlbGVjdGVkIHdoZW4gaW4gYW4gb3B0Z3JvdXAuIEVTTGludCBydWxlIFwibm8tdW51c2VkLWV4cHJlc3Npb25zXCJcbi8vIGlzIGRpc2FibGVkIGZvciB0aGlzIGNvZGUgc2luY2UgaXQgY29uc2lkZXJzIHN1Y2ggYWNjZXNzaW9ucyBub29wLlxuaWYgKCBpc0lFICkge1xuXHRqUXVlcnkucHJvcEhvb2tzLnNlbGVjdGVkID0ge1xuXHRcdGdldDogZnVuY3Rpb24oIGVsZW0gKSB7XG5cblx0XHRcdHZhciBwYXJlbnQgPSBlbGVtLnBhcmVudE5vZGU7XG5cdFx0XHRpZiAoIHBhcmVudCAmJiBwYXJlbnQucGFyZW50Tm9kZSApIHtcblx0XHRcdFx0Ly8gZXNsaW50LWRpc2FibGUtbmV4dC1saW5lIG5vLXVudXNlZC1leHByZXNzaW9uc1xuXHRcdFx0XHRwYXJlbnQucGFyZW50Tm9kZS5zZWxlY3RlZEluZGV4O1xuXHRcdFx0fVxuXHRcdFx0cmV0dXJuIG51bGw7XG5cdFx0fSxcblx0XHRzZXQ6IGZ1bmN0aW9uKCBlbGVtICkge1xuXG5cblx0XHRcdHZhciBwYXJlbnQgPSBlbGVtLnBhcmVudE5vZGU7XG5cdFx0XHRpZiAoIHBhcmVudCApIHtcblx0XHRcdFx0Ly8gZXNsaW50LWRpc2FibGUtbmV4dC1saW5lIG5vLXVudXNlZC1leHByZXNzaW9uc1xuXHRcdFx0XHRwYXJlbnQuc2VsZWN0ZWRJbmRleDtcblxuXHRcdFx0XHRpZiAoIHBhcmVudC5wYXJlbnROb2RlICkge1xuXHRcdFx0XHRcdC8vIGVzbGludC1kaXNhYmxlLW5leHQtbGluZSBuby11bnVzZWQtZXhwcmVzc2lvbnNcblx0XHRcdFx0XHRwYXJlbnQucGFyZW50Tm9kZS5zZWxlY3RlZEluZGV4O1xuXHRcdFx0XHR9XG5cdFx0XHR9XG5cdFx0fVxuXHR9O1xufVxuXG5qUXVlcnkuZWFjaCggW1xuXHRcInRhYkluZGV4XCIsXG5cdFwicmVhZE9ubHlcIixcblx0XCJtYXhMZW5ndGhcIixcblx0XCJjZWxsU3BhY2luZ1wiLFxuXHRcImNlbGxQYWRkaW5nXCIsXG5cdFwicm93U3BhblwiLFxuXHRcImNvbFNwYW5cIixcblx0XCJ1c2VNYXBcIixcblx0XCJmcmFtZUJvcmRlclwiLFxuXHRcImNvbnRlbnRFZGl0YWJsZVwiXG5dLCBmdW5jdGlvbigpIHtcblx0alF1ZXJ5LnByb3BGaXhbIHRoaXMudG9Mb3dlckNhc2UoKSBdID0gdGhpcztcbn0gKTtcblxuLy8gU3RyaXAgYW5kIGNvbGxhcHNlIHdoaXRlc3BhY2UgYWNjb3JkaW5nIHRvIEhUTUwgc3BlY1xuLy8gaHR0cHM6Ly9pbmZyYS5zcGVjLndoYXR3Zy5vcmcvI3N0cmlwLWFuZC1jb2xsYXBzZS1hc2NpaS13aGl0ZXNwYWNlXG5mdW5jdGlvbiBzdHJpcEFuZENvbGxhcHNlKCB2YWx1ZSApIHtcblx0dmFyIHRva2VucyA9IHZhbHVlLm1hdGNoKCBybm90aHRtbHdoaXRlICkgfHwgW107XG5cdHJldHVybiB0b2tlbnMuam9pbiggXCIgXCIgKTtcbn1cblxuZnVuY3Rpb24gZ2V0Q2xhc3MoIGVsZW0gKSB7XG5cdHJldHVybiBlbGVtLmdldEF0dHJpYnV0ZSAmJiBlbGVtLmdldEF0dHJpYnV0ZSggXCJjbGFzc1wiICkgfHwgXCJcIjtcbn1cblxuZnVuY3Rpb24gY2xhc3Nlc1RvQXJyYXkoIHZhbHVlICkge1xuXHRpZiAoIEFycmF5LmlzQXJyYXkoIHZhbHVlICkgKSB7XG5cdFx0cmV0dXJuIHZhbHVlO1xuXHR9XG5cdGlmICggdHlwZW9mIHZhbHVlID09PSBcInN0cmluZ1wiICkge1xuXHRcdHJldHVybiB2YWx1ZS5tYXRjaCggcm5vdGh0bWx3aGl0ZSApIHx8IFtdO1xuXHR9XG5cdHJldHVybiBbXTtcbn1cblxualF1ZXJ5LmZuLmV4dGVuZCgge1xuXHRhZGRDbGFzczogZnVuY3Rpb24oIHZhbHVlICkge1xuXHRcdHZhciBjbGFzc05hbWVzLCBjdXIsIGN1clZhbHVlLCBjbGFzc05hbWUsIGksIGZpbmFsVmFsdWU7XG5cblx0XHRpZiAoIHR5cGVvZiB2YWx1ZSA9PT0gXCJmdW5jdGlvblwiICkge1xuXHRcdFx0cmV0dXJuIHRoaXMuZWFjaCggZnVuY3Rpb24oIGogKSB7XG5cdFx0XHRcdGpRdWVyeSggdGhpcyApLmFkZENsYXNzKCB2YWx1ZS5jYWxsKCB0aGlzLCBqLCBnZXRDbGFzcyggdGhpcyApICkgKTtcblx0XHRcdH0gKTtcblx0XHR9XG5cblx0XHRjbGFzc05hbWVzID0gY2xhc3Nlc1RvQXJyYXkoIHZhbHVlICk7XG5cblx0XHRpZiAoIGNsYXNzTmFtZXMubGVuZ3RoICkge1xuXHRcdFx0cmV0dXJuIHRoaXMuZWFjaCggZnVuY3Rpb24oKSB7XG5cdFx0XHRcdGN1clZhbHVlID0gZ2V0Q2xhc3MoIHRoaXMgKTtcblx0XHRcdFx0Y3VyID0gdGhpcy5ub2RlVHlwZSA9PT0gMSAmJiAoIFwiIFwiICsgc3RyaXBBbmRDb2xsYXBzZSggY3VyVmFsdWUgKSArIFwiIFwiICk7XG5cblx0XHRcdFx0aWYgKCBjdXIgKSB7XG5cdFx0XHRcdFx0Zm9yICggaSA9IDA7IGkgPCBjbGFzc05hbWVzLmxlbmd0aDsgaSsrICkge1xuXHRcdFx0XHRcdFx0Y2xhc3NOYW1lID0gY2xhc3NOYW1lc1sgaSBdO1xuXHRcdFx0XHRcdFx0aWYgKCBjdXIuaW5kZXhPZiggXCIgXCIgKyBjbGFzc05hbWUgKyBcIiBcIiApIDwgMCApIHtcblx0XHRcdFx0XHRcdFx0Y3VyICs9IGNsYXNzTmFtZSArIFwiIFwiO1xuXHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdH1cblxuXHRcdFx0XHRcdC8vIE9ubHkgYXNzaWduIGlmIGRpZmZlcmVudCB0byBhdm9pZCB1bm5lZWRlZCByZW5kZXJpbmcuXG5cdFx0XHRcdFx0ZmluYWxWYWx1ZSA9IHN0cmlwQW5kQ29sbGFwc2UoIGN1ciApO1xuXHRcdFx0XHRcdGlmICggY3VyVmFsdWUgIT09IGZpbmFsVmFsdWUgKSB7XG5cdFx0XHRcdFx0XHR0aGlzLnNldEF0dHJpYnV0ZSggXCJjbGFzc1wiLCBmaW5hbFZhbHVlICk7XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHR9XG5cdFx0XHR9ICk7XG5cdFx0fVxuXG5cdFx0cmV0dXJuIHRoaXM7XG5cdH0sXG5cblx0cmVtb3ZlQ2xhc3M6IGZ1bmN0aW9uKCB2YWx1ZSApIHtcblx0XHR2YXIgY2xhc3NOYW1lcywgY3VyLCBjdXJWYWx1ZSwgY2xhc3NOYW1lLCBpLCBmaW5hbFZhbHVlO1xuXG5cdFx0aWYgKCB0eXBlb2YgdmFsdWUgPT09IFwiZnVuY3Rpb25cIiApIHtcblx0XHRcdHJldHVybiB0aGlzLmVhY2goIGZ1bmN0aW9uKCBqICkge1xuXHRcdFx0XHRqUXVlcnkoIHRoaXMgKS5yZW1vdmVDbGFzcyggdmFsdWUuY2FsbCggdGhpcywgaiwgZ2V0Q2xhc3MoIHRoaXMgKSApICk7XG5cdFx0XHR9ICk7XG5cdFx0fVxuXG5cdFx0aWYgKCAhYXJndW1lbnRzLmxlbmd0aCApIHtcblx0XHRcdHJldHVybiB0aGlzLmF0dHIoIFwiY2xhc3NcIiwgXCJcIiApO1xuXHRcdH1cblxuXHRcdGNsYXNzTmFtZXMgPSBjbGFzc2VzVG9BcnJheSggdmFsdWUgKTtcblxuXHRcdGlmICggY2xhc3NOYW1lcy5sZW5ndGggKSB7XG5cdFx0XHRyZXR1cm4gdGhpcy5lYWNoKCBmdW5jdGlvbigpIHtcblx0XHRcdFx0Y3VyVmFsdWUgPSBnZXRDbGFzcyggdGhpcyApO1xuXG5cdFx0XHRcdC8vIFRoaXMgZXhwcmVzc2lvbiBpcyBoZXJlIGZvciBiZXR0ZXIgY29tcHJlc3NpYmlsaXR5IChzZWUgYWRkQ2xhc3MpXG5cdFx0XHRcdGN1ciA9IHRoaXMubm9kZVR5cGUgPT09IDEgJiYgKCBcIiBcIiArIHN0cmlwQW5kQ29sbGFwc2UoIGN1clZhbHVlICkgKyBcIiBcIiApO1xuXG5cdFx0XHRcdGlmICggY3VyICkge1xuXHRcdFx0XHRcdGZvciAoIGkgPSAwOyBpIDwgY2xhc3NOYW1lcy5sZW5ndGg7IGkrKyApIHtcblx0XHRcdFx0XHRcdGNsYXNzTmFtZSA9IGNsYXNzTmFtZXNbIGkgXTtcblxuXHRcdFx0XHRcdFx0Ly8gUmVtb3ZlICphbGwqIGluc3RhbmNlc1xuXHRcdFx0XHRcdFx0d2hpbGUgKCBjdXIuaW5kZXhPZiggXCIgXCIgKyBjbGFzc05hbWUgKyBcIiBcIiApID4gLTEgKSB7XG5cdFx0XHRcdFx0XHRcdGN1ciA9IGN1ci5yZXBsYWNlKCBcIiBcIiArIGNsYXNzTmFtZSArIFwiIFwiLCBcIiBcIiApO1xuXHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdH1cblxuXHRcdFx0XHRcdC8vIE9ubHkgYXNzaWduIGlmIGRpZmZlcmVudCB0byBhdm9pZCB1bm5lZWRlZCByZW5kZXJpbmcuXG5cdFx0XHRcdFx0ZmluYWxWYWx1ZSA9IHN0cmlwQW5kQ29sbGFwc2UoIGN1ciApO1xuXHRcdFx0XHRcdGlmICggY3VyVmFsdWUgIT09IGZpbmFsVmFsdWUgKSB7XG5cdFx0XHRcdFx0XHR0aGlzLnNldEF0dHJpYnV0ZSggXCJjbGFzc1wiLCBmaW5hbFZhbHVlICk7XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHR9XG5cdFx0XHR9ICk7XG5cdFx0fVxuXG5cdFx0cmV0dXJuIHRoaXM7XG5cdH0sXG5cblx0dG9nZ2xlQ2xhc3M6IGZ1bmN0aW9uKCB2YWx1ZSwgc3RhdGVWYWwgKSB7XG5cdFx0dmFyIGNsYXNzTmFtZXMsIGNsYXNzTmFtZSwgaSwgc2VsZjtcblxuXHRcdGlmICggdHlwZW9mIHZhbHVlID09PSBcImZ1bmN0aW9uXCIgKSB7XG5cdFx0XHRyZXR1cm4gdGhpcy5lYWNoKCBmdW5jdGlvbiggaSApIHtcblx0XHRcdFx0alF1ZXJ5KCB0aGlzICkudG9nZ2xlQ2xhc3MoXG5cdFx0XHRcdFx0dmFsdWUuY2FsbCggdGhpcywgaSwgZ2V0Q2xhc3MoIHRoaXMgKSwgc3RhdGVWYWwgKSxcblx0XHRcdFx0XHRzdGF0ZVZhbFxuXHRcdFx0XHQpO1xuXHRcdFx0fSApO1xuXHRcdH1cblxuXHRcdGlmICggdHlwZW9mIHN0YXRlVmFsID09PSBcImJvb2xlYW5cIiApIHtcblx0XHRcdHJldHVybiBzdGF0ZVZhbCA/IHRoaXMuYWRkQ2xhc3MoIHZhbHVlICkgOiB0aGlzLnJlbW92ZUNsYXNzKCB2YWx1ZSApO1xuXHRcdH1cblxuXHRcdGNsYXNzTmFtZXMgPSBjbGFzc2VzVG9BcnJheSggdmFsdWUgKTtcblxuXHRcdGlmICggY2xhc3NOYW1lcy5sZW5ndGggKSB7XG5cdFx0XHRyZXR1cm4gdGhpcy5lYWNoKCBmdW5jdGlvbigpIHtcblxuXHRcdFx0XHQvLyBUb2dnbGUgaW5kaXZpZHVhbCBjbGFzcyBuYW1lc1xuXHRcdFx0XHRzZWxmID0galF1ZXJ5KCB0aGlzICk7XG5cblx0XHRcdFx0Zm9yICggaSA9IDA7IGkgPCBjbGFzc05hbWVzLmxlbmd0aDsgaSsrICkge1xuXHRcdFx0XHRcdGNsYXNzTmFtZSA9IGNsYXNzTmFtZXNbIGkgXTtcblxuXHRcdFx0XHRcdC8vIENoZWNrIGVhY2ggY2xhc3NOYW1lIGdpdmVuLCBzcGFjZSBzZXBhcmF0ZWQgbGlzdFxuXHRcdFx0XHRcdGlmICggc2VsZi5oYXNDbGFzcyggY2xhc3NOYW1lICkgKSB7XG5cdFx0XHRcdFx0XHRzZWxmLnJlbW92ZUNsYXNzKCBjbGFzc05hbWUgKTtcblx0XHRcdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRcdFx0c2VsZi5hZGRDbGFzcyggY2xhc3NOYW1lICk7XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHR9XG5cdFx0XHR9ICk7XG5cdFx0fVxuXG5cdFx0cmV0dXJuIHRoaXM7XG5cdH0sXG5cblx0aGFzQ2xhc3M6IGZ1bmN0aW9uKCBzZWxlY3RvciApIHtcblx0XHR2YXIgY2xhc3NOYW1lLCBlbGVtLFxuXHRcdFx0aSA9IDA7XG5cblx0XHRjbGFzc05hbWUgPSBcIiBcIiArIHNlbGVjdG9yICsgXCIgXCI7XG5cdFx0d2hpbGUgKCAoIGVsZW0gPSB0aGlzWyBpKysgXSApICkge1xuXHRcdFx0aWYgKCBlbGVtLm5vZGVUeXBlID09PSAxICYmXG5cdFx0XHRcdCggXCIgXCIgKyBzdHJpcEFuZENvbGxhcHNlKCBnZXRDbGFzcyggZWxlbSApICkgKyBcIiBcIiApLmluZGV4T2YoIGNsYXNzTmFtZSApID4gLTEgKSB7XG5cdFx0XHRcdHJldHVybiB0cnVlO1xuXHRcdFx0fVxuXHRcdH1cblxuXHRcdHJldHVybiBmYWxzZTtcblx0fVxufSApO1xuXG5qUXVlcnkuZm4uZXh0ZW5kKCB7XG5cdHZhbDogZnVuY3Rpb24oIHZhbHVlICkge1xuXHRcdHZhciBob29rcywgcmV0LCB2YWx1ZUlzRnVuY3Rpb24sXG5cdFx0XHRlbGVtID0gdGhpc1sgMCBdO1xuXG5cdFx0aWYgKCAhYXJndW1lbnRzLmxlbmd0aCApIHtcblx0XHRcdGlmICggZWxlbSApIHtcblx0XHRcdFx0aG9va3MgPSBqUXVlcnkudmFsSG9va3NbIGVsZW0udHlwZSBdIHx8XG5cdFx0XHRcdFx0alF1ZXJ5LnZhbEhvb2tzWyBlbGVtLm5vZGVOYW1lLnRvTG93ZXJDYXNlKCkgXTtcblxuXHRcdFx0XHRpZiAoIGhvb2tzICYmXG5cdFx0XHRcdFx0XCJnZXRcIiBpbiBob29rcyAmJlxuXHRcdFx0XHRcdCggcmV0ID0gaG9va3MuZ2V0KCBlbGVtLCBcInZhbHVlXCIgKSApICE9PSB1bmRlZmluZWRcblx0XHRcdFx0KSB7XG5cdFx0XHRcdFx0cmV0dXJuIHJldDtcblx0XHRcdFx0fVxuXG5cdFx0XHRcdHJldCA9IGVsZW0udmFsdWU7XG5cblx0XHRcdFx0Ly8gSGFuZGxlIGNhc2VzIHdoZXJlIHZhbHVlIGlzIG51bGwvdW5kZWYgb3IgbnVtYmVyXG5cdFx0XHRcdHJldHVybiByZXQgPT0gbnVsbCA/IFwiXCIgOiByZXQ7XG5cdFx0XHR9XG5cblx0XHRcdHJldHVybjtcblx0XHR9XG5cblx0XHR2YWx1ZUlzRnVuY3Rpb24gPSB0eXBlb2YgdmFsdWUgPT09IFwiZnVuY3Rpb25cIjtcblxuXHRcdHJldHVybiB0aGlzLmVhY2goIGZ1bmN0aW9uKCBpICkge1xuXHRcdFx0dmFyIHZhbDtcblxuXHRcdFx0aWYgKCB0aGlzLm5vZGVUeXBlICE9PSAxICkge1xuXHRcdFx0XHRyZXR1cm47XG5cdFx0XHR9XG5cblx0XHRcdGlmICggdmFsdWVJc0Z1bmN0aW9uICkge1xuXHRcdFx0XHR2YWwgPSB2YWx1ZS5jYWxsKCB0aGlzLCBpLCBqUXVlcnkoIHRoaXMgKS52YWwoKSApO1xuXHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0dmFsID0gdmFsdWU7XG5cdFx0XHR9XG5cblx0XHRcdC8vIFRyZWF0IG51bGwvdW5kZWZpbmVkIGFzIFwiXCI7IGNvbnZlcnQgbnVtYmVycyB0byBzdHJpbmdcblx0XHRcdGlmICggdmFsID09IG51bGwgKSB7XG5cdFx0XHRcdHZhbCA9IFwiXCI7XG5cblx0XHRcdH0gZWxzZSBpZiAoIHR5cGVvZiB2YWwgPT09IFwibnVtYmVyXCIgKSB7XG5cdFx0XHRcdHZhbCArPSBcIlwiO1xuXG5cdFx0XHR9IGVsc2UgaWYgKCBBcnJheS5pc0FycmF5KCB2YWwgKSApIHtcblx0XHRcdFx0dmFsID0galF1ZXJ5Lm1hcCggdmFsLCBmdW5jdGlvbiggdmFsdWUgKSB7XG5cdFx0XHRcdFx0cmV0dXJuIHZhbHVlID09IG51bGwgPyBcIlwiIDogdmFsdWUgKyBcIlwiO1xuXHRcdFx0XHR9ICk7XG5cdFx0XHR9XG5cblx0XHRcdGhvb2tzID0galF1ZXJ5LnZhbEhvb2tzWyB0aGlzLnR5cGUgXSB8fCBqUXVlcnkudmFsSG9va3NbIHRoaXMubm9kZU5hbWUudG9Mb3dlckNhc2UoKSBdO1xuXG5cdFx0XHQvLyBJZiBzZXQgcmV0dXJucyB1bmRlZmluZWQsIGZhbGwgYmFjayB0byBub3JtYWwgc2V0dGluZ1xuXHRcdFx0aWYgKCAhaG9va3MgfHwgISggXCJzZXRcIiBpbiBob29rcyApIHx8IGhvb2tzLnNldCggdGhpcywgdmFsLCBcInZhbHVlXCIgKSA9PT0gdW5kZWZpbmVkICkge1xuXHRcdFx0XHR0aGlzLnZhbHVlID0gdmFsO1xuXHRcdFx0fVxuXHRcdH0gKTtcblx0fVxufSApO1xuXG5qUXVlcnkuZXh0ZW5kKCB7XG5cdHZhbEhvb2tzOiB7XG5cdFx0c2VsZWN0OiB7XG5cdFx0XHRnZXQ6IGZ1bmN0aW9uKCBlbGVtICkge1xuXHRcdFx0XHR2YXIgdmFsdWUsIG9wdGlvbiwgaSxcblx0XHRcdFx0XHRvcHRpb25zID0gZWxlbS5vcHRpb25zLFxuXHRcdFx0XHRcdGluZGV4ID0gZWxlbS5zZWxlY3RlZEluZGV4LFxuXHRcdFx0XHRcdG9uZSA9IGVsZW0udHlwZSA9PT0gXCJzZWxlY3Qtb25lXCIsXG5cdFx0XHRcdFx0dmFsdWVzID0gb25lID8gbnVsbCA6IFtdLFxuXHRcdFx0XHRcdG1heCA9IG9uZSA/IGluZGV4ICsgMSA6IG9wdGlvbnMubGVuZ3RoO1xuXG5cdFx0XHRcdGlmICggaW5kZXggPCAwICkge1xuXHRcdFx0XHRcdGkgPSBtYXg7XG5cblx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHRpID0gb25lID8gaW5kZXggOiAwO1xuXHRcdFx0XHR9XG5cblx0XHRcdFx0Ly8gTG9vcCB0aHJvdWdoIGFsbCB0aGUgc2VsZWN0ZWQgb3B0aW9uc1xuXHRcdFx0XHRmb3IgKCA7IGkgPCBtYXg7IGkrKyApIHtcblx0XHRcdFx0XHRvcHRpb24gPSBvcHRpb25zWyBpIF07XG5cblx0XHRcdFx0XHRpZiAoIG9wdGlvbi5zZWxlY3RlZCAmJlxuXG5cdFx0XHRcdFx0XHRcdC8vIERvbid0IHJldHVybiBvcHRpb25zIHRoYXQgYXJlIGRpc2FibGVkIG9yIGluIGEgZGlzYWJsZWQgb3B0Z3JvdXBcblx0XHRcdFx0XHRcdFx0IW9wdGlvbi5kaXNhYmxlZCAmJlxuXHRcdFx0XHRcdFx0XHQoICFvcHRpb24ucGFyZW50Tm9kZS5kaXNhYmxlZCB8fFxuXHRcdFx0XHRcdFx0XHRcdCFub2RlTmFtZSggb3B0aW9uLnBhcmVudE5vZGUsIFwib3B0Z3JvdXBcIiApICkgKSB7XG5cblx0XHRcdFx0XHRcdC8vIEdldCB0aGUgc3BlY2lmaWMgdmFsdWUgZm9yIHRoZSBvcHRpb25cblx0XHRcdFx0XHRcdHZhbHVlID0galF1ZXJ5KCBvcHRpb24gKS52YWwoKTtcblxuXHRcdFx0XHRcdFx0Ly8gV2UgZG9uJ3QgbmVlZCBhbiBhcnJheSBmb3Igb25lIHNlbGVjdHNcblx0XHRcdFx0XHRcdGlmICggb25lICkge1xuXHRcdFx0XHRcdFx0XHRyZXR1cm4gdmFsdWU7XG5cdFx0XHRcdFx0XHR9XG5cblx0XHRcdFx0XHRcdC8vIE11bHRpLVNlbGVjdHMgcmV0dXJuIGFuIGFycmF5XG5cdFx0XHRcdFx0XHR2YWx1ZXMucHVzaCggdmFsdWUgKTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH1cblxuXHRcdFx0XHRyZXR1cm4gdmFsdWVzO1xuXHRcdFx0fSxcblxuXHRcdFx0c2V0OiBmdW5jdGlvbiggZWxlbSwgdmFsdWUgKSB7XG5cdFx0XHRcdHZhciBvcHRpb25TZXQsIG9wdGlvbixcblx0XHRcdFx0XHRvcHRpb25zID0gZWxlbS5vcHRpb25zLFxuXHRcdFx0XHRcdHZhbHVlcyA9IGpRdWVyeS5tYWtlQXJyYXkoIHZhbHVlICksXG5cdFx0XHRcdFx0aSA9IG9wdGlvbnMubGVuZ3RoO1xuXG5cdFx0XHRcdHdoaWxlICggaS0tICkge1xuXHRcdFx0XHRcdG9wdGlvbiA9IG9wdGlvbnNbIGkgXTtcblxuXHRcdFx0XHRcdGlmICggKCBvcHRpb24uc2VsZWN0ZWQgPVxuXHRcdFx0XHRcdFx0alF1ZXJ5LmluQXJyYXkoIGpRdWVyeSggb3B0aW9uICkudmFsKCksIHZhbHVlcyApID4gLTFcblx0XHRcdFx0XHQpICkge1xuXHRcdFx0XHRcdFx0b3B0aW9uU2V0ID0gdHJ1ZTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH1cblxuXHRcdFx0XHQvLyBGb3JjZSBicm93c2VycyB0byBiZWhhdmUgY29uc2lzdGVudGx5IHdoZW4gbm9uLW1hdGNoaW5nIHZhbHVlIGlzIHNldFxuXHRcdFx0XHRpZiAoICFvcHRpb25TZXQgKSB7XG5cdFx0XHRcdFx0ZWxlbS5zZWxlY3RlZEluZGV4ID0gLTE7XG5cdFx0XHRcdH1cblx0XHRcdFx0cmV0dXJuIHZhbHVlcztcblx0XHRcdH1cblx0XHR9XG5cdH1cbn0gKTtcblxuaWYgKCBpc0lFICkge1xuXHRqUXVlcnkudmFsSG9va3Mub3B0aW9uID0ge1xuXHRcdGdldDogZnVuY3Rpb24oIGVsZW0gKSB7XG5cblx0XHRcdHZhciB2YWwgPSBlbGVtLmdldEF0dHJpYnV0ZSggXCJ2YWx1ZVwiICk7XG5cdFx0XHRyZXR1cm4gdmFsICE9IG51bGwgP1xuXHRcdFx0XHR2YWwgOlxuXG5cdFx0XHRcdC8vIFN1cHBvcnQ6IElFIDw9MTAgLSAxMStcblx0XHRcdFx0Ly8gb3B0aW9uLnRleHQgdGhyb3dzIGV4Y2VwdGlvbnMgKHRyYWMtMTQ2ODYsIHRyYWMtMTQ4NTgpXG5cdFx0XHRcdC8vIFN0cmlwIGFuZCBjb2xsYXBzZSB3aGl0ZXNwYWNlXG5cdFx0XHRcdC8vIGh0dHBzOi8vaHRtbC5zcGVjLndoYXR3Zy5vcmcvI3N0cmlwLWFuZC1jb2xsYXBzZS13aGl0ZXNwYWNlXG5cdFx0XHRcdHN0cmlwQW5kQ29sbGFwc2UoIGpRdWVyeS50ZXh0KCBlbGVtICkgKTtcblx0XHR9XG5cdH07XG59XG5cbi8vIFJhZGlvcyBhbmQgY2hlY2tib3hlcyBnZXR0ZXIvc2V0dGVyXG5qUXVlcnkuZWFjaCggWyBcInJhZGlvXCIsIFwiY2hlY2tib3hcIiBdLCBmdW5jdGlvbigpIHtcblx0alF1ZXJ5LnZhbEhvb2tzWyB0aGlzIF0gPSB7XG5cdFx0c2V0OiBmdW5jdGlvbiggZWxlbSwgdmFsdWUgKSB7XG5cdFx0XHRpZiAoIEFycmF5LmlzQXJyYXkoIHZhbHVlICkgKSB7XG5cdFx0XHRcdHJldHVybiAoIGVsZW0uY2hlY2tlZCA9IGpRdWVyeS5pbkFycmF5KCBqUXVlcnkoIGVsZW0gKS52YWwoKSwgdmFsdWUgKSA+IC0xICk7XG5cdFx0XHR9XG5cdFx0fVxuXHR9O1xufSApO1xuXG52YXIgcmZvY3VzTW9ycGggPSAvXig/OmZvY3VzaW5mb2N1c3xmb2N1c291dGJsdXIpJC8sXG5cdHN0b3BQcm9wYWdhdGlvbkNhbGxiYWNrID0gZnVuY3Rpb24oIGUgKSB7XG5cdFx0ZS5zdG9wUHJvcGFnYXRpb24oKTtcblx0fTtcblxualF1ZXJ5LmV4dGVuZCggalF1ZXJ5LmV2ZW50LCB7XG5cblx0dHJpZ2dlcjogZnVuY3Rpb24oIGV2ZW50LCBkYXRhLCBlbGVtLCBvbmx5SGFuZGxlcnMgKSB7XG5cblx0XHR2YXIgaSwgY3VyLCB0bXAsIGJ1YmJsZVR5cGUsIG9udHlwZSwgaGFuZGxlLCBzcGVjaWFsLCBsYXN0RWxlbWVudCxcblx0XHRcdGV2ZW50UGF0aCA9IFsgZWxlbSB8fCBkb2N1bWVudCQxIF0sXG5cdFx0XHR0eXBlID0gaGFzT3duLmNhbGwoIGV2ZW50LCBcInR5cGVcIiApID8gZXZlbnQudHlwZSA6IGV2ZW50LFxuXHRcdFx0bmFtZXNwYWNlcyA9IGhhc093bi5jYWxsKCBldmVudCwgXCJuYW1lc3BhY2VcIiApID8gZXZlbnQubmFtZXNwYWNlLnNwbGl0KCBcIi5cIiApIDogW107XG5cblx0XHRjdXIgPSBsYXN0RWxlbWVudCA9IHRtcCA9IGVsZW0gPSBlbGVtIHx8IGRvY3VtZW50JDE7XG5cblx0XHQvLyBEb24ndCBkbyBldmVudHMgb24gdGV4dCBhbmQgY29tbWVudCBub2Rlc1xuXHRcdGlmICggZWxlbS5ub2RlVHlwZSA9PT0gMyB8fCBlbGVtLm5vZGVUeXBlID09PSA4ICkge1xuXHRcdFx0cmV0dXJuO1xuXHRcdH1cblxuXHRcdC8vIGZvY3VzL2JsdXIgbW9ycGhzIHRvIGZvY3VzaW4vb3V0OyBlbnN1cmUgd2UncmUgbm90IGZpcmluZyB0aGVtIHJpZ2h0IG5vd1xuXHRcdGlmICggcmZvY3VzTW9ycGgudGVzdCggdHlwZSArIGpRdWVyeS5ldmVudC50cmlnZ2VyZWQgKSApIHtcblx0XHRcdHJldHVybjtcblx0XHR9XG5cblx0XHRpZiAoIHR5cGUuaW5kZXhPZiggXCIuXCIgKSA+IC0xICkge1xuXG5cdFx0XHQvLyBOYW1lc3BhY2VkIHRyaWdnZXI7IGNyZWF0ZSBhIHJlZ2V4cCB0byBtYXRjaCBldmVudCB0eXBlIGluIGhhbmRsZSgpXG5cdFx0XHRuYW1lc3BhY2VzID0gdHlwZS5zcGxpdCggXCIuXCIgKTtcblx0XHRcdHR5cGUgPSBuYW1lc3BhY2VzLnNoaWZ0KCk7XG5cdFx0XHRuYW1lc3BhY2VzLnNvcnQoKTtcblx0XHR9XG5cdFx0b250eXBlID0gdHlwZS5pbmRleE9mKCBcIjpcIiApIDwgMCAmJiBcIm9uXCIgKyB0eXBlO1xuXG5cdFx0Ly8gQ2FsbGVyIGNhbiBwYXNzIGluIGEgalF1ZXJ5LkV2ZW50IG9iamVjdCwgT2JqZWN0LCBvciBqdXN0IGFuIGV2ZW50IHR5cGUgc3RyaW5nXG5cdFx0ZXZlbnQgPSBldmVudFsgalF1ZXJ5LmV4cGFuZG8gXSA/XG5cdFx0XHRldmVudCA6XG5cdFx0XHRuZXcgalF1ZXJ5LkV2ZW50KCB0eXBlLCB0eXBlb2YgZXZlbnQgPT09IFwib2JqZWN0XCIgJiYgZXZlbnQgKTtcblxuXHRcdC8vIFRyaWdnZXIgYml0bWFzazogJiAxIGZvciBuYXRpdmUgaGFuZGxlcnM7ICYgMiBmb3IgalF1ZXJ5IChhbHdheXMgdHJ1ZSlcblx0XHRldmVudC5pc1RyaWdnZXIgPSBvbmx5SGFuZGxlcnMgPyAyIDogMztcblx0XHRldmVudC5uYW1lc3BhY2UgPSBuYW1lc3BhY2VzLmpvaW4oIFwiLlwiICk7XG5cdFx0ZXZlbnQucm5hbWVzcGFjZSA9IGV2ZW50Lm5hbWVzcGFjZSA/XG5cdFx0XHRuZXcgUmVnRXhwKCBcIihefFxcXFwuKVwiICsgbmFtZXNwYWNlcy5qb2luKCBcIlxcXFwuKD86LipcXFxcLnwpXCIgKSArIFwiKFxcXFwufCQpXCIgKSA6XG5cdFx0XHRudWxsO1xuXG5cdFx0Ly8gQ2xlYW4gdXAgdGhlIGV2ZW50IGluIGNhc2UgaXQgaXMgYmVpbmcgcmV1c2VkXG5cdFx0ZXZlbnQucmVzdWx0ID0gdW5kZWZpbmVkO1xuXHRcdGlmICggIWV2ZW50LnRhcmdldCApIHtcblx0XHRcdGV2ZW50LnRhcmdldCA9IGVsZW07XG5cdFx0fVxuXG5cdFx0Ly8gQ2xvbmUgYW55IGluY29taW5nIGRhdGEgYW5kIHByZXBlbmQgdGhlIGV2ZW50LCBjcmVhdGluZyB0aGUgaGFuZGxlciBhcmcgbGlzdFxuXHRcdGRhdGEgPSBkYXRhID09IG51bGwgP1xuXHRcdFx0WyBldmVudCBdIDpcblx0XHRcdGpRdWVyeS5tYWtlQXJyYXkoIGRhdGEsIFsgZXZlbnQgXSApO1xuXG5cdFx0Ly8gQWxsb3cgc3BlY2lhbCBldmVudHMgdG8gZHJhdyBvdXRzaWRlIHRoZSBsaW5lc1xuXHRcdHNwZWNpYWwgPSBqUXVlcnkuZXZlbnQuc3BlY2lhbFsgdHlwZSBdIHx8IHt9O1xuXHRcdGlmICggIW9ubHlIYW5kbGVycyAmJiBzcGVjaWFsLnRyaWdnZXIgJiYgc3BlY2lhbC50cmlnZ2VyLmFwcGx5KCBlbGVtLCBkYXRhICkgPT09IGZhbHNlICkge1xuXHRcdFx0cmV0dXJuO1xuXHRcdH1cblxuXHRcdC8vIERldGVybWluZSBldmVudCBwcm9wYWdhdGlvbiBwYXRoIGluIGFkdmFuY2UsIHBlciBXM0MgZXZlbnRzIHNwZWMgKHRyYWMtOTk1MSlcblx0XHQvLyBCdWJibGUgdXAgdG8gZG9jdW1lbnQsIHRoZW4gdG8gd2luZG93OyB3YXRjaCBmb3IgYSBnbG9iYWwgb3duZXJEb2N1bWVudCB2YXIgKHRyYWMtOTcyNClcblx0XHRpZiAoICFvbmx5SGFuZGxlcnMgJiYgIXNwZWNpYWwubm9CdWJibGUgJiYgIWlzV2luZG93KCBlbGVtICkgKSB7XG5cblx0XHRcdGJ1YmJsZVR5cGUgPSBzcGVjaWFsLmRlbGVnYXRlVHlwZSB8fCB0eXBlO1xuXHRcdFx0aWYgKCAhcmZvY3VzTW9ycGgudGVzdCggYnViYmxlVHlwZSArIHR5cGUgKSApIHtcblx0XHRcdFx0Y3VyID0gY3VyLnBhcmVudE5vZGU7XG5cdFx0XHR9XG5cdFx0XHRmb3IgKCA7IGN1cjsgY3VyID0gY3VyLnBhcmVudE5vZGUgKSB7XG5cdFx0XHRcdGV2ZW50UGF0aC5wdXNoKCBjdXIgKTtcblx0XHRcdFx0dG1wID0gY3VyO1xuXHRcdFx0fVxuXG5cdFx0XHQvLyBPbmx5IGFkZCB3aW5kb3cgaWYgd2UgZ290IHRvIGRvY3VtZW50IChlLmcuLCBub3QgcGxhaW4gb2JqIG9yIGRldGFjaGVkIERPTSlcblx0XHRcdGlmICggdG1wID09PSAoIGVsZW0ub3duZXJEb2N1bWVudCB8fCBkb2N1bWVudCQxICkgKSB7XG5cdFx0XHRcdGV2ZW50UGF0aC5wdXNoKCB0bXAuZGVmYXVsdFZpZXcgfHwgdG1wLnBhcmVudFdpbmRvdyB8fCB3aW5kb3cgKTtcblx0XHRcdH1cblx0XHR9XG5cblx0XHQvLyBGaXJlIGhhbmRsZXJzIG9uIHRoZSBldmVudCBwYXRoXG5cdFx0aSA9IDA7XG5cdFx0d2hpbGUgKCAoIGN1ciA9IGV2ZW50UGF0aFsgaSsrIF0gKSAmJiAhZXZlbnQuaXNQcm9wYWdhdGlvblN0b3BwZWQoKSApIHtcblx0XHRcdGxhc3RFbGVtZW50ID0gY3VyO1xuXHRcdFx0ZXZlbnQudHlwZSA9IGkgPiAxID9cblx0XHRcdFx0YnViYmxlVHlwZSA6XG5cdFx0XHRcdHNwZWNpYWwuYmluZFR5cGUgfHwgdHlwZTtcblxuXHRcdFx0Ly8galF1ZXJ5IGhhbmRsZXJcblx0XHRcdGhhbmRsZSA9ICggZGF0YVByaXYuZ2V0KCBjdXIsIFwiZXZlbnRzXCIgKSB8fCBPYmplY3QuY3JlYXRlKCBudWxsICkgKVsgZXZlbnQudHlwZSBdICYmXG5cdFx0XHRcdGRhdGFQcml2LmdldCggY3VyLCBcImhhbmRsZVwiICk7XG5cdFx0XHRpZiAoIGhhbmRsZSApIHtcblx0XHRcdFx0aGFuZGxlLmFwcGx5KCBjdXIsIGRhdGEgKTtcblx0XHRcdH1cblxuXHRcdFx0Ly8gTmF0aXZlIGhhbmRsZXJcblx0XHRcdGhhbmRsZSA9IG9udHlwZSAmJiBjdXJbIG9udHlwZSBdO1xuXHRcdFx0aWYgKCBoYW5kbGUgJiYgaGFuZGxlLmFwcGx5ICYmIGFjY2VwdERhdGEoIGN1ciApICkge1xuXHRcdFx0XHRldmVudC5yZXN1bHQgPSBoYW5kbGUuYXBwbHkoIGN1ciwgZGF0YSApO1xuXHRcdFx0XHRpZiAoIGV2ZW50LnJlc3VsdCA9PT0gZmFsc2UgKSB7XG5cdFx0XHRcdFx0ZXZlbnQucHJldmVudERlZmF1bHQoKTtcblx0XHRcdFx0fVxuXHRcdFx0fVxuXHRcdH1cblx0XHRldmVudC50eXBlID0gdHlwZTtcblxuXHRcdC8vIElmIG5vYm9keSBwcmV2ZW50ZWQgdGhlIGRlZmF1bHQgYWN0aW9uLCBkbyBpdCBub3dcblx0XHRpZiAoICFvbmx5SGFuZGxlcnMgJiYgIWV2ZW50LmlzRGVmYXVsdFByZXZlbnRlZCgpICkge1xuXG5cdFx0XHRpZiAoICggIXNwZWNpYWwuX2RlZmF1bHQgfHxcblx0XHRcdFx0c3BlY2lhbC5fZGVmYXVsdC5hcHBseSggZXZlbnRQYXRoLnBvcCgpLCBkYXRhICkgPT09IGZhbHNlICkgJiZcblx0XHRcdFx0YWNjZXB0RGF0YSggZWxlbSApICkge1xuXG5cdFx0XHRcdC8vIENhbGwgYSBuYXRpdmUgRE9NIG1ldGhvZCBvbiB0aGUgdGFyZ2V0IHdpdGggdGhlIHNhbWUgbmFtZSBhcyB0aGUgZXZlbnQuXG5cdFx0XHRcdC8vIERvbid0IGRvIGRlZmF1bHQgYWN0aW9ucyBvbiB3aW5kb3csIHRoYXQncyB3aGVyZSBnbG9iYWwgdmFyaWFibGVzIGJlICh0cmFjLTYxNzApXG5cdFx0XHRcdGlmICggb250eXBlICYmIHR5cGVvZiBlbGVtWyB0eXBlIF0gPT09IFwiZnVuY3Rpb25cIiAmJiAhaXNXaW5kb3coIGVsZW0gKSApIHtcblxuXHRcdFx0XHRcdC8vIERvbid0IHJlLXRyaWdnZXIgYW4gb25GT08gZXZlbnQgd2hlbiB3ZSBjYWxsIGl0cyBGT08oKSBtZXRob2Rcblx0XHRcdFx0XHR0bXAgPSBlbGVtWyBvbnR5cGUgXTtcblxuXHRcdFx0XHRcdGlmICggdG1wICkge1xuXHRcdFx0XHRcdFx0ZWxlbVsgb250eXBlIF0gPSBudWxsO1xuXHRcdFx0XHRcdH1cblxuXHRcdFx0XHRcdC8vIFByZXZlbnQgcmUtdHJpZ2dlcmluZyBvZiB0aGUgc2FtZSBldmVudCwgc2luY2Ugd2UgYWxyZWFkeSBidWJibGVkIGl0IGFib3ZlXG5cdFx0XHRcdFx0alF1ZXJ5LmV2ZW50LnRyaWdnZXJlZCA9IHR5cGU7XG5cblx0XHRcdFx0XHRpZiAoIGV2ZW50LmlzUHJvcGFnYXRpb25TdG9wcGVkKCkgKSB7XG5cdFx0XHRcdFx0XHRsYXN0RWxlbWVudC5hZGRFdmVudExpc3RlbmVyKCB0eXBlLCBzdG9wUHJvcGFnYXRpb25DYWxsYmFjayApO1xuXHRcdFx0XHRcdH1cblxuXHRcdFx0XHRcdGVsZW1bIHR5cGUgXSgpO1xuXG5cdFx0XHRcdFx0aWYgKCBldmVudC5pc1Byb3BhZ2F0aW9uU3RvcHBlZCgpICkge1xuXHRcdFx0XHRcdFx0bGFzdEVsZW1lbnQucmVtb3ZlRXZlbnRMaXN0ZW5lciggdHlwZSwgc3RvcFByb3BhZ2F0aW9uQ2FsbGJhY2sgKTtcblx0XHRcdFx0XHR9XG5cblx0XHRcdFx0XHRqUXVlcnkuZXZlbnQudHJpZ2dlcmVkID0gdW5kZWZpbmVkO1xuXG5cdFx0XHRcdFx0aWYgKCB0bXAgKSB7XG5cdFx0XHRcdFx0XHRlbGVtWyBvbnR5cGUgXSA9IHRtcDtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH1cblx0XHRcdH1cblx0XHR9XG5cblx0XHRyZXR1cm4gZXZlbnQucmVzdWx0O1xuXHR9LFxuXG5cdC8vIFBpZ2d5YmFjayBvbiBhIGRvbm9yIGV2ZW50IHRvIHNpbXVsYXRlIGEgZGlmZmVyZW50IG9uZVxuXHQvLyBVc2VkIG9ubHkgZm9yIGBmb2N1cyhpbiB8IG91dClgIGV2ZW50c1xuXHRzaW11bGF0ZTogZnVuY3Rpb24oIHR5cGUsIGVsZW0sIGV2ZW50ICkge1xuXHRcdHZhciBlID0galF1ZXJ5LmV4dGVuZChcblx0XHRcdG5ldyBqUXVlcnkuRXZlbnQoKSxcblx0XHRcdGV2ZW50LFxuXHRcdFx0e1xuXHRcdFx0XHR0eXBlOiB0eXBlLFxuXHRcdFx0XHRpc1NpbXVsYXRlZDogdHJ1ZVxuXHRcdFx0fVxuXHRcdCk7XG5cblx0XHRqUXVlcnkuZXZlbnQudHJpZ2dlciggZSwgbnVsbCwgZWxlbSApO1xuXHR9XG5cbn0gKTtcblxualF1ZXJ5LmZuLmV4dGVuZCgge1xuXG5cdHRyaWdnZXI6IGZ1bmN0aW9uKCB0eXBlLCBkYXRhICkge1xuXHRcdHJldHVybiB0aGlzLmVhY2goIGZ1bmN0aW9uKCkge1xuXHRcdFx0alF1ZXJ5LmV2ZW50LnRyaWdnZXIoIHR5cGUsIGRhdGEsIHRoaXMgKTtcblx0XHR9ICk7XG5cdH0sXG5cdHRyaWdnZXJIYW5kbGVyOiBmdW5jdGlvbiggdHlwZSwgZGF0YSApIHtcblx0XHR2YXIgZWxlbSA9IHRoaXNbIDAgXTtcblx0XHRpZiAoIGVsZW0gKSB7XG5cdFx0XHRyZXR1cm4galF1ZXJ5LmV2ZW50LnRyaWdnZXIoIHR5cGUsIGRhdGEsIGVsZW0sIHRydWUgKTtcblx0XHR9XG5cdH1cbn0gKTtcblxudmFyIGxvY2F0aW9uID0gd2luZG93LmxvY2F0aW9uO1xuXG52YXIgbm9uY2UgPSB7IGd1aWQ6IERhdGUubm93KCkgfTtcblxudmFyIHJxdWVyeSA9IC9cXD8vO1xuXG4vLyBDcm9zcy1icm93c2VyIHhtbCBwYXJzaW5nXG5qUXVlcnkucGFyc2VYTUwgPSBmdW5jdGlvbiggZGF0YSApIHtcblx0dmFyIHhtbCwgcGFyc2VyRXJyb3JFbGVtO1xuXHRpZiAoICFkYXRhIHx8IHR5cGVvZiBkYXRhICE9PSBcInN0cmluZ1wiICkge1xuXHRcdHJldHVybiBudWxsO1xuXHR9XG5cblx0Ly8gU3VwcG9ydDogSUUgOSAtIDExK1xuXHQvLyBJRSB0aHJvd3Mgb24gcGFyc2VGcm9tU3RyaW5nIHdpdGggaW52YWxpZCBpbnB1dC5cblx0dHJ5IHtcblx0XHR4bWwgPSAoIG5ldyB3aW5kb3cuRE9NUGFyc2VyKCkgKS5wYXJzZUZyb21TdHJpbmcoIGRhdGEsIFwidGV4dC94bWxcIiApO1xuXHR9IGNhdGNoICggZSApIHt9XG5cblx0cGFyc2VyRXJyb3JFbGVtID0geG1sICYmIHhtbC5nZXRFbGVtZW50c0J5VGFnTmFtZSggXCJwYXJzZXJlcnJvclwiIClbIDAgXTtcblx0aWYgKCAheG1sIHx8IHBhcnNlckVycm9yRWxlbSApIHtcblx0XHRqUXVlcnkuZXJyb3IoIFwiSW52YWxpZCBYTUw6IFwiICsgKFxuXHRcdFx0cGFyc2VyRXJyb3JFbGVtID9cblx0XHRcdFx0alF1ZXJ5Lm1hcCggcGFyc2VyRXJyb3JFbGVtLmNoaWxkTm9kZXMsIGZ1bmN0aW9uKCBlbCApIHtcblx0XHRcdFx0XHRyZXR1cm4gZWwudGV4dENvbnRlbnQ7XG5cdFx0XHRcdH0gKS5qb2luKCBcIlxcblwiICkgOlxuXHRcdFx0XHRkYXRhXG5cdFx0KSApO1xuXHR9XG5cdHJldHVybiB4bWw7XG59O1xuXG52YXJcblx0cmJyYWNrZXQgPSAvXFxbXFxdJC8sXG5cdHJDUkxGID0gL1xccj9cXG4vZyxcblx0cnN1Ym1pdHRlclR5cGVzID0gL14oPzpzdWJtaXR8YnV0dG9ufGltYWdlfHJlc2V0fGZpbGUpJC9pLFxuXHRyc3VibWl0dGFibGUgPSAvXig/OmlucHV0fHNlbGVjdHx0ZXh0YXJlYXxrZXlnZW4pL2k7XG5cbmZ1bmN0aW9uIGJ1aWxkUGFyYW1zKCBwcmVmaXgsIG9iaiwgdHJhZGl0aW9uYWwsIGFkZCApIHtcblx0dmFyIG5hbWU7XG5cblx0aWYgKCBBcnJheS5pc0FycmF5KCBvYmogKSApIHtcblxuXHRcdC8vIFNlcmlhbGl6ZSBhcnJheSBpdGVtLlxuXHRcdGpRdWVyeS5lYWNoKCBvYmosIGZ1bmN0aW9uKCBpLCB2ICkge1xuXHRcdFx0aWYgKCB0cmFkaXRpb25hbCB8fCByYnJhY2tldC50ZXN0KCBwcmVmaXggKSApIHtcblxuXHRcdFx0XHQvLyBUcmVhdCBlYWNoIGFycmF5IGl0ZW0gYXMgYSBzY2FsYXIuXG5cdFx0XHRcdGFkZCggcHJlZml4LCB2ICk7XG5cblx0XHRcdH0gZWxzZSB7XG5cblx0XHRcdFx0Ly8gSXRlbSBpcyBub24tc2NhbGFyIChhcnJheSBvciBvYmplY3QpLCBlbmNvZGUgaXRzIG51bWVyaWMgaW5kZXguXG5cdFx0XHRcdGJ1aWxkUGFyYW1zKFxuXHRcdFx0XHRcdHByZWZpeCArIFwiW1wiICsgKCB0eXBlb2YgdiA9PT0gXCJvYmplY3RcIiAmJiB2ICE9IG51bGwgPyBpIDogXCJcIiApICsgXCJdXCIsXG5cdFx0XHRcdFx0dixcblx0XHRcdFx0XHR0cmFkaXRpb25hbCxcblx0XHRcdFx0XHRhZGRcblx0XHRcdFx0KTtcblx0XHRcdH1cblx0XHR9ICk7XG5cblx0fSBlbHNlIGlmICggIXRyYWRpdGlvbmFsICYmIHRvVHlwZSggb2JqICkgPT09IFwib2JqZWN0XCIgKSB7XG5cblx0XHQvLyBTZXJpYWxpemUgb2JqZWN0IGl0ZW0uXG5cdFx0Zm9yICggbmFtZSBpbiBvYmogKSB7XG5cdFx0XHRidWlsZFBhcmFtcyggcHJlZml4ICsgXCJbXCIgKyBuYW1lICsgXCJdXCIsIG9ialsgbmFtZSBdLCB0cmFkaXRpb25hbCwgYWRkICk7XG5cdFx0fVxuXG5cdH0gZWxzZSB7XG5cblx0XHQvLyBTZXJpYWxpemUgc2NhbGFyIGl0ZW0uXG5cdFx0YWRkKCBwcmVmaXgsIG9iaiApO1xuXHR9XG59XG5cbi8vIFNlcmlhbGl6ZSBhbiBhcnJheSBvZiBmb3JtIGVsZW1lbnRzIG9yIGEgc2V0IG9mXG4vLyBrZXkvdmFsdWVzIGludG8gYSBxdWVyeSBzdHJpbmdcbmpRdWVyeS5wYXJhbSA9IGZ1bmN0aW9uKCBhLCB0cmFkaXRpb25hbCApIHtcblx0dmFyIHByZWZpeCxcblx0XHRzID0gW10sXG5cdFx0YWRkID0gZnVuY3Rpb24oIGtleSwgdmFsdWVPckZ1bmN0aW9uICkge1xuXG5cdFx0XHQvLyBJZiB2YWx1ZSBpcyBhIGZ1bmN0aW9uLCBpbnZva2UgaXQgYW5kIHVzZSBpdHMgcmV0dXJuIHZhbHVlXG5cdFx0XHR2YXIgdmFsdWUgPSB0eXBlb2YgdmFsdWVPckZ1bmN0aW9uID09PSBcImZ1bmN0aW9uXCIgP1xuXHRcdFx0XHR2YWx1ZU9yRnVuY3Rpb24oKSA6XG5cdFx0XHRcdHZhbHVlT3JGdW5jdGlvbjtcblxuXHRcdFx0c1sgcy5sZW5ndGggXSA9IGVuY29kZVVSSUNvbXBvbmVudCgga2V5ICkgKyBcIj1cIiArXG5cdFx0XHRcdGVuY29kZVVSSUNvbXBvbmVudCggdmFsdWUgPT0gbnVsbCA/IFwiXCIgOiB2YWx1ZSApO1xuXHRcdH07XG5cblx0aWYgKCBhID09IG51bGwgKSB7XG5cdFx0cmV0dXJuIFwiXCI7XG5cdH1cblxuXHQvLyBJZiBhbiBhcnJheSB3YXMgcGFzc2VkIGluLCBhc3N1bWUgdGhhdCBpdCBpcyBhbiBhcnJheSBvZiBmb3JtIGVsZW1lbnRzLlxuXHRpZiAoIEFycmF5LmlzQXJyYXkoIGEgKSB8fCAoIGEuanF1ZXJ5ICYmICFqUXVlcnkuaXNQbGFpbk9iamVjdCggYSApICkgKSB7XG5cblx0XHQvLyBTZXJpYWxpemUgdGhlIGZvcm0gZWxlbWVudHNcblx0XHRqUXVlcnkuZWFjaCggYSwgZnVuY3Rpb24oKSB7XG5cdFx0XHRhZGQoIHRoaXMubmFtZSwgdGhpcy52YWx1ZSApO1xuXHRcdH0gKTtcblxuXHR9IGVsc2Uge1xuXG5cdFx0Ly8gSWYgdHJhZGl0aW9uYWwsIGVuY29kZSB0aGUgXCJvbGRcIiB3YXkgKHRoZSB3YXkgMS4zLjIgb3Igb2xkZXJcblx0XHQvLyBkaWQgaXQpLCBvdGhlcndpc2UgZW5jb2RlIHBhcmFtcyByZWN1cnNpdmVseS5cblx0XHRmb3IgKCBwcmVmaXggaW4gYSApIHtcblx0XHRcdGJ1aWxkUGFyYW1zKCBwcmVmaXgsIGFbIHByZWZpeCBdLCB0cmFkaXRpb25hbCwgYWRkICk7XG5cdFx0fVxuXHR9XG5cblx0Ly8gUmV0dXJuIHRoZSByZXN1bHRpbmcgc2VyaWFsaXphdGlvblxuXHRyZXR1cm4gcy5qb2luKCBcIiZcIiApO1xufTtcblxualF1ZXJ5LmZuLmV4dGVuZCgge1xuXHRzZXJpYWxpemU6IGZ1bmN0aW9uKCkge1xuXHRcdHJldHVybiBqUXVlcnkucGFyYW0oIHRoaXMuc2VyaWFsaXplQXJyYXkoKSApO1xuXHR9LFxuXHRzZXJpYWxpemVBcnJheTogZnVuY3Rpb24oKSB7XG5cdFx0cmV0dXJuIHRoaXMubWFwKCBmdW5jdGlvbigpIHtcblxuXHRcdFx0Ly8gQ2FuIGFkZCBwcm9wSG9vayBmb3IgXCJlbGVtZW50c1wiIHRvIGZpbHRlciBvciBhZGQgZm9ybSBlbGVtZW50c1xuXHRcdFx0dmFyIGVsZW1lbnRzID0galF1ZXJ5LnByb3AoIHRoaXMsIFwiZWxlbWVudHNcIiApO1xuXHRcdFx0cmV0dXJuIGVsZW1lbnRzID8galF1ZXJ5Lm1ha2VBcnJheSggZWxlbWVudHMgKSA6IHRoaXM7XG5cdFx0fSApLmZpbHRlciggZnVuY3Rpb24oKSB7XG5cdFx0XHR2YXIgdHlwZSA9IHRoaXMudHlwZTtcblxuXHRcdFx0Ly8gVXNlIC5pcyggXCI6ZGlzYWJsZWRcIiApIHNvIHRoYXQgZmllbGRzZXRbZGlzYWJsZWRdIHdvcmtzXG5cdFx0XHRyZXR1cm4gdGhpcy5uYW1lICYmICFqUXVlcnkoIHRoaXMgKS5pcyggXCI6ZGlzYWJsZWRcIiApICYmXG5cdFx0XHRcdHJzdWJtaXR0YWJsZS50ZXN0KCB0aGlzLm5vZGVOYW1lICkgJiYgIXJzdWJtaXR0ZXJUeXBlcy50ZXN0KCB0eXBlICkgJiZcblx0XHRcdFx0KCB0aGlzLmNoZWNrZWQgfHwgIXJjaGVja2FibGVUeXBlLnRlc3QoIHR5cGUgKSApO1xuXHRcdH0gKS5tYXAoIGZ1bmN0aW9uKCBfaSwgZWxlbSApIHtcblx0XHRcdHZhciB2YWwgPSBqUXVlcnkoIHRoaXMgKS52YWwoKTtcblxuXHRcdFx0aWYgKCB2YWwgPT0gbnVsbCApIHtcblx0XHRcdFx0cmV0dXJuIG51bGw7XG5cdFx0XHR9XG5cblx0XHRcdGlmICggQXJyYXkuaXNBcnJheSggdmFsICkgKSB7XG5cdFx0XHRcdHJldHVybiBqUXVlcnkubWFwKCB2YWwsIGZ1bmN0aW9uKCB2YWwgKSB7XG5cdFx0XHRcdFx0cmV0dXJuIHsgbmFtZTogZWxlbS5uYW1lLCB2YWx1ZTogdmFsLnJlcGxhY2UoIHJDUkxGLCBcIlxcclxcblwiICkgfTtcblx0XHRcdFx0fSApO1xuXHRcdFx0fVxuXG5cdFx0XHRyZXR1cm4geyBuYW1lOiBlbGVtLm5hbWUsIHZhbHVlOiB2YWwucmVwbGFjZSggckNSTEYsIFwiXFxyXFxuXCIgKSB9O1xuXHRcdH0gKS5nZXQoKTtcblx0fVxufSApO1xuXG52YXJcblx0cjIwID0gLyUyMC9nLFxuXHRyaGFzaCA9IC8jLiokLyxcblx0cmFudGlDYWNoZSA9IC8oWz8mXSlfPVteJl0qLyxcblx0cmhlYWRlcnMgPSAvXiguKj8pOlsgXFx0XSooW15cXHJcXG5dKikkL21nLFxuXG5cdC8vIHRyYWMtNzY1MywgdHJhYy04MTI1LCB0cmFjLTgxNTI6IGxvY2FsIHByb3RvY29sIGRldGVjdGlvblxuXHRybG9jYWxQcm90b2NvbCA9IC9eKD86YWJvdXR8YXBwfGFwcC1zdG9yYWdlfC4rLWV4dGVuc2lvbnxmaWxlfHJlc3x3aWRnZXQpOiQvLFxuXHRybm9Db250ZW50ID0gL14oPzpHRVR8SEVBRCkkLyxcblx0cnByb3RvY29sID0gL15cXC9cXC8vLFxuXG5cdC8qIFByZWZpbHRlcnNcblx0ICogMSkgVGhleSBhcmUgdXNlZnVsIHRvIGludHJvZHVjZSBjdXN0b20gZGF0YVR5cGVzIChzZWUgYWpheC9qc29ucC5qcyBmb3IgYW4gZXhhbXBsZSlcblx0ICogMikgVGhlc2UgYXJlIGNhbGxlZDpcblx0ICogICAgLSBCRUZPUkUgYXNraW5nIGZvciBhIHRyYW5zcG9ydFxuXHQgKiAgICAtIEFGVEVSIHBhcmFtIHNlcmlhbGl6YXRpb24gKHMuZGF0YSBpcyBhIHN0cmluZyBpZiBzLnByb2Nlc3NEYXRhIGlzIHRydWUpXG5cdCAqIDMpIGtleSBpcyB0aGUgZGF0YVR5cGVcblx0ICogNCkgdGhlIGNhdGNoYWxsIHN5bWJvbCBcIipcIiBjYW4gYmUgdXNlZFxuXHQgKiA1KSBleGVjdXRpb24gd2lsbCBzdGFydCB3aXRoIHRyYW5zcG9ydCBkYXRhVHlwZSBhbmQgVEhFTiBjb250aW51ZSBkb3duIHRvIFwiKlwiIGlmIG5lZWRlZFxuXHQgKi9cblx0cHJlZmlsdGVycyA9IHt9LFxuXG5cdC8qIFRyYW5zcG9ydHMgYmluZGluZ3Ncblx0ICogMSkga2V5IGlzIHRoZSBkYXRhVHlwZVxuXHQgKiAyKSB0aGUgY2F0Y2hhbGwgc3ltYm9sIFwiKlwiIGNhbiBiZSB1c2VkXG5cdCAqIDMpIHNlbGVjdGlvbiB3aWxsIHN0YXJ0IHdpdGggdHJhbnNwb3J0IGRhdGFUeXBlIGFuZCBUSEVOIGdvIHRvIFwiKlwiIGlmIG5lZWRlZFxuXHQgKi9cblx0dHJhbnNwb3J0cyA9IHt9LFxuXG5cdC8vIEF2b2lkIGNvbW1lbnQtcHJvbG9nIGNoYXIgc2VxdWVuY2UgKHRyYWMtMTAwOTgpOyBtdXN0IGFwcGVhc2UgbGludCBhbmQgZXZhZGUgY29tcHJlc3Npb25cblx0YWxsVHlwZXMgPSBcIiovXCIuY29uY2F0KCBcIipcIiApLFxuXG5cdC8vIEFuY2hvciB0YWcgZm9yIHBhcnNpbmcgdGhlIGRvY3VtZW50IG9yaWdpblxuXHRvcmlnaW5BbmNob3IgPSBkb2N1bWVudCQxLmNyZWF0ZUVsZW1lbnQoIFwiYVwiICk7XG5cbm9yaWdpbkFuY2hvci5ocmVmID0gbG9jYXRpb24uaHJlZjtcblxuLy8gQmFzZSBcImNvbnN0cnVjdG9yXCIgZm9yIGpRdWVyeS5hamF4UHJlZmlsdGVyIGFuZCBqUXVlcnkuYWpheFRyYW5zcG9ydFxuZnVuY3Rpb24gYWRkVG9QcmVmaWx0ZXJzT3JUcmFuc3BvcnRzKCBzdHJ1Y3R1cmUgKSB7XG5cblx0Ly8gZGF0YVR5cGVFeHByZXNzaW9uIGlzIG9wdGlvbmFsIGFuZCBkZWZhdWx0cyB0byBcIipcIlxuXHRyZXR1cm4gZnVuY3Rpb24oIGRhdGFUeXBlRXhwcmVzc2lvbiwgZnVuYyApIHtcblxuXHRcdGlmICggdHlwZW9mIGRhdGFUeXBlRXhwcmVzc2lvbiAhPT0gXCJzdHJpbmdcIiApIHtcblx0XHRcdGZ1bmMgPSBkYXRhVHlwZUV4cHJlc3Npb247XG5cdFx0XHRkYXRhVHlwZUV4cHJlc3Npb24gPSBcIipcIjtcblx0XHR9XG5cblx0XHR2YXIgZGF0YVR5cGUsXG5cdFx0XHRpID0gMCxcblx0XHRcdGRhdGFUeXBlcyA9IGRhdGFUeXBlRXhwcmVzc2lvbi50b0xvd2VyQ2FzZSgpLm1hdGNoKCBybm90aHRtbHdoaXRlICkgfHwgW107XG5cblx0XHRpZiAoIHR5cGVvZiBmdW5jID09PSBcImZ1bmN0aW9uXCIgKSB7XG5cblx0XHRcdC8vIEZvciBlYWNoIGRhdGFUeXBlIGluIHRoZSBkYXRhVHlwZUV4cHJlc3Npb25cblx0XHRcdHdoaWxlICggKCBkYXRhVHlwZSA9IGRhdGFUeXBlc1sgaSsrIF0gKSApIHtcblxuXHRcdFx0XHQvLyBQcmVwZW5kIGlmIHJlcXVlc3RlZFxuXHRcdFx0XHRpZiAoIGRhdGFUeXBlWyAwIF0gPT09IFwiK1wiICkge1xuXHRcdFx0XHRcdGRhdGFUeXBlID0gZGF0YVR5cGUuc2xpY2UoIDEgKSB8fCBcIipcIjtcblx0XHRcdFx0XHQoIHN0cnVjdHVyZVsgZGF0YVR5cGUgXSA9IHN0cnVjdHVyZVsgZGF0YVR5cGUgXSB8fCBbXSApLnVuc2hpZnQoIGZ1bmMgKTtcblxuXHRcdFx0XHQvLyBPdGhlcndpc2UgYXBwZW5kXG5cdFx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdFx0KCBzdHJ1Y3R1cmVbIGRhdGFUeXBlIF0gPSBzdHJ1Y3R1cmVbIGRhdGFUeXBlIF0gfHwgW10gKS5wdXNoKCBmdW5jICk7XG5cdFx0XHRcdH1cblx0XHRcdH1cblx0XHR9XG5cdH07XG59XG5cbi8vIEJhc2UgaW5zcGVjdGlvbiBmdW5jdGlvbiBmb3IgcHJlZmlsdGVycyBhbmQgdHJhbnNwb3J0c1xuZnVuY3Rpb24gaW5zcGVjdFByZWZpbHRlcnNPclRyYW5zcG9ydHMoIHN0cnVjdHVyZSwgb3B0aW9ucywgb3JpZ2luYWxPcHRpb25zLCBqcVhIUiApIHtcblxuXHR2YXIgaW5zcGVjdGVkID0ge30sXG5cdFx0c2Vla2luZ1RyYW5zcG9ydCA9ICggc3RydWN0dXJlID09PSB0cmFuc3BvcnRzICk7XG5cblx0ZnVuY3Rpb24gaW5zcGVjdCggZGF0YVR5cGUgKSB7XG5cdFx0dmFyIHNlbGVjdGVkO1xuXHRcdGluc3BlY3RlZFsgZGF0YVR5cGUgXSA9IHRydWU7XG5cdFx0alF1ZXJ5LmVhY2goIHN0cnVjdHVyZVsgZGF0YVR5cGUgXSB8fCBbXSwgZnVuY3Rpb24oIF8sIHByZWZpbHRlck9yRmFjdG9yeSApIHtcblx0XHRcdHZhciBkYXRhVHlwZU9yVHJhbnNwb3J0ID0gcHJlZmlsdGVyT3JGYWN0b3J5KCBvcHRpb25zLCBvcmlnaW5hbE9wdGlvbnMsIGpxWEhSICk7XG5cdFx0XHRpZiAoIHR5cGVvZiBkYXRhVHlwZU9yVHJhbnNwb3J0ID09PSBcInN0cmluZ1wiICYmXG5cdFx0XHRcdCFzZWVraW5nVHJhbnNwb3J0ICYmICFpbnNwZWN0ZWRbIGRhdGFUeXBlT3JUcmFuc3BvcnQgXSApIHtcblxuXHRcdFx0XHRvcHRpb25zLmRhdGFUeXBlcy51bnNoaWZ0KCBkYXRhVHlwZU9yVHJhbnNwb3J0ICk7XG5cdFx0XHRcdGluc3BlY3QoIGRhdGFUeXBlT3JUcmFuc3BvcnQgKTtcblx0XHRcdFx0cmV0dXJuIGZhbHNlO1xuXHRcdFx0fSBlbHNlIGlmICggc2Vla2luZ1RyYW5zcG9ydCApIHtcblx0XHRcdFx0cmV0dXJuICEoIHNlbGVjdGVkID0gZGF0YVR5cGVPclRyYW5zcG9ydCApO1xuXHRcdFx0fVxuXHRcdH0gKTtcblx0XHRyZXR1cm4gc2VsZWN0ZWQ7XG5cdH1cblxuXHRyZXR1cm4gaW5zcGVjdCggb3B0aW9ucy5kYXRhVHlwZXNbIDAgXSApIHx8ICFpbnNwZWN0ZWRbIFwiKlwiIF0gJiYgaW5zcGVjdCggXCIqXCIgKTtcbn1cblxuLy8gQSBzcGVjaWFsIGV4dGVuZCBmb3IgYWpheCBvcHRpb25zXG4vLyB0aGF0IHRha2VzIFwiZmxhdFwiIG9wdGlvbnMgKG5vdCB0byBiZSBkZWVwIGV4dGVuZGVkKVxuLy8gRml4ZXMgdHJhYy05ODg3XG5mdW5jdGlvbiBhamF4RXh0ZW5kKCB0YXJnZXQsIHNyYyApIHtcblx0dmFyIGtleSwgZGVlcCxcblx0XHRmbGF0T3B0aW9ucyA9IGpRdWVyeS5hamF4U2V0dGluZ3MuZmxhdE9wdGlvbnMgfHwge307XG5cblx0Zm9yICgga2V5IGluIHNyYyApIHtcblx0XHRpZiAoIHNyY1sga2V5IF0gIT09IHVuZGVmaW5lZCApIHtcblx0XHRcdCggZmxhdE9wdGlvbnNbIGtleSBdID8gdGFyZ2V0IDogKCBkZWVwIHx8ICggZGVlcCA9IHt9ICkgKSApWyBrZXkgXSA9IHNyY1sga2V5IF07XG5cdFx0fVxuXHR9XG5cdGlmICggZGVlcCApIHtcblx0XHRqUXVlcnkuZXh0ZW5kKCB0cnVlLCB0YXJnZXQsIGRlZXAgKTtcblx0fVxuXG5cdHJldHVybiB0YXJnZXQ7XG59XG5cbi8qIEhhbmRsZXMgcmVzcG9uc2VzIHRvIGFuIGFqYXggcmVxdWVzdDpcbiAqIC0gZmluZHMgdGhlIHJpZ2h0IGRhdGFUeXBlIChtZWRpYXRlcyBiZXR3ZWVuIGNvbnRlbnQtdHlwZSBhbmQgZXhwZWN0ZWQgZGF0YVR5cGUpXG4gKiAtIHJldHVybnMgdGhlIGNvcnJlc3BvbmRpbmcgcmVzcG9uc2VcbiAqL1xuZnVuY3Rpb24gYWpheEhhbmRsZVJlc3BvbnNlcyggcywganFYSFIsIHJlc3BvbnNlcyApIHtcblxuXHR2YXIgY3QsIHR5cGUsIGZpbmFsRGF0YVR5cGUsIGZpcnN0RGF0YVR5cGUsXG5cdFx0Y29udGVudHMgPSBzLmNvbnRlbnRzLFxuXHRcdGRhdGFUeXBlcyA9IHMuZGF0YVR5cGVzO1xuXG5cdC8vIFJlbW92ZSBhdXRvIGRhdGFUeXBlIGFuZCBnZXQgY29udGVudC10eXBlIGluIHRoZSBwcm9jZXNzXG5cdHdoaWxlICggZGF0YVR5cGVzWyAwIF0gPT09IFwiKlwiICkge1xuXHRcdGRhdGFUeXBlcy5zaGlmdCgpO1xuXHRcdGlmICggY3QgPT09IHVuZGVmaW5lZCApIHtcblx0XHRcdGN0ID0gcy5taW1lVHlwZSB8fCBqcVhIUi5nZXRSZXNwb25zZUhlYWRlciggXCJDb250ZW50LVR5cGVcIiApO1xuXHRcdH1cblx0fVxuXG5cdC8vIENoZWNrIGlmIHdlJ3JlIGRlYWxpbmcgd2l0aCBhIGtub3duIGNvbnRlbnQtdHlwZVxuXHRpZiAoIGN0ICkge1xuXHRcdGZvciAoIHR5cGUgaW4gY29udGVudHMgKSB7XG5cdFx0XHRpZiAoIGNvbnRlbnRzWyB0eXBlIF0gJiYgY29udGVudHNbIHR5cGUgXS50ZXN0KCBjdCApICkge1xuXHRcdFx0XHRkYXRhVHlwZXMudW5zaGlmdCggdHlwZSApO1xuXHRcdFx0XHRicmVhaztcblx0XHRcdH1cblx0XHR9XG5cdH1cblxuXHQvLyBDaGVjayB0byBzZWUgaWYgd2UgaGF2ZSBhIHJlc3BvbnNlIGZvciB0aGUgZXhwZWN0ZWQgZGF0YVR5cGVcblx0aWYgKCBkYXRhVHlwZXNbIDAgXSBpbiByZXNwb25zZXMgKSB7XG5cdFx0ZmluYWxEYXRhVHlwZSA9IGRhdGFUeXBlc1sgMCBdO1xuXHR9IGVsc2Uge1xuXG5cdFx0Ly8gVHJ5IGNvbnZlcnRpYmxlIGRhdGFUeXBlc1xuXHRcdGZvciAoIHR5cGUgaW4gcmVzcG9uc2VzICkge1xuXHRcdFx0aWYgKCAhZGF0YVR5cGVzWyAwIF0gfHwgcy5jb252ZXJ0ZXJzWyB0eXBlICsgXCIgXCIgKyBkYXRhVHlwZXNbIDAgXSBdICkge1xuXHRcdFx0XHRmaW5hbERhdGFUeXBlID0gdHlwZTtcblx0XHRcdFx0YnJlYWs7XG5cdFx0XHR9XG5cdFx0XHRpZiAoICFmaXJzdERhdGFUeXBlICkge1xuXHRcdFx0XHRmaXJzdERhdGFUeXBlID0gdHlwZTtcblx0XHRcdH1cblx0XHR9XG5cblx0XHQvLyBPciBqdXN0IHVzZSBmaXJzdCBvbmVcblx0XHRmaW5hbERhdGFUeXBlID0gZmluYWxEYXRhVHlwZSB8fCBmaXJzdERhdGFUeXBlO1xuXHR9XG5cblx0Ly8gSWYgd2UgZm91bmQgYSBkYXRhVHlwZVxuXHQvLyBXZSBhZGQgdGhlIGRhdGFUeXBlIHRvIHRoZSBsaXN0IGlmIG5lZWRlZFxuXHQvLyBhbmQgcmV0dXJuIHRoZSBjb3JyZXNwb25kaW5nIHJlc3BvbnNlXG5cdGlmICggZmluYWxEYXRhVHlwZSApIHtcblx0XHRpZiAoIGZpbmFsRGF0YVR5cGUgIT09IGRhdGFUeXBlc1sgMCBdICkge1xuXHRcdFx0ZGF0YVR5cGVzLnVuc2hpZnQoIGZpbmFsRGF0YVR5cGUgKTtcblx0XHR9XG5cdFx0cmV0dXJuIHJlc3BvbnNlc1sgZmluYWxEYXRhVHlwZSBdO1xuXHR9XG59XG5cbi8qIENoYWluIGNvbnZlcnNpb25zIGdpdmVuIHRoZSByZXF1ZXN0IGFuZCB0aGUgb3JpZ2luYWwgcmVzcG9uc2VcbiAqIEFsc28gc2V0cyB0aGUgcmVzcG9uc2VYWFggZmllbGRzIG9uIHRoZSBqcVhIUiBpbnN0YW5jZVxuICovXG5mdW5jdGlvbiBhamF4Q29udmVydCggcywgcmVzcG9uc2UsIGpxWEhSLCBpc1N1Y2Nlc3MgKSB7XG5cdHZhciBjb252MiwgY3VycmVudCwgY29udiwgdG1wLCBwcmV2LFxuXHRcdGNvbnZlcnRlcnMgPSB7fSxcblxuXHRcdC8vIFdvcmsgd2l0aCBhIGNvcHkgb2YgZGF0YVR5cGVzIGluIGNhc2Ugd2UgbmVlZCB0byBtb2RpZnkgaXQgZm9yIGNvbnZlcnNpb25cblx0XHRkYXRhVHlwZXMgPSBzLmRhdGFUeXBlcy5zbGljZSgpO1xuXG5cdC8vIENyZWF0ZSBjb252ZXJ0ZXJzIG1hcCB3aXRoIGxvd2VyY2FzZWQga2V5c1xuXHRpZiAoIGRhdGFUeXBlc1sgMSBdICkge1xuXHRcdGZvciAoIGNvbnYgaW4gcy5jb252ZXJ0ZXJzICkge1xuXHRcdFx0Y29udmVydGVyc1sgY29udi50b0xvd2VyQ2FzZSgpIF0gPSBzLmNvbnZlcnRlcnNbIGNvbnYgXTtcblx0XHR9XG5cdH1cblxuXHRjdXJyZW50ID0gZGF0YVR5cGVzLnNoaWZ0KCk7XG5cblx0Ly8gQ29udmVydCB0byBlYWNoIHNlcXVlbnRpYWwgZGF0YVR5cGVcblx0d2hpbGUgKCBjdXJyZW50ICkge1xuXG5cdFx0aWYgKCBzLnJlc3BvbnNlRmllbGRzWyBjdXJyZW50IF0gKSB7XG5cdFx0XHRqcVhIUlsgcy5yZXNwb25zZUZpZWxkc1sgY3VycmVudCBdIF0gPSByZXNwb25zZTtcblx0XHR9XG5cblx0XHQvLyBBcHBseSB0aGUgZGF0YUZpbHRlciBpZiBwcm92aWRlZFxuXHRcdGlmICggIXByZXYgJiYgaXNTdWNjZXNzICYmIHMuZGF0YUZpbHRlciApIHtcblx0XHRcdHJlc3BvbnNlID0gcy5kYXRhRmlsdGVyKCByZXNwb25zZSwgcy5kYXRhVHlwZSApO1xuXHRcdH1cblxuXHRcdHByZXYgPSBjdXJyZW50O1xuXHRcdGN1cnJlbnQgPSBkYXRhVHlwZXMuc2hpZnQoKTtcblxuXHRcdGlmICggY3VycmVudCApIHtcblxuXHRcdFx0Ly8gVGhlcmUncyBvbmx5IHdvcmsgdG8gZG8gaWYgY3VycmVudCBkYXRhVHlwZSBpcyBub24tYXV0b1xuXHRcdFx0aWYgKCBjdXJyZW50ID09PSBcIipcIiApIHtcblxuXHRcdFx0XHRjdXJyZW50ID0gcHJldjtcblxuXHRcdFx0Ly8gQ29udmVydCByZXNwb25zZSBpZiBwcmV2IGRhdGFUeXBlIGlzIG5vbi1hdXRvIGFuZCBkaWZmZXJzIGZyb20gY3VycmVudFxuXHRcdFx0fSBlbHNlIGlmICggcHJldiAhPT0gXCIqXCIgJiYgcHJldiAhPT0gY3VycmVudCApIHtcblxuXHRcdFx0XHQvLyBTZWVrIGEgZGlyZWN0IGNvbnZlcnRlclxuXHRcdFx0XHRjb252ID0gY29udmVydGVyc1sgcHJldiArIFwiIFwiICsgY3VycmVudCBdIHx8IGNvbnZlcnRlcnNbIFwiKiBcIiArIGN1cnJlbnQgXTtcblxuXHRcdFx0XHQvLyBJZiBub25lIGZvdW5kLCBzZWVrIGEgcGFpclxuXHRcdFx0XHRpZiAoICFjb252ICkge1xuXHRcdFx0XHRcdGZvciAoIGNvbnYyIGluIGNvbnZlcnRlcnMgKSB7XG5cblx0XHRcdFx0XHRcdC8vIElmIGNvbnYyIG91dHB1dHMgY3VycmVudFxuXHRcdFx0XHRcdFx0dG1wID0gY29udjIuc3BsaXQoIFwiIFwiICk7XG5cdFx0XHRcdFx0XHRpZiAoIHRtcFsgMSBdID09PSBjdXJyZW50ICkge1xuXG5cdFx0XHRcdFx0XHRcdC8vIElmIHByZXYgY2FuIGJlIGNvbnZlcnRlZCB0byBhY2NlcHRlZCBpbnB1dFxuXHRcdFx0XHRcdFx0XHRjb252ID0gY29udmVydGVyc1sgcHJldiArIFwiIFwiICsgdG1wWyAwIF0gXSB8fFxuXHRcdFx0XHRcdFx0XHRcdGNvbnZlcnRlcnNbIFwiKiBcIiArIHRtcFsgMCBdIF07XG5cdFx0XHRcdFx0XHRcdGlmICggY29udiApIHtcblxuXHRcdFx0XHRcdFx0XHRcdC8vIENvbmRlbnNlIGVxdWl2YWxlbmNlIGNvbnZlcnRlcnNcblx0XHRcdFx0XHRcdFx0XHRpZiAoIGNvbnYgPT09IHRydWUgKSB7XG5cdFx0XHRcdFx0XHRcdFx0XHRjb252ID0gY29udmVydGVyc1sgY29udjIgXTtcblxuXHRcdFx0XHRcdFx0XHRcdC8vIE90aGVyd2lzZSwgaW5zZXJ0IHRoZSBpbnRlcm1lZGlhdGUgZGF0YVR5cGVcblx0XHRcdFx0XHRcdFx0XHR9IGVsc2UgaWYgKCBjb252ZXJ0ZXJzWyBjb252MiBdICE9PSB0cnVlICkge1xuXHRcdFx0XHRcdFx0XHRcdFx0Y3VycmVudCA9IHRtcFsgMCBdO1xuXHRcdFx0XHRcdFx0XHRcdFx0ZGF0YVR5cGVzLnVuc2hpZnQoIHRtcFsgMSBdICk7XG5cdFx0XHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdFx0XHRcdGJyZWFrO1xuXHRcdFx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHR9XG5cblx0XHRcdFx0Ly8gQXBwbHkgY29udmVydGVyIChpZiBub3QgYW4gZXF1aXZhbGVuY2UpXG5cdFx0XHRcdGlmICggY29udiAhPT0gdHJ1ZSApIHtcblxuXHRcdFx0XHRcdC8vIFVubGVzcyBlcnJvcnMgYXJlIGFsbG93ZWQgdG8gYnViYmxlLCBjYXRjaCBhbmQgcmV0dXJuIHRoZW1cblx0XHRcdFx0XHRpZiAoIGNvbnYgJiYgcy50aHJvd3MgKSB7XG5cdFx0XHRcdFx0XHRyZXNwb25zZSA9IGNvbnYoIHJlc3BvbnNlICk7XG5cdFx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHRcdHRyeSB7XG5cdFx0XHRcdFx0XHRcdHJlc3BvbnNlID0gY29udiggcmVzcG9uc2UgKTtcblx0XHRcdFx0XHRcdH0gY2F0Y2ggKCBlICkge1xuXHRcdFx0XHRcdFx0XHRyZXR1cm4ge1xuXHRcdFx0XHRcdFx0XHRcdHN0YXRlOiBcInBhcnNlcmVycm9yXCIsXG5cdFx0XHRcdFx0XHRcdFx0ZXJyb3I6IGNvbnYgPyBlIDogXCJObyBjb252ZXJzaW9uIGZyb20gXCIgKyBwcmV2ICsgXCIgdG8gXCIgKyBjdXJyZW50XG5cdFx0XHRcdFx0XHRcdH07XG5cdFx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHR9XG5cdFx0XHR9XG5cdFx0fVxuXHR9XG5cblx0cmV0dXJuIHsgc3RhdGU6IFwic3VjY2Vzc1wiLCBkYXRhOiByZXNwb25zZSB9O1xufVxuXG5qUXVlcnkuZXh0ZW5kKCB7XG5cblx0Ly8gQ291bnRlciBmb3IgaG9sZGluZyB0aGUgbnVtYmVyIG9mIGFjdGl2ZSBxdWVyaWVzXG5cdGFjdGl2ZTogMCxcblxuXHQvLyBMYXN0LU1vZGlmaWVkIGhlYWRlciBjYWNoZSBmb3IgbmV4dCByZXF1ZXN0XG5cdGxhc3RNb2RpZmllZDoge30sXG5cdGV0YWc6IHt9LFxuXG5cdGFqYXhTZXR0aW5nczoge1xuXHRcdHVybDogbG9jYXRpb24uaHJlZixcblx0XHR0eXBlOiBcIkdFVFwiLFxuXHRcdGlzTG9jYWw6IHJsb2NhbFByb3RvY29sLnRlc3QoIGxvY2F0aW9uLnByb3RvY29sICksXG5cdFx0Z2xvYmFsOiB0cnVlLFxuXHRcdHByb2Nlc3NEYXRhOiB0cnVlLFxuXHRcdGFzeW5jOiB0cnVlLFxuXHRcdGNvbnRlbnRUeXBlOiBcImFwcGxpY2F0aW9uL3gtd3d3LWZvcm0tdXJsZW5jb2RlZDsgY2hhcnNldD1VVEYtOFwiLFxuXG5cdFx0Lypcblx0XHR0aW1lb3V0OiAwLFxuXHRcdGRhdGE6IG51bGwsXG5cdFx0ZGF0YVR5cGU6IG51bGwsXG5cdFx0dXNlcm5hbWU6IG51bGwsXG5cdFx0cGFzc3dvcmQ6IG51bGwsXG5cdFx0Y2FjaGU6IG51bGwsXG5cdFx0dGhyb3dzOiBmYWxzZSxcblx0XHR0cmFkaXRpb25hbDogZmFsc2UsXG5cdFx0aGVhZGVyczoge30sXG5cdFx0Ki9cblxuXHRcdGFjY2VwdHM6IHtcblx0XHRcdFwiKlwiOiBhbGxUeXBlcyxcblx0XHRcdHRleHQ6IFwidGV4dC9wbGFpblwiLFxuXHRcdFx0aHRtbDogXCJ0ZXh0L2h0bWxcIixcblx0XHRcdHhtbDogXCJhcHBsaWNhdGlvbi94bWwsIHRleHQveG1sXCIsXG5cdFx0XHRqc29uOiBcImFwcGxpY2F0aW9uL2pzb24sIHRleHQvamF2YXNjcmlwdFwiXG5cdFx0fSxcblxuXHRcdGNvbnRlbnRzOiB7XG5cdFx0XHR4bWw6IC9cXGJ4bWxcXGIvLFxuXHRcdFx0aHRtbDogL1xcYmh0bWwvLFxuXHRcdFx0anNvbjogL1xcYmpzb25cXGIvXG5cdFx0fSxcblxuXHRcdHJlc3BvbnNlRmllbGRzOiB7XG5cdFx0XHR4bWw6IFwicmVzcG9uc2VYTUxcIixcblx0XHRcdHRleHQ6IFwicmVzcG9uc2VUZXh0XCIsXG5cdFx0XHRqc29uOiBcInJlc3BvbnNlSlNPTlwiXG5cdFx0fSxcblxuXHRcdC8vIERhdGEgY29udmVydGVyc1xuXHRcdC8vIEtleXMgc2VwYXJhdGUgc291cmNlIChvciBjYXRjaGFsbCBcIipcIikgYW5kIGRlc3RpbmF0aW9uIHR5cGVzIHdpdGggYSBzaW5nbGUgc3BhY2Vcblx0XHRjb252ZXJ0ZXJzOiB7XG5cblx0XHRcdC8vIENvbnZlcnQgYW55dGhpbmcgdG8gdGV4dFxuXHRcdFx0XCIqIHRleHRcIjogU3RyaW5nLFxuXG5cdFx0XHQvLyBUZXh0IHRvIGh0bWwgKHRydWUgPSBubyB0cmFuc2Zvcm1hdGlvbilcblx0XHRcdFwidGV4dCBodG1sXCI6IHRydWUsXG5cblx0XHRcdC8vIEV2YWx1YXRlIHRleHQgYXMgYSBqc29uIGV4cHJlc3Npb25cblx0XHRcdFwidGV4dCBqc29uXCI6IEpTT04ucGFyc2UsXG5cblx0XHRcdC8vIFBhcnNlIHRleHQgYXMgeG1sXG5cdFx0XHRcInRleHQgeG1sXCI6IGpRdWVyeS5wYXJzZVhNTFxuXHRcdH0sXG5cblx0XHQvLyBGb3Igb3B0aW9ucyB0aGF0IHNob3VsZG4ndCBiZSBkZWVwIGV4dGVuZGVkOlxuXHRcdC8vIHlvdSBjYW4gYWRkIHlvdXIgb3duIGN1c3RvbSBvcHRpb25zIGhlcmUgaWZcblx0XHQvLyBhbmQgd2hlbiB5b3UgY3JlYXRlIG9uZSB0aGF0IHNob3VsZG4ndCBiZVxuXHRcdC8vIGRlZXAgZXh0ZW5kZWQgKHNlZSBhamF4RXh0ZW5kKVxuXHRcdGZsYXRPcHRpb25zOiB7XG5cdFx0XHR1cmw6IHRydWUsXG5cdFx0XHRjb250ZXh0OiB0cnVlXG5cdFx0fVxuXHR9LFxuXG5cdC8vIENyZWF0ZXMgYSBmdWxsIGZsZWRnZWQgc2V0dGluZ3Mgb2JqZWN0IGludG8gdGFyZ2V0XG5cdC8vIHdpdGggYm90aCBhamF4U2V0dGluZ3MgYW5kIHNldHRpbmdzIGZpZWxkcy5cblx0Ly8gSWYgdGFyZ2V0IGlzIG9taXR0ZWQsIHdyaXRlcyBpbnRvIGFqYXhTZXR0aW5ncy5cblx0YWpheFNldHVwOiBmdW5jdGlvbiggdGFyZ2V0LCBzZXR0aW5ncyApIHtcblx0XHRyZXR1cm4gc2V0dGluZ3MgP1xuXG5cdFx0XHQvLyBCdWlsZGluZyBhIHNldHRpbmdzIG9iamVjdFxuXHRcdFx0YWpheEV4dGVuZCggYWpheEV4dGVuZCggdGFyZ2V0LCBqUXVlcnkuYWpheFNldHRpbmdzICksIHNldHRpbmdzICkgOlxuXG5cdFx0XHQvLyBFeHRlbmRpbmcgYWpheFNldHRpbmdzXG5cdFx0XHRhamF4RXh0ZW5kKCBqUXVlcnkuYWpheFNldHRpbmdzLCB0YXJnZXQgKTtcblx0fSxcblxuXHRhamF4UHJlZmlsdGVyOiBhZGRUb1ByZWZpbHRlcnNPclRyYW5zcG9ydHMoIHByZWZpbHRlcnMgKSxcblx0YWpheFRyYW5zcG9ydDogYWRkVG9QcmVmaWx0ZXJzT3JUcmFuc3BvcnRzKCB0cmFuc3BvcnRzICksXG5cblx0Ly8gTWFpbiBtZXRob2Rcblx0YWpheDogZnVuY3Rpb24oIHVybCwgb3B0aW9ucyApIHtcblxuXHRcdC8vIElmIHVybCBpcyBhbiBvYmplY3QsIHNpbXVsYXRlIHByZS0xLjUgc2lnbmF0dXJlXG5cdFx0aWYgKCB0eXBlb2YgdXJsID09PSBcIm9iamVjdFwiICkge1xuXHRcdFx0b3B0aW9ucyA9IHVybDtcblx0XHRcdHVybCA9IHVuZGVmaW5lZDtcblx0XHR9XG5cblx0XHQvLyBGb3JjZSBvcHRpb25zIHRvIGJlIGFuIG9iamVjdFxuXHRcdG9wdGlvbnMgPSBvcHRpb25zIHx8IHt9O1xuXG5cdFx0dmFyIHRyYW5zcG9ydCxcblxuXHRcdFx0Ly8gVVJMIHdpdGhvdXQgYW50aS1jYWNoZSBwYXJhbVxuXHRcdFx0Y2FjaGVVUkwsXG5cblx0XHRcdC8vIFJlc3BvbnNlIGhlYWRlcnNcblx0XHRcdHJlc3BvbnNlSGVhZGVyc1N0cmluZyxcblx0XHRcdHJlc3BvbnNlSGVhZGVycyxcblxuXHRcdFx0Ly8gdGltZW91dCBoYW5kbGVcblx0XHRcdHRpbWVvdXRUaW1lcixcblxuXHRcdFx0Ly8gVXJsIGNsZWFudXAgdmFyXG5cdFx0XHR1cmxBbmNob3IsXG5cblx0XHRcdC8vIFJlcXVlc3Qgc3RhdGUgKGJlY29tZXMgZmFsc2UgdXBvbiBzZW5kIGFuZCB0cnVlIHVwb24gY29tcGxldGlvbilcblx0XHRcdGNvbXBsZXRlZCxcblxuXHRcdFx0Ly8gVG8ga25vdyBpZiBnbG9iYWwgZXZlbnRzIGFyZSB0byBiZSBkaXNwYXRjaGVkXG5cdFx0XHRmaXJlR2xvYmFscyxcblxuXHRcdFx0Ly8gTG9vcCB2YXJpYWJsZVxuXHRcdFx0aSxcblxuXHRcdFx0Ly8gdW5jYWNoZWQgcGFydCBvZiB0aGUgdXJsXG5cdFx0XHR1bmNhY2hlZCxcblxuXHRcdFx0Ly8gQ3JlYXRlIHRoZSBmaW5hbCBvcHRpb25zIG9iamVjdFxuXHRcdFx0cyA9IGpRdWVyeS5hamF4U2V0dXAoIHt9LCBvcHRpb25zICksXG5cblx0XHRcdC8vIENhbGxiYWNrcyBjb250ZXh0XG5cdFx0XHRjYWxsYmFja0NvbnRleHQgPSBzLmNvbnRleHQgfHwgcyxcblxuXHRcdFx0Ly8gQ29udGV4dCBmb3IgZ2xvYmFsIGV2ZW50cyBpcyBjYWxsYmFja0NvbnRleHQgaWYgaXQgaXMgYSBET00gbm9kZSBvciBqUXVlcnkgY29sbGVjdGlvblxuXHRcdFx0Z2xvYmFsRXZlbnRDb250ZXh0ID0gcy5jb250ZXh0ICYmXG5cdFx0XHRcdCggY2FsbGJhY2tDb250ZXh0Lm5vZGVUeXBlIHx8IGNhbGxiYWNrQ29udGV4dC5qcXVlcnkgKSA/XG5cdFx0XHRcdGpRdWVyeSggY2FsbGJhY2tDb250ZXh0ICkgOlxuXHRcdFx0XHRqUXVlcnkuZXZlbnQsXG5cblx0XHRcdC8vIERlZmVycmVkc1xuXHRcdFx0ZGVmZXJyZWQgPSBqUXVlcnkuRGVmZXJyZWQoKSxcblx0XHRcdGNvbXBsZXRlRGVmZXJyZWQgPSBqUXVlcnkuQ2FsbGJhY2tzKCBcIm9uY2UgbWVtb3J5XCIgKSxcblxuXHRcdFx0Ly8gU3RhdHVzLWRlcGVuZGVudCBjYWxsYmFja3Ncblx0XHRcdHN0YXR1c0NvZGUgPSBzLnN0YXR1c0NvZGUgfHwge30sXG5cblx0XHRcdC8vIEhlYWRlcnMgKHRoZXkgYXJlIHNlbnQgYWxsIGF0IG9uY2UpXG5cdFx0XHRyZXF1ZXN0SGVhZGVycyA9IHt9LFxuXHRcdFx0cmVxdWVzdEhlYWRlcnNOYW1lcyA9IHt9LFxuXG5cdFx0XHQvLyBEZWZhdWx0IGFib3J0IG1lc3NhZ2Vcblx0XHRcdHN0ckFib3J0ID0gXCJjYW5jZWxlZFwiLFxuXG5cdFx0XHQvLyBGYWtlIHhoclxuXHRcdFx0anFYSFIgPSB7XG5cdFx0XHRcdHJlYWR5U3RhdGU6IDAsXG5cblx0XHRcdFx0Ly8gQnVpbGRzIGhlYWRlcnMgaGFzaHRhYmxlIGlmIG5lZWRlZFxuXHRcdFx0XHRnZXRSZXNwb25zZUhlYWRlcjogZnVuY3Rpb24oIGtleSApIHtcblx0XHRcdFx0XHR2YXIgbWF0Y2g7XG5cdFx0XHRcdFx0aWYgKCBjb21wbGV0ZWQgKSB7XG5cdFx0XHRcdFx0XHRpZiAoICFyZXNwb25zZUhlYWRlcnMgKSB7XG5cdFx0XHRcdFx0XHRcdHJlc3BvbnNlSGVhZGVycyA9IHt9O1xuXHRcdFx0XHRcdFx0XHR3aGlsZSAoICggbWF0Y2ggPSByaGVhZGVycy5leGVjKCByZXNwb25zZUhlYWRlcnNTdHJpbmcgKSApICkge1xuXG5cdFx0XHRcdFx0XHRcdFx0Ly8gU3VwcG9ydDogSUUgMTErXG5cdFx0XHRcdFx0XHRcdFx0Ly8gYGdldFJlc3BvbnNlSGVhZGVyKCBrZXkgKWAgaW4gSUUgZG9lc24ndCBjb21iaW5lIGFsbCBoZWFkZXJcblx0XHRcdFx0XHRcdFx0XHQvLyB2YWx1ZXMgZm9yIHRoZSBwcm92aWRlZCBrZXkgaW50byBhIHNpbmdsZSByZXN1bHQgd2l0aCB2YWx1ZXNcblx0XHRcdFx0XHRcdFx0XHQvLyBqb2luZWQgYnkgY29tbWFzIGFzIG90aGVyIGJyb3dzZXJzIGRvLiBJbnN0ZWFkLCBpdCByZXR1cm5zXG5cdFx0XHRcdFx0XHRcdFx0Ly8gdGhlbSBvbiBzZXBhcmF0ZSBsaW5lcy5cblx0XHRcdFx0XHRcdFx0XHRyZXNwb25zZUhlYWRlcnNbIG1hdGNoWyAxIF0udG9Mb3dlckNhc2UoKSArIFwiIFwiIF0gPVxuXHRcdFx0XHRcdFx0XHRcdFx0KCByZXNwb25zZUhlYWRlcnNbIG1hdGNoWyAxIF0udG9Mb3dlckNhc2UoKSArIFwiIFwiIF0gfHwgW10gKVxuXHRcdFx0XHRcdFx0XHRcdFx0XHQuY29uY2F0KCBtYXRjaFsgMiBdICk7XG5cdFx0XHRcdFx0XHRcdH1cblx0XHRcdFx0XHRcdH1cblx0XHRcdFx0XHRcdG1hdGNoID0gcmVzcG9uc2VIZWFkZXJzWyBrZXkudG9Mb3dlckNhc2UoKSArIFwiIFwiIF07XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHRcdHJldHVybiBtYXRjaCA9PSBudWxsID8gbnVsbCA6IG1hdGNoLmpvaW4oIFwiLCBcIiApO1xuXHRcdFx0XHR9LFxuXG5cdFx0XHRcdC8vIFJhdyBzdHJpbmdcblx0XHRcdFx0Z2V0QWxsUmVzcG9uc2VIZWFkZXJzOiBmdW5jdGlvbigpIHtcblx0XHRcdFx0XHRyZXR1cm4gY29tcGxldGVkID8gcmVzcG9uc2VIZWFkZXJzU3RyaW5nIDogbnVsbDtcblx0XHRcdFx0fSxcblxuXHRcdFx0XHQvLyBDYWNoZXMgdGhlIGhlYWRlclxuXHRcdFx0XHRzZXRSZXF1ZXN0SGVhZGVyOiBmdW5jdGlvbiggbmFtZSwgdmFsdWUgKSB7XG5cdFx0XHRcdFx0aWYgKCBjb21wbGV0ZWQgPT0gbnVsbCApIHtcblx0XHRcdFx0XHRcdG5hbWUgPSByZXF1ZXN0SGVhZGVyc05hbWVzWyBuYW1lLnRvTG93ZXJDYXNlKCkgXSA9XG5cdFx0XHRcdFx0XHRcdHJlcXVlc3RIZWFkZXJzTmFtZXNbIG5hbWUudG9Mb3dlckNhc2UoKSBdIHx8IG5hbWU7XG5cdFx0XHRcdFx0XHRyZXF1ZXN0SGVhZGVyc1sgbmFtZSBdID0gdmFsdWU7XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHRcdHJldHVybiB0aGlzO1xuXHRcdFx0XHR9LFxuXG5cdFx0XHRcdC8vIE92ZXJyaWRlcyByZXNwb25zZSBjb250ZW50LXR5cGUgaGVhZGVyXG5cdFx0XHRcdG92ZXJyaWRlTWltZVR5cGU6IGZ1bmN0aW9uKCB0eXBlICkge1xuXHRcdFx0XHRcdGlmICggY29tcGxldGVkID09IG51bGwgKSB7XG5cdFx0XHRcdFx0XHRzLm1pbWVUeXBlID0gdHlwZTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0cmV0dXJuIHRoaXM7XG5cdFx0XHRcdH0sXG5cblx0XHRcdFx0Ly8gU3RhdHVzLWRlcGVuZGVudCBjYWxsYmFja3Ncblx0XHRcdFx0c3RhdHVzQ29kZTogZnVuY3Rpb24oIG1hcCApIHtcblx0XHRcdFx0XHR2YXIgY29kZTtcblx0XHRcdFx0XHRpZiAoIG1hcCApIHtcblx0XHRcdFx0XHRcdGlmICggY29tcGxldGVkICkge1xuXG5cdFx0XHRcdFx0XHRcdC8vIEV4ZWN1dGUgdGhlIGFwcHJvcHJpYXRlIGNhbGxiYWNrc1xuXHRcdFx0XHRcdFx0XHRqcVhIUi5hbHdheXMoIG1hcFsganFYSFIuc3RhdHVzIF0gKTtcblx0XHRcdFx0XHRcdH0gZWxzZSB7XG5cblx0XHRcdFx0XHRcdFx0Ly8gTGF6eS1hZGQgdGhlIG5ldyBjYWxsYmFja3MgaW4gYSB3YXkgdGhhdCBwcmVzZXJ2ZXMgb2xkIG9uZXNcblx0XHRcdFx0XHRcdFx0Zm9yICggY29kZSBpbiBtYXAgKSB7XG5cdFx0XHRcdFx0XHRcdFx0c3RhdHVzQ29kZVsgY29kZSBdID0gWyBzdGF0dXNDb2RlWyBjb2RlIF0sIG1hcFsgY29kZSBdIF07XG5cdFx0XHRcdFx0XHRcdH1cblx0XHRcdFx0XHRcdH1cblx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0cmV0dXJuIHRoaXM7XG5cdFx0XHRcdH0sXG5cblx0XHRcdFx0Ly8gQ2FuY2VsIHRoZSByZXF1ZXN0XG5cdFx0XHRcdGFib3J0OiBmdW5jdGlvbiggc3RhdHVzVGV4dCApIHtcblx0XHRcdFx0XHR2YXIgZmluYWxUZXh0ID0gc3RhdHVzVGV4dCB8fCBzdHJBYm9ydDtcblx0XHRcdFx0XHRpZiAoIHRyYW5zcG9ydCApIHtcblx0XHRcdFx0XHRcdHRyYW5zcG9ydC5hYm9ydCggZmluYWxUZXh0ICk7XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHRcdGRvbmUoIDAsIGZpbmFsVGV4dCApO1xuXHRcdFx0XHRcdHJldHVybiB0aGlzO1xuXHRcdFx0XHR9XG5cdFx0XHR9O1xuXG5cdFx0Ly8gQXR0YWNoIGRlZmVycmVkc1xuXHRcdGRlZmVycmVkLnByb21pc2UoIGpxWEhSICk7XG5cblx0XHQvLyBBZGQgcHJvdG9jb2wgaWYgbm90IHByb3ZpZGVkIChwcmVmaWx0ZXJzIG1pZ2h0IGV4cGVjdCBpdClcblx0XHQvLyBIYW5kbGUgZmFsc3kgdXJsIGluIHRoZSBzZXR0aW5ncyBvYmplY3QgKHRyYWMtMTAwOTM6IGNvbnNpc3RlbmN5IHdpdGggb2xkIHNpZ25hdHVyZSlcblx0XHQvLyBXZSBhbHNvIHVzZSB0aGUgdXJsIHBhcmFtZXRlciBpZiBhdmFpbGFibGVcblx0XHRzLnVybCA9ICggKCB1cmwgfHwgcy51cmwgfHwgbG9jYXRpb24uaHJlZiApICsgXCJcIiApXG5cdFx0XHQucmVwbGFjZSggcnByb3RvY29sLCBsb2NhdGlvbi5wcm90b2NvbCArIFwiLy9cIiApO1xuXG5cdFx0Ly8gQWxpYXMgbWV0aG9kIG9wdGlvbiB0byB0eXBlIGFzIHBlciB0aWNrZXQgdHJhYy0xMjAwNFxuXHRcdHMudHlwZSA9IG9wdGlvbnMubWV0aG9kIHx8IG9wdGlvbnMudHlwZSB8fCBzLm1ldGhvZCB8fCBzLnR5cGU7XG5cblx0XHQvLyBFeHRyYWN0IGRhdGFUeXBlcyBsaXN0XG5cdFx0cy5kYXRhVHlwZXMgPSAoIHMuZGF0YVR5cGUgfHwgXCIqXCIgKS50b0xvd2VyQ2FzZSgpLm1hdGNoKCBybm90aHRtbHdoaXRlICkgfHwgWyBcIlwiIF07XG5cblx0XHQvLyBBIGNyb3NzLWRvbWFpbiByZXF1ZXN0IGlzIGluIG9yZGVyIHdoZW4gdGhlIG9yaWdpbiBkb2Vzbid0IG1hdGNoIHRoZSBjdXJyZW50IG9yaWdpbi5cblx0XHRpZiAoIHMuY3Jvc3NEb21haW4gPT0gbnVsbCApIHtcblx0XHRcdHVybEFuY2hvciA9IGRvY3VtZW50JDEuY3JlYXRlRWxlbWVudCggXCJhXCIgKTtcblxuXHRcdFx0Ly8gU3VwcG9ydDogSUUgPD04IC0gMTErXG5cdFx0XHQvLyBJRSB0aHJvd3MgZXhjZXB0aW9uIG9uIGFjY2Vzc2luZyB0aGUgaHJlZiBwcm9wZXJ0eSBpZiB1cmwgaXMgbWFsZm9ybWVkLFxuXHRcdFx0Ly8gZS5nLiBodHRwOi8vZXhhbXBsZS5jb206ODB4L1xuXHRcdFx0dHJ5IHtcblx0XHRcdFx0dXJsQW5jaG9yLmhyZWYgPSBzLnVybDtcblxuXHRcdFx0XHQvLyBTdXBwb3J0OiBJRSA8PTggLSAxMStcblx0XHRcdFx0Ly8gQW5jaG9yJ3MgaG9zdCBwcm9wZXJ0eSBpc24ndCBjb3JyZWN0bHkgc2V0IHdoZW4gcy51cmwgaXMgcmVsYXRpdmVcblx0XHRcdFx0dXJsQW5jaG9yLmhyZWYgPSB1cmxBbmNob3IuaHJlZjtcblx0XHRcdFx0cy5jcm9zc0RvbWFpbiA9IG9yaWdpbkFuY2hvci5wcm90b2NvbCArIFwiLy9cIiArIG9yaWdpbkFuY2hvci5ob3N0ICE9PVxuXHRcdFx0XHRcdHVybEFuY2hvci5wcm90b2NvbCArIFwiLy9cIiArIHVybEFuY2hvci5ob3N0O1xuXHRcdFx0fSBjYXRjaCAoIGUgKSB7XG5cblx0XHRcdFx0Ly8gSWYgdGhlcmUgaXMgYW4gZXJyb3IgcGFyc2luZyB0aGUgVVJMLCBhc3N1bWUgaXQgaXMgY3Jvc3NEb21haW4sXG5cdFx0XHRcdC8vIGl0IGNhbiBiZSByZWplY3RlZCBieSB0aGUgdHJhbnNwb3J0IGlmIGl0IGlzIGludmFsaWRcblx0XHRcdFx0cy5jcm9zc0RvbWFpbiA9IHRydWU7XG5cdFx0XHR9XG5cdFx0fVxuXG5cdFx0Ly8gQXBwbHkgcHJlZmlsdGVyc1xuXHRcdGluc3BlY3RQcmVmaWx0ZXJzT3JUcmFuc3BvcnRzKCBwcmVmaWx0ZXJzLCBzLCBvcHRpb25zLCBqcVhIUiApO1xuXG5cdFx0Ly8gQ29udmVydCBkYXRhIGlmIG5vdCBhbHJlYWR5IGEgc3RyaW5nXG5cdFx0aWYgKCBzLmRhdGEgJiYgcy5wcm9jZXNzRGF0YSAmJiB0eXBlb2Ygcy5kYXRhICE9PSBcInN0cmluZ1wiICkge1xuXHRcdFx0cy5kYXRhID0galF1ZXJ5LnBhcmFtKCBzLmRhdGEsIHMudHJhZGl0aW9uYWwgKTtcblx0XHR9XG5cblx0XHQvLyBJZiByZXF1ZXN0IHdhcyBhYm9ydGVkIGluc2lkZSBhIHByZWZpbHRlciwgc3RvcCB0aGVyZVxuXHRcdGlmICggY29tcGxldGVkICkge1xuXHRcdFx0cmV0dXJuIGpxWEhSO1xuXHRcdH1cblxuXHRcdC8vIFdlIGNhbiBmaXJlIGdsb2JhbCBldmVudHMgYXMgb2Ygbm93IGlmIGFza2VkIHRvXG5cdFx0Ly8gRG9uJ3QgZmlyZSBldmVudHMgaWYgalF1ZXJ5LmV2ZW50IGlzIHVuZGVmaW5lZCBpbiBhbiBFU00tdXNhZ2Ugc2NlbmFyaW8gKHRyYWMtMTUxMTgpXG5cdFx0ZmlyZUdsb2JhbHMgPSBqUXVlcnkuZXZlbnQgJiYgcy5nbG9iYWw7XG5cblx0XHQvLyBXYXRjaCBmb3IgYSBuZXcgc2V0IG9mIHJlcXVlc3RzXG5cdFx0aWYgKCBmaXJlR2xvYmFscyAmJiBqUXVlcnkuYWN0aXZlKysgPT09IDAgKSB7XG5cdFx0XHRqUXVlcnkuZXZlbnQudHJpZ2dlciggXCJhamF4U3RhcnRcIiApO1xuXHRcdH1cblxuXHRcdC8vIFVwcGVyY2FzZSB0aGUgdHlwZVxuXHRcdHMudHlwZSA9IHMudHlwZS50b1VwcGVyQ2FzZSgpO1xuXG5cdFx0Ly8gRGV0ZXJtaW5lIGlmIHJlcXVlc3QgaGFzIGNvbnRlbnRcblx0XHRzLmhhc0NvbnRlbnQgPSAhcm5vQ29udGVudC50ZXN0KCBzLnR5cGUgKTtcblxuXHRcdC8vIFNhdmUgdGhlIFVSTCBpbiBjYXNlIHdlJ3JlIHRveWluZyB3aXRoIHRoZSBJZi1Nb2RpZmllZC1TaW5jZVxuXHRcdC8vIGFuZC9vciBJZi1Ob25lLU1hdGNoIGhlYWRlciBsYXRlciBvblxuXHRcdC8vIFJlbW92ZSBoYXNoIHRvIHNpbXBsaWZ5IHVybCBtYW5pcHVsYXRpb25cblx0XHRjYWNoZVVSTCA9IHMudXJsLnJlcGxhY2UoIHJoYXNoLCBcIlwiICk7XG5cblx0XHQvLyBNb3JlIG9wdGlvbnMgaGFuZGxpbmcgZm9yIHJlcXVlc3RzIHdpdGggbm8gY29udGVudFxuXHRcdGlmICggIXMuaGFzQ29udGVudCApIHtcblxuXHRcdFx0Ly8gUmVtZW1iZXIgdGhlIGhhc2ggc28gd2UgY2FuIHB1dCBpdCBiYWNrXG5cdFx0XHR1bmNhY2hlZCA9IHMudXJsLnNsaWNlKCBjYWNoZVVSTC5sZW5ndGggKTtcblxuXHRcdFx0Ly8gSWYgZGF0YSBpcyBhdmFpbGFibGUgYW5kIHNob3VsZCBiZSBwcm9jZXNzZWQsIGFwcGVuZCBkYXRhIHRvIHVybFxuXHRcdFx0aWYgKCBzLmRhdGEgJiYgKCBzLnByb2Nlc3NEYXRhIHx8IHR5cGVvZiBzLmRhdGEgPT09IFwic3RyaW5nXCIgKSApIHtcblx0XHRcdFx0Y2FjaGVVUkwgKz0gKCBycXVlcnkudGVzdCggY2FjaGVVUkwgKSA/IFwiJlwiIDogXCI/XCIgKSArIHMuZGF0YTtcblxuXHRcdFx0XHQvLyB0cmFjLTk2ODI6IHJlbW92ZSBkYXRhIHNvIHRoYXQgaXQncyBub3QgdXNlZCBpbiBhbiBldmVudHVhbCByZXRyeVxuXHRcdFx0XHRkZWxldGUgcy5kYXRhO1xuXHRcdFx0fVxuXG5cdFx0XHQvLyBBZGQgb3IgdXBkYXRlIGFudGktY2FjaGUgcGFyYW0gaWYgbmVlZGVkXG5cdFx0XHRpZiAoIHMuY2FjaGUgPT09IGZhbHNlICkge1xuXHRcdFx0XHRjYWNoZVVSTCA9IGNhY2hlVVJMLnJlcGxhY2UoIHJhbnRpQ2FjaGUsIFwiJDFcIiApO1xuXHRcdFx0XHR1bmNhY2hlZCA9ICggcnF1ZXJ5LnRlc3QoIGNhY2hlVVJMICkgPyBcIiZcIiA6IFwiP1wiICkgKyBcIl89XCIgK1xuXHRcdFx0XHRcdCggbm9uY2UuZ3VpZCsrICkgKyB1bmNhY2hlZDtcblx0XHRcdH1cblxuXHRcdFx0Ly8gUHV0IGhhc2ggYW5kIGFudGktY2FjaGUgb24gdGhlIFVSTCB0aGF0IHdpbGwgYmUgcmVxdWVzdGVkIChnaC0xNzMyKVxuXHRcdFx0cy51cmwgPSBjYWNoZVVSTCArIHVuY2FjaGVkO1xuXG5cdFx0Ly8gQ2hhbmdlICclMjAnIHRvICcrJyBpZiB0aGlzIGlzIGVuY29kZWQgZm9ybSBib2R5IGNvbnRlbnQgKGdoLTI2NTgpXG5cdFx0fSBlbHNlIGlmICggcy5kYXRhICYmIHMucHJvY2Vzc0RhdGEgJiZcblx0XHRcdCggcy5jb250ZW50VHlwZSB8fCBcIlwiICkuaW5kZXhPZiggXCJhcHBsaWNhdGlvbi94LXd3dy1mb3JtLXVybGVuY29kZWRcIiApID09PSAwICkge1xuXHRcdFx0cy5kYXRhID0gcy5kYXRhLnJlcGxhY2UoIHIyMCwgXCIrXCIgKTtcblx0XHR9XG5cblx0XHQvLyBTZXQgdGhlIElmLU1vZGlmaWVkLVNpbmNlIGFuZC9vciBJZi1Ob25lLU1hdGNoIGhlYWRlciwgaWYgaW4gaWZNb2RpZmllZCBtb2RlLlxuXHRcdGlmICggcy5pZk1vZGlmaWVkICkge1xuXHRcdFx0aWYgKCBqUXVlcnkubGFzdE1vZGlmaWVkWyBjYWNoZVVSTCBdICkge1xuXHRcdFx0XHRqcVhIUi5zZXRSZXF1ZXN0SGVhZGVyKCBcIklmLU1vZGlmaWVkLVNpbmNlXCIsIGpRdWVyeS5sYXN0TW9kaWZpZWRbIGNhY2hlVVJMIF0gKTtcblx0XHRcdH1cblx0XHRcdGlmICggalF1ZXJ5LmV0YWdbIGNhY2hlVVJMIF0gKSB7XG5cdFx0XHRcdGpxWEhSLnNldFJlcXVlc3RIZWFkZXIoIFwiSWYtTm9uZS1NYXRjaFwiLCBqUXVlcnkuZXRhZ1sgY2FjaGVVUkwgXSApO1xuXHRcdFx0fVxuXHRcdH1cblxuXHRcdC8vIFNldCB0aGUgY29ycmVjdCBoZWFkZXIsIGlmIGRhdGEgaXMgYmVpbmcgc2VudFxuXHRcdGlmICggcy5kYXRhICYmIHMuaGFzQ29udGVudCAmJiBzLmNvbnRlbnRUeXBlICE9PSBmYWxzZSB8fCBvcHRpb25zLmNvbnRlbnRUeXBlICkge1xuXHRcdFx0anFYSFIuc2V0UmVxdWVzdEhlYWRlciggXCJDb250ZW50LVR5cGVcIiwgcy5jb250ZW50VHlwZSApO1xuXHRcdH1cblxuXHRcdC8vIFNldCB0aGUgQWNjZXB0cyBoZWFkZXIgZm9yIHRoZSBzZXJ2ZXIsIGRlcGVuZGluZyBvbiB0aGUgZGF0YVR5cGVcblx0XHRqcVhIUi5zZXRSZXF1ZXN0SGVhZGVyKFxuXHRcdFx0XCJBY2NlcHRcIixcblx0XHRcdHMuZGF0YVR5cGVzWyAwIF0gJiYgcy5hY2NlcHRzWyBzLmRhdGFUeXBlc1sgMCBdIF0gP1xuXHRcdFx0XHRzLmFjY2VwdHNbIHMuZGF0YVR5cGVzWyAwIF0gXSArXG5cdFx0XHRcdFx0KCBzLmRhdGFUeXBlc1sgMCBdICE9PSBcIipcIiA/IFwiLCBcIiArIGFsbFR5cGVzICsgXCI7IHE9MC4wMVwiIDogXCJcIiApIDpcblx0XHRcdFx0cy5hY2NlcHRzWyBcIipcIiBdXG5cdFx0KTtcblxuXHRcdC8vIENoZWNrIGZvciBoZWFkZXJzIG9wdGlvblxuXHRcdGZvciAoIGkgaW4gcy5oZWFkZXJzICkge1xuXHRcdFx0anFYSFIuc2V0UmVxdWVzdEhlYWRlciggaSwgcy5oZWFkZXJzWyBpIF0gKTtcblx0XHR9XG5cblx0XHQvLyBBbGxvdyBjdXN0b20gaGVhZGVycy9taW1ldHlwZXMgYW5kIGVhcmx5IGFib3J0XG5cdFx0aWYgKCBzLmJlZm9yZVNlbmQgJiZcblx0XHRcdCggcy5iZWZvcmVTZW5kLmNhbGwoIGNhbGxiYWNrQ29udGV4dCwganFYSFIsIHMgKSA9PT0gZmFsc2UgfHwgY29tcGxldGVkICkgKSB7XG5cblx0XHRcdC8vIEFib3J0IGlmIG5vdCBkb25lIGFscmVhZHkgYW5kIHJldHVyblxuXHRcdFx0cmV0dXJuIGpxWEhSLmFib3J0KCk7XG5cdFx0fVxuXG5cdFx0Ly8gQWJvcnRpbmcgaXMgbm8gbG9uZ2VyIGEgY2FuY2VsbGF0aW9uXG5cdFx0c3RyQWJvcnQgPSBcImFib3J0XCI7XG5cblx0XHQvLyBJbnN0YWxsIGNhbGxiYWNrcyBvbiBkZWZlcnJlZHNcblx0XHRjb21wbGV0ZURlZmVycmVkLmFkZCggcy5jb21wbGV0ZSApO1xuXHRcdGpxWEhSLmRvbmUoIHMuc3VjY2VzcyApO1xuXHRcdGpxWEhSLmZhaWwoIHMuZXJyb3IgKTtcblxuXHRcdC8vIEdldCB0cmFuc3BvcnRcblx0XHR0cmFuc3BvcnQgPSBpbnNwZWN0UHJlZmlsdGVyc09yVHJhbnNwb3J0cyggdHJhbnNwb3J0cywgcywgb3B0aW9ucywganFYSFIgKTtcblxuXHRcdC8vIElmIG5vIHRyYW5zcG9ydCwgd2UgYXV0by1hYm9ydFxuXHRcdGlmICggIXRyYW5zcG9ydCApIHtcblx0XHRcdGRvbmUoIC0xLCBcIk5vIFRyYW5zcG9ydFwiICk7XG5cdFx0fSBlbHNlIHtcblx0XHRcdGpxWEhSLnJlYWR5U3RhdGUgPSAxO1xuXG5cdFx0XHQvLyBTZW5kIGdsb2JhbCBldmVudFxuXHRcdFx0aWYgKCBmaXJlR2xvYmFscyApIHtcblx0XHRcdFx0Z2xvYmFsRXZlbnRDb250ZXh0LnRyaWdnZXIoIFwiYWpheFNlbmRcIiwgWyBqcVhIUiwgcyBdICk7XG5cdFx0XHR9XG5cblx0XHRcdC8vIElmIHJlcXVlc3Qgd2FzIGFib3J0ZWQgaW5zaWRlIGFqYXhTZW5kLCBzdG9wIHRoZXJlXG5cdFx0XHRpZiAoIGNvbXBsZXRlZCApIHtcblx0XHRcdFx0cmV0dXJuIGpxWEhSO1xuXHRcdFx0fVxuXG5cdFx0XHQvLyBUaW1lb3V0XG5cdFx0XHRpZiAoIHMuYXN5bmMgJiYgcy50aW1lb3V0ID4gMCApIHtcblx0XHRcdFx0dGltZW91dFRpbWVyID0gd2luZG93LnNldFRpbWVvdXQoIGZ1bmN0aW9uKCkge1xuXHRcdFx0XHRcdGpxWEhSLmFib3J0KCBcInRpbWVvdXRcIiApO1xuXHRcdFx0XHR9LCBzLnRpbWVvdXQgKTtcblx0XHRcdH1cblxuXHRcdFx0dHJ5IHtcblx0XHRcdFx0Y29tcGxldGVkID0gZmFsc2U7XG5cdFx0XHRcdHRyYW5zcG9ydC5zZW5kKCByZXF1ZXN0SGVhZGVycywgZG9uZSApO1xuXHRcdFx0fSBjYXRjaCAoIGUgKSB7XG5cblx0XHRcdFx0Ly8gUmV0aHJvdyBwb3N0LWNvbXBsZXRpb24gZXhjZXB0aW9uc1xuXHRcdFx0XHRpZiAoIGNvbXBsZXRlZCApIHtcblx0XHRcdFx0XHR0aHJvdyBlO1xuXHRcdFx0XHR9XG5cblx0XHRcdFx0Ly8gUHJvcGFnYXRlIG90aGVycyBhcyByZXN1bHRzXG5cdFx0XHRcdGRvbmUoIC0xLCBlICk7XG5cdFx0XHR9XG5cdFx0fVxuXG5cdFx0Ly8gQ2FsbGJhY2sgZm9yIHdoZW4gZXZlcnl0aGluZyBpcyBkb25lXG5cdFx0ZnVuY3Rpb24gZG9uZSggc3RhdHVzLCBuYXRpdmVTdGF0dXNUZXh0LCByZXNwb25zZXMsIGhlYWRlcnMgKSB7XG5cdFx0XHR2YXIgaXNTdWNjZXNzLCBzdWNjZXNzLCBlcnJvciwgcmVzcG9uc2UsIG1vZGlmaWVkLFxuXHRcdFx0XHRzdGF0dXNUZXh0ID0gbmF0aXZlU3RhdHVzVGV4dDtcblxuXHRcdFx0Ly8gSWdub3JlIHJlcGVhdCBpbnZvY2F0aW9uc1xuXHRcdFx0aWYgKCBjb21wbGV0ZWQgKSB7XG5cdFx0XHRcdHJldHVybjtcblx0XHRcdH1cblxuXHRcdFx0Y29tcGxldGVkID0gdHJ1ZTtcblxuXHRcdFx0Ly8gQ2xlYXIgdGltZW91dCBpZiBpdCBleGlzdHNcblx0XHRcdGlmICggdGltZW91dFRpbWVyICkge1xuXHRcdFx0XHR3aW5kb3cuY2xlYXJUaW1lb3V0KCB0aW1lb3V0VGltZXIgKTtcblx0XHRcdH1cblxuXHRcdFx0Ly8gRGVyZWZlcmVuY2UgdHJhbnNwb3J0IGZvciBlYXJseSBnYXJiYWdlIGNvbGxlY3Rpb25cblx0XHRcdC8vIChubyBtYXR0ZXIgaG93IGxvbmcgdGhlIGpxWEhSIG9iamVjdCB3aWxsIGJlIHVzZWQpXG5cdFx0XHR0cmFuc3BvcnQgPSB1bmRlZmluZWQ7XG5cblx0XHRcdC8vIENhY2hlIHJlc3BvbnNlIGhlYWRlcnNcblx0XHRcdHJlc3BvbnNlSGVhZGVyc1N0cmluZyA9IGhlYWRlcnMgfHwgXCJcIjtcblxuXHRcdFx0Ly8gU2V0IHJlYWR5U3RhdGVcblx0XHRcdGpxWEhSLnJlYWR5U3RhdGUgPSBzdGF0dXMgPiAwID8gNCA6IDA7XG5cblx0XHRcdC8vIERldGVybWluZSBpZiBzdWNjZXNzZnVsXG5cdFx0XHRpc1N1Y2Nlc3MgPSBzdGF0dXMgPj0gMjAwICYmIHN0YXR1cyA8IDMwMCB8fCBzdGF0dXMgPT09IDMwNDtcblxuXHRcdFx0Ly8gR2V0IHJlc3BvbnNlIGRhdGFcblx0XHRcdGlmICggcmVzcG9uc2VzICkge1xuXHRcdFx0XHRyZXNwb25zZSA9IGFqYXhIYW5kbGVSZXNwb25zZXMoIHMsIGpxWEhSLCByZXNwb25zZXMgKTtcblx0XHRcdH1cblxuXHRcdFx0Ly8gVXNlIGEgbm9vcCBjb252ZXJ0ZXIgZm9yIG1pc3Npbmcgc2NyaXB0IGJ1dCBub3QgaWYganNvbnBcblx0XHRcdGlmICggIWlzU3VjY2VzcyAmJlxuXHRcdFx0XHRqUXVlcnkuaW5BcnJheSggXCJzY3JpcHRcIiwgcy5kYXRhVHlwZXMgKSA+IC0xICYmXG5cdFx0XHRcdGpRdWVyeS5pbkFycmF5KCBcImpzb25cIiwgcy5kYXRhVHlwZXMgKSA8IDAgKSB7XG5cdFx0XHRcdHMuY29udmVydGVyc1sgXCJ0ZXh0IHNjcmlwdFwiIF0gPSBmdW5jdGlvbigpIHt9O1xuXHRcdFx0fVxuXG5cdFx0XHQvLyBDb252ZXJ0IG5vIG1hdHRlciB3aGF0ICh0aGF0IHdheSByZXNwb25zZVhYWCBmaWVsZHMgYXJlIGFsd2F5cyBzZXQpXG5cdFx0XHRyZXNwb25zZSA9IGFqYXhDb252ZXJ0KCBzLCByZXNwb25zZSwganFYSFIsIGlzU3VjY2VzcyApO1xuXG5cdFx0XHQvLyBJZiBzdWNjZXNzZnVsLCBoYW5kbGUgdHlwZSBjaGFpbmluZ1xuXHRcdFx0aWYgKCBpc1N1Y2Nlc3MgKSB7XG5cblx0XHRcdFx0Ly8gU2V0IHRoZSBJZi1Nb2RpZmllZC1TaW5jZSBhbmQvb3IgSWYtTm9uZS1NYXRjaCBoZWFkZXIsIGlmIGluIGlmTW9kaWZpZWQgbW9kZS5cblx0XHRcdFx0aWYgKCBzLmlmTW9kaWZpZWQgKSB7XG5cdFx0XHRcdFx0bW9kaWZpZWQgPSBqcVhIUi5nZXRSZXNwb25zZUhlYWRlciggXCJMYXN0LU1vZGlmaWVkXCIgKTtcblx0XHRcdFx0XHRpZiAoIG1vZGlmaWVkICkge1xuXHRcdFx0XHRcdFx0alF1ZXJ5Lmxhc3RNb2RpZmllZFsgY2FjaGVVUkwgXSA9IG1vZGlmaWVkO1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0XHRtb2RpZmllZCA9IGpxWEhSLmdldFJlc3BvbnNlSGVhZGVyKCBcImV0YWdcIiApO1xuXHRcdFx0XHRcdGlmICggbW9kaWZpZWQgKSB7XG5cdFx0XHRcdFx0XHRqUXVlcnkuZXRhZ1sgY2FjaGVVUkwgXSA9IG1vZGlmaWVkO1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0fVxuXG5cdFx0XHRcdC8vIGlmIG5vIGNvbnRlbnRcblx0XHRcdFx0aWYgKCBzdGF0dXMgPT09IDIwNCB8fCBzLnR5cGUgPT09IFwiSEVBRFwiICkge1xuXHRcdFx0XHRcdHN0YXR1c1RleHQgPSBcIm5vY29udGVudFwiO1xuXG5cdFx0XHRcdC8vIGlmIG5vdCBtb2RpZmllZFxuXHRcdFx0XHR9IGVsc2UgaWYgKCBzdGF0dXMgPT09IDMwNCApIHtcblx0XHRcdFx0XHRzdGF0dXNUZXh0ID0gXCJub3Rtb2RpZmllZFwiO1xuXG5cdFx0XHRcdC8vIElmIHdlIGhhdmUgZGF0YSwgbGV0J3MgY29udmVydCBpdFxuXHRcdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRcdHN0YXR1c1RleHQgPSByZXNwb25zZS5zdGF0ZTtcblx0XHRcdFx0XHRzdWNjZXNzID0gcmVzcG9uc2UuZGF0YTtcblx0XHRcdFx0XHRlcnJvciA9IHJlc3BvbnNlLmVycm9yO1xuXHRcdFx0XHRcdGlzU3VjY2VzcyA9ICFlcnJvcjtcblx0XHRcdFx0fVxuXHRcdFx0fSBlbHNlIHtcblxuXHRcdFx0XHQvLyBFeHRyYWN0IGVycm9yIGZyb20gc3RhdHVzVGV4dCBhbmQgbm9ybWFsaXplIGZvciBub24tYWJvcnRzXG5cdFx0XHRcdGVycm9yID0gc3RhdHVzVGV4dDtcblx0XHRcdFx0aWYgKCBzdGF0dXMgfHwgIXN0YXR1c1RleHQgKSB7XG5cdFx0XHRcdFx0c3RhdHVzVGV4dCA9IFwiZXJyb3JcIjtcblx0XHRcdFx0XHRpZiAoIHN0YXR1cyA8IDAgKSB7XG5cdFx0XHRcdFx0XHRzdGF0dXMgPSAwO1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0fVxuXHRcdFx0fVxuXG5cdFx0XHQvLyBTZXQgZGF0YSBmb3IgdGhlIGZha2UgeGhyIG9iamVjdFxuXHRcdFx0anFYSFIuc3RhdHVzID0gc3RhdHVzO1xuXHRcdFx0anFYSFIuc3RhdHVzVGV4dCA9ICggbmF0aXZlU3RhdHVzVGV4dCB8fCBzdGF0dXNUZXh0ICkgKyBcIlwiO1xuXG5cdFx0XHQvLyBTdWNjZXNzL0Vycm9yXG5cdFx0XHRpZiAoIGlzU3VjY2VzcyApIHtcblx0XHRcdFx0ZGVmZXJyZWQucmVzb2x2ZVdpdGgoIGNhbGxiYWNrQ29udGV4dCwgWyBzdWNjZXNzLCBzdGF0dXNUZXh0LCBqcVhIUiBdICk7XG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRkZWZlcnJlZC5yZWplY3RXaXRoKCBjYWxsYmFja0NvbnRleHQsIFsganFYSFIsIHN0YXR1c1RleHQsIGVycm9yIF0gKTtcblx0XHRcdH1cblxuXHRcdFx0Ly8gU3RhdHVzLWRlcGVuZGVudCBjYWxsYmFja3Ncblx0XHRcdGpxWEhSLnN0YXR1c0NvZGUoIHN0YXR1c0NvZGUgKTtcblx0XHRcdHN0YXR1c0NvZGUgPSB1bmRlZmluZWQ7XG5cblx0XHRcdGlmICggZmlyZUdsb2JhbHMgKSB7XG5cdFx0XHRcdGdsb2JhbEV2ZW50Q29udGV4dC50cmlnZ2VyKCBpc1N1Y2Nlc3MgPyBcImFqYXhTdWNjZXNzXCIgOiBcImFqYXhFcnJvclwiLFxuXHRcdFx0XHRcdFsganFYSFIsIHMsIGlzU3VjY2VzcyA/IHN1Y2Nlc3MgOiBlcnJvciBdICk7XG5cdFx0XHR9XG5cblx0XHRcdC8vIENvbXBsZXRlXG5cdFx0XHRjb21wbGV0ZURlZmVycmVkLmZpcmVXaXRoKCBjYWxsYmFja0NvbnRleHQsIFsganFYSFIsIHN0YXR1c1RleHQgXSApO1xuXG5cdFx0XHRpZiAoIGZpcmVHbG9iYWxzICkge1xuXHRcdFx0XHRnbG9iYWxFdmVudENvbnRleHQudHJpZ2dlciggXCJhamF4Q29tcGxldGVcIiwgWyBqcVhIUiwgcyBdICk7XG5cblx0XHRcdFx0Ly8gSGFuZGxlIHRoZSBnbG9iYWwgQUpBWCBjb3VudGVyXG5cdFx0XHRcdGlmICggISggLS1qUXVlcnkuYWN0aXZlICkgKSB7XG5cdFx0XHRcdFx0alF1ZXJ5LmV2ZW50LnRyaWdnZXIoIFwiYWpheFN0b3BcIiApO1xuXHRcdFx0XHR9XG5cdFx0XHR9XG5cdFx0fVxuXG5cdFx0cmV0dXJuIGpxWEhSO1xuXHR9LFxuXG5cdGdldEpTT046IGZ1bmN0aW9uKCB1cmwsIGRhdGEsIGNhbGxiYWNrICkge1xuXHRcdHJldHVybiBqUXVlcnkuZ2V0KCB1cmwsIGRhdGEsIGNhbGxiYWNrLCBcImpzb25cIiApO1xuXHR9LFxuXG5cdGdldFNjcmlwdDogZnVuY3Rpb24oIHVybCwgY2FsbGJhY2sgKSB7XG5cdFx0cmV0dXJuIGpRdWVyeS5nZXQoIHVybCwgdW5kZWZpbmVkLCBjYWxsYmFjaywgXCJzY3JpcHRcIiApO1xuXHR9XG59ICk7XG5cbmpRdWVyeS5lYWNoKCBbIFwiZ2V0XCIsIFwicG9zdFwiIF0sIGZ1bmN0aW9uKCBfaSwgbWV0aG9kICkge1xuXHRqUXVlcnlbIG1ldGhvZCBdID0gZnVuY3Rpb24oIHVybCwgZGF0YSwgY2FsbGJhY2ssIHR5cGUgKSB7XG5cblx0XHQvLyBTaGlmdCBhcmd1bWVudHMgaWYgZGF0YSBhcmd1bWVudCB3YXMgb21pdHRlZC5cblx0XHQvLyBIYW5kbGUgdGhlIG51bGwgY2FsbGJhY2sgcGxhY2Vob2xkZXIuXG5cdFx0aWYgKCB0eXBlb2YgZGF0YSA9PT0gXCJmdW5jdGlvblwiIHx8IGRhdGEgPT09IG51bGwgKSB7XG5cdFx0XHR0eXBlID0gdHlwZSB8fCBjYWxsYmFjaztcblx0XHRcdGNhbGxiYWNrID0gZGF0YTtcblx0XHRcdGRhdGEgPSB1bmRlZmluZWQ7XG5cdFx0fVxuXG5cdFx0Ly8gVGhlIHVybCBjYW4gYmUgYW4gb3B0aW9ucyBvYmplY3QgKHdoaWNoIHRoZW4gbXVzdCBoYXZlIC51cmwpXG5cdFx0cmV0dXJuIGpRdWVyeS5hamF4KCBqUXVlcnkuZXh0ZW5kKCB7XG5cdFx0XHR1cmw6IHVybCxcblx0XHRcdHR5cGU6IG1ldGhvZCxcblx0XHRcdGRhdGFUeXBlOiB0eXBlLFxuXHRcdFx0ZGF0YTogZGF0YSxcblx0XHRcdHN1Y2Nlc3M6IGNhbGxiYWNrXG5cdFx0fSwgalF1ZXJ5LmlzUGxhaW5PYmplY3QoIHVybCApICYmIHVybCApICk7XG5cdH07XG59ICk7XG5cbmpRdWVyeS5hamF4UHJlZmlsdGVyKCBmdW5jdGlvbiggcyApIHtcblx0dmFyIGk7XG5cdGZvciAoIGkgaW4gcy5oZWFkZXJzICkge1xuXHRcdGlmICggaS50b0xvd2VyQ2FzZSgpID09PSBcImNvbnRlbnQtdHlwZVwiICkge1xuXHRcdFx0cy5jb250ZW50VHlwZSA9IHMuaGVhZGVyc1sgaSBdIHx8IFwiXCI7XG5cdFx0fVxuXHR9XG59ICk7XG5cbmpRdWVyeS5fZXZhbFVybCA9IGZ1bmN0aW9uKCB1cmwsIG9wdGlvbnMsIGRvYyApIHtcblx0cmV0dXJuIGpRdWVyeS5hamF4KCB7XG5cdFx0dXJsOiB1cmwsXG5cblx0XHQvLyBNYWtlIHRoaXMgZXhwbGljaXQsIHNpbmNlIHVzZXIgY2FuIG92ZXJyaWRlIHRoaXMgdGhyb3VnaCBhamF4U2V0dXAgKHRyYWMtMTEyNjQpXG5cdFx0dHlwZTogXCJHRVRcIixcblx0XHRkYXRhVHlwZTogXCJzY3JpcHRcIixcblx0XHRjYWNoZTogdHJ1ZSxcblx0XHRhc3luYzogZmFsc2UsXG5cdFx0Z2xvYmFsOiBmYWxzZSxcblx0XHRzY3JpcHRBdHRyczogb3B0aW9ucy5jcm9zc09yaWdpbiA/IHsgXCJjcm9zc09yaWdpblwiOiBvcHRpb25zLmNyb3NzT3JpZ2luIH0gOiB1bmRlZmluZWQsXG5cblx0XHQvLyBPbmx5IGV2YWx1YXRlIHRoZSByZXNwb25zZSBpZiBpdCBpcyBzdWNjZXNzZnVsIChnaC00MTI2KVxuXHRcdC8vIGRhdGFGaWx0ZXIgaXMgbm90IGludm9rZWQgZm9yIGZhaWx1cmUgcmVzcG9uc2VzLCBzbyB1c2luZyBpdCBpbnN0ZWFkXG5cdFx0Ly8gb2YgdGhlIGRlZmF1bHQgY29udmVydGVyIGlzIGtsdWRneSBidXQgaXQgd29ya3MuXG5cdFx0Y29udmVydGVyczoge1xuXHRcdFx0XCJ0ZXh0IHNjcmlwdFwiOiBmdW5jdGlvbigpIHt9XG5cdFx0fSxcblx0XHRkYXRhRmlsdGVyOiBmdW5jdGlvbiggcmVzcG9uc2UgKSB7XG5cdFx0XHRqUXVlcnkuZ2xvYmFsRXZhbCggcmVzcG9uc2UsIG9wdGlvbnMsIGRvYyApO1xuXHRcdH1cblx0fSApO1xufTtcblxualF1ZXJ5LmZuLmV4dGVuZCgge1xuXHR3cmFwQWxsOiBmdW5jdGlvbiggaHRtbCApIHtcblx0XHR2YXIgd3JhcDtcblxuXHRcdGlmICggdGhpc1sgMCBdICkge1xuXHRcdFx0aWYgKCB0eXBlb2YgaHRtbCA9PT0gXCJmdW5jdGlvblwiICkge1xuXHRcdFx0XHRodG1sID0gaHRtbC5jYWxsKCB0aGlzWyAwIF0gKTtcblx0XHRcdH1cblxuXHRcdFx0Ly8gVGhlIGVsZW1lbnRzIHRvIHdyYXAgdGhlIHRhcmdldCBhcm91bmRcblx0XHRcdHdyYXAgPSBqUXVlcnkoIGh0bWwsIHRoaXNbIDAgXS5vd25lckRvY3VtZW50ICkuZXEoIDAgKS5jbG9uZSggdHJ1ZSApO1xuXG5cdFx0XHRpZiAoIHRoaXNbIDAgXS5wYXJlbnROb2RlICkge1xuXHRcdFx0XHR3cmFwLmluc2VydEJlZm9yZSggdGhpc1sgMCBdICk7XG5cdFx0XHR9XG5cblx0XHRcdHdyYXAubWFwKCBmdW5jdGlvbigpIHtcblx0XHRcdFx0dmFyIGVsZW0gPSB0aGlzO1xuXG5cdFx0XHRcdHdoaWxlICggZWxlbS5maXJzdEVsZW1lbnRDaGlsZCApIHtcblx0XHRcdFx0XHRlbGVtID0gZWxlbS5maXJzdEVsZW1lbnRDaGlsZDtcblx0XHRcdFx0fVxuXG5cdFx0XHRcdHJldHVybiBlbGVtO1xuXHRcdFx0fSApLmFwcGVuZCggdGhpcyApO1xuXHRcdH1cblxuXHRcdHJldHVybiB0aGlzO1xuXHR9LFxuXG5cdHdyYXBJbm5lcjogZnVuY3Rpb24oIGh0bWwgKSB7XG5cdFx0aWYgKCB0eXBlb2YgaHRtbCA9PT0gXCJmdW5jdGlvblwiICkge1xuXHRcdFx0cmV0dXJuIHRoaXMuZWFjaCggZnVuY3Rpb24oIGkgKSB7XG5cdFx0XHRcdGpRdWVyeSggdGhpcyApLndyYXBJbm5lciggaHRtbC5jYWxsKCB0aGlzLCBpICkgKTtcblx0XHRcdH0gKTtcblx0XHR9XG5cblx0XHRyZXR1cm4gdGhpcy5lYWNoKCBmdW5jdGlvbigpIHtcblx0XHRcdHZhciBzZWxmID0galF1ZXJ5KCB0aGlzICksXG5cdFx0XHRcdGNvbnRlbnRzID0gc2VsZi5jb250ZW50cygpO1xuXG5cdFx0XHRpZiAoIGNvbnRlbnRzLmxlbmd0aCApIHtcblx0XHRcdFx0Y29udGVudHMud3JhcEFsbCggaHRtbCApO1xuXG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRzZWxmLmFwcGVuZCggaHRtbCApO1xuXHRcdFx0fVxuXHRcdH0gKTtcblx0fSxcblxuXHR3cmFwOiBmdW5jdGlvbiggaHRtbCApIHtcblx0XHR2YXIgaHRtbElzRnVuY3Rpb24gPSB0eXBlb2YgaHRtbCA9PT0gXCJmdW5jdGlvblwiO1xuXG5cdFx0cmV0dXJuIHRoaXMuZWFjaCggZnVuY3Rpb24oIGkgKSB7XG5cdFx0XHRqUXVlcnkoIHRoaXMgKS53cmFwQWxsKCBodG1sSXNGdW5jdGlvbiA/IGh0bWwuY2FsbCggdGhpcywgaSApIDogaHRtbCApO1xuXHRcdH0gKTtcblx0fSxcblxuXHR1bndyYXA6IGZ1bmN0aW9uKCBzZWxlY3RvciApIHtcblx0XHR0aGlzLnBhcmVudCggc2VsZWN0b3IgKS5ub3QoIFwiYm9keVwiICkuZWFjaCggZnVuY3Rpb24oKSB7XG5cdFx0XHRqUXVlcnkoIHRoaXMgKS5yZXBsYWNlV2l0aCggdGhpcy5jaGlsZE5vZGVzICk7XG5cdFx0fSApO1xuXHRcdHJldHVybiB0aGlzO1xuXHR9XG59ICk7XG5cbmpRdWVyeS5leHByLnBzZXVkb3MuaGlkZGVuID0gZnVuY3Rpb24oIGVsZW0gKSB7XG5cdHJldHVybiAhalF1ZXJ5LmV4cHIucHNldWRvcy52aXNpYmxlKCBlbGVtICk7XG59O1xualF1ZXJ5LmV4cHIucHNldWRvcy52aXNpYmxlID0gZnVuY3Rpb24oIGVsZW0gKSB7XG5cdHJldHVybiAhISggZWxlbS5vZmZzZXRXaWR0aCB8fCBlbGVtLm9mZnNldEhlaWdodCB8fCBlbGVtLmdldENsaWVudFJlY3RzKCkubGVuZ3RoICk7XG59O1xuXG5qUXVlcnkuYWpheFNldHRpbmdzLnhociA9IGZ1bmN0aW9uKCkge1xuXHRyZXR1cm4gbmV3IHdpbmRvdy5YTUxIdHRwUmVxdWVzdCgpO1xufTtcblxudmFyIHhoclN1Y2Nlc3NTdGF0dXMgPSB7XG5cblx0Ly8gRmlsZSBwcm90b2NvbCBhbHdheXMgeWllbGRzIHN0YXR1cyBjb2RlIDAsIGFzc3VtZSAyMDBcblx0MDogMjAwXG59O1xuXG5qUXVlcnkuYWpheFRyYW5zcG9ydCggZnVuY3Rpb24oIG9wdGlvbnMgKSB7XG5cdHZhciBjYWxsYmFjaztcblxuXHRyZXR1cm4ge1xuXHRcdHNlbmQ6IGZ1bmN0aW9uKCBoZWFkZXJzLCBjb21wbGV0ZSApIHtcblx0XHRcdHZhciBpLFxuXHRcdFx0XHR4aHIgPSBvcHRpb25zLnhocigpO1xuXG5cdFx0XHR4aHIub3Blbihcblx0XHRcdFx0b3B0aW9ucy50eXBlLFxuXHRcdFx0XHRvcHRpb25zLnVybCxcblx0XHRcdFx0b3B0aW9ucy5hc3luYyxcblx0XHRcdFx0b3B0aW9ucy51c2VybmFtZSxcblx0XHRcdFx0b3B0aW9ucy5wYXNzd29yZFxuXHRcdFx0KTtcblxuXHRcdFx0Ly8gQXBwbHkgY3VzdG9tIGZpZWxkcyBpZiBwcm92aWRlZFxuXHRcdFx0aWYgKCBvcHRpb25zLnhockZpZWxkcyApIHtcblx0XHRcdFx0Zm9yICggaSBpbiBvcHRpb25zLnhockZpZWxkcyApIHtcblx0XHRcdFx0XHR4aHJbIGkgXSA9IG9wdGlvbnMueGhyRmllbGRzWyBpIF07XG5cdFx0XHRcdH1cblx0XHRcdH1cblxuXHRcdFx0Ly8gT3ZlcnJpZGUgbWltZSB0eXBlIGlmIG5lZWRlZFxuXHRcdFx0aWYgKCBvcHRpb25zLm1pbWVUeXBlICYmIHhoci5vdmVycmlkZU1pbWVUeXBlICkge1xuXHRcdFx0XHR4aHIub3ZlcnJpZGVNaW1lVHlwZSggb3B0aW9ucy5taW1lVHlwZSApO1xuXHRcdFx0fVxuXG5cdFx0XHQvLyBYLVJlcXVlc3RlZC1XaXRoIGhlYWRlclxuXHRcdFx0Ly8gRm9yIGNyb3NzLWRvbWFpbiByZXF1ZXN0cywgc2VlaW5nIGFzIGNvbmRpdGlvbnMgZm9yIGEgcHJlZmxpZ2h0IGFyZVxuXHRcdFx0Ly8gYWtpbiB0byBhIGppZ3NhdyBwdXp6bGUsIHdlIHNpbXBseSBuZXZlciBzZXQgaXQgdG8gYmUgc3VyZS5cblx0XHRcdC8vIChpdCBjYW4gYWx3YXlzIGJlIHNldCBvbiBhIHBlci1yZXF1ZXN0IGJhc2lzIG9yIGV2ZW4gdXNpbmcgYWpheFNldHVwKVxuXHRcdFx0Ly8gRm9yIHNhbWUtZG9tYWluIHJlcXVlc3RzLCB3b24ndCBjaGFuZ2UgaGVhZGVyIGlmIGFscmVhZHkgcHJvdmlkZWQuXG5cdFx0XHRpZiAoICFvcHRpb25zLmNyb3NzRG9tYWluICYmICFoZWFkZXJzWyBcIlgtUmVxdWVzdGVkLVdpdGhcIiBdICkge1xuXHRcdFx0XHRoZWFkZXJzWyBcIlgtUmVxdWVzdGVkLVdpdGhcIiBdID0gXCJYTUxIdHRwUmVxdWVzdFwiO1xuXHRcdFx0fVxuXG5cdFx0XHQvLyBTZXQgaGVhZGVyc1xuXHRcdFx0Zm9yICggaSBpbiBoZWFkZXJzICkge1xuXHRcdFx0XHR4aHIuc2V0UmVxdWVzdEhlYWRlciggaSwgaGVhZGVyc1sgaSBdICk7XG5cdFx0XHR9XG5cblx0XHRcdC8vIENhbGxiYWNrXG5cdFx0XHRjYWxsYmFjayA9IGZ1bmN0aW9uKCB0eXBlICkge1xuXHRcdFx0XHRyZXR1cm4gZnVuY3Rpb24oKSB7XG5cdFx0XHRcdFx0aWYgKCBjYWxsYmFjayApIHtcblx0XHRcdFx0XHRcdGNhbGxiYWNrID0geGhyLm9ubG9hZCA9IHhoci5vbmVycm9yID0geGhyLm9uYWJvcnQgPSB4aHIub250aW1lb3V0ID0gbnVsbDtcblxuXHRcdFx0XHRcdFx0aWYgKCB0eXBlID09PSBcImFib3J0XCIgKSB7XG5cdFx0XHRcdFx0XHRcdHhoci5hYm9ydCgpO1xuXHRcdFx0XHRcdFx0fSBlbHNlIGlmICggdHlwZSA9PT0gXCJlcnJvclwiICkge1xuXHRcdFx0XHRcdFx0XHRjb21wbGV0ZShcblxuXHRcdFx0XHRcdFx0XHRcdC8vIEZpbGU6IHByb3RvY29sIGFsd2F5cyB5aWVsZHMgc3RhdHVzIDA7IHNlZSB0cmFjLTg2MDUsIHRyYWMtMTQyMDdcblx0XHRcdFx0XHRcdFx0XHR4aHIuc3RhdHVzLFxuXHRcdFx0XHRcdFx0XHRcdHhoci5zdGF0dXNUZXh0XG5cdFx0XHRcdFx0XHRcdCk7XG5cdFx0XHRcdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRcdFx0XHRjb21wbGV0ZShcblx0XHRcdFx0XHRcdFx0XHR4aHJTdWNjZXNzU3RhdHVzWyB4aHIuc3RhdHVzIF0gfHwgeGhyLnN0YXR1cyxcblx0XHRcdFx0XHRcdFx0XHR4aHIuc3RhdHVzVGV4dCxcblxuXHRcdFx0XHRcdFx0XHRcdC8vIEZvciBYSFIyIG5vbi10ZXh0LCBsZXQgdGhlIGNhbGxlciBoYW5kbGUgaXQgKGdoLTI0OTgpXG5cdFx0XHRcdFx0XHRcdFx0KCB4aHIucmVzcG9uc2VUeXBlIHx8IFwidGV4dFwiICkgPT09IFwidGV4dFwiID9cblx0XHRcdFx0XHRcdFx0XHRcdHsgdGV4dDogeGhyLnJlc3BvbnNlVGV4dCB9IDpcblx0XHRcdFx0XHRcdFx0XHRcdHsgYmluYXJ5OiB4aHIucmVzcG9uc2UgfSxcblx0XHRcdFx0XHRcdFx0XHR4aHIuZ2V0QWxsUmVzcG9uc2VIZWFkZXJzKClcblx0XHRcdFx0XHRcdFx0KTtcblx0XHRcdFx0XHRcdH1cblx0XHRcdFx0XHR9XG5cdFx0XHRcdH07XG5cdFx0XHR9O1xuXG5cdFx0XHQvLyBMaXN0ZW4gdG8gZXZlbnRzXG5cdFx0XHR4aHIub25sb2FkID0gY2FsbGJhY2soKTtcblx0XHRcdHhoci5vbmFib3J0ID0geGhyLm9uZXJyb3IgPSB4aHIub250aW1lb3V0ID0gY2FsbGJhY2soIFwiZXJyb3JcIiApO1xuXG5cdFx0XHQvLyBDcmVhdGUgdGhlIGFib3J0IGNhbGxiYWNrXG5cdFx0XHRjYWxsYmFjayA9IGNhbGxiYWNrKCBcImFib3J0XCIgKTtcblxuXHRcdFx0dHJ5IHtcblxuXHRcdFx0XHQvLyBEbyBzZW5kIHRoZSByZXF1ZXN0ICh0aGlzIG1heSByYWlzZSBhbiBleGNlcHRpb24pXG5cdFx0XHRcdHhoci5zZW5kKCBvcHRpb25zLmhhc0NvbnRlbnQgJiYgb3B0aW9ucy5kYXRhIHx8IG51bGwgKTtcblx0XHRcdH0gY2F0Y2ggKCBlICkge1xuXG5cdFx0XHRcdC8vIHRyYWMtMTQ2ODM6IE9ubHkgcmV0aHJvdyBpZiB0aGlzIGhhc24ndCBiZWVuIG5vdGlmaWVkIGFzIGFuIGVycm9yIHlldFxuXHRcdFx0XHRpZiAoIGNhbGxiYWNrICkge1xuXHRcdFx0XHRcdHRocm93IGU7XG5cdFx0XHRcdH1cblx0XHRcdH1cblx0XHR9LFxuXG5cdFx0YWJvcnQ6IGZ1bmN0aW9uKCkge1xuXHRcdFx0aWYgKCBjYWxsYmFjayApIHtcblx0XHRcdFx0Y2FsbGJhY2soKTtcblx0XHRcdH1cblx0XHR9XG5cdH07XG59ICk7XG5cbmZ1bmN0aW9uIGNhblVzZVNjcmlwdFRhZyggcyApIHtcblxuXHQvLyBBIHNjcmlwdCB0YWcgY2FuIG9ubHkgYmUgdXNlZCBmb3IgYXN5bmMsIGNyb3NzIGRvbWFpbiBvciBmb3JjZWQtYnktYXR0cnMgcmVxdWVzdHMuXG5cdC8vIFJlcXVlc3RzIHdpdGggaGVhZGVycyBjYW5ub3QgdXNlIGEgc2NyaXB0IHRhZy4gSG93ZXZlciwgd2hlbiBib3RoIGBzY3JpcHRBdHRyc2AgJlxuXHQvLyBgaGVhZGVyc2Agb3B0aW9ucyBhcmUgc3BlY2lmaWVkLCBib3RoIGFyZSBpbXBvc3NpYmxlIHRvIHNhdGlzZnkgdG9nZXRoZXI7IHdlXG5cdC8vIHByZWZlciBgc2NyaXB0QXR0cnNgIHRoZW4uXG5cdC8vIFN5bmMgcmVxdWVzdHMgcmVtYWluIGhhbmRsZWQgZGlmZmVyZW50bHkgdG8gcHJlc2VydmUgc3RyaWN0IHNjcmlwdCBvcmRlcmluZy5cblx0cmV0dXJuIHMuc2NyaXB0QXR0cnMgfHwgKFxuXHRcdCFzLmhlYWRlcnMgJiZcblx0XHQoXG5cdFx0XHRzLmNyb3NzRG9tYWluIHx8XG5cblx0XHRcdC8vIFdoZW4gZGVhbGluZyB3aXRoIEpTT05QIChgcy5kYXRhVHlwZXNgIGluY2x1ZGUgXCJqc29uXCIgdGhlbilcblx0XHRcdC8vIGRvbid0IHVzZSBhIHNjcmlwdCB0YWcgc28gdGhhdCBlcnJvciByZXNwb25zZXMgc3RpbGwgbWF5IGhhdmVcblx0XHRcdC8vIGByZXNwb25zZUpTT05gIHNldC4gQ29udGludWUgdXNpbmcgYSBzY3JpcHQgdGFnIGZvciBKU09OUCByZXF1ZXN0cyB0aGF0OlxuXHRcdFx0Ly8gICAqIGFyZSBjcm9zcy1kb21haW4gYXMgQUpBWCByZXF1ZXN0cyB3b24ndCB3b3JrIHdpdGhvdXQgYSBDT1JTIHNldHVwXG5cdFx0XHQvLyAgICogaGF2ZSBgc2NyaXB0QXR0cnNgIHNldCBhcyB0aGF0J3MgYSBzY3JpcHQtb25seSBmdW5jdGlvbmFsaXR5XG5cdFx0XHQvLyBOb3RlIHRoYXQgdGhpcyBtZWFucyBKU09OUCByZXF1ZXN0cyB2aW9sYXRlIHN0cmljdCBDU1Agc2NyaXB0LXNyYyBzZXR0aW5ncy5cblx0XHRcdC8vIEEgcHJvcGVyIHNvbHV0aW9uIGlzIHRvIG1pZ3JhdGUgZnJvbSB1c2luZyBKU09OUCB0byBhIENPUlMgc2V0dXAuXG5cdFx0XHQoIHMuYXN5bmMgJiYgalF1ZXJ5LmluQXJyYXkoIFwianNvblwiLCBzLmRhdGFUeXBlcyApIDwgMCApXG5cdFx0KVxuXHQpO1xufVxuXG4vLyBJbnN0YWxsIHNjcmlwdCBkYXRhVHlwZS4gRG9uJ3Qgc3BlY2lmeSBgY29udGVudHMuc2NyaXB0YCBzbyB0aGF0IGFuIGV4cGxpY2l0XG4vLyBgZGF0YVR5cGU6IFwic2NyaXB0XCJgIGlzIHJlcXVpcmVkIChzZWUgZ2gtMjQzMiwgZ2gtNDgyMilcbmpRdWVyeS5hamF4U2V0dXAoIHtcblx0YWNjZXB0czoge1xuXHRcdHNjcmlwdDogXCJ0ZXh0L2phdmFzY3JpcHQsIGFwcGxpY2F0aW9uL2phdmFzY3JpcHQsIFwiICtcblx0XHRcdFwiYXBwbGljYXRpb24vZWNtYXNjcmlwdCwgYXBwbGljYXRpb24veC1lY21hc2NyaXB0XCJcblx0fSxcblx0Y29udmVydGVyczoge1xuXHRcdFwidGV4dCBzY3JpcHRcIjogZnVuY3Rpb24oIHRleHQgKSB7XG5cdFx0XHRqUXVlcnkuZ2xvYmFsRXZhbCggdGV4dCApO1xuXHRcdFx0cmV0dXJuIHRleHQ7XG5cdFx0fVxuXHR9XG59ICk7XG5cbi8vIEhhbmRsZSBjYWNoZSdzIHNwZWNpYWwgY2FzZSBhbmQgY3Jvc3NEb21haW5cbmpRdWVyeS5hamF4UHJlZmlsdGVyKCBcInNjcmlwdFwiLCBmdW5jdGlvbiggcyApIHtcblx0aWYgKCBzLmNhY2hlID09PSB1bmRlZmluZWQgKSB7XG5cdFx0cy5jYWNoZSA9IGZhbHNlO1xuXHR9XG5cblx0Ly8gVGhlc2UgdHlwZXMgb2YgcmVxdWVzdHMgYXJlIGhhbmRsZWQgdmlhIGEgc2NyaXB0IHRhZ1xuXHQvLyBzbyBmb3JjZSB0aGVpciBtZXRob2RzIHRvIEdFVC5cblx0aWYgKCBjYW5Vc2VTY3JpcHRUYWcoIHMgKSApIHtcblx0XHRzLnR5cGUgPSBcIkdFVFwiO1xuXHR9XG59ICk7XG5cbi8vIEJpbmQgc2NyaXB0IHRhZyBoYWNrIHRyYW5zcG9ydFxualF1ZXJ5LmFqYXhUcmFuc3BvcnQoIFwic2NyaXB0XCIsIGZ1bmN0aW9uKCBzICkge1xuXHRpZiAoIGNhblVzZVNjcmlwdFRhZyggcyApICkge1xuXHRcdHZhciBzY3JpcHQsIGNhbGxiYWNrO1xuXHRcdHJldHVybiB7XG5cdFx0XHRzZW5kOiBmdW5jdGlvbiggXywgY29tcGxldGUgKSB7XG5cdFx0XHRcdHNjcmlwdCA9IGpRdWVyeSggXCI8c2NyaXB0PlwiIClcblx0XHRcdFx0XHQuYXR0ciggcy5zY3JpcHRBdHRycyB8fCB7fSApXG5cdFx0XHRcdFx0LnByb3AoIHsgY2hhcnNldDogcy5zY3JpcHRDaGFyc2V0LCBzcmM6IHMudXJsIH0gKVxuXHRcdFx0XHRcdC5vbiggXCJsb2FkIGVycm9yXCIsIGNhbGxiYWNrID0gZnVuY3Rpb24oIGV2dCApIHtcblx0XHRcdFx0XHRcdHNjcmlwdC5yZW1vdmUoKTtcblx0XHRcdFx0XHRcdGNhbGxiYWNrID0gbnVsbDtcblx0XHRcdFx0XHRcdGlmICggZXZ0ICkge1xuXHRcdFx0XHRcdFx0XHRjb21wbGV0ZSggZXZ0LnR5cGUgPT09IFwiZXJyb3JcIiA/IDQwNCA6IDIwMCwgZXZ0LnR5cGUgKTtcblx0XHRcdFx0XHRcdH1cblx0XHRcdFx0XHR9ICk7XG5cblx0XHRcdFx0Ly8gVXNlIG5hdGl2ZSBET00gbWFuaXB1bGF0aW9uIHRvIGF2b2lkIG91ciBkb21NYW5pcCBBSkFYIHRyaWNrZXJ5XG5cdFx0XHRcdGRvY3VtZW50JDEuaGVhZC5hcHBlbmRDaGlsZCggc2NyaXB0WyAwIF0gKTtcblx0XHRcdH0sXG5cdFx0XHRhYm9ydDogZnVuY3Rpb24oKSB7XG5cdFx0XHRcdGlmICggY2FsbGJhY2sgKSB7XG5cdFx0XHRcdFx0Y2FsbGJhY2soKTtcblx0XHRcdFx0fVxuXHRcdFx0fVxuXHRcdH07XG5cdH1cbn0gKTtcblxudmFyIG9sZENhbGxiYWNrcyA9IFtdLFxuXHRyanNvbnAgPSAvKD0pXFw/KD89JnwkKXxcXD9cXD8vO1xuXG4vLyBEZWZhdWx0IGpzb25wIHNldHRpbmdzXG5qUXVlcnkuYWpheFNldHVwKCB7XG5cdGpzb25wOiBcImNhbGxiYWNrXCIsXG5cdGpzb25wQ2FsbGJhY2s6IGZ1bmN0aW9uKCkge1xuXHRcdHZhciBjYWxsYmFjayA9IG9sZENhbGxiYWNrcy5wb3AoKSB8fCAoIGpRdWVyeS5leHBhbmRvICsgXCJfXCIgKyAoIG5vbmNlLmd1aWQrKyApICk7XG5cdFx0dGhpc1sgY2FsbGJhY2sgXSA9IHRydWU7XG5cdFx0cmV0dXJuIGNhbGxiYWNrO1xuXHR9XG59ICk7XG5cbi8vIERldGVjdCwgbm9ybWFsaXplIG9wdGlvbnMgYW5kIGluc3RhbGwgY2FsbGJhY2tzIGZvciBqc29ucCByZXF1ZXN0c1xualF1ZXJ5LmFqYXhQcmVmaWx0ZXIoIFwianNvbnBcIiwgZnVuY3Rpb24oIHMsIG9yaWdpbmFsU2V0dGluZ3MsIGpxWEhSICkge1xuXG5cdHZhciBjYWxsYmFja05hbWUsIG92ZXJ3cml0dGVuLCByZXNwb25zZUNvbnRhaW5lcixcblx0XHRqc29uUHJvcCA9IHMuanNvbnAgIT09IGZhbHNlICYmICggcmpzb25wLnRlc3QoIHMudXJsICkgP1xuXHRcdFx0XCJ1cmxcIiA6XG5cdFx0XHR0eXBlb2Ygcy5kYXRhID09PSBcInN0cmluZ1wiICYmXG5cdFx0XHRcdCggcy5jb250ZW50VHlwZSB8fCBcIlwiIClcblx0XHRcdFx0XHQuaW5kZXhPZiggXCJhcHBsaWNhdGlvbi94LXd3dy1mb3JtLXVybGVuY29kZWRcIiApID09PSAwICYmXG5cdFx0XHRcdHJqc29ucC50ZXN0KCBzLmRhdGEgKSAmJiBcImRhdGFcIlxuXHRcdCk7XG5cblx0Ly8gR2V0IGNhbGxiYWNrIG5hbWUsIHJlbWVtYmVyaW5nIHByZWV4aXN0aW5nIHZhbHVlIGFzc29jaWF0ZWQgd2l0aCBpdFxuXHRjYWxsYmFja05hbWUgPSBzLmpzb25wQ2FsbGJhY2sgPSB0eXBlb2Ygcy5qc29ucENhbGxiYWNrID09PSBcImZ1bmN0aW9uXCIgP1xuXHRcdHMuanNvbnBDYWxsYmFjaygpIDpcblx0XHRzLmpzb25wQ2FsbGJhY2s7XG5cblx0Ly8gSW5zZXJ0IGNhbGxiYWNrIGludG8gdXJsIG9yIGZvcm0gZGF0YVxuXHRpZiAoIGpzb25Qcm9wICkge1xuXHRcdHNbIGpzb25Qcm9wIF0gPSBzWyBqc29uUHJvcCBdLnJlcGxhY2UoIHJqc29ucCwgXCIkMVwiICsgY2FsbGJhY2tOYW1lICk7XG5cdH0gZWxzZSBpZiAoIHMuanNvbnAgIT09IGZhbHNlICkge1xuXHRcdHMudXJsICs9ICggcnF1ZXJ5LnRlc3QoIHMudXJsICkgPyBcIiZcIiA6IFwiP1wiICkgKyBzLmpzb25wICsgXCI9XCIgKyBjYWxsYmFja05hbWU7XG5cdH1cblxuXHQvLyBVc2UgZGF0YSBjb252ZXJ0ZXIgdG8gcmV0cmlldmUganNvbiBhZnRlciBzY3JpcHQgZXhlY3V0aW9uXG5cdHMuY29udmVydGVyc1sgXCJzY3JpcHQganNvblwiIF0gPSBmdW5jdGlvbigpIHtcblx0XHRpZiAoICFyZXNwb25zZUNvbnRhaW5lciApIHtcblx0XHRcdGpRdWVyeS5lcnJvciggY2FsbGJhY2tOYW1lICsgXCIgd2FzIG5vdCBjYWxsZWRcIiApO1xuXHRcdH1cblx0XHRyZXR1cm4gcmVzcG9uc2VDb250YWluZXJbIDAgXTtcblx0fTtcblxuXHQvLyBGb3JjZSBqc29uIGRhdGFUeXBlXG5cdHMuZGF0YVR5cGVzWyAwIF0gPSBcImpzb25cIjtcblxuXHQvLyBJbnN0YWxsIGNhbGxiYWNrXG5cdG92ZXJ3cml0dGVuID0gd2luZG93WyBjYWxsYmFja05hbWUgXTtcblx0d2luZG93WyBjYWxsYmFja05hbWUgXSA9IGZ1bmN0aW9uKCkge1xuXHRcdHJlc3BvbnNlQ29udGFpbmVyID0gYXJndW1lbnRzO1xuXHR9O1xuXG5cdC8vIENsZWFuLXVwIGZ1bmN0aW9uIChmaXJlcyBhZnRlciBjb252ZXJ0ZXJzKVxuXHRqcVhIUi5hbHdheXMoIGZ1bmN0aW9uKCkge1xuXG5cdFx0Ly8gSWYgcHJldmlvdXMgdmFsdWUgZGlkbid0IGV4aXN0IC0gcmVtb3ZlIGl0XG5cdFx0aWYgKCBvdmVyd3JpdHRlbiA9PT0gdW5kZWZpbmVkICkge1xuXHRcdFx0alF1ZXJ5KCB3aW5kb3cgKS5yZW1vdmVQcm9wKCBjYWxsYmFja05hbWUgKTtcblxuXHRcdC8vIE90aGVyd2lzZSByZXN0b3JlIHByZWV4aXN0aW5nIHZhbHVlXG5cdFx0fSBlbHNlIHtcblx0XHRcdHdpbmRvd1sgY2FsbGJhY2tOYW1lIF0gPSBvdmVyd3JpdHRlbjtcblx0XHR9XG5cblx0XHQvLyBTYXZlIGJhY2sgYXMgZnJlZVxuXHRcdGlmICggc1sgY2FsbGJhY2tOYW1lIF0gKSB7XG5cblx0XHRcdC8vIE1ha2Ugc3VyZSB0aGF0IHJlLXVzaW5nIHRoZSBvcHRpb25zIGRvZXNuJ3Qgc2NyZXcgdGhpbmdzIGFyb3VuZFxuXHRcdFx0cy5qc29ucENhbGxiYWNrID0gb3JpZ2luYWxTZXR0aW5ncy5qc29ucENhbGxiYWNrO1xuXG5cdFx0XHQvLyBTYXZlIHRoZSBjYWxsYmFjayBuYW1lIGZvciBmdXR1cmUgdXNlXG5cdFx0XHRvbGRDYWxsYmFja3MucHVzaCggY2FsbGJhY2tOYW1lICk7XG5cdFx0fVxuXG5cdFx0Ly8gQ2FsbCBpZiBpdCB3YXMgYSBmdW5jdGlvbiBhbmQgd2UgaGF2ZSBhIHJlc3BvbnNlXG5cdFx0aWYgKCByZXNwb25zZUNvbnRhaW5lciAmJiB0eXBlb2Ygb3ZlcndyaXR0ZW4gPT09IFwiZnVuY3Rpb25cIiApIHtcblx0XHRcdG92ZXJ3cml0dGVuKCByZXNwb25zZUNvbnRhaW5lclsgMCBdICk7XG5cdFx0fVxuXG5cdFx0cmVzcG9uc2VDb250YWluZXIgPSBvdmVyd3JpdHRlbiA9IHVuZGVmaW5lZDtcblx0fSApO1xuXG5cdC8vIERlbGVnYXRlIHRvIHNjcmlwdFxuXHRyZXR1cm4gXCJzY3JpcHRcIjtcbn0gKTtcblxualF1ZXJ5LmFqYXhQcmVmaWx0ZXIoIGZ1bmN0aW9uKCBzLCBvcmlnT3B0aW9ucyApIHtcblxuXHQvLyBCaW5hcnkgZGF0YSBuZWVkcyB0byBiZSBwYXNzZWQgdG8gWEhSIGFzLWlzIHdpdGhvdXQgc3RyaW5naWZpY2F0aW9uLlxuXHRpZiAoIHR5cGVvZiBzLmRhdGEgIT09IFwic3RyaW5nXCIgJiYgIWpRdWVyeS5pc1BsYWluT2JqZWN0KCBzLmRhdGEgKSAmJlxuXHRcdFx0IUFycmF5LmlzQXJyYXkoIHMuZGF0YSApICYmXG5cblx0XHRcdC8vIERvbid0IGRpc2FibGUgZGF0YSBwcm9jZXNzaW5nIGlmIGV4cGxpY2l0bHkgc2V0IGJ5IHRoZSB1c2VyLlxuXHRcdFx0ISggXCJwcm9jZXNzRGF0YVwiIGluIG9yaWdPcHRpb25zICkgKSB7XG5cdFx0cy5wcm9jZXNzRGF0YSA9IGZhbHNlO1xuXHR9XG5cblx0Ly8gYENvbnRlbnQtVHlwZWAgZm9yIHJlcXVlc3RzIHdpdGggYEZvcm1EYXRhYCBib2RpZXMgbmVlZHMgdG8gYmUgc2V0XG5cdC8vIGJ5IHRoZSBicm93c2VyIGFzIGl0IG5lZWRzIHRvIGFwcGVuZCB0aGUgYGJvdW5kYXJ5YCBpdCBnZW5lcmF0ZWQuXG5cdGlmICggcy5kYXRhIGluc3RhbmNlb2Ygd2luZG93LkZvcm1EYXRhICkge1xuXHRcdHMuY29udGVudFR5cGUgPSBmYWxzZTtcblx0fVxufSApO1xuXG4vLyBBcmd1bWVudCBcImRhdGFcIiBzaG91bGQgYmUgc3RyaW5nIG9mIGh0bWwgb3IgYSBUcnVzdGVkSFRNTCB3cmFwcGVyIG9mIG9idmlvdXMgSFRNTFxuLy8gY29udGV4dCAob3B0aW9uYWwpOiBJZiBzcGVjaWZpZWQsIHRoZSBmcmFnbWVudCB3aWxsIGJlIGNyZWF0ZWQgaW4gdGhpcyBjb250ZXh0LFxuLy8gZGVmYXVsdHMgdG8gZG9jdW1lbnRcbi8vIGtlZXBTY3JpcHRzIChvcHRpb25hbCk6IElmIHRydWUsIHdpbGwgaW5jbHVkZSBzY3JpcHRzIHBhc3NlZCBpbiB0aGUgaHRtbCBzdHJpbmdcbmpRdWVyeS5wYXJzZUhUTUwgPSBmdW5jdGlvbiggZGF0YSwgY29udGV4dCwga2VlcFNjcmlwdHMgKSB7XG5cdGlmICggdHlwZW9mIGRhdGEgIT09IFwic3RyaW5nXCIgJiYgIWlzT2J2aW91c0h0bWwoIGRhdGEgKyBcIlwiICkgKSB7XG5cdFx0cmV0dXJuIFtdO1xuXHR9XG5cdGlmICggdHlwZW9mIGNvbnRleHQgPT09IFwiYm9vbGVhblwiICkge1xuXHRcdGtlZXBTY3JpcHRzID0gY29udGV4dDtcblx0XHRjb250ZXh0ID0gZmFsc2U7XG5cdH1cblxuXHR2YXIgcGFyc2VkLCBzY3JpcHRzO1xuXG5cdGlmICggIWNvbnRleHQgKSB7XG5cblx0XHQvLyBTdG9wIHNjcmlwdHMgb3IgaW5saW5lIGV2ZW50IGhhbmRsZXJzIGZyb20gYmVpbmcgZXhlY3V0ZWQgaW1tZWRpYXRlbHlcblx0XHQvLyBieSB1c2luZyBET01QYXJzZXJcblx0XHRjb250ZXh0ID0gKCBuZXcgd2luZG93LkRPTVBhcnNlcigpIClcblx0XHRcdC5wYXJzZUZyb21TdHJpbmcoIFwiXCIsIFwidGV4dC9odG1sXCIgKTtcblx0fVxuXG5cdHBhcnNlZCA9IHJzaW5nbGVUYWcuZXhlYyggZGF0YSApO1xuXHRzY3JpcHRzID0gIWtlZXBTY3JpcHRzICYmIFtdO1xuXG5cdC8vIFNpbmdsZSB0YWdcblx0aWYgKCBwYXJzZWQgKSB7XG5cdFx0cmV0dXJuIFsgY29udGV4dC5jcmVhdGVFbGVtZW50KCBwYXJzZWRbIDEgXSApIF07XG5cdH1cblxuXHRwYXJzZWQgPSBidWlsZEZyYWdtZW50KCBbIGRhdGEgXSwgY29udGV4dCwgc2NyaXB0cyApO1xuXG5cdGlmICggc2NyaXB0cyAmJiBzY3JpcHRzLmxlbmd0aCApIHtcblx0XHRqUXVlcnkoIHNjcmlwdHMgKS5yZW1vdmUoKTtcblx0fVxuXG5cdHJldHVybiBqUXVlcnkubWVyZ2UoIFtdLCBwYXJzZWQuY2hpbGROb2RlcyApO1xufTtcblxuLyoqXG4gKiBMb2FkIGEgdXJsIGludG8gYSBwYWdlXG4gKi9cbmpRdWVyeS5mbi5sb2FkID0gZnVuY3Rpb24oIHVybCwgcGFyYW1zLCBjYWxsYmFjayApIHtcblx0dmFyIHNlbGVjdG9yLCB0eXBlLCByZXNwb25zZSxcblx0XHRzZWxmID0gdGhpcyxcblx0XHRvZmYgPSB1cmwuaW5kZXhPZiggXCIgXCIgKTtcblxuXHRpZiAoIG9mZiA+IC0xICkge1xuXHRcdHNlbGVjdG9yID0gc3RyaXBBbmRDb2xsYXBzZSggdXJsLnNsaWNlKCBvZmYgKSApO1xuXHRcdHVybCA9IHVybC5zbGljZSggMCwgb2ZmICk7XG5cdH1cblxuXHQvLyBJZiBpdCdzIGEgZnVuY3Rpb25cblx0aWYgKCB0eXBlb2YgcGFyYW1zID09PSBcImZ1bmN0aW9uXCIgKSB7XG5cblx0XHQvLyBXZSBhc3N1bWUgdGhhdCBpdCdzIHRoZSBjYWxsYmFja1xuXHRcdGNhbGxiYWNrID0gcGFyYW1zO1xuXHRcdHBhcmFtcyA9IHVuZGVmaW5lZDtcblxuXHQvLyBPdGhlcndpc2UsIGJ1aWxkIGEgcGFyYW0gc3RyaW5nXG5cdH0gZWxzZSBpZiAoIHBhcmFtcyAmJiB0eXBlb2YgcGFyYW1zID09PSBcIm9iamVjdFwiICkge1xuXHRcdHR5cGUgPSBcIlBPU1RcIjtcblx0fVxuXG5cdC8vIElmIHdlIGhhdmUgZWxlbWVudHMgdG8gbW9kaWZ5LCBtYWtlIHRoZSByZXF1ZXN0XG5cdGlmICggc2VsZi5sZW5ndGggPiAwICkge1xuXHRcdGpRdWVyeS5hamF4KCB7XG5cdFx0XHR1cmw6IHVybCxcblxuXHRcdFx0Ly8gSWYgXCJ0eXBlXCIgdmFyaWFibGUgaXMgdW5kZWZpbmVkLCB0aGVuIFwiR0VUXCIgbWV0aG9kIHdpbGwgYmUgdXNlZC5cblx0XHRcdC8vIE1ha2UgdmFsdWUgb2YgdGhpcyBmaWVsZCBleHBsaWNpdCBzaW5jZVxuXHRcdFx0Ly8gdXNlciBjYW4gb3ZlcnJpZGUgaXQgdGhyb3VnaCBhamF4U2V0dXAgbWV0aG9kXG5cdFx0XHR0eXBlOiB0eXBlIHx8IFwiR0VUXCIsXG5cdFx0XHRkYXRhVHlwZTogXCJodG1sXCIsXG5cdFx0XHRkYXRhOiBwYXJhbXNcblx0XHR9ICkuZG9uZSggZnVuY3Rpb24oIHJlc3BvbnNlVGV4dCApIHtcblxuXHRcdFx0Ly8gU2F2ZSByZXNwb25zZSBmb3IgdXNlIGluIGNvbXBsZXRlIGNhbGxiYWNrXG5cdFx0XHRyZXNwb25zZSA9IGFyZ3VtZW50cztcblxuXHRcdFx0c2VsZi5odG1sKCBzZWxlY3RvciA/XG5cblx0XHRcdFx0Ly8gSWYgYSBzZWxlY3RvciB3YXMgc3BlY2lmaWVkLCBsb2NhdGUgdGhlIHJpZ2h0IGVsZW1lbnRzIGluIGEgZHVtbXkgZGl2XG5cdFx0XHRcdC8vIEV4Y2x1ZGUgc2NyaXB0cyB0byBhdm9pZCBJRSAnUGVybWlzc2lvbiBEZW5pZWQnIGVycm9yc1xuXHRcdFx0XHRqUXVlcnkoIFwiPGRpdj5cIiApLmFwcGVuZCggalF1ZXJ5LnBhcnNlSFRNTCggcmVzcG9uc2VUZXh0ICkgKS5maW5kKCBzZWxlY3RvciApIDpcblxuXHRcdFx0XHQvLyBPdGhlcndpc2UgdXNlIHRoZSBmdWxsIHJlc3VsdFxuXHRcdFx0XHRyZXNwb25zZVRleHQgKTtcblxuXHRcdC8vIElmIHRoZSByZXF1ZXN0IHN1Y2NlZWRzLCB0aGlzIGZ1bmN0aW9uIGdldHMgXCJkYXRhXCIsIFwic3RhdHVzXCIsIFwianFYSFJcIlxuXHRcdC8vIGJ1dCB0aGV5IGFyZSBpZ25vcmVkIGJlY2F1c2UgcmVzcG9uc2Ugd2FzIHNldCBhYm92ZS5cblx0XHQvLyBJZiBpdCBmYWlscywgdGhpcyBmdW5jdGlvbiBnZXRzIFwianFYSFJcIiwgXCJzdGF0dXNcIiwgXCJlcnJvclwiXG5cdFx0fSApLmFsd2F5cyggY2FsbGJhY2sgJiYgZnVuY3Rpb24oIGpxWEhSLCBzdGF0dXMgKSB7XG5cdFx0XHRzZWxmLmVhY2goIGZ1bmN0aW9uKCkge1xuXHRcdFx0XHRjYWxsYmFjay5hcHBseSggdGhpcywgcmVzcG9uc2UgfHwgWyBqcVhIUi5yZXNwb25zZVRleHQsIHN0YXR1cywganFYSFIgXSApO1xuXHRcdFx0fSApO1xuXHRcdH0gKTtcblx0fVxuXG5cdHJldHVybiB0aGlzO1xufTtcblxualF1ZXJ5LmV4cHIucHNldWRvcy5hbmltYXRlZCA9IGZ1bmN0aW9uKCBlbGVtICkge1xuXHRyZXR1cm4galF1ZXJ5LmdyZXAoIGpRdWVyeS50aW1lcnMsIGZ1bmN0aW9uKCBmbiApIHtcblx0XHRyZXR1cm4gZWxlbSA9PT0gZm4uZWxlbTtcblx0fSApLmxlbmd0aDtcbn07XG5cbmpRdWVyeS5vZmZzZXQgPSB7XG5cdHNldE9mZnNldDogZnVuY3Rpb24oIGVsZW0sIG9wdGlvbnMsIGkgKSB7XG5cdFx0dmFyIGN1clBvc2l0aW9uLCBjdXJMZWZ0LCBjdXJDU1NUb3AsIGN1clRvcCwgY3VyT2Zmc2V0LCBjdXJDU1NMZWZ0LCBjYWxjdWxhdGVQb3NpdGlvbixcblx0XHRcdHBvc2l0aW9uID0galF1ZXJ5LmNzcyggZWxlbSwgXCJwb3NpdGlvblwiICksXG5cdFx0XHRjdXJFbGVtID0galF1ZXJ5KCBlbGVtICksXG5cdFx0XHRwcm9wcyA9IHt9O1xuXG5cdFx0Ly8gU2V0IHBvc2l0aW9uIGZpcnN0LCBpbi1jYXNlIHRvcC9sZWZ0IGFyZSBzZXQgZXZlbiBvbiBzdGF0aWMgZWxlbVxuXHRcdGlmICggcG9zaXRpb24gPT09IFwic3RhdGljXCIgKSB7XG5cdFx0XHRlbGVtLnN0eWxlLnBvc2l0aW9uID0gXCJyZWxhdGl2ZVwiO1xuXHRcdH1cblxuXHRcdGN1ck9mZnNldCA9IGN1ckVsZW0ub2Zmc2V0KCk7XG5cdFx0Y3VyQ1NTVG9wID0galF1ZXJ5LmNzcyggZWxlbSwgXCJ0b3BcIiApO1xuXHRcdGN1ckNTU0xlZnQgPSBqUXVlcnkuY3NzKCBlbGVtLCBcImxlZnRcIiApO1xuXHRcdGNhbGN1bGF0ZVBvc2l0aW9uID0gKCBwb3NpdGlvbiA9PT0gXCJhYnNvbHV0ZVwiIHx8IHBvc2l0aW9uID09PSBcImZpeGVkXCIgKSAmJlxuXHRcdFx0KCBjdXJDU1NUb3AgKyBjdXJDU1NMZWZ0ICkuaW5kZXhPZiggXCJhdXRvXCIgKSA+IC0xO1xuXG5cdFx0Ly8gTmVlZCB0byBiZSBhYmxlIHRvIGNhbGN1bGF0ZSBwb3NpdGlvbiBpZiBlaXRoZXJcblx0XHQvLyB0b3Agb3IgbGVmdCBpcyBhdXRvIGFuZCBwb3NpdGlvbiBpcyBlaXRoZXIgYWJzb2x1dGUgb3IgZml4ZWRcblx0XHRpZiAoIGNhbGN1bGF0ZVBvc2l0aW9uICkge1xuXHRcdFx0Y3VyUG9zaXRpb24gPSBjdXJFbGVtLnBvc2l0aW9uKCk7XG5cdFx0XHRjdXJUb3AgPSBjdXJQb3NpdGlvbi50b3A7XG5cdFx0XHRjdXJMZWZ0ID0gY3VyUG9zaXRpb24ubGVmdDtcblxuXHRcdH0gZWxzZSB7XG5cdFx0XHRjdXJUb3AgPSBwYXJzZUZsb2F0KCBjdXJDU1NUb3AgKSB8fCAwO1xuXHRcdFx0Y3VyTGVmdCA9IHBhcnNlRmxvYXQoIGN1ckNTU0xlZnQgKSB8fCAwO1xuXHRcdH1cblxuXHRcdGlmICggdHlwZW9mIG9wdGlvbnMgPT09IFwiZnVuY3Rpb25cIiApIHtcblxuXHRcdFx0Ly8gVXNlIGpRdWVyeS5leHRlbmQgaGVyZSB0byBhbGxvdyBtb2RpZmljYXRpb24gb2YgY29vcmRpbmF0ZXMgYXJndW1lbnQgKGdoLTE4NDgpXG5cdFx0XHRvcHRpb25zID0gb3B0aW9ucy5jYWxsKCBlbGVtLCBpLCBqUXVlcnkuZXh0ZW5kKCB7fSwgY3VyT2Zmc2V0ICkgKTtcblx0XHR9XG5cblx0XHRpZiAoIG9wdGlvbnMudG9wICE9IG51bGwgKSB7XG5cdFx0XHRwcm9wcy50b3AgPSAoIG9wdGlvbnMudG9wIC0gY3VyT2Zmc2V0LnRvcCApICsgY3VyVG9wO1xuXHRcdH1cblx0XHRpZiAoIG9wdGlvbnMubGVmdCAhPSBudWxsICkge1xuXHRcdFx0cHJvcHMubGVmdCA9ICggb3B0aW9ucy5sZWZ0IC0gY3VyT2Zmc2V0LmxlZnQgKSArIGN1ckxlZnQ7XG5cdFx0fVxuXG5cdFx0aWYgKCBcInVzaW5nXCIgaW4gb3B0aW9ucyApIHtcblx0XHRcdG9wdGlvbnMudXNpbmcuY2FsbCggZWxlbSwgcHJvcHMgKTtcblxuXHRcdH0gZWxzZSB7XG5cdFx0XHRjdXJFbGVtLmNzcyggcHJvcHMgKTtcblx0XHR9XG5cdH1cbn07XG5cbmpRdWVyeS5mbi5leHRlbmQoIHtcblxuXHQvLyBvZmZzZXQoKSByZWxhdGVzIGFuIGVsZW1lbnQncyBib3JkZXIgYm94IHRvIHRoZSBkb2N1bWVudCBvcmlnaW5cblx0b2Zmc2V0OiBmdW5jdGlvbiggb3B0aW9ucyApIHtcblxuXHRcdC8vIFByZXNlcnZlIGNoYWluaW5nIGZvciBzZXR0ZXJcblx0XHRpZiAoIGFyZ3VtZW50cy5sZW5ndGggKSB7XG5cdFx0XHRyZXR1cm4gb3B0aW9ucyA9PT0gdW5kZWZpbmVkID9cblx0XHRcdFx0dGhpcyA6XG5cdFx0XHRcdHRoaXMuZWFjaCggZnVuY3Rpb24oIGkgKSB7XG5cdFx0XHRcdFx0alF1ZXJ5Lm9mZnNldC5zZXRPZmZzZXQoIHRoaXMsIG9wdGlvbnMsIGkgKTtcblx0XHRcdFx0fSApO1xuXHRcdH1cblxuXHRcdHZhciByZWN0LCB3aW4sXG5cdFx0XHRlbGVtID0gdGhpc1sgMCBdO1xuXG5cdFx0aWYgKCAhZWxlbSApIHtcblx0XHRcdHJldHVybjtcblx0XHR9XG5cblx0XHQvLyBSZXR1cm4gemVyb3MgZm9yIGRpc2Nvbm5lY3RlZCBhbmQgaGlkZGVuIChkaXNwbGF5OiBub25lKSBlbGVtZW50cyAoZ2gtMjMxMClcblx0XHQvLyBTdXBwb3J0OiBJRSA8PTExK1xuXHRcdC8vIFJ1bm5pbmcgZ2V0Qm91bmRpbmdDbGllbnRSZWN0IG9uIGFcblx0XHQvLyBkaXNjb25uZWN0ZWQgbm9kZSBpbiBJRSB0aHJvd3MgYW4gZXJyb3Jcblx0XHRpZiAoICFlbGVtLmdldENsaWVudFJlY3RzKCkubGVuZ3RoICkge1xuXHRcdFx0cmV0dXJuIHsgdG9wOiAwLCBsZWZ0OiAwIH07XG5cdFx0fVxuXG5cdFx0Ly8gR2V0IGRvY3VtZW50LXJlbGF0aXZlIHBvc2l0aW9uIGJ5IGFkZGluZyB2aWV3cG9ydCBzY3JvbGwgdG8gdmlld3BvcnQtcmVsYXRpdmUgZ0JDUlxuXHRcdHJlY3QgPSBlbGVtLmdldEJvdW5kaW5nQ2xpZW50UmVjdCgpO1xuXHRcdHdpbiA9IGVsZW0ub3duZXJEb2N1bWVudC5kZWZhdWx0Vmlldztcblx0XHRyZXR1cm4ge1xuXHRcdFx0dG9wOiByZWN0LnRvcCArIHdpbi5wYWdlWU9mZnNldCxcblx0XHRcdGxlZnQ6IHJlY3QubGVmdCArIHdpbi5wYWdlWE9mZnNldFxuXHRcdH07XG5cdH0sXG5cblx0Ly8gcG9zaXRpb24oKSByZWxhdGVzIGFuIGVsZW1lbnQncyBtYXJnaW4gYm94IHRvIGl0cyBvZmZzZXQgcGFyZW50J3MgcGFkZGluZyBib3hcblx0Ly8gVGhpcyBjb3JyZXNwb25kcyB0byB0aGUgYmVoYXZpb3Igb2YgQ1NTIGFic29sdXRlIHBvc2l0aW9uaW5nXG5cdHBvc2l0aW9uOiBmdW5jdGlvbigpIHtcblx0XHRpZiAoICF0aGlzWyAwIF0gKSB7XG5cdFx0XHRyZXR1cm47XG5cdFx0fVxuXG5cdFx0dmFyIG9mZnNldFBhcmVudCwgb2Zmc2V0LCBkb2MsXG5cdFx0XHRlbGVtID0gdGhpc1sgMCBdLFxuXHRcdFx0cGFyZW50T2Zmc2V0ID0geyB0b3A6IDAsIGxlZnQ6IDAgfTtcblxuXHRcdC8vIHBvc2l0aW9uOmZpeGVkIGVsZW1lbnRzIGFyZSBvZmZzZXQgZnJvbSB0aGUgdmlld3BvcnQsIHdoaWNoIGl0c2VsZiBhbHdheXMgaGFzIHplcm8gb2Zmc2V0XG5cdFx0aWYgKCBqUXVlcnkuY3NzKCBlbGVtLCBcInBvc2l0aW9uXCIgKSA9PT0gXCJmaXhlZFwiICkge1xuXG5cdFx0XHQvLyBBc3N1bWUgcG9zaXRpb246Zml4ZWQgaW1wbGllcyBhdmFpbGFiaWxpdHkgb2YgZ2V0Qm91bmRpbmdDbGllbnRSZWN0XG5cdFx0XHRvZmZzZXQgPSBlbGVtLmdldEJvdW5kaW5nQ2xpZW50UmVjdCgpO1xuXG5cdFx0fSBlbHNlIHtcblx0XHRcdG9mZnNldCA9IHRoaXMub2Zmc2V0KCk7XG5cblx0XHRcdC8vIEFjY291bnQgZm9yIHRoZSAqcmVhbCogb2Zmc2V0IHBhcmVudCwgd2hpY2ggY2FuIGJlIHRoZSBkb2N1bWVudCBvciBpdHMgcm9vdCBlbGVtZW50XG5cdFx0XHQvLyB3aGVuIGEgc3RhdGljYWxseSBwb3NpdGlvbmVkIGVsZW1lbnQgaXMgaWRlbnRpZmllZFxuXHRcdFx0ZG9jID0gZWxlbS5vd25lckRvY3VtZW50O1xuXHRcdFx0b2Zmc2V0UGFyZW50ID0gZWxlbS5vZmZzZXRQYXJlbnQgfHwgZG9jLmRvY3VtZW50RWxlbWVudDtcblx0XHRcdHdoaWxlICggb2Zmc2V0UGFyZW50ICYmXG5cdFx0XHRcdG9mZnNldFBhcmVudCAhPT0gZG9jLmRvY3VtZW50RWxlbWVudCAmJlxuXHRcdFx0XHRqUXVlcnkuY3NzKCBvZmZzZXRQYXJlbnQsIFwicG9zaXRpb25cIiApID09PSBcInN0YXRpY1wiICkge1xuXG5cdFx0XHRcdG9mZnNldFBhcmVudCA9IG9mZnNldFBhcmVudC5vZmZzZXRQYXJlbnQgfHwgZG9jLmRvY3VtZW50RWxlbWVudDtcblx0XHRcdH1cblx0XHRcdGlmICggb2Zmc2V0UGFyZW50ICYmIG9mZnNldFBhcmVudCAhPT0gZWxlbSAmJiBvZmZzZXRQYXJlbnQubm9kZVR5cGUgPT09IDEgJiZcblx0XHRcdFx0alF1ZXJ5LmNzcyggb2Zmc2V0UGFyZW50LCBcInBvc2l0aW9uXCIgKSAhPT0gXCJzdGF0aWNcIiApIHtcblxuXHRcdFx0XHQvLyBJbmNvcnBvcmF0ZSBib3JkZXJzIGludG8gaXRzIG9mZnNldCwgc2luY2UgdGhleSBhcmUgb3V0c2lkZSBpdHMgY29udGVudCBvcmlnaW5cblx0XHRcdFx0cGFyZW50T2Zmc2V0ID0galF1ZXJ5KCBvZmZzZXRQYXJlbnQgKS5vZmZzZXQoKTtcblx0XHRcdFx0cGFyZW50T2Zmc2V0LnRvcCArPSBqUXVlcnkuY3NzKCBvZmZzZXRQYXJlbnQsIFwiYm9yZGVyVG9wV2lkdGhcIiwgdHJ1ZSApO1xuXHRcdFx0XHRwYXJlbnRPZmZzZXQubGVmdCArPSBqUXVlcnkuY3NzKCBvZmZzZXRQYXJlbnQsIFwiYm9yZGVyTGVmdFdpZHRoXCIsIHRydWUgKTtcblx0XHRcdH1cblx0XHR9XG5cblx0XHQvLyBTdWJ0cmFjdCBwYXJlbnQgb2Zmc2V0cyBhbmQgZWxlbWVudCBtYXJnaW5zXG5cdFx0cmV0dXJuIHtcblx0XHRcdHRvcDogb2Zmc2V0LnRvcCAtIHBhcmVudE9mZnNldC50b3AgLSBqUXVlcnkuY3NzKCBlbGVtLCBcIm1hcmdpblRvcFwiLCB0cnVlICksXG5cdFx0XHRsZWZ0OiBvZmZzZXQubGVmdCAtIHBhcmVudE9mZnNldC5sZWZ0IC0galF1ZXJ5LmNzcyggZWxlbSwgXCJtYXJnaW5MZWZ0XCIsIHRydWUgKVxuXHRcdH07XG5cdH0sXG5cblx0Ly8gVGhpcyBtZXRob2Qgd2lsbCByZXR1cm4gZG9jdW1lbnRFbGVtZW50IGluIHRoZSBmb2xsb3dpbmcgY2FzZXM6XG5cdC8vIDEpIEZvciB0aGUgZWxlbWVudCBpbnNpZGUgdGhlIGlmcmFtZSB3aXRob3V0IG9mZnNldFBhcmVudCwgdGhpcyBtZXRob2Qgd2lsbCByZXR1cm5cblx0Ly8gICAgZG9jdW1lbnRFbGVtZW50IG9mIHRoZSBwYXJlbnQgd2luZG93XG5cdC8vIDIpIEZvciB0aGUgaGlkZGVuIG9yIGRldGFjaGVkIGVsZW1lbnRcblx0Ly8gMykgRm9yIGJvZHkgb3IgaHRtbCBlbGVtZW50LCBpLmUuIGluIGNhc2Ugb2YgdGhlIGh0bWwgbm9kZSAtIGl0IHdpbGwgcmV0dXJuIGl0c2VsZlxuXHQvL1xuXHQvLyBidXQgdGhvc2UgZXhjZXB0aW9ucyB3ZXJlIG5ldmVyIHByZXNlbnRlZCBhcyBhIHJlYWwgbGlmZSB1c2UtY2FzZXNcblx0Ly8gYW5kIG1pZ2h0IGJlIGNvbnNpZGVyZWQgYXMgbW9yZSBwcmVmZXJhYmxlIHJlc3VsdHMuXG5cdC8vXG5cdC8vIFRoaXMgbG9naWMsIGhvd2V2ZXIsIGlzIG5vdCBndWFyYW50ZWVkIGFuZCBjYW4gY2hhbmdlIGF0IGFueSBwb2ludCBpbiB0aGUgZnV0dXJlXG5cdG9mZnNldFBhcmVudDogZnVuY3Rpb24oKSB7XG5cdFx0cmV0dXJuIHRoaXMubWFwKCBmdW5jdGlvbigpIHtcblx0XHRcdHZhciBvZmZzZXRQYXJlbnQgPSB0aGlzLm9mZnNldFBhcmVudDtcblxuXHRcdFx0d2hpbGUgKCBvZmZzZXRQYXJlbnQgJiYgalF1ZXJ5LmNzcyggb2Zmc2V0UGFyZW50LCBcInBvc2l0aW9uXCIgKSA9PT0gXCJzdGF0aWNcIiApIHtcblx0XHRcdFx0b2Zmc2V0UGFyZW50ID0gb2Zmc2V0UGFyZW50Lm9mZnNldFBhcmVudDtcblx0XHRcdH1cblxuXHRcdFx0cmV0dXJuIG9mZnNldFBhcmVudCB8fCBkb2N1bWVudEVsZW1lbnQkMTtcblx0XHR9ICk7XG5cdH1cbn0gKTtcblxuLy8gQ3JlYXRlIHNjcm9sbExlZnQgYW5kIHNjcm9sbFRvcCBtZXRob2RzXG5qUXVlcnkuZWFjaCggeyBzY3JvbGxMZWZ0OiBcInBhZ2VYT2Zmc2V0XCIsIHNjcm9sbFRvcDogXCJwYWdlWU9mZnNldFwiIH0sIGZ1bmN0aW9uKCBtZXRob2QsIHByb3AgKSB7XG5cdHZhciB0b3AgPSBcInBhZ2VZT2Zmc2V0XCIgPT09IHByb3A7XG5cblx0alF1ZXJ5LmZuWyBtZXRob2QgXSA9IGZ1bmN0aW9uKCB2YWwgKSB7XG5cdFx0cmV0dXJuIGFjY2VzcyggdGhpcywgZnVuY3Rpb24oIGVsZW0sIG1ldGhvZCwgdmFsICkge1xuXG5cdFx0XHQvLyBDb2FsZXNjZSBkb2N1bWVudHMgYW5kIHdpbmRvd3Ncblx0XHRcdHZhciB3aW47XG5cdFx0XHRpZiAoIGlzV2luZG93KCBlbGVtICkgKSB7XG5cdFx0XHRcdHdpbiA9IGVsZW07XG5cdFx0XHR9IGVsc2UgaWYgKCBlbGVtLm5vZGVUeXBlID09PSA5ICkge1xuXHRcdFx0XHR3aW4gPSBlbGVtLmRlZmF1bHRWaWV3O1xuXHRcdFx0fVxuXG5cdFx0XHRpZiAoIHZhbCA9PT0gdW5kZWZpbmVkICkge1xuXHRcdFx0XHRyZXR1cm4gd2luID8gd2luWyBwcm9wIF0gOiBlbGVtWyBtZXRob2QgXTtcblx0XHRcdH1cblxuXHRcdFx0aWYgKCB3aW4gKSB7XG5cdFx0XHRcdHdpbi5zY3JvbGxUbyhcblx0XHRcdFx0XHQhdG9wID8gdmFsIDogd2luLnBhZ2VYT2Zmc2V0LFxuXHRcdFx0XHRcdHRvcCA/IHZhbCA6IHdpbi5wYWdlWU9mZnNldFxuXHRcdFx0XHQpO1xuXG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRlbGVtWyBtZXRob2QgXSA9IHZhbDtcblx0XHRcdH1cblx0XHR9LCBtZXRob2QsIHZhbCwgYXJndW1lbnRzLmxlbmd0aCApO1xuXHR9O1xufSApO1xuXG4vLyBDcmVhdGUgaW5uZXJIZWlnaHQsIGlubmVyV2lkdGgsIGhlaWdodCwgd2lkdGgsIG91dGVySGVpZ2h0IGFuZCBvdXRlcldpZHRoIG1ldGhvZHNcbmpRdWVyeS5lYWNoKCB7IEhlaWdodDogXCJoZWlnaHRcIiwgV2lkdGg6IFwid2lkdGhcIiB9LCBmdW5jdGlvbiggbmFtZSwgdHlwZSApIHtcblx0alF1ZXJ5LmVhY2goIHtcblx0XHRwYWRkaW5nOiBcImlubmVyXCIgKyBuYW1lLFxuXHRcdGNvbnRlbnQ6IHR5cGUsXG5cdFx0XCJcIjogXCJvdXRlclwiICsgbmFtZVxuXHR9LCBmdW5jdGlvbiggZGVmYXVsdEV4dHJhLCBmdW5jTmFtZSApIHtcblxuXHRcdC8vIE1hcmdpbiBpcyBvbmx5IGZvciBvdXRlckhlaWdodCwgb3V0ZXJXaWR0aFxuXHRcdGpRdWVyeS5mblsgZnVuY05hbWUgXSA9IGZ1bmN0aW9uKCBtYXJnaW4sIHZhbHVlICkge1xuXHRcdFx0dmFyIGNoYWluYWJsZSA9IGFyZ3VtZW50cy5sZW5ndGggJiYgKCBkZWZhdWx0RXh0cmEgfHwgdHlwZW9mIG1hcmdpbiAhPT0gXCJib29sZWFuXCIgKSxcblx0XHRcdFx0ZXh0cmEgPSBkZWZhdWx0RXh0cmEgfHwgKCBtYXJnaW4gPT09IHRydWUgfHwgdmFsdWUgPT09IHRydWUgPyBcIm1hcmdpblwiIDogXCJib3JkZXJcIiApO1xuXG5cdFx0XHRyZXR1cm4gYWNjZXNzKCB0aGlzLCBmdW5jdGlvbiggZWxlbSwgdHlwZSwgdmFsdWUgKSB7XG5cdFx0XHRcdHZhciBkb2M7XG5cblx0XHRcdFx0aWYgKCBpc1dpbmRvdyggZWxlbSApICkge1xuXG5cdFx0XHRcdFx0Ly8gJCggd2luZG93ICkub3V0ZXJXaWR0aC9IZWlnaHQgcmV0dXJuIHcvaCBpbmNsdWRpbmcgc2Nyb2xsYmFycyAoZ2gtMTcyOSlcblx0XHRcdFx0XHRyZXR1cm4gZnVuY05hbWUuaW5kZXhPZiggXCJvdXRlclwiICkgPT09IDAgP1xuXHRcdFx0XHRcdFx0ZWxlbVsgXCJpbm5lclwiICsgbmFtZSBdIDpcblx0XHRcdFx0XHRcdGVsZW0uZG9jdW1lbnQuZG9jdW1lbnRFbGVtZW50WyBcImNsaWVudFwiICsgbmFtZSBdO1xuXHRcdFx0XHR9XG5cblx0XHRcdFx0Ly8gR2V0IGRvY3VtZW50IHdpZHRoIG9yIGhlaWdodFxuXHRcdFx0XHRpZiAoIGVsZW0ubm9kZVR5cGUgPT09IDkgKSB7XG5cdFx0XHRcdFx0ZG9jID0gZWxlbS5kb2N1bWVudEVsZW1lbnQ7XG5cblx0XHRcdFx0XHQvLyBFaXRoZXIgc2Nyb2xsW1dpZHRoL0hlaWdodF0gb3Igb2Zmc2V0W1dpZHRoL0hlaWdodF0gb3IgY2xpZW50W1dpZHRoL0hlaWdodF0sXG5cdFx0XHRcdFx0Ly8gd2hpY2hldmVyIGlzIGdyZWF0ZXN0XG5cdFx0XHRcdFx0cmV0dXJuIE1hdGgubWF4KFxuXHRcdFx0XHRcdFx0ZWxlbS5ib2R5WyBcInNjcm9sbFwiICsgbmFtZSBdLCBkb2NbIFwic2Nyb2xsXCIgKyBuYW1lIF0sXG5cdFx0XHRcdFx0XHRlbGVtLmJvZHlbIFwib2Zmc2V0XCIgKyBuYW1lIF0sIGRvY1sgXCJvZmZzZXRcIiArIG5hbWUgXSxcblx0XHRcdFx0XHRcdGRvY1sgXCJjbGllbnRcIiArIG5hbWUgXVxuXHRcdFx0XHRcdCk7XG5cdFx0XHRcdH1cblxuXHRcdFx0XHRyZXR1cm4gdmFsdWUgPT09IHVuZGVmaW5lZCA/XG5cblx0XHRcdFx0XHQvLyBHZXQgd2lkdGggb3IgaGVpZ2h0IG9uIHRoZSBlbGVtZW50LCByZXF1ZXN0aW5nIGJ1dCBub3QgZm9yY2luZyBwYXJzZUZsb2F0XG5cdFx0XHRcdFx0alF1ZXJ5LmNzcyggZWxlbSwgdHlwZSwgZXh0cmEgKSA6XG5cblx0XHRcdFx0XHQvLyBTZXQgd2lkdGggb3IgaGVpZ2h0IG9uIHRoZSBlbGVtZW50XG5cdFx0XHRcdFx0alF1ZXJ5LnN0eWxlKCBlbGVtLCB0eXBlLCB2YWx1ZSwgZXh0cmEgKTtcblx0XHRcdH0sIHR5cGUsIGNoYWluYWJsZSA/IG1hcmdpbiA6IHVuZGVmaW5lZCwgY2hhaW5hYmxlICk7XG5cdFx0fTtcblx0fSApO1xufSApO1xuXG5qUXVlcnkuZWFjaCggW1xuXHRcImFqYXhTdGFydFwiLFxuXHRcImFqYXhTdG9wXCIsXG5cdFwiYWpheENvbXBsZXRlXCIsXG5cdFwiYWpheEVycm9yXCIsXG5cdFwiYWpheFN1Y2Nlc3NcIixcblx0XCJhamF4U2VuZFwiXG5dLCBmdW5jdGlvbiggX2ksIHR5cGUgKSB7XG5cdGpRdWVyeS5mblsgdHlwZSBdID0gZnVuY3Rpb24oIGZuICkge1xuXHRcdHJldHVybiB0aGlzLm9uKCB0eXBlLCBmbiApO1xuXHR9O1xufSApO1xuXG5qUXVlcnkuZm4uZXh0ZW5kKCB7XG5cblx0YmluZDogZnVuY3Rpb24oIHR5cGVzLCBkYXRhLCBmbiApIHtcblx0XHRyZXR1cm4gdGhpcy5vbiggdHlwZXMsIG51bGwsIGRhdGEsIGZuICk7XG5cdH0sXG5cdHVuYmluZDogZnVuY3Rpb24oIHR5cGVzLCBmbiApIHtcblx0XHRyZXR1cm4gdGhpcy5vZmYoIHR5cGVzLCBudWxsLCBmbiApO1xuXHR9LFxuXG5cdGRlbGVnYXRlOiBmdW5jdGlvbiggc2VsZWN0b3IsIHR5cGVzLCBkYXRhLCBmbiApIHtcblx0XHRyZXR1cm4gdGhpcy5vbiggdHlwZXMsIHNlbGVjdG9yLCBkYXRhLCBmbiApO1xuXHR9LFxuXHR1bmRlbGVnYXRlOiBmdW5jdGlvbiggc2VsZWN0b3IsIHR5cGVzLCBmbiApIHtcblxuXHRcdC8vICggbmFtZXNwYWNlICkgb3IgKCBzZWxlY3RvciwgdHlwZXMgWywgZm5dIClcblx0XHRyZXR1cm4gYXJndW1lbnRzLmxlbmd0aCA9PT0gMSA/XG5cdFx0XHR0aGlzLm9mZiggc2VsZWN0b3IsIFwiKipcIiApIDpcblx0XHRcdHRoaXMub2ZmKCB0eXBlcywgc2VsZWN0b3IgfHwgXCIqKlwiLCBmbiApO1xuXHR9LFxuXG5cdGhvdmVyOiBmdW5jdGlvbiggZm5PdmVyLCBmbk91dCApIHtcblx0XHRyZXR1cm4gdGhpc1xuXHRcdFx0Lm9uKCBcIm1vdXNlZW50ZXJcIiwgZm5PdmVyIClcblx0XHRcdC5vbiggXCJtb3VzZWxlYXZlXCIsIGZuT3V0IHx8IGZuT3ZlciApO1xuXHR9XG59ICk7XG5cbmpRdWVyeS5lYWNoKFxuXHQoIFwiYmx1ciBmb2N1cyBmb2N1c2luIGZvY3Vzb3V0IHJlc2l6ZSBzY3JvbGwgY2xpY2sgZGJsY2xpY2sgXCIgK1xuXHRcIm1vdXNlZG93biBtb3VzZXVwIG1vdXNlbW92ZSBtb3VzZW92ZXIgbW91c2VvdXQgbW91c2VlbnRlciBtb3VzZWxlYXZlIFwiICtcblx0XCJjaGFuZ2Ugc2VsZWN0IHN1Ym1pdCBrZXlkb3duIGtleXByZXNzIGtleXVwIGNvbnRleHRtZW51XCIgKS5zcGxpdCggXCIgXCIgKSxcblx0ZnVuY3Rpb24oIF9pLCBuYW1lICkge1xuXG5cdFx0Ly8gSGFuZGxlIGV2ZW50IGJpbmRpbmdcblx0XHRqUXVlcnkuZm5bIG5hbWUgXSA9IGZ1bmN0aW9uKCBkYXRhLCBmbiApIHtcblx0XHRcdHJldHVybiBhcmd1bWVudHMubGVuZ3RoID4gMCA/XG5cdFx0XHRcdHRoaXMub24oIG5hbWUsIG51bGwsIGRhdGEsIGZuICkgOlxuXHRcdFx0XHR0aGlzLnRyaWdnZXIoIG5hbWUgKTtcblx0XHR9O1xuXHR9XG4pO1xuXG4vLyBCaW5kIGEgZnVuY3Rpb24gdG8gYSBjb250ZXh0LCBvcHRpb25hbGx5IHBhcnRpYWxseSBhcHBseWluZyBhbnlcbi8vIGFyZ3VtZW50cy5cbi8vIGpRdWVyeS5wcm94eSBpcyBkZXByZWNhdGVkIHRvIHByb21vdGUgc3RhbmRhcmRzIChzcGVjaWZpY2FsbHkgRnVuY3Rpb24jYmluZClcbi8vIEhvd2V2ZXIsIGl0IGlzIG5vdCBzbGF0ZWQgZm9yIHJlbW92YWwgYW55IHRpbWUgc29vblxualF1ZXJ5LnByb3h5ID0gZnVuY3Rpb24oIGZuLCBjb250ZXh0ICkge1xuXHR2YXIgdG1wLCBhcmdzLCBwcm94eTtcblxuXHRpZiAoIHR5cGVvZiBjb250ZXh0ID09PSBcInN0cmluZ1wiICkge1xuXHRcdHRtcCA9IGZuWyBjb250ZXh0IF07XG5cdFx0Y29udGV4dCA9IGZuO1xuXHRcdGZuID0gdG1wO1xuXHR9XG5cblx0Ly8gUXVpY2sgY2hlY2sgdG8gZGV0ZXJtaW5lIGlmIHRhcmdldCBpcyBjYWxsYWJsZSwgaW4gdGhlIHNwZWNcblx0Ly8gdGhpcyB0aHJvd3MgYSBUeXBlRXJyb3IsIGJ1dCB3ZSB3aWxsIGp1c3QgcmV0dXJuIHVuZGVmaW5lZC5cblx0aWYgKCB0eXBlb2YgZm4gIT09IFwiZnVuY3Rpb25cIiApIHtcblx0XHRyZXR1cm4gdW5kZWZpbmVkO1xuXHR9XG5cblx0Ly8gU2ltdWxhdGVkIGJpbmRcblx0YXJncyA9IHNsaWNlLmNhbGwoIGFyZ3VtZW50cywgMiApO1xuXHRwcm94eSA9IGZ1bmN0aW9uKCkge1xuXHRcdHJldHVybiBmbi5hcHBseSggY29udGV4dCB8fCB0aGlzLCBhcmdzLmNvbmNhdCggc2xpY2UuY2FsbCggYXJndW1lbnRzICkgKSApO1xuXHR9O1xuXG5cdC8vIFNldCB0aGUgZ3VpZCBvZiB1bmlxdWUgaGFuZGxlciB0byB0aGUgc2FtZSBvZiBvcmlnaW5hbCBoYW5kbGVyLCBzbyBpdCBjYW4gYmUgcmVtb3ZlZFxuXHRwcm94eS5ndWlkID0gZm4uZ3VpZCA9IGZuLmd1aWQgfHwgalF1ZXJ5Lmd1aWQrKztcblxuXHRyZXR1cm4gcHJveHk7XG59O1xuXG5qUXVlcnkuaG9sZFJlYWR5ID0gZnVuY3Rpb24oIGhvbGQgKSB7XG5cdGlmICggaG9sZCApIHtcblx0XHRqUXVlcnkucmVhZHlXYWl0Kys7XG5cdH0gZWxzZSB7XG5cdFx0alF1ZXJ5LnJlYWR5KCB0cnVlICk7XG5cdH1cbn07XG5cbmpRdWVyeS5leHByWyBcIjpcIiBdID0galF1ZXJ5LmV4cHIuZmlsdGVycyA9IGpRdWVyeS5leHByLnBzZXVkb3M7XG5cbi8vIFJlZ2lzdGVyIGFzIGEgbmFtZWQgQU1EIG1vZHVsZSwgc2luY2UgalF1ZXJ5IGNhbiBiZSBjb25jYXRlbmF0ZWQgd2l0aCBvdGhlclxuLy8gZmlsZXMgdGhhdCBtYXkgdXNlIGRlZmluZSwgYnV0IG5vdCB2aWEgYSBwcm9wZXIgY29uY2F0ZW5hdGlvbiBzY3JpcHQgdGhhdFxuLy8gdW5kZXJzdGFuZHMgYW5vbnltb3VzIEFNRCBtb2R1bGVzLiBBIG5hbWVkIEFNRCBpcyBzYWZlc3QgYW5kIG1vc3Qgcm9idXN0XG4vLyB3YXkgdG8gcmVnaXN0ZXIuIExvd2VyY2FzZSBqcXVlcnkgaXMgdXNlZCBiZWNhdXNlIEFNRCBtb2R1bGUgbmFtZXMgYXJlXG4vLyBkZXJpdmVkIGZyb20gZmlsZSBuYW1lcywgYW5kIGpRdWVyeSBpcyBub3JtYWxseSBkZWxpdmVyZWQgaW4gYSBsb3dlcmNhc2Vcbi8vIGZpbGUgbmFtZS4gRG8gdGhpcyBhZnRlciBjcmVhdGluZyB0aGUgZ2xvYmFsIHNvIHRoYXQgaWYgYW4gQU1EIG1vZHVsZSB3YW50c1xuLy8gdG8gY2FsbCBub0NvbmZsaWN0IHRvIGhpZGUgdGhpcyB2ZXJzaW9uIG9mIGpRdWVyeSwgaXQgd2lsbCB3b3JrLlxuXG4vLyBOb3RlIHRoYXQgZm9yIG1heGltdW0gcG9ydGFiaWxpdHksIGxpYnJhcmllcyB0aGF0IGFyZSBub3QgalF1ZXJ5IHNob3VsZFxuLy8gZGVjbGFyZSB0aGVtc2VsdmVzIGFzIGFub255bW91cyBtb2R1bGVzLCBhbmQgYXZvaWQgc2V0dGluZyBhIGdsb2JhbCBpZiBhblxuLy8gQU1EIGxvYWRlciBpcyBwcmVzZW50LiBqUXVlcnkgaXMgYSBzcGVjaWFsIGNhc2UuIEZvciBtb3JlIGluZm9ybWF0aW9uLCBzZWVcbi8vIGh0dHBzOi8vZ2l0aHViLmNvbS9qcmJ1cmtlL3JlcXVpcmVqcy93aWtpL1VwZGF0aW5nLWV4aXN0aW5nLWxpYnJhcmllcyN3aWtpLWFub25cblxuaWYgKCB0eXBlb2YgZGVmaW5lID09PSBcImZ1bmN0aW9uXCIgJiYgZGVmaW5lLmFtZCApIHtcblx0ZGVmaW5lKCBcImpxdWVyeVwiLCBbXSwgZnVuY3Rpb24oKSB7XG5cdFx0cmV0dXJuIGpRdWVyeTtcblx0fSApO1xufVxuXG52YXJcblxuXHQvLyBNYXAgb3ZlciBqUXVlcnkgaW4gY2FzZSBvZiBvdmVyd3JpdGVcblx0X2pRdWVyeSA9IHdpbmRvdy5qUXVlcnksXG5cblx0Ly8gTWFwIG92ZXIgdGhlICQgaW4gY2FzZSBvZiBvdmVyd3JpdGVcblx0XyQgPSB3aW5kb3cuJDtcblxualF1ZXJ5Lm5vQ29uZmxpY3QgPSBmdW5jdGlvbiggZGVlcCApIHtcblx0aWYgKCB3aW5kb3cuJCA9PT0galF1ZXJ5ICkge1xuXHRcdHdpbmRvdy4kID0gXyQ7XG5cdH1cblxuXHRpZiAoIGRlZXAgJiYgd2luZG93LmpRdWVyeSA9PT0galF1ZXJ5ICkge1xuXHRcdHdpbmRvdy5qUXVlcnkgPSBfalF1ZXJ5O1xuXHR9XG5cblx0cmV0dXJuIGpRdWVyeTtcbn07XG5cbi8vIEV4cG9zZSBqUXVlcnkgYW5kICQgaWRlbnRpZmllcnMsIGV2ZW4gaW4gQU1EXG4vLyAodHJhYy03MTAyI2NvbW1lbnQ6MTAsIGdoLTU1Nylcbi8vIGFuZCBDb21tb25KUyBmb3IgYnJvd3NlciBlbXVsYXRvcnMgKHRyYWMtMTM1NjYpXG5pZiAoIHR5cGVvZiBub0dsb2JhbCA9PT0gXCJ1bmRlZmluZWRcIiApIHtcblx0d2luZG93LmpRdWVyeSA9IHdpbmRvdy4kID0galF1ZXJ5O1xufVxuXG5yZXR1cm4galF1ZXJ5O1xuXG59XG5cbnZhciBqUXVlcnkgPSBqUXVlcnlGYWN0b3J5KCB3aW5kb3csIHRydWUgKTtcblxuZXhwb3J0IHsgalF1ZXJ5LCBqUXVlcnkgYXMgJCB9O1xuXG5leHBvcnQgZGVmYXVsdCBqUXVlcnk7XG4iXSwieF9nb29nbGVfaWdub3JlTGlzdCI6WzBdLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7Ozs7QUFZQSxTQUFTLGNBQWUsUUFBUSxVQUFXO0NBRTNDLElBQUssT0FBTyxXQUFXLGVBQWUsQ0FBQyxPQUFPLFVBQzdDLE1BQU0sSUFBSSxNQUFPLDBDQUEyQztDQUc3RCxJQUFJLE1BQU0sQ0FBQztDQUVYLElBQUksV0FBVyxPQUFPO0NBRXRCLElBQUksUUFBUSxJQUFJO0NBSWhCLElBQUksT0FBTyxJQUFJLE9BQU8sU0FBVSxPQUFRO0VBQ3ZDLE9BQU8sSUFBSSxLQUFLLEtBQU0sS0FBTTtDQUM3QixJQUFJLFNBQVUsT0FBUTtFQUNyQixPQUFPLElBQUksT0FBTyxNQUFPLENBQUMsR0FBRyxLQUFNO0NBQ3BDO0NBRUEsSUFBSSxPQUFPLElBQUk7Q0FFZixJQUFJLFVBQVUsSUFBSTtDQUdsQixJQUFJLGFBQWEsQ0FBQztDQUVsQixJQUFJLFdBQVcsV0FBVztDQUUxQixJQUFJLFNBQVMsV0FBVztDQUV4QixJQUFJLGFBQWEsT0FBTztDQUV4QixJQUFJLHVCQUF1QixXQUFXLEtBQU0sTUFBTztDQUduRCxJQUFJLFVBQVUsQ0FBQztDQUVmLFNBQVMsT0FBUSxLQUFNO0VBQ3RCLElBQUssT0FBTyxNQUNYLE9BQU8sTUFBTTtFQUdkLE9BQU8sT0FBTyxRQUFRLFdBQ3JCLFdBQVksU0FBUyxLQUFNLEdBQUksTUFBTyxXQUN0QyxPQUFPO0NBQ1Q7Q0FFQSxTQUFTLFNBQVUsS0FBTTtFQUN4QixPQUFPLE9BQU8sUUFBUSxRQUFRLElBQUk7Q0FDbkM7Q0FFQSxTQUFTLFlBQWEsS0FBTTtFQUUzQixJQUFJLFNBQVMsQ0FBQyxDQUFDLE9BQU8sSUFBSSxRQUN6QixPQUFPLE9BQVEsR0FBSTtFQUVwQixJQUFLLE9BQU8sUUFB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