import Vue                         from 'vue'
import VueRouter                   from 'vue-router'

Vue.use(VueRouter)

import landing_page                from './components/admin/pages/Landing_page'
import item                        from './components/admin/pages/Item_masterfile'
import picker_time                 from './components/admin/pages/Picker_time'
import pickup                      from './components/admin/pages/Pickup_cutoff'
import disabled_item_batch         from './components/admin/pages/Item_disabled_batch'
import home                        from './components/admin/pages/Dashboard'
import users                       from './components/admin/pages/Users'
import central_item                from './components/admin/pages/Central_item'
import business_rule               from './components/admin/pages/Business_rule'
import uploading                   from './components/admin/pages/Uploading'
import dashboard                   from './components/admin/pages/Dashboard_super'
import setting                     from './components/admin/pages/Setting'
import reports_store               from './components/admin/pages/Reports_store'
import reports                     from './components/admin/pages/Reports'
import transaction                 from './components/admin/pages/Transactions'
import accountability              from './components/admin/pages/Accountability_Report'
import exporting                   from './components/admin/pages/ExportFiles'
import liquidition                 from './components/admin/pages/Liquidition_Report'
import bu_time                     from './components/admin/pages/Business_time'
import tenant                      from './components/admin/pages/Tenants'
import count                       from './components/admin/pages/Available_item_store'
import disable_uom                 from './components/admin/pages/Item_disable_per_uom'
import enable_uom                  from './components/admin/pages/Item_enable_per_uom'
import minimum_delivery            from './components/admin/pages/Minimum_order_delivery'
import delivery_charges            from './components/admin/pages/Delivery_charges'



const routes = [
    
     { path: '/',                   component: landing_page},
     { 
         path: '/home',
         name: 'home',
         component: home,
         beforeEnter: (to, from, next) => {
            if(to.params.id === 6)
            {
                next();
            }else{
                next('/');
            }
        }
     },    
     { 
         path: '/item',
         name: 'item',               
         component: item,
         beforeEnter: (to, from, next) => {
            if(to.params.id === 15  || to.params.id === 6)
            {
                next();
            }else{
                next('/');
            }
        }
     },
     { 
         path: '/uploading',
         name:'uploading', 
         component: uploading,
         beforeEnter: (to, from, next) => {
            if(to.params.id === 6 || to.params.id === 12)
            {
                next();
            }else{
                next('/');
            }
        }
    },
     { 
         path: '/business_rule',
         name: 'business_rule',      
         component: business_rule,
         beforeEnter: (to, from, next) => {
            if(to.params.id === 12)
            {
                next();
            }else{
                next('/');
            }
        }
     },
     {          
        path: '/picker_time', 
        name: 'picker_time',
        component: picker_time,
        beforeEnter: (to, from, next) => {
            if(window.user === 6)
            {
                next();
            }else{
                next('/');
            }
        }
    },
     { 
         path: '/users', 
         name: 'users',
         component: users,
         beforeEnter: (to, from, next) => {
            if(window.user === 12)
            {
                next();
            }else{
                next('/');
            }
        }
     },
     { 
         path: '/central_item',
         name:'central_item',        
         component: central_item,
         beforeEnter: (to, from, next) => {
            if(to.params.id === 15 || to.params.id === 12)
            {
                next();
            }else{
                next('/');
            }
        }
     },
     {          
        path: '/pickup',          
        name: 'pickup',            
        component: pickup,
        beforeEnter: (to, from, next) => {
            if(to.params.id === 6)
            {
                next();
            }else{
                next('/');
            }
        }
     },
     { 
         path: '/disabled_item_batch',
         name: 'disabled_item',
         component: disabled_item_batch,
         beforeEnter: (to, from, next) => {
            if(to.params.id === 15)
            {
                next();
            }else{
                next('/');
            }
        }
     },
     { 
         path: '/dashboard',          
         name: 'dashboard',            
         component: dashboard,
         beforeEnter: (to, from, next) => {
            if(to.params.id === 12)
            {
                next();
            }else{
                next('/');
            }
        }
     },
     { 
         path: '/setting',
         name: 'setting',            
         component: setting,
         beforeEnter: (to, from, next) => {
            if(to.params.id === 6 || to.params.id === 12)
            {
                next();
            }else{
                next('/');
            }
        }
     },
     { 
         path: '/reports',
         name: 'report_item',            
         component: reports,
         beforeEnter: (to, from, next) => {
            if(to.params.id === 12)
            {
                next();
            }else{
                next('/');
            }
        }
    
     },
     { 
        path: '/reports_store',
        name: 'reports_store',            
        component: reports_store,
        beforeEnter: (to, from, next) => {
           if(to.params.id === 15 || to.params.id === 6)
           {
               next();
           }else{
               next('/');
           }
       }
   
     },
     { 
         path: '/transaction',
         name: 'transaction',
         component: transaction,
         beforeEnter: (to, from, next) => {
            if(to.params.id === 17 || to.params.id === 12)
            {
                next();
            }else{
                next('/');
            }
        }
     },
     { 
         path: '/exporting',
         name: 'export',          
         component: exporting,
         beforeEnter: (to, from, next) => {
            if(to.params.id === 8 || to.params.id === 12)
            {
                next();
            }else{
                next('/');
            }
        }
     },
     { 
         path: '/accountability', 
         name: 'accountability',
         component: accountability,
         beforeEnter: (to, from, next) => {
            if(to.params.id === 7 || to.params.id === 12)
            {
                next();
            }else{
                next('/');
            }
        }
    },
    { 
        path: '/liquidition', 
        name: 'liquidition',
        component: liquidition,
        beforeEnter: (to, from, next) => {
           if(to.params.id === 14 || to.params.id === 12 )
           {
               next();
           }else{
               next('/');
           }
        }
   },
   { 
        path: '/bu_time', 
        name: 'bu_time',
        component: bu_time,
        beforeEnter: (to, from, next) => {
            if(to.params.id === 12)
            {
                next();
            }else{
                next('/');
            }
        }
   },
   { 
        path: '/tenant', 
        name: 'tenant',
        component: tenant,
        beforeEnter: (to, from, next) => {
            if(to.params.id === 12)
            {
                next();
            }else{
                next('/');
            }
        }
    },
    { 
        path: '/count', 
        name: 'count',
        component: count,
        beforeEnter: (to, from, next) => {
           if(to.params.id === 12)
           {
               next();
           }else{
               next('/');
           }
        }
    },
    { 
        path: '/disable_uom', 
        name: 'disable_uom',
        component: disable_uom,
        beforeEnter: (to, from, next) => {
           if(to.params.id === 12)
           {
               next();
           }else{
               next('/');
           }
        }
    },
    { 
        path: '/enable_uom', 
        name: 'enable_uom',
        component: enable_uom,
        beforeEnter: (to, from, next) => {
           if(to.params.id === 12)
           {
               next();
           }else{
               next('/');
           }
        }
    },
    { 
        path: '/minimum_delivery', 
        name: 'minimum_delivery',
        component: minimum_delivery,
        beforeEnter: (to, from, next) => {
           if(to.params.id === 12)
           {
               next();
           }else{
               next('/');
           }
        }
    },
    { 
        path: '/delivery_charges', 
        name: 'delivery_charges',
        component: delivery_charges,
        beforeEnter: (to, from, next) => {
           if(to.params.id === 12)
           {
               next();
           }else{
               next('/');
           }
        }
    },
    

 ]
 export default  new VueRouter({
     mode: 'history',
     routes,
 })

