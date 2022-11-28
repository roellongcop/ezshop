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

export {
    accountRequired,
    errorMessage,
    successMessage,
    successReload,
    block,
    unblock,
}