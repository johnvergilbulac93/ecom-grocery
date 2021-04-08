import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import landing_page from './components/admin/pages/Landing-page'
import item from './components/admin/pages/Item-masterfile'
import picker_time from './components/admin/pages/Picker_time'
import pickup from './components/admin/pages/Pickup_cutoff'
import disabled_item_batch from './components/admin/pages/Item-disabled-batch'
import home from './components/admin/pages/Dashboard'
import users from './components/admin/pages/Users'
import central_item from './components/admin/pages/Central-item'
import business_rule from './components/admin/pages/Business-rule'
import uploading from './components/admin/pages/Uploading'
import dashboard from './components/admin/pages/Dashboard-super'
import setting from './components/admin/pages/Setting'
import reports_store from './components/admin/pages/Reports-store'
import reports from './components/admin/pages/Reports'
import transaction from './components/admin/pages/Transactions'
import accountability from './components/admin/pages/Accountability-Report'
import exporting from './components/admin/pages/ExportFiles'
import liquidition from './components/admin/pages/Liquidition-Report'
import bu_time from './components/admin/pages/Business-time'
import tenant from './components/admin/pages/Tenants'
import count from './components/admin/pages/Available-item-store'
import disable_uom from './components/admin/pages/Item-disable-per-uom'
import enable_uom from './components/admin/pages/Item-enable-per-uom'
import minimum_delivery from './components/admin/pages/Minimum-order-delivery'
import delivery_charges from './components/admin/pages/Delivery-charges'
import multiple from './components/admin/pages/Multiple-images'
import liquidition_store from './components/admin/pages/Liquidition-Report-Store'
import accountability_store from './components/admin/pages/Accountability-Report-Store'
import menu from './components/admin/pages/Menu'
import viewcharge from './components/admin/pages/View-Charge'


