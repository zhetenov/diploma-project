import store from './../../store'

const state = {
    users: []
}

const getters = {
    getUsers(state) {
        return state.users
    },
}

const mutations = {
    SET_USERS(state, users){
        state.users = users
    },
}

const actions = {
    fetchUsers({commit}, payload) {
        return axios.get('/api/users', {
            params: {
                page: payload
            }
        })
            .then((response) => {
                commit('SET_USERS', response.data)
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
    uploadData({commit}, payload) {
        return axios.post('/api/upload/data', payload)
            .then((response) => {
                Vue.$toast.open({
                    message: 'Data uploaded successfully',
                    type: 'success',
                    position: 'top-right',
                    duration: 5000
                });

                return true
            })
            .catch((error) => {
                Vue.$toast.open({
                    message: error,
                    type: 'error',
                    position: 'top-right',
                    duration: 5000
                });

                return false
            })
    }
}

store.registerModule('main', {
    state, getters, mutations, actions
})
