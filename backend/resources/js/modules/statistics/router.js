import router from  './../../router'
import Statisctics from './pages/Statisctics'

router.addRoutes([
    {
        path: '/statistics',
        name: 'statistics',
        component: Statisctics
    }
])