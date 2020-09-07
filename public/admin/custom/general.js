var General = function() {

    var handleDefaultCountry = function() {
        if(is_country_set == 0) {
            $("#user-country-modal-btn").click();
        }
    };

    return {
        init: function() {
            handleDefaultCountry();
        }
    }
}();

$(document).ready(function() {
    General.init();
});