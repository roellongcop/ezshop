const accountRequired = ({errorSummary}) => {
	Swal.fire({
        title: "Account Required",
        text: errorSummary,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sign In",
        cancelButtonText: "Sign Up",
    }).then(function(result) {
        if (result.value) {
            window.location.href = app.baseUrl + 'login';
        }
        else if (result.dismiss === "cancel") {
            window.location.href = app.baseUrl + 'signup';
        }
    });
}

const successMessage = ({ message, buttonText, url }) => {
    Swal.fire({
        title: "Success",
        text: message,
        icon: "success",
        showCancelButton: true,
        confirmButtonText: buttonText,
        cancelButtonText: "Close",
    }).then(function(result) {
        if (result.value) {
            window.location.href = app.baseUrl + url;
        }
    });
}

const successReload = ({ message }) => {
    Swal.fire({
        text: message,
        icon: "success",
        timer: 1200,
        showConfirmButton: false,
    }).then(function(result) {
        if (result.dismiss === "timer") {
            window.location.reload();
        }
    })
}

const errorMessage = ({errorSummary}) => {
    Swal.fire({
        title: 'Error', 
        html: errorSummary,  
        icon: "error",
    });
}

const block = (container, message) => {
    KTApp.block(container, {
        overlayColor: '#000000',
        message: message,
        state: 'primary'
    });
}

const unblock = (container) => {
    KTApp.unblock(container);
}


const { ref } = Vue;

const appState = ref({
    isLoading: true
});

const request = ( url, params = {}, method = 'GET', signal) => {
    url = app.baseUrl + url;
    params[app.csrfParam] = app.csrfToken

    let options = {
        method,
    };

    if (signal) {
        options.signal = signal;
    }

    if ( 'GET' === method ) {
        url += '?' + ( new URLSearchParams( params ) ).toString();
    } else {
        options.body = JSON.stringify(params);
        options.headers = {
            'Content-Type': 'application/json'
        }
    }
    
    return fetch( url, options ).then( response => response.json() );
};
const get = ( url, params, signal='' ) => request( url, params, 'GET', signal );
const post = ( url, params, signal='' ) => request( url, params, 'POST', signal );

const sweetAlert = (title='Title', icon='success', timer=1000) => {
    Swal.fire({
        icon: icon,
        title: title,
        showConfirmButton: false,
        timer: timer
    });
}


export {
    appState,
    get,
    post,
    sweetAlert,
    accountRequired,
    errorMessage,
    successMessage,
    successReload,
    block,
    unblock,
}