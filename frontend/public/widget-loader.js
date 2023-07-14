(function(w, d, link, script, widget, p) {
    window.onload = function() {
        /* put into frontend_host is where the app is currently hosted */
        const frontend_host = 'http://127.0.0.1:8080';

        let css = frontend_host + "/css/app.css";
        let js = frontend_host + "/js/app.js";

        link = d.createElement("link");
        link.rel = "stylesheet";
        link.href = css;
        d.getElementsByTagName("head")[0].appendChild(link);

        script = d.createElement("script");
        script.async = 1;
        script.src = js;
        p = d.getElementsByTagName("script")[0];
        p.parentNode.insertBefore(script, p);

        widget = d.createElement("vue-widget");
        d.getElementsByTagName("body")[0].appendChild(widget);
    };
})(window, document);
