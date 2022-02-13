import {createRouter, createWebHashHistory} from "vue-router";

export default createRouter({
  history: createWebHashHistory(),
  routes: [
    {path: "/", component: () => import("../views/ListItems.vue")},
    {path: "/login", component: () => import("../views/Login.vue")},
    {path: "/register", component: () => import("../views/Register.vue")},
    {path: "/items", component: () => import("../views/ListItems.vue")},
    {path: "/items/:id", component: () => import("../views/ItemView.vue")},
    {path: "/categories/", component: () => import("../views/CategoriesView.vue")},
    {path: "/categories/:name", component: () => import("../views/ListItems.vue")},
    {path: "/admin/", component: () => import("../views/Admin/Admin.vue")},
    {path: "/admin/donations", component: () => import("../views/Admin/Admin.vue")},
    {path: "/admin/categories", component: () => import("../views/Admin/Categories.vue")},
    {path: "/payment", component: () => import("../views/Payment.vue")},
  ],
});

