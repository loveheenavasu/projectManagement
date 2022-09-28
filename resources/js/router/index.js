import { createRouter, createWebHistory } from 'vue-router'

import login from '../components/login'
import register from '../components/register'
import dashboard from '../components/dashboard'
import Welcome from '../components/Welcome'
import adduser from '../components/adduser'
import edituser from '../components/edituser'
import userList from '../components/userList'

const routes = [
    {
        path: "/",
        name: "Welcome",
        component: Welcome,
      },
    {
        path: '/login',
        name: 'login',
        component: login
    },
    {
        path: '/register',
        name: 'register',
        component: register
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: dashboard
    },
    {
        path: '/add-user',
        name: 'adduser',
        component: adduser
    },
    {
        path: '/user-list',
        name: 'userList',
        component: userList
    },
    {
        path: '/user-edit/:id',
        name: 'edituser',
        component: edituser
    }
]



const router=createRouter({
    history: createWebHistory(),
    routes
});
export default router;

