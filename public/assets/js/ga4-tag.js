/* A first-party bootstrap: establish gtag's queue before loading the remote Google tag. */
(function () {
    'use strict';
    var script = document.currentScript;
    var id = script && script.getAttribute('data-measurement-id');
    if (!/^G-[A-Z0-9]+$/.test(id || '')) return;

    window.dataLayer = window.dataLayer || [];
    window.gtag = function () { window.dataLayer.push(arguments); };
    window.gtag('js', new Date());
    window.gtag('config', id);

    var tag = document.createElement('script');
    tag.async = true;
    tag.src = 'https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(id);
    document.head.appendChild(tag);
}());
