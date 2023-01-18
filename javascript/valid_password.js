function password_validity(pass_string) {
    let validity = "";

    if(pass_string.toUpperCase() == pass_string) {
        validity = "Password requires at least 1 lowercase character";
    }

    if(pass_string.toLowerCase() == pass_string) {
        validity = "Password requires at least 1 uppercase character";
    }

    if(!/\d/.test(pass_string)) {
        validity = "Password requires at least 1 numeric character";
    }

    if(pass_string.length < 8) {
        validity = "Password must be at least 8 characters long";
    }

    return validity;
}