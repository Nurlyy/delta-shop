function getAccount(type) {
    var received_data = null;
    $.ajax({
        url: '/api/get-account',
        method: 'GET',
        data: {type: type},
        success: function(data) {
            received_data = data;
            console.log(data);
        },
        error: function(xhr, status, error) {
            console.error(xhr); // handle error response
        }
    });

    return received_data;
}