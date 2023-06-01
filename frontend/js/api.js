export const BACKEND_URL = 'http://localhost:8080/'

export async function post(url, model, action, data) {
    const response = await fetch(`${BACKEND_URL}${url}?model=${model}&action=${action}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });

    if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status} \n ${await response.text()}`);
    }

    const json = await response.json();
    return json;
}

export async function get(url, model, action, params) {
    url = `${BACKEND_URL}${url}?model=${model}&action=${action}`;
    if (params != undefined) {
        let paramString = "&";
        for (const [key, value] of Object.entries(params)) {
            paramString += `${key}=${value}&`;
        }
        
        url += paramString;
    }

    const response = await fetch(url);

    if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status} \n ${await response.text()}`);
    }

    const data = await response.json();
    return data;
}
