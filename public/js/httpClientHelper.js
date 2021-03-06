/**
 * Send http post request
 * @param {FormData} data
 * @param {string} url
 */
async function asyncHttpPost(data, url) {
  const result = await fetch(url, {
    method: 'POST',
    body: data,
  });
  return await result.json();
}

/**
 * Send http put request
 * @param {FormData} data
 * @param {string} url
 */
async function asyncHttpPut(data, url) {
  const result = await fetch(url, {
    method: 'PUT',
    body: data,
  });
  return await result.json();
}
