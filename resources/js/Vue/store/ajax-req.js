
import axios from 'axios';

export default class AjaxReq {

    axios = null;

    constructor() {
        this.axios = axios.create({
            baseURL: 'http://localhost:8098/api/animals'
        });
        this.axios.defaults.headers.common['Content-Type'] = 'application/json';
        this.axios.defaults.headers.common['Accept'] = 'application/json';
    }

    async getListKind() {
        let data = null;
        try {
            const response = await this.axios.get('/kinds');
            data = response.data.data;
        }
        catch(e) {

        }
        return data;
    }

    async getKind(kindName) {
        let data = null
        try {
            const response = await this.axios.get('/kinds/:' + kindName);
            data = response.data.data;
        }
        catch(e) {

        }
        return data;
    }

    async getListAnimals() {
        let data = null
        try {
            const response = await this.axios.get('/active');
            data = response.data.data;
        }
        catch(e) {

        }
        return data;
    }

    async getName(value) {
        let data = null
        try {
            const response = await this.axios.get('/active/:' + value);
            data = response.data.data;
        }
        catch(e) {

        }
        return data;
    }

    async updAge(value) {
        let data = null
        try {
            const response = await this.axios.post('/active/age', {
                                                        name: value
                                                    });
            data = response.data.data;
        }
        catch(e) {

        }
        return data;
    }

    async add(inName, inKind) {
        let data = null
        try {
            const response = await this.axios.post('/active', {
                name: inName,
                kind: inKind
            });
            data = response.data.data;
        }
        catch(e) {

        }
        return data;
    }

    async delete(inName) {
        let res = false;
        try {
            const response = await this.axios.post('/active/delete/:' + inName);
            res = response.data.error == null;
        }
        catch(e) {
            res = false;
        }
        return res;
    }

    async deleteAll() {
        let res = false;
        try {
            const response = await this.axios.post('/active/delete');
            res = response.data.error == null;
        }
        catch(e) {

        }
        return res;
    }
}

// const cfgAxios = {
//     method: 'GET',
//     url: 'http://localhost:8098/api/animals',
//     headers: {
//         'Content-Type': 'application/json',
//         'Accept': 'application/json',
//     }
// }
