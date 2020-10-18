//lazy load components
export const Home = resolve => {
    require.ensure(['./../components/pages/HomePage.vue'], () => {
        resolve(require('./../components/pages/HomePage.vue'));
    }, 'home');
};

export const App = resolve => {
    require.ensure(['./../App.vue'], () => {
        resolve(require('./../App.vue'));
    }, 'app');
};

export const Login = resolve => {
    require.ensure(['./../components/pages/Login.vue'], () => {
        resolve(require('./../components/pages/Login.vue'));
    }, 'login');
};

export const Register = resolve => {
    require.ensure(['./../components/pages/Register.vue'], () => {
        resolve(require('./../components/pages/Register.vue'));
    }, 'register');
};

export const ForgotPassword = resolve => {
    require.ensure(['./../components/pages/ForgotPassword.vue'], () => {
        resolve(require('./../components/pages/ForgotPassword.vue'));
    }, 'forgotPassword');
};

export const Messages = resolve => {
    require.ensure(['./../components/pages/ChatPage.vue'], () => {
        resolve(require('./../components/pages/ChatPage.vue'));
    }, 'messages');
};

export const ProfileHome = resolve => {
    require.ensure(['./../components/pages/ProfileHomePage.vue'], () => {
        resolve(require('./../components/pages/ProfileHomePage.vue'));
    }, 'profileHome');
};

export const ProfilePhotos = resolve => {
    require.ensure(['./../components/pages/ProfilePhotosPage.vue'], () => {
        resolve(require('./../components/pages/ProfilePhotosPage.vue'));
    }, 'profilePhotos');
};

export const ProfileAbout = resolve => {
    require.ensure(['./../components/pages/ProfileAboutPage.vue'], () => {
        resolve(require('./../components/pages/ProfileAboutPage.vue'));
    }, 'profileAbout');
};

export const MyMatches = resolve => {
    require.ensure(['./../components/pages/MyMatchesPage.vue'], () => {
        resolve(require('./../components/pages/MyMatchesPage.vue'));
    }, 'myMatches');
};