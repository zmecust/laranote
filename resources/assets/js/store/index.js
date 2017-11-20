import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        note: ''
    },
    mutations: {
        NOTE: (state, data) => {
            Vue.set(state, 'note', data);
        },
    }
});

export default store