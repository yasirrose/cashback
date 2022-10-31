const login = {
    getUserInfo(data, cb, errorCB) {
        axios
            .post(window.API_URL+'login', data)
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
            .post(window.API_URL+'logout')
            .then(resp => {
            
                if (resp.status == 200) {
                    cb(resp.data)
                }
            })
            .catch(err => {
                errorCB(err.response.data)
            })
    },
    // all(cb, errorCB) {
    //     axios
    //         .get(API_URL + 'me')
    //         .then(resp => {
    //             if (resp.status == 200) {
    //                 cb(resp.data)
    //             } else {
    //                 errorCB(resp.data)
    //             }
    //         })
    //         .catch(err => {
    //             errorCB(err.response)
    //         })
    // },
    // getToken(data, cb, errorCB) {
    //     axios
    //         .post(API_URL + 'getToken', data)
    //         .then(resp => {
    //             if (resp.status == 200) {
    //                 cb(resp.data)
    //             }
    //         })
    //         .catch(err => {
    //             errorCB(err.response.data)
    //         })
    // },
    // get_user(id, cb, errorCB) {
    //     axios
    //         .get(API_URL + 'get_user/' + id)
    //         .then(resp => {
    //             if (resp.status == 200) {
    //                 cb(resp.data)
    //             }
    //         })
    //         .catch(err => {
    //             errorCB(err.response.data)
    //         })
    // },
    // update_user(id, data, cb, errorCB) {
    //     axios
    //         .put(API_URL + 'update_user/' + id, data)
    //         .then(resp => {
    //             console.log('updateUser:', resp)
    //             if (resp.status == 200) {
    //                 cb(resp.data)
    //             }
    //         })
    //         .catch(err => {
    //             errorCB(err.response.data)
    //         })
    // },
    // get_user_profile(id, cb, errorCB) {
    //     axios
    //         .get(API_URL + 'admin/get_user_profile/' + id)
    //         .then(resp => {
    //             if (resp.status == 200) {
    //                 cb(resp.data)
    //             }
    //         })
    //         .catch(err => {
    //             errorCB(err.response.data)
    //         })
    // },
    // update_user_profile(id, data, cb, errorCB) {
    //     axios
    //         .put(API_URL + 'admin/update_user_profile/' + id, data)
    //         .then(resp => {
    //             console.log('updateUser:', resp)
    //             if (resp.status == 200) {
    //                 cb(resp.data)
    //             }
    //         })
    //         .catch(err => {
    //             errorCB(err.response.data)
    //         })
    // },
    // add_user(data, cb, errorCB) {
    //     axios
    //         .post(API_URL + 'admin/add_user', data)
    //         .then(resp => {
    //             if (resp.status == 200) {
    //                 cb(resp.data)
    //             }
    //         })
    //         .catch(err => {
    //             errorCB(err.response.data)
    //         })
    // },
    // logout_user(cb, errorCB) {
    //     axios
    //         .post('/logout')
    //         .then(resp => {
    //             if (resp.status == 200) {
    //                 window.location.reload();
    //             }
    //         })
    //         .catch(err => {
    //             errorCB(err.response.data)
    //         })
    // },
    // delete(id, cb, errorCB) {
    //     axios
    //         .delete(API_URL + 'admin/delete_user/' + id)
    //         .then(resp => {
    //             console.log('deleteUser:', resp)
    //             if (resp.status == 204) {
    //                 cb(resp.data)
    //             }
    //         })
    //         .catch(err => {
    //             errorCB(err.response.data)
    //         })
    // },
}

export default login
