import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

const router = new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      component: require('./components/Layout'),
      children: [
        {
          path: 'home',
          component: require('./components/home/Index'),
        },
        {
          path: 'notes/create',
          component: require('./components/note/Create'),
        },
        {
          path: 'notes/:id/edit',
          component: require('./components/note/Edit'),
        },
        {
          path: 'categories/:id',
          name: 'ShowNote',
          component: require('./components/note/Show')
        },
        {
          path: 'important',
          component: require('./components/note/Show')
        },
        {
          path: 'trash',
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
