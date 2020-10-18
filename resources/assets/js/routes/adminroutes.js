//lazy load components
export const AdminHome = resolve => {
    require.ensure(['./../components/admin/HomePage.vue'], () => {
        resolve(require('./../components/admin/HomePage.vue'));
    }, 'adminhome');
};

export const AdminCreateUser = resolve => {
    require.ensure(['./../components/admin/CreateUser.vue'], () => {
        resolve(require('./../components/admin/CreateUser.vue'));
    }, 'admincreateuser');
};
