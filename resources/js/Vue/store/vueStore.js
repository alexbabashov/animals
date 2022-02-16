
import {createStore} from 'vuex'
import {moduleAnimals} from './module-animals.js';

export const store = createStore({
    modules: {
        animals: moduleAnimals
    }
});
