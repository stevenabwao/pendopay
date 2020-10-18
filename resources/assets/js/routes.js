//lazy load components
const Home = resolve => {
    require.ensure(['./components/pages/Home.vue'], () => {
        resolve(require('./components/pages/Home.vue'));
    }, 'home');
};

const Dashboard = resolve => {
    require.ensure(['./components/pages/Dashboard.vue'], () => {
        resolve(require('./components/pages/Dashboard.vue'));
    }, 'dashboard');
};

const Chat = resolve => {
    require.ensure(['./components/pages/ChatPage.vue'], () => {
        resolve(require('./components/pages/ChatPage.vue'));
    }, 'chat');
};

const Login = resolve => {
    require.ensure(['./components/pages/Login.vue'], () => {
        resolve(require('./components/pages/Login.vue'));
    }, 'login');
};

const ChatUserList = resolve => {
    require.ensure(['./components/chat/ChatUserList.vue'], () => {
        resolve(require('./components/chat/ChatUserList.vue'));
    }, 'chatUserList');
};

export const routes = [
    
    { path: '/', component: Home, name: 'home' },
    { path: '/login', component: Login, name: 'login' },
    { path: '/dashboard', component: Dashboard, name: 'dashboard' },
    { path: '/chat', component: Chat, name: 'chat' , children: [
        { path: 'chatUsers', component: ChatUserList, name: 'chatUserList' },
        /*{ path: ':id/edit', component: ProfileEdit, beforeEnter: (to, from, next) => 
            {
                next();
            } 
        }*/
    ]},
    { path: '/redirect-me', redirect: { name: 'home' } },
    { path: '*', redirect: { name: 'home' } }

];