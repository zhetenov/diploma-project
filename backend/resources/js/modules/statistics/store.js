import store from './../../store'

const state = {
    mainStatisctics: []
}

const getters = {
    getMainStatistics(state) {
        return state.mainStatisctics
    }
}


const mutations = {
    SET_STATISTICS(state, statistics) {
        state.mainStatisctics = statistics
    }
}

const actions = {
    fetchStatistics({commit}) {
        return axios.get('/api/statistics')
            .then((response) => {
                commit('SET_STATISTICS', response.data)
                console.log('ress',response)
                Vue.$toast.open({
                    message: 'Data received successfully',
                    type: 'success',
                    position: 'top-right',
                    duration: 5000
                });
            })
            .catch((error) => {
                Vue.$toast.open({
                    message: error,
                    type: 'error',
                    position: 'top-right',
                    duration: 5000
                });
            })
    }
}

store.registerModule('statistics', {
    state, getters, mutations, actions
})
