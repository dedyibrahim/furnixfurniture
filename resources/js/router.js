
import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)


import Login  from './components/Login.vue'
import Beranda  from './components/Beranda.vue'
import Home  from './components/Home.vue'
import Product  from './components/Product.vue'
import Search  from './components/Search.vue'
import DetailProduct  from './components/DetailProduct.vue'
import DetailBerita  from './components/DetailBerita.vue'
import News  from './components/News.vue'
import About  from './components/About.vue'
import Contact  from './components/Contact.vue'

import Dashboard  from './components/Dashboard/Dashboard.vue'
import DataProduk from './components/Dashboard/DataProduk.vue';
import DataKategori from './components/Dashboard/DataKategori.vue';
import DataBerita from './components/Dashboard/DataBerita.vue';
import DataTamu  from './components/Dashboard/DataTamu.vue'
import DataBanner  from './components/Dashboard/DataBanner.vue'

let routes =[
    {
    path:'/',
    name :"Beranda",
    component:Beranda,
    children :[
        {
        path:'/',
        name :"Home",
        component:Home,
        },
        {
            path:'/',
            name :"Home",
            component:Home,
        },
        {
            path:'/product',
            name :"Product",
            component:Product,
        },
        {
            path:'/detail-produk',
            name :"Detail Product",
            component:DetailProduct,
        },
        {
            path:'/detail-berita',
            name :"Detail Berita",
            component:DetailBerita,
        },
        {
            path:'/News',
            name :"News",
            component:News,
        },
        {
            path:'/About',
            name :"About",
            component:About,
        },
        {
            path:'/Contact',
            name :"Contact",
            component:Contact,
        },
        {
            path:'/pencarian',
            name :'Pencarian',
            component:Search,
        }

    ]
    },{
    path:'/Login',
    name :"Login",
    component:Login,
    },{
        path:'/Dashboard',
        name :"Dashboard",
        component:Dashboard,
        children :[{
            path :'/Dashboard',
            name :"DataTamu",
            component:DataTamu
            },
            {
                path :'/Dashboard/data-produk',
                name :"DataProduk",
                component:DataProduk
              },
              {
                path :'/Dashboard/data-kategori',
                name :"DataKategori",
                component:DataKategori
              },
              {
                path :'/Dashboard/data-berita',
                name :"Data Berita",
                component:DataBerita
              },
              {
                path :'/Dashboard/data-banner',
                name :"Data Banner",
                component:DataBanner
              }]

    }
]


export const router = new VueRouter({
    mode:"history",
    routes
});