const routes = [

    {
        path: '/',
        name: 'main-page',
        component: landing_page

    },
    {
        path: '/home',
        name: 'home',
        component: home,
        beforeEnter: (to, from, next) => {
            if (to.params.id != 12) {
                next();
            } else {
                next('/');
            }
        }
    },
    {
        path: '/item',
        name: 'item',
        component: item,       
         beforeEnter: (to, from, next) => {
            if (to.params.id === 15 || to.params.id === 6) {
                next();
            }else{
                next('/');
            }
        }
    },
    {
        path: '/uploading',
        name: 'uploading',
        component: uploading,
        beforeEnter: (to, from, next) => {
            if (to.params.id === 6 || from.params.id === 12) {
                next();
            } else {
                next('/');
            }
        }
    },
    {
        path: '/business_rules',
        name: 'business_rule',
        component: business_rule,
        beforeEnter: (to, from, next) => {
            if (from.params.id === 12) {
                next()
            } else {
                next('/');
            }
        }
    },
    {
        path: '/picker_time',
        name: 'picker_time',
        component: picker_time,
        beforeEnter: (to, from, next) => {
            if (to.params.id === 6) {
                next();
            } else {
                next('/');
            }
        }
    },
    {
        path: '/users',
        name: 'users',
        component: users,
        beforeEnter: (to, from, next) => {
            if (from.params.id === 12) {
                next();
            } else {
                next('/');
            }
        }
    },
    {
        path: '/central_item',
        name: 'central_item',
        component: central_item,
        beforeEnter: (to, from, next) => {
            if (from.params.id === 15 || from.params.id === 12) {
                next();
            } else {
                next('/');
            }
        }
    },
    {
        path: '/pickup',
        name: 'pickup',
        component: pickup,
        beforeEnter: (to, from, next) => {
            if (to.params.id === 6) {
                next();
            } else {
                next('/');
            }
        }
    },
    {
        path: '/disabled_item_batch',
        name: 'disabled_item',
        component: disabled_item_batch,
        beforeEnter: (to, from, next) => {
            if (to.params.id === 15) {
                next();
            } else {
                next('/');
            }
        }
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: dashboard,
        beforeEnter: (to, from, next) => {
            if (to.params.id === 12) {
                next();
            } else {
                next('/');
            }
        }
    },
    {
        path: '/setting',
        name: 'setting',
        component: setting,
        beforeEnter: (to, from, next) => {
            if (to.params.id === 6 || from.params.id === 12) {
                next();
            } else {
                next('/');
            }
        }
    },
    {
        path: '/reports',
        name: 'report_item',
        component: reports,
        beforeEnter: (to, from, next) => {
            if (from.params.id === 12) {
                next();
            } else {
                next('/');
            }
        }

    },
    {
        path: '/reports_store',
        name: 'reports_store',
        component: reports_store,
        beforeEnter: (to, from, next) => {
            if (to.params.id === 15 || to.params.id === 6) {
                next();
            } else {
                next('/');
            }
        }

    },
    {
        path: '/transaction',
        name: 'transaction',
        component: transaction,
        beforeEnter: (to, from, next) => {
            if (from.params.id === 12) {
                next();
            } else {
                next('/');
            }
        }
    },
    {
        path: '/exporting',
        name: 'export',
        component: exporting,
        beforeEnter: (to, from, next) => {
            if (to.params.id === 8 || from.params.id === 12) {
                next();
            } else {
                next('/');
            }
        }
    },
    {
        path: '/accountability',
        name: 'accountability',
        component: accountability,
        beforeEnter: (to, from, next) => {
            if (from.params.id === 12) {
                next();
            } else {
                next('/');
            }
        }
    },
    {
        path: '/liquidition',
        name: 'liquidition',
        component: liquidition,
        beforeEnter: (to, from, next) => {
            if (from.params.id === 12) {
                next();
            } else {
                next('/');
            }
        }
    },
    {
        path: '/bu_time',
        name: 'bu_time',
        component: bu_time,
        beforeEnter: (to, from, next) => {
            if (from.params.id === 12) {
                next();
            } else {
                next('/');
            }
        }
    },
    {
        path: '/tenant',
        name: 'tenant',
        component: tenant,
        beforeEnter: (to, from, next) => {
            if (from.params.id === 12) {
                next();
            } else {
                next('/');
            }
        }
    },
    {
        path: '/count',
        name: 'count',
        component: count,
        beforeEnter: (to, from, next) => {
            if (from.params.id === 12) {
                next();
            } else {
                next('/');
            }
        }
    },
    {
        path: '/disable_uom',
        name: 'disable_uom',
        component: disable_uom,
        beforeEnter: (to, from, next) => {
            if (from.params.id === 12) {
                next();
            } else {
                next('/');
            }
        }
    },
    {
        path: '/enable_uom',
        name: 'enable_uom',
        component: enable_uom,
        beforeEnter: (to, from, next) => {
            if (from.params.id === 12) {
                next();
            } else {
                next('/');
            }
        }
    },
    {
        path: '/minimum_delivery',
        name: 'minimum_delivery',
        component: minimum_delivery,
        beforeEnter: (to, from, next) => {
            if (from.params.id === 12) {
                next();
            } else {
                next('/');
            }
        }
    },
    {
        path: '/delivery_charges',
        name: 'delivery_charges',
        component: delivery_charges,
        // beforeEnter: (to, from, next) => {
        //     if (from.params.id === 12) {
        //         next();
        //     } else {
        //         next('/');
        //     }
        // }
    },
    {
        path: '/multiple',
        name: 'multiple',
        component: multiple,
        beforeEnter: (to, from, next) => {
            if (from.params.id === 12 || to.params.id === 6) {
                next();
            } else {
                next('/');
            }
        }
    },
    {
        path: '/liquidition_store',
        name: 'liquidition_store',
        component: liquidition_store,
        beforeEnter: (to, from, next) => {
            if (to.params.id === 7 || to.params.id === 14) {
                next();
            } else {
                next('/');
            }
        }
    },
    {
        path: '/accountability_store',
        name: 'accountability_store',
        component: accountability_store,
        beforeEnter: (to, from, next) => {
            if (to.params.id === 7) {
                next();
            } else {
                next('/');
            }
        }
    },
    {
        path: '/menu',
        name: 'menu',
        component: menu,
        beforeEnter: (to, from, next) => {
            if (to.params.id === 12) {
                next();
            } else {
                next('/');
            }
        }
    },
    {
        path: '/charge/:chrg_id',
        name: 'viewcharge',
        component: viewcharge,
        props: true

    },



]
export default new VueRouter({
    mode: 'history',
    routes,
})
