const admin = {
    getAdminInfo(cb, errorCB) {
        axios
            .get(window.API_URL + 'admin/getAdminInfo')
            .then(resp => {

                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    getUsers(cb, errorCB) {
        axios
            .get(window.API_URL + 'admin/getUsers')
            .then(resp => {

                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    createUser(data, cb, errorCB) {
        axios
            .post(window.API_URL + 'admin/createUser', data)
            .then(resp => {

                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    updateAdminInfo(data, cb, errorCB) {
        axios
            .post(window.API_URL + 'admin/updateAdminInfo', data)
            .then(resp => {

                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    updateProfileInfo(data, cb, errorCB) {
        axios
            .post(window.API_URL + 'admin/updateProfileInfo', data)
            .then(resp => {

                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    updatePassword(data, cb, errorCB) {
        axios
            .post(window.API_URL + 'admin/updatePassword', data)
            .then(resp => {

                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    updateEmail(data, cb, errorCB) {
        axios
            .post(window.API_URL + 'admin/updateEmail', data)
            .then(resp => {

                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    getAppLinks(cb, errorCB) {
        axios
            .get(window.API_URL + 'admin/getAppLinks')
            .then(resp => {
                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    getUserLogs(cb, errorCB) {
        axios
            .get(window.API_URL + 'admin/getUserLogs')
            .then(resp => {
                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    logout(cb, errorCB) {
        axios
            .post(window.API_URL + 'logout')
            .then(resp => {

                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    deleteUser(id, cb, errorCB) {
        //alert('in api file',id);
        axios
            .get(window.API_URL + 'admin/deleteUser/' + id)
            .then(resp => {
                //console.log('deleteUser:', resp)
                if (resp.status == 200) {
                    cb(resp.data);
                }
            })
            .catch(err => {
                errorCB(err.response.data);
            })
    },
    deleteMultiUsers(data, cb, errorCB) {
        //alert('in api file',id);
        axios
            .post(window.API_URL + 'admin/deleteMultiUsers/', data)
            .then(resp => {
                //console.log('deleteMultiUsers:', resp)
                if (resp.status == 200) {
                    cb(resp.data);
                }
            })
            .catch(err => {
                errorCB(err.response.data);
            })
    },
    updateUserProfile(data, cb, errorCB) {
        axios
            .post(window.API_URL + 'admin/updateUserProfile', data)
            .then(resp => {

                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    deleteMultiCashbacks(data, cb, errorCB) {
        //alert('in api file',id);
        axios
            .post(window.API_URL + 'admin/deleteMultiCashbacks/', data)
            .then(resp => {
                //console.log('deleteMultiCashbacks:', resp)
                if (resp.status == 200) {
                    cb(resp.data);
                }
            })
            .catch(err => {
                errorCB(err.response.data);
            })
    },
    deleteMultiStores(data, cb, errorCB) {
        //alert('in api file',id);
        axios
            .post(window.API_URL + 'admin/deleteMultiStores/', data)
            .then(resp => {
                //console.log('deleteMultiStores:', resp)
                if (resp.status == 200) {
                    cb(resp.data);
                }
            })
            .catch(err => {
                errorCB(err.response.data);
            })
    },

    forgotPassword(data, cb, errorCB) {
        //alert('in api file',id);
        axios
            .post(window.API_URL + 'forgotPassword/', data)
            .then(resp => {

                if (resp.status == 200) {
                    //console.log('forgotPassword response is:', resp)
                    cb(resp);
                }
            })
            .catch(err => {
                errorCB(err.response.data);
            })
    },
    resetPassword(data, cb, errorCB) {
        //alert('in api file',id);
        axios
            .post(window.API_URL + 'resetPassword/', data)
            .then(resp => {

                if (resp.status == 200) {
                    //console.log('resetPassword response is:', resp)
                    cb(resp);
                }
            })
            .catch(err => {
                errorCB(err.response.data);
            })
    },
    getServerRecords(url, data, cb, errorCB) {
        axios
            .post(window.API_URL + `admin/${url}`, data)
            .then(resp => {

                if (resp.status == 200) {
                    //console.log('getServerRecords response is:', resp)
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },

    //abstract api calls
    addRecord(url, data, cb, errorCB) {
        axios
            .post(window.API_URL + `admin/${url}`, data)
            .then(resp => {

                if (resp.status == 200) {

                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    updateRecord(url, data, cb, errorCB) {
        axios
            .post(window.API_URL + `admin/${url}`, data)
            .then(resp => {

                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    getRow(url, id, cb, errorCB) {
        axios
            .get(window.API_URL + `admin/${url}/${id}`)
            .then(resp => {

                if (resp.status == 200) {

                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    getRecords(url, cb, errorCB) {
        axios
            .get(window.API_URL + `admin/${url}`)
            .then(resp => {
                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    deleteRecord(url, id, cb, errorCB) {
        axios
            .get(window.API_URL + `admin/${url}/${id}`)
            .then(resp => {
                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },

}

export default admin