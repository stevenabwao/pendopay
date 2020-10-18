import  { 
            App,
            Home, 
            Login, 
            Register, 
            ForgotPassword, 
            Messages, 
            MyMatches,
            ProfileHome, 
            ProfilePhotos,
            ProfileAbout 
        } 
        from './mainsiteroutes.js';
        
import  { 
            AdminHome,
            AdminCreateUser
        } 
        from './adminroutes.js';

export const routes = [

    { path: '/', component: Home, name: 'home', meta: { requiresAuth: true } },
    { path: '/login', component: Login, name: 'login' },
    { path: '/register', component: Register, name: 'register' },
    { path: '/forgot-password', component: ForgotPassword, name: 'forgotPassword' },
    { path: '/messages', component: Messages, name: 'messages', meta: { requiresAuth: true } },
    { path: '/matches', component: MyMatches, name: 'myMatches', meta: { requiresAuth: true } },
    { path: '/profile', component: ProfileHome, name: 'profileHome', meta: { requiresAuth: true } },
    { path: '/profile/:id', component: ProfileHome, name: 'profileHomeId', meta: { requiresAuth: true } },
    { path: '/profile/:id/about', component: ProfileAbout, name: 'profileAbout', meta: { requiresAuth: true } },
    { path: '/profile/:id/photos', component: ProfilePhotos, name: 'profilePhotos', meta: { requiresAuth: true } },
    //{ path: '/profile', component: ProfileHome, name: 'profileHome' , children: [
        /*{ path: 'about', component: ProfileAbout, name: 'profileAbout' },
        { path: 'photos', component: ProfilePhotos, name: 'profilePhotos' }*/
        /*{ path: ':id/edit', component: ProfileEdit, beforeEnter: (to, from, next) => {
            next();
        } }*/
    //]},

    { path: '/admin', component: AdminHome, name: 'adminhome', meta: { requiresAuth: true } },
    { path: '/admin/user/create', component: AdminCreateUser, name: 'admincreateuser', meta: { requiresAuth: true } },
    /*{ path: '/admin/users', component: AdminHome, name: 'adminhome' },
    
    { path: '/admin/user/edit', component: AdminHome, name: 'adminhome' },
    { path: '/admin/roles', component: AdminHome, name: 'adminhome' },
    { path: '/admin/role/create', component: AdminHome, name: 'adminhome' },
    { path: '/admin/role/edit', component: AdminHome, name: 'adminhome' },*/

    { path: '/redirect-me', redirect: { name: 'home' } },
    { path: '*', redirect: { name: 'home' } }

];