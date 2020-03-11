import router from  './../../router'
import Users from './pages/Users'

router.addRoutes([
    {
        path: '/users',
        name: 'users',
        component: Users
    }
])