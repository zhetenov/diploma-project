import store from './../../store'

const state = {
    classifications: [],
    users_without_graph: [],
    loading: false
}

const getters = {
    getClassifications(state) {
        return state.classifications
    },
    getUsersWithoutGraph(state) {
        return state.users_without_graph
    },
    getLoading(state) {
        return state.loading
    }
}

const mutations = {
    SET_CLASSIFICATIONS(state, classifications) {
        state.classifications = classifications
    },
    SET_USERS_WITHOUT_GRAPH(state, users) {
        state.users_without_graph = users
    },
    SET_LOADING(state, loading) {
        state.loading = loading
    }
}

const actions = {
    makeClassification({commit}) {
        commit('SET_LOADING', true)
        return axios.post('/api/rfm')
            .then((response) => {
                commit('SET_LOADING', false)
            })
            .catch((error) => {
                commit('SET_LOADING', false)
                Vue.$toast.open({
                    message: error,
                    type: 'error',
                    position: 'top-right',
                    duration: 5000
                });
            })
    },
    fetchRfm({commit}) {
        commit('SET_LOADING', true)
        return axios.get('/api/rfm/get')
            .then((response) => {
                console.log(response);
                commit('SET_LOADING', false)
                commit('SET_CLASSIFICATIONS', response.data)
                Vue.$toast.open({
                    message: 'Data received successfully',
                    type: 'success',
                    position: 'top-right',
                    duration: 5000
                });
            })
            .catch((error) => {
                commit('SET_LOADING', false)
                Vue.$toast.open({
                    message: error,
                    type: 'error',
                    position: 'top-right',
                    duration: 5000
                });
            })
    },
    fetchUsersWithoutGraph({commit}, payload) {
        commit('SET_LOADING', true)
        return axios.get('/api/users/without/graph', {
            params: {
                page: payload.page,
                name: payload.name ?? null,
                email: payload.email ?? null,
                rfm: payload.rfm ?? null
            }
        })
            .then((response) => {
                commit('SET_LOADING', false)
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
    fetchUsersWithoutGraphFile({commit}, payload) {
        commit('SET_LOADING', true)
        return axios('/api/users/without/graph/file', {
            params: {
                page: payload.page,
                name: payload.name ?? null,
                email: payload.email ?? null,
                rfm: payload.rfm ?? null
            }
        })
            .then((response) => {
                console.log(response)
            })
            .catch((error) => {

            })
    },
}

store.registerModule('rfm', {
    state, getters, mutations, actions
})
