import store from './../../store'

const state = {

}

const getters = {

}

const mutations = {

}

const actions = {
    sendEmail({commit}, payload) {
        return axios.post('/api/mailing/send', payload)
            .then((response) => {
                Vue.$toast.open({
                    message: 'Email sent successfully',
                    type: 'success',
                    position: 'top-right',
                    duration:5000
                });
                return true

            })
            .catch((error) => {
                Vue.$toast.open({
                    message: error,
                    type: 'error',
                    position: 'top-right',
                    duration:5000
                });
                return false
            })
    }
}

store.registerModule('mailing', {
    state, getters, mutations, actions
})
