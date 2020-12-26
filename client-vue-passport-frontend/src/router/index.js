import { createRouter, createWebHistory } from 'vue-router'

const routes = [
   {
      path: '/',
      name: 'customer.index',
      component: () => import( /* webpackChunkName: "post.index" */ '@/views/customer/Index.vue')
   },
   {
      path: '/create',
      name: 'customer.create',
      component: () => import( /* webpackChunkName: "post.create" */ '@/views/customer/Create.vue')
   },
   {
      path: '/edit/:id',
      name: 'customer.edit',
      component: () => import( /* webpackChunkName: "post.edit" */ '@/views/customer/Edit.vue')
   }
]

//create router
const router = createRouter({
    history: createWebHistory(),
    routes  // config routes
})

export default router