import Vue from 'vue';
import Router from 'vue-router';
import Nprogress from 'nprogress';

/////////////////////////////////////////////////////////////////////
////////////////////////////  ROUTES  ///////////////////////////////
/////////////////////////////////////////////////////////////////////
import {
    BaseAuth,
    CustomerAuth,
    ShopAuth
} from './auth';
import SuperAdminRoutes from './super-admin';
import CompanyAdminRoutes from './company-admin';
import BranchAdminRoutes from './branch-admin';
import CustomerRoutes from './customer';
import ShopSellingRoutes from './shop';

import PageNotFound from '../views/partials/pages/page404';
import Room from '../views/shop/room/index.vue';

Vue.use(Router)

var routers = [];
routers = [
    BaseAuth,
    CustomerAuth,
    ShopAuth,
    CompanyAdminRoutes,
    ShopSellingRoutes,
    SuperAdminRoutes,
    CustomerRoutes,
    BranchAdminRoutes,
    {
        path: '/room-tab',
        component: Room
    },
    {
        // Page Not Found
        path: '*',
        component: PageNotFound
    }
];

var router = new Router({
    mode: 'history',
    routes: routers,
});

// ------------------------------------------------------------------------------------
// ------------------ Config Navigations guards before each v2 ------------------------
// ------------------------------------------------------------------------------------

router.beforeEach((to, from, next) => {

    Nprogress.start();
    const authUser = JSON.parse(localStorage.getItem('user'));
    const token = localStorage.getItem('access_token');

    if (to.meta.requiresAuth) {
        if (!token) {
            if (to.meta.adminAuth || to.meta.companyAuth || to.meta.branchAuth) {
                next({
                    path: '/login'
                });
            }
            if (to.meta.shopAuth) {
                next({
                    path: '/shop/login'
                });
            }
            if (to.meta.customerAuth) {
                next({
                    path: '/customer/login'
                });
            }
        } else if (to.meta.adminAuth) {

            if (authUser.role_id == "1") {

                next();
            } else {

                next({
                    path: '/company-admin/dashboard'
                });
            }
        } else if (to.meta.companyAuth) {

            if (authUser.role_id == "2") {

                next();
            } else {
                next({
                    path: '/super-admin/dashboard'
                });
            }
        } else if (to.meta.branchAuth) {

            if (authUser.role_id == "3") {

                next();
            } else {

                next({
                    path: '/branch-admin/dashboard'
                });
            }
        } else if (to.meta.customerAuth) {

            if (authUser.role_id == '4') {

                next()
            } else {

                next({
                    path: '/customer/login'
                })
            }
        } else if (to.meta.shopAuth) {

            if (authUser.role_id == '5') {

                next()
            } else {

                next({
                    path: '/shop/login'
                })
            }
        }
    } else {
        if (to.path === '/login') {
            if (token) {
                if (authUser.role_id == "1") {

                    next({
                        path: '/super-admin/dashboard'
                    });
                } else if (authUser.role_id == "2") {

                    next({
                        path: '/company-admin/dashboard'
                    });
                } else if (authUser.role_id == "3") {

                    next({
                        path: '/branch-admin/dashboard'
                    })
                }
            }
        }
        if (to.path === '/customer/login') {
            if (token) {
                if (authUser.role_id == "4") {

                    next({
                        path: '/customer/photos'
                    });
                }
            }
        }
        if (to.path === '/shop/login') {
            if (token) {
                if (authUser.role_id == "5") {

                    next({
                        path: 'shop/dashboard'
                    })
                }
            }
        }
        next()
    }

    if (to.meta.requiresRoom) {
        const roomLogin = JSON.parse(localStorage.getItem('roomLogin'))

        if (roomLogin) {

            next({
                path: '/shop/photos'
            })
        } else {

            next({
                path: '/shop/dashboard'
            })
        }
    }
});

// Navigation guard after each
router.afterEach((to, from) => {
    Nprogress.done()
    setTimeout(() => {
        const contentWrapper = document.querySelector(".v-content__wrap");
        if (contentWrapper !== null) {
            contentWrapper.scrollTop = 0;
        }
        const boxedLayout = document.querySelector('.app-boxed-layout .app-content');
        if (boxedLayout !== null) {
            boxedLayout.scrollTop = 0;
        }
        const miniLayout = document.querySelector('.app-mini-layout .app-content');
        if (miniLayout !== null) {
            miniLayout.scrollTop = 0;
        }
    }, 200);
})

export default router;
