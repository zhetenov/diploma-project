import router from  './../../router'
import IndexMailing from './pages/IndexMailing'

router.addRoutes([
    {
        path: '/mailing',
        name: 'mailing',
        component: IndexMailing
    }
])