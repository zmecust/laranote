import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

const router = new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      component: require('./components/Sidebar'),
      children: [
        {
          path: 'notes/:id',
          component: require('./components/note/Show')
        }
      ]
    },
    {
      path: '*',
      component: require('./components/404')
    },
  ]
})

export default router;
