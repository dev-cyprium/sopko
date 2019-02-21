export default function ajax( url, data = {} ) {
    return fetch(url, {
        method: 'POST',
        body: JSON.stringify(data),
        headers: { 'Content-Type': 'application/json' }
    }).then(resp => resp.json())
}