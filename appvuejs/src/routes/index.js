import {createRouter, createWebHashHistory} from "vue-router";

export default createRouter({
  history: createWebHashHistory(),
  routes: [
    {path: "/", component: () => import("../views/ListItems.vue")},
    {path: "/login", component: () => import("../views/Login.vue")},
    {path: "/register", component: () => import("../views/Register.vue")},
    {path: "/items", component: () => import("../views/ListItems.vue")},
    {path: "/items/:id", component: () => import("../views/ItemView.vue")},
    {path: "/categories", component: () => import("../views/CategoriesView.vue")},
    {path: "/categories/:id", component: () => import("../views/ListItems.vue")},
    {path: "/admin/donations", component: () => import("../views/Admin/Donations.vue")},
    {path: "/admin/categories", component: () => import("../views/Admin/Categories.vue")},
    {path: "/payment", component: () => import("../views/Payment.vue")},
    {path: "/admin/pieces", component: () => import("../views/Admin/Pieces.vue")},
    {path: "/payment/confirmation", component: () => import("../views/PaymentConfirmation.vue")},
  ],
});

