exports.request = async function request(method, url, data, headers = {}) {
    const response = await fetch(url, {
        method: method,
        headers: headers,
        body: data,
    });

    data = await response.json();
    if (! response.ok) {
        throw new Error(`Request failed with status: ${response.status}`, {
            cause: data.message
        });
    }

    return data;
}
