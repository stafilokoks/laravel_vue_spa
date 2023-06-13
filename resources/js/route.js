import {createRouter, createWebHistory} from 'vue-router';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/login',
            name: 'Login',
            component: () => import('./vue/pages/Login.vue')
        },
        {
            path: '/register',
            name: 'Register',
            component: () => import('./vue/pages/Register.vue')
        },
        {
            path: '/',
            name: 'Index',
            component: () => import('./vue/pages/Index.vue'),
            props: true
        }
    ],
})

router.beforeEach((to, from) => {
    if (to.name !== 'Login' && to.name !== 'Register' && !isAuthenticated()) {
        return {name: 'Login'};
    }
})

function isAuthenticated() {
    return Boolean(localStorage.getItem('USER_TOKEN'))
}


export default router;
