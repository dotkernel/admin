export const request = async (url, options = {}) => {
    try {
        const response = await fetch(url, options);
        const body = await response.text();
        if (! response.ok) {
            throw {
                data: body,
            }
        }
        return body;
    } catch (error) {
        throw {
            data: error.data,
        }
    }
};