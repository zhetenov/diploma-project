import store from './../../store'

const state = {
    classifications: [],
    users_without_graph: []
}

const getters = {
    getClassifications(state) {
        return state.classifications
    },
    getUsersWithoutGraph(state) {
        return state.users_without_graph
    }
}

const mutations = {
    SET_CLASSIFICATIONS(state, classifications) {
        state.classifications = classifications
    },
    SET_USERS_WITHOUT_GRAPH(state, users) {
        state.users_without_graph = users
    },
}

const actions = {
    makeClassification({commit}) {
        return axios.post('/api/rfm')
            .then((response) => {

            })
            .catch((error) => {
                Vue.$toast.open({
                    message: error,
                    type: 'error',
                    position: 'top-right',
                    duration: 5000
                });
            })
    },
    fetchRfm({commit}) {
        return axios.get('/api/rfm/get')
            .then((response) => {
                commit('SET_CLASSIFICATIONS', response.data)
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
    },
    fetchUsersWithoutGraph({commit}, payload) {
        return axios.get('/api/users/without/graph', {
            params: {
                page: payload
            }
        })
            .then((response) => {
                commit('SET_USERS_WITHOUT_GRAPH', response.data)
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
    },
}

store.registerModule('rfm', {
    state, getters, mutations, actions
})
