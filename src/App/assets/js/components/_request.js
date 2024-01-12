exports.request = (method, url, data) => {
    return fetch(url, {
        method: method.toUpperCase(),
        body: JSON.stringify(data),
        headers: {'Content-Type': 'application/json'},
    }).then(response => {
        if (! response.ok) {
            throw new Error('HTTP error ' + response.status);
        }
        return response.json();
    });
};
