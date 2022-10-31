const client = {
    getFileRecords(data, cb, errorCB) {
        axios
        .post(window.API_URL+'client/getFileRecords', data)
        .then(resp => {
        
            if (resp.status == 200) {
                cb(resp.data)
            }
        })
        .catch(err => {
            errorCB(err.response.data)
        })
    },
    getKeywords(data, cb, errorCB) {
        axios
        .post(window.API_URL+'admin/getKeywords', data)
        .then(resp => {
        
            if (resp.status == 200) {
                cb(resp.data)
            }
        })
        .catch(err => {
            errorCB(err.response.data)
        })
    },
    storeBusinessRecords(data, cb, errorCB) {
        axios
        .post(window.API_URL+'client/storeBusinessRecords', data)
        .then(resp => {
        
            if (resp.status == 200) {
                cb(resp.data)
            }
        })
        .catch(err => {
            errorCB(err.response.data)
        })
    },
    destroyRecords(data, cb, errorCB) {
        axios
        .post(window.API_URL+'client/destroyRecords', data)
        .then(resp => {
        
            if (resp.status == 200) {
                cb(resp.data)
            }
        })
        .catch(err => {
            errorCB(err.response.data)
        })
    },
    keepRecords(data, cb, errorCB) {
        axios
        .post(window.API_URL+'client/keepRecords', data)
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
        .post(window.API_URL+'admin/updateAdminInfo', data)
        .then(resp => {
        
            if (resp.status == 200) {
                cb(resp.data)
            }
        })
        .catch(err => {
            errorCB(err.response.data)
        })
    },
    updatePassword(data, cb, errorCB){
        axios
        .post(window.API_URL+'admin/updatePassword', data)
        .then(resp => {
        
            if (resp.status == 200) {
                cb(resp.data)
            }
        })
        .catch(err => {
            errorCB(err.response.data)
        })
    },

    uploadFile(data, cb, errorCB){
        axios
        .post(window.API_URL+'client/file', data, {
            headers: {
                'content-type': 'multipart/form-data'
            }
        })
        .then(resp => {
            if (resp.status == 200) {
                cb(resp.data)
            }
        })
        .catch(err => {
            console.log(err);
            errorCB(err.response.data)
        })
    },

    getFile(cb, errorCB){
        axios
        .get(window.API_URL+'client/getFile')
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
}

export default client
