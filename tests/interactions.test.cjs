const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const vm = require('node:vm');
const root = process.env.TEMPLATE_ROOT || path.join(__dirname, '..');
function element() {
    const classes = new Set();
    return {listeners: {}, classList: {add(...xs) {xs.forEach(x => classes.add(x));}, remove(...xs) {xs.forEach(x => classes.delete(x));}, contains(x) {return classes.has(x);}}, addEventListener(n, f) {this.listeners[n] = f;}, setAttribute() {}, removeAttribute() {}, contains() {return false;}, value: '', innerHTML: '', blur() {}};
}
const form = element(), field = element(), results = element(), entries = element(), close = element(), clear = element(), body = element();
const nodes = {'[data-search-form]': form, '[data-search-form] input[type="search"]': field, '[data-search-results]': results, '[data-search-results] .phpdocumentor-search-results__entries': entries, '.phpdocumentor-search-results__close': close, '[data-search-clear]': clear};
const context = {document: {querySelector: s => nodes[s], body, addEventListener() {}, createElement() {return {set textContent(v) {this.innerHTML = v;}};}}, window: {addEventListener() {}}, Fuse: function () {this.search = value => value === 'missing' ? [] : [{name: 'Example', url: 'classes/Example.html'}];}, setTimeout(f) {f(); return 1;}, clearTimeout() {}};
vm.createContext(context);
vm.runInContext(fs.readFileSync(path.join(root, 'js/search.js.twig'), 'utf8'), context);
context.Search.init();
const event = {target: field, stopPropagation() {}, preventDefault() {}};
for (const query of ['Example', 'missing']) {
    field.value = query;
    field.listeners.keyup(event);
    const original = entries.innerHTML;
    assert.ok(original);
    close.listeners.click(event);
    assert.equal(entries.innerHTML, '');
    field.listeners.focus(event);
    assert.equal(entries.innerHTML, original, 'Reopening must regenerate unchanged-query results');
    assert.ok(body.classList.contains('phpdocumentor-search--active-body'));
    assert.ok(form.classList.contains('phpdocumentor-search--has-results'));
    assert.ok(results.classList.contains('show'));
}
clear.listeners.click(event);
assert.equal(field.value, '');
assert.equal(entries.innerHTML, '');
assert.ok(!results.classList.contains('show'));
console.log('PASS search reopen, empty results, state and clear');
const graph = fs.readFileSync(path.join(root, 'graphs/class.html.twig'), 'utf8');
const scripts = graph.match(/{% block javascripts %}([\s\S]*?){% endblock %}/)[1];
assert.match(graph, /{% block stylesheets %}\s*{{ parent\(\) }}/);
assert.match(scripts, /{{ parent\(\) }}/);
assert.ok(scripts.indexOf('panzoom.min.js') < scripts.indexOf('var instance = panzoom'));
assert.ok(scripts.includes('var instance = panzoom'), 'Graph initialization must live after its footer dependency');
const graphNodes = {};
const calls = [];
vm.runInNewContext(scripts.match(/<script>([\s\S]*?)<\/script>/)[1], {document: {getElementById(id) {return graphNodes[id] ||= {...element(), style: {}};}}, panzoom() {return {smoothZoom(...args) {calls.push(args);}, moveTo(...args) {calls.push(args);}, zoomAbs(...args) {calls.push(args);}};}});
graphNodes['zoom-in'].listeners.click();
graphNodes['zoom-out'].listeners.click();
graphNodes['reset-panzoom'].listeners.click();
assert.deepEqual(calls, [[0, 0, 1.2], [0, 0, 0.8], [0, 0], [0, 0, 1]]);
console.log('PASS graph inherited assets, dependency ordering and controls');
