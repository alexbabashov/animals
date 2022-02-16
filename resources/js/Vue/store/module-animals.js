
import _ from 'lodash';
import AjaxReq from './ajax-req.js';

export const moduleAnimals = {
    state() {
        return {
            requestObj: new AjaxReq(),
            isBlockButtons: false,
            listKindAnimals: null,
            listActiveAnimals: null,
            sizeRatio:0,
        };
    },
    getters: {
        getNameByKind: (state, getters) => (nameKind) =>  {
            let name = "";
            if(String(nameKind) === "cat"){ name = "Simon"; }
                        else if(String(nameKind) === "dog"){ name = "Bob"; }
                        else if(String(nameKind) === "bird"){ name = "Philip"; }
                        else if(String(nameKind) === "bear"){ name = "Lex"; };
            return name;
        },
        isKindCreated: (state, getters) => (nameKind) =>  {
            let nameAnimals = getters.getNameByKind(nameKind);
            return (null != getters.getAnimalByName(nameAnimals)) || state.blockRequestCreate;
        },
        urlAvatarOfKind: (state, getters) => (nameKind) =>  {
            let objKind = getters.getKind(nameKind);
            if (objKind != null) {
                return objKind.avatar;
            } else {
                return "";
            }
        },
        isBlockButtons(state){
            return state.isBlockButtons;
        },
        getListKinds(state){
            return state.listKindAnimals;
        },
        isListKindsNotNull(state){
            return ((state.listKindAnimals != null) && (state.listKindAnimals.size > 0));
        },
        getKind: (state) => (nameKind) =>  {
             if ( state.listKindAnimals != null && state.listKindAnimals.has(nameKind)) {
                return state.listKindAnimals.get(nameKind);
            } else {
                return null;
            }
        },
        listActiveAnimals(state){
            return state.listActiveAnimals;
        },
        getAnimalByName: (state) => (nameAnimal) =>  {
            if ( state.listActiveAnimals != null && state.listActiveAnimals.has(nameAnimal)) {
               return state.listActiveAnimals.get(nameAnimal);
            } else {
               return null;
            }
        },
        getWidthAnimalByName: (state, getters) => (nameAnimal) => {
            let width = 0;
            if ( (state.listActiveAnimals != null)
                    && state.listActiveAnimals.has(nameAnimal)
            ){
                let animal = state.listActiveAnimals.get(nameAnimal);
                if(animal != null) {
                    //width = animal.size * (100 / animal.kind.size_max ) * state.sizeRatio;
                    width = animal.size * state.sizeRatio;
                }
            }
            return width;
        },
        isPossiblyIncreaseAge: (state, getters) => (nameAnimal) => {
            let isPossibly = false;
            let animal = getters.getAnimalByName(nameAnimal);
            if ( (animal != null)
                && (animal.size < animal.kind.size_max)
                && (animal.age < animal.kind.age_max)
                )
            {
                isPossibly = true;
            }
            return isPossibly;
        },
    },
    mutations: {
        setBlockButtons(state, isBlock){
            state.isBlockButtons = isBlock;
        },
        setListKind(state, data){
            if (_.isObject(data) && !_.isArray(data)) {
                state.listKindAnimals = new Map(Object.entries(data));
            } else {
                state.listKindAnimals = null;
            }
            if (state.listKindAnimals != null) {
                let maxKindSize = [...state.listKindAnimals.entries()].reduce((acc, curr) => {
                    return acc[1].size_max > curr[1].size_max ? acc : curr
                });
                state.sizeRatio = 100 / maxKindSize[1].size_max;
            }
            else {
                state.sizeRatio = 0;
            }
        },
        setActiveAnimals(state, data) {
            if (_.isObject(data) && !_.isArray(data)) {
                state.listActiveAnimals = _.cloneDeep(data);
            } else {
                state.listActiveAnimals = null;
            }
        },
        updateActiveAnimal(state, data) {
            if (_.isObject(data) && !_.isArray(data)) {
                let [tmp] = new Map(Object.entries(data));
                if ( state.listActiveAnimals != null && state.listActiveAnimals.has(tmp[0])) {
                    state.listActiveAnimals.set(tmp[0], tmp[1]);
                }
            }
        },
        addActiveAnimal(state, activeAnimal) {
            if (activeAnimal != null) {
                if (state.listActiveAnimals == null) {
                    state.listActiveAnimals = new Map(Object.entries(activeAnimal));
                } else {
                    let [tmp] = new Map(Object.entries(activeAnimal));
                    state.listActiveAnimals.set(tmp[0], tmp[1]);
                }
            }
        }
    },
    actions: {
        async updateListKinds({ state, commit, getters, dispatch}) {
            if ( getters.isBlockButtons) { return; };
            await commit('setBlockButtons',true);
            await commit('setListKind', null);
            const data = await state.requestObj.getListKind();
            if (data != null) {
                await commit('setListKind', data);
            }
            await commit('setBlockButtons',false);
        },
        async createAnimal({ state, commit, getters, dispatch}, kind) {
            await commit('setBlockButtons',true);

            let name = getters.getNameByKind(kind);
            const data = await state.requestObj.add(name,kind);
            await commit('addActiveAnimal', data);

            await commit('setBlockButtons', false);
        },
        async increaseAgeAnimal({ state, commit, getters, dispatch}, name) {
            const data = await state.requestObj.updAge(name);
            if ( data != null ) {
                await commit('updateActiveAnimal', data);
            }
            else {
                // TODO: обработка ошибки
            }
        },
        async deleteAllAnimal({ state, commit, getters, dispatch}) {
            const response = await state.requestObj.deleteAll();
            if ( response ) {
                await commit('setActiveAnimals', null);
            }
        },
    }
}
