require('./bootstrap');

window.Vue = require('vue').default;

import vuetify from './vuetify';
import VueCookies from 'vue-cookies'

import App  from './components/App.vue'
import { router  }from './router'
import CKEditor from '@ckeditor/ckeditor5-vue2';
import InfiniteLoading from 'vue-infinite-loading';
import VueMeta from 'vue-meta';

Vue.use(VueMeta, {
  // optional pluginOptions
  refreshOnceOnNavigation: true
})
Vue.use( CKEditor );
Vue.use(InfiniteLoading, { /* options */ });
Vue.use(VueCookies)

/*router.beforeEach((to, from, next) => {
    if (to.name !== 'Login' && !$cookies.get("token")) next({ name: 'Login' })
    else next()

 });*/

new Vue({
    vuetify,
    el: '#app',
    components:{App},
    router,
  });
