const Welcome = () => import('./components/Welcome.vue' /* webpackChunkName: "resource/js/components/welcome" */)
const ShipperList = () => import('./components/shipper/List.vue' /* webpackChunkName: "resource/js/components/shipper/list" */)
const ShipperCreate = () => import('./components/shipper/Add.vue' /* webpackChunkName: "resource/js/components/shipper/add" */)
const ShipperEdit = () => import('./components/shipper/Edit.vue' /* webpackChunkName: "resource/js/components/shipper/edit" */)

export const routes = [
    {
        name: 'shipperList',
        path: '/',
        component: ShipperList
    },
    {
        name: 'shipperEdit',
        path: '/shipper/:id/edit',
        component: ShipperEdit
    },
    {
        name: 'shipperAdd',
        path: '/shipper/add',
        component: ShipperCreate
    }
]