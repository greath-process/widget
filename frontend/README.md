# Widget-frontend

## Technologies

* [Vue.js](https://vuejs.org/)
* [Vue-cli](https://cli.vuejs.org/)
* [Vue-custom-element](https://github.com/karol-f/vue-custom-element)

## Getting started

```
cp .env.example .env.local
npm install
npm run build
```

Configure your `.env.local` (host where is backend and frontend is currently hosted) : 
```
VUE_APP_BACKEND_API_URL=http://<host>:<port>/api/v1/questions
VUE_APP_FRONTEND_API_URL=http://<host>:<port>/
```

Change your `public/widget-loader.js`  (host where is frontend is currently hosted) :
```
const frontend_host = 'http://127.0.0.1:8080';
```

### To embed a widget into the site, you need to insert this script below on your site
#### `http://localhost` need to change to host is where the frontend is currently hosted
```
<script>
  var js = document.createElement("script");
  js.async = true;
  js.src = "http://localhost/widget-loader.js";
  document.getElementsByTagName("head")[0].appendChild(js);
</script>
```
