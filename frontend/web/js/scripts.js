function getAccount(type, callback) {
    $.ajax({
        url: '/account/get-account',
        method: 'GET',
        data: {type: type},
        success: function(data) {
            callback(data);
        },
        error: function(xhr, status, error) {
            console.error(xhr); // handle error response
        }
    });
}


function user_logout(){
    $.ajax({
        url: '/site/logout',
        type: 'POST',
        success: function(data) {
            location.reload();
        }
    });
}

