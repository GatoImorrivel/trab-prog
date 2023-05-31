export async function post(url, data) {
    return await fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });
}

export async function get(url, params) {
  if (params != undefined) {
    let paramString = "";
    for (const [key, value] of Object.entries(params)) {
      paramString += `${key}=${value}&`;
    }
    url = `${url}?${paramString}`;
  }
  
  const response = await fetch(url);
  
  if (!response.ok) {
    throw new Error(`HTTP error! Status: ${response.status}`);
  }
  
  const data = await response.json();
  return data;
}
