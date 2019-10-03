import Vue from "vue";
import app from './app';
import Home from "./components/Home";
import Menu from "./components/menu/Menu";
import Users from "./components/menu/Users";
import Product from "./components/menu/Products";
import Category from "./components/menu/Categories";
import Reservation from "./components/menu/Reservations";
import Profile from "./components/menu/Profile";
import Userboard from "./components/menu/Userboard";
import Orders from "./components/menu/Orders";
import Products from "./components/Products/ProductsList";
import Details from "./components/Products/Details";
import NotFound from "./components/NotFound";
import Gate from './Gate';
Vue.prototype.$gate = new Gate(window.user);

import VueRouter from 'vue-router';
Vue.use(VueRouter);

let routes = [
    { path: "/", name: "Home", component: Home },
    { path: '/products', name: "Products", component: Products },
    { path: '/details', name: "Details", component: Details },
    { path: '*', name: "NotFound", component: NotFound },
    {
        path: '/menu', name: "Menu", component: Menu, meta: { requiresAuth: true },
        children: [
            { path: "/users", name: "Users", component: Users },
            { path: "/product", name: "Product", component: Product },
            { path: "/categories", name: "Category", component: Category },
            { path: "/reservations", name: "Reservation", component: Reservation },
            { path: "/profile", name: "Profile", component: Profile },
            { path: "/userboard", name: "Userboard", component: Userboard },
            { path: "/orders", name: "Orders", component: Orders },
        ]
    },
];

Vue.component('Navbar', require('./components/Navbar.vue').default);
Vue.component('products-component', require('./components/Products/Products.vue').default);
Vue.component('productsCategory', require('./components/Products/ProductsCategory.vue').default);
Vue.component('add-to-compare', require('./components/Compare/AddToCompare.vue').default);
Vue.component('miniList', require('./components/Compare/MiniList.vue').default);
Vue.component('compare', require('./components/Compare/CompareList.vue').default);
Vue.component('miniReservation', require('./components/Reservation/Reservation.vue').default);
Vue.component('Hero', require('./components/Hero.vue').default);
Vue.component('Footer', require('./components/Footer.vue').default);

const router = new VueRouter({
    mode: 'history',
    routes,
    base: process.env.BASE_URL,
    scrollBehavior (to, from, savedPosition) {
        return { x: 0, y: 0 };
    },
})

router.beforeResolve((to, from, next) => {
    const requiresAuth = to.matched.some(x => x.meta.requiresAuth);

    const currentUser = Vue.prototype.$gate.user == undefined ? true : false;

    if (requiresAuth && currentUser) {
        next('/')
    } else if (requiresAuth && !currentUser) {
        next()
    } else {
        next()
    }
})


export default router;