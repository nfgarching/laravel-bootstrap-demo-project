import * as bootstrap from 'bootstrap';
import hljs from 'highlight.js/lib/core';
import bash from 'highlight.js/lib/languages/bash';
import json from 'highlight.js/lib/languages/json';
import php from 'highlight.js/lib/languages/php';
import xml from 'highlight.js/lib/languages/xml';

// Die Inline-Skripte des Package-Layouts (Modals, Toasts, Tooltips) erwarten
// Bootstrap als globale Variable – wie zuvor beim CDN-Bundle.
window.bootstrap = bootstrap;

hljs.registerLanguage('bash', bash);
hljs.registerLanguage('json', json);
hljs.registerLanguage('php', php);
hljs.registerLanguage('xml', xml);

const highlightAll = () => {
    document.querySelectorAll('pre code[class*="language-"]:not([data-highlighted])').forEach((block) => {
        hljs.highlightElement(block);
    });
};

document.addEventListener('DOMContentLoaded', highlightAll);
document.addEventListener('livewire:navigated', highlightAll);
